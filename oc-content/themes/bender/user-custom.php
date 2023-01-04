<?php


    // meta tag robots
    osc_add_hook('header','bender_nofollow_construct');

    bender_add_body_class('user user-custom');
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-sidebar.php');
    }
    osc_current_web_theme_path('header.php') ;

    osc_render_file();

    osc_current_web_theme_path('footer.php');
?>