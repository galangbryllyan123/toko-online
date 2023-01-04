<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
</head>
<body>
  <?php osc_current_web_theme_path('header.php') ; ?>
  <div class="content user_account">
  <h1>
    <?php if(function_exists('profile_picture_show')) { profile_picture_show(null, null, 39); } ?>
    <span><?php _e('Latest listings published by you', 'tatiana') ; ?></span>
  </h1>
  <div id="sidebar">
    <?php echo osc_private_user_menu() ; ?>
  </div>

  <div id="main" class="ad_list">
    <h2>
      <div class="icon-dash"></div>
      <span>
        <?php _e('User dashboard', 'tatiana'); ?>
        <span class="normal"><?php echo 20*(osc_search_page())+1;?> - <?php echo 20*(osc_search_page()+1)+osc_count_items()-20;?> <?php echo ' ' . __('from', 'tatiana') . ' '; ?> <?php echo osc_search_total_items(); ?></span>
      </span>
    </h2>
    <div class="clear"></div>

    <?php if(osc_count_items() == 0) { ?>
      <div class="empty"><?php _e("You did not publish any listings yet", 'tatiana'); ?></div>
    <?php } else { ?>
      <table border="0" cellspacing="0">
        <tbody>
          <?php $class = "odd" ; $second = true;?>
          <?php while(osc_has_items())  { ?>
            <tr class="<?php echo $class; ?>" <?php if(Params::getParam('new_window')) { ?>onclick="window.open('<?php echo osc_item_url();?>', '_blank');window.open('#', '_self');"<?php } else { ?>onclick="location.href='<?php echo osc_item_url();?>';"<?php } ?>>
              <?php if( osc_images_enabled_at_items() ) { ?>
                <td class="photo">
                  <?php if(osc_count_item_resources()) { ?>
                    <a href="<?php echo osc_item_url() ; ?>"><img class="round2" src="<?php echo osc_resource_thumbnail_url() ; ?>" width="150" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>"/></a>
                  <?php } else { ?>
                    <a href="<?php echo osc_item_url() ; ?>"><img class="round2" src="<?php echo osc_current_web_theme_url('images/no-image.png') ; ?>" width="150" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>" /></a>
                  <?php } ?>
                </td>
              <?php } ?>

              <td class="text <?php if(!osc_images_enabled_at_items()) {?>no-pic<?php } ?>">      
                <h3><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title(); ?>"><?php echo ucfirst( osc_highlight( strip_tags( osc_item_title() ), 120 ) ); ?></a></h3>
                <?php if( osc_price_enabled_at_items() ) { echo '<div class="zoznam_cena round2">' . osc_item_formated_price() . '</div>'; } ?>
                <div class="zoznam_views"><div class="icon-latest-views"></div></span><?php echo osc_item_views();?>x</span></div>
                <div class="zoznam_views"><div class="icon-count-photos"></div></span><?php echo osc_count_item_resources();?>x</span></div>
                <div class="zoznam_desc"><?php echo osc_highlight(strip_tags( osc_item_description() ), 350 ); ?></div>
                <div class="zoznam_dole">
                  <span class="zoznam_country"><?php if(osc_item_country() <> '') { echo osc_item_country() . ' &middot; '; } ?></span>
                  <span class="zoznam_region"><?php if(osc_item_region() <> '') { echo osc_item_region() . ' &middot; '; } ?></span>
                  <span class="zoznam_city"><?php if(osc_item_city() <> '') { echo osc_item_city() . ' &middot; '; } ?></span>
                  <span class="zoznam_datum"><?php echo osc_format_date(osc_item_pub_date()); ?></span>
                </div>
              </td>
            </tr>
            <?php $class = ($class == 'even') ? 'odd' : 'even' ; $second = false; ?>
          <?php } ?>
        </tbody>
      </table>

      <div class="clear"></div>

      <div class="paginate">
        <?php for($i = 0 ; $i < osc_list_total_pages() ; $i++) {
          if($i == osc_list_page()) {
            printf('<a class="searchPaginationSelected" href="%s">%d</a>', osc_user_list_items_url($i), ($i + 1));
          } else { 
            printf('<a class="searchPaginationNonSelected" href="%s">%d</a>', osc_user_list_items_url($i), ($i + 1));
          }
        } ?>
      </div>
    <?php } ?>
  </div>
  </div>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>