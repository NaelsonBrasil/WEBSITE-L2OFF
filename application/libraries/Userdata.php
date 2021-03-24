<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userdata extends Account
{

  public $stat = array();
  public $charArrayName = array();
  public $arrayCharId = array();

  function __construct()
  {
    parent::__construct();
    global $iniGlobal;
    $this->config = $iniGlobal;

  }

  public function index(){}

  //Bug virify if id exist of character
  //Improvement set choice werehouse or iventory
  //History primary for parser error
  public function addItemCharacter($userId , $charId, $itemId, $quantity) : int
  {


    $updateDonated = new donate();
    date_default_timezone_set($this->config["DataZone"]);

    if($this->getConnectCachedServer() == 0) {

    if($this->getCountItemCharacter($charId, $itemId) > 0) {
        
        $qt = $this->getCountItemDonated($userId, $itemId) - $quantity;
        $updateDonated->updateItemDonate($userId,$itemId,$qt);
        $updateDonated->setHistoryTransfer($userId,$itemId,$charId,$quantity,date("Y-m-d H:i:s"));

        $valueUpded = $quantity + $this->getCountItemCharacter($charId, $itemId);
        $this->dbWord->query("UPDATE user_item SET amount = '$valueUpded' WHERE char_id = '$charId' AND item_type = '$itemId' ");
        
      return 1;

      } else {

        
        $qt = $this->getCountItemDonated($userId, $itemId) - $quantity;
        $updateDonated->updateItemDonate($userId,$itemId,$qt);
        $updateDonated->setHistoryTransfer($userId,$itemId,$charId,$quantity,date("Y-m-d H:i:s"));

        $data = array(
          'char_id' => $charId,
          'item_type' => $itemId,
          'amount' => $quantity,
          'enchant' => 0,
          'eroded'=> 0,
          'bless' => 0,
          'ident' => 0,
          'wished' => 0,
          'warehouse' => 0);

        $this->dbWord->insert('user_item', $data);
        return 1;
     }

     /*
        Bug if add item with cached on and delete item x, cause bug of item exist cached
        For fix need verify if item exist in database, if not exist need add item using cachedAdd and insert database or
        if delete item close cached for reset
     */

   } else {
    
      
        $valueUpded = $this->getCountItemDonated($userId, $itemId) - $quantity;
        $updateDonated->updateItemDonate($userId,$itemId, $valueUpded);
        $updateDonated->setHistoryTransfer($userId,$itemId,$charId,$quantity,date("Y-m-d H:i:s"));

        try {

           if($this->KickCharacterPacket($charId)) {
              $this->CachedAddItem($charId,0,$itemId,$quantity);
              return 1;
           }

        } catch (Exception $e) {
          return 0;
        }
     }
  }

  public function getConnectCachedServer() : int
  {

      $p = @fsockopen($this->config['IpConnect'], $this->config['CachedPort'], $err_no, $err_str, 1);
      if (!empty($p)){return 1;} else {return 0;}

  }

  public function getCountItemDonated($userId, $itemId) : int
  {
      $p = new donate();
      return $p->getCountItemDonated($userId, $itemId);
  }



  public function getCountItemCharacter($charId, $itemId) : int
  {

      $this->dbWord->where('char_id', $charId);
      $this->dbWord->where('item_type', $itemId);
      
      $query = $this->dbWord->get('user_item');

      if ($query->num_rows() > 0) {

        return $query->row()->amount;

      }
      else {
        return 0;
      }
      
  }

  public function getCharId($userId) : array
  {

    $this->dbWord->select(array('char_id', 'char_name'));
    $this->dbWord->where('account_id', $userId);
    $query = $this->dbWord->get('user_data');
    return $query->result_array();

  }


  public function countCharId($userId) : int
  {

    $query = $this->dbWord->get_where('user_data', array('account_id' => $userId));

    if ($query->num_rows() > 0) {

        return $query->num_rows();

    } else {
        return 0;
    }

  }

  //Load last character of account that leave server
  public function loadUserData($id)
  {

    $query = $this->dbWord->query("SELECT * FROM user_data WHERE account_id = '$id' ORDER BY logout");

    foreach ($query->result_array() as $key => $item)
      $this->stat = $item;

  }

  public function getListChar($id)
  {

    $query = $this->dbWord->select('*')->where('account_id', $id)->get('user_data');

    $i = 0;
    foreach ($query->result() as $row) {

      $this->charArrayName[$i] = $row->char_name;
      $this->arrayCharId[$i] = $row->char_id;
      $i++;
    }

  }

  public function getAccessLevelChar($name)
  {

    $query = $this->dbWord->select('builder')->where('account_name', $name)->get('user_data');
    return $query->num_rows();

  }

}