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
            <li class="active"><a href="#login" data-toggle="tab"><?php _e("Log in", 'wayst');?></a></li>
            <li><a href="#register" data-toggle="tab"><?php _e("Create", 'wayst');?></a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="login">
            <div class="alert alert-dismissable alert-info"><div class="text-center"><?php _e('Access to your account', 'wayst'); ?></div></div>
            <form action="<?php echo osc_base_url(true); ?>" class="form-horizontal" id="form" role="form" method="post" >
            <input type="hidden" name="page" value="login" />
            <input type="hidden" name="action" value="login_post" />
                                    <div class="form-group">
                        <label for="EmailAddress" class="col-sm-3 control-label"><?php _e('E-mail', 'wayst'); ?></label>
                        <div class="col-sm-8">
                                                         <input class="form-control" id="email" type="email" name="email" value="" required="required" />   
                                                                                    </div>
                                            </div>
                                    <div class="form-group">
                        <label for="Password" class="col-sm-3 control-label"><?php _e('Password', 'wayst'); ?></label>
                        <div class="col-sm-8">
                                                        <input class="form-control" id="password" type="password" name="password" value="" autocomplete="off" required="required" />
                                                                                    </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="Password" class="col-sm-3 control-label"></label>
                                            <div class="col-sm-8">
                        <label class="newsletter-checkbox">
                        <?php UserForm::rememberme_login_checkbox();?>
                             <?php _e('Remember me', 'wayst'); ?></label>
                                            </div> </div>
                                    
                            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-save btn-lg"><i class="fa fa-unlock-alt"></i> <?php _e("Log in", 'wayst');?></button> <a class="" href="<?php echo osc_recover_user_password_url(); ?>"><?php _e("Forgot password?", 'wayst'); ?></a>
                </div>
            </div>
        </form>                        
            </div>
            <div class="tab-pane" id="register">
                <a name="register"></a>
                
                <div class="alert alert-dismissable alert-info"><div class="text-center"><?php _e('Register an account for free', 'wayst'); ?></div></div>
                <form class="form-horizontal" name="register" action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="register" />
            <input type="hidden" name="action" value="register_post" />
                
                            <div class="form-group ">
                                    <label for="EmailAddress" class="col-sm-4 control-label"><?php _e('Name', 'wayst'); ?></label>
                            <div class="col-sm-8 " id="EmailAddress-column">
                            <input class="form-control" id="s_name" type="text" name="s_name" value="" required="required" />
                            
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="FirstName" class="col-sm-4 control-label"><?php _e('E-mail', 'wayst'); ?></label>
                            <div class="col-sm-8 " id="FirstName-column">
                            <input class="form-control" id="s_email" type="email" name="s_email" value="" required="required" />
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="Surname" class="col-sm-4 control-label"><?php _e('Password', 'wayst'); ?></label>
                            <div class="col-sm-8 " id="Surname-column">
                            <input class="form-control" id="s_password" type="password" name="s_password" value="" autocomplete="off" required="required" />
                            
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                    <label for="newpassword" class="col-sm-4 control-label"><?php _e('Repeat password', 'wayst'); ?></label>
                            <div class="col-sm-8 " id="newpassword-column">
                            <input class="form-control" id="s_password2" type="password" name="s_password2" value="" autocomplete="off" required="required" />
                            <p id="password-error" style="display:none;">
                        <?php _e("Passwords don't match", 'wayst'); ?>
                            
                                            </div>
                                    </div>
                                    <div class="form-group ">
                            <div class="col-sm-8 " id="confirmpassword-column">
                            <?php osc_run_hook('user_register_form'); ?>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                    <label for="newpassword" class="col-sm-4 control-label"></label>
                <div class="col-sm-8">
                    <?php osc_show_recaptcha('register'); ?>                </div>
            </div>

                        
                            <div class="form-group ">
                                    <label for="submit" class="col-sm-4 control-label"></label>
                            <div class="col-sm-8 " id="submit-column">
                            <button type="submit" name="submit" id="submit" class="btn btn-save btn-lg" value="" onClick=""><i class="fa fa-lock"></i> <?php _e("Create", 'wayst'); ?></button>
                                            </div>
                                    </div>
                </form>
                
            </div>
        </div>                    
        
                                    </div>
                                      
            <!-- end page content -->
            
            <?php osc_current_web_theme_path('common/rtop-menu.php') ; ?>
                        
            <?php osc_current_web_theme_path('common/rfooter.php') ; ?>
                            

        
        </body></html>