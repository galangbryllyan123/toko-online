<div class="container page-content front">

<?php if (osc_get_preference('homepage-block1', 'wayst')){ echo osc_get_preference('', 'wayst');} else { echo ' <div class="alert alert-info site-message alert-with-icon table">  <div class="icon-sign"><i class="fa fa-check-circle"></i></div>  <div class="icon-message"> Post a free ad in under 60 seconds. Get enquiries and make cash! <a class="small" href="'. osc_item_post_url(). '">'. __("Publish", "wayst") . '!</a>  </div></div>  '; } ?>
<?php if( osc_get_preference('homepage-block1', 'wayst') != '') {?>


                                                <div class="alert alert-info site-message alert-with-icon table">  <div class="icon-sign"><i class="fa fa-check-circle"></i></div>  <div class="icon-message"> <?php echo osc_get_preference('homepage-block1', 'wayst'); ?> <a class="small" href="<?php echo osc_get_preference('homepage-block1l', 'wayst'); ?>"><?php echo osc_get_preference('homepage-block2', 'wayst'); ?>!</a>  </div></div>    <?php } ?>            
                                                <div align="center"><?php osc_show_widgets('header'); ?></div>
                                                <div class="front-left">
                                                <h2 class="front-title"><a href="<?php echo osc_search_show_all_url();?>" class="ga-event" data-cat="Front" data-action="" data-label="Heading"><?php _e("See all listings", 'wayst'); ?> &raquo;</a></h2><div class="front-covers grid  front-no-title ">  <!-- class: hide-mobile-captions -->      <?php 
	
				echo homepage_image(); 
		
?>
                
                <?php osc_query_item(array(
    "category_name" => "",
	"results_per_page" => "16",
	// "offset" => $random
    
));
if( osc_count_custom_items() == 0) { ?>
    <p class="empty"><?php _e('No Listings', 'wayst') ; ?></p>
<?php } else { ?>
                
                    <?php $class = "ga-event overlay-5"; ?>
                                <?php while ( osc_has_custom_items() ) { ?>
                <div class="front-cover front-cover-small">
                
            <a href="<?php echo osc_item_url(); ?>" title="<?php echo osc_highlight( strip_tags( osc_item_title() ), 40 ); ?> - <?php if ( osc_item_pub_date() != '' ) echo __('', '') . ' ' . osc_format_date( osc_item_pub_date() ); ?>" class="<?php osc_run_hook("highlight_class"); ?> <?php echo $class. (osc_item_is_premium()?" premium":""); ?>" data-cat="Front" data-action="" data-label="<?php echo osc_esc_html(osc_item_title()); ?>"></a>
           <?php if( osc_images_enabled_at_items() ) { ?> <figure>
           <?php if( osc_count_item_resources() ) { ?>
                                                
                <img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>">
                <?php } else { ?>
                                                <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" />
                                            <?php } ?>
                                    <figcaption>
                        <?php echo osc_highlight( strip_tags( osc_item_title() ), 19 ); ?> <div class="title2"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { echo osc_item_formated_price(); ?> <?php } ?></div><!-- < ?php echo (osc_item_is_premium()?" premium":""); ?> -->                    </figcaption>
                            </figure><?php } ?>
                           <!-- <span class="price">
                        < ?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { echo osc_item_formated_price(); ?>                    </span>< ?php } ?> -->
                            
                    </div>
                    <?php $class = ($class == 'ga-event overlay-5') ? 'ga-event overlay-3' : 'ga-event overlay-5'; ?>
                                <?php } ?>
                    
                    <?php View::newInstance()->_erase('items'); } ?>
        </div>                        
        
                                                <?php osc_current_web_theme_path('common/rslider1.php') ; ?> 
                                                <div class="clearfix"></div>
                                                <?php osc_current_web_theme_path('common/rslider2.php') ; ?>
                                                <div class="clearfix"></div>
                                                <?php osc_current_web_theme_path('common/rslider3.php') ; ?>                       
                                                <div class="clearfix"></div>
                                                
                                                 <div class=" hidden-sm hidden-xs visible-md visible-lg visible-xl" align="center">
                    <?php if (osc_get_preference('header-728x90', 'wayst')){ echo osc_get_preference('header-728x90', 'wayst');} else { echo ''; } ?>
                    </div>
                        
                                                
                        </div>                <?php osc_current_web_theme_path('common/rright-column.php') ; ?>
                                <div class="right-column" align="center">
                                
                                
                    <div class=" hidden-sm hidden-xs hidden-md ">
                    <aside class="best-sellers">
                    <?php if (osc_get_preference('homepage-728x90', 'wayst')){ echo osc_get_preference('homepage-728x90', 'wayst');} else { echo '<img src="' . osc_current_web_theme_url('images/unnamed.png') . '"> '; } ?>
                    </aside>
                    </div>
                    
                    
                    
                    <div class=" hidden-sm hidden-xs visible-md ">
                    <aside class="best-sellers">
                    <?php if (osc_get_preference('header-728x90', 'wayst')){ echo osc_get_preference('header-728x90', 'wayst');} else { echo '<img src="' . osc_current_web_theme_url('images/unnamed2.png') . '"> '; } ?>
                    </aside>
                    </div>
                    
                    
                    <?php if( osc_get_preference('search-results-top-728x90', 'wayst') != '') {?>
                    <div class=" visible-sm hidden-xs hidden-md ">
                    <aside class="best-sellers">
                    <?php echo osc_get_preference('search-results-top-728x90', 'wayst'); ?>
                    </aside>
                    </div>
                    <?php } ?>
                    
                    
                    <div class=" hidden-sm visible-xs hidden-md ">
                    <aside class="best-sellers">
                    <?php if (osc_get_preference('sidebar-300x250', 'wayst')){ echo osc_get_preference('sidebar-300x250', 'wayst');} else { echo '<img src="' . osc_current_web_theme_url('images/banner300-250.jpg') . '"> '; } ?>
                    </aside>
                    </div>
                    
                    
                </div>
                
                
                                             </div>