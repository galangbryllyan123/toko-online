             

<?php osc_current_web_theme_path('user/head-user.php') ; ?>
<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    // meta tag robots
    osc_add_hook('header','wayst_nofollow_construct');

    wayst_add_body_class('user user-profile');
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-sidebar.php');
    }
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Update account', 'wayst');
    }
    $user = osc_user();
?>
  

<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2012 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    $address = '';
    if(osc_user_address()!='') {
        if(osc_user_city_area()!='') {
            $address = osc_user_address().", ".osc_user_city_area();
        } else {
            $address = osc_user_address();
        }
    } else {
        $address = osc_user_city_area();
    }
    $location_array = array();
    if(trim(osc_user_city()." ".osc_user_zip())!='') {
        $location_array[] = trim(osc_user_city()." ".osc_user_zip());
    }
    if(osc_user_region()!='') {
        $location_array[] = osc_user_region();
    }
    if(osc_user_country()!='') {
        $location_array[] = osc_user_country();
    }
    $location = implode(", ", $location_array);
    unset($location_array);

    osc_enqueue_script('jquery-validate');
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php osc_current_web_theme_path('user/main-header.php') ; ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php osc_current_web_theme_path('user/main-sidebar.php') ; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php _e('Update account', 'wayst'); ?>
      </h1>
      <?php UserForm::location_javascript(); ?>
       <?php
        $breadcrumb = osc_breadcrumb('', false, get_breadcrumb_lang());
        if( $breadcrumb !== '') { ?>
      <?php echo $breadcrumb; ?>
      <?php } ?>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
             <!-- <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> -->              <h3 class="profile-username text-center"><?php echo osc_logged_user_name(); ?></h3>

              <?php if (function_exists('profile_picture_upload')){profile_picture_upload();} else{ echo '<img src="' . osc_current_web_theme_url('images/no-user-photo.jpg') . '" class="profile-user-img img-responsive img-circle" >'; } ?>

              <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                  <b><?php _e('Member', 'wayst'); ?></b>: <a class="pull-right"><?php echo osc_format_date(osc_user_field('dt_reg_date')); ?></a>
                </li>
                <li class="list-group-item">
                  <b><?php _e('Listings', 'wayst'); ?></b>: <a class="pull-right"><?php echo osc_user_items_validated(); ?></a>
                </li>
                <li class="list-group-item">
                  <b><a href="<?php echo osc_item_post_url(); ?>"><?php _e('Publish a listing', 'wayst'); ?></a></b>
                </li>
                
              </ul>

              <a href="<?php echo osc_user_public_profile_url(); ?>" class="btn btn-primary btn-block"><b><?php _e('Public Profile', 'wayst'); ?></b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <!-- <h3 class="box-title">< ? php _e('Description', 'wayst'); ?></h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <strong><i class="fa fa-book margin-r-5"></i> <?php _e('Phone', 'wayst'); ?></strong>

              <p class="text-muted">
                <?php echo osc_user_phone(); ?>
              </p>

              <hr>
              <strong><i class="fa fa-book margin-r-5"></i> <?php _e('Cell phone', 'wayst'); ?></strong>

              <p class="text-muted">
               <?php echo osc_user_phone_mobile() ; ?>
              </p>

              <hr>
              <strong><i class="fa fa-book margin-r-5"></i> <?php _e('Description', 'wayst'); ?></strong>

              <p class="text-muted">
                <?php echo osc_user_info(); ?>
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> <?php _e('Location', 'wayst'); ?></strong>

              <p class="text-muted"><?php echo $location; ?></p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> <?php _e('Address', 'wayst'); ?></strong>

              <p class="text-muted">
               <?php echo $address; ?>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> <?php _e('Website', 'wayst'); ?></strong>

              <p><a href="<?php echo osc_user_website(); ?>"><?php echo osc_user_website(); ?></a></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
           
          <!-- starting content to edit user info -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php _e('Update', 'wayst'); ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="<?php echo osc_base_url(true); ?>" method="post" role="form">
            <input type="hidden" name="page" value="user" />
            <input type="hidden" name="action" value="profile_post" />
            <!-- start box body form --><div class="box-body">
            <div class="form-group">
                  
                <label class="control-label" for="name"><?php _e('Name', 'wayst'); ?></label>
                <div class="">
                    <?php UserForm::name_text(osc_user()); ?> 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="user_type"><?php _e('User type', 'wayst'); ?></label>
                <div class="">
                    <?php UserForm::is_company_select(osc_user()); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label" for="phoneMobile"><?php _e('Cell phone', 'wayst'); ?></label>
                <div class="">
                    <?php UserForm::mobile_text(osc_user()); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="phoneLand"><?php _e('Phone', 'wayst'); ?></label>
                <div class="">
                    <?php UserForm::phone_land_text(osc_user()); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="country"><?php _e('Country', 'wayst'); ?></label>
                <div class="">
                    <?php UserForm::country_select(osc_get_countries(), osc_user()); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="region"><?php _e('Region', 'wayst'); ?></label>
                <div class="">
                    <?php UserForm::region_select(osc_get_regions(), osc_user()); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="city"><?php _e('City', 'wayst'); ?></label>
                <div class="">
                    <?php UserForm::city_select(osc_get_cities(), osc_user()); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="city_area"><?php _e('City area', 'wayst'); ?></label>
                <div class="">
                    <?php UserForm::city_area_text(osc_user()); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"l for="address"><?php _e('Address', 'wayst'); ?></label>
                <div class="controls">
                    <?php UserForm::address_text(osc_user()); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="webSite"><?php _e('Website', 'wayst'); ?></label>
                <div class="">
                    <?php UserForm::website_text(osc_user()); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="s_info"><?php _e('Description', 'wayst'); ?></label>
                <div class="controls">
                    <?php UserForm::info_textarea('s_info', osc_locale_code(), @$osc_user['locale'][osc_locale_code()]['s_info']); ?>
                </div>
            </div>
            <?php osc_run_hook('user_profile_form', osc_user()); ?>
            
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><?php _e("Update", 'wayst');?></button>  <a class="btn btn-danger pull-right" title="1 click: <?php echo osc_esc_html(__('Delete account', 'wayst')); ?>. <?php echo osc_esc_html(__('Are you sure you want to delete your account?', 'wayst'));?>" href="<?php echo osc_base_url(true).'?page=user&action=delete&id='.osc_user_id().'&secret='.$user['s_secret']; ?>"><?php _e('Delete account', 'wayst'); ?></a>
                </div>
            
            <div class="form-group">
                <div class="controls">
                    <?php osc_run_hook('user_form', osc_user()); ?>
                </div>
            </div>
            </div> <!-- end box body form -->
        </form>
          </div>
          <!-- end content to edit user info -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php osc_current_web_theme_path('user/user-footer.php') ; ?>

  <!-- Control Sidebar -->
  <?php osc_current_web_theme_path('user/user-control-sidebar.php') ; ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  
</div>
<!-- ./wrapper -->

<?php osc_current_web_theme_path('user/user-jscripts-footer.php') ; ?>
</body>
</html>
