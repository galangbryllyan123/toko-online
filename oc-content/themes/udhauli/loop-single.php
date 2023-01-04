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
    } ?>

<?php if($loopClass != "") {
    echo '<div class="col-md-4 col-sm-6" id="grid-view-col">' ;
    echo '<div id="grid-view">' ;
} else {
    echo '<div id="list-view">' ;
    echo '<div class="row listing-views">' ;
}

$size = explode('x', osc_thumbnail_dimensions()); ?>

    <?php if($loopClass == "") {
        echo '<div class="col-md-3 col-sm-4">' ;
    } ?>
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
    <?php if(osc_item_is_premium()) { ?>
        <span class="ribbon"><span>
            <?php _e('Premium','udhauli');?>
            </span> 
        </span>
        <?php } ?>
    <?php if( osc_price_enabled_at_items() ) { ?>
            <span class="currency-value"><?php echo osc_format_price(osc_item_price()); ?></span>
        <?php } ?>
  </div>
  <?php if($loopClass == "") {
        echo '</div>' ;
    } ?>
  <?php if($loopClass != "") { ?>
  <li class="<?php osc_run_hook("highlight_class"); ?>listing-card <?php echo $class; if(osc_item_is_premium()){ echo ' premium'; } ?>">
      <div class="listing-detail">
                <div class="listing-basicinfo"><br>
                    <h4><a href="<?php echo osc_item_url() ; ?>" class="title" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_highlight( osc_item_title(), 18 ); ?></a></h4>
                    <div class="listing-lists">
                        <span class="category"><?php echo osc_item_category() ; ?></span> <br><br>
                       
                        <?php if($loopClass !="") { ?>
                            <p><?php echo osc_highlight( osc_item_description() ,70) ; ?></p>
                        <?php } else{ ?>
                            <p><?php echo osc_highlight( osc_item_description() ,300) ; ?></p>
                        <?php } ?>
                        <br>
                        <div class="row">
                            <div class="year col-xs-4"><i class="fa fa-calendar"></i><br><?php echo udhauli_cars_vehiclesYear(osc_item_ID()); ?> </div>
                            <div class="mileage col-xs-4"><i class="fa fa-tachometer"></i><br><?php echo udhauli_cars_vehiclesMileage(osc_item_ID()); ?> </div>
                            <div class="transmission col-xs-4"><i class="fa fa-gears"></i><br><?php echo udhauli_cars_vehiclesTransmissions(osc_item_ID()); ?> </div>
                        </div>
                    </div>
                <?php if($admin){ ?>
                <span class="admin-options">
                        <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><?php _e('Edit item', 'udhauli'); ?></a>
                        <span>|</span>
                        <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'udhauli')); ?>')" href="<?php echo osc_item_delete_url();?>" ><?php _e('Delete', 'udhauli'); ?></a>
                        <?php if(osc_item_is_inactive()) {?>
                        <span>|</span>
                        <a href="<?php echo osc_item_activate_url();?>" ><?php _e('Activate', 'udhauli'); ?></a>
                        <?php } ?>
                </span>    
             <?php } ?> 
         </div>     
    </div>       
  </li>
  <?php echo '</div>' ; 
  echo '</div>' ; ?>
  <?php } else {
    echo '<div class = "col-md-9 col-sm-8 list-detail">'; ?>
  <li class="<?php osc_run_hook("highlight_class"); ?>listing-card <?php echo $class; if(osc_item_is_premium()){ echo ' premium'; } ?>">
    
    <div class="listing-detail">
        <div class="listing-cell">
            <div class="listing-data">
                <div class="listing-basicinfo">
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
                        <i class="fa fa-map-marker"></i><span class="location"><?php if( osc_item_city()!='' ) { echo osc_item_city().', '; } ?><?php if( osc_item_region()!='' ) { ?><?php echo osc_item_region(); ?><?php } ?></span></br>
                        <div class="row">
                            <div class="year col-xs-4"><i class="fa fa-calendar"></i><br><?php echo udhauli_cars_vehiclesYear(osc_item_ID()); ?> </div>
                            <div class="mileage col-xs-4"><i class="fa fa-tachometer"></i><br><?php echo udhauli_cars_vehiclesMileage(osc_item_ID()); ?> </div>
                            <div class="transmission col-xs-4"><i class="fa fa-gears"></i><br><?php echo udhauli_cars_vehiclesTransmissions(osc_item_ID()); ?> </div>
                        </div>
                </div>
                <?php if($admin){ ?>
                    <span class="admin-options">
                        <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><?php _e('Edit item', 'udhauli'); ?></a>
                        <span>|</span>
                        <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'udhauli')); ?>')" href="<?php echo osc_item_delete_url();?>" ><?php _e('Delete', 'udhauli'); ?></a>
                        <?php if(osc_item_is_inactive()) {?>
                        <span>|</span>
                        <a href="<?php echo osc_item_activate_url();?>" ><?php _e('Activate', 'udhauli'); ?></a>
                        <?php } ?>
                    </span>
                <?php } ?>
            </div>
        </div>
    </div>
  </li>
    <?php echo '</div>';
    echo '</div>';
    echo '</div>';
  } ?>

