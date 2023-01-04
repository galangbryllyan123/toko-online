<?php

    osc_add_filter('meta_robots','meta_robots_custom');
    function meta_robots_custom(){
        return 'noindex, nofollow';
    }

    function itemCustomHead(){ 
        echo '<script type="text/javascript" src="'.osc_current_web_theme_js_url('tabber-minimized.js').'"></script>';
        ?>
        <?php
        if (realestate_default_location_show_as() == 'dropdown') {
            ItemForm::location_javascript();
        } else {
            ItemForm::location_javascript_new();
        }
        ?>
        <?php if(osc_images_enabled_at_items()) ItemForm::photos_javascript(); ?>
        <!-- end only item-post.php -->
        <?php

    }
    osc_add_hook('header','itemCustomHead', 10);
?>
<?php osc_current_web_theme_path('header.php') ; ?>
<h1><strong><?php _e('Publish an item', 'realestate'); ?></strong></h1>
<form name="item" action="<?php echo osc_base_url(true);?>" method="post" enctype="multipart/form-data">
<div class="publish-left">
<h2><?php _e('General Information', 'realestate'); ?></h2>
    <input type="hidden" name="action" value="item_add_post" />
    <input type="hidden" name="page" value="item" />
<ul id="error_list"></ul>
<div class="content add_item">
    <div class="ui-generic-form ">
        <div class="ui-generic-form-content">
            <?php
            $locales = osc_get_locales();
            $item = osc_item();
            $num_locales = count($locales);
            if($num_locales > 1){
                echo '<div class="row">';
                echo '<label for="switch-language">'.__('Language', 'realestate').'</label>';
                echo '<select name="switch-language">';
                foreach($locales as $locale) {
                    echo '<option value="'.$locale['pk_c_code'].'">'.$locale['s_short_name'].'</option>';
                }
                echo '</select>';
                echo '</div>';
            }


            ?>
            <?php if(!osc_is_web_user_logged_in() ) { ?>
            <strong><?php _e('Publish contact','realestate'); ?></strong>
            <div class="row ui-row-text">
                <label for="contactName"><?php _e('Name', 'realestate'); ?></label>
                <?php ItemForm::contact_name_text() ; ?>
            </div>
            <div class="row ui-row-text">
                <label for="contactEmail"><?php _e('E-mail', 'realestate'); ?> *</label>
                <?php ItemForm::contact_email_text() ; ?>
            </div>
            <div class="actions">
                <?php ItemForm::show_email_checkbox() ; ?>
                <span for="showEmail" class="ui-label-check"><?php _e('Show e-mail on the item page', 'realestate'); ?></span>
            </div>
            <?php }; ?>

            <div class="row">
                <label for="catId"><?php _e('Category', 'realestate'); ?> *</label>
                <?php ItemForm::category_select(null, null, __('Select a category', 'realestate')); ?>
            </div>
            <div class="row ui-row-text">
                <?php
                if($locales==null) { $locales = osc_get_locales(); }
                $value = array();
                foreach($locales as $locale) {
                    $title = (isset($item) && isset($item['locale'][$locale['pk_c_code']]) && isset($item['locale'][$locale['pk_c_code']]['s_title'])) ? $item['locale'][$locale['pk_c_code']]['s_title'] : '' ;
                    if( Session::newInstance()->_getForm('title') != "" ) {
                        $title_ = Session::newInstance()->_getForm('title');
                        if( $title_[$locale['pk_c_code']] != "" ){
                            $title = $title_[$locale['pk_c_code']];
                        }
                    }
                    $value[$locale['pk_c_code']] = $title;
                }
                $fields = array(
                             array('name'=>'title[%locale%]','label'=>__('Title','realestate'),'type'=>'text','args'=>'','required'=>true,'value'=>$value)
                          );
                multilanguage_form($fields); ?>
            </div>
            <div class="row ui-row-text">
                <?php
                if($locales==null) { $locales = osc_get_locales(); }
                $value = array();
                foreach($locales as $locale) {
                    $description = (isset($item) && isset($item['locale'][$locale['pk_c_code']]) && isset($item['locale'][$locale['pk_c_code']]['s_description'])) ? $item['locale'][$locale['pk_c_code']]['s_description'] : '';
                    if( Session::newInstance()->_getForm('description') != "" ) {
                        $description_ = Session::newInstance()->_getForm('description');
                        if( $description_[$locale['pk_c_code']] != "" ){
                            $description = $description_[$locale['pk_c_code']];
                        }
                    }
                    $value[$locale['pk_c_code']] = $description;
                }
                $fields = array(
                            array('name'=>'description[%locale%]','label'=>__('Description','realestate'), 'type'=>'textarea','args'=>'','required'=>true,'value'=>$value)
                          );
                multilanguage_form($fields); ?>
            </div>
            <?php if( osc_price_enabled_at_items() ) { ?>
            <div class="row ui-row-text">
                <label for="price"><?php _e('Price', 'realestate'); ?></label>
                <span class="float-left"><?php ItemForm::price_input_text(); ?></span>
                <?php ItemForm::currency_select(); ?>
            </div>
            <?php } ?>
            <?php if( osc_images_enabled_at_items() ) { ?>

                <div class="row">
                    <label><?php _e('Photos', 'realestate'); ?></label>
                    <input type="file" name="photos[]" />
                </div>
                 <div class="actions">
                    <div id="photos"></div>
                <a href="#" onclick="addNewPhoto(); return false;"><?php _e('Add new photo', 'realestate'); ?></a>
            </div>
            <?php } ?>
            <div class="publish-hook">
            <?php ItemForm::plugin_post_item(); ?>
            </div>
            <div class="actions">
                    <?php if( osc_recaptcha_items_enabled() ) {?>
                    <div class="box">
                        <div class="row">
                            <?php osc_show_recaptcha(); ?>
                        </div>
                    </div>
                    <?php }?>
                <a href="#" class="ui-button ui-button-gray js-submit"><?php _e("Publish", 'realestate');?></a>
            </div>
        </div>
    </div>
