<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php'); ?>" method="post" class="nocsrf">
  <input type="hidden" name="action_specific" value="widget_links" />
  <h2 class="render-title">
    <?php _e('Links Widget', 'lhoshar'); ?>
  </h2>
  <fieldset>
    <div class="form-horizontal">
      <div class="form-row">
        <div class="form-label">
          <?php _e('Title', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <input type="text" name="widget_links_title" value="<?php echo ( osc_get_preference('widget_links_title', 'lhoshar') ); ?>" />
        </div>
      </div>
      <div class="form-row">
        <div class="form-controls">
          <button id="widget_links_add" type="button" class="btn btn-success fileinput-button" ><i class="glyphicon glyphicon-plus"></i> <span>
          <?php _e('Add links', 'lhoshar'); ?>
          </span></button>
        </div>
      </div>
      <?php 	
			$widget_links_list =  json_decode(osc_get_preference('widget_links_list', 'lhoshar'));
			?>
      <div class="sortable links_sorts" id="links_list">
        <?php 
			if(!empty($widget_links_list)){
				foreach($widget_links_list as $link){
			?>
        <div class="form-row">
          <div class="row">
            <div class="col-md-3">
              <label>Text:</label>
              <input required type="text" name="link_text[]" value="<?php echo $link->link_text; ?>"/>
            </div>
            <div class="col-md-3">
              <label> Link:</label>
              <input required type="text" name="link_href[]" value="<?php echo $link->link_href; ?>"/>
            </div>
            <div class="col-md-2">
              <label> Target: </label>
              <select name="link_target[]">
                <option value="_blank" <?php if($link->link_target == '_blank'){ echo 'selected="selected"'; } ?>>_blank</option>
                <option value="_parent" <?php if($link->link_target == '_parent'){ echo 'selected="selected"'; } ?>>_parent</option>
                <option value="_self" <?php if($link->link_target == '_self'){ echo 'selected="selected"'; } ?>>_self</option>
                <option value="_top" <?php if($link->link_target == '_top'){ echo 'selected="selected"'; } ?>>_top</option>
                <option value="framename" <?php if($link->link_target == 'framename'){ echo 'selected="selected"'; } ?>>framename</option>
              </select>
            </div>
            <div class="col-md-2"> <span class="remove_link"> <i class="fa fa-times"></i> </span> </div>
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
