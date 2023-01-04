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
    osc_add_hook('header','udhauli_nofollow_construct');

    udhauli_add_body_class('user user-profile');
    
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Change password', 'udhauli');;
    }
    osc_current_web_theme_path('header.php') ;
    $osc_user = osc_user();
?>
<div class="row" id="form-row">
    <?php osc_current_web_theme_path('user-sidebar.php');?>
   <div class="col-md-9 item-post" id="form-login">
   <div class="form-row-header"> 
       <h1 id="form-row-h1"><?php _e('Change password', 'udhauli'); ?></h1> 
   </div>    
    <div class="form-login col-md-offset-2 col-md-offset-right-2">
        <ul id="error_list"></ul>
        <form action="<?php echo osc_base_url(true); ?>" method="post">
            <input type="hidden" name="page" value="user" />
            <input type="hidden" name="action" value="change_password_post" />
            <div class="control-group">
                <label class="control-label" for="password"><?php _e('Current password', 'udhauli'); ?> *</label>
                <div class="controls">
                    <input type="password" name="password" id="password" value="" autocomplete="off" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="new_password"><?php _e('New password', 'udhauli'); ?> *</label>
                <div class="controls">
                    <input type="password" name="new_password" id="new_password" value="" autocomplete="off" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="new_password2"><?php _e('Repeat new password', 'udhauli'); ?> *</label>
                <div class="controls">
                    <input type="password" name="new_password2" id="new_password2" value="" autocomplete="off" />
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-md"><?php _e("Update", 'udhauli');?></button>
                </div>
            </div>
        </form><br><br>
    </div>
  </div>  
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>