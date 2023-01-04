<?php
    /*
     *       Hero Responsive Osclass Themes
     *       
     *       Copyright (C) 2017 OSCLASS.me
     * 
     *       This is Hero Osclass Themes with Single License
     *  
     *       This program is a commercial software. Copying or distribution without a license is not allowed.
     *         
     *       If you need more licenses for this software. Please read more here <http://www.osclass.me/osclass-me-license/>.
     */
?>
<style>
body{
    background-color: #<?php echo osc_get_preference('back-color', 'hero'); ?>;
}
a, button.mami.btn.btn-default.dropdown-toggle, li#sks a{
    color:#<?php echo osc_get_preference('a-color', 'hero'); ?>;
}
button.navbar-toggle.collapsed i, .navbar-default .navbar-nav > li > a, h2.harga {
    color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
}
.navbar-default .navbar-toggle .icon-bar, span.icon-bar {
    background-color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
}
li.dropdown i, .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus{
    color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
}
.putih{ color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
}
.footes, .footes li a, a.navbar-brand, .navbar-nav>li>a, .links>a, div#footer-copyright, .iconbox-wrap, .dropdown-menu>li>a, .bima, .footer-nav .nav-title, .footer-nav .nav-item > a, .footer-copyright {
    color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
}
.user_type {
    border-bottom: #<?php echo osc_get_preference('theme-color', 'hero'); ?> 3px solid;
}
.list .user_type .all {
    color: #<?php echo osc_get_preference('a-color', 'hero'); ?>;
}
.breadcrumb a {
    color: #<?php echo osc_get_preference('a-color', 'hero'); ?>;
}
.list .user_type span:hover, .red{
    background: #<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
#footerme, .footer{
color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
    background: #<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
.satus {
    border-bottom: #<?php echo osc_get_preference('theme-color', 'hero'); ?> 1px dashed;
}
.list .user_type .personal, .list .user_type .firm{
    color:#<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
.navbar-default .navbar-toggle {
    border-color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
    background: #<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
    border-color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
    background: #<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
.show-more, .show-less, .show-mores, .show-lesss{
    color: #<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
.lias img, img.lazyOwl {
    border: #e2e2e2 1px solid;
}
.dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover {
  color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
}
#footer{
    color:#555;
}
.pull-right span small, .caption strong, .caption p, .ari h2, .col-md-9.text.kat1 strong, .thumbnail .caption, .well-sm strong, .product-price h2, .pricetext, .warnae, .warnas {
    color: #<?php echo osc_get_preference('b-color', 'hero'); ?>;
}
.pages li {
    list-style: none;
}
.navbar, .navbar-default,
.dropdown-menu > li > a:focus, .dropdown-menu > .active > a,
.dropdown-menu > .active > a:hover,
.dropdown-menu > .active > a:focus, .nav-pills > li.active > a,
.nav-pills > li.active > a:hover,
.nav-pills > li.active > a:focus, .label-primary, .badge, .progress-bar, .list-group-item.active,
.list-group-item.active:hover,
.list-group-item.active:focus, .panel-primary > .panel-heading, .breadcrumb_wrapper, #breadcrumb_wrapper, div#footer-copyright, .iconbox-wrap, .cursor1 span.badge, header#top, .menu-hero2, .subMenu.smint.fxd, .dropdown-menu{
    background: #<?php echo osc_get_preference('theme-color', 'hero'); ?>;
    border-color: transparent;
}
.dropdown-menu > li > a:hover{
}
.icon-box a {
    font-size:40px;
    border: none;
}
.ribbonse, .ribbons {
    color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
    background: #<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
.pagination>li>a, .pagination>li>span, .box h4, h3.title, .panel-default>.panel-heading, .warna, li.manis a:hover {
    color: #<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
h1, h2, h3, h4, h5, h6{
    color:#<?php echo osc_get_preference('h1-color', 'hero'); ?>;
}
.btn-primary.active,.btn-primary:active, .btn-primary.focus, .btn-primary:focus, .btn-primary{background-color:#<?php echo osc_get_preference('primary-color', 'hero'); ?>;border-color:#<?php echo osc_get_preference('primary-color', 'hero'); ?>;
}
.btn-primary:active:hover,.btn-primary:hover{background-color:#<?php echo osc_get_preference('primaryh-color', 'hero'); ?>;border-color:#<?php echo osc_get_preference('primaryh-color', 'hero'); ?>;
}
.btn-success:active, .btn-success.focus, .btn-success:focus, .btn-success{background-color:#<?php echo osc_get_preference('green-color', 'hero'); ?>;border-color:#<?php echo osc_get_preference('green-color', 'hero'); ?>;
}
.btn-success:active:hover,.btn-success:hover{background-color:#<?php echo osc_get_preference('greenh-color', 'hero'); ?>;border-color:#<?php echo osc_get_preference('greenh-color', 'hero'); ?>;
}
a.publish{
    background-color: #<?php echo osc_get_preference('green-color', 'hero'); ?>;
}
.navbar-default .navbar-nav>li>a.publish:focus, .navbar-default .navbar-nav>li>a.publish:hover, .nav .open>a.publish:focus, .nav .open>a.publish:hover, .nav>li>a.publish:focus, .nav>li>a.publish:hover{
    background-color: #<?php echo osc_get_preference('greenh-color', 'hero'); ?>;
}
.btn-warning.active,.btn-warning:active, .btn-warning.focus, .btn-warning:focus, .btn-warning{background-color:#<?php echo osc_get_preference('yellow-color', 'hero'); ?>;border-color:#<?php echo osc_get_preference('yellow-color', 'hero'); ?>;
}
.btn-warning:active:hover,.btn-warning:hover{background-color:#<?php echo osc_get_preference('yellowh-color', 'hero'); ?>;border-color:#<?php echo osc_get_preference('yellowh-color', 'hero'); ?>;
}
.btn-info:active:hover,.btn-info.active,.btn-info:active, .btn-info.focus, .btn-info:focus, .btn-info{background-color:#<?php echo osc_get_preference('blue-color', 'hero'); ?>;border-color:#<?php echo osc_get_preference('blue-color', 'hero'); ?>;
}
.btn-info:hover{background-color:#<?php echo osc_get_preference('blueh-color', 'hero'); ?>;border-color:#<?php echo osc_get_preference('blueh-color', 'hero'); ?>;
}
.btn-danger.active,.btn-danger:active, .btn-danger.focus, .btn-danger:focus, .btn-danger{background-color:#<?php echo osc_get_preference('red-color', 'hero'); ?>;border-color:#<?php echo osc_get_preference('red-color', 'hero'); ?>;
}
.btn-danger:active:hover,.btn-danger:hover{background-color:#<?php echo osc_get_preference('redh-color', 'hero'); ?>;border-color:#<?php echo osc_get_preference('redh-color', 'hero'); ?>;
}
a.watchlist {
    background-color:#<?php echo osc_get_preference('blue-color', 'hero'); ?>;
}
a.watchlist:hover {
    text-decoration: none;background-color:#<?php echo osc_get_preference('blueh-color', 'hero'); ?>;
}
.catalog{
    border-bottom: #<?php echo osc_get_preference('theme-color', 'hero'); ?> 1px dashed;
}
h1.manisa{
    color:#<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
p.leader {
  color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
}
.beautiful, .cd-top.cd-is-visible{
    border:#ddd 1px solid;
    background-color:#<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
.box h4 {
    border-bottom: 2px solid #<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
.list .user_type .active{
    color: #<?php echo osc_get_preference('a2-color', 'hero'); ?>;
    background: #<?php echo osc_get_preference('theme-color', 'hero'); ?>;
}
.navigasi{
    padding:10px;
    text-align:center;
}
<?php if(osc_get_preference('header-vera', 'hero') == "header1") { ?>
body{
    padding-top:70px;
}
<?php } else { ?>
<?php }  ?>
<?php if(osc_get_preference('single-vera', 'hero') == "single3") { ?>
.even {
  border: #E2E2E2 1px solid;
  margin-top: 1px;
}
.komen{display:none;
}
img.irmacinta {
  background: #fff;
}
label {
    margin-top: 15px;
}
img#zoom_03 {
  width: 100%;
}
.nav-tabs {
  border: 1px solid #ddd;
}
.radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"] {
  position: absolute;
  margin-left: 10px;
  margin-top: 5px;
}
.panel {
  margin-bottom: 21px;
  background-color: #ffffff;
  border: 1px solid rgb(221, 221, 221);
}

img#zoom_03 {
  width: 100%;
}
span.price {
  float: right;
  font-weight: bold;
}
<?php } else { ?>
<?php }  ?>
<?php if(osc_get_preference('header-vera', 'hero') == "header3") { ?>
a#logo.navbar-brand img {
    max-height: 40px;
}
div#header {
    margin-bottom: 15px;
}
body {
        padding-top: 70px;
}
nav#menu {
    display: none;
}
<?php } else { ?>
<?php }  ?>
<?php if(osc_get_preference('status-font', 'hero') == "standart") { ?>
body, .tuxedo-menu ul li a, .tuxedo-menu ul li h1, .thumbnail .caption, h1, h2, h3, h4, h5, h6, .listings h2 a, .listing-attr .currency-value, input[type=text], input[type=password], textarea, select, div.fancy-select div.trigger, .main-search label {
    font-family: <?php echo osc_get_preference('ari-font', 'hero'); ?>, Helvetica, sans-serif;
}
<?php } else { ?>
body, .tuxedo-menu ul li a, .tuxedo-menu ul li h1, .thumbnail .caption, h1, h2, h3, h4, h5, h6, .listings h2 a, .listing-attr .currency-value, input[type=text], input[type=password], textarea, select, div.fancy-select div.trigger, .main-search label {
    font-family: '<?php echo osc_get_preference('google_fonts', 'hero_theme'); ?>', sans-serif;
}
<?php } ?>
<?php echo osc_get_preference('address-us', 'hero'); ?>
</style>