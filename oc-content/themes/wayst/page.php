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

    wayst_add_body_class('custom');
?>
<?php osc_current_web_theme_path('header.php') ; ?>

<body class="wayst">
            <?php osc_current_web_theme_path('common/rtop-menu2.php') ; ?>
            
            <div align="center"><?php osc_show_widgets('header'); ?></div>
            
            <!-- initiate page content -->
            <div class="container page-content ">
                                                                        <h1><?php echo osc_static_page_title(); ?></h1>
        <article class="block-text terms">
            <p><?php echo osc_static_page_text(); ?></p>        </article>
                        <div class="clearfix"></div>            </div>                           
            <!-- end page content -->
            
            <?php osc_current_web_theme_path('common/rtop-menu.php') ; ?>
                        
            <?php osc_current_web_theme_path('common/rfooter.php') ; ?>
                            

        
        </body></html>