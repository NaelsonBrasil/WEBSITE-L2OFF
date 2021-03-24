<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Vipcriativo.com
 * Gmail: vipcriativo.web@gmail.com
 * Date: 11/10/2018
 * Time: 1:15 PM
 */

class Report_controllers extends CI_Controller
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

        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);
        
        $this->arrayGlobal['vip'] = $this->account->checkVip($this->arrayGlobal['id']);
        $this->arrayGlobal['pag_content'] = 'admin/pag/Report_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);

    }

    public function create()
    {

        if ($_SERVER['REQUEST_METHOD'] ==='POST' AND !empty($_POST["g-recaptcha-response"])) {

            $response = $_POST["g-recaptcha-response"];
            $captKey = $this->arrayGlobal['cphKey'];
            $success = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$captKey&response=$response");
            $verify = json_decode($success);

            if ($verify->success === true) {
                //Ony member vip can create report
                if ($this->account->checkVip($this->arrayGlobal['id']) === 1) {

                    date_default_timezone_set($this->arrayGlobal["dataZone"]);
                    $data = array(
                        'charId' => $this->arrayGlobal['id'],
                        'username' => $this->arrayGlobal['user_name'],
                        'category' => $this->input->post('category'),
                        'title' => $this->input->post('title'),
                        'dateTime' => date("Y-m-d H:i:s"),
                        'content' => $this->input->post('content'));

                    $this->arrayGlobal['success'] = $this->report->createPost($data['charId'], $data['category'], $data['username'], $data['title'], $data['content'], $data['dateTime']);
                } else {
                    $this->arrayGlobal['success'] = false;
                }

            } else if ($verify->success === false) {
                $this->arrayGlobal['success'] = false;
            }

            $this->arrayGlobal['pag_content'] = 'admin/pag/Report_view';
            $this->load->view('admin/template/Template', $this->arrayGlobal);
        }


    }
}