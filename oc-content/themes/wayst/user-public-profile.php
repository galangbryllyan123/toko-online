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
    osc_add_hook('header','wayst_follow_construct');

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

    wayst_add_body_class('user-public-profile');
    osc_add_hook('after-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-public-sidebar.php');
    }

    osc_current_web_theme_path('header.php');
?>
<style type="text/css">
.profile 
{
    min-height: 230px;
    display: inline-block;
    }
figcaption.ratings
{
    margin-top:20px;
    }
figcaption.ratings a
{
    color:#f1c40f;
    font-size:11px;
    }
figcaption.ratings a:hover
{
    color:#f39c12;
    text-decoration:none;
    }
.divider 
{
    border-top:1px solid rgba(0,0,0,0.1);
    }
.emphasis 
{
    border-top: 4px solid transparent;
    }
.emphasis:hover 
{
    border-top: 4px solid #1abc9c;
    }
.emphasis h2
{
    margin-bottom:0;
    }
span.tags 
{
    background: #1abc9c;
    border-radius: 2px;
    color: #f5f5f5;
    font-weight: bold;
    padding: 2px 4px;
    }
.dropdown-menu 
{
    background-color: #34495e;    
    box-shadow: none;
    -webkit-box-shadow: none;
    width: 250px;
    margin-left: -125px;
    left: 50%;
    }
.dropdown-menu .divider 
{
    background:none;    
    }
.dropdown-menu>li>a
{
    color:#f5f5f5;
    }
.dropup .dropdown-menu 
{
    margin-bottom:10px;
    }
.dropup .dropdown-menu:before 
{
    content: "";
    border-top: 10px solid #34495e;
    border-right: 10px solid transparent;
    border-left: 10px solid transparent;
    position: absolute;
    bottom: -10px;
    left: 50%;
    margin-left: -10px;
    z-index: 10;
    }
</style>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/addthis_widget.js'); ?>"></script>
                        <script>

var addthis_config = {
    "data_track_clickback":true,
    "data_track_addressbar":true,
    "data_ga_property": "",
    "data_ga_social": true,
    "ui_email_note":"<?php echo sprintf(__('%s\'s profile', 'wayst'), osc_user_name()); ?>"

};

var addthis_share =
{
   url: "<?php echo osc_item_url(); ?>",
   lurl: "<?php echo osc_item_url(); ?>",
   title:"<?php echo osc_item_title(); ?>",
   description:"<?php echo sprintf(__('%s\'s profile', 'wayst'), osc_user_name()); ?>",
}
</script>
<body class="wayst">
            <?php osc_current_web_theme_path('common/rtop-menu2.php') ; ?>
            
            <!-- initiate page content -->
            <div class="container page-content news">
                <?php
        $breadcrumb = osc_breadcrumb('', false, get_breadcrumb_lang());
        if( $breadcrumb !== '') { ?>
                <ol class="breadcrumb"><li><?php echo $breadcrumb; ?></li></ol><?php
        }
    ?>                                                            <h1>
                <?php echo sprintf(__('%s\'s profile', 'wayst'), osc_user_name()); ?><small>
                            <span class="share">
                        <a class="addthis_button_facebook addthis_32x32_style" title="Facebook" href="javascript:(void)"></a>
                    <a class="addthis_button_twitter addthis_32x32_style" title="Tweet" href="javascript:(void)"></a>
                    <a class="addthis_button_google_plusone_share addthis_32x32_style" title="Google+" href="javascript:(void)"></a>
                    <a class="addthis_button_email addthis_32x32_style" target="_blank" title="Email" href="javascript:(void)"></a>
                    <a class="addthis_button_compact addthis_32x32_style" href="javascript:(void)"></a>
                    </span>
                                    </small>
            </h1>

            <article class="news-article ">
            <!-- starting profile -->
            <div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
    	 <div class="well profile">
            <div class="col-sm-12">
                <div class="col-xs-12 col-sm-8">
                    <p><strong><?php _e('Name', 'wayst'); ?>: </strong><?php echo osc_user_name(); ?></p>
                    <p><strong><?php _e('Location', 'wayst'); ?>: </strong><?php echo $location; ?></p>
                    <p><strong>Member: </strong><?php echo osc_format_date(osc_user_field('dt_reg_date')); ?></p>
                    <p><strong><?php _e("Phone", 'wayst'); ?>: </strong>
                        <span class="tags"><?php echo osc_user_phone(); ?></span> 
                        
                    </p>
                </div>             
                <div class="col-xs-12 col-sm-4 text-center">
                    <figure class="image-s"><?php if (function_exists('profile_picture_show')){profile_picture_show();} else{ echo '<img src="' . osc_current_web_theme_url('images/no-user-photo.jpg') . '" class="img-circle profile_avatar img-responsive" >'; } ?>
                        
                        
                    </figure>
                </div>
            </div>            
            <div class="col-xs-12 divider text-center">
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h2><strong> <?php echo osc_user_items_validated() ?> </strong></h2>                    
                    <p><small><?php _e('Active', 'wayst'); ?></small></p>
                    <button class="btn btn-success btn-block"><span class="fa fa-check-circle"></span> <?php _e('Listings', 'wayst'); ?> </button>
                </div>
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h2><strong><?php _e('Send', 'wayst'); ?></strong></h2>                    
                    <p><small><?php _e('Email', 'wayst'); ?></small></p>
                    <button class="btn btn-info btn-block" id="share-email"><span class="fa fa-envelope"></span> <?php _e('Send', 'wayst'); ?> <?php _e('Email', 'wayst'); ?></button>
                </div>
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h2><strong><?php _e('Website', 'wayst'); ?></strong></h2>                    
                    <p><small><?php _e('Description', 'wayst'); ?></small></p>
                    <div class="btn-group dropup btn-block">
                      <button type="button" class="btn btn-primary"><span class="fa fa-plus-circle"></span> See more </button>
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu text-left" role="menu">
                        <li><a href="<?php echo osc_user_website(); ?>" target="_blank" rel="nofollow"><?php _e('Website', 'wayst'); ?>: <?php echo osc_user_website(); ?></a></li>
                        <li class="divider"></li>
                        <li style="background-color:#FFFFFF; padding:5px"><?php _e('Description', 'wayst'); ?>: <?php echo osc_user_info(); ?></li>
                        <li class="divider"></li>
                        <li><a href="javascript:;"><?php _e('Last active', 'wayst'); ?>: <?php echo osc_format_date(osc_user_field('dt_access_date')); ?></a></li>
                        <li class="divider"></li>
                        
                      </ul>
                    </div>
                </div>
            </div>
    	 </div>                 
		</div>
	</div>
