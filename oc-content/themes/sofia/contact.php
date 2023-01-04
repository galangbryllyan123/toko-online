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
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="content user_forms">
      <div class="inner">
        <h1><?php _e('Contact us', 'sofia'); ?></h1>
        <ul id="error_list"></ul>
        <form action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" id="contact">
          <input type="hidden" name="page" value="contact" />
          <input type="hidden" name="action" value="contact_post" />
          <fieldset>
            <label for="subject"><?php _e('Subject', 'sofia'); ?> (<?php _e('optional', 'sofia'); ?>)</label> <?php ContactForm::the_subject(); ?><br />
            <label for="message"><?php _e('Message', 'sofia'); ?></label> <?php ContactForm::your_message(); ?><br />
            <label for="yourName"><?php _e('Your name', 'sofia'); ?> (<?php _e('optional', 'sofia'); ?>)</label> <?php ContactForm::your_name(); ?><br />
            <label for="yourEmail"><?php _e('Your e-mail address', 'sofia'); ?></label> <?php ContactForm::your_email(); ?><br />
            <?php osc_run_hook('contact_form'); ?>

            <div style="float:left;clear:both;width:100%;margin:5px 0 10px 0;">
              <?php osc_run_hook("anr_captcha_form_field"); ?>
            </div>

            <button type="submit"><?php _e('Send', 'sofia'); ?></button>
            <?php osc_run_hook('admin_contact_form'); ?>
          </fieldset>
        </form>
      </div>

      <div class="right">
        <h2><?php _e('How to contact us', 'sofia'); ?></h2>
        <div class="delim"></div>
        <h3><?php _e('If you are seller...', 'sofia'); ?></h3>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('If you are intrested in cooperations, do not hestitate to contact us', 'sofia'); ?></div>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('If you are intrested in advertisement on our site, contact us on info@info.com', 'sofia'); ?></div>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('If you forgot login details, use "forgot password" form', 'sofia'); ?></div>
        <div class="delim"></div>

        <h3><?php _e('If you are byuer...', 'sofia'); ?></h3>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('If you need more informations about seller, we can provide only those they are online', 'sofia'); ?></div>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('If you want to contact seller of listing that has expired, we can not give you any informations about seller', 'sofia'); ?></div>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('If you were robbed, contact police and we will provide all informations to police', 'sofia'); ?></div>
      </div>
    </div>
    <?php ContactForm::js_validation(); ?>
    <?php osc_current_web_theme_path('footer.php'); ?>
  </body>
</html>