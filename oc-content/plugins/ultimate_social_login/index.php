<?php defined('ABS_PATH') or die('Access denied');
/*
  Plugin Name: Ultimate Social Login 
  Plugin URI: https://osclass-pro.com/ 
  Plugin update URI: ultimate-social-login 
  Description: Osclass register or login from  social networks             
  Version: 1.2.0                                                         
  Author: osclass-pro
  Author URI: https://osclass-pro.com/  
*/
/*
 * Copyright 2019 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
define('USL_PATH', osc_plugins_path() . 'ultimate_social_login/');

require_once USL_PATH . 'consts.php';
require_once USL_PATH . 'load.php';

if(OC_ADMIN) {
    $adminSettings = new USLAdminSettings();
}

if(!osc_is_web_user_logged_in() && !OC_ADMIN) {
    $userAuth = new USLUserAuth();
}

function usl_install() {
    USLModel::newInstance()->install();
}

function usl_unistall() {
    USLModel::newInstance()->uninstall();
}

function usl_update() {
$version = osc_get_preference('version', 'usl_settings');

if($version<120) {
        osc_set_preference('version', 120, 'usl_settings');
    }    
}

usl_update();

function usl_settings() {
    osc_redirect_to(osc_route_admin_url('usl-settings'));
}

osc_register_plugin(osc_plugin_path(__FILE__), 'usl_install');
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'usl_unistall');
osc_add_hook(osc_plugin_path(__FILE__) . "_configure", 'usl_settings');