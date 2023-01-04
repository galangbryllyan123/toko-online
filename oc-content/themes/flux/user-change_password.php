<?php
    osc_add_hook('header','flux_nofollow_construct');

    flux_add_body_class('user user-profile');
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-sidebar.php');
    }
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Change password', 'flux');;
    }
    osc_current_web_theme_path('header.php') ;
    $osc_user = osc_user();
?>
<h1 class="__mdl_regu_hd"><?php _e('Change password', 'flux'); ?></h1>
<div class="form-container form-horizontal">
    <div class="resp-wrapper">
        <ul id="error_list"></ul>
        <form action="<?php echo osc_base_url(true); ?>" method="post">
            <input type="hidden" name="page" value="user" />
            <input type="hidden" name="action" value="change_password_post" />
            <div class="control-group">
                <label class="control-label" for="password"><?php _e('Current password', 'flux'); ?> *</label>
                <div class="controls">
                    <input type="password" name="password" id="password" value="" autocomplete="off" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="new_password"><?php _e('New password', 'flux'); ?> *</label>
                <div class="controls">
                    <input type="password" name="new_password" id="new_password" value="" autocomplete="off" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="new_password2"><?php _e('Repeat new password', 'flux'); ?> *</label>
                <div class="controls">
                    <input type="password" name="new_password2" id="new_password2" value="" autocomplete="off" />
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="ui-button ui-button-middle ui-button-main"><?php _e("Update", 'flux');?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>