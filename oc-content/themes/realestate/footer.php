<?php
    osc_show_widgets('footer');
?>
</div>
<!-- /container -->
<!-- footer -->
<div id="footer">
    <div id="footer-inner">
        <?php echo logo_footer(); ?>
        <ul id="footer-nav">
            <li><a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'realestate') ; ?></a></li>
            <?php osc_reset_static_pages() ;
            $i = 1;
            while( osc_has_static_pages() ) {
                $last = '';
                if($i == osc_count_static_pages()){
                    $last = 'class="last"';
                }
            ?>
                <li <?php echo $last; ?>><a href="<?php echo osc_static_page_url() ; ?>"><?php echo osc_static_page_title() ; ?></a></li>
            <?php
                $i++;
            }
            ?>
        </ul>

        <?php if (!defined('MULTISITE') || MULTISITE==0) { ?>
            <p><?php _e('This website is proudly using the open source classifieds software <strong><a href="https://osclass-classifieds.com/">Osclass</a></strong>', 'realestate') ; ?>.</p>
            <p><a href="http://twitter.com/osclass" target="_blank" class="social-icon-twitter"><span class="icon"></span><?php _e('Follow @Osclass', 'realestate') ; ?></a></p>
        <?php }; ?>
    </div>
</div>
<!-- /footer -->
<?php osc_run_hook('footer') ; ?>
    </body>
</html>