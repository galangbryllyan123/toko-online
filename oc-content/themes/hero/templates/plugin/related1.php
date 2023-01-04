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
<div class="related">
    <div id="owl-demo45" class="owl-carousel">
        <?php while(osc_has_items()) { ?>
        <div class="item productbox">
<?php if( osc_item_is_premium() ) { ?>
<div class="ribbonz"><span class="premiumss"><?php _e("Premium", 'hero'); ?></span></div><?php } ?>
            <?php if( osc_images_enabled_at_items() ) { ?>
            <?php if(osc_count_item_resources()) { ?> <a href="<?php echo osc_item_url(); ?>"><img class="lazyOwl" src="<?php echo osc_resource_thumbnail_url(); ?>" data-src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"></a>
            <?php } else { ?> <a href="<?php echo osc_item_url(); ?>" class="overlay-background-color" title="<?php echo osc_esc_html(osc_item_title()) ; ?>">&nbsp;</a> <a href="<?php echo osc_item_url(); ?>"><img class="lazyOwl" src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" data-src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"></a>
            <?php } ?>
            <?php } ?>
            <div class="productprice">
                            <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { ?>
                            <div class="pricetext">
                                <?php echo osc_format_price(osc_item_price()); ?> </div>
                            <?php } ?> </div>
                        <div class="producttitle aribudin">
                            <a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a>
                        </div>
                        <div class="centered">
                            <?php if(osc_item_city()!='' ) { ?><strong><i class="fa fa-map-marker"></i></strong>
                            <?php echo osc_item_city(); ?>
                            <?php } ?> &middot;
                            <?php if(osc_item_region()!='' ) { ?>
                            <?php echo osc_item_region(); ?>
                            <?php } ?> </div>
        </div>
        <?php } ?> </div>
</div>
<script src="<?php echo osc_current_web_theme_js_url('owl.carousel.js') ; ?>"></script> 
<script>
$("#owl-demo45").owlCarousel({
    items : 3,
<?php if(osc_get_preference('sect12_view', 'hero_theme') == "1") { ?>
     autoPlay: 5000,
    autoplay: true,
<?php } ?>
    lazyLoad : true,
    navigation : true,
     navigationText: [
      "<i class='fa fa-chevron-left'></i>",
      "<i class='fa fa-chevron-right'></i>"
      ],
  }); 
</script>