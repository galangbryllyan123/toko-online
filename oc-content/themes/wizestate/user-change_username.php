<?php
    // meta tag robots
    osc_add_hook('header','osclasswizards_nofollow_construct');

    osc_enqueue_script('jquery-validate');

    osclasswizards_add_body_class('user user-usernames');
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-sidebar.php');
    }
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return osc_esc_html(__('Change username', OSCLASSWIZARDS_THEME_FOLDER));
    }
    osc_current_web_theme_path('header.php') ;
    $osc_user = osc_user();
?>
<script type="text/javascript">
$(document).ready(function() {
    $('form#change-username').validate({
        rules: {
            s_username: {
                required: true
            }
        },
        messages: {
            s_username: {
                required: '<?php echo osc_esc_js(__("Username: this field is required", OSCLASSWIZARDS_THEME_FOLDER)); ?>.'
            }
        },
        errorLabelContainer: "#error_list",
        wrapper: "li",
        invalidHandler: function(form, validator) {
            $('html,body').animate({ scrollTop: $('h1').offset().top }, { duration: 250, easing: 'swing'});
        },
        submitHandler: function(form){
            $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
            form.submit();
        }
    });

    var cInterval;
    $("#s_username").keydown(function(event) {
        if($("#s_username").attr("value")!='') {
            clearInterval(cInterval);
            cInterval = setInterval(function(){
                $.getJSON(
                    "<?php echo osc_base_url(true); ?>?page=ajax&action=check_username_availability",
                    {"s_username": $("#s_username").attr("value")},
                    function(data){
                        clearInterval(cInterval);
                        if(data.exists==0) {
                            $("#available").text('<?php echo osc_esc_js(__("The username is available", OSCLASSWIZARDS_THEME_FOLDER)); ?>');
                        } else {
                            $("#available").text('<?php echo osc_esc_js(__("The username is NOT available", OSCLASSWIZARDS_THEME_FOLDER)); ?>');
                        }
                    }
                );
            }, 1000);
        }
    });

});
</script>

<div class="row">
  <?php
	        osc_current_web_theme_path('user-sidebar.php');

   ?>
  <div class="col-sm-8 col-md-9">
  
  <div class="title">
    <h1>
      <?php _e('Change Username', OSCLASSWIZARDS_THEME_FOLDER); ?>
    </h1>
    
    </div>
    <ul id="error_list">
    </ul>
    <div class="dashboard_form">
    
    <form action="<?php echo osc_base_url(true); ?>" method="post" id="change-username">
      <input type="hidden" name="page" value="user" />
      <input type="hidden" name="action" value="change_username_post" />
      <div class="form-group">
        <label class="control-label" for="s_username">
          <?php _e('Username', OSCLASSWIZARDS_THEME_FOLDER); ?>
        </label>
        <div class="controls">
          <input type="text" name="s_username" id="s_username" value="" />
          <div id="available"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="controls">
          <button type="submit" class="btn btn-success">
          <?php _e("Update", OSCLASSWIZARDS_THEME_FOLDER);?>
          </button>
        </div>
      </div>
    </form></div>
  </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
