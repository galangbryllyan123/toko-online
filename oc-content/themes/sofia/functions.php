<?php

define('SOFIA_THEME_VERSION', '3.4.1');


function sofia_theme_info() {
  return array(
    'name'    => 'OSClass Sofia Premium Theme',
    'version'   => '3.4.1',
    'description' => 'Premium OSClass Sofia Theme',
    'author_name' => 'MB Themes',
    'author_url'  => 'https://osclasspoint.com',
    'support_uri'  => 'https://forums.osclasspoint.com/sofia-osclass-responsive-theme/',
    'locations'   => array('header', 'footer')
  );
}


// -------- Start Cookies Management -----
if(!function_exists('mb_set_cookie')) {
  function mb_set_cookie($name, $val) {
    Cookie::newInstance()->set_expires( 86400 * 30 );
    Cookie::newInstance()->push($name, $val);
    Cookie::newInstance()->set();
  }
}

if(!function_exists('mb_get_cookie')) {
  function mb_get_cookie($name) {
    return Cookie::newInstance()->get_value($name);
  }
}

if(!function_exists('mb_drop_cookie')) {
  function mb_drop_cookie($name) {
    Cookie::newInstance()->pop($name);
  }
}

// Ajax clear cookies
if(Params::getParam('clearCookieSearch') == 'done') {
  mb_drop_cookie('sofia-sCategory');
  mb_drop_cookie('sofia-sPattern');
  mb_drop_cookie('sofia-sPriceMin');
  mb_drop_cookie('sofia-sPriceMax');
}

if(Params::getParam('clearCookieLocation') == 'done') {
  mb_drop_cookie('sofia-sCountry');
  mb_drop_cookie('sofia-sRegion');
  mb_drop_cookie('sofia-sCity');
  mb_drop_cookie('sofia-sLocator');
}

if(!function_exists('radius_installed')) {
  function radius_installed() {
    return '';
  }
}

