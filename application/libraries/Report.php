<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Account
{
    private $table = "posts";

    function __construct()
    {
        parent::__construct();
    }

    public function createPost($accountId, $category, $nick, $title, $content, $dataTime): bool
    {

        $data = array(

            'account_id' => inputProtection($accountId),
            'category' => inputProtection($category),
            'nick' => inputProtection($nick), 'title' => inputProtection($title),
            'content' => inputProtection($content),
            'date_time' => inputProtection($dataTime));

        try {

            $this->dbWeb->insert($this->table, $data);
            return true;

        } catch (Exception $e) {

            return true;
        }

    }

    public function getCountPost()
    {
        $query = $this->dbWeb->get($this->table);
        return $query->num_rows();
    }


}