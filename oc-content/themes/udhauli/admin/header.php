<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<style type="text/css" media="screen">
.command {
	background-color: white;
	color: #2E2E2E;
	border: 1px solid black;
	padding: 8px;
}
.theme-files {
	min-width: 500px;
}
</style>
<h2 class="render-title">
  <?php _e('Header logo', 'udhauli'); ?>
</h2>
<?php
    $logo_prefence = osc_get_preference('logo', 'udhauli');
?>
<?php if( is_writable( osc_uploads_path()) ) { ?>
<?php if($logo_prefence) { ?>
<h3 class="render-title">
  <?php _e('Preview', 'udhauli') ?>
</h3>
<img style="max-width:100%;"  border="0" alt="<?php echo osc_esc_html( osc_page_title() ); ?>" src="<?php echo udhauli_logo_url().'?'.filemtime(osc_uploads_path() . osc_get_preference('logo','udhauli'));?>" />
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/udhauli/admin/settings.php');?>" method="post" enctype="multipart/form-data" class="nocsrf">
  <input type="hidden" name="action_specific" value="remove" />
  <fieldset>
    <div class="form-horizontal">
      <div class="form-actions">
        <input id="button_remove" type="submit" value="<?php echo osc_esc_html(__('Remove logo','udhauli')); ?>" class="btn btn-red">
      </div>
    </div>
  </fieldset>
</form>
<?php } else { ?>
<div class="flashmessage flashmessage-warning flashmessage-inline" style="display: block;">
  <p>
    <?php _e('No logo has been uploaded yet', 'udhauli'); ?>
  </p>
</div>
<?php } ?>
<h2 class="render-title separate-top">
  <?php _e('Upload logo', 'udhauli') ?>
</h2>
<p>
  <?php _e('The preferred size of the logo is 177x30 pixels.', 'udhauli'); ?>
</p>
<?php if( $logo_prefence ) { ?>
<div class="flashmessage flashmessage-inline flashmessage-warning">
  <p>
    <?php _e('<strong>Note:</strong> Uploading another logo will overwrite the current logo.', 'udhauli'); ?>
  </p>
</div>
<?php } ?>
<br/>
<br/>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/udhauli/admin/settings.php'); ?>" method="post" enctype="multipart/form-data" class="nocsrf">
  <input type="hidden" name="action_specific" value="upload_logo" />
  <fieldset>
    <div class="form-horizontal">
      <div class="form-row">
        <div class="form-label">
          <?php _e('Logo image (png,gif,jpg)','udhauli'); ?>
        </div>
        <div class="form-controls">
          <input type="file" name="logo" id="package" />
        </div>
      </div>
      <div class="form-actions">
        <input id="button_save" type="submit" value="<?php echo osc_esc_html(__('Upload','udhauli')); ?>" class="btn btn-submit">
      </div>
    </div>
  </fieldset>
</form>
<?php } else { ?>
<div class="flashmessage flashmessage-error" style="display: block;">
  <p>
    <?php
                $msg  = sprintf(__('The images folder <strong>%s</strong> is not writable on your server', 'udhauli'), WebThemes::newInstance()->getCurrentThemePath() ."images/" ) .", ";
                $msg .= __("Osclass can't upload the logo image from the administration panel.", 'udhauli') . ' ';
                $msg .= __('Please make the aforementioned image folder writable.', 'udhauli') . ' ';
                echo $msg;
            ?>
  </p>
  <p>
    <?php _e('To make a directory writable under UNIX execute this command from the shell:','udhauli'); ?>
  </p>
  <p class="command"> chmod a+w <?php echo WebThemes::newInstance()->getCurrentThemePath() ."images/"; ?> </p>
</div>
<?php } ?>
