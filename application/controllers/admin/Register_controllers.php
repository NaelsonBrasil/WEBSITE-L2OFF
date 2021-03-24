<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register_controllers extends CI_Controller
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
        
        $this->arrayGlobal['random'] = rand(100, 999);
        $this->load->view('admin/Register_view', $this->arrayGlobal);
    }

    public function verify()
    {

        if (!empty($_POST) && isset($_POST)) {

            if ($this->input->post($this->security->get_csrf_token_name()) == $this->security->get_csrf_hash()) {

                if (!empty($this->input->post('form_username')) AND !empty($this->input->post('csrf_protection'))) {

                    if ($this->account->verifyUserName($this->input->post('form_username')) === true) {

                        echo json_encode(array("verify" => true));

                    } else {

                        echo json_encode(array("verify" => false));
                    }

                }

                if (!empty($this->input->post('form_email')) AND !empty($this->input->post('csrf_protection'))) {


                    if ($this->account->verifyEmail($this->input->post('form_email')) === true) {

                        echo json_encode(array("verify" => true));

                    } else {

                        echo json_encode(array("verify" => false));
                    }

                }


            } else {
                show_error("CSRF Protection!");
            }
        }
    }

    public function account()
    {


         if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->input->post($this->security->get_csrf_token_name()) == $this->security->get_csrf_hash()) {
                $response = $_POST["g-recaptcha-response"];
                
                $captKey = $this->arrayGlobal['cphKey'];
                $success = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$captKey&response=$response");

                $verify = json_decode($success);

                if ($verify->success === true) {

                    if ($this->account->verifyUserName($this->input->post('form_name')) === false AND $this->account->verifyEmail($this->input->post('form_email')) === false) {

                        $data = array(
                            'name' => $this->input->post('form_name'),
                            'rand' => $this->input->post('form_random'),
                            'email' => $this->input->post('form_email'),
                            'password' => $this->input->post('form_password1'),
                            'quizOne' => $this->input->post('form_quizOne'),
                            'quizTwo' => $this->input->post('form_quizTwo'),
                            'answerOne' => $this->input->post('form_answerOne'),
                            'answerTwo' => $this->input->post('form_answerTwo'),
                        );

                         if($this->account->createAccount($data['name'] . $data['rand'], $data['email'], $data['password'], null, $data['quizOne'], $data['quizTwo'], $data['answerOne'], $data['answerTwo']) === true){
                            echo json_encode(array("success" => true)); 
                         } else {
                            echo json_encode(array("success" => false));
                      }

                    } else {

                        echo json_encode(array("nException" => true));
                    }

                } else if ($verify->success === false) {
                    echo json_encode(array("nCaptcha" => true));
                }

            } else {
                show_error("CSRF Protection!");
            }

        }
    }
}