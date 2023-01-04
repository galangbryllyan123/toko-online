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

/**
** DEFAULT VALUES
**/
    if( !osc_get_preference('sub_cat_limit', 'sakela') ) {
        osc_set_preference('sub_cat_limit', 5, 'sakela');
    }
    if( !osc_get_preference('popular_regions_limit', 'sakela') ) {
        osc_set_preference('popular_regions_limit', 10, 'sakela');
    }   
    if( !osc_get_preference('popular_cities_limit', 'sakela') ) {
        osc_set_preference('popular_cities_limit', 10, 'sakela');
    }   
    if( !osc_get_preference('popular_searches_limit', 'sakela') ) {
        osc_set_preference('popular_searches_limit', 10, 'sakela');
    }
    
    if( !osc_get_preference('locations_input_as', 'sakela') ) {
        osc_set_preference('locations_input_as', 'text', 'sakela');
    }   
    if( !osc_get_preference('premium_listings_shown_home', 'sakela') ) {
        osc_set_preference('premium_listings_shown_home', 6, 'sakela');
    }
    if( !osc_get_preference('premium_listings_shown', 'sakela') ) {
        osc_set_preference('premium_listings_shown', 6, 'sakela');
    }
    if( !osc_get_preference('title_minimum_length', 'sakela') ) {
        osc_set_preference('title_minimum_length', 1, 'sakela');
    }   
    if( !osc_get_preference('description_minimum_length', 'sakela') ) {
        osc_set_preference('description_minimum_length', 3, 'sakela');
    }
    if( !osc_get_preference('theme_color_mode', 'sakela') ) {
        osc_set_preference('theme_color_mode', 'green', 'sakela');
    }
    if( !osc_get_preference('theme_color', 'sakela') ) {
        osc_set_preference('theme_color', '#77c04b', 'sakela');
    }
    osc_reset_preferences();

    define('SAKELA_THEME_VERSION', '100');
    if( (string)osc_get_preference('keyword_placeholder', 'sakela')=="" ) {
        Params::setParam('keyword_placeholder', __('ie. PHP Programmer', 'sakela') ) ;
    }
    osc_register_script('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.pack.js'), array('jquery'));
    osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
    osc_enqueue_script('fancybox');

    osc_enqueue_style('font-awesome', osc_current_web_theme_url('css/font-awesome-4.1.0/css/font-awesome.min.css'));
    // used for date/dateinterval custom fields
    osc_enqueue_script('php-date');
    if(!OC_ADMIN) {
        osc_enqueue_style('fine-uploader-css', osc_assets_url('js/fineuploader/fineuploader.css'));
        osc_enqueue_style('sakela-fine-uploader-css', osc_current_web_theme_url('css/ajax-uploader.css'));
    }
    osc_enqueue_script('jquery-fineuploader');

