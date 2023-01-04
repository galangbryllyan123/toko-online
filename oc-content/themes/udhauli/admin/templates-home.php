<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<h2 class="render-title">
  <?php _e('Home page settings', 'udhauli'); ?>
</h2>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/udhauli/admin/settings.php'); ?>" method="post" class="nocsrf">
  <input type="hidden" name="action_specific" value="templates_home" />
  <fieldset>
    <div class="form-horizontal">
      <div class="form-row">
        <div class="form-label">
          <?php _e('Show Banner/Slider', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <select name="defaultShowAs@home">
            <option value="banner" <?php if((udhauli_default_show_as_home()) == 'banner'){ echo 'selected="selected"'; } ?>>
              <?php echo osc_esc_html(__('Banner','udhauli')); ?>
            </option>
            <option value="slider" <?php if((udhauli_default_show_as_home()) == 'slider'){ echo 'selected="selected"'; } ?>>
              <?php echo osc_esc_html(__('Slider','udhauli')); ?>
            </option>
          </select>
        </div>
      </div> 
      <div class="form-row">
        <div class="form-label">
          <?php _e('Search placeholder', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <input type="text" class="xlarge" name="keyword_placeholder" value="<?php echo osc_esc_html( osc_get_preference('keyword_placeholder', 'udhauli') ); ?>" maxlength="30" >
        </div>
      </div>
      <div class="form-row">
        <div class="form-label">
          <?php _e('Search country option', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <div class="form-label-checkbox">
            <input type="checkbox" class="switch" name="show_search_country" value="1" <?php echo (osc_esc_html( osc_get_preference('show_search_country', 'udhauli') ) == "1")? "checked": ""; ?>>
          </div>
        </div>
      </div>
	  
      <div class="form-row">
        <div class="form-label">
          <?php _e('Premium listings shown', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <input type="number" min="1" max="50" class="xlarge" name="premium_listings_shown_home" value="<?php echo osc_esc_html( osc_get_preference('premium_listings_shown_home', 'udhauli') ); ?>">
        </div>
      </div>
      <div class="form-row">
        <div class="form-label">
          <?php _e('Subcategories limit ', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <input type="number" min="1" max="100" class="xlarge" name="sub_cat_limit" value="<?php echo osc_esc_html( osc_get_preference('sub_cat_limit', 'udhauli') ); ?>">
        </div>
      </div>
	   <div class="form-row">
        <div class="form-label">
          <?php _e('Show popular', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <div class="form-label-checkbox">
            <input type="checkbox" name="show_popular" value="1" <?php echo ( osc_esc_html( osc_get_preference('show_popular', 'udhauli') ) == "1")? "checked": ""; ?>>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-label">
          <?php _e('Popular searches', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <div class="form-label-checkbox">
            <input type="checkbox" name="show_popular_searches" value="1" <?php echo ( osc_esc_html( osc_get_preference('show_popular_searches', 'udhauli') ) == "1")? "checked": ""; ?>>
          </div>
        </div>
      </div>
	   <div class="form-row">
        <div class="form-label">
          <?php _e('Popular regions', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <div class="form-label-checkbox">
            <input type="checkbox" name="show_popular_regions" value="1" <?php echo ( osc_esc_html( osc_get_preference('show_popular_regions', 'udhauli') ) == "1")? "checked": ""; ?>>
          </div>
        </div>
      </div>
	        <div class="form-row">
        <div class="form-label">
          <?php _e('Popular cities', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <div class="form-label-checkbox">
            <input type="checkbox" name="show_popular_cities" value="1" <?php echo ( osc_esc_html( osc_get_preference('show_popular_cities', 'udhauli') ) == "1")? "checked": ""; ?>>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-label">
          <?php _e('Popular searches limit', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <input type="number" min="1" max="100" name="popular_searches_limit" value="<?php echo osc_esc_html( osc_get_preference('popular_searches_limit', 'udhauli') ); ?>">
        </div>
      </div>

      <div class="form-row">
        <div class="form-label">
          <?php _e('Popular regions limit', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <input type="number" min="1" max="100" name="popular_regions_limit" value="<?php echo osc_esc_html( osc_get_preference('popular_regions_limit', 'udhauli') ); ?>">
        </div>
      </div>

      <div class="form-row">
        <div class="form-label">
          <?php _e('Popular cities limit', 'udhauli'); ?>
        </div>
        <div class="form-controls">
          <input type="number" min="1" max="100" name="popular_cities_limit" value="<?php echo osc_esc_html( osc_get_preference('popular_cities_limit', 'udhauli') ); ?>">
        </div>
      </div>
    </div>
  </fieldset>
  <div class="form-actions">
    <input type="submit" value="<?php echo osc_esc_html(__('Save changes', 'udhauli')); ?>" class="btn btn-submit">
  </div>
</form>
