<div class="usl-manage-menu">
    <ul>
        <li class="<?php echo (usl_is_settings_page()) ? 'active' : ''; ?>">
            <a href="<?php echo (usl_is_settings_page()) ? '' : osc_route_admin_url('usl-settings'); ?>"><?php _e('Configuration', 'ultimate_social_login'); ?></a>
        </li>

        <li class="<?php echo (usl_is_help_page()) ? 'active' : ''; ?>">
            <a href="<?php echo (usl_is_help_page()) ? '' : osc_route_admin_url('usl-help'); ?>"><?php _e('Help', 'ultimate_social_login'); ?></a>
        </li>
    </ul>
</div>