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

    wayst_add_body_class('contact');
    osc_enqueue_script('jquery-validate');
    osc_current_web_theme_path('header.php');
?>
<body class="wayst">
            <?php osc_current_web_theme_path('common/rtop-menu2.php') ; ?>
            
            <div align="center"><?php osc_show_widgets('header'); ?></div>
            <!-- initiate page content -->
            <div class="container page-content contact">
                                                                        <h1><?php _e('Contact us', 'wayst'); ?></h1>
                                                                        <p><?php echo osc_get_preference('contact-text', 'wayst'); ?></p>
          <div id="facebook_user_info"></div>
          <?php if( osc_get_preference('facebook-top', 'wayst') != '') {?><a target='_blank' href="<?php echo osc_get_preference('facebook-top', 'wayst'); ?>"><i class="fa fa-facebook-official fa-3x" aria-hidden="true"></i></a> &nbsp;
                    <?php } else { ?><i class="fa fa-facebook-official fa-3x" aria-hidden="true"></i> &nbsp; <?php } ?> 
                    <?php if( osc_get_preference('twitter-top', 'wayst') != '') {?><a target='_blank' href="<?php echo osc_get_preference('twitter-top', 'wayst'); ?>"> <i class="fa fa-twitter fa-3x" aria-hidden="true"></i></a> &nbsp; <?php } else { ?> <i class="fa fa-twitter fa-3x" aria-hidden="true"></i> &nbsp; <?php } ?>  
                     <?php if( osc_get_preference('google-plus-top', 'wayst') != '') {?><a target='_blank' href="<?php echo osc_get_preference('google-plus-top', 'wayst'); ?>"><i class="fa fa-google-plus fa-3x" aria-hidden="true"></i></a> &nbsp; <?php } else { ?> <i class="fa fa-google-plus fa-3x" aria-hidden="true"></i> &nbsp; <?php } ?>
                      
                    <?php if( osc_get_preference('skype-top', 'wayst') != '') {?> <a target='_blank' href="skype:<?php echo osc_get_preference('skype-top', 'wayst'); ?>"> <i class="fa fa-skype fa-3x" aria-hidden="true"></i></a> &nbsp; <?php } else { ?>  <i class="fa fa-skype fa-3x" aria-hidden="true"></i> &nbsp; <?php } ?> 
                     <?php if( osc_get_preference('email-top', 'wayst') != '') {?> <a target='_blank' href="mailto:<?php echo osc_get_preference('email-top', 'wayst'); ?>"> <i class="fa fa-envelope-o fa-3x" aria-hidden="true"></i></a> &nbsp; <?php } else { ?> <i class="fa fa-envelope-o fa-3x" aria-hidden="true"></i> <?php } ?>
                    
        <h1></h1>
        <form class="form-horizontal" name="contact_form" action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="contact" />
            <input type="hidden" name="action" value="contact_post" />

                <div class="form-group">
                    <label for="Customer" class="col-sm-2"><?php _e('Your name', 'wayst'); ?>
                    (<?php _e('optional', 'wayst'); ?>)</label>
                    <div class="col-sm-10">
                    <input class="form-control" id="yourName" type="text" name="yourName" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="Email" class="col-sm-2"><?php _e('Your email address', 'wayst'); ?></label>
                    <div class="col-sm-10">
                    <input class="form-control" id="yourEmail" type="text" name="yourEmail" value="" required="required" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="Reason" class="col-sm-2"><?php _e('Subject', 'wayst'); ?>
                    (<?php _e('optional', 'wayst'); ?>)</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="subject" type="text" name="subject" value="" />
                    </div>
                </div>
                                    <div class="form-group">
                        <label for="Message" class="col-sm-2"><?php _e('Message', 'wayst'); ?></label>
                        <div class="col-sm-10">
                           <textarea class="form-control" id="message" name="message" rows="8" required="required"></textarea>
                        </div>
                    </div>
                                    <div class="form-group">
                    <label for="Message" class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <?php osc_run_hook('contact_form'); ?>
                    <?php osc_show_recaptcha(); ?>
                    </div>
                </div>
                <div class="col-sm-offset-2">
                    <button type="submit" name="customermsg" value="1" class="btn btn-lg btn-save"><i class="fa fa-envelope"></i> <?php _e("Send", 'wayst'); ?></button>
                </div>
            </form>
                            <div class="clearfix"></div>            </div>                           
            <!-- end page content -->
            
            <?php osc_current_web_theme_path('common/rtop-menu.php') ; ?>
                        
            <?php osc_current_web_theme_path('common/rfooter.php') ; ?>
                            

        
        </body></html>