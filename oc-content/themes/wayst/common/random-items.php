<?php $random = ''; 
            $random = rand(0, 12); //more info about the rand function can be found at the link below. ?>
	<?php osc_query_item(array(
    "category_name" => "",
	"results_per_page" => "6",
	"offset" => $random
    
));
if( osc_count_custom_items() == 0) { ?>
    
<?php } else { ?>
<div class="container  product-release product-search ">
                                    <div class="grid"><div class="clearfix"></div><div class="date-heading"><i class="fa fa-random" aria-hidden="true"></i> <?php _e('Listings', 'wayst'); ?> <?php _e('Random', 'wayst'); ?></div>        
                                    <?php while ( osc_has_custom_items() ) { ?>
                                    <div class="item">
                                    <?php if( osc_images_enabled_at_items() ) { ?>
                                    <?php if(osc_count_item_resources()) { ?>
            <figure><a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" class="image-s" itemprop="image"></a></figure>
            <?php } else { ?>
            <figure><a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" class="image-s" itemprop="image"></a></figure><?php } ?>
            <h2>
                <a href="<?php echo osc_item_url(); ?>"><span itemprop="name"><?php echo osc_highlight( strip_tags( osc_item_title() ), 88 ); ?></span></a>
            </h2>
            <h3><?php echo osc_highlight( strip_tags( osc_item_description() ), 18 ); ?></h3>
            
                    <div class="price-avail">
            <div class="avail"><link itemprop="availability"  /><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() )  echo osc_item_formated_price(); ?><?php } ?></div>        <dl class="">
            <dt></dt>
            <dd><?php echo osc_format_date(osc_item_pub_date()); ?></dd>
        </dl>
                    
                        </div>
                    <div class="cart-wish">
                                            <?php if (function_exists('watchlist')) { ?>  <form class="wishlist">
                                       <a href="javascript://" class="btn btn-wish-add watchlist" id="<?php echo osc_item_id(); ?>"></a>
                
            </form> <?php } else { ?> <?php }?>
                                        </div>
            <!-- <span class="product-label new-label">Hot</span> -->       </div><?php } ?>
                
                                    </div></div>
                                    <?php } ?>