
<div class="actions">
  <a href="#" data-bclass-toggle="display-filters" class="resp-toogle show-filters-btn"><?php _e('Display menu','flux'); ?></a>
</div>
<div id="sidebar">
    <?php echo osc_private_user_menu( get_user_menu() ); ?>
</div>
<div id="dialog-delete-account" title="<?php echo osc_esc_html(__('Delete account', 'flux')); ?>">
<?php _e('Are you sure you want to delete your account?', 'flux'); ?>
</div>