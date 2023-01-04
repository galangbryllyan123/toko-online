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
    if( osc_item_is_spam() || osc_premium_is_spam() ) {
        osc_add_hook('header','udhauli_nofollow_construct');
    } else {
        osc_add_hook('header','udhauli_follow_construct');
    }

    osc_enqueue_script('fancybox');
    osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
    osc_enqueue_script('jquery-validate');

    udhauli_add_body_class('item');
    // osc_add_hook('after-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('item-sidebar.php');
    }

    $location = array();
    if( osc_item_city_area() !== '' ) {
        $location[] = osc_item_city_area();
    }
    if( osc_item_city() !== '' ) {
        $location[] = osc_item_city();
    }
    if( osc_item_region() !== '' ) {
        $location[] = osc_item_region();
    }
    if( osc_item_country() !== '' ) {
        $location[] = osc_item_country();
    }

    osc_current_web_theme_path('header.php');
?>
<div class="row">
  <div class="col-md-7 item-content-col">
  <div id="item-header">  
    <div class="row">
    <h1><?php echo osc_item_title() . ' ' . osc_item_city(); ?></h1><br>
    </div>
        <div class="item-header row">   
            <div class="col-sm-6">
            <div id="publish">
                <?php if ( osc_item_pub_date() !== '' ) { printf( __('<i class="fa fa-calendar-o"></i> <strong class="publish"></strong> %1$s', 'udhauli'), osc_format_date( osc_item_pub_date() ) ); } ?>
            </div>    
            </div>
            <?php if ( osc_item_mod_date() !== '' ) { ?>
                <div class="col-sm-6">
                    <div id="update">
                        <?php printf( __('<i class="fa fa-calendar"></i><strong class="update"></strong> %1$s', 'udhauli'), osc_format_date( osc_item_mod_date() ) );?>
                    </div>
                </div>
            <?php } ?>
            <?php if (count($location)>0) { ?>
            <div class="col-sm-6">
                <ul id="item_location">
                    <li><i class="fa fa-map-marker"></i><?php echo implode(', ', $location); ?></li>
                </ul>
            </div>    
            <?php }; ?>
            <div class="col-sm-6">
              <div id="price">
                 <i class="fa fa-money"></i><?php if( osc_price_enabled_at_items() ) { ?><?php echo osc_item_formated_price(); ?> <?php } ?>
              </div>
            </div>     
        </div>
  </div>
   <div id="item-content">      
        <?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) { ?>
            <p id="edit_item_view">
                <strong>
                    <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><?php _e('Edit item', 'udhauli'); ?></a>
                </strong>
            </p>
        <?php } ?>
    <?php if( osc_images_enabled_at_items() ) { ?>
        <?php
        if( osc_count_item_resources() > 0 ) {
            $i = 0;
        ?>    
        <div class="item-photos">
            <a href="<?php echo osc_resource_url(); ?>" class="main-photo" title="<?php _e('Image', 'udhauli'); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>">
                <img src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" />
            </a>
            <div class="thumbs">
                <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
                <a href="<?php echo osc_resource_url(); ?>" class="fancybox" data-fancybox-group="group" title="<?php _e('Image', 'udhauli'); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>">
                    <img src="<?php echo osc_resource_thumbnail_url(); ?>" width="75" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" />
                </a>
                <?php } ?>
            </div>
        </div>    
        <?php } ?>
    <?php } ?>
    <div id="description">
        <p><?php echo osc_item_description(); ?></p>
        <?php osc_run_hook('item_detail', osc_item() ); ?>
        <div class="contact_button">
           <a href="<?php echo osc_item_send_friend_url(); ?>" rel="nofollow" class="btn btn-md"><?php _e('Share', 'udhauli'); ?></a>
        </div>
        <?php osc_run_hook('location'); ?>
    </div>
    <!-- plugins -->

    <?php if( osc_comments_enabled() ) { ?>
        <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
        <div id="comments">
            <h2><?php _e('Comments', 'udhauli'); ?></h2><hr>
            <ul id="comment_error_list"></ul>
            <?php CommentForm::js_validation(); ?>
            <?php if( osc_count_item_comments() >= 1 ) { ?>
                <div class="comments_list">
                    <?php while ( osc_has_item_comments() ) { ?>
                        <div class="comment">
                            <h3><strong><?php echo osc_comment_title(); ?></strong> <em><?php _e("by", 'udhauli'); ?> <?php echo osc_comment_author_name(); ?>:</em></h3>
                            <p><?php echo nl2br( osc_comment_body() ); ?> </p>
                            <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
                            <p>
                                <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php _e('Delete your comment', 'udhauli'); ?>"><?php _e('Delete', 'udhauli'); ?></a>
                            </p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="paginate" style="text-align: right;">
                        <?php echo osc_comments_pagination(); ?>
                    </div>
                </div>
            <?php } ?>
            <div id="useful_info" class="bordered-box">
                 <h2><?php _e('Useful Information :', 'udhauli'); ?></h2>
                    <ul>
                       <li><?php _e('Avoid scams by acting locally or paying with PayPal', 'udhauli'); ?></li>
                       <li><?php _e('Never pay with Western Union, Moneygram or other anonymous payment services', 'udhauli'); ?></li>
                       <li><?php _e('Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country', 'udhauli'); ?></li>
                       <li><?php _e('This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer "buyer protection" or "seller certification"', 'udhauli'); ?></li>
                    </ul>
            </div>
            <div class="form-container form-horizontal">
                <div class="header">
                    <h3><?php _e('Leave your comment (spam and offensive messages will be removed)', 'udhauli'); ?></h3><hr>
                </div>
                <div class="resp-wrapper">
                    <form action="<?php echo osc_base_url(true); ?>" method="post" name="comment_form" id="comment_form">
                        <fieldset>

                            <input type="hidden" name="action" value="add_comment" />
                            <input type="hidden" name="page" value="item" />
                            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                            <?php if(osc_is_web_user_logged_in()) { ?>
                                <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
                                <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
                            <?php } else { ?>
                                <div class="control-group">
                                    <label class="control-label" for="authorName"><?php _e('Your name', 'udhauli'); ?></label>
                                    <div class="controls">
                                        <?php CommentForm::author_input_text(); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="authorEmail"><?php _e('Your e-mail', 'udhauli'); ?></label>
                                    <div class="controls">
                                        <?php CommentForm::email_input_text(); ?>
                                    </div>
                                </div>
                            <?php }; ?>
                            <div class="control-group">
                                <label class="control-label" for="title"><?php _e('Title', 'udhauli'); ?></label>
                                <div class="controls">
                                    <?php CommentForm::title_input_text(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="body"><?php _e('Comment', 'udhauli'); ?></label>
                                <div class="controls textarea">
                                    <?php CommentForm::body_input_textarea(); ?>
                                </div>
                            </div>
                           
                                <button type="submit" class="btn btn-md"><?php _e('Send', 'udhauli'); ?></button>
                        

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
     </div>   
  </div>      
        <?php } ?>
    <?php } ?>
     <div class="col-md-5" id="item-sidebar-col">
     <?php osc_current_web_theme_path('item-sidebar.php'); ?>
  </div>
</div>   
<div id="releated-search-list">
     <?php related_listings(); ?>
        <?php if( osc_count_items() > 0 ) { ?>
        <div class="similar_ads">
            <h2><?php _e('Related listings', 'udhauli'); ?></h2>
            <?php
            View::newInstance()->_exportVariableToView("listType", 'items');
            osc_current_web_theme_path('loop.php');
            ?>
            <div class="clear"></div>
        </div>
    <?php } ?>
</div>    
<?php osc_current_web_theme_path('footer.php') ; ?>
