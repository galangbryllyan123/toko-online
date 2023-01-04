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
                    <?php echo show_avatar(osc_logged_user_id()); ?></div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo osc_user_name(); ?> </div>
                </div>
                <?php echo osc_private_user_menu( get_user_menu() ); ?>
                <div class="ads">
                    <?php echo osc_get_preference('ads-member', 'hero'); ?> </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="cat-box-title">
                        <h2><?php _e("Your listings", 'hero'); ?></h2>
                        <div class="stripe-line"></div>
                    </div>
                    <div class="panel-body">
                        <div id="products" class="row list-group">
                            <?php if(osc_count_items()==0 ) { ?>
                            <div class="item  col-xs-6 col-md-4">
                                <h3><?php _e("You don't have any listings yet", 'hero'); ?></h3> </div>
                            <?php } else { ?>
                            <?php while(osc_has_items()) { ?>
                            <div class="item  ari-4 col-md-3">
                                <div class="col-item">
                                    <div class="photo">
                                        <?php if (osc_images_enabled_at_items()) { ?>
                                        <?php if (osc_count_item_resources()) { ?> <a href="<?php echo osc_item_url(); ?>"><img class="img-responsive" src="<?php echo osc_resource_thumbnail_url(); ?>"/></a>
                                        <?php if( osc_item_is_premium() ) { ?> <span class="cat-label cat-label-label2"><i class="fa fa-star"></i></span>
                                        <?php } ?>
                                        <?php } else { ?> <img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" />
                                        <?php } ?>
                                        <?php } ?> </div>
                                    <div class="info">
                                        <div class="row">
                                            <div class="col-md-12 price">
                                                <p class="pricetext">
                                                    <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { ?>
                                                    <?php echo osc_format_price(osc_item_price()); ?>
                                                    <?php } ?> </p>
                                            </div>
                                            <div class="aribudin col-md-12">
                                                <a href="<?php echo osc_item_url(); ?>">
                                                    <?php echo osc_item_title(); ?> </a>
                                            </div>
                                        </div>
                                        <div class="separator clear-left">
                                            <p class="btn-add"> <i class="fa fa-edit"></i>
                                                <a href="<?php echo osc_item_edit_url(); ?>">
                                                    <?php _e("Edit", 'hero'); ?> </a>
                                            </p>
                                            <p class="btn-details"> <i class="fa fa-power-off"></i>
                                                <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'hero')); ?>')" href="<?php echo osc_item_delete_url();?>">
                                                    <?php _e("Delete", 'hero'); ?> </a>
                                                <?php if(osc_item_is_inactive()) {?> <span>|</span>
                                                <a href="<?php echo osc_item_activate_url();?>">
                                                    <?php _e("Activate", 'hero'); ?> </a>
                                                <?php } ?> </p>
                                        </div>
                                        <div class="clearfix"> </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <br />
                            <div class="paginate">
                                <?php for($i=0 ; $i < osc_list_total_pages(); $i++) { if($i==osc_list_page()) { printf( '<a class="searchPaginationSelected" href="%s">%d</a>', osc_user_list_items_url($i+1), ($i + 1)); } else { printf( '<a class="searchPaginationNonSelected" href="%s">%d</a>', osc_user_list_items_url($i+1), ($i + 1)); } } ?> </div>
                            <?php } ?> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?> </body>

</html>