<?php
  $locales   = __get('locales') ;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
</head>
<body>
  <?php osc_current_web_theme_path('header.php') ; ?>
  <div class="content user_account">
    <h1>
      <?php if(function_exists('profile_picture_show')) { profile_picture_show(null, null, 39); } ?>
      <span><?php _e('User account manager', 'tatiana') ; ?></span>
    </h1>
    <div id="sidebar">
      <?php echo osc_private_user_menu() ; ?>
      <?php if(function_exists('profile_picture_upload')) { profile_picture_upload();} ?>
    </div>
    <div id="main" class="modify_profile">
      <?php UserForm::location_javascript(); ?>
      <form action="<?php echo osc_base_url(true) ; ?>" method="post">
      <input type="hidden" name="page" value="user" />
      <input type="hidden" name="action" value="profile_post" />

      <div id="left-user">
        <h2><div class="icon-p-info"></div><span><?php _e('Personal Information', 'tatiana') ; ?></span></h2>
        <div class="row">
          <label for="name"><span><?php _e('Name', 'tatiana') ; ?></span><span class="req">*</span></label>
          <?php UserForm::name_text(osc_user()) ; ?>
        </div>

        <div class="row">
          <label for="email"><span><?php _e('E-mail', 'tatiana') ; ?></span><span class="req">*</span></label>
          <span class="update">
            <?php echo osc_user_email() ; ?><br />
            <a href="<?php echo osc_change_user_email_url() ; ?>"><?php _e('Modify e-mail', 'tatiana') ; ?></a> <a href="<?php echo osc_change_user_password_url() ; ?>" ><?php _e('Modify password', 'tatiana') ; ?></a>
          </span>
        </div>

        <div class="row">
          <label for="phoneMobile"><span><?php _e('Mobile phone', 'tatiana'); ?></span><span class="req">*</span></label>
          <?php UserForm::mobile_text(osc_user()) ; ?>
        </div>

        <div class="row">
          <label for="phoneLand"><?php _e('Land Phone', 'tatiana') ; ?></label>
          <?php UserForm::phone_land_text(osc_user()) ; ?>
        </div>                        

        <div class="row">
          <label for="info"><?php _e('Some info about you', 'tatiana') ; ?></label>
          <?php UserForm::multilanguage_info($locales, osc_user()); ?>
        </div>
        <div class="req-what"><div class="req">*</div><div class="small-info"><?php _e('This field is required', 'tatiana'); ?></div></div>

        <div class="row">
          <button type="submit" id="blue" class="round3 button"><?php _e('Update', 'tatiana') ; ?></button>
        </div>
      </div>

      <div id="right-user">
        <h2><div class="icon-b-info"></div><span><?php _e('Business Information & Location', 'tatiana'); ?></span></h2>
        <div class="row">
          <label for="user_type"><?php _e('User type', 'tatiana') ; ?></label>
          <?php UserForm::is_company_select(osc_user()) ; ?>
        </div>

        <div class="row">
          <label for="webSite"><?php _e('Website', 'tatiana') ; ?></label>
          <?php UserForm::website_text(osc_user()) ; ?>
        </div>

        <?php $user = osc_user(); ?>
        <?php $country = Country::newInstance()->listAll(); ?>
        <?php $country_first = $country[0]; ?>

        <div class="row" <?php if(count($country) == 1) { ?>style="display:none;"<?php } ?>>
          <label for="country"><span><?php _e('Country', 'tatiana') ; ?></span><span class="req">*</span></label>
          <?php UserForm::country_select(Country::newInstance()->listAll(), osc_user()); ?>
        </div>

        <div class="row">
          <label for="region"><span><?php _e('Region', 'tatiana') ; ?></span><span class="req">*</span></label>
          <?php UserForm::region_select($user['fk_c_country_code'] <> '' ? osc_get_regions($user['fk_c_country_code']) : (count($country) == 1 ? osc_get_regions($country_first['pk_c_code']) : ''), osc_user()) ; ?>
        </div>

        <div class="row">
          <label for="city"><span><?php _e('City', 'tatiana') ; ?></span><span class="req">*</span></label>
          <?php UserForm::city_select($user['fk_i_region_id'] <> '' ? osc_get_cities($user['fk_i_region_id']) : '', osc_user()) ; ?>
        </div>

        <div class="row">
          <label for="address"><?php _e('Address', 'tatiana') ; ?></label>
          <?php UserForm::address_text(osc_user()) ; ?>
        </div>
      </div>
           
      <?php osc_run_hook('user_form') ; ?>
      </form>
    </div>
  </div>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>