<title><?php echo meta_title(); ?></title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="title" content="<?php echo osc_esc_html(meta_title()); ?>" />

<?php if( meta_description() != '' ) { ?>
  <meta name="description" content="<?php echo osc_esc_html(meta_description()); ?>" />
<?php } ?>

<?php if( function_exists('meta_keywords') ) { ?>
  <?php if( meta_keywords() != '' ) { ?>
    <meta name="keywords" content="<?php echo osc_esc_html(meta_keywords()); ?>" />
  <?php } ?>
<?php } ?>

<?php if( osc_get_canonical() != '' ) { ?>
  <link rel="canonical" href="<?php echo osc_get_canonical(); ?>"/>
<?php } ?>

<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Fri, Jan 01 1970 00:00:00 GMT" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php osc_get_item_resources(); ?>
<?php if(osc_is_ad_page()) { ?><meta property="og:image" content="<?php echo osc_resource_url(); ?>" /><?php } ?>

<script type="text/javascript">
  var fileDefaultText = '<?php echo osc_esc_js( __('No file selected', 'sofia') ); ?>';
  var fileBtnText = '<?php echo osc_esc_js( __('Choose File', 'sofia') ); ?>';
</script>

<?php
  osc_enqueue_style('style', osc_current_web_theme_url('css/style.css'));
  osc_enqueue_style('tabs', osc_current_web_theme_url('css/tabs.css'));
  osc_enqueue_style('jquery_menu', osc_base_url() . 'oc-content/plugins/jquery_menu/jquery_menu.css');
  osc_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
?>

<!--[if gt IE 8]>
  <?php osc_enqueue_style('responsive', osc_current_web_theme_url('css/responsive.css')); ?>
<![endif]-->

<?php
  osc_register_script('jquery-uniform', osc_current_web_theme_js_url('jquery.uniform.js'), 'jquery');
  osc_register_script('global', osc_current_web_theme_js_url('global.js'));
  osc_register_script('jquery_menu', osc_base_url() . 'oc-content/plugins/jquery_menu/jquery_menu.js');
  osc_register_script('date', osc_base_url() . 'oc-includes/osclass/assets/js/date.js');

  if(osc_is_ad_page()){
    osc_enqueue_script('date');
  }

  osc_enqueue_script('jquery');
  osc_enqueue_script('jquery-ui');
  osc_enqueue_script('jquery-uniform');
  osc_enqueue_script('tabber');
  osc_enqueue_script('global');

  if(function_exists('jquery_menu')) {
    osc_enqueue_script('jquery_menu');
  }
?>

<?php sofia_manage_cookies(); ?>

<?php osc_run_hook('header'); ?>