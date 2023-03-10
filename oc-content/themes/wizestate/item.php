<?php
    // meta tag robots
    if( osc_item_is_spam() || osc_premium_is_spam() ) {
        osc_add_hook('header','osclasswizards_nofollow_construct');
    } else {
        osc_add_hook('header','osclasswizards_follow_construct');
    }

    osc_enqueue_script('fancybox');
    osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
    osc_enqueue_script('jquery-validate');

    osclasswizards_add_body_class('item');
	
    $location = array();
    if( osc_item_city_area() !== '' ) {
        $location[] = osc_item_city_area();
    }
    if( osc_item_city() !== '' ) {
        $location[] = osc_item_city();
    }
    if( osc_item_region() !== '' ) {
        $location[] = osc_item_region();
    }
    if( osc_item_country() !== '' ) {
        $location[] = osc_item_country();
    }
    osc_current_web_theme_path('header.php');
	?>
<div class="row">
  <div class="col-sm-7 col-md-8">
    <div class="block_list">
      <h1 class="title title_code"> <strong><?php echo osc_item_title(); ?></strong> </h1>
      <ul class="item-header">
        <li>
          <?php if( osc_price_enabled_at_items() ) { ?>
          <i class="fa fa-money"></i><?php echo osc_item_formated_price(); ?>
          <?php } ?>
        </li>
        <li>
          <?php if ( osc_item_pub_date() !== '' ) { printf( __('<i class="fa fa-calendar-o"></i> Published date: %1$s', OSCLASSWIZARDS_THEME_FOLDER), osc_format_date( osc_item_pub_date() ) ); } ?>
        </li>
        <li>
          <?php if ( osc_item_mod_date() !== '' ) { printf( __('<span class="update"><i class="fa fa-calendar"></i> Modified date:</span> %1$s', OSCLASSWIZARDS_THEME_FOLDER), osc_format_date( osc_item_mod_date() ) ); } ?>
        </li>
        <?php if (count($location)>0) { ?>
        <li>
          <ul id="item_location">
            <li><i class="fa fa-map-marker"></i> <?php echo implode(', ', $location); ?></li>
          </ul>
          <?php }; ?>
        </li>
      </ul>
    </div>
    <?php
		if(function_exists('show_qrcode')){
			echo '<div class="block_list  mobile_list">';
			show_qrcode();
		
			echo ' </div>';

		}
	?>
    <div id="item-content">
      <?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) { ?>
      <p id="edit_item_view"> <strong> <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
        <?php _e('Edit item', OSCLASSWIZARDS_THEME_FOLDER); ?>
        </a> </strong> </p>
      <?php } ?>
      <?php if( osc_images_enabled_at_items() ) { ?>
      <div class="item-photos">
          <?php
        if( osc_count_item_resources() > 0 ) {
            $i = 0;
        ?>
          <a href="<?php echo osc_resource_url(); ?>" class="main-photo" title="<?php echo osc_esc_html( __('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>"> <img class="img-responsive" src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" /> </a>
          <div class="thumbs">
              <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
              <a href="<?php echo osc_resource_url(); ?>" class="fancybox" data-fancybox-group="group" title="<?php echo osc_esc_html( __('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>"> <img src="<?php echo osc_resource_thumbnail_url(); ?>" width="75" alt="<?php echo osc_esc_html(osc_item_title()); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" class="img-responsive"/> </a>
              <?php } ?>
            </div>
          <?php }else{ ?>
        <a href="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" class="main-photo" title="<?php echo osc_esc_html( __('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?>"> <img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" /> </a>
         
            <div class="thumbs"> <a href="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" class="fancybox" data-fancybox-group="group" title="<?php echo osc_esc_html( __('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?>"> <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" width="75" alt="<?php echo osc_esc_html(osc_item_title()); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" class="img-responsive"/> </a> </div>
        
          <?php } ?>
      </div>
      <?php } ?>
      <div id="description">
        <p><?php echo osc_item_description(); ?></p>
        <div id="custom_fields">
          <?php if( osc_count_item_meta() >= 1 ) { ?>
          <br />
          <div class="meta_list">
            <?php while ( osc_has_item_meta() ) { ?>
            <?php if(osc_item_meta_value()!='') { ?>
            <div class="meta"> <strong><?php echo osc_item_meta_name(); ?>:</strong> <?php echo osc_item_meta_value(); ?> </div>
            <?php } ?>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
        <?php osc_run_hook('item_detail', osc_item() ); ?>
        <ul class="contact_button">
          <li>
            <?php if( !osc_item_is_expired () ) { ?>
            <?php if( !( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) ) { ?>
            <?php     if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
            <a href="#contact">
            <?php _e('Contact seller', OSCLASSWIZARDS_THEME_FOLDER); ?>
            </a>
            <?php     } ?>
            <?php     } ?>
            <?php } ?>
          </li>
          <li><a href="<?php echo osc_item_send_friend_url(); ?>" rel="nofollow">
            <?php _e('Share', OSCLASSWIZARDS_THEME_FOLDER); ?>
            </a></li>
          <?php if(function_exists('watchlist')) {?>
          <li>
            <?php watchlist(); ?>
          </li>
          <?php } ?>
          <li><a class="see_all" href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>">
            <?php _e('Lihat semua iklan dari pengiklan ini', OSCLASSWIZARDS_THEME_FOLDER); ?>
            </a> </li>
        </ul>
        <?php osc_run_hook('location'); ?>
      </div>
    </div>
    <?php if( osc_comments_enabled() ) { ?>
    <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
    <div id="comments">
      <?php if( osc_count_item_comments() >= 1 ) { ?>
      <h2 class="title">
        <?php _e('Comments', OSCLASSWIZARDS_THEME_FOLDER); ?>
      </h2>
      <?php }
	  
	  ?>
      <ul id="comment_error_list">
      </ul>
      <?php CommentForm::js_validation(); ?>
      <?php if( osc_count_item_comments() >= 1 ) { ?>
      <div class="comments_list">
        <?php while ( osc_has_item_comments() ) { ?>
        <div class="comment">
          <h4><?php echo osc_comment_title(); ?> <em>
            <?php _e("by", OSCLASSWIZARDS_THEME_FOLDER); ?>
            <?php echo osc_comment_author_name(); ?>:</em></h4>
          <p><?php echo nl2br( osc_comment_body() ); ?> </p>
          <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
          <p> <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php echo osc_esc_html(__('Delete your comment', OSCLASSWIZARDS_THEME_FOLDER)); ?>">
            <?php _e('Delete', OSCLASSWIZARDS_THEME_FOLDER); ?>
            </a> </p>
          <?php } ?>
        </div>
        <?php } ?>
        <div class="pagination"> <?php echo osc_comments_pagination(); ?> </div>
      </div>
      <?php } ?>
      <div class="comment_form">
        <div class="title">
          <h1>
            <?php _e('Leave your comment (spam and offensive messages will be removed)', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </h1>
        </div>
        <div class="resp-wrapper">
          <form action="<?php echo osc_base_url(true); ?>" method="post" name="comment_form" id="comment_form">
            <fieldset>
              <input type="hidden" name="action" value="add_comment" />
              <input type="hidden" name="page" value="item" />
              <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
              <?php if(osc_is_web_user_logged_in()) { ?>
              <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
              <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
              <?php } else { ?>
              <div class="form-group">
                <label class="control-label" for="authorName">
                  <?php _e('Your name', OSCLASSWIZARDS_THEME_FOLDER); ?>
                </label>
                <div class="controls">
                  <?php CommentForm::author_input_text(); ?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="authorEmail">
                  <?php _e('Your e-mail', OSCLASSWIZARDS_THEME_FOLDER); ?>
                </label>
                <div class="controls">
                  <?php CommentForm::email_input_text(); ?>
                </div>
              </div>
              <?php }; ?>
              <div class="form-group">
                <label class="control-label" for="title">
                  <?php _e('Title', OSCLASSWIZARDS_THEME_FOLDER); ?>
                </label>
                <div class="controls">
                  <?php CommentForm::title_input_text(); ?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="body">
                  <?php _e('Comment', OSCLASSWIZARDS_THEME_FOLDER); ?>
                </label>
                <div class="controls textarea">
                  <?php CommentForm::body_input_textarea(); ?>
                </div>
              </div>
              <div class="actions">
                <button type="submit" class="btn btn-success">
                <?php _e('Send', OSCLASSWIZARDS_THEME_FOLDER); ?>
                </button>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php } ?>
  </div>
  <div class="col-sm-5 col-md-4">
    
    <?php
		if(function_exists('show_qrcode')){
			echo '<div class="block_list block_listed">';
			show_qrcode();
			
			echo ' </div>';

		}
	?>
    
    <div class="alert_block">
      <?php if(!osc_is_web_user_logged_in() || osc_logged_user_id()!=osc_item_user_id()) { ?>
      <form action="<?php echo osc_base_url(true); ?>" method="post" name="mask_as_form" id="mask_as_form">
        <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
        <input type="hidden" name="as" value="spam" />
        <input type="hidden" name="action" value="mark" />
        <input type="hidden" name="page" value="item" />
        <select name="as" id="as" class="mark_as">
          <option>
          <?php echo osc_esc_html(__("Mark as...", OSCLASSWIZARDS_THEME_FOLDER)); ?>
          </option>
          <option value="spam">
          <?php echo osc_esc_html(__("Mark as spam", OSCLASSWIZARDS_THEME_FOLDER)); ?>
          </option>
          <option value="badcat">
          <?php echo osc_esc_html(__("Mark as misclassified", OSCLASSWIZARDS_THEME_FOLDER)); ?>
          </option>
          <option value="repeated">
          <?php echo osc_esc_html(__("Mark as duplicated", OSCLASSWIZARDS_THEME_FOLDER)); ?>
          </option>
          <option value="expired">
          <?php echo osc_esc_html(__("Mark as expired", OSCLASSWIZARDS_THEME_FOLDER)); ?>
          </option>
          <option value="offensive">
          <?php echo osc_esc_html(__("Mark as offensive", OSCLASSWIZARDS_THEME_FOLDER)); ?>
          </option>
        </select>
      </form>
      <?php } ?>
    </div>
    <?php osc_current_web_theme_path('item-sidebar.php'); ?>
    <div class="block_list">
      <div id="useful_info">
        <h1 class="title">
          <?php _e('Useful information', OSCLASSWIZARDS_THEME_FOLDER); ?>
        </h1>
        <ul>
          <li>
            <?php _e('Hubungi penjual terlebih dahulu sebelum bertransaksi', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </li>
          <li>
            <?php _e('Semua transaksi tidak ada hubungannya dengan kami, lebih teliti dan bijaksana dalam bertransaksi', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </li>
          <li>
            <?php _e('Pastikan anda membaca terlebih dahulu keterangan produk agar anda tidak kecewa', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </li>
          <li>
            <?php _e('Situs ini tidak pernah terlibat dalam transaksi apapun, dan tidak menangani pembayaran, pengiriman, jaminan transaksi. Sebisa mungkin lakukan transaksi dengan cara COD (Cash On Delivery) (Bayar Ditempat) dengan cara bertemu satu sama lain', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php related_listings(); ?>
<?php if( osc_count_items() > 0 ) { ?>
<div class="similar_ads">
  <h2 class="title">
    <?php _e('Related listings', OSCLASSWIZARDS_THEME_FOLDER); ?>
  </h2>
  <?php
		View::newInstance()->_exportVariableToView("listType", 'items');
		osc_current_web_theme_path('loop-search-grid.php');
    ?>
</div>
<?php } ?>
<?php osc_current_web_theme_path('footer.php') ; ?>
