<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title><?php echo meta_title() ; ?></title>
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

<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Mon, 01 Jul 1970 00:00:00 GMT" />
<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php osc_get_item_resources(); ?>
<?php if(osc_is_ad_page()) { ?><meta property="og:image" content="<?php echo osc_resource_url(); ?>" /><?php } ?>

<!--<meta http-equiv="X-UA-Compatible" content="IE=8" />-->

<script type="text/javascript">
  var fileDefaultText = '<?php echo osc_esc_js( __('No file selected', 'tatiana') ) ; ?>';
  var fileBtnText     = '<?php echo osc_esc_js( __('Choose File', 'tatiana') ) ; ?>';
</script>

<?php
osc_enqueue_style('style', osc_current_web_theme_url('style.css'));
osc_enqueue_style('tabs', osc_current_web_theme_url('tabs.css'));
osc_enqueue_style('responsive', osc_current_web_theme_url('responsive.css'));
osc_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
osc_enqueue_style('datePick', '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.min.css');

osc_register_script('jquery-uniform', osc_current_web_theme_js_url('jquery.uniform.js'), 'jquery');
osc_register_script('global', osc_current_web_theme_js_url('global.js'));
osc_register_script('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.js'), array('jquery'));
osc_register_script('validate', osc_current_web_theme_js_url('jquery.validate.min.js'), array('jquery'));
osc_register_script('date', osc_base_url() . 'oc-includes/osclass/assets/js/date.js');

osc_enqueue_script('jquery');
osc_enqueue_script('fancybox');
osc_enqueue_script('validate');

if (function_exists('watchlist')) {
  osc_register_script('watchlist', osc_base_url(). 'oc-content/plugins/watchlist/js/watchlist.js');
  osc_enqueue_script('watchlist');
}

osc_enqueue_script('jquery-ui');
osc_enqueue_script('jquery-uniform');
osc_enqueue_script('tabber');
osc_enqueue_script('global');

if(osc_is_publish_page() || osc_is_edit_page()){ 
  osc_enqueue_script('date');
}
?>

<?php
if (class_exists('OSCFacebook') and 1==2) {
  $fblogoutpage = "/?facebook_logout=true";
  $currentpagefb = $_SERVER['REQUEST_URI'];

  if($fblogoutpage==$currentpagefb) {
    echo '<meta http-equiv="REFRESH" content="0;url=' . OSCFacebook::newInstance()->logoutUrl() . '">';
  }
}
?>

<?php tatiana_manage_cookies(); ?>

<?php osc_run_hook('header') ; ?>