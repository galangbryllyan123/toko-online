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

    // meta tag robots
    osc_add_hook('header','wayst_nofollow_construct');

    osc_enqueue_script('jquery-validate');
    wayst_add_body_class('item item-post');
    $action = 'item_add_post';
    $edit = false;
    if(Params::getParam('action') == 'item_edit'){
        $action = 'item_edit_post';
        $edit = true;
    }
	
    ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="shortcut icon" href="<?php if (osc_get_preference('favicon2', 'wayst')){ echo osc_get_preference('favicon2', 'wayst');} else { echo osc_current_web_theme_url('images/tick.png'); } ?>" type="image/x-icon">

<link href="<?php echo osc_current_web_theme_url('nss/css-post-item/jquery-ui-1.10.2.custom.min.css'); ?>" rel="stylesheet" type="text/css" />
<!--Ie Js-->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<link href="<?php echo osc_current_web_theme_url('nss/css-post-item/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('nss/css-post-item/main.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('nss/css-post-item/apps-blue.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('nss/css-post-item/jquery.fancybox.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('nss/font-awesome-4.1.0/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('js/fineuploader/fineuploader.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('nss/css-post-item/ajax-uploader.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/fancybox/jquery.fancybox.pack.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/date.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/jquery.fineuploader.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/watchlist.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/jquery.validate.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/jquery-ui.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/global.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/checkbox.js'); ?>"></script>

<link href="<?php echo osc_current_web_theme_url('nss/css-post-item/apps.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('nss/css-post-item/main.js'); ?>"></script>


<meta name="robots" content="noindex, nofollow, noarchive" />
<meta name="googlebot" content="noindex, nofollow, noarchive" />
</head>
<?php ItemForm::location_javascript(); ?>
<body class="item item-post">
<header id="header">
  
  <div class="main_header" id="main_header">
    <div class="container" align="center">
      <div id="logo" align="center"> <?php echo logo_header(); ?> <?php 
	
				echo homepage3_image(); 
			
?> </div>
      
    </div>
  </div>
  
</header>
<div class="wrapper-flash">
  
  <div class="breadcrumb">
    <div class="container"><ul class="breadcrumb">
<li class="first-child"><a href="javascript:history.back()">
                           <i class="fa fa-caret-left" aria-hidden="true"></i> Back                                 
                            </a> |</li> <li class="first-child"><a href="javascript:;" data-toggle="modal" data-target="#myModalhelp">
                           <i class="fa fa-question-circle" aria-hidden="true"></i> <?php _e('Help', "wayst"); ?>                                 
                            </a> |</li>
<li class="last-child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb" > <span itemprop="title"><i class="fa fa-check" aria-hidden="true"></i> <?php _e('Publish a listing', "wayst"); ?></span> <i class="fa fa-caret-right" aria-hidden="true"></i></li>
</ul>

  </div>
  </div>
  <div class="modal fade" id="myModalhelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabelhelp">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" align="center"><span class='glyphicon glyphicon-question-sign'></span> <?php _e('Help', 'wayst'); ?> - <?php _e('Useful information', 'wayst'); ?></h4>
      </div>
      <div class="modal-body">
      <?php if (osc_get_preference('help-text', 'wayst')){ echo osc_get_preference('', 'wayst');} else { echo "<strong>For sellers.</strong> <br/> 1. When you publish any listing, we recommend to login with your details. If you don't have an account on our website, please feel free to register a new account for free. <br />2. In the ad use a picture, title and description to better describe your product that you sell. <br />3. Use your active e-mail and correct phone number. <br /> <strong>For buyers.</strong> <br />1. Avoid scams by acting locally or paying with PayPal. <br /> 2. Never pay with Western Union, Moneygram or other anonymous payment services. <br /> 3. Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country. <br /> 4. This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer 'buyer protection' or 'seller certification'."; } ?>
      
      <?php if( osc_get_preference('help-text', 'wayst') != '') {?>
        <?php echo osc_get_preference('help-text', 'wayst'); ?>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'wayst'); ?></button>
      </div>
    </div>
  </div>
</div>
  <div class="container">
    <div class="error_list">
     
      <?php osc_show_flash_message(); ?>
    </div>
  </div>
