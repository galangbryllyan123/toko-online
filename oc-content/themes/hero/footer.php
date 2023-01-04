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
    osc_show_widgets('footer');
?>
<div class="container">
    <?php if(osc_get_preference('homepage-728x90', 'hero')!='' ) { ?>
    <div class="ads centeres">
        <?php echo osc_get_preference('homepage-728x90', 'hero'); ?> 
    </div>
    <?php } ?> 
</div>
<nav id="sidebar5" class="tuxedo-menu metismenu">
    <ul>
        <li>
            <div class="navigasi"><?php _e("Menu", 'hero') ; ?></div>
        </li>
        <li>
            <a href='<?php echo osc_base_url(); ?>'><span><i class="fa fa-home"></i> <?php _e("Home", 'hero') ; ?></span></a>
        </li>
        <li>
            <a class="pagesside" href='#'><?php _e("Pages", 'hero') ; ?> <span class="fa fa-arrow-down arrow"></span></a>
            <ul>
                <?php osc_reset_static_pages(); ?>
                <?php while( osc_has_static_pages() ) { ?>
                <li>
                    <a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a>
                </li>
                <?php } ?>
                <li>
                    <a href='<?php echo osc_contact_url(); ?>'><span><?php _e("Contact", 'hero'); ?></span></a>
                </li>
            </ul>
        </li>
        <li>
            <a class="catside" href='#'><?php _e("Categories", 'hero'); ?> <span class="fa fa-arrow-down arrow"></span></a>
         <?php osc_goto_first_category() ; ?>
                            <?php if(osc_count_categories () > 0) { ?>
                            <ul>
                                <?php while ( osc_has_categories() ) { ?>
                                <li>
                                    <a href="<?php echo osc_search_category_url() ; ?>"><?php View::newInstance()->_erase('subcategories'); echo osc_category_name() ; ?></a>
                                 </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
        </li>
<?php if ( osc_count_web_enabled_locales() > 1) { ?>
        <?php osc_goto_first_locale(); ?>
      <li> <a class="langside" href="#"><?php _e("Language", 'hero') ; ?> <span class="fa fa-arrow-down arrow"></span></a>
                                <ul>
                                    <?php $i=0 ; ?>
                                    <?php while ( osc_has_web_enabled_locales() ) { ?>
                                    <li <?php if( $i==0 ) { echo "class='first'"; } ?>><a class="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><img alt="<?php echo osc_esc_html(osc_locale_name()) ; ?>" src="<?php echo osc_current_web_theme_url() ; ?>/images/language/<?php echo osc_locale_code(); ?>.png"><?php echo osc_locale_name(); ?></a> </li>
                                    <?php $i++; ?>
                                    <?php } ?> </ul>
                        </li>
                        <?php } ?>
                        <?php if(osc_users_enabled()) { ?>
                        <?php if( osc_is_web_user_logged_in() ) { ?>
                        <li><a href="#"><i class="fa fa-user"></i> <?php _e("My account", 'hero'); ?> <span class="fa fa-arrow-down arrow"></span></a>
                            <ul>
                                <li><a href="<?php echo osc_user_list_items_url() ; ?>"><span class="fa fa-th-list" aria-hidden="true"></span> <?php _e("Your listings", 'hero') ; ?></a></li>
                                <li><a href="<?php echo osc_user_profile_url() ; ?>"><span class="fa fa-user" aria-hidden="true"></span> <?php _e("My account", 'hero') ; ?></a></li>
                                <li><a href="<?php echo osc_user_alerts_url() ; ?>"><span class="fa fa-warning" aria-hidden="true"></span> <?php _e("Your alerts", 'hero') ; ?></a></li>
                                <li><a href="<?php echo osc_change_user_email_url() ; ?>"><span class="fa fa-envelope" aria-hidden="true"></span> <?php _e("Modify e-mail", 'hero') ; ?></a></li>
                                <li><a href="<?php echo osc_change_user_password_url() ; ?>"><span class="fa fa-cog" aria-hidden="true"></span> <?php _e("Modify password", 'hero') ; ?></a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo osc_user_logout_url(); ?>"><i class="fa fa-power-off"></i>  <?php _e("Logout", 'hero'); ?></a></li>
                        <?php } else { ?>
                        <li><a href="<?php echo osc_user_login_url(); ?>"><i class="fa fa-lock"></i> <?php _e("Login", 'hero'); ?></a></li>
                        <?php if(osc_user_registration_enabled()) { ?>
                        <li><a href="<?php echo osc_register_account_url(); ?>"><i class="fa fa-user"></i>  <?php _e("Register", 'hero'); ?></a></li>
                        <?php }; ?>
                        <?php } ?>
                        <?php } ?>
                        <?php if(osc_get_preference('blog-links', 'hero')!='' ) { ?>
                            <li><a target="_blank" href="<?php echo osc_get_preference('blog-links', 'hero'); ?>"><?php echo osc_get_preference('blog-text', 'hero'); ?></a></li>
                         <?php } ?> 
                        <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
                        <li class="postadd">
                            <a style="color:#fff;" class="btn btn-block   btn-border btn-post btn-success" href="<?php echo osc_item_post_url_in_category(); ?>"><?php _e("Publish your ad for free", 'hero');?> </a>
                        </li>
                        <?php } ?>
                </ul>
</nav>
<!-- version <?php _e('1.7.0', 'hero'); ?> -->
<!-- footer -->
<?php osc_current_web_theme_path('templates/footer/'.osc_get_preference('footer-vera', 'hero'). '.php') ; ?>
<!-- /footer -->
<a href="#0" class="cd-top">
    <?php _e("Top", 'hero');?> </a>
<script src="<?php echo osc_current_web_theme_js_url('metisMenu.min.js') ; ?>"></script>
<script src="<?php echo osc_current_web_theme_js_url('tuxedo-menu.js') ; ?>"></script>
<script src="<?php echo osc_current_web_theme_js_url('top.js') ; ?>"></script>
<script>
    (function ($) {
        var isFixed = true;
        $('#sidebar5').tuxedoMenu({isFixed: isFixed}).metisMenu({
            toggle: false,
            activeClass: 'active'
        });
        $('#toggle-is-fixed').on('click', function () {
            $('#sidebar5').tuxedoMenu({isFixed: isFixed = !isFixed});
            $('#menu-container').toggleClass('col-sm-3');
            $('.tuxedo-menu-trigger').toggleClass('hidden');
            $('#menu-style').html(isFixed ? 'Sidebar' : 'Drawer');
        });
    })(jQuery);
</script>
<?php osc_run_hook('footer') ; ?>