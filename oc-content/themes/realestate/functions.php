<?php
  //Preferences
  if(!osc_get_preference('keyword_placeholder','realestate')){
    osc_set_preference('keyword_placeholder',__('Luxury Villas', 'realestate'),'realestate');
  }
  if(osc_get_preference('theme_version', 'realestate')=='') {
    osc_set_preference('theme_version', '0','realestate');
  }
  if( osc_get_preference('defaultLocationShowAs','realestate')=='') {
    osc_set_preference('defaultLocationShowAs', 'dropdown', 'realestate');
  }

  // update THEME_VERSION preference
  if(osc_get_preference('theme_version', 'realestate')=='') {
    // Update logo destination, now is uploaded to oc-content/uploads/
    if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
    rename(WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg", osc_uploads_path() . "realestate-logo.jpg");
    }
    if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo-footer.jpg" ) ) {
    rename(WebThemes::newInstance()->getCurrentThemePath() . "images/logo-footer.jpg", osc_uploads_path() . "realestate-logo-footer.jpg");
    }
    osc_set_preference('theme_version', 202,'realestate');
  }

  function item_realestate_attributes(){
    //get_realestate_attributes
    if(function_exists('get_realestate_attributes')){
      $data = get_realestate_attributes();
      $print = array();
      if(isset($data['attributes']['property_type'])){
        $print[] = $data['attributes']['property_type']['value'];
      }
      if(isset($data['attributes']['plot_area'])){
        $print[] = $data['attributes']['plot_area']['value'].' m<sup>2</sup>';
      }
      if($print){
        echo join('<br />',$print);
      }
    }
    return false;
  }
  function multilanguage_form_input_text($locale,$field){
    $name = str_replace('%locale%',$locale['pk_c_code'],$field['name']);
    echo '<input id="'.$name.'" type="text" name="'.$name.'" value="'.osc_esc_html(htmlentities($field['value'][$locale['pk_c_code']], ENT_COMPAT, "UTF-8")).'" '.$field['args'].' />' ;
  }
  function multilanguage_form_input_textarea($locale,$field){
    $name = str_replace('%locale%', $locale['pk_c_code'], $field['name']);
    $txt = '' ;
    if( array_key_exists('value', $field) ) {
      if( array_key_exists($locale['pk_c_code'], $field['value']) ) {
        $txt = $field['value'][$locale['pk_c_code']];
      }
    }
    echo '<textarea id="'.$name.'" name="'.$name.'" '.$field['args'].'>'.$txt.'</textarea>';
  }
  function multilanguage_form_input_select($locale,$field){
    $name = str_replace('%locale%',$locale['pk_c_code'],$field['name']);
    echo '<select id="'.$name.'" name="'.$name.'" '.$fields['args'].'>';
       if($field['options'][$locale['pk_c_code']]){
         foreach($field['options'][$locale['pk_c_code']] as $option){
          echo '<option value="'.$option['value'].'">'.$option['label'].'</option>';
         }
       }
    echo '</select>';
  }
  function multilanguage_form_label($locale,$field){
    $required = '';
    if($field['required']){
      if($field['required']==true){
        $required = '*';
      }
    }
    $name = str_replace('%locale%',$locale['pk_c_code'],$field['name']);
    echo '<label for="'.$name.']">' . $field['label'] .$required. '</label>';
  }
  function multilanguage_form_create_field($locale,$field,$label = true){
    if(!isset($field['args'])){
      $fields['args'] = '';
    }
    if(!isset($field['value'][$locale['pk_c_code']])){
      $fields['value'][$locale['pk_c_code']] = '';
    }
    if($label){
      multilanguage_form_label($locale,$field);
    }
    call_user_func_array('multilanguage_form_input_'.$field['type'],array($locale,$field));
  }
  function multilanguage_form($fields) {
      $locales = osc_get_locales();
      $item = osc_item();
      $num_locales = count($locales);

      foreach($locales as $locale) {
        foreach($fields as $field){
          if($num_locales > 1){
            echo '<div class="switch-locale locale-'.$locale['pk_c_code'].'">';
          }
          multilanguage_form_create_field($locale,$field);
          if($num_locales > 1){
            echo '</div>';
          }
        }
       }
  }
  if( !OC_ADMIN ) {
    if( !function_exists('add_close_button_fm') ) {
      function add_close_button_fm($message){
        return $message.'<a class="close">??</a>' ;
      }
      if(osc_version() < 300){
        osc_add_filter('flash_message_text', 'add_close_button_fm') ;
      }
    }
    if( !function_exists('add_close_button_action') ) {
      function add_close_button_action(){
        echo '<script type="text/javascript">';
          echo '$(".FlashMessage .close, .flashmessage .ico-close").click(function(){';
            echo '$(this).parent().hide();';
          echo '});';
        echo '</script>';
      }
      osc_add_hook('footer', 'add_close_button_action') ;
    }
  }

  if( !function_exists('get_gravatar') ) {
    function get_gravatar($email = null, $size = 65) {
      $email = md5( strtolower( trim( $email ) ) );
      $default = urlencode( osc_current_web_theme_url('images/avatar.png') );
      return "http://www.gravatar.com/avatar/$email?s=$size&d=$default";
    }
  }
  if( !function_exists('logo_header') ) {
    function logo_header() {

       $html = '<a id="logo" href="' . osc_base_url() . '"><img border="0" alt="' . osc_page_title() . '" src="' . osc_base_url() . str_replace(ABS_PATH, '', osc_uploads_path()) . "realestate-logo.jpg" . '" /></a>';
       if( file_exists( osc_uploads_path() . "realestate-logo.jpg" ) ) {
        return $html;
       } else {
        return '<a id="logo" class="logo-text" href="' . osc_base_url() . '">' . osc_page_title() . '</a>';

      }
    }
  }
  if( !function_exists('logo_footer') ) {
    function logo_footer() {

       $html = '<a id="logo-footer" href="' . osc_base_url() . '"><img border="0" alt="' . osc_page_title() . '" src="' . osc_base_url() . str_replace(ABS_PATH, '', osc_uploads_path()) . "realestate-logo-footer.jpg" . '" /></a>';
       if( file_exists( osc_uploads_path() . "realestate-logo-footer.jpg" ) ) {
        return $html;
       } else {
        return '<a id="logo-footer" class="logo-footer-text" href="' . osc_base_url() . '">' . osc_page_title() . '</a>';

      }
    }
  }

  if( !function_exists('realestate_theme_admin_menu') ) {
    osc_admin_menu_appearance(__('Header logo', 'realestate'), osc_admin_render_theme_url('oc-content/themes/realestate/admin/logo_settings.php'), 'header_realestate');
    osc_admin_menu_appearance(__('Theme settings', 'realestate'), osc_admin_render_theme_url('oc-content/themes/realestate/admin/admin_settings.php'), 'settings_realestate');
  }

  $sQuery = osc_get_preference('keyword_placeholder','realestate') ;
  osc_add_hook('footer','fjs_search');
  if(!function_exists('fjs_search')){
    function fjs_search(){
      echo "\n";
  ?>
  <script type="text/javascript">
  var sQuery = '<?php echo osc_esc_js( osc_get_preference('keyword_placeholder','realestate') ) ; ?>' ;
  $(document).ready(function(){
        var element = $('input[name="sPattern"]');
        element.focus(function(){
            $(this).prev().hide();
        }).blur(function(){
          if($(this).val() == '') {
            $(this).prev().show();
          }
        }).prev().click(function(){
            $(this).hide();
            $(this).next().focus();
        });
        if(element.val() != ''){
          element.prev().hide();
        }
        <?php if(osc_locale_thousands_sep()!='' || osc_locale_dec_point() != '') { ?>
          $("#price").blur(function(event) {
            var price = $("#price").attr("value");
            <?php if(osc_locale_thousands_sep()!='') { ?>
            while(price.indexOf('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>')!=-1) {
              price = price.replace('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>', '');
            }
            <?php }; ?>
            <?php if(osc_locale_dec_point()!='') { ?>
            var tmp = price.split('<?php echo osc_esc_js(osc_locale_dec_point())?>');
            if(tmp.length>2) {
              price = tmp[0]+'<?php echo osc_esc_js(osc_locale_dec_point())?>'+tmp[1];
            }
            <?php }; ?>
            $("#price").attr("value", price);
          });
        <?php }; ?>
      });
  function doSearch() {
    var sPattern = $('input[name=sPattern]');
    var text = '<?php echo osc_esc_js( __('Your search must be at least three characters long','realestate') ) ; ?>';
    if((sPattern.hasClass('js-input-home') && sPattern.val() == '' && sPattern.val().length < 3) || (sPattern.val() != '' && sPattern.val().length < 3)) {
      $('#message-seach').text(text).show();
      return false;
    }
    return true;
  }
  </script>
  <?php
    }
  }

  // hacks to work with < 2.4 versions
  if( !defined('OC_ADMIN') ) {
    define('OC_ADMIN', false) ;
  }

  if( !function_exists('meta_title') ) {
    function meta_title( ) {
      $location = Rewrite::newInstance()->get_location();
      $section  = Rewrite::newInstance()->get_section();

      switch ($location) {
        case ('item'):
          switch ($section) {
            case 'item_add':  $text = __('Publish an item', 'realestate') . ' - ' . osc_page_title(); break;
            case 'item_edit':   $text = __('Edit your item', 'realestate') . ' - ' . osc_page_title(); break;
            case 'send_friend': $text = __('Send to a friend', 'realestate') . ' - ' . osc_item_title() . ' - ' . osc_page_title(); break;
            case 'contact':   $text = __('Contact seller', 'realestate') . ' - ' . osc_item_title() . ' - ' . osc_page_title(); break;
            default:      $text = osc_item_title() . ' - ' . osc_page_title(); break;
          }
        break;
        case('page'):
          $text = osc_static_page_title() . ' - ' . osc_page_title();
        break;
        case('error'):
          $text = __('Error', 'realestate') . ' - ' . osc_page_title();
        break;
        case('search'):
          $region   = Params::getParam('sRegion');
          $city   = Params::getParam('sCity');
          $pattern  = Params::getParam('sPattern');
          $category = osc_search_category_id();
          $category = ((count($category) == 1) ? $category[0] : '');
          $s_page   = '';
          $i_page   = Params::getParam('iPage');

          if($i_page != '' && $i_page > 0) {
            $s_page = __('page', 'realestate') . ' ' . ($i_page + 1) . ' - ';
          }

          $b_show_all = ($region == '' && $city == '' & $pattern == '' && $category == '');
          $b_category = ($category != '');
          $b_pattern  = ($pattern != '');
          $b_city   = ($city != '');
          $b_region   = ($region != '');

          if($b_show_all) {
            $text = __('Show all items', 'realestate') . ' - ' . $s_page . osc_page_title();
          }

          $result = '';
          if($b_pattern) {
            $result .= $pattern . ' &raquo; ';
          }

          if($b_category) {
            $list    = array();
            $aCategories = Category::newInstance()->toRootTree($category);
            if(count($aCategories) > 0) {
              foreach ($aCategories as $single) {
                $list[] = $single['s_name'];
              }
              $result .= implode(' &raquo; ', $list) . ' &raquo; ';
            }
          }

          if($b_city) {
            $result .= $city . ' &raquo; ';
          }

          if($b_region) {
            $result .= $region . ' &raquo; ';
          }

          $result = preg_replace('|\s?&raquo;\s$|', '', $result);

          if($result == '') {
            $result = __('Search', 'realestate');
          }

          $text = $result . ' - ' . $s_page . osc_page_title();
        break;
        case('login'):
          switch ($section) {
            case('recover'): $text = __('Recover your password', 'realestate') . ' - ' . osc_page_title();
            default:     $text = __('Login', 'realestate') . ' - ' . osc_page_title();
          }
        break;
        case('register'):
          $text = __('Create a new account', 'realestate') . ' - ' . osc_page_title();
        break;
        case('user'):
          switch ($section) {
            case('dashboard'):     $text = __('Dashboard', 'realestate') . ' - ' . osc_page_title(); break;
            case('items'):       $text = __('Manage my items', 'realestate') . ' - ' . osc_page_title(); break;
            case('alerts'):      $text = __('Manage my alerts', 'realestate') . ' - ' . osc_page_title(); break;
            case('profile'):     $text = __('Update my profile', 'realestate') . ' - ' . osc_page_title(); break;
            case('change_email'):  $text = __('Change my email', 'realestate') . ' - ' . osc_page_title(); break;
            case('change_password'): $text = __('Change my password', 'realestate') . ' - ' . osc_page_title(); break;
            case('forgot'):      $text = __('Recover my password', 'realestate') . ' - ' . osc_page_title(); break;
            default:         $text = osc_page_title(); break;
          }
        break;
        case('contact'):
          $text = __('Contact', 'realestate') . ' - ' . osc_page_title();
        break;
        default:
          $text = osc_page_title();
        break;
      }

      $text = str_replace("\n", '', $text) ;
      $text = trim($text) ;
      $text = osc_esc_html($text) ;
      return (osc_apply_filter('meta_title_filter', $text)) ;
    }
  }

  if( !function_exists('meta_description') ) {
    function meta_description( ) {
      $location = Rewrite::newInstance()->get_location();
      $section  = Rewrite::newInstance()->get_section();
      $text   = '';

      switch ($location) {
        case ('item'):
          switch ($section) {
            case 'item_add':  $text = ''; break;
            case 'item_edit':   $text = ''; break;
            case 'send_friend': $text = ''; break;
            case 'contact':   $text = ''; break;
            default:
              $text = osc_item_category() . ', ' . osc_highlight(strip_tags(osc_item_description()), 140) . '..., ' . osc_item_category();
              break;
          }
        break;
        case('page'):
          $text = osc_highlight(strip_tags(osc_static_page_text()), 140, '', '') ;
        break;
        case('search'):
          $result = '';

          if(osc_count_items() == 0) {
            $text = '';
          }

          if(osc_has_items ()) {
            $result = osc_item_category() . ', ' . osc_highlight(strip_tags(osc_item_description()), 140) . '..., ' . osc_item_category();
          }

          osc_reset_items();
          $text = $result;
          break;
        case(''): // home
          $result = '';
          if(osc_count_latest_items() == 0) {
            $text = '';
          }

          if(osc_has_latest_items()) {
            $result = osc_item_category() . ', ' . osc_highlight(strip_tags(osc_item_description()), 140) . '..., ' . osc_item_category();
          }

          osc_reset_latest_items();
          $text = $result;
        break;
      }

      $text = str_replace("\n", '', $text) ;
      $text = trim($text) ;
      $text = osc_esc_html($text) ;
      return (osc_apply_filter('meta_description_filter', $text)) ;
    }
  }

  /* ads  SEARCH */
  if (!function_exists('search_ads_listing_top_fn')) {
    function search_ads_listing_top_fn() {
      if(osc_get_preference('search-results-top-728x90', 'realestate')!='') {
        echo '<div class="clear"></div>' . PHP_EOL;
        echo '<div class="ads_728">' . PHP_EOL;
        echo osc_get_preference('search-results-top-728x90', 'realestate');
        echo '</div>' . PHP_EOL;
      }
    }
  }
  osc_add_hook('search_ads_listing_top', 'search_ads_listing_top_fn');

  if (!function_exists('search_ads_listing_medium_fn')) {
    function search_ads_listing_medium_fn() {
      if(osc_get_preference('search-results-middle-728x90', 'realestate')!='') {
        echo '<div class="clear"></div>' . PHP_EOL;
        echo '<div class="ads_728">' . PHP_EOL;
        echo osc_get_preference('search-results-middle-728x90', 'realestate');
        echo '</div>' . PHP_EOL;
      }
    }
  }
  osc_add_hook('search_ads_listing_medium', 'search_ads_listing_medium_fn');

  if(!function_exists('realestate_default_location_show_as')) {
    function realestate_default_location_show_as() {
      return osc_get_preference('defaultLocationShowAs', 'realestate');
    }
  }

  osc_register_script('jquery-validate-realestate', osc_current_web_theme_js_url('jquery.validate.min.js'), 'jquery');
  function realestate_scripts() {
    osc_enqueue_script('jquery-validate-realestate');
  }
  osc_add_hook('init', 'realestate_scripts');
?>
