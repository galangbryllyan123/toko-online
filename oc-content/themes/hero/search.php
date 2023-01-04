<?php
    /*
     *       Hero Responsive Osclass Themes
     *       
     *       Copyright (C) 2017 OSCLASS.me
     * 
     *       This is Hero Osclass Themes with Single License
     *  
     *       This program is a commercial software. Copying or distribution without a license is not allowed.
     *         
     *       If you need more licenses for this software. Please read more here <http://www.osclass.me/osclass-me-license/>.
     */
    $locales   = __get('locales');
    $user = osc_user();
    osc_enqueue_script('jquery-validate');
?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
    <?php osc_current_web_theme_path('common/head.php'); ?>
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow" /> 
</head>
<body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div id="content" class="container">
        <div class="row">
            <div class="main col-md-12">

<div class="col-md-12">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php $spubcat = get_categorieshero(); ?>
					<?php if (!isset($spubcat[2]) && !isset($spubcat[1]) && isset($spubcat[0])) { ?>
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingsne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsesne" aria-expanded="true" aria-controls="collapsesne">
          <?php echo search_title(); ?>
        </a>
      </h4>
    </div>
    <div id="collapsesne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingsne">
      <div class="panel-body"><div class="hola"><?php echo osc_category_description($locale = ""); ?></div>
                                        <div class="refine">
						<?php ;
							foreach(get_subcategories() as $subcat) {
								
								echo "<li><span><a href='".$subcat["url"]."'><span>".$subcat["s_name"]."</span></a> <span class='color'>" . get_category_num_items($subcat) . "</span></span></li>";
								
							} ?></div>
</div></div></div><?php } ?>

  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <?php _e("Advance Search", 'hero'); ?>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
<div class="box">
       <form action="<?php echo osc_base_url(true); ?>" method="get" class="nocsrf">
                                                <input type="hidden" name="page" value="search" />
                                                <input type="hidden" name="sOrder" value="<?php echo osc_esc_html(osc_search_order()); ?>" />
                                                <input type="hidden" name="sCompany" class="sCompany" id="sCompany" value="<?php echo Params::getParam('sCompany');?>" />
                                                <input type="hidden" name="iOrderType" value="<?php $allowedTypesForSorting = Search::getAllowedTypesForSorting(); echo osc_esc_html($allowedTypesForSorting[osc_search_order_type()]); ?>" />
                                                <?php foreach(osc_search_user() as $userId) { ?>
                                                <input type="hidden" name="sUser[]" value="<?php echo osc_esc_html($userId); ?>" />
                                                <?php } ?>
                                                <fieldset>
                                                    <div class="form-group col-md-3 col-sm-4 col-xs-12">
                                                        <label for="sCity">
                                                            <?php _e("Your Search", 'hero'); ?>
                                                        </label>
                                                        <input type="text" name="sPattern" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'hero'), 'hero')); ?>" class="form-control" id="query" value="<?php echo osc_esc_html( osc_search_pattern() ); ?>" /> </div>
                                                    <div class="form-group col-md-3 col-sm-4 col-xs-12">
                                                        <label>
                                                            <?php _e("Categories", 'hero'); ?>
                                                        </label>
                                                        <?php if ( osc_count_categories() ) { ?>
                                                        <div class="cell selector">
                                                            <?php chosen_select_standard() ; ?> 
                                                        </div>
                                                        <?php } ?> </div>
                                                    <div class="form-group  col-md-3 col-sm-4 col-xs-12">
                                                        <label for="sRegion">
                                                            <?php _e("Region", 'hero'); ?>
                                                        </label>
                                                        <input type="text" class="sRegion form-control" name="sRegion" value="<?php echo osc_esc_html( osc_search_region() ); ?>" /> 
                                                    </div>
                                                    <div class="form-group col-md-3 col-sm-4 col-xs-12">
                                                        <label for="sCity">
                                                            <?php _e("City", 'hero'); ?>
                                                        </label>
                                                        <input type="text" class="sCity form-control" name="sCity" value="<?php echo osc_esc_html( osc_search_city() ); ?>" /> 
                                                    </div>
                                                    <?php if( osc_images_enabled_at_items() ) { ?>
                                                    <div class="form-group col-md-3 col-sm-4 col-xs-12">
                                                        <label>
                                                            <?php _e("Show only", 'hero'); ?>
                                                        </label>
                                                        <br>
                                                        <div class="checkboxes">
                                                            
                                                                    <input type="checkbox" name="bPic" id="withPicture" value="1" <?php echo (osc_search_has_pic() ? 'checked="checked"' : ''); ?> />
                                                                    <p>
                                                                        <?php _e("Show only listings with pictures", 'hero'); ?>
                                                                    </p>
                                                               
                                                        </div>
                                                           </div><?php } ?> 
                                                    <?php if( osc_price_enabled_at_items() ) { ?>
                                                    <div class="form-group col-md-3 col-sm-4 col-xs-12">
                                                      
                                                        <label for="sCity">
                                                            <?php _e("Price", 'hero'); ?>
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-6">
                                                                    <?php _e("Min", 'hero'); ?>
                                                                    <input type="text" class="form-control" name="sPriceMin" value="<?php echo osc_esc_html(osc_search_price_min()); ?>" size="6" maxlength="6" />
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <?php _e("Max", 'hero'); ?>
                                                                    <input type="text" class="form-control" name="sPriceMax" value="<?php echo osc_esc_html(osc_search_price_max()); ?>" size="6" maxlength="6" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <?php } ?> 
                                                    <div class="form-group  col-md-3 col-sm-4 col-xs-12"><div class="col-md-12"><?php if(osc_search_category_id()) { osc_run_hook( 'search_form', osc_search_category_id()); } else { osc_run_hook( 'search_form'); } ?></div></div>
                                                    <button class="btn btn-success satusan" type="submit">
                                                        <?php _e("Apply", 'hero'); ?>
                                                    </button>
                                                </fieldset>
                                            </form>
      </div>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         <?php _e("Subscribe to this search", 'hero'); ?>
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        
                                            <?php osc_alert_form(); ?>
                                        
      </div>
    </div>
  </div>
  
