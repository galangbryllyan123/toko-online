<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    // meta tag robots
    if( osc_count_items() == 0 || stripos($_SERVER['REQUEST_URI'], 'search') ) {
        osc_add_hook('header','wayst_nofollow_construct');
    } else {
        osc_add_hook('header','wayst_follow_construct');
    }

    wayst_add_body_class('search');
    $listClass = '';
    $buttonClass = '';
    if(osc_search_show_as() == 'gallery'){
          $listClass = 'listing-grid';
          $buttonClass = 'active';
    }
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        
    }
    osc_add_hook('footer','autocompleteCity');
    function autocompleteCity(){ ?>
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
                            $("#sRegion").attr("value", ui.item.region);
                            log( ui.item ?
                                "<?php echo osc_esc_html( __('Selected', 'wayst') ); ?>: " + ui.item.value + " aka " + ui.item.id :
                                "<?php echo osc_esc_html( __('Nothing selected, input was', 'wayst') ); ?> " + this.value );
                        }
                    });
                });
    </script>
    <?php
    }
?>
<?php osc_current_web_theme_path('header.php') ; ?>

<body class="wayst">
            <?php osc_current_web_theme_path('common/rtop-menu2.php') ; ?>
            <div align="center"><?php osc_show_widgets('header'); ?></div>
            <!-- initiate page content -->
            <div class="container page-content product-search">
            <div class=" hidden-sm hidden-xs visible-md visible-lg " align="center">
                    <?php if (osc_get_preference('header-728x90', 'wayst')){ echo osc_get_preference('header-728x90', 'wayst');} else { echo ''; } ?>
                    </div>
                    
                    <div class=" visible-sm hidden-xs hidden-md hidden-lg " align="center">
                    <?php if (osc_get_preference('search-results-top-728x90', 'wayst')){ echo osc_get_preference('search-results-top-728x90', 'wayst');} else { echo ''; } ?>
                    </div>
                                                                        <header class="heading">
            <h1 class="pull-left">
              <?php echo search_title(); ?> <span><?php
                $search_number = wayst_search_number();
                printf(__('%1$d - %2$d of %3$d listings', 'wayst'), $search_number['from'], $search_number['to'], $search_number['of']);
            ?> </span>
            </h1>

            <div class="pull-right layout sortbar-container">
                <div class="sortbar">
                    <form id="sort-form">
                        <div class="sortbar-inputs">
                            
                            <select onChange="SortListingM(this.value)">
                <option value=''><?php _e('Sort by', 'wayst'); ?></option>
                 <?php $i = 0; ?>
                                <?php $orders = osc_list_orders();
                                foreach($orders as $label => $params) {
                                    $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1'; ?>
                                    <?php if(osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) { ?>
                                         <option selected value="<?php echo osc_esc_html(osc_update_search_url($params)); ?>"><?php echo $label; ?></option>
                                    <?php } else { ?>
                                         <option selected value="<?php echo osc_esc_html(osc_update_search_url($params)); ?>"><?php echo $label; ?></option>
                                    <?php } ?>
                                    <?php if ($i != count($orders)-1) { ?>
                                        
                                    <?php } ?>
                                    <?php $i++; ?>
                                <?php } ?>
                                    
                                       
                                </select>
                                <script language="javascript">//<!--
    
    function ToggleView(view, obj) {
        
        var src_class = 'grid';
        var target_class = 'list';
        var target_id = 'list_btn';
        var src_id = 'grid_btn';
        if(view == 'grid') {
            src_class = 'list';
            target_class = 'grid';
            target_id = 'grid_btn';
            src_id = 'list_btn';
        }
        
        document.cookie = 'view_type' + "=" + view + ';domain=.' + _SITE_DOMAIN;
        $('#'+src_id).addClass('active');
        $('#'+target_id).removeClass('active');
        $('ul.'+src_class).removeClass(src_class).addClass(target_class);
    }
    
    function ShowRefineBar() {
        $('div.refine_search').hide().removeClass('hidden-xs').slideDown();
    }
    function HideRefineBar() {
        $('div.refine_search').slideUp().addClass('hidden-xs');
    }
    function SortListingM(val) {
        if (val != '') { window.location = val;}
    }
    function sortnavClick(currValue)
    {
        if (currValue != '')
        {
            // If it's some JS in the value, run it, otherwise switch to the new URL
            if (currValue.charAt(0) == '$')
            {
                if (currValue.charAt(1) == '!')
                {
                    currValue = currValue.substring(2);
                }
                eval(currValue);
            }
            else
            {
                // Disable the dropdown so it can load nicely
                $('sortnav').disabled = true;
                $('sortnav').options[$('sortnav').selectedIndex].text = 'Loading...';

                window.location.href = currValue;
            }
        }
    }
