<?php
  osc_show_widgets('footer');
  $sQuery = osc_esc_js(osc_get_preference('keyword_placeholder', 'sofia_theme'));
?>

<!-- Footer Start -->
<div id="footer">
  <div class="inner">
    <?php if(osc_get_preference('facebook_link', 'sofia_theme') <> '') { ?><div class="element soc"><a href="<?php echo osc_get_preference('facebook_link', 'sofia_theme'); ?>" class="fb" title="<?php echo osc_esc_html(__('Share us on Facebook', 'sofia')); ?>"><i class="fa fa-facebook-square"></i></a></div><?php } ?>
    <?php if(osc_get_preference('twitter_link', 'sofia_theme') <> '') { ?><div class="element soc"><a href="<?php echo osc_get_preference('twitter_link', 'sofia_theme'); ?>" class="tw" title="<?php echo osc_esc_html(__('Tweet us', 'sofia')); ?>"><i class="fa fa-twitter-square"></i></a></div><?php } ?>
    <?php if(osc_get_preference('google_link', 'sofia_theme') <> '') { ?><div class="element soc last"><a href="<?php echo osc_get_preference('google_link', 'sofia_theme'); ?>" class="gp" title="<?php echo osc_esc_html(__('Promote us on Google+', 'sofia')); ?>"><i class="fa fa-google-plus-square"></i></a></div><?php } ?>

    <div class="element"><a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'sofia'); ?></a></div>

    <?php osc_reset_static_pages(); ?>
    <?php while( osc_has_static_pages() ) { ?>
      <div class="del">.</div><div class="element"><a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a></div>
    <?php } ?>

    <?php if(osc_get_preference('footer_email', 'sofia_theme') <> '') { ?>
      <div class="del">.</div><div class="element"><a href="mailto:<?php echo osc_get_preference('footer_email', 'sofia_theme'); ?>"><?php echo osc_get_preference('footer_email', 'sofia_theme'); ?></a></div>
    <?php } ?>

    <?php if(osc_get_preference('footer_link', 'sofia_theme') == 1) { ?>
      <div class="del">.</div><div class="element"><a href="https://osclasspoint.com/">Osclass Themes and Plugins</a></div>
      <div class="del">.</div><div class="element"><a href="https://osclass.osclasspoint.com/">Classifieds script Osclass</a></div>
    <?php } ?>

    <?php if(osc_get_preference('contact_email', 'sofia_theme') <> '') { ?>
      <div class="del">.</div><div class="element"><?php echo osc_get_preference('contact_email', 'sofia_theme'); ?></div>
    <?php } ?>

    <div id="cop">&copy; <?php echo date("Y"); ?> Sofia Premium Theme</div>
  </div>
</div>
<!-- /footer -->

<script>
  $(document).ready(function(){
    $('.subloc-list h3 .icon-add-next').click(function(){
      $(this).siblings('.sub').first().slideToggle();
    });

    $('#loc-wrap').hide();
    $('.loc-alt').click(function(){
      $('#loc-wrap').slideDown(300);
    }); 
    
    $('.close-wrap').click(function(){
      $('#loc-wrap').fadeOut(300);
    }); 

    $('.single-loc').click(function(){
      var locID = $(this).attr('id');
      $('.loc-block').slideUp(300);
      $('#sub-' + $(this).attr('id')).slideDown(300);
    });

    $('.back-wrap').click(function(){
      $('.loc-block').slideDown(300);
      $('.subloc-list').slideUp(300);
    });
    
    $('#open-loc').click(function(){
      $('#loc-wrap').fadeToggle(300);
    });
  });

  var sQuery = '<?php echo $sQuery ; ?>';
  function doSearch() {
    if($('input[name=sPattern]').val() == sQuery ) {
      document.getElementById("query").value = '';
    }
  }
</script>

<style>
<?php if(osc_get_preference('bg_color', 'sofia_theme') <> '') { ?>body {background: <?php echo osc_get_preference('bg_color', 'sofia_theme');?>}<?php } ?>

