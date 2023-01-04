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
            <div class="col-md-3">
                <?php osc_goto_first_category() ; ?>
                <?php if(osc_count_categories ()> 0) { ?>
                <ul class="list-group">
                    <?php while ( osc_has_categories() ) { ?>
                    <li onclick="parent.location='<?php echo osc_search_category_url() ; ?>'" class="list-group-item cursor1"> <span class="badge"><?php echo osc_category_total_items() ; ?></span> <i class="fa fa-<?php echo heros_category_icon( osc_category_id() ); ?> warna"></i>
                        <?php echo osc_category_name() ; ?><div class="dropdown-menu subbox box">
                            <h4><i class="fa fa-<?php echo heros_category_icon( osc_category_id() ); ?> warna"></i> <?php echo osc_category_name() ; ?></h4>
                            <?php if ( osc_count_subcategories()> 0 ) { ?>
                            <ul class="row">
                                <?php while ( osc_has_subcategories() ) { ?>
                                <li class="col-md-4 manis">
                                    <i class="fa fa-<?php echo heros_category_icon( osc_category_id() ); ?> warna"></i> <a class="<?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>">
                                        <?php echo osc_category_name() ; ?> <span>(<?php echo osc_category_total_items() ; ?>)</span> </a>
                                </li>
                                <?php } ?>
                                <li class="clearfix"></li>
                            </ul>
                            <?php } ?> </div>
                    </li>
                    <?php } ?> </ul>
                <?php } ?> </div>
            <div class="col-md-6">
                <div id="owl-demo5" class="owl-carousel owl-theme">
                    <?php echo logo_slider(); ?>
                    <?php echo logo_slider_1(); ?>
                    <?php echo logo_slider_2(); ?>
                    <?php echo logo_slider_3(); ?> </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12 populer">
                        <div class="panel panel-default">
                            <div class="panel-heading"> <span class="fa  fa-bullhorn"></span> <b><?php _e("Sponsored ad", 'hero') ; ?></b> </div>
                            <div class="panel-body padi">
                                <div class="row">
                                    <div class="slider2">
                                        <ul class="demo1">
                                            <?php osc_get_premiums($max=osc_get_preference('popularads_num_ads', 'hero')) ;if( osc_count_premiums()> 0 ) { ?>
                                            <?php while ( osc_has_premiums() ) { ?>
                                            <li class="news-item">
                                                <table>
                                                    <tr>
                                                        <?php if( osc_count_premium_resources() ) { ?>
                                                        <td><a class="pull-left" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img class="media-object empatpuluh" src="<?php echo osc_resource_thumbnail_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>"></a> </td>
                                                        <td>
                                                         <?php } else { ?>
                                                        <td><a class="pull-left" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img class="media-object empatpuluh" src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>"></a> </td>
                                                        <td>
                                                        <?php } ?> 
                                                            <div class="pull-right">
                                                                <a href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>">
                                                                    <?php echo osc_premium_title(); ?> </a>
                                                                <br> <span><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) { ?><small><?php echo osc_format_price(osc_premium_price(), osc_premium_currency_symbol()); ?></small><?php } ?></span> </div>
                                                        </td></tr>
                                                </table>
                                            </li>
                                            <?php } ?>
                                            <?php } ?> </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(osc_get_preference('sect10_view', 'hero_theme')=="1" ) { ?>
            <div class="col-md-12">
                <?php echo osc_get_preference('memo-us', 'hero'); ?> </div>
            <?php } ?>
            
            <?php if(osc_get_preference('sect1_view', 'hero_theme')=="1" ) { ?>
            <div class="col-md-12">
                <div class="catalog">
                    <div class="warna teng"><i class="fa fa-star"></i> <?php _e('Premium Ads', 'hero'); ?></div>
                </div>
                <?php osc_get_premiums($max=osc_get_preference('popularads_num_ads', 'hero')) ; if( osc_count_premiums()> 0 ) { ?>
                <div id="owl-demo" class="owl-carousel">
                    <?php while ( osc_has_premiums() ) { ?>
                    <div class="item productbox caption">
<div class="ribbonz"><span class="premiumss"><?php _e("Premium", 'hero'); ?></span></div>
                        <?php if( osc_count_premium_resources() ) { ?><a href="<?php echo osc_premium_url() ; ?>"><img class="lazyOwl" src="<?php echo osc_resource_thumbnail_url() ; ?>" data-src="<?php echo osc_resource_thumbnail_url() ; ?>" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"></a>
                        <?php } else { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_premium_category_id() ); ?> warna"></i></span><a href="<?php echo osc_premium_url() ; ?>">
            <img class="lazyOwl" src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" data-src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"/></a>
                        <?php } ?>
                        <div class="productprice">
                            <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) { ?>
                            <div class="pricetext">
                                <?php echo osc_format_price(osc_premium_price(), osc_premium_currency_symbol()); ?> </div>
                            <?php } ?> </div>
                        <div class="producttitle aribudin">
                            <a href="<?php echo osc_premium_url() ; ?>">
                                <?php echo osc_premium_title(); ?> </a>
                        </div>
                        <div class="centered">
                            <?php if(osc_premium_city()!='' ) { ?><strong><i class="fa fa-map-marker"></i></strong>
                            <?php echo osc_premium_city(); ?>
                            <?php } ?> &middot;
                            <?php if(osc_premium_region()!='' ) { ?>
                            <?php echo osc_premium_region(); ?>
                            <?php } ?> </div>
                    </div>
                    <?php } ?> </div>
                <?php } ?> </div>
            <?php } ?>
            <?php if(osc_get_preference('sect2_view', 'hero_theme')=="1" ) { ?>
            <div class="col-md-12">
                <div class="catalog">
                    <div class="warna teng"><i class="fa fa-rss"></i> <?php _e('Latest Ads', 'hero'); ?></div>
                </div>
                <?php osc_query_item(array( "results_per_page"=> osc_get_preference('latest_num_ads', 'hero'))); if( osc_count_custom_items() == 0) { ?>
                <div id="owl-demo2" class="owl-carousel">
                    <p class="empty">
                        <?php _e("No Latest Listings", 'hero'); ?> </p>
                </div>
                <?php } else { ?>
                <div id="owl-demo2" class="owl-carousel">
                    <?php while ( osc_has_custom_items() ) { ?>
                    <div class="<?php osc_run_hook("highlight_class"); ?> item productbox caption">
<?php if( osc_item_is_premium() ) { ?>
<div class="ribbonz"><span class="premiumss"><?php _e("Premium", 'hero'); ?></span></div><?php } ?> 
                        <?php if( osc_images_enabled_at_items() ) { ?>
                        <?php if( osc_count_item_resources() ) { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_item_category_id() ); ?> warna"></i></span><a href="<?php echo osc_item_url(); ?>"><img class="lazyOwl" src="<?php echo osc_resource_thumbnail_url(); ?>" data-src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"></a>
                        <?php } else { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_item_category_id() ); ?> warna"></i></span><a href="<?php echo osc_item_url(); ?>"><img class="lazyOwl" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" data-src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"/></a>
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
                <?php } ?> </div>
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
                    <?php echo brand_8(); ?> </div>
            </div>
            <?php } ?> </div>
    </div>
    </div>