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

<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<style type="text/css" media="screen">
    .command { background-color: white; color: #2E2E2E; border: 1px solid black; padding: 8px; }
    .theme-files { min-width: 500px; }
</style>
<h2 class="render-title"><?php _e('Favicon Image', 'wayst'); ?></h2>
<p><?php _e('The preferred size of the favicon is 16x16 pixels.', 'wayst'); ?>. <br />Accepted format: .ico, .png, .jpg, .gif</p>
       <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php');?>" method="post" enctype="multipart/form-data" class="nocsrf">
            <input type="hidden" name="action_specific7" value="settings7" />
        <div class="form-actions">
         <div class="form-row">
                <div class="form-label"><?php _e('Favicon link', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="favicon2" value="<?php echo osc_esc_html( osc_get_preference('favicon2', 'wayst') ); ?>" > Example: http://www.yourwebsite.com/oc-content/themes/wayst/images/favicon.ico<br />
<br />
                </div>
            </div>
                <input type="submit" value="<?php echo osc_esc_html(__('Save changes','wayst')); ?>" class="btn btn-submit">
            </div>
        </form>