.form_publish .publish_button a { 
  <?php if(osc_get_preference('publish_bg_top', 'sofia_theme') <> '' and osc_get_preference('publish_bg_bottom', 'sofia_theme') <> '') { ?>background: -moz-linear-gradient(center top , <?php echo osc_get_preference('publish_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('publish_bg_bottom', 'sofia_theme');?>) repeat scroll 0 0 transparent;<?php } ?>
  <?php if(osc_get_preference('publish_border', 'sofia_theme')) { ?>border: 1px solid <?php echo osc_get_preference('publish_border', 'sofia_theme');?>;<?php } ?>   
  <?php if(osc_get_preference('publish_color', 'sofia_theme') <> '') { ?>color:<?php echo osc_get_preference('publish_color', 'sofia_theme');?>;<?php } ?>

  <?php if(osc_get_preference('publish_bg_top', 'sofia_theme') <> '' and osc_get_preference('publish_bg_bottom', 'sofia_theme') <> '') { ?>
    background:-moz-linear-gradient(center top , <?php echo osc_get_preference('publish_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('publish_bg_bottom', 'sofia_theme');?>) repeat scroll 0 0 transparent;
    background:-webkit-linear-gradient(top, <?php echo osc_get_preference('publish_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('publish_bg_bottom', 'sofia_theme');?>);
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=<?php echo osc_get_preference('publish_bg_top', 'sofia_theme');?>, endColorstr=<?php echo osc_get_preference('publish_bg_bottom', 'sofia_theme');?>)";
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=<?php echo osc_get_preference('publish_bg_top', 'sofia_theme');?>, endColorstr=<?php echo osc_get_preference('publish_bg_bottom', 'sofia_theme');?>); 
  <?php } ?>
}

.form_publish .publish_button a:hover {
  <?php if(osc_get_preference('publish_bg_hover_top', 'sofia_theme') <> '' and osc_get_preference('publish_bg_hover_bottom', 'sofia_theme') <> '') { ?>
    background: -moz-linear-gradient(-90deg, <?php echo osc_get_preference('publish_bg_hover_top', 'sofia_theme');?>, <?php echo osc_get_preference('publish_bg_hover_bottom', 'sofia_theme');?>) repeat scroll 0;
    background:-webkit-linear-gradient(top, <?php echo osc_get_preference('publish_bg_hover_top', 'sofia_theme');?>, <?php echo osc_get_preference('publish_bg_hover_bottom', 'sofia_theme');?>);
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=<?php echo osc_get_preference('publish_bg_hover_top', 'sofia_theme');?>, endColorstr= <?php echo osc_get_preference('publish_bg_hover_bottom', 'sofia_theme');?>)";
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=<?php echo osc_get_preference('publish_bg_hover_top', 'sofia_theme');?>, endColorstr= <?php echo osc_get_preference('publish_bg_hover_bottom', 'sofia_theme');?>); 
  <?php } ?>
}

#home-search #uniform-home-search {
  <?php if(osc_get_preference('search_color', 'sofia_theme') <> '') { ?>color:<?php echo osc_get_preference('search_color', 'sofia_theme');?>;<?php } ?>
  <?php if(osc_get_preference('search_bg_bottom', 'sofia_theme') <> '') { ?>background-color:<?php echo osc_get_preference('search_bg_bottom', 'sofia_theme');?>;<?php } ?>

  <?php if(osc_get_preference('search_bg_top', 'sofia_theme') <> '' and osc_get_preference('search_bg_bottom', 'sofia_theme') <> '') { ?>
    background-image:-webkit-gradient(linear, 0 0, 0 100%, from(<?php echo osc_get_preference('search_bg_top', 'sofia_theme');?>), color-stop(25%, <?php echo osc_get_preference('search_bg_top', 'sofia_theme');?>), to(<?php echo osc_get_preference('search_bg_bottom', 'sofia_theme');?>));
    background-image:-webkit-linear-gradient(<?php echo osc_get_preference('search_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('search_bg_top', 'sofia_theme');?> 25%, <?php echo osc_get_preference('search_bg_bottom', 'sofia_theme');?>);
    background-image:-moz-linear-gradient(top, <?php echo osc_get_preference('search_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('search_bg_top', 'sofia_theme');?> 25%, <?php echo osc_get_preference('search_bg_bottom', 'sofia_theme');?>);
    background-image:-ms-linear-gradient(<?php echo osc_get_preference('search_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('search_bg_top', 'sofia_theme');?> 25%, <?php echo osc_get_preference('search_bg_bottom', 'sofia_theme');?>);
    background-image:-o-linear-gradient(<?php echo osc_get_preference('search_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('search_bg_top', 'sofia_theme');?> 25%, <?php echo osc_get_preference('search_bg_bottom', 'sofia_theme');?>);
    background-image:linear-gradient(<?php echo osc_get_preference('search_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('search_bg_top', 'sofia_theme');?> 25%, <?php echo osc_get_preference('search_bg_bottom', 'sofia_theme');?>);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo osc_get_preference('search_bg_top', 'sofia_theme');?>', endColorstr='<?php echo osc_get_preference('search_bg_bottom', 'sofia_theme');?>', GradientType=0);
  <?php } ?>
  <?php if (osc_get_preference('search_border', 'sofia_theme')) { ?>border:1px solid <?php echo osc_get_preference('search_border', 'sofia_theme');?>;<?php } ?>
}

.item #sidebar .summary #uniform-undefined, .item #sidebar .summary #contact_button {
  <?php if(osc_get_preference('contact_color', 'sofia_theme') <> '') { ?>color:<?php echo osc_get_preference('contact_color', 'sofia_theme');?>;<?php } ?>
  <?php if(osc_get_preference('contact_bg_bottom', 'sofia_theme') <> '') { ?>background-color:<?php echo osc_get_preference('contact_bg_bottom', 'sofia_theme');?>;<?php } ?>

  <?php if(osc_get_preference('contact_bg_top', 'sofia_theme') <> '' and osc_get_preference('contact_bg_bottom', 'sofia_theme') <> '') { ?>
    background-image:-webkit-gradient(linear, 0 0, 0 100%, from(<?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?>), color-stop(25%, <?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?>), to(<?php echo osc_get_preference('contact_bg_bottom', 'sofia_theme');?>));
    background-image:-webkit-linear-gradient(<?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?> 25%, <?php echo osc_get_preference('contact_bg_bottom', 'sofia_theme');?>);
    background-image:-moz-linear-gradient(top, <?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?> 25%, <?php echo osc_get_preference('contact_bg_bottom', 'sofia_theme');?>);
    background-image:-ms-linear-gradient(<?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?> 25%, <?php echo osc_get_preference('contact_bg_bottom', 'sofia_theme');?>);
    background-image:-o-linear-gradient(<?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?> 25%, <?php echo osc_get_preference('contact_bg_bottom', 'sofia_theme');?>);
    background-image:linear-gradient(<?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?>, <?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?> 25%, <?php echo osc_get_preference('contact_bg_bottom', 'sofia_theme');?>);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo osc_get_preference('contact_bg_top', 'sofia_theme');?>', endColorstr='<?php echo osc_get_preference('contact_bg_bottom', 'sofia_theme');?>', GradientType=0);
  <?php } ?>
  <?php if (osc_get_preference('contact_border', 'sofia_theme')) { ?>border:1px solid <?php echo osc_get_preference('contact_border', 'sofia_theme');?>;<?php } ?>
}
</style>

<!--[if IE]>
  <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('style-ie.css');?>" type="text/css" />
<![endif]-->

<?php osc_run_hook('footer'); ?>

<?php if (1==2) { 
  $cat = osc_search_category_id();
  $cat = $cat[0];

  echo 'Page: ' . Params::getParam('page') . '<br />';
  echo 'Param Country: ' . Params::getParam('sCountry') . '<br />';
  echo 'Param Region: ' . Params::getParam('sRegion') . '<br />';
  echo 'Param City: ' . Params::getParam('sCity') . '<br />';
  echo 'Param Locator: ' . Params::getParam('sLocator') . '<br />';
  echo 'Param Category: ' . Params::getParam('sCategory') . '<br />';
  echo 'Search Region: ' . osc_search_region() . '<br />';
  echo 'Search City: ' . osc_search_city() . '<br />';
  echo 'Search Category: ' . $cat . '<br />';
  echo 'Param Picture: ' . Params::getParam('bPic') . '<br />';
  echo '<br/> ------------------------------------------------- </br>';
  echo 'Cookie Category: ' . mb_get_cookie('sofia-sCategory') . '<br />';
  echo 'Cookie Country: ' . mb_get_cookie('sofia-sCountry') . '<br />';
  echo 'Cookie Region: ' . mb_get_cookie('sofia-sRegion') . '<br />';
  echo 'Cookie City: ' . mb_get_cookie('sofia-sCity') . '<br />';
  echo 'Cookie Picture: ' . mb_get_cookie('sofia-bPic') . '<br />';
  echo '<br/> ------------------------------------------------- </br>';

  echo '<br/>';
  echo '<br/>';
  echo 'end<br/>';

}
?>