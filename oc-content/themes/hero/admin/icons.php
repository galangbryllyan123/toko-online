<?php
    /*
     *       Hero Responsive Osclass Themes
     *       
     *       Copyright (C) 2017 OSCLASS.me
     * 
     *       This is Hero Osclass Themes with Single License
     *  
     *       This program is a commercial software. Copying or distribution without a license is not allowed.
     *         
     *       If you need more licenses for this software. Please read more here <http://www.osclass.me/osclass-me-license/>.
     */
?>
<?php 
    $conn = getConnection(); 
    $categories = Category::newInstance()->toTreeAll();
 ?>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('admin/css/hero.css');?>">
<h2 class="render-title"><?php _e("Categories Icons", 'hero'); ?></h2>
    <div class="form-row">
	<div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e("Please visit", 'hero'); ?> <a style="color:red; text-decoration: none;" target="_blank" href="http://fontawesome.io/cheatsheet/"><?php _e("Font Awesome Icons.", 'hero'); ?></a> <?php _e("Just Copy and paste code images ex. home or heart.", 'hero'); ?></p>
        </div>
	</div>
<form id="categories-icons" action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#icon');?>" method="post" enctype="multipart/form-data" class="nocsrf">
    <input type="hidden" name="action_specific" value="categories_icons" />
	<fieldset>
		<div class="cats">
		 <?php foreach($categories as $c) { ?>
                <h3><strong><?php _e($c['s_name'], 'hero'); ?></strong>&nbsp;&nbsp;&nbsp;<i id="icon-<?php echo $c['pk_i_id'];?>" class="fa fa-<?php echo heros_category_icon( $c['pk_i_id'] ); ?>"></i></h3>
                <div class="inner">
					<div class="form-controls"><div class="sukses"><?php _e($c['s_name'], 'hero'); ?></div>
					<input type="text" class="xlarge kaya" name="cat-icons[<?php echo $c['pk_i_id']; ?>]" value="<?php echo osc_esc_html( osc_get_preference('cat-icons-'.$c['pk_i_id'], 'heros_theme_cat_icons') ); ?>" cat-id="<?php echo $c['pk_i_id'];?>" />
					&nbsp;&nbsp;&nbsp;<i id="icon-<?php echo $c['pk_i_id'];?>" class="fa fa-<?php echo heros_category_icon( $c['pk_i_id'] ); ?>"></i>
					</div>
					<?php if(!empty($c['categories'])) { ?>
						<?php foreach($c['categories'] as $cc) { ?>

							<div class="form-controls">
							<div class="sukses"><?php _e($cc['s_name'], 'hero'); ?></div><input type="text" class="xlarge kaya" name="cat-icons[<?php echo $cc['pk_i_id']; ?>]" value="<?php echo osc_esc_html( osc_get_preference('cat-icons-'.$cc['pk_i_id'], 'heros_theme_cat_icons') ); ?>" cat-id="<?php echo $cc['pk_i_id'];?>"  />
							&nbsp;&nbsp;&nbsp;<i id="icon-<?php echo $cc['pk_i_id'];?>" class="fa fa-<?php echo heros_category_icon( $cc['pk_i_id'] ); ?>"></i>
							</div>

						<?php } ?>
					<?php } ?>
				</div>			
		 <?php } ?>
		 </div>
			<div class="form-actions">
				<input id="button" type="submit" value="<?php echo osc_esc_html(__('Save Icons','hero')); ?>" class="btn btn-submit">
			</div>
		
	</fieldset>
</form>