<?php
  osc_register_script('fancybox', osc_current_web_theme_js_url('fancybox/jquery.fancybox.js'), array('jquery'));
  osc_enqueue_script('fancybox');
  osc_enqueue_script('jquery-validate');
  osc_enqueue_style('fancybox', osc_current_web_theme_js_url('fancybox/jquery.fancybox.css'));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
  <head>
    <?php osc_current_web_theme_path('head.php'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $("a[rel=image_group]").fancybox({
          openEffect : 'none',
          closeEffect : 'none',
          nextEffect : 'fade',
          prevEffect : 'fade',
          loop : false,
          helpers : {
            title : {
              type : 'inside'
            }
          }
        });
      });
    </script>
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow" />
  </head>
  
  <body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="content item">
      <div id="item_head">
        <div class="inner">
          <h1>
            <?php echo osc_item_title();?> - <?php echo osc_item_category(); if (osc_item_city()!='') { _e(' in ', 'sofia'); echo osc_item_city();} ?>
          </h1>
        </div>

        <div class="short-wrap">
          <div id="report">
            <div id="inside"><i class="fa fa-flag"></i></div>              
              <span>
                <a id="item_spam" href="<?php echo osc_item_link_spam(); ?>" rel="nofollow"><?php _e('spam', 'sofia'); ?></a>
                <a id="item_bad_category" href="<?php echo osc_item_link_bad_category(); ?>" rel="nofollow"><?php _e('misclassified', 'sofia'); ?></a>
                <a id="item_repeated" href="<?php echo osc_item_link_repeated(); ?>" rel="nofollow"><?php _e('duplicated', 'sofia'); ?></a>
                <a id="item_expired" href="<?php echo osc_item_link_expired(); ?>" rel="nofollow"><?php _e('expired', 'sofia'); ?></a>
                <a id="item_offensive" href="<?php echo osc_item_link_offensive(); ?>" rel="nofollow"><?php _e('offensive', 'sofia'); ?></a>
              </span>
          </div>

          <?php if(function_exists('watchlist')) { ?>
            <a href="javascript://" class="watchlist" id="<?php echo osc_item_id(); ?>" title="<?php echo osc_esc_html(__('Add to watchlist', 'sofia')); ?>"><i class="fa fa-star"></i></a>
          <?php } ?>

          <?php if(function_exists('show_printpdf')) { ?>
            <a href="<?php echo osc_base_url(); ?>oc-content/plugins/printpdf/download.php?item=<?php echo osc_item_id(); ?>" class="printpdf" title="<?php echo osc_esc_html(__('Download PDF sheet of this listing', 'sofia')); ?>"><i class="fa fa-file-pdf-o"></i></a>
          <?php } ?>

          <?php if(function_exists('print_ad')) { print_ad(); } ?>
        </div>
      </div>

      <div class="dates">
        <span class="publish"><?php if ( osc_item_pub_date() != '' ) {?><strong><?php echo __('Published date', 'sofia') . ':</strong> ' . osc_format_date( osc_item_pub_date() ); } ?></span>
        <span class="update"><?php if ( osc_item_mod_date() != '' ) {?><strong><?php echo __('Modified date', 'sofia') . ':</strong> ' . osc_format_date( osc_item_mod_date() ); } ?></span>

        <?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) { ?>
          <span id="edit_item_view">
            <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><?php _e('Edit item', 'sofia'); ?></a>
          </span>
        <?php } ?>
      </div>

      <div id="total-main">
        <div id="main">
          <div class="item_id">#<?php echo osc_item_id();?></div>
          <div class="view"><?php echo osc_item_views(); if(osc_item_views() == 1) { _e(' view', 'sofia'); } else { _e(' views', 'sofia') ;}?></div>
          <div class="cat"><a href="<?php echo osc_search_category_url();?>"><?php echo osc_item_category(); ?></a></div> 
          <?php if( osc_price_enabled_at_items() ) { ?><div class="price"><?php echo osc_item_formated_price(); ?></div> <?php } ?>
          <div class="clear"></div>
          <h2><i class="fa fa-th-large"></i><?php _e("Details of listing", 'sofia'); ?>: <?php echo osc_item_title();?></h2> 

          <?php $switcher = -1;$many = 1; ?>
          <div class="item_location">
            <?php if ( osc_item_country() != "" ) { ?><div class="left <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} ?>"><?php _e("Country", 'sofia'); ?></div><div class="right <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} if($many == 1) {$switcher = $switcher * (-1); $many = 0;} else {$many = 1;} ?>"><?php echo osc_item_country(); ?></div><?php } ?>
            <?php if ( osc_item_region() != "" ) { ?><div class="left <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} ?>"><?php _e("Region", 'sofia'); ?></div><div class="right <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} if($many == 1) {$switcher = $switcher * (-1); $many = 0;} else {$many = 1;} ?>"><?php echo osc_item_region(); ?></div><?php } ?>
            <?php if ( osc_item_city() != "" ) { ?><div class="left <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} ;?>"><?php _e("City", 'sofia'); ?></div><div class="right <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} if($many == 1) {$switcher = $switcher * (-1); $many = 0;} else {$many = 1;} ?>"><?php echo osc_item_city(); ?></div><?php } ?>
            <?php if ( osc_item_address() != "" ) { ?><div class="left <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} ?>"><?php _e("Address", 'sofia'); ?></div><div class="right <?php if($switcher == -1) { echo 'strong';} else {echo 'weak';} if($many == 1) {$switcher = $switcher * (-1); $many = 0;} else {$many = 1;} ?>"><?php echo osc_item_address(); ?></div><?php } ?>
          </div>
          <h2><i class="fa fa-tasks"></i><?php _e("Additional information", 'sofia'); ?></h2>

          <div id="description">
            <div class="des">
              <?php if (function_exists('post_qrcode_url')) { ?>
                <a id="top-ico-qr" href="<?php post_qrcode_url();?>" rel="image_group"><?php show_qrcode();?></a>
              <?php } ?>

              <?php echo osc_item_description(); ?>
            </div>
            
            <div id="custom_fields">
              <?php if( osc_count_item_meta() >= 1 ) { ?>
                <br />
                <div class="meta_list">
                  <?php while ( osc_has_item_meta() ) { ?>
                    <?php if(osc_item_meta_value()!='') { ?>
                      <div class="meta">
                        <strong><?php echo osc_item_meta_name(); ?>:</strong> <?php echo osc_item_meta_value(); ?>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
            <?php osc_run_hook('item_detail', osc_item() ); ?>          
            <?php osc_run_hook('location'); ?>
          </div>
          <!-- plugins -->

          <?php if( osc_comments_enabled() ) { ?>
            <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
            <div id="comments">
              <h2><i class="fa fa-comments-o"></i><?php _e('Comments', 'sofia'); ?></h2>
              <div class="del"></div>
              <ul id="comment_error_list"></ul>
              <?php CommentForm::js_validation(); ?>
              <?php if( osc_count_item_comments() >= 1 ) { ?>
                <div class="comments_list">
                  <?php while ( osc_has_item_comments() ) { ?>
                    <div class="comment">
                      <div class="comment-image">
                        <?php if(function_exists('profile_picture_show')) { profile_picture_show(40, 'comment'); } else { echo '<img src="' . osc_base_url() . 'oc-content/plugins/profile_picture/no-user.png" alt="' . osc_esc_html(__('Profile picture', 'sofia')) . '"/>'; } ?>
                      </div>
                      <h3><strong><?php echo osc_comment_title(); ?></strong> <em><?php _e("by", 'sofia'); ?> <?php echo osc_comment_author_name(); ?>:</em></h3>
                      <p><?php echo nl2br( osc_comment_body() ); ?> </p>
                      <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
                        <p>
                          <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php echo osc_esc_html(__('Delete your comment', 'sofia')); ?>"><?php _e('Delete', 'sofia'); ?></a>
                        </p>
                      <?php } ?>
                    </div>
                  <?php } ?>
                  <div class="paginate" style="text-align: right;">
                    <?php echo osc_comments_pagination(); ?>
                  </div>
                </div>
              <?php } ?>
              <form action="<?php echo osc_base_url(true); ?>" method="post" name="comment_form" id="comment_form">
                <h3><i class="fa fa-pencil"></i><?php _e('Leave your comment or feedback', 'sofia'); ?><i class="fa fa-plus-circle exp"></i></h3>
                <div class="del"></div>
                <fieldset>
                  <input type="hidden" name="action" value="add_comment" />
                  <input type="hidden" name="page" value="item" />
                  <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                  <?php if(osc_is_web_user_logged_in()) { ?>
                    <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
                    <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
                  <?php } else { ?>
                    <label for="authorName"><?php _e('Name', 'sofia'); ?>:</label> <?php CommentForm::author_input_text(); ?><br />
                    <label for="authorEmail"><?php _e('E-mail', 'sofia'); ?>:</label> <?php CommentForm::email_input_text(); ?><br />
                  <?php }; ?>
                  <label for="title"><?php _e('Title', 'sofia'); ?>:</label><?php CommentForm::title_input_text(); ?><br />
                  <label for="body"><?php _e('Message', 'sofia'); ?>:</label><?php CommentForm::body_input_textarea(); ?><br />

                  <div style="float:left;clear:both;width:100%;margin:15px 0 5px 0;">
                    <?php osc_run_hook("anr_captcha_form_field"); ?>
                  </div>

                  <button type="submit"><?php _e('Send comment', 'sofia'); ?></button>
                </fieldset>
              </form>
            </div>
            <?php } ?>
          <?php } ?>

          <?php if( osc_count_item_resources() > 0 ) { ?>
            <div class="img-gal">
              <h2><i class="fa fa-camera"></i><?php _e('Image Gallery', 'sofia'); ?></h2>
              <?php if( osc_images_enabled_at_items() ) { ?>
                <div id="photos">
                  <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
                    <a id="img-link" href="<?php echo osc_resource_url(); ?>" rel="image_group" title="<?php echo osc_esc_html(__('Image', 'sofia')); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>">
                      <img id="small-img" style="padding:1px;" src="<?php echo osc_resource_thumbnail_url(); ?>" width="68" alt="<?php echo osc_esc_html(osc_item_title()); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" />
                    </a>
                  <?php } ?>
                </div>
              <?php } ?> 
            </div>
          <?php } ?>
        </div>

        <div id="sidebar">
          <?php osc_reset_resources(); ?>
          <?php if( osc_images_enabled_at_items() ) { ?>
            <?php if( osc_count_item_resources() > 0 ) { ?>
              <div id="photos">
                <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
                  <a <?php if( $i <> 0 ) { echo ' id="img-link" '; } ?>href="<?php echo osc_resource_url(); ?>" rel="image_group" title="<?php echo osc_esc_html(__('Image', 'sofia')); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>">
                    <?php if( $i == 0 ) { ?>
                      <img id="big-img" src="<?php echo osc_resource_url(); ?>" width="294" alt="<?php echo osc_esc_html(osc_item_title()); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" />
                    <?php } ?>
                  </a>
                <?php } ?>

                <div class="more"><i class="fa fa-image"></i><?php _e('View Gallery', 'sofia'); ?></div>
              </div>
            <?php } ?>
          <?php } ?>   

          <div class="summary">  
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
              if($mobile == '') { $mobile = __('No phone number', 'sofia'); }      
            ?> 
            
            <h3 class="mobile-show" rel="<?php echo $mobile; ?>">
             <i class="fa fa-mobile"></i>
             <span>
             <?php 
               if(strlen($mobile) > 3 and $mobile <> __('No phone number', 'sofia')) {
               echo substr($mobile, 0, strlen($mobile) - 3) . 'XXX'; 
               } else {
               echo $mobile;
               }
             ?>
            </span>
            </h3>

            <?php if(strlen($mobile) > 3 and $mobile <> __('No phone number', 'sofia')) { ?>
              <div id="mobile-text"><?php _e('Click to show phone number', 'sofia'); ?></div>
            <?php } ?>

            <div class="ref">ref <?php echo osc_item_id();?></div>
            <div class="del"></div>
            
            <?php if( osc_item_user_id() != null ) { ?>
              <div class="left"><i class="fa fa-user"></i><?php _e('Name', 'sofia') ?></div>
              <div class="right prof-pic">
                <div class="pic-wrap">
                  <?php if(function_exists('profile_picture_show')) { profile_picture_show(null, null, 25); } ?>
                  <div class="picture-hidden round2">
                    <?php if(function_exists('profile_picture_show')) { profile_picture_show(null, null, 150); } ?>
                    <span class="v-items round2"><?php echo osc_user_items_validated() . ' ' . __('listings', 'sofia'); ?></span>
                  </div>
                </div>

                <a class="reg-user-link" href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>" ><?php echo osc_item_contact_name(); ?></a> 
                <span class="reg-user-text">(<?php _e('registered', 'sofia'); ?>)</span>
              </div>
              <div class="swap"></div>
            <?php } else { ?>
             <div class="left"><i class="fa fa-user"></i><?php _e('Name', 'sofia') ?></div><div class="right"><?php echo osc_item_contact_name();?></div><div class="swap"></div>
            <?php } ?>
            
            <?php if( osc_item_show_email() ) { ?>
              <div class="left"><i class="fa fa-envelope"></i><?php _e('E-mail', 'sofia'); ?></div><div class="right"><?php echo osc_item_contact_email(); ?></div><div class="swap"></div>
            <?php } ?>
            
            <div class="left"><i class="fa fa-history"></i><?php _e('Registered', 'sofia'); ?></div><div class="right"><?php if(osc_user_regdate() != '') { echo osc_format_date(osc_user_regdate()); } else { echo '-';} ?></div><div class="swap"></div>

            <?php 
              $loc = array(osc_item_country(), osc_item_region(), osc_item_city());
              $loc = array_filter($loc);
              $loc = implode(', ', $loc);
            ?>

            <?php if($loc <> '') { ?><div class="left"><i class="fa fa-truck"></i><?php _e('Location', 'sofia'); ?></div><div class="right"><?php echo $loc; ?></div><div class="swap"></div><?php } ?>
            <?php if(osc_user_website() != '' and osc_user_website() <> 'http://') { ?><div class="left"><i class="fa fa-link"></i><?php _e('Website', 'sofia'); ?></div><div class="right"><?php echo '<a href="' . osc_user_website() . '" title="' . osc_esc_html(osc_user_website()) . '" class="url-user" target="_blank" rel="nofollow">' . osc_user_website() . '</a>'; ?></div><?php } ?>

            <?php if (function_exists('seller_post') && osc_item_user_id() <> 0) { ?>
              <div class="text"><?php seller_post(); ?></a></div>
              <div class="del"></div>
            <?php } else { ?>            
              <div class="del-special"></div>
            <?php } ?>

            <?php if( !osc_item_is_expired () ) { ?>
              <?php if( !( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) ) { ?>
                <?php if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
                  <div id="contact_button">
                    <?php _e('Contact seller', 'sofia'); ?>
                  </div>
                <?php } ?>
              <?php } ?>
            <?php } ?>
            
            <a href="<?php echo osc_item_send_friend_url(); ?>" rel="nofollow"><div id="uniform-undefined"><?php _e('Send to friend', 'sofia'); ?></div></a>
          </div>   
        
          <div id="ad-title"><i class="fa fa-line-chart"></i><?php _e('Advertising', 'sofia'); ?></div>

          <?php if(osc_get_preference('theme_adsense', 'sofia_theme')) { ?>
            <div id="home-ad-google"><?php echo osc_get_preference('banner_item', 'sofia_theme'); ?></div>     
          <?php } ?>

          <?php if (function_exists('related_ads_start')) {related_ads_start();} ?>
        </div>
      </div>
    </div>

    <div id="contact-wrap">
      <div id="contact">
        <div class="close-wrap"></div>
        
        <h2><?php _e("Contact publisher", 'sofia'); ?></h2>
        <?php if( osc_item_is_expired () ) { ?>
          <p>
            <?php _e("The listing is expired. You can't contact the publisher.", 'sofia'); ?>
          </p>
        <?php } else if( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) { ?>
          <p>
            <?php _e("It's your own listing, you can't contact the publisher.", 'sofia'); ?>
          </p>
        <?php } else if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?>
          <p>
            <?php _e("You must log in or register a new account in order to contact the advertiser", 'sofia'); ?>
          </p>
          <p class="contact_button">
            <strong><a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'sofia'); ?></a></strong>
            <strong><a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register for a free account', 'sofia'); ?></a></strong>
          </p>
        <?php } else { ?>
          <?php if( osc_item_user_id() != null ) { ?>
            <p class="name"><?php _e('Name', 'sofia') ?>: <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>" ><?php echo osc_item_contact_name(); ?></a></p>
          <?php } else { ?>
            <p class="name"><?php _e('Name', 'sofia') ?>: <?php echo osc_item_contact_name(); ?></p>
          <?php } ?>
          <?php if( osc_item_show_email() ) { ?>
            <p class="email"><?php _e('E-mail', 'sofia'); ?>: <?php echo osc_item_contact_email(); ?></p>
          <?php } ?>
          <?php if ( osc_user_phone() != '' ) { ?>
            <p class="phone"><?php _e("Tel", 'sofia'); ?>.: <?php echo osc_user_phone(); ?></p>
          <?php } ?>
          <ul id="error_list"></ul>

          <?php osc_run_hook('item_contact_form', osc_item_id()); ?>

          <?php ContactForm::js_validation(); ?>
          <form action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" id="contact_form">
            <?php osc_prepare_user_info(); ?>
            <fieldset>
              <label for="yourName"><?php _e('Your name', 'sofia'); ?>:</label> <?php ContactForm::your_name(); ?>
              <label for="yourEmail"><?php _e('Your e-mail address', 'sofia'); ?>:</label> <?php ContactForm::your_email(); ?>
              <label for="phoneNumber"><?php _e('Phone number', 'sofia'); ?> (<?php _e('optional', 'sofia'); ?>):</label> <?php ContactForm::your_phone_number(); ?>
              <?php osc_run_hook('item_contact_form', osc_item_id()); ?>
              <label for="message"><?php _e('Message', 'sofia'); ?>:</label> <?php ContactForm::your_message(); ?>
              <input type="hidden" name="action" value="contact_post" />
              <input type="hidden" name="page" value="item" />
              <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
              
              <div style="float:left;clear:both;width:100%;margin:5px 0 10px 0;">
                <?php osc_run_hook("anr_captcha_form_field"); ?>
              </div>
              
              <button type="submit"><?php _e('Send', 'sofia'); ?></button>
            </fieldset>
          </form>
        <?php } ?>
      </div>
    </div>       

    <?php 
      $mobile_text = osc_base_url();
      $mobile_text = str_replace('http://', '', $mobile_text);
      $mobile_text = str_replace('www.', '', $mobile_text);
      $mobile_text = str_replace('/', '', $mobile_text);
    ?>

    <script type="text/javascript"> 
      $(document).ready(function(){ 
        $("#contact-wrap").hide();
        $('#contact_button').click(function(){
          $("#contact-wrap").fadeToggle(300);
        });
       
        $('.close-wrap').click(function(){
          $("#contact-wrap").fadeOut(300);
        });
       
        $('h3.mobile-show').click(function() {
          $(this).find('span').text($(this).attr('rel'));
          $('#mobile-text').text("<?php echo osc_esc_js(__('Do not forget to tell you found this offer on', 'sofia')) . ' ' . osc_esc_js($mobile_text); ?>");
          $('#mobile-text').css('margin-top', -$('#mobile-text').height() + 15);
        });
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
        $(".item #main .price").hide(0);
      }
    });
    </script>

    <?php osc_current_web_theme_path('footer.php'); ?>
  </body>
</html>