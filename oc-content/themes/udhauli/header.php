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
<body <?php udhauli_body_class(); ?>>
  <div class="clear"></div>
    <nav class="navbar navbar-default"> 
          <div class="container">
             <?php if ( !EMPTY(osc_get_preference('contact_numbr', 'udhauli')) || !EMPTY(osc_get_preference('contact_email', 'udhauli')) ) { ?>
              <div class="contact-list navbar-left">
                <?php if ( !EMPTY(osc_get_preference('contact_numbr', 'udhauli')) ) { ?>
                  <i class = "fa fa-phone" ></i>Call Us Now: <?php _e(osc_get_preference('contact_numbr', 'udhauli')) ; ?><br>
                <?php } ?>
                <?php if ( !EMPTY(osc_get_preference('contact_email', 'udhauli')) ) { ?>
                  <i class = "fa fa-envelope-o" ></i>E-mail: <?php _e(osc_get_preference('contact_email', 'udhauli')) ; ?>
                <?php } ?>
              </div>  
             <?php } ?>    
            <ul class="nav navbar-nav navbar-right"> 
              <?php if( osc_users_enabled() ) { ?>
                <?php if( osc_is_web_user_logged_in() ) { ?>
                  <li class="first logged" style="display: inline-flex;" >
                      <a class="name"><?php echo sprintf(__('Hi %s', 'udhauli'), osc_logged_user_name() . '!'); ?></a>
                      <a href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My account', 'udhauli'); ?></a>
                      <a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'udhauli'); ?></a>
                  </li>
                <?php } else { ?>
                  <li class="register"><a href="<?php echo osc_register_account_url() ; ?>"><?php _e('Register', 'udhauli'); ?></a></li>
                  <li class="login"><a id="login_open" href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'udhauli') ; ?></a></li>
                <?php }; ?>
                  <?php if(osc_user_registration_enabled()) { ?>
              <?php } ?>
              <?php } ?> 
              <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
              <li class="publish"><a href="<?php echo osc_item_post_url_in_category() ; ?>"><?php _e("Publish your ad for free", 'udhauli');?></a></li>
              <?php } ?>
              <li class="language dropdown">
                  <?php ?>
                  <?php if ( osc_count_web_enabled_locales() > 1) { ?>
                  <?php osc_goto_first_locale(); ?>
                  <button class="btn btn-md" type="button" data-toggle="dropdown">
                  <?php _e('Language:', 'udhauli'); ?>
                  <span>
                  <?php $local = osc_get_current_user_locale(); echo $local['s_name']; ?>
                  <i class="fa fa-caret-down"></i></span></button>
                  <ul class="dropdown-menu">
                    <?php $i = 0;  ?>
                    <?php while ( osc_has_web_enabled_locales() ) { ?>
                    <li style="display: inline-flex;"><?php if( osc_locale_code() ) { ?><img src="<?php echo osc_current_web_theme_url('images/flags/'. osc_locale_code() .'.png') ; ?>" style = "height: 20px; width: 20px; margin-top: 5px;" /><?php } ?><a <?php if(osc_locale_code() == osc_current_user_locale() ) echo "class=active"; ?> id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a></li><br>
                    <?php if( $i == 0 ) { echo ""; } ?>
                    <?php $i++; ?>
                    <?php } ?>
                  </ul>
                  <?php } ?>
                </li> 
          </ul>
        </div>
    </nav>  

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
                   <li>
                       <a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'udhauli'); ?></a>
                   </li>
                 </ul>
                </div>
            </div>
      </nav>       

