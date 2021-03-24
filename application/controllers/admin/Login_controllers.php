<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_controllers extends CI_Controller
{
    protected $arrayGlobal = array();

    function __construct()
    {
        parent::__construct();

        $instGload = new Gload($this->session->userdata('id'));
        $this->arrayGlobal = $instGload->array;
       
    }

    public function index()
    {
        
        if (empty($this->session->contry)) {

            switch($this->arrayGlobal['lang_default']) {
  
              case 'br':
              $this->lang->load('a1_br_lang');
              break;
  
              case 'en':
              $this->lang->load('a2_en_lang');
              break;
  
              case 'sp':
              $this->lang->load('a3_esp_lang');
              break;
  
          }

        } else if(!empty($this->session->contry)) {
  
          unset($this->session->contry);
  
          switch($this->session->contry){
  
            case 'br':
            $this->lang->load('a1_br_lang');
            break;
  
            case 'en':
            $this->lang->load('a2_en_lang');
            break;
  
            case 'sp':
            $this->lang->load('a3_esp_lang');
            break;

        }
    }

        $this->load->view('admin/Login_view.php');

    }

    public function verify()
    {

        if (isset($_POST['form_username'])) {

            if ($this->input->post($this->security->get_csrf_token_name()) == $this->security->get_csrf_hash()) {

                if (!empty($this->input->post('form_username'))) {


                    if ($this->account->verifyUserName($this->input->post('form_username')) === true) {

                        header("Content-Type:  application/json");
                        echo json_encode(array("success" => true));

                    } else if ($this->account->verifyEmail($this->input->post('form_username')) === true) {

                        header("Content-Type:  application/json");
                        echo json_encode(array("success" => true));

                    } else {
                        header("Content-Type:  application/json");
                        echo json_encode(array("success" => false));
                    }
                }
            } else {
                show_error("CSRF Protection");
            }
        } else {
            show_error("Input empty click return!");
        }

    }

    public function loginValidation()
    {
        if (isset($_POST) && !empty($_POST)) {

            if ($this->input->post($this->security->get_csrf_token_name()) == $this->security->get_csrf_hash()) {

                $response = $_POST["g-recaptcha-response"];

                $captKey = $this->arrayGlobal['cphKey'];
                $success = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$captKey&response=$response");
                
                $verify = json_decode($success);

                if ($verify->success === true) {

                    $successLogin = $this->account->validation($this->input->post('form_username'), $this->input->post('form_password'));

                    if ($successLogin > 0) {

                        $arraySession = array('logged_in' => true, 'id' => $successLogin);
                        $this->session->set_userdata($arraySession);

                        echo json_encode(array("success" => true));

                    } else if ($successLogin == 0) {
                        echo json_encode(array("success" => false));
                    }

                } else {

                    echo json_encode(array("nCaptcha" => false));
                }
            } else {
                show_error("CSRF Protection");
            }
        } else {
            show_error("Input empty click return!");
        }
    }

}
