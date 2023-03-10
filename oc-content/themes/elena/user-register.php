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
    <div class="content user_forms">
      <div class="inner">
        <h1><?php _e('Register an account for free', 'elena') ; ?></h1>
        <ul id="error_list"></ul>
        <form name="register" id="register" action="<?php echo osc_base_url(true) ; ?>" method="post" >
          <input type="hidden" name="page" value="register" />
          <input type="hidden" name="action" value="register_post" />

          <fieldset>
            <label for="name"><?php _e('Name', 'elena') ; ?></label> <?php UserForm::name_text(); ?><br />
            <label for="password"><?php _e('Password', 'elena') ; ?></label> <?php UserForm::password_text(); ?><br />
            <label for="password"><?php _e('Re-type password', 'elena') ; ?></label> <?php UserForm::check_password_text(); ?><br />
            <p id="password-error" style="display:none;">
              <?php _e('Passwords don\'t match', 'elena') ; ?>.
            </p>
            <label for="email"><?php _e('E-mail', 'elena') ; ?></label> <?php UserForm::email_text() ; ?><br />
            <label for="phone"><?php _e('Mobil', 'elena'); ?></label> <?php UserForm::mobile_text(osc_user()) ; ?><br />
            <?php UserForm::js_validation() ; ?>
            <?php osc_run_hook('user_register_form') ; ?>

            <div style="float:left;clear:both;width:100%;margin:5px 0 10px 0;">
              <?php osc_run_hook("anr_captcha_form_field"); ?>
            </div>

            <button type="submit"><?php _e('Create', 'elena') ; ?></button>
          </fieldset>
        </form>
      </div>
    </div>
    <?php osc_current_web_theme_path('footer.php') ; ?>
  </body>
</html>