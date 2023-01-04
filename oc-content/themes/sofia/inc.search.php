<?php
  $sQuery = osc_get_preference('keyword_placeholder', 'sofia_theme');
?>

<script type="text/javascript">
  var sQuery = '<?php echo osc_esc_js( $sQuery ); ?>';

  $(document).ready(function(){
    if($('input[name=sPattern]').val() == sQuery) {
      $('input[name=sPattern]').css('color', 'gray');
    }
    $('input[name=sPattern]').click(function(){
      if($('input[name=sPattern]').val() == sQuery) {
        $('input[name=sPattern]').val('');
        $('input[name=sPattern]').css('color', '');
      }
    });
    $('input[name=sPattern]').blur(function(){
      if($('input[name=sPattern]').val() == '') {
        $('input[name=sPattern]').val(sQuery);
        $('input[name=sPattern]').css('color', 'gray');
      }
    });
    $('input[name=sPattern]').keypress(function(){
      $('input[name=sPattern]').css('background','');
    })

    if($('input[name=sPattern]').val() == '') { 
      $('input[name=sPattern]').val(sQuery); 
      $('input[name=sPattern]').css('color', 'gray');
    }
  });
</script>