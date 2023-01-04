<?php

?>
<?php osc_current_web_theme_path('header.php') ; ?>
<div class="content user-area">
    <div id="right-side">
        <h1><?php _e('User account manager', 'realestate') ; ?></h1>
        <h2><?php _e('Change your e-mail', 'realestate'); ?></h2>
        <div class="ui-generic-form ui-center">
            <div class="ui-generic-form-content">
                <form action="<?php echo osc_base_url(true) ; ?>" method="post">
                    <input type="hidden" name="page" value="user" />
                    <input type="hidden" name="action" value="change_email_post" />
                    <fieldset>
                        <div class="row ui-row-text">
                            <label for="email"><?php _e('Current e-mail', 'realestate') ; ?></label>
                            <input type="text" disabled="disabled" value="<?php echo osc_logged_user_email(); ?>" />
                        </div>
                        <div class="row ui-row-text">
                            <label for="new_email"><?php _e('New e-mail', 'realestate') ; ?> *</label>
                            <input type="text" name="new_email" id="new_email" value="" />
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