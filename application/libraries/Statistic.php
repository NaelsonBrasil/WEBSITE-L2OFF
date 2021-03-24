<?php
/**
 * Created by PhpStorm.
 * User: vipcriativo.com
 * Date: 2/3/2018
 * Time: 11:01
 */
defined('BASEPATH') OR exit('No direct script access allowed');

global $iniGlobal;

class Statistic {

    public $data;
    public $name;
    private $db;
    public $arrayMonday   = array();
    public $arrayTuesday  = array();
    public $arrayWednesday= array();
    public $arrayThursday = array();
    public $arrayFriday   = array();
    public $arraySaturday = array();
    public $arraySunday   = array();



    function __construct($arg_date =  null, $name_account = null){
        $CI = get_instance();
        $this->db = $CI->load->database('custom',true);

        $this->data = $arg_date;
        $this->name = $name_account;

        $this->getName();
        $this->getData();
        $this->setData();
        $this->dataDay();
    }

    public function setData(){

        switch (strtolower($this->data)) {
            case 'monday': $this->db->insert('data_amount',  array('monday'   => $this->name)); break;
            case 'tuesday':$this->db->insert('data_amount',  array('tuesday'  => $this->name)); break;
            case 'wednesday':$this->db->insert('data_amount',array('wednesday'=> $this->name)); break;
            case 'thursday':$this->db->insert('data_amount', array('thursday' => $this->name)); break;
            case 'friday':$this->db->insert('data_amount',   array('friday'   => $this->name)); break;
            case 'saturday':$this->db->insert('data_amount', array('saturday' => $this->name)); break;
            case 'sunday':$this->db->insert('data_amount',   array('sunday'   => $this->name)); break;
            default:return 0;
            break;
        }

    }

    // Delete Register statistic
    public function clearDataStatistic(){ $this->db->empty_table('data_amount'); }
    public function getData(){ return $this->data; }
    public function getName(){ return $this->name; }

    public function dataDay(){

        $query = $this->db->query('select * from data_amount');

        $i = 0;
        foreach ($query->result() as $row){

            if(!empty($row->monday) AND strlen($row->monday) > 0)
                $this->arrayMonday[$i] = $row->monday;

            if(!empty($row->tuesday)   AND strlen($row->tuesday) > 0)
                $this->arrayTuesday[$i] = $row->tuesday;

            if(!empty($row->wednesday) AND strlen($row->wednesday) > 0)
                $this->arrayWednesday[$i] = $row->wednesday;

            if(!empty($row->thursday) AND strlen($row->thursday) > 0)
                $this->arrayThursday[$i] = $row->thursday;

            if(!empty($row->friday) AND strlen($row->friday) > 0)
                $this->arrayFriday[$i] = $row->friday;

            if(!empty($row->saturday) AND strlen($row->saturday) > 0)
                $this->arraySaturday[$i] = $row->saturday;

            if(!empty($row->sunday) AND strlen($row->sunday) > 0)
                $this->arraySunday[$i] = $row->sunday;
            $i++; // need pass for bottom, if no index, no will be zero

        }
    }
}