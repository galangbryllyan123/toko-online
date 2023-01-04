<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()) ; ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
</head>
<body>
  <?php osc_current_web_theme_path('header.php') ; ?>
  <div class="content home">
    <div id="sidebar">
      <div class="navigation">
        <div class="box location">
          <ul class="country-block" <?php if(osc_get_preference('new_cat_list', 'tatiana_theme') == 0) { ?>style="margin-top:30px;"<?php } ?>>
            <?php View::newInstance()->_erase('list_countries') ;  ?>
            <?php View::newInstance()->_erase('list_regions') ;  ?>
            <?php View::newInstance()->_erase('list_cities') ;  ?>

            <?php if(osc_count_countries() > 1) { ?>

              <?php while(osc_has_list_countries()) { ?>
                <div id="wrap-list">
                  <?php if(osc_count_list_countries() > 1 ) { ?>
                    <!--<li class="country round3"><a href="<?php echo osc_list_country_url();?>"><?php echo osc_list_country_name();?></a><div id="plus-minus" class="icon-country-<?php if(strtoupper(substr(osc_current_user_locale(), 3)) <> osc_list_country_code()) { echo 'plus';} else { echo 'minus';} ?>"></div></li>-->
                    <li class="country round3"><a href="<?php echo osc_list_country_url();?>"><?php echo osc_list_country_name();?></a><div id="plus-minus" class="icon-country-<?php if(Params::getParam('sCountry') <> osc_list_country_name() and Params::getParam('sCountry') <> osc_list_country_code()) { echo 'plus';} else { echo 'minus';} ?>"></div></li>
                  <?php } ?>

                  <ul class="region-block" <?php if(Params::getParam('sCountry') <> osc_list_country_name() and Params::getParam('sCountry') <> osc_list_country_code() and osc_count_list_countries() > 1) { echo ' style="display:none"';} ?>>
                    <?php View::newInstance()->_exportVariableToView('list_regions', Search::newInstance()->listRegions(osc_list_country_code(), '>', 'region_name ASC') ) ; ?>
                    <?php while(osc_has_list_regions()) { ?>
                      <li class="region"><a href="<?php echo osc_list_region_url(); ?>"><?php echo osc_list_region_name(); ?></a></li>

                      <ul class="city-block">
                        <?php while(osc_has_list_cities(osc_list_region_id())) { ?>
                          <li class="city"><a href="<?php echo osc_list_city_url();?>"><?php echo osc_list_city_name();?></a></li>
                        <?php } ?>
                        <?php View::newInstance()->_erase('list_cities') ;  ?>
                      </ul>
                    <?php } ?>
                    <?php View::newInstance()->_erase('list_regions') ;  ?>
                  </ul>
                </div>
              <?php } ?>
              <?php View::newInstance()->_erase('list_countries') ;  ?>

            <?php //If there is only 1 country, show yellow boxes too ?>
            <?php } else { ?>
              <?php while(osc_has_list_regions()) { ?>
                <div id="wrap-list">
                  <li class="country round3 <?php if(osc_count_list_cities(osc_list_region_id()) == 0) { ?>noclick<?php } ?>" <?php if(osc_count_list_cities(osc_list_region_id()) == 0) { ?>style="cursor:default;"<?php } ?>><a href="<?php echo osc_list_region_url();?>"><?php echo osc_list_region_name();?></a><?php if(osc_count_list_cities(osc_list_region_id()) > 0) { ?><div id="plus-minus" class="icon-country-plus"></div><?php } ?></li>

                  <ul class="region-block" style="display:none">
                    <?php while(osc_has_list_cities(osc_list_region_id())) { ?>
                      <li class="region"><a href="<?php echo osc_list_city_url();?>"><?php echo osc_list_city_name();?></a></li>
                    <?php } ?>
                    <?php View::newInstance()->_erase('list_cities') ;  ?>
                    <li class="region">&nbsp;</li>
                  </ul>
                </div>
              <?php } ?>

              <?php View::newInstance()->_erase('list_regions') ;  ?>
              <?php View::newInstance()->_erase('list_countries') ;  ?>
            <?php } ?>

          </ul>
        </div>
      </div>

      <?php if(osc_get_preference('theme_adsense', 'tatiana_theme') == 1) { ?>
        <div class="home-google">
          <?php echo osc_get_preference('banner_home', 'tatiana_theme'); ?>
        </div>
      <?php } ?>

      <div class="mobile-friendly">
        <div class="text"><?php _e('Available also on your smartphone & tablet', 'tatiana'); ?></div>
      </div>

      <div class="fb-friendly">
        <div class="text"><?php _e('Like us on Facebook and be our fan', 'tatiana'); ?></div>
      </div>
    </div>


    <?php if(osc_get_preference('new_cat_list', 'tatiana_theme') == 0) { ?>
      <div id="main">
        <?php
          $total_categories   = osc_count_categories() ;
          $col1_max_cat       = ceil($total_categories/2);
          $col2_max_cat       = ceil(($total_categories-$col1_max_cat));
        ?>

        <div class="categories <?php echo 'c' . $total_categories ; ?>">
          <?php osc_goto_first_category() ; ?>
          <?php
            $i      = 1;
            $x      = 1;
            $col    = 1;
            $count_i_max = 100;
            if(osc_count_categories () > 0) { echo '<div class="col c1">'; }
          ?>

          <?php while ( osc_has_categories()) { ?><?php $count_i = 0; ?>
            <div class="category">
              <a class="tit" href="<?php echo osc_search_category_url(); ?>" title="<?php echo osc_category_description() ; ?>" alt="<?php echo osc_category_name() ; ?>">
                <img id="main_img" src="<?php echo osc_current_web_theme_url('images/large_cat/').osc_category_id().'.png'; ?>" alt="<?php echo osc_category_name();?>"/>
              </a>

              <div id="main_div">
                <h1>
                  <a href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?> </a>
                </h1>                                                                       

                <?php if ( osc_count_subcategories() > 0 ) { ?>
                  <?php while ( osc_has_subcategories() ) { $count_i = $count_i + strlen(osc_category_name()) + 2; ?>
                    <?php if ($count_i < $count_i_max) { ?><a id="main_link" class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url(); ?>"><?php echo osc_category_name().','; ?></a><?php } ?>
                  <?php } ?>
                  <?php echo '...'; ?>
                <?php } ?>
              </div>
            </div>

            <?php
              if (($col==1 && $i==$col1_max_cat) || ($col==2 && $i==$col2_max_cat) /* || ($col==3 && $i==$col3_max_cat) */ ) {
                $i = 1;
                $col++;
                echo '</div>';
                if($x < $total_categories) { echo '<div class="col c'.$col.'">'; }
              } else {
                $i++ ;
              }
              $x++ ;
            ?>
          <?php } ?>
        </div> 
      </div> 

    <?php } else { ?>

      <div id="main-new" class="round4">
        <?php
          $total_categories   = osc_count_categories();
          $col1_max_cat       = ceil($total_categories/2);
          $col2_max_cat       = ceil(($total_categories-$col1_max_cat));
        ?>

        <div class="categories <?php echo 'c' . $total_categories; ?>">
          <?php osc_goto_first_category(); ?>
          <?php
            $i      = 1;
            $x      = 1;
            $col    = 1;
            if(osc_count_categories () > 0) { echo '<div class="col c1">'; }
          ?>

          <?php while ( osc_has_categories()) { ?>
            <div class="category-box category">
              <h1><a class="category cat_<?php echo osc_category_id(); ?>" href="<?php echo osc_search_category_url(); ?>"><?php echo osc_category_name(); ?></a><div class="cat-img"><img src='<?php echo osc_current_web_theme_url();?>images/large_cat/<?php echo osc_category_id();?>.png' /></div></h1>

              <div class="cat-bg">
                <?php if ( osc_count_subcategories() > 0 ) { ?>
                  <ul>
                    <?php $citam = 1; while ( osc_has_subcategories()) { ?>
                      <li <?php if($citam>10) {?>style="display:none;"<?php } ?>><a class="category cat_<?php echo osc_category_id(); ?>" href="<?php echo osc_search_category_url(); ?>"><?php echo osc_category_name(); ?></a></li>
                    <?php $citam++;} ?>
                  </ul>
                  <div class="show-all"><a class="category cat_<?php echo osc_category_id(); ?>" href="<?php echo osc_search_category_url(); ?>"><?php echo __('Show more from', 'tatiana') . ' '; ?><?php echo osc_category_name(); ?> &rarr;</a></div>
                <?php } ?>
              </div>
            </div>

            <?php
              if (($col==1 && $i==$col1_max_cat) || ($col==2 && $i==$col2_max_cat)) {
                $i = 1;
                $col++;
                echo '</div>';
                if($x < $total_categories) { echo '<div class="col c'.$col.'">'; }
              } else {
                $i++;
              }
              $x++;
            ?>
          <?php } ?>
        </div>
      </div>

    <?php } ?> 


    <!-- Latest listings -->
    <div class="latest_ads round4">
      <h1><div class="icon-latest-header"></div><span><?php echo __('Latest offer on', 'tatiana') . ' ' . osc_page_title(); ?></span></h1>
      <?php if( osc_count_latest_items() == 0) { ?>
        <p class="empty"><?php _e('No Latest Listings', 'tatiana') ; ?></p>
      <?php } else { ?>

        <table border="0" cellspacing="0">
        <tbody>
          <?php $class = "odd" ; $second = true;?>
          <?php while(osc_has_latest_items())  { if (1==1 /* !osc_item_is_premium() */) {  ?>
            <tr class="<?php echo $class; ?>" onclick="location.href='<?php echo osc_item_url();?>';">
              <?php if( osc_images_enabled_at_items() ) { ?>
                <td class="photo">
                  <?php if(osc_count_item_resources()) { ?>
                    <a href="<?php echo osc_item_url() ; ?>"><img class="round2" src="<?php echo osc_resource_thumbnail_url() ; ?>" width="150" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>" /></a>
                  <?php } else { ?>
                    <a href="<?php echo osc_item_url() ; ?>"><img class="round2" width="150" src="<?php echo osc_current_web_theme_url('images/no-image.png') ; ?>" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>" /></a>
                  <?php } ?>
                </td>
              <?php } ?>

              <td class="text <?php if(!osc_images_enabled_at_items()) {?>no-pic<?php } ?>">                      
                <h3><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title(); ?>"><?php echo ucfirst( osc_highlight( strip_tags( osc_item_title() ), 80 ) ); ?></a></h3>
                <?php if( osc_price_enabled_at_items() ) { echo '<div class="zoznam_cena round2">' . osc_item_formated_price() . '</div>'; } ?>
                <div class="zoznam_views"><div class="icon-latest-views"></div></span><?php echo osc_item_views();?>x</span></div>
                <div class="zoznam_desc"><?php echo osc_highlight(strip_tags( osc_item_description() ), 120 ); ?></div>
                <div class="zoznam_dole">
                  <span class="zoznam_country"><?php if(osc_item_country() <> '') { echo osc_item_country() . ' &middot; '; } ?></span>
                  <span class="zoznam_region"><?php if(osc_item_region() <> '') { echo osc_item_region() . ' &middot; '; } ?></span>
                  <span class="zoznam_city"><?php if(osc_item_city() <> '') { echo osc_item_city() . ' &middot; '; } ?></span>
                  <span class="zoznam_datum"><?php echo osc_format_date(osc_item_pub_date()); ?></span>
                </div>
              </td>
            </tr>
            <?php if($second) { $class = ($class == 'even') ? 'odd' : 'even' ; $second = false; } else {$second = true; } ?>
          <?php } ?>
        <?php } ?>
        </tbody>
        </table>

        <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>
          <p class='pagination'><?php echo osc_search_pagination(); ?></p>
          <div class="see_more_link">
            <a href="<?php echo osc_search_url(array('page' => 'search'));?>"><?php _e("See all offers", 'tatiana'); ?></a>
            <div class="icon-show-all"></div>
            <div class="icon-show-all"></div>
          </div>
        <?php } ?>
        <?php View::newInstance()->_erase('items') ; ?>
      <?php } ?>
    </div>
  </div> 

  <script>
  $('.country').click(function(){
    if(!$(this).hasClass('noclick')) {
      if($(this).find('#plus-minus').attr('class') == 'icon-country-minus') {
        $(this).siblings('.region-block').slideUp('fast');
        $(this).find('#plus-minus').addClass('icon-country-plus').removeClass('icon-country-minus');
      } else {
        $(this).siblings('.region-block').slideDown('fast');
        $(this).find('#plus-minus').addClass('icon-country-minus').removeClass('icon-country-plus');
      }
    }
  }); 
  </script>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>