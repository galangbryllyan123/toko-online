<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
  <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script>
</head>
<body>
  <?php UserForm::js_validation() ; ?>
  <?php osc_current_web_theme_path('header.php') ; ?>
  <div id="i-forms" class="content">
    <div id="left">
      <div class="keep-header">
        <h1><div class="icon-login"></div><span><?php _e('Login to your account', 'tatiana'); ?></span></h1>
      </div>
      <div class="user_forms login">
        <div class="inner">                
          <form action="<?php echo osc_base_url(true); ?>" method="post" >
          <input type="hidden" name="page" value="login" />
          <input type="hidden" name="action" value="login_post" />
          <fieldset>
            <label for="email"><span><?php _e('E-mail', 'tatiana'); ?></span><span class="req">*</span></label> <?php UserForm::email_login_text() ; ?>
            <label for="password"><span><?php _e('Password', 'tatiana'); ?></span><span class="req">*</span></label> <?php UserForm::password_login_text() ; ?>
            <div class="req-what"><div class="req">*</div><div class="small-info"><?php _e('This field is required', 'tatiana'); ?></div></div>
            <div class="checkbox"><?php UserForm::rememberme_login_checkbox();?> <label for="rememberMe"><?php _e('Remember me', 'tatiana') ; ?></label></div>
            <div class="clear"></div>
            <button type="submit" id="blue"><?php _e("Log in", 'tatiana');?></button>

            <div class="more-login">
              <a href="<?php echo osc_recover_user_password_url() ; ?>"><?php _e("Forgot password?", 'tatiana') ; ?></a>
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

    <div id="right">
      <div class="keep-header">
        <h1><div class="icon-register"></div><span><?php _e('Register an account for free', 'tatiana'); ?></span></h1>
      </div>
      <div class="user_forms register">
        <div class="inner">          
          <ul id="error_list"></ul>
          <form name="register" id="register" action="<?php echo osc_base_url(true) ; ?>" method="post" >
          <input type="hidden" name="page" value="register" />
          <input type="hidden" name="action" value="register_post" />
          <fieldset>
            <label for="name"><span><?php _e('Name', 'tatiana') ; ?></span><span class="req">*</span></label> <?php UserForm::name_text(); ?>
            <label for="password"><span><?php _e('Password', 'tatiana') ; ?></span><span class="req">*</span></label> <?php UserForm::password_text(); ?>
            <label for="password"><span><?php _e('Re-type password', 'tatiana') ; ?></span><span class="req">*</span></label> <?php UserForm::check_password_text(); ?>
            <p id="password-error" style="display:none;">
              <?php _e('Passwords don\'t match', 'tatiana') ; ?>.
            </p>
            <label for="email"><span><?php _e('E-mail', 'tatiana') ; ?></span><span class="req">*</span></label> <?php UserForm::email_text() ; ?>
            <label for="phone"><?php _e('Mobile Phone', 'tatiana'); ?></label> <?php UserForm::mobile_text(osc_user()) ; ?>
            <div class="req-what"><div class="req">*</div><div class="small-info"><?php _e('This field is required', 'tatiana'); ?></div></div>

            <?php UserForm::js_validation() ; ?>
            <?php osc_run_hook('user_register_form') ; ?>

            <div style="float:left;clear:both;width:100%;margin:5px 0 10px 0;">
              <?php osc_run_hook("anr_captcha_form_field"); ?>
            </div>

            <button type="submit" id="green"><?php _e('Create account', 'tatiana') ; ?></button>
          </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>