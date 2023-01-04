<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    // meta tag robots
    osc_add_hook('header','lhoshar_follow_construct');

    lhoshar_add_body_class('home');


    $buttonClass = '';
    $listClass   = '';
    if(lhoshar_show_as() == 'gallery'){
          $listClass = 'listing-grid';
          $buttonClass = 'active';
    }
?>
<?php osc_current_web_theme_path('header.php') ; ?>


<?php

    osc_get_premiums(lhoshar_premium_listings_shown_home());
  
    if(osc_count_premiums() > 0) {

?>
<div class="row" id="premium-main-row">
<h2 class="title">
  <?php _e('Premium Listings','lhoshar');?>
</h2>
<div id="listing-card-list" class="listing-card-list listings_grid listings_grids">
  <div class="row regular">
    <?php
  $listcount = 1;
    while ( osc_has_premiums() ) {
  ?>
    <?php $size = explode('x', osc_thumbnail_dimensions()); ?>
    <div class="listing-card premium col-md-3">
        <div class="hovereffect">
        <div id="grid-images">
            <?php if( osc_images_enabled_at_items() ) { ?>
            <?php if(osc_count_premium_resources()) { ?>
            <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img class="img-responsive" src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
            <?php } else { ?>
            <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
            <?php } ?>
            <?php } ?>
        </div>
        <span class="ribbon"><span>
            <?php _e('Premium','lhoshar');?>
            </span> 
        </span>
        <?php if (!EMPTY( lhoshar_realEstate_type(osc_premium_ID()) )) { ?><span class="onsale_wiz"> <?php echo lhoshar_realEstate_type(osc_premium_ID());?> </span><?php } ?> 
        <div class="listing-grid-overlay">    
            <?php if( osc_price_enabled_at_items() ) { ?>
            <span class="currency-value"><?php echo osc_format_price(osc_premium_price(), osc_premium_currency_symbol()); ?></span>
            <?php } ?>
        <div class="listing-attr">
          <h4><a href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><?php echo osc_highlight(strip_tags(osc_premium_title()),40) ; ?></a></h4>
          <article>
            <div class="locate"> <span class="location"><i class="fa fa-map-marker"></i><?php echo osc_premium_city(); ?>
              <?php if(osc_premium_region()!='') { ?>
              ,<?php echo osc_premium_region(); ?>
              <?php } ?>
              </span> </div>
          </article>
        </div>  
      </div>

          <div class="clear_state overlay row" id="overlay-row">
            <?php if ( is_realEstate_enabled() ) { ?> 
              <span class="wiz_area col-xs-4"><?php _e('Area','lhoshar');?><br><?php echo lhoshar_realEstate_area(osc_premium_ID());?> </span>
              <span class="wiz_rooms col-xs-4"><?php _e('Beds','lhoshar');?><br><?php echo lhoshar_realEstate_rooms(osc_premium_ID());?></span> 
              <span class="wiz_bathrooms col-xs-4"><?php _e('Baths','lhoshar');?><br><?php echo lhoshar_realEstate_bathrooms(osc_premium_ID());?></span> 
            <?php } ?>
          </div>
        </div>
    </div>
    <?php
    
  } 
  ?>
</div>
</div>
</div>
<?php
  }
 ?>



<div class="clear"></div>
<div class="latest_ads">
<h1><strong><?php _e('Latest Listings', 'lhoshar') ; ?></strong></h1>
 <?php if( osc_count_latest_items() == 0) { ?>
    <div class="clear"></div>
    <p class="empty"><?php _e("There aren't listings available at this moment", 'lhoshar'); ?></p>
<?php } else { ?>
    <div class="actions">
      <span class="doublebutton <?php echo $buttonClass; ?>">
           <a href="<?php echo osc_base_url(true); ?>?sShowAs=list" class="list-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('List', 'lhoshar'); ?></span></a>
           <a href="<?php echo osc_base_url(true); ?>?sShowAs=gallery" class="grid-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('Grid', 'lhoshar'); ?></span></a>
      </span>
    </div>
    <?php
    View::newInstance()->_exportVariableToView("listType", 'latestItems');
    View::newInstance()->_exportVariableToView("listClass",$listClass);
    osc_current_web_theme_path('loop.php');
    ?>
    <div class="clear"></div>
    <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>
        <p class="see_more_link"><a href="<?php echo osc_search_show_all_url() ; ?>">
            <strong><?php _e('See all listings', 'lhoshar') ; ?> &raquo;</strong></a>
        </p>
    <?php } ?>
<?php } ?>
</div>
</div><!-- main -->
<div id="sidebar">
    <?php if(osc_get_preference('show_popular', 'lhoshar') == '1'){?>
    <h2 class="title"> <?php echo sprintf(__('Most viewed in '.'%s', 'lhoshar'), osc_page_title()) ; ?> </h2>
    <?php if(lhoshar_show_popular_searches() ){ ?>
    <div class="row" id="mostview-row">
    <section id='Searches'>
      <div class="popular-cities">
        <?php $searches =   lhoshar_popular_searches( lhoshar_popular_searches_limit() ); ?>
           <?php if(!empty($searches)){ ?>
        <ul>
          <?php foreach($searches as $search){?>
          <?php if($search['s_search'] !=""){?>
          <li><a href="<?php echo osc_search_url(array('sPattern' => $search['s_search'])); ?>"><?php echo  $search['s_search']; ?> <em>(<?php echo $search['total']; ?>)</em></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
           <?php } ?>
      </div>
    </section>
    <?php } ?>
    <?php if(lhoshar_show_popular_regions() ){ ?>
    <section id='Regions'>
      <div class="popular-regions">
        <?php $regions  =   lhoshar_popular_regions(lhoshar_popular_regions_limit()); ?>
         <?php if(!empty($regions)){ ?>
        <ul>
          <?php foreach($regions as $region => $count){?>
          <li><a href="<?php echo osc_search_url( array( 'sRegion' => $region ) ); ?>"><i class="fa fa-map-marker"></i><?php echo $region; ?> <em>(<?php echo $count; ?>)</em></a></li>
          <?php } ?>
        </ul>
          <?php } ?>
      </div>
    </section>
    <?php } ?>
    <?php if(lhoshar_show_popular_cities() ){ ?>
    <section id='Cities'>
      <div class="popular-cities">
        <?php $cities   =   lhoshar_popular_cities(lhoshar_popular_cities_limit()); ?>
        <?php if(!empty($cities)){ ?>
        <ul>
          <?php foreach($cities as $city => $count){?>
          <li><a href="<?php echo osc_search_url( array( 'sCity' => $city ) ); ?>"><i class="fa fa-map-marker"></i><?php echo $city; ?> <em>(<?php echo $count; ?>)</em></a></li>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
    </section>
    <?php } ?>
  <?php } ?>
</div>
</div>
<div class="clear"><!-- do not close, use main clossing tag for this case -->
<?php if( osc_get_preference('homepage-728x90', 'lhoshar') != '') { ?>
<!-- homepage ad 728x60-->
</br><div class="ads_header ads-headers">
    <?php echo osc_get_preference('homepage-728x90', 'lhoshar'); ?>
</div>
<!-- /homepage ad 728x60-->
<?php } ?>
<?php osc_current_web_theme_path('footer.php') ; ?>