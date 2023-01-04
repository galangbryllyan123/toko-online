<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<?php $colorMode = osc_get_preference('theme_color_mode', 'lhoshar');?>
<h2 class="render-title"><?php _e('Theme Style', 'lhoshar'); ?></h2>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php');?>" method="post" enctype="multipart/form-data" class="nocsrf">
    <input type="hidden" name="action_specific" value="theme_style" />
	<fieldset>
		<div class="form-horizontal">
			<div class="form-row">
                <div class="form-label"><?php _e('Theme color mode', 'lhoshar'); ?></div>
                <div class="form-controls">
                    <select name="theme_color_mode">
                    	<option value="blue" <?php if($colorMode == 'blue'){ echo 'selected="selected"' ; } ?>><?php echo osc_esc_html(__('Blue','lhoshar'));?></option>
                    	<option value="darkblue" <?php if($colorMode == 'darkblue'){ echo 'selected="selected"' ; } ?>><?php echo osc_esc_html(__('Dark Blue','lhoshar'));?></option>
                    	<option value="darkgreen" <?php if($colorMode == 'darkgreen'){ echo 'selected="selected"' ; } ?>><?php echo osc_esc_html(__('Dark Green','lhoshar'));?></option> 
                        <option value="lightgreen" <?php if($colorMode == 'lightgreen'){ echo 'selected="selected"' ; } ?>><?php echo osc_esc_html(__('Light Green','lhoshar'));?></option>
                        <option value="maroon" <?php if($colorMode == 'maroon'){ echo 'selected="selected"' ; } ?>><?php echo osc_esc_html(__('Maroon','lhoshar'));?></option>
                        <option value="purple" <?php if($colorMode == 'purple'){ echo 'selected="selected"' ; } ?>><?php echo osc_esc_html(__('Purple','lhoshar'));?></option>           
                        <option value="red" <?php if($colorMode == 'red'){ echo 'selected="selected"' ; } ?>><?php echo osc_esc_html(__('Red','lhoshar'));?></option>
                    </select>
                </div>
			</div>
            <div class="form-row">
                <div class="form-label"><?php _e('RTL view', 'lhoshar'); ?></div>
                <div class="form-controls">
					<div class="form-label-checkbox">
						<input type="checkbox" name="rtl_view" value="1" <?php echo (osc_esc_html( osc_get_preference('rtl_view', 'lhoshar') ) == "1")? "checked": ""; ?>>
						<br>
						<div class="help-box"><?php _e('Right to left view.', 'lhoshar'); ?></div>
					</div>
				</div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Custom CSS', 'lhoshar'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;"name="custom_css"><?php echo osc_esc_html( osc_get_preference('custom_css', 'lhoshar') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('You can write your custom CSS and override the default CSS.', 'lhoshar'); ?></div>
                </div>
            </div>			
			<div class="form-actions">
				<input id="button" type="submit" value="<?php echo osc_esc_html(__('Save changes','lhoshar')); ?>" class="btn btn-submit">
			</div>
		</div>
	</fieldset>
</form>