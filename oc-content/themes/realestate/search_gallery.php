<?php


    osc_get_premiums();
    if(osc_count_premiums() > 0) {
?>
        <?php while(osc_has_premiums()) { ?>
            <div class="ui-item ui-item-list premium">
                <div class="frame">
                    <a href="<?php echo osc_premium_url() ; ?>"><?php if( osc_images_enabled_at_items() ) { ?>
                        <?php if( osc_count_item_resources() ) { ?>
                            <img src="<?php echo osc_resource_thumbnail_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()); ?>" alt="<?php echo osc_esc_html(osc_premium_title()); ?>"/>
                        <?php } else { ?>
                            <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/>
                        <?php } ?>
                    <?php } else { ?>
                        <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/>
                    <?php } ?>
                    <div class="type"><?php echo osc_premium_category(); ?></div>
                    <?php if( osc_price_enabled_at_items() ) { ?><div class="price"><?php echo osc_premium_formated_price(); ?></div> <?php } ?>
                    </a>
                </div>
                <div class="info">
                    <div>
                        <h3><a href="<?php echo osc_premium_url() ; ?>"><?php if(strlen(osc_premium_title()) > 31){ echo substr(osc_premium_title(), 0, 28).'...'; } else { echo osc_premium_title(); } ?></a></h3>
                    </div>
                    <div class="data"><?php item_realestate_attributes(); ?></div>
                    <div class="author">
                        <?php echo osc_format_date(osc_premium_pub_date()); ?><br />
                        <?php echo osc_premium_city(); ?> (<?php echo osc_premium_region();?>)
                    </div>
                </div>
            </div>
        <?php } ?>
<?php } ?>
        <?php $i=1; while(osc_has_items()) { $i++; ?>
            <div class="<?php osc_run_hook("highlight_class"); ?> ui-item ui-item-list">
                <div class="frame">
                    <a href="<?php echo osc_item_url() ; ?>"><?php if( osc_images_enabled_at_items() ) { ?>
                        <?php if( osc_count_item_resources() ) { ?>
                            <img src="<?php echo osc_resource_thumbnail_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>"/>
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
                    <div class="data"><?php item_realestate_attributes(); ?></div>
                    <div class="author">
                        <?php echo osc_format_date(osc_item_pub_date()); ?><br />
                        <?php echo osc_item_city(); ?> (<?php echo osc_item_region();?>)
                    </div>
                </div>
            </div>
            <?php if($i==5) search_ads_listing_medium_fn(); ?>
        <?php } ?>