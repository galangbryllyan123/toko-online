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
    osc_enqueue_script('jquery-validate');
?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('common/head.php'); ?>
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />
        <script type="text/javascript">
            $(document).ready(function() {
                $('form#change-email').validate({
                    rules: {
                        new_email: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        new_email: {
                            required: '<?php echo osc_esc_js(__("Email: this field is required", "hero")); ?>.',
                            email: '<?php echo osc_esc_js(__("Invalid email address", "hero")); ?>.'
                        }
                    },
                    errorLabelContainer: "#error_list",
                    wrapper: "li",
                    invalidHandler: function(form, validator) {
                        $('html,body').animate({ scrollTop: $('h1').offset().top }, { duration: 250, easing: 'swing'});
                    },
                    submitHandler: function(form){
                        $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
                        form.submit();
                    }
                });
            });
        </script>
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
                        <h2><?php _e("Change your e-mail", 'hero'); ?></h2>
                        <div class="stripe-line"></div>
                    </div>
                    <div class="panel-body">
                        <ul id="error_list"></ul>
                        <form id="change-email" action="<?php echo osc_base_url(true); ?>" method="post">
                            <input type="hidden" name="page" value="user" />
                            <input type="hidden" name="action" value="change_email_post" />
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label" for="email">
                                        <?php _e("Current e-mail", 'hero'); ?> 
                                    </label> 
                                    <span><?php echo osc_logged_user_email(); ?></span> 
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="new_email">
                                        <?php _e("New e-mail", 'hero'); ?> *</label>
                                    <input type="text" name="new_email" id="new_email" value="" />
                                <div class="topper">
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