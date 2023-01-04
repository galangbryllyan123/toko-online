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
                    <input type="hidden" name="action" value="recover_post" />
                    <fieldset>
                        <div><?php osc_show_recaptcha('recover_password'); ?></div>
                        <div class="row ui-row-text"><label for="email"><?php _e('E-mail', 'realestate') ; ?></label> <?php UserForm::email_text() ; ?></div>
                        <div class="actions">
                            <a href="#" class="ui-button ui-button-gray js-submit"><?php _e("Send me a new password", 'realestate');?></a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>