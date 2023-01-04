<?php
define('ABS_PATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
require_once ABS_PATH . 'oc-load.php';
require_once ABS_PATH . 'oc-content/themes/sofia/functions.php';

// Ajax clear cookies
if(Params::getParam('clearCookieSearch') == 'done') {
  mb_set_cookie('sofia-sCategory', '');
  mb_set_cookie('sofia-sPattern', '');
  mb_set_cookie('sofia-sPriceMin', '');
  mb_set_cookie('sofia-sPriceMax', '');
}

if(Params::getParam('clearCookieLocation') == 'done') {
  mb_set_cookie('sofia-sCountry', '');
  mb_set_cookie('sofia-sRegion', '');
  mb_set_cookie('sofia-sCity', '');
  mb_set_cookie('sofia-sLocator', '');
}

if(Params::getParam('clearCookieCountry') == 'done') {
  mb_set_cookie('sofia-sCountry', '');
  Params::setParam('sCountry', '');
}

if(Params::getParam('clearCookieRegion') == 'done') {
  mb_set_cookie('sofia-sRegion', '');
  Params::setParam('sRegion', '');
}

if(Params::getParam('clearCookieCity') == 'done') {
  mb_set_cookie('sofia-sCity', '');
  Params::setParam('sCity', '');
}

if(Params::getParam('clearCookieCategory') == 'done') {
  mb_set_cookie('sofia-sCategory', '');
  Params::setParam('sCategory', '');
}

if(Params::getParam('clearCookiePriceMin') == 'done') {
  mb_set_cookie('sofia-sPriceMin', '');
  Params::setParam('sPriceMin', '');
}

if(Params::getParam('clearCookiePriceMax') == 'done') {
  mb_set_cookie('sofia-sPriceMax', '');
  Params::setParam('sPriceMax', '');
}

//echo 'haha is there';
?>