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
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo meta_title(); ?></title>
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
<?php echo logo_footer(); ?>
<script type="text/javascript">
    var hero = window.hero || {};
    hero.base_url = '<?php echo osc_base_url(true); ?>';
    var fileDefaultText = '<?php echo osc_esc_js( __('No file selected', 'hero') ) ; ?>';
    var fileBtnText     = '<?php echo osc_esc_js( __('Choose File', 'hero') ) ; ?>';
</script>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_styles_url('owl.carousel.css') ; ?>">
<link rel="stylesheet" href="<?php echo osc_current_web_theme_styles_url('bootstrap.min.css') ; ?>">
<link rel="stylesheet" href="<?php echo osc_current_web_theme_styles_url('hero.css') ; ?>">
<link rel="stylesheet" href="<?php echo osc_current_web_theme_styles_url('tuxedo-menu.css') ; ?>">
<link rel="stylesheet" href="<?php echo osc_current_web_theme_styles_url('animate.css') ; ?>">
<?php if(osc_get_preference('status-font', 'hero') == "standart") { ?>
<?php } else { ?>
<link href='https://fonts.googleapis.com/css?family=<?php echo osc_get_preference('google_fonts', 'hero_theme'); ?>' rel='stylesheet' type='text/css'>
<?php } ?>
<script src="<?php echo osc_current_web_theme_js_url('jquery-1.9.1.min.js') ; ?>"></script>
<script src="<?php echo osc_current_web_theme_js_url('bootstrap.min.js') ; ?>"></script>

<?php if(arabic_language_direction()=='rtl'){ ?>
<link href="<?php echo osc_current_web_theme_url('css/rtl.css') ; ?>" rel="stylesheet" type="text/css" />
<?php } ?>
<?php if(osc_get_preference('header-vera', 'hero') == "header1") { ?>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_styles_url('mega.css') ; ?>">
<?php } else { ?>
<?php }  ?>
<?php if(osc_get_preference('font_view', 'hero_theme') == "1") { ?>
    <?php osc_current_web_theme_path('css.php'); ?>
<?php } ?>
<?php  
    
    osc_enqueue_script('jquery-ui');
    osc_run_hook('header');

FieldForm::i18n_datePicker();
?>

<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
