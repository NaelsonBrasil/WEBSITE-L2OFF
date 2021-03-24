<?php
defined('BASEPATH') OR exit('No direct script access allowed');

global $iniGlobal;


class Notice extends Account
{
  public $noticeTitle = array();
  public $noticeText = array();
  public $noticeTime = array();
  public $noticeDate = array();
  public $noticeToken = array();
  private $db;

  function __construct()
  {
    parent::__construct();
      $CI = get_instance();
      $this->db = $CI->load->database('custom',true);
  }

  public function createNotice($title, $text)
  {

    date_default_timezone_set($this->config["DataZone"]);

    //Token Protection flooding Token
    $data = array('title' => $title, 'text' => $text, 'time' => date("H:i:s"), 'date' => date("Y-m-d"), 'token' => md5(rand(1, 99999)));
    try {
      $this->db->insert('notice', $data);
      return true;

    } catch (PDOException $e) {
      return false;
    }
  }

  public function getAmountNotice()
  {

    $query = $this->db->get("notice");
    if ($query->num_rows() > 0) {
      $this->getNoticeAllTable();
      return $query->num_rows();
    }
    return 0;

  }

  public function getNoticeAllTable()
  {

    $query = $this->db->get("notice");
    $i = 0;
    foreach ($query->result() as $row) {
      $this->noticeTitle[$i] = $row->title;
      $this->noticeText[$i] = $row->text;
      $this->noticeTime[$i] = $row->time;
      $this->noticeDate[$i] = $row->date;
      $this->noticeToken[$i] = $row->token;
      $i++;

    }
  }

  public function delete($token)
  {
    try {
      $this->db->where('token', $token);
      $this->db->delete("notice");
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }


  public function getAllRecords($sort = 'id', $order = 'asc', $limit = null, $offset = null)
  {
    $this->db->order_by($sort, $order);

    if ($limit)
      $this->db->limit($limit, $offset);
      $query = $this->db->get('notice');

    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return null;
    }

  }

}