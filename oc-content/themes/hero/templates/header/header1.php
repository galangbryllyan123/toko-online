<?php
    /*
     *       Hero Responsive Osclass Themes
     *       
     *       Copyright (C) 2017 OSCLASS.me
     * 
     *       This is Hero Osclass Themes with Single License
     *  
     *       This program is a commercial software. Copying or distribution without a license is not allowed.
     *         
     *       If you need more licenses for this software. Please read more here <http://www.osclass.me/osclass-me-license/>.
     */
?>
<header id='header'>
    <div class="menu-hero2">
        <div class='container'>
            <nav class="navbar navbar-static-top bs-docs-nav navbar-fixed-top" id="top">
                <div class="container">
                <div class='navbar-header'>
 
                    <button type="button" class="tuxedo-menu-trigger navbar-toggle"> <span class="sr-only"><?php _e("Toggle navigation", 'hero'); ?></span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
<button type="button" class="navbar-toggle collapsed" data-toggle="modal" data-target=".bs-example-modal-sm"> <i class="putih fa fa-search"></i> </button>
                    <div class="logo">
                        <a class="navbar-brand" href="<?php echo osc_base_url(); ?>" title="<?php echo osc_esc_html(osc_page_title()) ; ?>">
                            <?php echo logo_header(); ?> </a>
                    </div>
                </div>
                <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
                    <ul class='nav navbar-nav navbar-right'>
                        <li>
                            <a href='<?php echo osc_base_url(); ?>'> <span><?php _e("Home", 'hero') ; ?></span></a>
                        </li>
                       
                        
                        <li class='dropdown mega-dropdown'>
                            <a class='dropdown-toggle' data-delay='50' data-hover='dropdown' data-toggle='dropdown' href='#'> <span><?php _e("Search", 'hero') ; ?> <i class='fa fa-angle-down'></i></span> </a>
                            
                            <div class="dropdown-menu mega-dropdown-menu mappa row">
                                <div class="col-md-12">
                                <div class="row">
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-121">
                            <?php osc_current_web_theme_path('templates/inc/'.osc_get_preference('inc-vera', 'hero').'.php') ; ?> </div>
                    </div></div>
                            </div>
                           
                        </li>
                        
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
                        <?php } ?>
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
                        <?php if(osc_get_preference('blog-links', 'hero')!='' ) { ?>
                            <li><a target="_blank" href="<?php echo osc_get_preference('blog-links', 'hero'); ?>"><?php echo osc_get_preference('blog-text', 'hero'); ?></a></li>
                            <?php } ?> 
                        <li>
                            <a class="publish" href='<?php echo osc_item_post_url_in_category(); ?>'> <span><i class='fa fa-plus fa-lg'></i> <?php _e("Publish", 'hero') ; ?></span> </a>
                            
                        </li>
                  </ul>
                </div></div>
            </nav>
        </div>
    </div>
</header>
  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
 <form action="<?php echo osc_base_url(true); ?>" method="get" role="search" class="nocsrf">
                <fieldset>
                    <div class="input-group ulfa">
                        <input type="hidden" name="page" value="search" />
                        <input type="text" name="sPattern" class="form-control" placeholder="<?php echo osc_esc_html( osc_get_preference('keyword_placeholder', 'hero') ); ?>" value="" /> <span class="input-group-btn">
        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> <?php _e("Search", 'hero'); ?></button>
      </span> </div>
                </fieldset>
            </form>
    </div>
  </div>
</div>

<?php
    osc_show_widgets('header');
    $breadcrumb = osc_breadcrumb('&raquo;', false);
    if( $breadcrumb != '') { ?>
<div class="satus">
    <div class="ulfa container">
        <?php echo $breadcrumb; ?>
        <div class="clear"></div>
    </div>
</div>
<?php } ?>
<div class="container forcemessages-inline">
    <?php osc_show_flash_message(); ?>
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
