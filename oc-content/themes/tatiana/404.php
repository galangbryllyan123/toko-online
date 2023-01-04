<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
  <head>
    <?php osc_current_web_theme_path('head.php') ; ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
    <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script>
  </head>
  <body>
    <?php osc_current_web_theme_path('header.php') ; ?>
    <div class="content error err400">
        <h1><?php _e('Whoops, something is wrong', 'tatiana'); ?></h1>
        <div class="reason">
          <?php _e('We are sorry, but the Web address you have entered is no longer available.', 'tatiana'); ?><br />
          <?php _e('To find a correct listing, please use search box above.', 'tatiana'); ?><br /><br /><br />

          <a class="button gray-button round3" href="<?php echo osc_base_url();?>"><?php _e('Go home', 'tatiana'); ?></a>
          <br /><br />

          <!-- Latest listings -->
          <div class="home">
            <div class="latest_ads round4">
              <h1><div class="icon-latest-header"></div><span><?php echo __('Check latest offer on', 'tatiana') . ' ' . osc_page_title(); ?></span></h1>
              <?php if( osc_count_latest_items() > 0) { ?>
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

                      <td class="text">                      
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
                    <a href="<?php echo osc_search_show_all_url();?>"><?php _e("See all offers", 'tatiana'); ?></a>
                    <div class="icon-show-all"></div>
                    <div class="icon-show-all"></div>
                  </div>
                <?php } ?>
                <?php View::newInstance()->_erase('items') ; ?>
              <?php } ?>
            </div>
          </div>
        </div>
    </div>
    <?php osc_current_web_theme_path('footer.php') ; ?>
  </body>
</html>