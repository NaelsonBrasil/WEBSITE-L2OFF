<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cachedchatterbox extends LinCached {

 public $fSockError = 'Unable to connect with CacheD';
 public $socketErrors=array(
"1" => "OK.",
"01" => "Error.",
"02" => "Arguments need.",
"03" => "Arguments invalid.",
"04" => "Char not found.",
"05" => "Warehouse not found.",
"06" => "Account not found.",
"07" => "Char in game.",
"08" => "Too many chars.",
"09" => "Char in pledge.",
"010" => "Char pledge owner.",
"011" => "Cannot ban.",
"012" => "Name exist.",
"013" => "Obsolete.",
"014" => "Invalid char name.",
"015" => "Char not in game.",
"016" => "Same char",
"017" => "Char not in pledge.",
"018" => "Char pledge master.",
"019" => "Server not connected.",
"020" => "Create pet failed.",
"021" => "Pledge exist.",
"022" => "No chars.",
"023" => "Invalid announce id.",
"024" => "Pledge not found.",
"025" => "Castle not found.",
"026" => "Pet not found.");
}

