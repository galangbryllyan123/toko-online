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
    define('WAYST_THEME_VERSION', '200');
    if( (string)osc_get_preference('keyword_placeholder', 'wayst')=="" ) {
        Params::setParam('keyword_placeholder', __('ie. PHP Programmer', 'wayst') ) ;
    }
    osc_register_script('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.pack.js'), array('jquery'));
    osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
    osc_enqueue_script('fancybox');

    osc_enqueue_style('font-awesome', osc_current_web_theme_url('nss/font-awesome-4.1.0/font-awesome.min.css'));
    // used for date/dateinterval custom fields
    osc_enqueue_script('php-date');
    if(!OC_ADMIN) {
        osc_enqueue_style('fine-uploader-css', osc_assets_url('js/fineuploader/fineuploader.css'));
        osc_enqueue_style('wayst-fine-uploader-css', osc_current_web_theme_url('css/ajax-uploader.css'));
    }
    osc_enqueue_script('jquery-fineuploader');


/**

FUNCTIONS

*/

    // install options
    if( !function_exists('wayst_theme_install') ) {
        function wayst_theme_install() {
            osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'wayst');
            osc_set_preference('version', WAYST_THEME_VERSION, 'wayst');
            osc_set_preference('footer_link', '1', 'wayst');
            osc_set_preference('donation', '0', 'wayst');
            osc_set_preference('defaultShowAs@all', 'list', 'wayst');
            osc_set_preference('defaultShowAs@search', 'list');
            osc_set_preference('defaultLocationShowAs', 'dropdown', 'wayst'); // dropdown / autocomplete
            osc_reset_preferences();
        }
    }
    // update options
	
	
	
    if( !function_exists('wayst_theme_update') ) {
        function wayst_theme_update($current_version) {
            if($current_version==0) {
                wayst_theme_install();
            }
            osc_delete_preference('default_logo', 'wayst');

            $logo_prefence = osc_get_preference('logo', 'wayst');
            $logo_name     = 'wayst_logo';
            $temp_name     = WebThemes::newInstance()->getCurrentThemePath() . 'images/logo.jpg';
            if( file_exists( $temp_name ) && !$logo_prefence) {

                $img = ImageResizer::fromFile($temp_name);
                $ext = $img->getExt();
                $logo_name .= '.'.$ext;
                $img->saveToFile(osc_uploads_path().$logo_name);
                osc_set_preference('logo', $logo_name, 'wayst');
            }
            osc_set_preference('version', '200', 'wayst');

            if($current_version<200 || $current_version=='2.0.0') {
                // add preferences
                osc_set_preference('defaultLocationShowAs', 'dropdown', 'wayst');
                osc_set_preference('version', '200', 'wayst');
            }
            osc_set_preference('version', '200', 'wayst');
            osc_reset_preferences();
        }
    }
    if(!function_exists('check_install_wayst_theme')) {
        function check_install_wayst_theme() {
            $current_version = osc_get_preference('version', 'wayst');
            //check if current version is installed or need an update<
            if( $current_version=='' ) {
                wayst_theme_update(0);
            } else if($current_version < WAYST_THEME_VERSION){
                wayst_theme_update($current_version);
            }
        }
    }

    if(!function_exists('wayst_add_body_class_construct')) {
        function wayst_add_body_class_construct($classes){
            $waystBodyClass = waystBodyClass::newInstance();
            $classes = array_merge($classes, $waystBodyClass->get());
            return $classes;
        }
    }
    if(!function_exists('wayst_body_class')) {
        function wayst_body_class($echo = true){
            /**
            * Print body classes.
            *
            * @param string $echo Optional parameter.
            * @return print string with all body classes concatenated
            */
            osc_add_filter('wayst_bodyClass','wayst_add_body_class_construct');
            $classes = osc_apply_filter('wayst_bodyClass', array());
            if($echo && count($classes)){
                echo 'class="'.implode(' ',$classes).'"';
            } else {
                return $classes;
            }
        }
    }
    if(!function_exists('wayst_add_body_class')) {
        function wayst_add_body_class($class){
            /**
            * Add new body class to body class array.
            *
            * @param string $class required parameter.
            */
            $waystBodyClass = waystBodyClass::newInstance();
            $waystBodyClass->add($class);
        }
    }
    if(!function_exists('wayst_nofollow_construct')) {
        /**
        * Hook for header, meta tags robots nofollos
        */
        function wayst_nofollow_construct() {
            echo '<meta name="robots" content="noindex, nofollow, noarchive" />' . PHP_EOL;
            echo '<meta name="googlebot" content="noindex, nofollow, noarchive" />' . PHP_EOL;

        }
    }
    if( !function_exists('wayst_follow_construct') ) {
        /**
        * Hook for header, meta tags robots follow
        */
        function wayst_follow_construct() {
            echo '<meta name="robots" content="index, follow" />' . PHP_EOL;
            echo '<meta name="googlebot" content="index, follow" />' . PHP_EOL;

        }
    }
	
	/* favicon */
    if( !function_exists('wayst_favicon') ) {
        function wayst_favicon() {
			echo '<link rel="shortcut icon" href="'.wayst_favicon_url().'" type="image/x-icon" />';
			echo "\n";
        }
    }  
	//end favicon
	
    /* logo */
	 if( !function_exists('logo_header') ) {
        function logo_header() {
            $html = '<a class="navbar-brand hidden-xs" href="'.osc_base_url().'"><img  width="185" height="75" border="0" src="' . osc_current_web_theme_url('images/logo.jpg') . '" /></a>';
            if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
                return $html;
            } else if( osc_get_preference('default_logo', 'wayst') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/default-logo.png")) ) {
                return '<a class="navbar-brand hidden-xs" href="'.osc_base_url().'"><img width="185" height="75" border="0" src="' . osc_current_web_theme_url('images/default-logo.png') . '" /></a>';
            } else {
                return '<a class="navbar-brand hidden-xs" href="'.osc_base_url().'"><img width="185" height="75" border="0" src="' . osc_current_web_theme_url('images/default-logo.png') . '" /></a>';
            }
        }
    }
	//homepage image
	if( !function_exists('homepage_image') ) {
        function homepage_image() {
             // you can add color to background like: style="background-color:#1575b9;"
             $html = '<div class="front-cover front-cover-big">
            <a href="'. osc_esc_html(osc_get_preference('hbanner-link1', 'wayst')) . '" class="ga-event overlay-1" data-cat="Front" data-action="" data-label=""></a>
            <figure>
                <img  class="img-responsive" border="0" src="' . osc_current_web_theme_url('images/homeimage1.jpg') . '">
                                    
                            </figure>
                    </div>';
             if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage1.jpg" ) ) {
                return $html;
             } else if( osc_get_preference('homeimage', 'wayst') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage1.jpg")) ) {
			 return $html;
            } else {
                return '<div class="front-cover front-cover-big">
            <a href="'. osc_item_post_url() .'" class="ga-event overlay-1" data-cat="Front" data-action="" data-label=""></a>
            <figure>
                <img class="img-responsive" border="0" src="' . osc_current_web_theme_url('images/homeimage12.jpg') . '" alt="'. osc_esc_html(__("Publish", "wayst")) .'!">
                                    <figcaption>
                        '. osc_esc_html(__('Publish', 'wayst')) .'!                   </figcaption>
                            </figure>
                    </div>';
            }
        }
    }
	
	
	if( !function_exists('homepageslider2_image') ) {
        function homepageslider2_image() {
             
             $html = ' <div class="hero_banner_slide3 center"><a href="'. osc_get_preference('hbanner-link2', 'wayst') . '"><img width="1320" height="224" class="img-responsive" border="0" src="' . osc_current_web_theme_url('images/homeimage2.jpg') . '"></a></div>';
             if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage2.jpg" ) ) {
                return $html;
             } else if( osc_get_preference('homeimageslider2', 'wayst') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage2.jpg")) ) {
			 return $html;
            } else {
                return false;
            }
        }
    }
	
	
	if( !function_exists('homepageslider3_image') ) {
        function homepageslider3_image() {
             
             $html = ' <div class="hero_banner_slide6 center "><a href="'. osc_get_preference('hbanner-link3', 'wayst') . '"><img width="1320" height="224" class="img-responsive" border="0" src="' . osc_current_web_theme_url('images/homeimage3.jpg') . '"></a></div>';
             if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage3.jpg" ) ) {
                return $html;
             } else if( osc_get_preference('homeimageslider2', 'wayst') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage3.jpg")) ) {
			 return $html;
            } else {
                return false;
            }
        }
    }
	
	//end homepage image
	
	if( !function_exists('homepage2_image') ) {
        function homepage2_image() {
             
             $html = '<div class="hero_banner_slide102 center"><a href="'. osc_get_preference('hbanner-link4', 'wayst') . '"><img width="800" height="320" class="img-responsive" border="0" src="' . osc_current_web_theme_url('images/homeimagemobile1.jpg') . '"></a></div>';
             if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile1.jpg" ) ) {
                return $html;
             } else if( osc_get_preference('homeimageslider2', 'wayst') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile1.jpg")) ) {
			 return $html;
             } else {
                return '<a href="#"><img width="800" height="320" class="img-responsive" border="0" src="' . osc_current_web_theme_url('images/homeimagemobile1.jpg') . '"></a>';
            }
        }
    }
	
	
	if( !function_exists('homepageimagemobile2_image') ) {
        function homepageimagemobile2_image() {
             
             $html = '<div class="hero_banner_slide104 center">
<a href="'. osc_get_preference('hbanner-link5', 'wayst') . '"><img width="800" height="320" class="img-responsive" border="0" src="' . osc_current_web_theme_url('images/homeimagemobile2.jpg') . '"></a></div>';
             if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile2.jpg" ) ) {
                return $html;
             } else if( osc_get_preference('homeimagemobile2', 'wayst') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile2.jpg")) ) {
			 return $html;
             } else {
                return false;
            }
        }
    }
	
	
	if( !function_exists('homepageimagemobile3_image') ) {
        function homepageimagemobile3_image() {
             $logo = osc_get_preference('homeimagemobile3','wayst');
             $html = '<div class="hero_banner_slide105 center"><a href="'. osc_get_preference('hbanner-link6', 'wayst') . '"><img width="800" height="320" class="img-responsive" border="0" src="' . osc_current_web_theme_url('images/homeimagemobile3.jpg') . '"></a></div>';
             if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile3.jpg" ) ) {
                return $html;
             } else if( osc_get_preference('homeimagemobile3', 'wayst') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile3.jpg")) ) {
			 return $html;
             } else {
                return false;
            }
        }
    }
	
	
	if( !function_exists('homepage3_image') ) {
        function homepage3_image() {
		$html = '<a class="navbar-brand visible-xs " href="'.osc_base_url().'"><img width="100" height="41" border="0" src="' . osc_current_web_theme_url('images/logo.jpg') . '" /></a>';
            if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
                return $html;
            } else if( osc_get_preference('default_logo', 'wayst') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/default-logo.png")) ) {
                return '<a class="navbar-brand visible-xs " href="'.osc_base_url().'"><img width="100" height="41" border="0" src="' . osc_current_web_theme_url('images/default-logo.png') . '" /></a>';
            } else {
                return '<a class="navbar-brand visible-xs " href="'.osc_base_url().'"><img width="100" height="41" border="0" src="' . osc_current_web_theme_url('images/default-logo.png') . '" /></a>';
            }
        }
    }
	
	/* favicon */
    if( !function_exists('wayst_favicon_url') ) {
        function wayst_favicon_url() {
            $logo = osc_get_preference('favicon','wayst');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
			else
			{
				return osc_current_web_theme_url('images/favicon.png'); 
			}
        }
    } 
	//end favicon
	
	
    /* logo */
    if( !function_exists('wayst_logo_url') ) {
        function wayst_logo_url() {
            $logo = osc_get_preference('logo','wayst');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
	//homeimage url
	if( !function_exists('wayst_homeimage_url') ) {
        function wayst_homeimage_url() {
            $logo = osc_get_preference('homeimage','wayst');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
	
	if( !function_exists('wayst_homeimageslider2_url') ) {
        function wayst_homeimageslider2_url() {
            $logo = osc_get_preference('homeimageslider2','wayst');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
	
	if( !function_exists('wayst_homeimageslider3_url') ) {
        function wayst_homeimageslider3_url() {
            $logo = osc_get_preference('homeimageslider3','wayst');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
	//homeimage url
	
	if( !function_exists('wayst_homeimagemobile_url') ) {
        function wayst_homeimagemobile_url() {
            $logo = osc_get_preference('homeimagemobile','wayst');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
	
	if( !function_exists('wayst_homeimagemobile2_url') ) {
        function wayst_homeimagemobile2_url() {
            $logo = osc_get_preference('homeimagemobile2','wayst');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
	
	if( !function_exists('wayst_homeimagemobile3_url') ) {
        function wayst_homeimagemobile3_url() {
            $logo = osc_get_preference('homeimagemobile3','wayst');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
	
	if( !function_exists('wayst_homeimagemobilelogo_url') ) {
        function wayst_homeimagemobilelogo_url() {
            $logo = osc_get_preference('homeimagemobilelogo','wayst');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
	
	
	
    if( !function_exists('wayst_draw_item') ) {
        function wayst_draw_item($class = false,$admin = false, $premium = false) {
            $filename = 'loop-single';
            if($premium){
                $filename .='-premium';
            }
            require WebThemes::newInstance()->getCurrentThemePath().$filename.'.php';
        }
    }
    if( !function_exists('wayst_show_as') ){
        function wayst_show_as(){

            $p_sShowAs    = Params::getParam('sShowAs');
            $aValidShowAsValues = array('list', 'gallery');
            if (!in_array($p_sShowAs, $aValidShowAsValues)) {
                $p_sShowAs = wayst_default_show_as();
            }

            return $p_sShowAs;
        }
    }
    if( !function_exists('wayst_default_show_as') ){
        function wayst_default_show_as(){
            return getPreference('defaultShowAs@all','wayst');
        }
    }
    if( !function_exists('wayst_default_location_show_as') ){
        function wayst_default_location_show_as(){
            return osc_get_preference('defaultLocationShowAs','wayst');
        }
    }
    if( !function_exists('wayst_draw_categories_list') ) {
        function wayst_draw_categories_list(){ ?>
        <?php if(!osc_is_home_page()){ echo '<div class="col_group hidden-xs">'; } ?>
         <?php
         //cell_3
        $total_categories   = osc_count_categories();
        $col1_max_cat       = ceil($total_categories/3);

         osc_goto_first_category();
         $i      = 0;

         while ( osc_has_categories() ) {
         ?>
        <?php
            if($i%$col1_max_cat == 0){
                if($i > 0) { echo '</div>'; }
                if($i == 0) {
                   echo '<div class="col_group hidden-xs"><div class="column">';
                } else {
                    echo '<div class="column">';
                }
            }
        ?>
        <ul>
             <li class="long">
             <hgroup id="< ? php echo $_slug; ? >">
              <?php if (function_exists('categoryIconActions')) { ?>
              <?php if(get_category_icon(osc_category_id())) { ?>
                    <span class="icon1"><img src="<?php echo get_category_icon(osc_category_id()); ?>" width="40" height="40" /> </span>
                     <?php } else { ?> <span class="icon1"><img src="<?php echo osc_current_web_theme_url('images/no-icon.png'); ?>" border="0" width="40" height="40" /> </span> <?php } ?><?php } ?>
                     
                      <?php if (function_exists('categoryIconActions')){get_category_icon(osc_category_id());} else { echo '<span class="icon1"><img src="' . osc_current_web_theme_url('images/no-icon.png') . '" border="0" width="40" height="40" /> </span>'; } ?>
             
                 <h2 class="text-bold">
                    <?php
                    $_slug      = osc_category_slug();
                    $_url       = osc_search_category_url();
                    $_name      = osc_category_name();
                    $_total_items = osc_category_total_items();
                    if ( osc_count_subcategories() > 0 ) { ?>
                    <?php } ?>
                    <?php if($_total_items > 0) { ?>
                    <a href="<?php echo $_url; ?>"><?php echo $_name ; ?> <br /><span>(<?php echo $_total_items ; ?>)</span></a> 
                    
                    <?php } else { ?>
                    <a href="#"><?php echo $_name ; ?> <br /><span>(<?php echo $_total_items ; ?>)</span></a>
                    
                    <?php } ?>
                 </h2></hgroup>
                 <?php if ( osc_count_subcategories() > 0 ) { ?>
                   <ul class="category_list">
                         <?php while ( osc_has_subcategories() ) { ?>
                             <li>
                             <?php if( osc_category_total_items() > 0 ) { ?>
                                 <a  href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?></a>
                             <?php } else { ?>
                                 <a  href="#"><?php echo osc_category_name() ; ?></a>
                             <?php } ?>
                             </li>
                         <?php } ?>
                   </ul>
                 <?php } ?>
             </li>
        </ul>
        <?php
                $i++;
            }
            echo '</div></div>';
        ?>
        <?php if(!osc_is_home_page()){ echo '</div>'; } ?>
        <?php
        }
    }
    if( !function_exists('wayst_search_number') ) {
        /**
          *
          * @return array
          */
        function wayst_search_number() {
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
    if( !function_exists('wayst_item_title') ) {
        function wayst_item_title() {
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
    if( !function_exists('wayst_item_description') ) {
        function wayst_item_description() {
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
            $lang['item_add']               = __('Publish a listing', 'wayst');
            $lang['item_edit']              = __('Edit your listing', 'wayst');
            $lang['item_send_friend']       = __('Send to a friend', 'wayst');
            $lang['item_contact']           = __('Contact publisher', 'wayst');
            $lang['search']                 = __('Search results', 'wayst');
            $lang['search_pattern']         = __('Search results: %s', 'wayst');
            $lang['user_dashboard']         = __('Dashboard', 'wayst');
            $lang['user_dashboard_profile'] = __("%s's profile", 'wayst');
            $lang['user_account']           = __('Account', 'wayst');
            $lang['user_items']             = __('Listings', 'wayst');
            $lang['user_alerts']            = __('Alerts', 'wayst');
            $lang['user_profile']           = __('Update account', 'wayst');
            $lang['user_change_email']      = __('Change email', 'wayst');
            $lang['user_change_username']   = __('Change username', 'wayst');
            $lang['user_change_password']   = __('Change password', 'wayst');
            $lang['login']                  = __('Login', 'wayst');
            $lang['login_recover']          = __('Recover password', 'wayst');
            $lang['login_forgot']           = __('Change password', 'wayst');
            $lang['register']               = __('Create a new account', 'wayst');
            $lang['contact']                = __('Contact', 'wayst');
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
                'name' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span> ' . __('Public Profile'),
                 'url' => osc_user_public_profile_url(),
               'class' => 'opt_publicprofile'
            );
			$options[] = array(
                'name'  => '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> ' . __('Dashboard', 'wayst'),
                'url'   => osc_user_profile_url(),
                'class' => 'opt_items'
            );
            $options[] = array(
                'name'  => '<span class="glyphicon glyphicon-file" aria-hidden="true"></span> ' . __('Listings', 'wayst'),
                'url'   => osc_user_list_items_url(),
                'class' => 'opt_items'
            );
            $options[] = array(
                'name' => '<span class="glyphicon glyphicon-bell" aria-hidden="true"></span> ' . __('Alerts', 'wayst'),
                'url' => osc_user_alerts_url(),
                'class' => 'opt_alerts'
            );
           
            $options[] = array(
                'name'  => '<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> ' . __('Change email', 'wayst'),
                'url'   => osc_change_user_email_url(),
                'class' => 'opt_change_email'
            );
            $options[] = array(
                'name'  => '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' . __('Change username', 'wayst'),
                'url'   => osc_change_user_username_url(),
                'class' => 'opt_change_username'
            );
            $options[] = array(
                'name'  => '<span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span> ' . __('Change password', 'wayst'),
                'url'   => osc_change_user_password_url(),
                'class' => 'opt_change_password'
            );
			$options[] = array(
                'name'  => '<span class="glyphicon glyphicon-off" aria-hidden="true"></span> ' . __('Logout', 'wayst'),
                'url'   => osc_user_logout_url(),
                'class' => 'opt_change_password'
            );
            $options[] = array(
                'name'  => '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ' . __('Delete account', 'wayst'),
                'url'   => '#',
                'class' => 'opt_delete_account'
            );

            return $options;
        }
    }
	
	if( !function_exists('get_user_menu2') ) {
        function get_user_menu2() {
            $options   = array();
            $options[] = array(
                'name' => '<i class="fa fa-user text-aqua"></i> <span>' . __('Public Profile'), '</span>',
                 'url' => osc_user_public_profile_url(),
               'class' => 'opt_publicprofile'
            );
			$options[] = array(
                'name'  => '<i class="fa fa-cogs text-aqua"></i> <span>' . __('Dashboard', 'wayst'), '</span>',
                'url'   => osc_user_profile_url(),
                'class' => 'opt_items'
            );
            $options[] = array(
                'name'  => '<i class="fa fa-file text-aqua"></i> <span>' . __('Listings', 'wayst'), '</span>',
                'url'   => osc_user_list_items_url(),
                'class' => 'opt_items'
            );
            $options[] = array(
                'name' => '<i class="fa fa-bell text-yellow"></i> <span>' . __('Alerts', 'wayst'), '</span>',
                'url' => osc_user_alerts_url(),
                'class' => 'opt_alerts'
            );
           
            $options[] = array(
                'name'  => '<i class="fa fa-envelope text-aqua"></i> <span>' . __('Change email', 'wayst'), '</span>',
                'url'   => osc_change_user_email_url(),
                'class' => 'opt_change_email'
            );
            $options[] = array(
                'name'  => '<i class="fa fa-smile-o text-aqua"></i> <span>' . __('Change username', 'wayst'), '</span>',
                'url'   => osc_change_user_username_url(),
                'class' => 'opt_change_username'
            );
            $options[] = array(
                'name'  => '<i class="fa fa-ellipsis-h text-aqua"></i> <span>' . __('Change password', 'wayst'), '</span>',
                'url'   => osc_change_user_password_url(),
                'class' => 'opt_change_password'
            );
			$options[] = array(
                'name'  => '<i class="fa fa-sign-out text-aqua"></i> <span>' . __('Logout', 'wayst'), '</span>',
                'url'   => osc_user_logout_url(),
                'class' => 'opt_change_password'
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
    wayst.user = {};
    wayst.user.id = '<?php echo osc_user_id(); ?>';
    wayst.user.secret = '<?php echo osc_user_field("s_secret"); ?>';
</script>
            <?php }
        }
        osc_add_hook('header', 'user_info_js');
    }

    function theme_wayst_actions_admin() {
        //if(OC_ADMIN)
        if( Params::getParam('file') == 'oc-content/themes/wayst/admin/settings.php' ) {
            if( Params::getParam('donation') == 'successful' ) {
                osc_set_preference('donation', '1', 'wayst');
                osc_reset_preferences();
            }
        }

 switch( Params::getParam('action_specific1') ) {
            case('settings1'):
			osc_set_preference('hbanner-link1',       trim(Params::getParam('hbanner-link1', false, false, false)),                'wayst');
			
			 osc_add_flash_ok_message(__('Theme settings updated correctly', 'wayst'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;
			}
			switch( Params::getParam('action_specific2') ) {
            case('settings2'):
			osc_set_preference('hbanner-link2',       trim(Params::getParam('hbanner-link2', false, false, false)),                'wayst');
			
			 osc_add_flash_ok_message(__('Theme settings updated correctly', 'wayst'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;
			}
			switch( Params::getParam('action_specific3') ) {
            case('settings3'):
			osc_set_preference('hbanner-link3',       trim(Params::getParam('hbanner-link3', false, false, false)),                'wayst');
			
			 osc_add_flash_ok_message(__('Theme settings updated correctly', 'wayst'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;
			}
			switch( Params::getParam('action_specific4') ) {
            case('settings4'):
			osc_set_preference('hbanner-link4',       trim(Params::getParam('hbanner-link4', false, false, false)),                'wayst');
			
			 osc_add_flash_ok_message(__('Theme settings updated correctly', 'wayst'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;
			}
			switch( Params::getParam('action_specific5') ) {
            case('settings5'):
			osc_set_preference('hbanner-link5',       trim(Params::getParam('hbanner-link5', false, false, false)),                'wayst');
			
			 osc_add_flash_ok_message(__('Theme settings updated correctly', 'wayst'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;
			}
			switch( Params::getParam('action_specific6') ) {
            case('settings6'):
			osc_set_preference('hbanner-link6',       trim(Params::getParam('hbanner-link6', false, false, false)),                'wayst');
			
			 osc_add_flash_ok_message(__('Theme settings updated correctly', 'wayst'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;
			}
			
			switch( Params::getParam('action_specific7') ) {
            case('settings7'):
			osc_set_preference('favicon2',       trim(Params::getParam('favicon2', false, false, false)),                'wayst');
			
			 osc_add_flash_ok_message(__('Theme settings updated correctly', 'wayst'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/header.php'));
            break;
			}
			
        switch( Params::getParam('action_specific') ) {
            case('settings'):
                $footerLink  = Params::getParam('footer_link');

                osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'wayst');
                osc_set_preference('footer_link', ($footerLink ? '1' : '0'), 'wayst');
                osc_set_preference('defaultShowAs@all', Params::getParam('defaultShowAs@all'), 'wayst');
                osc_set_preference('defaultShowAs@search', Params::getParam('defaultShowAs@all'));

                osc_set_preference('defaultLocationShowAs', Params::getParam('defaultLocationShowAs'), 'wayst');
				
				osc_set_preference('contact-text',       trim(Params::getParam('contact-text', false, false, false)),                'wayst');
				osc_set_preference('help-text',       trim(Params::getParam('help-text', false, false, false)),                'wayst');
                
				osc_set_preference('facebook-top',         trim(Params::getParam('facebook-top', false, false, false)),                  'wayst');
				osc_set_preference('twitter-top',         trim(Params::getParam('twitter-top', false, false, false)),                  'wayst');
				osc_set_preference('google-plus-top',         trim(Params::getParam('google-plus-top', false, false, false)),                  'wayst');
				osc_set_preference('youtube-top',         trim(Params::getParam('youtube-top', false, false, false)),                  'wayst');
				osc_set_preference('skype-top',         trim(Params::getParam('skype-top', false, false, false)),                  'wayst');
				osc_set_preference('email-top',         trim(Params::getParam('email-top', false, false, false)),                  'wayst');
                osc_set_preference('header-728x90',         trim(Params::getParam('header-728x90', false, false, false)),                  'wayst');
                osc_set_preference('homepage-728x90',       trim(Params::getParam('homepage-728x90', false, false, false)),                'wayst');
                osc_set_preference('sidebar-300x250',       trim(Params::getParam('sidebar-300x250', false, false, false)),                'wayst');
                osc_set_preference('search-results-top-728x90',     trim(Params::getParam('search-results-top-728x90', false, false, false)),          'wayst');
                osc_set_preference('search-results-middle-728x90',  trim(Params::getParam('search-results-middle-728x90', false, false, false)),       'wayst');
				osc_set_preference('homepage-block1',         trim(Params::getParam('homepage-block1', false, false, false)),                  'wayst');
				osc_set_preference('homepage-block1l',         trim(Params::getParam('homepage-block1l', false, false, false)),                  'wayst');
				osc_set_preference('homepage-block2',         trim(Params::getParam('homepage-block2', false, false, false)),                  'wayst');
				osc_set_preference('homepage-block2l',         trim(Params::getParam('homepage-block2l', false, false, false)),                  'wayst');
				osc_set_preference('homepage-block3',         trim(Params::getParam('homepage-block3', false, false, false)),                  'wayst');
				osc_set_preference('homepage-block3l',         trim(Params::getParam('homepage-block3l', false, false, false)),                  'wayst');
				osc_set_preference('homepage-block4',         trim(Params::getParam('homepage-block4', false, false, false)),                  'wayst');
				osc_set_preference('homepage-block5',         trim(Params::getParam('homepage-block5', false, false, false)),                  'wayst');
				osc_set_preference('homepage-block6',         trim(Params::getParam('homepage-block6', false, false, false)),                  'wayst');
				osc_set_preference('footer-partners',         trim(Params::getParam('footer-partners', false, false, false)),                  'wayst');
				osc_set_preference('footer-partners1',         trim(Params::getParam('footer-partners1', false, false, false)),                  'wayst');
				osc_set_preference('footer-partners2',         trim(Params::getParam('footer-partners2', false, false, false)),                  'wayst');
				osc_set_preference('footer-partners3',         trim(Params::getParam('footer-partners3', false, false, false)),                  'wayst');
				osc_set_preference('footer-partners4',         trim(Params::getParam('footer-partners4', false, false, false)),                  'wayst');
				osc_set_preference('footer-partners5',         trim(Params::getParam('footer-partners5', false, false, false)),                  'wayst');
				osc_set_preference('footer-partners6',         trim(Params::getParam('footer-partners6', false, false, false)),                  'wayst');
				osc_set_preference('footer-partnersl1',         trim(Params::getParam('footer-partnersl1', false, false, false)),                  'wayst');
				osc_set_preference('footer-partnersl2',         trim(Params::getParam('footer-partnersl2', false, false, false)),                  'wayst');
				osc_set_preference('footer-partnersl3',         trim(Params::getParam('footer-partnersl3', false, false, false)),                  'wayst');
				osc_set_preference('footer-partnersl4',         trim(Params::getParam('footer-partnersl4', false, false, false)),                  'wayst');
				osc_set_preference('footer-partnersl5',         trim(Params::getParam('footer-partnersl5', false, false, false)),                  'wayst');
				osc_set_preference('footer-partnersl6',         trim(Params::getParam('footer-partnersl6', false, false, false)),                  'wayst');
				
				osc_set_preference('slidercatname1',       trim(Params::getParam('slidercatname1', false, false, false)),                'wayst');
				osc_set_preference('slidercatname2',       trim(Params::getParam('slidercatname2', false, false, false)),                'wayst');
				osc_set_preference('slidercatname3',       trim(Params::getParam('slidercatname3', false, false, false)),                'wayst');
				osc_set_preference('slidercatname1m',       trim(Params::getParam('slidercatname1m', false, false, false)),                'wayst');
				osc_set_preference('slidercatname2m',       trim(Params::getParam('slidercatname2m', false, false, false)),                'wayst');
				osc_set_preference('slidercatname3m',       trim(Params::getParam('slidercatname3m', false, false, false)),                'wayst');
				
				
                osc_add_flash_ok_message(__('Theme settings updated correctly', 'wayst'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
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

                    osc_set_preference('favicon', $logo_name, 'wayst');

                    osc_add_flash_ok_message(__('The favicon image has been uploaded correctly', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php#favicon'));
            break;
			
            case('upload_logo'):
                $package = Params::getFiles('logo');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
                        osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'wayst'), 'admin');
                    } else {
                        osc_add_flash_error_message(__("An error has occurred, please try again", 'wayst'), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'wayst'), 'admin');
                }
                header('Location: ' . osc_admin_render_theme_url('oc-content/themes/wayst/admin/header.php')); exit;
            break;
			
			case('remove_favicon'):
                $logo = osc_get_preference('favicon','wayst');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('favicon','wayst');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The favicon image has been removed', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php#favicon'));
            break;
			
            case('remove'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
                    @unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" );
                    osc_add_flash_ok_message(__('The logo image has been removed', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'wayst'), 'admin');
                }
                header('Location: ' . osc_admin_render_theme_url('oc-content/themes/wayst/admin/header.php')); exit;
            break;
			
        case('upload_homeimage'):
                $package = Params::getFiles('homeimage');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'homeimage';
                    $logo_name    .= '.'.$ext;
                    $path = move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage1.jpg" ) ;
                    $img->saveToFile($path);

                    osc_set_preference('homeimage', $logo_name, 'wayst');

                    osc_add_flash_ok_message(__('The banner image has been uploaded correctly', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php#banner'));
            break;  
			case('remove_homeimage'):
                $logo = osc_get_preference('homeimage','wayst');
                $path = (WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage1.jpg" );
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('homeimage','wayst');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The banner image has been removed', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php#banner'));
            break;
		
       
	   	   case('upload_homeimageslider2'):
                $package = Params::getFiles('homeimageslider2');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'homeimageslider2';
                    $logo_name    .= '.'.$ext;
                    $path = move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage2.jpg" ) ;
                    $img->saveToFile($path);

                    osc_set_preference('homeimageslider2', $logo_name, 'wayst');

                    osc_add_flash_ok_message(__('The banner image has been uploaded correctly', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;  
			case('remove_homeimageslider2'):
                $logo = osc_get_preference('homeimageslider2','wayst');
                $path = (WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage2.jpg" );
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('homeimageslider2','wayst');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The banner image has been removed', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;
			
			
			case('upload_homeimageslider3'):
                $package = Params::getFiles('homeimageslider3');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'homeimageslider3';
                    $logo_name    .= '.'.$ext;
                    $path = move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage3.jpg" ) ;
                    $img->saveToFile($path);

                    osc_set_preference('homeimageslider3', $logo_name, 'wayst');

                    osc_add_flash_ok_message(__('The banner image has been uploaded correctly', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;  
			case('remove_homeimageslider3'):
                $logo = osc_get_preference('homeimageslider3','wayst');
                $path = (WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage3.jpg" );
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('homeimageslider3','wayst');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The banner image has been removed', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;
	   
	
	//homeimagemobile
	case('upload_homeimagemobile'):
                $package = Params::getFiles('homeimagemobile');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'homeimagemobile';
                    $logo_name    .= '.'.$ext;
                    $path = move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile1.jpg" ) ;
                    $img->saveToFile($path);

                    osc_set_preference('homeimagemobile', $logo_name, 'wayst');

                    osc_add_flash_ok_message(__('The banner image has been uploaded correctly', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php#banner'));
            break;  
			case('remove_homeimagemobile'):
                $logo = osc_get_preference('homeimagemobile','wayst');
                $path = (WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile1.jpg" );
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('homeimagemobile','wayst');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The banner image has been removed', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php#banner'));
            break;
			
			
			case('upload_homeimagemobile2'):
                $package = Params::getFiles('homeimagemobile2');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'homeimagemobile2';
                    $logo_name    .= '.'.$ext;
                    $path = move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile2.jpg" ) ;
                    $img->saveToFile($path);

                    osc_set_preference('homeimagemobile2', $logo_name, 'wayst');

                    osc_add_flash_ok_message(__('The banner image has been uploaded correctly', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;  
			case('remove_homeimagemobile2'):
                $logo = osc_get_preference('homeimagemobile2','wayst');
                $path = (WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile2.jpg" );
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('homeimagemobile2','wayst');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The banner image has been removed', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php#banner'));
            break;
			
			
			case('upload_homeimagemobile3'):
                $package = Params::getFiles('homeimagemobile3');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'homeimagemobile3';
                    $logo_name    .= '.'.$ext;
                    $path = move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile3.jpg" ) ;
                    $img->saveToFile($path);

                    osc_set_preference('homeimagemobile3', $logo_name, 'wayst');

                    osc_add_flash_ok_message(__('The banner image has been uploaded correctly', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;  
			case('remove_homeimagemobile3'):
                $logo = osc_get_preference('homeimagemobile3','wayst');
                $path = (WebThemes::newInstance()->getCurrentThemePath() . "images/homeimagemobile3.jpg" );
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('homeimagemobile3','wayst');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The banner image has been removed', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'));
            break;
			
			
			case('upload_homeimagemobilelogo'):
                $package = Params::getFiles('homeimagemobilelogo');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'homeimagemobilelogo';
                    $logo_name    .= '.'.$ext;
                    $path = osc_uploads_path() . $logo_name ;
                    $img->saveToFile($path);

                    osc_set_preference('homeimagemobilelogo', $logo_name, 'wayst');

                    osc_add_flash_ok_message(__('The banner image has been uploaded correctly', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/header.php'));
            break;  
			case('remove_homeimagemobilelogo'):
                $logo = osc_get_preference('homeimagemobilelogo','wayst');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('homeimagemobilelogo','wayst');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The banner image has been removed', 'wayst'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'wayst'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/wayst/admin/header.php'));
            break;
		
        }
    }
	//end homeimagemobile
	

    function wayst_redirect_user_dashboard()
    {
        if( (Rewrite::newInstance()->get_location() === 'user') && (Rewrite::newInstance()->get_section() === 'dashboard') ) {
            header('Location: ' .osc_user_list_items_url());
            exit;
        }
    }

    function wayst_delete() {
        Preference::newInstance()->delete(array('s_section' => 'wayst'));
    }

    osc_add_hook('init', 'wayst_redirect_user_dashboard', 2);
    osc_add_hook('init_admin', 'theme_wayst_actions_admin');
    osc_add_hook('theme_delete_wayst', 'wayst_delete');
    osc_admin_menu_appearance(__('Header logo', 'wayst'), osc_admin_render_theme_url('oc-content/themes/wayst/admin/header.php'), 'header_wayst');
    osc_admin_menu_appearance(__('Theme settings', 'wayst'), osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'), 'settings_wayst');
	osc_admin_menu_appearance(__('Documentation', 'wayst'), osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'), 'wayst');
	
/**

TRIGGER FUNCTIONS

*/
check_install_wayst_theme();
if(osc_is_home_page()){
    osc_add_hook('inside-main','wayst_draw_categories_list');
} else if( osc_is_static_page() || osc_is_contact_page() ){
    osc_add_hook('before-content','wayst_draw_categories_list');
}

if(osc_is_home_page() || osc_is_search_page()){
    wayst_add_body_class('has-searchbox');
}


function wayst_sidebar_category_search($catId = null)
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

    wayst_print_sidebar_category_search($aCategories, $catId);
}

function wayst_print_sidebar_category_search($aCategories, $current_category = null, $i = 0)
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
            echo '<li><span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span><a class="text-bold" href="'.osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))).'">'.__('All categories', 'wayst')."</a></li>";
        }
        foreach($c as $key => $value) {
    ?>
            <li><a class="text-bold" id="cat_<?php echo osc_esc_html($value['pk_i_id']);?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=> $value['pk_i_id'], 'iPage'=>null))); ?>"><span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span><?php if(isset($current_category) && $current_category == $value['pk_i_id']){ echo '<strong>'.$value['s_name'].'</strong>'; }
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
        <li><a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))); ?>"><?php _e('All categories', 'wayst'); ?></a></li>
        <?php } ?>
            <li>
                <a id="cat_<?php echo osc_esc_html($c['pk_i_id']);?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=> $c['pk_i_id'], 'iPage'=>null))); ?>">
                <?php if(isset($current_category) && $current_category == $c['pk_i_id']){ echo '<strong>'.$c['s_name'].'</strong>'; }
                      else{ echo $c['s_name']; } ?>
                </a>
                <?php wayst_print_sidebar_category_search($aCategories, $current_category, $i); ?>
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
class waystBodyClass
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
        $logo = osc_get_preference('logo', 'wayst');
        if ($logo != '' && file_exists(osc_uploads_path() . $logo)) {
            $path = str_replace(ABS_PATH, '', osc_uploads_path() . '/');
            return osc_base_url() . $path . $item;
        }
    }
}

/*

    ads  SEARCH

 */
if (!function_exists('search_ads_listing_top_fn')) {
    function search_ads_listing_top_fn() {
        if(osc_get_preference('search-results-top-728x90', 'wayst')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_728">' . PHP_EOL;
            echo osc_get_preference('search-results-top-728x90', 'wayst');
            echo '</div>' . PHP_EOL;
        }
    }
}
//osc_add_hook('search_ads_listing_top', 'search_ads_listing_top_fn');

if (!function_exists('search_ads_listing_medium_fn')) {
    function search_ads_listing_medium_fn() {
        if(osc_get_preference('search-results-middle-728x90', 'wayst')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_728">' . PHP_EOL;
            echo osc_get_preference('search-results-middle-728x90', 'wayst');
            echo '</div>' . PHP_EOL;
        }
    }
}
osc_add_hook('search_ads_listing_medium', 'search_ads_listing_medium_fn');


/* categories customized */
	if( !function_exists('get_categoriesHierarchy') ) {
        function get_categoriesHierarchy( ) {
            $location = Rewrite::newInstance()->get_location() ;
            $section  = Rewrite::newInstance()->get_section() ;
            
            if ( $location != 'search' ) {
                return false ;
            }
            
            $category_id = osc_search_category_id() ;
            
            if(count($category_id) == 0) {
                return false;
            }
            
            $category_id = (int) $category_id[0] ;
            
            $categoriesHierarchy = Category::newInstance()->hierarchy($category_id) ;
            
            foreach($categoriesHierarchy as &$category) {
                $category['url'] = get_category_url($category) ;
            }
            
            return $categoriesHierarchy ;
         }
     }
     
     if( !function_exists('get_subcategories') ) {
         function get_subcategories( ) {
             $location = Rewrite::newInstance()->get_location() ;
             $section  = Rewrite::newInstance()->get_section() ;
            
             if ( $location != 'search' ) {
                 return false ;
             }
            
             $category_id = osc_search_category_id() ;
            
             if(count($category_id) > 1) {
                 return false ;
             }
            
             $category_id = (int) $category_id[0] ;
            
             $subCategories = Category::newInstance()->findSubcategories($category_id) ;
            
             foreach($subCategories as &$category) {
                 $category['url'] = get_category_url($category) ;
             }
            
             return $subCategories ;
         }
     }

     if ( !function_exists('get_category_url') ) {
         function get_category_url( $category ) {
             $path = '';
             if ( osc_rewrite_enabled() ) {
                if ($category != '') {
                    $category = Category::newInstance()->hierarchy($category['pk_i_id']) ;
                    $sanitized_category = "" ;
                    for ($i = count($category); $i > 0; $i--) {
                        $sanitized_category .= $category[$i - 1]['s_slug'] . '/' ;
                    }
                    $path = osc_base_url() . $sanitized_category ;
                }
            } else {
                $path = sprintf( osc_base_url(true) . '?page=search&sCategory=%d', $category['pk_i_id'] ) ;
            }
            
            return $path;
         }
     }
     
     if ( !function_exists('get_category_num_items') ) {
         function get_category_num_items( $category ) {
            $category_stats = CategoryStats::newInstance()->countItemsFromCategory($category['pk_i_id']) ;
            
            if( empty($category_stats) ) {
                return 0 ;
            }
            
            return $category_stats;
         }
     }
	/* end categories customized */
	
	if (wayst_is_fineuploader()) {
    if (!OC_ADMIN) {
        osc_enqueue_style('fine-uploader-css', osc_assets_url('js/fineuploader/fineuploader.css'));
    }
    osc_enqueue_script('jquery-fineuploader');
}

function wayst_is_fineuploader() {
    return Scripts::newInstance()->registered['jquery-fineuploader'] && method_exists('ItemForm', 'ajax_photos');
}

//add favicon
osc_add_hook('wayst_head', 'wayst_favicon');

?>
