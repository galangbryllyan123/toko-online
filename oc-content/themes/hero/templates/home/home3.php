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
<div class="main">
    <div class="container">
        <div class="row">
            <?php if(osc_get_preference('sect10_view', 'hero_theme')=="1" ) { ?>
            <div class="col-md-12">
                <?php echo osc_get_preference('memo-us', 'hero'); ?> 
            </div>
            <?php } ?>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 catico">
                    <ul class="lia-list-standard fadeInDown animated">
                    <?php osc_goto_first_category(); ?>
                    <?php while ( osc_has_categories() ) { ?>
            
                <li>
                    <a href="<?php echo osc_search_category_url() ; ?>"><div style="background: #fff url(<?php echo osc_current_web_theme_url() ; ?>/images/categorys/<?php echo osc_category_id() ; ?>.png) no-repeat;background-size:contain;background-position: center center;" class="icos <?php echo osc_category_slug() ; ?>"></div></a>
                    <a class="nams" href="<?php echo osc_search_category_url() ; ?>">
                        <?php echo osc_category_name() ; ?> </a>
                </li>
            
            <?php } ?>
                       </ul>
             <?php if(osc_count_categories ()> 10) { ?>
            <div class='show-more hidden'><?php _e('View more...', 'hero'); ?> <i class="fa  fa-angle-double-down"></i></div>
<div class='show-less hidden'><?php _e('hide', 'hero'); ?> <i class="fa  fa-angle-double-up"></i></div>
            <?php } else { ?> 
            <?php } ?> 
                    </div>

                </div>
            </div>

