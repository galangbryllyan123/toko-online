<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
  <head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
  </head>

  <body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="content user_forms">
      <div class="inner">
        <h1><?php _e('Access to your account', 'sofia'); ?></h1>
        <form action="<?php echo osc_base_url(true); ?>" method="post" >
          <input type="hidden" name="page" value="login" />
          <input type="hidden" name="action" value="login_post" />
          <fieldset>
            <label for="email"><?php _e('E-mail', 'sofia'); ?></label> <?php UserForm::email_login_text(); ?><br />
            <label for="password"><?php _e('Password', 'sofia'); ?></label> <?php UserForm::password_login_text(); ?><br />
            <div class="del"></div>
            <p class="checkbox"><?php UserForm::rememberme_login_checkbox();?> <label class="log-lab" for="rememberMe"><?php _e('Remember me', 'sofia'); ?></label></p>
            <div class="del"></div>
            <button type="submit"><?php _e("Log in", 'sofia');?></button>
            <div class="more-login">
              <a href="<?php echo osc_register_account_url(); ?>"><?php _e("Register for a free account", 'sofia'); ?></a>
              <a href="<?php echo osc_recover_user_password_url(); ?>"><?php _e("Forgot password?", 'sofia'); ?></a>
            </div>
          </fieldset>
        </form>
      </div>
      <div class="right">
       <h2><?php _e('Why to log in?', 'sofia'); ?></h2>
       <div class="delim"></div>
       <h3><?php _e('If you are seller...', 'sofia'); ?></h3>
       <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('You can easily watch your items', 'sofia'); ?></div>
       <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('You can add new listings fast', 'sofia'); ?></div>
       <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('You can manage your listings', 'sofia'); ?></div>
       <div class="delim"></div>

       <h3><?php _e('If you are byuer...', 'sofia'); ?></h3>
       <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Subscribe to alerts', 'sofia'); ?></div>
       <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Keep and share your favorite items', 'sofia'); ?></div>
       <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Fast contact with seller', 'sofia'); ?></div>
      </div>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?>
  </body>
</html>