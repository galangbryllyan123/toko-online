<nav class="navbar-collapse collapse" id="navbar-collapse-1">
            <div class="navbar navbar-inverse navbar-fixed-left in-dept" id="navbar-left">
                <div class="navbar-header nav-stacked text-center">
                    <?php echo logo_header(); ?>
                </div>

                <ul class="nav navbar-nav nav-stacked dept-menu">
                    <li class="">
                        <a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))); ?>"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <!--< ?php echo osc_highlight( strip_tags( osc_page_title() ), 17 ); ? >--> <?php _e('All categories', 'wayst'); ?></a>
                    </li>
                                            
                                        <li>
                        <!-- without droptdown --><ul class="nav navbar-nav nav-stacked ">
 <?php
         osc_goto_first_category();
         $i= 0;
         while ( osc_has_categories() ) {
            $liClass = '';
            if($i%3 == 0){
                $liClass = 'clear';
            }
            $i++;
         ?>
                            <li class="">
                                <a class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><i class="fa fa-fw fa-folder-open-o" aria-hidden="true"></i> <?php echo osc_category_name() ; ?></a>
                               
                                
                            </li> <?php } ?>
                        </ul> 
                    </li>
                </ul>

                                    <ul class="nav navbar-nav nav-stacked filter-menu">
                      
                        
                        <li class="dropdown-submenu">
                        <ul class="dropdown-subsubmenu nav navbar-nav nav-stacked">
                            <li>
                            <a href="javascript:;"><i class="fa fa-globe"></i> <?php _e('Listing Location', 'wayst'); ?></a>
                            </li>
                           
                        </ul>
                    </li>
                    </ul>
                    
                <ul class="nav navbar-nav nav-stacked secondary-menu">
                <div class="form-group">
                <select class="form-control" name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
                <option value=""><?php _e('Country', 'wayst'); ?></option>
                 <?php if(osc_count_list_countries() > 0 ) { ?>
     <?php while(osc_has_list_countries() ) { ?>
									 <option value="<?php echo osc_esc_html(osc_list_country_url()); ?>"><?php echo osc_list_country_name(); ?> (<?php echo osc_list_country_items(); ?>)</option>						
 <?php } ?><?php } ?>
                    
            </select>
                
            </div>
            <div class="form-group"> <select class="form-control" name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
                <option value=""><?php _e('City', 'wayst'); ?></option>
                 <?php if(osc_count_list_regions() > 0 ) { ?>
     <?php while(osc_has_list_regions() ) { ?>
									 <option value="<?php echo osc_esc_html(osc_list_region_url()); ?>"><?php echo osc_list_region_name(); ?> (<?php echo osc_list_region_items(); ?>)</option>						
 <?php } ?><?php } ?>
                    
            </select> </div>
               
                </ul>
            </div>
        </nav>
                            <nav class="navbar navbar-default navbar-fixed-top searchbar">
            <div class="searchbar-nav" role="search">
                <div class="searchbar-items">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="brand"><?php echo osc_highlight( strip_tags( osc_page_title() ), 15 ); ?></span>                    </button>
                </div>

                <form class="navbar-form search nocsrf" method="get" action="<?php echo osc_base_url(true); ?>" id="search-form" <?php /* onsubmit="javascript:return doSearch();"*/ ?>>
                <input type="hidden" name="page" value="search"/>

                                        <div class="input-group">
                        <div class="form-control">
                            <div class="searchbar-inputs">                                <span class="twitter-typeahead" style="position: relative; display: inline-block;"><input type="text" value="" aria-label="Search Text" itemprop="query-input" class="tt-hint" readonly="" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255);"><input placeholder="<?php echo osc_esc_html(osc_get_preference('keyword_placeholder', 'wayst') ); ?>" type="text" name="sPattern" value="" id="search" aria-label="Search Text" itemprop="query-input" required="required" class="tt-input" autocomplete="off" spellcheck="false" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-search"></div></div></span>
                               <?php  if ( osc_count_categories() ) { ?>
                                <span class="search-suffix">
                                    
                                        <?php osc_categories_select('sCategory', null, __('Select a category', 'wayst')) ; ?>
                                </span> <?php  } else { ?> <?php  } ?>                           </div>
                        </div>
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-search" type="submit" aria-label="Search"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </span>                    </div>
                </form>

                       <?php if( osc_users_enabled() ) { ?>
            <?php if( osc_is_web_user_logged_in() ) { ?> <ul class="nav navbar-right hidden-xs">
            <li class="dropdown">
                <a class="dropdown-toggle btn btn-default" href="<?php echo osc_user_profile_url(); ?>" role="button" id="login-menu-button">
                    <i class="fa fa-cog fa-lg" aria-hidden="true"></i> <?php _e('Dashboard', 'wayst'); ?></a>
                
            </li>
        </ul>
        
        <?php } else { ?>
        <ul class="nav navbar-right hidden-xs">
            <li class="dropdown">
                <a class="dropdown-toggle btn btn-default" data-toggle="dropdown" role="button" id="login-menu-button">
                    <i class="fa fa-user fa-lg" aria-hidden="true"></i>  Hi Guest! <span class="caret"></span>                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="login-menu-button">
                    <li><a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'wayst') ; ?></a></li>
                    <li><a href="<?php echo osc_register_account_url() ; ?>"><?php _e('Register for a free account', 'wayst'); ?></a></li>
                </ul>
            </li>
        </ul>
        
            <?php } ?>
            <?php } ?>
                    </div>
        </nav>
                        