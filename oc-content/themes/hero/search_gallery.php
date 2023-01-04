<?php
    /*
     *       Hero Responsive Osclass Themes
     *       
     *       Copyright (C) 2017 OSCLASS.me
     * 
     *       This is Hero Osclass Themes with Single License
     *  
     *       This program is a commercial software. Copying or distribution without a license is not allowed.
     *         
     *       If you need more licenses for this software. Please read more here <http://www.osclass.me/osclass-me-license/>.
     */
?>
<div class="col-md-12">
<?php while(osc_has_items()) { ?>
<div class="<?php osc_run_hook("highlight_class"); ?> item col-lg-2 col-md-15 col-md-2 col-sm-3 col-xs-4 four-6 ari-6 three-12 productbox caption">
<?php if( osc_item_is_premium() ) { ?>
<div class="ribbonz"><span class="premiumss"><?php _e("Premium", 'hero'); ?></span></div><?php } ?> 
        <?php if( osc_images_enabled_at_items() ) { ?>
        <?php if(osc_count_item_resources()) { ?> <a href="<?php echo osc_item_url(); ?>"><img class="lazyOwl" src="<?php echo osc_resource_thumbnail_url(); ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" /></a>

<span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_item_category_id() ); ?> warnas"></i></span> 
                                  
        <?php } else { ?> <a href="<?php echo osc_item_url(); ?>"><img class="lazyOwl" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" /></a>

<span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_item_category_id() ); ?> warnas"></i></span> 
                                 
        <?php } ?>
        <?php } ?>
        <div class="productprice">
            <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { ?>
            <p><strong><?php echo osc_format_price(osc_item_price()); ?></strong></p>
            <?php } ?>
            <div class="aribudin">
                <a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a>
            </div>
            <br>
            <div class="centered">
                <?php if(osc_item_city()!='' ) { ?><strong><i class="fa fa-map-marker"></i></strong>
                <?php echo osc_item_city(); ?>
                <?php } ?> &middot;
                <?php if(osc_item_region()!='' ) { ?>
                <?php echo osc_item_region(); ?>
                <?php } ?> 
            </div>
    </div>
</div>
<?php } ?>
</div>