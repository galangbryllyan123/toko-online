<?php if (function_exists('mdh_avatar_preview_url')) { ?>

<div class="centeres"><img class="img-responsive" alt="<?php echo osc_esc_html(__('Seller profile','rival')); ?>" src="<?php echo mdh_avatar_preview_url(osc_user_id()); ?>" /></div>

<?php } else { ?>

<div class="centeres"><img class="img-responsive" alt="<?php echo osc_esc_html(__('Seller profile','rival')); ?>" src="<?php echo osc_current_web_theme_url('images/avatar.png') ; ?>" /></div>

<?php } ?>