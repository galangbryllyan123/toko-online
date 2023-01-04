<?php


    $sExample = osc_esc_js( __('ie. Comercial', 'masjob') ) ;
?>
<script type="text/javascript">
    var sQuery = '<?php echo $sExample; ?>';

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
    function doSearch() {
        if($('input[name=sPattern]').val() == sQuery){
            // Highlight the input
            $("input[name=sPattern]").effect("highlight", {color: '#ffffcc'}, 3000);
            return false;
        }
        if($('input[name=sPattern]').val().length < 3) {
            // Highlight the input
            $("input[name=sPattern]").effect("highlight", {color: '#ffffcc'}, 3000);
            $('input[name=sPattern]').css('background', '#FFC6C6');
            return false;
        }
        return true;
    }
</script>
<form action="<?php echo osc_base_url(true) ; ?>" method="post" class="search" onsubmit="javascript:return doSearch();" >
    <input type="hidden" name="page" value="search" />
    <fieldset class="main">
        <label for="query"><?php _e('What job are you looking for?', 'masjob') ; ?></label>
        <input type="text" name="sPattern"  id="query" value="<?php echo ( osc_search_pattern() != '' ) ? osc_search_pattern() : $sExample ; ?>" />
        <?php  if ( osc_count_categories() ) { ?>
            <?php osc_goto_first_category() ; ?>
            <select name="sCategory" id="sCategory">
                <option value=""><?php _e('All areas', 'masjob') ; ?></option>
                <?php while ( osc_has_categories() ) { ?>
                        <option value="<?php echo osc_category_id() ; ?>"><?php echo osc_category_name() ; ?></option>
                        <?php if ( osc_count_subcategories() > 0 ) { ?>
                            <?php while ( osc_has_subcategories() ) { ?>
                                <option class="pad" value="<?php echo osc_category_id() ; ?>"><?php echo osc_category_name() ; ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
            </select>
        <?php  } ?>
        <button type="submit"><?php _e('Search', 'masjob') ; ?></button>
    </fieldset>
</form>