<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function firstLatter($str_name){

  if (isset($str_name) AND !empty($str_name)) {
    $words = explode(" ", $str_name);
    $acronym = '';
    foreach ($words as $w) {$acronym .= $w[3];}
    return strtoupper($acronym);
  }
}


function checkString($str)
{
  $string = str_replace(' ', '-', $str); // Replaces all spaces with hyphens.
  return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function checkPregMatch($str)  {

    if (preg_match("/^[a-zA-Z0-9_. +@]+$/", $str) === 0)
        return false;
    else if (preg_match("/^[a-zA-Z0-9_. +@]+$/", $str) === 1)
        return true;

}

//Lock Character
function checkLockPregMatch($str)  {

    if (preg_match("/^[0-9 -]+$/", $str) === 0)
        return false;
    else if (preg_match("/^[0-9 -]+$/", $str) === 1)
        return true;

}

//Remove spaces
function removeSpaces($str) :string {
    return $string = str_replace(' ', '', $str); // Replaces all spaces with hyphens.
}

/* Protection against injection
 * space empty trim
 * html strip_tags
 * bar invert addslashes
 * convert code for text
 */
function inputProtection($str) :string
{
    $spaceRemove = preg_replace('/\s+/', '', $str);
    return addslashes(strip_tags(trim(htmlspecialchars($spaceRemove))));
}

function guard($login, $username, $list_access){
  (strcmp($login, $username) === 0 AND $list_access === 1) ? true : header("location: logged");
}

function changeLang($formLang,$sessionCountry,$defaultLang){

    $cIn =& get_instance();
    //$cIn->load->library('session');

      //Language multiple
      if (isset($formLang) ) {

        unset($sessionCountry);

        switch($formLang) {

          case 1:
          $cIn->lang->load('a1_br_lang');
          $cIn->session->contry = 'br';
          break;

          case 2:
          $cIn->lang->load('a2_en_lang');
          $cIn->session->contry = 'en';
          break;

          case 3:
          $cIn->lang->load('a3_esp_lang');
          $cIn->session->contry = 'sp';
          break;

        }

    } else if(empty($sessionCountry)) {

      if($defaultLang == 'br') { 

        $cIn->lang->load('a1_br_lang'); 

     } 
      else if ($defaultLang == 'en') { 

        $cIn->lang->load('a2_en_lang');

     } 
      else if ($defaultLang == 'sp') { 

        $cIn->lang->load('a3_esp_lang');

       }
    
    } else if(!empty($sessionCountry)) {

      if($sessionCountry == 'br') { 

        $cIn->lang->load('a1_br_lang');

      } 
      else if ($sessionCountry == 'en') { 

        $cIn->lang->load('a2_en_lang');

      } 
      else if ($sessionCountry == 'sp') { 

        $cIn->lang->load('a3_esp_lang');

     }

  }//End Language    

}