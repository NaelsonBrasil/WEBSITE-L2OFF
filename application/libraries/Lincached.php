<?php
defined('BASEPATH') OR exit('No direct script access allowed');

global $iniGlobal;

//http://wiki.depmax64.com/index.php/IL-functions_list
//Product files server http://depmax64.com/en/pages/main
/*
a - NUL-padded string
A - SPACE-padded string
h - Hex string, low nibble first
H - Hex string, high nibble first
c - signed char
C - unsigned char
s - signed short (always 16 bit, machine byte order)
S - unsigned short (always 16 bit, machine byte order)
n - unsigned short (always 16 bit, big endian byte order)
v - unsigned short (always 16 bit, little endian byte order)
i - signed integer (machine dependent size and byte order)
I - unsigned integer (machine dependent size and byte order)
l - signed long (always 32 bit, machine byte order)
L - unsigned long (always 32 bit, machine byte order)
N - unsigned long (always 32 bit, big endian byte order)
V - unsigned long (always 32 bit, little endian byte order)
f - float (machine dependent size and representation)
d - double (machine dependent size and representation)
x - NUL byte
X - Back up one byte
Z - NUL-padded string
@ - NUL-fill to absolute position
 */

class Lincached { // sobe assim

    public $cachedIp;
    public $cachedPort;
    public $webAdmin;
    public $connected;
    public $config;

    //To have explicit output, use CacheD_chatterbox, better than editing this array
    public $fSockError = false;
    public $socketErrors = array(
        "1"  => True,  "01"  => False, "02"  => False, "03"  => False, "04"  => False,
        "05" => False, "06"  => False, "07"  => False, "08"  => False, "09"  => False,
        "010"=> False, "011" => False, "012" => False, "013" => False, "014" => False,
        "015"=> False, "016" => False, "017" => False, "018" => False, "019" => False,
        "020"=> False, "021" => False, "022" => False, "023" => False, "024" => False,
        "025"=> False, "026" => False);

    public function __construct(){

        global $iniGlobal;
        $this->config = $iniGlobal;

        $this->cachedIp   = $this->config['IpConnect'];
        $this->cachedPort = $this->config['CachedPort'];
        $this->webAdmin   = $this->config['AdmNickName'];

    }

    public function toUnicode ($string){
        $rs = "";
        for($i=0; $i < strlen($string); $i++)
         $rs .= $string[$i].chr(0); // Para retornar chr, se não tiver ele retorna somente 1 caracter
        return $rs;
    }

    public function CacheDInteractive($buf) {
        $fp = fsockopen($this->cachedIp, $this->cachedPort , $errno, $errstr, 5);
        $rs = "";
        if (!$fp){ $this->connected=false; return $this -> fSockError;}
        else $this->connected=true;

        $packet = pack("s", (strlen($buf)+2)).$buf;
        fwrite($fp, $packet);
        $len = unpack("v", fread($fp, 2));
        $rid = unpack("c", fread($fp, 1));
        for ($i = 0;$i < (($len[1]-4) / 4);$i++) {
            $read = unpack("i", fread($fp, 4));
            $rs .= $read[1];
        }
        fclose($fp);
        $result = $this -> socketErrors[$rs];
        return($result);
    }

