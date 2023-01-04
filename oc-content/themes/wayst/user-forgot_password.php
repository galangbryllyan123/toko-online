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

    // meta tag robots
    osc_add_hook('header','wayst_nofollow_construct');

    wayst_add_body_class('login');
    osc_current_web_theme_path('header.php');
?>

<body class="wayst">
            <?php osc_current_web_theme_path('common/rtop-menu2.php') ; ?>
            
            <!-- initiate page content -->
            
            <div class="container page-content login-page">
                                                                
        <ul class="nav nav-tabs">
            <li class="active"><a href="#login" data-toggle="tab"><?php _e('Recover your password', 'wayst'); ?></a></li>
            
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="login">
            <div class="alert alert-dismissable alert-info"><div class="text-center"><?php _e("Forgot password?", 'wayst'); ?> <?php _e('Recover your password', 'wayst'); ?>!</div></div>
            <form class="form-horizontal" action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="login" />
            <input type="hidden" name="action" value="forgot_post" />
            <input type="hidden" name="userId" value="<?php echo osc_esc_html(Params::getParam('userId')); ?>" />
            <input type="hidden" name="code" value="<?php echo osc_esc_html(Params::getParam('code')); ?>" />
                                    <div class="form-group">
                        <label for="EmailAddress" class="col-sm-3 control-label"><?php _e('New password', 'wayst'); ?></label>
                        <div class="col-sm-8">
                                                         <input class="form-control" type="password" name="new_password" value="" autocomplete="off" required="required" />   
                                                                                    </div>
                                            </div>
                                    <div class="form-group">
                        <label for="Password" class="col-sm-3 control-label"><?php _e('Repeat new password', 'wayst'); ?></label>
                        <div class="col-sm-8">
                                                        <input class="form-control" type="password" name="new_password2" value="" autocomplete="off" required="required" />
                                                                                    </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="Password" class="col-sm-3 control-label"></label>
                                            <div class="col-sm-8">
                        <?php osc_show_recaptcha('recover_password'); ?>
                                            </div> </div>
                                    
                            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-save btn-lg"><i class="fa fa-pencil"></i> <?php _e("Change password", 'wayst');?></button>
                </div>
            </div>
        </form>                        
            </div>
            
        </div>        
                                    </div>
                                                  
            <?php osc_current_web_theme_path('common/rtop-menu.php') ; ?>
                        
            <?php osc_current_web_theme_path('common/rfooter.php') ; ?>
                            

        
        </body></html>