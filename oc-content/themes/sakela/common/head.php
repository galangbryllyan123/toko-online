<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */
?>

<?php
    $js_lang = array(
        'delete' => __('Delete', 'sakela'),
        'cancel' => __('Cancel', 'sakela')
    );

    osc_register_script('jquery', osc_current_web_theme_js_url('jquery.min.js'));
    osc_enqueue_script('jquery');
    osc_enqueue_script('jquery-ui');
    osc_register_script('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.pack.js'), array('jquery'));
    osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
    osc_enqueue_script('fancybox');
    osc_register_script('jquery-validate', osc_current_web_theme_js_url('jquery.validate.min.js'));
    osc_enqueue_script('jquery-validate');
    osc_enqueue_script('bootstrap-theme-js');
    osc_register_script('bootstrap-theme-js', osc_current_web_theme_js_url('bootstrap.min.js'), 'jquery');
    osc_enqueue_script('library-js');
    osc_register_script('library-js', osc_current_web_theme_js_url('library.js'), 'jquery');
    osc_register_script('global-theme-js', osc_current_web_theme_js_url('global.js'), 'jquery');
    osc_register_script('delete-user-js', osc_current_web_theme_js_url('delete_user.js'), 'jquery-ui');
    osc_enqueue_script('global-theme-js');
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

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

<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<link rel="shortcut icon" href="<?php echo sakela_favicon_url(); ?>" type="image/x-icon" />

<link href="<?php echo osc_current_web_theme_url('js/jquery-ui/jquery-ui-1.10.2.custom.min.css') ; ?>" rel="stylesheet" type="text/css" />

<script type="text/javascript">
    var sakela = window.sakela || {};
    sakela.base_url = '<?php echo osc_base_url(true); ?>';
    sakela.langs = <?php echo json_encode($js_lang); ?>;
    sakela.fancybox_prev = '<?php echo osc_esc_js( __('Previous image','sakela')) ?>';
    sakela.fancybox_next = '<?php echo osc_esc_js( __('Next image','sakela')) ?>';
    sakela.fancybox_closeBtn = '<?php echo osc_esc_js( __('Close','sakela')) ?>';
    sakela.rtl_view = '<?php echo (osc_get_preference('rtl_view', 'sakela') == '1')? '1': '0'; ?>';
</script>

<link href="<?php echo osc_current_web_theme_url('css/main.css') ; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('css/bootstrap.min.css') ; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('css/style.css') ; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('css/mediascreen.css') ; ?>" rel="stylesheet" type="text/css" />
<?php if(osc_get_preference('rtl_view', 'sakela') == "1") { ?>
<link href="<?php echo osc_current_web_theme_url('css/rtl.css') ; ?>" rel="stylesheet" type="text/css" />
<?php } ?>
<link href="<?php echo osc_current_web_theme_url('css/font.css') ; ?>" rel="stylesheet" type="text/css" />
<?php $color_mode = sakela_theme_color_mode(); ?>
<link href="<?php echo osc_current_web_theme_url('css/'.$color_mode.'.css') ; ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
#header {
    background: url(
        <?php if(osc_get_preference('show_banner', 'sakela') == '1') {
            $logo = osc_get_preference('homeimage','sakela') ;
            if( $logo!='' && file_exists( osc_uploads_path() . $logo ) ) {
                echo osc_base_url().'oc-content/uploads/'.$logo ;
            } else {
                echo osc_base_url().'oc-content/themes/sakela/images/background/background.jpg';
            }
        } else {
            echo osc_base_url().'oc-content/themes/sakela/images/background/background.jpg';
        } ?> 
    ) ;
    background-position:center;
    background-size:cover;
    min-height: 375px;
    margin-top: 0px;
    margin-bottom: 0px;
}
</style>
<style type="text/css">
#footer {
    background: url(
        <?php if(osc_get_preference('show_footer', 'sakela') == '1') {
            $logo = osc_get_preference('footerimage','sakela') ;
            if( $logo!='' && file_exists( osc_uploads_path() . $logo ) ) {
                echo osc_base_url().'oc-content/uploads/'.$logo ;
            } else {
                echo osc_base_url().'oc-content/themes/sakela/images/background/footerbackground.jpg';
            }
        } else {
            echo osc_base_url().'oc-content/themes/sakela/images/background/footerbackground.jpg';
        } ?> 
    ) ;
    background-position:center;
    background-size:cover;
    min-height: 500px;
    color: #fff;
    text-align: center;
    margin-top: 0px;
}
</style>


<?php osc_run_hook('header') ; ?>
