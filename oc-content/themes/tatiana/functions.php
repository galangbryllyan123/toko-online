<?php

define('TATIANA_THEME_VERSION', '3.5.6');

function tatiana_theme_info() {
  return array(
    'name'    => 'OSClass Tatiana Premium Theme',
    'version'   => '3.5.6',
    'description' => 'Best selling premium theme for osclass',
    'author_name' => 'MB Themes',
    'author_url'  => 'https://osclasspoint.com',
    'support_uri'  => 'http://forums.osclasspoint.com/tatiana-osclass-responsive-theme/',
    'locations'   => array('header', 'footer')
  );
}


// Cookies work
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

if( !function_exists('osc_is_edit_page') ) {
  function osc_is_edit_page() {
    return true;
  }
}

// Ajax clear cookies
if(Params::getParam('clearCookieSearch') == 'done') {
  mb_drop_cookie('tatiana-sCategory');
  //mb_drop_cookie('tatiana-sPattern');
  mb_drop_cookie('tatiana-sPriceMin');
  mb_drop_cookie('tatiana-sPriceMax');
}

if(Params::getParam('clearCookieLocation') == 'done') {
  mb_drop_cookie('tatiana-sCountry');
  mb_drop_cookie('tatiana-sRegion');
  mb_drop_cookie('tatiana-sCity');
  mb_drop_cookie('tatiana-sLocator');
}

