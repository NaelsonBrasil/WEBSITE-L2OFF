<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Gload {

  public $array = array();
  private $config;
  private $devConfig;
  private $shopConfig;

  function __construct($id = null){

    global $iniGlobal;
    $this->config = $iniGlobal;

    global $iniShop;
    $this->shopConfig = $iniShop;

    global $iniDevGlobal;
    $this->devConfig = $iniDevGlobal;

    $instAcc = new Account();
    $instUserData = new UserData();
    $booleanSett = new Setting();
    $instGallery = new Gallery();
    $instLive = new Live();
    $instNotice = new Notice();
    $booleanSett->getValuesSettings();


    $this->array = array(

           "dataZone" => $this->config["DataZone"],
           "cphKey" => $this->devConfig["cphKey"],
           "version" => $this->devConfig["version"],
           "paypalClientId" => $this->devConfig["payCidKey"],
           "paypalClientSecret" => $this->devConfig["payCstKey"],
           'workApi' => $this->devConfig['workApi'],
           "pag_menu" => "admin/template/Menu",
           "pag_content" => "admin/template/Content",
           "pag_footer" => "admin/template/Footer",
           "title" => "Vip DashBoard",


           "cp" => null,
           "hp" => null,
           "mp"=> null,
           "sp" => null,
           "id" => $id,
           "user_name" => $instAcc->getAccountName($id),
           "acc_level" => $instUserData->getAccessLevelChar($instAcc->getAccountName($id)),
           "list_acc_level" => $instUserData->checkListAccessLevel($id),

           'limit_orders' => $this->shopConfig['LimitOrders'],
           'currency_type' => $this->shopConfig['Currency'],
      //Config.ini
           "ini_login_adm" => null,
           "lang_default" => $this->config["LangDefault"],
      //Notice
           "amount_news" => $instNotice->getAmountNotice(),
           "notice_title" => array(),
           "notice_text" => array(),
           "notice_time" => array(),
           "notice_date" => array(),
           "notice_token" => array(),
      //Gallery
           "amount_img_up" => $instGallery->getCountImage(),
           "gallery_id" => array(),
           "gallery_image_name" => array(),
           "gallery_token" => array(),
      //Live
           "amount_live" => $instLive->getCountLive(),
           "live_id" => array(),
           "live_nick" => array(),
           "live_datetime" => array(),
           "live_url" => array(),
           "live_miniature" => array(),
           "live_token" => array(),
      //BASE URL
           "base_url" => null,
           "fist_latter" => null,
      //Errors
           "valid" => null,
      //Account change begin
           "password" => null,
           "nick_name" => null,
           "email" => null,
           "x_loc0" => null,
           "y_loc0" => null,
           "z_loc0" => null,
           "x_loc1" => null,
           "y_loc1" => null,
           "z_loc1" => null,
      //User data
           "char_name" => $charArrayName = array(),
           "char_id" => $arrayCharId = array(),
      //Setting
           "val_password" => $booleanSett->valSetting['val_password'],
           "val_nick" => $booleanSett->valSetting['val_nick'],
           "val_email" => $booleanSett->valSetting['val_email'],
           "val_unlock" => $booleanSett->valSetting['val_unlock'],
           "val_send_email_register" => $booleanSett->valSetting['val_send_email_register'],

      );



    $this->array['ini_login_adm'] = $instAcc->config['LoginAdm'];
    $this->array['base_url'] = $instAcc->config['BaseUrl'];
    $this->array['user_name'] = $instAcc->getAccountName($this->array['id']);
   //$this->array['acc_level'] = $instAcc->checkAccessLevelByName($this->array['user_name']);

    if (isset($this->array['user_name']) AND !empty($this->array['user_name'])) $this->array['fist_latter'] = firstLatter($this->array['user_name']);

    for ($i = 0; $i < $this->array['amount_img_up']; $i++) {
      $this->array['gallery_id'][$i] = $instGallery->galleryId[$i];
      $this->array['gallery_image_name'][$i] = $instGallery->galleryImageName[$i];
      $this->array['gallery_token'][$i] = $instGallery->galleryToken[$i];
    }

    for ($i = 0; $i < $this->array['amount_live']; $i++) {
      $this->array['live_id'][$i] = $instLive->liveId[$i];
      $this->array['live_nick'][$i] = $instLive->liveNick[$i];
      $this->array['live_datetime'][$i] = $instLive->liveDateTime[$i];
      $this->array['live_url'][$i] = $instLive->liveUrl[$i];
      $this->array['live_miniature'][$i] = $instLive->liveMiniatureName[$i];
      $this->array['live_token'][$i] = $instLive->liveToken[$i];
    }


    for ($i = 0; $i < $this->array['amount_news']; $i++) {
      $this->array['notice_title'][$i] = $instNotice->noticeTitle[$i];
      $this->array['notice_text'][$i] = $instNotice->noticeText[$i];
      $this->array['notice_time'][$i] = $instNotice->noticeTime[$i];
      $this->array['notice_date'][$i] = $instNotice->noticeDate[$i];
      $this->array['notice_token'][$i] = $instNotice->noticeToken[$i];
    }

  }

}
