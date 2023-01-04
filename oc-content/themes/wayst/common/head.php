 <?php
    $js_lang = array(
        'delete' => __('Delete', 'wayst'),
        'cancel' => __('Cancel', 'wayst')
    );

    osc_enqueue_script('jquery');
    osc_enqueue_script('jquery-ui');
    osc_register_script('global-theme-js', osc_current_web_theme_js_url('global.js'), 'jquery');
    osc_register_script('delete-user-js', osc_current_web_theme_js_url('delete_user.js'), 'jquery-ui');
    osc_enqueue_script('global-theme-js');
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title><?php echo meta_title() ; ?></title>
<meta name="title" content="<?php echo osc_esc_html(meta_title()); ?>" />
<?php if( meta_description() != '' ) { ?>
<meta name="description" content="<?php echo osc_esc_html(meta_description()); ?>" />
<?php } ?>
<?php if( meta_keywords() != '' ) { ?>
<meta name="keywords" content="<?php echo osc_esc_html(meta_keywords()); ?>" />
<?php } ?>
<?php if( osc_get_canonical() != '' ) { ?>
<!-- canonical -->
<link rel="canonical" href="<?php echo osc_get_canonical(); ?>"/>
<!-- /canonical -->
<?php } ?>
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Fri, Jan 01 1970 00:00:00 GMT" />

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<!-- favicon -->
<link rel="shortcut icon" href="<?php if (osc_get_preference('favicon2', 'wayst')){ echo osc_get_preference('favicon2', 'wayst');} else { echo osc_current_web_theme_url('images/tick.png'); } ?>" type="image/x-icon">

<script type="text/javascript">
    var wayst = window.wayst || {};
    wayst.base_url = '<?php echo osc_base_url(true); ?>';
    wayst.langs = <?php echo json_encode($js_lang); ?>;
    wayst.fancybox_prev = '<?php echo osc_esc_js( __('Previous image','wayst')) ?>';
    wayst.fancybox_next = '<?php echo osc_esc_js( __('Next image','wayst')) ?>';
    wayst.fancybox_closeBtn = '<?php echo osc_esc_js( __('Close','wayst')) ?>';
</script>
<?php osc_run_hook('header') ; ?>
<script>
$.noConflict();
// Code that uses other library's $ can follow here.
</script>
<!-- start new theme -->
    <script src="<?php echo osc_current_web_theme_url('script/jquery-1.11.1.min.js'); ?>"></script>
    <script src="<?php echo osc_current_web_theme_url('script/passwd.js'); ?>"></script>
     <script src="<?php echo osc_current_web_theme_url('script/respond.min.js'); ?>"></script>
                              
                              <script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>          
          <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('script/wayst.css'); ?>">
          <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('nss/font-awesome-4.1.0/font-awesome.min.css'); ?>">

  <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery-migrate-1.2.1.min.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_url('js/slick.css'); ?>"/>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/slick.min.js'); ?>"></script>

          <!--[if lt IE 9]>
           <!--[if lt IE 9]>
                <script src="<?php echo osc_current_web_theme_url('script/html5shiv.min.js'); ?>"></script>
                <script src="<?php echo osc_current_web_theme_url('script/respond.min.js'); ?>"></script>
           <![endif]-->