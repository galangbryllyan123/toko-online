<?php
    

    // meta tag robots
    osc_add_hook('header','flux_nofollow_construct');

    flux_add_body_class('contact');
    osc_enqueue_script('jquery-validate');
    osc_current_web_theme_path('header.php');
?>
<div class="form-container form-horizontal form-container-box">
    <div class="header">
        <h1><?php _e('Contact us', 'flux'); ?></h1>
    </div>
    <div class="resp-wrapper">
        <ul id="error_list"></ul>
        <form name="contact_form" action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="contact" />
            <input type="hidden" name="action" value="contact_post" />
            <div class="control-group">
                <label class="control-label" for="yourName">
                    <?php _e('Your name', 'flux'); ?>
                    (<?php _e('optional', 'flux'); ?>)</label>
                <div class="controls">
                    <?php ContactForm::your_name(); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label" for="yourEmail">
                    <?php _e('Your email address', 'flux'); ?></label>
                <div class="controls">
                    <?php ContactForm::your_email(); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label" for="subject">
                    <?php _e('Subject', 'flux'); ?>
                    (<?php _e('optional', 'flux'); ?>)</label>
                <div class="controls">
                    <?php ContactForm::the_subject(); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label" for="message">
                    <?php _e('Message', 'flux'); ?></label>
                <div class="controls textarea">
                    <?php ContactForm::your_message(); ?></div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php osc_run_hook('contact_form'); ?>
                    <?php osc_show_recaptcha(); ?>
                    <button type="submit" class="ui-button ui-button-middle ui-button-main"><?php _e("Send", 'flux');?></button>
                    <?php osc_run_hook('admin_contact_form'); ?>
                </div>
            </div>
        </form>
        <?php ContactForm::js_validation(); ?>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>