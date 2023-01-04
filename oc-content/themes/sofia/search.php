<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
  <head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <?php if( osc_count_items() == 0 || Params::getParam('iPage') > 0 || stripos($_SERVER['REQUEST_URI'], 'search') )  { ?>
      <meta name="robots" content="noindex, nofollow" />
      <meta name="googlebot" content="noindex, nofollow" />
    <?php } else { ?>
      <meta name="robots" content="index, follow" />
      <meta name="googlebot" content="index, follow" />
    <?php } ?>
  </head>

  <body>
    <?php osc_current_web_theme_path('header.php'); ?>    
    <div class="content list">
      <div id="main">
        <div class="ad_list">
          <div id="list_head">
            <div class="inner">
              <h1>
                <strong><?php echo osc_search_total_items().' '.__('results', 'sofia'); ?>
                  <?php if (search_title() != __('Search results', 'sofia')) { ?>
                <span style="color:#999"> &raquo <?php echo osc_category_name();?></span><?php } ?></strong>
              </h1>
              
              <div class="wrap">
                <?php $params['sShowAs'] = 'gallery'; ?>
                <a href="<?php echo osc_update_search_url($params) ; ?>" title="<?php echo osc_esc_html(__('Switch to grid view', 'sofia')); ?>"><i class="fa fa-th"></i></a>
                <?php $params['sShowAs'] = 'list'; ?>
                <a href="<?php echo osc_update_search_url($params) ; ?>" title="<?php echo osc_esc_html(__('Switch to list view', 'sofia')); ?>"><i class="fa fa-list"></i></a>
              </div>
              
              <p class="see_by">
                <?php _e('Sort by', 'sofia'); ?>:
                <?php $i = 0; ?>
                <?php $orders = osc_list_orders();
                foreach($orders as $label => $params) {
                  $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1'; ?>
                  <?php if(osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) { ?>
                    <a class="current" href="<?php echo osc_esc_html(osc_update_search_url($params)); ?>"><?php echo $label; ?></a>
                  <?php } else { ?>
                    <a href="<?php echo osc_esc_html(osc_update_search_url($params)); ?>"><?php echo $label; ?></a>
                  <?php } ?>
                  <?php if ($i != count($orders)-1) { ?>
                    <span>|</span>
                  <?php } ?>
                  <?php $i++; ?>
                <?php } ?>
              </p>
            </div>
          </div>
          
          <?php if(osc_count_items() == 0) { ?>
            <div class="user_type_buttons">
              <div class="round3 all <?php if(Params::getParam('sCompany') == '' or Params::getParam('sCompany') == null) { ?>active<?php } ?>"><span><?php _e('All results', 'sofia'); ?></span></div>
              <div class="round3 individual <?php if(Params::getParam('sCompany') == '0') { ?>active<?php } ?>"><span><?php _e('Personal', 'sofia'); ?></span></div>
              <div class="round3 company <?php if(Params::getParam('sCompany') == '1') { ?>active<?php } ?>"><span><?php _e('Company', 'sofia'); ?></span></div>
            </div>
            <div id="regular-header"></div>

            <p class="empty" ><?php printf(__('There are no results matching "%s"', 'sofia'), osc_search_pattern()); ?></p>
          <?php } else { ?>
            <?php require(Params::getParam('sShowAs') == 'gallery' ? 'search_gallery.php' : 'search_list.php') ; ?>
            <div class="paginate" >
            <?php echo osc_search_pagination(); ?>
            </div>
          <?php } ?>
          
          <div class="clear"></div>          
        </div>
      </div>
      
      <div id="sidebar">
        <div id="search-alert">
          <?php osc_alert_form(); ?>
        </div>

        <?php if (Params::getParam('sCountry') <> '' or Params::getParam('sRegion') <> '' or Params::getParam('sCity') <> '' or Params::getParam('sCategory') <> '' or Params::getParam('sPriceMIn') <> '' or Params::getParam('sPriceMax') <> '') { ?>
          <div id="list-search" class="s-filter">
            <div class="text"><i class="fa fa-filter"></i>&nbsp;<?php _e('Active filters', 'sofia'); ?></div>

            <?php if (Params::getParam('sCountry') <> '') { ?><div class="entry country-filter round2"><?php _e('Country', 'sofia'); ?>: <strong><?php echo Params::getParam('sCountry'); ?></strong><i class="fa fa-close country-clear"></i></div><?php } ?>
            <?php if (Params::getParam('sRegion') <> '') { ?><div class="entry region-filter round2"><?php _e('Region', 'sofia'); ?>: <strong><?php echo Params::getParam('sRegion'); ?></strong><i class="fa fa-close region-clear"></i></div><?php } ?>
            <?php if (Params::getParam('sCity') <> '') { ?><div class="entry city-filter round2"><?php _e('City', 'sofia'); ?>: <strong><?php echo Params::getParam('sCity'); ?></strong><i class="fa fa-close city-clear"></i></div><?php } ?>
            <?php if (Params::getParam('sCategory') <> '') { ?>
              <?php $cat_filter = Category::newInstance()->findByPrimaryKey(Params::getParam('sCategory')); ?>
              <div class="entry category-filter round2"><?php _e('Category', 'sofia'); ?>: <strong><?php echo $cat_filter['s_name']; ?></strong><i class="fa fa-close category-clear"></i></div>
            <?php } ?>

            <?php $currency = Currency::newInstance()->findByPrimaryKey(osc_currency()); ?>
            <?php if (Params::getParam('sPriceMin') <> '') { ?><div class="entry pricemin-filter round2"><?php _e('Minimum price', 'sofia'); ?>: <strong><?php echo Params::getParam('sPriceMin'); ?> <?php echo $currency['s_description']; ?></strong><i class="fa fa-close pricemin-clear"></i></div><?php } ?>
            <?php if (Params::getParam('sPriceMax') <> '') { ?><div class="entry pricemax-filter round2"><?php _e('Maximum price', 'sofia'); ?>: <strong><?php echo Params::getParam('sPriceMax'); ?> <?php echo $currency['s_description']; ?></strong><i class="fa fa-close pricemax-clear"></i></div><?php } ?>
          </div>
        <?php } ?>

        <div id="list-search">
          <div class="text"><i class="fa fa-search"></i>&nbsp;<?php _e('Start your search there', 'sofia'); ?></div>

          <div class="search-input">
            <form action="<?php echo osc_base_url(true); ?>" method="get" class="search nocsrf" onsubmit="javascript:return doSearch();">
              <input type="hidden" name="page" value="search" />
              <input type="hidden" name="sCountry" id="sCountry" value="<?php echo Params::getParam('sCountry');?>" />
              <input type="hidden" name="cookie-action" id="cookie-action" value="" />
              <input type="hidden" name="sCompany" class="sCompany" id="sCompany" value="<?php echo Params::getParam('sCompany');?>" />
              <input type="hidden" name="sCategory" class="sCategory" id="sCategory" value="<?php echo Params::getParam('sCategory');?>" />
              <input type="hidden" name="sShowAs" class="sShowAs" id="sShowAs" value="<?php echo Params::getParam('sShowAs');?>" />

              <fieldset class="main">
                <input type="text" name="sPattern"  id="query" value="<?php echo osc_esc_html( ( osc_search_pattern() != '' ) ? osc_search_pattern() : '' ); ?>" placeholder="<?php echo osc_esc_html(__('Search...', 'sofia')); ?>" />
                <?php  if ( osc_count_categories() ) { ?> 
                  <?php $def_cat['pk_i_id'] = Params::getParam('sCategory'); ?>
                  <?php osc_categories_select('sCategory', $def_cat, __('Select a category', 'sofia')); ?>
                <?php } ?>
                
                <?php chosen_region_select(Params::getParam('sRegion')); ?>
                <input type="text" name="sCity" id="sCity-input" value="<?php echo Params::getParam('sCity');?>" placeholder="<?php echo osc_esc_html(__('Enter city...', 'sofia')); ?>" />

                <?php if( osc_price_enabled_at_items() ) { ?>
                 <div class="row two_input">
                   <input type="text" id="priceMin" name="sPriceMin" value="<?php echo Params::getParam('sPriceMin'); ?>" size="6" maxlength="6" placeholder="<?php echo osc_esc_html(__('min', 'sofia')); ?> <?php echo osc_currency();?>" />
                   <div class="price-del"></div>
                   <input type="text" id="priceMax" name="sPriceMax" value="<?php echo Params::getParam('sPriceMax'); ?>" size="6" maxlength="6" placeholder="<?php echo osc_esc_html(__('max', 'sofia')); ?> <?php echo osc_currency();?>" />
                 </div>
                <?php } ?>
                
                <input type="checkbox" name="bPic" id="withPicture" value="1" <?php echo (osc_search_has_pic() ? 'checked="checked"' : ''); ?> />
                <label for="withPicture" id="withPictureLabel"><?php _e('Listings with pictures only', 'sofia'); ?></label>
                
                <?php //if(function_exists('placeRadius')) { echo placeRadius(); } // you could place radius search here! ?>
                
                <div class="plugin-hooks">
                  <?php
                    if(osc_search_category_id()) {
                      osc_run_hook('search_form', osc_search_category_id()) ;
                    } else {
                      osc_run_hook('search_form') ;
                    }
                  ?>
                </div>

                <button type="submit"><?php _e('Search', 'sofia'); ?></button>
              </fieldset>
              <div id="search-example"></div>
            </form>
          </div>
        </div>
        
        <?php if(osc_get_preference('theme_adsense', 'sofia_theme')) { ?>
          <div id="home-ad-google"><?php echo osc_get_preference('banner_search', 'sofia_theme'); ?></div>
        <?php } ?>

        <div id="menu">
          <h2><i class="fa fa-unlink"></i><?php _e('Related Categories', 'sofia'); ?></h2>
          <div class="menu-wrap">
            <?php 
              $current_cat = osc_search_category_id(); 
              $current_cat = isset($current_cat['0']) ? $current_cat['0'] : '';
              $aCategory = osc_get_category('id', $current_cat);
              $parentCategory = osc_get_category('id', isset($aCategory['fk_i_parent_id']) ? $aCategory['fk_i_parent_id'] : '');
              $search_params = sofia_search_params();
            ?>
            
            <?php osc_goto_first_category() ; ?>              
            <?php while ( osc_has_categories() ) { ?>
              <?php $parent_id = osc_category_id($locale = ""); ?>
              <?php if ($parent_id == $current_cat or $current_cat == 0 or $parentCategory['pk_i_id'] == $parent_id) {  ?>
                <div class="category">
                  <?php $search_params['sCategory'] = osc_category_id(); ?>
                  <h2><a href="<?php echo osc_search_url($search_params); ?>"><?php echo osc_category_name() ; ?> </a> <span>(<?php echo osc_category_total_items() ; ?>)</span></h2>

                  <?php if ( osc_count_subcategories() > 0 ) { ?>
                  <ul class="subcategory" id="showSubcat<?php echo $current_cat; ?>" <?php if ($current_cat == 0) {?>style="display:none;"<?php } ?>>
                    <?php while ( osc_has_subcategories() ) { ?>
                      <?php $search_params['sCategory'] = osc_category_id(); ?>
                      <?php $subcat_id = osc_category_id($locale = ""); ?>
                      <?php $child_id = osc_category_id($locale = ""); ?>
                      <li id="topbar_element" <?php if ($child_id == $current_cat) { echo ' class="is_child" '; }  ?>>
                        <a class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_url($search_params); ?>"><?php echo osc_category_name() ; ?></a>
                      </li>
                    <?php } ?>
                  </ul>
                  <?php } ?>
                </div> 
              <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>
      
      <script type="text/javascript">

        $(function() {
          function log( message ) {
            $( "<div/>" ).text( message ).prependTo( "#log" );
            $( "#log" ).attr( "scrollTop", 0 );
          }

          var pk_c_code = $("#sRegion").val();
          var url = "<?php echo osc_base_url(true); ?>?page=ajax&action=location_cities&region=" + pk_c_code;
          
          $(document).ready(function(){ $('.ui-helper-hidden-accessible').hide(); });

          //$("#sCity").autocomplete({
          //  source: url,
          //  minLength: 1,
          //  select: function( event, ui ) {
          //    $("#sRegion").attr("value", ui.item.region);
          //    log( ui.item ? "<?php _e('Selected', 'sofia'); ?>: " + ui.item.value + " aka " + ui.item.id : "<?php echo osc_esc_js(__('Nothing selected, input was', 'sofia')); ?> " + this.value );
          //  }
          //});

          $("#sRegion").on("change",function(){
            $('.ui-helper-hidden-accessible').hide();
            $("#sCity").val('');

            pk_c_code = $(this).val();
            url = "<?php echo osc_base_url(true); ?>?page=ajax&action=location_cities&region=" + pk_c_code;

            //$("#sCity").autocomplete({
            //  source: url,
            //  minLength: 1,
            //  select: function( event, ui ) {
            //    $("#sRegion").attr("value", ui.item.region);
            //    log( ui.item ? "<?php _e('Selected', 'sofia'); ?>: " + ui.item.value + " aka " + ui.item.id : "<?php echo osc_esc_js(__('Nothing selected, input was', 'sofia')); ?> " + this.value );
            //  }
            //});
          });
        });

        function checkEmptyCategories() {
          var n = $("input[id*=cat]:checked").length;
          if(n>0) { return true; } else { return false; }
        }
      </script>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?>
  </body>
</html>