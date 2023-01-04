<?php
  osc_enqueue_script('jquery-validate');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
  <head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />

    <!-- Only item-post.php -->
    <?php ItemForm::location_javascript_new(); ?>
    <?php if(osc_images_enabled_at_items()) ItemForm::photos_javascript(); ?>

    <script type="text/javascript">
      <?php if(osc_get_preference('image_upload', 'sofia_theme') <> 1) { ?>
        function uniform_input_file(){
          photos_div = $('div.photos');
          $('div',photos_div).each(function(){
            if( $(this).find('div.uploader').length == 0  ){
              divid = $(this).attr('id');
              if(divid != 'photos'){
                divclass = $(this).hasClass('box');
                if( !$(this).hasClass('box') & !$(this).hasClass('uploader') & !$(this).hasClass('row')){
                  $("div#"+$(this).attr('id')+" input:file").uniform({fileDefaultText: fileDefaultText,fileBtnText: fileBtnText});
                }
              }
            }
          });
        }
      <?php } ?>

      setInterval("uniform_plugins()", 250);
      function uniform_plugins() {
        <?php if(osc_get_preference('image_upload', 'sofia_theme') == 1) { ?>
          $(document).ready(function() { $('#p-0').hide(); });
        <?php } ?>
        
        var content_plugin_hook = $('#plugin-hook').text();
        content_plugin_hook = content_plugin_hook.replace(/(\r\n|\n|\r)/gm,"");
        if( content_plugin_hook != '' ){
          var div_plugin_hook = $('#plugin-hook');
          var num_uniform = $("div[id*='uniform-']", div_plugin_hook ).size();
          if( num_uniform == 0 ){
            if( $('#plugin-hook input:text').size() > 0 ){
              $('#plugin-hook input:text').uniform();
            }
            
            if( $('#plugin-hook select').size() > 0 ){
              $('#plugin-hook select').uniform();
            }
          }
        }
      }
      
      <?php if(osc_locale_thousands_sep()!='' || osc_locale_dec_point() != '') { ?>
        $().ready(function(){
          $('#price').blur(function(event) {
            var price = $('#price').attr('value');
            
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
            $('#price').attr('value', price);
          });
        });
      <?php }; ?>
    </script>
    <!-- end only item-post.php -->
  </head>

  <?php
    $def_cat['fk_i_category_id'] = Params::getParam('sCategory'); 
    $def_country['fk_c_country_code'] = Params::getParam('sCountry'); 
    if(is_numeric(Params::getParam('sRegion'))) { $def_reg['fk_i_region_id'] = Params::getParam('sRegion'); } else {  $def_reg['s_region'] = Params::getParam('sRegion'); }
    if(is_numeric(Params::getParam('sCity'))) { $def_city['fk_i_city_id'] = Params::getParam('sCity'); } else {  $def_city['s_city'] = Params::getParam('sCity'); }
  ?>

  <body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="content add_item">
      <h1 class="round2"><?php _e('Publish a listing', 'sofia'); ?></h1>
      <ul id="error_list"></ul>
      
      <form name="item" action="<?php echo osc_base_url(true);?>" method="post" enctype="multipart/form-data">
        <fieldset>
          <input type="hidden" name="action" value="item_add_post" />
          <input type="hidden" name="page" value="item" />
          
          <div id="left-block">
            <div class="box general_info">
              <h2><i class="fa fa-pencil"></i>&nbsp;<?php _e('General Information', 'sofia'); ?></h2>
              <div class="del"></div>

              <div class="row cat-select round3">
                <label for="catId"><?php _e('Category', 'sofia'); ?> <sup>*</sup></label>
                <?php ItemForm::category_select(null, $def_cat, __('Select a category', 'sofia')); ?>
              </div>
              
              <div class="row <?php if(osc_count_web_enabled_locales() == 1) { ?>one-lang<?php } ?>">
                <?php ItemForm::multilanguage_title_description(); ?>
              </div>
            </div>
              
            <?php if( osc_price_enabled_at_items() ) { ?>
              <div class="box price round3">
                <label for="price"><?php _e('Price', 'sofia'); ?></label>
                <?php ItemForm::price_input_text(); ?>
                <?php ItemForm::currency_select(); ?>
                <span class="price-warn"><i class="fa fa-warning"></i>&nbsp;<?php _e('For <strong>"Check with seller"</strong> option leave blank', 'sofia'); ?>.</span>
              </div>
            <?php } ?>
              
            <div class="box photos photoshow <?php if(osc_get_preference('image_upload', 'sofia_theme') == 1) { echo 'drag_drop'; } ?>">
              <?php if(osc_get_preference('image_upload', 'sofia_theme') <> 1) { ?><h2><i class="fa fa-camera"></i>&nbsp;<?php _e('Photos', 'sofia'); ?></h2><div class="del"></div><?php } ?>
              <div id="photos">
                <?php if(osc_images_enabled_at_items()) { ?>
                  <?php if(modern_is_fineuploader() && osc_get_preference('image_upload', 'sofia_theme') == 1) { ?>
                    <?php ItemForm::ajax_photos(); ?>
                    </div>
                  <?php } else { ?>
                    <div class="row">
                      <input type="file" name="photos[]" multiple />
                    </div>
                  </div>
                  <a id="new-pho" href="#" onclick="addNewPhoto(); uniform_input_file(); return false;"><?php _e('Add new photo', 'sofia'); ?></a>
                <?php } ?>
              <?php } ?>
            </div>
          </div>

          <div id="right-block" class="round2">
            <div class="box location">
              <h2><i class="fa fa-map-marker"></i>&nbsp;<?php _e('Listing Location', 'sofia'); ?></h2>
              <div class="del"></div>

              <?php $country = Country::newInstance()->listAll(); ?>
              <div class="row" <?php if(count($country) == 1) { ?>style="display:none;"<?php } ?>>
                <label for="countryId"><?php _e('Country', 'sofia'); ?></label>
                <?php $go_country = osc_is_web_user_logged_in() ? osc_user() : $def_country; ?>
                <?php ItemForm::country_select(Country::newInstance()->listAll(), $go_country); ?>
              </div>
              
              <div class="row">
                <label for="regionId"><?php _e('Region', 'sofia'); ?></label>
                <?php $go_reg = osc_is_web_user_logged_in() ? osc_user() : $def_reg; ?>
                <?php ItemForm::region_text($go_reg); ?>
              </div>
               
              <div class="row">
                <label for="cityId"><?php _e('City', 'sofia'); ?></label>
                <?php $go_city = osc_is_web_user_logged_in() ? osc_user() : $def_city; ?>
                <?php ItemForm::city_text($go_city); ?>
              </div>
              
              <div class="row">
                <label for="address"><?php _e('Address', 'sofia'); ?></label>
                <?php ItemForm::address_text(osc_user()); ?>
              </div>
            </div>
              
            <!-- seller info -->
            <?php if(!osc_is_web_user_logged_in() ) { ?>
              <div class="box seller_info">
                <h2><i class="fa fa-users"></i>&nbsp;<?php _e("Seller's information", 'sofia'); ?></h2>
                <div class="del"></div>

                <div class="row">
                  <label for="contactName"><?php _e('Name', 'sofia'); ?></label>
                  <?php ItemForm::contact_name_text(); ?>
                </div>
                <div class="row">
                  <label for="city"><?php _e('Mobile Phone', 'sofia'); ?></label>
                  <?php ItemForm::city_area_text(osc_user()); ?>
                </div>
                <div class="row">
                  <label for="contactEmail"><?php _e('E-mail', 'sofia'); ?>  <sup>*</sup></label>
                  <?php ItemForm::contact_email_text(); ?>
                </div>
                <div class="row">
                  <div id="showEmail">
                    <?php ItemForm::show_email_checkbox(); ?>
                  </div>
                  <label for="showEmail" id="showEmailLabel"><?php _e('Show e-mail on the listing page', 'sofia'); ?></label>
                </div>
              </div>
            <?php } else { ?>
              <div class="box seller_info">
                <h2><i class="fa fa-users"></i>&nbsp;<?php _e("Seller's information", 'sofia'); ?></h2>
                <div class="del"></div>

                <div class="row">
                  <label for="city"><?php _e('Mobile Phone', 'sofia'); ?></label>
                  <?php UserForm::mobile_text(osc_user()); ?>
                  <div class="change_mobile">
                    <a href="<?php echo osc_user_profile_url(); ?>" target="_blank"><?php _e('Change your mobile phone number', 'sofia');?></a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
            
          <div id="bottom-block">
            <?php ItemForm::plugin_post_item(); ?>
            <div style="float:left;clear:both;width:100%;margin:5px 0 10px 0;">
              <?php osc_run_hook("anr_captcha_form_field"); ?>
             </div>
          </div>
          
          <div class="clear"></div>
          <div class="add_it_but">
            <button class="add_but" type="submit"><?php _e('Publish listing', 'sofia'); ?></button>
          </div>
        </fieldset>
      </form>
    </div>
      
    <?php osc_current_web_theme_path('footer.php'); ?>
    <script>
      $( document ).ready(function() {
        $("#s_phone_mobile").attr("disabled", true);
        $("#s_phone_mobile").css("float", "left");
   
        $('img[src$="<?php echo osc_base_url(); ?>oc-content/uploads/temp/"]').parent().parent('.qq-upload-success').remove();

        if(!$('li.qq-upload-success').length) {
          $('.drag_drop #photos h3').hide();
        } else {
          $('.drag_drop #photos h3').show();
        }

        $('.qq-upload-button>div').html('<?php echo '<i class="fa fa-camera"></i>&nbsp;' . osc_esc_js(__('Click or Drag for upload images', 'sofia'));?>');

        if($('.tabbertab').length) {
          $('.tabbertab').prepend('<div class="inside"><div class="bg"></div></div>');
        }
      });
    </script>
  </body>
</html>