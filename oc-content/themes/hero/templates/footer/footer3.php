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
<div id="footer-copyright" class="topper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 clearfix">
                <div class="copyright pull-left">
                    <?php echo osc_get_preference('copyright-us', 'hero'); ?> </div>
                <div class="links pull-right">
                    <a class="kanan2" href="<?php echo osc_contact_url(); ?>">
                        <?php _e("Contact", 'hero'); ?> </a>
                    <?php osc_reset_static_pages(); ?>
                    <?php while( osc_has_static_pages() ) { ?>
                    <a class="kanan2" href="<?php echo osc_static_page_url(); ?>">
                        <?php echo osc_static_page_title(); ?> </a>
                    <?php } ?><?php if(osc_get_preference('blog-links', 'hero')!='' ) { ?>
                            <a target="_blank" href="<?php echo osc_get_preference('blog-links', 'hero'); ?>"><?php echo osc_get_preference('blog-text', 'hero'); ?></a>
                            <?php } ?>  </div>
            </div>
        </div>
    </div>
</div>