</div>
 <!-- end profile -->
                

                <h2 class="list-heading"><?php _e("Listings", 'wayst'); ?> <?php echo osc_user_name(); ?></h2>                <table class="table table-striped table-condensed product-list" >
                    <tr>
                                                <th ></th>
                        <th ><?php _e("Description", 'wayst'); ?></th>
                                                                            <th class="text-right" ></th>
                            <th class="text-right" ><?php _e("Price", 'wayst'); ?></th>
                                            </tr>
                                            
                                               <!-- start -->
                                               <?php if(osc_count_items() == 0) { ?>
                                               <p align="center"><?php _e('No listings have been added yet', 'wayst'); ?></p>
                <?php } else { ?>
                            <?php while(osc_has_items()) { ?>
                                                <tr itemProp="itemOffered" class="item small-cover">

                            <td class="col-0 text-center">            <?php if( osc_images_enabled_at_items() ) { ?>
         <?php if(osc_count_item_resources()) { ?><figure class="image-s">
                <a href="<?php echo osc_item_url(); ?>"  >
                    <img src="<?php echo osc_resource_thumbnail_url(); ?>" class="image-s" itemprop="image">                </a>
            </figure>
            <?php } else { ?>
            <figure class="image-s">
                <a href="<?php echo osc_item_url(); ?>"  >
                    <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" class="image-s" itemprop="image">                </a>
            </figure>
            <?php } ?><?php } ?>
            </td>
                            <td >
                                                                    <a href="<?php echo osc_item_url(); ?>" >
                                        <span itemprop="name"><?php echo osc_highlight( strip_tags( osc_item_title() ), 77 ); ?></span></a><small> - <?php echo osc_format_date(osc_item_pub_date()); ?></small><div class="avail-color"><?php echo osc_highlight( strip_tags( osc_item_description() ), 333 ); ?></div>                            </td>
                                                                <td class="text-right gray col-xs-1" >
                                                                            </td>                                    <td class="text-right small-cart-wish nowrap col-xs-1">
                                        <meta itemprop="priceCurrency" content="ZAR" /><span itemprop="price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() )  echo osc_item_formated_price(); ?></span><div class="cart-wish">            
            </div>                                    </td>                        </tr> <?php } ?><?php } ?><!-- end -->
                                                
                                                                                                
                                                
                                        </table>
                <div class="text-right">
                <div class="pagination">
                            <?php echo osc_pagination_items(); ?>
                    </div>
        </div>
                <div class="news-text">
                                    </div>
            </article>
                            <div class="clearfix"></div>            </div>                          
            <!-- end page content -->
            
            <?php osc_current_web_theme_path('common/rtop-menu.php') ; ?>
                        
            <?php osc_current_web_theme_path('common/rfooter.php') ; ?>
            
            
            <div class="modal   fade" id="share-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="share-modal-title" align="center"><?php _e("Contact seller", 'wayst'); ?>: <i class="fa fa-user"></i> <?php echo osc_user_name(); ?></h4>
                        </div>
                                        <div class="modal-body" id="share-modal-body">
                <form action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" id="contact_form" class="form-horizontal">
                <input type="hidden" name="action" value="contact_post" />
                        <input type="hidden" name="page" value="user" />
                        <input type="hidden" name="id" value="<?php echo osc_user_id();?>" />
                        <?php osc_prepare_user_info(); ?>
                    
                            <div class="form-group ">
                                    <label for="RecipientName" class="col-sm-2 control-label"><?php _e('Message', 'wayst'); ?></label>
                            <div class="col-sm-10 " id="RecipientName-column">
                            <textarea id="message" name="message" rows="7" class="form-control" placeholder="" title="" data-orig="" onKeyUp="" onChange="" required="required"></textarea>
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="RecipientEmailAddress" class="col-sm-2 control-label"><?php _e('Your name', 'wayst'); ?></label>
                            <div class="col-sm-10 " id="RecipientEmailAddress-column">
                            <input id="yourName" type="text" name="yourName" value="" class="form-control" placeholder="" title="" data-orig="" onKeyUp="" onChange="" required="required" />
                            
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="ShareMessage" class="col-sm-2 control-label"><?php _e('Your e-mail address', 'wayst'); ?></label>
                            <div class="col-sm-10 " id="ShareMessage-column">
                            <input id="yourEmail" type="email" name="yourEmail" value="" class="form-control" placeholder="" title="" data-orig="" onKeyUp="" onChange="" required="required" />
                            
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="FromName" class="col-sm-2 control-label"><?php _e('Phone number', 'wayst'); ?> (<?php _e('optional', 'wayst'); ?>)</label>
                            <div class="col-sm-10 " id="FromName-column">
                            <input id="phoneNumber" type="text" name="phoneNumber" value="" class="form-control" placeholder="" title="" data-orig="" onKeyUp="" onChange="" />
                            
                                            </div>
                                    </div>
                                    
                                    <div class="form-group ">
                                    <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 " id="-column">
                            <div id="" class="form-control-static"><div id="g-recaptcha1" class="g-recaptcha1"><?php osc_show_recaptcha(); ?></div></div>
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="CustomerShare" class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 " id="CustomerShare-column">
                            <button type="submit" name="CustomerShare" id="customer-share-send1" class="btn btn-success" value="1" onClick=""><i class="fa fa-envelope"></i> <?php _e('Send', 'wayst'); ?> <?php _e('Email', 'wayst'); ?></button>
                                            </div>
                                    </div>
                </form>                    </div>
                    <div class="modal-footer">
                                                <button type="button" class="btn btn-close" data-dismiss="modal"><?php _e('Close', 'wayst'); ?></button>
                    </div>
                </div>
            </div>
        </div>
                    <script>
            function showReCaptcha() {
                grecaptcha.render('', {
                    'sitekey' : ''
                });
                $('#customer-share-send').prop('disabled', false);
            }

            $('#share-email, #share-email2').click(function() {
                $('#share-modal').modal('show');
                                    $('#customer-share-send').prop('disabled', true);
                    $('').html('');
                    $.getScript('');
                            });
        </script>
                <script>
            $(document).ready(function() {
                $('#fbshare').click(function(e) {
                    popupCenter($(this).attr('href'), 'Facebook', 550, 400);
                    e.preventDefault();
                });
                $('#tweet').click(function(e) {
                    popupCenter($(this).attr('href'), 'Twitter', 550, 520);
                    e.preventDefault();
                });
                $('#pinit').click(function(e) {
                    popupCenter($(this).attr('href'), 'Pinterest', 770, 535);
                    e.preventDefault();
                });
            });
        </script>
                <script>
            function sleep(milliseconds) {
                var start = new Date().getTime();
                for (var i = 0; i < 1e7; i++) {
                    if ((new Date().getTime() - start) > milliseconds){
                        break;
                    }
                }
            }

            $(document).ready(function() {
                $('audio').on('playing', function(e) {
                    $('audio').each(function() {
                        if (this != e.target) {
                            this.pause();
                            if (this.currentTime) this.currentTime = 0;
                        }
                    });
                });
                $('#play-all').click(function() {
                    var somePlaying = false;
                    $('audio')
                        .on('ended', function(e) {
                            sleep(500);
                            var track = $(e.target).attr('id').replace('audio','');
                            track++;
                            var next = $('#audio'+track);
                            if (next.length) {
                                next[0].play();
                            }
                        })
                        .each(function() {
                        if (!this.paused) {
                            this.pause();
                            somePlaying = true;
                        }
                    });
                    if (!somePlaying) {
                        $('#audio1')[0].play();
                    }
                });
            });
        </script>        

        
        </body></html>