<?php
defined('BASEPATH') OR exit('No direct script access allowed');

global $iniGlobal;

class Clan_ranking extends Account
{
    public $topClan = array();
    public $levelClan = array();
    public $topAlliance = array();
    public $topNick = array();
    public $topCountMember = array();
    public $size; //Return num of rows
    public $maxLimit;
    public $config;

    function __construct(){

        parent::__construct();
        global $iniGlobal;
        $this->maxLimit = $iniGlobal['RankLimit'];

        $this->size = $this->topClan();

    }

    public function topClan(){

        $query = $this->dbWord->query("SELECT Pledge.name as clan_name,alliance_id,Alliance.name as alliance_name,skill_level,char_name,Pledge.pledge_id as pd_id FROM Pledge LEFT JOIN Alliance ON Pledge.alliance_id = Alliance.id LEFT JOIN user_data ON Pledge.ruler_id = user_data.char_id ORDER BY skill_level DESC");

        $i = 0;
        foreach ($query->result() as $row) {

            $this->topClan[$i] = ucfirst($row->clan_name);
            $this->levelClan[$i] = $row->skill_level;
            $this->topAlliance[$i] = ( empty($row->alliance_name) ) ? '-' :  ucfirst($row->alliance_name);
            $this->topCountMember[$i] = ( empty($this->countMember($row->pd_id)) OR $this->countMember($row->pd_id) === 0) ? '-' :  $this->countMember($row->pd_id);
            $this->topNick[$i] = ucfirst($row->char_name);
            if ($this->maxLimit === $i) break;
            $i++;
        }
        return $i;
    }

    public function countMember($pledge_id){
        $query = $this->dbWord->query("SELECT pledge_id FROM user_data WHERE pledge_id = '$pledge_id'");
        return  $query->num_rows();
    }
}