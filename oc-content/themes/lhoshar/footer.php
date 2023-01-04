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
</div><!-- content -->
</div><!-- container -->
</div>
<?php osc_run_hook('after-main'); ?>
</div>

<div id="responsive-trigger"></div>
<!-- footer -->
<div class="clear"></div>
<?php osc_show_widgets('footer');?>
<div id="footer">
     <div class="container">  
      <div class="row" id="footer-row">
       <div class="col-sm-5 col-sm-offset-1">
        <ul class="resp-toggle">
            <?php if( osc_users_enabled() ) { ?>
            <?php if( osc_is_web_user_logged_in() ) { ?>
                <li>
                    <a href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My account', 'lhoshar'); ?></a><br>
                    <a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'lhoshar'); ?></a><br><br>
                </li>
            <?php } else { ?>
                <li><a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'lhoshar'); ?></a></li><br>
                <?php if(osc_user_registration_enabled()) { ?>
                    <li>
                        <a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register for a free account', 'lhoshar'); ?></a>
                    </li><br>
                <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
            <li class="publish">
                <a href="<?php echo osc_item_post_url_in_category(); ?>"><?php _e("Publish your ad for free", 'lhoshar');?></a>
            </li><br>
            <?php } ?>
        </ul>
       </div>
       <div class="col-sm-4 col-sm-offset-1"> 
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
                <a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'lhoshar'); ?></a>
            </li>
        </ul>
       </div> 
   </div><hr>
       <div class="row socialmedia-footer" style="text-align: center;">
            <h3><?php _e('Follow us', 'lhoshar') ; ?></h3> 
            <div class="socialmedia">
                <?php $social = unserialize ( osc_get_preference ( 'social', 'lhoshar' ) ) ; ?>
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
        <div class="footer-msg">
            <?php
                if(lhoshar_footer_msg()){
                    echo '</br>'.lhoshar_footer_msg();
                }
            ?>
        </div>
    </div>
  </div>
</div>
<div id="last-footer">
   <div class="container"> 
      <h5><?php
            echo '<div class="copyright">' . sprintf(__('Free responsive Osclass theme by <a target="_blank" title="osclasswizards" href="%s">OsclassWizards</a>','lhoshar'), 'http://www.osclasswizards.com/') . '</div>';
      ?></h5> 
</div>
</div> 
   
<?php if ( osc_get_preference('to_the_top', 'lhoshar') == 1 ) { ?>
    <button id="myBtn" title="Go to top" style="display: block;"><span class="glyphicon glyphicon-chevron-up"></span></button>
<?php } ?>

<?php osc_run_hook('footer'); ?>
</body></html>
