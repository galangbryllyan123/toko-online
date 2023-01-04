<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    // meta tag robots
    osc_add_hook('header','lhoshar_nofollow_construct');

    osc_enqueue_script('jquery-validate');
    lhoshar_add_body_class('user user-profile');
    
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Change e-mail', 'lhoshar');;
    }
    osc_current_web_theme_path('header.php') ;
    $osc_user = osc_user();
?>
<div class="row" id="userchange-email-row">
    <?php osc_current_web_theme_path('user-sidebar.php');?>
 <div class="col-md-9 item-post" id="user-login">
   <h1><?php _e('Change E-Mail', 'lhoshar'); ?></h1>
    <div class="form-login col-md-offset-1 col-md-offset-right-3 item-post">
        <ul id="error_list"></ul>
        <form id="change-email" action="<?php echo osc_base_url(true); ?>" method="post">
            <input type="hidden" name="page" value="user" />
            <input type="hidden" name="action" value="change_Email_post" />
            <div class="control-group">
                <label for="email"><?php _e('Current e-mail', 'lhoshar'); ?></label>
                <div class="controls">
                    <?php echo osc_logged_user_email(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="new_email"><?php _e('New E-Mail', 'lhoshar'); ?> *</label>
                <div class="controls">
                    <input type="text" name="new_email" id="new_email" value="" />
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-md"><?php _e("Update", 'lhoshar');?></button>
                </div>
            </div>
        </form><br><br><hr id="user-register-hr">
    </div>
</div>
</div>
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
                    required: '<?php echo osc_esc_js(__("Email: this field is required", "lhoshar")); ?>.',
                    email: '<?php echo osc_esc_js(__("Invalid email address", "lhoshar")); ?>.'
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

<?php osc_current_web_theme_path('footer.php') ; ?>