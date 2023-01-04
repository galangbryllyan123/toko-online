<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
  <head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
  </head>
  
  <body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="content user_account">
      <h1>
        <strong><?php _e('User account manager', 'sofia'); ?></strong>
      </h1>
      <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
      </div>
      <div id="main">
        <h2 class="round2">
          <i class="fa fa-list"></i>&nbsp;<?php _e('Your listings', 'sofia'); ?>
          <a href="<?php echo osc_item_post_url(); ?>"><i class="fa fa-plus-circle"></i>&nbsp;<?php _e('Post a new listing', 'sofia'); ?></a>
        </h2>
        <?php if(osc_count_items() == 0) { ?>
          <div class="empty"><?php _e("You don't have any listings yet", 'sofia'); ?></div>
        <?php } else { ?>
          <div class="ad_list">
            <table border="0" cellspacing="0">
              <tbody>
                <?php $class = "even"; ?>

                <?php while(osc_has_items()) { ?>
                  <tr class="<?php echo $class; ?>">
                    <?php if( osc_images_enabled_at_items() ) { ?>
                     <td class="photo">
                       <?php if(osc_count_item_resources()) { ?>
                        <a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" width="150" height="125" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" /></a>
                      <?php } else { ?>
                        <a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" width="150" height="125"/></a>
                      <?php } ?>
                     </td>
                     <?php } ?>
                     <td class="text">
                       <div id="search-list">
                        <?php if( osc_price_enabled_at_items() ) { ?>
                        <div class="price"><?php echo osc_item_formated_price(); } ?></div>
                        <div class="cat"><?php  echo osc_item_category(); ?></div>
                        <div class="date"><?php echo date("d-m-Y", strtotime(osc_item_pub_date())); ?></div>
                        <?php if(osc_item_city() <> '') { ?><div class="other"><?php  echo osc_item_city(); ?></div><?php } ?>
                        <?php if(osc_item_region() <> '') { ?><div class="other"><?php echo osc_item_region(); ?></div><?php } ?>
                       </div>
                       <h3>
                        <a class="item-name" href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight( strip_tags( osc_item_title() ) ); ?></a>
                        <a class="edit-links" href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><i class="fa fa-wrench"></i>&nbsp;<?php _e('Edit', 'sofia'); ?></a>
                        <a class="edit-links" onclick="return confirm('<?php _e('Are you sure you want to delete this listing? This action cannot be undone.', 'sofia'); ?>')" href="<?php echo osc_item_delete_url(); ?>" rel="nofollow"><i class="fa fa-trash-o"></i>&nbsp;<?php _e('Delete', 'sofia'); ?></a>
                       </h3>           
                       <p class="desc"><?php echo osc_highlight( strip_tags( osc_item_description() ), 130); ?></p>
                       <p class="go-more">
                         <a id="more-link" href="<?php echo osc_item_url(); ?>">
                          <?php _e('see more details', 'sofia'); ?>
                          <?php if (osc_count_premium_resources()>0) { 
                            echo ' ' . __('and', 'sofia') . ' '; 
                            echo osc_count_premium_resources();
                            if(osc_count_premium_resources()>1) { echo ' ' . __('photos', 'sofia'); } else { echo ' ' . __('photo', 'sofia'); } } 
                          ?>      
                        </a>
                      </p>
                    </td>
                  </tr>
                  <?php $class = ($class == 'even') ? 'odd' : 'even'; ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <br />
          
          <div class="paginate" >
          <?php for($i = 0; $i < osc_list_total_pages(); $i++) {
            if($i == osc_list_page()) {
              printf('<a class="searchPaginationSelected" href="%s">%d</a>', osc_user_list_items_url($i + 1), ($i + 1));
            } else {
              printf('<a class="searchPaginationNonSelected" href="%s">%d</a>', osc_user_list_items_url($i + 1), ($i + 1));
            }
          } ?>
          </div>
        <?php } ?>
      </div>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?>
  </body>
</html>	