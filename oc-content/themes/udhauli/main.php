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
    osc_add_hook('header','udhauli_follow_construct');

    udhauli_add_body_class('home');


    $buttonClass = '';
    $listClass   = '';
    if(udhauli_show_as() == 'gallery'){
          $listClass = 'listing-grid';
          $buttonClass = 'active';
    }
?>
<?php osc_current_web_theme_path('header.php') ; ?>

<?php osc_get_premiums(udhauli_premium_listings_shown_home());  
    if(osc_count_premiums() > 0) { ?>
<div id="premium-slick-slider">
<h2 class="title">
  <?php _e('Premium Listings','udhauli');?>
</h2>
<div id="listing-card-list" class="listing-card-list listings_grid listings_grids">
  <div class="row regular">
    <?php
  $listcount = 1;
    while ( osc_has_premiums() ) { ?>
    <?php $size = explode('x', osc_thumbnail_dimensions()); ?>
    <div class="col-md-4 premium">
    <div class="listing-card">
      <div class="grid-view">
        <div class="grid-images">
            <?php if( osc_images_enabled_at_items() ) { ?>
            <?php if(osc_count_premium_resources()) { ?>
            <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img class="img-responsive" src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
            <?php } else { ?>
            <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
            <?php } ?>
            <?php } ?>
        </div>
            <span class="ribbon">
              <span> <?php _e('Premium','udhauli');?> </span> 
            </span>
            <?php if( osc_price_enabled_at_items() ) { ?>
            <span class="currency-value"><?php echo osc_format_price(osc_premium_price(), osc_premium_currency_symbol()); ?></span>
            <?php } ?>
        <div class="listing-attr">
          <h4><a href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><?php echo osc_highlight(strip_tags(osc_premium_title()),18) ; ?></a></h4>
          <span class="category"><?php echo osc_premium_category() ; ?></span> <br><br>
           <p><?php echo osc_highlight( osc_premium_description(), 70 ); ?></p><br>
          <article>         
          <div class="row car-descriptions">
            <div class="year col-xs-4"><i class="fa fa-calendar"></i><br><?php echo udhauli_cars_vehiclesYear(osc_premium_ID()); ?> </div>
            <div class="mileage col-xs-4"><i class="fa fa-tachometer"></i><br><?php echo udhauli_cars_vehiclesMileage(osc_premium_ID()); ?> </div>
            <div class="transmission col-xs-4"><i class="fa fa-gears"></i><br><?php echo udhauli_cars_vehiclesTransmissions(osc_premium_ID()); ?> </div>
          </div>
          </article>
          </div>
      </div>
    </div>
    </div>
    <?php
    
  } 
  ?>
  </ul>
</div>
</div>
<?php
  }
 ?>
 
<div class="clear"></div>
<div class="latest-ads">
<h1><?php _e('Latest Listings', 'udhauli') ; ?></h1>
 <?php if( osc_count_latest_items() == 0) { ?>
    <div class="clear"></div>
    <p class="empty"><?php _e("There aren't listings available at this moment", 'udhauli'); ?></p>
<?php } else { ?>
    <div class="actions">
      <span class="doublebutton <?php echo $buttonClass; ?>">
           <a href="<?php echo osc_base_url(true); ?>?sShowAs=list#listing-card-list" class="list-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('List', 'udhauli'); ?></span></a>
           <a href="<?php echo osc_base_url(true); ?>?sShowAs=gallery#listing-card-list" class="grid-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('Grid', 'udhauli'); ?></span></a>
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
            <strong><?php _e('See all listings', 'udhauli') ; ?> &raquo;</strong></a>
        </p>
    <?php } ?>
<?php } ?>
</div>
</div><!-- main -->
<div id="sidebar">
    <?php if(osc_get_preference('show_popular', 'udhauli') == '1'){?>
    <h2 class="title"> <?php echo sprintf(__('Most viewed in '.'%s', 'udhauli'), osc_page_title()) ; ?> </h2>
    <?php if(udhauli_show_popular_searches() ){ ?>
    <div class="row" id="mostview-row">
    <section id='Searches'>
      <div class="popular-cities">
        <?php $searches =   udhauli_popular_searches( udhauli_popular_searches_limit() ); ?>
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
    <?php if(udhauli_show_popular_regions() ){ ?>
    <section id='Regions'>
      <div class="popular-regions">
        <?php $regions  =   udhauli_popular_regions(udhauli_popular_regions_limit()); ?>
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
    <?php if(udhauli_show_popular_cities() ){ ?>
    <section id='Cities'>
      <div class="popular-cities">
        <?php $cities   =   udhauli_popular_cities(udhauli_popular_cities_limit()); ?>
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
<?php if( osc_get_preference('homepage-728x90', 'udhauli') != '') { ?>
<!-- homepage ad 728x60-->
</br><div class="ads_header ads-headers">
    <?php echo osc_get_preference('homepage-728x90', 'udhauli'); ?>
</div>
<!-- /homepage ad 728x60-->
<?php } ?>
<?php osc_current_web_theme_path('footer.php') ; ?>