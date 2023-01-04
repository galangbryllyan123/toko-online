<div class="wrapper wrapper-flash"><?php osc_show_flash_message(); ?></div>
<header class="main-header">
    <a href="<?php echo osc_base_url(); ?>" class="logo">
      <span class="logo-mini"><b><?php echo osc_highlight( strip_tags( osc_page_title() ), 3 ); ?></b></span>
      <span class="logo-lg"><b><?php echo osc_page_title(); ?></b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown messages-menu">
            <a href="<?php echo osc_user_profile_url(); ?>" class="dropdown-toggle">
              <i class="fa fa-home"></i>
            </a>
          </li>
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-chevron-down"></i> <span class="hidden-xs"><?php _e("Category", 'wayst');?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><?php _e("Select a category", 'wayst');?></li>
              <li>
                <ul class="menu">
                 <?php osc_goto_first_category() ; ?>
                                <?php while ( osc_has_categories() ) { ?>
                  <li>
                    <a href="<?php echo osc_search_category_url() ; ?>">
                                               <?php echo osc_category_name() ; ?> </a> 
                  </li> <?php } ?>
                  
                </ul>
              </li>
                            <li class="footer"><a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))); ?>"><?php _e("All categories", 'wayst');?></a></li>

            </ul>
          </li>
          <li class="dropdown messages-menu">
            <a href="<?php echo osc_item_post_url(); ?>" class="dropdown-toggle">
              <i class="fa fa-pencil"></i> <span class="hidden-xs"><?php _e("Publish", 'wayst');?></span>
            </a>
            
          </li>
          <li class="dropdown messages-menu">
            <a href="<?php echo osc_contact_url(); ?>" class="dropdown-toggle">
              <i class="fa fa-envelope-o"></i> <span class="hidden-xs"><?php _e("Contact us", 'wayst');?></span>
            </a>
            
          </li>
          <?php if ( osc_count_web_enabled_locales() > 1) { ?>
            <?php osc_goto_first_locale(); ?>
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i> <span class="hidden-xs"><?php _e('Language:', 'wayst'); ?></span> <i class="fa fa-chevron-down hidden-xs"></i>
            </a>
            <ul class="dropdown-menu">
              <li>
                <ul class="menu">
                 <?php while ( osc_has_web_enabled_locales() ) { ?>
                  <li><!-- Task item -->
                  <a  id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><h3><?php echo osc_locale_name(); ?></h3></a>
                   
                  </li>
               <?php } ?>
                </ul>
              </li>
            </ul>
          </li><?php } ?>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i>
              <span class="hidden-xs"><?php echo osc_logged_user_name(); ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                 <?php if (function_exists('profile_picture_show')){profile_picture_show();} else{ echo '<img src="' . osc_current_web_theme_url('images/no-user-photo.jpg') . '" class="profile-user-img img-responsive img-circle">'; } ?>
                <p>
                 <?php echo sprintf(__('Hi %s', 'wayst'), osc_logged_user_name() . '!'); ?> 
                  <small><?php _e('Member', 'wayst'); ?>: <?php 
        if(osc_is_web_user_logged_in()){
            $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
            echo osc_format_date($user['dt_reg_date']); 
        }
    ?></small>
                </p>
              </li>
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-6 text-center">
                    <a href="<?php echo osc_item_post_url(); ?>"><?php _e('Publish a listing', 'wayst'); ?></a>
                  </div>
                  <div class="col-xs-6 text-center">
                    <a href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My account', 'wayst'); ?></a>
                  </div>
                 
                </div>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                <a class="btn btn-default btn-flat" href="<?php echo osc_user_public_profile_url(); ?>"><?php _e('Public Profile', 'wayst'); ?></a>
                </div>
                <div class="pull-right">
                <a class="btn btn-default btn-flat" href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'wayst'); ?></a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>