<?php
    osc_get_premiums(12);
    if(osc_count_premiums() > 0) {
?>
<div class="right-column">
                    <aside class="best-sellers">
                        <h2 align="center" title="<?php echo osc_esc_html(__('Premium listings', 'wayst')); ?>"><i class="fa fa-check-square-o" aria-hidden="true"></i> <strong><?php _e('Premium listings', 'wayst'); ?></strong></h2>
                        
                        <ol>
                                                            <?php while(osc_has_premiums()) { ?>
                                                                <li>
                                    <a href="<?php echo osc_premium_url(); ?>" class="ga-event" data-cat="Sidebar" data-label="<?php echo osc_esc_html(osc_item_title()); ?>" data-value="10" title="<?php echo osc_esc_html(__('Price', 'wayst')); ?>: <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) { echo osc_premium_formated_price() ; } ?>">
                                    <?php if( osc_images_enabled_at_items() ) { ?>
                                        <figure>
                                        <?php if(osc_count_premium_resources()) { ?>
                                            <img src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>">
                                            <?php } else { ?>
                        <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="No Photo"><?php } ?>
                                        </figure>
                                        <?php } ?>
                                        <span>
                                            <?php echo osc_highlight( strip_tags( osc_premium_title() ), 33 ); ?>                                                                                    </span>
                                    </a>
                                </li>
                                                <?php } ?>        </ol>
                                                
                    </aside>
                </div> <?php } else { ?>
                <?php $random = ''; 
            $random = rand(0, 12); //more info about the rand function can be found at the link below. ?>
	<?php osc_query_item(array(
    "category_name" => "",
	"results_per_page" => "10",
	"offset" => $random
    ));
if( osc_count_custom_items() == 0) { ?>
    
<?php } else { ?>
<div class="right-column">
                    <aside class="best-sellers">
                        <h2 align="center" title="<?php _e('Listings', 'wayst'); ?> <?php _e('Random', 'wayst'); ?>"><i class="fa fa-random" aria-hidden="true"></i> <strong><?php _e('Listings', 'wayst'); ?></strong></h2>
                        
                        <ol>
                                                            <?php while(osc_has_custom_items()) { ?>
                                                                <li>
                                    <a href="<?php echo osc_item_url(); ?>" class="ga-event" data-cat="Sidebar" data-label="<?php echo osc_esc_html(osc_item_title()); ?>" data-value="10" title="<?php echo osc_esc_html(__('Price', 'wayst')); ?>: <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() )  echo osc_item_formated_price(); ?>">
                                    <?php if( osc_images_enabled_at_items() ) { ?>
                                        <figure>
                                        <?php if(osc_count_item_resources()) { ?>
                                            <img src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>">
                                            <?php } else { ?>
                        <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="No Photo"><?php } ?>
                                        </figure>
                                        <?php } ?>
                                        <span>
                                            <?php echo osc_highlight( strip_tags( osc_item_title() ), 33 ); ?>                                                                                    </span>
                                    </a>
                                </li>
                                                <?php } ?>        </ol>
                                                
                    </aside>
                </div> <?php } ?><?php } ?>
                