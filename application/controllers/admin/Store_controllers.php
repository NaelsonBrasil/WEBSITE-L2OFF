<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Created by PhpStorm.
 * User: Vipcriativo.com
 * Gmail: vipcriativo.web@gmail.com
 * Date: 11/10/2018
 * Time: 1:15 PM
 */

class Store_controllers extends CI_Controller
{
    protected $arrayGlobal = array(
        'donateItemId' => array(),
        'donateItemName' => array(),
        'donateIconName' => array(),
        'donateItemPrice' => array(),
        'donateCountItem' => 0
    );

    function __construct()
    {
        parent::__construct();
        $instGload = new Gload($this->session->userdata('id'));
        $this->arrayGlobal = $instGload->array;

        $i = 0;
        foreach ($this->donate->getItem("register") as $key) {

            $this->arrayGlobal['donateItemId'][$i] = $key['item_id'];
            $this->arrayGlobal['donateItemName'][$i] = $key['item_name'];
            $this->arrayGlobal['donateIconName'][$i] = $key['icon_name'];
            $this->arrayGlobal['donateItemPrice'][$i] = $key['item_price'];
            $this->arrayGlobal['donateBonus'][$i] = $key['item_bonus'];
            $this->arrayGlobal['donateToken'][$i] = $key['token'];
            $i++;
        }

        $this->arrayGlobal['donateCountItem'] = $this->donate->getCountItem("register");
    }

    public function index()
    {
        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);
        $this->arrayGlobal['pag_content'] = 'admin/pag/shop/Cart_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }

    public function deleteRegister()
    {

        if (isset($_POST['token']) and !empty($_POST['token'])) {

            if ($this->donate->delete("register", $_POST['token'], null, null) === true) {

                echo json_encode(array("deleted" => true));

            } else {
                show_404("Error Submit Delete");
            }

        } else {
            show_404("Error Submit Delete");
        }

    }

    public function deleteOrder()
    {
        if ($this->input->post($this->security->get_csrf_token_name()) == $this->security->get_csrf_hash()) {

            if (isset($_POST['token']) and !empty($_POST['token']) and isset($_POST['orderId']) and !empty($_POST['orderId'])) {

                if ($this->donate->delete("order", $_POST['token'], $_POST['orderId'], $this->arrayGlobal['id']) === true) {

                    unset($this->session->item);
                    unset($this->session->itemName);
                    unset($this->session->itemIconName);
                    unset($this->session->total);
                    unset($this->session->amount);
                    unset($this->session->sessionProtection);

                    echo json_encode(array("deleted" => true));

                } else {
                    show_404("Error Submit Delete");
                }

            } else {
                show_404("Error Submit Delete");
            }
        }
    }
    public function addItem()
    {
        guard($this->arrayGlobal['ini_login_adm'], $this->arrayGlobal['user_name'], $this->arrayGlobal['list_acc_level']);
        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);

          
        if (isset($_POST) AND !empty($_POST) AND isset($_FILES['upload_name']['tmp_name'])) {

            $nameCrypt = md5($this->input->post($_FILES['upload_name']['tmp_name']) . rand(0, 999)) . ".jpg";
            $path = 'uploaded/icon/';
            $uploadFile = $path . basename($nameCrypt);
            move_uploaded_file($_FILES['upload_name']['tmp_name'], $uploadFile);

            $this->arrayGlobal['success'] = $this->donate->setItem(
                $this->input->post('form_id_number'),
                $this->arrayGlobal['id'],
                $this->arrayGlobal['user_name'],
                $this->input->post('form_item_name'),
                $this->input->post('form_item_price'),
                $this->input->post('form_item_bonus'),
                $nameCrypt,
                $this->input->post('form_date_time'),
                md5(rand(1, 99999))
            );

            $this->arrayGlobal['pag_content'] = 'admin/pag/shop/Add_view';
            $this->load->view('admin/template/Template', $this->arrayGlobal);
        }

        $this->arrayGlobal['pag_content'] = 'admin/pag/shop/Add_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }

