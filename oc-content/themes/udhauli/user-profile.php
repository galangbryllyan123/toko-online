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
    osc_add_hook('header','udhauli_nofollow_construct');

    udhauli_add_body_class('user user-profile');
    
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Update account', 'udhauli');
    }
    osc_current_web_theme_path('header.php') ;
    $osc_user = osc_user();
?>
<div class="row" id="form-row">
    <?php osc_current_web_theme_path('user-sidebar.php');?>
<div class="col-md-9 item-post" id="form-login"> 
    <div class="form-row-header">   
        <h1 id="form-row-h1"><?php _e('Update account', 'udhauli'); ?></h1>
    </div>    
     <div class="form-login col-md-offset-2 col-md-offset-right-2 item-post">
        <?php UserForm::location_javascript(); ?>
        <ul id="error_list"></ul>
        <form action="<?php echo osc_base_url(true); ?>" method="post">
            <input type="hidden" name="page" value="user" />
            <input type="hidden" name="action" value="profile_post" />
            <div class="control-group">
                <label class="control-label" for="name"><?php _e('Name', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::name_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="user_type"><?php _e('User type', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::is_company_select(osc_user()); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="phoneMobile"><?php _e('Cell phone', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::mobile_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="phoneLand"><?php _e('Phone', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::phone_land_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="country"><?php _e('Country', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::country_select(osc_get_countries(), osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="region"><?php _e('Region', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::region_select(osc_get_regions(), osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="city"><?php _e('City', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::city_select(osc_get_cities(), osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="city_area"><?php _e('City area', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::city_area_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"l for="address"><?php _e('Address', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::address_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="webSite"><?php _e('Website', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::website_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="s_info"><?php _e('Description', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::info_textarea('s_info', osc_current_user_locale(), @$osc_user['locale'][osc_current_user_locale()]['s_info']); ?>
                </div>
            </div>
            <?php osc_run_hook('user_profile_form', osc_user()); ?>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-md"><?php _e("Update", 'udhauli');?></button>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php osc_run_hook('user_form', osc_user()); ?>
                </div>
            </div>
        </form><br><br>
    </div>
  </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>