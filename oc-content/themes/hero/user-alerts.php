<?php
    /*
     *       Hero Responsive Osclass Themes
     *       
     *       Copyright (C) 2016 OSCLASS.me
     * 
     *       This is Hero Osclass Themes with Single License
     *  
     *       This program is a commercial software. Copying or distribution without a license is not allowed.
     *         
     *       If you need more licenses for this software. Please read more here <http://www.osclass.me/osclass-me-license/>.
     */
?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
    <?php osc_current_web_theme_path('common/head.php'); ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" /> 
</head>
<body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="container">
        <div class="veraari">
            <div class="col-md-3">
                <div class="profile-userpic">
                    <?php echo show_avatar(osc_logged_user_id()); ?>
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo osc_user_name(); ?> 
                    </div>
                </div>
                <?php echo osc_private_user_menu( get_user_menu() ); ?>
                <div class="ads">
                    <?php echo osc_get_preference('ads-member', 'hero'); ?> 
                </div>
            </div>
            <div class="col-md-9">
                <div class="wraps">
                    <div class="cat-box-title">
                        <h2><?php _e("Your alerts", 'hero'); ?></h2>
                        <div class="stripe-line"></div>
                    </div>
                    <div class="panel-body">
                        <?php if(osc_count_alerts()==0 ) { ?>
                        <h3><?php _e("You do not have any alerts yet", 'hero'); ?>.</h3>
                        <?php } else { ?>
                        <?php while(osc_has_alerts()) { ?>
                        <div class="useralert">
                            <div>
                                <?php _e("Alert", 'hero'); ?> |
                                <a onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can\'t be undone. Are you sure you want to continue?', 'hero')); ?>');" href="<?php echo osc_user_unsubscribe_alert_url(); ?>">
                                    <?php _e("Delete this alert", 'hero'); ?> </a>
                            </div>
                        </div>
                        <?php while(osc_has_items()) { ?>
                        <div class="item  ari-4 col-md-3">
                            <div class="col-item">
                                <div class="photo">
                                    <?php if (osc_images_enabled_at_items()) { ?>
                                    <?php if (osc_count_item_resources()) { ?> <a href="<?php echo osc_item_url(); ?>"><img class="img-responsive" src="<?php echo osc_resource_thumbnail_url(); ?>"/></a>
                                    <?php if( osc_item_is_premium() ) { ?> <span title="<?php echo osc_esc_html(__('Premium Ads','hero')); ?>" class="cat-label cat-label-label2"><i class="fa fa-star"></i></span>
                                    <?php } ?>
                                    <?php } else { ?> <a href="<?php echo osc_item_url(); ?>"> <img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>"/></a>
                                    <?php } ?>
                                    <?php } ?> 
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="col-md-12 price">
                                            <p class="pricetext">
                                                <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { _e("Price", 'hero'); ?>:
                                                <?php echo osc_format_price(osc_item_price()); } ?> </p>
                                        </div>
                                        <div class="aribudin col-md-12">
                                            <a href="<?php echo osc_item_url(); ?>">
                                                <?php echo osc_item_title(); ?> </a>
                                            <div class="userItemData">
                                                <?php echo osc_format_date(osc_item_pub_date()); ?> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(osc_count_items()==0 ) { ?> 0
                        <?php _e("Listings", 'hero'); ?>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?> 
</body>
</html>