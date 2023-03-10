<?php

?>
<?php osc_current_web_theme_path('header.php') ; ?>
<div class="content user-area">
    <div id="right-side">
        <h1><?php _e('User account manager', 'realestate') ; ?></h1>
        <h2><?php echo sprintf(__('listings from %s', 'realestate') ,osc_logged_user_name()); ?></h2>
        <div class="ad_list">
            <?php if(osc_count_items() == 0) { ?>
            <h3><?php _e('No listings have been added yet', 'realestate'); ?></h3>
        <?php } else { ?>
            <?php while(osc_has_items()) { ?>
            <div class="ui-item ui-item-list">
                <div class="frame">
                    <a href="<?php echo osc_item_url() ; ?>"><?php if( osc_images_enabled_at_items() ) { ?>
                        <?php if( osc_count_item_resources() ) { ?>
                            <img src="<?php echo osc_resource_thumbnail_url() ; ?>" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>"/>
                        <?php } else { ?>
                            <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/>
                        <?php } ?>
                    <?php } else { ?>
                        <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/>
                    <?php } ?>
                    <div class="type"><?php echo osc_item_category(); ?></div>
                    <?php if( osc_price_enabled_at_items() ) { ?><div class="price"><?php echo osc_item_formated_price() ; ?></div> <?php } ?>
                    </a>
                </div>
                <div class="info">
                    <div>
                        <h3><a href="<?php echo osc_item_url() ; ?>"><?php if(strlen(osc_item_title()) > 31){ echo substr(osc_item_title(), 0, 28).'...'; } else { echo osc_item_title(); } ?></a></h3>
                    </div>
                    <div class="data data-full">
                        <?php _e('Publication date', 'realestate') ; ?>: <?php echo osc_format_date(osc_item_pub_date()) ; ?><br />
                        <div>
                        <a href="<?php echo osc_item_url(); ?>" class="ui-button ui-button-grey ui-button-mini"><?php _e('View item', 'realestate'); ?></a>
                        <a href="<?php echo osc_item_edit_url(); ?>" class="ui-button ui-button-grey ui-button-mini"><?php _e('Edit', 'realestate'); ?></a>
                        <?php if(osc_item_is_inactive()) {?>
                        <a href="<?php echo osc_item_activate_url();?>" class="ui-button ui-button-grey ui-button-mini"><?php _e('Activate', 'realestate'); ?></a>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
        </div>
        
    </div>
    <?php require('user_sidebar.php') ; ?>
    <div class="clear"></div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>