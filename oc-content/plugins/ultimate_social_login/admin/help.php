<?php defined('ABS_PATH') or die('Access denied'); ?>
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
        <h3><?php _e('Help desk', 'ultimate_social_login'); ?></h3>
        
        <div style="margin:15px;">
            <div class="accordion">
                <section class="accordion_item active_block">
                    <h3 class="title_block"><?php _e('How to integrate social networking buttons', 'ultimate_social_login') ?></h3>
                    <div class="info" style="display: block;">
                        <p class="info_item">
                            <?php _e('Once you configure the plugin, open these 2 files in your template:', 'ultimate_social_login') ?> <strong>user-login.php</strong>, <strong>user-register.php</strong>
                        </p>
                        
                        <p class="info_item">
                            <?php _e('And add the one line of code:', 'ultimate_social_login') ?> 
                            
                            <span class="code-block"> 
                                <span class="php-tag">&lt;?php</span>
                                    <span class="php-function"> osc_run_hook(<span class="php-function-data">'usl_auth_buttons'</span>); </span>
                                <span class="php-tag">?&gt;</span>
                            </span>
                        </p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring Facebook authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="https://developers.facebook.com/apps/" target="_blank">Facebook Developers</a> <?php _e('and <ins>create a new application</ins> by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('+Add a New App', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-1.png" /></p>
                        <p class="info_item">2. <?php _e('Provide a <ins>Display Name</ins>, <ins>Contact Email</ins> and click', 'ultimate_social_login') ?> <strong>"<?php _e('Create App ID', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-2.png" /></p>
                        <p class="info_item">3. <?php _e('On the <ins>+ Add Product</ins> page choose <ins>Facebook Login</ins> and click', 'ultimate_social_login') ?> <strong>"<?php _e('Set Up', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-3.png" /></p>
                        <p class="info_item">4. <?php _e('On the Next page Select', 'ultimate_social_login') ?> <strong>"WWW (Web)"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-4.png" /></p>
                        <p class="info_item">
                            5. <?php _e('Put your website domain in the <ins>Site Url</ins> field and click', 'ultimate_social_login') ?> <strong>"<?php _e('Save') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your Site URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url();?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-5.png" /></p>
                        <p class="info_item">
                            6. <?php _e('Go to <ins>Facebook Login =&gt; Settings</ins> and provide your website url in the <ins>Valid OAuth redirect URIs</ins> and click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your Site URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'index.php?page=custom&route=usl-endpoint&hauth_done=Facebook';?></span>
                            </span>
                        </p>
						<p class="info_item">
                            <span class="code-block">
                                <span class="php-function-data"><strong><?php _e('Notice:', 'ultimate_social_login') ?></strong> <?php _e('If the Friendly URI is activated, use this  Valid OAuth redirect URIs', 'ultimate_social_login') ?>.</span>
                            </span>
                        
                            <span class="code-block">
                                <strong><?php _e('Your Site URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'ultimate_social_login/connect?hauth_done=Facebook';?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-6.png" /></p>
                        <p class="info_item">7. <?php _e('Go to <ins>App Review</ins> page and change marker as', 'ultimate_social_login') ?> <strong>"<?php _e('Yes', 'ultimate_social_login') ?>"</strong> <?php _e('to make your App is available to the public', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-7.png" /></p>
                        <p class="info_item">8. <?php _e('Select <ins>Category</ins> in the pop-up window and click', 'ultimate_social_login') ?> <strong>"<?php _e('Confirm', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-8.png" /></p>
                        <p class="info_item">9. <?php _e('Go to <ins>Settings =&gt; Basic</ins> and copy your <strong>App ID</strong> and <strong>App Secret</strong> (click', 'ultimate_social_login') ?> <strong>"<?php _e('Show', 'ultimate_social_login') ?>"</strong> <?php _e('You may be required to re-enter your Facebook password)', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-9.png" /></p>
                        <p class="info_item">10. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>App ID</strong> and <strong>App Secret</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-10.png" /></p>
                        <p class="info_item">11. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed Facebook Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>facebook/fb-11.png" /></p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring Google authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="https://developers.google.com/identity/sign-in/web/sign-in" target="_blank">Google Sign-In for Websites</a> <?php _e('and <ins>create a new project</ins> (or select an existing one) by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('Configure a project', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>google/g-1.png" /></p>
                        
                        <p class="info_item">2. <?php _e('In the pop-up window, enter any data. And on the tab <ins>"Configure your OAuth client"</ins> make the following settings:', 'ultimate_social_login') ?> 
                            <span class="code-block">
                                - <?php _e('From the list <strong>"Where are you calling from?"</strong> select <ins>Web Server</ins>', 'ultimate_social_login') ?>
                            </span>
                            
                            <span class="code-block">
                               - <?php _e('In the "Authorized redirect URIs" field, enter this URI:', 'ultimate_social_login') ?> <span class="php-function-data"><?php echo rtrim(osc_base_url(),'/');?></span>
                            </span>
                            
                            <span class="code-block">
                                - <?php _e('Complete the action by clicking on the <strong>"Create"</strong> button', 'ultimate_social_login') ?>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>google/g-2.png" /></p>
                        
                        <p class="info_item">3. <?php _e('Go to the <ins>"API Console"</ins> page by clicking on the <strong>"API Console"</strong> link', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>google/g-3.png" /></p>
                        
                        <p class="info_item">4. <?php _e('On the next page, click on the <strong>"Credentials"</strong> page', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>google/g-4.png" /></p>
                        
                        <p class="info_item">5. <?php _e('On the next page, click on the <strong>"Create credentials"</strong> button and select <strong>"OAuth client ID"</strong>', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>google/g-5.png" /></p>
                        
                        <p class="info_item">6. <?php _e('On the next page, make the following settings:', 'ultimate_social_login') ?>
                            <span class="code-block">
                                - <?php _e('From the options, select <ins>Web application</ins>', 'ultimate_social_login') ?>
                            </span>
                            
                            <span class="code-block">
                               - <?php _e('In the "Authorized JavaScript origins" field, enter this URI:', 'ultimate_social_login') ?> <span class="php-function-data"><?php echo rtrim(osc_base_url(),'/');?></span>
                            </span>
                            
                            <span class="code-block">
                               - <?php _e('In the "Authorized redirect URIs" field, enter this URI:', 'ultimate_social_login') ?> <span class="php-function-data"><?php echo rtrim(osc_base_url(),'/');?></span>
                            </span>
                            
                            <span class="code-block">
                                - <?php _e('Complete the action by clicking on the <strong>"Create"</strong> button', 'ultimate_social_login') ?>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>google/g-6.png" /></p>
                        
                        <p class="info_item">7. <?php _e('Copy your <ins>Client ID</ins> and <ins>Client Secret</ins>', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>google/g-7.png" /></p>
                        
                        <p class="info_item">8. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>App ID</strong> and <strong>App Secret</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>google/g-8.png" /></p>
                        
                        <p class="info_item">9. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed Google+ Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>google/g-9.png" /></p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring Twitter authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="https://developer.twitter.com/en/apps" target="_blank">Twitter Application Management</a> <?php _e('and <ins>create a new app</ins> by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('Create New App', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>twitter/tw-1.png" /></p>
                        
                        <p class="info_item">2. <?php _e('Fill out any required fields such as the <ins>Name</ins>, <ins>Description</ins>, <ins>Website</ins> and <ins>Callback URL</ins> and create your App by clicking on', 'ultimate_social_login') ?> <strong>"<?php _e('Create your Twitter application', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your Website URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo rtrim(osc_base_url(),'/');?></span>
                            </span>
                            
                            <span class="code-block">
                                <strong><?php _e('Your Callback URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'oc-content/plugins/ultimate_social_login/twitter.php';?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>twitter/tw-2.png" /></p>
                        
                        <p class="info_item">3. <?php _e('After that, go to the tab <ins>Settings</ins> and provide your <ins>Privacy Policy URL</ins> and <ins>Terms of Service URL</ins> (it must be done so that the plug-in can get the Twitter user\'s E-mail). Save settings by click', 'ultimate_social_login') ?> <strong>"<?php _e('Update Settings', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>twitter/tw-3.png" /></p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>twitter/tw-3-1.png" /></p>
                        <p class="info_item">4. <?php _e('Now go to the <ins>Permissions</ins> tab and check the box <ins>Request email addresses from users</ins>. Update permissions by click', 'ultimate_social_login') ?> <strong>"<?php _e('Update Settings', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>twitter/tw-4.png" /></p>
						<p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>twitter/tw-4-1.png" /></p>
                        
                        <p class="info_item">5. <?php _e('And now go to the <ins>Keys and Access Tokens</ins> tab, scroll down the page and click on', 'ultimate_social_login') ?> <strong>"<?php _e('Create my access token', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>twitter/tw-5.png" /></p>
                        
                        <p class="info_item">6. <?php _e('After that, scroll up the page and copy your <ins>Consumer Key (API Key)</ins> and <ins>Consumer Secret (API Secret)</ins>', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>twitter/tw-6.png" /></p>
                        
                        <p class="info_item">7. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>API Key</strong> and <strong>API Secret</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>twitter/tw-7.png" /></p>
                        
                        <p class="info_item">8. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed Twitter Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>twitter/tw-8.png" /></p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring Instagram authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="https://www.instagram.com/developer/clients/manage/" target="_blank">Manage Clients</a> <?php _e('and <ins>create a new app</ins> by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('Register a New Client', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>instagram/inst-1.png" /></p>
                    
                        <p class="info_item">2. <?php _e('Fill out any required fields such as the <ins>Application Name</ins>, <ins>Description</ins>, <ins>Company Name</ins>, <ins>Website URL</ins>, <ins>Valid redirect URIs</ins>, <ins>Privacy Policy URL</ins>, <ins>Contact email</ins> and create your Client ID by clicking on', 'ultimate_social_login') ?> <strong>"<?php _e('Register', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your Website URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo rtrim(osc_base_url(),'/');?></span>
                            </span>
                            
                            <span class="code-block">
                                <strong><?php _e('Your Valid redirect URI:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'index.php?page=custom&route=usl-endpoint?hauth.done=Instagram';?></span>
                            </span>
                        </p>
						<p class="info_item">
                            <span class="code-block">
                                <span class="php-function-data"><strong><?php _e('Notice:', 'ultimate_social_login') ?></strong> <?php _e('If the Friendly URI is activated, use this Callback URI', 'ultimate_social_login') ?>.</span>
                            </span>
                        
                            <span class="code-block">
                                <strong><?php _e('Your Valid redirect URI:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'ultimate_social_login/connect?hauth.done=Instagram';?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>instagram/inst-2.png" /></p>
                        
                        <p class="info_item">3. <?php _e('After <ins>Client ID</ins> was created click on the', 'ultimate_social_login') ?> <strong>"<?php _e('Manage', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>instagram/inst-3.png" /></p>
                        
                        <p class="info_item">4. <?php _e('To activate the <ins>Client ID</ins>, go to the <ins>Permissions</ins> tab and click', 'ultimate_social_login') ?> <strong>"<?php _e('Start a submission', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>instagram/inst-4.png" /></p>
                        
                        <p class="info_item">5. <?php _e('On the next page, fill out all required fields such as the <ins>API use case</ins>, <ins>Video Screencast URL</ins> and click', 'ultimate_social_login') ?> <strong>"<?php _e('Submit', 'ultimate_social_login') ?>"</strong>. <?php _e('Once your request is reviewed and approved, authorization via instagram will work', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>instagram/inst-5.png" /></p>
                        
                        <p class="info_item">6. <?php _e('After that, copy your <ins>Client ID</ins> and <ins>Client Secret</ins>', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>instagram/inst-6.png" /></p>
                        
                        <p class="info_item">7. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>Client ID</strong> and <strong>Client Secret</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>instagram/inst-7.png" /></p>
                        
                        <p class="info_item">8. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed Instagram Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>instagram/inst-8.png" /></p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring Linkedin authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="https://www.linkedin.com/secure/developer" target="_blank">LinkedIn Developers</a> <?php _e('and <ins>create a new application</ins> by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('Create Application', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>linkedin/lin-1.png" /></p>
                        
                        <p class="info_item">2. <?php _e('Fill out any required fields such as the <ins>Company Name</ins>, <ins>Application Name</ins>, <ins>Description</ins>, <ins>Website URL</ins>, <ins>Business Email</ins>, <ins>Business Phone</ins>, upload your <ins>Application Logo</ins> and select <ins>Application Use</ins>. And create your Application by clicking on', 'ultimate_social_login') ?> <strong>"<?php _e('Submit', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your Website URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo rtrim(osc_base_url(),'/');?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>linkedin/lin-2.png" /></p>
                        
                        <p class="info_item">3. <?php _e('On the next page, check the box <ins>r_emailaddress</ins> and provide your <ins>Authorized Redirect URLs</ins> and update settings by clicking on', 'ultimate_social_login') ?> <strong>"<?php _e('Update', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your Authorized Redirect URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'index.php?page=custom&route=usl-endpoint?hauth.done=LinkedIn';?></span>
                            </span>
                        </p>
						<p class="info_item">
                            <span class="code-block">
                                <span class="php-function-data"><strong><?php _e('Notice:', 'ultimate_social_login') ?></strong> <?php _e('If the Friendly URI is activated, use this Callback URI', 'ultimate_social_login') ?>.</span>
                            </span>
                        
                            <span class="code-block">
                                <strong><?php _e('Your Authorized Redirect URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'ultimate_social_login/connect?hauth.done=LinkedIn';?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>linkedin/lin-3.png" /></p>
                        
                        <p class="info_item">4. <?php _e('After that, copy your <ins>Client ID</ins> and <ins>Client Secret</ins>', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>linkedin/lin-4.png" /></p>
                        
                        <p class="info_item">5. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>Client ID</strong> and <strong>Client Secret</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>linkedin/lin-5.png" /></p>
                        
                        <p class="info_item">6. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed LinkedIn Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>linkedin/lin-6.png" /></p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring Windows Live authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="https://account.live.com/developers/applications/index" target="_blank">My applications</a> <?php _e('and <ins>create a new application</ins> by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('Add an app', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <span class="php-function-data"><strong><?php _e('Notice:', 'ultimate_social_login') ?></strong> <?php _e('SSL is required if you want to use Windows Live', 'ultimate_social_login') ?>.</span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-1.png" /></p>
                        
                        <p class="info_item">2. <?php _e('Fill out any required fields such as the <ins>Application Name</ins>, <ins>Contact Email</ins>. And register your Application by clicking on', 'ultimate_social_login') ?> <strong>"<?php _e('Create', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-2.png" /></p>
                        
                        <p class="info_item">3. <?php _e('First of all, you need to add the platform by clicking on', 'ultimate_social_login') ?> <strong>"<?php _e('Add Platform', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-3.png" /></p>
                        
                        <p class="info_item">4. <?php _e('In the pop-up window click on the', 'ultimate_social_login') ?> <strong>"<?php _e('Web', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-4.png" /></p>
                        
                        <p class="info_item">5. <?php _e('Provide your <ins>Redirect URLs</ins>', 'ultimate_social_login') ?>.
                            <span class="code-block">
                                <strong><?php _e('Your Authorized Redirect URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'oc-content/plugins/ultimate_social_login/winlive.php';?></span>
                            </span>
                        </p>
                        
                        
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-5.png" /></p>
                        
                        <p class="info_item">6. <?php _e('Now you need to <ins>Delegate Permissions</ins> by clicking on', 'ultimate_social_login') ?> <strong>"<?php _e('Add', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-6.png" /></p>
                        
                        <p class="info_item">7. <?php _e('In the pop-up window check boxes: <ins>email</ins>, <ins>openid</ins>, <ins>profile</ins> and click on the', 'ultimate_social_login') ?> <strong>"<?php _e('Ok', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-7.png" /></p>
                        
                        <p class="info_item">8. <?php _e('Scroll up the page and <ins>Generate Application Secret</ins> by clicking on', 'ultimate_social_login') ?> <strong>"<?php _e('Generate New Password', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-8.png" /></p>
                        
                        <p class="info_item">9. <?php _e('Copy your generated <ins>Password</ins> and click on the', 'ultimate_social_login') ?> <strong>"<?php _e('Ok', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-9.png" /></p>
                        
                        <p class="info_item">10. <?php _e('Copy your <ins>Application Id</ins> and <ins>Save changes</ins> by clicking on', 'ultimate_social_login') ?> <strong>"<?php _e('Save', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-10.png" /></p>
                        
                        <p class="info_item">11. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>Application Id</strong> and <strong>Password</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-11.png" /></p>
                        
                        <p class="info_item">12. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed Windows Live Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>windows/win-12.png" /></p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring Yahoo authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="https://developer.yahoo.com/apps/create/" target="_blank">Yahoo Developer Network</a> <?php _e('and <ins>create a new Application</ins>', 'ultimate_social_login') ?>.</p>
                        
                        <p class="info_item"><?php _e('Fill out any required fields such as the <ins>Application Name</ins>, <ins>Home Page URL</ins>, <ins>Callback Domain</ins> and check boxes <ins>API Permissions</ins>: <strong>Contacts</strong> (Read/Write), <strong>Profiles</strong> (Read/Write Public and Private) and click on the', 'ultimate_social_login') ?>  <strong>"<?php _e('Create app', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your Home Page and Callback Domain URLs:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo rtrim(osc_base_url(),'/');?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>yahoo/yh-1.png" /></p>
						<p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>yahoo/yh-1-1.jpg" /></p>
                        
                        <p class="info_item">2. <?php _e('Copy your <ins>Client ID</ins> and <ins>Client Secret</ins>', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>yahoo/yh-2.png" /></p>
                        
                        <p class="info_item">3. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>Client ID</strong> and <strong>Client Secret</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>yahoo/yh-3.png" /></p>
                        
                        <p class="info_item">4. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed Yahoo Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>yahoo/yh-4.png" /></p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring Classmates authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="https://ok.ru/devaccess" target="_blank">Developer rights granting request</a> <?php _e('and <ins>receive the developer rights</ins> by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('Receive the developer rights', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <span class="php-function-data"><strong><?php _e('Notice:', 'ultimate_social_login') ?></strong> <?php _e('SSL is required if you want to use Classmates', 'ultimate_social_login') ?>.</span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>ok/ok-1.png" /></p>
                        
                        <p class="info_item">2. <?php _e('After you have gained developed rights, go to:', 'ultimate_social_login') ?> <a href="https://ok.ru/dk?st.cmd=appsInfoMyDevList" target="_blank">My App Uploads</a> <?php _e('and <ins>Add your Application</ins> by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('Add App', 'ultimate_social_login') ?>"</strong>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>ok/ok-2.png" /></p>
                        
                        <p class="info_item">3. <?php _e('Click on the <ins>Enable OAuth</ins> and fill out any required fields such as the <ins>Title</ins>, <ins>Image 128x128 (provide link to your Image)</ins>, <ins>List of permitted redirect_uri</ins> and click on the', 'ultimate_social_login') ?>  <strong>"<?php _e('Save', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your permitted redirect_uri:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'index.php?page=custom&route=usl-endpoint?hauth.done=Odnoklassniki';?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>ok/ok-3.png" /></p>
                        
                        <p class="info_item">4. <?php _e('Check your E-mail and copy your <ins>Application ID</ins> and <ins>Secret Key</ins>', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>ok/ok-4.png" /></p>
                        
                        <p class="info_item">5. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>Application ID</strong> and <strong>Secret Key</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>ok/ok-5.png" /></p>
                        
                        <p class="info_item">6. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed Classmates Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>ok/ok-6.png" /></p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring VKontakte authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="https://vk.com/editapp?act=create" target="_blank">VK Developers</a>. <?php _e('Select <ins>Website</ins>, fill out any required fields such as the <ins>Title</ins>, <ins>Site address</ins>, <ins>Base domain</ins> and <ins>create a new Application</ins> by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('Connect Site', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your Site address:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo rtrim(osc_base_url(),'/');?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>vk/vk-1.png" /></p>
                        
                        <p class="info_item">2. <?php _e('After creating a "Project", navigate to <ins>Settings</ins> using the left-hand menu. On the opened page copy your: <ins>Application ID</ins> and <ins>Secure key</ins>', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>vk/vk-2.png" /></p>
                        
                        <p class="info_item">3. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>Application ID</strong> and <strong>Secure key</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>vk/vk-3.png" /></p>
                        
                        <p class="info_item">4. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed Vkontakte Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>vk/vk-4.png" /></p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring Mail.ru authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="http://api.mail.ru/sites/my/add/" target="_blank">Mail.ru Developers</a>. <?php _e('Provide <ins>App Name</ins>, <ins>Base domain</ins> and <ins>create a new Application</ins> by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('Continue', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your Base domain:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo rtrim(osc_base_url(),'/');?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>mailru/ml-1.png" /></p>
                        
                        <p class="info_item">2. <?php _e('To confirm the rights to your domain, download the file and put it in the root of your site (as shown in the screenshot). After that click on the', 'ultimate_social_login') ?>  <strong>"<?php _e('Continue', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Link to your file:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'receiver.html';?></span>
                            </span>
                        </p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>mailru/ml-2.png" /></p>
                        
                        <p class="info_item">3. <?php _e('On the next page copy your <ins>ID</ins> and <ins>Secret Key</ins>', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>mailru/ml-3.png" /></p>
                        
                        <p class="info_item">4. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>ID</strong> and <strong>Secret key</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>mailru/ml-4.png" /></p>
                        
                        <p class="info_item">5. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed Mailru Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>mailru/ml-5.png" /></p>
                    </div>
                </section>
                
                <section class="accordion_item">
                    <h3 class="title_block"><?php _e('Configuring Yandex authorization', 'ultimate_social_login') ?></h3>
                    <div class="info">
                        <p class="info_item">1. <?php _e('Go to:', 'ultimate_social_login') ?> <a href="https://oauth.yandex.ru/client/new" target="_blank">Yandex Application Management</a>. <?php _e('Provide <ins>App Name</ins>, <ins>Callback URL</ins>, check boxes: <ins>Access to Email</ins>, <ins>Access to Birthday</ins>, <ins>Access to Login</ins>, <ins>Access to Avatar</ins> and <ins>create a new Application</ins> by clicking on', 'ultimate_social_login') ?>  <strong>"<?php _e('Save', 'ultimate_social_login') ?>"</strong>.
                            <span class="code-block">
                                <strong><?php _e('Your Callback URL:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'index.php?page=custom&route=usl-endpoint&hauth.done=Yandex';?></span>
                            </span>
                        </p>
                        
                        <p class="info_item">
                            <span class="code-block">
                                <span class="php-function-data"><strong><?php _e('Notice:', 'ultimate_social_login') ?></strong> <?php _e('If the Friendly URI is activated, use this Callback URI', 'ultimate_social_login') ?>.</span>
                            </span>
                        
                            <span class="code-block">
                                <strong><?php _e('Callback URI:', 'ultimate_social_login') ?></strong> <span class="php-function-data"><?php echo osc_base_url() . 'ultimate_social_login/connect?hauth.done=Yandex';?></span>
                            </span>
                        </p>
                        
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>yandex/yx-1.png" /></p>
                        
                        <p class="info_item">2. <?php _e('On the next page copy your <ins>ID</ins> and <ins>Password</ins>', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>yandex/yx-2.png" /></p>
                        
                        <p class="info_item">3. <?php _e('Go back to <ins><strong>Ultimate Social Login</strong> Cofiguration</ins> and paste copied <strong>ID</strong> and <strong>Password</strong> into the fields like on the screenshot', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>yandex/yx-3.png" /></p>
                        
                        <p class="info_item">4. <?php _e('Click', 'ultimate_social_login') ?> <strong>"<?php _e('Save Changes', 'ultimate_social_login') ?>"</strong> <?php _e('and enjoyed Yandex Login', 'ultimate_social_login') ?>.</p>
                        <p class="info_item"><img class="large-img" src="<?php echo USL_ADM_IMG?>yandex/yx-4.png" /></p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
! function(i) {
  var o, n;
  i(".title_block").on("click", function() {
    o = i(this).parents(".accordion_item"), n = o.find(".info"),
      o.hasClass("active_block") ? (o.removeClass("active_block"),
        n.slideUp()) : (o.addClass("active_block"), n.stop(!0, !0).slideDown(),
        o.siblings(".active_block").removeClass("active_block").children(
          ".info").stop(!0, !0).slideUp())
  })
}(jQuery);
</script>