    public function cal()
    {
        if ($this->input->post($this->security->get_csrf_token_name()) == $this->security->get_csrf_hash()) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if (isset($_POST['qt']) and !empty($_POST['qt']) and
                    isset($_POST['price']) and !empty($_POST['price']) and
                    isset($_POST['bonus']) and !empty($_POST['bonus']) and
                    isset($_POST['itemId']) and !empty($_POST['itemId'])) {

                    unset($this->session->item);
                    unset($this->session->itemName);
                    unset($this->session->itemIconName);
                    unset($this->session->total);
                    unset($this->session->amount);
                    unset($this->session->sessionProtection);

                    $total = $_POST['qt'] * $_POST['price'];
                    $qt = $_POST['qt'] + $_POST['bonus'];

                    $totalFormat = number_format($total, 2, '.', '');
                    $sessionData = array(
                        'item' => $_POST['itemId'],
                        'itemName' => $_POST['itemName'],
                        'itemIconName' => $_POST['iconName'],
                        'total' => $totalFormat,
                        'amount' => $qt,
                        'sessionProtection' => md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']) //Protection Hijacking
                    );

                    $this->session->set_userdata($sessionData);
                    echo json_encode(array("success" => true, "total" => $totalFormat, "qt" => $qt, "item" => $_POST['itemName']));

                } else {
                    echo json_encode(array("empty" => true));
                }
            }

        }// Ajax not return else
    }

    public function order()
    {
        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' AND !empty($this->input->post('form_item_total')) AND !empty($this->input->post('form_item_amount'))) {

          if($this->donate->getCountOrders($this->arrayGlobal['id']) <= $this->arrayGlobal['limit_orders']) {

            // if (!empty($this->input->post('form_item_total')) AND !empty($this->input->post('form_item_amount'))) {

                $tokenSession = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

                //CheckSession
                if ($this->session->sessionProtection == $tokenSession) {

                    if ($this->session->total == $this->input->post('form_item_total') and $this->session->amount == $this->input->post('form_item_amount')) {

                        date_default_timezone_set($this->arrayGlobal["dataZone"]);

                        $this->donate->setOrderItem(
                            $this->session->item,
                            $this->arrayGlobal['id'],
                            $this->arrayGlobal['user_name'],
                            $this->session->itemName,
                            $this->session->itemIconName,
                            $this->session->amount,
                            $this->session->total,
                            date("Y-m-d H:i:s")
                        );
               
                        $i = 0;
                        foreach ($this->donate->getItem("order", $this->arrayGlobal['id']) as $key) {
                            $this->arrayGlobal['orderId'][$i] = $key['id'];
                            $this->arrayGlobal['orderUserName'][$i] = $key['user_name'];
                            $this->arrayGlobal['orderItemName'][$i] = $key['item_name'];
                            $this->arrayGlobal['orderIcon'][$i] = $key['icon_name'];
                            $this->arrayGlobal['orderAmount'][$i] = $key['amount'];
                            $this->arrayGlobal['total'][$i] = $key['total'];
                            $this->arrayGlobal['orderDataTime'][$i] = $key['date_time'];
                            $this->arrayGlobal['token'][$i] = $key['token'];
                            $i++;
                        }

                       
                        $this->arrayGlobal['orderCountItem'] = $this->donate->getCountItem("order", $this->arrayGlobal['id']);

                        unset($this->session->item);
                        unset($this->session->itemName);
                        unset($this->session->itemIconName);
                        unset($this->session->total);
                        unset($this->session->amount);
                        unset($this->session->sessionProtection);

                        $this->arrayGlobal['success'] = true;
                        $this->arrayGlobal['pag_content'] = 'admin/pag/shop/Order_view';
                        $this->load->view('admin/template/Template', $this->arrayGlobal);

                    } else {

                        log_message('debug', 'Invaded access donate item IP: ' . $this->input->ip_address() . " UserName: " . $this->arrayGlobal['user_name'] . " Handled values input! Query? Contact vipcriativo.web@gmail.com");
                        show_error('Values incompatible with registered!');

                    }

                } else {

                    log_message('debug', 'Invaded access donate item IP: ' . $this->input->ip_address() . " UserName: " . $this->arrayGlobal['user_name'] . " Try Hijacking! Query? Contact vipcriativo.web@gmail.com");
                    show_error('Protection session flooding');

                }

            // } else { // Case several test and zero error can be delete

            //     $this->arrayGlobal['success'] = 'empty';
            //     $this->arrayGlobal['pag_content'] = 'admin/pag/shop/Donate_view';
            //     $this->load->view('admin/template/Template', $this->arrayGlobal);

            // }
         } else {
             
            $i = 0;
            foreach ($this->donate->getItem("order", $this->arrayGlobal['id']) as $key) {
                $this->arrayGlobal['orderId'][$i] = $key['id'];
                $this->arrayGlobal['orderUserName'][$i] = $key['user_name'];
                $this->arrayGlobal['orderItemName'][$i] = $key['item_name'];
                $this->arrayGlobal['orderIcon'][$i] = $key['icon_name'];
                $this->arrayGlobal['orderAmount'][$i] = $key['amount'];
                $this->arrayGlobal['total'][$i] = $key['total'];
                $this->arrayGlobal['orderDataTime'][$i] = $key['date_time'];
                $this->arrayGlobal['token'][$i] = $key['token'];
                $i++;
            }

            $this->arrayGlobal['limitOders'] = true;
            $this->arrayGlobal['orderCountItem'] = $this->donate->getCountItem("order", $this->arrayGlobal['id']);
            $this->arrayGlobal['pag_content'] = 'admin/pag/shop/Order_view';
            $this->load->view('admin/template/Template', $this->arrayGlobal);
            
         }
        } else {

            $i = 0;
            foreach ($this->donate->getItem("order", $this->arrayGlobal['id']) as $key) {
                $this->arrayGlobal['orderId'][$i] = $key['id'];
                $this->arrayGlobal['orderUserName'][$i] = $key['user_name'];
                $this->arrayGlobal['orderItemName'][$i] = $key['item_name'];
                $this->arrayGlobal['orderIcon'][$i] = $key['icon_name'];
                $this->arrayGlobal['orderAmount'][$i] = $key['amount'];
                $this->arrayGlobal['total'][$i] = $key['total'];
                $this->arrayGlobal['orderDataTime'][$i] = $key['date_time'];
                $this->arrayGlobal['token'][$i] = $key['token'];
                $i++;
            }

            $this->arrayGlobal['orderCountItem'] = $this->donate->getCountItem("order", $this->arrayGlobal['id']);
            $this->arrayGlobal['pag_content'] = 'admin/pag/shop/Order_view';
            $this->load->view('admin/template/Template', $this->arrayGlobal);
        }
    }

    public function process()
    {

        if ($this->input->post($this->security->get_csrf_token_name()) == $this->security->get_csrf_hash()) {

            if (is_array($this->donate->getDonate($this->input->post('form_order'), $this->arrayGlobal['id'])) and $this->donate->getDonate($this->input->post('form_order'), $this->arrayGlobal['id']) != 0) {

                $apiContext = new \PayPal\Rest\ApiContext(
                    new \PayPal\Auth\OAuthTokenCredential(
                        $this->arrayGlobal['paypalClientId'],  // ClientID
                        $this->arrayGlobal['paypalClientSecret']  // ClientSecret
                    )
                );
                
                date_default_timezone_set($this->arrayGlobal["dataZone"]);

                //Paypal: 1
                switch ($this->input->post('form_select')) {
                    case '1':

                        foreach ($this->donate->getDonate($this->input->post('form_order'), $this->arrayGlobal['id']) as $key) {
                            
                            $sessionData = array(
                                'iconName' => $key['icon_name'],
                                'dateTime' => date("Y-m-d H:i:s")
                            );
    
                            $this->session->set_userdata($sessionData);
                            pay::initialize($apiContext, base_url('admin/completed'), base_url('admin/completed'), $key['item_name'], $this->arrayGlobal['currency_type'], $key['amount'], $key['item_id'], $this->donate->getPrice($key['item_name']), $this->donate->getBonus($key['item_name']), $key['total']);
                        
                        }

                        break;

                        case '2':
                        foreach ($this->donate->getDonate($this->input->post('form_order'), $this->arrayGlobal['id']) as $key) {

                            $sessionData = array(
                                'iconName' => $key['icon_name'],
                                'dateTime' => date("Y-m-d H:i:s")
                            );
                           
                           $withOutBonus = $key['amount'] - $this->donate->getBonus($key['item_name']); 
                           paysecurity::initializePaySecurity($key['code_reference'], $key['item_id'] , $key['item_name'] , $withOutBonus ,$this->donate->getPrice($key['item_name']) ,base_url('admin/redirection'),base_url('admin/notification'));
                       
                        }

                        break;

                    default:
                        show_error("Exception submit");
                        break;
                }
            }

        } else {
            show_404("Error Submit Delete");
        }

    }

    public function verifyChar(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($this->input->post($this->security->get_csrf_token_name()) == $this->security->get_csrf_hash()) {

             echo json_encode(array('success'=> true,'charName'=>$this->account->getCharName($this->input->post('charId'))));

        }
      }
    }

    //Need delete row after of zering quantity
    public function transferItem() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($this->input->post($this->security->get_csrf_token_name()) == $this->security->get_csrf_hash()) {

           if($this->donate->getCountItemDonated($this->arrayGlobal['id'],$this->input->post("form_itemId")) > 0) {

           if($this->donate->getCountItemDonated($this->arrayGlobal['id'],$this->input->post("form_itemId")) >= $this->input->post('form_quantity')) {

           if($this->account->checkCharExist($this->input->post('form_charId')) > 0) {

           if($this->userdata->addItemCharacter($this->arrayGlobal['id'],$this->input->post('form_charId'),$this->input->post("form_itemId"),$this->input->post('form_quantity')) == 1){
             
            echo json_encode(array('success'=> true, 'qt'=> $this->donate->getCountItemDonated($this->arrayGlobal['id'],$this->input->post("form_itemId"))));

           } else { echo json_encode(array('success'=> false)); }
          } else { echo json_encode(array('charNotExist'=> true)); }
         } else { echo json_encode(array('bigger'=> true)); }
        } else { echo json_encode(array('notHaveItem'=> true)); }
       }
     }
   }

    public function itemDonated() {
        changeLang(@$_POST['form_lang'],$this->session->contry,$this->arrayGlobal['lang_default']);
        $i = 0;
        foreach ($this->donate->getDonated($this->arrayGlobal['id']) as $key) {

            $this->arrayGlobal['itemId'][$i] = $key['item_id'];
            $this->arrayGlobal['itemName'][$i] = $key['item_name'];
            $this->arrayGlobal['iconName'][$i] = $key['icon_name'];
            $this->arrayGlobal['quantity'][$i] = $key['amount'];
            $this->arrayGlobal['priceTotal'][$i] = $key['total'];
            $this->arrayGlobal['dateTime'][$i] = $key['date_time'];
            $this->arrayGlobal['dateTime'][$i] = $this->userdata->getCharId($this->arrayGlobal['id']);

            $i ++;

        }

        $j = 0;
        foreach ($this->userdata->getCharId($this->arrayGlobal['id']) as $key) {

            $this->arrayGlobal['charName'][$j] = $key['char_name'];
            $this->arrayGlobal['charId'][$j] = $key['char_id'];
            $j ++;

        }

        
        $this->arrayGlobal['countChar'] = $this->userdata->countCharId($this->arrayGlobal['id']);
        $this->arrayGlobal['countRegisterDonated'] = $this->donate->getCountRegisterDonated($this->arrayGlobal['id']);
        $this->arrayGlobal['pag_content'] = 'admin/pag/shop/Donated_view';
        $this->load->view('admin/template/Template', $this->arrayGlobal);
    }

    public function completed()
    {
        if($this->pay->completed($_GET['paymentId'], $_GET['PayerID'],$this->arrayGlobal['id'],$this->session->iconName,$this->session->dateTime) === true)
        header("Location: " . 'donated');
    }


    public function cancel()
    {
        $this->show_404('Payment Cancel');
    }

    public function redirection()
    {
         
        if (isset($_GET['transaction_id'])) {
            echo "Hello";
        }

    }

    public function notification()
    {
        if($this->arrayGlobal['workApi'] == 0){

        header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

        if (isset($_POST['notificationCode'])) {
        
        $data = array("notified_code" => $_POST['notificationCode'], "email" => "naelson.g.saraiva@gmail.com","token" => "76D361FC0DB44674A179919398F06744");

        $url = "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/{$data['notified_code']}?email={$data['email']}&token={$data['token']}";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $exe = curl_exec($ch);
        $xml = simplexml_load_string($exe);
        echo '<pre>';
        print_r($xml);
        echo '</pre>';

       }

     } else if($this->arrayGlobal['workApi'] == 1){

        header("access-control-allow-origin: https://ws.pagseguro.uol.com.br");
        if (isset($_POST['notificationCode'])) {
        
        $data = array("notified_code" => $_POST['notificationCode'], "email" => "naelson.g.saraiva@gmail.com","token" => "76D361FC0DB44674A179919398F06744");

        $url = "https://ws.pagseguro.uol.com.br/v3/transactions/notifications/{$data['notified_code']}?email={$data['email']}&token={$data['token']}";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $exe = curl_exec($ch);
        $xml = simplexml_load_string($exe);
        echo '<pre>';
        print_r($xml);
        echo '</pre>';

      }
    }
  }
}