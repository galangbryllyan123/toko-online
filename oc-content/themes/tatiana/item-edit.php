<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
  
  <!-- only item-edit.php -->
  <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script>
  <?php ItemForm::location_javascript_new(); ?>

  <?php if(osc_images_enabled_at_items()) ItemForm::photos_javascript(); ?>

  <script type="text/javascript">

    <?php if(osc_get_preference('image_upload', 'tatiana_theme') <> 1) { ?>
    function uniform_input_file(){
      photos_div = $('div.photos');
      $('div',photos_div).each(
        function(){
          if( $(this).find('div.uploader').length == 0  ){
            divid = $(this).attr('id');
            if(divid != 'photos'){
              divclass = $(this).hasClass('box');
              if( !$(this).hasClass('box') & !$(this).hasClass('uploader') & !$(this).hasClass('row')){
                $("div#"+$(this).attr('id')+" input:file").uniform({fileDefaultText: fileDefaultText,fileBtnText: fileBtnText});
              }
            }
          }
        }
      );
    }
    <?php } ?>

            function uniform_input_file(){
                photos_div = $('div.photos');
                $('div',photos_div).each(
                    function(){
                        if( $(this).find('div.uploader').length == 0  ){
                            divid = $(this).attr('id');
                            if(divid != 'photos'){
                                divclass = $(this).hasClass('box');
                                if( !$(this).hasClass('box') & !$(this).hasClass('uploader') & !$(this).hasClass('row')){
                                    $("div#"+$(this).attr('id')+" input:file").uniform({fileDefaultText: fileDefaultText,fileBtnText: fileBtnText});
                                }
                            }
                        }
                    }
                );
            }

    setInterval("uniform_plugins()", 250);
    function uniform_plugins() {
      
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
      $("#price").blur(function(event) {
        var price = $("#price").attr("value");
        <?php if(osc_locale_thousands_sep()!='') { ?>
        while(price.indexOf('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>')!=-1) {
          price = price.replace('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>', '');
        }
        <?php }; ?>
        <?php if(osc_locale_dec_point() !='') { ?>
        var tmp = price.split('<?php echo osc_esc_js(osc_locale_dec_point())?>');
        if(tmp.length>2) {
          price = tmp[0]+'<?php echo osc_esc_js(osc_locale_dec_point())?>'+tmp[1];
        }
        <?php }; ?>
        $("#price").attr("value", price);
      });
    });
    <?php }; ?>

    <?php $country = Country::newInstance()->listAll(); ?>
    <?php if(count($country) <= 1) { ?>
      $(document).ready(function() { 
        $("select#countryId option:last").attr("selected","selected");
      });
    <?php } ?>
  </script>
  <!-- end only item-edit.php -->
</head>

