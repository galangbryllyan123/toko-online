<aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <?php if (function_exists('profile_picture_show')){profile_picture_show();} else{ echo '<img src="' . osc_current_web_theme_url('images/no-user-photo.jpg') . '" class="profile-user-img img-responsive img-circle">'; } ?>
        </div>
        <div class="pull-left info">
          <p><?php echo osc_logged_user_name(); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <form id="search-form-head" method="get" action="<?php echo osc_base_url(true); ?>" class="sidebar-form nocsrf" <?php /* onsubmit="javascript:return doSearch();"*/ ?>>
    <input type="hidden" name="page" value="search"/>
        <div class="input-group">
        <input type="text" name="sPattern" class="form-control" placeholder="<?php echo osc_esc_html(osc_get_preference('keyword_placeholder', 'wayst') ); ?>" value="" />          
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <ul class="user_menu">
        <li class="header"><?php _e('My account', 'wayst'); ?></li>
        </ul>
        
        <?php echo osc_private_user_menu( get_user_menu2() ); ?>
        <ul class="user_menu"> <!-- changed with "sidebar-menu" original class -->
                      
              <li class="header"><?php _e('All categories', 'wayst'); ?></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list-ul text-aqua"></i> <span><?php _e('Category', 'wayst'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php osc_goto_first_category() ; ?>
<?php while ( osc_has_categories() ) { ?>
          <ul class="treeview-menu">
          <li><a href="<?php echo osc_search_category_url() ; ?>" ><i class="fa fa-circle-o text-aqua"></i> <?php echo osc_category_name() ; ?></a></li>
          </ul>
          <?php } ?>
        </li>        
        <li class="header"><?php _e('Pages', 'wayst'); ?></li>
        <li><a href="<?php echo osc_item_post_url(); ?>"><i class="fa fa-pencil text-yellow"></i> <span><?php _e("Publish a listing", 'wayst');?></span></a></li>
                <li><a href="<?php echo osc_contact_url(); ?>"><i class="fa fa-envelope text-green"></i> <span><?php _e('Contact us', 'wayst'); ?></span></a></li>
        <?php osc_reset_static_pages(); ?>
        <?php while( osc_has_static_pages() ) { ?>
            <li> <a href="<?php echo osc_static_page_url(); ?>"><i class="fa fa-circle-o text-aqua"></i> <span><?php echo osc_static_page_title(); ?></span></a></li>
        <?php } ?>
      </ul>
    </section>
  </aside>