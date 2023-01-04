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
    <?php osc_current_web_theme_path('common/head.php') ; ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
</head>
<body>
    <?php osc_current_web_theme_path('header.php') ; ?>
    <div class="content error">
        <div class="container">
            <div class="notfound col-md-8">
                <i class="fa fa-ban veranda"></i>
                <h1><?php _e("Page not found", 'hero') ; ?></h1>
                <p class="nott2">
                    <?php _e("Sorry, an error has occured, Requested page not found!", 'hero') ; ?>
                </p>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php _e("<strong>Look</strong> for it in the most popular categories.", 'hero') ; ?></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nott">
                            <li>
                                <div class="categories">
                                    <?php osc_goto_first_category() ; ?>
                                    <?php while ( osc_has_categories() ) { ?>
                                    <h3><b><a class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?></a></b> <span>(<?php echo osc_category_total_items() ; ?>)</span></h3>
                                    <?php if ( osc_count_subcategories()> 0 ) { ?>
                                    <?php while ( osc_has_subcategories() ) { ?>
                                    <?php if( osc_category_total_items()> 0 ) { ?>
                                    <h3><a class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?></a> <span>(<?php echo osc_category_total_items() ; ?>)</span></h3>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>