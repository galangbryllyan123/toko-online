<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php'); ?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="widget_text" />

    <h2 class="render-title"><?php _e('Text Widget', 'lhoshar'); ?></h2>

    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Title', 'lhoshar'); ?></div>
                <div class="form-controls">
                    <input type="text" name="widget_text_title" value="<?php echo ( osc_get_preference('widget_text_title', 'lhoshar') ); ?>" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Content', 'lhoshar'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="widget_text_content"><?php echo ( osc_get_preference('widget_text_content', 'lhoshar') ); ?></textarea>
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" value="<?php echo osc_esc_html(__('Save changes', 'lhoshar')); ?>" class="btn btn-submit">
            </div>
        </div>
    </fieldset>
</form>





