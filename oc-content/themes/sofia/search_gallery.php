<div class="user_type_buttons">
  <div class="all <?php if(Params::getParam('sCompany') == '' or Params::getParam('sCompany') == null) { ?>active<?php } ?>"><span><?php _e('All', 'sofia'); ?></span></div>
  <div class="individual <?php if(Params::getParam('sCompany') == '0') { ?>active<?php } ?>"><span><?php _e('Personal', 'sofia'); ?></span></div>
  <div class="company <?php if(Params::getParam('sCompany') == '1') { ?>active<?php } ?>"><span><?php _e('Company', 'sofia'); ?></span></div>
</div>

<div id="regular-header"><!--<div id="regular-span"><?php _e('All listings', 'sofia'); ?></div>--></div>

<div id="search-gallery">
  <?php while ( osc_has_items() ) { ?>
    <div class="box round2">
      <?php if( osc_images_enabled_at_items() ) { ?>
        <div class="photo">
          <?php if( osc_count_item_resources() ) { ?>
            <a href="<?php echo osc_item_url(); ?>">
              <img class="round2" src="<?php echo osc_resource_thumbnail_url(); ?>" width="152" height="120" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" />
            </a>
          <?php } else { ?>
            <a href="<?php echo osc_item_url(); ?>">
              <img class="round2" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" width="130" height="95" />
            </a>
          <?php } ?>
        </div>
      <?php } ?>
      <div class="price"><?php if( osc_price_enabled_at_items() ) { echo osc_item_formated_price(); ?><?php } ?></div>
        <h3><a href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight(osc_item_title(), 50); ?></a></h3>
      </div>
  <?php } ?>
</div>