/**

FUNCTIONS

*/
    // install options
    if( !function_exists('sakela_theme_install') ) {
        function sakela_theme_install() {
            osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'sakela');
            osc_set_preference('version', SAKELA_THEME_VERSION, 'sakela');
            osc_set_preference('footer_link', '1', 'sakela');
            osc_set_preference('donation', '0', 'sakela');
            osc_set_preference('defaultShowAs@all', 'list', 'sakela');
            osc_set_preference('defaultShowAs@search', 'list', 'sakela');
            osc_set_preference('defaultLocationShowAs', 'dropdown', 'sakela'); // dropdown / autocomplete
            osc_set_preference('show_banner', '0', 'sakela');
            osc_set_preference('show_footer', '0', 'sakela');
            osc_set_preference('show_popular', '1', 'sakela');
            osc_set_preference('show_popular_regions', '1', 'sakela');
            osc_set_preference('show_popular_cities', '1', 'sakela');
            osc_set_preference('show_search_country', '1', 'sakela');
            osc_set_preference('show_popular_searches', '1', 'sakela');
            osc_set_preference('sub_cat_limit', 5, 'sakela');
            $social = [ 'facebook' => '#', 'twitter' => '#', 'instagram' => '#', 'linkedin' => '#', 'google' => '#', 'youtube' => '#' ];
            osc_set_preference('social', serialize($social), 'sakela');
            osc_reset_preferences();
        }
    }
    // update options
    if( !function_exists('sakela_theme_update') ) {
        function sakela_theme_update($current_version) {
            if($current_version==0) {
                sakela_theme_install();
            }
            osc_delete_preference('default_logo', 'sakela');

            $logo_prefence = osc_get_preference('logo', 'sakela');
            $logo_name     = 'sakela_logo';
            $temp_name     = WebThemes::newInstance()->getCurrentThemePath() . 'images/logo.jpg';
            if( file_exists( $temp_name ) && !$logo_prefence) {

                $img = ImageResizer::fromFile($temp_name);
                $ext = $img->getExt();
                $logo_name .= '.'.$ext;
                $img->saveToFile(osc_uploads_path().$logo_name);
                osc_set_preference('logo', $logo_name, 'sakela');
            }
            osc_set_preference('version', '100', 'sakela');

            if($current_version<100 || $current_version=='1.0.0') {
                // add preferences
                osc_set_preference('defaultLocationShowAs', 'dropdown', 'sakela');
                osc_set_preference('version', '100', 'sakela');
            }
            osc_set_preference('version', '100', 'sakela');
            osc_reset_preferences();
        }
    }
    if(!function_exists('check_install_sakela_theme')) {
        function check_install_sakela_theme() {
            $current_version = osc_get_preference('version', 'sakela');
            //check if current version is installed or need an update<
            if( $current_version=='' ) {
                sakela_theme_update(0);
            } else if($current_version < SAKELA_THEME_VERSION){
                sakela_theme_update($current_version);
            }
        }
    }

    if(!function_exists('sakela_add_body_class_construct')) {
        function sakela_add_body_class_construct($classes){
            $sakelaBodyClass = sakelaBodyClass::newInstance();
            $classes = array_merge($classes, $sakelaBodyClass->get());
            return $classes;
        }
    }
    if(!function_exists('sakela_body_class')) {
        function sakela_body_class($echo = true){
            /**
            * Print body classes.
            *
            * @param string $echo Optional parameter.
            * @return print string with all body classes concatenated
            */
            osc_add_filter('sakela_bodyClass','sakela_add_body_class_construct');
            $classes = osc_apply_filter('sakela_bodyClass', array());
            if($echo && count($classes)){
                echo 'class="'.implode(' ',$classes).'"';
            } else {
                return $classes;
            }
        }
    }
    if(!function_exists('sakela_add_body_class')) {
        function sakela_add_body_class($class){
            /**
            * Add new body class to body class array.
            *
            * @param string $class required parameter.
            */
            $sakelaBodyClass = sakelaBodyClass::newInstance();
            $sakelaBodyClass->add($class);
        }
    }
    if(!function_exists('sakela_nofollow_construct')) {
        /**
        * Hook for header, meta tags robots nofollos
        */
        function sakela_nofollow_construct() {
            echo '<meta name="robots" content="noindex, nofollow, noarchive" />' . PHP_EOL;
            echo '<meta name="googlebot" content="noindex, nofollow, noarchive" />' . PHP_EOL;

        }
    }
    if( !function_exists('sakela_follow_construct') ) {
        /**
        * Hook for header, meta tags robots follow
        */
        function sakela_follow_construct() {
            echo '<meta name="robots" content="index, follow" />' . PHP_EOL;
            echo '<meta name="googlebot" content="index, follow" />' . PHP_EOL;

        }
    }
    /* logo */
    if( !function_exists('logo_header') ) {
        function logo_header() {
             $logo = osc_get_preference('logo','sakela');
             $html = '<a href="'.osc_base_url().'"><img border="0" alt="' . osc_page_title() . '" src="' . sakela_logo_url() . '"></a>';
             if( $logo!='' && file_exists( osc_uploads_path() . $logo ) ) {
                return $html;
             } else {
                return '<a href="'.osc_base_url().'"><img border="0" height="25" width="148" alt="' . osc_page_title() . '" src = "' . osc_base_url().'oc-content/themes/sakela/images/logo.jpg' . '" ></a>';
            }
        }
    }
    
    /* logo */
    if( !function_exists('sakela_logo_url') ) {
        function sakela_logo_url() {
            $logo = osc_get_preference('logo','sakela');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
    if( !function_exists('sakela_favicon_url') ) {
        function sakela_favicon_url() {
            $logo = osc_get_preference('favicon','sakela');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            else
            {
                return osc_current_web_theme_url('images/favicon.png'); 
            }
        }
    }
    if( !function_exists('sakela_draw_item') ) {
        function sakela_draw_item($class = false,$admin = false, $premium = false) {
            $filename = 'loop-single';
            if($premium){
                $filename .='-premium';
            }
            require WebThemes::newInstance()->getCurrentThemePath().$filename.'.php';
        }
    }

    function sakela_countries_select($name, $id, $label, $value=NULL){
        $name = osc_esc_html($name);
        $id = osc_esc_html($id);
        $label = osc_esc_html($label);
        
        $aCountries = Country::newInstance()->listAll(); 
        if(count($aCountries) > 0 ) { 
            $html  = '<select name="'.$name.'" id="'.$id.'">';
            $html .= '<option value="">'.$label.'</option>';
            foreach($aCountries as $country) {
                if($value == $country['pk_c_code']) $selected = 'selected="selected"'; else $selected = '';
                $html .= '<option value="'. $country['pk_c_code'].'" '.$selected.'>'. $country['s_name'].'</option>';
            } 
            $html .= '</select>';
        } 

        echo $html;
    }

    function sakela_regions_select($name, $id, $label, $value=NULL){
        $name = osc_esc_html($name);
        $id = osc_esc_html($id);
        $label = osc_esc_html($label);
        
        $aRegions = Region::newInstance()->listAll(); 
        if(count($aRegions) > 0 ) { 

            $html  = '<select name="'.$name.'" id="'.$id.'">';
            $html .= '<option value="" id="sRegionSelect">'.$label.'</option>';
            foreach($aRegions as $region) {
                if($value == $region['s_name']) $selected = 'selected="selected"'; else $selected = '';
                $html .= '<option value="'. $region['pk_i_id'].'" '.$selected.'>'. $region['s_name'].'</option>';
            } 
            $html .= '</select>';
        } 

        echo $html;
    }
    function sakela_cities_select($name, $id, $label, $value=NULL){
        $name = osc_esc_html($name);
        $id = osc_esc_html($id);
        $label = osc_esc_html($label);
        
        $html  = '<select name="'.$name.'" id="'.$id.'">';
        $html .= '<option value="" id="sCitySelect">'.$label.'</option>';
        if(osc_count_list_cities() > 0 ) {
            while(osc_has_list_cities() ) { 
                if($value == osc_list_city_name()) $selected = 'selected="selected"'; else $selected = '';
                $html .= '<option value="'. osc_list_city_name().'" '.$selected.'>'. osc_list_city_name().'</option>';
            }
        }
        $html .= '</select>';

        echo $html;
    }
    function sakela_popular_regions($limit = 20){
        View::newInstance()->_exportVariableToView('list_regions', Search::newInstance()->listRegions('%%%%', '>') ) ;
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
    function sakela_popular_cities($limit = 20){
        View::newInstance()->_exportVariableToView('list_cities', Search::newInstance()->listCities('%%%%', '>') ) ;
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
    function sakela_popular_searches($limit = 20){
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
    function sakela_insert_search(){
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
    osc_add_hook('search', 'sakela_insert_search');
    function sakela_theme_color_mode(){
        return osc_get_preference('theme_color_mode', 'sakela');
    }
    function sakela_show_popular_regions(){
        if(osc_get_preference('show_popular_regions', 'sakela') == 1){
            return true;
        }
        else{
            return false;
        }
    }
    function sakela_popular_regions_limit(){
        return osc_get_preference('popular_regions_limit', 'sakela');
    }
    function sakela_show_popular_cities(){
        if(osc_get_preference('show_popular_cities', 'sakela') == 1){
            return true;
        }
        else{
            return false;
        }
    }
    function sakela_popular_cities_limit(){
        return osc_get_preference('popular_cities_limit', 'sakela');
    }
    function sakela_show_popular_searches(){
        if(osc_get_preference('show_popular_searches', 'sakela') == 1){
            return true;
        }
        else{
            return false;
        }
    }
    function sakela_popular_searches_limit(){
        return osc_get_preference('popular_searches_limit', 'sakela');
    }

    if( !function_exists('sakela_show_as') ){
        function sakela_show_as(){

            $p_sShowAs    = Params::getParam('sShowAs');
            $aValidShowAsValues = array('list', 'gallery');
            if (!in_array($p_sShowAs, $aValidShowAsValues)) {
                $p_sShowAs = sakela_default_show_as();
            }

            return $p_sShowAs;
        }
    }
    if( !function_exists('sakela_default_show_as') ){
        function sakela_default_show_as(){
            return getPreference('defaultShowAs@all','sakela');
        }
    }
    if( !function_exists('sakela_default_location_show_as') ){
        function sakela_default_location_show_as(){
            return osc_get_preference('defaultLocationShowAs','sakela');
        }
    }
    if( !function_exists('sakela_draw_categories_list') ) {
        function sakela_draw_categories_list(){ ?>
        <?php if(!osc_is_home_page()){ echo '<div class="resp-wrapper">'; } ?>
 <div class="row" id="categories-row">  
   <h1 id="categories-row-h1"><?php _e("Categories", "sakela") ; ?></h1>       
         <?php
         //cell_3
        $total_categories   = osc_count_categories();
        $col1_max_cat       = ceil($total_categories/3);

         osc_goto_first_category();
         $i      = 0;

         $icons = unserialize(osc_get_preference('icons', 'sakela'));

         while ( osc_has_categories() ) {
         ?>
        <?php
            if($i%$col1_max_cat == 0){
                if($i > 0) { echo '</div>'; }
                if($i == 0) {
                   echo '<div class="categories-list">';
                } else {
                    echo '<div class="categories-list">';
                }
            }
        ?>
      <div class="col-md-4 col-sm-6">  
        <ul id="category-heading">
             <li>
                 <h1>
                    <?php
                    $_catid      = osc_category_id();
                    $_slug      = osc_category_slug();
                    $_url       = osc_search_category_url();
                    $_name      = osc_category_name();
                    $_total_items = osc_category_total_items();
                    if ( osc_count_subcategories() > 0 ) { ?>
                    <span class="collapse resp-toogle"><i class="fa fa-caret-right fa-lg"></i></span>
                    <?php } ?>
                    <a class="category <?php echo $_slug; ?>" href="<?php echo $_url; ?>"><?php echo $_name ; ?></a> <span><i class="fa <?php echo osc_esc_html($icons[$_catid])?:'fa-archive'?>"></i></span>
                 </h1>
                 <?php if ( osc_count_subcategories() > 0 ) { $m=1; ?>
                        <ul id="all-categories">
                        <?php while ( osc_has_subcategories() ) { if( $m<=(osc_get_preference('sub_cat_limit', 'sakela'))){?>
                        <li>
                            <?php if( osc_category_total_items() > 0 ) { ?>
                            <a class="category sub-category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?></a> <span>(<?php echo osc_category_total_items() ; ?>)</span>
                            <?php } else { ?>
                            <a class="category sub-category <?php echo osc_category_slug() ; ?>" href="#"><?php echo osc_category_name() ; ?></a> <span>(<?php echo osc_category_total_items() ; ?>)</span>
                            <?php } ?>
                        </li>
                        <?php } $m++; } if($m>(osc_get_preference('sub_cat_limit', 'sakela'))+1) {?>
                        <li class="last"><a href="<?php echo $_url; ?>"><strong><?php _e('view all...', 'sakela');?></strong></a></li>
                        <?php } ?>
                        </ul>
                        <?php } ?>
             </li>
        </ul>
     </div>   
        <?php
                $i++;
            }
            echo '</div>';
        ?>
    </div>
        <?php if(!osc_is_home_page()){ echo '</div>'; } ?>
        <?php
        }
    }
    if( !function_exists('sakela_search_number') ) {
        /**
          *
          * @return array
          */
        function sakela_search_number() {
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
    if( !function_exists('sakela_item_title') ) {
        function sakela_item_title() {
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
    if( !function_exists('sakela_item_description') ) {
        function sakela_item_description() {
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
            $lang['item_add']               = __('Publish a listing', 'sakela');
            $lang['item_edit']              = __('Edit your listing', 'sakela');
            $lang['item_send_friend']       = __('Send to a friend', 'sakela');
            $lang['item_contact']           = __('Contact publisher', 'sakela');
            $lang['search']                 = __('Search results', 'sakela');
            $lang['search_pattern']         = __('Search results: %s', 'sakela');
            $lang['user_dashboard']         = __('Dashboard', 'sakela');
            $lang['user_dashboard_profile'] = __("%s's profile", 'sakela');
            $lang['user_account']           = __('Account', 'sakela');
            $lang['user_items']             = __('Listings', 'sakela');
            $lang['user_alerts']            = __('Alerts', 'sakela');
            $lang['user_profile']           = __('Update account', 'sakela');
            $lang['user_change_email']      = __('Change email', 'sakela');
            $lang['user_change_username']   = __('Change username', 'sakela');
            $lang['user_change_password']   = __('Change password', 'sakela');
            $lang['login']                  = __('Login', 'sakela');
            $lang['login_recover']          = __('Recover password', 'sakela');
            $lang['login_forgot']           = __('Change password', 'sakela');
            $lang['register']               = __('Create a new account', 'sakela');
            $lang['contact']                = __('Contact', 'sakela');
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
                'name'  => __('Listings', 'sakela'),
                'url'   => osc_user_list_items_url(),
                'class' => 'opt_items'
            );
            $options[] = array(
                'name' => __('Alerts', 'sakela'),
                'url' => osc_user_alerts_url(),
                'class' => 'opt_alerts'
            );
            $options[] = array(
                'name'  => __('Account', 'sakela'),
                'url'   => osc_user_profile_url(),
                'class' => 'opt_account'
            );
            $options[] = array(
                'name'  => __('Change email', 'sakela'),
                'url'   => osc_change_user_email_url(),
                'class' => 'opt_change_email'
            );
            $options[] = array(
                'name'  => __('Change username', 'sakela'),
                'url'   => osc_change_user_username_url(),
                'class' => 'opt_change_username'
            );
            $options[] = array(
                'name'  => __('Change password', 'sakela'),
                'url'   => osc_change_user_password_url(),
                'class' => 'opt_change_password'
            );
            $options[] = array(
                'name'  => __('Delete account', 'sakela'),
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
    sakela.user = {};
    sakela.user.id = '<?php echo osc_user_id(); ?>';
    sakela.user.secret = '<?php echo osc_user_field("s_secret"); ?>';
</script>
            <?php }
        }
        osc_add_hook('header', 'user_info_js');
    }

    function theme_sakela_actions_admin() {
        //if(OC_ADMIN)
        if( Params::getParam('file') == 'oc-content/themes/sakela/admin/settings.php' ) {
            if( Params::getParam('donation') == 'successful' ) {
                osc_set_preference('donation', '1', 'sakela');
                osc_reset_preferences();
            }
        }

        switch( Params::getParam('action_specific') ) {
            case('settings'):
                $footerLink  = Params::getParam('footer_link');

                osc_set_preference('show_banner', ((Params::getParam('show_banner'))? '1' : '0'), 'sakela');
                osc_set_preference('show_footer', ((Params::getParam('show_footer'))? '1' : '0'), 'sakela');
                osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'sakela');
                osc_set_preference('footer_link', ($footerLink ? '1' : '0'), 'sakela');
                osc_set_preference('defaultShowAs@all', Params::getParam('defaultShowAs@all'), 'sakela');
                osc_set_preference('defaultShowAs@search', Params::getParam('defaultShowAs@all'));

                osc_set_preference('defaultLocationShowAs', Params::getParam('defaultLocationShowAs'), 'sakela');

                osc_set_preference('header-728x90',         trim(Params::getParam('header-728x90', false, false, false)),                  'sakela');
                osc_set_preference('homepage-728x90',       trim(Params::getParam('homepage-728x90', false, false, false)),                'sakela');
                osc_set_preference('sidebar-300x250',       trim(Params::getParam('sidebar-300x250', false, false, false)),                'sakela');
                osc_set_preference('search-results-top-728x90',     trim(Params::getParam('search-results-top-728x90', false, false, false)),          'sakela');
                osc_set_preference('search-results-middle-728x90',  trim(Params::getParam('search-results-middle-728x90', false, false, false)),       'sakela');

                osc_add_flash_ok_message(__('Theme settings updated correctly', 'sakela'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php'));
            break;

            case('theme_style'):    
                $color_mode  = Params::getParam('theme_color_mode');
                osc_set_preference('theme_color_mode', $color_mode, 'sakela');
                // osc_set_preference('google_fonts', Params::getParam('google_fonts'), 'sakela');

                $rtl_view   =   Params::getParam('rtl_view', 'sakela');
                osc_set_preference('rtl_view', ($rtl_view ? '1' : '0'), 'sakela');
                osc_set_preference('custom_css', trim(Params::getParam('custom_css', false, false, false)), 'sakela');
                
                osc_add_flash_ok_message(__('Theme color settings updated correctly', 'sakela'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/sakela/admin/settings.php#theme-style' ));

            case ('ads'):
            osc_set_preference('header-728x90', trim(Params::getParam('header-728x90', false, false, false)), 'sakela');
                osc_set_preference('homepage-728x90', trim(Params::getParam('homepage-728x90', false, false, false)), 'sakela');
                osc_set_preference('sidebar-300x250', trim(Params::getParam('sidebar-300x250', false, false, false)), 'sakela');
                osc_set_preference('search-results-top-728x90', trim(Params::getParam('search-results-top-728x90', false, false, false)), 'sakela');
                osc_set_preference('search-results-middle-728x90', trim(Params::getParam('search-results-middle-728x90', false, false, false)), 'sakela');
                 osc_add_flash_ok_message(__('Ads settings updated correctly', 'sakela'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#ads'));
            break;
            case('upload_logo'):
                $package = Params::getFiles('logo');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'sakela_logo';
                    $logo_name    .= '.'.$ext;
                    $path = osc_uploads_path() . $logo_name ;
                    $img->saveToFile($path);

                    osc_set_preference('logo', $logo_name, 'sakela');

                    osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'sakela'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'sakela'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#logo'));
            break;
            case('remove'):
                $logo = osc_get_preference('logo','sakela');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('logo','sakela');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The logo image has been removed', 'sakela'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'sakela'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#logo'));
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

                    osc_set_preference('favicon', $logo_name, 'sakela');

                    osc_add_flash_ok_message(__('The favicon image has been uploaded correctly', 'sakela'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'sakela'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#favicon'));
            break;
            case('remove_favicon'):
                $logo = osc_get_preference('favicon','sakela');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('favicon','sakela');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The favicon image has been removed', 'sakela'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'sakela'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#favicon'));
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

                    osc_set_preference('homeimage', $logo_name, 'sakela');

                    osc_add_flash_ok_message(__('The header background image has been uploaded correctly', 'sakela'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'sakela'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#banner'));
            break;  
            case('remove_homeimage'):
                $logo = osc_get_preference('homeimage','sakela');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('homeimage','sakela');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The header background image has been removed', 'sakela'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'sakela'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#banner'));
            break;

            case('upload_footerimage'):
                $package = Params::getFiles('footerimage');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'footerimage';
                    $logo_name    .= '.'.$ext;
                    $path = osc_uploads_path() . $logo_name ;
                    $img->saveToFile($path);

                    osc_set_preference('footerimage', $logo_name, 'sakela');

                    osc_add_flash_ok_message(__('The footer background image has been uploaded correctly', 'sakela'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'sakela'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#footer'));
            break;  
            case('remove_footerimage'):
                $logo = osc_get_preference('footerimage','sakela');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('footerimage','sakela');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The footer background image image has been removed', 'sakela'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'sakela'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#footer'));
            break;

            case('icons'):

            $icons = Params::getParam('icons');
            osc_set_preference('icons', serialize($icons), 'sakela');
            osc_add_flash_ok_message(__('The category icon settings has been saved', 'sakela'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#category'));
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

                osc_set_preference('social', serialize($social), 'sakela');
                osc_add_flash_ok_message(__('Social links updated correctly', 'sakela'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php#social'));
            break;
        }
    }

    function sakela_redirect_user_dashboard()
    {
        if( (Rewrite::newInstance()->get_location() === 'user') && (Rewrite::newInstance()->get_section() === 'dashboard') ) {
            header('Location: ' .osc_user_list_items_url());
            exit;
        }
    }

    function sakela_delete() {
        Preference::newInstance()->delete(array('s_section' => 'sakela'));
    }

    osc_add_hook('init', 'sakela_redirect_user_dashboard', 2);
    osc_add_hook('init_admin', 'theme_sakela_actions_admin');
    osc_add_hook('theme_delete_sakela', 'sakela_delete');
    osc_admin_menu_appearance(__('Sakela Theme settings', 'sakela'), osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php'), 'settings_sakela');
/**

TRIGGER FUNCTIONS

*/
check_install_sakela_theme();
if(osc_is_home_page()){
    osc_add_hook('inside-main','sakela_draw_categories_list');
} else if( osc_is_static_page() || osc_is_contact_page() ){
    osc_add_hook('before-content','sakela_draw_categories_list');
}

if(osc_is_home_page() || osc_is_search_page()){
    sakela_add_body_class('has-searchbox');
}


function sakela_sidebar_category_search($catId = null)
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

    sakela_print_sidebar_category_search($aCategories, $catId);
}

function sakela_print_sidebar_category_search($aCategories, $current_category = null, $i = 0)
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
            echo '<li><a href="'.osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))).'">'.__('All categories', 'sakela')."</a></li>";
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
        <li><a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))); ?>"><?php _e('All categories', 'sakela'); ?></a></li>
        <?php } ?>
            <li>
                <a id="cat_<?php echo osc_esc_html($c['pk_i_id']);?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=> $c['pk_i_id'], 'iPage'=>null))); ?>">
                <?php if(isset($current_category) && $current_category == $c['pk_i_id']){ echo '<strong>'.$c['s_name'].'</strong>'; }
                      else{ echo $c['s_name']; } ?>
                </a>
                <?php sakela_print_sidebar_category_search($aCategories, $current_category, $i); ?>
            </li>
        <?php if($i==1) { ?>
        <?php } ?>
    </ul>
<?php
    }
}

/**

CLASSES

*/
class sakelaBodyClass
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
if( !function_exists('osc_uploads_url') ){
    function osc_uploads_url($item = ''){
        return osc_base_url().'oc-content/uploads/'.$item;
    }
}

/*

    ads  SEARCH

 */
if (!function_exists('search_ads_listing_top_fn')) {
    function search_ads_listing_top_fn() {
        if(osc_get_preference('search-results-top-728x90', 'sakela')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_728">' . PHP_EOL;
            echo osc_get_preference('search-results-top-728x90', 'sakela');
            echo '</div>' . PHP_EOL;
        }
    }
}
//osc_add_hook('search_ads_listing_top', 'search_ads_listing_top_fn');

if (!function_exists('search_ads_listing_medium_fn')) {
    function search_ads_listing_medium_fn() {
        if(osc_get_preference('search-results-middle-728x90', 'sakela')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_728">' . PHP_EOL;
            echo osc_get_preference('search-results-middle-728x90', 'sakela');
            echo '</div>' . PHP_EOL;
        }
    }
}
osc_add_hook('search_ads_listing_medium', 'search_ads_listing_medium_fn');

function sakela_footer_css(){
    $custom_css = trim(osc_get_preference('custom_css', 'sakela'));
    if( $custom_css != "" ){
        echo "<style>";
        echo $custom_css;
        echo "</style>";
    }
}
osc_add_hook('footer', 'sakela_footer_css');

?>
