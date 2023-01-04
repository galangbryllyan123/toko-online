<?php
    

    // meta tag robots
    osc_add_hook('header','flux_nofollow_construct');

    flux_add_body_class('page');
    osc_current_web_theme_path('header.php') ;
?>
<div class="__mdl__static_page">
<h1><?php echo osc_static_page_title(); ?></h1>
<?php echo osc_static_page_text(); ?>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>