</div>
</div>
<div id="publish-right" class="publish-right">
<h2><?php _e('Item Location', 'realestate'); ?></h2>
<div class="content add_item">
    <div class="ui-generic-form ">
        <div class="ui-generic-form-content">
            <?php if(count(osc_get_countries()) > 1) { ?>
            <div class="row">
                <label for="countryId"><?php _e('Country', 'realestate'); ?></label>
                <?php ItemForm::country_select(osc_get_countries(), osc_user()); ?>
            </div>
            <div class="row <?php if(realestate_default_location_show_as() != 'dropdown') { ?>ui-row-text <?php } ?>">
                <label for="regionId"><?php _e('Region', 'realestate'); ?></label>
                <?php
                if (realestate_default_location_show_as() == 'dropdown') {
                    ItemForm::region_select(osc_get_regions(osc_user_field('fk_c_country_code')), osc_user());
                } else {
                    ItemForm::region_text(osc_user());
                }
                ?>
            </div>
            <?php
                } else {
                    $aCountries = osc_get_countries();
                    $aRegions = osc_get_regions($aCountries[0]['pk_c_code']);
                    ?>
            <input type="hidden" id="countryId" name="countryId" value="<?php echo osc_esc_html($aCountries[0]['pk_c_code']); ?>"/>
            <div class="row <?php if(realestate_default_location_show_as() != 'dropdown') { ?>ui-row-text <?php } ?>">
                <label for="regionId"><?php _e('Region', 'theme_map'); ?></label>
                <?php
                if (realestate_default_location_show_as() == 'dropdown') {
                    ItemForm::region_select($aRegions, osc_user());
                } else {
                    ItemForm::region_text(osc_user());
                }
                ?>
            </div>
            <?php } ?>
            <div class="row <?php if(realestate_default_location_show_as() != 'dropdown') { ?>ui-row-text <?php } ?>">
                <label for="city"><?php _e('City', 'realestate'); ?></label>
                <?php
                if (realestate_default_location_show_as() == 'dropdown') {
                    if(Params::getParam('action') != 'item_edit') {
                        ItemForm::city_select(null, osc_item());
                    } else { // add new item
                        ItemForm::city_select(osc_get_cities(osc_user_region_id()), osc_user());
                    }
                } else {
                    ItemForm::city_text(osc_user());
                }
                ?>
            </div>
            <div class="row ui-row-text">
                <label for="city"><?php _e('City Area', 'realestate'); ?></label>
                <?php ItemForm::city_area_text(osc_user()) ; ?>
            </div>
            <div class="row ui-row-text">
                <label for="address"><?php _e('Address', 'realestate'); ?></label>
                <?php ItemForm::address_text(osc_user()) ; ?>
            </div>
        </div>
    </div>
</div>
</div>
</form>
<div class="clear"></div>
<script>
function themeUiHook(){
    $('#plugin-hook select').each(function(){
        if($(this).parents('.tabbertab').length == 0){
            selectUi($(this));
        }
    });
    $('select[name="switch-language"]').trigger('change');
}
</script>
<?php osc_current_web_theme_path('footer.php') ; ?>