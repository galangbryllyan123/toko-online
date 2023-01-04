<?php
  osc_show_widgets('footer');
  $sQuery = osc_esc_js(osc_get_preference('keyword_placeholder', 'tatiana_theme'));
?>

<!-- footer -->
<div id="footer">
  <div class="inner">
    <span class="fact"><?php echo osc_total_active_items() . ' ' . __('listings are active', 'tatiana'); ?></span><span class="dott">-</span>
    <span class="fact"><?php echo osc_total_items() . ' ' . __('listings were added', 'tatiana'); ?></span><span class="dott">-</span>
    <span class="fact"><?php echo osc_total_items_today() . ' ' . __('listings added today', 'tatiana'); ?></span><span class="dott">-</span>
    <span class="fact"><?php echo osc_total_active_items_today() . ' ' . __('listings activated today', 'tatiana'); ?></span><span class="dott">-</span>
    <span class="fact"><?php echo osc_total_users() . ' ' . __('users registered', 'tatiana'); ?></span>
  </div>
</div></div>
<!-- /footer -->
<!-- /container -->
<script type="text/javascript">
$("#tip_close2").click(function(){
  $("#flashmessage").slideUp("slow");
});
</script>

<!--[if IE]>
  <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('style-ie.css');?>" type="text/css" />
<![endif]-->

<div class="footer-hook">
  <?php osc_run_hook('footer') ; ?>
<div>

<div id="footer-new">
  <div class="top-white"></div>
  <div class="inside">

    <div class="bottom-place">
      <div class="some-block">
        <h4><div class="icon-hot"></div><span><?php _e('Do not miss hot items', 'tatiana'); ?></span></h4>
        <div class="del"></div>
        <div class="text">
          <?php osc_query_item(); $c = 1; ?>
          <?php while(osc_has_custom_items() and $c <= 3) { ?>
            <span><a href="<?php echo osc_item_url();?>" title="<?php echo strip_tags(osc_item_description());?>"><?php echo ucfirst(osc_item_title());?></a></span>
          <?php $c++; } ?>
        </div>
      </div>

      <div class="some-block">
        <h4><div class="icon-fav"></div><span><?php _e('Favorite categories', 'tatiana'); ?></span></h4>
        <div class="del"></div>
        <div class="text">
          <?php osc_goto_first_category(); $c = 1; ?>
          <?php while(osc_has_categories() and $c <= 3) { ?>
            <span><a href="<?php echo osc_search_category_url() ; ?>" title="<?php echo osc_category_name(); ?>"><?php echo ucfirst(osc_category_name());?></a></span>
          <?php $c++; } ?>
        </div>
      </div>

      <div class="some-block right">
        <h4><div class="icon-inf"></div><span><?php _e('Information', 'tatiana'); ?></span></h4>
        <div class="del"></div>
        <div class="text">
          <?php $c = 1; ?>
          <?php while(osc_has_static_pages() and $c <= 3) { ?>
            <span><a href="<?php echo osc_static_page_url(); ?>" title="<?php echo osc_static_page_title(); ?>"><?php echo ucfirst(osc_static_page_title());?></a></span>
          <?php $c++; } ?>
        </div>
      </div>

    </div>

    <div class="del is_full"></div>

    <div class="top-place">
      <div class="element"><a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'tatiana'); ?></a></div>

      <?php if(osc_get_preference('contact_email', 'tatiana_theme') <> '') { ?>
        <div class="dot">.</div><div class="element"><a href=""><?php echo osc_get_preference('contact_email', 'tatiana_theme'); ?></a></div>
      <?php } ?>

      <?php if(osc_get_preference('footer_link', 'tatiana_theme')) { ?>
        <div class="dot">.</div><div class="element"><a href="https://osclasspoint.com/">Osclass Themes and Plugins</a></div>
        <div class="dot">.</div><div class="element"><a href="https://osclass.osclasspoint.com/">Classifieds Script Osclass</a></div>
      <?php } ?>

      <div class="cop">&copy; <?php echo date("Y"); ?> Tatiana Premium Theme</div>
    </div>
  </div>
</div>