<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <?php if( osc_count_items() == 0 || Params::getParam('iPage') > 0 || stripos($_SERVER['REQUEST_URI'], 'search') )  { ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
  <?php } else { ?>
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow" />
  <?php } ?>
</head>

<body>
<?php osc_current_web_theme_path('header.php') ; ?>

<div class="content list">
  <div id="main">
    <div class="ad_list">                    
      <?php if(osc_count_items() == 0) { ?>
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
        </div>

        <div class="empty" ><?php printf(__('There are no results matching "%s"', 'tatiana'), osc_search_pattern()) ; ?></div>
      <?php } else { ?>
        <?php require(Params::getParam('sShowAs') == 'gallery' ? 'search_gallery.php' : 'search_list.php') ; ?>
      <?php } ?>
      <div class="paginate"><?php echo osc_search_pagination(); ?></div>
      <div class="clear"></div>
    </div>
  </div>

  <div id="sidebar">
    <?php osc_alert_form(); ?>

    <div id="sidebar-between"></div>

    <div id="sidebar-search">
      <form action="<?php echo osc_base_url(true); ?>" method="get" onsubmit="return doSearch()" class="nocsrf">
      <input type="hidden" name="page" value="search" />
      <input type="hidden" name="sCategory" value="<?php echo Params::getParam('sCategory'); ?>" />
      <input type="hidden" name="page" value="search" />
      <input type="hidden" name="sOrder" value="<?php echo osc_search_order(); ?>" />
      <input type="hidden" name="iOrderType" value="<?php $allowedTypesForSorting = Search::getAllowedTypesForSorting() ; echo $allowedTypesForSorting[osc_search_order_type()]; ?>" />
      <?php foreach(osc_search_user() as $userId) { ?>
        <input type="hidden" name="sUser[]" value="<?php echo $userId; ?>" />
      <?php } ?>
      <input type="hidden" name="sCompany" class="sCompany" id="sCompany" value="<?php echo Params::getParam('sCompany');?>" />

      <h3><div class="icon-s-search"></div><span><?php _e('Advanced search', 'tatiana'); ?></span></h3>
      <div class="del"></div>
      <fieldset class="box location">
        <div class="icon-s-text"></div><h6><?php _e('Search', 'tatiana') ; ?></h6>                            
        <div class="row one_input">
          <input type="text" name="sPattern" id="query" value="<?php echo osc_esc_html(osc_search_pattern()); ?>" />
          <div id="search-example"></div>
        </div>

        <div class="icon-s-region"></div><h6><?php _e('Region', 'tatiana') ; ?></h6>
        <div class="row one_input">
          <input type="text" id="sRegion" name="sRegion" value="<?php echo (osc_search_region() <> '' ? osc_esc_html(osc_search_region()) : Params::getParam('sRegion')); ?>" />
        </div>

        <div class="icon-s-city"></div><h6><?php _e('City', 'tatiana') ; ?></h6>
        <div class="row one_input">
          <input type="text" id="sCity" name="sCity" value="<?php echo (osc_search_city() <> '' ? osc_esc_html(osc_search_city()) : Params::getParam('sCity')); ?>" />
        </div>

      </fieldset>

      <div class="od"></div>
      <div class="icon-s-more"></div><h6><?php _e('More options', 'tatiana') ; ?></h6>
      <div class="del2"></div>
      <fieldset class="box show_only">
        <?php if( osc_images_enabled_at_items() ) { ?>
          <div class="row checkboxes">
            <input type="checkbox" name="bPic" id="withPicture" value="1" <?php echo (osc_search_has_pic() ? 'checked="checked"' : ''); ?> />
            <label for="withPicture" class="with-pic-label"><?php _e('Show only listings with photo', 'tatiana') ; ?></label>
          </div>
        <?php } ?>
        <div class="row checkboxes">
          <input type="checkbox" name="new_window" id="new_window" value="1" <?php echo (Params::getParam('new_window') ? 'checked="checked"' : ''); ?> />
          <label for="new_window" class="with-pic-label"><?php _e('Open listings in new tab', 'tatiana') ; ?></label>
        </div>

        <?php if( osc_price_enabled_at_items() ) { ?>
          <div class="clear"></div>
          <div class="od"></div>
          <div class="icon-s-price"></div><h6><?php _e('Price', 'tatiana') ; ?></h6>
          <div class="del2"></div>
          <div class="row two_input">
            <div class="clear"></div>
            <div id="hladat_cena_left">
              <input type="text" id="priceMin" name="sPriceMin" value="<?php echo osc_search_price_min() ; ?>" placeholder="<?php if( osc_search_price_min() == '') { _e('Price min.', 'tatiana');} else { osc_search_price_min();} ?>" size="6" maxlength="6" />
            </div>
            <div class="icon-s-price-range"></div>
            <div id="hladat_cena_right">
              <input type="text" id="priceMax" name="sPriceMax" value="<?php echo osc_search_price_max() ; ?>" placeholder="<?php if( osc_search_price_max() == '') { _e('Price max.', 'tatiana');} else { osc_search_price_max();} ?>" size="6" maxlength="6" />
            </div>
          </div>
        <?php } ?>
 
        <div id="search-hooks">
          <?php if(osc_search_category_id()) { osc_run_hook('search_form', osc_search_category_id());} else { osc_run_hook('search_form');} ?>
        </div>
      </fieldset>

      <button type="submit" id="blue"><?php _e('Search', 'tatiana') ; ?></button>
      <div class="clear"></div>
      </form>
    </div>

    <?php if(osc_get_preference('theme_adsense', 'tatiana_theme') == 1) { ?>
      <div class="adsense-search">
        <?php echo osc_get_preference('banner_search', 'tatiana_theme'); ?>        
      </div>
    <?php } ?>

    <div id="sidebar-between"></div>
    <div id="sidebar-cat-header"><h3><div class="icon-category"></div><span><?php _e('Categories', 'tatiana'); ?></span></h3></div>

    <!-- Show all categories -->
    <?php if(osc_get_preference('refine_cat', 'tatiana_theme') == 0) { ?>
      <?php $cat_id = ''; ?>
      <?php $curr_cat = ''; ?>
      <?php $max_sub = 3;?>
      <div id="menu">
        <?php $search_params = tatiana_search_params(); ?>
        <div class="menu-wrap">
        <?php $current_cat = osc_search_category_id(); $current_cat = $current_cat['0'];?>

        <?php osc_goto_first_category() ; ?>                            
        <?php while ( osc_has_categories() ) { ?>
          <?php $search_params['sCategory'] = osc_category_id(); ?>
          <?php $parent_id = osc_category_id($locale = ""); ?>

          <div class="category">
            <img class="small_img" src='<?php echo osc_current_web_theme_url();?>images/small_cat/<?php echo osc_category_id();?>.png' /><h2 <?php if ($parent_id == $current_cat) { echo ' class="is_parent" '; }  ?>><a href="<?php echo osc_search_url($search_params); ?>"><?php echo osc_category_name() ; ?> </a> <span>(<?php echo osc_category_total_items() ; ?>)</span></h2>
            <?php if ( osc_count_subcategories() > 0 ) { ?>
              <ul class="subcategory" id="showSubcat<?php echo $cat_id; ?>" >
                <?php $pocitaj_subcat = 1; ?>
                <?php while ( osc_has_subcategories() ) {  $subcat_id = osc_category_id($locale = ""); if ($subcat_id == $curr_cat) {?><!-- Code for selected subcategory --><?php }  ?>
                  <?php $child_id = osc_category_id($locale = "");?>
                  <?php $search_params['sCategory'] = osc_category_id(); ?>

                  <li id="topbar_element" <?php if ($child_id == $current_cat) { echo ' class="is_child" '; }  ?>><a class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_url($search_params); ?>"><?php echo osc_category_name() ; ?></a></li>
                  <?php if ($pocitaj_subcat == $max_sub) { ?><li onclick="hide_viac('viac<?php echo $parent_id;?>')" class="viac_main" id="viac<?php echo $parent_id;?>"><?php _e('Show more', 'tatiana'); ?></li><div class="ukaz" id="viac<?php echo $parent_id;?>block"><?php } ?>
                  <?php $pocitaj_subcat++; ?>
                <?php } ?>
                <?php if ($pocitaj_subcat > $max_sub) { ?></div><?php } // ending of div that can be hidden and then expanded?>
              </ul>
            <?php } ?>
          </div>                                
        <?php } ?>
        </div>
      </div>

    <!-- Regine categories -->
    <?php } else { ?>
      <div id="menu">
        <div class="menu-wrap">
        <?php 
          $current_cat = osc_search_category_id(); 
          $current_cat = $current_cat['0'];
          $aCategory = osc_get_category('id', $current_cat);
          $parentCategory = osc_get_category('id', $aCategory['fk_i_parent_id']);
          $search_params = tatiana_search_params();
        ?>
        <?php osc_goto_first_category() ; ?>                            
        <?php while ( osc_has_categories() ) { ?>
          <?php $parent_id = osc_category_id($locale = ""); ?>
          <?php if ($parent_id == $current_cat or $current_cat == 0 or $parentCategory['pk_i_id'] == $parent_id) {  ?>
            <div class="category">
              <?php $search_params['sCategory'] = osc_category_id(); ?>
              <img class="small_img" src='<?php echo osc_current_web_theme_url();?>images/small_cat/<?php echo osc_category_id();?>.png' <?php if ($current_cat == 0) {?>style="margin-top:12px;"<?php } ?>/>
              <h2 <?php if ($current_cat == 0) {?>style="margin-bottom:0;padding-top:15px;"<?php } ?>><a href="<?php echo osc_search_url($search_params); ?>"><?php echo osc_category_name() ; ?> </a> <span>(<?php echo osc_category_total_items() ; ?>)</span></h2>
              <?php if ( osc_count_subcategories() > 0 ) { ?>
                <ul class="subcategory" id="showSubcat<?php echo $cat_id; ?>" <?php if ($current_cat == 0) {?>style="display:none;"<?php } ?>>
                  <?php while ( osc_has_subcategories() ) {  $subcat_id = osc_category_id($locale = ""); ?> 
                    <?php $child_id = osc_category_id($locale = "");?>
                    <?php $search_params['sCategory'] = osc_category_id(); ?>
                    <li id="topbar_element" <?php if ($child_id == $current_cat) { echo ' class="is_child" '; }  ?>><a class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_url($search_params); ?>"><?php echo osc_category_name() ; ?></a></li>
                  <?php } ?>
                </ul>
              <?php } ?>
            </div> 
          <?php } ?>
        <?php } ?>
        </div>
      </div>
    <?php } ?>
    <div id="bottom-grad"></div>
  </div>
</div>

<script type="text/javascript">
$(function() {
  function log( message ) {
    $( "<div/>" ).text( message ).prependTo( "#log" );
    $( "#log" ).attr( "scrollTop", 0 );
  }

  $( "#sCity" ).autocomplete({
    source: "<?php echo osc_base_url(true); ?>?page=ajax&action=location",
    minLength: 2,
    select: function( event, ui ) {
    log( ui.item ?
      "<?php _e('Selected', 'tatiana'); ?>: " + ui.item.value + " aka " + ui.item.id :
      "<?php _e('Nothing selected, input was', 'tatiana'); ?> " + this.value );
    }
  });
});
</script>

<?php if(osc_get_preference('refine_cat', 'tatiana_theme') == 0) { ?>
  <script>
    function hide_viac(id) {
      $("#" + id).slideUp("slow");
      $("#" + id + "block").show("slow", "swing");
    }

    $('.is_child').closest('#showSubcat').siblings('h2').addClass('is_parent');
    $('.is_child').closest('.ukaz').show();
    $('.is_child').closest('.ukaz').siblings('.viac_main').hide();
    $('.is_child').siblings('.ukaz').show();
    $('.is_child').siblings('.viac_main').hide();
  </script>
<?php } ?>

<?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>