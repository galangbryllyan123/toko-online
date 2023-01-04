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
    <div class="col-md-3" id="user-sidebar-col">
        <h1><?php _e('MENU', 'lhoshar') ; ?></h1>
            <div id="user-sidebar">
               <?php echo osc_private_user_menu( get_user_menu() ); ?>
            </div>            
               <div id="dialog-delete-account" title="<?php echo osc_esc_html(__('Delete account', 'lhoshar')); ?>">
                   <?php _e('Are you sure you want to delete your account?', 'lhoshar'); ?>
               </div><br>         
    </div>    