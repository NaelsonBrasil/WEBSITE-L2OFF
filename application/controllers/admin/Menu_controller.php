<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_controller extends CI_Controller
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
        
        //Statistic
        $dataList = new Statistic();
        $this->arrayGlobal["monday"] = count($dataList->arrayMonday);
        $this->arrayGlobal["tuesday"] = count($dataList->arrayTuesday);
        $this->arrayGlobal["wednesday"] = count($dataList->arrayWednesday);
        $this->arrayGlobal["thursday"] = count($dataList->arrayThursday);
        $this->arrayGlobal["friday"] = count($dataList->arrayFriday);
        $this->arrayGlobal["saturday"] = count($dataList->arraySaturday);
        $this->arrayGlobal["sunday"] = count($dataList->arraySunday);

        if (isset($_GET['password_active'])) {
            $this->setting->setUpdateSettingView($this->session->userdata('id'), "password_active", $_GET['password_active']);
            header("Refresh: 0; url=" . current_url());
        } else if (isset($_GET['nick_name_active'])) {
            $this->setting->setUpdateSettingView($this->session->userdata('id'), "nick_name_active", $_GET['nick_name_active']);
            header("Refresh: 0; url=" . current_url());
        } else if (isset($_GET['email_active'])) {
            $this->setting->setUpdateSettingView($this->session->userdata('id'), "email_active", $_GET['email_active']);
            header("Refresh: 0; url=" . current_url());
        } else if (isset($_GET['unlock_active'])) {
            $this->setting->setUpdateSettingView($this->session->userdata('id'), "unlock_active", $_GET['unlock_active']);
            header("Refresh: 0; url=" . current_url());
        } else if (isset($_GET['send_email_active'])) {
            $this->setting->setUpdateSettingView($this->session->userdata('id'), "send_email_active", $_GET['send_email_active']);
            header("Refresh: 0; url=" . current_url());
        }


        if (isset($_POST['form_statistic'])) {
            if ($_POST['form_statistic'] == 1) {
                $this->statistic->clearDataStatistic();
                redirect(base_url('admin/menu'));
            }
        }

        $this->arrayGlobal['pag_content'] = 'admin/pag/Menu_admin_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }

    public function announcement()
    {
        guard($this->arrayGlobal['ini_login_adm'], $this->arrayGlobal['user_name'], $this->arrayGlobal['list_acc_level']);

        if (isset($_POST['form_announce']) AND !empty($_POST['form_announce'])) {

            $res = $this->lincached->SetInstantAnnouncePacket(checkString($_POST['form_announce']));

            if ($res != false)

                $this->arrayGlobal['success'] = true;

            else
                $this->arrayGlobal['success'] = false;

        }else {
            $this->arrayGlobal['success'] = false;
        }

        $this->arrayGlobal['pag_content'] = 'admin/pag/Menu_admin_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }

}