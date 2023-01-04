<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

/**

DEFINES

*/
if (osc_is_user_dashboard()){
    echo "This is user dashboard";
}
    define('LHOSHAR_THEME_VERSION', '100');
    if( (string)osc_get_preference('keyword_placeholder', 'lhoshar')=="" ) {
        Params::setParam('keyword_placeholder', __('ie. PHP Programmer', 'lhoshar') ) ;
    }
    osc_register_script('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.pack.js'), array('jquery'));
    osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
    osc_enqueue_script('fancybox');

    osc_enqueue_style('font-awesome', osc_current_web_theme_url('css/font-awesome-4.1.0/css/font-awesome.min.css'));
    // used for date/dateinterval custom fields
    osc_enqueue_script('php-date');
    if(!OC_ADMIN) {
        osc_enqueue_style('fine-uploader-css', osc_assets_url('js/fineuploader/fineuploader.css'));
        if(getPreference('rtl','lhoshar')=='0') {
            osc_enqueue_style('lhoshar-fine-uploader-css', osc_current_web_theme_url('css/ajax-uploader.css'));
        } else {
            osc_enqueue_style('lhoshar-fine-uploader-css', osc_current_web_theme_url('css/ajax-uploader-rtl.css'));
        }
    }
    osc_enqueue_script('jquery-fineuploader');


    /**
** DEFAULT VALUES
**/
    if( !osc_get_preference('sub_cat_limit', 'lhoshar') ) {
        osc_set_preference('sub_cat_limit', 5, 'lhoshar');
    }
    if( !osc_get_preference('popular_regions_limit', 'lhoshar') ) {
        osc_set_preference('popular_regions_limit', 10, 'lhoshar');
    }   
    if( !osc_get_preference('popular_cities_limit', 'lhoshar') ) {
        osc_set_preference('popular_cities_limit', 10, 'lhoshar');
    }   
    if( !osc_get_preference('popular_searches_limit', 'lhoshar') ) {
        osc_set_preference('popular_searches_limit', 10, 'lhoshar');
    }
    
    if( !osc_get_preference('locations_input_as', 'lhoshar') ) {
        osc_set_preference('locations_input_as', 'text', 'lhoshar');
    }   
    if( !osc_get_preference('premium_listings_shown_home', 'lhoshar') ) {
        osc_set_preference('premium_listings_shown_home', 6, 'lhoshar');
    }
    if( !osc_get_preference('premium_listings_shown', 'lhoshar') ) {
        osc_set_preference('premium_listings_shown', 6, 'lhoshar');
    }
    if( !osc_get_preference('title_minimum_length', 'lhoshar') ) {
        osc_set_preference('title_minimum_length', 1, 'lhoshar');
    }   
    if( !osc_get_preference('description_minimum_length', 'lhoshar') ) {
        osc_set_preference('description_minimum_length', 3, 'lhoshar');
    }
    if( !osc_get_preference('theme_color_mode', 'lhoshar') ) {
        osc_set_preference('theme_color_mode', 'blue', 'lhoshar');
    }
    if( !osc_get_preference('theme_color', 'lhoshar') ) {
        osc_set_preference('theme_color', '#1396e2', 'lhoshar');
    }
    if( !osc_get_preference('slider_option', 'lhoshar') ) {
        osc_set_preference('slider_option', 'slide', 'lhoshar');
    }
    osc_reset_preferences();

