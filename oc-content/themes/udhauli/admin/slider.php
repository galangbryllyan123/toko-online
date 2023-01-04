<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<h2 class="render-title <?php echo (osc_get_preference('footer_link', 'udhauli') ? '' : 'separate-top'); ?>"><?php _e('Slider settings', 'udhauli'); ?></h2>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/udhauli/admin/slider.php'); ?>" method="post" class="nocsrf" enctype="multipart/form-data">
    <input type="hidden" name="action_specific" value="slider" />
    <?php $slider = unserialize(osc_get_preference('slider', 'udhauli'));?>
    <fieldset>
        <?php for($i=0;$i<=4;$i++){?>
        <h4><?php _e('Slide', 'udhauli')?> <?php echo $i+1?></h4>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Title', 'udhauli'); ?> <?php echo $i+1?></div>
                <div class="form-controls"><input type="text" class="xlarge" name="title[<?php echo $i?>]" value="<?php echo $slider['title'][$i]?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Button Text', 'udhauli'); ?> <?php echo $i+1?></div>
                <div class="form-controls"><input type="text" class="xlarge" name="btn_text[<?php echo $i?>]" value="<?php echo $slider['button_text'][$i]?>" >
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Button url', 'udhauli'); ?> <?php echo $i+1?></div>
                <div class="form-controls"><input type="text" class="xlarge" name="btn_url[<?php echo $i?>]" value="<?php echo $slider['button_url'][$i]?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Paragraph text', 'udhauli'); ?> <?php echo $i+1?></div>
                <div class="form-controls">
                <textarea name="paragraph[<?php echo $i?>]"><?php echo $slider['paragraph'][$i]?></textarea>
                </div>
            </div>
            <div class="form-row">
                <input type="hidden" name='image[]' value="<?php echo $slider['image'][$i]?>">
                <div class="form-label"><?php _e('Slide image', 'udhauli'); ?> <?php echo $i+1?></div>
                <div class="form-controls">
                <input type="file" name="t_image[<?php echo $i?>]">
                    <?php if($slider['image'][$i]){?>
                        <img src="<?php echo osc_uploads_url().$slider['image'][$i]?>" style="width:100px;clear:both;display:block;margin-top:10px;">
                        <a href="<?php echo osc_admin_render_theme_url('oc-content/themes/udhauli/admin/slider.php?mdl-ctl-rm=true&remove-mdl-ctl-slider-image='.$i)?>"><?php _e('Remove image', 'udhauli')?></a>
                    <?php }?>
                </div>
            </div>
        </div>
        <?php }?>
    </fieldset>

    <fieldset>
        <div class="form-horizontal">
            <div class="form-actions">
                <input type="submit" value="<?php _e('Save changes', 'udhauli'); ?>" class="btn btn-submit">
            </div>
        </div>
    </fieldset>
</form>
