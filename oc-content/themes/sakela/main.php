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
    osc_add_hook('header','sakela_follow_construct');

    sakela_add_body_class('home');


    $buttonClass = '';
    $listClass   = '';
    if(sakela_show_as() == 'gallery'){
          $listClass = 'listing-grid';
          $buttonClass = 'active';
    }
?>
<?php osc_current_web_theme_path('header.php') ; ?>
<div class="clear"></div>
<div class="latest-all-ads">
<div class="list-grid-buttons">  
    <h1><strong><?php _e('Latest Listings', 'sakela') ; ?></strong></h1>
     <?php if( osc_count_latest_items() == 0) { ?>
        <div class="clear"></div>
        <p class="empty"><?php _e("There aren't listings available at this moment", 'sakela'); ?></p>
    <?php } else { ?>
        <div class="actions">
          <span class="doublebutton <?php echo $buttonClass; ?>">
               <a href="<?php echo osc_base_url(true); ?>?sShowAs=list" class="list-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('List', 'sakela'); ?></span></a>
               <a href="<?php echo osc_base_url(true); ?>?sShowAs=gallery" class="grid-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('Grid', 'sakela'); ?></span></a>
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
            <strong id="latest-listing-strong"><?php _e('See all listings', 'sakela') ; ?> &raquo;</strong></a>
        </p>
    <?php } ?>
<?php } ?>
</div>
  <div id="main-sidebar">
    <?php if(osc_get_preference('show_popular', 'sakela') == '1'){?>
    <h2 class="title"> <?php echo sprintf(__('Most viewed in %s', 'sakela'), osc_page_title()) ; ?> </h2>
    <?php if(sakela_show_popular_searches() ){ ?>
    <section id='Searches'>
      <div class="popular-cities">
        <?php $searches =   sakela_popular_searches( sakela_popular_searches_limit() ); ?>
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
    <?php if(sakela_show_popular_regions() ){ ?>
    <section id='Regions'>
      <div class="popular-regions">
        <?php $regions  =   sakela_popular_regions(sakela_popular_regions_limit()); ?>
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
    <?php if(sakela_show_popular_cities() ){ ?>
    <section id='Cities'>
      <div class="popular-cities">
        <?php $cities   =   sakela_popular_cities(sakela_popular_cities_limit()); ?>
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
</div><!-- main -->
<div class="clear"><!-- do not close, use main clossing tag for this case -->
<?php if( osc_get_preference('homepage-728x90', 'sakela') != '') { ?>
<!-- homepage ad 728x60-->
<div class="ads_728">
    <?php echo osc_get_preference('homepage-728x90', 'sakela'); ?>
</div>
<!-- /homepage ad 728x60-->
<?php } ?>
<?php osc_current_web_theme_path('footer.php') ; ?>