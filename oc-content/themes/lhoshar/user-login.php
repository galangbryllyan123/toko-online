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

    lhoshar_add_body_class('login');
    osc_current_web_theme_path('header.php');
?>
<div class="row" id="userchange-email-row">
    <h1><?php _e('Login', 'lhoshar'); ?></h1>
    <div class="col-md-6 col-md-offset-3 item-post" id="user-login">
    <div class="form-login">
        <form action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="login" />
            <input type="hidden" name="action" value="login_post" />

            <div class="control-group">
                <label class="control-label" for="email"><?php _e('E-mail', 'lhoshar'); ?></label>
                <?php UserForm::email_login_text(); ?>
                </div>
            <div class="control-group">

                <label class="control-label" for="password"><?php _e('Password', 'lhoshar'); ?></label>
                <div class="controls">
                    <?php UserForm::password_login_text(); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls checkbox">
                    <?php UserForm::rememberme_login_checkbox();?><label for="remember"><?php _e('Remember me', 'lhoshar'); ?></label>
                </div>
                <div class="controls">
                    <button type="submit" class="btn btn-md"><?php _e("Login to My Account", 'lhoshar');?></button>
                </div><br>
            </div>
            <div class="actions">
                <a href="<?php echo osc_register_account_url(); ?>"><?php _e("Register for a free account", 'lhoshar'); ?></a><br /><a href="<?php echo osc_recover_user_password_url(); ?>"><?php _e("Forgot password?", 'lhoshar'); ?></a>
            </div>
        </form>
    </div>
  </div>
 </div>
<?php osc_current_web_theme_path('footer.php') ; ?>