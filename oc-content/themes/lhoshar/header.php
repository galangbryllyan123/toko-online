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
<body <?php lhoshar_body_class(); ?>>
<?php if ( osc_is_home_page() ) { ?>
<div id="navbar" class="navbar-fixed-top">
  <?php } else { ?>
  <div id="navbar">
  <?php } ?>
  <div class="clear"></div>
    <div class="wrapper">
      <nav class="navbar navbar-default"> 
       <div class="top_links">
    <div class="container">
      <ul class="nav">
        <div class="dropdown" id="language-dropdown"> 
      <div class="language">
        <?php ?>
        <?php if ( osc_count_web_enabled_locales() > 1) { ?>
        <?php osc_goto_first_locale(); ?>
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
        <?php _e('Language:', 'lhoshar'); ?>
        <span>
        <?php $local = osc_get_current_user_locale(); echo $local['s_name']; ?>
        <i class="fa fa-caret-down"></i></span></button>
        <ul class="dropdown-menu">
          <?php $i = 0;  ?>
          <?php while ( osc_has_web_enabled_locales() ) { ?>
          <li>
            <?php if( osc_locale_code() ) { ?><img src="<?php echo osc_current_web_theme_url('images/flags/'. osc_locale_code() .'.png') ; ?>" style = "height: 20px; width: 20px; margin-top: 6px;" /><?php } ?>
            <a <?php if(osc_locale_code() == osc_current_user_locale() ) echo "class=active"; ?> id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a>
          </li>
          <?php if( $i == 0 ) { echo ""; } ?>
          <?php $i++; ?>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
     </div>
            <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
            <li class="publish"><a href="<?php echo osc_item_post_url_in_category() ; ?>"><?php _e("Publish your ad for free", 'lhoshar');?></a></li>
            <?php } ?>
            <?php if( osc_users_enabled() ) { ?>
            <?php if( osc_is_web_user_logged_in() ) { ?>
                <li class="first logged">
                    <span><?php echo sprintf(__('Hi %s', 'lhoshar'), osc_logged_user_name() . '!'); ?>  &middot;</span>
                    <strong><a href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My account', 'lhoshar'); ?></a></strong>
                    <a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'lhoshar'); ?></a>
                </li>
            <?php } else { ?>
                <li class="login"><a id="login_open" href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'lhoshar') ; ?></a></li>
                <?php if(osc_user_registration_enabled()) { ?>
                    <li class="register"><a href="<?php echo osc_register_account_url() ; ?>"><?php _e('Register', 'lhoshar'); ?></a></li>
                <?php }; ?>
            <?php } ?>
            <?php } ?>  
        </ul>
    </div>
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
                 </ul>
                </div>
            </div>
      </nav>           
    </div>
</div>

