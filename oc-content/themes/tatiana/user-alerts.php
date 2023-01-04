<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
</head>
<body>
  <?php osc_current_web_theme_path('header.php') ; ?>

  <div class="content user_account">
    <h1>
      <?php if(function_exists('profile_picture_show')) { profile_picture_show(null, null, 39); } ?>
      <span><?php _e('User alerts', 'tatiana') ; ?></span>
    </h1>

    <div id="sidebar">
      <?php echo osc_private_user_menu() ; ?>
    </div>

    <div id="main">
      <h2><div class="icon-alerts"></div><span><?php _e('Your alerts', 'tatiana'); ?></span></h2>


      <?php if(osc_count_alerts() == 0) { ?>
        <div class="empty"><?php _e('You do not have any alerts yet', 'tatiana'); ?>.</div>
      <?php } else { ?>
        <?php $i = 1; ?>


        <?php while(osc_has_alerts()) { ?>
          <div class="userItem">
            <div class="alert-head">
              <span><?php echo __('Alert', 'tatiana') . ' #' . $i ; ?></span>
              <a class="button red-button round3" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can\'t be undone. Are you sure you want to continue?', 'tatiana')); ?>');" href="<?php echo osc_user_unsubscribe_alert_url() ; ?>"><?php _e('Delete this alert', 'tatiana') ; ?></a>
              <span class="small"><?php _e('Following listings match criteria of your search', 'tatiana'); ?></span>
            </div>
            <div class="alert-listing-list">
              <?php while(osc_has_items()) { ?>
                <div class="simple-listing" >
                  <div><a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title() ; ?></a></div>
                  <div class="clear"></div>
                  <span class="lab"><?php _e('Publication date', 'tatiana') ; ?>:</span><span class="tex"><?php echo osc_format_date(osc_item_pub_date()) ; ?></span>
                  <div class="clear"></div>
                  <span class="lab"><?php _e('Description', 'tatiana') ; ?>:</span><span class="tex"><?php echo osc_highlight(osc_item_description(), 80) ; ?></span>
                  <div class="clear"></div>
                  <?php if( osc_price_enabled_at_items() ) { echo '<span class="lab">' . __('Price', 'tatiana'); ?>:</span><span class="tex"><?php echo osc_format_price(osc_item_price()) . '</span>' ; } ?>
                </div>
              <?php } ?>
             
              <?php if(osc_count_items() == 0) { ?>
                <div class="no-listing"><?php _e('No listing match criteria of this alert', 'tatiana'); ?></div>
              <?php } ?>
            </div>
          </div>
          <?php $i++; ?>
        <?php } ?>
      <?php } ?>
    </div>
  </div>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>