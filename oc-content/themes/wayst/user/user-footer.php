<footer class="main-footer">
    <strong>&copy; <a href="<?php echo osc_base_url(); ?>"><?php echo osc_page_title(); ?></a></strong> - <a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact us', 'wayst'); ?></a>. 
    <?php
            if( osc_get_preference('footer_link', 'wayst') ) {
                echo '  ' . __('This website is proudly using the <a title="Osclass web" href="http://osclass.org/">classifieds scripts</a> software <strong>Osclass</strong>', 'wayst');
            }
        ?>
  </footer>
  <script>
$(".flashmessage .ico-close").click(function(){
$(this).parent().hide();
});
 </script>