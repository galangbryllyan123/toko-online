<?php osc_show_flash_message(); ?>

<!-- HEADER -->
<div id="top-header">
  <div class="top-inner">
    <div id="header">
      <a id="logo" href="<?php echo osc_base_url(); ?>"><?php echo logo_header(); ?></a>
      
      <div id="user_menu">
        <ul>
          <?php if(osc_users_enabled()) { ?>
            <?php if( osc_is_web_user_logged_in() ) { ?>
              <li class="first logged">
                <?php if(function_exists('profile_picture_show')) { profile_picture_show(34); } ?>
                <span class="wel"><?php echo sprintf(__('Hi %s', 'elena'), osc_logged_user_name() . '!'); ?></span> <span class="dot">&middot;</span>
                <strong><a href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My account', 'elena'); ?></a></strong> <span class="dot">&middot;</span>
                <?php if (class_exists('OSCFacebook')) { ?>
                  <a href="<?php echo osc_base_url(); echo "?facebook_logout=true"; ?>"><?php _e( 'Logout', 'facebook' ); ?></a>  
                <?php } else { ?>
                  <a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'elena'); ?></a>
                <?php } ?>
                <?php if ( osc_count_web_enabled_locales() > 1) { ?> <span class="dot">&middot;</span> <?php } ?>
              </li>
            <?php } else { ?>
              <li class="first">
                <a id="login_open" href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'elena'); ?></a>
                <?php if(osc_user_registration_enabled()) { ?>
                  <span class="dot">&middot;</span>
                  <a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register', 'elena'); ?></a>
                  <span class="dot">&middot;</span>
                  <?php if( osc_get_osclass_location() != 'error') { if(function_exists('fbc_button')) { fbc_button(); } } ?>
                <?php } ?>
                
                <form id="login" action="<?php echo osc_base_url(true); ?>" method="post">
                  <fieldset>
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="login_post" />
                    
                    <label for="email"><?php _e('E-mail', 'elena'); ?></label><br/>
                    <?php UserForm::email_login_text(); ?><br/>
                    <label for="password"><?php _e('Password', 'elena'); ?></label><br/>
                    <?php UserForm::password_login_text(); ?>
                    <p class="checkbox">
                      <?php UserForm::rememberme_login_checkbox(); ?> <label for="rememberMe"><?php _e('Remember me', 'elena'); ?></label>
                    </p>
                    <button type="submit"><?php _e('Log in', 'elena'); ?></button>
                    <div class="forgot">
                      <a href="<?php echo osc_recover_user_password_url(); ?>"><?php _e("Forgot password?", 'elena'); ?></a>
                    </div>
                  </fieldset>
                </form>
              </li>
            <?php } ?>
          <?php } ?>
          
          <?php if ( osc_count_web_enabled_locales() > 1) { ?>
            <?php osc_goto_first_locale(); ?>
            <li class="last with_sub">
              <strong><?php _e("Language", 'elena'); ?></strong>
              <ul>
                <?php $i = 0;  ?>
                <?php while ( osc_has_web_enabled_locales() ) { ?>
                  <li <?php if( $i == 0 ) { echo "class='first'"; } ?>>
                    <a id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a>
                  </li>
                  <?php $i++; ?>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
        </ul>
 
        <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
          <a class="btn btn-orange" id="publish_button" href="<?php echo osc_item_post_url(); ?>"><?php _e("Publish your ad for free", 'elena'); ?></a>
        <?php } ?>
      </div>

      <div class="active-top <?php if(osc_is_ad_page() or osc_is_search_page()) {?>top-it<?php } ?>">
        <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
          <a class="btn btn-orange" id="publish_button" href="<?php echo osc_item_post_url(); ?>"><?php _e("Publish your ad for free", 'elena'); ?></a>
        <?php } ?>

        <span><?php echo __('Search in', 'elena') . ' ' . osc_total_active_items() . ' ' . __('active listings', 'elena'); ?></span>
      </div>
    </div>
    
    <div class="clear"></div>

    <div id="form_publish">
      <?php osc_current_web_theme_path('inc.search.php'); ?>
    </div>
    
    <div class="clear"></div>
  </div>
</div>

<?php if (strpos($_SERVER['HTTP_HOST'],'mb-themes') !== false) { ?>
  <div id="piracy" class="noselect" title="Click to hide this box">This theme is ownership of MB Themes and can be downloaded only on <a href="https://osclasspoint.com/graphic-themes/general/elena-free-osclass-theme_i68">OsclassPoint.com</a>. When downloaded on other site, there is no support and updates provided. Do not support stealers, support developer!</div>
  <script>$(document).ready(function(){ $('#piracy').click(function(){ $(this).fadeOut(200); }); });</script>
<?php } ?>


<!-- CONTAINER -->
<div class="container">
  <div class="c-inside">
    <?php if(function_exists('scrolltop')) { scrolltop(); } ?>

    <?php
      osc_show_widgets('header');
      $breadcrumb = osc_breadcrumb('<span class="bread_arrow"></span>', false);
    ?>
    <?php if( $breadcrumb != '') { ?>
      <div class="breadcrumb">
        <a href="<?php echo osc_base_url(); ?>" class="b-home"></a>
        <?php echo $breadcrumb; ?>
        <?php if (osc_is_ad_page()) { if (osc_item_is_premium()) { ?><span id="topovany"><?php _e('Premium', 'elena'); ?></span><?php } } ?>
        <?php if (osc_is_ad_page()) { if(function_exists('bo_mgr_edit_delete_links')) { bo_mgr_edit_delete_links(); } } ?>
        
      </div>
    <?php } ?>  