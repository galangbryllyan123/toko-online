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
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('admin/css/jquery.switchButton.css');?>">
<h3>Wayst Documentation: <a href="<?php echo osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'); ?>" target="_blank">click here to read online documentation</a>.</h3>
<?php if( (!defined('MULTISITE') || MULTISITE==0)&& !osc_get_preference('footer_link', 'wayst') && !osc_get_preference('donation', 'wayst') ) { ?>
<form name="_xclick" action="https://www.paypal.com/in/cgi-bin/webscr" method="post" class="nocsrf">
    <input type="hidden" name="cmd" value="_donations">
    <input type="hidden" name="rm" value="2">
    <input type="hidden" name="business" value="info@osclass.org">
    <input type="hidden" name="item_name" value="Osclass project">
    <input type="hidden" name="return" value="http://osclass.org/paypal/">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="US" />
    <input type="hidden" name="custom" value="<?php echo osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'); ?>&donation=successful&source=wayst">
    <div id="flashmessage" class="flashmessage flashmessage-inline flashmessage-warning" style="color: #505050; display: block; ">
        <p><?php _e('I would like to contribute to the development of Osclass with a donation of', 'wayst'); ?> <select name="amount" class="select-box-medium">
            <option value="50">50$</option>
            <option value="25">25$</option>
            <option value="10" selected>10$</option>
            <option value="5">5$</option>
            <option value=""><?php _e('Custom', 'wayst'); ?></option>
        </select><input type="submit" class="btn btn-mini" name="submit" value="<?php echo osc_esc_html(__('Donate', 'wayst')); ?>"></p>
    </div>
</form>
<?php } ?>


<div id="content-page">
                <div class="grid-system">
                    <div class="grid-row grid-first-row grid-100">
                        <div class="row-wrapper ">
