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
    osc_add_hook('header','udhauli_nofollow_construct');

    udhauli_add_body_class('register');
    osc_enqueue_script('jquery-validate');
    osc_current_web_theme_path('header.php') ;
?>
<div class="form-row-header">
  <h1 id="form-row-h1"><?php _e('Register', 'udhauli'); ?></h1>
</div>  
<div class="row" id="form-row">
    <div class="col-md-6 col-md-offset-3 item-post" id="form-login">   
     <div class="form-login"> 
        <form name="register" action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="register" />
            <input type="hidden" name="action" value="register_post" />
            <ul id="error_list"></ul>
            <div class="control-group">
                <label class="control-label" for="name"><?php _e('Name', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::name_text(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="email"><?php _e('E-mail', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::email_text(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password"><?php _e('Password', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::password_text(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password-2"><?php _e('Repeat password', 'udhauli'); ?></label>
                <div class="controls">
                    <?php UserForm::check_password_text(); ?>
                    <p id="password-error" style="display:none;">
                        <?php _e("Passwords don't match", 'udhauli'); ?>
                    </p>
                </div>
            </div>
            <?php osc_run_hook('user_register_form'); ?>
            <div class="control-group">
                <div class="controls">
                    <?php osc_show_recaptcha('register'); ?>
                </div>
            </div><br>
            <div class="control-group">
                <div class="controls btn-control">
                    <button type="submit" class="btn btn-md"><?php _e("Create an Account", 'udhauli'); ?></button>
                </div>
            </div><br>
        </form>
      </div>
    </div>
</div>
<?php UserForm::js_validation(); ?>
<?php osc_current_web_theme_path('footer.php') ; ?>