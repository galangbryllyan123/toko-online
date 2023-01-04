<!-- container -->
<div class="container">
  <?php if (strpos($_SERVER['HTTP_HOST'],'mb-themes') !== false) { ?>
    <div id="piracy" class="noselect" title="Click to hide this box">This theme is ownership of MB Themes and can be bought only on <a href="https://osclasspoint.com/graphic-themes/general/sofia-osclass-theme_i67">OsclassPoint.com</a>. When bought on other site, there is no support and updates provided. Do not support stealers, support developer!</div>
    <script>$(document).ready(function(){ $('#piracy').click(function(){ $(this).fadeOut(200); }); });</script>
  <?php } ?>
  <?php if(function_exists('scrolltop')) { scrolltop(); } ?>

  <!-- Header Start -->
  <div id="header">
    <a id="logo-480" href="<?php echo osc_base_url(); ?>"><?php echo logo_header(); ?></a>
    
    <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
      <div class="form_publish" id="pub_970">
        <div class="publish_button">
          <a href="<?php echo osc_item_post_url_in_category(); ?>">
            <?php _e('Publish your ad for free', 'sofia');?>
          </a>
        </div>
      </div>
    <?php } ?>  

    <div class="links-wrap">
      <div class="loc-select">
        <div class="mark round3">
          <i class="fa fa-map-marker"></i>
          <i class="fa fa-caret-left"></i>
        </div>

        <div class="h-my-loc round3">
          <i class="fa fa-caret-left"></i>
          <div class="font" rel="<?php _e('Location not saved', 'sofia'); ?>">
            <?php
              if(Params::getParam('sCountry' . radius_installed()) == '' and Params::getParam('sRegion' . radius_installed()) == '' and Params::getParam('sCity' . radius_installed()) == '') {
                _e('Location not saved', 'sofia');
              } else {
                $loc = array_filter(array(Params::getParam('sCountry' . radius_installed()), Params::getParam('sRegion' . radius_installed()), Params::getParam('sCity' . radius_installed())));
                $loc = trim(implode(', ', $loc));
                echo $loc;
                echo '<i class="fa fa-close clear-cookie-location"></i>';
              }
            ?>
          </div>
        </div>

        <div id="open-loc" class="loc-change round3">
          <a href="#"><i class="fa fa-external-link"></i><?php _e('Change location', 'sofia'); ?></a>
        </div>
      </div>

      <a id="logo" href="<?php echo osc_base_url(); ?>"><?php echo logo_header(); ?></a>

      <div class="head-links">
        <?php if(osc_users_enabled()) { ?>
          <?php if( osc_is_web_user_logged_in() ) { ?>
            <span class="is_logged"><?php echo sprintf(__('Hi %s', 'sofia'), osc_logged_user_name() . '!'); ?></span>
            <span class="top-dot">&middot;</span>
            
            <a href="<?php echo osc_user_dashboard_url(); ?>">
              <i class="fa fa-user"></i>
              <?php _e('My account', 'sofia'); ?>
            </a>
            <span class="top-dot">&middot;</span>
            
            <a href="<?php echo osc_user_logout_url(); ?>"><i class="fa fa-sign-out"></i><?php _e('Logout', 'sofia');?></a>
          <?php } else { ?>
            <a id="login_open" href="<?php echo osc_user_login_url(); ?>">
              <i class="fa fa-user"></i>
              <?php _e('Login', 'sofia'); ?>
            </a>
            
            <a id="login_open480" href="<?php echo osc_user_login_url(); ?>">
              <i class="fa fa-user"></i>
              <?php _e('Login', 'sofia'); ?>
            </a>
            
            <?php if(osc_user_registration_enabled()) { ?>
              <span class="top-dot">&middot;</span>
              <a href="<?php echo osc_register_account_url(); ?>">
                <i class="fa fa-pencil"></i>
                <?php _e('Register', 'sofia'); ?>
              </a>
            <?php } ?>
            
            <div id="login-wrap">
              <form id="login" action="<?php echo osc_base_url(true); ?>" method="post">
              <div class="close-wrap"></div>
              <h2><?php _e('Login', 'sofia'); ?></h2>
                <div class="del"></div>
                <fieldset>
                  <input type="hidden" name="page" value="login" />
                  <input type="hidden" name="action" value="login_post" />
                  
                  <label for="email"><?php _e('E-mail', 'sofia'); ?></label>
                  <?php UserForm::email_login_text(); ?>
                  <div class="clear"></div>
                  
                  <label for="password"><?php _e('Password', 'sofia'); ?></label>
                  <?php UserForm::password_login_text(); ?>
                  <p class="checkbox"><?php UserForm::rememberme_login_checkbox();?> <label for="rememberMe"><?php _e('Remember me', 'sofia'); ?></label></p>
                  <button type="submit"><?php _e('Log in', 'sofia'); ?></button>
                  <div class="forgot">
                    <a href="<?php echo osc_recover_user_password_url(); ?>"><?php _e("Forgot password?", 'sofia');?></a>
                  </div>
                </fieldset>
              </form>
            </div>
            
            <?php if(function_exists('fbc_button')) {?>
              <span class="top-dot">&middot;</span>
              <?php fbc_button(); ?>
            <?php } ?>
          <?php } ?>

          <?php if ( osc_count_web_enabled_locales() > 1) { ?>
            <?php osc_goto_first_locale(); ?>
            <span class="top-dot">&middot;</span>
            <div class="open-lang">
              <strong>
                <i class="fa fa-language"></i>&nbsp;<?php _e('Language', 'sofia'); ?>
              </strong>

              <ul class="round3">
                <?php $i = 0;  ?>
                <?php while ( osc_has_web_enabled_locales() ) { ?>
                  <li <?php if( $i == 0 ) { echo "class='first'"; } ?>>
                    <a id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url(osc_locale_code()); ?>">
                      <?php echo osc_locale_name(); ?>
                    </a>
                  </li>
                  <?php $i++; ?>
                <?php } ?>
              </ul>
            </div>            
          <?php } ?>
        <?php } ?>
      </div>

      <div id="loc-wrap">
        <div id="loc-list">
          <div class="close-wrap"></div>
          <a class="back-wrap"><div class="icon-add-back"></div><span><?php _e('Back', 'sofia'); ?></span></a>
      
          <h2><i class="fa fa-map-marker"></i><?php _e('Select a location', 'sofia'); ?></h2>

          <div class="loc-block">
            <?php while(osc_has_list_countries() ) { ?>

            <?php View::newInstance()->_exportVariableToView('list_regions', Search::newInstance()->listRegions(osc_list_country_code(), '>=') ); ?>
              <?php while(osc_has_list_regions()) { ?>
                <?php if (osc_list_region_items() > 0) { ?>
                  <div class="single-loc round3" id="<?php echo osc_list_region_id();?>">
                    <a href="#" title="<?php echo osc_esc_html(osc_list_region_name());?>" alt="<?php echo osc_esc_html(osc_list_region_name());?> - <?php echo osc_esc_html(osc_list_country_name());?>">
                      <h3><?php echo osc_list_region_name() . ' (' . osc_list_country_code() . ')';?></h3>
                    </a>
                  </div>
                <?php } ?>
              <?php } ?>
            <?php } ?>
          </div>
          
          <?php
            //Prepare fields for another use
            View::newInstance()->_erase('cities');
            View::newInstance()->_erase('regions');
            View::newInstance()->_erase('countries');
          ?>

          <?php while(osc_has_list_countries() ) { ?>

            <?php View::newInstance()->_exportVariableToView('list_regions', Search::newInstance()->listRegions(osc_list_country_code(), '>=') ); ?>
            <?php while(osc_has_list_regions()) { ?>
              <?php if (osc_list_region_items() > 0) { ?>
                <div class="subloc-list" id="sub-<?php echo osc_list_region_id();?>" style="display:none">
                  <div class="single-loc round3" id="<?php echo osc_list_region_id();?>">
                    <a href="<?php echo osc_list_region_url();?>" title="<?php echo osc_esc_html(osc_list_region_name());?>" alt="<?php echo osc_esc_html(osc_list_region_name());?>">
                      <h3><?php echo osc_list_region_name() . ' ' . __('in', 'sofia') . ' ' . osc_list_country_name();?></h3>
                    </a>
                  </div>

                  <?php View::newInstance()->_exportVariableToView('list_cities', Search::newInstance()->listCities(osc_list_region_id(), '>=') ) ; ?>
                  <?php while(osc_has_list_cities() ) { ?>
                    <?php if (osc_list_city_items() > 0) { ?>
                      <h3><a href="<?php echo osc_list_city_url();?>" class="single-subloc" id="<?php echo osc_list_city_id();?>"><?php echo osc_list_city_name();?></a></h3>
                    <?php } ?>
                  <?php } ?>
                </div>
              <?php } ?>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <!-- Header End -->
  
  <?php
    //Prepare fields for another use
    View::newInstance()->_erase('cities');
    View::newInstance()->_erase('regions');
    View::newInstance()->_erase('countries');
  ?>

  <div class="clear"></div>

  <!-- jQuery Menu Start -->
  <div class="search-bar-wrap">
    <?php if(function_exists('jquery_menu')) { jquery_menu(); } else { ?>
      <?php $search_params = sofia_search_params(); ?>

      <div id="search-bar">
        <?php osc_goto_first_category(); ?>
        <?php while ( osc_has_categories() ) { ?>
          <?php $search_params['sCategory'] = osc_category_id(); ?>
          <a class="but" href="<?php echo osc_search_url($search_params); ?>"><?php echo osc_category_name(); ?></a>
        <?php } ?>
      </div>
    <?php } ?>

    <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
      <div class="form_publish" id="pub_full">
        <div class="publish_button">
          <a href="<?php echo osc_item_post_url_in_category(); ?>"><?php _e('Publish your ad for free', 'sofia');?></a>
        </div>
      </div>
    <?php } ?>  
  </div>
  <!-- jQuery Menu End -->

  <?php
    osc_show_widgets('header');

    $breadcrumb = osc_breadcrumb('<i class="fa fa-angle-right"></i>', false);
    if( $breadcrumb != '') { 
  ?>
      <div class="breadcrumb">
        <?php echo $breadcrumb; ?>
        <div class="clear"></div>
      </div>
  <?php } ?>
  
  <div class="forcemessages-inline">
    <?php osc_show_flash_message(); ?>
  </div>