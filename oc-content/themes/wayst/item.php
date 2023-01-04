<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    // meta tag robots
    if( osc_item_is_spam() || osc_premium_is_spam() ) {
        osc_add_hook('header','wayst_nofollow_construct');
    } else {
        osc_add_hook('header','wayst_follow_construct');
    }

    osc_enqueue_script('fancybox');
    osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
    osc_enqueue_script('jquery-validate');

    wayst_add_body_class('item');
    osc_add_hook('after-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('item-sidebar.php');
    }

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

<style type="text/css">
img {
  max-width: 100%; }

.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }
  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px; } }

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 15px; }
  .preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%; }
    .preview-thumbnail.nav-tabs li img {
      max-width: 100%;
      display: block; }
    .preview-thumbnail.nav-tabs li a {
      padding: 0;
      margin: 0; }
    .preview-thumbnail.nav-tabs li:last-of-type {
      margin-right: 0; }

.tab-content {
  overflow: hidden; }
  .tab-content img {
    width: 100%;
    -webkit-animation-name: opacity;
            animation-name: opacity;
    -webkit-animation-duration: .3s;
            animation-duration: .3s; }

.card {
  margin-top: 5px;
  background: #eee;
  padding: 3em;
  line-height: 1.5em; }

@media screen and (min-width: 997px) {
  .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex; } }

.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }

