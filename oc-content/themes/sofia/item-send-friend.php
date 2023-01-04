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
      <div id="contact" class="inner">
        <h1><?php _e('Send to a friend', 'sofia'); ?></h1>
        <div class="del"></div>
        <ul id="error_list"></ul>
        <form id="sendfriend" name="sendfriend" action="<?php echo osc_base_url(true); ?>" method="post">
          <fieldset>
            <input type="hidden" name="action" value="send_friend_post" />
            <input type="hidden" name="page" value="item" />
            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
            <div id="send_friend">
              <span class="left"><?php _e('Item', 'sofia'); ?></span>
              <span class="right"><a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a></span>
            </div>
            
            <?php if(osc_is_web_user_logged_in()) { ?>
              <input type="hidden" name="yourName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
              <input type="hidden" name="yourEmail" value="<?php echo osc_logged_user_email();?>" />
            <?php } else { ?>
              <label for="yourName"><?php _e('Your name', 'sofia'); ?></label> <?php SendFriendForm::your_name(); ?> <br />
              <label for="yourEmail"><?php _e('Your e-mail address', 'sofia'); ?></label> <?php SendFriendForm::your_email(); ?> <br />
            <?php } ?>
            
            <label for="friendName"><?php _e("Friend's name", 'sofia'); ?></label> <?php SendFriendForm::friend_name(); ?> <br />
            <label for="friendEmail"><?php _e("Friend's e-mail address", 'sofia'); ?></label> <?php SendFriendForm::friend_email(); ?> <br />
            <label for="message"><?php _e('Message', 'sofia'); ?></label> <?php SendFriendForm::your_message(); ?> <br />

            <div style="float:left;clear:both;width:100%;margin:5px 0 10px 0;">
              <?php osc_run_hook("anr_captcha_form_field"); ?>
            </div>   
         
            <div class="del"></div>
            <button type="submit"><?php _e('Send', 'sofia'); ?></button>
          </fieldset>
        </form>
      </div>
      
      <div id="s_friend">
        <h2><?php _e('Why to use it', 'sofia'); ?></h2>
        <div class="del"></div>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Reason 1 ...', 'sofia'); ?></div>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Reason 2 ...', 'sofia'); ?></div>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Reason 3 ...', 'sofia'); ?></div>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Reason 4 ...', 'sofia'); ?></div>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Reason 5 ...', 'sofia'); ?></div>
        <div class="text"><i class="fa fa-chevron-right"></i>&nbsp;<?php _e('Reason 6 ...', 'sofia'); ?></div>
      </div>
    </div>
    <?php SendFriendForm::js_validation(); ?>
    <?php osc_current_web_theme_path('footer.php'); ?>
  </body>
</html>