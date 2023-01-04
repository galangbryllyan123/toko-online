<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
</head>
<body>
  <?php osc_current_web_theme_path('header.php') ; ?>
  <div id="i-forms" class="content recover">
    <div class="keep-header">
      <h1><div class="icon-recover"></div><span><?php _e('Recover your password', 'tatiana'); ?></span></h1>
    </div>
    <div class="user_forms">
      <div class="inner">
        <form action="<?php echo osc_base_url(true) ; ?>" method="post" >
          <input type="hidden" name="page" value="login" />
          <input type="hidden" name="action" value="recover_post" />
          <fieldset>
            <label for="email"><?php _e('E-mail', 'tatiana') ; ?></label> <?php UserForm::email_text() ; ?><br />
            <?php osc_show_recaptcha('recover_password'); ?>
            <button type="submit" id="green"><?php _e('Send me a new password', 'tatiana') ; ?></button>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <div class="clear"></div><br /><br />

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>