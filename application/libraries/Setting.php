<?php
defined('BASEPATH') OR exit('No direct script access allowed');

global $iniGlobal;

class Setting extends Account
{
  private $db;
  public $valSetting = array('val_password' => null, 'val_nick' => null, 'val_email' => null, 'val_unlock' => null, 'val_send_email_register' => null);

  function __construct()
  {
    parent::__construct();
      $CI = get_instance();
      $this->db = $CI->load->database('custom',true);
  }

  public function setUpdateSettingView($id, $key, $get)
  {

    switch ($key) {

      case 'password_active':
        $data = array("id_account" => $id, "password_account" => $get);
        $this->db->set($data);
        $this->db->update('setting_view');
        break;

      case 'nick_name_active':
        $data = array("id_account" => $id, "change_nick" => $get);
        $this->db->set($data);
        $this->db->update('setting_view');
        break;

      case 'email_active':
        $data = array("id_account" => $id, "change_email" => $get);
        $this->db->set($data);
        $this->db->update('setting_view');
        break;

      case 'unlock_active':
        $data = array("id_account" => $id, "unlock_char" => $get);
        $this->db->set($data);
        $this->db->update('setting_view');
        break;

      case 'send_email_active':
        $data = array("id_account" => $id, "send_email_register" => $get);
        $this->db->set($data);
        $this->db->update('setting_view');
        break;


      default:
        show_404("Error setting config", true);
    }


  }

  public function getValuesSettings()
  {

    $this->db->select('*');
    $query = $this->db->get('setting_view');

    foreach ($query->result() as $row) {
      $this->valSetting['val_password'] = $row->password_account;
      $this->valSetting['val_nick'] = $row->change_nick;
      $this->valSetting['val_email'] = $row->change_email;
      $this->valSetting['val_unlock'] = $row->unlock_char;
      $this->valSetting['val_send_email_register'] = $row->send_email_register;

    }
  }


}