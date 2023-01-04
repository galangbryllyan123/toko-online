<?php

?>
<?php osc_current_web_theme_path('header.php') ; ?>
<div class="content user-area">
    <div id="right-side">
        <?php osc_render_file(); ?>
    </div>
    <?php require('user_sidebar.php') ; ?>
    <div class="clear"></div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>