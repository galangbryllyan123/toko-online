<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
  <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script>
</head>
<body>
  <?php osc_current_web_theme_path('header.php') ; ?>
  <div id="friend" class="content user_forms round5">
    <div id="contact" class="inner">
      <h1><?php echo __('Send to a friend note about', 'tatiana') . ' '; ?><a href="<?php echo osc_item_url( ); ?>"><?php echo osc_item_title(); ?></a></h1>
      <div class="div-desc"><?php _e('You can tell him what you think about this item and what are positives/negatives of it or why it should be checked. All messages are moderated', 'tatiana') ; ?></div>
      <div class="clear"></div>

      <ul id="error_list"></ul>
      <form id="sendfriend" name="sendfriend" action="<?php echo osc_base_url(true); ?>" method="post">
      <fieldset>
        <input type="hidden" name="action" value="send_friend_post" />
        <input type="hidden" name="page" value="item" />
        <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
        <?php if(osc_is_web_user_logged_in()) { ?>
          <input type="hidden" name="yourName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
          <input type="hidden" name="yourEmail" value="<?php echo osc_logged_user_email();?>" />
        <?php } else { ?>
          <div class="third">
            <label for="yourName"><span><?php _e('Your name', 'tatiana'); ?></span><div class="req">*</div></label> 
            <?php SendFriendForm::your_name(); ?>
            <div class="small-info"><?php _e('Your Real name or Username', 'tatiana'); ?></div>
          </div>
        <?php }; ?>

        <div class="four">
          <label for="friendName"><span><?php _e("Your friend's name", 'tatiana'); ?></span><div class="req">*</div></label>
          <?php SendFriendForm::friend_name(); ?>
          <div class="small-info"><?php _e('Real name or username of friend', 'tatiana'); ?></div>
        </div>

        <?php if(!osc_is_web_user_logged_in()) { ?>
          <div class="third">
            <label for="yourEmail"><span><?php _e('Your e-mail address', 'tatiana'); ?></span><div class="req">*</div></label>
            <?php SendFriendForm::your_email(); ?>
            <div class="small-info"><?php _e('Friend can contact you back', 'tatiana'); ?></div>
          </div>
        <?php } ?>

        <div class="four">
          <label for="friendEmail"><span><?php _e("Your friend's e-mail address", 'tatiana'); ?></span><div class="req">*</div></label>
          <?php SendFriendForm::friend_email(); ?>
          <div class="small-info"><?php _e('Where your friend receive mail', 'tatiana'); ?></div>
        </div>
                      
        <?php SendFriendForm::your_message(); ?>
        <div class="req-what"><div class="req">*</div><div class="small-info"><?php _e('This field is required', 'tatiana'); ?></div></div>

        <div style="float:left;clear:both;width:100%;margin:5px 0 10px 0;">
          <?php osc_run_hook("anr_captcha_form_field"); ?>
        </div>

        <button type="submit" id="blue"><?php _e('Send', 'tatiana'); ?></button>
      </fieldset>
      </form>
    </div>
  </div>

  <?php SendFriendForm::js_validation(); ?>
  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>