<?php


     $sQuery = __("ie. PHP Programmer", 'realestate');
?>

<script type="text/javascript">
    var sQuery = '<?php echo $sQuery; ?>' ;

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
    });
</script>

<form action="<?php echo osc_base_url(true) ; ?>" method="get" class="search" onsubmit="javascript:return doSearch();">
    <input type="hidden" name="page" value="search" />
    <fieldset class="main">
        <input type="text" name="sPattern"  id="query" value="<?php echo ( osc_search_pattern() != '' ) ? osc_search_pattern() : $sQuery; ?>" />
        <?php  if ( osc_count_categories() ) { ?>
            <?php osc_categories_select('sCategory', null, __('Select a category', 'realestate')) ; ?>
        <?php  } ?>
        <button type="submit"><?php _e('Search', 'realestate') ; ?></button>
    </fieldset>
</form>
