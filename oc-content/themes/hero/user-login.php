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
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="container">
        <div class="tengah col-md-8">
            <div class="wraps">
                <div class="cat-box-title">
                            <h2><?php _e("Login", 'hero'); ?></h2>
                            <div class="stripe-line"></div>
                        </div>
                <div class="panel-body">
                <form action="<?php echo osc_base_url(true); ?>" method="post" class="form-signin">
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="login_post" />
                    <fieldset>
                        
                        <div class="form-group">
                            <label class="control-label" for="email">
                                <?php _e("E-mail", 'hero'); ?> </label>
                            <div class="controls">
                                <?php UserForm::email_login_text(); ?> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">
                                <?php _e("Password", 'hero'); ?> </label>
                            <div class="controls">
                                <?php UserForm::password_login_text(); ?> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls">
                                <?php UserForm::rememberme_login_checkbox();?>
                                <label for="remember">
                                    <?php _e("Remember me", 'hero'); ?> </label>
                            </div>
                        </div>
                        <?php osc_run_hook('usl_auth_buttons'); ?>
                        <button class="btn btn-success btn-lg seratus" type="submit"><span class="fa fa-sign-in" aria-hidden="true"></span>
                            <?php _e("Log in", 'hero');?> </button>
                        <br>
                        <div class="jarak"></div>
                        <?php osc_current_web_theme_path('templates/plugin/fb.php') ; ?>
                        <div class="forg">
                            <div class="control">
                                <div style="padding-top:15px">
                                    <a class="forgot2" href="<?php echo osc_recover_user_password_url(); ?>">
                                        <?php _e("Forgot password?", 'hero'); ?> </a>
                                </div>
                            </div>
                        </div>
                        <div class="forg">
                            <div class="control">
                                <div style="padding-top:15px;padding-bottom:15px">
                                    <?php _e("Don't have an account!", 'hero') ; ?>
                                    <a class="kir10" href="<?php echo osc_register_account_url() ; ?>">
                                        <?php _e("Sign Up here", 'hero') ; ?> </a>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form> 
             </div>
            </div>
        </div>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?> 
</body>
</html>