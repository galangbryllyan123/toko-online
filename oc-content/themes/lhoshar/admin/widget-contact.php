<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php'); ?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="widget_contact" />

    <h2 class="render-title"><?php _e('Contact Widget', 'lhoshar'); ?></h2>

    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Title', 'lhoshar'); ?></div>
                <div class="form-controls">
                    <input type="text" name="widget_contact_title" value="<?php echo ( osc_get_preference('widget_contact_title', 'lhoshar') ); ?>" />
			   </div>
				 
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Phone', 'lhoshar'); ?></div>
                <div class="form-controls">
                    <input type="text" name="widget_contact_phone" value="<?php echo ( osc_get_preference('widget_contact_phone', 'lhoshar') ); ?>" />
				&nbsp;<?php _e('Icon', 'lhoshar'); ?>
				    <input type="text" class="fa_icon" placeholder="phone" name="widget_contact_phone_icon" value="<?php echo ( osc_get_preference('widget_contact_phone_icon', 'lhoshar') ); ?>" />
					&nbsp;<i class="fa fa-<?php echo ( osc_get_preference('widget_contact_phone_icon', 'lhoshar') ); ?>"></i>
			   </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Email', 'lhoshar'); ?></div>
                <div class="form-controls">
                    <input type="text" name="widget_contact_email" value="<?php echo ( osc_get_preference('widget_contact_email', 'lhoshar') ); ?>" />
				&nbsp;<?php _e('Icon', 'lhoshar'); ?>
				    <input type="text" class="fa_icon" placeholder="envelope-o"  name="widget_contact_email_icon" value="<?php echo ( osc_get_preference('widget_contact_email_icon', 'lhoshar') ); ?>" />
					&nbsp;<i class="fa fa-<?php echo ( osc_get_preference('widget_contact_email_icon', 'lhoshar') ); ?>"></i>
				</div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Address', 'lhoshar'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 55px; width: 300px;" name="widget_contact_location"><?php echo ( osc_get_preference('widget_contact_location', 'lhoshar') ); ?></textarea>
				&nbsp;<?php _e('Icon', 'lhoshar'); ?>
				    <input type="text" class="fa_icon" placeholder="map-marker" name="widget_contact_location_icon" value="<?php echo ( osc_get_preference('widget_contact_location_icon', 'lhoshar') ); ?>" />
					&nbsp;<i class="fa fa-<?php echo ( osc_get_preference('widget_contact_location_icon', 'lhoshar') ); ?>"></i>
				</div>
            </div>
            <div class="form-actions">
                <input type="submit" value="<?php echo osc_esc_html(__('Save changes', 'lhoshar')); ?>" class="btn btn-submit">
            </div>
        </div>
    </fieldset>
</form>





