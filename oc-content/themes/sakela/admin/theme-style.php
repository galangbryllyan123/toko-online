<?php 
/**
* Admin menu page for Theme Colors settings
*
*/
?>

<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<?php $colorMode = osc_get_preference('theme_color_mode', 'sakela');?>
<?php $google_fonts = osc_get_preference('google_fonts', 'sakela');?>
<h2 class="render-title"><?php _e('Theme Style', 'sakela'); ?></h2>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/sakela/admin/settings.php');?>" method="post" enctype="multipart/form-data" class="nocsrf">
    <input type="hidden" name="action_specific" value="theme_style" />
	<fieldset>
		<div class="form-horizontal">
			<div class="form-row">
                <div class="form-label"><?php _e('Theme color mode', 'sakela'); ?></div>
                <div class="form-controls">
                    <select name="theme_color_mode">
                        <option value="green" <?php if($colorMode == 'green'){ echo 'selected="selected"' ; } ?>><?php echo osc_esc_html(__('Green','sakela'));?></option>
                        <option value="darkgreen" <?php if($colorMode == 'darkgreen'){ echo 'selected="selected"' ; } ?>><?php  echo osc_esc_html(__('Dark Green','sakela'));?></option>
                        <option value="red" <?php if($colorMode == 'red'){ echo 'selected="selected"' ; } ?>><?php  echo osc_esc_html(__('Red','sakela'));?></option>
                        <option value="blue" <?php if($colorMode == 'blue'){ echo 'selected="selected"' ; } ?>><?php  echo osc_esc_html(__('Blue','sakela'));?></option>
					    <option value="purple" <?php if($colorMode == 'purple'){ echo 'selected="selected"' ; } ?>><?php  echo osc_esc_html(__('Purple','sakela'));?></option>
                    </select>
                </div>
			</div>
            <div class="form-row">
                <div class="form-label"><?php _e('RTL view', 'sakela'); ?></div>
                <div class="form-controls">
                    <div class="form-label-checkbox">
                        <input type="checkbox" name="rtl_view" value="1" <?php echo (osc_esc_html( osc_get_preference('rtl_view', 'sakela') ) == "1")? "checked": ""; ?>>
                        <br>
                        <div class="help-box"><?php _e('Right to left view.', 'sakela'); ?></div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Custom CSS', 'sakela'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;"name="custom_css"><?php echo osc_esc_html( osc_get_preference('custom_css', 'sakela') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('You can write your custom CSS and override the default CSS.', 'sakela'); ?></div>
                </div>
            </div>			
			<div class="form-actions">
				<input id="button" type="submit" value="<?php echo osc_esc_html(__('Save changes','sakela')); ?>" class="btn btn-submit">
			</div>
		</div>
	</fieldset>
</form>