<?php if ( osc_is_home_page() ) { 
   if ( udhauli_default_show_as_home() == 'slider' ) { ?>
    <div id="boot-slide" class="carousel slide carousel-fade" data-ride="carousel">

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">

            <?php $slider = (array)unserialize(osc_get_preference('slider', 'udhauli')) ;$count = 0 ; ?>
            
            <?php if($slider['image'] && array_filter($slider['image'])) { ?>
            <?php foreach ($slider['image'] as $key => $slide) { ?>

            <?php if($slide){ ?>

            <div class="item <?php echo ($count == 0)?'active':''?>">
              <img src="<?php echo osc_uploads_url().$slide?>" alt="">
              <div class="carousel-caption">
                
                <?php if(osc_esc_html($slider['title'][$key])){?>
                <h1><?php echo osc_esc_html($slider['title'][$key])?></h1>
                <?php }?>

                <?php if(osc_esc_html($slider['paragraph'][$key])){?>
                  <p><?php echo osc_highlight( osc_esc_html($slider['paragraph'][$key]), 300 )?></p>
                <?php }?>

                <?php if(osc_esc_html($slider['button_text'][$key])){?>
                  <a href="<?php echo osc_esc_html($slider['button_url'][$key])?>" target="_blank"><?php echo osc_esc_html($slider['button_text'][$key])?></a>
                <?php }?>
              </div>
            </div>

            <?php $count++; } //if statement ends here?>

            <?php } //foreach statement ends here?>
            <?php } else { ?>
              <div class="item <?php echo ($count == 0)?'active':''?>">
              <img src="<?php echo osc_current_web_theme_url('images/car.jpeg')?>" alt="">
              <div class="carousel-caption">

                <h1><?php _e( 'Slider Image', 'udhauli' ) ; ?></h1>

                <a href="#"><?php _e('Button', 'udhauli') ; ?></a>

              </div>
            </div>
            <?php } ?>  
          </div>

          <!-- Controls -->
          <a class="left carousel-control" href="#boot-slide" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#boot-slide" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
    <?php } else {
        echo '<div id="header_map" class="banner_slider">' ;
        if ( homepage_image() ) {
          echo homepage_image() ; 
        }
        echo '</div>' ;
    } ?>

    <?php if( is_car_enabled() && udhauli_default_show_as_home() == 'slider' ) { ?>
    <div class="quick-search">
     <h1><?php _e('Search Your Car Model', 'udhauli'); ?></h1>
      <form action="<?php echo osc_base_url(true); ?>" id="car_search" method="get" class="search nocsrf" >
        <input type="hidden" name="page" value="search"/>
          <div class="row" id="main-search-second-row">
              <?php $p_make = udhauli_cars_vehiclesMake();
              if($p_make){ ?>
                <div class="col-xs-12">
                  <div class="cell">
                    <label class="control-label" for="make"><?php _e('MAKE', 'udhauli'); ?></label>
                      <select name="make" id="make_slider">
                        <option value=""> <?php echo osc_esc_html(__('Select a car make', 'udhauli')); ?> </option>
                        <?php foreach($p_make as $value) { ?>
                        <option make_ID="<?php echo $value['pk_i_id']; ?>" value="<?php echo $value['pk_i_id']; ?>"><?php echo $value['s_name']; ?></option>
                        <?php } ?>
                      </select>
                  </div>
                </div>
              <?php } ?>
      
              <div class="col-xs-12">
                <div class="cell">
                  <label class="control-label" for="model"><?php _e('MODEL', 'udhauli'); ?></label>
                  <select name="model" id="model_slider">
                    <?php udhauli_cars_vehiclesModel_options(); ?>
                  </select>
                </div>
              </div>
              
              <?php $p_type = udhauli_cars_vehiclesType();
              if($p_type){ ?>
                <div class="col-xs-12">
                  <div class="cell">
                    <label class="control-label" for="type"><?php _e('TYPE', 'udhauli'); ?></label>
                    <select name="type" id="type">
                      <option value=""> <?php echo osc_esc_html(__('Select a car type', 'udhauli')); ?> </option>
                      <?php foreach($p_type as $k => $v) { ?>
                        <option value="<?php echo  $k; ?>"><?php echo $v; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              <?php } ?> 

              <div class="col-xs-12">
                <div class="cell">
                  <?php $transmission = Params::getParam('transmission') ; ?>
                  <label class="control-label" for="transmission" style="margin-bottom: 15px;" ><?php _e('TRANSMISSION', 'udhauli'); ?></label><br>
                  <input style="width:20px;" type="radio" name="transmission" value="MANUAL" id="manual" <?php if($transmission == 'MANUAL') { echo 'checked="yes"'; } ?>/> <label for="manual"><?php _e('Manual', 'udhauli'); ?></label><br>
                  <input style="width:20px;" type="radio" name="transmission" value="AUTO" id="auto" <?php if($transmission == 'AUTO') { echo 'checked="yes"'; } ?>/> <label for="auto"><?php _e('Auto', 'udhauli'); ?></label>
                </div>
              </div>           
                
              <div class="cell reset-padding col-xs-12">
                <button  class="btn btn-md"><i class="fa fa-search"></i> <span>
                  <?php _e("Search", 'udhauli');?>
                </span> </button>
              </div>
          </div>
      </form>
    </div>
  <?php } ?>

<div id="search-boxes">
  <div class="container" id="main-search-container">
    <div class="banner_none" id="form_vh_map">
    <form action="<?php echo osc_base_url(true); ?>" id="main_search" method="get" class="search nocsrf" >
        <input type="hidden" name="page" value="search"/>
        <div class="main-searches">
          <div class="form-filters">
            <div class="row" id="main-search-first-row">
              <?php $showCountry  = (osc_get_preference('show_search_country', 'udhauli') == '1') ? true : false; ?>
              <div class="col-sm-4 col-md-4">
                <div class="cell">
                  <input type="text" name="sPattern" id="query" class="input-text" value="" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'udhauli'), 'udhauli')); ?>" />
                </div>
              </div>
              <?php if($showCountry) { ?>
              <div class="col-sm-3 col-md-3">
                <div class="cell selector">
                  <?php udhauli_countries_select('sCountry', 'sCountry', __('Select a country', 'udhauli'));?>
                </div>
              </div>
              <?php } ?>
              <div class="col-sm-3 col-md-3">
                <div class="cell selector">
                  <?php udhauli_regions_select('sRegion', 'sRegion', __('Select a region', 'udhauli')) ; ?>
                </div>
              </div>
              <div class="col-sm-2 col-md-2">
                <div class="cell selector">
                  <?php udhauli_cities_select('sCity', 'sCity', __('Select a city', 'udhauli')) ; ?>
                </div>
              </div>
              
            </div>

            <div class="row" id="main-search-second-row">
              <?php if( is_car_enabled() ){ ?>
              <?php
                $p_make = udhauli_cars_vehiclesMake();
                if($p_make){
                ?>
              <div class="col-md-3 col-sm-2">
                <div class="cell">
                  <select name="make" id="make_search">
                    <option value=""> <?php echo osc_esc_html(__('Select make', 'udhauli')); ?> </option>
                    <?php foreach($p_make as $value) { ?>
                    <option make_ID="<?php echo $value['pk_i_id']; ?>" value="<?php echo $value['pk_i_id']; ?>"><?php echo $value['s_name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } ?>
              
                <div class="col-md-3 col-sm-2">
                  <div class="cell">
                    <select name="model" id="model_search">
                      <?php udhauli_cars_vehiclesModel_options(); ?>
                    </select>
                  </div>
                </div>
              <?php
                $p_type = udhauli_cars_vehiclesType();
                if($p_type){
                ?>
              <div class="col-sm-2">
                <div class="cell">
                  <select name="type" id="type">
                    <option value=""> <?php echo osc_esc_html(__('Select type', 'udhauli')); ?> </option>
                    <?php foreach($p_type as $k => $v) { ?>
                    <option value="<?php echo  $k; ?>"><?php echo $v; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } ?>

              <div class="col-md-4 col-sm-6">
                <div class="cell transmission-cell">
                  <?php $transmission = Params::getParam('transmission') ; ?>
                  <label class="control-label" for="type"><?php _e('Transmission:', 'udhauli'); ?></label>
                  <input style="width:20px;" type="radio" name="transmission" value="MANUAL" id="manual" <?php if($transmission == 'MANUAL') { echo 'checked="yes"'; } ?>/> <label for="manual"><?php _e('Manual', 'udhauli'); ?></label>
                  <input style="width:20px;" type="radio" name="transmission" value="AUTO" id="auto" <?php if($transmission == 'AUTO') { echo 'checked="yes"'; } ?>/> <label for="auto"><?php _e('Auto', 'udhauli'); ?></label>
                </div>
              </div>
              <?php } ?>
            </div>

            <div class="row" id="main-search-third-row">
              <div class="col-sm-4">
                <?php  if ( osc_count_categories() ) { ?>
                <div class="cell selector">
                  <?php osc_categories_select('sCategory', null, osc_esc_html(__('Select a category', 'udhauli'))) ; ?>
                </div>
                <?php  } ?>
              </div>    
              
              <div class="col-sm-4">
                <div class="cell">
                  <div class="row" id="price-range-row">
                    <div class="col-sm-6">
                      <input placeholder="<?php _e( "Min Price", "udhauli" ) ; ?>" onkeypress='OsWizValidate(event)' class="input-text" type="text" id="priceMin" name="sPriceMin" size="12" maxlength="12" />
                    </div>
                    <div class="col-sm-6">
                      <input placeholder="<?php _e( "Max Price", "udhauli" ) ; ?>" onkeypress='OsWizValidate(event)' class="input-text" type="text" id="priceMax" name="sPriceMax" size="12" maxlength="12" />
                    </div>
                  </div>
                </div>
              </div> 

            <div class="col-sm-2">
                <div class="cell reset-padding">
                  <button  class="btn btn-md"><i class="fa fa-search"></i> <span <?php echo ($showCountry)? '' : 'class="showLabel"'; ?>>
                  <?php _e("Search", 'udhauli');?>
                  </span> </button>
                </div>
              </div>
          </div>
        </div>
          <div id="message-seach"></div>
        </div>
    </form>
  </div>  
  <?php } ?>  
 </div> 
</div>

<?php osc_show_widgets('header'); ?>
<div id="breadcrumb">
  <?php
    $breadcrumb = osc_breadcrumb('&raquo;', false, get_breadcrumb_lang());
    if( $breadcrumb !== '') { ?>
      <div class="breadcrumb">
        <div class="container">
          <?php echo $breadcrumb; ?>
          <div class="clear"></div>
        </div>  
      </div>
    <?php
    } ?>
  <?php osc_show_flash_message(); ?>
</div>
<?php osc_run_hook('before-content'); ?>
  <div class="container">
    <?php if(osc_is_home_page() ){ ?>
<?php if( osc_get_preference('header-728x90', 'udhauli') !=""){ ?>
<div class="ads_header ads-headers"> <?php echo osc_get_preference('header-728x90', 'udhauli'); ?> </div>
<?php } ?>
<?php } ?>
    <div id="content">
        <?php osc_run_hook('inside-main'); ?>
        