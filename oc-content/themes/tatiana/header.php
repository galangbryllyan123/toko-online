<?php osc_goto_first_locale(); ?>
<!-- container -->
<div id="top-navi">
  <div class="navi-wrap">
    <div id="h-bar">
      <div class="h-my-loc">
        <div class="i-pos"></div>
        <div class="font">
          <?php
            if(Params::getParam('sCountry') == '' and Params::getParam('sRegion') == '' and Params::getParam('sCity') == '') {
              _e('Location not saved', 'tatiana');
            } else {
              $loc = array_filter(array(Params::getParam('sCountry'), Params::getParam('sRegion'), Params::getParam('sCity')));
              $loc = trim(implode(', ', $loc));
              echo $loc;
              echo '<i class="fa fa-close clear-cookie-location"></i>';
            }
          ?>
        </div>
      </div>

      <?php if(osc_get_preference('phone', 'tatiana_theme') <> '') { ?>
        <div id="h-phone">
          <span><?php echo osc_esc_html( osc_get_preference('phone', 'tatiana_theme') ); ?></span>
        </div>
      <?php } ?>

      <?php if ( osc_count_web_enabled_locales() > 1) { ?>
        <?php $current_locale = mb_get_current_user_locale(); ?>

        <?php osc_goto_first_locale(); ?>
        <span id="lang-open-box">
          <span id="lang_open"><img src="<?php echo osc_current_web_theme_url();?>images/country_flags/<?php echo strtolower(substr(osc_current_user_locale(), 3)); ?>.png" alt="<?php _e('Country flag', 'tatiana');?> " /><span><?php echo $current_locale['s_short_name']; ?></span></span>

          <div id="lang-wrap">
            <div class="lang-top-arrow"></div>
            <ul id="lang-box" class="round3">
              <?php $i = 0 ;  ?>
              <?php while ( osc_has_web_enabled_locales() ) { ?>
                <li <?php if( $i == 0 ) { echo "class='first'" ; } ?> title="<?php echo osc_locale_field("s_description"); ?>"><a id="<?php echo osc_locale_code() ; ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ) ; ?>"><img src="<?php echo osc_current_web_theme_url();?>images/country_flags/<?php echo strtolower(substr(osc_locale_code(), 3)); ?>.png" alt="<?php _e('Country flag', 'tatiana');?>" /><span><?php echo osc_locale_name(); ?></span></a><?php if (osc_locale_code() == $current_locale['pk_c_code']) { ?><div class="icon-lang-cur"></div><?php } ?></li>
                <?php $i++ ; ?>
              <?php } ?>
            </ul>
          </div>
        </span>
      <?php } ?>

      <?php if(osc_users_enabled()) { ?>
        <?php if( osc_is_web_user_logged_in() ) { ?>
          <?php if (class_exists('OSCFacebook') and 1==2) { ?>
            <span><div class="icon-user-logout"></div><span><a href="<?php echo osc_base_url(); echo "?facebook_logout=true";?>"><?php _e('Logout', 'facebook');?></a></span></span>
          <?php } else { ?>
            <span><div class="icon-user-logout"></div><span><a href="<?php echo osc_user_logout_url() ; ?>"><?php _e('Logout', 'tatiana') ; ?></a></span></span>
          <?php } ?>

          <span><div class="icon-user-reg"></div><span><a href="<?php echo osc_user_dashboard_url() ; ?>"><?php _e('My account', 'tatiana') ; ?></a></span></span>

          <span><?php echo __('Hi', 'tatiana') . ' ' . osc_logged_user_name() . ' !'; ?></span>
          
        <?php } else { ?>

          <?php if(osc_user_registration_enabled()) { ?>
            <span><div class="icon-user-reg"></div><span><a href="<?php echo osc_register_account_url() ; ?>"><?php _e('Register', 'tatiana'); ?></a></span></span>
            <?php if( osc_get_osclass_location() != 'error') { if(function_exists('fbc_button')) { fbc_button(); ?><?php } } ?>
          <?php } ?>  

          <span id="login-wrap">
            <div class="icon-user-login"></div><span><a id="login_open" href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'tatiana') ; ?></a></span>

            <div id="login-box" class="round3" >
            <div class="top-arrow"></div>
              <form id="login" action="<?php echo osc_base_url(true) ; ?>" method="post">
                <fieldset>
                  <input type="hidden" name="page" value="login" />
                  <input type="hidden" name="action" value="login_post" />
                  <label for="email"><?php _e('E-mail', 'tatiana') ; ?></label>
                  <?php UserForm::email_login_text(); ?>
                  <div class="clear"></div>
                  <label for="password"><?php _e('Password', 'tatiana') ; ?></label>
                  <?php UserForm::password_login_text(); ?>
                  <div class="clear"></div>
                  <div class="checkbox"><?php UserForm::rememberme_login_checkbox();?> <label for="rememberMe"><?php _e('Remember me', 'tatiana') ; ?></label></div>
                  <div class="clear"></div>
                  <button type="submit" id="blue"><?php _e('Log in', 'tatiana') ; ?></button>
                  <a href="<?php echo osc_recover_user_password_url() ; ?>"><?php _e("Forgot password?", 'tatiana');?></a>
                </fieldset>
              </form>
            </div>
          </span>       
        <?php } ?>
      <?php } ?>

      
    </div>

    <div id="header">
      <a id="logo" href="<?php echo osc_base_url() ; ?>"><?php echo logo_header(); ?></a>
      <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
        <div class="form_publish">
          <div class="publish_button"><a class="button orange-button round3" href="<?php echo osc_item_post_url_in_category() ; ?>"><span><?php _e("Publish your ad for free", 'tatiana');?></span></a></div>
        </div>
      <?php } ?>

      <?php if (osc_get_preference('allow_fb', 'tatiana_theme') == 1) { ?>
        <!--[if !IE]><!-->
          <div id="fb-block" class="round3">
            <div id="fb-root"></div>
            <script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=425656524150689";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
            <div style="float:right;" class="fb-like" data-href="<?php echo osc_base_url();?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
          </div> 
        <!--<![endif]-->
      <?php } ?>
    </div>

    <div class="clear"></div>

    <!-- Search Bar -->
    <div id="form_publish">
      <?php osc_current_web_theme_path('inc.search.php') ; ?>
    </div>
  </div>
