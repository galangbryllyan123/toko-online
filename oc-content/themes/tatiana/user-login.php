<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
</head>
<body>
  <?php osc_current_web_theme_path('header.php') ; ?>
  <div id="i-forms" class="login-me content">
    <div class="keep-header">
      <h1><div class="icon-login-account"></div><span><?php _e('Login to your account', 'tatiana'); ?></span></h1>
    </div>
    <div class="user_forms">
      <div class="inner">
        <form action="<?php echo osc_base_url(true); ?>" method="post" >
          <input type="hidden" name="page" value="login" />
          <input type="hidden" name="action" value="login_post" />
          <fieldset>
            <label for="email"><?php _e('E-mail', 'tatiana'); ?></label> <?php UserForm::email_login_text() ; ?>
            <div class="clear"></div>
            <label for="password"><?php _e('Password', 'tatiana'); ?></label> <?php UserForm::password_login_text() ; ?>
            <div class="clear"></div>
            <div class="checkbox"><?php UserForm::rememberme_login_checkbox();?> <label for="rememberMe"><?php _e('Remember me', 'tatiana') ; ?></label></div>
            <button type="submit" id="green"><?php _e("Log in", 'tatiana');?></button>
            <div class="more-login">
              <a href="<?php echo osc_register_account_url() ; ?>"><?php _e("Register for a free account", 'tatiana') ; ?></a> · <a href="<?php echo osc_recover_user_password_url() ; ?>"><?php _e("Forgot password?", 'tatiana') ; ?></a>
            </div>
          </fieldset>
        </form>
      </div>
    </div>

    <?php if(class_exists('OSCFacebook')) { ?>
      <?php 
        $user = OSCFacebook::newInstance()->getUser() ;
        if( !$user or !osc_is_web_user_logged_in() ) {
      ?>

      <div class="or"><?php _e('or', 'tatiana'); ?></div>
      <a class="fb-login" href="<?php echo OSCFacebook::newInstance()->loginUrl(); ?>"><img src="<?php echo osc_base_url(); ?>oc-content/themes/tatiana/images/fb-login.png" alt="<?php _e('Login with facebook', 'tatiana'); ?>" /></a>

      <?php } ?>
    <?php } ?>
  </div>
  <div class="clear"></div><br /><br />

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>