function sofia_manage_cookies() {
  if(Params::getParam('page') == 'search') { $reset = true; } else { $reset = false; }
  if($reset) {
    if(Params::getParam('sCountry') <> '' or Params::getParam('cookie-action') == 'done') {
      mb_set_cookie('sofia-sCountry', Params::getParam('sCountry'));
      mb_set_cookie('sofia-sRegion', ''); 
      mb_set_cookie('sofia-sCity', ''); 
    }

    if(Params::getParam('sRegion') <> '' or Params::getParam('cookie-action') == 'done') {
      if(is_numeric(Params::getParam('sRegion'))) {
        $reg = Region::newInstance()->findByPrimaryKey(Params::getParam('sRegion'));
      
        mb_set_cookie('sofia-sCountry', strtoupper(isset($reg['fk_c_country_code']) ? $reg['fk_c_country_code'] : '')); 
        mb_set_cookie('sofia-sRegion', isset($reg['s_name']) ? $reg['s_name'] : ''); 
        mb_set_cookie('sofia-sCity', ''); 
      } else {
        $reg = Region::newInstance()->findByName(Params::getParam('sRegion'));

        mb_set_cookie('sofia-sCountry', strtoupper(isset($reg['fk_c_country_code']) ? $reg['fk_c_country_code'] : '')); 
        mb_set_cookie('sofia-sRegion', Params::getParam('sRegion')); 
        mb_set_cookie('sofia-sCity', ''); 
      }
    }

    if(Params::getParam('sCity') <> '' or Params::getParam('cookie-action') == 'done') {
      if(is_numeric(Params::getParam('sCity'))) {
        $city = City::newInstance()->findByPrimaryKey(Params::getParam('sCity'));
        $reg = Region::newInstance()->findByPrimaryKey(isset($city['fk_i_region_id']) ? $city['fk_i_region_id'] : '');
        
        mb_set_cookie('sofia-sCountry', strtoupper(isset($city['fk_c_country_code']) ? $city['fk_c_country_code'] : '')); 
        mb_set_cookie('sofia-sRegion', isset($reg['s_name']) ? $reg['s_name'] : ''); 
        mb_set_cookie('sofia-sCity', isset($city['s_name']) ? $city['s_name'] : ''); 
      } else {
        $city = City::newInstance()->findByName(Params::getParam('sCity'));
        $reg = Region::newInstance()->findByPrimaryKey(isset($city['fk_i_region_id']) ? $city['fk_i_region_id'] : '');
        $reg_final = Params::getParam('sRegion') <> '' ? Params::getParam('sRegion') : (isset($reg['s_name']) ? $reg['s_name'] : '');

        mb_set_cookie('sofia-sCountry', strtoupper(isset($city['fk_c_country_code']) ? $city['fk_c_country_code'] : '')); 
        mb_set_cookie('sofia-sRegion', $reg_final); 
        mb_set_cookie('sofia-sCity', Params::getParam('sCity')); 
      }
    }

    if(Params::getParam('sCategory') <> '' and Params::getParam('sCategory') <> 0 or Params::getParam('cookie-action') == 'done') { mb_set_cookie('sofia-sCategory', Params::getParam('sCategory')); }
    //if(Params::getParam('sPattern') <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('sofia-sPattern', Params::getParam('sPattern')); }
    if(Params::getParam('sPriceMin') <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('sofia-sPriceMin', Params::getParam('sPriceMin')); }
    if(Params::getParam('sPriceMax') <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('sofia-sPriceMax', Params::getParam('sPriceMax')); }
    if(Params::getParam('sCompany') <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('sofia-sCompany', Params::getParam('sCompany')); }
    if(Params::getParam('sShowAs') <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('sofia-sShowAs', Params::getParam('sShowAs')); }
  }

  $cat = osc_search_category_id();
  $cat = isset($cat[0]) ? $cat[0] : '';

  $reg = osc_search_region();
  $cit = osc_search_city();

  if($cat <> '' and $cat <> 0 or Params::getParam('cookie-action') == 'done') { mb_set_cookie('sofia-sCategory', $cat); }
  if($reg <> '') { mb_set_cookie('sofia-sRegion', $reg); }
  if($cit <> '') { mb_set_cookie('sofia-sCity', $cit); }


  Params::setParam('sCountry', mb_get_cookie('sofia-sCountry'));
  Params::setParam('sRegion', mb_get_cookie('sofia-sRegion'));
  Params::setParam('sCity', mb_get_cookie('sofia-sCity'));

  Params::setParam('sCategory', mb_get_cookie('sofia-sCategory'));
  Params::setParam('sPattern', mb_get_cookie('sofia-sPattern'));
  Params::setParam('sPriceMin', mb_get_cookie('sofia-sPriceMin'));
  Params::setParam('sPriceMax', mb_get_cookie('sofia-sPriceMax'));
  Params::setParam('sLocator', mb_get_cookie('sofia-sLocator'));
  Params::setParam('sCompany', mb_get_cookie('sofia-sCompany'));
  Params::setParam('sShowAs', mb_get_cookie('sofia-sShowAs'));
}
// -------- End Cookies Management -------

function sofia_filter_user_type() {
  if(Params::getParam('sCompany') <> '' and Params::getParam('sCompany') <> null) {
    Search::newInstance()->addJoinTable( 'pk_i_id', DB_TABLE_PREFIX.'t_user', DB_TABLE_PREFIX.'t_item.fk_i_user_id = '.DB_TABLE_PREFIX.'t_user.pk_i_id', 'LEFT OUTER' ) ; // Mod

    if(Params::getParam('sCompany') == 1) {
      Search::newInstance()->addConditions(sprintf("%st_user.b_company = 1", DB_TABLE_PREFIX));
    } else {
      Search::newInstance()->addConditions(sprintf("coalesce(%st_user.b_company, 0) <> 1", DB_TABLE_PREFIX, DB_TABLE_PREFIX));
    }
  }
}

