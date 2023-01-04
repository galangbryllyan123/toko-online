<?php

?>
<?php osc_current_web_theme_path('header.php') ; ?>
<div class="content-item">
    <div class="content user_forms">
        <div class="ui-generic-form ui-center single-form">
            <h1><?php _e('Recover your password', 'realestate') ; ?></h1>
            <div class="ui-generic-form-content">
                <form action="<?php echo osc_base_url(true) ; ?>" method="post" >
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="forgot_post" />
                    <input type="hidden" name="userId" value="<?php echo Params::getParam('userId'); ?>" />
                    <input type="hidden" name="code" value="<?php echo Params::getParam('code'); ?>" />
                    <fieldset>
                        <div class="row ui-row-text"><label for="new_email"><?php _e('New pasword', 'realestate') ; ?></label><input type="password" name="new_password" value="" /></div>
                        <div class="row ui-row-text"><label for="new_email"><?php _e('Repeat new pasword', 'realestate') ; ?></label><input type="password" name="new_password2" value="" /></div>
                        <div class="actions">
                            <a href="#" class="ui-button ui-button-gray js-submit"><?php _e("Change password", 'realestate');?></a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>