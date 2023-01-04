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
        return __('Alerts', 'wayst');;
    }
    $osc_user = osc_user();
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
        <?php osc_run_hook('search_ads_listing_top'); ?>

      <h1>
        <?php _e('Alerts', 'wayst'); ?>
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
              <h3 class="box-title"><?php _e('Alerts', 'wayst'); ?></h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
              
              
              
              
             <?php if(osc_count_alerts() == 0) { ?>
                   <h3><?php _e('You do not have any alerts yet', 'wayst'); ?>.</h3>
                <?php } else { ?>
                    <?php while(osc_has_alerts()) { ?>
                    <span class="label label-success "><?php _e('Alert', 'wayst'); ?></span> | <a onClick="javascript:return confirm('<?php echo osc_esc_js(__('This action can\'t be undone. Are you sure you want to continue?', 'wayst')); ?>');" href="<?php echo osc_user_unsubscribe_alert_url(); ?>"><span class="label label-danger"><?php _e('Delete this alert', 'wayst'); ?></span></a> 
                    <?php while(osc_has_items()) { ?>
                <li class="item">
                <?php if( osc_images_enabled_at_items() ) { ?>
                  <div class="product-img">
                  <?php if(osc_count_item_resources()) { ?>
                        <a href="<?php echo osc_item_url(); ?>" target="_blank"><img class="img-responsive" src="<?php echo osc_resource_thumbnail_url(); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" /></a>
                    <?php } else { ?>
                        <a href="<?php echo osc_item_url(); ?>" target="_blank"><img class="img-responsive" src="<?php echo osc_current_web_theme_url('imagesb/no_photo.gif'); ?>" /></a>
                    <?php } ?>
                  
                  </div> <?php } ?>
                                                  
                  <div class="product-info">
                  <a class="product-title" href="<?php echo osc_item_url(); ?>" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> <?php echo osc_highlight( strip_tags( osc_item_title() ) ); ?></a>
                    
                        <span class="product-description">
                          <strong><?php echo osc_highlight( strip_tags( osc_item_description() ), 850 ); ?></strong>
                        </span>
                        <span class="product-description">
                          <i class="fa fa-folder-o" aria-hidden="true"></i> <?php echo osc_item_category() ; ?>, <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo osc_item_city(); ?> <?php if( osc_item_region()!='' ) { ?> (<?php echo osc_item_region(); ?>)<?php } ?>, <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo osc_format_date(osc_item_pub_date()); ?>, ID: <?php echo osc_item_id(); ?>, <i class="fa fa-eye" aria-hidden="true"></i> <?php echo osc_item_views(); ?>
                        </span>
                      <i class="fa fa-user" aria-hidden="true"></i> <?php echo osc_item_contact_name(); ?>, <?php _e('Price', 'wayst'); ?>: <span class="label label-default "><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() )  echo osc_item_formated_price(); ?></span> 
                        <?php if(osc_count_items() == 0) { ?>
                                    <br />
                                    0 <?php _e('Listings', 'wayst'); ?>
                            <?php } ?>
                  </div>

                </li><?php } ?> <?php } ?><?php } ?>
                <!-- /.item -->
              </ul>
            </div>
            <!-- /.box-body -->          
            <div class="box-footer clearfix text-center">
              <ul class="pagination pagination-sm no-margin ">
               <?php for($i = 0; $i < osc_list_total_pages(); $i++) {
                        if($i == osc_list_page()) {
                            printf('<li><a href="%s">%d</a></li>', osc_user_list_items_url($i+1), ($i + 1));
                        } else {
                            printf('<li><a href="%s">%d</a></li>', osc_user_list_items_url($i+1), ($i + 1));
                        }
                    } ?>
                
              </ul>
            </div>
            <!-- /.box-footer -->
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
</div>
<!-- ./wrapper -->
<?php osc_current_web_theme_path('user/user-jscripts-footer.php') ; ?>
</body>
</html>