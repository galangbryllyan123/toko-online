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
<h2 class="render-title"><?php _e('Image', 'wayst'); ?></h2><br />
<?php
    $logo_prefence = osc_get_preference('homeimage', 'wayst');
?>
<?php if( is_writable( osc_uploads_path()) ) { ?>
    <?php if($logo_prefence) { ?>
        <h3 class="render-title"><?php _e('Preview', 'wayst') ?></h3>
         <?php if( is_writable( WebThemes::newInstance()->getCurrentThemePath() . "images/") ) { ?>
    <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/homeimage1.jpg" ) ) { ?>
        <a href="<?php echo osc_get_preference('hbanner-link1', 'wayst'); ?>"><img style="max-width:100%;" height="224" class="img-responsive" border="0" src="<?php echo osc_current_web_theme_url('images/homeimage1.jpg');?>" /></a>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php');?>" method="post" enctype="multipart/form-data" class="nocsrf">
       
            <input type="hidden" name="action_specific" value="remove_homeimage" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-actions">
                        <input id="button_remove" type="submit" value="<?php echo osc_esc_html(__('Remove image','wayst')); ?>" class="btn btn-red">
                    </div>
                </div>
            </fieldset>
        </form>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php');?>" method="post" enctype="multipart/form-data" class="nocsrf">
            <input type="hidden" name="action_specific1" value="settings1" />
        <div class="form-actions">
         <div class="form-row">
                <div class="form-label"><?php _e('Link (optional)', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="hbanner-link1" value="<?php echo osc_esc_html( osc_get_preference('hbanner-link1', 'wayst') ); ?>" > Example: http://www.yourwebsite.com/link-name/<br />
<br />
                </div>
            </div>
                <input type="submit" value="<?php echo osc_esc_html(__('Save changes', 'wayst')); ?>" class="btn btn-submit">
            </div>
        </form>
        <?php } ?><?php } ?>
    <?php } else { ?>
        <div class="flashmessage flashmessage-warning flashmessage-inline" style="display: block;">
            <p><?php _e('No image has been uploaded yet', 'wayst'); ?></p>
        </div>
    <?php } ?>
    <h2 class="render-title separate-top"><?php _e('Upload image', 'wayst') ?></h2>
    <?php if( $logo_prefence ) { ?>
    <div class="flashmessage flashmessage-inline flashmessage-warning"><p><?php _e('<strong>Note:</strong> Uploading another image will overwrite the current image.', 'wayst'); ?></p></div>
    <?php } ?>
    <br/><br/>
    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'); ?>" method="post" enctype="multipart/form-data" class="nocsrf">
        <input type="hidden" name="action_specific" value="upload_homeimage" />
        <fieldset>
            <div class="form-horizontal">
                <div class="form-row">
                    <div class="form-label"><?php _e('Accepted image (png,gif,jpg)','wayst'); ?></div>
                    <div class="form-controls">
                        <input type="file" name="homeimage" id="package" />
                    </div>
                </div>
                <div class="form-actions">
                    <input id="button_save" type="submit" value="<?php echo osc_esc_html(__('Upload','wayst')); ?>" class="btn btn-submit">
                </div>
            </div>
        </fieldset>
    </form>
<?php } else { ?>
    <div class="flashmessage flashmessage-error" style="display: block;">
        <p>
            <?php
                $msg  = sprintf(__('The images folder <strong>%s</strong> is not writable on your server', 'wayst'), WebThemes::newInstance()->getCurrentThemePath() ."images/" ) .", ";
                $msg .= __("Osclass can't upload the image from the administration panel.", 'wayst') . ' ';
                $msg .= __('Please make the aforementioned image folder writable.', 'wayst') . ' ';
                echo $msg;
            ?>
        </p>
        <p>
            <?php _e('To make a directory writable under UNIX execute this command from the shell:','wayst'); ?>
        </p>
        <p class="command">
            chmod a+w <?php echo WebThemes::newInstance()->getCurrentThemePath() ."images/"; ?>
        </p>
    </div>
<?php } ?>