</div>
<?php osc_run_hook('before-content'); ?>
<div class="wrapper" id="content">
<div class="container">
<?php if( osc_get_preference('header-728x90', 'wayst') !=""){ ?>
<div class="ads_header ads-headers"> <?php echo osc_get_preference('header-728x90', 'wayst'); ?> </div>
<?php } ?>
<div id="main">


<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="wraps">
      <div class="title">
        <h1>
          <?php _e('Publish a listing', "wayst"); ?>
        </h1>
      </div>
      <ul id="error_list">
      </ul>
      <form name="item" action="<?php echo osc_base_url(true);?>" method="post" enctype="multipart/form-data" id="item-post">
        <fieldset>
          <input type="hidden" name="action" value="<?php echo $action; ?>" />
          <input type="hidden" name="page" value="item" />
          <?php if($edit){ ?>
          <input type="hidden" name="id" value="<?php echo osc_item_id();?>" />
          <input type="hidden" name="secret" value="<?php echo osc_item_secret();?>" />
          <?php } ?>
          <h2>
            <?php _e('General Information', "wayst"); ?>
          </h2>
          <div class="form-group">
            <label class="control-label" for="select_1">
              <?php _e('Category', "wayst"); ?>
            </label>
            <div class="controls styled-select_border">
              <?php  if ( osc_count_categories() ) { ?>
			<?php if(osc_get_preference('category_multiple_selects', 'wayst') == '1'){ ?>
			  <div class="cat_multiselect"><?php ItemForm::category_multiple_selects(null, null, null, __('Select a category', "wayst")); ?></div>
			<?php }else{ ?>
              <?php ItemForm::category_select(null, null, __('Select a category', "wayst")); ?>
			<?php } ?>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label" for="title[<?php echo osc_current_user_locale(); ?>]">
              <?php _e('Title', "wayst"); ?>
            </label>
            <div class="controls">
              <?php ItemForm::title_input('title',osc_current_user_locale(), osc_esc_html( wayst_item_title() )); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label" for="description[<?php echo osc_current_user_locale(); ?>]">
              <?php _e('Description', "wayst"); ?>
            </label>
            <div class="controls">
              <?php ItemForm::description_textarea('description',osc_current_user_locale(), osc_esc_html( wayst_item_description() )); ?>
            </div>
          </div>
          <?php if( osc_price_enabled_at_items() ) { ?>
          <div class="form-group form-group-price">
            <label class="control-label" for="price">
              <?php _e('Price', "wayst"); ?>
            </label>
            <div class="controls">
              <ul class="row">
                <li class="col-sm-5 col-md-5">
                  <?php ItemForm::price_input_text(); ?>
                </li>
                <li class="col-sm-7 col-md-7">
                <div class="styled-select_border">
                  <?php ItemForm::currency_select(); ?></div>
                </li>
              </ul>
            </div>
          </div>
          <?php } ?>
          <?php 
			if( osc_images_enabled_at_items() ) {
                ItemForm::ajax_photos();
            } ?>
          <div class="box location">
            <h2>
              <?php _e('Listing Location', "wayst"); ?>
            </h2>
            <div class="form-group">
              <label class="control-label" for="country">
                <?php _e('Country', "wayst"); ?>
              </label>
              <div class="controls styled-select_border">
                <?php ItemForm::country_select(osc_get_countries(), osc_user()); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="region">
                <?php _e('Region', "wayst"); ?>
              </label>
              <div class="controls styled-select_border">
                <?php ItemForm::region_select(osc_get_regions(osc_user_country()), osc_user()) ; ?>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="city">
                <?php _e('City', "wayst"); ?>
              </label>
              <div class="controls styled-select_border">
                <?php ItemForm::city_select(osc_get_cities(osc_user_region_id()), osc_user()) ; ?>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="cityArea">
                <?php _e('City Area', "wayst"); ?>
              </label>
              <div class="controls">
                <?php ItemForm::city_area_text(osc_user()); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="address">
                <?php _e('Address', "wayst"); ?>
              </label>
              <div class="controls">
                <?php ItemForm::address_text(osc_user()); ?>
              </div>
            </div>
          </div>
          <!-- seller info -->
          <?php if(!osc_is_web_user_logged_in() ) { ?>
          <div class="box seller_info">
            <h2>
              <?php _e("Seller's information", "wayst"); ?>
            </h2>
            <div class="form-group">
              <label class="control-label" for="contactName">
                <?php _e('Name', "wayst"); ?>
              </label>
              <div class="controls">
                <?php ItemForm::contact_name_text(); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="contactEmail">
                <?php _e('E-mail', "wayst"); ?>
              </label>
              <div class="controls">
                <?php ItemForm::contact_email_text(); ?>
              </div>
            </div>
            <div class="form-group">
              <div class="controls checkbox">
                <?php ItemForm::show_email_checkbox(); ?>
                <label for="showEmail">
                  <?php _e('Show e-mail on the listing page', "wayst"); ?>
                </label>
              </div>
            </div>
          </div>
          <?php
                        }
		
                        if($edit) {
                            ItemForm::plugin_edit_item();
                        } else {
                            ItemForm::plugin_post_item();
                        }
                        ?>
          <div class="form-group">
            
            <div class="controls" align="center">
              <?php osc_show_recaptcha(); ?>
            </div>
            <br />
            <div class="controls">
              <button type="submit" class="btn btn-success btn-block">
              <?php if($edit) { _e("Update", "wayst"); } else { _e("Publish", "wayst"); } ?>
              </button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
            $('#price').bind('hide-price', function(){
                $('.form-group-price').hide();
            });

            $('#price').bind('show-price', function(){
                $('.form-group-price').show();
            });

    <?php if(osc_locale_thousands_sep()!='' || osc_locale_dec_point() != '') { ?>
    $().ready(function(){
        $("#price").blur(function(event) {
            var price = $("#price").prop("value");
            <?php if(osc_locale_thousands_sep()!='') { ?>
            while(price.indexOf('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>')!=-1) {
                price = price.replace('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>', '');
            }
            <?php }; ?>
            <?php if(osc_locale_dec_point()!='') { ?>
            var tmp = price.split('<?php echo osc_esc_js(osc_locale_dec_point())?>');
            if(tmp.length>2) {
                price = tmp[0]+'<?php echo osc_esc_js(osc_locale_dec_point())?>'+tmp[1];
            }
            <?php }; ?>
            $("#price").prop("value", price);
        });
    });
    <?php }; ?>
</script>

</div>
</div>
<?php osc_run_hook('after-main'); ?>
</div>
<?php osc_show_widgets('footer');?>

<footer id="footer">
  <div class="container">
    <div class="footer">
      <?php //------- languages ---------/ ?>
      <?php if ( osc_count_web_enabled_locales() > 1) { ?>
      <?php osc_goto_first_locale(); ?>
      <strong>
      <?php _e('Language:', "wayst"); ?>
      </strong>
      <ul>
        <?php $i = 0;  ?>
        <?php while ( osc_has_web_enabled_locales() ) { ?>
        <li><a id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a></li>
        <?php if( $i == 0 ) { echo ""; } ?>
        <?php $i++; ?>
        <?php } ?>
      </ul>
      <?php } ?>
      <ul>
        <?php if( osc_users_enabled() ) { ?>
        <?php if( osc_is_web_user_logged_in() ) { ?>
        <li> <?php echo sprintf(__('Hi %s', "wayst"), osc_logged_user_name() . '!'); ?> &#10072; <strong><a href="<?php echo osc_user_dashboard_url(); ?>">
          <?php _e('My account', "wayst"); ?>
          </a></strong> <a href="<?php echo osc_user_logout_url(); ?>">
          <?php _e('Logout', "wayst"); ?>
          </a> </li>
        <?php } else { ?>
        <li> <a href="<?php echo osc_user_login_url(); ?>">
          <?php _e('Login', "wayst"); ?>
          </a></li>
        <?php if(osc_user_registration_enabled()) { ?>
        <li> <a href="<?php echo osc_register_account_url(); ?>">
          <?php _e('Register for a free account', "wayst"); ?>
          </a> </li>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        
        <li> <a href="<?php echo osc_contact_url(); ?>">
          <?php _e('Contact', "wayst"); ?>
          </a> </li>
      </ul>
      <?php
            if( osc_get_preference('footer_link', 'wayst') ) {
            echo '<div class="copyright">' . sprintf(__('Powered by: <a class="link_primary txt_underline text-bold" title="Osclass web" href="%s"><strong>Osclass.org</strong>.</a>'), 'http://osclass.org/') . ' </div>'; }
        ?>
    </div>
  </div>
</footer>
<?php osc_run_hook('footer'); ?>
<?php if(osc_is_ad_page() || osc_is_search_page()){ ?>
<?php } ?>
</body></html>