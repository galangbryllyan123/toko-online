<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<style type="text/css" media="screen">
    .command { background-color: white; color: #2E2E2E; border: 1px solid black; padding: 8px; }
    .theme-files { min-width: 500px; }
</style>

<h2 class="render-title"><?php _e('Category Icon settings', 'sakela'); ?></h2>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/sakela/admin/category.php'); ?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="icons" />
    <fieldset>
        <div class="form-row">
            <p>
                <?php _e('Choose your icons form fontawesome website at', 'sakela');?>
                <a target="_blank" href="http://fontawesome.io/cheatsheet/">http://fontawesome.io/cheatsheet/</a>
            </p>
        </div>
        <div class="form-horizontal">
        <?php  $icons = unserialize(osc_get_preference('icons', 'sakela')); while ( osc_has_categories() ) {?>

            <div class="form-row">
                <div class="form-label"><?php echo osc_esc_html(osc_category_name()) ?></div>
                <div class="form-controls"><input type="text" class="xlarge" name="icons[<?php echo osc_category_id()?>]" value="<?php echo osc_esc_html($icons[osc_category_id()])?>"></div>
            </div>
        <?php }?>    
        </div>
    </fieldset>
    <fieldset>
        <div class="form-actions">
            <input type="submit" value="<?php _e('Save changes', 'sakela'); ?>" class="btn btn-submit">
        </div>
    </fieldset>
</form>
