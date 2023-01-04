<div class="wrapper wrapper-flash"><?php osc_show_flash_message(); ?></div>
<nav class="navbar-collapse1 collapse" id="frontmenu-collapse">            <nav class="navbar navbar-frontmenu">
                <ul class="nav navbar-nav">
                            <li class="child-2"><a href="<?php echo osc_base_url(); ?>"><i class="fa fa-home fa-fw" aria-hidden="true"></i></a></li>
                <li class="child-5"><a href="<?php echo osc_item_post_url(); ?>"><i class="fa fa-pencil" aria-hidden="true"></i> <?php _e("Publish a listing", 'wayst'); ?></a></li>
                
                <?php if( osc_users_enabled() ) { ?>
            <?php if( osc_is_web_user_logged_in() ) { ?>
            <li class="child-1"><a href="<?php echo osc_user_profile_url(); ?>"><i class="fa fa-user" aria-hidden="true"></i> <?php echo sprintf(__('Hi %s', 'wayst'), osc_logged_user_name() . '!'); ?></a></li>
            <?php } else { ?>
            
            <li class="child-1"><a href="<?php echo osc_user_login_url(); ?>"><i class="fa fa-user" aria-hidden="true"></i> <?php _e('Login', 'wayst') ; ?> <?php if(osc_user_registration_enabled()) { ?>/ <?php _e('Create', 'wayst'); ?> <?php }; ?></a></li>
            
                
                
            <?php } ?>
            <?php } ?> 
            <li class="child-4"><a href="<?php echo osc_contact_url(); ?>"><i class="fa fa-envelope" aria-hidden="true"></i> <?php _e('Contact us', 'wayst'); ?></a></li>
            
            <?php if ( osc_count_web_enabled_locales() > 1) { ?>
            <li role="presentation" class="dropdown child-2"><a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> <?php if ( osc_count_web_enabled_locales() > 1) { ?>
            <?php osc_goto_first_locale(); ?> <i class="fa fa-flag fa-fw" aria-hidden="true"></i> <?php _e('Language:', 'wayst'); ?> <span class="caret"></span></a> <ul style="background-color:#0081BF" class="dropdown-menu" role="menu" ><?php while ( osc_has_web_enabled_locales() ) { ?>
                    <a  style="display:block" id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a> <?php } ?>
                </ul>  <?php } ?> </li>  <?php } else { ?> 
                
                <li role="presentation" class="dropdown child-2"><a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-flag fa-fw" aria-hidden="true"></i> <?php _e('Language:', 'wayst'); ?> <span class="caret"></span></a> <ul style="background-color:#0081BF" class="dropdown-menu" role="menu" >
                    <a  style="display:block" id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a> 
                </ul>  </li>
                
                 <?php } ?>
                
                
                <li class="child-3"><a href="javascript:;" data-toggle="modal" data-target="#myModalhelp" ><i class="fa fa-question-circle" aria-hidden="true"></i>  <?php _e('Help', 'wayst'); ?></a></li>       
            
                        </ul>
            </nav>
            
            <?php if (osc_is_home_page()) { ?><?php } else { ?> 
            
            
                        <?php
    osc_get_premiums(10);
    if(osc_count_premiums() > 0) {
?>
                
                <nav class="frontmenu-secondary hidden-sm hidden-xs">
                <ul>
                    <li>
                                                <a href="javascript:;" class="dept" title="<?php echo osc_esc_html(__('Premium listings', 'wayst')); ?>"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?php _e('Premium', 'wayst'); ?></a>
                                            </li>
                                            <?php while(osc_has_premiums()) { ?>
                            <li><a href="<?php echo osc_premium_url(); ?>" title="<?php echo osc_highlight( strip_tags( osc_esc_html(osc_premium_title()) ), 50 ); ?>" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="bottom" data-content="&lt;div class=&quot;text-center&quot;&gt;<?php if( osc_images_enabled_at_items() ) { ?><?php if(osc_count_premium_resources()) { ?>&lt;img src=&quot;<?php echo osc_resource_url(); ?>&quot; alt=&quot;<?php echo osc_esc_html(osc_item_title()); ?>&quot; class=&quot;image-s&quot; itemprop=&quot;image&quot;&gt; <?php } else { ?> &lt;img src=&quot;<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>&quot; alt=&quot;<?php echo osc_esc_html(osc_item_title()); ?>&quot; class=&quot;image-s&quot; itemprop=&quot;image&quot;&gt; <?php } ?> <?php } ?> &lt;div class=&quot;avail-color&quot;&gt;<?php echo osc_format_date(osc_premium_pub_date()); ?>&lt;/div&gt;&lt;div class=&quot;price&quot;&gt;<?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) { echo osc_premium_formated_price() ; } ?>&lt;/div&gt;&lt;/div&gt;"><?php echo osc_highlight( strip_tags( osc_premium_title() ), 15 ); ?></a></li><?php } ?>
                
                        </ul>
            </nav>
            
            <?php } else { ?> 
			<?php $random = ''; 
            $random = rand(0, 5); //more info about the rand function can be found at the link below. ?>
	<?php osc_query_item(array(
    "category_name" => "",
	"results_per_page" => "10",
	"offset" => $random
    
));
if( osc_count_custom_items() == 0) { ?>
    
<?php } else { ?>
    <nav class="frontmenu-secondary hidden-sm hidden-xs">
                <ul>
                    <li>
                                                <a href="javascript:;" class="dept" title="Random <?php _e('Listings', 'wayst'); ?>"><i class="fa fa-random" aria-hidden="true"></i> <?php _e('Listings', 'wayst'); ?></a>
                                            </li>
                                            <?php while(osc_has_custom_items()) { ?>
                            <li><a href="<?php echo osc_item_url(); ?>" title="<?php echo osc_highlight( strip_tags( osc_esc_html(osc_item_title()) ), 50 ); ?>" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="bottom" data-content="&lt;div class=&quot;text-center&quot;&gt;<?php if( osc_images_enabled_at_items() ) { ?><?php if(osc_count_item_resources()) { ?>&lt;img src=&quot;<?php echo osc_resource_url(); ?>&quot; alt=&quot;<?php echo osc_esc_html(osc_item_title()); ?>&quot; class=&quot;image-s&quot; itemprop=&quot;image&quot;&gt; <?php } else { ?> &lt;img src=&quot;<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>&quot; alt=&quot;<?php echo osc_esc_html(osc_item_title()); ?>&quot; class=&quot;image-s&quot; itemprop=&quot;image&quot;&gt; <?php } ?> <?php } ?> &lt;div class=&quot;avail-color&quot;&gt;<?php echo osc_format_date(osc_item_pub_date()); ?>&lt;/div&gt;&lt;div class=&quot;price&quot;&gt;<?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_item_category_id()) ) { echo osc_item_formated_price() ; } ?>&lt;/div&gt;&lt;/div&gt;"><?php echo osc_highlight( strip_tags( osc_esc_html(osc_item_title()) ), 15 ); ?></a></li><?php } ?>
                
                        </ul>
            </nav>
    <?php } ?> <?php } ?> <?php } ?>
            
            
            </nav>            <button type="button" class="frontmenu-toggle" data-toggle="collapse" data-target="#frontmenu-collapse">
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="modal fade" id="myModalhelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabelhelp">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" align="center"><i class="fa fa-question-circle" aria-hidden="true"></i> <?php _e('Help', 'wayst'); ?> - <?php _e('Useful information', 'wayst'); ?></h4>
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