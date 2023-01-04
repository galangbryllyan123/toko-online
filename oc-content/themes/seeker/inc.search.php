<?php


    $sQuery = osc_get_preference('keyword_placeholder','seeker') ;
    osc_add_hook('footer_js','fjs_search');
if(!function_exists('fjs_search')){
    function fjs_search(){
        echo "\n";
?>
    var sQuery = '<?php echo osc_esc_js( osc_get_preference('keyword_placeholder','seeker') ) ; ?>' ;
    $(document).ready(function(){
                var element = $('input[name="sPattern"]');
                element.focus(function(){
                        $(this).prev().hide();
                }).blur(function(){
                    if($(this).val() == '') {
                        $(this).prev().show();
                    }
                }).prev().click(function(){
                        $(this).hide();
                        $(this).next().focus();
                });
                if(element.val() != ''){
                    element.prev().hide();
                }
            });
    function doSearch() {
        var sPattern = $('input[name=sPattern]');
        if(sPattern.val() == ''){
            return false;
        }
        return true;
    }
<?php
    }
}
?>
<div id="main-search">
<form action="<?php echo osc_base_url(true) ; ?>" method="get" class="search" onsubmit="javascript:return doSearch();">
	<label for="query"><?php _e('I\'m looking for...','seeker'); ?></label>
    <input type="hidden" name="page" value="search" />
    <fieldset class="main">
        <span id="search-placeholder"><?php echo $sQuery; ?></span>
        <input type="text" name="sPattern"  id="query" value="<?php echo osc_search_pattern(); ?>" />
        <?php  if ( osc_count_categories() ) { ?>
            <?php osc_categories_select('sCategory', null, __('Select a category', 'seeker')) ; ?>
        <?php  } ?>
    </fieldset>
    <button type="submit"><?php _e('Search', 'seeker') ; ?></button>
    <div class="clear"></div>
</form>
</div>