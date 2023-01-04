<?php
  osc_enqueue_script('jquery-validate');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
  <head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
  </head>
  
  <body>
    <?php UserForm::js_validation(); ?>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="content user_forms">
      <div class="inner">
        <h1><?php _e('Register an account for free', 'sofia'); ?></h1>
        <ul id="error_list"></ul>
        <form name="register" id="register" action="<?php echo osc_base_url(true); ?>" method="post" >
          <input type="hidden" name="page" value="register" />
          <input type="hidden" name="action" value="register_post" />

          <fieldset>
            <label for="name"><?php _e('Name', 'sofia'); ?></label> <?php UserForm::name_text(); ?><br />
            <label for="password"><?php _e('Password', 'sofia'); ?></label> <?php UserForm::password_text(); ?><br />
            <label for="password"><?php _e('Re-type password', 'sofia'); ?></label> <?php UserForm::check_password_text(); ?><br />
            <p id="password-error" style="display:none;">
              <?php _e('Passwords don\'t match', 'sofia'); ?>.
            </p>
            <label for="email"><?php _e('E-mail', 'sofia'); ?></label> <?php UserForm::email_text(); ?><br />
            <?php osc_run_hook('user_register_form'); ?>

            <div style="float:left;clear:both;width:100%;margin:5px 0 10px 0;">
              <?php osc_run_hook("anr_captcha_form_field"); ?>
            </div>

            <div class="delim"></div>
            <button type="submit"><?php _e('Create', 'sofia'); ?></button>
          </fieldset>
        </form>
      </div>
      <div class="right">
       <h2><?php _e('Welcome', 'sofia'); ?></h2>
       <div class="delim"></div>
       <h3><?php _e('If you are seller...', 'sofia'); ?></h3>
       <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('We help you to sell your stuffs', 'sofia'); ?></div>
       <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('It is easy, free and fast', 'sofia'); ?></div>
       <div class="delim"></div>

       <h3><?php _e('If you are byuer...', 'sofia'); ?></h3>
       <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Subscribe to alerts', 'sofia'); ?></div>
       <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Keep and share your favorite vehicles', 'sofia'); ?></div>
      </div>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?>
  </body>
</html>