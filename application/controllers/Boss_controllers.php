<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boss_controllers extends CI_Controller
{
  protected $arrayPublic = array();

  function __construct()
  {
    parent::__construct();

    $instance = new Pload($this->session->userdata('id'));
    $this->arrayPublic = $instance->arrayPublic;


    $config = array(
           "base_url" => base_url('boss/pag'),
           "per_page" => 35,
           "num_links" => 2,
           "uri_segment" => 3,
           "total_rows" => $this->boss_ranking->getAmountBoss(),
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
    $this->arrayPublic['boss'] = $this->boss_ranking->getAllRecords('npc_db_name', 'asc', $config['per_page'], $offset);


  }


  public function index()
  {

    $this->arrayPublic['pag_dynamic'] = 'public/dynamic/dyBoss';
    $this->load->view('public/header_view', $this->arrayPublic);

  }
}