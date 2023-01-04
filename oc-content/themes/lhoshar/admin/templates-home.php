<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<h2 class="render-title">
  <?php _e('Home page settings', 'lhoshar'); ?>
</h2>
<?php $slider_option = osc_get_preference('slider_option', 'lhoshar') ; ?>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/lhoshar/admin/settings.php'); ?>" method="post" class="nocsrf">
  <input type="hidden" name="action_specific" value="templates_home" />
  <fieldset>
    <div class="form-horizontal">
      <div class="form-row">
        <div class="form-label">
          <?php _e('Show Banner/Slider', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <select name="defaultShowAs@home">
            <option value="banner" <?php if((lhoshar_default_show_as_home()) == 'banner'){ echo 'selected="selected"'; } ?>>
              <?php echo osc_esc_html(__('Banner','lhoshar')); ?>
            </option>
            <option value="slider" <?php if((lhoshar_default_show_as_home()) == 'slider'){ echo 'selected="selected"'; } ?>>
              <?php echo osc_esc_html(__('Slider','lhoshar')); ?>
            </option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-label">
          <?php _e('Image Slider Option', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <select name="slider_option">
            <option value="slide" <?php if( $slider_option == 'slide'){ echo 'selected="selected"'; } ?>>
              <?php echo osc_esc_html(__('Slide','lhoshar')); ?>
            </option>
            <option value="fade" <?php if( $slider_option == 'fade'){ echo 'selected="selected"'; } ?>>
              <?php echo osc_esc_html(__('Fade','lhoshar')); ?>
            </option>
          </select>
        </div>
      </div> 
      <div class="form-row">
        <div class="form-label">
          <?php _e('Search placeholder', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <input type="text" class="xlarge" name="keyword_placeholder" value="<?php echo osc_esc_html( osc_get_preference('keyword_placeholder', 'lhoshar') ); ?>" maxlength="30" >
        </div>
      </div>
      <div class="form-row">
        <div class="form-label">
          <?php _e('Search country option', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <div class="form-label-checkbox">
            <input type="checkbox" class="switch" name="show_search_country" value="1" <?php echo (osc_esc_html( osc_get_preference('show_search_country', 'lhoshar') ) == "1")? "checked": ""; ?>>
          </div>
        </div>
      </div>
	  
      <div class="form-row">
        <div class="form-label">
          <?php _e('Premium listings shown', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <input type="number" min="1" max="50" class="xlarge" name="premium_listings_shown_home" value="<?php echo osc_esc_html( osc_get_preference('premium_listings_shown_home', 'lhoshar') ); ?>">
        </div>
      </div>
      <div class="form-row">
        <div class="form-label">
          <?php _e('Subcategories limit ', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <input type="number" min="1" max="100" class="xlarge" name="sub_cat_limit" value="<?php echo osc_esc_html( osc_get_preference('sub_cat_limit', 'lhoshar') ); ?>">
        </div>
      </div>
	   <div class="form-row">
        <div class="form-label">
          <?php _e('Show popular', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <div class="form-label-checkbox">
            <input type="checkbox" name="show_popular" value="1" <?php echo ( osc_esc_html( osc_get_preference('show_popular', 'lhoshar') ) == "1")? "checked": ""; ?>>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-label">
          <?php _e('Popular searches', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <div class="form-label-checkbox">
            <input type="checkbox" name="show_popular_searches" value="1" <?php echo ( osc_esc_html( osc_get_preference('show_popular_searches', 'lhoshar') ) == "1")? "checked": ""; ?>>
          </div>
        </div>
      </div>
	   <div class="form-row">
        <div class="form-label">
          <?php _e('Popular regions', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <div class="form-label-checkbox">
            <input type="checkbox" name="show_popular_regions" value="1" <?php echo ( osc_esc_html( osc_get_preference('show_popular_regions', 'lhoshar') ) == "1")? "checked": ""; ?>>
          </div>
        </div>
      </div>
	        <div class="form-row">
        <div class="form-label">
          <?php _e('Popular cities', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <div class="form-label-checkbox">
            <input type="checkbox" name="show_popular_cities" value="1" <?php echo ( osc_esc_html( osc_get_preference('show_popular_cities', 'lhoshar') ) == "1")? "checked": ""; ?>>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-label">
          <?php _e('Popular searches limit', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <input type="number" min="1" max="100" name="popular_searches_limit" value="<?php echo osc_esc_html( osc_get_preference('popular_searches_limit', 'lhoshar') ); ?>">
        </div>
      </div>

      <div class="form-row">
        <div class="form-label">
          <?php _e('Popular regions limit', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <input type="number" min="1" max="100" name="popular_regions_limit" value="<?php echo osc_esc_html( osc_get_preference('popular_regions_limit', 'lhoshar') ); ?>">
        </div>
      </div>

      <div class="form-row">
        <div class="form-label">
          <?php _e('Popular cities limit', 'lhoshar'); ?>
        </div>
        <div class="form-controls">
          <input type="number" min="1" max="100" name="popular_cities_limit" value="<?php echo osc_esc_html( osc_get_preference('popular_cities_limit', 'lhoshar') ); ?>">
        </div>
      </div>
    </div>
  </fieldset>
  <div class="form-actions">
    <input type="submit" value="<?php echo osc_esc_html(__('Save changes', 'lhoshar')); ?>" class="btn btn-submit">
  </div>
</form>