</div>

<div class="container">
<!-- header -->
<?php if (strpos($_SERVER['HTTP_HOST'],'mb-themes') !== false) { ?>
  <div id="piracy" class="noselect" title="Click to hide this box">This theme is ownership of MB Themes and can be bought only on <a href="https://osclasspoint.com/graphic-themes/general/tatiana-osclass-theme_i66">OsclassPoint.com</a>. When bought on other site, there is no support and updates provided. Do not support stealers, support developer!</div>
  <script>$(document).ready(function(){ $('#piracy').click(function(){ $(this).fadeOut(200); }); });</script>
<?php } ?>
<?php if(function_exists('scrolltop')) { scrolltop(); } ?>

<script>
  var base_url_js = "<?php echo osc_base_url();?>";
</script>

<div class="clear"></div>
<!-- /header -->

<?php osc_show_flash_message(); ?>

<?php
  osc_show_widgets('header') ;
  $breadcrumb = osc_breadcrumb('<span class="bread_arrow"></span>', false);
  if( $breadcrumb != '') { ?>
    <div class="breadcrumb">
      <div class="icon-home"></div><?php echo $breadcrumb; ?><?php if (osc_is_ad_page()) { if (osc_item_is_premium()) { ?><span id="topovany" class="round3" title="<?php _e('Premium listing', 'tatiana'); ?>">PREMIUM</span><?php } } ?>
      <?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id() && osc_is_ad_page()) { ?>
        <div id="edit_item_view">
          <span><a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><?php _e('Edit this item', 'tatiana'); ?></a></span><div class="icon-edit-item"></div>
        </div>
      <?php } ?>
    <div class="clear"></div>
  </div>
<?php } ?>

<?php View::newInstance()->_erase('countries'); ?>
<?php View::newInstance()->_erase('regions'); ?>
<?php View::newInstance()->_erase('cities'); ?>