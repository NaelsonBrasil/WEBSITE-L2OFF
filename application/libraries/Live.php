<?php
defined('BASEPATH') OR exit('No direct script access allowed');
global $iniGlobal;

class Live extends Gallery
{
    public $liveId = array();
    public $liveNick = array();
    public $liveDateTime = array();
    public $liveUrl = array();
    public $liveMiniatureName = array();
    public $liveToken = array();
    private $table = "live";
    private $upload = "uploaded/miniature/";
    public $success = false;
    private $db;

    function __construct()
    {
        parent::__construct();
        $CI = get_instance();
        $this->db = $CI->load->database('custom', true);
    }

    //OverHead
    public function setStoreUploadLive($nickName, $dateTime, $url, $miniature)
    {
        //Token Protection flooding
        $data = array('nick' => $nickName, 'date_time' => $dateTime, 'url' => $url, 'miniature_name' => $miniature, 'token' => md5(rand(1, 99999)));

        try {
            $this->db->insert($this->table, $data);
            $this->success = true;
        } catch (Exception $e) {
            $this->success = false;
        }

    }

    public function getCountLive()
    {
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $this->getValues();
            return $query->num_rows();
        } else return 0;
    }

    //Polymorphism
    public function getValues()
    {
        $query = $this->db->get($this->table);

        $i = 0;
        foreach ($query->result() as $row) {
            $this->liveId[$i] = $row->id;
            $this->liveNick[$i] = $row->nick;
            $this->liveDateTime[$i] = $row->date_time;
            $this->liveUrl[$i] = $row->url;
            $this->liveMiniatureName[$i] = $row->miniature_name;
            $this->liveToken[$i] = $row->token;
            $i++;
        }
    }

    //Polymorphism
    public function delRegisterLive($token): bool
    {
        $unLik = $this->upload . $this->getMiniatureName($token);
        @unlink($unLik);
        $this->db->where('token', $token);
        try {
            $this->db->delete($this->table);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function getMiniatureName($token): string
    {
        $this->db->select("miniature_name");
        $query = $this->db->get_where($this->table, array('token' => $token));
        foreach ($query->result() as $row)
            if (!empty($row->miniature_name)) return $row->miniature_name; else return 0;

    }

    public function getSuccessful()
    {
        return $this->success;
    }

}