/**

FUNCTIONS

*/
    // install options
    if( !function_exists('lhoshar_theme_install') ) {
        function lhoshar_theme_install() {
            osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'lhoshar');
            osc_set_preference('version', LHOSHAR_THEME_VERSION, 'lhoshar');
            osc_set_preference('footer_link', '1', 'lhoshar');
            osc_set_preference('donation', '0', 'lhoshar');
            osc_set_preference('defaultShowAs@all', 'gallery', 'lhoshar');
            osc_set_preference('defaultShowAs@search', 'gallery');
            osc_set_preference('defaultShowAs@home', 'banner', 'lhoshar');
            osc_set_preference('defaultLocationShowAs', 'dropdown', 'lhoshar'); // dropdown / autocomplete
            osc_set_preference('show_popular', '1', 'lhoshar');
            osc_set_preference('show_popular_regions', '1', 'lhoshar');
            osc_set_preference('show_popular_cities', '1', 'lhoshar');
            osc_set_preference('show_search_country', '1', 'lhoshar');
            osc_set_preference('show_popular_searches', '1', 'lhoshar');
            osc_set_preference('sub_cat_limit', 5, 'lhoshar');
            osc_set_preference('to_the_top', '1', 'lhoshar');
            $social = [ 'facebook' => '#', 'twitter' => '#', 'instagram' => '#', 'linkedin' => '#', 'google' => '#', 'youtube' => '#' ];
            osc_set_preference('social', serialize($social), 'lhoshar');
            osc_reset_preferences();
        }
    }
    // update options
    if( !function_exists('lhoshar_theme_update') ) {
        function lhoshar_theme_update($current_version) {
            if($current_version==0) {
                lhoshar_theme_install();
            }
            osc_delete_preference('default_logo', 'lhoshar');

            $logo_prefence = osc_get_preference('logo', 'lhoshar');
            $logo_name     = 'lhoshar_logo';
            $temp_name     = WebThemes::newInstance()->getCurrentThemePath() . 'images/logo.jpg';
            if( file_exists( $temp_name ) && !$logo_prefence) {

                $img = ImageResizer::fromFile($temp_name);
                $ext = $img->getExt();
                $logo_name .= '.'.$ext;
                $img->saveToFile(osc_uploads_path().$logo_name);
                osc_set_preference('logo', $logo_name, 'lhoshar');
            }
            osc_set_preference('version', '100', 'lhoshar');

            if($current_version<100 || $current_version=='1.0.0') {
                // add preferences
                osc_set_preference('defaultLocationShowAs', 'dropdown', 'lhoshar');
                osc_set_preference('version', '100', 'lhoshar');
            }
            osc_set_preference('version', '100', 'lhoshar');
            osc_reset_preferences();
        }
    }
    if(!function_exists('check_install_lhoshar_theme')) {
        function check_install_lhoshar_theme() {
            $current_version = osc_get_preference('version', 'lhoshar');
            //check if current version is installed or need an update<
            if( $current_version=='' ) {
                lhoshar_theme_update(0);
            } else if($current_version < LHOSHAR_THEME_VERSION){
                lhoshar_theme_update($current_version);
            }
        }
    }

    if(!function_exists('lhoshar_add_body_class_construct')) {
        function lhoshar_add_body_class_construct($classes){
            $lhosharBodyClass = lhosharBodyClass::newInstance();
            $classes = array_merge($classes, $lhosharBodyClass->get());
            return $classes;
        }
    }
    if(!function_exists('lhoshar_body_class')) {
        function lhoshar_body_class($echo = true){
            /**
            * Print body classes.
            *
            * @param string $echo Optional parameter.
            * @return print string with all body classes concatenated
            */
            osc_add_filter('lhoshar_bodyClass','lhoshar_add_body_class_construct');
            $classes = osc_apply_filter('lhoshar_bodyClass', array());
            if($echo && count($classes)){
                echo 'class="'.implode(' ',$classes).'"';
            } else {
                return $classes;
            }
        }
    }
    if(!function_exists('lhoshar_add_body_class')) {
        function lhoshar_add_body_class($class){
            /**
            * Add new body class to body class array.
            *
            * @param string $class required parameter.
            */
            $lhosharBodyClass = lhosharBodyClass::newInstance();
            $lhosharBodyClass->add($class);
        }
    }
    if(!function_exists('lhoshar_nofollow_construct')) {
        /**
        * Hook for header, meta tags robots nofollos
        */
        function lhoshar_nofollow_construct() {
            echo '<meta name="robots" content="noindex, nofollow, noarchive" />' . PHP_EOL;
            echo '<meta name="googlebot" content="noindex, nofollow, noarchive" />' . PHP_EOL;

        }
    }
    if( !function_exists('lhoshar_follow_construct') ) {
        /**
        * Hook for header, meta tags robots follow
        */
        function lhoshar_follow_construct() {
            echo '<meta name="robots" content="index, follow" />' . PHP_EOL;
            echo '<meta name="googlebot" content="index, follow" />' . PHP_EOL;

        }
    }
    /* logo */
    if( !function_exists('logo_header') ) {
        function logo_header() {
             $logo = osc_get_preference('logo','lhoshar');
             $html = '<a href="'.osc_base_url().'"><img border="0" alt="' . osc_page_title() . '" src="' . lhoshar_logo_url() . '"></a>';
             if( $logo!='' && file_exists( osc_uploads_path() . $logo ) ) {
                return $html;
             } else {
                return '<a href="'.osc_base_url().'"><img border="0" height="36" width="114" alt="' . osc_page_title() . '" src = "' . osc_base_url().'oc-content/themes/lhoshar/images/logo.jpg' . '" ></a>';
            }
        }
    }
    if( !function_exists('homepage_image') ) {
        function homepage_image() {
            $logo = osc_get_preference('homeimage','lhoshar');
            $html = '<img border="0" alt="' . osc_esc_html(osc_page_title()) . '" src="' . lhoshar_homeimage_url() . '">';
            if ( !EMPTY ( $logo ) ) {
                return $html ;
            } else {        
                echo '<img src="'.osc_current_web_theme_url('images/banner.jpg').'" />' ;
            }
        }
    }
   
    if( !function_exists('lhoshar_favicon_url') ) {
        function lhoshar_favicon_url() {
            $logo = osc_get_preference('favicon','lhoshar');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            else
            {
                return osc_current_web_theme_url('images/favicon.png'); 
            }
        }
    }
    /* logo */
    if( !function_exists('lhoshar_logo_url') ) {
        function lhoshar_logo_url() {
            $logo = osc_get_preference('logo','lhoshar');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
    if( !function_exists('lhoshar_homeimage_url') ) {
        function lhoshar_homeimage_url() {
            $logo = osc_get_preference('homeimage','lhoshar');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
    if( !function_exists('lhoshar_draw_item') ) {
        function lhoshar_draw_item($class = false,$admin = false, $premium = false) {
            $filename = 'loop-single';
            if($premium){
                $filename .='-premium';
            }
            require WebThemes::newInstance()->getCurrentThemePath().$filename.'.php';
        }
    }
    if( !function_exists('lhoshar_show_as') ){
        function lhoshar_show_as(){

            $p_sShowAs    = Params::getParam('sShowAs');
            $aValidShowAsValues = array('list', 'gallery');
            if (!in_array($p_sShowAs, $aValidShowAsValues)) {
                $p_sShowAs = lhoshar_default_show_as();
            }

            return $p_sShowAs;
        }
    }
    if( !function_exists('lhoshar_default_direction') ){
        function lhoshar_default_direction(){
            return getPreference('rtl','lhoshar');
        }
    }
    if( !function_exists('lhoshar_default_show_as') ){
        function lhoshar_default_show_as(){
            return getPreference('defaultShowAs@all','lhoshar');
        }
    }
    if( !function_exists('lhoshar_default_show_as_home') ){
        function lhoshar_default_show_as_home(){
            return getPreference('defaultShowAs@home','lhoshar');
        }
    }
    if( !function_exists('lhoshar_default_location_show_as') ){
        function lhoshar_default_location_show_as(){
            return osc_get_preference('defaultLocationShowAs','lhoshar');
        }
    }
    if( !function_exists('lhoshar_draw_categories_list') ) {
        function lhoshar_draw_categories_list(){ ?>
        <?php if(!osc_is_home_page()){ echo '<div class="resp-wrapper">'; } ?>
 
<h1 class="title" id="categories-heading-one"><?php _e('Categories', 'lhoshar');?></h1>
<div class="row" id="categories-row">
<?php

    $total_categories   = osc_count_categories();
    $col1_max_cat       = ceil($total_categories/1);
    osc_goto_first_category();
    $catcount   =   0;
    $icons = unserialize(osc_get_preference('icons', 'lhoshar'));
    while ( osc_has_categories() ) {
        $_catid      = osc_category_id();
?>
<ul class="col-sm-6 col-md-3 grid_list">
  <li>
    <section class="listings">
     <h2><i class="fa <?php echo osc_esc_html($icons[$_catid])?:'fa-archive'?>"></i>
      <?php
            $_slug      = osc_category_slug();
            $_url       = osc_search_category_url();
            $_name      = osc_category_name();
            $_total_items = osc_category_total_items();
            if ( osc_count_subcategories() > 0 ) { ?>
      <?php } ?>
      <?php if($_total_items > 0) { ?>
      <a class="category <?php echo $_slug; ?>" href="<?php echo $_url; ?>"><?php echo $_name ;?></a> <span><?php echo $_total_items ; ?></span>
      <?php } else { ?>
      <a class="category <?php echo $_slug; ?>" href="<?php echo $_url; ?>"><?php echo $_name ; ?></a> <span><?php echo $_total_items ; ?></span>
      <?php } ?>
    </h2>
    <?php if ( osc_count_subcategories() > 0 ) { $m=1; ?>
    <ul>
      <?php while ( osc_has_subcategories() ) { if( $m<=(osc_get_preference('sub_cat_limit', 'lhoshar'))){?>
      <li>
        <?php if( osc_category_total_items() > 0 ) { ?>
        <a class="category sub-category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?></a> <span>(<?php echo osc_category_total_items() ; ?>)</span>
        <?php } else { ?>
        <a class="category sub-category <?php echo osc_category_slug() ; ?>" href="#"><?php echo osc_category_name() ; ?></a> <span>(<?php echo osc_category_total_items() ; ?>)</span>
        <?php } ?>
      </li>
      <?php } $m++; } if($m>(osc_get_preference('sub_cat_limit', 'lhoshar'))+1) {?>
      <li class="last"><a href="<?php echo $_url; ?>"><strong><?php _e('See more listings...', 'lhoshar');?></strong></a></li>
      <?php } ?>
    </ul>
    <?php } ?>
    </section>
  </li>
</ul>
<?php
        $catcount++;
        if($catcount%4==0)
        {
            echo '</div><div class="row" id="categories-row">';
        }
    }
 ?>
 </div>
 <?php //if(!osc_is_home_page()){ echo '</div>'; } ?>
<?php
        }
    }
    if( !function_exists('lhoshar_search_number') ) {
        /**
          *
          * @return array
          */
        function lhoshar_search_number() {
            $search_from = ((osc_search_page() * osc_default_results_per_page_at_search()) + 1);
            $search_to   = ((osc_search_page() + 1) * osc_default_results_per_page_at_search());
            if( $search_to > osc_search_total_items() ) {
                $search_to = osc_search_total_items();
            }

            return array(
                'from' => $search_from,
                'to'   => $search_to,
                'of'   => osc_search_total_items()
            );
        }
    }
    /*
     * Helpers used at view
     */
    if( !function_exists('lhoshar_item_title') ) {
        function lhoshar_item_title() {
            $title = osc_item_title();
            foreach( osc_get_locales() as $locale ) {
                if( Session::newInstance()->_getForm('title') != "" ) {
                    $title_ = Session::newInstance()->_getForm('title');
                    if( @$title_[$locale['pk_c_code']] != "" ){
                        $title = $title_[$locale['pk_c_code']];
                    }
                }
            }
            return $title;
        }
    }
    if( !function_exists('lhoshar_item_description') ) {
        function lhoshar_item_description() {
            $description = osc_item_description();
            foreach( osc_get_locales() as $locale ) {
                if( Session::newInstance()->_getForm('description') != "" ) {
                    $description_ = Session::newInstance()->_getForm('description');
                    if( @$description_[$locale['pk_c_code']] != "" ){
                        $description = $description_[$locale['pk_c_code']];
                    }
                }
            }
            return $description;
        }
    }
    if( !function_exists('related_listings') ) {
        function related_listings() {
            View::newInstance()->_exportVariableToView('items', array());

            $mSearch = new Search();
            $mSearch->addCategory(osc_item_category_id());
            $mSearch->addRegion(osc_item_region());
            $mSearch->addItemConditions(sprintf("%st_item.pk_i_id < %s ", DB_TABLE_PREFIX, osc_item_id()));
            $mSearch->limit('0', '3');

            $aItems      = $mSearch->doSearch();
            $iTotalItems = count($aItems);
            if( $iTotalItems == 3 ) {
                View::newInstance()->_exportVariableToView('items', $aItems);
                return $iTotalItems;
            }
            unset($mSearch);

            $mSearch = new Search();
            $mSearch->addCategory(osc_item_category_id());
            $mSearch->addItemConditions(sprintf("%st_item.pk_i_id != %s ", DB_TABLE_PREFIX, osc_item_id()));
            $mSearch->limit('0', '3');

            $aItems = $mSearch->doSearch();
            $iTotalItems = count($aItems);
            if( $iTotalItems > 0 ) {
                View::newInstance()->_exportVariableToView('items', $aItems);
                return $iTotalItems;
            }
            unset($mSearch);

            return 0;
        }
    }

    if( !function_exists('osc_is_contact_page') ) {
        function osc_is_contact_page() {
            if( Rewrite::newInstance()->get_location() === 'contact' ) {
                return true;
            }

            return false;
        }
    }

    if( !function_exists('get_breadcrumb_lang') ) {
        function get_breadcrumb_lang() {
            $lang = array();
            $lang['item_add']               = __('Publish a listing', 'lhoshar');
            $lang['item_edit']              = __('Edit your listing', 'lhoshar');
            $lang['item_send_friend']       = __('Send to a friend', 'lhoshar');
            $lang['item_contact']           = __('Contact publisher', 'lhoshar');
            $lang['search']                 = __('Search results', 'lhoshar');
            $lang['search_pattern']         = __('Search results: %s', 'lhoshar');
            $lang['user_dashboard']         = __('Dashboard', 'lhoshar');
            $lang['user_dashboard_profile'] = __("%s's profile", 'lhoshar');
            $lang['user_account']           = __('Account', 'lhoshar');
            $lang['user_items']             = __('Listings', 'lhoshar');
            $lang['user_alerts']            = __('Alerts', 'lhoshar');
            $lang['user_profile']           = __('Update account', 'lhoshar');
            $lang['user_change_email']      = __('Change email', 'lhoshar');
            $lang['user_change_username']   = __('Change username', 'lhoshar');
            $lang['user_change_password']   = __('Change password', 'lhoshar');
            $lang['login']                  = __('Login', 'lhoshar');
            $lang['login_recover']          = __('Recover password', 'lhoshar');
            $lang['login_forgot']           = __('Change password', 'lhoshar');
            $lang['register']               = __('Create a new account', 'lhoshar');
            $lang['contact']                = __('Contact', 'lhoshar');
            return $lang;
        }
    }

    if(!function_exists('user_dashboard_redirect')) {
        function user_dashboard_redirect() {
            $page   = Params::getParam('page');
            $action = Params::getParam('action');
            if($page=='user' && $action=='dashboard') {
                if(ob_get_length()>0) {
                    ob_end_flush();
                }
                header("Location: ".osc_user_list_items_url(), TRUE,301);
            }
        }
        osc_add_hook('init', 'user_dashboard_redirect');
    }

    if( !function_exists('get_user_menu') ) {
        function get_user_menu() {
            $options   = array();
            $options[] = array(
                'name' => __('Public Profile'),
                 'url' => osc_user_public_profile_url(),
               'class' => 'opt_publicprofile'
            );
            $options[] = array(
                'name'  => __('Listings', 'lhoshar'),
                'url'   => osc_user_list_items_url(),
                'class' => 'opt_items'
            );
            $options[] = array(
                'name' => __('Alerts', 'lhoshar'),
                'url' => osc_user_alerts_url(),
                'class' => 'opt_alerts'
            );
            $options[] = array(
                'name'  => __('Account', 'lhoshar'),
                'url'   => osc_user_profile_url(),
                'class' => 'opt_account'
            );
            $options[] = array(
                'name'  => __('Change email', 'lhoshar'),
                'url'   => osc_change_user_email_url(),
                'class' => 'opt_change_email'
            );
            $options[] = array(
                'name'  => __('Change username', 'lhoshar'),
                'url'   => osc_change_user_username_url(),
                'class' => 'opt_change_username'
            );
            $options[] = array(
                'name'  => __('Change password', 'lhoshar'),
                'url'   => osc_change_user_password_url(),
                'class' => 'opt_change_password'
            );
            $options[] = array(
                'name'  => __('Delete account', 'lhoshar'),
                'url'   => '#',
                'class' => 'opt_delete_account'
            );

            return $options;
        }
    }

    if( !function_exists('delete_user_js') ) {
        function delete_user_js() {
            $location = Rewrite::newInstance()->get_location();
            $section  = Rewrite::newInstance()->get_section();
            if( ($location === 'user' && in_array($section, array('dashboard', 'profile', 'alerts', 'change_email', 'change_username',  'change_password', 'items'))) || (Params::getParam('page') ==='custom' && Params::getParam('in_user_menu')==true ) ) {
                osc_enqueue_script('delete-user-js');
            }
        }
        osc_add_hook('header', 'delete_user_js', 1);
    }

    if( !function_exists('user_info_js') ) {
        function user_info_js() {
            $location = Rewrite::newInstance()->get_location();
            $section  = Rewrite::newInstance()->get_section();

            if( $location === 'user' && in_array($section, array('dashboard', 'profile', 'alerts', 'change_email', 'change_username',  'change_password', 'items')) ) {
                $user = User::newInstance()->findByPrimaryKey( Session::newInstance()->_get('userId') );
                View::newInstance()->_exportVariableToView('user', $user);
                ?>
<script type="text/javascript">
    lhoshar.user = {};
    lhoshar.user.id = '<?php echo osc_user_id(); ?>';
    lhoshar.user.secret = '<?php echo osc_user_field("s_secret"); ?>';
</script>
            <?php }
        }
        osc_add_hook('header', 'user_info_js');
    }

    function theme_lhoshar_actions_admin() {
        if( Params::getParam('file') == 'oc-content/themes/lhoshar/admin/settings.php' ) {
            if( Params::getParam('donation') == 'successful' ) {
                osc_set_preference('donation', '1', 'lhoshar');
                osc_reset_preferences();
            }
        }

        if(Params::getParam('remove-mdl-ctl-slider-image') != null){

            $sid = Params::getParam('remove-mdl-ctl-slider-image');
            $slider = unserialize(osc_get_preference('slider', 'lhoshar'));

            $file = osc_uploads_path().$slider['image'][$sid];

            if(file_exists($file)){
                @unlink( $file );
            }

            $slider['image'][$sid] = '';
                osc_set_preference('slider', serialize($slider), 'lhoshar');
                osc_add_flash_ok_message(__('The slider settings has been saved', 'lhoshar'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/slider.php'));
        }
        
        switch( Params::getParam('action_specific') ) {
            case('settings'):
                osc_set_preference('footer_message',  trim(Params::getParam('footer_message', false, false, false)), 'lhoshar');
                osc_set_preference('defaultShowAs@all', Params::getParam('defaultShowAs@all'), 'lhoshar');
                osc_set_preference('defaultShowAs@search', Params::getParam('defaultShowAs@all'));
                $to_the_top   =   Params::getParam('to_the_top', 'lhoshar');
                osc_set_preference('to_the_top', ($to_the_top ? '1' : '0'), 'lhoshar');
                osc_add_flash_ok_message(__('Theme settings updated correctly', 'lhoshar'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php'));
            break;
            case('templates_home'):
                osc_set_preference('defaultShowAs@home', Params::getParam('defaultShowAs@home'), 'lhoshar');
                osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'lhoshar');

                $slider_option  = Params::getParam('slider_option');
                osc_set_preference('slider_option', $slider_option, 'lhoshar');
                
                osc_set_preference('show_search_country', ((Params::getParam('show_search_country'))? '1' : '0'), 'lhoshar');
                osc_set_preference('premium_listings_shown_home', Params::getParam('premium_listings_shown_home'), 'lhoshar');
                osc_set_preference('sub_cat_limit', Params::getParam('sub_cat_limit'), 'lhoshar');
                osc_set_preference('show_popular', Params::getParam('show_popular'), 'lhoshar');
                osc_set_preference('show_popular_regions', Params::getParam('show_popular_regions'), 'lhoshar');
                osc_set_preference('show_popular_cities', Params::getParam('show_popular_cities'), 'lhoshar');
                osc_set_preference('show_popular_searches', Params::getParam('show_popular_searches'), 'lhoshar');
                osc_set_preference('popular_regions_limit', Params::getParam('popular_regions_limit'), 'lhoshar');
                osc_set_preference('popular_cities_limit', Params::getParam('popular_cities_limit'), 'lhoshar');
                osc_set_preference('popular_searches_limit', Params::getParam('popular_searches_limit'), 'lhoshar');

                osc_add_flash_ok_message(__('Templates settings updated correctly', 'lhoshar'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/lhoshar/admin/settings.php#templates' ));            break;
            case('templates_search'):
                osc_set_preference('premium_listings_shown', Params::getParam('premium_listings_shown'), 'lhoshar');
                
                osc_add_flash_ok_message(__('Templates settings updated correctly', 'lhoshar'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/lhoshar/admin/settings.php#templates' ));            break;
            case('templates_item_post'):
                $locations_required =   Params::getParam('locations_required', 'lhoshar');
                $category_multiple_selects  =   Params::getParam('category_multiple_selects', 'lhoshar');
                osc_set_preference('title_minimum_length', Params::getParam('title_minimum_length', 'lhoshar'), 'lhoshar');
                osc_set_preference('description_minimum_length', Params::getParam('description_minimum_length', 'lhoshar'), 'lhoshar');
                osc_set_preference('defaultLocationShowAs', Params::getParam('defaultLocationShowAs'), 'lhoshar');
                osc_set_preference('locations_required', ($locations_required ? '1' : '0'), 'lhoshar');
                osc_set_preference('category_multiple_selects', ($category_multiple_selects ? '1' : '0'), 'lhoshar');
                
                osc_add_flash_ok_message(__('Templates settings updated correctly', 'lhoshar'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/lhoshar/admin/settings.php#templates' ));
            break;

            case('ads_mgmt'):
                osc_set_preference('header-728x90', trim(Params::getParam('header-728x90', false, false, false)), 'lhoshar');
                osc_set_preference('homepage-728x90', trim(Params::getParam('homepage-728x90', false, false, false)), 'lhoshar');
                osc_set_preference('sidebar-300x250', trim(Params::getParam('sidebar-300x250', false, false, false)), 'lhoshar');
                osc_set_preference('search-results-top-728x90', trim(Params::getParam('search-results-top-728x90', false, false, false)), 'lhoshar');
                osc_set_preference('search-results-middle-728x90', trim(Params::getParam('search-results-middle-728x90', false, false, false)), 'lhoshar');

                osc_add_flash_ok_message(__('Ads management updated correctly', 'lhoshar'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/lhoshar/admin/settings.php#ads' ));
            break;
            case('icons'):
                $icons = Params::getParam('icons');
                osc_set_preference('icons', serialize($icons), 'lhoshar');

                osc_add_flash_ok_message(__('Category icons settings updated correctly', 'lhoshar'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/lhoshar/admin/settings.php#category' ));
            break;
            case('theme_style'):    
                $color_mode  = Params::getParam('theme_color_mode');
                osc_set_preference('theme_color_mode', $color_mode, 'lhoshar');
                
                $rtl_view   =   Params::getParam('rtl_view', 'lhoshar');
                osc_set_preference('rtl_view', ($rtl_view ? '1' : '0'), 'lhoshar');
                osc_set_preference('custom_css', trim(Params::getParam('custom_css', false, false, false)), 'lhoshar');
                
                osc_add_flash_ok_message(__('Theme style settings updated correctly', 'lhoshar'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/lhoshar/admin/settings.php#theme-style' ));
                
            break;
            case ('social'):
                $social = [
                    'facebook' => trim(Params::getParam('facebook'))?:'',
                    'twitter' => trim(Params::getParam('twitter'))?:'',
                    'instagram' => trim(Params::getParam('instagram'))?:'',
                    'linkedin' => trim(Params::getParam('linkedin'))?:'',
                    'google' => trim(Params::getParam('google'))?:'',
                    'youtube' => trim(Params::getParam('youtube'))?:''
                    ];

                osc_set_preference('social', serialize($social), 'lhoshar');
                osc_add_flash_ok_message(__('Social links updated correctly', 'lhoshar'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php#social'));
            break;
            case('upload_favicon'):
                $package = Params::getFiles('favicon');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'favicon';
                    $logo_name    .= '.'.$ext;
                    $path = osc_uploads_path() . $logo_name ;
                    $img->saveToFile($path);

                    osc_set_preference('favicon', $logo_name, 'lhoshar');

                    osc_add_flash_ok_message(__('The favicon image has been uploaded correctly', 'lhoshar'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'lhoshar'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php#favicon'));
            break;
            case('upload_logo'):
                $package = Params::getFiles('logo');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'logo';
                    $logo_name    .= '.'.$ext;
                    $path = osc_uploads_path() . $logo_name ;
                    $img->saveToFile($path);

                    osc_set_preference('logo', $logo_name, 'lhoshar');

                    osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'lhoshar'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'lhoshar'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php#logo'));
            break;

            case('slider'):

                $data = [
                    'title' => Params::getParam('title'),
                    'button_text' => Params::getParam('btn_text'),
                    'button_url' => Params::getParam('btn_url'),
                    'paragraph' => Params::getParam('paragraph'),
                    'image' => Params::getParam('image')
                ];

                $images = Params::getFiles('t_image');

                
                for($i=0;$i<=4;$i++){
                    if($images['name'][$i] && $images['error'][$i] == UPLOAD_ERR_OK ) {

                        $image = ImageResizer::fromFile($images['tmp_name'][$i]);

                        $ext = $image->getExt();
                        $name = uniqid();
                        $name .= '.'.$ext;
                        $path = osc_uploads_path() . $name ; 

                        if(move_uploaded_file($images['tmp_name'][$i],$path)){
                            if($data['image'][$i]){
                                $oi = osc_uploads_path().$data['image'][$i];
                                if(file_exists(osc_uploads_path().$data['image'][$i])){
                                    @unlink( $oi );    
                                }
                            }
                            $data['image'][$i] = $name;    
                        }
                    }
                }  
                osc_set_preference('slider', serialize($data), 'lhoshar');
                osc_add_flash_ok_message(__('The slider settings has been saved', 'lhoshar'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php#slider'));
            break;
        
            case('remove_favicon'):
                $logo = osc_get_preference('favicon','lhoshar');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('favicon','lhoshar');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The favicon image has been removed', 'lhoshar'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'lhoshar'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php#favicon'));
            break;

            case('remove'):
                $logo = osc_get_preference('logo','lhoshar');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('logo','lhoshar');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The logo image has been removed', 'lhoshar'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'lhoshar'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php#logo'));
            break;
            
            case('upload_homeimage'):
                $package = Params::getFiles('homeimage');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'homeimage';
                    $logo_name    .= '.'.$ext;
                    $path = osc_uploads_path() . $logo_name ;
                    $img->saveToFile($path);

                    osc_set_preference('homeimage', $logo_name, 'lhoshar');

                    osc_add_flash_ok_message(__('The banner image has been uploaded correctly', 'lhoshar'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'lhoshar'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php#banner'));
            break;  
            case('remove_homeimage'):
                $logo = osc_get_preference('homeimage','lhoshar');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('homeimage','lhoshar');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The banner image has been removed', 'lhoshar'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'lhoshar'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php#banner'));
            break;        
        }
    }

    function lhoshar_redirect_user_dashboard()
    {
        if( (Rewrite::newInstance()->get_location() === 'user') && (Rewrite::newInstance()->get_section() === 'dashboard') ) {
            header('Location: ' .osc_user_list_items_url());
            exit;
        }
    }

    function lhoshar_delete() {
        Preference::newInstance()->delete(array('s_section' => 'lhoshar'));
    }

    osc_add_hook('init', 'lhoshar_redirect_user_dashboard', 2);
    osc_add_hook('init_admin', 'theme_lhoshar_actions_admin');
    osc_add_hook('theme_delete_lhoshar', 'lhoshar_delete');
    osc_admin_menu_appearance(__('Lhoshar', 'lhoshar'), osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php'), 'settings_lhoshar');
/**

TRIGGER FUNCTIONS

*/
check_install_lhoshar_theme();
if(osc_is_home_page()){
    osc_add_hook('inside-main','lhoshar_draw_categories_list');
}

if(osc_is_home_page() || osc_is_search_page()){
    lhoshar_add_body_class('has-searchbox');
}

function lhoshar_sidebar_category_search($catId = null)
{
    $aCategories = array();
    if($catId==null) {
        $aCategories[] = Category::newInstance()->findRootCategoriesEnabled();
    } else {
        // if parent category, only show parent categories
        $aCategories = Category::newInstance()->toRootTree($catId);
        end($aCategories);
        $cat = current($aCategories);
        // if is parent of some category
        $childCategories = Category::newInstance()->findSubcategoriesEnabled($cat['pk_i_id']);
        if(count($childCategories) > 0) {
            $aCategories[] = $childCategories;
        }
    }

    if(count($aCategories) == 0) {
        return "";
    }

    lhoshar_print_sidebar_category_search($aCategories, $catId);
}

function lhoshar_print_sidebar_category_search($aCategories, $current_category = null, $i = 0)
{
    $class = '';
    if(!isset($aCategories[$i])) {
        return null;
    }

    if($i===0) {
        $class = 'class="category"';
    }

    $c   = $aCategories[$i];
    $i++;
    if(!isset($c['pk_i_id'])) {
        echo '<ul '.$class.'>';
        if($i==1) {
            echo '<li><a href="'.osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))).'">'.__('All categories', 'lhoshar')."</a></li>";
        }
        foreach($c as $key => $value) {
    ?>
            <li>
                <a id="cat_<?php echo osc_esc_html($value['pk_i_id']);?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=> $value['pk_i_id'], 'iPage'=>null))); ?>">
                <?php if(isset($current_category) && $current_category == $value['pk_i_id']){ echo '<strong>'.$value['s_name'].'</strong>'; }
                else{ echo $value['s_name']; } ?>
                </a>

            </li>
    <?php
        }
        if($i==1) {
        echo "</ul>";
        } else {
        echo "</ul>";
        }
    } else {
    ?>
    <ul <?php echo $class;?>>
        <?php if($i==1) { ?>
        <li><a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))); ?>"><?php _e('All categories', 'lhoshar'); ?></a></li>
        <?php } ?>
            <li>
                <a id="cat_<?php echo osc_esc_html($c['pk_i_id']);?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=> $c['pk_i_id'], 'iPage'=>null))); ?>">
                <?php if(isset($current_category) && $current_category == $c['pk_i_id']){ echo '<strong>'.$c['s_name'].'</strong>'; }
                      else{ echo $c['s_name']; } ?>
                </a>
                <?php lhoshar_print_sidebar_category_search($aCategories, $current_category, $i); ?>
            </li>
        <?php if($i==1) { ?>
        <?php } ?>
    </ul>
<?php
    }
}

function lhoshar_item_post_form_validate(){
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#regionId, #cityId').removeAttr('disabled');
    });

    //form validate
    $('form[name=item]').validate({
        rules: {
            catId: {
                required: true,
                digits: true
            },
            'title[<?php echo osc_current_user_locale();?>]': {
                required:true,
                minlength:<?php echo lhoshar_title_minimum_length();?>
            },
            'description[<?php echo osc_current_user_locale();?>]': {
                minlength:<?php echo lhoshar_description_minimum_length();?>
            },
            price: {
                maxlength: 50
            },
            currency: "required",
            "photos[]": {
                accept: "png,gif,jpg,jpeg"
            },
            contactName: {
                required: true,
                minlength: 3,
                maxlength: 35
            },
            contactEmail: {
                required: true,
                email: true
            },
            countryId:{
                required: <?php echo lhoshar_locations_required(); ?>
            },
            region: {
                required: <?php echo lhoshar_locations_required(); ?>,
                minlength: 3,
                maxlength: 100
            },
            city: {
                required: <?php echo lhoshar_locations_required(); ?>,
                minlength: 3,
                maxlength: 100
            }
            <?php if(lhoshar_locations_input_as()=='select'){ ?>
            ,
            regionId: {
                required: <?php echo lhoshar_locations_required(); ?>
            },
            cityId: {
                required: <?php echo lhoshar_locations_required(); ?>
            }
            <?php } ?>
            
        },
        messages: {
            catId: {
            required: '<?php echo osc_esc_js(__("Choose one category", 'lhoshar')); ?>.'
            },
            'title[<?php echo osc_current_user_locale();?>]': {
                required: '<?php echo osc_esc_js(__("Title: this field is required", 'lhoshar')); ?>.',
                minlength: '<?php echo osc_esc_js(__("Title too short", 'lhoshar')); ?>.'
            },
            'description[<?php echo osc_current_user_locale();?>]': {
                minlength: '<?php echo osc_esc_js(__("Description too short", 'lhoshar')); ?>.'
            },
            price: {
                maxlength: '<?php echo osc_esc_js(__("Price: no more than 50 characters", 'lhoshar')); ?>.'
            },
            currency: '<?php echo osc_esc_js(__("Currency: make your selection", 'lhoshar')); ?>.',
            "photos[]": {
                accept: '<?php echo osc_esc_js(__("Photo: must be png,gif,jpg,jpeg", 'lhoshar')); ?>.'
            },
            contactName: {
                required: '<?php echo osc_esc_js(__("Name: this field is required", 'lhoshar')); ?>.',
                minlength: '<?php echo osc_esc_js(__("Name: enter at least 3 characters", 'lhoshar')); ?>.',
                maxlength: '<?php echo osc_esc_js(__("Name: no more than 35 characters", 'lhoshar')); ?>.'
            },
            contactEmail: {
                required: '<?php echo osc_esc_js(__("Email: this field is required", 'lhoshar')); ?>.',
                email: '<?php echo osc_esc_js(__("Invalid email address", 'lhoshar')); ?>.'
            },
            countryId: {
                required: '<?php echo osc_esc_js(__("Please select a country", 'lhoshar')); ?>.'
            },
            region: {
                required: '<?php echo osc_esc_js(__("Region: this field is required", 'lhoshar')); ?>.',
                minlength: '<?php echo osc_esc_js(__("Region: enter at least 3 characters", 'lhoshar')); ?>.',
                maxlength: '<?php echo osc_esc_js(__("Region: no more than 100 characters", 'lhoshar')); ?>.'
            },
            city: {
                required: '<?php echo osc_esc_js(__("City: this field is required", 'lhoshar')); ?>.',
                minlength: '<?php echo osc_esc_js(__("City: enter at least 3 characters", 'lhoshar')); ?>.',
                maxlength: '<?php echo osc_esc_js(__("City: no more than 100 characters", 'lhoshar')); ?>.'
            }
            <?php if(lhoshar_locations_input_as()=='select'){ ?>
            ,
            regionId: {
                required: '<?php echo osc_esc_js(__("Region: this field is required", 'lhoshar')); ?>.'
            },
            cityId: {
                required: '<?php echo osc_esc_js(__("City: this field is required", 'lhoshar')); ?>.'
            }
            <?php } ?>
        },
        errorLabelContainer: "#error_list",
        wrapper: "li",
        invalidHandler: function(form, validator) {
            $('html,body').animate({ scrollTop: $('h1').offset().top }, { duration: 250, easing: 'swing'});
        },
        submitHandler: function(form){
            $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
            setTimeout("$('button[type=submit], input[type=submit]').removeAttr('disabled')", 5000);
            form.submit();
        }
    });
</script>
<?php
}

if(osc_is_publish_page() || osc_is_edit_page()){
    osc_add_hook('footer', 'lhoshar_item_post_form_validate');
}


/**

CLASSES

*/
class lhosharBodyClass
{
    /**
    * Custom Class for add, remove or get body classes.
    *
    * @param string $instance used for singleton.
    * @param array $class.
    */
    private static $instance;
    private $class;

    private function __construct()
    {
        $this->class = array();
    }

    public static function newInstance()
    {
        if (  !self::$instance instanceof self)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function add($class)
    {
        $this->class[] = $class;
    }
    public function get()
    {
        return $this->class;
    }
}

/**

HELPERS

*/
if( !function_exists('osc_uploads_url')) {
    function osc_uploads_url($item = '') {
        return osc_base_url().'oc-content/uploads/'.$item;
    }
}

function lhoshar_footer_msg(){
    if( osc_get_preference('footer_message', 'lhoshar') ) {
        return osc_get_preference('footer_message', 'lhoshar');
    }else{
        return false;
    }
}
function lhoshar_premium_listings_shown_home(){
    return osc_get_preference('premium_listings_shown_home', 'lhoshar');
}

function lhoshar_title_minimum_length(){
    return osc_get_preference('title_minimum_length', 'lhoshar');
}
function lhoshar_description_minimum_length(){
    return osc_get_preference('description_minimum_length', 'lhoshar');
}
function lhoshar_premium_listings_shown(){
    return osc_get_preference('premium_listings_shown', 'lhoshar');
}
function lhoshar_locations_input_as(){
    return osc_get_preference('locations_input_as', 'lhoshar');
}
function lhoshar_locations_required(){
    return (osc_get_preference('locations_required', 'lhoshar') == '1')? 'true': 'false';
}
function lhoshar_categories_select($name, $id, $label){
    $name = osc_esc_html($name);
    $id = osc_esc_html($id);
    $label = osc_esc_html($label);
    $categories = Category::newInstance()->toTreeAll();

    if(count($categories) > 0 ) {
            
        $html  = '<select name="'.$name.'" id="'.$id.'">';
        $html .= '<option value="">'.$label.'</option>';
        foreach($categories as $topcat) { 
            $html .= '<option class="top" value="'.osc_esc_html( $topcat['s_name']).'">'. $topcat['s_name'].'</option>';
            if(!empty($topcat['categories'])) {
                
                foreach($topcat['categories'] as $subcat) {
                    $html .= '<option value="'. osc_esc_html($subcat['s_name']).'">&nbsp;&nbsp;'. $subcat['s_name'].'</option>';
                }
            
            }
        } 
        $html .= '</select>';
    } 

    echo $html;
}
function lhoshar_countries_select($name, $id, $label, $value=NULL){
    $name = osc_esc_html($name);
    $id = osc_esc_html($id);
    $label = osc_esc_html($label);
    
    $aCountries = Country::newInstance()->listAll(); 
    if(count($aCountries) > 0 ) { 
        $html  = '<select name="'.$name.'" id="'.$id.'">';
        $html .= '<option value="">'.$label.'</option>';
        foreach($aCountries as $country) {
            if($value == $country['pk_c_code']) $selected = 'selected="selected"'; else $selected = '';
            $html .= '<option value="'. osc_esc_html($country['pk_c_code']).'" '.$selected.'>'. $country['s_name'].'</option>';
        } 
        $html .= '</select>';
    } 

    echo $html;
}
function lhoshar_regions_select($name, $id, $label, $value=NULL){
    $name = osc_esc_html($name);
    $id = osc_esc_html($id);
    $label = osc_esc_html($label);
    
    $aRegions = Region::newInstance()->listAll(); 
    if(count($aRegions) > 0 ) { 

        $html  = '<select name="'.$name.'" id="'.$id.'">';
        $html .= '<option value="" id="sRegionSelect">'.$label.'</option>';
        foreach($aRegions as $region) {
            if($value == $region['s_name']) $selected = 'selected="selected"'; else $selected = '';
            $html .= '<option value="'. osc_esc_html($region['s_name']).'" '.$selected.'>'. $region['s_name'].'</option>';
        } 
        $html .= '</select>';
    } 

    echo $html;
}
function lhoshar_cities_select($name, $id, $label, $value=NULL){
    $name = osc_esc_html($name);
    $id = osc_esc_html($id);
    $label = osc_esc_html($label);
    
    $html  = '<select name="'.$name.'" id="'.$id.'">';
    $html .= '<option value="" id="sCitySelect">'.$label.'</option>';
    if(osc_count_list_cities() > 0 ) {
        while(osc_has_list_cities() ) { 
            if($value == osc_list_city_name()) $selected = 'selected="selected"'; else $selected = '';
            $html .= '<option value="'. osc_esc_html(osc_list_city_name()).'" '.$selected.'>'. osc_list_city_name().'</option>';
        }
    }
    $html .= '</select>';

    echo $html;
}
function lhoshar_popular_regions($limit = 20){
    View::newInstance()->_exportVariableToView('list_regions', Search::newInstance()->listRegions('%%%%', '>=') ) ;
    if(osc_count_list_regions() > 0 ) { 
        $array  =   array();
        while(osc_has_list_regions() ) {
            if( osc_list_region_items() > 0){
                $region_name            =   osc_list_region_name();
                $array[ $region_name ]  =   osc_list_region_items();
            }
        }
        arsort($array);
        return  array_slice($array, 0, $limit);
    }else{
        return false;
    }
}
function lhoshar_popular_cities($limit = 20){
    View::newInstance()->_exportVariableToView('list_cities', Search::newInstance()->listCities('%%%%', '>=') ) ;
    if(osc_count_list_cities() > 0 ) { 
        $array  =   array();
        while(osc_has_list_cities() ) {
            if( osc_list_city_items() > 0){ 
                $city_name  =   osc_list_city_name();
                $array[ $city_name ]    =   osc_list_city_items();
            }
        }
        arsort($array);
        return  array_slice($array, 0, $limit);
    }else{
        return false;
    }
}
function lhoshar_popular_searches($limit = 20){

    if(osc_count_latest_searches() > 0){
        $conn = getConnection() ;
        $conn->autocommit(false);
        try {
            $results    =   $conn->osc_dbFetchResults("SELECT s_search, COUNT(s_search) AS total FROM %st_latest_searches WHERE s_search != '' GROUP BY s_search ORDER BY total DESC LIMIT %d", DB_TABLE_PREFIX, $limit);
            $conn->commit();
            return $results;
        } catch (Exception $e) {
            $conn->rollback();
            echo $e->getMessage();
        }
        $conn->autocommit(true);
    }else{
        return false;
    }
}
function lhoshar_insert_search(){
    $search_word    =   Params::getParam('sPattern');
    if(isset($search_word) && $search_word!="" ){
        $conn = getConnection() ;
        $conn->autocommit(false);
        try {
            $conn->osc_dbExec("INSERT INTO %st_latest_searches (d_date, s_search) VALUES (now(), '%s')", DB_TABLE_PREFIX, $search_word);
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            echo $e->getMessage();
        }
        $conn->autocommit(true);
    }
}
osc_add_hook('search', 'lhoshar_insert_search');
function lhoshar_theme_color_mode(){
    return osc_get_preference('theme_color_mode', 'lhoshar');
}
function lhoshar_show_popular_regions(){
    if(osc_get_preference('show_popular_regions', 'lhoshar') == 1){
        return true;
    }
    else{
        return false;
    }
}
function lhoshar_popular_regions_limit(){
    return osc_get_preference('popular_regions_limit', 'lhoshar');
}
function lhoshar_show_popular_cities(){
    if(osc_get_preference('show_popular_cities', 'lhoshar') == 1){
        return true;
    }
    else{
        return false;
    }
}
function lhoshar_popular_cities_limit(){
    return osc_get_preference('popular_cities_limit', 'lhoshar');
}
function lhoshar_show_popular_searches(){
    if(osc_get_preference('show_popular_searches', 'lhoshar') == 1){
        return true;
    }
    else{
        return false;
    }
}
function lhoshar_popular_searches_limit(){
    return osc_get_preference('popular_searches_limit', 'lhoshar');
}

function lhoshar_facebook_like_box(){
?>
<div class="fb-page" data-href="<?php echo osc_esc_html( osc_get_preference('facebook-url', 'lhoshar') ); ?>" data-width="<?php echo osc_esc_html( osc_get_preference('facebook-width', 'lhoshar') ); ?>" data-height="<?php echo osc_esc_html( osc_get_preference('facebook-height', 'lhoshar') ); ?>" data-hide-cover="<?php echo (osc_esc_html( osc_get_preference('facebook-hidecover', 'lhoshar')) == "1" ) ? "true":"false"; ?>" data-show-facepile="<?php echo (osc_esc_html( osc_get_preference('facebook-showface', 'lhoshar')) == "1" ) ? "true":"false"; ?>" data-show-posts="<?php echo (osc_esc_html( osc_get_preference('facebook-showpost', 'lhoshar')) == "1" ) ? "true":"false"; ?>"></div>
<?php
}
function lhoshar_footer_css(){
    $custom_css = trim(osc_get_preference('custom_css', 'lhoshar'));
    if( $custom_css != "" ){
        echo "<style>";
        echo $custom_css;
        echo "</style>";
    }
}
osc_add_hook('footer', 'lhoshar_footer_css');
function lhoshar_footer_js(){
    echo '<script type="text/javascript" src="'.osc_current_web_theme_js_url('main.js').'"></script>';
}
osc_add_hook('footer', 'lhoshar_footer_js');

function is_realEstate_enabled(){
if(class_exists('ModelRealEstate'))
    return true;
else
    return false;
}
function lhoshar_realEstate_garages($id){
if( is_realEstate_enabled() ){
    $detail = ModelRealEstate::newInstance()->getAttributes( $id );

    if(!empty( $detail['i_num_garages'] ))
    {
        return $detail['i_num_garages'];
    }else{
        return __("n/a", 'lhoshar');
    }
}
return;
}
function lhoshar_realEstate_bathrooms($id){
if( is_realEstate_enabled() ){
    $detail = ModelRealEstate::newInstance()->getAttributes( $id );
    
    if(!empty( $detail['i_num_bathrooms'] ))
    {
        return $detail['i_num_bathrooms'];
    }else{
        return __("n/a", 'lhoshar');
    }
}
return;
}
function lhoshar_realEstate_floors($id){
if( is_realEstate_enabled() ){
    $detail = ModelRealEstate::newInstance()->getAttributes( $id );
    
    if(!empty( $detail['i_num_floors'] ))
    {
        return $detail['i_num_floors'];
    }else{
        return __("n/a", 'lhoshar');
    }
}
return;
}
function lhoshar_realEstate_rooms($id){
if( is_realEstate_enabled() ){
    $detail = ModelRealEstate::newInstance()->getAttributes( $id );
    
    if(!empty( $detail['i_num_rooms'] ))
    {
        return $detail['i_num_rooms'];
    }else{
        return __("n/a", 'lhoshar');
    }
}
return;
}
function lhoshar_realEstate_area($id){
if( is_realEstate_enabled() ){
    $detail = ModelRealEstate::newInstance()->getAttributes( $id );
    
    if(!empty( $detail['i_plot_area'] ))
    {
        return $detail['i_plot_area']."/m<sup>2</sup>";
    }else{
        return __("n/a", 'lhoshar');
    }
}
return;
}
function lhoshar_realEstate_type($id){
if( is_realEstate_enabled() ){
    $detail = ModelRealEstate::newInstance()->getAttributes( $id );
    
    if(!empty( $detail['e_type'] ))
    {
        if($detail['e_type'] == "FOR SALE") $type = __('SALE', 'lhoshar'); else $type = __('RENT', 'lhoshar');
        return $type;
    }
}
return false;
}
function lhoshar_realEstate_propertyType($format = true){
if( is_realEstate_enabled() ){
    $detail = ModelRealEstate::newInstance()->getPropertyTypes( $format );
    $locale = osc_current_user_locale();
    if(!empty( $detail[$locale] ))
    {
        return $detail[$locale];
    }else{
        return false;
    }
}
return false;
}

//Slick Slider Script
function slickslider_script(){ ?>
<script>
$('.regular').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        responsive: [
            {
                breakpoint: 991, // tablet breakpoint
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767, // mobile breakpoint
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
});
</script>
<?php }
osc_add_hook('footer', 'slickslider_script');

// To the Top Script
function to_the_top_script(){ ?>
    <script>
    jQuery(document).ready(function($){
    $(window).scroll(function(){
        if ($(this).scrollTop() > 50) {
            $('#myBtn').fadeIn('slow');
        } else {
            $('#myBtn').fadeOut('slow');
        }
    });
    $('#myBtn').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 1800);
        return false;
    });
});
</script>
<?php }
if ( osc_get_preference('to_the_top', 'lhoshar') == 1 ) {
    osc_add_hook('footer', 'to_the_top_script');
}

/*

    ads  SEARCH

 */
if (!function_exists('search_ads_listing_top_fn')) {
    function search_ads_listing_top_fn() {
        if(osc_get_preference('search-results-top-728x90', 'lhoshar')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_header ads-headers">' . PHP_EOL;
            echo osc_get_preference('search-results-top-728x90', 'lhoshar');
            echo '</div>' . PHP_EOL;
            echo '</br>';
        }
    }
}
osc_add_hook('search_ads_listing_top', 'search_ads_listing_top_fn');

if (!function_exists('search_ads_listing_medium_fn')) {
    function search_ads_listing_medium_fn() {
        if(osc_get_preference('search-results-middle-728x90', 'lhoshar')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_header ads-headers">' . PHP_EOL;
            echo osc_get_preference('search-results-middle-728x90', 'lhoshar');
            echo '</div>' . PHP_EOL;
        }
    }
}
osc_add_hook('search_ads_listing_medium', 'search_ads_listing_medium_fn');
?>
