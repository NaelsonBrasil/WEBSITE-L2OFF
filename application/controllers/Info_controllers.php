<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Info_controllers extends CI_Controller
{
  protected $arrayPublic = array();

  function __construct()
  {
    parent::__construct();
    $instance = new Pload($this->session->userdata('id'));
    $this->arrayPublic = $instance->arrayPublic;

  }

  public function index()
  {

    $this->arrayPublic['pag_dynamic'] = 'public/dynamic/dyInfo';
    $this->load->view('public/header_view', $this->arrayPublic);

  }
}