<body>
  <?php osc_current_web_theme_path('header.php') ; ?>

  <div id="cat-wrap">
    <div id="cat-list">
      <div class="close-wrap"></div>
      <a class="back-wrap"><div class="icon-add-back"></div><span><?php _e('Back', 'tatiana'); ?></span></a>
    
      <h2><?php _e('Select a category', 'tatiana'); ?></h2>

      <div class="cat-block">
        <?php osc_goto_first_category() ; ?>
        <?php while ( osc_has_categories() ) { ?>
          <div class="single-cat round3" id="<?php echo osc_category_id();?>">
            <a href="#" title="<?php echo osc_category_description() ; ?>" alt="<?php echo osc_category_name() ; ?>">
              <h3><?php echo osc_category_name(); ?></h3>
              <img id="main_img" src="<?php echo osc_current_web_theme_url('images/large_cat/').osc_category_id().'.png'; ?>" alt="<?php echo osc_category_slug();?>"/>
            </a>
          </div>
        <?php } ?>
      </div>

      <?php osc_goto_first_category() ; ?>
      <?php $categories = Category::newInstance()->toTree(); ?>
      <?php foreach($categories as $c) { ?>
        <div class="subcat-list" id="sub-<?php echo $c['pk_i_id'];?>" style="display:none">
          <div class="single-cat round3" id="<?php echo $c['pk_i_id'];?>">
            <a href="#" title="<?php echo $c['s_description']; ?>" alt="<?php echo $c['s_name']; ?>">
              <h3><?php echo $c['s_name']; ?></h3>
              <img id="main_img" src="<?php echo osc_current_web_theme_url('images/large_cat/').$c['pk_i_id'].'.png'; ?>" alt="<?php echo $c['s_name'];?>"/>
            </a>
          </div>

          <?php mb_subcat_list($c['categories']); ?>

          <?php /* while( osc_has_subcategories()) { ?>
            <h3><a href="#" class="single-subcat" id="<?php echo osc_category_id();?>"><?php echo osc_category_name() ; ?></a></h3>
          <?php } */ ?>
        </div>
      <?php } ?>
    </div>
  </div>

  <ul id="error_list" class="new-item"></ul>

  <div class="content add_item">
    <h1><?php _e('Edit listing', 'tatiana'); ?></h1>

    <form name="item" action="<?php echo osc_base_url(true)?>" method="post" enctype="multipart/form-data">
      <fieldset>
      <input type="hidden" name="action" value="item_edit_post" />
      <input type="hidden" name="page" value="item" />
      <input type="hidden" name="id" value="<?php echo osc_item_id() ;?>" />
      <input type="hidden" name="secret" value="<?php echo osc_item_secret() ;?>" />


      <div id="left">
        <div class="box general_info">
          <div class="row catshow">
            <label for="catId"><div class="icon-add-cat"></div><span><?php _e('Category', 'tatiana'); ?></span><span class="req">*</span></label>
            <?php ItemForm::category_select(null, null, __('Select a category', 'tatiana')); ?>
            <span class="cat-del"><?php echo ' ' . __('or pick one', 'tatiana') . ' '; ?></span>
            <img src="<?php echo osc_current_web_theme_url('images');?>/select_cat.png" class="cat-alt" alt="<?php _e('Select category with dropdowns', 'tatiana'); ?>"/>

            <div class="item-tool-wrap item-tool-cat">
              <div class="item-tool-arrow"></div>
              <div class="item-tool-body"><?php _e('Select exact category your item match. Correct category selection helps you to sell item faster', 'tatiana'); ?></div>
            </div>
          </div>
          <div class="row descshow">
            <?php ItemForm::multilanguage_title_description(); ?>
            <div class="req-what"><div class="req">*</div><div class="small-info"><?php _e('This field is required', 'tatiana'); ?></div></div>

            <div class="item-tool-wrap item-tool-desc">
              <div class="item-tool-arrow"></div>
              <div class="item-tool-body"><?php _e('Try to add constructive and detail description of item. This will help possible buyer to decide as well as users to find this listing on Google and other search engines', 'tatiana'); ?></div>
            </div>
          </div>
        </div>
        <?php if( osc_price_enabled_at_items() ) { ?>
        <div class="box price">
          <label for="price"><div class="icon-add-price"></div><span><?php _e('Price', 'tatiana'); ?></span></label>
          <?php ItemForm::price_input_text(); ?>
          <?php ItemForm::currency_select(); ?>
          <span class="price-del"><?php echo ' ' . __('or', 'tatiana') . ' ';?></span>
          <select id="PriceSelect">
          <option value="0"><?php _e('Select option', 'tatiana'); ?></option>
          <option value="1"><?php _e('Free', 'tatiana'); ?></option>
          <option value="2"><?php _e('Check with seller', 'tatiana'); ?></option>
          </select>   
        </div>
        
        <?php } ?>
        <?php if( osc_images_enabled_at_items() ) { ?>
        <div class="box photos photoshow <?php if(osc_get_preference('image_upload', 'tatiana_theme') == 1) { echo 'drag_drop'; } ?>">
          <div class="photos-header"><div class="icon-add-photo"></div><span><?php _e('Photos', 'tatiana'); ?></span></div>
          <?php if(osc_get_preference('image_upload', 'tatiana_theme') <> 1) { ItemForm::photos(); } ?>

          <div id="photos">
            <?php 
              if(modern_is_fineuploader() && osc_get_preference('image_upload', 'tatiana_theme') == 1) {
                ItemForm::ajax_photos();
                echo '</div>';
              } else { ?>
                <div class="row">
                  <input type="file" name="photos[]" multiple />
                </div>
              </div>
              <a id="new-pho" href="#" onclick="addNewPhotoTatiana(); uniform_input_file(); return false;"><?php _e('Add new photo', 'tatiana'); ?></a>
              <?php } ?>

          <div class="item-tool-wrap item-tool-photo" style="margin-top:-10px;">
            <div class="item-tool-arrow"></div>
            <div class="item-tool-body"><?php _e('Did you know that classified listings with photo are 7x more efficient than listings without photo?', 'tatiana'); ?></div>
          </div>
        </div>
        <?php } ?>
      </div>  <!-- END Left -->

      <div id="right" class="round4">
        <?php if(!osc_is_web_user_logged_in() ) { ?>
          <h2><div class="icon-add-user"></div><span><?php _e('Seller\'s Information & Location', 'tatiana'); ?></span></h2>
          <div class="del"></div>
        <?php } ?>

        <!-- Seller info -->
        <?php if(!osc_is_web_user_logged_in() ) { ?>
        <div class="box seller_info">
          <div class="row">
            <label for="contactName"><?php _e('Name', 'tatiana'); ?></label>
            <?php ItemForm::contact_name_text() ; ?>
          </div>

          <div class="item-toolr-wrap item-toolr-contact">
            <div class="item-toolr-arrow"></div>
            <div class="item-toolr-body"><?php _e('Please enter correct personal information. If you leave incorrect info, buyers will not be able to contact you with offer.', 'tatiana'); ?></div>
          </div>  
        
          <div class="row">
            <label for="phone"><?php _e('Mobile Phone', 'tatiana'); ?></label>
            <?php ItemForm::city_area_text(osc_item()) ; ?>
          </div>

          <div class="row">
            <label for="address"><?php _e('Address', 'tatiana'); ?></label>
            <?php ItemForm::address_text(osc_item()); ?>
          </div>

          <div class="row">
            <label for="contactEmail"><span><?php _e('E-mail', 'tatiana'); ?></span><span class="req">*</span></label>
            <?php ItemForm::contact_email_text() ; ?>
          </div>
          <div class="row">
            <div id="novy_email_check">
              <?php ItemForm::show_email_checkbox() ; ?>
            </div>
            <label for="showEmail" id="novy_email_show"><?php _e('Show email on listing page', 'tatiana'); ?></label>
          </div>
        </div>
        <?php } ?>

        <!-- Location -->
        <div class="box location">
          <h2><div class="icon-add-loc"></div><span><?php _e('Location', 'tatiana'); ?></span></h2>
          <div class="del"></div>

          <?php $country = Country::newInstance()->listAll(); ?>
          <div class="row" <?php if(count($country) == 1) { ?>style="display:none;"<?php } ?>>
            <label for="countryId"><?php _e('Country', 'tatiana'); ?></label>
            <?php ItemForm::country_select(Country::newInstance()->listAll(), osc_item()); ?>
          </div>

          <div class="item-toolr-wrap item-toolr-loc">
            <div class="item-toolr-arrow"></div>
            <div class="item-toolr-body"><?php _e('Information about location of offered item is plus if you want that buyer will come to pick item personally.', 'tatiana'); ?></div>
          </div>

          <div class="row">
            <label for="regionId"><?php _e('Region', 'tatiana'); ?></label>
            <?php ItemForm::region_text(osc_item()); ?>
          </div>
          <div class="row">
            <label for="city"><span><?php _e('City', 'tatiana'); ?></span><span class="req">*</span></label>
            <?php ItemForm::city_text(osc_item()); ?>
          </div>
        </div>
      </div>

      <?php ItemForm::plugin_edit_item(); ?>
      <br /><br />

      <div style="float:left;clear:both;width:100%;margin:5px 0 10px 0;">
        <?php osc_run_hook("anr_captcha_form_field"); ?>
      </div>

      <div class="clear"></div>

      <button type="submit" id="blue"><?php _e('Save', 'tatiana'); ?></button>
      </fieldset>
    </form>
  </div>

  <script type="text/javascript">
    tabberAutomatic();

    document.getElementById("PriceSelect").onchange = function(){ 
      if (document.getElementById("PriceSelect").value == 0) {
        document.getElementById("price").readOnly=false;
        document.getElementById("price").style.backgroundColor="#fff";
      } else if (document.getElementById("PriceSelect").value == 1) {
        document.getElementById("price").value = 0;
        document.getElementById("price").readOnly=true;
        document.getElementById("price").style.backgroundColor="#ddd";
      } else if (document.getElementById("PriceSelect").value == 2) {
        document.getElementById("price").value = "";
        document.getElementById("price").readOnly=true;
        document.getElementById("price").style.backgroundColor="#ddd";
      }
    }

    $('.catshow').hover(function() { $('.item-tool-cat').show(); }, function() {$('.item-tool-cat').hide();});
    $('.descshow').hover(function() { $('.item-tool-desc').show(); }, function() {$('.item-tool-desc').hide();});
    $('.photoshow').hover(function() { $('.item-tool-photo').show(); }, function() {$('.item-tool-photo').hide();});
    $('.seller_info').hover(function() { $('.item-toolr-contact').show(); }, function() {$('.item-toolr-contact').hide();});
    $('.location').hover(function() { $('.item-toolr-loc').show(); }, function() {$('.item-toolr-loc').hide();});

    $(document).ready(function(){
      $('.subcat-list h3 .icon-add-next').click(function(){
        $(this).siblings('.sub').first().slideToggle();
      });

      $('#cat-wrap').hide();
      $('.cat-alt').click(function(){
        $('#cat-wrap').slideDown('slow');
      }); 
      $('.close-wrap').click(function(){
        $('#cat-wrap').slideUp('slow');
      }); 
    });

    $('.single-cat').click(function(){
      var catID = $(this).attr('id');
      $('.cat-block').slideUp('slow');
      $('#sub-' + $(this).attr('id')).show('slow');
    });

    $('.back-wrap').click(function(){
      $('.cat-block').slideDown('slow');
      $('.subcat-list').slideUp('slow');
    });

    $('.single-subcat').click(function(){
      var subcatID = $(this).attr('id');
      $('#cat-wrap').slideUp('slow');
      $('#catId').val($(this).attr('id'));
      $('#uniform-catId span').html($('#catId').find(':selected').text());
      $('#catId').click();
    });

    <?php if(osc_selectable_parent_categories()) { ?>
      $('.single-cat').click(function(){
        if($('.single-cat:visible').length == 1) {
          var subcatID = $(this).attr('id');
          $('#cat-wrap').slideUp('slow');
          $('#catId').val($(this).attr('id'));
          $('#uniform-catId span').html($('#catId').find(':selected').text());
          $('#catId').click();
        }
      });
    <?php } ?>


    $("#catId").click(function(){
      var cat_id = $(this).val();
      var url = '<?php echo osc_base_url(); ?>index.php';
      var result = '';

      if(cat_id != '') {
        if(catPriceEnabled[cat_id] == 1) {
          $("#price").closest("div").show();
        } else {
          $("#price").closest("div").hide();
          $('#price').val('') ;
        }

        $.ajax({
          type: "POST",
          url: url,
          data: 'page=ajax&action=runhook&hook=item_form&catId=' + cat_id,
          dataType: 'html',
          success: function(data){
          $("#plugin-hook").html(data);
        }
      });
    }
  });
  </script>

  <?php if(osc_get_preference('image_upload', 'tatiana_theme') <> 1) { ?>
  <script>
    var photoIndex = 0;
    function gebi(id) { return document.getElementById(id); }
    function ce(name) { return document.createElement(name); }
    function re(id) {
      var e = gebi(id);
      e.parentNode.removeChild(e);
    }
    function addNewPhotoTatiana() {
      var max = <?php echo osc_max_images_per_item(); ?>;
      var num_img = $('input[name="photos[]"]').size() + $("a.delete").size();
      if((max!=0 && num_img<max) || max==0) {
        var id = 'p-' + photoIndex++;

        var i = ce('input');
        i.setAttribute('type', 'file');
        i.setAttribute('name', 'photos[]');

        var a = ce('a');
        a.style.fontSize = 'x-small';
        a.style.paddingLeft = '10px';
        a.setAttribute('href', '#');
        a.setAttribute('divid', id);
        a.onclick = function() { re(this.getAttribute('divid')); return false; }
        a.appendChild(document.createTextNode('<?php echo osc_esc_js(__('Remove')); ?>'));

        var d = ce('div');
        d.setAttribute('id', id);
        d.setAttribute('style','padding: 4px 0;')

        d.appendChild(i);
        d.appendChild(a);

        gebi('photos').appendChild(d);

      } else {
        alert('<?php echo osc_esc_js(__('Sorry, you have reached the maximum number of images per listing')); ?>');
      }
    }
    // Listener: automatically add new file field when the visible ones are full.
    setInterval("add_file_field()", 250);
    /**
     * Timed: if there are no empty file fields, add new file field.
     */

    function add_file_field() {
      var count = 0;
      $('input[name="photos[]"]').each(function(index) {
        if ( $(this).val() == '' ) {
          count++;
        }
      });
      var max = <?php echo osc_max_images_per_item(); ?>;
      var num_img = $('input[name="photos[]"]').size() + $("a.delete").size();
      if (count == 0 && (max==0 || (max!=0 && num_img<max))) {
        addNewPhotoTatiana();uniform_input_file(); return false;
      }
    }
  </script>
  <?php } ?>

  <script>
    $(document).ready(function(){
      $('.button').click(function(){
        $('select.error').parent().addClass('error');
      });

      $('select').change(function(){
        if($(this).val() != '' && $(this).val() != 0) {
          $(this).parent().removeClass('error');
          $(this).parent().addClass('valid');
        } else {
          $(this).parent().removeClass('valid');
          $(this).parent().addClass('error');
        }
      });
    });
  </script>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>