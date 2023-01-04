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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('common/head.php') ; ?>
    </head>
    <nav class="navbar navbar-inverse">
            <div class="container"> 
                   <div class="navbar-header">
                    <div class="navbar-brand">
                        <?php echo logo_header(); ?>
                    </div>

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                      
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="navbar-collapse">

                    <ul class="nav navbar-nav" id="main-navbar">
                      <?php
                     while( osc_has_static_pages() ) { ?>
                    <li>
                      <a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a>
                    </li>
                   <?php
                   }
                   osc_reset_static_pages();
                   ?>
                 </ul>
                </div>
            </div>
             <div class="pull-right">
              <ul class="nav" id="right-navbar">
                  <?php if( osc_is_static_page() || osc_is_contact_page() ){ ?>
                  <?php } ?>
                  <?php if( osc_users_enabled() ) { ?>
                  <?php if( osc_is_web_user_logged_in() ) { ?>
                     <li class="first-logged">
                         <span><?php echo sprintf(__('Hi %s', 'sakela'), osc_logged_user_name() . '!'); ?>  &middot;</span>
                         <strong><a href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My account', 'sakela'); ?></a></strong> &middot;
                         <a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'sakela'); ?></a>
                     </li>
                  <?php } else { ?>
                     <li><a id="login_open" href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'sakela') ; ?></a></li>
                     <?php if(osc_user_registration_enabled()) { ?>
                         <li><a href="<?php echo osc_register_account_url() ; ?>"><?php _e('Register for a free account', 'sakela'); ?></a></li>
                     <?php }; ?>
                 <?php } ?>
                 <?php } ?>
                 <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
                 <li class="publish"><a href="<?php echo osc_item_post_url_in_category() ; ?>"><?php _e("Publish your ad for free", 'sakela');?></a> </li>
                 <?php } ?>             
             </ul>
            </div>
    </nav>
<body <?php sakela_body_class(); ?>>
<?php if( osc_is_home_page() ) { ?>
<div id="header">
    <div class="clear"></div>
 
<div class="container"> 
    <div class="row">
        <h1 class="heading"><?php _e('What are you looking for?', 'sakela') ; ?></h1>
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2" id="header-col">
    <?php if( osc_is_home_page() || osc_is_static_page() || osc_is_contact_page() ) { ?>
    <form action="<?php echo osc_base_url(true); ?>" method="get" class="search nocsrf" <?php /* onsubmit="javascript:return doSearch();"*/ ?>>       
        <input type="hidden" name="page" value="search"/> 
            <div class="cell">
                <input type="text" name="sPattern" id="query" class="input-text" value="" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'sakela'), 'sakela')); ?>" />
            </div>
            <div id="cells">
            <?php  if ( osc_count_categories() ) { ?>
                <div class="cell selector" id="cell1">
                  <span class="glyphicon glyphicon-chevron-down"></span><?php sakela_countries_select('sCountry', 'sCountry', __('Select a country', 'sakela'));?>
                </div>
                <div class="cell selector" id="cell2">
                   <span class="glyphicon glyphicon-chevron-down"></span><?php osc_categories_select('sCategory', null, __('Select a category', 'sakela')) ; ?>
                </div>
            </div>
                <div class="cell reset-padding">
            <?php  } else { ?>
                <div class="cell">
            <?php  } ?>
                <button class="ui-button ui-button-big js-submit"><?php _e("Search", 'sakela');?></button>
            </div>
        </div>
        <div id="message-seach"></div>
    </form>
    <?php } ?>
</div></div>
 </div>   
</div>
<?php osc_show_widgets('header'); ?>
<nav class="nav navbar-default">
    <div class="container">
                <?php $_icons = unserialize(osc_get_preference('icons', 'sakela')) ;
                $_icons = (array)$_icons ;
                $_count = count(array_filter($_icons)) ;
                if ( $_count > 0 ) { ?>
                    <div class = "navbar-right">                               
                        <p><?php _e('Filters:', 'sakela') ; ?></p>
                        <?php if ( osc_count_categories() > 0 ) {
                            $i = 1 ;
                            while ( osc_has_categories() && $i <= 10 ) {
                                $_catid     = osc_category_id() ;
                                $_slug      = osc_category_slug() ;
                                $_url       = osc_search_category_url() ;
                                if ( !EMPTY ( $_icons[$_catid] ) ) { ?>
                                    <div class = "shadow" id = "profileicon">
                                        <a class = "icon <?php echo $_slug ; ?>" href = "<?php echo $_url ; ?>"><span><i class = "fa <?php echo osc_esc_html($_icons[$_catid]) ; ?>" ></i></span></a>
                                    </div>
                                <?php }
                                $i++ ;
                            }
                        } ?>                       
                    </div>
                <?php } ?>               
    </div>            
</nav> 
<?php } ?>
<!-- header ad 728x60-->
     <div class="ads_header">
    <?php echo osc_get_preference('header-728x90', 'sakela'); ?> </div> 
    <!-- /header ad 728x60-->

<div class="wrapper wrapper-flash">
    <?php
        $breadcrumb = osc_breadcrumb('&raquo;', false, get_breadcrumb_lang());
        if( $breadcrumb !== '') { ?>
        <div class="breadcrumb">
            <div class="col-lg-10 col-lg-offset-1" id="breadcrumb-col">
            <?php echo $breadcrumb; ?></div>
            <div class="clear"></div>
        </div>
    <?php
        }
    ?>
    <?php osc_show_flash_message(); ?></div>
<div class="wrapper" id="content">
  <div class="container">  
    <div id="main">
        <?php osc_run_hook('inside-main'); ?>
