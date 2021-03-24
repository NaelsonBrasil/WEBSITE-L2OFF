<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Vipcriativo.com
 * Gmail: vipcriativo.web@gmail.com
 * Date: 11/10/2018
 * Time: 1:15 PM
 */

class Tools_controllers extends CI_Controller
{
    protected $arrayGlobal = array();

    function __construct()
    {
        parent::__construct();

        $instGload = new Gload($this->session->userdata('id'));
        $this->arrayGlobal = $instGload->array;

        $this->userdata->loadUserData($this->session->userdata('id')); //Get loc
    }

    public function unlockFunc()
    {

        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);
        $this->userdata->getListChar($this->arrayGlobal['id']);

        $len = count($this->userdata->charArrayName);
        for ($i = 0; $i < $len; $i++) {

            $this->arrayGlobal['charName'][$i] = $this->userdata->charArrayName[$i];
            $this->arrayGlobal['charId'][$i] = $this->userdata->arrayCharId[$i];

        }

        $this->arrayGlobal['x_loc0'] = (isset($this->user_data->stat['xloc']) == null) ? 0 : @$this->userdata->stat['xloc'];
        $this->arrayGlobal['y_loc0'] = (isset($this->user_data->stat['yloc']) == null) ? 0 : @$this->userdata->stat['yloc'];
        $this->arrayGlobal['z_loc0'] = (isset($this->user_data->stat['zloc']) == null) ? 0 : @$this->userdata->stat['zloc'];

        $this->arrayGlobal['x_loc1'] = $this->userdata->config['Xloc1'];
        $this->arrayGlobal['y_loc1'] = $this->userdata->config['Yloc2'];
        $this->arrayGlobal['z_loc1'] = $this->userdata->config['Zloc3'];


        if ($_SERVER['REQUEST_METHOD'] === 'POST' AND !empty($_POST["g-recaptcha-response"])) {

            $response = @$_POST["g-recaptcha-response"];
            $captKey = $this->arrayGlobal['cphKey'];
            $success = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$captKey&response=$response");
            $verify = json_decode($success);

            if ($verify->success === true) {

                if (checkLockPregMatch($this->input->post('form_char')) === true AND checkLockPregMatch($this->input->post('form_xloc')) === true AND checkLockPregMatch($this->input->post('form_yloc')) AND checkLockPregMatch($this->input->post('form_zloc'))) {

                    $data = array(
                        'idChar' => removeSpaces($this->input->post('form_char')),
                        'xLoc' => removeSpaces($this->input->post('form_xloc')),
                        'yLoc' => removeSpaces($this->input->post('form_yloc')),
                        'zLoc' => removeSpaces($this->input->post('form_zloc')));

                    $this->arrayGlobal['success'] = $this->tools->UpdateUnlockChar($data['idChar'], $data['xLoc'], $data['yLoc'], $data['zLoc']);

                } else {
                    $this->arrayGlobal['success'] = 200;
                }


            } else if ($verify->success === false) {
                $this->arrayGlobal['success'] = false;
            }

        }

        $this->arrayGlobal['pag_content'] = 'admin/pag/Unlock_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }

}