<div id="tabs" class="ui-osc-tabs ui-tabs-right">
    <ul><li><a href="#2">Footer links</a></li>
    <li><a href="#1">Homepage Message</a></li>
    <li><a href="#3">Listings/Slider Homepage</a></li>
    <li><a href="#4">Banner Homepage</a></li>
                <li><a href="#update-plugins">Ads Management</a></li>
                <li><a href="#market">Social Network</a></li>
        <li><a href="#upload-plugins"><?php _e('Theme settings', 'wayst'); ?></a></li>
    </ul>
    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/wayst/admin/settings.php'); ?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="settings" />
    <div id="upload-plugins">
    <h2 class="render-title"><strong><?php _e('Theme settings', 'wayst'); ?></strong></h2>
        <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Search placeholder', 'wayst'); ?></div>
                <div class="form-controls"><input type="text" class="xlarge" name="keyword_placeholder" value="<?php echo osc_esc_html( osc_get_preference('keyword_placeholder', 'wayst') ); ?>"></div>
            </div>
            
            
            <?php if(!defined('MULTISITE') || MULTISITE==0) { ?>
            <div class="form-row">
                <div class="form-label"><?php _e('Footer link', 'wayst'); ?></div>
                <div class="form-controls">
                    <div class="form-label-checkbox"><input type="checkbox" name="footer_link" value="1" <?php echo (osc_get_preference('footer_link', 'wayst') ? 'checked' : ''); ?> > <?php _e('I want to help Osclass by linking to <a href="http://osclass.org/" target="_blank">osclass.org</a> from my site with the following text:', 'wayst'); ?></div>
                    <span class="help-box"><?php _e('This website is proudly using the <a title="Osclass web" href="http://osclass.org/">classifieds scripts</a> software <strong>Osclass</strong>', 'wayst'); ?></span>
                </div>
            </div>
            <?php } ?>
        </div>
    </fieldset>

    <h2 class="render-title"><?php _e('Location input', 'wayst'); ?></h2>
    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Show location input as:', 'wayst'); ?></div>
                <div class="form-controls">
                    <select name="defaultLocationShowAs">
                        <option value="dropdown" <?php if(wayst_default_location_show_as() == 'dropdown'){ echo 'selected="selected"' ; } ?>><?php _e('Dropdown','wayst'); ?></option>
                        <option value="autocomplete" <?php if(wayst_default_location_show_as() == 'autocomplete'){ echo 'selected="selected"' ; } ?>><?php _e('Autocomplete','wayst'); ?></option>
                    </select>
                </div>
            </div>
        </div>
    </fieldset>
    <br />
    <h2 class="render-title"><?php _e('Contacts', 'wayst'); ?></h2>
    <div class="form-row">
                <div class="form-label"><?php _e('Example: Street / Location / Mobile/Phone', 'wayst'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 85px; width: 500px;" name="contact-text" placeholder="Example: A superb place.
3102 Highway 98
Mexico Beach, FL
Phone: 850-648-4200"><?php echo osc_get_preference('contact-text', 'wayst') ; ?></textarea>
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
            <br />
            <h2 class="render-title"><?php _e('Help', 'wayst'); ?> and <?php _e('Useful information', 'wayst'); ?></h2>
    <div class="form-row">
                <div class="form-label"><?php _e('Write here any help and useful information for your visitors. HTML format is accepted. See below example.', 'wayst'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 85px; width: 500px;" name="help-text" placeholder="<strong>For sellers.</strong> <br/> 1. When you publish any listing, we recommend to login with your details. If you don't have an account on our website, please feel free to register a new account for free. <br />2. In the ad use a picture, title and description to better describe your product that you sell. <br />3. Use your active e-mail and correct phone number. <br /> <strong>For buyers.</strong> <br />1. Avoid scams by acting locally or paying with PayPal. <br /> 2. Never pay with Western Union, Moneygram or other anonymous payment services. <br /> 3. Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country. <br /> 4. This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer 'buyer protection' or 'seller certification'."><?php echo osc_get_preference('help-text', 'wayst'); ?></textarea>
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
        
    </div>
        <div id="update-plugins">
                <h2 class="render-title"><?php _e('Ads management', 'wayst'); ?></h2>
    <div class="form-row">
        <div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e('In this section you can configure your site to display ads and start generating revenue.', 'wayst'); ?><br/><?php _e('If you are using an online advertising platform, such as Google Adsense, copy and paste here the provided code for ads.', 'wayst'); ?> <br /> Personalized images with a link should be like this:<strong> "&lt;a href="#"&gt;&lt;img src="http://yourwebsite.com/images/ads.jpg" /&gt;&lt;/a&gt;"</strong></p>
        </div>
    </div>
    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Header 728x90', 'wayst'); ?> leaderboard</div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;"name="header-728x90"><?php echo osc_esc_html( osc_get_preference('header-728x90', 'wayst') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Wide skyscraper 160x600', 'wayst'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="homepage-728x90"><?php echo osc_esc_html( osc_get_preference('homepage-728x90', 'wayst') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Ad format 468x60', 'wayst'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="search-results-top-728x90"><?php echo osc_esc_html( osc_get_preference('search-results-top-728x90', 'wayst') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label"><?php _e('Ad size 120x600 (left on search page)', 'wayst'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="search-results-middle-728x90"><?php echo osc_esc_html( osc_get_preference('search-results-middle-728x90', 'wayst') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div> 
            
            <div class="form-row">
                <div class="form-label"><?php _e('Medium rectangle 300x250', 'wayst'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="sidebar-300x250"><?php echo osc_esc_html( osc_get_preference('sidebar-300x250', 'wayst') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
            <!-- personalized --></div></fieldset>
    </div>
        <div id="market">
        <h2 class="render-title"><?php _e('Social network', 'wayst'); ?></h2>
    <div class="form-row">
        <div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e('In this section you can configure your social network.', 'wayst'); ?></p>
        </div>
    </div>
    <fieldset>
        <div class="form-horizontal">
            
            <div class="form-row">
                <div class="form-label"><?php _e('Facebook', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="facebook-top" value="<?php echo osc_esc_html( osc_get_preference('facebook-top', 'wayst') ); ?>" > Example: http://www.facebook.com/bigiolush
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label"><?php _e('Twitter', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="twitter-top" value="<?php echo osc_esc_html( osc_get_preference('twitter-top', 'wayst') ); ?>" > Example: http://www.twitter.com/bigiolush
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label"><?php _e('Google plus', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="google-plus-top" value="<?php echo osc_esc_html( osc_get_preference('google-plus-top', 'wayst') ); ?>" > Example: https://plus.google.com/112339814309990308923
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label"><?php _e('Youtube', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="youtube-top" value="<?php echo osc_esc_html( osc_get_preference('youtube-top', 'wayst') ); ?>" > Example: https://www.youtube.com/user/mishu22able
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label"><?php _e('Skype', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="skype-top" value="<?php echo osc_esc_html( osc_get_preference('skype-top', 'wayst') ); ?>" > Example: bigiolush
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label"><?php _e('Email', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="email-top" value="<?php echo osc_esc_html( osc_get_preference('email-top', 'wayst') ); ?>" > Example: admin@example.com
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div></div></fieldset>
    </div>
    <div id="1">
         <h2 class="render-title"><?php _e('Homepage message', 'wayst'); ?></h2>
    <div class="form-row">
        <div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e('In this section you can configure message that appears only on homepage under top menu. 
You can display a messages for your visitors to publish an ad. ;)', 'wayst'); ?><br/></p>
        </div>
    </div>
    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Message', 'wayst'); ?>*:</div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="homepage-block1" placeholder="Post a free ad in under 60 seconds" value="<?php echo osc_esc_html( osc_get_preference('homepage-block1', 'wayst') ); ?>" > Link name (optional):  <input type="text" class="xlarge" name="homepage-block2" placeholder="Get enquiries and make cash" value="<?php echo osc_esc_html( osc_get_preference('homepage-block2', 'wayst') ); ?>" > Link (optional): <input type="text" class="xlarge" name="homepage-block1l" value="<?php echo osc_esc_html( osc_get_preference('homepage-block1l', 'wayst') ); ?>" >
                    <br/><br/>
                    <div class="help-box"></div>
                </div>
            </div>
                        
            </div></fieldset>
    </div>
    <div id="2">
        <h2 class="render-title"><?php _e('Footer', 'wayst'); ?> links</h2>
    <div class="form-row">
        <div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e('In this section you can configure up to 6 links.', 'wayst'); ?><br/></p>
        </div>
    </div>
    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Title', 'wayst'); ?>:</div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="footer-partners" placeholder="Partners" value="<?php echo osc_esc_html( osc_get_preference('footer-partners', 'wayst') ); ?>" >
                    
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label"><?php _e('Name 1', 'wayst'); ?>:</div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="footer-partners1" placeholder="www.google.com" value="<?php echo osc_esc_html( osc_get_preference('footer-partners1', 'wayst') ); ?>" > Link 1: <input type="text" class="xlarge" name="footer-partnersl1" placeholder="http://www.google.com" value="<?php echo osc_esc_html( osc_get_preference('footer-partnersl1', 'wayst') ); ?>" >
                    
                </div>
            </div>
            
           
            
            <div class="form-row">
                <div class="form-label"><?php _e('Name 2', 'wayst'); ?>:</div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="footer-partners2" placeholder="www.facebook.com" value="<?php echo osc_esc_html( osc_get_preference('footer-partners2', 'wayst') ); ?>" > Link 2: <input type="text" class="xlarge" name="footer-partnersl2" placeholder="http://www.facebook.com" value="<?php echo osc_esc_html( osc_get_preference('footer-partnersl2', 'wayst') ); ?>" >
                    
                </div>
            </div>
            
            
            <div class="form-row">
                <div class="form-label"><?php _e('Name 3', 'wayst'); ?>:</div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="footer-partners3" placeholder="www.wikipedia.org" value="<?php echo osc_esc_html( osc_get_preference('footer-partners3', 'wayst') ); ?>" > Link 3: <input type="text" class="xlarge" name="footer-partnersl3" placeholder="http://www.wikipedia.org" value="<?php echo osc_esc_html( osc_get_preference('footer-partnersl3', 'wayst') ); ?>" >
                    
                </div>
            </div>
           
            
            
            <div class="form-row">
                <div class="form-label"><?php _e('Name 4', 'wayst'); ?>:</div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="footer-partners4" placeholder="www.osclass.org" value="<?php echo osc_esc_html( osc_get_preference('footer-partners4', 'wayst') ); ?>" > Link 4: <input type="text" class="xlarge" name="footer-partnersl4" placeholder="http://www.osclass.org" value="<?php echo osc_esc_html( osc_get_preference('footer-partnersl4', 'wayst') ); ?>" >
                    
                </div>
            </div>
            
           
            
            <div class="form-row">
                <div class="form-label"><?php _e('Name 5', 'wayst'); ?>:</div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="footer-partners5" placeholder="www.stackowerflow.com" value="<?php echo osc_esc_html( osc_get_preference('footer-partners5', 'wayst') ); ?>" > Link 5: <input type="text" class="xlarge" name="footer-partnersl5" placeholder="http://www.stackowerflow.com" value="<?php echo osc_esc_html( osc_get_preference('footer-partnersl5', 'wayst') ); ?>" >
                   
                </div>
            </div>
            
            
            
            <div class="form-row">
                <div class="form-label"><?php _e('Name 6', 'wayst'); ?>:</div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="footer-partners6" placeholder="www.paypal.com" value="<?php echo osc_esc_html( osc_get_preference('footer-partners6', 'wayst') ); ?>" > Link 6: <input type="text" class="xlarge" name="footer-partnersl6" placeholder="http://www.paypal.com" value="<?php echo osc_esc_html( osc_get_preference('footer-partnersl6', 'wayst') ); ?>" >
                   
                </div>
            </div></div></fieldset>
    </div>
    <div id="3">
         <h2 class="render-title"><?php _e('Listings on Slider by category on homepage', 'wayst'); ?></h2>
    <div class="form-row">
        <div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e('In this section you can configure to display listings on slider by category name.', 'wayst'); ?><br/>Please note that <strong>category name</strong> need to be in <strong>english</strong> and is required to be a <strong>slug</strong> format, for example, in box: <strong>"Category for slider"</strong> you need to write your desired category name, for example: <strong>"for-sale"</strong>, in a second box for: <strong>"name to show"</strong> you can write simply: <strong>"For sale"</strong>, or translated in your language.</p>
        </div>
    </div>
    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Category for slider 1', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="slidercatname1" placeholder="for-sale" value="<?php echo osc_esc_html( osc_get_preference('slidercatname1', 'wayst') ); ?>" > Name to show: <input type="text" class="xlarge" name="slidercatname1m" placeholder="For sale" value="<?php echo osc_esc_html( osc_get_preference('slidercatname1m', 'wayst') ); ?>" >
                   
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label"><?php _e('Category for slider 2', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="slidercatname2" placeholder="real-estate" value="<?php echo osc_esc_html( osc_get_preference('slidercatname2', 'wayst') ); ?>" > Name to show: <input type="text" class="xlarge" name="slidercatname2m" placeholder="Real estate" value="<?php echo osc_esc_html( osc_get_preference('slidercatname2m', 'wayst') ); ?>" >
                   
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label"><?php _e('Category for slider 3', 'wayst'); ?></div>
                <div class="form-controls">
                    <input type="text" class="xlarge" name="slidercatname3" placeholder="services" value="<?php echo osc_esc_html( osc_get_preference('slidercatname3', 'wayst') ); ?>" > Name to show: <input type="text" class="xlarge" name="slidercatname3m" placeholder="Services" value="<?php echo osc_esc_html( osc_get_preference('slidercatname3m', 'wayst') ); ?>" >
                   
                </div>
            </div>
           
          
            
            </div></fieldset>
    </div>
    
    <div class="form-actions">
                <input type="submit" value="<?php _e('Save changes', 'wayst'); ?>" class="btn btn-submit">
            </div>
        
</form>
<div id="4">
<h2 class="render-title"><strong><?php _e('Homepage banner', 'wayst'); ?></strong></h2><br />
In this section you can upload one image. This image will appear on home page. <br />
<strong>Recommended sizes: width: 390px, height: 390px</strong><br /><br /><br />
<?php include 'homeimage1.php'; ?>
    </div>
</div>

<script>
    $(function() {
        var tab_id = decodeURI(self.document.location.hash.substring(1));
        if(tab_id != '') {
            $( "#tabs" ).tabs({ active: 0 });
            $('html, body').animate({scrollTop:0}, 'slow');
        } else {
            $( "#tabs" ).tabs({ active: -1 });
        }

        $("#market_cancel").on("click", function(){
            $(".ui-dialog-content").dialog("close");
            return false;
        });

        $("#market_install").on("click", function(){
            $(".ui-dialog-content").dialog("close");
            $('<div id="downloading"><div class="osc-modal-content"></div></div>').dialog({title:'',modal:true});
            $.getJSON(
            "",
            {"code" : $("#market_code").attr("value"), "section" : 'plugins'},
            function(data){
                var content = data.message;
                if(data.error == 0) { // no errors
                    content += '<p></p>';
                    content += "<p>";
                    content += '<a class="btn btn-mini btn-green" href=""></a>';
                    content += "</p>";
                } else {
                    content += '<a class="btn btn-mini btn-green" onclick=\'$(".ui-dialog-content").dialog("close");\'></a>';
                }
                $("#downloading .osc-modal-content").html(content);
            });
            return false;
        });
    });

    $('.market-popup').on('click',function(){
        $.getJSON(
            "",
            {"code" : $(this).attr('href').replace('#',''), 'section' : 'plugins'},
            function(data){
                if(data!=null) {
                    $("#market_thumb").attr('src',data.s_thumbnail);
                    $("#market_code").attr("value", data.s_update_url);
                    $("#market_name").html(data.s_title);
                    $("#market_version").html(data.s_version);
                    $("#market_author").html(data.s_contact_name);
                    $("#market_url").attr('href',data.s_source_file);
                    $('#market_install').html("Updating");

                    $('#market_installer').dialog({
                        modal:true,
                        title: 'Piața Osclass',
                        width:485
                    });
                }
            }
        );

        return false;
    });
    function delete_plugin(plugin) {
        var x = confirm('');
        if(x) {
            window.location = ''+plugin;
        }
    }
</script>
            </div></div><div class="clear"></div></div><!-- #grid-system -->
            </div>


