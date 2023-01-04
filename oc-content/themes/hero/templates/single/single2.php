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

<div class="container item">
    <div id="content">
        <div class="row">
            <div class="main col-md-12">
                <div class="col-md-8">
                    <div class="col-md-12 panel panel-body">
                        <h1 class="judul"><?php echo osc_item_title(); ?></h1>
                        <p class="datas"><em class="publish"><i class="fa fa-calendar"></i> <?php if ( osc_item_pub_date() != '' ) echo __('Published date', 'hero') . ': ' . osc_format_date( osc_item_pub_date() ); ?></em> <em class="update"> <?php if ( osc_item_mod_date() != '' ) echo __('Modified date', 'hero') . ': ' . osc_format_date( osc_item_mod_date() ); ?></em> </p>
                        <div id="owl-demo77" class="owl-carousel owl-theme">
                            <?php if( osc_images_enabled_at_items() ) { ?>
                            <?php if( osc_count_item_resources()> 0 ) { $i = 0; ?>
                            <?php for ( $i=0 ; osc_has_item_resources(); $i++ ) { ?>
                            <div class="item"><a href="<?php echo osc_resource_url(); ?>" class="group1"><img src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" /></a></div>
                            <?php } ?>
                            <?php } else { ?>
                            <div class="item"><a href="<?php echo osc_resource_url(); ?>" class="group1"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" /></a></div>
                            <?php } ?>
                            <?php } ?> </div>
                        <h4 class="desss"><?php _e("Description", 'hero'); ?></h4>
                        <p class="narrow">
                            <?php echo osc_item_description(); ?> </p>
                        <?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) { ?>
                        <p id="edit_item_view"> <strong>
                                <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><?php _e("Edit item", 'hero'); ?></a>
                            </strong> </p>
                        <?php } ?>
                        <div class="senik">
                            <h4 class="desss"><?php _e("More information", 'hero'); ?></h4>
                            <p class="metas"><i class="fa fa-chevron-down"></i>
                                <?php _e("Category", 'hero'); ?>:
                                <?php echo osc_item_category(); ?> </p>
                            <p class="metas"><i class="fa fa-eye"></i>
                                <?php _e("Viewed", 'hero'); ?>:
                                <?php echo osc_item_views(); ?> </p>
                            <?php if( osc_count_item_meta()>= 1 ) { ?>
                            <div class="meta_list">
                                <?php while ( osc_has_item_meta() ) { ?>
                                <?php if(osc_item_meta_value()!='' ) { ?>
                                <p class="metas"><i class="fa fa-chevron-down"></i>
                                    <?php echo osc_item_meta_name(); ?>:
                                    <?php echo osc_item_meta_value(); ?> </p>
                                <?php } ?>
                                <?php } ?> </div>
                            <?php } ?> </div>
                        <div class="btn-group">
                            <button type="button" class="mami btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-flag"></i>
                                <?php _e("Mark as", 'hero'); ?> <span class="caret"></span> </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a id="item_spam" href="<?php echo osc_item_link_spam(); ?>" rel="nofollow">
                                        <?php _e("spam", 'hero'); ?> </a>
                                </li>
                                <li>
                                    <a id="item_bad_category" href="<?php echo osc_item_link_bad_category(); ?>" rel="nofollow">
                                        <?php _e("misclassified", 'hero'); ?> </a>
                                </li>
                                <li>
                                    <a id="item_repeated" href="<?php echo osc_item_link_repeated(); ?>" rel="nofollow">
                                        <?php _e("duplicated", 'hero'); ?> </a>
                                </li>
                                <li>
                                    <a id="item_expired" href="<?php echo osc_item_link_expired(); ?>" rel="nofollow">
                                        <?php _e("expired", 'hero'); ?> </a>
                                </li>
                                <li>
                                    <a id="item_offensive" href="<?php echo osc_item_link_offensive(); ?>" rel="nofollow">
                                        <?php _e("offensive", 'hero'); ?> </a>
                                </li>
                            </ul>
                        </div>
                        <button onclick="parent.location='<?php echo osc_item_send_friend_url(); ?>'" style="margin-left:5px" class="mami btn btn-default"><i class="fa fa-user"></i> <?php _e("Send to a friend", 'hero'); ?></button>
                        
                        <?php osc_run_hook( 'item_detail', osc_item() ); ?> </div>
                    <div id="related_ads">
                        <?php related_listings(); ?>
                        <?php if( osc_count_items()> 0 ) { ?>
                        <div class="similar_ads">
                            <h3><?php _e("Related Ads", 'hero'); ?></h3>
                            <?php View::newInstance()->_exportVariableToView("listType", 'items'); osc_current_web_theme_path('templates/plugin/related1.php'); ?>
                            <div class="clear"></div>
                        </div>
                        <?php } else { ?>
                        <div class="similar_ads">
                            <h3><?php _e("No Related Ads", 'hero'); ?></h3> </div>
                        <?php } ?> </div>
                    <?php if( osc_comments_enabled() ) { ?>
                    <div class="col-md-12 panel panel-body">
                        <p class="narrow text-center">
                            <h3 class="head text-center"><i class="fa fa-comment"></i> <?php _e("Comments", 'hero'); ?></h3>
                            <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
                            <div id="comments">
                                <ul id="comment_error_list"></ul>
                                <?php CommentForm::js_validation(); ?>
                                <?php if( osc_count_item_comments()>= 1 ) { ?>
                                <div class="comments_list">
                                    <?php while ( osc_has_item_comments() ) { ?>
                                    <div class="comment">
                                        <h3><strong><?php echo osc_comment_title(); ?></strong> <em><?php _e("by", 'hero'); ?> <?php echo osc_comment_author_name(); ?>:</em></h3>
                                        <div class="bubel">
                                            <div class="lancip"></div>
                                            <p>
                                                <?php echo nl2br( osc_comment_body() ); ?> </p>
                                        </div>
                                        <?php if ( osc_comment_user_id() && (osc_comment_user_id()==osc_logged_user_id()) ) { ?>
                                        <p>
                                            <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>">
                                                <?php _e("Delete", 'hero'); ?> </a>
                                        </p>
                                        <?php } ?> </div>
                                    <?php } ?>
                                    <div class="paginate" style="text-align: right;">
                                        <?php echo osc_comments_pagination(); ?> </div>
                                </div>
                                <?php } ?>
                                <a class="center btn btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"> <i class="fa fa-edit"></i>
                                    <?php _e("Leave your comment", 'hero'); ?> </a>
                                <br>
                                <div class="collapse" id="collapseExample">
                                    <div class="well">
                                        <form action="<?php echo osc_base_url(true); ?>" method="post" name="comment_form" id="comment_form">
                                            <fieldset>
                                                <input type="hidden" name="action" value="add_comment" />
                                                <input type="hidden" name="page" value="item" />
                                                <input type="hidden" name="id" value="<?php echo osc_esc_html( osc_item_id() ); ?>" />
                                                <?php if(osc_is_web_user_logged_in()) { ?>
                                                <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
                                                <input type="hidden" name="authorEmail" value="<?php echo osc_esc_html( osc_logged_user_email() ); ?>" />
                                                <?php } else { ?>
                                                <label for="authorName">
                                                    <?php _e("Your name", 'hero'); ?>:</label>
                                                <br>
                                                <?php CommentForm::author_input_text(); ?>
                                                <br>
                                                <label for="authorEmail">
                                                    <?php _e("Your e-mail", 'hero'); ?>:</label>
                                                <br>
                                                <?php CommentForm::email_input_text(); ?>
                                                <br>
                                                <?php }; ?>
                                                <label for="title">
                                                    <?php _e("Title", 'hero'); ?>:</label>
                                                <br>
                                                <?php CommentForm::title_input_text(); ?>
                                                <br />
                                                <label for="body">
                                                    <?php _e("Comment", 'hero'); ?>:</label>
                                                <br>
                                                <?php CommentForm::body_input_textarea(); ?>
                                                <br />
                                                <button style="margin-top:15px;" class="btn btn-success" type="submit">
                                                    <?php _e("Send", 'hero'); ?> </button>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php } ?> </div>
                    <?php } ?> </div>
                <!-- Content END -->
                <div class="col-md-4">
                    <div class="col-md-12 red panel-body bottomer">
                        <h2 class="harga"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { ?><?php echo osc_item_formated_price(); ?> <?php } ?></h2> </div>
                    <div class="col-md-12 panel panel-body">
                        <h3 class="head text-center"><?php _e("Contact seller", 'hero'); ?></h3>
                        <p class="narrow text-center">
                            <div class="profile-userpic">
                                <?php echo show_avatar(osc_user_id()); ?>
                            </div>
                            <p class="contact_button">
                                <?php if( !osc_item_is_expired () ) { ?>
                                <?php if( !( ( osc_logged_user_id()==osc_item_user_id() ) && osc_logged_user_id() !=0 ) ) { ?>
                                <?php if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?> <strong></strong>
                                <?php } ?>
                                <?php } ?>
                                <?php } ?>
                                <div id="contact">
                                    <?php if( osc_item_is_expired () ) { ?>
                                    <p>
                                        <?php _e("The listing is expired. You can't contact the publisher.", 'hero'); ?> </p>
                                    <?php } else if( ( osc_logged_user_id()==osc_item_user_id() ) && osc_logged_user_id() !=0 ) { ?>
                                    <p>
                                        <?php _e("It's your own listing, you can't contact the publisher.", 'hero'); ?> </p>
                                    <?php } else if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?>
                                    <p>
                                        <?php _e("You must log in or register a new account in order to contact the advertiser", 'hero'); ?> </p>
                                    <p class="contact_button"> <strong><a href="<?php echo osc_user_login_url(); ?>"><?php _e("Login", 'hero'); ?></a></strong> <strong><a href="<?php echo osc_register_account_url(); ?>"><?php _e("Register for a free account", 'hero'); ?></a></strong> </p>
                                    <br>
                                    <?php } else { ?>
<div class="profile-usermenus hidden-md-up">
    <div class="report-inner section_bg">
    	<div class="row"><?php if ( osc_user_phone_mobile() !='' ) { ?>
        	<div class="col-xs-6 paddinge">
            	<a href="https://api.whatsapp.com/send?phone=62<?php echo osc_user_phone_mobile(); ?>&text=<?php echo rawurlencode(osc_item_url()); ?>%20Stock%20Ready?"  class="btn btn-call btn-block"><span class=" fa fa-whatsapp"></span> <?php _e('Whatsapp', 'hero'); ?></a>
            </div><?php } ?>
             <?php if ( osc_user_phone() !='' ) { ?>
            <div class="col-xs-6  paddinge">
            	<a href="tel:<?php echo osc_user_phone(); ?>"  class="btn btn-call  btn-block "><span class="txt_color_1  fa fa-phone"></span> <?php _e('Call', 'hero'); ?></a>
            </div><?php } ?>
        </div>
    </div>
</div>
                                    <?php if( osc_item_user_id() !=null ) { ?> <p class="name"><strong><?php _e("Name", 'hero') ?>: <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>" ><?php echo osc_item_contact_name(); ?></a></strong></p>
                                    <?php } else { ?>
                                    <p class="name"><strong><?php _e("Name", 'hero') ?>:</strong>
                                        <?php echo osc_item_contact_name(); ?> </p>
                                    <?php } ?>
                                    <?php if( osc_item_show_email() ) { ?>
                                    <p class="email"><strong><?php _e("E-mail", 'hero'); ?>:</strong>
                                        <?php echo osc_item_contact_email(); ?> </p>
                                    <?php } ?>
                                    <div class="number">
                                        <?php if ( osc_user_phone_mobile() !='' ) { ?>
                                        <div class="mobile_number">
                                            <div class="see"> <strong><?php _e("Cell phone", 'hero'); ?>:</strong> <span id="clickToShow"><?php echo osc_user_phone_mobile(); ?></span> </div>
                                        </div>
                                        <?php } ?>
                                        <script>
                                        var shortNumber = $("#clickToShow").text().substring(0, $("#clickToShow").text().length - 8);
                                        var eventTracking = "_gaq.push(['_trackEvent', 'EVENT-CATEGORY', 'EVENT-ACTION', 'EVENT-LABEL']);";
                                        $("#clickToShow").hide().after('<span id="clickToShowButton" onClick="' + eventTracking + '">' + shortNumber + 'xx xxx xxx <span class="text"><span><?php _e("Show", 'hero'); ?></span></span></span>');
                                        $("#clickToShowButton").click(function()
                                        {
                                            $("#clickToShow").show();
                                            $("#clickToShowButton").hide();
                                        });
                                        </script>
                                    </div>
                                    <?php if (function_exists('osc_telephone_number')) { ?>
                                    <?php osc_telephone_number(); ?>
                                    <?php } ?>
                                    <?php if ( osc_item_city() !="" ) { ?>
                                    <p class="city"><strong><?php _e("City", 'hero'); ?>:</strong>
                                        <?php echo osc_item_city(); ?> </p>
                                    <?php } ?>
                                    <?php if ( osc_item_region() !='' ) { ?>
                                    <p class="region"><strong><?php _e("Region", 'hero'); ?>:</strong>
                                        <?php echo osc_item_region(); ?> </p>
                                    <?php } ?>
                                    <?php if ( osc_item_country() !='' ) { ?>
                                    <p class="region"><strong><?php _e("Country", 'hero'); ?>:</strong>
                                        <?php echo osc_item_country(); ?> </p>
                                    <?php } ?>
                                   <button type="button" class="btn btn-primary btn-lg rini seratus" data-toggle="collapse" data-target="#collapsePesan" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-envelope"></i>
                                        <?php _e("Send Mail", 'hero'); ?> </button>

<div class="collapse" id="collapsePesan">
  <div class="well">
<ul id="error_list"></ul>
                                                <?php ContactForm::js_validation(); ?>
                                                <div class="row">
                                                    
                                                        <form <?php if( osc_item_attachment() ) { ?>enctype="multipart/form-data"
                                                            <?php } ?> action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" id="contact_form" class="col-md-12">
                                                            <?php osc_prepare_user_info(); ?>
                                                            <fieldset>
                                                                <div class="row">
                                                                    
                                                                        <div class="form-group">
                                                                            <label>
                                                                                <?php _e("Your name", 'hero'); ?> </label>
                                                                            <?php ContactForm::your_name(); ?> </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                <?php _e("Your e-mail address", 'hero'); ?> </label>
                                                                            <?php ContactForm::your_email(); ?> </div>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                <?php _e("Phone number", 'hero'); ?> </label>
                                                                            <?php ContactForm::your_phone_number(); ?> </div>
                                                                    
                                                                        <?php if( osc_item_attachment() ) { ?>
                                                                        <label for="contact-attachment">
                                                                            <?php _e("Attachments", 'hero') ; ?> </label>
                                                                        <?php ContactForm::your_attachment() ; ?>
                                                                        <?php } ?>
                                                                        <?php osc_run_hook( 'item_contact_form', osc_item_id()); ?>
                                                                        <div class="form-group">
                                                                            <label>
                                                                                <?php _e("Message", 'hero'); ?> </label>
                                                                            <?php ContactForm::your_message(); ?> </div>
                                                                        <input type="hidden" name="action" value="contact_post" />
                                                                        <input type="hidden" name="page" value="item" />
                                                                        <input type="hidden" name="id" value="<?php echo osc_esc_html( osc_item_id() ); ?>" />
                                                                        <?php if( osc_recaptcha_public_key() ) { ?>
                                                                        <script type="text/javascript">
                                                                        var RecaptchaOptions = {
                                                                            theme: 'custom',
                                                                            custom_theme_widget: 'recaptcha_widget'
                                                                        };
                                                                        </script>
                                                                        
                                                                        <div id="recaptcha_widget">
                                                                            <div id="recaptcha_image"></div> <span class="recaptcha_only_if_image"><?php _e("Enter the words above",'hero'); ?>:</span>
                                                                            <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                                                                            
                                                                                <a href="javascript:Recaptcha.showhelp()">
                                                                                    <?php _e("Help", 'hero'); ?> </a>
                                                                            
                                                                        </div>
                                                                        <?php } ?>
                                                                        <?php osc_show_recaptcha(); ?> </div>
                                                                 
                                                                        <button type="submit" class="btn btn-success topper pull-left seratus">
                                                                            <?php _e("Send", 'hero'); ?> </button>
                                                                  
                                                                
                                                            </fieldset>
                                                        </form>
                                                   
                                                </div>
  </div>
</div>
<!-- collapse pesan -->
                                    <?php } ?>
                                    <?php if ( osc_user_name() !='' ) { ?>
                                    <button onclick="parent.location='<?php echo osc_user_public_profile_url(
osc_item_user_id() ); ?>'" style="width:100%" class="btn btn-info topper btn-lg rini"><?php _e("See all ads from", 'hero'); ?><?php echo osc_user_name(); ?></button>
                                    <?php } ?> </div>
                               
                                <div class="maparea">
                                    <?php osc_run_hook( 'location'); ?> </div>
                    </div>
                    <div class="col-md-12 wraps panel-body">
                                             <div class="useful">
                                                <h3><?php if(osc_get_preference('judul6-us', 'hero')!='' ) { ?><?php echo osc_get_preference('judul6-us', 'hero'); ?><?php } else { ?><?php _e("Useful information", 'hero'); ?><?php } ?></h3> </div>
                                            <div class="usecontent">
                                            <?php if(osc_get_preference('footer-us6', 'hero')!='' ) { ?>
                                                <?php echo osc_get_preference('footer-us6', 'hero'); ?>
                                            <?php } else { ?>
                                    <ul class="usef">
                                    <li>
                                        <?php _e('Avoid scams by acting locally or paying with PayPal', 'hero'); ?> </li>
                                    <li>
                                        <?php _e('Never pay with Western Union, Moneygram or other anonymous payment services', 'hero'); ?> </li>
                                    <li>
                                        <?php _e('Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country', 'hero'); ?> </li>
                                    <li>
                                        <?php _e('This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer "buyer protection" or "seller certification"', 'hero'); ?> </li>
                                </ul><?php } ?></div>
                                        </div>
                    <?php if(osc_get_preference( 'sidebar-300x250', 'hero')!='' ) { ?>
                    <div class="col-md-12 panel panel-body">
                        <?php echo osc_get_preference( 'sidebar-300x250', 'hero'); ?> </div>
                    <?php } ?> </div>
            </div>
        </div>
    </div>
</div>
<!-- Colorbox js -->
<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.colorbox.js') ; ?>"></script>
<script>
    $(document).ready(function() {
        $(".group1").colorbox({
            rel: 'group1'
        });

    });
</script>
<script>
var cboxOptions = {
  width: '95%',
  height: '95%',
  maxWidth: '960px',
  maxHeight: '960px',
}

$('.group1').colorbox(cboxOptions);

$(window).resize(function(){
    $.colorbox.resize({
      width: window.innerWidth > parseInt(cboxOptions.maxWidth) ? cboxOptions.maxWidth : cboxOptions.width,
      height: window.innerHeight > parseInt(cboxOptions.maxHeight) ? cboxOptions.maxHeight : cboxOptions.height
    });
});
</script>
<script src="<?php echo osc_current_web_theme_js_url('owl.carousel.js') ; ?>"></script>
<script src="<?php echo osc_current_web_theme_js_url('power3.js') ; ?>"></script>