<?php
/**
 * Created by PhpStorm.
 * User: Kabaite
 * Date: 16/10/2018
 * Time: 17:39
 */

class Test extends CI_Controller
{
  protected $arrayPublic = array();
  function __construct()
  {
    parent::__construct();
//    $instance = new PLoad($this->session->userdata('id'));
//    $this->arrayPublic = $instance->arrayPublic;
  }

  public function index(){
     //echo  ($this->account->createAccount("admin","admin","admin_15@hotmail.com",null,"sas","sasas","sasa","sdfd") === true) ? "True" : "false";
      //echo $this->account->validation('naelson.g.saraiva@gmail.com','admin');
      //echo removeSpaces("naelson gon");

      echo $this->account->validation("naelson@gmail.com","admin");
  }

}