<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Account_controllers extends CI_Controller
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
    }

    public function password()
    {

        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);
        $this->arrayGlobal['password'] = $this->account->getPass($this->account->getAccountName($this->session->userdata('id')));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' AND !empty($_POST["g-recaptcha-response"])) {

            $response = $_POST["g-recaptcha-response"];

            $captKey = $this->arrayGlobal['cphKey'];
            $success = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$captKey&response=$response");

            $verify = json_decode($success);

            if ($verify->success === true) {

                if (checkPregMatch($this->input->post('form_password1')) === true AND checkPregMatch($this->input->post('form_password2')) === true) {

                    $this->arrayGlobal['success'] = $this->account->setUpdatePass($this->session->userdata('id'), $this->input->post('form_password1'), $this->input->post('form_password2'));

                } else {

                    $this->arrayGlobal['success'] = 200;
                }

            } else if ($verify->success === false) {

                $this->arrayGlobal['success'] = false;
            }

        }

        $this->arrayGlobal['pag_content'] = 'admin/pag/Password_change_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }

    public function nickName()
    {

        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);

        $this->userdata->getListChar($this->arrayGlobal['id']);
        $len = count($this->userdata->charArrayName);

        for ($i = 0; $i < $len; $i++) {
            $this->arrayGlobal['char_name'][$i] = $this->userdata->charArrayName[$i];
            $this->arrayGlobal['char_id'][$i] = $this->userdata->arrayCharId[$i];
        }


        $this->arrayGlobal['password'] = $this->account->getPass($this->account->getAccountName($this->session->userdata('id')));
        $this->arrayGlobal['nick_name'] = $this->account->getCharNameFast($this->session->userdata('id'));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' AND !empty($_POST["g-recaptcha-response"])) {

            $response = @$_POST["g-recaptcha-response"];

            $captKey = $this->arrayGlobal['cphKey'];
            $success = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$captKey&response=$response");

            $verify = json_decode($success);

            if ($verify->success === true) {

                if (checkPregMatch($this->input->post('form_char')) === true AND checkPregMatch($this->input->post('form_nick')) === true) {

                    $this->arrayGlobal['success'] = $this->account->setUpdateCharacterName($this->input->post('form_char'), $this->input->post('form_nick'));

                } else {

                    $this->arrayGlobal['success'] = 200;
                }

            } else if ($verify->success === false) {

                $this->arrayGlobal['success'] = false;
            }

        }

        $this->arrayGlobal['pag_content'] = 'admin/pag/Nick_change_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }

    public function changeEmail()
    {

        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);
        $this->arrayGlobal['email'] = $this->account->getEmail($this->session->userdata('id'));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' AND !empty($_POST["g-recaptcha-response"])) {

            $response = @$_POST["g-recaptcha-response"];

            $captKey = $this->arrayGlobal['cphKey'];
            $success = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$captKey&response=$response");
            
            $verify = json_decode($success);

            if ($verify->success === true) {


                if(checkPregMatch($this->input->post('form_email')) === true){

                    $this->arrayGlobal['success'] = $this->account->updateEmail($this->session->userdata('id'), $this->input->post('form_email'));

                }else {
                    $this->arrayGlobal['success'] = false;
                }

            } else if ($verify->success === false) {

                $this->arrayGlobal['success'] = false;

            }
        }

        $this->arrayGlobal['pag_content'] = 'admin/pag/Email_change_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }

}