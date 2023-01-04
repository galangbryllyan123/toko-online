$("#Locator").change(function(){
  var sQuery = '<?php echo osc_esc_js( $sQuery ); ?>';
  var isreg = $('#Locator').val();
  if(!isreg.indexOf("--")) { 
    $('#sCity').val(isreg.substring(2, isreg.length));
  } else {
    $('#sRegion').val(isreg);
    $('#sCity').val('');
  }

  if($('input[name=sPattern]').val() == sQuery) {
    $('input[name=sPattern]').val('');
  } 
  $('.search').submit();
});

//document.getElementById("sCategory").onchange = function(){this.form.submit();};
$("#sCategory").change(function(){
  $('.search').submit();
});

