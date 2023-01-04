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
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-6 ari-12 topbot">
                <h3 class="title"><?php echo osc_get_preference('judul1-us', 'hero'); ?></h3>
                <div class="widget-footer">
                    <?php echo osc_get_preference('footer-us1', 'hero'); ?> </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 ari-12 topbot">
                <h3 class="title"><?php echo osc_get_preference('judul2-us', 'hero'); ?></h3>
                <div class="widget-footer">
                    <?php echo osc_get_preference('footer-us2', 'hero'); ?> </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 ari-12 topbot">
                <h3 class="title"><?php echo osc_get_preference('judul3-us', 'hero'); ?></h3>
                <div class="widget-footer">
                    <?php echo osc_get_preference('footer-us3', 'hero'); ?> </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 ari-12 topbot">
                <h3 class="title"><?php echo osc_get_preference('judul4-us', 'hero'); ?></h3>
                <div class="widget-footer">
                    <?php echo osc_get_preference('footer-us4', 'hero'); ?> </div>
            </div>
        </div>
    </div>
</div>
<div id="footer-copyright">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 clearfix">
<ul class="pagese">
                            <?php if(osc_get_preference('facebook-us', 'hero')!='' ) { ?>
                            <li>
                                <div class="icon-box">
                                    <a target="_blank" class="asli" href="<?php echo osc_get_preference('facebook-us', 'hero'); ?>"> <i class="fa fa-facebook-square text-dark"></i></a>
                                </div>
                            </li>
                            <?php } ?>
                            <?php if(osc_get_preference('twitter-us', 'hero')!='' ) { ?>
                            <li>
                                <div class="icon-box"><a target="_blank" class="asli" href="<?php echo osc_get_preference('twitter-us', 'hero'); ?>"><i class="fa fa-twitter-square text-dark"></i></a> </div>
                            </li>
                            <?php } ?>
                             <?php if(osc_get_preference('instagram-us', 'hero')!='' ) { ?>
                            <li>
                                <div class="icon-box">
                                    <a target="_blank" class="asli" href="<?php echo osc_get_preference('instagram-us', 'hero'); ?>"> <i class="fa fa-instagram text-dark"></i> </a>
                                </div>
                            </li>
                            <?php } ?>
                            <?php if(osc_get_preference('gplus-us', 'hero')!='' ) { ?>
                            <li>
                                <div class="icon-box"> <a target="_blank" class="asli" href="<?php echo osc_get_preference('gplus-us', 'hero'); ?>"><i class="fa fa-google-plus-square text-dark"></i></a> </div>
                            </li>
                            <?php } ?>
                            <?php if(osc_get_preference('linkedin-us', 'hero')!='' ) { ?>
                            <li>
                                <div class="icon-box"> <a target="_blank" class="asli" href="<?php echo osc_get_preference('linkedin-us', 'hero'); ?>"><i class="fa fa-linkedin-square text-dark"></i></a> </div>
                            </li>
                            <?php } ?>
                            <?php if(osc_get_preference('youtube-us', 'hero')!='' ) { ?>
                            <li>
                                <div class="icon-box"> <a target="_blank" class="asli" href="<?php echo osc_get_preference('youtube-us', 'hero'); ?>"><i class="fa fa-youtube text-dark"></i></a> </div>
                            </li>
                            <?php } ?> </ul>
                <div class="copyright">
                    <?php echo osc_get_preference('copyright-us', 'hero'); ?> </div>
                <div class="links">
                    <a class="kanan2" href="<?php echo osc_contact_url(); ?>">
                        <?php _e("Contact", 'hero'); ?> </a>
                    <?php osc_reset_static_pages(); ?>
                    <?php while( osc_has_static_pages() ) { ?>
                    <a class="kanan2" href="<?php echo osc_static_page_url(); ?>">
                        <?php echo osc_static_page_title(); ?> </a>
                    <?php } ?> <?php if(osc_get_preference('blog-links', 'hero')!='' ) { ?>
                            <a target="_blank" href="<?php echo osc_get_preference('blog-links', 'hero'); ?>"><?php echo osc_get_preference('blog-text', 'hero'); ?></a>
                            <?php } ?> </div><?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/bank.png" ) ) {?><br>
                <div class="footeris"><img alt="<?php echo osc_esc_html(__('Payment','hero')); ?>" src="<?php echo osc_current_web_theme_url('images/bank.png');?>"></div>
                <?php } else { ?>
                 <?php } ?>
            </div>
        </div>
    </div>
</div>