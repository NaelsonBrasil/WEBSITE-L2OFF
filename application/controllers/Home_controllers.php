<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_controllers extends CI_Controller
{
  protected $arrayPublic = array();

  function __construct()
  {
    parent::__construct();
    $instance = new Pload($this->session->userdata('id'));
    $this->arrayPublic = $instance->arrayPublic;

    $config = array(
           "base_url" => base_url('notices/pag'),
           "per_page" => 1,
           "num_links" => 2,
           "uri_segment" => 3,
           "total_rows" => $this->notice->getAmountNotice(),
           "full_tag_open" => "<ul class='pagination'>",
           "full_tag_close" => "</ul>",
           "first_link" => FALSE,
           "last_link" => FALSE,
           "first_tag_open" => "<li class='page-item page-link'>",
           "first_tag_close" => "</li>",
           "prev_link" => "Previous",
           "prev_tag_open" => "<li class='page-item page-link custom-pagination' aria-label='Previous'>",
           "prev_tag_close" => "</li>",
           "next_link" => "Próxima",
           "next_tag_open" => "<li class='page-item page-link custom-pagination'>",
           "next_tag_close" => "</li>",
           "last_tag_open" => "<li class='page-item page-link'>",
           "last_tag_close" => "</li>",
           "cur_tag_open" => "<li class='page-item active '><a href='#' class='page-link'>",
           "cur_tag_close" => "</a></li>",
           "num_tag_open" => "<li class='page-item page-link custom-pagination'>",
           "num_tag_close" => "</li>"
    );

    $this->pagination->initialize($config);
    $this->arrayPublic['pagination'] = $this->pagination->create_links();
    $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $this->arrayPublic['notice'] = $this->notice->getAllRecords('text', 'asc', $config['per_page'], $offset);


  }

  public function index()
  {

//    switch (@$_GET['language']) {
//      case 1:
//        $this->lang->load('a1_br');
//        break;
//      case 2:
//        $this->lang->load('a2_en');
//        break;
//      case 3:
//        $this->lang->load('a3_esp');
//        break;
//      default:
//        $this->lang->load('a1_br');
//        break;
//    }
//
//
//
//    $data = array(
//           'activeLang' > @$_GET['language'],
//
//  );


    //echo CI_VERSION;
    //echo $this->tools->autServerEnable();

    // echo $this->account_character->updateAccountName('1','naelson');
    // echo $this->account_character->updateAccountName('1','naelson');
    // echo $this->account_character->updateCharacterName('1','studioxgame');
    // echo $this->Account->createAccount("kabaite","admin","naelson2.g.aiva@gmail.com","192.168.16.5","a","b","c","d");
    // echo $this->account_character->updatePass(2,"naelson");
    // echo $this->cached->SetCharacterLocationPacket(1,83341,148623,-3400);
    // $this->statistic->clearDataStatistic();
    //

//        for ($i = 0; $i < $this->boss_ranking->size; $i++)
//            echo $this->boss_ranking->bossName[$i]." - ".$this->boss_ranking->bossOn[$i]." - ".$this->boss_ranking->hp[$i]."<br>";

//        echo "<br>";
//
//        for ($i = 0; $i < $this->clan_ranking->size; $i++)
//            echo $this->clan_ranking->topNick[$i]." | ".$this->clan_ranking->topClan[$i]." | ".$this->clan_ranking->levelClan[$i]." | ".$this->clan_ranking->topAlliance[$i]." | ".$this->clan_ranking->topCountMember[$i]."<br>";
//
//        echo "<br>";
//
//        for ($i = 0; $i < $this->pvp_ranking->size; $i++)
//            echo $this->pvp_ranking->topNick[$i] . " " . $this->pvp_ranking->topPvp[$i] . " " . $this->pvp_ranking->topPk[$i] . "<br>";
//        echo "<br>";
//
//
//        for ($i = 0; $i < $this->pk_ranking->size; $i++)
//            echo $this->pk_ranking->topNick[$i] . " " . $this->pk_ranking->topPvp[$i] . " " . $this->pk_ranking->topPk[$i] . "<br>";

    // echo $this->account_character->updateEmail('1',"naelson.g.saraiva@gmail.com");
    //$this->user_data->UpdateUnlockChar('1','-74881','251231','-4464');


    /*
            echo '<pre>';
            print_r($data);
            echo '</pre>';
    */

    $this->load->view('public/header_view', $this->arrayPublic);
  }

  public function validation()
  {

    if (isset($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['captcha'])) {

      if ($this->session->phrase === $_POST['captcha']) {

        $getCode = $this->Account->validation($_POST['username'], $_POST['password']); //Validation

        if ($getCode != false AND $getCode > 0) {

          $arraySession = array('logged_in' => true, 'id' => $getCode);
          $this->session->set_userdata($arraySession);
          header("location: logged");

        } else if ($getCode == false) echo json_encode(array("error" => true));

      } else if ($this->session->phrase !== $_POST['captcha']) echo json_encode(array("captcha" => true,"code"=>$this->session->phrase));


    } else {
      //Protection URL AJAX ACCESS
      echo json_encode(array("validation" => true));
      show_404("error_404");
    }
  }


}
