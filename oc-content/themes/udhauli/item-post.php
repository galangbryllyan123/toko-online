<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    // meta tag robots
    osc_add_hook('header','udhauli_nofollow_construct');

    osc_enqueue_script('jquery-validate');
    udhauli_add_body_class('item item-post');
    $action = 'item_add_post';
    $edit = false;
    if(Params::getParam('action') == 'item_edit') {
        $action = 'item_edit_post';
        $edit = true;
    }

    ?>
<?php osc_current_web_theme_path('header.php') ; ?>
        <?php
    if (udhauli_default_location_show_as() == 'dropdown') {
        ItemForm::location_javascript();
    } else {
        ItemForm::location_javascript_new();
    }
    ?>
    <div class="form-row-header">
       <h1 id="form-row-h1"><?php _e('Publish a listing', 'udhauli'); ?></h1>
    </div>   
    <div class="row" id="form-row">
        <div class="col-md-6 col-md-offset-3 item-post" id="form-login"> 
            <ul id="error_list"></ul>
              <div class="form-login">
                <form name="item" action="<?php echo osc_base_url(true);?>" method="post" enctype="multipart/form-data" id="item-post">
                    <fieldset>
                    <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <input type="hidden" name="page" value="item" />
                    <?php if($edit){ ?>
                        <input type="hidden" name="id" value="<?php echo osc_item_id();?>" />
                        <input type="hidden" name="secret" value="<?php echo osc_item_secret();?>" />
                    <?php } ?>
                        <h2><?php _e('General Information', 'udhauli'); ?></h2>
                        <div class="control-group">
                            <label class="control-label" for="select_1"><?php _e('Category', 'udhauli'); ?></label>
                            <div class="controls">
                                <?php  if ( osc_count_categories() ) { ?>
                                    <?php if(osc_get_preference('category_multiple_selects', 'udhauli') == '1'){ ?>
                                      <div class="cat_multiselect"><?php ItemForm::category_multiple_selects(null, null, null, osc_esc_html(__('Select a category', 'udhauli'))); ?></div>
                                    <?php }else{ ?>
                                      <?php ItemForm::category_select(null, null, osc_esc_html(__('Select a category', 'udhauli'))); ?>
                                    <?php } ?>
                                      <?php  } ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="title[<?php echo osc_current_user_locale(); ?>]"><?php _e('Title', 'udhauli'); ?></label>
                            <div class="controls">
                                <?php ItemForm::title_input('title',osc_current_user_locale(), osc_esc_html( udhauli_item_title() )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="description[<?php echo osc_current_user_locale(); ?>]"><?php _e('Description', 'udhauli'); ?></label>
                            <div class="controls">
                                <?php ItemForm::description_textarea('description',osc_current_user_locale(), osc_esc_html( udhauli_item_description() )); ?>
                            </div>
                        </div>
                        <?php if( osc_price_enabled_at_items() ) { ?>
                        <div class="control-group control-group-price">
                            <label class="control-label" for="price"><?php _e('Price', 'udhauli'); ?></label>
                            <div class="controls row">
                                <div class="col-xs-6"><?php ItemForm::price_input_text(); ?></div>
                                <div class="col-xs-6"><?php ItemForm::currency_select(); ?></div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if( osc_images_enabled_at_items() ) {
                            ItemForm::ajax_photos();
                         } ?>
                        <div class="box location">
                            <h2><?php _e('Listing Location', 'udhauli'); ?></h2>
                            <?php if(count(osc_get_countries()) > 1) { ?>
                            <div class="control-group">
                                <label class="control-label" for="country"><?php _e('Country', 'udhauli'); ?></label>
                                <div class="controls">
                                    <?php ItemForm::country_select(osc_get_countries(), osc_user()); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="regionId"><?php _e('Region', 'udhauli'); ?></label>
                                <div class="controls">
                                    <?php
                                    if (udhauli_default_location_show_as() == 'dropdown') {
                                        if($edit) {
                                            ItemForm::region_select(osc_get_regions(osc_item_country_code()), osc_item());
                                        } else {
                                            ItemForm::region_select(osc_get_regions(osc_user_field('fk_c_country_code')), osc_user());
                                        }
                                    } else {
                                        if($edit) {
                                            ItemForm::region_text(osc_item());
                                        } else {
                                            ItemForm::region_text(osc_user());
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            } else {
                                $aCountries = osc_get_countries();
                                $aRegions = osc_get_regions($aCountries[0]['pk_c_code']);
                                ?>
                            <input type="hidden" id="countryId" name="countryId" value="<?php echo osc_esc_html($aCountries[0]['pk_c_code']); ?>"/>
                            <div class="control-group">
                                <label class="control-label" for="region"><?php _e('Region', 'udhauli'); ?></label>
                                <div class="controls">
                                  <?php
                                    if (udhauli_default_location_show_as() == 'dropdown') {
                                        if($edit) {
                                            ItemForm::region_select($aRegions, osc_item());
                                        } else {
                                            ItemForm::region_select($aRegions, osc_user());
                                        }
                                    } else {
                                        if($edit) {
                                            ItemForm::region_text(osc_item());
                                        } else {
                                            ItemForm::region_text(osc_user());
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="control-group">
                                <label class="control-label" for="city"><?php _e('City', 'udhauli'); ?></label>
                                <div class="controls">
                                    <?php
                                    if (udhauli_default_location_show_as() == 'dropdown') {
                                        if($edit) {
                                            ItemForm::city_select(null, osc_item());
                                        } else { // add new item
                                            ItemForm::city_select(osc_get_cities(osc_user_region_id()), osc_user());
                                        }
                                    } else {
                                        ItemForm::city_text(osc_user());
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="cityArea"><?php _e('City Area', 'udhauli'); ?></label>
                                <div class="controls">
                                    <?php ItemForm::city_area_text(osc_user()); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="address"><?php _e('Address', 'udhauli'); ?></label>
                                <div class="controls">
                                  <?php ItemForm::address_text(osc_user()); ?>
                                </div>
                            </div>
                        </div>
                        <!-- seller info -->
                        <?php if(!osc_is_web_user_logged_in() ) { ?>
                        <div class="box seller_info">
                            <h2><?php _e("Seller's information", 'udhauli'); ?></h2>
                            <div class="control-group">
                                <label class="control-label" for="contactName"><?php _e('Name', 'udhauli'); ?></label>
                                <div class="controls">
                                    <?php ItemForm::contact_name_text(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="contactEmail"><?php _e('E-mail', 'udhauli'); ?></label>
                                <div class="controls">
                                    <?php ItemForm::contact_email_text(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls checkbox">
                                    <?php ItemForm::show_email_checkbox(); ?> <label for="showEmail" style="text-transform: unset;" ><?php _e('Show e-mail on the listing page', 'udhauli'); ?></label>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        if($edit) {
                            ItemForm::plugin_edit_item();
                        } else {
                            ItemForm::plugin_post_item();
                        }
                        ?>
                        <div class="control-group">
                            <?php if( osc_recaptcha_items_enabled() ) { ?>
                                <div class="controls">
                                    <?php osc_show_recaptcha(); ?>
                                </div>
                            <?php }?>
                            <div class="controls">
                                <button type="submit" class="btn btn-md"><?php if($edit) { _e("Update", 'udhauli'); } else { _e("Publish", 'udhauli'); } ?></button>
                            </div>
                        </div>
                    </fieldset>
                </form>
              </div>
            </div>
        </div>
        <script type="text/javascript">
            $('#price').bind('hide-price', function(){
                $('.control-group-price').hide();
            });

            $('#price').bind('show-price', function(){
                $('.control-group-price').show();
            });

    <?php if(osc_locale_thousands_sep()!='' || osc_locale_dec_point() != '') { ?>
    $().ready(function(){
        $("#price").blur(function(event) {
            var price = $("#price").prop("value");
            <?php if(osc_locale_thousands_sep()!='') { ?>
            while(price.indexOf('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>')!=-1) {
                price = price.replace('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>', '');
            }
            <?php }; ?>
            <?php if(osc_locale_dec_point()!='') { ?>
            var tmp = price.split('<?php echo osc_esc_js(osc_locale_dec_point())?>');
            if(tmp.length>2) {
                price = tmp[0]+'<?php echo osc_esc_js(osc_locale_dec_point())?>'+tmp[1];
            }
            <?php }; ?>
            $("#price").prop("value", price);
        });
    });
    <?php }; ?>
</script>
<?php osc_current_web_theme_path('footer.php'); ?>
