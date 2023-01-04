$(document).ready(function(){
  // Apply the UniForm plugin to pulldows and button
  $("input:file, textarea, select, button, .search select, .search button, .filters select, .filters button, #comments form button, #contact form button, .user_forms form button, .add_item form select, .add_item form button, .modify_profile select, .modify_profile button").uniform({fileDefaultText: fileDefaultText,fileBtnText: fileBtnText});

  if($('#login_open').length) {
  var position = $('.icon-user-login').offset();
  var box = $('#login-box').width();
  var place = $('#login_open').width();
  var marginer = Math.round(position.left) - box/2 + place/4;
  $('#login-box').css({'margin-left':'0', 'left':marginer+'px'});
  }

  if($('#lang_open').length) {
    var position_lang = $('#lang_open').offset();
    var box_lang = $('#lang-wrap').width();
    var place_lang = $('#lang_open').width();
    var marginer_lang = Math.round(position_lang.left - box_lang/2 + place_lang/2);
    $('#lang-wrap').css({'margin-left':'0', 'left':marginer_lang+'px'});
  }

  if($('.description textarea').length && $('.item-tool-desc').length) {
    var offset = $('.description textarea').first().offset();
    $('.item-tool-desc').css('top', offset.top);
  }

  $("a[rel=image_group]").fancybox({
    openEffect : 'none',
    closeEffect : 'none',
    nextEffect : 'fade',
    prevEffect : 'fade',
    loop : false,
    helpers : { title : {type : 'inside'} }
  });

  //Search page - filter by user type: All / Company / Personal
  $('.user_type_buttons div').click(function() {
    if($(this).hasClass('all')) {
      $('input#sCompany').val('');
    }

    if($(this).hasClass('individual')) {
      $('input#sCompany').val(0);
    }

    if($(this).hasClass('company')) {
      $('input#sCompany').val(1);
    }

    $('input#cookie-action').val('done');
    $('form.search').submit();
  });

  if($('.mceLayout').length) {
    $('.mceLayout').css('width', '100%');
  }

  //Compatibility mode for facebook login and fancy script
  if(Function('/*@cc_on return document.documentMode===10@*/')()){
    $('#fb-block').remove();
  }

  if(Function('/*@cc_on return document.documentMode===11@*/')()){
    $('#fb-block').remove();
  }
});