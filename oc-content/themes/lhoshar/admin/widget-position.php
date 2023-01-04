<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php'); ?>" method="post" class="nocsrf">
  <input type="hidden" name="action_specific" value="widget_position" />
  <h3 class="render-title">
    <?php _e('Arrange Widgets', 'lhoshar'); ?>
  </h3>
  
  <p>    <?php _e('You can drag the widget to alter the position', 'lhoshar'); ?>
</p>
  <fieldset>
    <div class="form-horizontal">
      <ul class="sortable sort_widget">
        <?php 
				$footer_widgets_position =  json_decode(osc_get_preference('footer_widgets_position', 'lhoshar'));
				if(!empty($footer_widgets_position)){
					foreach($footer_widgets_position as $value){
				?>
        <li>
          <div class="form-row">
            <input type="hidden" name="widget_position[]" value="<?php echo $value; ?>"/>
            <?php echo sprintf(__('%s Widget', 'lhoshar'), ucfirst($value));?></div>
        </li>
        <?php 
					}
				}
				?>
      </ul>
    </div>
    <div class="form-row">
      <div class="form-actions">
        <input type="submit" value="<?php echo osc_esc_html(__('Save changes', 'lhoshar')); ?>" class="btn btn-submit">
      </div>
    </div>
  </fieldset>
</form>
