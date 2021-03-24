<?php
defined('BASEPATH') OR exit('No direct script access allowed');

global $iniGlobal;

//Para não esquecer se o database file não tive sendo carregado não funciona
//$this->load->database('auth',true);
/*
 * Need confirm email
 * 201 = Successful
 * 409 = Conflict já existe nome
 * 410 = Conflict já existe email
 * 200 = Error special characters
 * 205 = Captcha error
 * 404 = Exception error
 */


class Account extends LinCached
{

    public $dbAuth;
    public $dbWord;
    public $dbWeb;
    public $config;

    function __construct()
    {
        parent::__construct();
        $CI = get_instance();
        global $iniGlobal;
        $this->config = $iniGlobal;

        $this->dbWeb = $CI->load->database('custom', true);
        $this->dbAuth = $CI->load->database('auth', true);
        $this->dbWord = $CI->load->database('world', true);

    }


    public function encrypt($password)
    {

        $key = array();
        $dst = array();
        $i = 0;

        while ($i < 16) {
            $i++;
            $key[$i] = ord(substr($password, $i - 1, 1));
            $dst[$i] = $key[$i];
        }

        $rslt = $key[1] + $key[2] * 256 + $key[3] * 65536 + $key[4] * 16777216;
        $one = $rslt * 213119 + 2529077;
        $one = $one - intval($one / 4294967296) * 4294967296;

        $rslt = $key[5] + $key[6] * 256 + $key[7] * 65536 + $key[8] * 16777216;
        $two = $rslt * 213247 + 2529089;
        $two = $two - intval($two / 4294967296) * 4294967296;

        $rslt = $key[9] + $key[10] * 256 + $key[11] * 65536 + $key[12] * 16777216;
        $three = $rslt * 213203 + 2529589;
        $three = $three - intval($three / 4294967296) * 4294967296;

        $rslt = $key[13] + $key[14] * 256 + $key[15] * 65536 + $key[16] * 16777216;
        $four = $rslt * 213821 + 2529997;
        $four = $four - intval($four / 4294967296) * 4294967296;

        $key[4] = intval($one / 16777216);
        $key[3] = intval(($one - $key[4] * 16777216) / 65535);
        $key[2] = intval(($one - $key[4] * 16777216 - $key[3] * 65536) / 256);
        $key[1] = intval(($one - $key[4] * 16777216 - $key[3] * 65536 - $key[2] * 256));

        $key[8] = intval($two / 16777216);
        $key[7] = intval(($two - $key[8] * 16777216) / 65535);
        $key[6] = intval(($two - $key[8] * 16777216 - $key[7] * 65536) / 256);
        $key[5] = intval(($two - $key[8] * 16777216 - $key[7] * 65536 - $key[6] * 256));

        $key[12] = intval($three / 16777216);
        $key[11] = intval(($three - $key[12] * 16777216) / 65535);
        $key[10] = intval(($three - $key[12] * 16777216 - $key[11] * 65536) / 256);
        $key[9] = intval(($three - $key[12] * 16777216 - $key[11] * 65536 - $key[10] * 256));

        $key[16] = intval($four / 16777216);
        $key[15] = intval(($four - $key[16] * 16777216) / 65535);
        $key[14] = intval(($four - $key[16] * 16777216 - $key[15] * 65536) / 256);
        $key[13] = intval(($four - $key[16] * 16777216 - $key[15] * 65536 - $key[14] * 256));

        $dst[1] = $dst[1] ^ $key[1];

        $i = 1;
        while ($i < 16) {
            $i++;
            $dst[$i] = $dst[$i] ^ $dst[$i - 1] ^ $key[$i];
        }

        $i = 0;
        while ($i < 16) {
            $i++;
            if ($dst[$i] == 0) {
                $dst[$i] = 102;
            }
        }

        $encrypt = "0x";
        $i = 0;
        while ($i < 16) {
            $i++;
            if ($dst[$i] < 16) {
                $encrypt = $encrypt . "0" . dechex($dst[$i]);
            } else {
                $encrypt = $encrypt . dechex($dst[$i]);
            }
        }

        return $encrypt;
    }

