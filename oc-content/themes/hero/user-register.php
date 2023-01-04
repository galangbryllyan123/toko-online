<?php
    /*
     *       Hero Responsive Osclass Themes
     *       
     *       Copyright (C) 2017 OSCLASS.me
     * 
     *       This is Hero Osclass Themes with Single License
     *  
     *       This program is a commercial software. Copying or distribution without a license is not allowed.
     *         
     *       If you need more licenses for this software. Please read more here <http://www.osclass.me/osclass-me-license/>.
     */
    osc_enqueue_style('jquery-ui-custom', osc_current_web_theme_js_url('jquery-ui/jquery-ui-1.10.2.custom.css'));
    osc_enqueue_script('jquery-validate');
?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('common/head.php'); ?>
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />
        <style>
        .controls {
         margin-top: 0px;
        }
        </style>
    </head>
<body>
    <?php UserForm::js_validation(); ?>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="container">
        <div class="tengah col-md-8">
            <div class="wraps">
<div class="cat-box-title">
                            <h2><?php _e("Register", 'hero'); ?></h2>
                            <div class="stripe-line"></div>
                        </div>
<div class="panel-body">
                <form name="register" id="register" action="<?php echo osc_base_url(true); ?>" method="post" class="form-signin">
                    <input type="hidden" name="page" value="register" />
                    <input type="hidden" name="action" value="register_post" />
                    <fieldset>
                        
                        <ul id="error_list"></ul>
                        <div class="form-group">
                            <label class="control-label" for="s_name">
                                <?php _e("Name", 'hero'); ?> </label>
                            <div class="controls">
                                <?php UserForm::name_text(); ?> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="s_password">
                                <?php _e("Password", 'hero'); ?> </label>
                            <div class="controls">
                                <?php UserForm::password_text(); ?> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="s_password2">
                                <?php _e("Re-type password", 'hero'); ?> </label>
                            <div class="controls">
                                <?php UserForm::check_password_text(); ?> </div>
                        </div>
                        <p id="password-error" style="display:none;">
                            <?php _e("Passwords don't match", 'hero '); ?>.
                   </p>

            <div class="form-group">
                 <label class="control-label" for="s_email"><?php _e("E-mail",'hero'); ?></label> 
                 <div class="controls"><?php UserForm::email_text(); ?></div></div>
            <div class="form-group">
                        <?php osc_run_hook('user_register_form'); ?>
            </div>
            <div class="form-group">
                        <?php osc_show_recaptcha('register '); ?>
            </div>
            <div class="form-group">
                        <label><input class="cekk" type="checkbox" required=""><?php _e("I agree to the", 'hero'); ?> <a target="_blank" href="<?php echo osc_get_preference('tos-me', 'hero'); ?>"><?php _e("Terms of Use", 'hero'); ?></a></label>
                        </div>
                        <?php osc_run_hook('usl_auth_buttons'); ?>
                        <button class="btn btn-success btn-lg seratus" type="submit"><span class="fa fa-group" aria-hidden="true"></span> <?php _e("Register", 'hero'); ?></button>
                        <div class="jarak"></div>
                        <?php osc_current_web_theme_path('templates/plugin/fb.php') ; ?>
                        

            <div class="forg">
                                    <div class="control">
                                        <div class="topper" >
 <?php _e("Already have an account?", 'hero') ; ?> <a class="kir10" href="<?php echo osc_user_login_url(); ?>"><?php _e("Sign In", 'hero') ; ?></a>
</div></div></div>
                </fieldset>
            </form>
         </div>
	</div>
   </div>
</div>
        <?php osc_current_web_theme_path('footer.php'); ?>
    <script>
    document.getElementById("s_name").maxLength = "30";
    </script>
    </body>
</html>