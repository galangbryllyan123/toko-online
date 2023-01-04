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
<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<?php $google_fonts = osc_get_preference('google_fonts', 'hero_theme');?>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('admin/css/jquery.switchButton.css');?>">
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('admin/css/hero.css');?>">
<script src="<?php echo osc_current_web_theme_url('admin/js/jquery.switchButton.js');?>"></script>
<script src="<?php echo osc_current_web_theme_url('admin/jscolor/jscolor.js');?>"></script>
<div class="body">
    <div class="theme-hero">
        <div class="ari">
            <h2><?php _e('Hero Theme Settings', 'hero'); ?></h2> </div>
    </div>
    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/settings.php'); ?>" method="post" class="nocsrf">
        <input type="hidden" name="action_specific" value="settings" />
        <fieldset>
            <div id="tabs">
                <ul>
                    <li><a href="#general"><i class="fa fa-gear"></i> <?php _e('General', 'hero'); ?></a> </li>
                    <li><a href="#widget"><i class="fa fa-pencil"></i> <?php _e('Widget', 'hero'); ?></a> </li>
                    <li><a href="#social"><i class="fa fa-facebook"></i> <?php _e('Social', 'hero'); ?></a> </li>
                    <li><a href="#product"><i class="fa fa-tag"></i> <?php _e('Product', 'hero'); ?></a> </li>
                    <li><a href="#price"><i class="fa fa-money"></i> <?php _e('Price', 'hero'); ?></a> </li>
                    <li><a href="#ads"><i class="fa  fa-bullhorn"></i> <?php _e('Advertiser', 'hero'); ?></a> </li>
                    <li><a href="#slider"><i class="fa fa-film"></i> <?php _e('Slider', 'hero'); ?></a> </li>
                    <li><a href="#custom"><i class="fa fa-wrench"></i> <?php _e('Custom', 'hero'); ?></a> </li>
                    <li><a href="#font"><i class="fa fa-bold"></i> <?php _e('Font and color', 'hero'); ?></a> </li>
                    <li><a href="#more"><i class="fa fa-gears"></i> <?php _e('More', 'hero'); ?></a> </li>
                </ul>
                <div id="general">
                    <h2 class="render-title"><?php _e('Theme settings', 'hero'); ?></h2>
                    <div class="form-horizontal">
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Header Style', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="cc-selector">
                                    <input id="header1" type="radio" name="header-vera" value="header1" <?php echo (osc_esc_html( osc_get_preference( 'header-vera', 'hero') )=="header1" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc header1" for="header1"></label>
                                    <input id="header2" type="radio" name="header-vera" value="header2" <?php echo (osc_esc_html( osc_get_preference( 'header-vera', 'hero') )=="header2" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc header2" for="header2"></label>
                                    <input id="header3" type="radio" name="header-vera" value="header3" <?php echo (osc_esc_html( osc_get_preference( 'header-vera', 'hero') )=="header3" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc header3" for="header3"></label>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Home Style', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="cc-selector">
                                    <input id="home1" type="radio" name="select-us" value="home1" <?php echo (osc_esc_html( osc_get_preference( 'select-us', 'hero') )=="home1" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc home1" for="home1"></label>
                                    <input id="home2" type="radio" name="select-us" value="home2" <?php echo (osc_esc_html( osc_get_preference( 'select-us', 'hero') )=="home2" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc home2" for="home2"></label>
                                    <input id="home3" type="radio" name="select-us" value="home3" <?php echo (osc_esc_html( osc_get_preference( 'select-us', 'hero') )=="home3" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc home3" for="home3"></label>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Footer Style', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="cc-selector">
                                    <input id="footer1" type="radio" name="footer-vera" value="footer1" <?php echo (osc_esc_html( osc_get_preference( 'footer-vera', 'hero') )=="footer1" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc footer1" for="footer1"></label>
                                    <input id="footer2" type="radio" name="footer-vera" value="footer2" <?php echo (osc_esc_html( osc_get_preference( 'footer-vera', 'hero') )=="footer2" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc footer2" for="footer2"></label>
                                    <input id="footer3" type="radio" name="footer-vera" value="footer3" <?php echo (osc_esc_html( osc_get_preference( 'footer-vera', 'hero') )=="footer3" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc footer3" for="footer3"></label>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Product Style', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="cc-selector">
                                    <input id="single1" type="radio" name="single-vera" value="single1" <?php echo (osc_esc_html( osc_get_preference( 'single-vera', 'hero') )=="single1" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc single1" for="single1"></label>
                                    <input id="single2" type="radio" name="single-vera" value="single2" <?php echo (osc_esc_html( osc_get_preference( 'single-vera', 'hero') )=="single2" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc single2" for="single2"></label>
                                    <input id="single3" type="radio" name="single-vera" value="single3" <?php echo (osc_esc_html( osc_get_preference( 'single-vera', 'hero') )=="single3" )? "checked": ""; ?>/>
                                    <label class="drinkcard-cc single3" for="single3"></label>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Search', 'hero'); ?> </div>
                            <div class="form-controls">
                                <?php $search_stl=osc_esc_html( osc_get_preference( 'inc-vera', 'hero') ); ?>
                                <select name="inc-vera">
                                    <option value="country" <?php if($search_stl=='country' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Country', 'hero'); ?> </option>
                                    <option value="region" <?php if($search_stl=='region' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Region', 'hero'); ?> </option>
                                    <option value="city" <?php if($search_stl=='city' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('City', 'hero'); ?> </option>
                                    <option value="category" <?php if($search_stl=='category' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Category', 'hero'); ?> </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Search Placeholder', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="keyword_placeholder" value="<?php echo osc_esc_html( osc_get_preference('keyword_placeholder', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Footer Copyright', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="copyright-us"><?php echo osc_esc_html( osc_get_preference( 'copyright-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('Copyright text on footer.', 'hero'); ?> </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- # widget starts -->
                <div id="widget">
                    <h2 class="render-title"><?php _e('Widget settings', 'hero'); ?></h2>
                    <div class="form-horizontal">
                        
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Title Footer', 'hero'); ?> <?php _e('1', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="judul1-us" value="<?php echo osc_esc_html( osc_get_preference('judul1-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Widget on Footer', 'hero'); ?> <?php _e('1', 'hero'); ?></div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="footer-us1"><?php echo osc_esc_html( osc_get_preference( 'footer-us1', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('You can add widget on footer with your custom widget ex: facebook widget or twitter widget.', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Title Footer', 'hero'); ?> <?php _e('2', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="judul2-us" value="<?php echo osc_esc_html( osc_get_preference('judul2-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Widget on Footer', 'hero'); ?> <?php _e('2', 'hero'); ?></div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="footer-us2"><?php echo osc_esc_html( osc_get_preference( 'footer-us2', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('You can add widget on footer with your custom widget ex: facebook widget or twitter widget.', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Title Footer', 'hero'); ?> <?php _e('3', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="judul3-us" value="<?php echo osc_esc_html( osc_get_preference('judul3-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Widget on Footer', 'hero'); ?> <?php _e('3', 'hero'); ?></div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="footer-us3"><?php echo osc_esc_html( osc_get_preference( 'footer-us3', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('You can add widget on footer with your custom widget ex: facebook widget or twitter widget.', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Title Footer', 'hero'); ?> <?php _e('4', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="judul4-us" value="<?php echo osc_esc_html( osc_get_preference('judul4-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Widget on Footer', 'hero'); ?> <?php _e('4', 'hero'); ?></div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="footer-us4"><?php echo osc_esc_html( osc_get_preference( 'footer-us4', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('You can add widget on footer with your custom widget ex: facebook widget or twitter widget.', 'hero'); ?> </div>
                            </div>
                        </div>
                        <h2 class="render-title"><?php _e('Information', 'hero'); ?></h2>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Title Useful Information', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="judul6-us" value="<?php echo osc_esc_html( osc_get_preference('judul6-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Useful Information', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="footer-us6" placeholder="<?php echo osc_esc_html(__('Add text for useful information.','hero')); ?>"><?php echo osc_esc_html( osc_get_preference( 'footer-us6', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('Add text for useful information.', 'hero'); ?> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- # social starts -->
                <div id="social">
                    <h2 class="render-title"><?php _e('Social settings', 'hero'); ?></h2>
                    <div class="form-horizontal">
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Facebook Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="facebook-us" placeholder="<?php echo osc_esc_html(__('http://facebook.com/osclass','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('facebook-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Twitter Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="twitter-us" placeholder="<?php echo osc_esc_html(__('http://twitter.com/osclass','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('twitter-us', 'hero') ); ?>"> </div>
                        </div>
                         <div class="form-row">
                            <div class="form-label">
                                <?php _e('Instagram Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="instagram-us" placeholder="<?php echo osc_esc_html(__('http://instagram.com/osclass','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('instagram-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Google plus link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="gplus-us" placeholder="<?php echo osc_esc_html(__('http://plus.google.com/osclass','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('gplus-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e( 'Linkedin link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="linkedin-us" placeholder="<?php echo osc_esc_html(__('http://linkedin.com/osclass','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('linkedin-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e( 'Youtube link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="youtube-us" placeholder="<?php echo osc_esc_html(__('http://youtube.com/osclass','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('youtube-us', 'hero') ); ?>"> </div>
                        </div>
                    </div>
                </div>
                <!-- # product starts -->
                <div id="product">
                    <h2 class="render-title"><?php _e('Product settings', 'hero'); ?></h2>
                    <div class="form-horizontal">
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Show lists as', 'hero'); ?> </div>
                            <div class="form-controls">
                                <select name="defaultShowAs@all">
                                    <option value="gallery" <?php if(hero_default_show_as()=='gallery' ){ echo 'selected="selected"' ;}?>>
                                        <?php _e('Gallery', 'hero'); ?> </option>
                                    <option value="list" <?php if(hero_default_show_as()=='list' ){ echo 'selected="selected"' ;}?>>
                                        <?php _e('List', 'hero'); ?> </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Latest Ads', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="latest_num_ads" placeholder="<?php echo osc_esc_html(__('8','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('latest_num_ads', 'hero') ); ?>">
                                <br>
                                <div class="help-box">
                                    <?php _e( 'Amount of the Latest ads', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e( 'Slider Premium Ads', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="popularads_num_ads" placeholder="<?php echo osc_esc_html(__('8','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('popularads_num_ads', 'hero') ); ?>">
                                <br>
                                <div class="help-box">
                                    <?php _e('Amount of the premium ads', 'hero'); ?> </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Search Premium Ads', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="premiumads_search_ads" placeholder="<?php echo osc_esc_html(__('8','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('premiumads_search_ads', 'hero') ); ?>">
                                <br>
                                <div class="help-box">
                                    <?php _e('Amount of the search page premium ads', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Related Ads', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="related" placeholder="<?php echo osc_esc_html(__('6','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('related', 'hero') ); ?>">
                                <br>
                                <div class="help-box">
                                    <?php _e('Amount of the related ads', 'hero'); ?> </div>
                            </div>
                        </div>
                        <h2 class="render-title"><?php _e('Content display', 'hero'); ?></h2>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Premium Ads Display', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" name="sect1_view" value="1" <?php echo (osc_esc_html( osc_get_preference( 'sect1_view', 'hero_theme') )=="1" )? "checked": ""; ?>>
                                    <br/>
                                    <div class="help-box">
                                        <?php _e('Show or hide', 'hero'); ?>
                                        <?php _e('Premium Ads', 'hero'); ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Latest Ads Display', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" name="sect2_view" value="1" <?php echo (osc_esc_html( osc_get_preference( 'sect2_view', 'hero_theme') )=="1" )? "checked": ""; ?>>
                                    <br/>
                                    <div class="help-box">
                                        <?php _e('Show or hide', 'hero'); ?>
                                        <?php _e('Latest Ads', 'hero'); ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Item post multilanguages', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" name="multi_view" value="1" <?php echo (osc_esc_html( osc_get_preference( 'multi_view', 'hero_theme') )=="1" )? "checked": ""; ?>>
                                    <br/>
                                    <div class="help-box">
                                        <?php _e('Activate', 'hero'); ?>
                                        <?php _e('Item post multilanguages', 'hero'); ?> </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Brand Display', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" name="sect5_view" value="1" <?php echo (osc_esc_html( osc_get_preference( 'sect5_view', 'hero_theme') )=="1" )? "checked": ""; ?>>
                                    <br/>
                                    <div class="help-box">
                                        <?php _e('Show or hide', 'hero'); ?>
                                        <?php _e('Brand slider', 'hero'); ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Price table Display', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" name="sect6_view" value="1" <?php echo (osc_esc_html( osc_get_preference( 'sect6_view', 'hero_theme') )=="1" )? "checked": ""; ?>>
                                    <br/>
                                    <div class="help-box">
                                        <?php _e('Show or hide', 'hero'); ?>
                                        <?php _e('Price table', 'hero'); ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Auto Play Product Slider', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" name="sect12_view" value="1" <?php echo (osc_esc_html( osc_get_preference( 'sect12_view', 'hero_theme') )=="1" )? "checked": ""; ?>>
                                    <br/>
                                    <div class="help-box">
                                        <?php _e('Auto Play Product Slider', 'hero'); ?> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- # ads starts -->
                <div id="ads">
                    <h2 class="render-title"><?php _e('Ads settings', 'hero'); ?></h2>
                    <div class="form-horizontal">
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Header Ads', 'hero'); ?> 728x90</div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="header-728x90"><?php echo osc_esc_html( osc_get_preference( 'header-728x90', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('This ad will be shown at the top of your website, next to the site title and above the search results. Note that the size of the ad has to be 728x90 pixels.', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Footer Ads', 'hero'); ?> 728x90</div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="homepage-728x90"><?php echo osc_esc_html( osc_get_preference( 'homepage-728x90', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e( 'This ad will be shown on the footer of your website. Note that the size of the ad has to be 728x90 pixels.', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Search results page', 'hero'); ?> <?php _e('728x90', 'hero'); ?></div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="search-results-top-728x90"><?php echo osc_esc_html( osc_get_preference( 'search-results-top-728x90', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('This ad will be shown among the search results of your site. Note that the size of the ad has to be 728x90 pixels.', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Sidebar Left', 'hero'); ?> <?php _e('250x250', 'hero'); ?></div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="sidebar-160x600"><?php echo osc_esc_html( osc_get_preference( 'sidebar-160x600', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('This ad will be shown at the right sidebar of your website. Note that the size of the ad has to be 160x600 pixels.', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Sidebar Right', 'hero'); ?> <?php _e('250x250', 'hero'); ?></div>
                            <div class="form-controls"><textarea class="cantiki" name="sidebar-300x250">
                                    <?php echo osc_esc_html( osc_get_preference( 'sidebar-300x250', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('This ad will be shown at the right sidebar of your website. Note that the size of the ad has to be 300x350 pixels.', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Sidebar Ads Member Area', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="ads-member"><?php echo osc_esc_html( osc_get_preference( 'ads-member', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('This ad will be shown on the sidebar of your member area.', 'hero'); ?> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- # slider starts -->
                <div id="slider">
                    <div class="form-horizontal">
                        
                        <div class="form-row">
                            <h1 class="render-title separate-top"><?php _e('Slider Title and Links', 'hero'); ?></h1> </div>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider11.jpg" ) ) {?><div class="form-row">
                            <div class="form-label"><b><?php _e('Slider text', 'hero'); ?> <?php _e('1', 'hero'); ?></b> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="slider1-us" placeholder="<?php echo osc_esc_html(__('welcome to classifieds','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('slider1-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Slider Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" name="slider12-link" value="<?php echo osc_esc_html( osc_get_preference('slider12-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider22.jpg" ) ) {?>
                        <div class="form-row">
                            <div class="form-label"><b><?php _e('Slider text', 'hero'); ?> <?php _e('2', 'hero'); ?></b> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="slider2-us" placeholder="<?php echo osc_esc_html(__('welcome to classifieds','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('slider2-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Slider Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" name="slider22-link" value="<?php echo osc_esc_html( osc_get_preference('slider22-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider33.jpg" ) ) {?>
                        <div class="form-row">
                            <div class="form-label"><b><?php _e('Slider text', 'hero'); ?> <?php _e('3', 'hero'); ?></b> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="slider3-us" placeholder="<?php echo osc_esc_html(__('welcome to classifieds','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('slider3-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Slider Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" name="slider32-link" value="<?php echo osc_esc_html( osc_get_preference('slider32-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider44.jpg" ) ) {?>
                        <div class="form-row">
                            <div class="form-label"><b><?php _e('Slider text', 'hero'); ?> <?php _e('4', 'hero'); ?></b> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="slider4-us" placeholder="<?php echo osc_esc_html(__('welcome to classifieds','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('slider4-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Slider Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" name="slider42-link" value="<?php echo osc_esc_html( osc_get_preference('slider42-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                     <div class="form-row">
<h1 class="render-title separate-top"><?php _e('Brand Links', 'hero'); ?></h1> </div>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/1.jpg" ) ) {?>
                        
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Brand Link', 'hero'); ?> <?php _e('1', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="brand1-link" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('brand1-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/2.jpg" ) ) {?>
                       
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Brand Link', 'hero'); ?> <?php _e('2', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="brand2-link" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('brand2-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/3.jpg" ) ) {?>
                        
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Brand Link', 'hero'); ?> <?php _e('3', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="brand3-link" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('brand3-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/4.jpg" ) ) {?>
                        
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Brand Link', 'hero'); ?> <?php _e('4', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="brand4-link" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('brand4-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/5.jpg" ) ) {?>
                        
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Brand Link', 'hero'); ?> <?php _e('5', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="brand5-link" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('brand5-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/6.jpg" ) ) {?>
                       
                       <div class="form-row">
                            <div class="form-label">
                                <?php _e('Brand Link', 'hero'); ?> <?php _e('6', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="brand6-link" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('brand6-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/7.jpg" ) ) {?>
                        
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Brand Link', 'hero'); ?> <?php _e('7', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="brand7-link" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('brand7-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/8.jpg" ) ) {?>
                        
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Brand Link', 'hero'); ?> <?php _e('8', 'hero'); ?></div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="brand8-link" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('brand8-link', 'hero') ); ?>"> </div>
                        </div><?php } ?>
                    </div>
                </div>
                <!-- # custom starts -->
                <div id="custom">
                    <h2 class="render-title"><?php _e('Custom settings', 'hero'); ?></h2>
                    <div class="form-horizontal">
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Custom CSS', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="address-us"><?php echo osc_esc_html( osc_get_preference( 'address-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can costumize css.', 'hero'); ?> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- # price starts -->
                <div id="price">
                    <h2 class="render-title"><?php _e('Price settings', 'hero'); ?></h2>
                    <div class="form-horizontal">
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Price 1', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="price1-us"><?php echo osc_esc_html( osc_get_preference( 'price1-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can settings price', 'hero'); ?> </div>
                            </div>
                        </div>
                         <div class="form-row">
                            <div class="form-label">
                                <?php _e('Description Price 1', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="price2-us"><?php echo osc_esc_html( osc_get_preference( 'price2-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can settings description price 1', 'hero'); ?> </div>
                            </div>
                        </div>
                              <div class="form-row">
                            <div class="form-label">
                                <?php _e('Content Price 1', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="price3-us"><?php echo osc_esc_html( osc_get_preference( 'price3-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can settings content price 1', 'hero'); ?> </div>
                            </div>
                        </div>   
                      <div class="form-row">
                            <div class="form-label"><b><?php _e('Button text', 'hero'); ?></b> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="price4-us" placeholder="<?php echo osc_esc_html(__('Detail','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('price4-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Button Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" name="price5-us" value="<?php echo osc_esc_html( osc_get_preference('price5-us', 'hero') ); ?>"> </div>
                        </div>



 <div class="form-row">
                            <div class="form-label">
                                <?php _e('Price 2', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="price6-us"><?php echo osc_esc_html( osc_get_preference( 'price6-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can settings price 2', 'hero'); ?> </div>
                            </div>
                        </div>
                         <div class="form-row">
                            <div class="form-label">
                                <?php _e('Description Price 2', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="price7-us"><?php echo osc_esc_html( osc_get_preference( 'price7-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can settings description price 2', 'hero'); ?> </div>
                            </div>
                        </div>
                              <div class="form-row">
                            <div class="form-label">
                                <?php _e('Content Price 2', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="price8-us"><?php echo osc_esc_html( osc_get_preference('price8-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can settings content price 2', 'hero'); ?> </div>
                            </div>
                        </div>   
                      <div class="form-row">
                            <div class="form-label"><b><?php _e('Button text', 'hero'); ?></b> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="price9-us" placeholder="<?php echo osc_esc_html(__('Detail','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('price9-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Button Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" name="price10-us" value="<?php echo osc_esc_html( osc_get_preference('price10-us', 'hero') ); ?>"> </div>
                        </div>

 <div class="form-row">
                            <div class="form-label">
                                <?php _e('Price 3', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="price11-us"><?php echo osc_esc_html( osc_get_preference( 'price11-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can settings price 3', 'hero'); ?> </div>
                            </div>
                        </div>
                         <div class="form-row">
                            <div class="form-label">
                                <?php _e('Description Price 3', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="price12-us"><?php echo osc_esc_html( osc_get_preference( 'price12-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can settings description price 3', 'hero'); ?> </div>
                            </div>
                        </div>
                              <div class="form-row">
                            <div class="form-label">
                                <?php _e('Content Price 3', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="price13-us"><?php echo osc_esc_html( osc_get_preference( 'price13-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can settings content price 3', 'hero'); ?> </div>
                            </div>
                        </div>   
                      <div class="form-row">
                            <div class="form-label"><b><?php _e('Button text', 'hero'); ?></b> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="price14-us" placeholder="<?php echo osc_esc_html(__('Detail','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('price14-us', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Button Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" name="price15-us" value="<?php echo osc_esc_html( osc_get_preference('price15-us', 'hero') ); ?>"> </div>
                        </div>


                    </div>
                </div>
                <!-- # font starts -->
                <div id="font">
                    <h2 class="render-title"><?php _e('Font and Color settings', 'hero'); ?></h2>
                    <div class="form-horizontal">
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Customize Panel', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" name="font_view" value="1" <?php echo (osc_esc_html( osc_get_preference( 'font_view', 'hero_theme') )=="1" )? "checked": ""; ?>> </div>
                                <br/>
                                <div class="help-box">
                                    <?php _e('Switch on to activate custom font and color.', 'hero'); ?> </div>
                            </div>
                        </div>
                         <div class="form-row">
                            <div class="form-label">
                                <?php _e('Font Style', 'hero'); ?> </div>
                            <div class="form-controls">
                                <?php $fon_stl=osc_esc_html( osc_get_preference( 'status-font', 'hero') ); ?>
                                <select name="status-font">
                                    <option value="google" <?php if($fon_stl=='google' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Google font', 'hero'); ?> </option>
                                    <option value="standart" <?php if($fon_stl=='standart' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Standart font', 'hero'); ?> </option>
                                </select><div class="help-box">
                                    <?php _e('You can select google font or standart font.', 'hero'); ?> </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Standart font', 'hero'); ?> </div>
                            <div class="form-controls">
                                <?php $stf_stl=osc_esc_html( osc_get_preference( 'ari-font', 'hero') ); ?>
                                <select name="ari-font">
                                    <option value="Arial" <?php if($stf_stl=='Arial' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Arial', 'hero'); ?> </option>
                                    <option value="Georgia" <?php if($stf_stl=='Georgia' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Georgia', 'hero'); ?> </option>
                                    <option value="Courier" <?php if($stf_stl=='Courier' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Courier', 'hero'); ?> </option>
                                    <option value="Verdana" <?php if($stf_stl=='Verdana' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Verdana', 'hero'); ?> </option>
                                    <option value="Tahoma" <?php if($stf_stl=='Tahoma' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Tahoma', 'hero'); ?> </option>
                                    <option value="Impact" <?php if($stf_stl=='Impact' ){ echo 'selected="selected"' ; } ?>>
                                        <?php _e('Impact', 'hero'); ?> </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Google font', 'hero'); ?> </div>
                            <div class="form-controls">
                                <select name="google_fonts">
                                    <option value="Abel" <?php if($google_fonts=="Abel" ){ echo "selected='selected'" ; } ?>><?php _e( 'Abel', 'hero'); ?></option>
                                    <option value="Abril+Fatface" <?php if($google_fonts=="Abril+Fatface" ){ echo "selected='selected'" ; } ?>><?php _e( 'Abril Fatface', 'hero'); ?></option>
                                    <option value="Aclonica" <?php if($google_fonts=="Aclonica" ){ echo "selected='selected'" ; } ?>><?php _e( 'Aclonica', 'hero'); ?></option>
                                    <option value="Actor" <?php if($google_fonts=="Actor" ){ echo "selected='selected'" ; } ?>><?php _e( 'Actor', 'hero'); ?></option>
                                    <option value="Adamina" <?php if($google_fonts=="Adamina" ){ echo "selected='selected'" ; } ?>><?php _e( 'Adamina', 'hero'); ?></option>
                                    <option value="Aguafina+Script" <?php if($google_fonts=="Aguafina+Script" ){ echo "selected='selected'" ; } ?>><?php _e( 'Aguafina Script', 'hero'); ?></option>
                                    <option value="Aladin" <?php if($google_fonts=="Aladin" ){ echo "selected='selected'" ; } ?>><?php _e( 'Aladin', 'hero'); ?></option>
                                    <option value="Aldrich" <?php if($google_fonts=="Aldrich" ){ echo "selected='selected'" ; } ?>><?php _e( 'Aldrich', 'hero'); ?></option>
                                    <option value="Alice" <?php if($google_fonts=="Alice" ){ echo "selected='selected'" ; } ?>><?php _e( 'Alice', 'hero'); ?></option>
                                    <option value="Alike+Angular" <?php if($google_fonts=="Alike+Angular" ){ echo "selected='selected'" ; } ?>><?php _e( 'Alike Angular', 'hero'); ?></option>
                                    <option value="Alike" <?php if($google_fonts=="Alike" ){ echo "selected='selected'" ; } ?>><?php _e( 'Alike', 'hero'); ?></option>
                                    <option value="Allan" <?php if($google_fonts=="Allan" ){ echo "selected='selected'" ; } ?>><?php _e( 'Allan', 'hero'); ?></option>
                                    <option value="Allerta+Stencil" <?php if($google_fonts=="Allerta+Stencil" ){ echo "selected='selected'" ; } ?>><?php _e( 'Allerta Stencil', 'hero'); ?></option>
                                    <option value="Allerta" <?php if($google_fonts=="Allerta" ){ echo "selected='selected'" ; } ?>><?php _e( 'Allerta', 'hero'); ?></option>
                                    <option value="Amaranth" <?php if($google_fonts=="Amaranth" ){ echo "selected='selected'" ; } ?>><?php _e( 'Amaranth', 'hero'); ?></option>
                                    <option value="Amatic+SC" <?php if($google_fonts=="Amatic+SC" ){ echo "selected='selected'" ; } ?>><?php _e( 'Amatic SC', 'hero'); ?></option>
                                    <option value="Andada" <?php if($google_fonts=="Andada" ){ echo "selected='selected'" ; } ?>><?php _e( 'Andada', 'hero'); ?></option>
                                    <option value="Andika" <?php if($google_fonts=="Andika" ){ echo "selected='selected'" ; } ?>><?php _e( 'Andika', 'hero'); ?></option>
                                    <option value="Annie+Use+Your+Telescope" <?php if($google_fonts=="Annie+Use+Your+Telescope" ){ echo "selected='selected'" ; } ?>><?php _e( 'Annie Use Your Telescope', 'hero'); ?></option>
                                    <option value="Anonymous+Pro" <?php if($google_fonts=="Anonymous+Pro" ){ echo "selected='selected'" ; } ?>><?php _e( 'Anonymous Pro', 'hero'); ?></option>
                                    <option value="Antic" <?php if($google_fonts=="Antic" ){ echo "selected='selected'" ; } ?>><?php _e( 'Antic', 'hero'); ?></option>
                                    <option value="Anton" <?php if($google_fonts=="Anton" ){ echo "selected='selected'" ; } ?>><?php _e( 'Anton', 'hero'); ?></option>
                                    <option value="Arapey" <?php if($google_fonts=="Arapey" ){ echo "selected='selected'" ; } ?>><?php _e( 'Arapey', 'hero'); ?></option>
                                    
                                    <option value="Architects+Daughter" <?php if($google_fonts=="Architects+Daughter" ){ echo "selected='selected'" ; } ?>><?php _e( 'Architects Daughter', 'hero'); ?></option>
                                    <option value="Arimo" <?php if($google_fonts=="Arimo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Arimo', 'hero'); ?></option>
                                    <option value="Artifika" <?php if($google_fonts=="Artifika" ){ echo "selected='selected'" ; } ?>><?php _e( 'Artifika', 'hero'); ?></option>
                                    <option value="Arvo" <?php if($google_fonts=="Arvo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Arvo', 'hero'); ?></option>
                                    <option value="Asset" <?php if($google_fonts=="Asset" ){ echo "selected='selected'" ; } ?>><?php _e( 'Asset', 'hero'); ?></option>
                                    <option value="Astloch" <?php if($google_fonts=="Astloch" ){ echo "selected='selected'" ; } ?>><?php _e( 'Astloch', 'hero'); ?></option>
                                    <option value="Atomic+Age" <?php if($google_fonts=="Atomic+Age" ){ echo "selected='selected'" ; } ?>><?php _e( 'Atomic Age', 'hero'); ?></option>
                                    <option value="Aubrey" <?php if($google_fonts=="Aubrey" ){ echo "selected='selected'" ; } ?>><?php _e( 'Aubrey', 'hero'); ?></option>
                                    <option value="Bangers" <?php if($google_fonts=="Bangers" ){ echo "selected='selected'" ; } ?>><?php _e( 'Bangers', 'hero'); ?></option>
                                    <option value="Bentham" <?php if($google_fonts=="Bentham" ){ echo "selected='selected'" ; } ?>><?php _e( 'Bentham', 'hero'); ?></option>
                                    <option value="Bevan" <?php if($google_fonts=="Bevan" ){ echo "selected='selected'" ; } ?>><?php _e( 'Bevan', 'hero'); ?></option>
                                    <option value="Bigshot+One" <?php if($google_fonts=="Bigshot+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Bigshot One', 'hero'); ?></option>
                                    <option value="Bitter" <?php if($google_fonts=="Bitter" ){ echo "selected='selected'" ; } ?>><?php _e( 'Bitter', 'hero'); ?></option>
                                    <option value="Black+Ops+One" <?php if($google_fonts=="Black+Ops+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Black Ops One', 'hero'); ?></option>
                                    <option value="Bowlby+One+SC" <?php if($google_fonts=="Bowlby+One+SC" ){ echo "selected='selected'" ; } ?>><?php _e( 'Bowlby One SC', 'hero'); ?></option>
                                    <option value="Bowlby+One" <?php if($google_fonts=="Bowlby+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Bowlby One', 'hero'); ?></option>
                                    <option value="Brawler" <?php if($google_fonts=="Brawler" ){ echo "selected='selected'" ; } ?>><?php _e( 'Brawler', 'hero'); ?></option>
                                    <option value="Bubblegum+Sans" <?php if($google_fonts=="Bubblegum+Sans" ){ echo "selected='selected'" ; } ?>><?php _e( 'Bubblegum Sans', 'hero'); ?></option>
                                    <option value="Buda" <?php if($google_fonts=="Buda" ){ echo "selected='selected'" ; } ?>><?php _e( 'Buda', 'hero'); ?></option>
                                    <option value="Butcherman+Caps" <?php if($google_fonts=="Butcherman+Caps" ){ echo "selected='selected'" ; } ?>><?php _e( 'Butcherman Caps', 'hero'); ?></option>
                                    <option value="Cabin+Condensed" <?php if($google_fonts=="Cabin+Condensed" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cabin Condensed', 'hero'); ?></option>
                                    <option value="Cabin+Sketch" <?php if($google_fonts=="Cabin+Sketch" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cabin Sketch', 'hero'); ?></option>
                                    <option value="Cabin" <?php if($google_fonts=="Cabin" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cabin', 'hero'); ?></option>
                                    <option value="Cagliostro" <?php if($google_fonts=="Cagliostro" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cagliostro', 'hero'); ?></option>
                                    <option value="Calligraffitti" <?php if($google_fonts=="Calligraffitti" ){ echo "selected='selected'" ; } ?>><?php _e( 'Calligraffitti', 'hero'); ?></option>
                                    <option value="Candal" <?php if($google_fonts=="Candal" ){ echo "selected='selected'" ; } ?>><?php _e( 'Candal', 'hero'); ?></option>
                                    <option value="Cantarell" <?php if($google_fonts=="Cantarell" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cantarell', 'hero'); ?></option>
                                    <option value="Cardo" <?php if($google_fonts=="Cardo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cardo', 'hero'); ?></option>
                                    <option value="Carme" <?php if($google_fonts=="Carme" ){ echo "selected='selected'" ; } ?>><?php _e( 'Carme', 'hero'); ?></option>
                                    <option value="Carter+One" <?php if($google_fonts=="Carter+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Carter One', 'hero'); ?></option>
                                    <option value="Caudex" <?php if($google_fonts=="Caudex" ){ echo "selected='selected'" ; } ?>><?php _e( 'Caudex', 'hero'); ?></option>
                                    <option value="Cedarville+Cursive" <?php if($google_fonts=="Cedarville+Cursive" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cedarville Cursive', 'hero'); ?></option>
                                    <option value="Changa+One" <?php if($google_fonts=="Changa+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Changa One', 'hero'); ?></option>
                                    <option value="Cherry+Cream+Soda" <?php if($google_fonts=="Cherry+Cream+Soda" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cherry Cream Soda', 'hero'); ?></option>
                                    <option value="Chewy" <?php if($google_fonts=="Chewy" ){ echo "selected='selected'" ; } ?>><?php _e( 'Chewy', 'hero'); ?></option>
                                    <option value="Chicle" <?php if($google_fonts=="Chicle" ){ echo "selected='selected'" ; } ?>><?php _e( 'Chicle', 'hero'); ?></option>
                                    <option value="Chivo" <?php if($google_fonts=="Chivo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Chivo', 'hero'); ?></option>
                                    <option value="Coda+Caption" <?php if($google_fonts=="Coda+Caption" ){ echo "selected='selected'" ; } ?>><?php _e( 'Coda Caption', 'hero'); ?></option>
                                    <option value="Coda" <?php if($google_fonts=="Coda" ){ echo "selected='selected'" ; } ?>><?php _e( 'Coda', 'hero'); ?></option>
                                    <option value="Comfortaa" <?php if($google_fonts=="Comfortaa" ){ echo "selected='selected'" ; } ?>><?php _e( 'Comfortaa', 'hero'); ?></option>
                                    <option value="Coming+Soon" <?php if($google_fonts=="Coming+Soon" ){ echo "selected='selected'" ; } ?>><?php _e( 'Coming Soon', 'hero'); ?></option>
                                    <option value="Contrail+One" <?php if($google_fonts=="Contrail+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Contrail One', 'hero'); ?></option>
                                    <option value="Convergence" <?php if($google_fonts=="Convergence" ){ echo "selected='selected'" ; } ?>><?php _e( 'Convergence', 'hero'); ?></option>
                                    <option value="Cookie" <?php if($google_fonts=="Cookie" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cookie', 'hero'); ?></option>
                                    <option value="Copse" <?php if($google_fonts=="Copse" ){ echo "selected='selected'" ; } ?>><?php _e( 'Copse', 'hero'); ?></option>
                                    <option value="Corben" <?php if($google_fonts=="Corben" ){ echo "selected='selected'" ; } ?>><?php _e( 'Corben', 'hero'); ?></option>
                                    <option value="Cousine" <?php if($google_fonts=="Cousine" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cousine', 'hero'); ?></option>
                                    <option value="Coustard" <?php if($google_fonts=="Coustard" ){ echo "selected='selected'" ; } ?>><?php _e( 'Coustard', 'hero'); ?></option>
                                    <option value="Covered+By+Your+Grace" <?php if($google_fonts=="Covered+By+Your+Grace" ){ echo "selected='selected'" ; } ?>><?php _e( 'Covered By Your Grace', 'hero'); ?></option>
                                    <option value="Crafty+Girls" <?php if($google_fonts=="Crafty+Girls" ){ echo "selected='selected'" ; } ?>><?php _e( 'Crafty Girls', 'hero'); ?></option>
                                    <option value="Creepster+Caps" <?php if($google_fonts=="Creepster+Caps" ){ echo "selected='selected'" ; } ?>><?php _e( 'Creepster Caps', 'hero'); ?></option>
                                    <option value="Crimson+Text" <?php if($google_fonts=="Crimson+Text" ){ echo "selected='selected'" ; } ?>><?php _e( 'Crimson Text', 'hero'); ?></option>
                                    <option value="Crushed" <?php if($google_fonts=="Crushed" ){ echo "selected='selected'" ; } ?>><?php _e( 'Crushed', 'hero'); ?></option>
                                    <option value="Cuprum" <?php if($google_fonts=="Cuprum" ){ echo "selected='selected'" ; } ?>><?php _e( 'Cuprum', 'hero'); ?></option>
                                    <option value="Damion" <?php if($google_fonts=="Damion" ){ echo "selected='selected'" ; } ?>><?php _e( 'Damion', 'hero'); ?></option>
                                    <option value="Dancing+Script" <?php if($google_fonts=="Dancing+Script" ){ echo "selected='selected'" ; } ?>><?php _e( 'Dancing Script', 'hero'); ?></option>
                                    <option value="Dawning+of+a+New+Day" <?php if($google_fonts=="Dawning+of+a+New+Day" ){ echo "selected='selected'" ; } ?>><?php _e( 'Dawning of a New Day', 'hero'); ?></option>
                                    <option value="Days+One" <?php if($google_fonts=="Days+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Days One', 'hero'); ?></option>
                                    <option value="Delius+Swash+Caps" <?php if($google_fonts=="Delius+Swash+Caps" ){ echo "selected='selected'" ; } ?>><?php _e( 'Delius Swash Caps', 'hero'); ?></option>
                                    <option value="Delius+Unicase" <?php if($google_fonts=="Delius+Unicase" ){ echo "selected='selected'" ; } ?>><?php _e( 'Delius Unicase', 'hero'); ?></option>
                                    <option value="Delius" <?php if($google_fonts=="Delius" ){ echo "selected='selected'" ; } ?>><?php _e( 'Delius', 'hero'); ?></option>
                                    <option value="Devonshire" <?php if($google_fonts=="Devonshire" ){ echo "selected='selected'" ; } ?>><?php _e( 'Devonshire', 'hero'); ?></option>
                                    <option value="Didact+Gothic" <?php if($google_fonts=="Didact+Gothic" ){ echo "selected='selected'" ; } ?>><?php _e( 'Didact Gothic', 'hero'); ?></option>
                                    <option value="Dorsa" <?php if($google_fonts=="Dorsa" ){ echo "selected='selected'" ; } ?>><?php _e( 'Dorsa', 'hero'); ?></option>
                                    <option value="Dr+Sugiyama" <?php if($google_fonts=="Dr+Sugiyama" ){ echo "selected='selected'" ; } ?>><?php _e( 'Dr Sugiyama', 'hero'); ?></option>
                                    <option value="Droid+Sans+Mono" <?php if($google_fonts=="Droid+Sans+Mono" ){ echo "selected='selected'" ; } ?>><?php _e( 'Droid Sans Mono', 'hero'); ?></option>
                                    <option value="Droid+Sans" <?php if($google_fonts=="Droid+Sans" ){ echo "selected='selected'" ; } ?>><?php _e( 'Droid Sans', 'hero'); ?></option>
                                    <option value="Droid+Serif" <?php if($google_fonts=="Droid+Serif" ){ echo "selected='selected'" ; } ?>><?php _e( 'Droid Serif', 'hero'); ?></option>
                                    <option value="EB+Garamond" <?php if($google_fonts=="EB+Garamond" ){ echo "selected='selected'" ; } ?>><?php _e( 'EB Garamond', 'hero'); ?></option>
                                    <option value="Eater+Caps" <?php if($google_fonts=="Eater+Caps" ){ echo "selected='selected'" ; } ?>><?php _e( 'Eater Caps', 'hero'); ?></option>
                                    <option value="Expletus+Sans" <?php if($google_fonts=="Expletus+Sans" ){ echo "selected='selected'" ; } ?>><?php _e( 'Expletus Sans', 'hero'); ?></option>
                                    <option value="Fanwood+Text" <?php if($google_fonts=="Fanwood+Text" ){ echo "selected='selected'" ; } ?>><?php _e( 'Fanwood Text', 'hero'); ?></option>
                                    <option value="Federant" <?php if($google_fonts=="Federant" ){ echo "selected='selected'" ; } ?>><?php _e( 'Federant', 'hero'); ?></option>
                                    <option value="Federo" <?php if($google_fonts=="Federo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Federo', 'hero'); ?></option>
                                    <option value="Fjord+One" <?php if($google_fonts=="Fjord+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Fjord One', 'hero'); ?></option>
                                    <option value="Fondamento" <?php if($google_fonts=="Fondamento" ){ echo "selected='selected'" ; } ?>><?php _e( 'Fondamento', 'hero'); ?></option>
                                    <option value="Fontdiner+Swanky" <?php if($google_fonts=="Fontdiner+Swanky" ){ echo "selected='selected'" ; } ?>><?php _e( 'Fontdiner Swanky', 'hero'); ?></option>
                                    <option value="Forum" <?php if($google_fonts=="Forum" ){ echo "selected='selected'" ; } ?>><?php _e( 'Forum', 'hero'); ?></option>
                                    <option value="Francois+One" <?php if($google_fonts=="Francois+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Francois One', 'hero'); ?></option>
                                    <option value="Gentium+Basic" <?php if($google_fonts=="Gentium+Basic" ){ echo "selected='selected'" ; } ?>><?php _e( 'Gentium Basic', 'hero'); ?></option>
                                    <option value="Gentium+Book+Basic" <?php if($google_fonts=="Gentium+Book+Basic" ){ echo "selected='selected'" ; } ?>><?php _e( 'Gentium Book Basic', 'hero'); ?></option>
                                    <option value="Geo" <?php if($google_fonts=="Geo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Geo', 'hero'); ?></option>
                                    <option value="Geostar+Fill" <?php if($google_fonts=="Geostar+Fill" ){ echo "selected='selected'" ; } ?>><?php _e( 'Geostar Fill', 'hero'); ?></option>
                                    <option value="Geostar" <?php if($google_fonts=="Geostar" ){ echo "selected='selected'" ; } ?>><?php _e( 'Geostar', 'hero'); ?></option>
                                    <option value="Give+You+Glory" <?php if($google_fonts=="Give+You+Glory" ){ echo "selected='selected'" ; } ?>><?php _e( 'Give You Glory', 'hero'); ?></option>
                                    <option value="Gloria+Hallelujah" <?php if($google_fonts=="Gloria+Hallelujah" ){ echo "selected='selected'" ; } ?>><?php _e( 'Gloria Hallelujah', 'hero'); ?></option>
                                    <option value="Goblin+One" <?php if($google_fonts=="Goblin+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Goblin One', 'hero'); ?></option>
                                    <option value="Gochi+Hand" <?php if($google_fonts=="Gochi+Hand" ){ echo "selected='selected'" ; } ?>><?php _e( 'Gochi Hand', 'hero'); ?></option>
                                    <option value="Goudy+Bookletter+1911" <?php if($google_fonts=="Goudy+Bookletter+1911" ){ echo "selected='selected'" ; } ?>><?php _e( 'Goudy Bookletter 1911', 'hero'); ?></option>
                                    <option value="Gravitas+One" <?php if($google_fonts=="Gravitas+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Gravitas One', 'hero'); ?></option>
                                    <option value="Gruppo" <?php if($google_fonts=="Gruppo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Gruppo', 'hero'); ?></option>
                                    <option value="Hammersmith+One" <?php if($google_fonts=="Hammersmith+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Hammersmith One', 'hero'); ?></option>
                                    <option value="Herr+Von+Muellerhoff" <?php if($google_fonts=="Herr+Von+Muellerhoff" ){ echo "selected='selected'" ; } ?>><?php _e( 'Herr Von Muellerhoff', 'hero'); ?></option>
                                    <option value="Holtwood+One+SC" <?php if($google_fonts=="Holtwood+One+SC" ){ echo "selected='selected'" ; } ?>><?php _e( 'Holtwood One SC', 'hero'); ?></option>
                                    <option value="Homemade+Apple" <?php if($google_fonts=="Homemade+Apple" ){ echo "selected='selected'" ; } ?>><?php _e( 'Homemade Apple', 'hero'); ?></option>
                                    <option value="IM+Fell+DW+Pica+SC" <?php if($google_fonts=="IM+Fell+DW+Pica+SC" ){ echo "selected='selected'" ; } ?>><?php _e( 'IM Fell DW Pica SC', 'hero'); ?></option>
                                    <option value="IM+Fell+DW+Pica" <?php if($google_fonts=="IM+Fell+DW+Pica" ){ echo "selected='selected'" ; } ?>><?php _e( 'IM Fell DW Pica', 'hero'); ?></option>
                                    <option value="IM+Fell+Double+Pica+SC" <?php if($google_fonts=="IM+Fell+Double+Pica+SC" ){ echo "selected='selected'" ; } ?>><?php _e( 'IM Fell Double Pica SC', 'hero'); ?></option>
                                    <option value="IM+Fell+Double+Pica" <?php if($google_fonts=="IM+Fell+Double+Pica" ){ echo "selected='selected'" ; } ?>><?php _e( 'IM Fell Double Pica', 'hero'); ?></option>
                                    <option value="IM+Fell+English+SC" <?php if($google_fonts=="IM+Fell+English+SC" ){ echo "selected='selected'" ; } ?>><?php _e( 'IM Fell English SC', 'hero'); ?></option>
                                    <option value="IM+Fell+English" <?php if($google_fonts=="IM+Fell+English" ){ echo "selected='selected'" ; } ?>><?php _e( 'IM Fell English', 'hero'); ?></option>
                                    <option value="IM+Fell+French+Canon+SC" <?php if($google_fonts=="IM+Fell+French+Canon+SC" ){ echo "selected='selected'" ; } ?>><?php _e( 'IM Fell French Canon SC', 'hero'); ?></option>
                                    <option value="IM+Fell+French+Canon" <?php if($google_fonts=="IM+Fell+French+Canon" ){ echo "selected='selected'" ; } ?>><?php _e( 'IM Fell French Canon', 'hero'); ?></option>
                                    <option value="IM+Fell+Great+Primer+SC" <?php if($google_fonts=="IM+Fell+Great+Primer+SC" ){ echo "selected='selected'" ; } ?>><?php _e( 'IM Fell Great Primer SC', 'hero'); ?></option>
                                    <option value="IM+Fell+Great+Primer" <?php if($google_fonts=="IM+Fell+Great+Primer" ){ echo "selected='selected'" ; } ?>><?php _e( 'IM Fell Great Primer', 'hero'); ?></option>
                                    <option value="Iceland" <?php if($google_fonts=="Iceland" ){ echo "selected='selected'" ; } ?>><?php _e( 'Iceland', 'hero'); ?></option>
                                    <option value="Inconsolata" <?php if($google_fonts=="Inconsolata" ){ echo "selected='selected'" ; } ?>><?php _e( 'Inconsolata', 'hero'); ?></option>
                                    <option value="Indie+Flower" <?php if($google_fonts=="Indie+Flower" ){ echo "selected='selected'" ; } ?>><?php _e( 'Indie Flower', 'hero'); ?></option>
                                    <option value="Irish+Grover" <?php if($google_fonts=="Irish+Grover" ){ echo "selected='selected'" ; } ?>><?php _e( 'Irish Grover', 'hero'); ?></option>
                                    <option value="Istok+Web" <?php if($google_fonts=="Istok+Web" ){ echo "selected='selected'" ; } ?>><?php _e( 'Istok Web', 'hero'); ?></option>
                                    <option value="Jockey+One" <?php if($google_fonts=="Jockey+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Jockey One', 'hero'); ?></option>
                                    <option value="Josefin+Sans" <?php if($google_fonts=="Josefin+Sans" ){ echo "selected='selected'" ; } ?>><?php _e( 'Josefin Sans', 'hero'); ?></option>
                                    <option value="Josefin+Slab" <?php if($google_fonts=="Josefin+Slab" ){ echo "selected='selected'" ; } ?>><?php _e( 'Josefin Slab', 'hero'); ?></option>
                                    <option value="Judson" <?php if($google_fonts=="Judson" ){ echo "selected='selected'" ; } ?>><?php _e( 'Judson', 'hero'); ?></option>
                                    <option value="Julee" <?php if($google_fonts=="Julee" ){ echo "selected='selected'" ; } ?>><?php _e( 'Julee', 'hero'); ?></option>
                                    <option value="Jura" <?php if($google_fonts=="Jura" ){ echo "selected='selected'" ; } ?>><?php _e( 'Jura', 'hero'); ?></option>
                                    <option value="Just+Another+Hand" <?php if($google_fonts=="Just+Another+Hand" ){ echo "selected='selected'" ; } ?>><?php _e( 'Just Another Hand', 'hero'); ?></option>
                                    <option value="Just+Me+Again+Down+Here" <?php if($google_fonts=="Just+Me+Again+Down+Here" ){ echo "selected='selected'" ; } ?>><?php _e( 'Just Me Again Down Here', 'hero'); ?></option>
                                    <option value="Kameron" <?php if($google_fonts=="Kameron" ){ echo "selected='selected'" ; } ?>><?php _e( 'Kameron', 'hero'); ?></option>
                                    <option value="Kelly+Slab" <?php if($google_fonts=="Kelly+Slab" ){ echo "selected='selected'" ; } ?>><?php _e( 'Kelly Slab', 'hero'); ?></option>
                                    <option value="Kenia" <?php if($google_fonts=="Kenia" ){ echo "selected='selected'" ; } ?>><?php _e( 'Kenia', 'hero'); ?></option>
                                    <option value="Knewave" <?php if($google_fonts=="Knewave" ){ echo "selected='selected'" ; } ?>><?php _e( 'Knewave', 'hero'); ?></option>
                                    <option value="Kranky" <?php if($google_fonts=="Kranky" ){ echo "selected='selected'" ; } ?>><?php _e( 'Kranky', 'hero'); ?></option>
                                    <option value="Kreon" <?php if($google_fonts=="Kreon" ){ echo "selected='selected'" ; } ?>><?php _e( 'Kreon', 'hero'); ?></option>
                                    <option value="Kristi" <?php if($google_fonts=="Kristi" ){ echo "selected='selected'" ; } ?>><?php _e( 'Kristi', 'hero'); ?></option>
                                    <option value="La+Belle+Aurore" <?php if($google_fonts=="La+Belle+Aurore" ){ echo "selected='selected'" ; } ?>><?php _e( 'La Belle Aurore', 'hero'); ?></option>
                                    <option value="Lancelot" <?php if($google_fonts=="Lancelot" ){ echo "selected='selected'" ; } ?>><?php _e( 'Lancelot', 'hero'); ?></option>
                                    <option value="Lato" <?php if($google_fonts=="Lato" ){ echo "selected='selected'" ; } ?>><?php _e( 'Lato', 'hero'); ?></option>
                                    <option value="League+Script" <?php if($google_fonts=="League+Script" ){ echo "selected='selected'" ; } ?>><?php _e( 'League Script', 'hero'); ?></option>
                                    <option value="Leckerli+One" <?php if($google_fonts=="Leckerli+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Leckerli One', 'hero'); ?></option>
                                    <option value="Lekton" <?php if($google_fonts=="Lekton" ){ echo "selected='selected'" ; } ?>><?php _e( 'Lekton', 'hero'); ?></option>
                                    <option value="Lemon" <?php if($google_fonts=="Lemon" ){ echo "selected='selected'" ; } ?>><?php _e( 'Lemon', 'hero'); ?></option>
                                    <option value="Limelight" <?php if($google_fonts=="Limelight" ){ echo "selected='selected'" ; } ?>><?php _e( 'Limelight', 'hero'); ?></option>
                                    <option value="Linden+Hill" <?php if($google_fonts=="Linden+Hill" ){ echo "selected='selected'" ; } ?>><?php _e( 'Linden Hill', 'hero'); ?></option>
                                    <option value="Lobster+Two" <?php if($google_fonts=="Lobster+Two" ){ echo "selected='selected'" ; } ?>><?php _e( 'Lobster Two', 'hero'); ?></option>
                                    <option value="Lobster" <?php if($google_fonts=="Lobster" ){ echo "selected='selected'" ; } ?>><?php _e( 'Lobster', 'hero'); ?></option>
                                    <option value="Lora" <?php if($google_fonts=="Lora" ){ echo "selected='selected'" ; } ?>><?php _e( 'Lora', 'hero'); ?></option>
                                    <option value="Love+Ya+Like+A+Sister" <?php if($google_fonts=="Love+Ya+Like+A+Sister" ){ echo "selected='selected'" ; } ?>><?php _e( 'Love Ya Like A Sister', 'hero'); ?></option>
                                    <option value="Loved+by+the+King" <?php if($google_fonts=="Loved+by+the+King" ){ echo "selected='selected'" ; } ?>><?php _e( 'Loved by the King', 'hero'); ?></option>
                                    <option value="Luckiest+Guy" <?php if($google_fonts=="Luckiest+Guy" ){ echo "selected='selected'" ; } ?>><?php _e( 'Luckiest Guy', 'hero'); ?></option>
                                    <option value="Maiden+Orange" <?php if($google_fonts=="Maiden+Orange" ){ echo "selected='selected'" ; } ?>><?php _e( 'Maiden Orange', 'hero'); ?></option>
                                    <option value="Mako" <?php if($google_fonts=="Mako" ){ echo "selected='selected'" ; } ?>><?php _e( 'Mako', 'hero'); ?></option>
                                    <option value="Marck+Script" <?php if($google_fonts=="Marck+Script" ){ echo "selected='selected'" ; } ?>><?php _e( 'Marck Script', 'hero'); ?></option>
                                    <option value="Marvel" <?php if($google_fonts=="Marvel" ){ echo "selected='selected'" ; } ?>><?php _e( 'Marvel', 'hero'); ?></option>
                                    <option value="Mate+SC" <?php if($google_fonts=="Mate+SC" ){ echo "selected='selected'" ; } ?>><?php _e( 'Mate SC', 'hero'); ?></option>
                                    <option value="Mate" <?php if($google_fonts=="Mate" ){ echo "selected='selected'" ; } ?>><?php _e( 'Mate', 'hero'); ?></option>
                                    <option value="Maven+Pro" <?php if($google_fonts=="Maven+Pro" ){ echo "selected='selected'" ; } ?>><?php _e( 'Maven Pro', 'hero'); ?></option>
                                    <option value="Meddon" <?php if($google_fonts=="Meddon" ){ echo "selected='selected'" ; } ?>><?php _e( 'Meddon', 'hero'); ?></option>
                                    <option value="MedievalSharp" <?php if($google_fonts=="MedievalSharp" ){ echo "selected='selected'" ; } ?>><?php _e( 'MedievalSharp', 'hero'); ?></option>
                                    <option value="Megrim" <?php if($google_fonts=="Megrim" ){ echo "selected='selected'" ; } ?>><?php _e( 'Megrim', 'hero'); ?></option>
                                    <option value="Merienda+One" <?php if($google_fonts=="Merienda+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Merienda One', 'hero'); ?></option>
                                    <option value="Merriweather" <?php if($google_fonts=="Merriweather" ){ echo "selected='selected'" ; } ?>><?php _e( 'Merriweather', 'hero'); ?></option>
                                    <option value="Metrophobic" <?php if($google_fonts=="Metrophobic" ){ echo "selected='selected'" ; } ?>><?php _e( 'Metrophobic', 'hero'); ?></option>
                                    <option value="Michroma" <?php if($google_fonts=="Michroma" ){ echo "selected='selected'" ; } ?>><?php _e( 'Michroma', 'hero'); ?></option>
                                    <option value="Miltonian+Tattoo" <?php if($google_fonts=="Miltonian+Tattoo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Miltonian Tattoo', 'hero'); ?></option>
                                    <option value="Miltonian" <?php if($google_fonts=="Miltonian" ){ echo "selected='selected'" ; } ?>><?php _e( 'Miltonian', 'hero'); ?></option>
                                    <option value="Miss+Fajardose" <?php if($google_fonts=="Miss+Fajardose" ){ echo "selected='selected'" ; } ?>><?php _e( 'Miss Fajardose', 'hero'); ?></option>
                                    <option value="Miss+Saint+Delafield" <?php if($google_fonts=="Miss+Saint+Delafield" ){ echo "selected='selected'" ; } ?>><?php _e( 'Miss Saint Delafield', 'hero'); ?></option>
                                    <option value="Modern+Antiqua" <?php if($google_fonts=="Modern+Antiqua" ){ echo "selected='selected'" ; } ?>><?php _e( 'Modern Antiqua', 'hero'); ?></option>
                                    <option value="Molengo" <?php if($google_fonts=="Molengo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Molengo', 'hero'); ?></option>
                                    <option value="Monofett" <?php if($google_fonts=="Monofett" ){ echo "selected='selected'" ; } ?>><?php _e( 'Monofett', 'hero'); ?></option>
                                    <option value="Monoton" <?php if($google_fonts=="Monoton" ){ echo "selected='selected'" ; } ?>><?php _e( 'Monoton', 'hero'); ?></option>
                                    <option value="Monsieur+La+Doulaise" <?php if($google_fonts=="Monsieur+La+Doulaise" ){ echo "selected='selected'" ; } ?>><?php _e( 'Monsieur La Doulaise', 'hero'); ?></option>
                                    <option value="Montez" <?php if($google_fonts=="Montez" ){ echo "selected='selected'" ; } ?>><?php _e( 'Montez', 'hero'); ?></option>
                                    <option value="Mountains+of+Christmas" <?php if($google_fonts=="Mountains+of+Christmas" ){ echo "selected='selected'" ; } ?>><?php _e( 'Mountains of Christmas', 'hero'); ?></option>
                                    <option value="Mr+Bedford" <?php if($google_fonts=="Mr+Bedford" ){ echo "selected='selected'" ; } ?>><?php _e( 'Mr Bedford', 'hero'); ?></option>
                                    <option value="Mr+Dafoe" <?php if($google_fonts=="Mr+Dafoe" ){ echo "selected='selected'" ; } ?>><?php _e( 'Mr Dafoe', 'hero'); ?></option>
                                    <option value="Mr+De+Haviland" <?php if($google_fonts=="Mr+De+Haviland" ){ echo "selected='selected'" ; } ?>><?php _e( 'Mr De Haviland', 'hero'); ?></option>
                                    <option value="Mrs+Sheppards" <?php if($google_fonts=="Mrs+Sheppards" ){ echo "selected='selected'" ; } ?>><?php _e( 'Mrs Sheppards', 'hero'); ?></option>
                                    <option value="Muli" <?php if($google_fonts=="Muli" ){ echo "selected='selected'" ; } ?>><?php _e( 'Muli', 'hero'); ?></option>
                                    <option value="Neucha" <?php if($google_fonts=="Neucha" ){ echo "selected='selected'" ; } ?>><?php _e( 'Neucha', 'hero'); ?></option>
                                    <option value="Neuton" <?php if($google_fonts=="Neuton" ){ echo "selected='selected'" ; } ?>><?php _e( 'Neuton', 'hero'); ?></option>
                                    <option value="News+Cycle" <?php if($google_fonts=="News+Cycle" ){ echo "selected='selected'" ; } ?>><?php _e( 'News Cycle', 'hero'); ?></option>
                                    <option value="Niconne" <?php if($google_fonts=="Niconne" ){ echo "selected='selected'" ; } ?>><?php _e( 'Niconne', 'hero'); ?></option>
                                    <option value="Nixie+One" <?php if($google_fonts=="Nixie+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nixie One', 'hero'); ?></option>
                                    <option value="Nobile" <?php if($google_fonts=="Nobile" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nobile', 'hero'); ?></option>
                                    <option value="Nosifer+Caps" <?php if($google_fonts=="Nosifer+Caps" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nosifer Caps', 'hero'); ?></option>
                                    <option value="Nothing+You+Could+Do" <?php if($google_fonts=="Nothing+You+Could+Do" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nothing You Could Do', 'hero'); ?></option>
                                    <option value="Nova+Cut" <?php if($google_fonts=="Nova+Cut" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nova Cut', 'hero'); ?></option>
                                    <option value="Nova+Flat" <?php if($google_fonts=="Nova+Flat" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nova Flat', 'hero'); ?></option>
                                    <option value="Nova+Mono" <?php if($google_fonts=="Nova+Mono" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nova Mono', 'hero'); ?></option>
                                    <option value="Nova+Oval" <?php if($google_fonts=="Nova+Oval" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nova Oval', 'hero'); ?></option>
                                    <option value="Nova+Round" <?php if($google_fonts=="Nova+Round" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nova Round', 'hero'); ?></option>
                                    <option value="Nova+Script" <?php if($google_fonts=="Nova+Script" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nova Script', 'hero'); ?></option>
                                    <option value="Nova+Slim" <?php if($google_fonts=="Nova+Slim" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nova Slim', 'hero'); ?></option>
                                    <option value="Nova+Square" <?php if($google_fonts=="Nova+Square" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nova Square', 'hero'); ?></option>
                                    <option value="Numans" <?php if($google_fonts=="Numans" ){ echo "selected='selected'" ; } ?>><?php _e( 'Numans', 'hero'); ?></option>
                                    <option value="Nunito" <?php if($google_fonts=="Nunito" ){ echo "selected='selected'" ; } ?>><?php _e( 'Nunito', 'hero'); ?></option>
                                    <option value="Old+Standard+TT" <?php if($google_fonts=="Old+Standard+TT" ){ echo "selected='selected'" ; } ?>><?php _e( 'Old Standard TT', 'hero'); ?></option>
                                    <option value="Open+Sans+Condensed" <?php if($google_fonts=="Open+Sans+Condensed" ){ echo "selected='selected'" ; } ?>><?php _e( 'Open Sans Condensed', 'hero'); ?></option>
                                    <option value="Open+Sans" <?php if($google_fonts=="Open+Sans" ){ echo "selected='selected'" ; } ?>><?php _e( 'Open Sans', 'hero'); ?></option>
                                    <option value="Orbitron" <?php if($google_fonts=="Orbitron" ){ echo "selected='selected'" ; } ?>><?php _e( 'Orbitron', 'hero'); ?></option>
                                    <option value="Oswald" <?php if($google_fonts=="Oswald" ){ echo "selected='selected'" ; } ?>><?php _e( 'Oswald', 'hero'); ?></option>
                                    <option value="Over+the+Rainbow" <?php if($google_fonts=="Over+the+Rainbow" ){ echo "selected='selected'" ; } ?>><?php _e( 'Over the Rainbow', 'hero'); ?></option>
                                    <option value="Ovo" <?php if($google_fonts=="Ovo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Ovo', 'hero'); ?></option>
                                    <option value="PT+Sans+Caption" <?php if($google_fonts=="PT+Sans+Caption" ){ echo "selected='selected'" ; } ?>><?php _e( 'PT Sans Caption', 'hero'); ?></option>
                                    <option value="PT+Sans+Narrow" <?php if($google_fonts=="PT+Sans+Narrow" ){ echo "selected='selected'" ; } ?>><?php _e( 'PT Sans Narrow', 'hero'); ?></option>
                                    <option value="PT+Sans" <?php if($google_fonts=="PT+Sans" ){ echo "selected='selected'" ; } ?>><?php _e( 'PT Sans', 'hero'); ?></option>
                                    <option value="PT+Serif+Caption" <?php if($google_fonts=="PT+Serif+Caption" ){ echo "selected='selected'" ; } ?>><?php _e( 'PT Serif Caption', 'hero'); ?></option>
                                    <option value="PT+Serif" <?php if($google_fonts=="PT+Serif" ){ echo "selected='selected'" ; } ?>><?php _e( 'PT Serif', 'hero'); ?></option>
                                    <option value="Pacifico" <?php if($google_fonts=="Pacifico" ){ echo "selected='selected'" ; } ?>><?php _e( 'Pacifico', 'hero'); ?></option>
                                    <option value="Passero+One" <?php if($google_fonts=="Passero+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Passero One', 'hero'); ?></option>
                                    <option value="Patrick+Hand" <?php if($google_fonts=="Patrick+Hand" ){ echo "selected='selected'" ; } ?>><?php _e( 'Patrick Hand', 'hero'); ?></option>
                                    <option value="Paytone+One" <?php if($google_fonts=="Paytone+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Paytone One', 'hero'); ?></option>
                                    <option value="Permanent+Marker" <?php if($google_fonts=="Permanent+Marker" ){ echo "selected='selected'" ; } ?>><?php _e( 'Permanent Marker', 'hero'); ?></option>
                                    <option value="Petrona" <?php if($google_fonts=="Petrona" ){ echo "selected='selected'" ; } ?>><?php _e( 'Petrona', 'hero'); ?></option>
                                    <option value="Philosopher" <?php if($google_fonts=="Philosopher" ){ echo "selected='selected'" ; } ?>><?php _e( 'Philosopher', 'hero'); ?></option>
                                    <option value="Piedra" <?php if($google_fonts=="Piedra" ){ echo "selected='selected'" ; } ?>><?php _e( 'Piedra', 'hero'); ?></option>
                                    <option value="Pinyon+Script" <?php if($google_fonts=="Pinyon+Script" ){ echo "selected='selected'" ; } ?>><?php _e( 'Pinyon Script', 'hero'); ?></option>
                                    <option value="Play" <?php if($google_fonts=="Play" ){ echo "selected='selected'" ; } ?>><?php _e( 'Play', 'hero'); ?></option>
                                    <option value="Playfair+Display" <?php if($google_fonts=="Playfair+Display" ){ echo "selected='selected'" ; } ?>><?php _e( 'Playfair Display', 'hero'); ?></option>
                                    <option value="Podkova" <?php if($google_fonts=="Podkova" ){ echo "selected='selected'" ; } ?>><?php _e( 'Podkova', 'hero'); ?></option>
                                    <option value="Poller+One" <?php if($google_fonts=="Poller+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Poller One', 'hero'); ?></option>
                                    <option value="Poly" <?php if($google_fonts=="Poly" ){ echo "selected='selected'" ; } ?>><?php _e( 'Poly', 'hero'); ?></option>
                                    <option value="Pompiere" <?php if($google_fonts=="Pompiere" ){ echo "selected='selected'" ; } ?>><?php _e( 'Pompiere', 'hero'); ?></option>
                                    <option value="Prata" <?php if($google_fonts=="Prata" ){ echo "selected='selected'" ; } ?>><?php _e( 'Prata', 'hero'); ?></option>
                                    <option value="Prociono" <?php if($google_fonts=="Prociono" ){ echo "selected='selected'" ; } ?>><?php _e( 'Prociono', 'hero'); ?></option>
                                    <option value="Puritan" <?php if($google_fonts=="Puritan" ){ echo "selected='selected'" ; } ?>><?php _e( 'Puritan', 'hero'); ?></option>
                                    <option value="Quattrocento+Sans" <?php if($google_fonts=="Quattrocento+Sans" ){ echo "selected='selected'" ; } ?>><?php _e( 'Quattrocento Sans', 'hero'); ?></option>
                                    <option value="Quattrocento" <?php if($google_fonts=="Quattrocento" ){ echo "selected='selected'" ; } ?>><?php _e( 'Quattrocento', 'hero'); ?></option>
                                    <option value="Questrial" <?php if($google_fonts=="Questrial" ){ echo "selected='selected'" ; } ?>><?php _e( 'Questrial', 'hero'); ?></option>
                                    <option value="Quicksand" <?php if($google_fonts=="Quicksand" ){ echo "selected='selected'" ; } ?>><?php _e( 'Quicksand', 'hero'); ?></option>
                                    <option value="Radley" <?php if($google_fonts=="Radley" ){ echo "selected='selected'" ; } ?>><?php _e( 'Radley', 'hero'); ?></option>
                                    <option value="Raleway" <?php if($google_fonts=="Raleway" ){ echo "selected='selected'" ; } ?>><?php _e( 'Raleway', 'hero'); ?></option>
                                    <option value="Rammetto+One" <?php if($google_fonts=="Rammetto+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Rammetto One', 'hero'); ?></option>
                                    <option value="Rancho" <?php if($google_fonts=="Rancho" ){ echo "selected='selected'" ; } ?>><?php _e( 'Rancho', 'hero'); ?></option>
                                    <option value="Rationale" <?php if($google_fonts=="Rationale" ){ echo "selected='selected'" ; } ?>><?php _e( 'Rationale', 'hero'); ?></option>
                                    <option value="Redressed" <?php if($google_fonts=="Redressed" ){ echo "selected='selected'" ; } ?>><?php _e( 'Redressed', 'hero'); ?></option>
                                    <option value="Reenie+Beanie" <?php if($google_fonts=="Reenie+Beanie" ){ echo "selected='selected'" ; } ?>><?php _e( 'Reenie Beanie', 'hero'); ?></option>
                                    <option value="Ribeye+Marrow" <?php if($google_fonts=="Ribeye+Marrow" ){ echo "selected='selected'" ; } ?>><?php _e( 'Ribeye Marrow', 'hero'); ?></option>
                                    <option value="Ribeye" <?php if($google_fonts=="Ribeye" ){ echo "selected='selected'" ; } ?>><?php _e( 'Ribeye', 'hero'); ?></option>
                                    <option value="Righteous" <?php if($google_fonts=="Righteous" ){ echo "selected='selected'" ; } ?>><?php _e( 'Righteous', 'hero'); ?></option>
                                    <option value="Rochester" <?php if($google_fonts=="Rochester" ){ echo "selected='selected'" ; } ?>><?php _e( 'Rochester', 'hero'); ?></option>
                                    <option value="Rock+Salt" <?php if($google_fonts=="Rock+Salt" ){ echo "selected='selected'" ; } ?>><?php _e( 'Rock Salt', 'hero'); ?></option>
                                    <option value="Rokkitt" <?php if($google_fonts=="Rokkitt" ){ echo "selected='selected'" ; } ?>><?php _e( 'Rokkitt', 'hero'); ?></option>
                                    <option value="Rosario" <?php if($google_fonts=="Rosario" ){ echo "selected='selected'" ; } ?>><?php _e( 'Rosario', 'hero'); ?></option>
                                    <option value="Ruslan+Display" <?php if($google_fonts=="Ruslan+Display" ){ echo "selected='selected'" ; } ?>><?php _e( 'Ruslan Display', 'hero'); ?></option>
                                    <option value="Salsa" <?php if($google_fonts=="Salsa" ){ echo "selected='selected'" ; } ?>><?php _e( 'Salsa', 'hero'); ?></option>
                                    <option value="Sancreek" <?php if($google_fonts=="Sancreek" ){ echo "selected='selected'" ; } ?>><?php _e( 'Sancreek', 'hero'); ?></option>
                                    <option value="Sansita+One" <?php if($google_fonts=="Sansita+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Sansita One', 'hero'); ?></option>
                                    <option value="Satisfy" <?php if($google_fonts=="Satisfy" ){ echo "selected='selected'" ; } ?>><?php _e( 'Satisfy', 'hero'); ?></option>
                                    <option value="Schoolbell" <?php if($google_fonts=="Schoolbell" ){ echo "selected='selected'" ; } ?>><?php _e( 'Schoolbell', 'hero'); ?></option>
                                    <option value="Shadows+Into+Light" <?php if($google_fonts=="Shadows+Into+Light" ){ echo "selected='selected'" ; } ?>><?php _e( 'Shadows Into Light', 'hero'); ?></option>
                                    <option value="Shanti" <?php if($google_fonts=="Shanti" ){ echo "selected='selected'" ; } ?>><?php _e( 'Shanti', 'hero'); ?></option>
                                    <option value="Short+Stack" <?php if($google_fonts=="Short+Stack" ){ echo "selected='selected'" ; } ?>><?php _e( 'Short Stack', 'hero'); ?></option>
                                    <option value="Sigmar+One" <?php if($google_fonts=="Sigmar+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Sigmar One', 'hero'); ?></option>
                                    <option value="Signika+Negative" <?php if($google_fonts=="Signika+Negative" ){ echo "selected='selected'" ; } ?>><?php _e( 'Signika Negative', 'hero'); ?></option>
                                    <option value="Signika" <?php if($google_fonts=="Signika" ){ echo "selected='selected'" ; } ?>><?php _e( 'Signika', 'hero'); ?></option>
                                    <option value="Six+Caps" <?php if($google_fonts=="Six+Caps" ){ echo "selected='selected'" ; } ?>><?php _e( 'Six Caps', 'hero'); ?></option>
                                    <option value="Slackey" <?php if($google_fonts=="Slackey" ){ echo "selected='selected'" ; } ?>><?php _e( 'Slackey', 'hero'); ?></option>
                                    <option value="Smokum" <?php if($google_fonts=="Smokum" ){ echo "selected='selected'" ; } ?>><?php _e( 'Smokum', 'hero'); ?></option>
                                    <option value="Smythe" <?php if($google_fonts=="Smythe" ){ echo "selected='selected'" ; } ?>><?php _e( 'Smythe', 'hero'); ?></option>
                                    <option value="Sniglet" <?php if($google_fonts=="Sniglet" ){ echo "selected='selected'" ; } ?>><?php _e( 'Sniglet', 'hero'); ?></option>
                                    <option value="Snippet" <?php if($google_fonts=="Snippet" ){ echo "selected='selected'" ; } ?>><?php _e( 'Snippet', 'hero'); ?></option>
                                    <option value="Sorts+Mill+Goudy" <?php if($google_fonts=="Sorts+Mill+Goudy" ){ echo "selected='selected'" ; } ?>><?php _e( 'Sorts Mill Goudy', 'hero'); ?></option>
                                    <option value="Special+Elite" <?php if($google_fonts=="Special+Elite" ){ echo "selected='selected'" ; } ?>><?php _e( 'Special Elite', 'hero'); ?></option>
                                    <option value="Spinnaker" <?php if($google_fonts=="Spinnaker" ){ echo "selected='selected'" ; } ?>><?php _e( 'Spinnaker', 'hero'); ?></option>
                                    <option value="Spirax" <?php if($google_fonts=="Spirax" ){ echo "selected='selected'" ; } ?>><?php _e( 'Spirax', 'hero'); ?></option>
                                    <option value="Stardos+Stencil" <?php if($google_fonts=="Stardos+Stencil" ){ echo "selected='selected'" ; } ?>><?php _e( 'Stardos Stencil', 'hero'); ?></option>
                                    <option value="Sue+Ellen+Francisco" <?php if($google_fonts=="Sue+Ellen+Francisco" ){ echo "selected='selected'" ; } ?>><?php _e( 'Sue Ellen Francisco', 'hero'); ?></option>
                                    <option value="Sunshiney" <?php if($google_fonts=="Sunshiney" ){ echo "selected='selected'" ; } ?>><?php _e( 'Sunshiney', 'hero'); ?></option>
                                    <option value="Supermercado+One" <?php if($google_fonts=="Supermercado+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Supermercado One', 'hero'); ?></option>
                                    <option value="Swanky+and+Moo+Moo" <?php if($google_fonts=="Swanky+and+Moo+Moo" ){ echo "selected='selected'" ; } ?>><?php _e( 'Swanky and Moo Moo', 'hero'); ?></option>
                                    <option value="Syncopate" <?php if($google_fonts=="Syncopate" ){ echo "selected='selected'" ; } ?>><?php _e( 'Syncopate', 'hero'); ?></option>
                                    <option value="Tangerine" <?php if($google_fonts=="Tangerine" ){ echo "selected='selected'" ; } ?>><?php _e( 'Tangerine', 'hero'); ?></option>
                                    <option value="Tenor+Sans" <?php if($google_fonts=="Tenor+Sans" ){ echo "selected='selected'" ; } ?>><?php _e( 'Tenor Sans', 'hero'); ?></option>
                                    <option value="Terminal+Dosis" <?php if($google_fonts=="Terminal+Dosis" ){ echo "selected='selected'" ; } ?>><?php _e( 'Terminal Dosis', 'hero'); ?></option>
                                    <option value="The+Girl+Next+Door" <?php if($google_fonts=="The+Girl+Next+Door" ){ echo "selected='selected'" ; } ?>><?php _e( 'The Girl Next Door', 'hero'); ?></option>
                                    <option value="Tienne" <?php if($google_fonts=="Tienne" ){ echo "selected='selected'" ; } ?>><?php _e( 'Tienne', 'hero'); ?></option>
                                    <option value="Tinos" <?php if($google_fonts=="Tinos" ){ echo "selected='selected'" ; } ?>><?php _e( 'Tinos', 'hero'); ?></option>
                                    <option value="Tulpen+One" <?php if($google_fonts=="Tulpen+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Tulpen One', 'hero'); ?></option>
                                    <option value="Ubuntu+Condensed" <?php if($google_fonts=="Ubuntu+Condensed" ){ echo "selected='selected'" ; } ?>><?php _e( 'Ubuntu Condensed', 'hero'); ?></option>
                                    <option value="Ubuntu+Mono" <?php if($google_fonts=="Ubuntu+Mono" ){ echo "selected='selected'" ; } ?>><?php _e( 'Ubuntu Mono', 'hero'); ?></option>
                                    <option value="Ubuntu" <?php if($google_fonts=="Ubuntu" ){ echo "selected='selected'" ; } ?>><?php _e( 'Ubuntu', 'hero'); ?></option>
                                    <option value="Ultra" <?php if($google_fonts=="Ultra" ){ echo "selected='selected'" ; } ?>><?php _e( 'Ultra', 'hero'); ?></option>
                                    <option value="UnifrakturCook" <?php if($google_fonts=="UnifrakturCook" ){ echo "selected='selected'" ; } ?>><?php _e( 'UnifrakturCook', 'hero'); ?></option>
                                    <option value="UnifrakturMaguntia" <?php if($google_fonts=="UnifrakturMaguntia" ){ echo "selected='selected'" ; } ?>><?php _e( 'UnifrakturMaguntia', 'hero'); ?></option>
                                    <option value="Unkempt" <?php if($google_fonts=="Unkempt" ){ echo "selected='selected'" ; } ?>><?php _e( 'Unkempt', 'hero'); ?></option>
                                    <option value="Unlock" <?php if($google_fonts=="Unlock" ){ echo "selected='selected'" ; } ?>><?php _e( 'Unlock', 'hero'); ?></option>
                                    <option value="Unna" <?php if($google_fonts=="Unna" ){ echo "selected='selected'" ; } ?>><?php _e( 'Unna', 'hero'); ?></option>
                                    <option value="VT323" <?php if($google_fonts=="VT323" ){ echo "selected='selected'" ; } ?>><?php _e( 'VT323', 'hero'); ?></option>
                                    <option value="Varela+Round" <?php if($google_fonts=="Varela+Round" ){ echo "selected='selected'" ; } ?>><?php _e( 'Varela Round', 'hero'); ?></option>
                                    <option value="Varela" <?php if($google_fonts=="Varela" ){ echo "selected='selected'" ; } ?>><?php _e( 'Varela', 'hero'); ?></option>
                                    <option value="Vast+Shadow" <?php if($google_fonts=="Vast+Shadow" ){ echo "selected='selected'" ; } ?>><?php _e( 'Vast Shadow', 'hero'); ?></option>
                                    <option value="Vibur" <?php if($google_fonts=="Vibur" ){ echo "selected='selected'" ; } ?>><?php _e( 'Vibur', 'hero'); ?></option>
                                    <option value="Vidaloka" <?php if($google_fonts=="Vidaloka" ){ echo "selected='selected'" ; } ?>><?php _e( 'Vidaloka', 'hero'); ?></option>
                                    <option value="Volkhov" <?php if($google_fonts=="Volkhov" ){ echo "selected='selected'" ; } ?>><?php _e( 'Volkhov', 'hero'); ?></option>
                                    <option value="Vollkorn" <?php if($google_fonts=="Vollkorn" ){ echo "selected='selected'" ; } ?>><?php _e( 'Vollkorn', 'hero'); ?></option>
                                    <option value="Voltaire" <?php if($google_fonts=="Voltaire" ){ echo "selected='selected'" ; } ?>><?php _e( 'Voltaire', 'hero'); ?></option>
                                    <option value="Waiting+for+the+Sunrise" <?php if($google_fonts=="Waiting+for+the+Sunrise" ){ echo "selected='selected'" ; } ?>><?php _e( 'Waiting for the Sunrise', 'hero'); ?></option>
                                    <option value="Wallpoet" <?php if($google_fonts=="Wallpoet" ){ echo "selected='selected'" ; } ?>><?php _e( 'Wallpoet', 'hero'); ?></option>
                                    <option value="Walter+Turncoat" <?php if($google_fonts=="Walter+Turncoat" ){ echo "selected='selected'" ; } ?>><?php _e( 'Walter Turncoat', 'hero'); ?></option>
                                    <option value="Wire+One" <?php if($google_fonts=="Wire+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Wire One', 'hero'); ?></option>
                                    <option value="Yanone+Kaffeesatz" <?php if($google_fonts=="Yanone+Kaffeesatz" ){ echo "selected='selected'" ; } ?>><?php _e( 'Yanone Kaffeesatz', 'hero'); ?></option>
                                    <option value="Yellowtail" <?php if($google_fonts=="Yellowtail" ){ echo "selected='selected'" ; } ?>><?php _e( 'Yellowtail', 'hero'); ?></option>
                                    <option value="Yeseva+One" <?php if($google_fonts=="Yeseva+One" ){ echo "selected='selected'" ; } ?>><?php _e( 'Yeseva One', 'hero'); ?></option>
                                    <option value="Zeyada" <?php if($google_fonts=="Zeyada" ){ echo "selected='selected'" ; } ?>><?php _e( 'Zeyada', 'hero'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-horizontal">
                  <div class="form-row">
                    <div class="form-label">
                      <?php _e('Reset Color',  'hero'); ?>
                    </div>
                    <div class="form-controls color_box">
                        <table width="100%">
                            <tr>
                                <td width="15%"><div class="redss" style="background: #FF7058; cursor: pointer;"></div></td>
                                <td width="15%"><div class="bluess" style="background: #1789c5; cursor: pointer;"></div></td>
                                <td width="15%"><div class="blackss" style="background: #34495e; cursor: pointer;"></div></td>
                                <td width="15%"><div class="greenss" style="background: #2ecc71; cursor: pointer;"></div></td>
                                <td width="15%"><div class="orangess" style="background: #e67e22; cursor: pointer;"></div></td>
                                <td width="15%"><div class="whitess" style="background: #8e44ad; cursor: pointer;"></div></td>
                            </tr>
                        </table>
                        
                    </div>
                  </div>
                  
                </div> 
                <div class="form-row">
                    <div class="form-controls"><div class="help-box">
                                    <?php _e('Reset your color settings, click one color', 'hero'); ?> </div></div></div><br>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Font a Color', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="a-color" id="a-color" value="<?php echo osc_esc_html( osc_get_preference('a-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Title and Price', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="b-color" id="b-color" value="<?php echo osc_esc_html( osc_get_preference('b-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('h1,h2,h3,h4,h5,h6 Color', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="h1-color" id="h1-color" value="<?php echo osc_esc_html( osc_get_preference('h1-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Font Menu and Footer', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="a2-color" id="a2-color" value="<?php echo osc_esc_html( osc_get_preference('a2-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Theme Color', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="theme-color" id="theme-color" value="<?php echo osc_esc_html( osc_get_preference('theme-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Background Color', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="back-color" id="back-color" value="<?php echo osc_esc_html( osc_get_preference('back-color', 'hero') ); ?>"> </div>
                        </div>
                        <h2 class="render-title"><?php _e('Button Color', 'hero'); ?></h2>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Primary Button', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="primary-color" value="<?php echo osc_esc_html( osc_get_preference('primary-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Primary Hover Button', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="primaryh-color" value="<?php echo osc_esc_html( osc_get_preference('primaryh-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Green Button', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="green-color" value="<?php echo osc_esc_html( osc_get_preference('green-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Green Hover Button', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="greenh-color" value="<?php echo osc_esc_html( osc_get_preference('greenh-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Yellow Button', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="yellow-color" value="<?php echo osc_esc_html( osc_get_preference('yellow-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Yellow Hover Button', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="yellowh-color" value="<?php echo osc_esc_html( osc_get_preference('yellowh-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Blue Button', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="blue-color" value="<?php echo osc_esc_html( osc_get_preference('blue-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Blue Hover Button', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="blueh-color" value="<?php echo osc_esc_html( osc_get_preference('blueh-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Red Button', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="red-color" value="<?php echo osc_esc_html( osc_get_preference('red-color', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Red Hover Button', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge color" name="redh-color" value="<?php echo osc_esc_html( osc_get_preference('redh-color', 'hero') ); ?>"> </div>
                        </div>
                    </div>
                </div>
               
                <!-- # more starts -->
                <div id="more">
                    
                    <div class="form-horizontal">
                        <div class="form-row">
                            <h1 class="render-title separate-top"><?php _e('External links Menu', 'hero'); ?></h1> </div>
                        <div class="form-row">
                            <div class="form-label"><b><?php _e('Menu text', 'hero'); ?></b> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="blog-text" placeholder="<?php echo osc_esc_html(__('Blogs','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('blog-text', 'hero') ); ?>"> </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Menu Link', 'hero'); ?> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" name="blog-links" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" value="<?php echo osc_esc_html( osc_get_preference('blog-links', 'hero') ); ?>"> </div>
                        </div>
<h1 class="render-title separate-top"><?php _e('More settings', 'hero'); ?></h1>
                        <div class="form-row">
                            <div class="form-label"><b><?php _e('Terms of Use', 'hero'); ?> Link</b> </div>
                            <div class="form-controls">
                                <input type="text" class="xlarge" placeholder="<?php echo osc_esc_html(__('http://your-link.com','hero')); ?>" name="tos-me" value="<?php echo osc_esc_html( osc_get_preference('tos-me', 'hero') ); ?>"> </div>
                            <div class="form-controls">
                                <p>
                                    <?php _e('create new pages TOS and copy url here', 'hero'); ?> </p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Custom Html (display)', 'hero'); ?> </div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" name="sect10_view" value="1" <?php echo (osc_esc_html( osc_get_preference( 'sect10_view', 'hero_theme') )=="1" )? "checked": ""; ?>>
                                    <br/>
                                    <div class="help-box">
                                        <p>
                                            <?php _e('you can customize html code on home', 'hero'); ?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label">
                                <?php _e('Custom Home HTML', 'hero'); ?> </div>
                            <div class="form-controls">
                                <textarea class="cantiki" name="memo-us" placeholder="<?php echo osc_esc_html(__('insert your text or html code','hero')); ?>"><?php echo osc_esc_html( osc_get_preference( 'memo-us', 'hero') ); ?></textarea>
                                <br/>
                                <br/>
                                <div class="help-box">
                                    <?php _e('you can costumize html on home under slider.', 'hero'); ?> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" value="<?php echo osc_esc_html(__('Save changes','hero')); ?>" class="btn btn-submit"> </div>
        </fieldset>
    </form>
</div>
<div class="power">
    <p>
        <?php _e('Hero', 'hero'); ?>
        <?php _e('version', 'hero'); ?> <?php _e('1.7.0', 'hero'); ?> |
        <?php _e('by', 'hero'); ?>
        <a title="<?php echo osc_esc_html(__('hero','hero')); ?> <?php echo osc_esc_html(__('Themes Powered by OsclassDotMe','hero')); ?>" target="_blank" href="http://market.osclass.org/user/profile/2614">
            <?php _e('Osclass.Me', 'hero'); ?> </a>
    </p>
    </div>
     <script>
            $(document).ready(function() {
                $(".bluess").click(function(){
                    $('#a-color').attr('value', '4080FF');
                    
                    $('#b-color').attr('value', 'A30D0D');
                    $('#h1-color').attr('value', '2851A1');
                    
                    $('#a2-color').attr('value', 'ffffff');
                    $('#theme-color').attr('value', '1789c5');
                    
                    $('#back-color').attr('value', 'F1EFEF');
                    
                    
                });
                $(".redss").click(function(){
                    $('#a-color').attr('value', 'FF7058');
                    $('#a2-color').attr('value', 'FFFFFF');
                    
                    $('#b-color').attr('value', 'A0CB57');
                    $('#h1-color').attr('value', 'FF7058');
                    
                    $('#theme-color').attr('value', 'FF7058');
                    $('#back-color').attr('value', 'FFFFFF');
                    
                });
                $(".blackss").click(function(){
                    $('#a-color').attr('value', '34495e');
                    
                    $('#b-color').attr('value', 'A30D0D');
                    $('#h1-color').attr('value', '34495e');
                    
                    $('#a2-color').attr('value', 'ffffff');
                    $('#theme-color').attr('value', '34495e');
                    
                    $('#back-color').attr('value', 'F1EFEF');
                    
                });
                $(".greenss").click(function(){
                    $('#a-color').attr('value', '3f8a07');
                    
                    $('#b-color').attr('value', 'A30D0D');
                    $('#h1-color').attr('value', '3f8a07');
                    
                    $('#a2-color').attr('value', 'ffffff');
                    $('#theme-color').attr('value', '2ecc71');
                    
                    $('#back-color').attr('value', 'F1EFEF');
                });
               $(".orangess").click(function(){
                    $('#a-color').attr('value', 'dc6d0b');
                    
                    $('#b-color').attr('value', 'A30D0D');
                    $('#h1-color').attr('value', 'dc6d0b');
                    
                    $('#a2-color').attr('value', 'ffffff');
                    $('#theme-color').attr('value', 'e67e22');
                    
                    $('#back-color').attr('value', 'F1EFEF');
                    
                });
                $(".whitess").click(function(){
                   $('#a-color').attr('value', '8e44ad');
                    
                    $('#b-color').attr('value', 'A30D0D');
                    $('#h1-color').attr('value', '8e44ad');
                    
                    $('#a2-color').attr('value', 'ffffff');
                    $('#theme-color').attr('value', '8e44ad');
                    
                    $('#back-color').attr('value', 'FFFFFF');
                    
                });
                    $('#font input').on('input',function(e){
                        var id_name = $(this).attr("id");
                        if(id_name.slice(0,4)=='txt_'){
                            var id_value = $(this).val();
                            var color_pkr = id_name.substring(4);
                            $('#'+color_pkr).attr('value', id_value );
                        }else{
                            var id_value = $(this).val();
                            $('#txt_'+id_name).attr('value', id_value );
                        }

                        
                    });
                    $( "#tabs" ).tabs();
                    $("input[type=checkbox]").switchButton();   
                
            });
        </script>