    // If false no exist or true already exist
    public function verifyUserName($name): bool
    {
        $checkHackInsert = inputProtection($name);
        $query = $this->dbWeb->select("username")->where('username', $checkHackInsert)->get('users');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // If false no exist or true already exist
    public function verifyEmail($email): bool
    {
        $checkHackInsert = inputProtection($email);
        $query = $this->dbWeb->select("email")->where('email', $checkHackInsert)->get('users');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function createAccount($username, $email, $pass, $ip = null, $quiz1, $quiz2, $answer1, $answer2): bool
    {

        $nameAntHack = inputProtection($username);
        $emailAntHack = inputProtection($email);
        $passwordAntHack = $this->encrypt(inputProtection($pass));
        $quizAntHack1 = inputProtection($quiz1);
        $quizAntHack2 = inputProtection($quiz2);
        $answer1AntHackCrypt = $this->encrypt(inputProtection($answer1));
        $answer2AntHackCrypt = $this->encrypt(inputProtection($answer2));

        $dataAuth = array(
            'account' => $nameAntHack,
            'pay_stat' => '1');

        $dataUsers = array(
            'username' => $nameAntHack,
            'email' => $emailAntHack,
            'password' => $passwordAntHack,
            'vip' => null,
            'ip' => $ip);

        try {

            $this->dbAuth->insert('user_account', $dataAuth);
            $this->dbWeb->insert('users', $dataUsers);
            $SQL = "INSERT INTO user_auth (account,password,quiz1,quiz2,answer1,answer2) VALUES ('$nameAntHack', CONVERT(binary, {$passwordAntHack}),'$quizAntHack1','$quizAntHack2' , CONVERT(binary, {$answer1AntHackCrypt}), CONVERT(binary, {$answer2AntHackCrypt}))";
            $this->dbAuth->query($SQL);

            $booleanSett = new Setting();
            $booleanSett->getValuesSettings();


            if($booleanSett->valSetting['val_send_email_register'] == 1){
                
                $message ='<html><body><h1 style="width: 100%;height: 50px;color: #2d2d2d;border-radius: 15px;text-align: center;font-family: Arial, Helvetica, sans-serif">Links das Imagens</h1><ol>';
                $message .= '<li></li>';
                $message .= '</ol></body></html>';

                // To send HTML mail, the Content-type header must be set
                $headers = 'MIME-Version: 1.1' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                mail($emailAntHack, "Password", $message, $headers);
            }

            if ($this->config["StatisticEnable"] == 1) {
                date_default_timezone_set($this->config["DataZone"]);
                new Statistic(date("l"), $nameAntHack);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function validation($ac, $pass): int
    {

        $passAntHack = $this->encrypt(inputProtection($pass));
        $acAntHack = inputProtection($ac);

        $sql = "SELECT id FROM users WHERE username = '$acAntHack' OR email = '$acAntHack' AND password = '$passAntHack' ";
        $query = $this->dbWeb->query($sql);

        if ($query->num_rows() > 0) {

            return $query->row()->id;

        } else {
            return 0;
        }

    }

    public function getAccountName($id)
    {

        $query = $this->dbAuth->select("account")->where("uid", $id)->get("user_account");

        foreach ($query->result() as $row) {
            return $row->account;
        }

    }

    public function checkListAccessLevel($id)
    {

        $query = $this->dbWord->select('builder')->where('builder', $id)->get('user_data');

        foreach ($query->result() as $row) if ($row->builder >= 1) return 1; else return 0;

    }

    public function getCharNameFast($id) : string
    {

        $query = $this->dbWord->select("char_name")->where("account_id", $id)->get("user_data");
        
        if($query->num_rows() > 0) {
            return $query->row()->char_name;
        }

        else {

            return 0;
        }
    }


    public function getCharName($id)
    {
        //Is numeric slow delay
        if(is_numeric($id) === true) {
            $query = $this->dbWord->select("char_name")->where("char_id", $id)->get("user_data");
            return $query->row()->char_name;
        }
        
    }

    public function checkCharExist($id) : int
    {
        
        if(is_numeric($id) === true) {
            $query = $this->dbWord->query("SELECT * FROM user_data WHERE char_id = '$id' ");
            return $query->num_rows();
        }
    }

    public function getPass($accountName)
    {

        $this->dbAuth->select('password');
        $this->dbAuth->from('user_auth');
        $this->dbAuth->where('account', $accountName);

        $query = $this->dbAuth->get();
        return $this->encrypt($query->row()->password);

    }

    /* 404 Error catch
     * Compare password and account
     * If num_rows > 0 update password new where equal old password and login
     * Successful = true
     * Error equal false
     */
    public function setUpdatePass($id, $oldPass, $newPass)
    {

        $nameAc = $this->getAccountName($id);
        $newAntHackPass = $this->encrypt(inputProtection($newPass));
        $oldAntHackPass = $this->encrypt(inputProtection($oldPass));

        $sql = "select * from user_auth where password = CONVERT(binary, {$oldAntHackPass} ) AND account = '$nameAc'";
        $sql = $this->dbAuth->query($sql);

        if ($sql->num_rows() > 0) {

            try {

                $sql = "UPDATE user_auth SET password = CONVERT(binary, {$newAntHackPass} ) WHERE password = CONVERT(binary, {$oldAntHackPass} ) AND account = '$nameAc'";
                $this->dbAuth->query($sql);
                return true;

            } catch (Error $e) {

                return false;

            }

        } else {
            return false;
        }

    }

    public function setUpdateAccountName($id, $new_account)
    {

        if (checkPregMatch($new_account) === false) {

            return 200;

        } else {

            $findName = $this->getAccountName($id);
            $protectNewAccount = inputProtection($new_account);

            try {

                $this->dbAuth->set('account', $protectNewAccount);
                $this->dbAuth->where('uid', $id);
                $this->dbAuth->update('user_account');

                $sql = "UPDATE user_auth SET account = '$protectNewAccount' where account = '$findName' ";
                $this->dbAuth->query($sql);
                return true;

            } catch (Error $e) {

                return false;
            }
        }
    }

    public function setUpdateCharacterName($id, $newNickName): bool
    {
        $newAntHackNick = inputProtection($newNickName);

        try {

            $this->KickCharacterPacket($id);
            usleep(100000);
            $this->ChangeCharacterNamePacket($id, $newAntHackNick);
            return true;

        } catch (Error $e) {
            return false;

        }
    }

    public function getEmail($id)
    {
        $query = $this->dbWeb->select("email")->where('id', $id)->get('users');
        return $query->row()->email;
    }

    public function updateEmail($id, $new_email)
    {

        $data = array('email' => $new_email);

        try {

            $this->dbWeb->set($data);
            $this->dbWeb->where('id', $id);
            $this->dbWeb->update('users');

            return true;

        } catch (Error $e) {
            return false;
        }
    }

    public function checkVip($id)
    {
        $query = $this->dbWeb->select("vip")->where('id', $id)->get('users');
        return $query->row()->vip;
    }

}