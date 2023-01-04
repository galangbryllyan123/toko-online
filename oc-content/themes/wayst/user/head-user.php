<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo meta_title() ; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="<?php if (osc_get_preference('favicon2', 'wayst')){ echo osc_get_preference('favicon2', 'wayst');} else { echo osc_esc_html(osc_current_web_theme_url('images/tick.png')); } ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('user-admin/bootstrap/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('nss/font-awesome-4.1.0/font-awesome.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('user-admin/dist/font/css/ionicons.min.css'); ?>">
 
  <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('user-admin/dist/css/AdminLTE.min.css'); ?>">
 
  <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('user-admin/dist/css/skins/_all-skins.min.css'); ?>">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?php echo osc_current_web_theme_url('user-admin/dist/font/html5shiv.min.js'); ?>"></script>
  <script src="<?php echo osc_current_web_theme_url('user-admin/dist/font/respond.min.js'); ?>"></script>
  <![endif]-->
  
  <!-- jQuery 2.2.3 -->
<script src="<?php echo osc_current_web_theme_url('user-admin/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo osc_current_web_theme_url('user-admin/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo osc_current_web_theme_url('user-admin/plugins/fastclick/fastclick.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo osc_current_web_theme_url('user-admin/dist/js/app.min.js'); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo osc_current_web_theme_url('user-admin/dist/js/demo.js'); ?>"></script>
</head>