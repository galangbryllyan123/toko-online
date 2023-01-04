<?php
    /*
     *       Hero Responsive Osclass Themes
     *       
     *       Copyright (C) 2016 OSCLASS.me
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
</head>
<body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="container">
        <div class="veraari">
            <div class="col-md-3">
                <div class="profile-userpic">
                    <?php echo show_avatar(osc_logged_user_id()); ?>
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo osc_user_name(); ?> 
                    </div>
                </div>
                <?php echo osc_private_user_menu( get_user_menu() ); ?>
                <div class="ads">
                    <?php echo osc_get_preference('ads-member', 'hero'); ?> 
                </div>
            </div>
            <div class="col-md-9">
                <div class="wraps">
                    <div class="cat-box-title">
                        <h2><?php _e("Change your password", 'hero'); ?></h2>
                        <div class="stripe-line"></div>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo osc_base_url(true); ?>" method="post">
                            <input type="hidden" name="page" value="user" />
                            <input type="hidden" name="action" value="change_password_post" />
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label" for="password">
                                        <?php _e("Current password", 'hero'); ?> *</label>
                                    <input type="password" name="password" id="password" value="" /> 
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="new_password">
                                        <?php _e("New password", 'hero'); ?> *</label>
                                    <input type="password" name="new_password" id="new_password" value="" /> 
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="new_password2">
                                        <?php _e("Repeat new password", 'hero'); ?> *</label>
                                    <input type="password" name="new_password2" id="new_password2" value="" /> 
                                </div>
                                <div style="clear:both;"></div>
                                <button class="btn btn-primary btn-lg" type="submit"><span class="fa fa-check-square" aria-hidden="true"></span>
                                    <?php _e("Update", 'hero'); ?> </button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?> 
</body>
</html>