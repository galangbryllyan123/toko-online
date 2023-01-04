<?php
    /*
     *       Hero Premium Responsive Osclass Themes
     *       
     *       Copyright (C) 2017 OSCLASS.me
     * 
     *       This is Hero Premium Osclass Themes with Single License
     *  
     *       This program is a commercial software. Copying or distribution without a license is not allowed.
     *         
     *       If you need more licenses for this software. Please read more here <http://www.osclass.me/osclass-me-license/>.
     */
?>
    <!-- header -->
    <div id="header">
        <header class="navbar navbar-static-top bs-docs-nav" id="top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-121"> <i class="fa fa-search"></i> </button> <span class="tuxedo-menu-trigger unik navbar-brand navbar-toggle"><i class="fa fa-bars"></i></span></div>
                <nav id="bs-navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php if(osc_users_enabled()) { ?>
                        <?php if( osc_is_web_user_logged_in() ) { ?>
                        <li><a href="<?php echo osc_user_dashboard_url(); ?>"><i class="fa fa-user"></i> <?php _e("My account", 'hero'); ?></a></li>
                        <li><a href="<?php echo osc_user_logout_url(); ?>"><i class="fa fa-power-off"></i>  <?php _e("Logout", 'hero'); ?></a></li>
                        <?php } else { ?>
                        <li><a href="<?php echo osc_user_login_url(); ?>"><i class="fa fa-lock"></i> <?php _e("Login", 'hero'); ?></a></li>
                        <?php if(osc_user_registration_enabled()) { ?>
                        <li><a href="<?php echo osc_register_account_url(); ?>"><i class="fa fa-user"></i>  <?php _e("Register", 'hero'); ?></a></li>
                        <?php }; ?>
                        <?php }; ?>
                        <?php }; ?>
                        <?php if ( osc_count_web_enabled_locales()> 1) { ?>
                        <?php osc_goto_first_locale(); ?>
                        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-language"></i> <?php _e("Language", 'hero') ; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php $i=0 ; ?>
                                <?php while ( osc_has_web_enabled_locales() ) { ?>
                                <li <?php if( $i==0 ) { echo "class='first'"; } ?>><a id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><img alt="<?php echo osc_esc_html(osc_locale_name()) ; ?>" src="<?php echo osc_current_web_theme_url() ; ?>/images/language/<?php echo osc_locale_code(); ?>.png"><?php echo osc_locale_name(); ?></a> </li>
                                <?php $i++; ?>
                                <?php } ?> </ul>
                        </li>
                        <?php } ?> </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo osc_base_url() ; ?>"><span class="fa fa-home" aria-hidden="true"></span> <?php _e("Home", 'hero') ; ?></a> </li>
                        <li>
                            <a href="<?php echo osc_contact_url(); ?>"><?php _e("Contact", 'hero'); ?></a>
                        </li>
                        <?php osc_reset_static_pages(); ?>
                        <?php while( osc_has_static_pages() ) { ?>
                        <li>
                            <a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a>
                        </li>
                        <?php } ?> 
                        <?php if(osc_get_preference('blog-links', 'hero')!='' ) { ?>
                        <li><a target="_blank" href="<?php echo osc_get_preference('blog-links', 'hero'); ?>"><?php echo osc_get_preference('blog-text', 'hero'); ?></a></li>
                            <?php } ?> </ul>
                </nav>
            </div>
        </header>
        <div class="head2">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <div class="centeres">
                            <a id="logo" href="<?php echo osc_base_url() ; ?>"><?php echo logo_header(); ?></a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-121">
                            <?php osc_current_web_theme_path( 'templates/inc/'.osc_get_preference('inc-vera', 'hero').'.php') ; ?> </div>
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-success btn-block" href="<?php echo osc_item_post_url_in_category(); ?>"> <i class="fa fa-plus"></i>
                            <?php _e("Publish", 'hero');?> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /header -->
    <div style="clear:both;"></div>
    <?php $breadcrumb=osc_breadcrumb('&raquo;', false); if( $breadcrumb !='' ) { ?>
    <div class="suka">
        <div class="container">
            <?php echo $breadcrumb; ?> </div>
    </div>
    <?php } ?>
    <div class="container">
        <?php osc_show_widgets('header') ; ?>
    </div>
    <?php if(osc_get_preference('select-us', 'hero') == "home3") { ?>
<?php if(  osc_is_home_page()){ ?>
<?php } else { ?>
<?php if(osc_get_preference('header-728x90', 'hero')!='' ) { ?>
<div class="container"><div class="ad-top ads centeres"><?php echo osc_get_preference('header-728x90', 'hero'); ?></div></div>
<?php } ?>
 <?php } ?>
<?php } else { ?>
<?php if(osc_get_preference('header-728x90', 'hero')!='' ) { ?>
<div class="container"><div class="ad-top ads centeres"><?php echo osc_get_preference('header-728x90', 'hero'); ?></div></div>
<?php } ?>
<?php }  ?>
    <div class="forcemessages-inline container">
        <?php osc_show_flash_message(); ?> 
    </div>