<?php if ( osc_is_home_page() ) { 
   if ( lhoshar_default_show_as_home() == 'slider' ) { 
    if ( osc_get_preference('slider_option', 'lhoshar') == 'slide' ) { ?>
      <div id="boot-slide" class="carousel slide" data-ride="carousel">
    <?php } else if ( osc_get_preference('slider_option', 'lhoshar') == 'fade' ) { ?>
      <div id="boot-slide" class="carousel slide carousel-fade" data-ride="carousel">
    <?php } ?>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <?php $slider = (array)unserialize(osc_get_preference('slider', 'lhoshar')) ;$count = 0 ; ?>    
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
                  <p><?php echo osc_highlight( osc_esc_html($slider['paragraph'][$key]), 100 )?></p>
                <?php }?><hr id="hr-one">

                <?php if(osc_esc_html($slider['button_text'][$key])){?>
                  <a href="<?php echo osc_esc_html($slider['button_url'][$key])?>" target="_blank"><?php echo osc_esc_html($slider['button_text'][$key])?></a>
                <?php }?>
                <hr id="hr-two">
              </div>
            </div>

            <?php $count++; } //if statement ends here?>

            <?php } //foreach statement ends here?>
            <?php } else { ?>
              <div class="item <?php echo ($count == 0)?'active':''?>">
              <img src="<?php echo osc_current_web_theme_url('images/home-bg-2.jpg')?>" alt="">
              <div class="carousel-caption">

                <h1><?php echo osc_esc_html(osc_page_title())?></h1>

                  <p><?php echo osc_page_description()?></p>

                  <a href="<?php echo osc_search_url()?>"><?php _e('See all categories', 'lhoshar')?></a>

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

<div id="search-boxes">
  <div class="container" id="main-search-container">
    <div class="banner_none" id="form_vh_map">
    <form action="<?php echo osc_base_url(true); ?>" id="main_search" method="get" class="search nocsrf" >
        <input type="hidden" name="page" value="search"/>
        <div class="main-searches">
          <div class="form-filters">
            <div class="row" id="main-search-first-row">
              <?php $showCountry  = (osc_get_preference('show_search_country', 'lhoshar') == '1') ? true : false; ?>
              <div class="col-sm-4 col-md-4">
                <div class="cell">
                  <input type="text" name="sPattern" id="query" class="input-text" value="" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'lhoshar'), 'lhoshar')); ?>" />
                </div>
              </div>
              <?php if($showCountry) { ?>
              <div class="col-sm-3 col-md-3">
                <div class="cell selector">
                  <?php lhoshar_countries_select('sCountry', 'sCountry', __('Select a country', 'lhoshar'));?>
                </div>
              </div>
              <?php } ?>
              <div class="col-sm-3 col-md-3">
                <div class="cell selector">
                  <?php lhoshar_regions_select('sRegion', 'sRegion', __('Select a region', 'lhoshar')) ; ?>
                </div>
              </div>
              <div class="col-sm-2 col-md-2">
                <div class="cell selector">
                  <?php lhoshar_cities_select('sCity', 'sCity', __('Select a city', 'lhoshar')) ; ?>
                </div>
              </div>
              
            </div>
            <div class="row" id="main-search-second-row">
              <div class="col-sm-2 col-md-2">
                <div class="cell">
                  <select name="property_type" id="property_type">
                    <option value=""> <?php echo osc_esc_html(__('Select a type', 'lhoshar')); ?> </option>
                    <option value="FOR RENT"> <?php echo osc_esc_html(__('For rent', 'lhoshar')); ?> </option>
                    <option value="FOR SALE"> <?php echo osc_esc_html(__('For sale', 'lhoshar')); ?> </option>
                  </select>
                </div>
              </div>
              <?php
                $p_type = lhoshar_realEstate_propertyType();
                if($p_type){
                ?>
              <div class="col-sm-2 col-md-2">
                <div class="cell">
                  <select name="p_type" id="p_type">
                    <option value=""> <?php echo osc_esc_html(__('Select a property type', 'lhoshar')); ?> </option>
                    <?php foreach($p_type as $k => $v) { ?>
                    <option value="<?php echo  $k; ?>"><?php echo $v; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } ?>
              <div class="col-sm-2 col-md-2">
                <?php  if ( osc_count_categories() ) { ?>
                <div class="cell selector">
                  <?php osc_categories_select('sCategory', null, osc_esc_html(__('Select a category', 'lhoshar'))) ; ?>
                </div>
                <?php  } ?>
              </div>
              <div class="col-sm-3 col-md-3">
                <div class="cell">
                  <div class="row" id="price-range-row">
                    <div class="col-sm-6 col-md-6">
                      <input placeholder="<?php _e( "Min Price", "lhoshar" ) ; ?>" onkeypress='OsWizValidate(event)' class="input-text" type="text" id="priceMin" name="sPriceMin" size="12" maxlength="12" />
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <input placeholder="<?php _e( "Max Price", "lhoshar" ) ; ?>" onkeypress='OsWizValidate(event)' class="input-text" type="text" id="priceMax" name="sPriceMax" size="12" maxlength="12" />
                    </div>
                  </div>
                </div>
              </div>
              <?php if($p_type){ ?>
                <div class="col-sm-3 col-md-3">
              <?php } else { ?>
                <div class="col-sm-5 col-md-5">
              <?php } ?>
                <div class="row">
                  <div class="col-sm-6 col-md-6">
                    <div class="_space">
                      <div class="range_room">
                        <input type="number" id="rooms" name="rooms" placeholder="<?php _e( "Rooms", "lhoshar" ) ; ?>" min="0" max="15">
                      </div>
                      <div class="slider" >
                        <div id="room-range"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                    <div class="_space_range">
                      <div class="range_room">
                        <input type="number" id="bathrooms" name="bathrooms" placeholder="<?php _e( "Bathrooms", "lhoshar" ) ; ?>" min="0" max="15">
                      </div>
                      <div class="slider" >
                        <div id="bathroom-range"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <p><?php echo osc_esc_html( osc_get_preference('search_box_text_1_'.osc_current_user_locale(), 'lhoshar') ); ?></p>
              <p><?php echo osc_esc_html( osc_get_preference('search_box_text_2_'.osc_current_user_locale(), 'lhoshar') ); ?></p>
              <p><?php echo osc_esc_html( osc_get_preference('search_box_text_3_'.osc_current_user_locale(), 'lhoshar') ); ?></p>
            </div>
            
            
            <div class="row"><div class="col-sm-2 col-md-2">
                <div class="cell reset-padding">
                  <button  class="btn btn-success btn-lg"><i class="fa fa-search"></i> <span <?php echo ($showCountry)? '' : 'class="showLabel"'; ?>>
                  <?php _e("Search", 'lhoshar');?>
                  </span> </button>
                </div>
              </div></div>
          </div>
          <div id="message-seach"></div>
        </div>
    </form>
  </div>  
  <?php } ?>  
 </div> 
</div>

<?php osc_show_widgets('header'); ?>
<div class="wrapper wrapper-flash">
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
        }
    ?>
    <?php osc_show_flash_message(); ?>
</div>
<?php osc_run_hook('before-content'); ?>
<div class="wrapper" id="content">
  <div class="container">
    <?php if(osc_is_home_page() ){ ?>
<?php if( osc_get_preference('header-728x90', 'lhoshar') !=""){ ?>
<div class="ads_header ads-headers"> <?php echo osc_get_preference('header-728x90', 'lhoshar'); ?> </div>
<?php } ?>
<?php } ?>
    <div id="main">
        <?php osc_run_hook('inside-main'); ?>
        