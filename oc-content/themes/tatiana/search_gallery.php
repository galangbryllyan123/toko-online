<?php
  osc_get_premiums(); 
?>

<div class="gallery-list">
<?php if(osc_count_premiums() > 0) { ?>

<div class="premium-offer round2">
  <div class="top"></div>
  <div class="text"><?php echo __('Premium offer on', 'tatiana') . ' ' . osc_page_title(); ?></div>
</div>

<table border="0" cellspacing="0" class="premium-table">
<tbody>
  <?php $class = "odd" ; $second = true;?>
  <?php while(osc_has_premiums())  { ?>
    <tr class="<?php echo $class; ?> premium" <?php if(Params::getParam('new_window')) { ?>onclick="window.open('<?php echo osc_premium_url();?>', '_blank');"<?php } else { ?>onclick="location.href='<?php echo osc_premium_url();?>';"<?php } ?>>
      <?php if( osc_images_enabled_at_items() ) { ?>
        <td class="photo">
          <?php if(osc_count_premium_resources()) { ?>
            <a href="<?php if(Params::getParam('new_window')) { echo 'javascript:void(0)'; } else { echo osc_premium_url();} ?>"><img class="round2" src="<?php echo osc_resource_thumbnail_url() ; ?>" width="150" title="<?php echo osc_premium_title(); ?>" alt="<?php echo osc_premium_title(); ?>" /></a>
          <?php } else { ?>
            <a href="<?php if(Params::getParam('new_window')) { echo 'javascript:void(0)'; } else { echo osc_premium_url();} ?>"><img class="round2" src="<?php echo osc_current_web_theme_url('images/no-image.png'); ?>" width="150" title="<?php echo osc_premium_title(); ?>" alt="<?php echo osc_premium_title(); ?>" /></a>
          <?php } ?>
        </td>
      <?php } ?>

      <td class="text">      
        <h3><a href="<?php if(Params::getParam('new_window')) { echo 'javascript:void(0)'; } else { echo osc_premium_url();} ?>" title="<?php echo osc_premium_title(); ?>"><?php echo ucfirst( osc_highlight( strip_tags( osc_premium_title() ), 25 ) ); ?></a></h3>
        <?php if( osc_price_enabled_at_items() ) { echo '<div class="zoznam_cena round2">' . osc_premium_formated_price() . '</div>'; } ?>
        <div class="zoznam_views"><div class="icon-latest-views"></div></span><?php echo osc_premium_views();?>x</span></div>
        <div class="zoznam_views phot"><div class="icon-count-photos"></div></span><?php echo osc_count_premium_resources();?>x</span></div>
        <div class="zoznam_desc"><?php echo osc_highlight(osc_premium_description(), 60); ?></div>
        <div class="zoznam_dole">
          <span class="zoznam_country"><?php if(osc_premium_country() <> '') { echo osc_premium_country() . ' &middot; '; } ?></span>
          <span class="zoznam_region"><?php if(osc_premium_region() <> '') { echo osc_premium_region() . ' &middot; '; } ?></span>
          <span class="zoznam_city"><?php if(osc_premium_city() <> '') { echo osc_premium_city() . ' &middot; '; } ?></span>
          <span class="zoznam_datum"><?php echo osc_format_date(osc_premium_pub_date()); ?></span>
        </div>
      </td>
    </tr>
    <?php if($second) { $class = ($class == 'even') ? 'odd' : 'even' ; $second = false; } else {$second = true; } ?>
  <?php } ?>
</tbody>
</table>
<?php } ?>

