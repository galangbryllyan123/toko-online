<?php

?>
<?php osc_current_web_theme_path('header.php') ; ?>
<div class="content user-area">
    <div id="right-side">
        <h1><?php _e('User account manager', 'realestate') ; ?></h1>
        <h2><?php _e('Change your password', 'realestate'); ?></h2>
        <div class="ui-generic-form ui-center">
            <div class="ui-generic-form-content">
                <form action="<?php echo osc_base_url(true) ; ?>" method="post">
                    <input type="hidden" name="page" value="user" />
                    <input type="hidden" name="action" value="change_password_post" />
                    <fieldset>
                        <div class="row ui-row-text">
                            <label for="password"><?php _e('Current password', 'realestate') ; ?> *</label>
                            <input type="password" name="password" id="password" value="" />
                        </div>
                        <div class="row ui-row-text">
                            <label for="new_password"><?php _e('New password', 'realestate') ; ?> *</label>
                            <input type="password" name="new_password" id="new_password" value="" />
                        </div>
                        <div class="row ui-row-text">
                            <label for="new_password2"><?php _e('Repeat new<br/> password', 'realestate') ; ?> *</label>
                            <input type="password" name="new_password2" id="new_password2" value="" />
                        </div>
                        <div class="actions">
                            <a href="#" class="ui-button ui-button-gray js-submit"><?php _e("Update", 'realestate');?></a>
                        </div>
                        <?php osc_run_hook('user_form') ; ?>
                    </fieldset>
                </form>
            </div>
        </div>    
    </div>
    <?php require('user_sidebar.php') ; ?>
    <div class="clear"></div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>