    public function CheckCharacterPacket($char_id) {
        $buf  = pack("c", 1);
        $buf .= pack("V", $char_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SetCharacterLocationPacket($char_id,$xloc,$yloc,$zloc) {
        $buf = pack("c", 2);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", 1);
        $buf .= pack("V", $xloc);
        $buf .= pack("V", $yloc);
        $buf .= pack("V", $zloc);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SetBuilderCharacterPacket($char_id, $builder_level) {
        $buf = pack("c", 3);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", $builder_level);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function ChangeCharacterNamePacket($char_id,$new_char_name){
        $buf=pack("cV",4,$char_id);
        $buf .= $this -> toUnicode($new_char_name);
        //$buf .= $this -> toUnicode($this -> webAdmin); Need hide for chance name without
        return $this -> CacheDInteractive($buf);
    }

    public function KickCharacterPacket($char_id){
        $buf = pack("cV",5,$char_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function AddSkillPacket($char_id, $skill_id, $skill_level) {
        $buf=pack("cVVV",6,$char_id,$skill_id,$skill_level);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function DelSkillPacket($char_id, $skill_id) {
        $buf = pack("c", 7);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", $skill_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function ModSkillPacket($char_id, $skill_id, $new_skill_level) {
        $buf=pack("cVVV",8,$char_id,$skill_id,$new_skill_level);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function DelItemPacket($char_id, $item_warehouse, $item_uid, $amount) {
        $buf = pack("cVVVV",13,$char_id,$item_warehouse,$item_uid,$amount);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function ModCharPacket($char_id, $new_SP, $new_EXP, $new_Karma, $new_PK, $new_PKP, $new_PVP) {
        $buf = pack("c", 15);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", $new_SP);
        $buf .= pack("V", $new_EXP);
        $buf .= pack("V", $new_Karma);
        $buf .= pack("V", $new_PK);
        $buf .= pack("V", $new_PKP);
        $buf .= pack("V", $new_PVP);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function ModChar2Packet($char_id, $gender, $race, $class, $face, $hair_shape, $hair_color) {
        $buf = pack("c", 16);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", $gender);
        $buf .= pack("V", $race);
        $buf .= pack("V", $class);
        $buf .= pack("V", $face);
        $buf .= pack("V", $hair_shape);
        $buf .= pack("V", $hair_color);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function PunishCharPacket($char_id,$punish_id,$punish_time) {
        $buf = pack("cVVV",18,$char_id,$punish_id,$punish_time);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SetBuilderAccountPacket($account_name, $builder_level) {
        $buf = pack("c", 19);
        $buf .= $this -> toUnicode($account_name);
        $buf .= pack("V", $builder_level);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function DisableCharacterPacket($char_id) {
        $buf = pack("c", 20);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", 1);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function EnableCharacterPacket($char_id, $account_id) {
        $buf = pack("c", 21);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", $account_id);
        return $this -> CacheDInteractive($buf);
    }

    public function ModChar3Packet($char_id, $add_SP, $add_EXP, $add_Karma, $add_PK, $add_PKP, $add_PVP) {
        $buf = pack("c", 29);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", $add_SP);
        $buf .= pack("V", $add_EXP);
        $buf .= pack("V", $add_Karma);
        $buf .= pack("V", $add_PK);
        $buf .= pack("V", $add_PKP);
        $buf .= pack("V", $add_PVP);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function MoveCharacterPacket($char_id,$new_account_id,$new_account_name){
        $buf=pack("cVVS",31,$char_id,$new_account_id,$this -> toUnicode($new_account_name));
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function DeleteCharPacket($char_id) {
        $buf = pack("cV",34,$char_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function PledgeChangeOwnerPacket($pledge_id, $new_leader_id) {
        $buf = pack("cVV",37,$pledge_id,$new_leader_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }


    public function PledgeDeletePacket($pledge_id) {
        $buf = pack("c", 38);
        $buf .= pack("V", $pledge_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function BanCharPacket($char_id, $hours ) {
        $buf = pack("c", 39);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", $hours);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SendHomePacket($char_id) {
        $buf = pack("cV",45,$char_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function ChangePledgeLevelPacket($pledge_id, $new_level) {
        $buf = pack("cVV",46,$pledge_id, $new_level);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function CreatePledgePacket($pledge_name, $leader_id) {
        $buf = pack("c",47);
        $buf .= $this -> toUnicode($pledge_name);
        $buf .= pack("V",$leader_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SetSkillAllPacket($char_id) {
        $buf = pack("cV",48,$char_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function RestoreCharToAccount($char_id,$new_char_name,$account_id,$account_name) {
        $buf = pack("c", 49);
        $buf .= pack("V", $char_id);
        $buf .= $this -> toUnicode($new_char_name);
        $buf .= pack("V", $account_id);
        $buf .= $this -> toUnicode($account_name);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function ManIntAnnouncePacket($text,$id,$interval) {
        $buf = pack("c", 51);
        $buf .= pack("V", 1);
        $buf .= pack("V", $interval);
        $buf .= pack("V", $id);
        $buf .= toUnicode($text);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function DelItem2Packet($item_uid, $amount) {
        $buf = pack("cVV", 54, $item_uid, $amount);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function AddItem2Packet($char_id,$warehouse,$item_type,$item_amount,$enchant, $eroded, $bless, $wished) {
        $buf = pack("c", 55);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", $warehouse);
        $buf .= pack("V", $item_type);
        $buf .= pack("V", $item_amount);
        $buf .= pack("V", $enchant);
        $buf .= pack("V", $eroded);
        $buf .= pack("V", $bless);
        $buf .= pack("V", $wished);
        $buf .= pack("V", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    //Work with char disconnected
    public function CachedAddItem($char_id,$warehouse,$item_type,$item_amount) {
        $buf = pack("c", 55);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", $warehouse);
        $buf .= pack("V", $item_type);
        $buf .= pack("V", $item_amount);
        $buf .= pack("V", 0);
        $buf .= pack("V", 0);
        $buf .= pack("V", 0);
        $buf .= pack("V", 0);
        $buf .= pack("V", 0);
        $buf .= pack("V", 254);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= pack("i", 0);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function AddItem3Packet($char_id,$warehouse,$item_type,$item_amount,$enchant, $eroded, $bless,$ident , $wished, $attack_attr_type, $attack_attr_value, $fire,$water,$wind,$earth,$holy,$unholy) {
        $buf = pack("c", 55);
        $buf .= pack("V", $char_id);
        $buf .= pack("V", $warehouse);
        $buf .= pack("V", $item_type);
        $buf .= pack("V", $item_amount);
        $buf .= pack("V", $enchant);
        $buf .= pack("V", $eroded);
        $buf .= pack("V", $bless);
        $buf .= pack("V", $ident);
        $buf .= pack("V", $wished);
        $buf .= pack("V", $attack_attr_type);
        $buf .= pack("i", $attack_attr_value);
        $buf .= pack("i", $fire);
        $buf .= pack("i", $water);
        $buf .= pack("i", $wind);
        $buf .= pack("i", $earth);
        $buf .= pack("i", $holy);
        $buf .= pack("i", $unholy);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SetSociality($char_id,$social) {
        $buf = pack("c", 69);
        $buf .= pack("i", $char_id);
        $buf .= pack("i", $social);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SetHero($char_id) {
        $buf = pack("cVV",107,$char_id,2).$this->toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SetInstantAnnouncePacket($text) {
        $buf = pack("c", 70);
        $buf .= $this -> toUnicode($text);
       // $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function ChangeSubJobPacket($char_id, $subjob_id) {
        $buf = pack("c", 89);
        $buf .= pack ("V", $char_id);
        $buf .= pack ("V", $subjob_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function StopCharPacket($char_id, $minutes) {
        $buf = pack("c", 90);
        $buf .= pack ("V", $char_id);
        $buf .= pack ("V", $minutes);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function DelPledgeEmblemPacket($pledge_id) {
        $buf = pack("c", 98);
        $buf .= pack ("V", $pledge_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SendPrivateAnnouncePacket($char_id, $text) {
        $buf = pack("c", 101);
        $buf .= pack ("V", $char_id);
        $buf .= $this -> toUnicode($text);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }


    public function EternalBanPacket($char_id) {
        $buf = pack("c", 104);
        $buf .= pack ("V", $char_id);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SetNameColor($search_type,$char,$cl_change_type,$color) {
        $buf = pack("c", 111);
        $buf .= pack("c",$search_type);
        $buf .= pack("c", $cl_change_type);
        if($search_type === 1) {
            $buf .= $this -> toUnicode($char);
        }
        else {
            $buf .= pack("V", $char);
        }
        $buf .= pack("V", $color);
        $buf .= $this -> toUnicode($this -> webAdmin);
        return $this -> CacheDInteractive($buf);
    }

    public function SetNobless($char_id) {
        $buf=pack("cVV",106,$char_id,1).$this->toUnicode("admin");
        return $this -> CacheDInteractive($buf);
    }

    public function VerCheck($id) {
        $fp = fsockopen("127.0.0.1", "7777", $errno, $errstr, 15);
        $rs = "";
        $buf = pack("c", 14);//0x0E
        $buf .= pack("i", $id);
        $len = unpack("v", fread($fp, 2)); $rid = unpack("c", fread($fp, 1));
        for ($i = 0; $i < (($len[1]-4) / 4); $i++) { $read = unpack("i", fread($fp, 4)); $rs .= $read[1]; }
        fclose($fp); return($rs);
    }

}
