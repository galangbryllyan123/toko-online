<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Wayst Osclass Theme - Installation Documentation</title>
<link href="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<aside>
  <div id="nav"> <a class="logo" href="<?php osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'); ?>#home"><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/logo.png" alt="logo"></a>
    <ul>
      <li><a href="<?php osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'); ?>#overview">Theme overview</a></li>
      <li><a href="<?php osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'); ?>#install">Installation &amp; Configuration</a></li>
      <li><a href="<?php osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'); ?>#lfv">Logo and Favicon</a></li>
      <li><a href="<?php osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'); ?>#plugins">Plugins</a></li>
      <li><a href="<?php osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'); ?>#banner">Homepage Banner</a></li>
      <li><a href="<?php osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'); ?>#lsh">Listings/Slider Homepage</a></li>
      <li><a href="<?php osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'); ?>#hbl">Message on homepage</a></li>
      <li><a href="<?php osc_admin_render_theme_url('oc-content/themes/wayst/docs/index.php'); ?>#credits">Credits</a></li>
    </ul>
    <address>
    © 2017 www.themehelp.us <br>
    All Rights Reserved.
    </address>
  </div>
</aside>
<section>
  <figure id="home"><div align="center"><img align="" src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/theme.jpg"></div></figure>
  <article id="overview">
    <h2>Theme Overview</h2>
    <ul>
      <li>Responsive layout</li>
      <li>Div/Tabless HTML5 mark-up</li>
      <li>CSS 2.0 and CSS 3.0 valid</li>
      <li>Based on bootstrap framework version: 3.3.4, by <a target="_blank" href="http://getbootstrap.com/">getbootstrap</a></li>
      <li>Cross-browser compatibility. Compatible with latest versions of all major browsers such as IE, Firefox, Safari, Chrome, Opera</li>
      <li>OSclass compatibility up to: 3.7.1</li>
    </ul>
  </article>
  <article id="install">
    <h2>1. Installation &amp; Configuration</h2>
    <p> Thank you for purchasing wayst theme! In this document, you will find step-by-step instructions for installing and using wayst theme for your osclass installation.</p>
    <p class="alert"><span>To make things easy for you we have prepared the separate theme package &amp; this theme will not overwrite any files.</span></p>
   
    <h3>System Requirements</h3>
    <p> <span> Installation requirements :<br>
      PHP version: 5.x or newer / MySQL database (or access to create one) / MySQLi module for PHP / GD module for PHP </span> </p>
    <p>wayst theme is compatible up to Osclass ver. 3.7.1 which can be downloaded from <a href="http://osclass.org/page/download" target="_blank">http://osclass.org/page/download</a></p>
    <p> Before downloading the theme, make sure you meet the minimum system requirements and test the compatibility of your server.</p>
    <p> For help with installing Osclass theme, please refer to the following links: </p>
    <ul>
      <li><a href="http://osclass.org/page/get-started" target="_blank">Get-started</a></li>
      <li><a href="http://osclass.org/page/tutorials" target="_blank">Tutorials</a></li>
      <li><a href="http://static.osclass.org/installation/guide.pdf" target="_blank"> Osclass Installation Guide</a></li>
    </ul>
    <h3>Uploading wayst Theme</h3>
    <p><span><strong>Warning</strong> - Before you begin the theme installation process, we recommend you to backup your database.</span></p>
    <h4>You can either upload the theme via FTP (File Transfer Protocol) or via Osclass admin panel:</h4>
    <h3>1. Upload theme via  FTP:</h3>
    <ol>
      <li>Unzip the downloaded free theme folder.</li>
      <li>
        <p>Using the FTP client, copy the plugins and themes folders to the Osclass software's root directory. If you are working with a Mac, please make sure you are merging the new folders with Osclass and not replacing the Osclass directory.</p>
        <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/ftp.jpg" alt="ftp"></p>
      </li>
      <li>
        <p>Make sure all the files are successfully transferred to the root directory.</p>
      </li>
    </ol>
    <h3>2. To upload Osclass theme via Osclass admin panel:</h3>
    <ol>
      <li>
        <p><strong>Go to Appearance &gt; Manage Themes: and click on add new button</strong></p>
        <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/admin.jpg" alt="admin"></p>
      </li>
      <li>
        <p>A window will appear like shown in the image below and unzip the <strong>wayst.zip </strong> and upload the <strong>wayst</strong> theme file inside the <strong>wayst.zip</strong> unzipped folder.</p>
        <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/upload.jpg" alt="upload"></p>
      </li>
    </ol>
    <h3>3. To activate the theme:</h3>
    <ol>
      <li>
        <p><strong>Navigate to Appearance &gt; Manage Themes and click in Activate button to activate the theme.</strong></p>
        <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/themes.jpg" alt="themes"></p>
      </li>
    </ol>
    
    <article id="lfv">
  <h2>2. Logo and Favicon</h2>
  <p class="alert"><span><strong>Go to Appearance &gt; Header logo</strong>, choose your logo and upload it. Recommended logo size is 180px X 61px, is recommended to be .jpg format with transparent background. To change favicon, please indicate in the box, link to your favicon. Recommended favicon size is: 16px X 16px. Accepted format is: .ico, .jpg, .jpg, .gif.</p>
  <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/logofavicon.jpg" alt="Logo and Favicon"></p>
  
    
  </article>
    
    
    <h3 id="plugins">3. How to add Plugins in Osclass:</h3>
     <p><span><strong>Warning</strong> - The theme should be working with all major of plugins from osclass market. So, to install manually the plugins you need to unzip the archive and upload plugins in osclass plugins directory (http://www.yourwebsite.com/oc-content/plugins/). You only need to Upload the theme, activate it, upload the plugins in plugins directory and enable them through admin control panel, then you can configure all the settings.</span></p>
    <ol>
      <li>
        <p><strong>To install automatically plugins: Go to Plugins &gt; Manage Plugins</strong> and click in the <strong>+</strong> icon to add new plugins.</p>
        <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/new_plugin.jpg"></p>
      </li>
      <li>
        <h3>Add New Plugin:</h3>
        <p class="alert"><span>There are lots of free and premium plugins available in the osclass theme market.</span></p>
        <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/market.jpg" alt="market"></p>
      </li>
      <li>
        <p><strong>Download the plugins from the <a target="_blank" href="http://market.osclass.org/plugins">Osclass Plugin Market</a></strong> and upload the plugins via Add plugin section and enable/disable it as shown in the pic. </p>
        <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/upload_plugin.jpg" alt="upload_plugin"></p>
      </li>
    </ol>
    <h3 id="banner">4. How to change homepage banner/image:</h3>
    <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/banner1.jpg" alt="banner for dektop, small devices"></p>
    <ol>
      <li>
        <p><strong>Go to Appearance &gt; Theme settings, From tabs choose &gt; Banner Homepage</strong> and upload the new banner image from choose file option to get new banner image in the homepage. <strong>Recommended size: width: 390px, height: 390px</strong>.
</p>
        <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/banner.jpg" alt="banner"></p>
      </li>
    </ol>
    <h3 id="lsh">5. Listings on Slider by category on homepage:</h3>
    <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/arabic.jpg" alt="arabic"></p>
    <ol>
      <li>
        <p><strong>Go to Appearance &gt; Theme Settings</strong> then choose from tabs: <strong>"Listings/Slider Homepage"</strong></p>
        <p><span>In this section you can configure to display listings on slider by category name.
Please note that <strong>category name</strong> need to be in <strong>english</strong> and is required to be a <strong>slug</strong> format, for example, in box: <strong>"Category for slider"</strong> you need to write your desired category name, for example: <strong>"for-sale"</strong>, in a second box for: <strong>"name to show"</strong> you can write simply: <strong>"For sale"</strong>, or translated in your language.</span></p>
        <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/rtl.jpg" alt="rtl"></p>
      </li>
    </ol>
    <h3 id="hbl">6. Message on homepage for visitors:</h3>
    <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/wizards.jpg" alt="Blocks on homepage"></p>
    <ol>
      <li>
        <em><em>
        <p><strong>Navigate to Appearance &gt; Theme settings</strong> then select from tabs: <strong>"Block Homepage"</strong></p>
        <p class="alert"><span>In this section you can configure 1 custom message that appears only on homepage under top menu.</span> </p>
        <p><img src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/plugins.jpg" alt="plugins"></p>
      </em></em></li><em><em>
    </em></em></ol><em><em>
  </em></em></article>
  
  
  <em><em>
  <article id="credits">
    <h3>Credits:</h3>
    <h4>Framework:</h4>
    <ol>
      <li><a target="_blank" href="http://osclass.org/page/download">Osclass open source classifieds (v3.7.1)</a> - Based on Bender Theme</li>
      <li><a target="_blank" href="http://getbootstrap.com/">Bootstrap Framework (v3.0.0)</a></li>
      <li><a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome (The iconic font)</a></li>
      <li><a href="https://jquery.com/" target="_blank">jQuery</a></li>
      <li><a href="http://bootsnipp.com/" target="_blank">Bootsnipp</a></li>
    </ol>
    <br>
    <h4>Plugins:</h4>
    <ol>
    
      <li><a target="_blank" href="http://market.osclass.org/plugins/ad-management/watchlist_36">Watchlist</a>. Version: 1.1.0. Author Email: keny10@gmail.com</li>
      <li>Related Ads. Version: 2.2.2. Author: Navjot Tomer - nav@tuffclassified.com. Web: <a target="_blank" href="http://tuffclassified.org/">http://tuffclassified.org/</a></li>
      <li>Seller Latest Ads. Author: onaldo@pisojobs.com. Web: <a target="_blank" href="http://www.pisojobs.com/">http://www.pisojobs.com/</a></li>
      <li><a target="_blank" href="http://forums.osclass.org/plugins/(new-plugin)-upload-profile-picture/">Profile Picture</a>. Version: 3.0.2.2. Author: Jesse - turbinejesse@gmail.com</li>
    </ol>
  </article>
  
  <article>
    <h4>Documentation template by: <a href="http://www.osclasswizards.com">www.osclasswizards.com</a></h4>
    
  </article>
  
  <article>
    <h3>Additional Help &amp; Contact</h3>
    <p> If you need further assistance or any help regarding Osclass theme, please mail us at: <a href="mailto:proiulia@gmail.com">proiulia@gmail.com</a></p>
    <h1>Thank you for purchasing wayst theme!!!</h1>
  </article>
</em></em></section><em><em>
<script src="<?php echo osc_base_url();?>oc-content/themes/wayst/docs/index_files/jquery1.js" type="text/javascript"></script>


</em></em></body></html>