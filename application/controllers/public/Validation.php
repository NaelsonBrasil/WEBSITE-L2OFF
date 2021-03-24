<?php

class Validation extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {

    if (isset($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['captcha'])) {

      if ($this->session->phrase == $_POST['captcha']) {

        $getCode = $this->Account->validation($_POST['username'], $_POST['password']); //Validation

        if ($getCode != false AND $getCode > 0) {

          $arraySession = array('logged_in' => true, 'id' => $getCode);
          $this->session->set_userdata($arraySession);
          echo json_encode(array("success" => true));

        } else if ($getCode == false) echo json_encode(array("error" => true));

      } else echo json_encode(array("captcha" => true));


    } else {
      //Protection URL AJAX ACCESS
      echo json_encode(array("validation" => true));
      show_404("error_404");
    }
  }
}