</div>
</div>
                            
                                    <div class="col-md-12">
                                        <?php
    osc_get_premiums($max = osc_get_preference('premiumads_search_ads', 'hero')) ;
    if( osc_count_premiums() > 0 ) {
?>
                                        <div class="catalog">
                    <div class="warna teng"><i class="fa fa-star"></i>
                        <?php _e("Premium Ads", 'hero'); ?></div>
                    
                </div>
                                        <div id="owl-demo33" class="owl-carousel">
                                            <?php while ( osc_has_premiums() ) { ?>
                                            <div class="item productbox caption">
<div class="ribbonz"><span class="premiumss"><?php _e("Premium", 'hero'); ?></span></div>
                                                <?php if( osc_count_premium_resources() ) { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_premium_category_id() ); ?> warnas"></i></span> <a href="<?php echo osc_premium_url() ; ?>"><img class="lazyOwl" src="<?php echo osc_resource_thumbnail_url() ; ?>" data-src="<?php echo osc_resource_thumbnail_url() ; ?>" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"></a>
                                                <?php } else { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_premium_category_id() ); ?> warna"></i></span><a href="<?php echo osc_premium_url() ; ?>">
                                                     <img class="lazyOwl" src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" data-src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"/></a>
                                                <?php } ?>
                                                <div class="productprice">
                                                    <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) { ?>
                                                    <div class="pricetext">
                                                        <?php echo osc_format_price(osc_premium_price(), osc_premium_currency_symbol()); ?>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="producttitle aribudin">
                                                    <a href="<?php echo osc_premium_url() ; ?>">
                                                        <?php echo osc_premium_title(); ?>
                                                    </a>
                                                </div>
                                                <div class="centered">
                                                    <?php if(osc_premium_city()!='' ) { ?><strong><i class="fa fa-map-marker"></i></strong>
                                                    <?php echo osc_premium_city(); ?>
                                                    <?php } ?> &middot;
                                                    <?php if(osc_premium_region()!='' ) { ?>
                                                    <?php echo osc_premium_region(); ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php } ?> 
                                        </div>
                                        <?php } ?> 
                                    </div>
                                    <div class="col-md-12 actions">
                                          <div class="row">
                                          <div class="col-md-12">
                                        <div class="list">
                                            <div class="user_type">
                                              

                                                <div class="search_num"><b><?php
                $search_number = hero_search_number();
                printf(__('%1$d - %2$d of %3$d listings', 'hero'), $search_number['from'], $search_number['to'], $search_number['of']);
            ?></b>
                                                </div>
                                                <div class="all <?php if(Params::getParam('sCompany') == '' or Params::getParam('sCompany') == null) { ?>active<?php } ?>"><span><?php _e("All", 'hero'); ?></span>
                                                    <div class="force_down"></div>
                                                </div>
                                                <div class="personal <?php if(Params::getParam('sCompany') == '0') { ?>active<?php } ?>"><span><?php _e("Personal", 'hero'); ?></span>
                                                </div>
                                                <div class="firm <?php if(Params::getParam('sCompany') == '1') { ?>active<?php } ?>"><span><?php _e("Company", 'hero'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bars">
                                            <div class="btn-group btn-sm pull-left"> <a title="<?php echo osc_esc_html(__('Show As Galery','hero')); ?>" class="btn btn-success <?php if(hero_show_as()=='gallery'){ ?>active<?php } ?> btn-sm" href="<?php echo osc_update_search_url(array('sShowAs'=> 'gallery')); ?>"><span class="fa fa-th" aria-hidden="true"></span></a> <a title="<?php echo osc_esc_html(__('Show As List','hero')); ?>" class="btn btn-success <?php if(hero_show_as()=='list'){ ?>active<?php } ?> btn-sm" href="<?php echo osc_update_search_url(array('sShowAs'=> 'list')); ?>"><span class="fa fa-th-list" aria-hidden="true"></span></a> </div>
                                            <!--     START sort by       -->
                                            <div class="btn-group btn-sm pull-right">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <?php _e("Sort by", 'hero'); ?><span class="caret"></span> </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <?php $i = 0; ?>
                                <?php $orders = osc_list_orders();
                                foreach($orders as $label => $params) {
                                    $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1'; ?>
                                    <?php if(osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) { ?>
                                        <li><a class="current" href="<?php echo osc_esc_html(osc_update_search_url($params)); ?>"><?php echo $label; ?></a></li>
                                    <?php } else { ?>
                                       <li> <a href="<?php echo osc_esc_html(osc_update_search_url($params)); ?>"><?php echo $label; ?></a></li>
                                    <?php } ?>
                                    <?php if ($i != count($orders)-1) { ?>
                                    <?php } ?>
                                    <?php $i++; ?>
                                <?php } ?> </ul>
                                            </div>
                                        </div>
                                        <!--     END sort by       -->
                                        <div class="clear"></div>
                                    
                                    <div class="clear"></div>
                                
                        </div></div></div>
                        <?php if(osc_count_items()==0 ) { ?>
                        <div class="col-md-12">
                            <div class="no-result"><h4><?php printf(__('There are no results matching "%s"', 'hero'), osc_search_pattern()); ?></h4></div>
                        </div>
                        <?php } else { ?>
                        <?php osc_run_hook( 'search_ads_listing_top1'); ?>
                        <?php require(osc_search_show_as()=='list' ? 'search_list.php' : 'search_gallery.php'); ?>
                        <div class="bawa"><div class="paginate"><?php echo osc_search_pagination(); ?> </div></div>
                        <?php } ?>
                        <div class="clear"></div>
                        <?php $footerLinks = osc_search_footer_links(); ?>
                        <div class="bawa"><ul class="footer-links">
                            <?php foreach($footerLinks as $f) { View::newInstance()->_exportVariableToView('footer_link', $f); ?>
                            <?php if($f[ 'total'] < 3) continue; ?>
                            <li>
                                <a href="<?php echo osc_footer_link_url(); ?>">
                                    <?php echo osc_footer_link_title(); ?>
                                </a>
                            </li>
                            <?php } ?> </ul></div>
                        <div class="clear"></div>            

            </div>
        </div>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?>
    <script src="<?php echo osc_current_web_theme_js_url('owl.carousel.js') ; ?>"></script>
    <script src="<?php echo osc_current_web_theme_js_url('power4.js') ; ?>"></script>
</body>

</html>