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
    if(View::newInstance()->_exists('listClass')){
        $loopClass = View::newInstance()->_get('listClass');
    }

if($loopClass != "") {
    echo '<div class="col-md-3 col-sm-6" id="grid-view-col">' ;
} else {
    echo '<div class="row" id="listing-view">' ;
        echo '<div class="row" id="listing-views">' ;
}

$size = explode('x', osc_thumbnail_dimensions()); ?>
<div id="grid-view">
    <?php if($loopClass == "") {
        echo '<div class="col-md-3 col-sm-4">' ; ?>
          <div class="hovereffect">
            <div id="list-images">
     <?php if( osc_images_enabled_at_items() ) { ?>
        <?php if(osc_count_item_resources()) { ?>
        <div class="listing-thumb-color">
            <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
        </div>
        <?php } else { ?>
        <div class="listing-thumb-color">
            <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if (!EMPTY( lhoshar_realEstate_type(osc_item_ID()) )) { ?><span class="sale_wiz"> <?php echo lhoshar_realEstate_type(osc_item_ID());?> </span><?php } ?>
  </div>
  <?php if ( osc_item_is_premium() ) { ?>
        <span class="ribbon"><span>
            <?php _e('Premium','lhoshar');?>
            </span> 
        </span>
  <?php } ?>
</div>
    <?php } else { ?>
    <div class="hovereffect">
  <div id="grid-images">
     <?php if( osc_images_enabled_at_items() ) { ?>
        <?php if(osc_count_item_resources()) { ?>
        <div class="listing-thumb-color">
            <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
        </div>
        <?php } else { ?>
        <div class="listing-thumb-color">
            <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
        </div>
        <?php } ?>
    <?php } ?>
  </div>
  <?php if ( osc_item_is_premium() ) { ?>
        <span class="ribbon"><span>
            <?php _e('Premium','lhoshar');?>
            </span> 
        </span>
  <?php } ?>
  <li class="<?php osc_run_hook("highlight_class"); ?>listing-card <?php echo $class; if(osc_item_is_premium()){ echo ' premium'; } ?>">
             <?php if (!EMPTY( lhoshar_realEstate_type(osc_item_ID()) )) { ?><span class="sale_wiz"> <?php echo lhoshar_realEstate_type(osc_item_ID());?> </span><?php } ?>
             <div class="listing-grid-overlay">
                    <?php if( osc_price_enabled_at_items() ) { ?>
                        <span class="currency-value"><?php echo osc_format_price(osc_item_price()); ?></span>
                    <?php } ?>
                    <div class="listing-grid-overlay-heading"><a href="<?php echo osc_item_url() ; ?>" class="title" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_item_title() ; ?></a> </div>
                    <div class="listing-lists">
                      <i class="fa fa-map-marker"></i><span class="location"><?php echo osc_item_city(); ?> <?php if( osc_item_region()!='' ) { ?>, <?php echo osc_item_region(); ?><?php } ?></span>
                </div>
                <?php if($admin){ ?>
                    <span class="admin-options">
                        <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><?php _e('Edit item', 'lhoshar'); ?></a>
                        <span>|</span>
                        <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'lhoshar')); ?>')" href="<?php echo osc_item_delete_url();?>" ><?php _e('Delete', 'lhoshar'); ?></a>
                        <?php if(osc_item_is_inactive()) {?>
                        <span>|</span>
                        <a href="<?php echo osc_item_activate_url();?>" ><?php _e('Activate', 'lhoshar'); ?></a>
                        <?php } ?>
                    </span>
                <?php } ?>
            </div>
        </li>
      
  <div class="overlay row" id="overlay-row">  
    <?php if ( is_realEstate_enabled() ) { ?>
      <span class="wiz_area col-xs-4"><?php _e('Area','lhoshar');?><br><?php echo lhoshar_realEstate_area(osc_item_ID());?> </span>
      <span class="wiz_rooms col-xs-4"><?php _e('Beds','lhoshar');?><br><?php echo lhoshar_realEstate_rooms(osc_item_ID());?></span>                          
      <span class="wiz_bathrooms col-xs-4"> <?php _e('Baths','lhoshar');?><br><?php echo lhoshar_realEstate_bathrooms(osc_item_ID());?></span>
    <?php } ?>
  </div>
</div>
<?php } ?>
  <?php if($loopClass == "") {
    echo '</div>';
    echo '<div class = "col-md-9 col-sm-8 list-detail">'; ?>
  <li class="<?php osc_run_hook("highlight_class"); ?>listing-card <?php echo $class; if(osc_item_is_premium()){ echo ' premium'; } ?>">
    
    <div class="listing-detail">
        <div class="listing-cell">
            <div class="listing-data">
                <div class="listing-basicinfo">
                    <?php if( osc_price_enabled_at_items() ) { ?>
                        <span class="currency-value"><?php echo osc_format_price(osc_item_price()); ?></span>
                    <?php } ?>
                    <a href="<?php echo osc_item_url() ; ?>" class="title" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_item_title() ; ?></a> 
                    <div class="listing-lists">
                        <span class="category"><?php echo osc_item_category() ; ?></span> <br>
                         <div id="listing-grid-date"><i class="fa fa-calendar-o"></i><span class="g-hide"></span><?php echo osc_format_date(osc_item_pub_date()); ?></div>
                       
                        <?php if($loopClass !="") { ?>
                            <p><?php echo osc_highlight( osc_item_description() ,70) ; ?></p>
                        <?php } else{ ?>
                            <p><?php echo osc_highlight( osc_item_description() ,200) ; ?></p>
                        <?php } ?>
                        <hr>
                        <i class="fa fa-map-marker"></i><span class="location"><?php echo osc_item_city(); ?> <?php if( osc_item_region()!='' ) { ?>, <?php echo osc_item_region(); ?><?php } ?></span></br>
                        <?php if ( is_realEstate_enabled() ) { ?>
                        <div class="row plugin-row">
                        <span class="wiz_area col-xs-4"><?php _e('Area','lhoshar');?><br><?php echo lhoshar_realEstate_area(osc_item_ID());?> </span>
                        <span class="wiz_rooms col-xs-4"><?php _e('Beds','lhoshar');?><br><?php echo lhoshar_realEstate_rooms(osc_item_ID());?></span>                          
                        <span class="wiz_bathrooms col-xs-4"> <?php _e('Baths','lhoshar');?><br><?php echo lhoshar_realEstate_bathrooms(osc_item_ID());?></span></div>
                        <?php } ?>
                </div>
                <?php if($admin){ ?>
                    <span class="admin-options">
                        <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><?php _e('Edit item', 'lhoshar'); ?></a>
                        <span>|</span>
                        <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'lhoshar')); ?>')" href="<?php echo osc_item_delete_url();?>" ><?php _e('Delete', 'lhoshar'); ?></a>
                        <?php if(osc_item_is_inactive()) {?>
                        <span>|</span>
                        <a href="<?php echo osc_item_activate_url();?>" ><?php _e('Activate', 'lhoshar'); ?></a>
                        <?php } ?>
                    </span>
                <?php } ?>
            </div>
        </div>
       </div> 
    </div>
  </li>
    <?php echo '</div>';
  } ?>
 </div> 
<?php if($loopClass == "") {
    echo '</div>';
  } ?>
</div>
