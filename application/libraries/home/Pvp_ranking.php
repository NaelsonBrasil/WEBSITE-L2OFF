<?php
defined('BASEPATH') OR exit('No direct script access allowed');

global $iniGlobal;


class Pvp_ranking extends Account{


    public $topPk   = array();
    public $topPvp  = array();
    public $topNick = array();
    public $size; //Return num of rows
    public $maxLimit;

    function __construct(){

        parent::__construct();
        global $iniGlobal;
        $this->maxLimit = $iniGlobal['RankLimit'];
        $this->size = $this->topPvp();

    }

    public function topPvp(){

        $query = $this->dbWord->query("SELECT align,PK,char_name FROM user_data ORDER BY align DESC");

        $i = 0;
        foreach ($query->result() as $row) {

            $this->topPvp[$i] = $row->align;
            $this->topPk[$i] = $row->PK;
            $this->topNick[$i] = ucfirst($row->char_name);
            if ($this->maxLimit == $i) break;
            $i++;
        }
        return $i;
    }

}