function tatiana_search_params() {
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

function tatiana_manage_cookies() {
  if(Params::getParam('page') == 'search') { $reset = true; } else { $reset = false; }
  if($reset) {
    if(Params::getParam('sCountry') <> '' or Params::getParam('cookie-action') == 'done') { 
      mb_set_cookie('tatiana-sCountry', Params::getParam('sCountry')); 
      mb_set_cookie('tatiana-sRegion', ''); 
      mb_set_cookie('tatiana-sCity', ''); 
    }

    if(Params::getParam('sRegion') <> '' or Params::getParam('cookie-action') == 'done') {
      if(is_numeric(Params::getParam('sRegion'))) {
        $reg = Region::newInstance()->findByPrimaryKey(Params::getParam('sRegion'));
      
        mb_set_cookie('tatiana-sCountry', strtoupper($reg['fk_c_country_code'])); 
        mb_set_cookie('tatiana-sRegion', $reg['s_name']); 
        mb_set_cookie('tatiana-sCity', ''); 
      } else {
        mb_set_cookie('tatiana-sRegion', Params::getParam('sRegion')); 
        mb_set_cookie('tatiana-sCity', ''); 
      }
    }

    if(Params::getParam('sCity') <> '' or Params::getParam('cookie-action') == 'done') {
      if(is_numeric(Params::getParam('sCity'))) {
        $city = City::newInstance()->findByPrimaryKey(Params::getParam('sCity'));
        $reg = Region::newInstance()->findByPrimaryKey($city['fk_i_region_id']);
        
        mb_set_cookie('tatiana-sCountry', strtoupper($city['fk_c_country_code'])); 
        mb_set_cookie('tatiana-sRegion', $reg['s_name']); 
        mb_set_cookie('tatiana-sCity', $city['s_name']); 
      } else {
        mb_set_cookie('tatiana-sCity', Params::getParam('sCity')); 
      }
    }

    if(Params::getParam('sCategory') <> '' and Params::getParam('sCategory') <> 0 or Params::getParam('cookie-action') == 'done') { mb_set_cookie('tatiana-sCategory', Params::getParam('sCategory')); }
    //if(Params::getParam('sPattern') <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('tatiana-sPattern', Params::getParam('sPattern')); }
    if(Params::getParam('sPriceMin') <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('tatiana-sPriceMin', Params::getParam('sPriceMin')); }
    if(Params::getParam('sPriceMax') <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('tatiana-sPriceMax', Params::getParam('sPriceMax')); }
    if(Params::getParam('sLocator') <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('tatiana-sLocator', Params::getParam('sLocator')); }
    if(Params::getParam('sCompany') <> '' or Params::getParam('cookie-action') == 'done' or Params::existParam('sCompany')) { mb_set_cookie('tatiana-sCompany', Params::getParam('sCompany')); }
    if(Params::getParam('sShowAs') <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('tatiana-sShowAs', Params::getParam('sShowAs')); }
  }

  $cat = osc_search_category_id();
  $cat = $cat[0];

  $reg = osc_search_region();
  $cit = osc_search_city();

  if($cat <> '' and $cat <> 0 or Params::getParam('cookie-action') == 'done') { mb_set_cookie('tatiana-sCategory', $cat); }
  if($reg <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('tatiana-sRegion', $reg); }
  if($cit <> '' or Params::getParam('cookie-action') == 'done') { mb_set_cookie('tatiana-sCity', $cit); }

  Params::setParam('sCountry', mb_get_cookie('tatiana-sCountry'));
  Params::setParam('sRegion', mb_get_cookie('tatiana-sRegion'));
  Params::setParam('sCity', mb_get_cookie('tatiana-sCity'));
  Params::setParam('sCategory', mb_get_cookie('tatiana-sCategory'));
  //Params::setParam('sPattern', mb_get_cookie('tatiana-sPattern'));
  Params::setParam('sPriceMin', mb_get_cookie('tatiana-sPriceMin'));
  Params::setParam('sPriceMax', mb_get_cookie('tatiana-sPriceMax'));
  Params::setParam('sLocator', mb_get_cookie('tatiana-sLocator'));
  Params::setParam('sCompany', mb_get_cookie('tatiana-sCompany'));
  Params::setParam('sShowAs', mb_get_cookie('tatiana-sShowAs'));
}

// Add All / Private /Company type to search page
function mb_filter_user_type() {
  if(Params::getParam('sCompany') <> '' and Params::getParam('sCompany') <> null) {
    Search::newInstance()->addJoinTable( 'pk_i_id', DB_TABLE_PREFIX.'t_user', DB_TABLE_PREFIX.'t_item.fk_i_user_id = '.DB_TABLE_PREFIX.'t_user.pk_i_id', 'LEFT OUTER' ) ; // Mod

    if(Params::getParam('sCompany') == 1) {
      Search::newInstance()->addConditions(sprintf("%st_user.b_company = 1", DB_TABLE_PREFIX));
    } else {
      Search::newInstance()->addConditions(sprintf("coalesce(%st_user.b_company, 0) <> 1", DB_TABLE_PREFIX, DB_TABLE_PREFIX));
    }
  }
}

osc_add_hook('search_conditions', 'mb_filter_user_type');

// Radius search compatibility
if(!function_exists('radius_installed')) {
  function radius_installed() {
    return '';
  }
}

// Drag & drop image uploader
if(modern_is_fineuploader() and osc_get_osclass_section() == 'item_add' or osc_get_osclass_section() == 'item_edit') {
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

if( !OC_ADMIN ) {
  if( !function_exists('add_close_button_action') ) {
    function add_close_button_action(){
      echo '<script type="text/javascript">';
      echo '$(".flashmessage .ico-close").click(function(){';
      echo '$(this).parent().hide();';
      echo '});';
      echo '</script>';
    }
    osc_add_hook('footer', 'add_close_button_action') ;
  }
}

if(!function_exists('message_ok')) {
  function message_ok( $text ) {
    $final  = '<div style="padding: 1%;width: 98%;margin-bottom: 15px;" class="flashmessage flashmessage-ok flashmessage-inline">';
    $final .= $text;
    $final .= '</div>';
    echo $final;
  }
}

if(!function_exists('message_error')) {
  function message_error( $text ) {
    $final  = '<div style="padding: 1%;width: 98%;margin-bottom: 15px;" class="flashmessage flashmessage-error flashmessage-inline">';
    $final .= $text;
    $final .= '</div>';
    echo $final;
  }
}

if(!function_exists('osc_count_countries')) {
  function osc_count_countries() {
    if ( !View::newInstance()->_exists('contries') ) {
      View::newInstance()->_exportVariableToView('countries', Search::newInstance()->listCountries( ">=", "country_name ASC" ) );
    }
    return View::newInstance()->_count('countries');
  }
}

/* ------------- Own functions to retrieve locations also with no listings --------------*/
function mb_has_list_countries() {
  $loc_empty = osc_get_preference('locations_empty', 'tatiana_theme') <> '' ? osc_get_preference('locations_empty', 'tatiana_theme') : 1;
  $loc_empty == 1 ? $comp = ">=" : $comp = ">";

  if ( !View::newInstance()->_exists('list_countries') ) {
    View::newInstance()->_exportVariableToView('list_countries', CountryStats::newInstance()->listCountries($comp) );
  }
  $result = View::newInstance()->_next('list_countries');
  if (!$result) {
    View::newInstance()->_reset('list_countries');
  }
  return $result;
}

function mb_has_list_regions($country = '%%%%') {
  $loc_empty = osc_get_preference('locations_empty', 'tatiana_theme') <> '' ? osc_get_preference('locations_empty', 'tatiana_theme') : 1;
  $loc_empty == 1 ? $comp = ">=" : $comp = ">";

  if ( !View::newInstance()->_exists('list_regions') ) {
    View::newInstance()->_exportVariableToView('list_regions', RegionStats::newInstance()->listRegions($country, $comp) );
  }
  $result = View::newInstance()->_next('list_regions');
  if (!$result) {
    View::newInstance()->_reset('list_regions');
  }
  return $result;
}

function mb_has_list_cities($region = '%%%%') {
  $loc_empty = osc_get_preference('locations_empty', 'tatiana_theme') <> '' ? osc_get_preference('locations_empty', 'tatiana_theme') : 1;
  $loc_empty == 1 ? $comp = ">=" : $comp = ">";
  
  if ( !View::newInstance()->_exists('list_cities') ) {
    View::newInstance()->_exportVariableToView('list_cities', CityStats::newInstance()->listCities($region, $comp) );
  }
  $result = View::newInstance()->_next('list_cities');
  if (!$result) {
    View::newInstance()->_reset('list_cities');
  }
  return $result;
}
/* --------------------------------------------------------------------------------------*/

function mb_subcat_list($categories) {
  foreach($categories as $c) {
    echo '<h3>';
      echo '<a href="#" class="single-subcat" id="' . $c['pk_i_id'] . '">' . $c['s_name'] . '</a>';

      if(isset($c['categories']) && is_array($c['categories']) && !empty($c['categories'])) {
        echo '<div class="icon-add-next"></div>';
        echo '<div class="sub" style="display:none">';
          mb_subcat_list($c['categories']);
        echo '</div>';
      }
    echo '</h3>';
  }     
}

/* ------------ New Category Select ----------------------*/
function mb_category_select($categories, $c_cat, $default_item = null, $name = "sCategory") {
  //if($c_cat == '') {
  //  $c_cat = osc_search_category_id();
  //  $c_cat = $c_cat[0];
  //}

  //if ($c_cat == '') { $c_cat = osc_item_category_id(); }

  echo '<select name="' . $name . '" id="' . $name . '">';
  if(isset($default_item)) {
    echo '<option value="">' . $default_item . '</option>';
  }

  $found_parent = false;
  if(!isset($is_parent)) { $is_parent = ''; }
  foreach($categories as $c) {
    echo '<option value="' . $c['pk_i_id'] . '"' . ( ($c_cat == $c['pk_i_id']) ? 'selected="selected"' : '' ) . '>' . $c['s_name'] . '</option>';
    if(isset($c['categories']) && is_array($c['categories']) && !$found_parent) {
      $a = mb_subcategory_select($c['categories'], $c_cat, $default_item, 1, $is_parent, $c['pk_i_id']);

      // If found selected category, whole subcategory tree is added to select
      if($a[1] or $c_cat == $c['pk_i_id']) { echo $a[0]; }
    }    
  }

  echo '</select>';
}

function mb_subcategory_select($categories, $c_cat = 0, $default_item = null, $deep = 0, $is_parent = 0, $parent = 0) {
  $deep_string = "";
  for($var = 0;$var<$deep;$var++) {
    $deep_string .= '&nbsp;&nbsp;';
  }
  $deep_string = $deep_string . '-&nbsp;';
  $deep++;


  $help_text = '';

  if($is_parent < 2) { // only show subcategories in next level, not more
    if($is_parent == 1) {$is_parent = 2;}
    $found_parent = false;
    foreach($categories as $c) {
      if($c_cat == $c['pk_i_id']) { 
        $is_parent = 1;
        $found_parent = true; 
      }

      $help_text .= '<option value="' . $c['pk_i_id'] . '"' . ( ($c_cat == $c['pk_i_id']) ? 'selected="selected"' : '' ) . '>' . $deep_string . $c['s_name'] . '</option>';

      if(isset($c['categories']) && is_array($c['categories'])) {
        $a = mb_subcategory_select($c['categories'], $c_cat, $default_item, $deep, $is_parent, $c['pk_i_id']);
        $help_text .= $a[0];
        if($a[1]) {$found_parent = true; }
      }
    }

    if($found_parent or $parent == $c_cat) {} else {$help_text = '';}
  }

  if(!isset($help_text)) { $help_text= ''; }
  return array($help_text, $found_parent);
}


function mb_categories_select($name = 'sCategory', $category = null, $default_str = null) {
  if($default_str == null) { $default_str = __('Select a category', 'tatiana'); }
  mb_category_select(Category::newInstance()->toTree(), $category, $default_str, $name);
}

/* ----------------- End New Category Select --------------------- */


function mb_get_current_user_locale() {
  return OSCLocale::newInstance()->findByPrimaryKey(osc_current_user_locale());
}

function theme_tatiana_actions_admin() {
  if( Params::getParam('tatiana_general') == 'done' ) {
    $footerLink  = Params::getParam('footer_link');
    $defaultLogo = Params::getParam('default_logo');
    $new_cat_list = Params::getParam('new_cat_list');
    $refine_cat = Params::getParam('refine_cat');
    $image_upload = Params::getParam('image_upload');
    $allow_fb = Params::getParam('allow_fb');
    $def_cur = Params::getParam('def_cur');
    $locations_empty = Params::getParam('locations_empty');

    osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'tatiana_theme');
    osc_set_preference('contact_email', Params::getParam('contact_email'), 'tatiana_theme');
    osc_set_preference('phone', Params::getParam('phone'), 'tatiana_theme');
    osc_set_preference('footer_link', ($footerLink ? '1' : '0'), 'tatiana_theme');
    osc_set_preference('default_logo', ($defaultLogo ? '1' : '0'), 'tatiana_theme');
    osc_set_preference('new_cat_list', ($new_cat_list ? '1' : '0'), 'tatiana_theme');
    osc_set_preference('refine_cat', ($refine_cat ? '1' : '0'), 'tatiana_theme');
    osc_set_preference('image_upload', ($image_upload ? '1' : '0'), 'tatiana_theme');
    osc_set_preference('allow_fb', ($allow_fb ? '1' : '0'), 'tatiana_theme');
    osc_set_preference('def_cur', Params::getParam('def_cur'), 'tatiana_theme');
    osc_set_preference('locations_empty', ($locations_empty ? '1' : '0'), 'tatiana_theme');

    osc_add_flash_ok_message(__('Theme settings updated correctly', 'tatiana'), 'admin');
    header('Location: ' . osc_admin_render_theme_url('oc-content/themes/tatiana/admin/settings.php')); exit;
  }


  if( Params::getParam('tatiana_banner') == 'done' ) {
    $theme_adsense = Params::getParam('theme_adsense');

    osc_set_preference('theme_adsense', ($theme_adsense ? '1' : '0'), 'tatiana_theme');
    osc_set_preference('banner_home', stripslashes(Params::getParam('banner_home', false, false)), 'tatiana_theme');
    osc_set_preference('banner_search', stripslashes(Params::getParam('banner_search', false, false)), 'tatiana_theme');
    osc_set_preference('banner_item', stripslashes(Params::getParam('banner_item', false, false)), 'tatiana_theme');

    osc_add_flash_ok_message(__('Banner settings updated correctly', 'tatiana'), 'admin');
    header('Location: ' . osc_admin_render_theme_url('oc-content/themes/tatiana/admin/settings.php')); exit;
  }


  switch( Params::getParam('action_specific') ) {
    case('upload_logo'):
      $package = Params::getFiles('logo');
      if( $package['error'] == UPLOAD_ERR_OK ) {
        if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
          osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'tatiana'), 'admin');
        } else {
          osc_add_flash_error_message(__("An error has occurred, please try again", 'tatiana'), 'admin');
        }
      } else {
        osc_add_flash_error_message(__("An error has occurred, please try again", 'tatiana'), 'admin');
      }
      header('Location: ' . osc_admin_render_theme_url('oc-content/themes/tatiana/admin/header.php')); exit;
      break;

    case('remove'):
      if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
        @unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" );
        osc_add_flash_ok_message(__('The logo image has been removed', 'tatiana'), 'admin');
      } else {
        osc_add_flash_error_message(__("Image not found", 'tatiana'), 'admin');
      }
      header('Location: ' . osc_admin_render_theme_url('oc-content/themes/tatiana/admin/header.php')); exit;
      break;
    }
  }


  osc_add_hook('init_admin', 'theme_tatiana_actions_admin');
  osc_admin_menu_appearance(__('Header logo', 'tatiana'), osc_admin_render_theme_url('oc-content/themes/tatiana/admin/header.php'), 'header_tatiana');
  osc_admin_menu_appearance(__('Theme settings', 'tatiana'), osc_admin_render_theme_url('oc-content/themes/tatiana/admin/settings.php'), 'settings_tatiana');

  if( !function_exists('logo_header') ) {
    function logo_header() {
      $html = '<img border="0" alt="' . osc_page_title() . '" src="' . osc_current_web_theme_url('images/logo.jpg') . '" />';
      if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
        return $html;
      } else if( osc_get_preference('default_logo', 'tatiana_theme') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/default-logo.jpg")) ) {
        return '<img border="0" alt="' . osc_page_title() . '" src="' . osc_current_web_theme_url('images/default-logo.jpg') . '" />';
      } else {
        return osc_page_title();
      }
    }
  }


  function location_selector() {
    //View::newInstance()->_exportVariableToView('list_regions', Search::newInstance()->listRegions('%%%%', '>=', 'region_name ASC') ) ;
    //View::newInstance()->_exportVariableToView('list_countries', Search::newInstance()->listCountries('%%%%', '>=', 'country_name ASC') ) ;
        
    $curr_country = '';
    $curr_reg = osc_search_region();
    $curr_city = osc_search_city();
    if($curr_country == '') { $curr_country = Params::getParam('sCountry'); }
    if($curr_reg == '') { $curr_reg = Params::getParam('sRegion');}
    if($curr_city == '') { $curr_city = Params::getParam('sCity');}

    if(osc_count_countries() > 1) {
      $del = '&nbsp;&nbsp;&nbsp;';
      $show_country = true;
    } else {
      $del = '';
      $show_country = false;
    }

    if(strlen($curr_country) > 2) { 
      $cc = Country::newInstance()->findByName($curr_country);
      $curr_country = $cc['pk_c_code'];
    }

    echo '<select name="Locator" data-placeholder="' . __('Select a location', 'tatiana') . '"  id="Locator">';
    echo '<option value="">' . __('Select a location', 'tatiana') . '</option>';

    if($show_country) {
      while(mb_has_list_countries()) {
        if($show_country) {
          echo '<option value="' . osc_list_country_name() . '" ' . ( ($curr_country<> '' && osc_list_country_code() == $curr_country && $curr_reg == '' && $curr_city == '') ? 'selected="selected"' : '' ) . '>' . osc_list_country_name() . '</option>';
        }

        if($curr_country <> '' && osc_list_country_code() == $curr_country) { 
          while(mb_has_list_regions($curr_country) ) { 
            echo '<option value="//' . osc_list_region_name() . '" ' . ( ($curr_reg <> '' && osc_list_region_name() == $curr_reg  && $curr_city == '') ? 'selected="selected"' : '' ) . '>' . $del . osc_list_region_name() . '</option>';

            if($curr_reg <> '' && osc_list_region_name() == $curr_reg) { 
              $myreg_id = '';
              if( $curr_reg != '' ) {
                $v_reg_id  = Region::newInstance()->findByName($curr_reg);
                if(isset($v_reg_id['pk_i_id'])) {
                $myreg_id = $v_reg_id['pk_i_id'];
              }
            }
 
            while(mb_has_list_cities($myreg_id)) { 
              echo '<option value="--' . osc_list_city_name() . '" ' . ( ($curr_city <> '' && osc_list_city_name() == $curr_city) ? 'selected="selected"' : '' ) . '>&nbsp;&nbsp;&nbsp;' . $del . '- ' . osc_list_city_name() . '</option>';
            }
          } 
        } // End region loop
      }
    } // End country loop 

  } else {

    while(mb_has_list_regions() ) { 
      echo '<option value="//' . osc_list_region_name() . '" ' . ( ($curr_reg <> '' && osc_list_region_name() == $curr_reg && $curr_city == '') ? 'selected="selected"' : '' ) . '>' . $del . osc_list_region_name() . '</option>';

      if($curr_reg <> '' && osc_list_region_name() == $curr_reg) { 
        $myreg_id = '';
        if( $curr_reg <> '' ) {
          $v_reg_id  = Region::newInstance()->findByName($curr_reg);
          if(isset($v_reg_id['pk_i_id'])) {
            $myreg_id = $v_reg_id['pk_i_id'];
          }
        }
 
        while(mb_has_list_cities($myreg_id)) { 
          echo '<option value="--' . osc_list_city_name() . '" ' . ( ($curr_city <> '' && osc_list_city_name() == $curr_city) ? 'selected="selected"' : '' ) . '>&nbsp;&nbsp;&nbsp;' . $del . '- ' . osc_list_city_name() . '</option>';
        }
      }
    }
  }

  echo '</select>';
  View::newInstance()->_erase('cities');
  View::newInstance()->_erase('regions');
  View::newInstance()->_erase('countries');
}


