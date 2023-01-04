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
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('admin/css/hero.css');?>">
<?php
function hero_images($category_hero, $deep = 0) {
  foreach($category_hero as $c) { 
    echo '<div' . ($deep == 0 ? ' class="primary"' : '') . '>';
  echo '<div' . ($deep == 1 ? ' class="cate"' : '') . '>';
  echo '<div' . ($deep == 2 ? ' class="cate2"' : '') . '>';
  echo '<div' . ($deep == 3 ? ' class="cate3"' : '') . '>';
       echo '<div class="sub' . $deep . ' name">' . $c['s_name'] .'</div>';
    if (file_exists(osc_themes_path() . 'hero/images/categorys/' . $c['pk_i_id'] . '.png')) {
    echo '<div class="image_show"><img style="height:200px; width:200px;" src="' . osc_base_url() . 'oc-content/themes/hero/images/categorys/' . $c['pk_i_id'] . '.png" alt="Exista" /></div>';

    ?>
   <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/images.php'); ?>" method="post" enctype="multipart/form-data">
     <input type="hidden" name="action_specific" value="remove_category" />
     <input type="hidden" value="<?php echo $c['pk_i_id']; ?>" name="id_remove"/>    
      <button type="submit" id="delete_image_bt" class="btn btn-red"><?php echo osc_esc_html(__('Remove','hero')); ?></button>     
    </form>
   <?php   
    } else { 
   ?>
   <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/images.php'); ?>" method="post" enctype="multipart/form-data">
      <input type="hidden" name="action_specific" value="up_category" />
      <input class="add_image" type="file" name="set_image" id="package" />
     <input type="hidden" value="<?php echo $c['pk_i_id']; ?>" name="id_category"/>    
      <div class="save"><input id="button_save" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" class="btn btn-submit"></div>      
    </form>
   <?php
    } 
  echo '</div>';
  echo '</div>';
   echo '</div>';
   echo '</div>';  
    if(isset($c['categories']) && is_array($c['categories']) && !empty($c['categories'])) {
      hero_images($c['categories'], $deep+1);
    }
  }
}

?>
<form name="promo_form" id="load_image" action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/images.php'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action_specific" value="hero_images" />
    <fieldset>
        <div class="form-horizontal in">
            <div class="headerz">
                <h2 class="render-title"><?php _e("Category Images", 'hero'); ?></h2>
                <p>
                    <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
            </div>
            <div class="body2">
                <?php echo hero_images(Category::newInstance()->toTree(), 0); ?> </div>
        </div>
    </fieldset>
</form>