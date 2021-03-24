<?php
defined('BASEPATH') or exit('No direct script access allowed');

global $iniGlobal;

class Tools extends Userdata
{
  function __construct()
  {
    global $iniGlobal;
    $this->config = $iniGlobal;
    parent::__construct();
  }

  public function UpdateUnlockChar($id, $xLc, $yLc, $zLc) : bool
  {
    try {

      $this->SetCharacterLocationPacket($id, $xLc, $yLc, $zLc);
      return true;

    } catch (Exception $e) {
      return false;
    }

  }

  public function amountPlayer()
  {
    $query = $this->dbWord->query("SELECT login FROM user_data WHERE login > logout");
    if ($query->num_rows() > 0) return $query->num_rows();
    else return 0;
  }

  public function authServerEnable()
  {
    if ($this->config['AuthEnable'] == 1) {

      $p = @fsockopen($this->config['IpConnect'], $this->config['AuthPort'], $err_no, $err_str, 1);

      if ($p)
        return 1;
      else
        return 0;
    } else if ($this->config['IpConnect'] == 0) return 'off';

  }

  public function serverEnable()
  {
    if ($this->config['SrvEnable'] == 1) {
      $p = @fsockopen($this->config['IpConnect'], $this->config['SrvPort'], $err_no, $err_str, 1);

      if ($p)
        return 1;
      else
        return 0;
    } else if ($this->config['SrvEnable'] == 0) return 'off';

  }

  public function npcEnable()
  {

    if ($this->config['NpcEnable'] == 1) {

      $p = @fsockopen($this->config['IpConnect'], $this->config['NpcPort'], $err_no, $err_str, 1);

      if ($p)
        return 1;
      else
        return 0;
    } else if ($this->config['NpcEnable'] == 0) return 'off';

  }

}