<?php
defined('BASEPATH') OR exit('No direct script access allowed');

global $iniGlobal;

class Boss_ranking extends Account
{
  public $bossName = array();
  public $bossOn = array();
  public $hp = array();
  public $mp = array();
  public $posX = array();
  public $posY = array();
  public $posZ = array();
  public $timeLow = array();
  public $timeHigh = array();
  public $size; //Return num of rows
  public $maxLimit;

  function __construct()
  {
    parent::__construct();
    global $iniGlobal;

    $this->maxLimit = $iniGlobal['BossLimit'];
    $this->size = $this->raidBoss();
  }

  public function raidBoss()
  {

    $this->dbWord->select('*');
    $query = $this->dbWord->get('npc_boss');

    $i = 0;
    foreach ($query->result() as $row) {
      $this->bossName[$i] = str_replace("_", " ", ucfirst($row->npc_db_name));
      $this->bossOn[$i] = $row->alive;
      $this->hp[$i] = $row->hp;
      $this->mp[$i] = $row->mp;
      $this->posX[$i] = $row->pos_x;
      $this->posY[$i] = $row->pos_y;
      $this->posZ[$i] = $row->pos_z;
      $this->timeLow[$i] = $row->time_low;
      $this->timeHigh[$i] = $row->time_high;
      if ($this->maxLimit === $i) break;
      $i++;

    }

    return $i;
  }

  public function getAmountBoss()
  {

    $query = $this->dbWord->get("npc_boss");
    if ($query->num_rows() > 0) {

      return $query->num_rows();
    }
    return 0;

  }

  function getAllRecords($sort = 'id', $order = 'asc', $limit = null, $offset = null)
  {
    $this->dbWord->order_by($sort, $order);

    if ($limit)
      $this->dbWord->limit($limit, $offset);
    $query = $this->dbWord->get('npc_boss');

    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return null;
    }

  }
}