<?php if(osc_get_preference('header-728x90', 'hero')!='' ) { ?><div class="col-md-12"><div class="row"><div class="ad-home ads"><?php echo osc_get_preference('header-728x90', 'hero'); ?></div></div></div><?php } ?> 

            <?php if(osc_get_preference('sect1_view', 'hero_theme')=="1" ) { ?>
            <div class="col-md-12">
                <div class="catalog">
                    <div class="warna teng"><i class="fa fa-star"></i> <?php _e('Premium Ads', 'hero'); ?></div>
                </div>
                <?php osc_get_premiums($max=osc_get_preference('popularads_num_ads', 'hero')) ; if( osc_count_premiums()> 0 ) { ?>
                <div id="owl-demo" class="owl-carousel">
                    <?php while ( osc_has_premiums() ) { ?>
                    <div class="item productbox caption"><div class="ribbonz"><span class="premiumss"><?php _e("Premium", 'hero'); ?></span></div>
                        <?php if( osc_count_premium_resources() ) { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_premium_category_id() ); ?> warnas"></i></span>
                        <a href="<?php echo osc_premium_url() ; ?>"><img class="lazyOwl" src="<?php echo osc_resource_thumbnail_url() ; ?>" data-src="<?php echo osc_resource_thumbnail_url() ; ?>" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"></a>
                        <?php } else { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_premium_category_id() ); ?> warnas"></i></span>
                        <a href="<?php echo osc_premium_url() ; ?>">
            <img class="lazyOwl" src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" data-src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"/></a>
                        <?php } ?>
                        <div class="productprice">
                            <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) { ?>
                            <div class="pricetext">
                                <?php echo osc_format_price(osc_premium_price(), osc_premium_currency_symbol()); ?> </div>
                            <?php } ?> </div>
                        <div class="producttitle aribudin">
                            <a href="<?php echo osc_premium_url() ; ?>"><?php echo osc_premium_title(); ?></a>
                        </div>
                        <div class="centered">
                            <?php if(osc_premium_city()!='' ) { ?><strong><i class="fa fa-map-marker"></i></strong>
                            <?php echo osc_premium_city(); ?>
                            <?php } ?> &middot;
                            <?php if(osc_premium_region()!='' ) { ?>
                            <?php echo osc_premium_region(); ?>
                            <?php } ?> </div>
                    </div>
                    <?php } ?> 
                </div>
                <?php } ?> 
            </div>
            <?php } ?>
            <?php if(osc_get_preference( 'sect2_view', 'hero_theme')=="1" ) { ?>
            <div class="col-md-12">
                <div class="catalog">
                    <div class="warna teng"><i class="fa fa-rss"></i> <?php _e('Latest Ads', 'hero'); ?></div>
                </div>
                <?php osc_query_item(array("results_per_page"=> osc_get_preference('latest_num_ads', 'hero'))); if( osc_count_custom_items()== 0) { ?>
                <div id="owl-demo2" class="owl-carousel">
                    <p class="empty">
                        <?php _e('No Latest Listings', 'hero'); ?> </p>
                </div>
                <?php } else { ?>
                <div class="row">
                    <div class="baru">
                        <?php while ( osc_has_custom_items() ) { ?>
                        <div class="<?php osc_run_hook("highlight_class"); ?> item col-lg-2 col-md-15 col-md-2 col-sm-3 col-xs-4 four-6 ari-6 three-12 productbox caption"><?php if( osc_item_is_premium() ) { ?>
<div class="ribbonz"><span class="premiumss"><?php _e("Premium", 'hero'); ?></span></div><?php } ?> 
                            <?php if( osc_images_enabled_at_items() ) { ?>
                            <?php if( osc_count_item_resources() ) { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_item_category_id() ); ?> warnas"></i></span>
                            <a href="<?php echo osc_item_url(); ?>"><img class="lazyOwl" src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"></a>
                            <?php } else { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_item_category_id() ); ?> warnas"></i></span>
                            <a href="<?php echo osc_item_url(); ?>"><img class="lazyOwl" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"/></a>
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
                                <?php } ?> 
                            </div>
                        </div>
                        <?php } ?> 
                    </div>
                </div>
                <?php } ?> 
            </div>
            <?php } ?>
            <?php if(osc_get_preference( 'sect6_view', 'hero_theme')=="1" ) { ?>
            <div class="col-md-12">
                <div class="catalog">
                    <div class="warna teng"><i class="fa fa-dollar"></i> <?php _e('Price', 'hero'); ?></div>
                </div>
                <div class="pricing">
                    <ul>
                        <li class="unit price-primary">
                            <div class="price-title">
                                <?php echo osc_get_preference('price1-us', 'hero'); ?> </div>
                            <div class="price-body">
                                <?php echo osc_get_preference('price2-us', 'hero'); ?>
                                <ul>
                                    <?php echo osc_get_preference('price3-us', 'hero'); ?> </ul>
                            </div>
                            <div class="price-foot">
                                <a href="<?php echo osc_get_preference('price5-us', 'hero'); ?>" class="btn btn-primary">
                                    <?php echo osc_get_preference('price4-us', 'hero'); ?></a>
                            </div>
                        </li>
                        <li class="unit price-success active">
                            <div class="price-title">
                                <?php echo osc_get_preference('price6-us', 'hero'); ?> </div>
                            <div class="price-body">
                                <?php echo osc_get_preference('price7-us', 'hero'); ?>
                                <ul>
                                    <?php echo osc_get_preference('price8-us', 'hero'); ?> </ul>
                            </div>
                            <div class="price-foot">
                                <a href="<?php echo osc_get_preference('price10-us', 'hero'); ?>" class="btn btn-success">
                                    <?php echo osc_get_preference('price9-us', 'hero'); ?></a>
                            </div>
                        </li>
                        <li class="unit price-warning">
                            <div class="price-title">
                                <?php echo osc_get_preference('price11-us', 'hero'); ?> </div>
                            <div class="price-body">
                                <?php echo osc_get_preference('price12-us', 'hero'); ?>
                                <ul>
                                    <?php echo osc_get_preference('price13-us', 'hero'); ?> </ul>
                            </div>
                            <div class="price-foot">
                                <a href="<?php echo osc_get_preference('price15-us', 'hero'); ?>" class="btn btn-warning">
                                    <?php echo osc_get_preference('price14-us', 'hero'); ?> </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <?php } ?>
            <?php if(osc_get_preference('sect5_view', 'hero_theme')=="1" ) { ?>
            <div class="col-md-12">
                <div class="catalog">
                    <div class="warna teng"><i class="fa fa-users"></i> <?php _e('Client', 'hero'); ?>
                    </div>
                </div>
                <div id="owl-demo7" class="owl-carousel">
                    <?php echo brand_1(); ?>
                    <?php echo brand_2(); ?>
                    <?php echo brand_3(); ?>
                    <?php echo brand_4(); ?>
                    <?php echo brand_5(); ?>
                    <?php echo brand_6(); ?>
                    <?php echo brand_7(); ?>
                    <?php echo brand_8(); ?> 
                </div>
            </div>
            <?php } ?> 
        </div>
    </div>
</div>
<script>
$(function(){
    
   $('.show-more').on('click', function(){
       $('.lia-list-standard li:gt(21)').show();
       $('.show-less').removeClass('hidden');
       $('.show-more').addClass('hidden');
    });

    $('.show-less').on('click', function(){
       $('.lia-list-standard li:gt(21)').hide();
       $('.show-more').removeClass('hidden');
       $('.show-less').addClass('hidden');
    });
    
    //Show only four items
    if ( $('.lia-list-standard li').length > 22 ) {
        /*$('.lia-list-standard li:gt(21)').hide();
        $('.show-more').removeClass('hidden');
        */
        
            $('.show-less').click();
    }
});
</script>