<?php
define('ABS_PATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
require_once ABS_PATH . 'oc-load.php';
require_once ABS_PATH . 'oc-content/themes/tatiana/functions.php';

// Ajax clear cookies
if($_GET['clearCookieSearch'] == 'done') {
  mb_set_cookie('tatiana-sCategory', '');
  mb_set_cookie('tatiana-sPattern', '');
  mb_set_cookie('tatiana-sPriceMin', '');
  mb_set_cookie('tatiana-sPriceMax', '');
}

if($_GET['clearCookieLocation'] == 'done') {
  mb_set_cookie('tatiana-sCountry', '');
  mb_set_cookie('tatiana-sRegion', '');
  mb_set_cookie('tatiana-sCity', '');
  mb_set_cookie('tatiana-sLocator', '');
}

//echo 'haha is there';
?>