<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Gallery_controllers extends CI_Controller
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

        $this->arrayGlobal['pag_content'] = 'admin/pag/Gallery_upload_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }

    public function upload()
    {
        guard($this->arrayGlobal['ini_login_adm'], $this->arrayGlobal['user_name'], $this->arrayGlobal['list_acc_level']);
        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);

        //Upload one image, POST detect if submit
        //print_r($_FILES);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nameCrypt = md5($this->input->post($_FILES['upload_name']['tmp_name']) . rand(0, 999)) . ".jpg";

            if ($this->gallery->setUpload($nameCrypt) === true) {
                $path = 'uploaded/';
                $uploadFile = $path . basename($nameCrypt);
                move_uploaded_file($_FILES['upload_name']['tmp_name'], $uploadFile);

                $this->arrayGlobal['success'] = true;
                $this->arrayGlobal['pag_content'] = 'admin/pag/Gallery_upload_view';
                $this->load->view('admin/template/Template', $this->arrayGlobal);
                
            } else {
                echo "Error exception insert";
            }

        } else {
            $this->arrayGlobal['success'] = false;
            $this->arrayGlobal['pag_content'] = 'admin/pag/Gallery_upload_view';
            $this->load->view('admin/template/Template', $this->arrayGlobal);
        }

    }

    public function delete()
    {
        guard($this->arrayGlobal['ini_login_adm'], $this->arrayGlobal['user_name'], $this->arrayGlobal['list_acc_level']);

        if (isset($_POST['btnId']) AND !empty($_POST['btnId']) AND isset($_POST['token']) AND !empty($_POST['token'])) {

            if ($this->gallery->deleteUp($_POST['token']) === true) {

                echo json_encode(array("deleted" => true));

            } else {

                show_404("Error Submit Delete");

            }

        } else {

            show_404("Error Delete");

        }

    }

}