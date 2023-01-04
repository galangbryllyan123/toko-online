<?php
    $address = '';
    if(osc_user_address()!='') {
      $address = osc_user_address();
    }
    $location_array = array();
    if(trim(osc_user_city()." ".osc_user_zip())!='') {
        $location_array[] = trim(osc_user_city()." ".osc_user_zip());
    }
    if(osc_user_region()!='') {
        $location_array[] = osc_user_region();
    }
    if(osc_user_country()!='') {
        $location_array[] = osc_user_country();
    }
    $location = implode(", ", $location_array);
    unset($location_array);

  $user_keep = osc_user(); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
  <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script>
</head>
<body>
  <?php View::newInstance()->_exportVariableToView('user', $user_keep); ?>
  <?php osc_current_web_theme_path('header.php') ; ?>

  <div class="content user_public_profile">
    <h1>
      <?php if(function_exists('profile_picture_show')) { profile_picture_show(null, null, 39); } ?>
      <span><?php echo __('Welcome in store of', 'tatiana') . ' ' . osc_user_name(); ?></span>
    </h1>

    <div id="description" class="round4">
      <h3><div class="icon-pub-info"></div><span><?php _e('Personal information', 'tatiana'); ?></span></h3>
      <?php if(function_exists('profile_picture_show')) { profile_picture_show(200); } ?>
      <ul id="user_data">
        <li><div class="icon-pub-name"></div><span><?php echo osc_user_name(); ?></span></li>
        <?php if ( osc_user_phone_mobile() != "" ) { ?><li><div class="icon-pub-phone"></div><span><?php echo osc_user_phone_mobile() ; ?></span></li><?php } ?>
        <?php if ( osc_user_phone() != "" && osc_user_phone() != osc_user_phone_mobile() ) { ?><li><div class="icon-pub-clear"></div><span><?php echo osc_user_phone() ; ?></span></li><?php } ?>                    
        <?php if ($address != '') { ?><li><div class="icon-pub-address"></div><span><?php echo $address; ?></span></li><?php } ?>
        <?php if ($location != '') { ?><li><div class="icon-pub-reg"></div><span><?php echo $location; ?></span></li><?php } ?>
        <?php if (osc_user_website() != '') { ?><li><div class="icon-pub-url"></div><span><?php echo osc_user_website(); ?></span></li><?php } ?>
      </ul>
      <div class="user-desc"><?php echo osc_user_info(); ?></div>
    </div>

    <?php if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
      <div id="c-box">
        <div id="contact_form_wrap">
          <ul id="error_list"></ul>
          <?php ContactForm::js_validation(); ?>
          <form action="<?php echo osc_base_url(true) ; ?>" method="post" name="contact_form" id="contact_form" class="round4" <?php if( osc_recaptcha_public_key() ) { ?>style="height:auto;"<?php } ?>>
          <input type="hidden" name="action" value="contact_post" class="nocsrf" />
          <input type="hidden" name="page" value="user" />
          <input type="hidden" name="id" value="<?php echo osc_user_id();?>" />
          <?php //osc_prepare_user_info() ; ?>
          <fieldset>
            <h3><div class="icon-pub-message"></div><span><?php _e('Send message to seller', 'tatiana') ; ?></span></h3>
            <div class="contact-desc"><?php _e('Post any questions you have or if you need more information. Spam & Scam are deleted.', 'tatiana') ; ?></div>
            <div class="clear"></div>
            <?php if(osc_is_web_user_logged_in()) { ?>
              <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
              <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
            <?php } else { ?>
              <div class="third">
                <label for="yourName"><span><?php _e('Name', 'tatiana') ; ?></label> 
                <?php ContactForm::your_name(); ?>
                <div class="small-info"><?php _e('Real name or Username', 'tatiana'); ?></div>
              </div>
              <div class="third">
                <label for="yourEmail"><span><?php _e('E-mail', 'tatiana') ; ?></span><span class="req">*</span></label> 
                <?php ContactForm::your_email(); ?>
                <div class="small-info"><?php _e('Where will sender reply', 'tatiana'); ?></div>
              </div>                  
            <?php }; ?>
            <div class="third" id="tit">
              <label for="phoneNumber"><span><?php _e('Phone number', 'tatiana') ; ?></label>
              <?php ContactForm::your_phone_number(); ?>
              <div class="small-info"><?php _e('You will get your answer faster', 'tatiana'); ?></div>
            </div>
             
            <?php ContactForm::your_message(); ?>
            <div class="req-what"><div class="req">*</div><div class="small-info"><?php _e('This field is required', 'tatiana'); ?></div></div>

            <!-- ReCaptcha -->
            <?php if( osc_recaptcha_public_key() ) { ?>
              <script type="text/javascript">
                var RecaptchaOptions = {
                  theme : 'custom',
                  custom_theme_widget: 'recaptcha_widget'
                };
              </script>

              <div id="recaptcha_widget">
                <div id="recaptcha_image"><img /></div>
                <span class="recaptcha_only_if_image"><?php _e('Enter the words above','tatiana'); ?>:</span>
                <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                <div><a href="javascript:Recaptcha.showhelp()"><?php _e('Help', 'tatiana'); ?></a></div>
              </div>
            <?php } ?>
            <?php osc_show_recaptcha(); ?>

            <button type="submit" id="blue"><?php _e('Send', 'tatiana') ; ?></button>
            <div onclick="document.getElementById('message').value = '';document.getElementById('yourName').value = '';document.getElementById('yourEmail').value = '';document.getElementById('phoneNumber').value = '';" class="clear-button-contact button gray-button round3">Clear</div>
          </fieldset>
          </form>
        </div>
      </div>
    <?php } ?>

    <div class="latest_ads ad_list">
      <div class="gallery-list">
        <h2><div class="icon-pub-lat"></div><span><?php _e('Latest listings', 'tatiana'); ?></span></h2>

        <?php $class = "odd" ; $second = true;?>
        <table border="0" cellspacing="0">
        <tbody>
          <?php $class = "odd" ; $second = true;?>
          <?php while(osc_has_items())  { if (1==1 /* !osc_item_is_premium() */) {  ?>
            <tr class="<?php echo $class; ?>" <?php if(Params::getParam('new_window')) { ?>onclick="window.open('<?php echo osc_item_url();?>', '_blank');"<?php } else { ?>onclick="location.href='<?php echo osc_item_url();?>';window.open('#', '_self');"<?php } ?>>
              <?php if( osc_images_enabled_at_items() ) { ?>
                <td class="photo">
                  <?php if(osc_count_item_resources()) { ?>
                    <a href="<?php echo osc_item_url() ; ?>"><img class="round2" src="<?php echo osc_resource_thumbnail_url() ; ?>" width="150" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>"/></a>
                  <?php } else { ?>
                    <a href="<?php echo osc_item_url() ; ?>"><img class="round2" src="<?php echo osc_current_web_theme_url('images/no-image.png') ; ?>" width="150" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>" /></a>
                  <?php } ?>
                </td>
              <?php } ?>

              <td class="text">      
                <h3><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title(); ?>"><?php echo ucfirst( osc_highlight( strip_tags( osc_item_title() ), 25 ) ); ?></a></h3>
                <?php if( osc_price_enabled_at_items() ) { echo '<div class="zoznam_cena round2">' . osc_item_formated_price() . '</div>'; } ?>
                <div class="zoznam_views"><div class="icon-latest-views"></div></span><?php echo osc_item_views();?>x</span></div>
                <div class="zoznam_views phot"><div class="icon-count-photos"></div></span><?php echo osc_count_item_resources();?>x</span></div>
                <div class="zoznam_desc"><?php echo osc_highlight(osc_item_description(), 60); ?></div>
                <div class="zoznam_dole">
                  <span class="zoznam_country"><?php if(osc_item_country() <> '') { echo osc_item_country() . ' &middot; '; } ?></span>
                  <span class="zoznam_region"><?php if(osc_item_region() <> '') { echo osc_item_region() . ' &middot; '; } ?></span>
                  <span class="zoznam_city"><?php if(osc_item_city() <> '') { echo osc_item_city() . ' &middot; '; } ?></span>
                  <span class="zoznam_datum"><?php echo osc_format_date(osc_item_pub_date()); ?></span>
                </div>
              </td>
            </tr>
            <?php if($second) { $class = ($class == 'even') ? 'odd' : 'even' ; $second = false; } else {$second = true; } ?>
          <?php } ?>
        <?php } ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>