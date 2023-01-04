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
    osc_add_hook('header','lhoshar_nofollow_construct');

    lhoshar_add_body_class('user user-profile');
    
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Alerts', 'lhoshar');;
    }
    osc_current_web_theme_path('header.php') ;
    $osc_user = osc_user();
?>
<div class="row" id="userchange-email-row">
<?php osc_current_web_theme_path('user-sidebar.php');?>
<div class="col-md-9" id="userchange-email-col">
 <h1><?php _e('Alerts', 'lhoshar'); ?></h1>
 <div class="form-login col-md-offset-1 col-md-offset-right-3">
  <?php if(osc_count_alerts() == 0) { ?>
    <h3><?php _e('You do not have any alerts yet', 'lhoshar'); ?>.</h3>
  <?php } else { ?>
    <?php
    $i = 1;
    while(osc_has_alerts()) { ?>
        <div class="userItem" >
            <div class="title-has-actions">
                <h3><?php _e('Alert', 'lhoshar'); ?> <?php echo $i; ?></h3> <a onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can\'t be undone. Are you sure you want to continue?', 'lhoshar')); ?>');" href="<?php echo osc_user_unsubscribe_alert_url(); ?>"><?php _e('Delete this alert', 'lhoshar'); ?></a><div class="clear"></div></div>
            <div>
            <?php osc_current_web_theme_path('loop.php') ; ?>
            <?php if(osc_count_items() == 0) { ?>
                    <br />
                    0 <?php _e('Listings', 'lhoshar'); ?>
            <?php } ?>
            </div>
        </div>
        <br />
    <?php
    $i++;
    }
    ?>
 <?php  } ?>
</div>
</div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>