osc_add_hook('search_conditions', 'sofia_filter_user_type');

function sofia_search_params() {
 return array(
   'sCategory' => Params::getParam('sCategory'),
   'sCountry' => Params::getParam('sCountry'),
   'sRegion' => Params::getParam('sRegion'),
   'sCity' => Params::getParam('sCity'),
   'sPriceMin' => Params::getParam('sPriceMin'),
   'sPriceMin' => Params::getParam('sPriceMax'),
   'sCompany' => Params::getParam('sCompany'),
   'sShowAs' => Params::getParam('sShowAs')
  );
}

if(modern_is_fineuploader()) {
  if(!OC_ADMIN) {
    osc_enqueue_style('fine-uploader-css', osc_assets_url('js/fineuploader/fineuploader.css'));
  }
  osc_enqueue_script('jquery-fineuploader');
}

function modern_is_fineuploader() {
  if(class_exists('Scripts')) {
    return Scripts::newInstance()->registered['jquery-fineuploader'] && method_exists('ItemForm', 'ajax_photos');
  }
}
function chosen_region_select($current_region = null) {
  View::newInstance()->_exportVariableToView('list_regions', Search::newInstance()->listRegions('%%%%', '>=', 'region_name ASC') ) ;

  if( osc_count_list_regions() > 0 ) {
    echo '<select name="sRegion" data-placeholder="' . osc_esc_html(__('Select a region...', 'sofia')) . '"  id="sRegion">' ;
    echo '<option value ="">' . __('Select a region', 'sofia') . '</option>' ;
    
    while( osc_has_list_regions() ) {
      echo '<option value="' . osc_esc_html(osc_list_region_name()) . '" '. (($current_region == osc_list_region_name() or $current_region == osc_list_region_id()) ? 'selected="selected"' : '') .'>' . osc_list_region_name() . '</option>' ;
    }
    
    echo '</select>' ;
  }
    
  View::newInstance()->_erase('list_regions') ;
}

function mb_subcat_list($categories) {
  foreach($categories as $c) {
    echo '<h3>';
      echo '<a href="#" class="single-subcat" id="' . (isset($c['pk_i_id']) ? $c['pk_i_id'] : '') . '">' . (isset($c['s_name']) ? $c['s_name'] : '') . '</a>';

      if(isset($c['categories']) && is_array($c['categories']) && !empty($c['categories'])) {
        echo '<div class="icon-add-next"></div>';
        echo '<div class="sub" style="display:none">';
          mb_subcat_list($c['categories']);
        echo '</div>';
      }
    echo '</h3>';
  }     
}

if( !OC_ADMIN ) {
  if( !function_exists('add_close_button_action') ) {
    function add_close_button_action(){
      echo '<script type="text/javascript">';
        echo '$(".flashmessage .ico-close").click(function(){';
          echo '$(this).parent().hide();';
        echo '});';
      echo '</script>';
    }
    osc_add_hook('footer', 'add_close_button_action');
  }
}

