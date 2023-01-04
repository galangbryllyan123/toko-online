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
            case('upload_slider1'):
                $package = Params::getFiles("slider1");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider11.jpg" ) ){
                        osc_add_flash_ok_message(__("The image has been uploaded correctly","hero"), 'admin');
                    } else {
                        osc_add_flash_error_message(__("An error has occurred, please try again","hero"), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again","hero"), 'admin');
                }
            break;
            case('upload_slider2'):
                $package = Params::getFiles("slider2");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider22.jpg" ) ){
                        osc_add_flash_ok_message(__("The image has been uploaded correctly","hero"), 'admin');
                    } else {
                        osc_add_flash_error_message(__("An error has occurred, please try again","hero"), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again","hero"), 'admin');
                }
            break;
                case('upload_slider3'):
                $package = Params::getFiles("slider3");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider33.jpg" ) ){
                        osc_add_flash_ok_message(__("The image has been uploaded correctly","hero"), 'admin');
                    } else {
                        osc_add_flash_error_message(__("An error has occurred, please try again","hero"), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again","hero"), 'admin');
                }
            break;
                case('upload_slider4'):
                $package = Params::getFiles("slider4");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider44.jpg" ) ){
                        osc_add_flash_ok_message(__("The image has been uploaded correctly","hero"), 'admin');
                    } else {
                        osc_add_flash_error_message(__("An error has occurred, please try again","hero"), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again","hero"), 'admin');
                }
            break;
                 case('upload_slider5'):
                $package = Params::getFiles("slider5");

                if ($package['error'] == UPLOAD_ERR_OK) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/payment.png" ) ){
                        osc_add_flash_ok_message(__("The image has been uploaded correctly","hero"), 'admin');
                    } else {
                        osc_add_flash_error_message(__("An error has occurred, please try again","hero"), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again","hero"), 'admin');
                }
            break;

          case('remove_slider1'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider11.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider11.jpg" );
                    osc_add_flash_ok_message(__("The image has been removed","hero"), 'admin');
                }else{
                    osc_add_flash_error_message(__("Image not found","hero"), 'admin');
                }
            break;
            case('remove_slider2'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider22.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider22.jpg" );
                    osc_add_flash_ok_message(__("The image has been removed","hero"), 'admin');
                }else{
                    osc_add_flash_error_message(__("Image not found","hero"), 'admin');
                }

            break;
                case('remove_slider3'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider33.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider33.jpg" );
                    osc_add_flash_ok_message(__("The image has been removed","hero"), 'admin');
                }else{
                    osc_add_flash_error_message(__("Image not found","hero"), 'admin');
                }

            break;
               case('remove_slider4'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider44.jpg" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider44.jpg" );
                    osc_add_flash_ok_message(__("The image has been removed","hero"), 'admin');
                }else{
                    osc_add_flash_error_message(__("Image not found","hero"), 'admin');
                }

            break;
                 case('remove_slider5'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/payment.png" ) ) {
                    unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/payment.png" );
                    osc_add_flash_ok_message(__("The image has been removed","hero"), 'admin');
                }else{
                    osc_add_flash_error_message(__("Image not found","hero"), 'admin');
                }

            break;
            
        }
    }
?>
    <?php osc_show_flash_message('admin') ; ?>
                <?php if(is_writable( WebThemes::newInstance()->getCurrentThemePath() ."images/slider/") )  { ?>

<h2 class="render-title"><?php _e("Slider Images", 'hero'); ?></h2>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Slider Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider11.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/slider/slider11.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#slider');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_slider1" />
            <fieldset>
                <input id="button_remove" class="btn btn-red" type="submit" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#slider');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_slider1" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Slider Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="slider1" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any images", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Slider Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider22.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/slider/slider22.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#slider');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_slider2" />
            <fieldset>
                <input id="button_remove" class="btn btn-red" type="submit" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#slider');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_slider2" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Slider Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="slider2" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any images", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Slider Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider33.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/slider/slider33.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#slider');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_slider3" />
            <fieldset>
                <input id="button_remove" type="submit" class="btn btn-red" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#slider');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_slider3" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Slider Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="slider3" id="package" /> </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any images", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Slider Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/slider/slider44.jpg" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/slider/slider44.jpg');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#slider');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_slider4" />
            <fieldset>
                <input id="button_remove" type="submit" class="btn btn-red" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#slider');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_slider4" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Slider Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="slider4" id="package" /> 
                        </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> 
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any images", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div id="settings_form">
    <div class="padi">
        <p class="avan">
            <?php _e("Footer Images", 'hero'); ?> </p>
        <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/payment.png" ) ) {?>
        <p>
            <?php _e("Preview", 'hero'); ?> </p> <img class="tomblok" src="<?php echo osc_current_web_theme_url('images/payment.png');?>" />
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#slider');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="remove_slider5" />
            <fieldset>
                <input id="button_remove" type="submit" class="btn btn-red" value="<?php echo osc_esc_html(__('Remove','hero')); ?>" /> </fieldset>
        </form>
        <p>
            <?php _e("Please reload or refresh your browser if images not change.", 'hero'); ?> </p>
        <button onclick='window.location.reload();'>
            <?php _e("Reload browser", 'hero'); ?> </button>
        <?php } else { ?>
        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/hero/admin/admin.php#slider');?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action_specific" value="upload_slider5" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label">
                            <label for="package"><?php _e("Footer Images", 'hero'); ?> <?php _e("png,gif,jpg", 'hero'); ?></label>
                        </div>
                        <div class="form-controls">
                            <input type="file" name="slider5" id="package" /> 
                        </div>
                        <div class="uploader">
                            <input id="button_save" class="btn btn-submit" type="submit" value="<?php echo osc_esc_html(__('Upload','hero')); ?>" /> 
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <p>
            <?php _e("Has not uploaded any images", 'hero');?> </p>
        <?php } ?> </div>
</div>
<div style="clear: both;"></div>
                <?php } else { ?>
                <div id="flash_message">
                <p>
                    <?php
                        $msg  = sprintf(__('The images folder %s is not writable on your server','hero'), WebThemes::newInstance()->getCurrentThemePath() ."images/" ) .", ";
                        $msg .= __('Osclass can\'t upload slider image from the administration panel','hero') . '. ';
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