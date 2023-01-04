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

if($loopClass == "listing-grid premium-list") {
    echo '<div class="col-md-4 col-sm-6" id="loop-single-premium-col">' ;
    echo '<div id="grid-view">' ;
} else {
    echo '<div id="list-view">' ;
    echo '<div id="listing-view">' ;
    echo '<div class="row" id="loop-single-listpremium-col">' ;
}

$size = explode('x', osc_thumbnail_dimensions()); ?>

<li class="listing-card <?php echo $class; ?> premium">
    <?php if($loopClass == "listing-grid premium-list") {
    } else {
        echo '<div class="col-md-3 col-sm-4">' ;
    } ?>
    <div id="grid-images">
    <?php if( osc_images_enabled_at_items() ) { ?>
        <?php if(osc_count_premium_resources()) { ?>
        <div class="listing-thumb-premium-color">
            <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
        </div>
        <?php } else { ?>
        <div class="listing-thumb-color">
            <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
        </div>
        <?php } ?>
    <?php } ?>
    </div>
    <span class="ribbon"><span>
        <?php _e('Premium','udhauli');?>
        </span> 
    </span>
    <?php if( osc_price_enabled_at_items() ) { ?>
            <span class="currency-value"><?php echo osc_premium_formated_price(osc_premium_price()); ?></span>
        <?php } ?>
    <?php if($loopClass == "listing-grid premium-list") {
    } else {
        echo '</div>';
        echo '<div class = "col-md-9 col-sm-8">';
    } ?>      
    <div class="listing-detail">
                <div class="listing-basicinfo">
                    <?php if($loopClass == "listing-grid premium-list") { ?>
                        <a href="<?php echo osc_premium_url() ; ?>" class="title" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><?php echo osc_highlight(strip_tags(osc_premium_title()),18) ; ?></a>
                    <?php } else { ?>
                        <a href="<?php echo osc_premium_url() ; ?>" class="title" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><?php echo osc_premium_title() ; ?></a>
                    <?php } ?>
                    <div class="listing-attributes">
                        <span class="category"><?php echo osc_premium_category() ; ?></span>
                        <?php if($loopClass == "listing-grid premium-list") {
                            echo '<br>' ;
                        } else { ?>
                            <div id="listing-grid-date"><i class="fa fa-calendar-o"></i><span class="g-hide"></span> <?php echo osc_format_date(osc_premium_pub_date()); ?></div> 
                        <?php } ?>                       
                    </div>
                    <?php if( $loopClass == "listing-grid premium-list" ) { ?>
                        <p><?php echo osc_highlight( osc_premium_description(), 70 ); ?></p>
                    <?php } else{ ?>
                        <p><?php echo osc_highlight( osc_premium_description(), 300 ); ?></p><hr>
                    <?php } ?>
                    <?php if($loopClass == "listing-grid premium-list") {
                            echo '<br>' ;
                        } else { ?>
                            <i class="fa fa-map-marker"></i><span class="location"><?php if( osc_premium_city()!='' ) { echo osc_premium_city().', '; } ?><?php if( osc_premium_region()!='' ) { ?><?php echo osc_premium_region(); ?><?php } ?></span>
                        <?php } ?> 
                    <div class="row car-description">
                        <div class="year col-xs-4"><i class="fa fa-calendar"></i><br><?php echo udhauli_cars_vehiclesYear(osc_premium_ID()); ?> </div>
                        <div class="mileage col-xs-4"><i class="fa fa-tachometer"></i><br><?php echo udhauli_cars_vehiclesMileage(osc_premium_ID()); ?> </div>
                        <div class="transmission col-xs-4"><i class="fa fa-gears"></i><br><?php echo udhauli_cars_vehiclesTransmissions(osc_premium_ID()); ?> </div>
                    </div>
                </div>
                <?php if($admin){ ?>
                    <span class="admin-options">
                        <a href="<?php echo osc_premium_edit_url(); ?>" rel="nofollow"><?php _e('Edit item', 'udhauli'); ?></a>
                        <span>|</span>
                        <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'udhauli')); ?>')" href="<?php echo osc_premium_delete_url();?>" ><?php _e('Delete', 'udhauli'); ?></a>
                        <?php if(osc_premium_is_inactive()) {?>
                        <span>|</span>
                        <a href="<?php echo osc_premium_activate_url();?>" ><?php _e('Activate', 'udhauli'); ?></a>
                        <?php } ?>
                    </span>
                <?php } ?>
        <?php if($loopClass == "premium-list") {
            echo '</div>';
        } ?>
    </div>
</li>
<?php if($loopClass == "listing-grid premium-list") {
    echo '</div>' ;
    echo '</div>' ;
} else {
    echo '</div>' ;
    echo '</div>' ;
    echo '</div>' ;
} ?>