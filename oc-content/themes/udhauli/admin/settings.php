<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('admin/css/jquery.switchButton.css');?>">
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('admin/css/admin.main.css');?>">

<div class="credit-osclasswizards log_main_head"> <a href="http://www.osclasswizards.com/" target="_blank" class="wizard_logo"> <img src="<?php echo osc_current_web_theme_url('admin/img/logo.png');?>" alt="Premium osclass themes" title="Premium osclass themes" /> </a>
  <div class="follow">
    <ul>
      <li>Follow us:</li>
      <li><a href="https://www.facebook.com/osclasswizards" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
      <li><a href="https://twitter.com/osclasswizards" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a></li>
      <li><a href="https://plus.google.com/112391938966018193484" target="_blank" title="google plus"><i class="fa fa-google-plus"></i></a></li>
    </ul>
  </div>
  <div class="donate">
    <form name="_xclick" action="https://www.paypal.com/in/cgi-bin/webscr" method="post" class="nocsrf">
      <input type="hidden" name="cmd" value="_donations">
      <input type="hidden" name="business" value="webgig.sagar@gmail.com">
      <input type="hidden" name="item_name" value="OsclassWizards Theme">
      <input type="hidden" name="currency_code" value="USD">
      <input type="hidden" name="lc" value="US" />
      <div id="flashmessage" >
        <p>
          <select name="amount" class="select-box-medium">
            <option value="10" selected>10$</option>
            <option value="5">5$</option>
            <option value="">
            <?php _e('Custom', 'udhauli'); ?>
            </option>
          </select>
          <input type="submit" class="btn btn-mini" name="submit" value="<?php echo osc_esc_html(__('Donate', 'udhauli')); ?>">
        </p>
      </div>
    </form>
  </div>
</div>
<div id="tabs" class="wizards_tab wiz_main_tabs">
  <ul>
    <li><a href="#general"><?php _e('General','udhauli');?></a></li>
    <li><a href="#theme-style"><?php _e('Theme Style','udhauli');?></a></li>
    <li><a href="#templates"><?php _e('Templates','udhauli');?></a></li>
    <li><a href="#logo"><?php _e('Header Logo','udhauli');?></a></li>
    <li><a href="#favicon"><?php _e('Favicon','udhauli');?></a></li>
    <li><a href="#banner"><?php _e('Banner','udhauli');?></a></li>
    <li><a href="#slider"><?php _e('Image Slider','udhauli');?></a></li>
    <li><a href="#category"><?php _e('Category Icons','udhauli');?></a></li>
    <li><a href="#ads"><?php _e('Ads Management','udhauli');?></a></li>
    <li><a href="#social"><?php _e('Social Links','udhauli');?></a></li>    
    <!-- <li><a href="#documentation"><?php //_e('Documentation','udhauli');?></a></li> -->
  </ul>
  <div id="general">
    <h2 class="render-title">
      <?php _e('Theme settings', 'udhauli'); ?>
    </h2>
    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/udhauli/admin/settings.php'); ?>" method="post" class="nocsrf">
      <input type="hidden" name="action_specific" value="settings" />
      <fieldset>
        <div class="form-horizontal">
          <div class="form-row">
            <div class="form-label">
              <?php _e('Contact Number', 'udhauli'); ?>
            </div>
            <div class="form-controls">
              <input type="text" class="xlarge" name="contact_numbr" value="<?php echo osc_esc_html( osc_get_preference('contact_numbr', 'udhauli') ); ?>" maxlength="30" >
            </div>
          </div>
          <div class="form-row">
            <div class="form-label">
              <?php _e('Contact E-mail', 'udhauli'); ?>
            </div>
            <div class="form-controls">
              <input type="text" class="xlarge" name="contact_email" value="<?php echo osc_esc_html( osc_get_preference('contact_email', 'udhauli') ); ?>" >
            </div>
          </div>
		    <div class="form-row">
            <div class="form-label">
              <?php _e('Footer message', 'udhauli'); ?>
            </div>
            <div class="form-controls">
              <textarea style="height: 50px; width: 500px;" name="footer_message"><?php echo  (osc_get_preference('footer_message', 'udhauli')) ; ?></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-label">
              <?php _e('Show lists as', 'udhauli'); ?>
            </div>
            <div class="form-controls">
              <select name="defaultShowAs@all">
                <option value="gallery" <?php if((udhauli_default_show_as()) == 'gallery'){ echo 'selected="selected"'; } ?>>
                <?php echo osc_esc_html(__('Grid','udhauli')); ?>
                </option>
                <option value="list" <?php if((udhauli_default_show_as()) == 'list'){ echo 'selected="selected"'; } ?>>
                <?php echo osc_esc_html(__('List','udhauli')); ?>
                </option>
              </select>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('To the Top', 'udhauli'); ?></div>
                <div class="form-controls">
                <div class="form-label-checkbox">
                  <input type="checkbox" name="to_the_top" value="1" <?php echo (osc_esc_html( osc_get_preference('to_the_top', 'udhauli') ) == "1")? "checked": ""; ?>>
                  <br>
                  <div class="help-box"><?php _e('Move to the top.', 'udhauli'); ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </fieldset>
      <div class="form-actions">
        <input type="submit" value="<?php echo osc_esc_html(__('Save changes', 'udhauli')); ?>" class="btn btn-submit btn-success">
      </div>
    </form>
  </div>
  <div id="theme-style">
    <?php include 'theme-style.php'; ?>
  </div>
  <div id="templates">
    <?php include 'templates.php'; ?>
  </div>
  <div id="logo">
    <?php include 'header.php'; ?>
  </div>
  <div id="favicon">
    <?php include 'favicon.php'; ?>
  </div>
  <div id="banner">
    <?php include 'homeimage.php'; ?>
  </div>
  <div id="slider">
    <?php include 'slider.php'; ?>
  </div>
  <div id="category">
    <?php include 'category.php'; ?>
  </div>
  <div id="ads">
    <?php include 'ads.php'; ?>
  </div> 
  <!-- <div id="documentation">
    <?php //include 'documentation.php'; ?>
  </div> -->
  <div id="social">
    <?php include 'social.php'; ?>
  </div> 
  <address class="wizards_address">
	<span>&copy; 2015 <a target="_blank" title="osclasswizards" href="http://www.osclasswizards.com/">OsclassWizards</a>. All rights reserved.</span>
  </p>
  </address>
</div>
<script src="<?php echo osc_current_web_theme_url('admin/js/jquery.switchButton.js');?>"></script>
<script src="<?php echo osc_current_web_theme_url('admin/js/jquery.admin.js');?>"></script>
