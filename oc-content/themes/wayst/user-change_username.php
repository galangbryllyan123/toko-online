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

    osc_enqueue_script('jquery-validate');

    wayst_add_body_class('user user-profile');
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-sidebar.php');
    }
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Change username', 'wayst');;
    }
    $osc_user = osc_user();
?>

<?php osc_current_web_theme_path('user/head-user.php') ; ?>

<script type="text/javascript">
$(document).ready(function() {
    $('form#change-username').validate({
        rules: {
            s_username: {
                required: true
            }
        },
        messages: {
            s_username: {
                required: '<?php echo osc_esc_js(__("Username: this field is required", "wayst")); ?>.'
            }
        },
        errorLabelContainer: "#error_list",
        wrapper: "li",
        invalidHandler: function(form, validator) {
            $('html,body').animate({ scrollTop: $('h1').offset().top }, { duration: 250, easing: 'swing'});
        },
        submitHandler: function(form){
            $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
            form.submit();
        }
    });

    var cInterval;
    $("#s_username").keydown(function(event) {
        if($("#s_username").attr("value")!='') {
            clearInterval(cInterval);
            cInterval = setInterval(function(){
                $.getJSON(
                    "<?php echo osc_base_url(true); ?>?page=ajax&action=check_username_availability",
                    {"s_username": $("#s_username").attr("value")},
                    function(data){
                        clearInterval(cInterval);
                        if(data.exists==0) {
                            $("#available").text('<?php echo osc_esc_js(__("The username is available", "wayst")); ?>');
                        } else {
                            $("#available").text('<?php echo osc_esc_js(__("The username is NOT available", "wayst")); ?>');
                        }
                    }
                );
            }, 1000);
        }
    });

});
</script>

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
        <?php _e('Change username', 'wayst'); ?>
      </h1>
       <?php
        $breadcrumb = osc_breadcrumb('', false, get_breadcrumb_lang());
        if( $breadcrumb !== '') { ?>
      <?php echo $breadcrumb; ?>
      <?php } ?>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-12">
           
          <!-- starting content to edit user info -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php _e('Update', 'wayst'); ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/jquery.validate.min.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery.form.js'); ?>"></script>
             <ul id="error_list"></ul>
        <form action="<?php echo osc_base_url(true); ?>" method="post" id="change-username">
            <input type="hidden" name="page" value="user" />
            <input type="hidden" name="action" value="change_username_post" />
            <div class="box-body">
            <div class="form-group">
                <label class="control-label" for="s_username"><?php _e('Username', 'wayst'); ?></label>
                <div class="">
                    <input class="form-control" type="text" name="s_username" id="s_username" value="" />
                    <div id="available"></div>
                </div>
            </div>
            
            <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><?php _e("Update", 'wayst');?></button>
                </div>
            
            
            </div>
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