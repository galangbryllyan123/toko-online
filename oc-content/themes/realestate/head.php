<?php


osc_register_script('jquery-ad-gallery', osc_current_web_theme_js_url('jquery.ad-gallery.1.2.5.js'), array('jquery'));
osc_register_script('tabber', osc_current_web_theme_js_url('tabber-minimized.js'), array('jquery'));
osc_register_script('theme-global', osc_current_web_theme_js_url('global.js'), array('jquery'));
osc_register_script('theme-ui', osc_current_web_theme_js_url('ui.js'), array('jquery'));
osc_enqueue_script('jquery-ui');
osc_enqueue_script('tabber');
osc_enqueue_script('jquery-ad-gallery');
osc_enqueue_script('jquery-validate');
osc_enqueue_script('theme-global');
osc_enqueue_script('theme-ui');

osc_enqueue_style('style', osc_current_web_theme_styles_url('style.css'));


?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<title><?php echo meta_title() ; ?></title>
<meta name="title" content="<?php echo meta_title() ; ?>" />
<meta name="description" content="<?php echo meta_description() ; ?>" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Fri, Jan 01 1970 00:00:00 GMT" />

<script type="text/javascript">
    var fileDefaultText = '<?php echo osc_esc_js( __('No file selected', 'realestate') ) ; ?>';
    var fileBtnText     = '<?php echo osc_esc_js( __('Choose File', 'realestate') ) ; ?>';
</script>

<?php osc_run_hook('header') ; ?>