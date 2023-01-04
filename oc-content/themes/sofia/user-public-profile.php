<?php
  $user_items = osc_user_items_validated();
  $user_comments = osc_user_comments_validated();

  $now = time();
  $your_date = strtotime(osc_user_regdate());
  $datediff = $now - $your_date;
  $user_days = floor($datediff/(60*60*24));

  $address = array(osc_user_city_area(), osc_user_address());
  $address = array_filter($address);
  $address = implode(', ', $address);
  
  $loc = array(osc_user_country(), osc_user_region(), osc_user_city());
  $loc = array_filter($loc);
  $loc = implode(', ', $loc);

  osc_enqueue_script('jquery-validate');
  $user_keep = osc_user(); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
  <head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
  </head>
  <body id="pub_profile">
    <?php osc_current_web_theme_path('header.php'); ?>
    <?php View::newInstance()->_exportVariableToView('user', $user_keep); ?>

      <div id="item_head">
        <div class="inner">
          <h1>
            <div><?php echo sprintf(__('%s\'s profile', 'sofia'), osc_user_name()); ?></div>
            <div class="tag green round3">
              <i class="fa fa-caret-left"></i>
              <?php if($user_items == 1) { ?>
                <?php echo $user_items . ' ' . __('item', 'sofia'); ?>
              <?php } else { ?>
                <?php echo $user_items . ' ' . __('items', 'sofia'); ?>
              <?php } ?>
            </div>

            <div class="tag orange round3">
              <i class="fa fa-caret-left"></i>
              <?php if($user_comments == 1) { ?>
                <?php echo $user_comments . ' ' . __('comment', 'sofia'); ?>
              <?php } else { ?>
                <?php echo $user_comments . ' ' . __('comments', 'sofia'); ?>
              <?php } ?>
            </div>

            <div class="tag blue round3">
              <i class="fa fa-caret-left"></i>
              <?php if($user_days == 1) { ?>
                <?php echo $user_days . ' ' . __('day registered', 'sofia'); ?>
              <?php } else { ?>
                <?php echo $user_days . ' ' . __('days registered', 'sofia'); ?>
              <?php } ?>
            </div>
          </h1>
        </div>
      </div>
    <div class="content user_public_profile">
      
      <div id="main">
        <div id="description-public">
        <h2><i class="fa fa-user"></i>&nbsp;<?php _e('Profile', 'sofia'); ?></h2>
        <div class="del"></div>
          <ul id="user_data">
            <li>
              <span class="left"><?php _e('Full name', 'sofia'); ?>:</span> 
              <span class="right"><?php echo osc_user_name(); ?></span>
            </li>
            
            <?php if($address <> '') { ?>
              <li>
                <span class="left"><?php _e('Address', 'sofia'); ?>:</span> 
                <span class="right"><?php echo $address; ?></span>
              </li>
            <?php } ?>
            
            <?php if($loc <> '') { ?>
              <li>
                <span class="left"><?php _e('Location', 'sofia'); ?>:</span> 
                <span class="right"><?php echo $loc; ?></span>
              </li>
            <?php } ?>
            
            <?php if(osc_user_website() <> '' && osc_user_website() <> 'http://') { ?>
              <li>
                <span class="left"><?php _e('Website', 'sofia'); ?>:</span>
                <span class="right"><?php echo '<a href="' . osc_user_website() . '" target="_blank" rel="nofollow">' . osc_user_website() . '</a>'; ?></span>
              </li>
            <?php } ?>
            
            <?php if(osc_user_info() <> '') { ?>
              <li>
                <span class="left"><?php _e('Description', 'sofia'); ?>:</span>
                <span class="right"><?php echo osc_user_info(); ?></span>
              </li>
            <?php } ?>
          </ul>
        </div>
        <div id="description" class="ad_list">
          <div id="regular-header"><div id="regular-span"><?php _e('Latest listings', 'sofia'); ?></div></div>
            <table border="0" cellspacing="0">
              <tbody>
                <?php $class = "even"; ?>
                <?php while(osc_has_items()) { ?>
                  <tr class="<?php echo $class; ?>">
                    <?php if( osc_images_enabled_at_items() ) { ?>
                     <td class="photo">
                       <?php if(osc_count_item_resources()) { ?>
                        <a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" width="150" height="125" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" /></a>
                      <?php } else { ?>
                        <a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" width="150" height="125"/></a>
                      <?php } ?>
                     </td>
                     <?php } ?>
                     <td class="text">
                       <div id="search-list">
                        <?php if( osc_price_enabled_at_items() ) { ?>
                        <div class="price"><?php echo osc_item_formated_price(); } ?></div>
                        <div class="cat"><?php  echo osc_item_category(); ?></div>
                        <div class="date"><?php echo date("d-m-Y", strtotime(osc_item_pub_date())); ?></div>
                        <?php if(osc_item_city() <> '') { ?><div class="other"><?php  echo osc_item_city(); ?></div><?php } ?>
                        <?php if(osc_item_region() <> '') { ?><div class="other"><?php echo osc_item_region(); ?></div><?php } ?>
                       </div>
                       <h3>
                        <a href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight( strip_tags( osc_item_title() ) ); ?></a>
                        <a href="<?php echo osc_item_url(); ?>"><i class="fa fa-folder"></i><i class="fa fa-folder-open"></i></a>
                       </h3>           
                       <p class="desc"><?php echo osc_highlight( strip_tags( osc_item_description() ), 130); ?></p>
                       <p class="go-more">
                         <a id="more-link" href="<?php echo osc_item_url(); ?>">
                           <?php _e('see more details', 'sofia'); ?><?php if (osc_count_premium_resources()>0) { 
                           echo ' ' . __('and', 'sofia') . ' '; 
                           echo osc_count_premium_resources();
                           if(osc_count_premium_resources()>1) { echo ' ' . __('photos', 'sofia'); } else { echo ' ' . __('photo', 'sofia'); } } ?>      
                         </a>
                       </p>
                     </td>
                   </tr>
                  <?php $class = ($class == 'even') ? 'odd' : 'even'; ?>
                <?php } ?>
              </tbody>
            </table>
          <?php if(osc_search_total_pages() > osc_max_results_per_page_at_search() ) { ?>
          <p class="see_more_link"><a href="<?php echo osc_base_url(true).'&page=search&sUser[]='.osc_user_id(); ?>"><strong><?php _e('See all offers', 'sofia'); ?></strong></a></p>
          <?php } ?>
        </div>
      </div>
      <div id="sidebar">
        <?php if(osc_logged_user_id()!=  osc_user_id()) { ?>
        <?php if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
        <div id="contact-public">
          <h2><i class="fa fa-envelope-o"></i>&nbsp;<?php _e("Contact publisher", 'sofia'); ?></h2>
          <div class="del"></div>
          <ul id="error_list"></ul>
          <?php ContactForm::js_validation(); ?>
          <form action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" id="contact_form">
            <input type="hidden" name="action" value="contact_post" />
            <input type="hidden" name="page" value="user" />
            <input type="hidden" name="id" value="<?php echo osc_user_id();?>" />
            <?php //osc_prepare_user_info(); ?>
            <fieldset>
              <label for="yourName"><?php _e('Your name', 'sofia'); ?>:</label> <?php ContactForm::your_name(); ?>
              <label for="yourEmail"><?php _e('Your e-mail address', 'sofia'); ?>:</label> <?php ContactForm::your_email(); ?>
              <label for="phoneNumber"><?php _e('Phone number', 'sofia'); ?> (<?php _e('optional', 'sofia'); ?>):</label> <?php ContactForm::your_phone_number(); ?>
              <label for="message"><?php _e('Message', 'sofia'); ?>:</label> <?php ContactForm::your_message(); ?>
              <?php if( osc_recaptcha_public_key() ) { ?>
              <script type="text/javascript">
                var RecaptchaOptions = {
                  theme : 'custom',
                  custom_theme_widget: 'recaptcha_widget'
                };
              </script>
              <style type="text/css"> div#recaptcha_widget, div#recaptcha_image > img { width:280px; } </style>
              <div id="recaptcha_widget">
                <div id="recaptcha_image"><img /></div>
                <span class="recaptcha_only_if_image"><?php _e('Enter the words above','sofia'); ?>:</span>
                <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                <div><a href="javascript:Recaptcha.showhelp()"><?php _e('Help', 'sofia'); ?></a></div>
              </div>
              <?php } ?>
              <?php osc_show_recaptcha(); ?>
              <button type="submit"><?php _e('Send', 'sofia'); ?></button>
            </fieldset>
          </form>
        </div>
        <?php   } ?>
        <?php } ?>
      </div>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?>
  </body>
</html>