.colors {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.product-title, .price, .sizes, .colors {
  text-transform: UPPERCASE;
  font-weight: bold; }

.checked, .price span {
  color: #ff9f1a; }

.product-title, .rating, .product-description, .price, .vote, .sizes {
  margin-bottom: 15px; }

.product-title {
  margin-top: 0; }

.size {
  margin-right: 10px; }
  .size:first-of-type {
    margin-left: 40px; }

.color {
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;
  height: 2em;
  width: 2em;
  border-radius: 2px; }
  .color:first-of-type {
    margin-left: 20px; }

.add-to-cart, .like {
  background: #ff9f1a;
  padding: 1.2em 1.5em;
  border: none;
  text-transform: UPPERCASE;
  font-weight: bold;
  color: #fff;
  -webkit-transition: background .3s ease;
          transition: background .3s ease; }
  .add-to-cart:hover, .like:hover {
    background: #b36800;
    color: #fff; }

.not-available {
  text-align: center;
  line-height: 2em; }
  .not-available:before {
    font-family: fontawesome;
    content: "\f00d";
    color: #fff; }

.orange {
  background: #ff9f1a; }

.green {
  background: #85ad00; }

.blue {
  background: #0076ad; }

.tooltip-inner {
  padding: 1.3em; }

@-webkit-keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

@keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }
</style>

<body class="wayst">
            <?php osc_current_web_theme_path('common/rtop-menu2.php') ; ?>
            
            <!-- initiate page content -->
            <div class="container page-content product-page">
            <?php
        $breadcrumb = osc_breadcrumb('', false, get_breadcrumb_lang());
        if( $breadcrumb !== '') { ?>
                <ol class="breadcrumb"><li><?php echo $breadcrumb; ?></li></ol><?php
        }
    ?>                                                     <div align="center"><?php osc_show_widgets('header'); ?></div>   <script>
            var currentImage = -1;
            var currentImageFieldID = 0;
            var images = [];
        </script><br />
        <div class=" hidden-sm hidden-xs visible-md visible-lg " align="center">
                    <?php if (osc_get_preference('header-728x90', 'wayst')){ echo osc_get_preference('header-728x90', 'wayst');} else { echo ''; } ?>
                    </div>
                    
                    <div class=" visible-sm hidden-xs hidden-md hidden-lg " align="center">
                    <?php if (osc_get_preference('search-results-top-728x90', 'wayst')){ echo osc_get_preference('search-results-top-728x90', 'wayst');} else { echo ''; } ?>
                    </div>
        <section>

            <h1 class="with-title2">
            <span itemprop="name"><?php echo osc_item_title(); ?></span></h1>
            <h4></h4>
            
            
            <!-- detail product -->
            <div class="">
		<div class="card">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						 
						<div class="preview-pic tab-content">
                        <?php if( osc_images_enabled_at_items() ) { ?>
        <?php
        if( osc_count_item_resources() > 0 ) {
            $i = 0;
        ?>
						  <div class="tab-pane active" id="<?php echo osc_resource_url(); ?>"><a href="<?php echo osc_resource_url(); ?>" class="fancybox fullscreen-button" data-target="#img-modal" rel="product-images" data-large="<?php echo osc_resource_url(); ?>" title="<?php echo osc_esc_html(__('Image', 'wayst')); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>"><img src="<?php echo osc_resource_url(); ?>" /></a></div>
                          <?php } else { ?>
                          <div class="tab-pane active" id="pic-12"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" /></div><?php } ?><?php } ?>
						  
						</div>
						<ul class="preview-thumbnail nav nav-tabs">
                        <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
						  <li class="active"><a href="<?php echo osc_resource_url(); ?>" data-target="#img-modal" data-toggle="tab"><img src="<?php echo osc_resource_thumbnail_url(); ?>" /></a></li><?php } ?>
						  
						</ul>
						
					</div>
					<div class="details col-md-6">
						<h4 class="price"><span><?php if( osc_price_enabled_at_items() ) { ?><?php echo osc_item_formated_price(); ?><?php } ?></span></h4>
						<div class="rating">
							<div class="stars">
								<span class="fa fa-eye">: <?php echo osc_item_views(); ?>,</span>
								<span class=""><strong>ID</strong>: <?php echo osc_item_id(); ?></span>
								
							</div>
							<span class="review-no"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php if ( osc_item_pub_date() != '' ) echo __('', '') . ' ' . osc_format_date( osc_item_pub_date() ); ?></span>
						</div>
						<p class="product-description"><?php echo osc_highlight( strip_tags( osc_item_description() ), 170 ); ?></p>
						<h4 class="price"><i class="fa fa-user" aria-hidden="true"></i> <?php echo osc_item_contact_name(); ?></h4>
						<p class="vote"><?php if ( osc_item_country() != "" ) { ?> <i class="fa fa-map-marker" aria-hidden="true"></i>
	<strong><?php _e("Country", 'wayst'); ?></strong>: <?php echo osc_item_country(); ?> <?php } else { ?><i class="fa fa-map-marker" aria-hidden="true"></i> <strong><?php _e("Country", 'wayst'); ?></strong>: N/A <?php } ?> <?php if ( osc_item_region() != "" ) { ?><strong><?php _e("Region", 'wayst'); ?></strong>: <?php echo osc_item_region(); ?> <?php } ?> <?php if ( osc_item_city() != "" ) { ?><strong><?php _e("City", 'wayst'); ?></strong>: <?php echo osc_item_city(); ?><?php } ?></p>
						<h5 class="sizes"><?php if ( osc_user_phone_land() != '' ) { ?><span class="">
                    <i class="fa fa-phone" aria-hidden="true"></i>: <?php echo osc_user_phone_land(); ?></span> &nbsp;
                    <?php } else { ?>
                    <span class="gray"><i class="fa fa-phone" aria-hidden="true"></i>: N/A</span> &nbsp;
                <?php } ?>
                
                <?php if ( osc_user_phone_mobile() != '' ) { ?><span class="">
                    <i class="fa fa-mobile" aria-hidden="true"></i>: <?php echo osc_user_phone_mobile(); ?></span>
                    <?php } else { ?>
                    <span class=" gray"><i class="fa fa-mobile" aria-hidden="true"></i>: N/A</span>
                <?php } ?>
                
                
						</h5>
                        <p class="vote"><?php if( osc_item_show_email() ) { ?>
  <i class="fa fa-envelope" aria-hidden="true"></i>: <a href="mailto:<?php echo osc_item_contact_email(); ?>"><?php echo osc_item_contact_email(); ?></a><?php } ?></p>
						<h5 class="colors">
                        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/addthis_widget.js'); ?>"></script>
                        <script>

var addthis_config = {
    "data_track_clickback":true,
    "data_track_addressbar":true,
    "data_ga_property": "",
    "data_ga_social": true,
    "ui_email_note":"<?php echo osc_item_title(); ?>"

};

var addthis_share =
{
   url: "<?php echo osc_item_url(); ?>",
   lurl: "<?php echo osc_item_url(); ?>",
   title:"<?php echo osc_item_title(); ?>",
   description:"<?php echo osc_item_title(); ?>",
}
</script>
							
                        <a class="addthis_button_facebook addthis_32x32_style" title="Facebook" href="javascript:(void)"></a>
                    <a class="addthis_button_twitter addthis_32x32_style" title="Tweet" href="javascript:(void)"></a>
                    <a class="addthis_button_google_plusone_share addthis_32x32_style" title="Google+" href="javascript:(void)"></a>
                    <a class="addthis_button_email addthis_32x32_style" target="_blank" title="Email" href="javascript:(void)"></a>
                    <a class="addthis_button_compact addthis_32x32_style" href="javascript:(void)"></a>
                    </h5>
						<div class="action">
                        <?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) { ?>
                        <a href="<?php echo osc_item_edit_url(); ?>" class="add-to-cart btn"><i class="fa fa-pencil"></i> <?php _e('Edit item', 'wayst'); ?></a>
                        
                        <?php } else if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?>
                        <button id="" title="<?php echo osc_esc_html(__("You must log in or register a new account in order to contact the advertiser", 'wayst')); ?>" class="btn disabled add-to-cart"><i class="fa fa-envelope-o"></i> <?php _e("Send", 'wayst'); ?></button> <?php } else { ?><button id="share-email" title="<?php echo osc_esc_html(__("Send", 'wayst')); ?> <?php echo osc_esc_html(__("E-mail", 'wayst')); ?>" class="add-to-cart btn"><i class="fa fa-envelope"></i> <?php _e("Send", 'wayst'); ?></button><?php }; ?>
                        
                        <?php if (function_exists('watchlist')) { ?><a href="javascript://" class="like btn watchlist '.$class.'" id="' . osc_item_id() . '"><span class="fa fa-heart" aria-hidden="true"></span></a> <?php } else { ?> <div class="btn-group">
  <button type="button" class="btn like dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="fa fa-bell" aria-hidden="true"></span> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="<?php echo osc_item_link_spam(); ?>"><?php _e('Mark as spam', 'wayst'); ?></a></li>
    <li><a href="<?php echo osc_item_link_bad_category(); ?>"><?php _e('Mark as misclassified', 'wayst'); ?></a></li>
    <li><a href="<?php echo osc_item_link_repeated(); ?>"><?php _e('Mark as duplicated', 'wayst'); ?></a></li>
    <li><a href="<?php echo osc_item_link_expired(); ?>"><?php _e('Mark as expired', 'wayst'); ?></a></li>
    <li><a href="<?php echo osc_item_link_offensive(); ?>"><?php _e('Mark as offensive', 'wayst'); ?></a></li>
  </ul>
</div> <?php }?> 
                        
                        
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
            <!-- end detail product -->
            
            
            <div class="clear"></div>
            
            <h2><?php _e("Description", 'wayst'); ?> <?php if (function_exists('watchlist')) { ?><div class="btn-group pull-right">
  <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="fa fa-bell" aria-hidden="true"></span> <?php _e('Mark as...', 'wayst'); ?> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="<?php echo osc_item_link_spam(); ?>"><?php _e('Mark as spam', 'wayst'); ?></a></li>
    <li><a href="<?php echo osc_item_link_bad_category(); ?>"><?php _e('Mark as misclassified', 'wayst'); ?></a></li>
    <li><a href="<?php echo osc_item_link_repeated(); ?>"><?php _e('Mark as duplicated', 'wayst'); ?></a></li>
    <li><a href="<?php echo osc_item_link_expired(); ?>"><?php _e('Mark as expired', 'wayst'); ?></a></li>
    <li><a href="<?php echo osc_item_link_offensive(); ?>"><?php _e('Mark as offensive', 'wayst'); ?></a></li>
  </ul>
</div> <?php } else { ?> <?php } ?></h2>
                <div class="product-description">
                    <div itemprop="description"><p><?php echo osc_item_description(); ?> <div class="clear"></div>
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
        
        <?php osc_run_hook('item_detail', osc_item() ); ?></p>
        <div class="clear"></div>
        <?php osc_run_hook('location'); ?>
        </div>                </div>
        
        
        <h2><i class="fa fa-user" aria-hidden="true"></i> <?php echo osc_item_contact_name(); ?></h2><div class="bundle-lists"><h3><?php if( osc_item_user_id() != null ) { ?><a class="bundle-list-link" href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>"><?php echo sprintf(__('%s\'s profile', 'wayst'), osc_user_name()); ?></a><?php } else { ?> <?php } ?></h3><?php if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?> <?php _e("You must log in or register a new account in order to contact the advertiser", 'wayst'); ?>
                        <a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'wayst'); ?></a> | 
                            <a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register for a free account', 'wayst'); ?></a><?php } ?><div class="bundle-list">
        
        <!--section start  -->

<?php if( osc_item_is_expired () ) { ?>
                        <?php _e("The listing is expired. You can't contact the publisher.", 'wayst'); ?>
                    <?php } else if( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) { ?>
                       
                       
                        <?php if( osc_item_user_id() != null ) { ?>
                        
                        <?php } else { ?>  
    <figure><img src="<?php echo osc_current_web_theme_url('images/no-user-photo.jpg'); ?>" class="image-s" alt="No User Photo"></figure>
  <span class="plus equal">=</span>        <div class="price-summary price-summary-inline">
            <dl class="rows">
                <dt><?php if( osc_item_show_email() ) { ?>
  <?php _e('E-mail', 'wayst'); ?>: <a href="mailto:<?php echo osc_item_contact_email(); ?>"><?php echo osc_item_contact_email(); ?></a><?php } ?></dt>
                <dd class="total-price"></dd>
                
            </dl>
                            <form  class="cart">
                    <button id="share-email" class="btn btn-cart margin">
                        <i class="fa fa-envelope-o"></i> <?php _e("Contact seller", 'wayst'); ?>
                    </button>
                </form>
                        </div>
  
  
       
                        <?php } ?>
                       
                        <?php if( osc_item_user_id() != null ) { ?>

   <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>"><?php if (function_exists('profile_picture_show')){profile_picture_show();} else{ echo '<figure><img class="image-s" src="' . osc_current_web_theme_url('images/no-user-photo.jpg') . '" alt="No user Photo"></figure>'; } ?></a>
  
  <span class="plus equal">=</span>        <div class="price-summary price-summary-inline">
            <dl class="rows">
                <dt><?php _e('Location', 'wayst'); ?></dt>
                <dd > <?php if (osc_user_country() == null ) { ?>N/A <?php } else { ?> <?php echo osc_user_country() ?> <?php } ?></dd>
                <dt><?php _e('Listings', 'wayst'); ?></dt>
                <dd > <?php echo osc_user_items_validated() ?></dd>
                <dt>Member</dt>
                <dd ><?php echo osc_format_date(osc_user_field('dt_reg_date')); ?></dd>
            </dl>
            <?php if( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) { ?>
                       <div class="cart">
                    <button id="share-email" class="btn btn-cart margin disabled">
                        <i class="fa fa-envelope-o"></i> <?php _e("Contact seller", 'wayst'); ?>
                    </button>
                </div> <?php } else { ?>
                            <div class="cart">
                    <button id="share-email" class="btn btn-cart margin">
                        <i class="fa fa-envelope-o"></i> <?php _e("Contact seller", 'wayst'); ?>
                    </button>
                </div> <?php } ?>
                        </div>
  
       
<div class="clearfix"></div>
 
                         <?php } ?>
                       
                    <?php } else if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?>
                        
                         <?php if( osc_item_user_id() != null ) { ?>
                         

                        <?php } else { ?>

                        
                        
    <a href="javascript:;"><figure><img class="image-s" src="<?php echo osc_current_web_theme_url('images/no-user-photo.jpg'); ?>" alt="No User Photo"></figure></a>
    <span class="plus equal">=</span>        <div class="price-summary price-summary-inline">
            <dl class="rows">
                <dt><?php _e('Location', 'wayst'); ?></dt>
                <dd >N/A</dd>
                <dt><?php _e('Listings', 'wayst'); ?></dt>
                <dd >N/A</dd>
                <dt>Member</dt>
                <dd >N/A</dd>
            </dl>
                            <div class="cart">
                    <button id="" class="btn btn-cart margin disabled">
                        <i class="fa fa-envelope-o"></i> <?php _e("Send", 'wayst'); ?> <?php _e("E-mail", 'wayst'); ?>
                    </button>
                </div>
                        </div>

        
<div class="clearfix"></div>
                        <?php } ?>
                       
                        <?php if( osc_item_user_id() != null ) { ?>
<a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>"><?php if (function_exists('profile_picture_show')){profile_picture_show();} else{ echo '<figure><img class="image-s" src="' . osc_current_web_theme_url('images/no-user-photo.jpg') . '" alt="No user Photo"></figure>'; } ?></a>
  
  <span class="plus equal">=</span>        <div class="price-summary price-summary-inline">
            <dl class="rows">
                <dt><?php _e('Location', 'wayst'); ?></dt>
                <dd ><?php if (osc_user_country() == null ) { ?>N/A <?php } else { ?> <?php echo osc_user_country() ?> <?php } ?></dd>
                <dt><?php _e('Listings', 'wayst'); ?></dt>
                <dd ><?php echo osc_user_items_validated() ?></dd>
                <dt>Member</dt>
                <dd ><?php echo osc_format_date(osc_user_field('dt_reg_date')); ?></dd>
            </dl>
                            <div class="cart">
                    <button id="share-email2" class="btn btn-cart margin">
                        <i class="fa fa-envelope-o"></i> <?php _e("Send", 'wayst'); ?> <?php _e("E-mail", 'wayst'); ?>
                    </button>
                </div>
                        </div>
 
                         <?php } ?>
                    <?php } else { ?>
                        <?php if( osc_item_user_id() != null ) { ?>
                        

                        <?php } else { ?>
                        
                        
                       
    <a href="javascript:;"><figure><img class="image-s" src="<?php echo osc_current_web_theme_url('images/no-user-photo.jpg'); ?>" alt="No User Photo"></figure></a>
    <span class="plus equal">=</span>        <div class="price-summary price-summary-inline">
            <dl class="rows">
                <dt><?php _e('Location', 'wayst'); ?></dt>
                <dd >N/A</dd>
                <dt><?php _e('Listings', 'wayst'); ?></dt>
                <dd >N/A</dd>
                <dt>Member</dt>
                <dd >N/A</dd>
            </dl>
            
            <?php if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?>
            <div class="cart">
                    <button id="" class="btn btn-cart margin disabled">
                        <i class="fa fa-envelope-o"></i> <?php _e("Send", 'wayst'); ?> <?php _e("E-mail", 'wayst'); ?>
                    </button>
                </div>
            <?php } else { ?>
                            <div class="cart">
                    <button id="share-email2" class="btn btn-cart margin">
                        <i class="fa fa-envelope-o"></i> <?php _e("Send", 'wayst'); ?> <?php _e("E-mail", 'wayst'); ?>
                    </button>
                </div> <?php }; ?>
                        </div>
  
       
<div class="clearfix"></div>
                        <?php } ?>
                       
                        <?php if( osc_item_user_id() != null ) { ?>
 <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>"><?php if (function_exists('profile_picture_show')){profile_picture_show();} else{ echo '<figure><img class="image-s" src="' . osc_current_web_theme_url('images/no-user-photo.jpg') . '" alt="No user Photo"></figure>'; } ?></a>
  
  <span class="plus equal">=</span>        <div class="price-summary price-summary-inline">
            <dl class="rows">
                <dt><?php _e('Location', 'wayst'); ?></dt>
                <dd ><?php if (osc_user_country() == null ) { ?>N/A <?php } else { ?> <?php echo osc_user_country() ?> <?php } ?></dd>
                <dt><?php _e('Listings', 'wayst'); ?></dt>
                <dd ><?php echo osc_user_items_validated() ?></dd>
                <dt>Member</dt>
                <dd ><?php echo osc_format_date(osc_user_field('dt_reg_date')); ?></dd>
            </dl>
                            <div class="cart">
                    <button id="share-email2" data-toggle="share-email" data-target="#share-email" class="btn btn-cart margin">
                        <i class="fa fa-envelope-o"></i> <?php _e("Send", 'wayst'); ?> <?php _e("E-mail", 'wayst'); ?>
                    </button>
                </div>
                        </div>
 
                         <?php } ?><?php } ?><!--section end  -->        
        </div></div>
            
                          <div class=" hidden-sm visible-xs hidden-md " align="center">
                    <?php if (osc_get_preference('sidebar-300x250', 'wayst')){ echo osc_get_preference('sidebar-300x250', 'wayst');} else { echo ''; } ?>
                    </div>
            
                    </section>

                <div class="modal modal-fixed-height  fade" id="img-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                                        <div class="modal-body" id="img-modal-body"><figure></figure></div>
                    <div class="modal-footer">
                                                <button type="button" class="btn btn-close" data-dismiss="modal"><?php _e("Close", 'wayst'); ?></button>
                    </div>
                </div>
            </div>
        </div>
                                    </div>      
                                    <?php osc_current_web_theme_path('common/random-items.php') ; ?>                     
            <!-- end page content -->
            
            <?php osc_current_web_theme_path('common/rtop-menu.php') ; ?>
                        
            <?php osc_current_web_theme_path('common/rfooter.php') ; ?>
                            <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery.form.js'); ?>"></script>
<div class="modal   fade" id="share-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="share-modal-title" align="center"><?php _e("Contact seller", 'wayst'); ?>: <i class="fa fa-user"></i> <?php echo osc_item_contact_name(); ?></h4>
                        </div>
                                        <div class="modal-body" id="share-modal-body">
                                        <form <?php if( osc_item_attachment() ) { ?>enctype="multipart/form-data"<?php } ?> action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" id="contact_form" class="form-horizontal">
                <?php osc_prepare_user_info(); ?>
                    <input type="hidden" name="action" value="contact_post" />
                    <input type="hidden" name="page" value="item" />
                    <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                    
                            <div class="form-group ">
                                    <label for="RecipientName" class="col-sm-2 control-label"><?php _e('Message', 'wayst'); ?></label>
                            <div class="col-sm-10 " id="RecipientName-column">
                            <textarea id="message" name="message" rows="7" class="form-control" placeholder="" title="" data-orig="" onKeyUp="" onChange="" required="required"></textarea>
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="RecipientEmailAddress" class="col-sm-2 control-label"><?php _e('Your name', 'wayst'); ?></label>
                            <div class="col-sm-10 " id="RecipientEmailAddress-column">
                            <input id="yourName" type="text" name="yourName" value="" class="form-control" placeholder="" title="" data-orig="" onKeyUp="" onChange="" required="required" />
                            
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="ShareMessage" class="col-sm-2 control-label"><?php _e('Your e-mail address', 'wayst'); ?></label>
                            <div class="col-sm-10 " id="ShareMessage-column">
                            <input id="yourEmail" type="email" name="yourEmail" value="" class="form-control" placeholder="" title="" data-orig="" onKeyUp="" onChange="" required="required" />
                            
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="FromName" class="col-sm-2 control-label"><?php _e('Phone number', 'wayst'); ?> (<?php _e('optional', 'wayst'); ?>)</label>
                            <div class="col-sm-10 " id="FromName-column">
                            <input id="phoneNumber" type="text" name="phoneNumber" value="" class="form-control" placeholder="" title="" data-orig="" onKeyUp="" onChange="" />
                            
                                            </div>
                                    </div>
                                    <?php if( osc_item_attachment() ) { ?><div class="form-group ">
                                    <label for="FromEmailAddress" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-10 " id="FromEmailAddress-column">
                            <div align="left"><?php ContactForm::your_attachment() ; ?>
                    <br /><?php osc_run_hook('item_contact_form', osc_item_id()); ?></div>

                                            </div>
                                    </div><?php } ?>
                                    <div class="form-group ">
                                    <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 " id="-column">
                            <div id="" class="form-control-static"><div id="g-recaptcha1" class="g-recaptcha1"><?php osc_show_recaptcha(); ?></div></div>
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="CustomerShare" class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 " id="CustomerShare-column">
                            <button type="submit" name="CustomerShare" id="customer-share-send1" class="btn btn-success" value="1" onClick=""><i class="fa fa-envelope"></i> <?php _e('Send', 'wayst'); ?> <?php _e('Email', 'wayst'); ?></button>
                                            </div>
                                    </div>
                </form>                    </div>
                    <div class="modal-footer">
                                                <button type="button" class="btn btn-close" data-dismiss="modal"><?php _e('Close', 'wayst'); ?></button>
                    </div>
                </div>
            </div>
        </div>
<script>
            function showReCaptcha() {
                grecaptcha.render('g-recaptcha', {
                    'sitekey' : 'yourkeyhere'
                });
                $('#customer-share-send').prop('disabled', false);
            }

            $('#share-email, #share-email2').click(function() {
                $('#share-modal').modal('show');
                                    $('#customer-share-send').prop('disabled', true);
                    $('#g-recaptcha').html('');
                    $.getScript('https://www.google.com/recaptcha/api.js?onload=showReCaptcha&render=explicit');
                            });
        </script>
                <script>
            $(document).ready(function() {
                $('#fbshare').click(function(e) {
                    popupCenter($(this).attr('href'), 'Facebook', 550, 400);
                    e.preventDefault();
                });
                $('#tweet').click(function(e) {
                    popupCenter($(this).attr('href'), 'Twitter', 550, 520);
                    e.preventDefault();
                });
                $('#pinit').click(function(e) {
                    popupCenter($(this).attr('href'), 'Pinterest', 770, 535);
                    e.preventDefault();
                });
            });
        </script>
                <script>
            function sleep(milliseconds) {
                var start = new Date().getTime();
                for (var i = 0; i < 1e7; i++) {
                    if ((new Date().getTime() - start) > milliseconds){
                        break;
                    }
                }
            }

            $(document).ready(function() {
                $('audio').on('playing', function(e) {
                    $('audio').each(function() {
                        if (this != e.target) {
                            this.pause();
                            if (this.currentTime) this.currentTime = 0;
                        }
                    });
                });
                $('#play-all').click(function() {
                    var somePlaying = false;
                    $('audio')
                        .on('ended', function(e) {
                            sleep(500);
                            var track = $(e.target).attr('id').replace('audio','');
                            track++;
                            var next = $('#audio'+track);
                            if (next.length) {
                                next[0].play();
                            }
                        })
                        .each(function() {
                        if (!this.paused) {
                            this.pause();
                            somePlaying = true;
                        }
                    });
                    if (!somePlaying) {
                        $('#audio1')[0].play();
                    }
                });
            });
        </script>
                <!--suppress HtmlUnknownAttribute -->
        <script>
            function playVideo(index, code, embedCode) {
                var elem = $('#video-embed-' + index);
                var playing = !elem.hasClass('hidden');
                $('.video-play').html('<i class="fa fa-play"></i> Play').removeClass('btn-success').addClass('btn-info');
                $('.video-embed').addClass('hidden').html('');
                $('.video-summary').removeClass('hidden');
                if (!playing) {
                    $('#video-summary-' + index).addClass('hidden');
                    elem.removeClass('hidden');
                    $('#video-play-' + index).html('<i class="fa fa-stop"></i> Stop').removeClass('btn-info').addClass('btn-success');
                    if (embedCode == '') {
                        elem.html('<iframe width="640" height="360" src="//www.youtube.com/embed/' + code + '?autoplay=1" frameborder="0" wmode=transparent allowfullscreen></iframe>');
                    } else {
                        elem.html(embedCode);
                    }
                }
            }
        </script>
                <script>
            // ratings events
            $('input[type=radio]').click(function() {
                $('form#starRating').submit();
            });

            $('[data-toggle="popover"]').popover();

                    </script>
                <script>
                        // image modals click events
            $('a[data-target=#img-modal]').click(function(e) {
                e.preventDefault();
                var target = $(this).attr('href');
                var fieldid = $(this).attr('data-fieldid');
                useIframe = $(this).attr('data-use-iframe');
                currentImageFieldID = (isNaN(fieldid) ? 0 : fieldid);
                setModalImage(target);
                if (images[currentImageFieldID].length > 1) {
                    $('#image-arrows').removeClass('hidden');
                } else {
                    $('#image-arrows').addClass('hidden');
                }
                $('#img-modal').modal('show');
            });
            // image arrows
            images[0] = [];
                            images[0][0] = '/image.jpg';
                            images[0][1] = '/image.jpg';
                            images[0][2] = '/image.jpg';
                            images[0][3] = '/image.jpg';
                            images[0][4] = '/image.jpg';
                            images[0][5] = '/image.jpg';
                            images[0][6] = '/image.jpg';
                            images[0][7] = '/image.jpg';
                            images[0][8] = '/image.jpg';
                            images[0][9] = '/image.jpg';
                        $('#image-btn-left').click(function() {
                setModalImage(images[currentImageFieldID][currentImage-1]);
            });
            $('#image-btn-right').click(function() {
                setModalImage(images[currentImageFieldID][currentImage+1]);
            });
            $('#img-modal').keyup(function(e) {
                if (e.which == 37) { //left
                    if (currentImage > 0) {
                        setModalImage(images[currentImageFieldID][currentImage-1]);
                    }
                }
                if (e.which == 39) { //right
                    if (currentImage < images[currentImageFieldID].length-1) {
                        setModalImage(images[currentImageFieldID][currentImage+1]);
                    }
                }
            });
            // image functions
            function setModalImage(image) {
                for (var i=0; i<images[currentImageFieldID].length; i++) {
                    if (images[currentImageFieldID][i] == image) {
                        currentImage = i;
                        break;
                    }
                }
                $('#image-btn-left').prop('disabled', (currentImage == 0));
                $('#image-btn-right').prop('disabled', (currentImage == images[currentImageFieldID].length-1));
                var imgTag;
                if (typeof useIframe != 'undefined' && useIframe) {
                    imgTag = '<iframe src="' + encodeURI(image) + '"></iframe>';
                } else {
                    imgTag = '<figure><img src="' + image + '"></figure>';
                }
                $('#img-modal-body').html(imgTag);
                $('#img-modal').focus();
            }
        </script>
                <script type="application/ld+json">
        {
          "@context": "http://schema.org/",
          "@type": "Product",
          "name": "Title",
          "image": "/image.jpg",
          "gtin13": "5702015868655",
          "category": "Category",
                        "brand": {
                "@type": "Name",
                "name": "Name"
              },
                                            "offers": {
                "@type": "",
                "priceCurrency": "",
                "price": "",
                "itemCondition": "http://schema.org/NewCondition",
                "availability": "http://schema.org/InStock"
              },
                    "description": "Description.
"
        }
        </script>
        
        </body></html>