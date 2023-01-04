<?php
  require_once 'functions.php';
  sofia_backoffice_menu(__('Settings', 'sofia'));
?>


<div class="mb-body">
  <div class="mb-info-box" style="margin:5px 0 30px 0;">
    <div class="mb-line"><strong><?php _e('Plugins for this theme', 'sofia'); ?></strong></div>
    <div class="mb-line"><?php _e('We have modified for you many plugins to fit theme design that will work without need of any modifications', 'sofia'); ?>.</div>
    <div class="mb-line"><?php _e('Plugins are not delivered in theme package, must be downloaded separately', 'sofia'); ?>.</div>
    <div class="mb-line" style="margin:10px 0;"><a href="https://osclasspoint.com/theme-plugins/sofia_plugins_20180307_JIpd2k.zip" target="_blank" class="mb-button-white"><i class="fa fa-download"></i> <?php _e('Download plugins', 'sofia'); ?></a></div>
    <div class="mb-line" style="margin-top:15px;">- <?php _e('upload and extract downloaded file <strong>sofia-plugins.zip</strong> into folder <strong>oc-content/plugins/</strong> on your hosting', 'sofia'); ?>.</div>
    <div class="mb-line">- <?php _e('go to <strong>oc-admin > Plugins</strong> and install plugins you like', 'sofia'); ?>.</div>
  </div>

  <!-- GENERAL -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-cog"></i> <?php _e('General settings', 'sofia'); ?></div>

    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/settings.php'); ?>" method="post">
      <input type="hidden" name="sofia_general" value="done" />

      <div class="mb-inside">
        <div class="mb-row">
          <label for="keyword_placeholder" class="h1"><span><?php _e('Search Placeholder', 'sofia'); ?></span></label> 
          <input size="40" name="keyword_placeholder" id="keyword_placeholder" type="text" value="<?php echo osc_esc_html( osc_get_preference('keyword_placeholder', 'sofia_theme') ); ?>" placeholder="<?php _e('Placeholder in search input', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="contact_email" class="h2"><span><?php _e('Contact Email', 'sofia'); ?></span></label> 
          <input size="40" name="contact_email" id="contact_email" type="text" value="<?php echo osc_esc_html( osc_get_preference('contact_email', 'sofia_theme') ); ?>" placeholder="<?php _e('Email in footer', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="footer_link"><span><?php _e('Link in Footer', 'sofia'); ?></span></label> 
          <input name="footer_link" id="footer_link" class="element-slide" type="checkbox" <?php echo (osc_get_preference('footer_link', 'sofia_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('When checked, link to Osclass will be shown in footer of your site', 'sofia'); ?></div>
        </div>
        
        <div class="mb-row">
          <label for="default_logo" class="h3"><span><?php _e('Use Default Logo', 'sofia'); ?></span></label> 
          <input name="default_logo" id="default_logo" class="element-slide" type="checkbox" <?php echo (osc_get_preference('default_logo', 'sofia_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Use default logo in case no other logo has been uploaded yet', 'sofia'); ?></div>
        </div> 
        
        <div class="mb-row">
          <label for="image_upload" class="h4"><span><?php _e('Use Drag & Drop Image Uploader', 'sofia'); ?></span></label> 
          <input name="image_upload" id="image_upload" class="element-slide" type="checkbox" <?php echo (osc_get_preference('image_upload', 'sofia_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('New drag & drop image uploader will be used instead of older one. Very suitable for mobile device.', 'sofia'); ?></div>
        </div>
        
        <div class="mb-row">
          <label for="facebook_link" class="h5"><span><?php _e('Facebook Share Link', 'sofia'); ?></span></label> 
          <input size="40" name="facebook_link" id="facebook_link" type="text" value="<?php echo osc_esc_html( osc_get_preference('facebook_link', 'sofia_theme') ); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="twitter_link" class="h5"><span><?php _e('Twitter Link', 'sofia'); ?></span></label> 
          <input size="40" name="twitter_link" id="twitter_link" type="text" value="<?php echo osc_esc_html( osc_get_preference('twitter_link', 'sofia_theme') ); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="google_link" class="h5"><span><?php _e('Google Plus Link', 'sofia'); ?></span></label> 
          <input size="40" name="google_link" id="google_link" type="text" value="<?php echo osc_esc_html( osc_get_preference('google_link', 'sofia_theme') ); ?>" />
        </div>
        
      </div>

      <div class="mb-foot">
        <button type="submit" class="mb-button"><?php _e('Save', 'sofia');?></button>
      </div>
    </form>
  </div>
  
  
  
  <!-- THEME LAYOUT -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-display"></i> <?php _e('Theme layout settings', 'sofia'); ?></div>

    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/settings.php'); ?>" method="post">
      <input type="hidden" name="sofia_layout" value="done" />

      <div class="mb-inside">
        
        <!-- General -->
        
        <div class="mb-line" style="padding-left:25%;margin-top:25px;"><span class="mb-u"><?php _e('Global layout settings', 'sofia'); ?></span></div>

        <div class="mb-row">
          <label for="bg_color" class="h99"><span><?php _e('Background Color', 'sofia'); ?></span></label> 
          <input size="40" name="bg_color" id="bg_color" type="text" value="<?php echo osc_esc_html( osc_get_preference('bg_color', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #FFFFFF', 'sofia'); ?>" />
        </div>
        
                
        <!-- Publish button -->
        <div class="mb-line" style="padding-left:25%;margin-top:25px;"><span class="mb-u"><?php _e('Publich button settings', 'sofia'); ?></span></div>
        
        <div class="mb-row">
          <label for="publish_bg_top" class="h99"><span><?php _e('Background Top Color', 'sofia'); ?></span></label> 
          <input size="40" name="publish_bg_top" id="publish_bg_top" type="text" value="<?php echo osc_esc_html( osc_get_preference('publish_bg_top', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #50B7D1', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="publish_bg_bottom" class="h99"><span><?php _e('Background Bottom Color', 'sofia'); ?></span></label> 
          <input size="40" name="publish_bg_bottom" id="publish_bg_bottom" type="text" value="<?php echo osc_esc_html( osc_get_preference('publish_bg_bottom', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #286DA3', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="publish_bg_hover_top" class="h99"><span><?php _e('Hover Background Top Color', 'sofia'); ?></span></label> 
          <input size="40" name="publish_bg_hover_top" id="publish_bg_hover_top" type="text" value="<?php echo osc_esc_html( osc_get_preference('publish_bg_hover_top', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #66C7E5', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="publish_bg_hover_bottom" class="h99"><span><?php _e('Hover Background Bottom Color', 'sofia'); ?></span></label> 
          <input size="40" name="publish_bg_hover_bottom" id="publish_bg_hover_bottom" type="text" value="<?php echo osc_esc_html( osc_get_preference('publish_bg_hover_bottom', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #328FC9', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="publish_color" class="h99"><span><?php _e('Text Color', 'sofia'); ?></span></label> 
          <input size="40" name="publish_color" id="publish_color" type="text" value="<?php echo osc_esc_html( osc_get_preference('publish_color', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #FFFFFF', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="publish_border" class="h99"><span><?php _e('Border Color', 'sofia'); ?></span></label> 
          <input size="40" name="publish_border" id="publish_border" type="text" value="<?php echo osc_esc_html( osc_get_preference('publish_border', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #51A0B3', 'sofia'); ?>" />
        </div>
        
        
        
        <!-- Search button -->

        <div class="mb-line" style="padding-left:25%;margin-top:25px;"><span class="mb-u"><?php _e('Search button settings', 'sofia'); ?></span></div>

        <div class="mb-row">
          <label for="search_bg_top" class="h99"><span><?php _e('Background Top Color', 'sofia'); ?></span></label> 
          <input size="40" name="search_bg_top" id="search_bg_top" type="text" value="<?php echo osc_esc_html( osc_get_preference('search_bg_top', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #5BC0DE', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="search_bg_bottom" class="h99"><span><?php _e('Background Bottom Color', 'sofia'); ?></span></label> 
          <input size="40" name="search_bg_bottom" id="search_bg_bottom" type="text" value="<?php echo osc_esc_html( osc_get_preference('search_bg_bottom', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #339BB9', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="search_color" class="h99"><span><?php _e('Text Color', 'sofia'); ?></span></label> 
          <input size="40" name="search_color" id="search_color" type="text" value="<?php echo osc_esc_html( osc_get_preference('search_color', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #FFFFFF', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="search_border" class="h99"><span><?php _e('Border Color', 'sofia'); ?></span></label> 
          <input size="40" name="search_border" id="search_border" type="text" value="<?php echo osc_esc_html( osc_get_preference('search_border', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #22687D', 'sofia'); ?>" />
        </div>
        
        
        
        <!-- Contact button -->
        
        <div class="mb-line" style="padding-left:25%;margin-top:25px;"><span class="mb-u"><?php _e('Contact & Send to friend button settings', 'sofia'); ?></span></div>

        <div class="mb-row">
          <label for="contact_bg_top" class="h99"><span><?php _e('Background Top Color', 'sofia'); ?></span></label> 
          <input size="40" name="contact_bg_top" id="contact_bg_top" type="text" value="<?php echo osc_esc_html( osc_get_preference('contact_bg_top', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #62C462', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="contact_bg_bottom" class="h99"><span><?php _e('Background Bottom Color', 'sofia'); ?></span></label> 
          <input size="40" name="contact_bg_bottom" id="contact_bg_bottom" type="text" value="<?php echo osc_esc_html( osc_get_preference('contact_bg_bottom', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #57A957', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="contact_color" class="h99"><span><?php _e('Text Color', 'sofia'); ?></span></label> 
          <input size="40" name="contact_color" id="contact_color" type="text" value="<?php echo osc_esc_html( osc_get_preference('contact_color', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #FFFFFF', 'sofia'); ?>" />
        </div>
        
        <div class="mb-row">
          <label for="contact_border" class="h99"><span><?php _e('Border Color', 'sofia'); ?></span></label> 
          <input size="40" name="contact_border" id="contact_border" type="text" value="<?php echo osc_esc_html( osc_get_preference('contact_border', 'sofia_theme') ); ?>" placeholder="<?php _e('Default: #3D773D', 'sofia'); ?>" />
        </div>
        
      </div>

      <div class="mb-foot">
        <button type="submit" class="mb-button"><?php _e('Save', 'sofia');?></button>
      </div>
    </form>
  </div>
  


  <!-- BANNERS -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-clone"></i> <?php _e('Banner settings', 'sofia'); ?></div>

    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/settings.php'); ?>" method="post">
      <input type="hidden" name="sofia_banner" value="done" />

      <div class="mb-inside">
        <div class="mb-row">
          <label for="theme_adsense" class="h11"><span><?php _e('Enable Google Adsense Banners', 'sofia'); ?></span></label> 
          <input name="theme_adsense" id="theme_adsense" class="element-slide" type="checkbox" <?php echo (osc_get_preference('theme_adsense', 'sofia_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('When enabled, bellow banners will be shown in front page.', 'sofia'); ?></div>
        </div>
        
        <div class="mb-row">
          <label for="banner_home" class="h12"><span><?php _e('Home Page Banner Code', 'sofia'); ?></span></label> 
          <textarea class="mb-textarea mb-textarea-large mb-text-code" name="banner_home" placeholder="<?php _e('Will be shown at bottom of home page, recommended is responsive banner with width 1200px', 'sofia'); ?>"><?php echo stripslashes( osc_get_preference('banner_home', 'sofia_theme') ); ?></textarea>
        </div>
        
        <div class="mb-row">
          <label for="banner_search" class="h13"><span><?php _e('Search Page Banner Code', 'sofia'); ?></span></label> 
          <textarea class="mb-textarea mb-textarea-large mb-text-code" name="banner_search" placeholder="<?php _e('Will be shown in left sidebar on search page, recommended is responsive banner with width 270px', 'sofia'); ?>"><?php echo stripslashes( osc_get_preference('banner_search', 'sofia_theme') ); ?></textarea>
        </div>   

        <div class="mb-row">
          <label for="banner_item" class="h14"><span><?php _e('Home Page Banner Code', 'sofia'); ?></span></label> 
          <textarea class="mb-textarea mb-textarea-large mb-text-code" name="banner_item" placeholder="<?php _e('Will be shown in right sidebar on item page, recommended is responsive banner with width 360px', 'sofia'); ?>"><?php echo stripslashes( osc_get_preference('banner_item', 'sofia_theme') ); ?></textarea>
        </div>
      </div>

      <div class="mb-foot">
        <button type="submit" class="mb-button"><?php _e('Save', 'sofia');?></button>
      </div>
    </form>
  </div>




  <!-- HELP TOPICS -->
  <div class="mb-box" id="mb-help">
    <div class="mb-head"><i class="fa fa-question-circle"></i> <?php _e('Help', 'sofia'); ?></div>

    <div class="mb-inside">
      <div class="mb-row mb-help"><span class="sup">(1)</span> <div class="h1"><?php _e('Text that will be shown as placeholder in search box in header. Can be i.e. "Samsung Galaxy S7..."', 'sofia'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(2)</span> <div class="h2"><?php _e('Leave blank to disable contact email. This email will be shown in theme footer.', 'sofia'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(3)</span> <div class="h3"><?php _e('Check to use default logo of osclass in case, you did not upload any other logo yet. Otherwise simple text with name of your classifieds will be shown instead of logo.', 'sofia'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(4)</span> <div class="h4"><?php _e('Use new Drag & Drop image uploader instead old one. Note that it is required to have osclass version 3.3 or higher.', 'sofia'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(5)</span> <div class="h5"><?php _e('Share links will be shown in footer of theme.', 'sofia'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(10)</span> <div class="h10"><?php _e('When set to Yes, facebook like button with counter will be shown next to Publish button in header.', 'sofia'); ?></div></div>

      <div class="mb-row mb-help"><span class="sup">(11)</span> <div class="h11"><?php _e('Check if you want to enable Google Adsense banners on your site. You can define code for banner in bellow boxes.', 'sofia'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(12)</span> <div class="h12"><?php _e('Will be shown at bottom of home page, recommended is responsive banner with width 1200px.', 'sofia'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(13)</span> <div class="h13"><?php _e('Will be shown in left sidebar on search/category page, recommended is responsive banner with width 270px.', 'sofia'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(14)</span> <div class="h14"><?php _e('Will be shown in right sidebar on listings page, recommended is responsive banner with width 360px.', 'sofia'); ?></div></div>


      <div class="mb-row mb-help"><span class="sup">*</span> <div class="h99"><?php _e('Leave blank to use default values. In each section fill all or no values. If you fill just one and other leave blank, it can break design. Use full color codes, i.e. #000000 (not #000).', 'sofia'); ?></div></div>
    </div>
  </div>
</div>

<?php echo sofia_footer(); ?>