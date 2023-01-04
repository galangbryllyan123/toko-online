<?php
    

    // meta tag robots
    osc_add_hook('header','flux_nofollow_construct');

    flux_add_body_class('user user-profile');
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-sidebar.php');
    }
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Update account', 'flux');
    }
    osc_current_web_theme_path('header.php') ;
    $osc_user = osc_user();
?>
<h1 class="__mdl_regu_hd"><?php _e('Update account', 'flux'); ?></h1>
<?php UserForm::location_javascript(); ?>
<div class="form-container form-horizontal">
    <div class="resp-wrapper">
        <ul id="error_list"></ul>
        <form action="<?php echo osc_base_url(true); ?>" method="post">
            <input type="hidden" name="page" value="user" />
            <input type="hidden" name="action" value="profile_post" />
            <div class="control-group">
                <label class="control-label" for="name"><?php _e('Name', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::name_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="user_type"><?php _e('User type', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::is_company_select(osc_user()); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="phoneMobile"><?php _e('Cell phone', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::mobile_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="phoneLand"><?php _e('Phone', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::phone_land_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="country"><?php _e('Country', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::country_select(osc_get_countries(), osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="region"><?php _e('Region', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::region_select(osc_get_regions(), osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="city"><?php _e('City', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::city_select(osc_get_cities(), osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="city_area"><?php _e('City area', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::city_area_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"l for="address"><?php _e('Address', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::address_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="webSite"><?php _e('Website', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::website_text(osc_user()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="s_info"><?php _e('Description', 'flux'); ?></label>
                <div class="controls">
                    <?php UserForm::info_textarea('s_info', osc_locale_code(), @$osc_user['locale'][osc_locale_code()]['s_info']); ?>
                </div>
            </div>
            <?php osc_run_hook('user_profile_form', osc_user()); ?>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="ui-button ui-button-middle ui-button-main"><?php _e("Update", 'flux');?></button>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php osc_run_hook('user_form', osc_user()); ?>
                </div>
            </div>
        </form>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>