<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
  <head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow" />
  </head>
  <body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="form_inc">
      <?php osc_current_web_theme_path('inc.search.php'); ?>
    </div>
    
    <div class="content home">
      <div id="main">
        <div id="home-title">
          <span class="left">
            <?php _e('Search in ', 'sofia')?>
            <?php echo osc_total_items();?>
            <?php echo ' ' . __('listings', 'sofia'); ?>
          </span>
          <span class="right">
            <?php _e('Promote your listing', 'sofia'); ?>
          </span>
        </div>
        
        <div id="home-search">
          <div class="text"><i class="fa fa-hand-o-right"></i>&nbsp;<?php _e('Start your search there', 'sofia'); ?></div>
          <div class="search-input">
            <form action="<?php echo osc_base_url(true); ?>" method="get" class="search nocsrf" onsubmit="doSearch();">
              <input type="hidden" name="page" value="search" />
              <input type="hidden" name="sCountry<?php echo radius_installed(); ?>" id="sCountry" value="<?php echo Params::getParam('sCountry' . radius_installed());?>" />
              <input type="hidden" name="sCity<?php echo radius_installed(); ?>" id="sCity" value="<?php echo Params::getParam('sCity' . radius_installed());?>" />
              <input type="hidden" name="cookie-action" id="cookie-action" value="" />
              <input type="hidden" name="sCompany" class="sCompany" id="sCompany" value="<?php echo Params::getParam('sCompany');?>" />
              <input type="hidden" name="sShowAs" class="sShowAs" id="sShowAs" value="<?php echo Params::getParam('sShowAs');?>" />
              <input type="hidden" name="sPriceMin" class="sPriceMin" id="sPriceMin" value="<?php echo Params::getParam('sPriceMin');?>" />
              <input type="hidden" name="sPriceMax" class="sPriceMax" id="sPriceMax" value="<?php echo Params::getParam('sPriceMax');?>" />

              <fieldset class="main">
                <input type="text" name="sPattern"  id="query" value="<?php echo osc_esc_html( ( osc_search_pattern() != '' ) ? osc_search_pattern() : '' ); ?>" />
                <?php if (osc_count_categories()) { ?>
                  <?php $def_cat['pk_i_id'] = Params::getParam('sCategory'); ?>
                  <?php osc_categories_select('sCategory', $def_cat, __('Select a category', 'sofia')); ?>
                <?php } ?>
                <?php chosen_region_select(Params::getParam('sRegion' . radius_installed()));?>
                <button type="submit" id="home-search"><?php _e('Search', 'sofia'); ?></button>
              </fieldset>
              <div id="search-example"></div>
            </form>
          </div>
        </div>
       
        <?php if (function_exists('carousel')) { carousel(); } ?>
        
        <div id="alert-info">
          <div class="title"><i class="fa fa-gavel"></i>&nbsp;<?php _e('Sell your used items', 'sofia'); ?></div>
          <div class="text"><?php _e('You can advertise all types of industrial vehicles, trucks, machinery or vans. Used clothes as well as electronics. We offer unlimited advertising for free.', 'sofia'); ?></div>
          <div class="list"><?php _e('Free and unlimited Ads', 'sofia'); ?></div>
          <a class="link" href="<?php echo osc_item_post_url_in_category(); ?>"><i class="fa fa-plus-circle"></i><?php _e('Publish your ad for free', 'sofia'); ?></a>
        </div>

        <div id="latest-home">
          <?php $thumb_size = explode("x", osc_thumbnail_dimensions()); ?>
          <div id="latest-header">
            <div id="latest-span">
              <?php _e('Latest Listings', 'sofia'); ?>
            </div>
          </div>
          
          <?php if( osc_count_latest_items() == 0) { ?>
            <p class="empty"><?php _e('No Latest Listings', 'sofia'); ?></p>
          <?php } else { ?>
            <?php while ( osc_has_latest_items() ) { ?>
              <div class="box round2">
                <?php if( osc_images_enabled_at_items() ) { ?>
                  <div class="photo">
                    <?php if( osc_count_item_resources() ) { ?>
                      <a href="<?php echo osc_item_url(); ?>">
                        <img class="round2" src="<?php echo osc_resource_thumbnail_url(); ?>" width="140" height="115" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" />
                      </a>
                    <?php } else { ?>
                      <a href="<?php echo osc_item_url(); ?>">
                        <img class="round2" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" width="140" height="115" />
                      </a>
                    <?php } ?>
                  </div>
                <?php } ?>
                
                <div class="price"><?php if( osc_price_enabled_at_items() ) { echo osc_item_formated_price(); ?><?php } ?></div>
                <h3><a href="<?php echo osc_item_url(); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>"><?php echo osc_highlight(osc_item_title(), 45); ?></a></h3>
              </div>
            <?php } ?>

            <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>
              <p class='pagination'><?php echo osc_search_pagination(); ?></p>
              <p class="see_more_link">
                <a href="<?php echo osc_search_url(array('page' => 'search'));?>">
                  <?php _e("See all offers", 'sofia'); ?>&nbsp;<i class="fa fa-sign-in"></i>
                </a>
              </p>
            <?php } ?>
            
            <?php View::newInstance()->_erase('items'); ?>
          <?php } ?>
        </div>
      </div>
      
      <div id="sidebar">
        <div id="ad-title"><i class="fa fa-line-chart"></i><?php _e('Advertising', 'sofia'); ?></div>

        <?php if(osc_get_preference('theme_adsense', 'sofia_theme')) { ?>
          <div id="home-ad-google">
            <?php echo osc_get_preference('banner_home', 'sofia_theme'); ?>
          </div>
        <?php } ?>

        <?php if(osc_get_preference('banner_home', 'sofia_theme') == '') { ?>
          <a href="<?php echo osc_contact_url();?>"><div id="home-ad">Your Ad Here</div></a>
          <a href="<?php echo osc_contact_url();?>"><div id="home-ad">Your Ad Here</div></a>
          <a href="<?php echo osc_contact_url();?>"><div id="home-ad">Your Ad Here</div></a>
        <?php } ?>

      </div>
    </div>
    
    <?php osc_current_web_theme_path('footer.php'); ?>
  </body>
</html>