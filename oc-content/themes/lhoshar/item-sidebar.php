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
 <div id="item-sidebar-item">  
  <div id="sidebars-sidebar">  
    <?php if(!osc_is_web_user_logged_in() || osc_logged_user_id()!=osc_item_user_id()) { ?>
        <form action="<?php echo osc_base_url(true); ?>" method="post" name="mask_as_form" id="mask_as_form">
            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
            <input type="hidden" name="as" value="spam" />
            <input type="hidden" name="action" value="mark" />
            <input type="hidden" name="page" value="item" />
            <select name="as" id="as" class="mark_as">
                    <option><?php _e("Mark as...", 'lhoshar'); ?></option>
                    <option value="spam"><?php _e("Mark as spam", 'lhoshar'); ?></option>
                    <option value="badcat"><?php _e("Mark as misclassified", 'lhoshar'); ?></option>
                    <option value="repeated"><?php _e("Mark as duplicated", 'lhoshar'); ?></option>
                    <option value="expired"><?php _e("Mark as expired", 'lhoshar'); ?></option>
                    <option value="offensive"><?php _e("Mark as offensive", 'lhoshar'); ?></option>
            </select>
        </form>
    <?php } ?>

    <div id="contact" class="widget-box form-container form-vertical">
        <h2><?php _e("Contact publisher", 'lhoshar'); ?></h2>
        <?php if( osc_item_is_expired () ) { ?>
            <p>
                <?php _e("The listing is expired. You can't contact the publisher.", 'lhoshar'); ?>
            </p>
        <?php } else if( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) { ?>
            <p>
                <?php _e("It's your own listing, you can't contact the publisher.", 'lhoshar'); ?>
            </p>
        <?php } else if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?>
            <p>
                <?php _e("You must log in or register a new account in order to contact the advertiser", 'lhoshar'); ?>
            </p>
            <p class="contact_button">
                <strong><a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'lhoshar'); ?></a></strong>
                <strong><a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register for a free account', 'lhoshar'); ?></a></strong>
            </p>
        <?php } else { ?>
            <?php if( osc_item_user_id() != null ) { ?>
                <p class="name"><?php _e('Name', 'lhoshar') ?>: <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>" ><?php echo osc_item_contact_name(); ?></a></p>
            <?php } else { ?>
                <p class="name"><i class="fa fa-user" aria-hidden="true"></i><?php printf(__(' %s', 'lhoshar'), osc_item_contact_name()); ?></p>
            <?php } ?>
            <?php if( osc_item_show_email() ) { ?>
                <p class="email"><i class="fa fa-envelope-o" aria-hidden="true"></i><?php printf(__(' %s', 'lhoshar'), osc_item_contact_email()); ?></p>
            <?php } ?>
            <?php if ( osc_user_phone() != '' ) { ?>
                <p class="phone"><i class="fa fa-phone" aria-hidden="true"></i><?php printf(__(" %s", 'lhoshar'), osc_user_phone()); ?></p>
            <?php } ?>
            <div id="custom_fields">
            <?php if( osc_count_item_meta() >= 1 ) { ?>
                <div class="meta_list">
                    <?php while ( osc_has_item_meta() ) { ?>
                        <?php if(osc_item_meta_value()!='') { ?>
                            <div class="meta">
                                <i class="fa fa-phone" aria-hidden="true"></i><strong><?php echo osc_item_meta_name(); ?>:</strong><?php echo osc_item_meta_value(); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#contact-publisher"><?php _e('Send message', 'lhoshar') ; ?></button>
        <div class="modal fade" id="contact-publisher" role="dialog">
           <div class="modal-dialog">

               <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php _e('Contact Publisher', 'lhoshar') ; ?></h4>  
                  </div>

                  <div class="modal-body">
                     <form action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" id="contact_form" <?php if(osc_item_attachment()) { echo 'enctype="multipart/form-data"'; };?> >
                       <?php osc_prepare_user_info(); ?>
                       <ul id="error_list"></ul>
                       <input type="hidden" name="action" value="contact_post" />
                          <input type="hidden" name="page" value="item" />
                          <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                      <div class="control-group">
                          <label class="control-label" for="yourName"><?php _e('Your name', 'lhoshar'); ?>:</label>
                          <div class="controls"><?php ContactForm::your_name(); ?></div>
                      </div>
                      <div class="control-group">
                          <label class="control-label" for="yourEmail"><?php _e('Your e-mail address', 'lhoshar'); ?>:</label>
                          <div class="controls"><?php ContactForm::your_email(); ?></div>
                      </div>
                      <div class="control-group">
                          <label class="control-label" for="phoneNumber"><?php _e('Phone number', 'lhoshar'); ?> (<?php _e('optional', 'lhoshar'); ?>):</label>
                          <div class="controls"><?php ContactForm::your_phone_number(); ?></div>
                      </div>

                      <div class="control-group">
                          <label class="control-label" for="message"><?php _e('Message', 'lhoshar'); ?>:</label>
                          <div class="controls textarea"><?php ContactForm::your_message(); ?></div>
                      </div>

                      <?php if(osc_item_attachment()) { ?>
                          <div class="control-group">
                              <label class="control-label" for="attachment"><?php _e('Attachment', 'lhoshar'); ?>:</label>
                              <div class="controls"><?php ContactForm::your_attachment(); ?></div>
                          </div>
                      <?php }; ?>
  
                      <div class="control-group">
                          <div class="controls">
                              <?php osc_run_hook('item_contact_form', osc_item_id()); ?>
                              <?php if( osc_recaptcha_public_key() ) { ?>
                              <script type="text/javascript">
                                  var RecaptchaOptions = {
                                      theme : 'custom',
                                      custom_theme_widget: 'recaptcha_widget'
                                  };
                              </script>
                              <style type="text/css">
                                div#recaptcha_widget, div#recaptcha_image > img { width:240px; margin-top: 5px; }
                                div#recaptcha_image { margin-bottom: 15px; }
                              </style>
                                <div id="recaptcha_widget">
                                <div id="recaptcha_image"><img /></div>
                                  <span class="recaptcha_only_if_image"><?php _e('Enter the words above','lhoshar'); ?>:</span>
                                  <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                                  <div><a href="javascript:Recaptcha.showhelp()"><?php _e('Help', 'lhoshar'); ?></a></div>
                                </div>
                              <?php } ?>
                              <?php osc_show_recaptcha(); ?>
                              <button type="submit" class="btn btn-md btn-info"><?php _e("Send", 'lhoshar');?></button>
                          </div>
                      </div>
                  </form>
                </div>
            </div>  
        </div>
    </div>
            <?php ContactForm::js_validation(); ?>
        <?php } ?>
    </div> 
 </div>    
</div><!-- /sidebar -->
<?php if( osc_get_preference('sidebar-300x250', 'lhoshar') != '') {?>
    <!-- sidebar ad 350x250 -->
  </br></br>
    <div class="ads_header ads-headers">
        <?php echo osc_get_preference('sidebar-300x250', 'lhoshar'); ?>
    </div>
    <!-- /sidebar ad 350x250 -->
    <?php } ?>
