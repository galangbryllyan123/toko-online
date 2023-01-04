<?php

    function itemCustomHead(){
        echo '<script type="text/javascript" src="'.osc_current_web_theme_js_url('jquery.validate.min.js').'"></script>';

    }
    osc_add_hook('header','itemCustomHead');
?>
<?php osc_current_web_theme_path('header.php') ;?>
<?php UserForm::js_validation() ; ?>
<div class="content-item">
    <div class="content user_forms">
        <div class="ui-generic-form ui-center single-form">
            <h1><?php _e('Register an account for free', 'realestate'); ?></h1>
            <ul id="error_list"></ul>
            <div class="ui-generic-form-content">
                <form name="register" id="register" action="<?php echo osc_base_url(true) ; ?>" method="post" >
                    <input type="hidden" name="page" value="register" />
                    <input type="hidden" name="action" value="register_post" />
                    <fieldset>
                        <div class="row ui-row-text"><label for="name"><?php _e('Name', 'realestate') ; ?></label> <?php UserForm::name_text(); ?></div>
                        <div class="row ui-row-text"><label for="password"><?php _e('Password', 'realestate') ; ?></label> <?php UserForm::password_text(); ?></div>
                        <div class="row ui-row-text"><label for="password2"><?php _e('Re-type password', 'realestate') ; ?></label> <?php UserForm::check_password_text(); ?></div>
                        <p id="password-error" style="display:none;">
                            <?php _e('Passwords don\'t match', 'realestate') ; ?>.
                        </p>
                        <div class="row ui-row-text"><label for="email"><?php _e('E-mail', 'realestate') ; ?></label> <?php UserForm::email_text() ; ?></div>
                        <div class="actions">
                            <?php osc_run_hook('user_register_form') ; ?>
                            <?php osc_show_recaptcha('register'); ?>
                            <a href="#" class="ui-button ui-button-gray js-submit"><?php _e("Create", 'realestate');?></a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>