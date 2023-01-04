<?php
  require_once 'functions.php';
  tatiana_backoffice_menu(__('Settings', 'tatiana'));
?>

<?php
// MANAGE IMAGES
if(Params::getParam('tatiana_images') == 'done') { 
  $upload_dir_small = osc_themes_path() . 'tatiana/images/small_cat/';
  $upload_dir_large = osc_themes_path() . 'tatiana/images/large_cat/';

  if (!file_exists($upload_dir_small)) { mkdir($upload_dir_small, 0777, true); }
  if (!file_exists($upload_dir_large)) { mkdir($upload_dir_large, 0777, true); }

  $count_real = 0;
  for ($i=1; $i<=1000; $i++) {
    if(isset($_POST['fa-icon' .$i])) {
      $fields['fields'] = array('s_icon' => Params::getParam('fa-icon' .$i));
      $fields['aFieldsDescription'] = array();
      Category::newInstance()->updateByPrimaryKey($fields, $i);
      message_ok(__('Font Awesome icon successfully saved for category' . ' <strong>#' . $i . '</strong>' ,'tatiana'));
    }

    if(isset($_FILES['small' .$i]) and $_FILES['small' .$i]['name'] <> ''){

      $file_ext   = strtolower(end(explode('.', $_FILES['small' .$i]['name'])));
      $file_name  = $i . '.' . $file_ext;
      $file_tmp   = $_FILES['small' .$i]['tmp_name'];
      $file_type  = $_FILES['small' .$i]['type'];   
      $extensions = array("png");

      if(in_array($file_ext,$extensions )=== false) {
        $errors = __('extension not allowed, only allowed extension is .png!','tatiana');
      } 
				
      if(empty($errors)==true){
        move_uploaded_file($file_tmp, $upload_dir_small.$file_name);
        message_ok(__('Small image #','tatiana') . $i . __(' uploaded successfully.','tatiana'));
        $count_real++;
      } else {
        message_error(__('There was error when uploading small image #','tatiana') . $i . ': ' .$errors);
      }
    }
  }

  $count_real = 0;
  for ($i=1; $i<=1000; $i++) {
    if(isset($_FILES['large' .$i]) and $_FILES['large' .$i]['name'] <> ''){
      $file_ext   = strtolower(end(explode('.', $_FILES['large' .$i]['name'])));
      $file_name  = $i . '.' . $file_ext;
      $file_tmp   = $_FILES['large' .$i]['tmp_name'];
      $file_type  = $_FILES['large' .$i]['type'];   
      $extensions = array("png");

      if(in_array($file_ext,$extensions )=== false) {
        $errors = __('extension not allowed, only allowed extension for large images is .png!','tatiana');
      }
				
      if(empty($errors)==true){
        move_uploaded_file($file_tmp, $upload_dir_large.$file_name);
        message_ok(__('Large image #','tatiana') . $i . __(' uploaded successfully.','tatiana'));
        $count_real++;
      } else {
        message_error(__('There was error when uploading large image #','tatiana') . $i . ': ' .$errors);
      }
    }
  }
}
?>



