<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Main_controllers extends CI_Controller
{

  protected $arrayGlobal = array();

  function __construct()
  {

    parent::__construct();

    $instGload = new Gload($this->session->userdata('id'));
    $this->arrayGlobal = $instGload->array;
    $this->userdata->loadUserData($this->session->userdata('id'));
 

  }

  public function index()
  {
    echo CI_VERSION;
   
    if ($this->session->userdata('logged_in') === true) {

      $this->arrayGlobal['hp'] = (isset($this->userdata->stat['HP']) == null) ? 0 : @$this->userdata->stat['HP'];
      $this->arrayGlobal['mp'] = (isset($this->userdata->stat['MP']) == null) ? 0 : @$this->userdata->stat['MP'];
      $this->arrayGlobal['sp'] = (isset($this->userdata->stat['SP']) == null) ? 0 : @$this->userdata->stat['SP'];
      $this->arrayGlobal['cp'] = (isset($this->userdata->stat['cp']) == null) ? 0 : @$this->userdata->stat['cp'];
    
      changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);
      

      $this->load->view('admin/template/Template', $this->arrayGlobal);

    } else {
      log_message('error', 'conta não possui permissão para logar');
      show_404("error_404");
    }
  }

  public function leave()
  {

    if ($this->session->unset_userdata('logged_in') == 0) {

      unset($this->arrayGlobal['username']);
      redirect('admin/login');
    } else show_404("error_404");

  }

}