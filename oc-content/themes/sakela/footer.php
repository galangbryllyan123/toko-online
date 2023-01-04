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
</div>
</div>
</div><!-- content -->
<?php osc_run_hook('after-main'); ?>
</div>
<div id="responsive-trigger"></div>
<!-- footer -->
<div class="clear"></div>
<?php osc_show_widgets('footer');?>
<div id="footer">
     <div class="container">  
      <div class="row" id="footer-row">
       <div class="col-xs-3">
        <ul class="resp-toggle">
            <?php if( osc_users_enabled() ) { ?>
            <?php if( osc_is_web_user_logged_in() ) { ?>
                <li>
                    <strong><a href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My account', 'sakela'); ?></a></strong><br><br>
                    <a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'sakela'); ?></a><br><br>
                </li>
            <?php } else { ?>
                <li><a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'sakela'); ?></a></li><br>
                <?php if(osc_user_registration_enabled()) { ?>
                    <li>
                        <a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register for a free account', 'sakela'); ?></a>
                    </li><br>
                <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
            <li class="publish">
                <a href="<?php echo osc_item_post_url_in_category(); ?>"><?php _e("Publish your ad for free", 'sakela');?></a>
            </li><br>
            <?php } ?>
        </ul>
       </div>
       <div class="col-xs-3"> 
        <ul>
        <?php
        osc_reset_static_pages();
        while( osc_has_static_pages() ) { ?>
            <li>
                <a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a>
            </li><br>
        <?php
        }
        ?>
            <li>
                <a href="<?php echo osc_contact_url(); ?>"><?php _e('CONTACT', 'sakela'); ?></a>
            </li>
        </ul>
       </div> 
       <div class="col-xs-6">
            <h3><?php _e('Follow us', 'sakela') ; ?></h3> 
            <div class="socialmedia">
                <?php $social = unserialize ( osc_get_preference ( 'social', 'sakela' ) ) ; ?>
                <?php if(osc_esc_html($social['facebook'])){?>
                    <a href="<?php echo osc_esc_html($social['facebook'])?:'#'?>" target = "_blank" ><i class="fa fa-facebook"></i></a>
                <?php }?>
                <?php if(osc_esc_html($social['twitter'])){?>
                    <a href="<?php echo osc_esc_html($social['twitter'])?:'#'?>" target = "_blank" ><i class="fa fa-twitter"></i></a>
                <?php }?>
                <?php if(osc_esc_html($social['linkedin'])){?>
                    <a href="<?php echo osc_esc_html($social['linkedin'])?:'#'?>" target = "_blank" ><i class="fa fa-linkedin"></i></a>
                <?php }?>
                <?php if(osc_esc_html($social['google'])){?>
                    <a href="<?php echo osc_esc_html($social['google'])?:'#'?>" target = "_blank" ><i class="fa fa-google-plus"></i></a>
                <?php }?>
                <?php if(osc_esc_html($social['instagram'])){?>
                    <a href="<?php echo osc_esc_html($social['instagram'])?:'#'?>" target = "_blank" ><i class="fa fa-instagram"></i></a>
                <?php }?>
                <?php if(osc_esc_html($social['youtube'])){?>
                    <a href="<?php echo osc_esc_html($social['youtube'])?:'#'?>" target = "_blank" ><i class="fa fa-youtube" aria-hidden="true"></i></a>
                <?php }?>
            </div>     
        </div>
    </div>
    <div class="row" id="language-row">
        <?php if ( osc_count_web_enabled_locales() > 1) { ?>
            <?php osc_goto_first_locale(); ?>
            <strong><?php _e('Language:', 'sakela'); ?></strong>
            <?php $i = 0;  ?>
            <?php while ( osc_has_web_enabled_locales() ) { ?>
            <span><a id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a></span><?php if( $i == 0 ) { echo ""; } ?>
                <?php $i++; ?>
            <?php } ?>
        <?php } ?> 
    </div>  
    <h5><?php
            echo '<div class="copyright">' . sprintf(__('Free responsive Osclass theme by <a target="_blank" title="osclasswizards" href="%s">OsclassWizards</a>','sakela'), 'http://www.osclasswizards.com/') . '</div>';
        ?></h5> 
</div>
<?php osc_run_hook('footer'); ?>
</div>
</body></html>
