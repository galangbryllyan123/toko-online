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
    lhoshar_add_body_class('contact');
    osc_current_web_theme_path('header.php');
?>
<div class="row" id="userchange-email-row">
        <h1><?php _e('Send to a friend', 'lhoshar'); ?></h1>
    <div class="col-md-6 col-md-offset-3 item-post" id="user-login">
      <div class="form-login">
        <ul id="error_list"></ul>
        <form name="sendfriend" action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="action" value="send_friend_post" />
            <input type="hidden" name="page" value="item" />
            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
            <?php if(osc_is_web_user_logged_in()) { ?>
                            <input type="hidden" name="yourName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
                            <input type="hidden" name="yourEmail" value="<?php echo osc_logged_user_email();?>" />
            <?php } else { ?>
            <div class="control-group">
                <label class="control-label" for="yourName"><?php _e("Your name",'lhoshar'); ?></label>
                <div class="controls ">
                    <?php SendFriendForm::your_name(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="yourEmail"><?php _e("Your e-mail",'lhoshar'); ?></label>
                <div class="controls ">
                    <?php SendFriendForm::your_email(); ?>
                </div>
            </div>
            <?php } ?>
            <div class="control-group">
                <label class="control-label" for="friendName"><?php _e("Your friend's name",'lhoshar'); ?></label>
                <div class="controls">
                    <?php SendFriendForm::friend_name(); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="friendEmail"><?php _e("Your friend's e-mail address", 'lhoshar'); ?></label> </label>
                <div class="controls">
                    <?php SendFriendForm::friend_email(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="subject">
                    <?php _e('Subject (optional)', 'lhoshar'); ?>
                </label>
                <div class="controls">
                    <?php ContactForm::the_subject(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="message">
                    <?php _e('Message', 'lhoshar'); ?></label>
                <div class="controls textarea">
                    <?php SendFriendForm::your_message(); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php osc_run_hook('contact_form'); ?>
                    <?php osc_show_recaptcha(); ?>
                    <button type="submit" class="btn btn-md"><?php _e("Send", 'lhoshar');?></button>
                    <?php osc_run_hook('admin_contact_form'); ?>
                </div>
            </div>
        </form>
        <?php SendFriendForm::js_validation(); ?>
    </div><hr id="user-register-hr">
  </div>  
</div>
<?php osc_current_web_theme_path('footer.php'); ?>