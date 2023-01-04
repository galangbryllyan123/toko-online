<?php
  $sQuery = osc_get_preference('keyword_placeholder', 'tatiana_theme');
  if(osc_count_countries() > 1) { $show_country = true; } else { $show_country = false; }
?>

<div class="scroller round5">
  <form action="<?php echo osc_base_url(true) ; ?>" method="get" class="search nocsrf" >
  <?php if($show_country) { ?><input type="hidden" name="sCountry<?php echo radius_installed(); ?>" id="sCountry" value="<?php echo Params::getParam('sCountry' . radius_installed());?>" /><?php } ?>
  <input type="hidden" name="sRegion<?php echo radius_installed(); ?>" id="sRegion" value="<?php echo Params::getParam('sRegion' . radius_installed());?>" />
  <input type="hidden" name="sCity<?php echo radius_installed(); ?>" id="sCity" value="<?php echo Params::getParam('sCity' . radius_installed());?>" />
  <input type="hidden" name="page" value="search" />
  <input type="hidden" name="cookie-action" id="cookie-action" value="" />
  <input type="hidden" name="sCompany" class="sCompany" id="sCompany" value="<?php echo Params::getParam('sCompany');?>" />
  <input type="hidden" name="sShowAs" class="sShowAs" id="sShowAs" value="<?php echo Params::getParam('sShowAs');?>" />

  <fieldset class="main">
    <input type="text" name="sPattern"  id="query" placeholder="<?php echo $sQuery; ?>" value="<?php if(Params::getParam('sPattern') <> '') { echo Params::getParam('sPattern'); } ?>" />
    <?php  if ( osc_count_categories() ) { ?>
      <?php mb_categories_select('sCategory', Params::getParam('sCategory'), __('Select a category', 'tatiana')) ; ?>
    <?php  } ?> 
    <?php location_selector() ; ?>                         
    <input type="text" id="priceMin" name="sPriceMin" placeholder="<?php echo osc_get_preference('def_cur', 'tatiana_theme'); ?> <?php _e('min', 'tatiana'); ?>" value="<?php echo Params::getParam('sPriceMin'); ?>" size="4" maxlength="6" />                                
    <input type="text" id="priceMax" name="sPriceMax" placeholder="<?php echo osc_get_preference('def_cur', 'tatiana_theme'); ?> <?php _e('max', 'tatiana'); ?>" value="<?php echo Params::getParam('sPriceMax'); ?>" size="4" maxlength="6" />                                

    <button type="submit"><?php _e('Search', 'tatiana') ; ?></button>
    <div class="clear-cookie" title="<?php _e('Clear search form', 'tatiana'); ?>"></div>
  </fieldset>
  <div id="search-example"></div>
  </form>  
</div>

<script>
$('.clear-cookie').click(function(){
  $.ajax({
    url: "<?php echo osc_base_url(); ?>oc-content/themes/tatiana/ajax.php?clearCookieSearch=done",
    type: "GET",
    success: function(response){
      //alert(response);
    }
  });

  $('#sCategory').val('');
  $('#uniform-sCategory span').text('<?php echo osc_esc_js(__('Select a category', 'tatiana')); ?>');
  $('#query').val('');
  $('#priceMin').val('');
  $('#priceMax').val('');
  $('#cookie-action').val('done');
});

$('.clear-cookie-location').click(function(){
  $.ajax({
    url: "<?php echo osc_base_url(); ?>oc-content/themes/tatiana/ajax.php?clearCookieLocation=done",
    type: "GET",
    success: function(response){
      //alert(response);
    }
  });

  $('#Locator').val('');
  $('input[name=sCountry<?php echo radius_installed(); ?>]').val('');
  $('input[name=sRegion<?php echo radius_installed(); ?>]').val('');
  $('input[name=sCity<?php echo radius_installed(); ?>]').val('');
  $('#uniform-Locator span').text('<?php echo osc_esc_js(__('Select a location', 'tatiana')); ?>');

  $('.h-my-loc .font').hide(150);
  $('.h-my-loc .font').text('<?php echo osc_esc_js(__('Location not saved', 'tatiana')); ?>');
  $('.h-my-loc .font').delay(150).show(150);
});

$('#sCategory').change(function(){
  $('#cookie-action').val('done');
});

$('#Locator').change(function(){
  var sQuery = '<?php echo osc_esc_js( $sQuery ); ?>';
  var isreg = $('#Locator').val();
  if(!isreg.indexOf("--")) { 
    $('#sCity').val(isreg.substring(2, isreg.length));
  } else if(!isreg.indexOf("//")) { 
    $('#sRegion').val(isreg.substring(2, isreg.length));
    $('#sCity').val('');
  } else {
    <?php if($show_country) { ?>$('#sCountry').val(isreg);<?php } ?>
    $('#sRegion').val('');
    $('#sCity').val('');
  }

  if($('input[name=sPattern]').val() == sQuery) {
    $('input[name=sPattern]').val('');
  }

  $('#Locator').val('');
  $('#cookie-action').val('done');
  $('.search').submit();
});

//document.getElementById("sCategory").onchange = function(){this.form.submit();};
$("#sCategory").change(function(){
  $('.search').submit();
});

$(".search").submit(function(){
  $('#Locator').val('');
});  
</script>