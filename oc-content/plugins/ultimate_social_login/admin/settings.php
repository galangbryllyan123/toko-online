<?php defined('ABS_PATH') or die('Access denied');
    
    osc_show_flash_message();
    
    $networks = USLModel::newInstance()->getSocNetworks();
    $soc_ico = usl_get_soc_icons();
    $data = USLAdminSettings::uslAdminGetSettings();
?>
<style>
.credit-osclasspro{clear: both;height:70px;}
.pro_logo {display: block;float:left;opacity:0.7;}
.pro_logo:hover  {opacity:1;}
.follow {float:right;color: #333;margin-top: 20px;}
.follow ul li:first-child {font-weight: bold;position: relative;top: 3px;margin: 0 0 0 20px;}
.follow ul li {float: left;margin: -15px 5px 5px 5px;}
.follow li a {opacity: 0.7;text-align: center;line-height: 1px;display: block;border-radius: 100%;font-size: 13px;-webkit-transition: all 0.3s ease-in-out 0s;-moz-transition: all 0.3s ease-in-out 0s;-ms-transition: all 0.3s ease-in-out 0s;-o-transition: all 0.3s ease-in-out 0s;transition: all 0.3s ease-in-out 0s;}
.follow li a:hover {opacity: 1;}
.follow li img{height: 40px;}
</style>
<div class="credit-osclasspro"> <a href="https://<?php _e('osclass-pro.com', 'ultimate_social_login'); ?>/" target="_blank" class="pro_logo">
<?php if( osc_current_admin_locale () == 'ru_RU') { ?>
 <img src="<?php echo osc_base_url();?>/oc-content/plugins/ultimate_social_login/admin/images/logoru.png" alt="Osclass шаблоны и плагины" title="Osclass шаблоны и плагины" />
<?php } else { ?>
 <img src="<?php echo osc_base_url();?>/oc-content/plugins/ultimate_social_login/admin/images/logo.png" alt="Premium themes and plugins" title="Premium themes and plugins" />
<?php } ?>
 </a>
</a>
  <div class="follow">
    <ul>
      <li><?php _e('Follow us','ultimate_social_login'); ?> <i class="fa fa-hand-o-right"></i></li>
	  	  	<?php if( osc_current_admin_locale () == 'ru_RU') { ?>
	  <li><a href="https://vk.com/osclasspro" target="_blank" title="vk"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGlkPSJDYXBhXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDExMi4xOTYgMTEyLjE5NjsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDExMi4xOTYgMTEyLjE5NiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGc+PGc+PGNpcmNsZSBjeD0iNTYuMDk4IiBjeT0iNTYuMDk4IiBpZD0iWE1MSURfMTFfIiByPSI1Ni4wOTgiIHN0eWxlPSJmaWxsOiM0RDc2QTE7Ii8+PC9nPjxwYXRoIGQ9Ik01My45NzksODAuNzAyaDQuNDAzYzAsMCwxLjMzLTAuMTQ2LDIuMDA5LTAuODc4ICAgYzAuNjI1LTAuNjcyLDAuNjA1LTEuOTM0LDAuNjA1LTEuOTM0cy0wLjA4Ni01LjkwOCwyLjY1Ni02Ljc3OGMyLjcwMy0wLjg1Nyw2LjE3NCw1LjcxLDkuODUzLDguMjM1ICAgYzIuNzgyLDEuOTExLDQuODk2LDEuNDkyLDQuODk2LDEuNDkybDkuODM3LTAuMTM3YzAsMCw1LjE0Ni0wLjMxNywyLjcwNi00LjM2M2MtMC4yLTAuMzMxLTEuNDIxLTIuOTkzLTcuMzE0LTguNDYzICAgYy02LjE2OC01LjcyNS01LjM0Mi00Ljc5OSwyLjA4OC0xNC43MDJjNC41MjUtNi4wMzEsNi4zMzQtOS43MTMsNS43NjktMTEuMjljLTAuNTM5LTEuNTAyLTMuODY3LTEuMTA1LTMuODY3LTEuMTA1bC0xMS4wNzYsMC4wNjkgICBjMCwwLTAuODIxLTAuMTEyLTEuNDMsMC4yNTJjLTAuNTk1LDAuMzU3LTAuOTc4LDEuMTg5LTAuOTc4LDEuMTg5cy0xLjc1Myw0LjY2Ny00LjA5MSw4LjYzNmMtNC45MzIsOC4zNzUtNi45MDQsOC44MTctNy43MSw4LjI5NyAgIGMtMS44NzUtMS4yMTItMS40MDctNC44NjktMS40MDctNy40NjdjMC04LjExNiwxLjIzMS0xMS41LTIuMzk3LTEyLjM3NmMtMS4yMDQtMC4yOTEtMi4wOS0wLjQ4My01LjE2OS0wLjUxNCAgIGMtMy45NTItMC4wNDEtNy4yOTcsMC4wMTItOS4xOTEsMC45NGMtMS4yNiwwLjYxNy0yLjIzMiwxLjk5Mi0xLjY0LDIuMDcxYzAuNzMyLDAuMDk4LDIuMzksMC40NDcsMy4yNjksMS42NDQgICBjMS4xMzUsMS41NDQsMS4wOTUsNS4wMTIsMS4wOTUsNS4wMTJzMC42NTIsOS41NTQtMS41MjMsMTAuNzQxYy0xLjQ5MywwLjgxNC0zLjU0MS0wLjg0OC03LjkzOC04LjQ0NiAgIGMtMi4yNTMtMy44OTItMy45NTQtOC4xOTQtMy45NTQtOC4xOTRzLTAuMzI4LTAuODA0LTAuOTEzLTEuMjM0Yy0wLjcxLTAuNTIxLTEuNzAyLTAuNjg3LTEuNzAyLTAuNjg3bC0xMC41MjUsMC4wNjkgICBjMCwwLTEuNTgsMC4wNDQtMi4xNiwwLjczMWMtMC41MTYsMC42MTEtMC4wNDEsMS44NzUtMC4wNDEsMS44NzVzOC4yNCwxOS4yNzgsMTcuNTcsMjguOTkzICAgQzQ0LjI2NCw4MS4yODcsNTMuOTc5LDgwLjcwMiw1My45NzksODAuNzAyTDUzLjk3OSw4MC43MDJ6IiBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7ZmlsbDojRkZGRkZGOyIvPjwvZz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48L3N2Zz4=" /></a></li>
		<?php } ?>
      <li><a href="https://www.facebook.com/<?php _e('osclassprocom', 'ultimate_social_login'); ?>" target="_blank" title="facebook"><img src="data:image/png;base64,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" /></a></li>
      <li><a href="https://twitter.com/<?php _e('osclass_pro_com', 'ultimate_social_login'); ?>" target="_blank" title="twitter"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGlkPSJDYXBhXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDExMi4xOTcgMTEyLjE5NzsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDExMi4xOTcgMTEyLjE5NyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGc+PGNpcmNsZSBjeD0iNTYuMDk5IiBjeT0iNTYuMDk4IiByPSI1Ni4wOTgiIHN0eWxlPSJmaWxsOiM1NUFDRUU7Ii8+PGc+PHBhdGggZD0iTTkwLjQ2MSw0MC4zMTZjLTIuNDA0LDEuMDY2LTQuOTksMS43ODctNy43MDIsMi4xMDljMi43NjktMS42NTksNC44OTQtNC4yODQsNS44OTctNy40MTcgICAgYy0yLjU5MSwxLjUzNy01LjQ2MiwyLjY1Mi04LjUxNSwzLjI1M2MtMi40NDYtMi42MDUtNS45MzEtNC4yMzMtOS43OS00LjIzM2MtNy40MDQsMC0xMy40MDksNi4wMDUtMTMuNDA5LDEzLjQwOSAgICBjMCwxLjA1MSwwLjExOSwyLjA3NCwwLjM0OSwzLjA1NmMtMTEuMTQ0LTAuNTU5LTIxLjAyNS01Ljg5Ny0yNy42MzktMTQuMDEyYy0xLjE1NCwxLjk4LTEuODE2LDQuMjg1LTEuODE2LDYuNzQyICAgIGMwLDQuNjUxLDIuMzY5LDguNzU3LDUuOTY1LDExLjE2MWMtMi4xOTctMC4wNjktNC4yNjYtMC42NzItNi4wNzMtMS42NzljLTAuMDAxLDAuMDU3LTAuMDAxLDAuMTE0LTAuMDAxLDAuMTcgICAgYzAsNi40OTcsNC42MjQsMTEuOTE2LDEwLjc1NywxMy4xNDdjLTEuMTI0LDAuMzA4LTIuMzExLDAuNDcxLTMuNTMyLDAuNDcxYy0wLjg2NiwwLTEuNzA1LTAuMDgzLTIuNTIzLTAuMjM5ICAgIGMxLjcwNiw1LjMyNiw2LjY1Nyw5LjIwMywxMi41MjYsOS4zMTJjLTQuNTksMy41OTctMTAuMzcxLDUuNzQtMTYuNjU1LDUuNzRjLTEuMDgsMC0yLjE1LTAuMDYzLTMuMTk3LTAuMTg4ICAgIGM1LjkzMSwzLjgwNiwxMi45ODEsNi4wMjUsMjAuNTUzLDYuMDI1YzI0LjY2NCwwLDM4LjE1Mi0yMC40MzIsMzguMTUyLTM4LjE1M2MwLTAuNTgxLTAuMDEzLTEuMTYtMC4wMzktMS43MzQgICAgQzg2LjM5MSw0NS4zNjYsODguNjY0LDQzLjAwNSw5MC40NjEsNDAuMzE2TDkwLjQ2MSw0MC4zMTZ6IiBzdHlsZT0iZmlsbDojRjFGMkYyOyIvPjwvZz48L2c+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PC9zdmc+" /></a></li>
    </ul>
  </div>
</div>
<div class="usl-manage-wrapper">
    <?php require_once 'left_menu.php'; ?>
    <div class="usl-manage-content usl-section">
        <h3><?php _e('Manage login social networks', 'ultimate_social_login'); ?></h3>
        
        <div style="margin:15px;">
            <form action="<?php echo osc_route_admin_url('usl-settings'); ?>" method="post">
                <input type="hidden" name="page" value="plugins"/>
                <input type="hidden" name="action" value="renderplugin"/>
                <input type="hidden" name="route" value="usl-settings"/>
                <input type="hidden" name="plugin_action" value="edit"/>
                
                <table id="sortable" class="table table-no-border">
                    <?php foreach($networks as $network): ?>
                    <tr id="<?php echo $network['usl_id']?>">
                        <td style="width: 50px;"><?php echo $soc_ico[$network['usl_code'] . '_ico'] ?></td>
                        <td style="width: 150px;"><?php _e($network['usl_name'], 'ultimate_social_login'); ?></td>
                        <td>
                            <input type="text" value="<?php echo osc_esc_html($data[$network['usl_code'] . '_id']); ?>" name="<?php echo $network['usl_code']?>_id" placeholder="<?php _e($network['usl_ph_id'], 'ultimate_social_login'); ?>" <?php if(!$data[$network['usl_code'] . '_status']):?>disabled<?php endif; ?> />
                        </td>
                        <td>
                            <input type="text" value="<?php echo osc_esc_html($data[$network['usl_code'] . '_secret']); ?>" name="<?php echo $network['usl_code']?>_secret" placeholder="<?php _e($network['usl_ph_secret'], 'ultimate_social_login'); ?>" <?php if(!$data[$network['usl_code'] . '_status']):?>disabled<?php endif; ?> />
                        </td>
                        <td>
                            <?php if($network['usl_code'] == 'ok'): ?>
                                <input type="text" value="<?php echo osc_esc_html($data[$network['usl_code'] . '_public']); ?>" name="<?php echo $network['usl_code']?>_public" placeholder="<?php _e($network['usl_name'] . ' Public Key', 'ultimate_social_login'); ?>" <?php if(!$data[$network['usl_code'] . '_status']):?>disabled<?php endif; ?> />
                            <?php endif; ?>
                        </td>
                        <td style="width: 50px; font-size: 15px; text-align: center;">
                            <a id="sort" href="javascript:void(0);"><i class="fa fa-arrows"></i></a>
                        </td>
                        <td class="col-actions">
                            <div style="display: inline-block;width: 80px; text-align: center;">
                                <div data-toggle="switch">
                                    <input id="<?php echo $network['usl_code']?>" type="checkbox" name="<?php echo $network['usl_code']?>_status" value="1" <?php if($data[$network['usl_code'] . '_status']):?>checked<?php endif; ?>  />
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <div class="load"></div>
                <div class="res"><?php _e('Configuration has been updated', 'ultimate_social_login') ?></div>
                
                <div class="form-actions">
                    <input type="submit" id="save_changes" value="<?php echo osc_esc_html(__("Save changes", 'ultimate_social_login')); ?>" class="btn btn-submit">
                </div>
            </form>
        </div>
    </div>
</div>
  <div class="seo_copyright">
	<span>&copy; <?php echo date('Y') ?> <a target="_blank" title="osclass-pro.com" href="https://<?php _e('osclass-pro.com', 'seo_plugin'); ?>/"><?php _e('osclass-pro.com', 'seo_plugin'); ?></a>. All rights reserved.</span>
  </div>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="switch"]').hurkanSwitch({
        'on':function(el){
            var socName = $(el).parents('td.col-actions').find('input[type="checkbox"]').attr('id');
            
            $('input[type="text"][name^="' + socName + '"]').removeAttr('disabled').css({'opacity' : 1});
        },
        'off':function(el){
            var socName = $(el).parents('td.col-actions').find('input[type="checkbox"]').attr('id');
            
            $('input[type="text"][name^="' + socName + '"]').attr('disabled', true).css({'opacity' : 0.7});
        },
        
        'onTitle' : 'On',
        'offTitle' : 'Off',
        'animate' : true,
        'offColor' : 'danger',
        'onColor' : 'success',
        'width': 60
    });
    
    $("#sortable").sortable({
        placeholder: "ph-highlights",    
        items: "tr",
        handle: "#sort",
        axis: "y",
        opacity: 0.5,
        revert: true,
        stop: function(){
    	   var id_s = $('#sortable').sortable('toArray');
        
            $(".load").fadeIn(700);
    
            $.ajax({
                url: '<?php echo osc_admin_base_url();?>index.php?page=plugins&action=renderplugin&route=usl-settings&ajax=sorting',
                type: 'POST',
                data: {"ids" : id_s},
                error: function(){},
                success: function(data){
                    $(".load").fadeOut(300,function () {
                        if(data.trim() != 'Error') {
                            $(".res").stop(true, true).fadeIn(300).fadeOut(2000);
                        }
                    });
                }
            });
    	}
    });
});
</script>