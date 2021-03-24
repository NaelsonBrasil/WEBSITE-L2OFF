<?php
defined('BASEPATH') OR exit('No direct script access allowed');

global $iniGlobal;

class Pload extends Gload
{
  public $arrayPublic = array();

  function __construct($id = null)
  {
    parent::__construct();

    $instPvp = new Pvp_ranking();
    $instPk = new Pk_ranking();
    $instStat = new Tools();
    $this->arrayPublic = array(
           'pag_dynamic' => 'public/dynamic/dyHome',
           'pag_menu_left' => 'public/menu_left_view',
           'pag_menu_right' => 'public/menu_right_view',
           'pag_content' => 'public/content_view',
           'pag_footer' => 'public/footer_view',
           'title' => 'Panel Administration',
           "stat_server" => $instStat->serverEnable(),
           "stat_auth" => $instStat->authServerEnable(),
           "stat_npc" => $instStat->npcEnable(),
           "amount_player" => $instStat->amountPlayer(),
      //Gallery
           "amount_img_up_public" => $this->array['amount_img_up'],
           "gallery_id_public" => array(),
           "gallery_name_public" => array(),
           "gallery__token_public" => array(),
      //Pvp
           "rank_rp_size" => $instPvp->size,
           "pvp_rp_public" => array(),
           "pk_rp_public" => array(),
           "nick_rp_public" => array(),
      //Pk
           "rank_rk_size" => $instPk->size,
           "pvp_rk_public" => array(),
           "pk_rk_public" => array(),
           "nick_rk_public" => array(),

      //Id
           'id' => $id

    );


    //Gallery
    for ($i = 0; $i < $this->arrayPublic['amount_img_up_public']; $i++) {
      $this->arrayPublic['gallery_id_public'][$i] = $this->array['gallery_id'][$i];
      $this->arrayPublic['gallery_name_public'][$i] = $this->array['gallery_image_name'][$i];
      $this->arrayPublic['gallery__token_public'][$i] = $this->array['gallery_token'][$i];
    }

    //Pvp
    for ($i = 0; $i < $instPvp->size; $i++) {
      $this->arrayPublic['pvp_rp_public'][$i] = $instPvp->topPvp[$i];
      $this->arrayPublic['pk_rp_public'][$i] = $instPvp->topPk[$i];
      $this->arrayPublic['nick_rp_public'][$i] = $instPvp->topNick[$i];
    }

    //Pk
    for ($i = 0; $i < $instPk->size; $i++) {
      $this->arrayPublic['pvp_rk_public'][$i] = $instPk->topPvp[$i];
      $this->arrayPublic['pk_rk_public'][$i] = $instPk->topPk[$i];
      $this->arrayPublic['nick_rk_public'][$i] = $instPk->topNick[$i];
    }

  }

}