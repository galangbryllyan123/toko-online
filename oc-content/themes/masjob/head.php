<?php


osc_register_script('jquery-extends', osc_current_web_theme_js_url('jquery-extends.js'), array('jquery'));
osc_register_script('theme-global', osc_current_web_theme_js_url('global.js'), array('jquery'));
osc_enqueue_script('jquery-extends');
osc_enqueue_script('jquery-validate');
osc_enqueue_script('theme-global');

osc_enqueue_style('style', osc_current_web_theme_styles_url('style.css'));

?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title><?php echo osc_page_title() ; ?></title>

<?php osc_run_hook('header') ; ?>