function theme_sofia_actions_admin() {
  if( Params::getParam('sofia_general') == 'done' ) {
    $footerLink  = Params::getParam('footer_link');
    $defaultLogo = Params::getParam('default_logo');
    $image_upload = Params::getParam('image_upload');

    osc_set_preference('image_upload', ($image_upload ? '1' : '0'), 'sofia_theme');
    osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'sofia_theme');
    osc_set_preference('contact_email', Params::getParam('contact_email'), 'sofia_theme');
    osc_set_preference('footer_link', ($footerLink ? '1' : '0'), 'sofia_theme');
    osc_set_preference('default_logo', ($defaultLogo ? '1' : '0'), 'sofia_theme');
    osc_set_preference('footer_email', Params::getParam('footer_email'), 'sofia_theme');
    osc_set_preference('facebook_link', Params::getParam('facebook_link'), 'sofia_theme');
    osc_set_preference('twitter_link', Params::getParam('twitter_link'), 'sofia_theme');
    osc_set_preference('google_link', Params::getParam('google_link'), 'sofia_theme');

    osc_add_flash_ok_message(__('Theme settings updated correctly', 'sofia'), 'admin');
    header('Location: ' . osc_admin_render_theme_url('oc-content/themes/sofia/admin/settings.php')); exit;
  }


  if( Params::getParam('sofia_banner') == 'done' ) {
    $theme_adsense = Params::getParam('theme_adsense');

    osc_set_preference('theme_adsense', ($theme_adsense ? '1' : '0'), 'sofia_theme');
    osc_set_preference('banner_home', stripslashes(Params::getParam('banner_home', false, false)), 'sofia_theme');
    osc_set_preference('banner_search', stripslashes(Params::getParam('banner_search', false, false)), 'sofia_theme');
    osc_set_preference('banner_item', stripslashes(Params::getParam('banner_item', false, false)), 'sofia_theme');

    osc_add_flash_ok_message(__('Banner settings updated correctly', 'sofia'), 'admin');
    header('Location: ' . osc_admin_render_theme_url('oc-content/themes/sofia/admin/settings.php')); exit;
  }
  
  
  if( Params::getParam('sofia_layout') == 'done' ) {
      osc_set_preference('bg_color', Params::getParam('bg_color'), 'sofia_theme');
      osc_set_preference('publish_bg_top', Params::getParam('publish_bg_top'), 'sofia_theme');
      osc_set_preference('publish_bg_bottom', Params::getParam('publish_bg_bottom'), 'sofia_theme');
      osc_set_preference('publish_color', Params::getParam('publish_color'), 'sofia_theme');
      osc_set_preference('publish_border', Params::getParam('publish_border'), 'sofia_theme');
      osc_set_preference('publish_bg_hover_top', Params::getParam('publish_bg_hover_top'), 'sofia_theme');
      osc_set_preference('publish_bg_hover_bottom', Params::getParam('publish_bg_hover_bottom'), 'sofia_theme');
      osc_set_preference('search_bg_top', Params::getParam('search_bg_top'), 'sofia_theme');
      osc_set_preference('search_bg_bottom', Params::getParam('search_bg_bottom'), 'sofia_theme');
      osc_set_preference('search_color', Params::getParam('search_color'), 'sofia_theme');
      osc_set_preference('search_border', Params::getParam('search_border'), 'sofia_theme');
      osc_set_preference('contact_bg_top', Params::getParam('contact_bg_top'), 'sofia_theme');
      osc_set_preference('contact_bg_bottom', Params::getParam('contact_bg_bottom'), 'sofia_theme');
      osc_set_preference('contact_color', Params::getParam('contact_color'), 'sofia_theme');
      osc_set_preference('contact_border', Params::getParam('contact_border'), 'sofia_theme');

    osc_add_flash_ok_message(__('Theme layout settings updated correctly', 'sofia'), 'admin');
    header('Location: ' . osc_admin_render_theme_url('oc-content/themes/sofia/admin/settings.php')); exit;
  }


  switch( Params::getParam('action_specific') ) {
    case('upload_logo'):
      $package = Params::getFiles('logo');
      if( isset($package['error']) && $package['error'] == UPLOAD_ERR_OK ) {
        if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
          osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'sofia'), 'admin');
        } else {
          osc_add_flash_error_message(__("An error has occurred, please try again", 'sofia'), 'admin');
        }
      } else {
        osc_add_flash_error_message(__("An error has occurred, please try again", 'sofia'), 'admin');
      }
      header('Location: ' . osc_admin_render_theme_url('oc-content/themes/sofia/admin/header.php')); exit;
      break;

    case('remove'):
      if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
        @unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" );
        osc_add_flash_ok_message(__('The logo image has been removed', 'sofia'), 'admin');
      } else {
        osc_add_flash_error_message(__("Image not found", 'sofia'), 'admin');
      }
      header('Location: ' . osc_admin_render_theme_url('oc-content/themes/sofia/admin/header.php')); exit;
      break;
    }
  }


