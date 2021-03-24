<?php
defined('BASEPATH') OR exit('No direct script access allowed');
global $iniGlobal;

class Gallery extends Account
{
    public $galleryId = array();
    public $galleryImageName = array();
    public $galleryToken = array();
    private $table = 'gallery';
    private $upload = "uploaded/";
    public $success = false;
    private $db;

    function __construct()
    {
        parent::__construct();
        $CI = get_instance();
        $this->db = $CI->load->database('custom', true);
    }

    public function setUpload($name)
    {

        //Token Protection flooding
        $data = array('image_name' => $name, 'token' => md5(rand(1, 99999)));
        try {
            $this->db->insert($this->table, $data);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function getCountImage()
    {
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $this->getValues();
            return $query->num_rows();
        } else return 0;
    }

    public function getValues()
    {
        $query = $this->db->get($this->table);

        $i = 0;
        foreach ($query->result() as $row) {
            $this->galleryId[$i] = $row->id;
            $this->galleryImageName[$i] = $row->image_name;
            $this->galleryToken[$i] = $row->token;
            $i++;
        }
    }

    public function deleteUp($token): bool
    {
        $unLik = $this->upload . $this->getImageName($token);
        @unlink($unLik);
        $this->db->where('token', $token);
        try {
            $this->db->delete($this->table);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function getImageName($name)
    {
        $this->db->select("image_name");
        $query = $this->db->get_where($this->table, array('token' => $name));
        foreach ($query->result() as $row) {
            if (!empty($row->image_name)) {
                return $row->image_name;
            } else {
                return 0;
            }
        }

        return 0;
    }


}