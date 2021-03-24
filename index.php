<?php
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

$exist = file_exists("config/config.ini");

if ($exist === true) {

  switch (ENVIRONMENT) {
    case 'development':
      error_reporting(-1);
      ini_set('display_errors', 1);
      break;

    case 'testing':
    case 'production':
      ini_set('display_errors', 0);
      if (version_compare(PHP_VERSION, '5.3', '>=')) {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
      } else {
        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
      }
      break;

    default:
      header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
      echo 'The application environment is not set correctly.';
      exit(1); // EXIT_ERROR
  }

  $system_path = 'system';
  $application_folder = 'application';
  $view_folder = '';
  if (defined('STDIN')) {
    chdir(dirname(__FILE__));
  }

  if (($_temp = realpath($system_path)) !== FALSE) {
    $system_path = $_temp . DIRECTORY_SEPARATOR;
  } else {
    // Ensure there's a trailing slash
    $system_path = strtr(
                  rtrim($system_path, '/\\'),
                  '/\\',
                  DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
           ) . DIRECTORY_SEPARATOR;
  }

  // Is the system path correct?
  if (!is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3); // EXIT_CONFIG
  }

  // The name of THIS file
  define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

  // Path to the system directory
  define('BASEPATH', $system_path);

  // Path to the front controller (this file) directory
  define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

  // Name of the "system" directory
  define('SYSDIR', basename(BASEPATH));

  // The path to the "application" directory
  if (is_dir($application_folder)) {
    if (($_temp = realpath($application_folder)) !== FALSE) {
      $application_folder = $_temp;
    } else {
      $application_folder = strtr(
             rtrim($application_folder, '/\\'),
             '/\\',
             DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
      );
    }
  } elseif (is_dir(BASEPATH . $application_folder . DIRECTORY_SEPARATOR)) {
    $application_folder = BASEPATH . strtr(
                  trim($application_folder, '/\\'),
                  '/\\',
                  DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
           );
  } else {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
    exit(3); // EXIT_CONFIG
  }

  define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);

  // The path to the "views" directory
  if (!isset($view_folder[0]) && is_dir(APPPATH . 'views' . DIRECTORY_SEPARATOR)) {
    $view_folder = APPPATH . 'views';
  } elseif (is_dir($view_folder)) {
    if (($_temp = realpath($view_folder)) !== FALSE) {
      $view_folder = $_temp;
    } else {
      $view_folder = strtr(
             rtrim($view_folder, '/\\'),
             '/\\',
             DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
      );
    }
  } elseif (is_dir(APPPATH . $view_folder . DIRECTORY_SEPARATOR)) {
    $view_folder = APPPATH . strtr(
                  trim($view_folder, '/\\'),
                  '/\\',
                  DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
           );
  } else {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
    exit(3); // EXIT_CONFIG
  }

  define('VIEWPATH', $view_folder . DIRECTORY_SEPARATOR);
  require_once BASEPATH . 'core/CodeIgniter.php';
} else {


  /**
   * Write an ini configuration file
   *
   * @param string $file
   * @param array $array
   * @return bool
   */
  function write_ini_file($file, $array = [])
  {
    // check first argument is string
    if (!is_string($file)) {
      throw new \InvalidArgumentException('Function argument 1 must be a string.');
    }

    // check second argument is array
    if (!is_array($array)) {
      throw new \InvalidArgumentException('Function argument 2 must be an array.');
    }

    // process array
    $data = array();
    foreach ($array as $key => $val) {
      if (is_array($val)) {
        $data[] = "[$key]";
        foreach ($val as $skey => $sval) {
          if (is_array($sval)) {
            foreach ($sval as $_skey => $_sval) {
              if (is_numeric($_skey)) {
                $data[] = $skey . '[] = ' . (is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"' . $_sval . '"'));
              } else {
                $data[] = $skey . '[' . $_skey . '] = ' . (is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"' . $_sval . '"'));
              }
            }
          } else {
            $data[] = $skey . ' = ' . (is_numeric($sval) ? $sval : (ctype_upper($sval) ? $sval : '"' . $sval . '"'));
          }
        }
      } else {
        $data[] = $key . ' = ' . (is_numeric($val) ? $val : (ctype_upper($val) ? $val : '"' . $val . '"'));
      }
      // empty line \n
      //$data[] = null;
    }

    // open file pointer, init flock options
    $fp = fopen($file, 'w');
    $retries = 0;
    $max_retries = 100;

    if (!$fp) {
      return false;
    }

    // loop until get lock, or reach max retries
    do {
      if ($retries > 0) {
        usleep(rand(1, 5000));
      }
      $retries += 1;
    } while (!flock($fp, LOCK_EX) && $retries <= $max_retries);

    // couldn't get the lock
    if ($retries == $max_retries) {
      return false;
    }

    // got lock, write data
    fwrite($fp, implode(PHP_EOL, $data) . PHP_EOL);

    // release lock
    flock($fp, LOCK_UN);
    fclose($fp);

    return true;
  }


  if (isset($_POST) AND !empty($_POST)) {

    $array = array(

      //Add Url
           "BaseUrl" => $_POST['url'],
      //[Connection defult "sqlsrv" Drive case host no suported change]
           "DriveType" => $_POST['drive'],
      //Ip machine or instance SQL SERVER
           "IpConnect" => $_POST['ip'],
      //Username SQL
           "User" => $_POST['user'],
      //Password SQL
           "Password" => $_POST['password'],
      //Database Name
           "DbWorld" =>  $_POST['lin2world'],
           "DbLin" => $_POST['lin2db'],
           "CustomSql" => $_POST['lin2off'],
      //Ip Chaced
           "CachedIp" => "127.0.0.1",
      //Port cached
           "CachedPort" => 2012,

      //[Admin Protection]
      //Active button menuAdmin website, need access level 1 in character
           "LoginAdm" => "982admin",

      //[Tools] 0=off,1=on
           "StatisticEnable" => 1,
           "DataZone" => "Brazil/East",

      //AuthEnable
           "AuthEnable" => 0,
           "AuthIp" => "127.0.0.1",
           "AuthPort" => 2106,

      //L2ServerEnable
           "SrvEnable" => 0,
           "SrvIp" => "127.0.0.1",
           "SrvPort" => 7777,

      //NpcEnable
           "NpcEnable" => 0,
           "NpcIp" => "127.0.0.1",
           "NpcPort" => 2002,

      //Max Limit top pvp/pk Default 50
           "RankLimit" => 3,

      //Max Limit raidboss 50
           "BossLimit" => 50,

      //[Mods]
      //UnlockChar Default
           "Xloc1" => 83341,
           "Yloc2" => 148623,
           "Zloc3" => -3400,

    );

    write_ini_file("config/config.ini", $array);
    header('Location: .');

  }
  if (file_exists("config/config.ini") === false) require 'layout.html';
}