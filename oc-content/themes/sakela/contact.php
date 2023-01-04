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

    sakela_add_body_class('contact');
    osc_enqueue_script('jquery-validate');
    osc_current_web_theme_path('header.php');
?>
<div class="col-sm-6 col-sm-offset-3" id="userchange-email-col"> 
    <div class="header">
        <h1><?php _e('Contact us', 'sakela'); ?></h1>
    </div>
    <div class="resp-wrapper">
        <ul id="error_list"></ul>
        <form name="contact_form" action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="contact" />
            <input type="hidden" name="action" value="contact_post" />
            <div class="control-group">
                <label class="control-label" for="yourName">
                    <?php _e('Your name', 'sakela'); ?>
                    (<?php _e('optional', 'sakela'); ?>)</label>
                <div class="controls">
                    <?php ContactForm::your_name(); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label" for="yourEmail">
                    <?php _e('Your email address', 'sakela'); ?></label>
                <div class="controls">
                    <?php ContactForm::your_email(); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label" for="subject">
                    <?php _e('Subject', 'sakela'); ?>
                    (<?php _e('optional', 'sakela'); ?>)</label>
                <div class="controls">
                    <?php ContactForm::the_subject(); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label" for="message">
                    <?php _e('Message', 'sakela'); ?></label>
                <div class="controls textarea">
                    <?php ContactForm::your_message(); ?></div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php osc_run_hook('contact_form'); ?>
                    <?php osc_show_recaptcha(); ?>
                    <button type="submit" class="btn btn-md btn-info"><?php _e("Send", 'sakela');?></button>
                    <?php osc_run_hook('admin_contact_form'); ?>
                </div>
            </div>
        </form>
        <?php ContactForm::js_validation(); ?>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>