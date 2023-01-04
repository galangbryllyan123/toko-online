<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php'); ?>" method="post" class="nocsrf">
  <input type="hidden" name="action_specific" value="widget_social" />
  <h2 class="render-title">
    <?php _e('Social Widget', 'lhoshar'); ?>
  </h2>
  <fieldset>
    <div class="form-horizontal">
      <div class="form-row">
        <div class="form-label">
          <?php _e('Title', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <input type="text" name="widget_social_title" value="<?php echo ( osc_get_preference('widget_social_title', 'lhoshar') ); ?>" />
        </div>
      </div>
      <div class="form-row">
        <div class="form-controls">
          <button id="widget_social_add" type="button" class="btn btn-success fileinput-button" ><i class="glyphicon glyphicon-plus"></i> <span>
          <?php _e('Add social links', 'lhoshar'); ?>
          </span></button>
        </div>
      </div>
      <?php 		
			$widget_social_list =  json_decode(osc_get_preference('widget_social_list', 'lhoshar'));
			?>
      <div class="sortable links_sorts" id="social_list">
        <?php 
			if(!empty($widget_social_list)){
				foreach($widget_social_list as $social){
			?>
        <div class="form-row">
          <div class="row">
            <div class=" col-md-3">
              <label>Icon:</label>
              <input class="fa_icon" required type="text" name="social_icon[]" value="<?php echo $social->social_icon; ?>"/>
              &nbsp;<i class="fa fa-<?php echo $social->social_icon; ?>"></i></div>
            <div class=" col-md-3">
              <label>Link:</label>
              <input required type="text" name="social_href[]" value="<?php echo $social->social_href; ?>"/>
            </div>
            <div class=" col-md-2">
              <label>Target:</label>
              <select name="social_target[]">
                <option value="_blank" <?php if($social->social_target == '_blank'){ echo 'selected="selected"'; } ?>>_blank</option>
                <option value="_parent" <?php if($social->social_target == '_parent'){ echo 'selected="selected"'; } ?>>_parent</option>
                <option value="_self" <?php if($social->social_target == '_self'){ echo 'selected="selected"'; } ?>>_self</option>
                <option value="_top" <?php if($social->social_target == '_top'){ echo 'selected="selected"'; } ?>>_top</option>
                <option value="framename" <?php if($social->social_target == 'framename'){ echo 'selected="selected"'; } ?>>framename</option>
              </select>
            </div>
            <div class=" col-md-2"><span class="remove_link"> <i class="fa fa-times"></i> </span> </div>
          </div>
        </div>
        <?php
				}
			}
			?>
      </div>
      <div class="form-actions">
        <input type="submit" value="<?php echo osc_esc_html(__('Save changes', 'lhoshar')); ?>" class="btn btn-submit">
      </div>
    </div>
  </fieldset>
</form>
