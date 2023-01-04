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
<div class="ama">
<?php $class="even" ; $i=0 ; ?>
<?php while(osc_has_items()) { $i++; ?>
<div class="persen row <?php osc_run_hook("highlight_class"); ?> <?php echo $class; ?> thumbnail">
    <?php if( osc_images_enabled_at_items() ) { ?>
    <div class="col-md-3 col-sm-3 col-xs-3 four-4 ari-5 lias">

        <?php if(osc_count_item_resources()) { ?> <a href="<?php echo osc_item_url(); ?>"><?php if( osc_item_is_premium() ) { ?>
<div class="ribbonz"><span class="premiumss"><?php _e("Premium", 'hero'); ?></span></div><?php } ?><img src="<?php echo osc_resource_thumbnail_url(); ?>"  title="<?php echo osc_esc_html(osc_item_title()) ; ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" /></a>
 
        <?php } else { ?> <a href="<?php echo osc_item_url(); ?>"><?php if( osc_item_is_premium() ) { ?>
<div class="ribbonz"><span class="premiumss"><?php _e("Premium", 'hero'); ?></span></div><?php } ?><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" /></a>
 
        <?php } ?> </div>
    <?php } ?>
    <div class="col-md-9 col-sm-9 col-xs-9 four-8 ari-7 text kat1">
<?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { ?> <h3 class="warnae"><?php echo osc_format_price(osc_item_price()); ?></h3>
        <?php } ?>
        <h4><a href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight( strip_tags( osc_item_title() ) ); ?></a></h4>
        
        <p class="hidden-xs-down"><?php echo osc_highlight( osc_item_description() ,300) ; ?></p>
        <p>
            <?php if(osc_item_city()!='' ) { ?><strong><i class="fa fa-map-marker"></i></strong>
            <?php echo osc_item_city(); ?>
            <?php } ?> &middot;
            <?php if(osc_item_region()!='' ) { ?>
            <?php echo osc_item_region(); ?>
            <?php } ?> <strong class="kirir"><i class="fa fa-calendar"></i></strong>
            <?php echo osc_format_date(osc_item_pub_date()); ?> 
        </p>
    </div>
</div>
<?php $class=( $class=='even' ) ? 'odd' : 'even'; ?>
<?php if( $i==5 ) { ?>
<?php } ?>
<?php } ?>
</div>
</div>