<?php


/*
Theme Name: bender
Theme URI: https://osclass-classifieds.com/
Description: <%- pkg.description %>
Version: <%- pkg.version %>
Author: <%- pkg.author %>
Author URI: https://osclass-classifieds.com/
Widgets:  header, footer
Theme update URI: bender
*/

    function bender_theme_info() {
        return array(
             'name'        => 'bender'
            ,'version'     => '<%- pkg.version %>'
            ,'description' => '<%- pkg.description %>'
            ,'author_name' => '<%- pkg.author %>'
            ,'author_url'  => 'http://osclass'
            ,'locations'   => array()
        );
    }

?>