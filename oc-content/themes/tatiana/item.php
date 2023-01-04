<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <!-- <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('fancybox/jquery.fancybox.js') ; ?>"></script> -->
  <link href="<?php echo osc_current_web_theme_js_url('fancybox/jquery.fancybox.css') ; ?>" rel="stylesheet" type="text/css" />
  <!-- <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script> -->
</head>
<body>         
  <?php osc_current_web_theme_path('header.php') ; ?>
  <?php if( osc_item_is_expired () ) { ?><div id="exp_box"></div><div id="exp_mes"><?php _e('This listing has expired.', 'tatiana'); ?></div><?php } ?>
  <div class="content">
    <div id="i-block">
      
      <div id="left-block">
        <div class="keep-header">
          <h1><?php echo osc_item_category(). ' - ' . ucfirst(osc_item_title()); ?></h1>

          <div id="report">
            <div class="cont-wrap">
              <div class="cont-top-arrow"></div>
                <div class="cont round4">
                <a id="item_spam" href="<?php echo osc_item_link_spam() ; ?>" rel="nofollow"><?php _e('spam', 'tatiana') ; ?></a>
                <a id="item_bad_category" href="<?php echo osc_item_link_bad_category() ; ?>" rel="nofollow"><?php _e('misclassified', 'tatiana') ; ?></a>
                <a id="item_repeated" href="<?php echo osc_item_link_repeated() ; ?>" rel="nofollow"><?php _e('duplicated', 'tatiana') ; ?></a>
                <a id="item_expired" href="<?php echo osc_item_link_expired() ; ?>" rel="nofollow"><?php _e('expired', 'tatiana') ; ?></a>
                <a id="item_offensive" href="<?php echo osc_item_link_offensive() ; ?>" rel="nofollow"><?php _e('offensive', 'tatiana') ; ?></a>
              </div>
            </div>
          </div>

          <?php if (function_exists('show_printpdf')) { ?>
            <a id="print_pdf" href="<?php echo osc_base_url(); ?>oc-content/plugins/printpdf/download.php?item=<?php echo osc_item_id(); ?>"><img id="print_pdf_img" src="<?php echo osc_base_url(); ?>oc-content/themes/tatiana/images/print_pdf.png" /></a>
          <?php } ?>
          
          <?php if (function_exists('print_ad')) { print_ad();} ?>

          <script>function fbs_click() {u=location.href;t=document.title;window.open('https://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script>
          <a id="face" href="https://www.facebook.com/share.php?u=<url>" onclick="return fbs_click()" target="_blank"><img src="<?php echo osc_base_url() .'oc-content/themes/tatiana/images/facebook-icon-item.png'; ?>"></a>

          <?php if (function_exists('watchlist')) { watchlist(); } ?>
        </div>
        <div class="keep-under"></div>
        <div class="details">
          <?php if (osc_item_pub_date() != '') { echo '<div class="element"><div class="icon-pub"></div><span>' . __('Published on', 'tatiana') . ' <span class="bold">' . osc_format_date(osc_item_pub_date()) . '</span></span></div>';} ?>
          <?php if (osc_item_mod_date() != '') { echo '<div class="element"><div class="icon-mod"></div><span>' . __('Modified on', 'tatiana') . ' <span class="bold">' . osc_format_date(osc_item_mod_date()) . '</span></span></div>';} ?>
          <?php if (osc_item_contact_name() != '') { echo '<div class="element"><div class="icon-user"></div><span>' . __('Published by', 'tatiana') . ' <span class="bold">' . osc_item_contact_name() . '</span></span></div>'; } ?>
          <?php if (osc_item_views() != '') { echo '<div class="element"><div class="icon-view"></div><span>' . __('Viewed by', 'tatiana') . ' <span class="bold">' . osc_item_views() . '</span> ' . __('people', 'tatiana') . '</span></div>';} ?>
          <div class="del"></div>
        </div>
        <div id="left">
          <div id="short-info">
            <div class="item_id round3" title="<?php _e('This is unique ID of this listing, if you have problems or you think this is fraud, you can contact website owner to report this listing using ID.', 'tatiana');?>">#<?php echo osc_item_id();?></div>
            <div class="cat round3" title="<?php _e('You will be redirected to category this listing belongs to.', 'tatiana');?>"><a href="<?php echo osc_search_category_url();?>"><?php echo osc_item_category(); ?></a></div> 
            <?php if(function_exists('ListingStatus')) { if(ListingStatus() <> '') { ?><div class="status round3" title="<?php echo __('Status of offered item. This item is', 'tatiana') . ' ' . ListingStatus();?>"><?php echo ListingStatus(); ?></div><?php } } ?> 
            <?php if( osc_price_enabled_at_items() ) { ?><div class="price round3" title="<?php _e('Price of item offered in this listing, shown in currency of seller.', 'tatiana');?>"><?php echo osc_item_formated_price(); ?></div> <?php } ?>
          </div>
          <div class="clear"></div>

          <h2><div class="icon-item-desc"></div><span><?php _e('Description of item', 'tatiana'); ?></span></h2>
          <div class="del"></div>
          <div class="desc round3">
            <div class="text"><?php echo osc_item_description(); ?></div>
          </div>

          <h2><div class="icon-item-loc"></div><span><?php _e('Location', 'tatiana'); ?></span></h2>
          <div class="del"></div>
          <?php $switcher = -1;$many = 1; ?>
          <div class="item_location">
            <?php if ( osc_item_country() != "" ) { ?><div class="left <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} ?>"><?php _e("Country", 'tatiana'); ?></div><div class="right <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} if($many == 1) {$switcher = $switcher * (-1); $many = 0;} else {$many = 1;} ?>"><?php echo osc_item_country(); ?></div><?php } ?>
            <?php if ( osc_item_region() != "" ) { ?><div class="left <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} ?>"><?php _e("Region", 'tatiana'); ?></div><div class="right <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} if($many == 1) {$switcher = $switcher * (-1); $many = 0;} else {$many = 1;} ?>"><?php echo osc_item_region(); ?></div><?php } ?>
            <?php if ( osc_item_city() != "" ) { ?><div class="left <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} ;?>"><?php _e("City", 'tatiana'); ?></div><div class="right <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} if($many == 1) {$switcher = $switcher * (-1); $many = 0;} else {$many = 1;} ?>"><?php echo osc_item_city(); ?></div><?php } ?>
            <?php if ( osc_item_address() != "" ) { ?><div class="left <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} ?>"><?php _e("Address", 'tatiana'); ?></div><div class="right <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} if($many == 1) {$switcher = $switcher * (-1); $many = 0;} else {$many = 1;} ?>"><?php echo osc_item_address(); ?></div><?php } ?>
          </div>

          <?php osc_run_hook('location') ; ?>

          <?php $has_custom = false; ?>
          <div id="custom_fields">
            <?php if( osc_count_item_meta() >= 1 ) { ?>
              <div class="meta_list">
                <h2><?php _e('Other information','tatiana'); ?></h2>
                <div class="del"></div>
                <?php while ( osc_has_item_meta() ) { ?>
                  <?php if(osc_item_meta_value()!='') { ?>
                    <?php $has_custom = true; ?>
                    <div class="meta">
                      <span><?php echo osc_item_meta_name(); ?>:</span> <?php echo osc_item_meta_value(); ?>
                    </div>
                  <?php } ?>
                <?php } ?>
              </div>
            <?php } ?>
          </div>
          <?php osc_run_hook('item_detail', osc_item() ) ; ?>  
  
        </div>

        <?php if( osc_comments_enabled() ) { ?>
          <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
            <div id="comments">
              <h2><div class="icon-comment"></div><span><?php echo __('Review & feedback on', 'tatiana') . ' ' . ucfirst(osc_item_title()); ?><span class="smalli">(<?php echo osc_item_total_comments();?>)</span></span></h2>
              <ul id="comment_error_list"></ul>
              <?php CommentForm::js_validation(); ?>
              <?php if( osc_count_item_comments() >= 1 ) { ?>
                <div class="comments_list">
                  <?php $class = 'even'; ?>
                  <?php while ( osc_has_item_comments() ) { ?>
                    <div class="comment-wrap <?php echo $class; ?>" onclick="this.style.display = 'none';">
                      <div class="hide"><?php _e('Click to hide', 'tatiana'); ?></div>
                      <div class="comment-image">
                        <?php if(function_exists('profile_picture_show')) { profile_picture_show(40, 'comment'); } ?>
                      </div>
                      <div class="comment">
                        <h3><span class="bold"><?php if(osc_comment_title() == '') { _e('Review', 'tatiana'); } else { echo osc_comment_title(); } ?></span> <?php _e('by', 'tatiana') ; ?> <span class="bold"><?php if(osc_comment_title() == '') { _e('Anonymous', 'tatiana'); } else { echo osc_comment_author_name(); } ?></span>:</h3>
                        <div><?php echo osc_comment_body() ; ?></div>
                        <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
                          <div>
                            <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php _e('Delete your comment', 'tatiana'); ?>"><?php _e('Delete', 'tatiana'); ?></a>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="clear"></div>
                    <?php $class = ($class == 'even') ? 'odd' : 'even'; ?>
                  <?php } ?>
                  <div class="pagination"><?php echo osc_comments_pagination(); ?></div>
                </div>
              <?php } ?>

              <div class="add_com round3"><h4><div class="icon-com-plus"></div><span><?php if(osc_count_item_comments() >= 1) { _e('Add your review or feedback', 'tatiana'); } else { _e('Be first to review or feedback', 'tatiana');} ?></span></h4><div class="keep_arrow"><div class="icon-comment-arrow"></div><div class="icon-comment-arrow"></div></div></div>

              <div id="comment_form_wrap">
                <form action="<?php echo osc_base_url(true) ; ?>" method="post" name="comment_form" id="comment_form" class="round4">
                <fieldset>
                  <h3><div class="icon-comment-add"></div><span><?php _e('Add new review', 'tatiana') ; ?></span></h3>
                  <div class="comment-desc"><?php _e('Post any questions you have or your experience with this item or seller. All comments are moderated', 'tatiana') ; ?></div>
                  <div class="clear"></div>
                  <input type="hidden" name="action" value="add_comment" />
                  <input type="hidden" name="page" value="item" />
                  <input type="hidden" name="id" value="<?php echo osc_item_id() ; ?>" />
                  <?php if(osc_is_web_user_logged_in()) { ?>
                    <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
                    <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
                  <?php } else { ?>
                    <div class="third">
                      <label for="authorName"><?php _e('Name', 'tatiana') ; ?></label> 
                      <?php CommentForm::author_input_text(); ?>
                      <div class="small-info"><?php _e('Real name or Username', 'tatiana'); ?></div>
                    </div>
                    <div class="third">
                      <label for="authorEmail"><span><?php _e('E-mail', 'tatiana') ; ?></span><span class="req">*</span></label> 
                      <?php CommentForm::email_input_text(); ?>
                      <div class="small-info"><?php _e('Will not be published', 'tatiana'); ?></div>
                    </div>                  
                  <?php }; ?>
                  <div class="third" id="tit">
                    <label for="title"><?php _e('Title', 'tatiana') ; ?></label>
                    <?php CommentForm::title_input_text(); ?>
                    <div class="small-info"><?php _e('Review, feedback or question', 'tatiana'); ?></div>
                  </div>
                
                  <?php CommentForm::body_input_textarea(); ?>
                  <div class="req-what"><div class="req">*</div><div class="small-info"><?php _e('This field is required', 'tatiana'); ?></div></div>

                  <div style="float:left;clear:both;width:100%;margin:5px 0 10px 0;">
                    <?php osc_run_hook("anr_captcha_form_field"); ?>
                  </div>

                  <button type="submit" id="blue"><?php _e('Send', 'tatiana') ; ?></button>
                  <div onclick="document.getElementById('body').value = '';document.getElementById('title').value = '';document.getElementById('authorName').value = '';document.getElementById('authorEmail').value = '';" class="clear-button-comment button gray-button round3"><?php _e('Clear' , 'tatiana'); ?></div>
                </fieldset>
                </form>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>

      <div id="right">
        <?php if( osc_images_enabled_at_items() and osc_count_item_resources() > 0 ) { ?>  
          <div class="right-header">
            <div class="text"><?php _e('Photos', 'tatiana'); ?></div>
          </div>
          <div class="keep-under"></div>

          <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
            <?php if($i == 1 and osc_count_item_resources() > 1) { echo '<div id="photos-block">'; } ?>
            <a <?php if( $i <> 0 ) { echo ' id="img-link" '; } ?>href="<?php echo osc_resource_url(); ?>" rel="image_group" title="<?php _e('Image', 'tatiana'); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>">
              <?php if( $i == 0 ) { ?>
                <img id="big-img" src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" />
              <?php } else { ?>
                <img id="small-img" class="round2" src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" />
              <?php } ?>
            </a>
          <?php } ?>
          <?php if(osc_count_item_resources() > 1) { echo '</div>'; } ?> 
          <div class="marginer"></div>
        <?php } ?>

        <div id="c-seller">
          <div class="contact-header">
            <div class="text">
              <span><?php _e('Seller information', 'tatiana'); ?></span>
              <?php if(function_exists('profile_picture_show')) { echo '<a href="' . osc_user_public_profile_url(osc_item_user_id()) . '" title="' . __('Check profile of this user', 'tatiana') . '">';  profile_picture_show(null, null, 33); echo '</a>'; } ?>
            </div>
          </div>
          <div class="keep-under"></div>

          <?php 
            if(osc_item_user_id() <> 0) {
              $item_user = User::newInstance()->findByPrimaryKey(osc_item_user_id());
            }
          ?>

          <?php 
            $mobile = '';
            if($mobile == '') { $mobile = osc_item_city_area(); }      
            if($mobile == '' && osc_item_user_id() <> 0) { $mobile = $item_user['s_phone_mobile']; }      
            if($mobile == '' && osc_item_user_id() <> 0) { $mobile = $item_user['s_phone_land']; }      
            if($mobile == '') { $mobile = __('No phone number', 'tatiana'); }      
          ?> 

          <div class="info">
            <?php if( osc_item_user_id() != null ) { ?>
               <div class="name-ico"></div><div class="left"><?php _e('Name', 'tatiana') ?></div><div class="right"><span><a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>" ><?php echo osc_item_contact_name(); ?></a></span><div class="icon-item-right"></div></div><div class="swap"></div>
            <?php } else { ?>
               <div class="name-ico"></div><div class="left"><?php _e('Name', 'tatiana') ?></div><div class="right"><?php echo osc_item_contact_name();?></div><div class="swap"></div>
            <?php } ?>
            <?php if( osc_item_show_email() ) { ?>
               <div class="email-ico"></div><div class="left"><?php _e('E-mail', 'tatiana'); ?></div><div class="right"><?php echo osc_item_contact_email(); ?></div><div class="swap"></div>
            <?php } ?>
            <div class="mob-ico"></div><div class="left"><?php _e('Phone', 'tatiana'); ?></div><div class="right mobile-show" rel="<?php echo $mobile; ?>">
              <span>
              <?php 
                if(strlen($mobile) > 3 and $mobile <> __('No phone number', 'tatiana')) {
                  echo substr($mobile, 0, strlen($mobile) - 3) . 'XXX'; 
                } else {
                  echo $mobile;
                }
              ?>
              </span>

              <?php if(strlen($mobile) > 3 and $mobile <> __('No phone number', 'tatiana')) { ?>
                <div id="mobile-text"><?php _e('Click to show phone number', 'tatiana'); ?></div>
              <?php } ?>

            </div><div class="swap"></div>
            <div class="reg-ico"></div><div class="left"><?php _e('Registered', 'tatiana'); ?></div><div class="right"><?php if(osc_user_regdate() != '') { echo osc_format_date(osc_user_regdate()); } else { echo '-';} ?></div><div class="swap"></div>
            <div class="loc-ico"></div><div class="left"><?php _e('Location', 'tatiana'); ?></div><div class="right"><?php if(osc_item_city() != '') { echo osc_item_city(); } else { echo osc_user_city();} if(osc_user_city() != '' or osc_item_city() != '') { echo ' in ';}  if(osc_user_region() != '') {echo osc_user_region();} else {echo osc_item_region();} if(osc_user_country() != '') { echo ', ' . osc_user_country();} else {echo ', ' . osc_item_country();} ?></div><div class="swap"></div>
            <?php if(osc_user_website() <> '' and osc_user_website() <> 'http://') { ?><div class="url-ico"></div><div class="left"><?php _e('Website', 'tatiana'); ?></div><div class="right"><?php echo '<a href="' . osc_user_website() . '" title="' . osc_user_website() . '" class="url-user" target="_blank" rel="nofollow">' . osc_user_website() . '</a>'; ?></div><div class="swap"></div><?php } ?>

            <div class="list_all">
              <?php if(function_exists('seller_post')) { if ( osc_item_user_id() != 0 ) { ?><?php seller_post(); ?><span class="num">(<?php $user = User::newInstance()->findByPrimaryKey(osc_item_user_id());$num_items_user = $user['i_items'];echo $num_items_user;?>)</span><?php } else {echo '<span>' . __('Unregistered user', 'tatiana') . '</span>';}} else {echo '<span>' . __('Unregistered user', 'tatiana') . '<span>';} ?>
              <a href="<?php echo osc_item_send_friend_url(); ?>" rel="nofollow"><?php _e('Send to friend', 'tatiana'); ?></a>
            </div>
          </div>

          <div id="right-seller">
            <div id="but-con" class="button blue-button round3"><?php _e('Contact seller', 'tatiana'); ?></div>

            <div class="inner-block">
              <?php if( osc_item_is_expired () ) { ?>
                <div class="empty" style="margin-top:8px;margin-bottom:0">
                  <?php _e('This listing expired, you cannot contact seller.', 'tatiana') ; ?>
                </div>
              <?php } else if( (osc_logged_user_id() == osc_item_user_id()) && osc_logged_user_id() != 0 ) { ?>
                <div class="empty" style="margin-top:8px;margin-bottom:0">
                  <?php _e('It is your own listing, you cannot contact yourself.', 'tatiana') ; ?>
                </div>
              <?php } else if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?>
                <div class="empty" style="margin-top:8px;margin-bottom:0">
                  <?php _e('You must log in or register a new account in order to contact the advertiser.', 'tatiana') ; ?>
                </div>

                <div class="log-reg">
                  <a href="<?php echo osc_user_login_url() ; ?>"><?php _e('Login', 'tatiana') ; ?></a>
                  <a href="<?php echo osc_register_account_url() ; ?>"><?php _e('Register for a free account', 'tatiana'); ?></a>
                </div>
              <?php } else { ?> 
                <ul id="error_list"></ul>
                <?php ContactForm::js_validation(); ?>

                <form action="<?php echo osc_base_url(true) ; ?>" method="post" name="contact_form" id="contact_form">
                <input type="hidden" name="action" value="contact_post" />
                <input type="hidden" name="page" value="item" />
                <input type="hidden" name="id" value="<?php echo osc_item_id() ; ?>" />

                <?php osc_prepare_user_info() ; ?>
                <fieldset class="round3">
                  <h3><div class="icon-message"></div><span><?php _e('Send message to seller', 'tatiana') ; ?></span></h3>
                  <div class="del"></div>

                  <label><?php _e('Name', 'tatiana') ; ?></label>
                  <?php ContactForm::your_name(); ?>

                  <label><span><?php _e('E-mail', 'tatiana'); ?></span><span class="req">*</span></label>
                  <?php ContactForm::your_email(); ?>

                  <label><span><?php _e('Message', 'tatiana') ; ?></span><span class="req">*</span></label>
                  <?php ContactForm::your_message(); ?>
                  <div class="req-what"><div class="req">*</div><div class="small-info"><?php _e('This field is required', 'tatiana'); ?></div></div>

                  <?php osc_run_hook('item_contact_form', osc_item_id()); ?>

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

                  <button type="submit" id="green"><?php _e('Send message', 'tatiana') ; ?></button>
                  <div onclick="document.getElementById('message').value = '';document.getElementById('yourName').value = '';document.getElementById('yourEmail').value = '';" class="clear-button button gray-button round3">Clear</div>
                </fieldset>
                </form>
              <?php } ?>

              <div id="useful-info">
                <div class="useful-header round3"><div class="icon-security"></div><span>Security Tips</span></div>
                <ul class="useful-list">
                  <li><?php _e('Avoid scams by acting locally or paying with PayPal', 'tatiana'); ?></li>
                  <li><?php _e('Never pay with Western Union, Moneygram or other anonymous payment services', 'tatiana'); ?></li>
                  <li><?php _e('Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country', 'tatiana'); ?></li>
                  <li><?php _e('This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer "buyer protection" or "seller certification"', 'tatiana') ; ?></li>
                </ul>

                <div class="useful-more">
                  <?php _e('For more information visit our', 'tatiana');?> <a target="_blank" href="<?php echo osc_base_url();?>"><?php _e('Security Center', 'tatiana'); ?></a>.
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php if (function_exists('related_ads_start')) {related_ads_start();} ?>
        <?php if (function_exists('show_qrcode')) { ?>
          <div id="qr-wrap">
            <div id="qr-block">
              <div class="icon-smartphone"></div>
              <h3><?php _e('Save this listing to your', 'tatiana'); ?><span class="bold"><?php echo ' ' .  __('SmartPhone', 'tatiana') . ' ';?></span><?php _e('or', 'tatiana'); ?><span class="bold"><?php echo ' ' . __('Tablet', 'tatiana');?></span>!</h3>
            </div>
            <?php show_qrcode(); ?>
          </div>

          <div id="qr-wrap-alt">
            <h3><?php _e('Save this listing to your', 'tatiana'); ?><span class="bold"><?php echo ' ' .  __('SmartPhone', 'tatiana') . ' ';?></span><?php _e('or', 'tatiana'); ?><span class="bold"><?php echo ' ' . __('Tablet', 'tatiana');?></span>!</h3>
            <?php show_qrcode(); ?>
          </div>
        <?php } ?>

        <?php if(osc_get_preference('theme_adsense', 'tatiana_theme') == 1) { ?>
          <div class="adsense-item">
            <?php echo osc_get_preference('banner_item', 'tatiana_theme'); ?>        
          </div>
        <?php } ?>

      </div>
    </div>
  </div>
     
<?php 
  $mobile_text = osc_base_url();
  $mobile_text = str_replace('http://', '', $mobile_text);
  $mobile_text = str_replace('www.', '', $mobile_text);
  $mobile_text = str_replace('/', '', $mobile_text);
?>
     
  <!-- Scripts -->
  <script type="text/javascript">
  $(document).ready(function(){

    $('.comment-wrap').hover(function(){
      $(this).find('.hide').show();}, 
      function(){
      $(this).find('.hide').hide();
    }); 

    $('#but-con').click(function(){
      $(".inner-block").slideToggle();
      $("#rel_ads").slideToggle();
    }); 

    $('#comment_form_wrap').hide();
    $('.add_com').click(function() {
      $('#comment_form_wrap').slideDown();
    });

    $('#c-seller .info .right a').hover(function(){
      $('.icon-item-right').css({'margin-left':'3.5%'});}, 
      function(){
      $('.icon-item-right').css({'margin-left':'2.5%'});
    }); 

    $('.mobile-show').click(function() {
      $(this).find('span').text($(this).attr('rel'));
      $('#mobile-text').text("<?php echo __('Do not forget to tell you found this offer on', 'tatiana') . ' ' . $mobile_text; ?>");
      $('#mobile-text').css('margin-top', -$('#mobile-text').height() + 15);
    });

    $('#mobile-text').hide(0);
    $('.mobile-show').hover(function() {
      $('#mobile-text').stop(true, true).fadeIn(300);
    }, function() {
      $('#mobile-text').stop(true, true).delay(500).fadeOut(300);
    });
    
    <?php if(!$has_custom) { echo '$("#custom_fields").hide();';} ?>
  });

  $(document).mouseup(function (e) {
    var container = $('.watchlist a');
    if (!container.is(e.target) && container.has(e.target).length === 0) { container.hide('slow'); }
  });
  </script>


  <!-- CHECK IF PRICE IN THIS CATEGORY IS ENABLED -->
  <script>
  $(document).ready(function(){
    var cat_id = <?php echo osc_item_category_id(); ?>;
    var catPriceEnabled = new Array();

    <?php
      $categories = Category::newInstance()->listAll( false );
      foreach( $categories as $c ) {
        if( $c['b_price_enabled'] != 1 ) {
          echo 'catPriceEnabled[ '.$c['pk_i_id'].' ] = '.$c[ 'b_price_enabled' ].';';
        }
      }
    ?>

    if(catPriceEnabled[cat_id] == 0) {
      $("#i-block .price").hide(0);
    }
  });
  </script>


  <?php osc_current_web_theme_path('footer.php') ; ?>
  </body>
</html>			