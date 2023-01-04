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
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
    <?php osc_current_web_theme_path('common/head.php'); ?>
    <meta name="robots" content="index, follow" /> 
</head>
<body>
    <?php osc_current_web_theme_path('header.php') ; ?>
    <div class="container margin-top-10">
        <?php hero_show_flash_message() ; ?> </div>
    <?php osc_current_web_theme_path('templates/home/'.osc_get_preference('select-us', 'hero').'.php') ; ?>
    <?php osc_current_web_theme_path('footer.php') ; ?>
    <script src="<?php echo osc_current_web_theme_js_url('owl.carousel.js') ; ?>"></script>
    <script src="<?php echo osc_current_web_theme_js_url('jquery.bootstrap.newsbox.min.js') ; ?>"></script>
    <?php if(osc_get_preference('sect12_view', 'hero_theme')=="1" ) { ?>
    <script src="<?php echo osc_current_web_theme_js_url('power.js') ; ?>"></script>
    <?php } else { ?>
    <script src="<?php echo osc_current_web_theme_js_url('power2.js') ; ?>"></script>
    <?php } ?> 
</body>
</html>