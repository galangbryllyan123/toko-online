<?php
    

    // meta tag robots
    osc_add_hook('header','flux_follow_construct');

    flux_add_body_class('home');


    $buttonClass = '';
    $listClass   = '';
    if(flux_show_as() == 'gallery'){
          $listClass = 'listing-grid';
          $buttonClass = 'active';
    }
?>
<?php osc_current_web_theme_path('header.php') ; ?>
<div class="clear"></div>
<div class="latest_ads">
<div class="__mdl_listing_frame">
<h1><strong><?php _e('Latest Listings', 'flux') ; ?></strong></h1>
 <?php if( osc_count_latest_items() == 0) { ?>
    <div class="clear"></div>
    <p class="empty"><?php _e("There aren't listings available at this moment", 'flux'); ?></p>
<?php } else { ?>
    <div class="actions">
      <span class="doublebutton <?php echo $buttonClass; ?>">
           <a href="<?php echo osc_base_url(true); ?>?sShowAs=list" class="list-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('List', 'flux'); ?></span></a>
           <a href="<?php echo osc_base_url(true); ?>?sShowAs=gallery" class="grid-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('Grid', 'flux'); ?></span></a>
      </span>
    </div>
    </div>
    <?php
    View::newInstance()->_exportVariableToView("listType", 'latestItems');
    View::newInstance()->_exportVariableToView("listClass",$listClass);
    osc_current_web_theme_path('loop.php');
    ?>

    <div class="clear"></div>
    <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>
        <p class="see_more_link"><a href="<?php echo osc_search_show_all_url() ; ?>">
            <?php _e('See all listings', 'flux') ; ?> &raquo;</a>
        </p>
    <?php } ?>
<?php } ?>
</div>
</div><!-- main -->
<div id="sidebar">
    <?php if( osc_get_preference('sidebar-300x250', 'flux') != '') {?>
    <!-- sidebar ad 350x250 -->
    <div class="ads_300">
        <?php echo osc_get_preference('sidebar-300x250', 'flux'); ?>
    </div>
    <!-- /sidebar ad 350x250 -->
    <?php } ?>
    <div class="widget-box">
        <?php if(osc_count_list_regions() > 0 ) { ?>
        <div class="box location">
            <h3><strong><?php _e("Location", 'flux') ; ?></strong></h3>
            <ul>
            <?php while(osc_has_list_regions() ) { ?>
                <li><a href="<?php echo osc_list_region_url(); ?>"><?php echo osc_list_region_name() ; ?> <em>(<?php echo osc_list_region_items() ; ?>)</em></a></li>
            <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </div>
</div>
<div class="clear"><!-- do not close, use main clossing tag for this case -->
<?php if( osc_get_preference('homepage-728x90', 'flux') != '') { ?>
<!-- homepage ad 728x60-->
<div class="ads_728">
    <?php echo osc_get_preference('homepage-728x90', 'flux'); ?>
</div>

<!-- /homepage ad 728x60-->
<?php } ?>
<?php osc_run_hook("oswz-partnership-slider")?>
<?php osc_current_web_theme_path('footer.php') ; ?>