//--></script>


                            <button type="submit" class="btn btn-sm btn-tool submit-button" title="Sort"><i class="fa fa-repeat"></i></button>


                            <button type="button" data-toggle="modal" data-target="#exampleModalLong" class="btn btn-sm btn-tool quick-button" title="<?php echo osc_esc_html(__("Subscribe now", "wayst")); ?>"><i class="fa fa-bell-o" aria-hidden="true"></i> <?php _e("Subscribe now", "wayst"); ?></button> 
                        </div>
                    </form>
                </div>

            </div>
        </header>
                    <article class="col-md-10 col-md-push-2 col-sm-9 col-sm-push-3 grid" id="search-layout">
                    
                    <!-- starting item --><?php    
    osc_get_premiums(10);
    if(osc_count_premiums() > 0) {
?>
<?php while(osc_has_premiums()) { ?>
                        <div class="item" itemscope="" itemprop="itemOffered">
                        <?php if( osc_images_enabled_at_items() ) { ?>
<?php if(osc_count_premium_resources()) { ?>
            <figure><a href="<?php echo osc_premium_url(); ?>"><img src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_esc_html(__("Premium", "wayst")); ?>" class="image-s" itemprop="image"></a></figure>
            <?php } else { ?>
            <figure><a href="<?php echo osc_premium_url(); ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="<?php echo osc_esc_html(__("Premium", "wayst")); ?>" class="image-s" itemprop="image"></a></figure><?php } ?><?php }?>
            <h2>
                <a href="<?php echo osc_premium_url(); ?>"><span itemprop="name"><?php echo osc_highlight( strip_tags( osc_premium_title() ) ); ?></span></a>
            </h2>
                            <h3><?php echo osc_highlight( strip_tags( osc_premium_description() ), 180 ); ?> - <strong><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) { echo osc_premium_formated_price(); ?></strong><?php } ?></h3>
            
                    <div class="price-avail">
            <div class="avail"><link itemprop="availability"><?php echo osc_format_date(osc_premium_pub_date()); ?></div>        <dl class="price">
            <dt><?php _e("Price", "wayst"); ?></dt>
            <dd><meta itemprop="priceCurrency" content="ZAR"><span itemprop="price"><?php _e("Premium", "wayst"); ?></span></dd>
        </dl>
                        </div>
                    <div class="cart-wish">
                                            
                                       <?php if (function_exists('watchlist')) { ?>  <form action="" method="post" class="wishlist">
                                       <a href="javascript://" class="btn btn-wish-add watchlist" id="<?php echo osc_premium_id(); ?>"></a>
                
            </form> <?php } else { ?> <?php }?>
                                      
                        </div><span class="product-label hot-label">Hot</span>
                    </div><?php } ?><?php }?> <!-- end item -->
            
            
            <!-- starting normal items -->
            <!-- starting item -->
			<?php if(osc_count_items() == 0) { ?>
                         <div align="center">
                        <p align="center"><?php printf(__('There are no results matching "%s"', 'wayst'), osc_search_pattern()); ?></p></div>
                    <?php } else { ?>
			
			<?php while(osc_has_items()) { $i++; ?>
                        <div class="item" itemscope="" itemprop="itemOffered">
                        <?php if( osc_images_enabled_at_items() ) { ?>
         <?php if(osc_count_item_resources()) { ?>
            <figure><a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_resource_url(); ?>" class="image-s" itemprop="image"></a></figure>
            <?php } else { ?>
            <figure><a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" class="image-s" itemprop="image"></a></figure><?php } ?><?php }?>
            <h2>
                <a href="<?php echo osc_item_url(); ?>"><span itemprop="name"><?php echo osc_highlight( strip_tags( osc_item_title() ) ); ?></span></a>
            </h2>
                            <h3><?php echo osc_highlight( strip_tags( osc_item_description() ), 180 ); ?></h3>
            
                    <div class="price-avail">
            <div class="avail"><link itemprop="availability"><?php echo osc_format_date(osc_item_pub_date()); ?></div>        <dl class="price">
            <dt><?php _e('Price', 'wayst'); ?></dt>
            <dd><meta itemprop="priceCurrency" content="ZAR"><span itemprop="price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() )  echo osc_item_formated_price(); ?></span></dd>
        </dl>
                        </div>
                    <div class="cart-wish">
                                            
                                       <?php if (function_exists('watchlist')) { ?>  <form class="wishlist">
                                       <a href="javascript://" class="btn btn-wish-add watchlist" id="<?php echo osc_item_id(); ?>"></a>
                
            </form> <?php } else { ?> <?php }?>
                                       
                        </div>
                    </div><?php } ?><?php } ?> <!-- end item -->
            <!-- end normal items -->                
                                
        <div class="text-right">        <div class="pagination-count">
            <?php
                $search_number = wayst_search_number();
                printf(__('%1$d - %2$d of %3$d listings', 'wayst'), $search_number['from'], $search_number['to'], $search_number['of']);
            ?>
        </div>
                <div class="pagination">
                            <?php echo osc_search_pagination(); ?>
                    </div>
        </div>            </article>
        
        
            <aside class="col-sm-3 col-sm-pull-9 col-md-2 col-md-pull-10 facets"><h5>Categories</h5>
            <?php $spubcat = get_categoriesHierarchy(); ?>
                            
                    	<?php if (!isset($spubcat[2]) && !isset($spubcat[1]) && isset($spubcat[0])){ ?>
                        <ul><li class="facet">
                        <a class="checkbox" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))); ?>"><i class="fa fa-folder-open-o" style="color:#996600" aria-hidden="true"></i> <?php _e('All categories', 'wayst'); ?></a> </li></ul>
                        <ul><li class="facet">
                        <?php _e('<a class="checkbox checked" href="' . $spubcat[0]["url"] . '"><span class="widget"></span><span class="label">' .  $spubcat[0]["s_name"] . '</span><span class="count">(' . get_category_num_items($spubcat[0]) . ')</span></a>' , 'wayst') ; ?></li></ul>
                        
                        
                        <?php ; echo '
<ul>';
                    		 foreach(get_subcategories() as $subcat) {
					echo "<li class='facet'><a class='checkbox' href='".$subcat["url"]."'><span class='widget'></span><span class='label'>".$subcat["s_name"]." </span><span class='count'>(" . get_category_num_items($subcat) . ")</span></a></li>";
				 }
				 echo '</ul>';
                    		 } 
                    	elseif (!isset($spubcat[2]) && isset($spubcat[1]) && isset($spubcat[0])) { ?>
                        		<ul><li class="facet">
                                <a class='checkbox' href='<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))); ?>'><i class="fa fa-folder-open-o" style="color:#996600" aria-hidden="true"></i> <?php _e('All categories', 'wayst'); ?></a></li></ul>
            <ul><li class="facet">
							<?php _e('<a class="checkbox checked" href="' . $spubcat[1]["url"] . '"><span class="widget"></span><span class="label">' .  $spubcat[1]["s_name"] . '</span><span class="count"> (' . get_category_num_items($spubcat[1]) . ')</span></a>' , 'wayst') ; ?></li></ul>
						<!--end titleheaderbg-->

                        
                    		<ul><li class="facet">
                    		 <?php _e('<a class="checkbox checked" href="' . $spubcat[0]["url"] . '"><span class="widget"></span><span class="label">' .  $spubcat[0]["s_name"] . '</span><span class="count"> (' . get_category_num_items($spubcat[0]) . ')</span></a>' , 'wayst') ; ?></li></ul>
							<?php ; echo '<ul>';
                    		 foreach(get_subcategories() as $subcat) {
					
					echo "<li class='facet'><a class='checkbox checked' href='".$subcat["url"]."'><span class='widget'></span><span class='label'>".$subcat["s_name"]." </span><span class='count'>(" . get_category_num_items($subcat) . ")</span></a></li> ";
				 }
				 echo '</ul>';
                    		}
                    	else { ?> <?php
         osc_goto_first_category();
         $i= 0;
         while ( osc_has_categories() ) {
            $liClass = '';
            if($i%3 == 0){
                $liClass = 'clear';
            }
            $i++;
         ?><ul><li class="facet"><i class="fa fa-folder-open-o" style="color:#996600" aria-hidden="true"></i> <a class="" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?></a></li></ul><?php } ?>
         
                    	<?php if (isset($spubcat[2])){ ?> 
                        
                        
							<ul><li class="facet"> <?php _e('<a class="checkbox checked" href="' . $spubcat[2]["url"] . '"><span class="widget"></span><span class="label">' .  $spubcat[2]["s_name"] . '</span><span class="count"> (' . get_category_num_items($spubcat[2]) . ')</span></a>' , 'wayst') ; ?> </li></ul> <?php ; } ?>
                   	  
                      <ul>
                    	<?php if (isset($spubcat[1])){ ?> <li class="facet"> <?php _e('<a class="checkbox checked" href="' . $spubcat[1]["url"] . '">' .  $spubcat[1]["s_name"] . ' (' . get_category_num_items($spubcat[1]) . ')</a> ' , 'wayst') ; ?> </li><?php ; } ?>
                    	<?php if (isset($spubcat[0])){ ?> <li class="facet"> <?php _e('<a class="checkbox checked" href="' . $spubcat[0]["url"] . '">' .  $spubcat[0]["s_name"] . ' (' . get_category_num_items($spubcat[0]) . ')</a>'  , 'wayst') ; ?> </li> <?php ; } ?>
                    <?php } ?></ul><?php if (isset($spubcat[2])){ ?><?php ; } ?>
                        
                        <form action="<?php echo osc_base_url(true); ?>" method="get" class="nocsrf" id="form-location">
        <input type="hidden" name="page" value="search"/>
        <input type="hidden" name="sOrder" value="<?php echo osc_search_order(); ?>" />
        <input type="hidden" name="iOrderType" value="<?php $allowedTypesForSorting = Search::getAllowedTypesForSorting() ; echo $allowedTypesForSorting[osc_search_order_type()]; ?>" />
        <?php foreach(osc_search_user() as $userId) { ?>
        <input type="hidden" name="sUser[]" value="<?php echo $userId; ?>"/>
        <?php } ?>
       
        <h5 class=""> <?php _e('Your search', 'wayst'); ?></h5>
            <div class="">
                <input class="form-control input-text" type="text" name="sPattern"  id="query" value="<?php echo osc_esc_html(osc_search_pattern()); ?>" />
            </div>
        
        
            <h5 class=""><?php _e('City', 'wayst'); ?></h5>
            <div class="">
                <input class="form-control input-text" type="text" id="sCity" name="sCity" value="<?php echo osc_esc_html(osc_search_city()); ?>" />
            </div>
        
        
        <?php if( osc_price_enabled_at_items() ) { ?>
            
                <h5 class=""><?php _e('Price', 'wayst') ; ?></h5>
                
               <div class="form-inline">
                <input class="form-control input-text" type="text" id="priceMin" name="sPriceMin" value="<?php echo osc_esc_html(osc_search_price_min()); ?>" size="2" maxlength="6" />
                
                <input class="form-control input-text" type="text" id="priceMax" name="sPriceMax" value="<?php echo osc_esc_html(osc_search_price_max()); ?>" size="2" maxlength="6" /></div>
           
        <?php } ?>
        <?php if( osc_images_enabled_at_items() ) { ?>
        
            <h5><?php _e('Show only', 'wayst') ; ?> <?php _e('listings with pictures', 'wayst') ; ?>
            
                <input type="checkbox" name="bPic" id="withPicture" value="1" <?php echo (osc_search_has_pic() ? 'checked' : ''); ?> />
                </h5>
            
        <?php } ?>
        <div class="clearfix"></div>
        <div class="">
        <div class="form-group">
        <div class="">
        <!-- plugins disabled temp.
            < ?php
            if(osc_search_category_id()) {
                osc_run_hook('search_form', osc_search_category_id()) ;
            } else {
                osc_run_hook('search_form') ;
            }
            ?> -->
        </div></div></div>
        <?php
        $aCategories = osc_search_category();
        foreach($aCategories as $cat_id) { ?>
            <input type="hidden" name="sCategory[]" value="<?php echo osc_esc_html($cat_id); ?>"/>
        <?php } ?>
        <div class="checkout-row row-cart">
            <button class="btn btn-primary margin" type="submit"><?php _e('Apply', 'wayst') ; ?></button>
        </div>
    </form></aside>    
    
                        
            <div class=" visible-sm hidden-xs visible-md visible-lg " align="center">
            <aside class="col-sm-3 col-sm-pull-9 col-md-2 col-md-pull-10 facets"> <br />
                     <?php if (osc_get_preference('search-results-middle-728x90', 'wayst')){ echo osc_get_preference('search-results-middle-728x90', 'wayst');} else { echo '<img src="' . osc_current_web_theme_url('images/unnamed1.png') . '"> '; } ?>
                   </aside> </div>
                           
                    
                    <div class=" hidden-sm visible-xs hidden-md ">
                    <aside class="col-sm-3 col-sm-pull-9 col-md-2 col-md-pull-10 facets">&nbsp;
                    
                    <?php if (osc_get_preference('sidebar-300x250', 'wayst')){ echo osc_get_preference('sidebar-300x250', 'wayst');} else { echo '<img src="' . osc_current_web_theme_url('images/banner300-250.jpg') . '"> '; } ?>
                    &nbsp;</aside>
                    </div> 
                                                            
                            <!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle" align="center"><?php _e('Subscribe to this search', 'wayst'); ?></h3>
      </div>
      <div class="modal-body" align="center">
        <?php osc_alert_form(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e('Close', 'wayst'); ?></button>
      </div>
    </div>
  </div>
</div>                
                            
                            <div class="clearfix"></div>
                                    </div>                           
            <!-- end page content -->
            
            <?php osc_current_web_theme_path('common/rtop-menu.php') ; ?>
                        
            <?php osc_current_web_theme_path('common/rfooter.php') ; ?>
                            

        
        </body></html>