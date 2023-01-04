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
    osc_add_hook('header','sakela_nofollow_construct');

    sakela_add_body_class('recover');
    osc_current_web_theme_path('header.php');
?>
<div class="row" id="userchange-email-row">
  <div class="col-sm-6 col-sm-offset-3" id="col-user-recover">
   <div class="form-password-recover">
    <div class="header">
        <h1><?php _e('Recover your password', 'sakela'); ?></h1>
    </div>
    <div class="resp-wrapper">
        <form action="<?php echo osc_base_url(true); ?>" method="post" >
        <input type="hidden" name="page" value="login" />
        <input type="hidden" name="action" value="recover_post" />
        <div class="control-group">
            <label class="control-label" for="email"><?php _e('E-mail', 'sakela'); ?></label>
            <div class="controls">
                <?php UserForm::email_text(); ?>
                <?php osc_show_recaptcha('recover_password'); ?>
            </div>
        </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-lg btn-deafult"><?php _e("New password", 'sakela');?></button>
                </div>
            </div>
        </form>
    </div>
  </div>
 </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>