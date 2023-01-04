<?php
    /*
     *       Hero Responsive Osclass Themes
     *       
     *       Copyright (C) 2016 OSCLASS.me
     * 
     *       This is Hero Osclass Themes with Single License
     *  
     *       This program is a commercial software. Copying or distribution without a license is not allowed.
     *         
     *       If you need more licenses for this software. Please read more here <http://www.osclass.me/osclass-me-license/>.
     */
    $address = '';
    if(osc_user_address()!='') {
        if(osc_user_city_area()!='') {
            $address = osc_user_address().", ".osc_user_city_area();
        } else {
            $address = osc_user_address();
        }
    } else {
        $address = osc_user_city_area();
    }
    $location_array = array();
    if(trim(osc_user_city()." ".osc_user_zip())!='') {
        $location_array[] = trim(osc_user_city()." ".osc_user_zip());
    }
    if(osc_user_region()!='') {
        $location_array[] = osc_user_region();
    }
    if(osc_user_country()!='') {
        $location_array[] = osc_user_country();
    }
    $location = implode(", ", $location_array);
    unset($location_array);

    osc_enqueue_script('jquery-validate');
?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
    <?php osc_current_web_theme_path('common/head.php'); ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" /> 
</head>
<body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <style>
    .col-item .btn-details {
        width: 100%;
    }
    ul#user_data {
        padding: 0px 10px;
    }
    </style>
    <div class="container">
        <div class="row profile">
            <div class="col-md-3">
                <div class="profile-sidebar">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <?php osc_current_web_theme_path('templates/plugin/avatar.php') ; ?>
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                            <?php echo osc_user_name(); ?> 
                        </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <?php if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?>
                    <div class="profile-sidebar" style="padding:20px">
                        <p>
                            <?php _e("You must log in or register a new account in order to contact the advertiser", 'hero'); ?> </p>
                        <p class="contact_button"> <strong><a class="btn btn-success" href="<?php echo osc_user_login_url(); ?>"><?php _e("Login", 'hero'); ?></a></strong> <strong><a class="btn btn-primary" href="<?php echo osc_register_account_url(); ?>"><?php _e("Register for a free account", 'hero'); ?></a></strong> </p>
                    </div>
                    <br>
                    <?php } else { ?>
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul id="user_data">
                            <?php if( osc_user_name() !=='' ) { ?>
                            <li><b><?php _e("Full name", 'hero'); ?></b>:
                                <?php echo osc_user_name(); ?> </li>
                            <?php } ?>
                            <?php if( osc_user_phone() !=='' ) { ?>
                            <li><b><?php _e("Phone", 'hero'); ?></b>:
                                <?php echo osc_user_phone(); ?> </li>
                            <?php } ?>
                            <?php if( osc_user_phone_mobile() !=='' ) { ?>
                            <li><b><?php _e("Cell phone", 'hero'); ?></b>:
                                <?php echo osc_user_phone_mobile(); ?> </li>
                            <?php } ?>
                            <?php if( $address !=='' ) { ?>
                            <li><b><?php _e("Address", 'hero'); ?></b>:
                                <?php echo $address; ?> </li>
                            <?php } ?>
                            <?php if( $location !=='' ) { ?>
                            <li><b><?php _e("Location", 'hero'); ?></b>:
                                <?php echo $location; ?> </li>
                            <?php } ?>
                            <?php if( osc_user_website() !=='' ) { ?>
                            <li><b><?php _e("Website", 'hero'); ?></b>:
                                <a href="<?php echo osc_user_website(); ?>" target="_blank" ><?php echo osc_user_website(); ?></a> </li>
                            <?php } ?>
                            <?php if( osc_user_info() !=='' ) { ?>
                            <li><b><?php _e("User Description", 'hero'); ?></b>:
                                <?php echo osc_user_info(); ?> </li>
                            <?php } ?> </ul>
                    </div>
                    <div class="profile-userbuttons">
                        <button type="button" class="btn btn-danger btn-sm seratus" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-envelope"></i>
                            <?php _e("Send Mail", 'hero'); ?> </button>
                    </div>
                    <?php } ?>
                    <!-- END MENU -->
                    <div class="collapse" id="collapseExample">
                        <div class="well">
                            <?php if(osc_logged_user_id() !=osc_user_id()) { ?>
                            <?php if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
                            <h4 class="modal-title" id="myModalLabel"><?php _e("Contact publisher", 'hero'); ?></h4>
                            <ul id="error_list"></ul>
                            <form action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" id="contact_form">
                                <input type="hidden" name="action" value="contact_post" />
                                <input type="hidden" name="page" value="user" />
                                <input type="hidden" name="id" value="<?php echo osc_esc_html( osc_user_id() ); ?>" />
                                <div class="control-group">
                                    <label class="control-label" for="yourName">
                                        <?php _e("Your name", 'hero'); ?>:</label>
                                    <div class="controls">
                                        <?php ContactForm::your_name(); ?> 
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="yourEmail">
                                        <?php _e("Your e-mail address", 'hero'); ?>:</label>
                                    <div class="controls">
                                        <?php ContactForm::your_email(); ?> 
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="phoneNumber">
                                        <?php _e("Phone number", 'hero'); ?> (
                                        <?php _e("optional", 'hero'); ?>):</label>
                                    <div class="controls">
                                        <?php ContactForm::your_phone_number(); ?> 
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="message">
                                        <?php _e("Message", 'hero'); ?>:</label>
                                    <div class="controls textarea">
                                        <?php ContactForm::your_message(); ?> 
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <?php osc_run_hook( 'item_contact_form', osc_item_id()); ?>
                                        <?php if( osc_recaptcha_public_key() ) { ?>
                                        <script type="text/javascript">
                                        var RecaptchaOptions = {
                                            theme: 'custom',
                                            custom_theme_widget: 'recaptcha_widget'
                                        };
                                        </script>
                                        <style type="text/css">
                                        div#recaptcha_widget,
                                        div#recaptcha_image > img {
                                            width: 280px;
                                        }
                                        </style>
                                        <div id="recaptcha_widget">
                                            <div id="recaptcha_image"><img /> </div> <span class="recaptcha_only_if_image"><?php _e("Enter the words above",'hero'); ?>:</span>
                                            <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                                            <div>
                                                <a href="javascript:Recaptcha.showhelp()">
                                                    <?php _e("Help", 'hero'); ?> </a>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php osc_show_recaptcha(); ?> 
                                    </div>
                                    <button type="submit" class="topper btn btn-primary seratus">
                                        <?php _e("Send", 'hero'); ?> </button>
                                </div>
                            </form>
                            <?php ContactForm::js_validation(); ?>
                            <?php } } ?> 
                        </div>
                    </div>
                </div>
                <div class="ads">
                    <?php echo osc_get_preference('ads-member', 'hero'); ?> 
                </div>
            </div>
            <div class="col-md-9">
                <div class="profile-content">
                    <div class="wraps">
                        <div class="cat-box-title">
                            <h2><?php echo sprintf(__('Listings from %s', 'hero') ,osc_user_name()); ?></h2>
                            <div class="stripe-line"></div>
                        </div>
                        <div class="panel-body">
                            <div id="products">
                                <?php while(osc_has_items()) { ?>
                                 <div class="<?php osc_run_hook("highlight_class"); ?> ari-4 item col-md-3 productbox caption">
                            <?php if( osc_images_enabled_at_items() ) { ?>
                            <?php if( osc_count_item_resources() ) { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_item_category_id() ); ?> warnas"></i></span>
                            <?php if( osc_item_is_premium() ) { ?>
                            <div class="ribbons">
                                <div class="banner">
                                    <div class="text"><?php _e('Premium', 'hero') ; ?></div>
                                </div>
                            </div>
                            <?php } ?> <a href="<?php echo osc_item_url(); ?>"><img class="lazyOwl" src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"></a>
                            <?php } else { ?> <span class="hiden cat-label cat-label-label2"><i class="fa fa-<?php echo heros_category_icon( osc_item_category_id() ); ?> warnas"></i></span>
                            <?php if( osc_item_is_premium() ) { ?>
                            <div class="ribbons">
                                <div class="banner">
                                    <div class="text"><?php _e('Premium', 'hero') ; ?> </div>
                                </div>
                            </div>
                            <?php } ?> <a href="<?php echo osc_item_url(); ?>"><img class="lazyOwl" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"/></a>
                            <?php } ?>
                            <?php } ?>
                            <div class="productprice">
                                <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { ?>
                                <div class="pricetext">
                                    <?php echo osc_format_price(osc_item_price()); ?> </div>
                                <?php } ?> </div>
                            <div class="producttitle aribudin">
                                <a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a>
                            </div>
                            <div class="centered">
                                <?php if(osc_item_city()!='' ) { ?><strong><i class="fa fa-map-marker"></i></strong>
                                <?php echo osc_item_city(); ?>
                                <?php } ?> &middot;
                                <?php if(osc_item_region()!='' ) { ?>
                                <?php echo osc_item_region(); ?>
                                <?php } ?> 
                            </div>
                        </div>
                        <?php } ?> 
                            </div>
                            <div class="paginate">
                                <?php echo osc_pagination_items(); ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?> 
</body>
</html>