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
<form action="<?php echo osc_base_url(true); ?>" method="get" role="search" class="nocsrf">
    <input type="hidden" name="page" value="search" />
    <fieldset>
        <div class="col-md-8">
            <div class="row">
                <input type="text" name="sPattern" class="depan form-control" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'hero'), 'hero')); ?>" value="" /> </div>
        </div>
        <div class="col-md-2">
            <?php if ( osc_count_categories() ) { ?>
            <div class="row">
                <div class="cell selector">
                    <?php osc_categories_select('sCategory', null, __('Select a category', 'hero')) ; ?> </div>
            </div>
            <?php } ?> </div>
        <div class="col-md-2">
            <div class="row">
                <input type="submit" class="btn btn-warning depans" value="<?php echo osc_esc_html(__('Search','hero')); ?>"> </div>
        </div>
    </fieldset>
</form>
<script>
$("#sCategory").addClass("form-control dpn", true);
</script>