osc_add_hook('init_admin', 'theme_sofia_actions_admin');
osc_admin_menu_appearance(__('Header logo', 'sofia'), osc_admin_render_theme_url('oc-content/themes/sofia/admin/header.php'), 'header_sofia');
osc_admin_menu_appearance(__('Theme settings', 'sofia'), osc_admin_render_theme_url('oc-content/themes/sofia/admin/settings.php'), 'settings_sofia');

if( !function_exists('logo_header') ) {
  function logo_header() {
    $html = '<img border="0" alt="' . osc_esc_html(osc_page_title()) . '" src="' . osc_current_web_theme_url('images/logo.jpg') . '" />';
    if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
      return $html;
    } else if( osc_get_preference('default_logo', 'sofia_theme') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/default-logo.jpg")) ) {
      return '<img border="0" alt="' . osc_esc_html(osc_page_title()) . '" src="' . osc_current_web_theme_url('images/default-logo.jpg') . '" />';
    } else {
      return osc_page_title();
    }
  }
}

// install update options
if( !function_exists('sofia_theme_install') ) {
  function sofia_theme_install() {
    osc_set_preference('keyword_placeholder', __('ie. PHP Programmer', 'sofia'), 'sofia_theme');
    osc_set_preference('contact_email', __('info@info.com', 'sofia'), 'sofia_theme');
    osc_set_preference('version', SOFIA_THEME_VERSION, 'sofia_theme');
    osc_set_preference('footer_link', true, 'sofia_theme');
    osc_set_preference('theme_adsense', true, 'sofia_theme');
    osc_set_preference('donation', '0', 'sofia_theme');
    osc_set_preference('default_logo', '1', 'sofia_theme');
    osc_set_preference('bg_color', '#FFFFFF', 'sofia_theme');
    osc_set_preference('publish_bg_top', '#50B7D1', 'sofia_theme');
    osc_set_preference('publish_bg_bottom', '#286DA3', 'sofia_theme');
    osc_set_preference('publish_color', '', 'sofia_theme');
    osc_set_preference('publish_border', '', 'sofia_theme');
    osc_set_preference('publish_bg_hover_bottom', '', 'sofia_theme');
    osc_set_preference('publish_bg_hover_top', '', 'sofia_theme');
    osc_set_preference('search_bg_top', '', 'sofia_theme');
    osc_set_preference('search_bg_bottom', '', 'sofia_theme');
    osc_set_preference('search_color', '', 'sofia_theme');
    osc_set_preference('search_border', '', 'sofia_theme');
    osc_set_preference('contact_bg_top', '', 'sofia_theme');
    osc_set_preference('contact_bg_bottom', '', 'sofia_theme');
    osc_set_preference('contact_color', '', 'sofia_theme');
    osc_set_preference('contact_border', '', 'sofia_theme');
    osc_set_preference('image_upload', '1', 'sofia_theme');
    osc_set_preference('footer_email', 'info@info.com', 'sofia_theme');
    osc_set_preference('banner_home', '', 'sofia_theme');
    osc_set_preference('banner_search', '', 'sofia_theme');
    osc_set_preference('banner_item', '', 'sofia_theme');
    osc_set_preference('facebook_link', '', 'sofia_theme');
    osc_set_preference('twitter_link', '', 'sofia_theme');
    osc_set_preference('google_link', '', 'sofia_theme');

    osc_reset_preferences();
  }
}

if(!function_exists('check_install_sofia_theme')) {
  function check_install_sofia_theme() {
    $current_version = osc_get_preference('version', 'sofia_theme');
    //check if current version is installed or need an update<
    if( !$current_version ) {
      sofia_theme_install();
    }
  }
}
check_install_sofia_theme();

?>