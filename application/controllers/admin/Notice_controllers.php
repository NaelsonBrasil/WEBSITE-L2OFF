<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Vipcriativo.com
 * Gmail: vipcriativo.web@gmail.com
 * Date: 11/10/2018
 * Time: 1:15 PM
 */

class Notice_controllers extends CI_Controller
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
        guard($this->arrayGlobal['ini_login_adm'], $this->arrayGlobal['user_name'], $this->arrayGlobal['list_acc_level']);
        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);

        $this->arrayGlobal['pag_content'] = "admin/pag/Notice_view";
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }


    public function sentNotice()
    {
        guard($this->arrayGlobal['ini_login_adm'], $this->arrayGlobal['user_name'], $this->arrayGlobal['list_acc_level']);

        $rules = array(array('field' => 'title', 'label' => 'Msg-title', 'rules' => 'required', 'errors' => array('required' => 'You must provide a %s.')),
            array('field' => 'text', 'label' => 'Msg-text', 'rules' => 'required', 'errors' => array('required' => 'You must provide a %s.')));

        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $this->arrayGlobal['pag_content'] = "admin/pag/Notice_view";
            $this->load->view('admin/template/Template', $this->arrayGlobal);
        } else {

            $bool = ($this->notice->createNotice($this->input->post("title"), $this->input->post("text"))) ? true : false;
            if ($bool === true) {
                $this->arrayGlobal['success'] = true;
                $this->arrayGlobal['pag_content'] = "admin/pag/Notice_view";
                $this->load->view('admin/template/Template', $this->arrayGlobal);
            }
        }
    }


    public function delete()
    {
        guard($this->arrayGlobal['ini_login_adm'], $this->arrayGlobal['user_name'], $this->arrayGlobal['list_acc_level']);
        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);

        if (isset($_POST['btnId']) AND !empty($_POST['btnId']) AND isset($_POST['token']) AND !empty($_POST['token'])) {

            $this->notice->delete($_POST['token']);
            echo json_encode(array('successful' => true));

        } else {
            show_404('Error delete notice');
        }
    }

}