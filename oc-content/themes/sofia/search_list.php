<?php
  osc_get_premiums();
  if(osc_count_premiums() > 0) {
?>

<div id="premium-header"><div id="premium-span"><?php _e('Premium listings', 'sofia'); ?></div></div>
<table border="0" cellspacing="0">
  <tbody>
    <?php $class = "even"; ?>
    <?php while(osc_has_premiums()) { ?>
      <tr class="<?php echo $class; ?>" style="background:rgb(231, 245, 255);">
        <?php if( osc_images_enabled_at_items() ) { ?>
         <td class="photo">
           <?php if(osc_count_premium_resources()) { ?>
            <a href="<?php echo osc_premium_url(); ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" width="150" height="125" title="<?php echo osc_esc_html(osc_premium_title()); ?>" alt="<?php echo osc_esc_html(osc_premium_title()); ?>" /></a>
          <?php } else { ?>
            <a href="<?php echo osc_premium_url(); ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" width="150" height="125"/></a>
          <?php } ?>
         </td>
         <?php } ?>
         <td class="text">
           <div id="search-list">
            <?php if( osc_price_enabled_at_items() ) { ?>
            <div class="price"><?php echo osc_premium_formated_price(); } ?></div>
            <div class="top"><?php _e('TOP', 'sofia'); ?></div>
            <?php if(osc_premium_category() <> '') { ?><div class="cat"><?php echo osc_premium_category(); ?></div><?php } ?>
            <div class="date"><?php echo osc_format_date(osc_premium_pub_date()); ?></div>
            <?php if(osc_premium_city() <> '') { ?><div class="other"><?php  echo osc_premium_city(); ?></div><?php } ?>
            <?php if(osc_premium_region() <> '') { ?><div class="other"><?php echo osc_premium_region(); ?></div><?php } ?>
           </div>
           <h3>
            <a href="<?php echo osc_premium_url(); ?>"><?php echo osc_highlight( strip_tags( osc_premium_title() ) ); ?></a>
            <a class="folder-icon" href="<?php echo osc_premium_url(); ?>"><i class="fa fa-folder"></i><i class="fa fa-folder-open"></i></a>
           </h3>           
           <p class="desc"><?php echo osc_highlight( strip_tags( osc_premium_description() ), 130); ?></p>
           <p class="go-more">
             <a id="more-link" href="<?php echo osc_premium_url(); ?>">
              <?php _e('see more details', 'sofia'); ?><?php if (osc_count_premium_resources()>0) { 
              echo ' ' . __('and', 'sofia') . ' '; 
              echo osc_count_premium_resources();
              if(osc_count_premium_resources()>1) { echo ' ' . __('photos', 'sofia'); } else { echo ' ' . __('photo', 'sofia'); } } ?>            
            </a>
           </p>
         </td>
       </tr>
      <?php $class = ($class == 'even') ? 'odd' : 'even'; ?>
    <?php } ?>
  </tbody>
</table>
<?php } ?>

<div class="user_type_buttons">
  <div class="all <?php if(Params::getParam('sCompany') == '' or Params::getParam('sCompany') == null) { ?>active<?php } ?>"><span><?php _e('All', 'sofia'); ?></span></div>
  <div class="individual <?php if(Params::getParam('sCompany') == '0') { ?>active<?php } ?>"><span><?php _e('Personal', 'sofia'); ?></span></div>
  <div class="company <?php if(Params::getParam('sCompany') == '1') { ?>active<?php } ?>"><span><?php _e('Company', 'sofia'); ?></span></div>
</div>

<div id="regular-header"><!--<div id="regular-span"><?php _e('All listings', 'sofia'); ?></div>--></div>
<table border="0" cellspacing="0">
  <tbody>
    <?php $class = "even"; ?>
    <?php while(osc_has_items()) { ?>
      <tr class="<?php echo $class; ?>">
        <?php if( osc_images_enabled_at_items() ) { ?>
         <td class="photo">
           <?php if(osc_count_item_resources()) { ?>
            <a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" width="150" height="125" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_item_title(); ?>" /></a>
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
            <a href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight( strip_tags( osc_item_title() ) ); ?></a>
            <a href="<?php echo osc_item_url(); ?>"><i class="fa fa-folder"></i><i class="fa fa-folder-open"></i></a>
           </h3>           
           <p class="desc"><?php echo osc_highlight( strip_tags( osc_item_description() ), 130); ?></p>
           <p class="go-more">
             <a id="more-link" href="<?php echo osc_item_url(); ?>">
               <?php _e('see more details', 'sofia'); ?><?php if (osc_count_premium_resources()>0) { 
               echo ' ' . __('and', 'sofia') . ' '; 
               echo osc_count_premium_resources();
               if(osc_count_premium_resources()>1) { echo ' ' . __('photos', 'sofia'); } else { echo ' ' . __('photo', 'sofia'); } } ?>      
             </a>
           </p>
         </td>
       </tr>
      <?php $class = ($class == 'even') ? 'odd' : 'even'; ?>
    <?php } ?>
  </tbody>
</table>