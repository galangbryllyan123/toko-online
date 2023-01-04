<?php
/*
Plugin Name: Avatar Plugin
Plugin URI: http://www.osclass.org
Description: Avatar plugins helps to upload profile picture while register.
Version: 1.0.2
Author: Media.Dmj
Author URI: http://www.vithudu.com/
Short name: Avatar Plugin
Plugin update URI: avatar-plugin
*/

include "ModelAvatar.php";

/* Install Plugin */
function avatar_install() {
	ModelAvatar::newInstance()->import('avatar_plugin/struct.sql');
	if (!file_exists(osc_content_path()."/plugins/avatar_plugin/avatar/")) {
		mkdir(osc_content_path()."/plugins/avatar_plugin/avatar/", 0777, true);
		fopen(osc_content_path()."/plugins/avatar_plugin/avatar/index.php", 'a');
	}
}

/* Uninstall Plugin */
function avatar_uninstall() {
	ModelAvatar::newInstance()->uninstall();
}


function insertAvatar($userId){
	if(!$_FILES["avatar"]["error"] == 4){
		$upload_directory = osc_content_path().'/plugins/avatar_plugin/avatar/';
		$safe_filename = preg_replace(
						 array("/\s+/", "/[^-\.\w]+/"),
						 array("_", ""),
						 trim($_FILES['avatar']['name'])); 
						 
		$ext = pathinfo($safe_filename, PATHINFO_EXTENSION);
		$ipath = $userId."_". uniqid() .'.'.$ext;
		move_uploaded_file (
					 $_FILES['avatar']['tmp_name'],
					 $upload_directory.$ipath);
					 
		$last_added = ModelAvatar::newInstance()->getAvatar($userId);
		if($last_added !="" ) {
			ModelAvatar::newInstance()->updateAvatar($ipath, $userId);
		} else {
			ModelAvatar::newInstance()->insertAvatar($ipath, $userId);
		}
	}
}


function show_avatar($user) {
	$avatar = ModelAvatar::newInstance()->getAvatar($user); 
		if($avatar){?>
      	<img class="avatar img-thumbnail" style="border: 1px solid rgb(221, 221, 221); background: rgb(255, 255, 255) none repeat scroll 0% 0%; padding: 5px; border-radius: 4px; margin-bottom: 5px; margin-left: 39px;" width="150"  src="<?php echo osc_base_url()."oc-content/plugins/avatar_plugin/avatar/". $avatar; ?>" />
  		 <?php } else { ?>
		 	<img class="avatar no-avatar img-thumbnail" style="border: 1px solid rgb(221, 221, 221); background: rgb(255, 255, 255) none repeat scroll 0% 0%; padding: 5px; border-radius: 4px; margin-bottom: 5px; margin-left: 39px;" width="150"  src="<?php echo osc_base_url()."oc-content/plugins/avatar_plugin/no-avatar.png";?>" />
		<?php }
		

}
function avatar_form(){ ?>
	<div class="control-group">
   		<label class="control-label" for="password"><?php _e('Avatar', 'avatar_plugin'); ?></label>
         <div class="controls">
    		<?php show_avatar(osc_user_id()); ?><br />
        </div>
        <div class="controls">
            <div id="text">
            <input id="pAvatar"  name="avatar" type="file" />
            <span id="lblError" style="color: red;"></span>
            </div>
           	
        </div>
    </div>
    <script type="text/javascript">
	    $(document).ready(function() {
	        $(".user-profile form").attr("enctype", "multipart/form-data");
			$("form[name='register']").attr("enctype", "multipart/form-data");
			
			
	    });
	</script>
    <?php if( osc_get_osclass_section() =="profile"){?>
    <script type="text/javascript" src="<?php echo osc_base_url().'oc-includes/osclass/assets/js/jquery.validate.min.js';?>"></script>
   	<?php } ?>
    <script type="text/javascript" src="<?php echo osc_base_url().'oc-content/plugins/avatar_plugin/js/additional-methods.min.js';?>"></script>
    
    
   	<script type="text/javascript">
			$.validator.addMethod('filesize', function (value, element, param) {
			    return this.optional(element) || (element.files[0].size <= param)
			});

			
			$("form[name='register'], form[name='profile']").validate({
			  rules: {
			    'avatar': {
			      <?php if (!OC_ADMIN) { ?>
			      //required: true,
			      <?php } ?>
			      extension: "png|jpe?g",
			      filesize: 3145728
			    }
			  },
			   messages:{
			        'avatar':{
			           <?php if (!OC_ADMIN) { ?>
			           //required : "<?php //echo osc_esc_js(__('Please upload at least a document','avatar_plugin')); ?>",
			           <?php } ?>
			           extension:"<?php echo osc_esc_js(__('Only png, jpg formats are allowed!','avatar_plugin')); ?>",
			           filesize: "<?php echo osc_esc_js(__('Size should less than 3MB','avatar_plugin')); ?>"
			        }
			    }
			});
			
	</script>

	<style type="text/css">
	label.error {
			color:#ff0000;
			display: block;
		}
	</style>


<?php }


function avatar_user_menu() {
	echo '<li style="background:#e7e7e7;"><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/help.php') . '" >' . __('Avatar Help', 'avatar_plugin') . '</a></li>';
}


osc_add_hook('admin_menu', 'avatar_user_menu');
osc_add_hook('user_register_form', 'avatar_form');
osc_add_hook('user_profile_form', 'avatar_form');
osc_add_hook('user_register_completed', 'insertAvatar');
osc_add_hook('user_edit_completed', 'insertAvatar');

osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'avatar_uninstall') ;
osc_register_plugin(osc_plugin_path(__FILE__), 'avatar_install') ;
?>