<div class="regular-offer round2">
  <div class="top"></div>
  <div class="text"><?php echo search_title(); ?></div>

  <div class="user_type_buttons">
    <div class="round3 all <?php if(Params::getParam('sCompany') == '' or Params::getParam('sCompany') == null) { ?>active<?php } ?>"><span><?php _e('All results', 'tatiana'); ?></span></div>
    <div class="round3 individual <?php if(Params::getParam('sCompany') == '0') { ?>active<?php } ?>"><span><?php _e('Personal', 'tatiana'); ?></span></div>
    <div class="round3 company <?php if(Params::getParam('sCompany') == '1') { ?>active<?php } ?>"><span><?php _e('Company', 'tatiana'); ?></span></div>
  </div>

  <div class="wrap round3">
    <?php $params['sShowAs'] = 'gallery'; ?>
    <a href="<?php echo osc_update_search_url($params) ; ?>" title="<?php _e('Switch to grid view', 'tatiana'); ?>"><div class="search-grid-ico"></div></a>
    <?php $params['sShowAs'] = 'list'; ?>
    <a href="<?php echo osc_update_search_url($params) ; ?>" title="<?php _e('Switch to list view', 'tatiana'); ?>"><div class="search-list-ico"></div></a>
  </div>
  <div class="sort-it">
    <div class="sort-title round3"><div class="icon-sort-list-up"></div><div class="icon-sort-list-bottom"></div></div>
    <div id="sort-wrap">
      <div class="sort-arrow-top"></div>
      <div class="sort-content round4">
        <?php $orders = osc_list_orders(); $i = 0;
        foreach($orders as $label => $params) {
          $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1'; 
          if(osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) { ?>
            <a class="current" href="<?php echo osc_update_search_url($params) ; ?>"><?php echo $label; ?></a>
          <?php } else { ?>
            <a href="<?php echo osc_update_search_url($params) ; ?>"><?php echo $label; ?></a>
          <?php } $i++ ; 
        } ?>
      </div>
    </div>
  </div>
  <div class="results"><?php echo 20*(osc_search_page())+1;?> - <?php echo 20*(osc_search_page()+1)+osc_count_items()-20;?> <?php echo ' ' . __('from', 'tatiana') . ' '; ?> <?php echo osc_search_total_items() ?></div>
</div>

<table border="0" cellspacing="0">
<tbody>
  <?php $class = "odd" ; $second = true;?>
  <?php while(osc_has_items())  { if (1==1 /* !osc_item_is_premium() */) {  ?>
    <tr class="<?php echo $class; ?>" <?php if(Params::getParam('new_window')) { ?>onclick="window.open('<?php echo osc_item_url();?>', '_blank');"<?php } else { ?>onclick="location.href='<?php echo osc_item_url();?>';"<?php } ?>>
      <?php if( osc_images_enabled_at_items() ) { ?>
        <td class="photo">
          <?php if(osc_count_item_resources()) { ?>
            <a href="<?php if(Params::getParam('new_window')) { echo 'javascript:void(0)'; } else { echo osc_item_url();} ?>"><img class="round2" src="<?php echo osc_resource_thumbnail_url() ; ?>" width="150" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>"/></a>
          <?php } else { ?>
            <a href="<?php if(Params::getParam('new_window')) { echo 'javascript:void(0)'; } else { echo osc_item_url();} ?>"><img class="round2" src="<?php echo osc_current_web_theme_url('images/no-image.png') ; ?>" width="150" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>" /></a>
          <?php } ?>
        </td>
      <?php } ?>

      <td class="text">      
        <h3><a href="<?php if(Params::getParam('new_window')) { echo 'javascript:void(0)'; } else { echo osc_item_url();} ?>" title="<?php echo osc_item_title(); ?>"><?php echo ucfirst( osc_highlight( strip_tags( osc_item_title() ), 25 ) ); ?></a></h3>
        <?php if( osc_price_enabled_at_items() ) { echo '<div class="zoznam_cena round2">' . osc_item_formated_price() . '</div>'; } ?>
        <div class="zoznam_views"><div class="icon-latest-views"></div></span><?php echo osc_item_views();?>x</span></div>
        <div class="zoznam_views phot"><div class="icon-count-photos"></div></span><?php echo osc_count_item_resources();?>x</span></div>
        <div class="zoznam_desc"><?php echo osc_highlight(osc_item_description(), 60); ?></div>
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
</div>