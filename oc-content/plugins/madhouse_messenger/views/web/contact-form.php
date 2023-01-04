<?php

/*
 * ========================================================================================
 *
 * TO CUSTOMIZE
 *
 * COPY THIS FILE TO YOUR THEME IN
 * oc-content/themes/{your_theme_name}/plugins/madhouse_messenger/contact-form.php
 *
 * FOR TRANSLATION, RENAME ALL "madhouse_messenger" in this file by "your_theme_name"
 * Then update your po and mo file of your theme
 *
 * ========================================================================================
 */

?>

<?php if(!osc_is_web_user_logged_in() || (osc_is_web_user_logged_in() && osc_logged_user_id() !=  osc_user_id())): ?>
    <div style="margin-bottom:20px;">
        <form id="messenger-contact-form" action="<?php echo osc_base_url(true); ?>" method="post" enctype="multipart/form-data">
            <?php if(osc_item_user_id() || osc_item_contact_name()): ?>
                <input type="hidden" name="page" value="item" />
                <input type="hidden" name="action" value="contact_post" />
                <?php ContactForm::primary_input_hidden(); ?>
                <?php // Deprecated, for Backward compatibility! ?>
                <?php if(osc_item_user_id()): ?>
                    <input type="hidden" name="recipients[]" value="<?php echo osc_item_user_id(); ?>" />
                <?php endif; ?>
            <?php elseif (osc_user_id()): ?>
                <input type="hidden" name="page" value="user" />
                <input type="hidden" name="action" value="contact_post" />
                <input type="hidden" name="id" value="<?php echo osc_user_id();?>" />
                <?php // Deprecated, for Backward compatibility! ?>
                <input type="hidden" name="recipients[]" value="<?php echo osc_user_id(); ?>" />
            <?php else: ?>
                <?php // @TODO ?>
            <?php endif; ?>

            <?php if(mdh_messenger_is_contacted()): ?>
                <div class="wrapper-flash">
                    <div class="flashmessage flashmessage-info alert alert-info">
                        <?php printf(__("You have already contacted %s for this listing: %ssee thread%s", 'madhouse_messenger'), osc_item_contact_name(), '<a style="color: #fff;" href="'.mdh_thread_url().'">' , '</a>'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!osc_is_web_user_logged_in()): ?>
                <div class="control-group form-group">
                    <label class="control-label"><?php _e('Your name', 'madhouse_messenger'); ?></label>
                    <div class="controls">
                        <input class="form-control" type="text" name="yourName" value="<?php echo osc_esc_html((Session::newInstance()->_getForm('pp_yourName') != '')?Session::newInstance()->_getForm('pp_yourName') : "") ?>" />
                    </div>
                </div>

                <div class="control-group form-group">
                    <label class="control-label"><?php _e('Email', 'madhouse_messenger'); ?></label>
                    <div class="controls">
                        <input class="form-control" type="text" name="yourEmail" value="<?php echo osc_esc_html((Session::newInstance()->_getForm('pp_yourEmail') != '')?Session::newInstance()->_getForm('pp_yourEmail') : "") ?>" />
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!mdh_messenger_is_contacted() && mdh_messenger_subject_enabled()): ?>
                <div class="control-group">
                    <label class="control-label"><?php _e('Subject', 'madhouse_messenger'); ?></label>
                    <div class="controls">
                        <input class="form-control" type="text" name="subject" value="<?php echo osc_esc_html((Session::newInstance()->_getForm('pp_subject') != '')?Session::newInstance()->_getForm('pp_subject') : "") ?>" />
                    </div>
                </div>
            <?php endif ?>
            <div class="control-group form-group"  style="margin-bottom:20px;">
                <div class="controls">
                   
                    <textarea
                        name="message"
                        rows="10"
                        required="required"
                        class="form-control"
                        data-msg-required="<?php _e("Please write something", 'madhouse_messenger')?>"
                        placeholder="<?php _e("Write something...", 'madhouse_messenger')?>"
                        ><?php echo osc_esc_html((Session::newInstance()->_getForm('pp_message') != '')?Session::newInstance()->_getForm('pp_message') : mdh_messenger_message_template()) ?></textarea>
                </div>
            </div>
            <?php if (mdh_messenger_resources_enabled()): ?>
                <div class="control-group">
                    <label class="control-label"><?php _e('Attachment', 'madhouse_messenger'); ?></label>
                    <div class="controls">
                        <input type="file" name="attachment" />
                    </div>
                </div>
            <?php endif ?>

            <?php osc_run_hook('item_contact_form', osc_item_id()); ?>

            <?php if (!osc_is_web_user_logged_in()) : ?>
                <div class="control-group form-group">
                    <div class="controls">
                        <?php osc_show_recaptcha(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="control-group">
                <div class="controls">
                    <button type="submit">
                        <?php _e('Send message', 'madhouse_messenger') ; ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
<?php endif; ?>
