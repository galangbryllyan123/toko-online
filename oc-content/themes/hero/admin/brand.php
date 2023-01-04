<?php
    /*
     *       Hero Responsive Osclass Themes
     *       
     *       Copyright (C) 2017 OSCLASS.me
     * 
     *       This is Hero Osclass Themes with Single License
     *  
     *       This program is a commercial software. Copying or distribution without a license is not allowed.
     *         
     *       If you need more licenses for this software. Please read more here <http://www.osclass.me/osclass-me-license/>.
     */
?>
<?php
    if(Params::getParam("action_specific")!='') {
        switch(Params::getParam("action_specific")) {
            case('upload_brand1'):
                $package = Params::getFiles("brand1");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/brand/1.jpg" ) ){
                        osc_add_flash_ok_message(__('The image has been uploaded correctly','hero'), 'admin');
                    } else {
                        osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                }
            break;
            case('upload_brand2'):
                $package = Params::getFiles("brand2");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/brand/2.jpg" ) ){
                        osc_add_flash_ok_message(__('The image has been uploaded correctly','hero'), 'admin');
                    } else {
                        osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                }
            break;
                case('upload_brand3'):
                $package = Params::getFiles("brand3");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/brand/3.jpg" ) ){
                        osc_add_flash_ok_message(__('The image has been uploaded correctly','hero'), 'admin');
                    } else {
                        osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                }
            break;
                case('upload_brand4'):
                $package = Params::getFiles("brand4");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/brand/4.jpg" ) ){
                        osc_add_flash_ok_message(__('The image has been uploaded correctly','hero'), 'admin');
                    } else {
                        osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                }
            break;
                 case('upload_brand5'):
                $package = Params::getFiles("brand5");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/brand/5.jpg" ) ){
                        osc_add_flash_ok_message(__('The image has been uploaded correctly','hero'), 'admin');
                    } else {
                        osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                }
            break;
               case('upload_brand6'):
                $package = Params::getFiles("brand6");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/brand/6.jpg" ) ){
                        osc_add_flash_ok_message(__('The image has been uploaded correctly','hero'), 'admin');
                    } else {
                        osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                }
            break;
            case('upload_brand7'):
                $package = Params::getFiles("brand7");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/brand/7.jpg" ) ){
                        osc_add_flash_ok_message(__('The image has been uploaded correctly','hero'), 'admin');
                    } else {
                        osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                }
            break;
            case('upload_brand8'):
                $package = Params::getFiles("brand8");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/brand/8.jpg" ) ){
                        osc_add_flash_ok_message(__('The image has been uploaded correctly','hero'), 'admin');
                    } else {
                        osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__('An error has occurred, please try again','hero'), 'admin');
                }
            break;

          case('remove_brand1'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/1.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/1.jpg" );
                    osc_add_flash_ok_message(__('The image has been removed','hero'), 'admin');
                }else{
                    osc_add_flash_error_message(__('Image not found','hero'), 'admin');
                }
            break;
            case('remove_brand2'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/2.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/2.jpg" );
                    osc_add_flash_ok_message(__('The image has been removed','hero'), 'admin');
                }else{
                    osc_add_flash_error_message(__('Image not found','hero'), 'admin');
                }

            break;
                case('remove_brand3'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/3.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/3.jpg" );
                    osc_add_flash_ok_message(__('The image has been removed','hero'), 'admin');
                }else{
                    osc_add_flash_error_message(__('Image not found','hero'), 'admin');
                }

            break;
               case('remove_brand4'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/4.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/4.jpg" );
                    osc_add_flash_ok_message(__('The image has been removed','hero'), 'admin');
                }else{
                    osc_add_flash_error_message(__('Image not found','hero'), 'admin');
                }

            break;
                 case('remove_brand5'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/5.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/5.jpg" );
                    osc_add_flash_ok_message(__('The image has been removed','hero'), 'admin');
                }else{
                    osc_add_flash_error_message(__('Image not found','hero'), 'admin');
                }

            break;
            case('remove_brand6'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/6.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/6.jpg" );
                    osc_add_flash_ok_message(__('The image has been removed','hero'), 'admin');
                }else{
                    osc_add_flash_error_message(__('Image not found','hero'), 'admin');
                }

            break;
            case('remove_brand7'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/7.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/7.jpg" );
                    osc_add_flash_ok_message(__('The image has been removed','hero'), 'admin');
                }else{
                    osc_add_flash_error_message(__('Image not found','hero'), 'admin');
                }

            break;
            case('remove_brand8'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/8.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/8.jpg" );
                    osc_add_flash_ok_message(__('The image has been removed','hero'), 'admin');
                }else{
                    osc_add_flash_error_message(__('Image not found','hero'), 'admin');
                }

            break;
            
        }
    }
?>
<?php osc_show_flash_message('admin') ; ?>
<?php if(is_writable( WebThemes::newInstance()->getCurrentThemePath() ."images/brand/") )  { ?>

<h2 class="render-title"><?php _e("Brand Images", 'hero'); ?></h2>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Brand Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/1.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/brand/1.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_brand1" />
            <fieldset>
                <input id="button_remove" class="btn btn-red" type="submit" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_brand1" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Brand Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="brand1" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any image", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Brand Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/2.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/brand/2.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_brand2" />
            <fieldset>
                <input id="button_remove" class="btn btn-red" type="submit" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_brand2" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Brand Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="brand2" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any image", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Brand Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/3.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/brand/3.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_brand3" />
            <fieldset>
                <input id="button_remove" class="btn btn-red" type="submit" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_brand3" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Brand Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="brand3" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any image", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Brand Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/4.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/brand/4.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_brand4" />
            <fieldset>
                <input id="button_remove" class="btn btn-red" type="submit" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_brand4" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Brand Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="brand4" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any image", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Brand Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/5.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/brand/5.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_brand5" />
            <fieldset>
                <input id="button_remove" class="btn btn-red" type="submit" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_brand5" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Brand Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="brand5" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any image", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Brand Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/6.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/brand/6.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_brand6" />
            <fieldset>
                <input id="button_remove" class="btn btn-red" type="submit" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_brand6" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Brand Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="brand6" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any image", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Brand Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/7.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/brand/7.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_brand7" />
            <fieldset>
                <input id="button_remove" class="btn btn-red" type="submit" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_brand7" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Brand Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="brand7" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any image", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Brand Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/brand/8.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/brand/8.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_brand8" />
            <fieldset>
                <input id="button_remove" class="btn btn-red" type="submit" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#brand');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_brand8" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Brand Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="brand8" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any image", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div style="clear: both;"></div>

            <?php } else { ?>

            <div id="flash_message">
                <p>
                    <?php
                        $msg  = sprintf(__('The images folder %s is not writable on your server','hero'), WebThemes::newInstance()->getCurrentThemePath() ."images/" ) .", ";
                        $msg .= __('Osclass can\'t upload brand image from the administration panel','hero') . '. ';
                        $msg .= __('Please make the mentioned images folder writable','hero') . '.';
                        echo $msg;
                    ?>
                </p>
                <p>
                    <?php _e("To make a directory writable under UNIX execute this command from the shell",'hero'); ?>:
                </p>
                <p class="deanda">
                    chmod a+w <?php echo WebThemes::newInstance()->getCurrentThemePath() ."images/" ; ?>
                </p>
            </div>

            <?php } ?>