// install update options
if( !function_exists('tatiana_theme_install') ) {
  function tatiana_theme_install() {
    osc_set_preference('keyword_placeholder', __('Search', 'tatiana'), 'tatiana_theme');
    osc_set_preference('contact_email', __('info@info.com', 'tatiana'), 'tatiana_theme');
    osc_set_preference('phone', __('+1 (800) 228-5651', 'tatiana'), 'tatiana_theme');
    osc_set_preference('version', TATIANA_THEME_VERSION, 'tatiana_theme');
    osc_set_preference('footer_link', true, 'tatiana_theme');
    osc_set_preference('donation', '0', 'tatiana_theme');
    osc_set_preference('default_logo', '1', 'tatiana_theme');
    osc_set_preference('new_cat_list', '1', 'tatiana_theme');
    osc_set_preference('refine_cat', '1', 'tatiana_theme');
    osc_set_preference('image_upload', '1', 'tatiana_theme');
    osc_set_preference('allow_fb', '1', 'tatiana_theme');
    osc_set_preference('def_cur', '', 'tatiana_theme');
    osc_set_preference('locations_empty', '1', 'tatiana_theme');

    osc_set_preference('banner_home', '', 'tatiana_theme');
    osc_set_preference('banner_search', '', 'tatiana_theme');
    osc_set_preference('banner_item', '', 'tatiana_theme');

    osc_reset_preferences();
  }
}

if(!function_exists('check_install_tatiana_theme')) {
  function check_install_tatiana_theme() {
    $current_version = osc_get_preference('version', 'tatiana_theme');
    //check if current version is installed or need an update<
    if( !$current_version ) {
      tatiana_theme_install();
    }
  }
}

check_install_tatiana_theme();

// USER MENU FIX
function tatiana_user_menu_fix() {
  $user = User::newInstance()->findByPrimaryKey( osc_logged_user_id() );
  View::newInstance()->_exportVariableToView('user', $user);
}

osc_add_hook('header', 'tatiana_user_menu_fix');
?>