<div class="mb-body">
  <div class="mb-info-box" style="margin:5px 0 30px 0;">
    <div class="mb-line"><strong><?php _e('Plugins for this theme', 'tatiana'); ?></strong></div>
    <div class="mb-line"><?php _e('We have modified for you many plugins to fit theme design that will work without need of any modifications', 'tatiana'); ?>.</div>
    <div class="mb-line"><?php _e('Plugins are not delivered in theme package, must be downloaded separately', 'tatiana'); ?>.</div>
    <div class="mb-line" style="margin:10px 0;"><a href="https://osclasspoint.com/theme-plugins/tatiana_plugins_20180307_akP89s.zip" target="_blank" class="mb-button-white"><i class="fa fa-download"></i> <?php _e('Download plugins', 'tatiana'); ?></a></div>
    <div class="mb-line" style="margin-top:15px;">- <?php _e('upload and extract downloaded file <strong>tatiana-plugins.zip</strong> into folder <strong>oc-content/plugins/</strong> on your hosting', 'tatiana'); ?>.</div>
    <div class="mb-line">- <?php _e('go to <strong>oc-admin > Plugins</strong> and install plugins you like', 'tatiana'); ?>.</div>
  </div>


  <!-- GENERAL -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-cog"></i> <?php _e('General settings', 'tatiana'); ?></div>

    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/settings.php'); ?>" method="post">
      <input type="hidden" name="tatiana_general" value="done" />

      <div class="mb-inside">
        <div class="mb-row">
          <label for="keyword_placeholder" class="h1"><span><?php _e('Search Placeholder', 'tatiana'); ?></span></label> 
          <input size="40" name="keyword_placeholder" id="keyword_placeholder" type="text" value="<?php echo osc_esc_html( osc_get_preference('keyword_placeholder', 'tatiana_theme') ); ?>" placeholder="<?php _e('Placeholder in search input', 'tatiana'); ?>" />
        </div>
 
        <div class="mb-row">
          <label for="phone" class="h2"><span><?php _e('Contact Phone', 'tatiana'); ?></span></label> 
          <input size="40" name="phone" id="phone" type="text" value="<?php echo osc_esc_html( osc_get_preference('phone', 'tatiana_theme') ); ?>" placeholder="<?php _e('Phone number shown in header', 'tatiana'); ?>" />
        </div>

        <div class="mb-row">
          <label for="contact_email" class="h4"><span><?php _e('Contact Email', 'tatiana'); ?></span></label> 
          <input size="40" name="contact_email" id="contact_email" type="text" value="<?php echo osc_esc_html( osc_get_preference('contact_email', 'tatiana_theme') ); ?>" placeholder="<?php _e('Email in footer', 'tatiana'); ?>" />
        </div>
 
        <div class="mb-row">
          <label for="def_cur" class="h3"><span><?php _e('Default Currency in Search Box', 'tatiana'); ?></span></label> 
          <select name="def_cur" id="def_cur">
            <?php foreach(osc_get_currencies() as $c) { ?>
              <option value="<?php echo $c['s_description']; ?>" <?php echo (osc_get_preference('def_cur', 'tatiana_theme') == $c['s_description'] ? 'selected="selected"' : ''); ?>><?php echo $c['s_description']; ?></option>
            <?php } ?>
          </select>

          <div class="mb-explain"><?php _e('Currency symbol shown in search box in price field', 'tatiana'); ?></div>
        </div>
  
        <div class="mb-row">
          <label for="footer_link"><span><?php _e('Link in Footer', 'tatiana'); ?></span></label> 
          <input name="footer_link" id="footer_link" class="element-slide" type="checkbox" <?php echo (osc_get_preference('footer_link', 'tatiana_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('When checked, link to Osclass will be shown in footer of your site', 'tatiana'); ?></div>
        </div>
  
        <div class="mb-row">
          <label for="default_logo" class="h5"><span><?php _e('Use Default Logo', 'tatiana'); ?></span></label> 
          <input name="default_logo" id="default_logo" class="element-slide" type="checkbox" <?php echo (osc_get_preference('default_logo', 'tatiana_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Use default logo in case no other logo has been uploaded yet', 'tatiana'); ?></div>
        </div> 
               
        <div class="mb-row">
          <label for="new_cat_list" class="h6"><span><?php _e('Use Newer Category List', 'tatiana'); ?></span></label> 
          <input name="new_cat_list" id="new_cat_list" class="element-slide" type="checkbox" <?php echo (osc_get_preference('new_cat_list', 'tatiana_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('More modern type of category list will be used to show categories on home page', 'tatiana'); ?></div>
        </div>
               
        <div class="mb-row">
          <label for="refine_cat" class="h7"><span><?php _e('Refine Categories', 'tatiana'); ?></span></label> 
          <input name="refine_cat" id="refine_cat" class="element-slide" type="checkbox" <?php echo (osc_get_preference('refine_cat', 'tatiana_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('When enabled, categories on search page are refined and shown only sub-categories of current category', 'tatiana'); ?></div>
        </div>
         
        <div class="mb-row">
          <label for="image_upload" class="h8"><span><?php _e('Use Drag & Drop Image Uploader', 'tatiana'); ?></span></label> 
          <input name="image_upload" id="image_upload" class="element-slide" type="checkbox" <?php echo (osc_get_preference('image_upload', 'tatiana_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('New drag & drop image uploader will be used instead of older one. Very suitable for mobile device.', 'tatiana'); ?></div>
        </div>
              
        <div class="mb-row">
          <label for="locations_empty" class="h9"><span><?php _e('Include Empty Locations', 'tatiana'); ?></span></label> 
          <input name="locations_empty" id="locations_empty" class="element-slide" type="checkbox" <?php echo (osc_get_preference('locations_empty', 'tatiana_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Check to show also Countries, Regions & Cities, that does not contain any listing', 'tatiana'); ?></div>
        </div>
 
        <div class="mb-row">
          <label for="allow_fb" class="h10"><span><?php _e('Show Facebook Like Button', 'tatiana'); ?></span></label> 
          <input name="allow_fb" id="allow_fb" class="element-slide" type="checkbox" <?php echo (osc_get_preference('allow_fb', 'tatiana_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Button will be shown next to Publish button in header', 'tatiana'); ?></div>
        </div> 
  
      </div>

      <div class="mb-foot">
        <button type="submit" class="mb-button"><?php _e('Save', 'tatiana');?></button>
      </div>
    </form>
  </div>


  <!-- BANNERS -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-clone"></i> <?php _e('Banner settings', 'tatiana'); ?></div>

    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/settings.php'); ?>" method="post">
      <input type="hidden" name="tatiana_banner" value="done" />

      <div class="mb-inside">
        <div class="mb-row">
          <label for="theme_adsense" class="h11"><span><?php _e('Enable Google Adsense Banners', 'tatiana'); ?></span></label> 
          <input name="theme_adsense" id="theme_adsense" class="element-slide" type="checkbox" <?php echo (osc_get_preference('theme_adsense', 'tatiana_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('When enabled, bellow banners will be shown in front page.', 'tatiana'); ?></div>
        </div>
        
        <div class="mb-row">
          <label for="banner_home" class="h12"><span><?php _e('Home Page Banner Code', 'tatiana'); ?></span></label> 
          <textarea class="mb-textarea mb-textarea-large mb-text-code" name="banner_home" placeholder="<?php _e('Will be shown at bottom of home page, recommended is responsive banner with width 1200px', 'tatiana'); ?>"><?php echo stripslashes( osc_get_preference('banner_home', 'tatiana_theme') ); ?></textarea>
        </div>
        
        <div class="mb-row">
          <label for="banner_search" class="h13"><span><?php _e('Search Page Banner Code', 'tatiana'); ?></span></label> 
          <textarea class="mb-textarea mb-textarea-large mb-text-code" name="banner_search" placeholder="<?php _e('Will be shown in left sidebar on search page, recommended is responsive banner with width 270px', 'tatiana'); ?>"><?php echo stripslashes( osc_get_preference('banner_search', 'tatiana_theme') ); ?></textarea>
        </div>   

        <div class="mb-row">
          <label for="banner_item" class="h14"><span><?php _e('Home Page Banner Code', 'tatiana'); ?></span></label> 
          <textarea class="mb-textarea mb-textarea-large mb-text-code" name="banner_item" placeholder="<?php _e('Will be shown in right sidebar on item page, recommended is responsive banner with width 360px', 'tatiana'); ?>"><?php echo stripslashes( osc_get_preference('banner_item', 'tatiana_theme') ); ?></textarea>
        </div>
      </div>

      <div class="mb-foot">
        <button type="submit" class="mb-button"><?php _e('Save', 'tatiana');?></button>
      </div>
    </form>
  </div>


  <!-- CATEGORY ICONS -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-photo"></i> <?php _e('Category icons settings', 'tatiana'); ?></div>

    <form name="promo_form" id="load_image" action="<?php echo osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/settings.php'); ?>" method="POST" enctype="multipart/form-data" >
      <input type="hidden" name="tatiana_images" value="done" />

      <div class="mb-inside">
        <div class="mb-table">
          <div class="mb-table-head">
            <div class="mb-col-1_2 id"><?php _e('ID', 'tatiana'); ?></div>
            <div class="mb-col-3 mb-align-left name"><?php _e('Name', 'tatiana'); ?></div>
            <div class="mb-col-1 mb-no-pad icon"><?php _e('Has small image', 'tatiana'); ?></div>
            <div class="mb-col-3"><?php _e('Small image (50x30px - png)', 'tatiana'); ?></div>
            <div class="mb-col-1_1_2 mb-no-pad icon"><?php _e('Has large image', 'tatiana'); ?></div>
            <div class="mb-col-3"><?php _e('Large image (60x50px - png)', 'tatiana'); ?></div>
            <!--<div class="mb-col-1_1_2 fa-icon"><a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank"><?php _e('Font-Awesome icon', 'tatiana'); ?></a></div>-->
          </div>

          <?php tatiana_has_subcategories_special(Category::newInstance()->toTree(), 0); ?> 
        </div>
      </div>

      <div class="mb-foot">
        <button type="submit" class="mb-button"><?php _e('Save', 'tatiana');?></button>
      </div>
    </form>
  </div>



  <!-- HELP TOPICS -->
  <div class="mb-box" id="mb-help">
    <div class="mb-head"><i class="fa fa-question-circle"></i> <?php _e('Help', 'tatiana'); ?></div>

    <div class="mb-inside">
      <div class="mb-row mb-help"><span class="sup">(1)</span> <div class="h1"><?php _e('Text that will be shown as placeholder in search box in header. Can be i.e. "Samsung Galaxy S7..."', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(2)</span> <div class="h2"><?php _e('Leave blank to disable contact number. This number will be shown in theme header.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(3)</span> <div class="h3"><?php _e('Choose which currency you want to show in search menu on category/search page.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(4)</span> <div class="h4"><?php _e('Leave blank to disable contact email. This email will be shown in theme footer.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(5)</span> <div class="h5"><?php _e('Check to use default logo of osclass in case, you did not upload any other logo yet. Otherwise simple text with name of your classifieds will be shown instead of logo.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(6)</span> <div class="h6"><?php _e('Enable to use newer category list on homepage. You can also disable this to use older one, that looks cool as well.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(7)</span> <div class="h7"><?php _e('Refine categories on category page (list in left sidebar). When checked, only current category and it\' subcategories will be shown. Otherwise all categories are shown.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(8)</span> <div class="h8"><?php _e('Use new Drag & Drop image uploader instead old one. Note that it is required to have osclass version 3.3 or higher.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(9)</span> <div class="h9"><?php _e('Set to Yes to show countries, regions and cities that does not contains any listings. It is not recommended to showin empty locations as this may cause user to leave your web.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(10)</span> <div class="h10"><?php _e('When set to Yes, facebook like button with counter will be shown next to Publish button in header.', 'tatiana'); ?></div></div>

      <div class="mb-row mb-help"><span class="sup">(11)</span> <div class="h11"><?php _e('Check if you want to enable Google Adsense banners on your site. You can define code for banner in bellow boxes.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(12)</span> <div class="h12"><?php _e('Will be shown at bottom of home page, recommended is responsive banner with width 1200px.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(13)</span> <div class="h13"><?php _e('Will be shown in left sidebar on search/category page, recommended is responsive banner with width 270px.', 'tatiana'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(14)</span> <div class="h14"><?php _e('Will be shown in right sidebar on listings page, recommended is responsive banner with width 360px.', 'tatiana'); ?></div></div>
    </div>
  </div>
</div>

<?php echo tatiana_footer(); ?>