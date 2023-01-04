$(document).ready(function(){
  // User_menu show/hide submenu
  $("#user_menu .with_sub").hover(function(){
      $(this).find("ul").show();
  },
  function(){
      $(this).find("ul").hide();
  });

  // Open login box in situ
  $('#login_open').click(function(e) {
      e.preventDefault();
      $('#login-wrap').fadeToggle(300, function(){});
  });

  $('.close-wrap').click(function() {
      $('#login-wrap').fadeOut(300, function(){});
  });

  // Apply the UniForm plugin to pulldows and button
  $("input:file, textarea, select, button, .search select, .search button, .filters select, .filters button, #comments form button, #contact form button, .user_forms form button, .add_item form select, .add_item form button, .modify_profile select, .modify_profile button").uniform({fileDefaultText: fileDefaultText,fileBtnText: fileBtnText});

  // Show advanced search in internal pages
  $("#expand_advanced").click(function(e){
      e.preventDefault();
      $(".search .extras").slideToggle();
  });

  // Show/hide Report as
  $("#report").hover(function(){
      $(this).find("span").show();
  },
  function(){
      $(this).find("span").hide();
  });

  // Hide login box
  $('html').click(function() {
      $('#login-wrap').fadeOut(300);
  });

  $('#login,#login_open').click(function(event){
      event.stopPropagation();
  });

  $('.fa.exp').click(function(){
    if($(this).hasClass('fa-plus-circle')) {
      $('#comment_form fieldset').slideDown(300);
      $('#comment_form .del').slideDown(300);
      $(this).addClass('fa-minus-circle').removeClass('fa-plus-circle');
    } else {
      $('#comment_form fieldset').slideUp(300);
      $('#comment_form .del').slideUp(300);
      $(this).addClass('fa-plus-circle').removeClass('fa-minus-circle');
    }
  });

  $('.more').click(function() {
    $('html, body').animate({
      scrollTop: $('.img-gal').offset().top
    }, 2000);
  });

  // Pagination content for Next, Last, Previous, First fix
  $('.searchPaginationNext').html('<i class="fa fa-angle-right"></i>');
  $('.searchPaginationLast').html('<i class="fa fa-angle-double-right"></i>');
  $('.searchPaginationPrev').html('<i class="fa fa-angle-left"></i>');
  $('.searchPaginationFirst').html('<i class="fa fa-angle-double-left"></i>');

  $('#uniform-home-search span').prepend('<i class="fa fa-search"></i>&nbsp;');


  $('.search').submit(function(){
    $('#cookie-action').val('done');
  });

  // Clear all locations
  $('.clear-cookie-location').click(function(){
    $.ajax({
      url: "oc-content/themes/sofia/ajax.php?clearCookieLocation=done",
      type: "GET",
      success: function(response){}
    });

    $('#sCountry').val('');
    $('#sCity').val('');
    $('#sRegion, #uniform-sRegion').val('');
    $('#sRegion span, #uniform-sRegion span').text($('#sRegion option').first().text());

    $('.h-my-loc .font').hide(150);
    $('.h-my-loc .font').text($('.h-my-loc .font').attr('rel'));
    $('.h-my-loc .font').delay(150).show(150);
  });

  // Clear country - active filters
  $('.country-clear').click(function(){
    $.ajax({
      url: "oc-content/themes/sofia/ajax.php?clearCookieCountry=done",
      type: "GET",
      success: function(response){}
    });

    $('#sCountry, [name="sCountry"]').val('');
    updateLoc();
  });

  // Clear region - active filters
  $('.region-clear').click(function(){
    $.ajax({
      url: "oc-content/themes/sofia/ajax.php?clearCookieRegion=done",
      type: "GET",
      success: function(response){}
    });

    $('#uniform-sRegion, #sRegion, [name="sRegion"]').val('');
    $('#uniform-sRegion span').text($('#sRegion option').first().text());
    updateLoc();
  });

  // Clear city - active filters
  $('.city-clear').click(function(){
    $.ajax({
      url: "oc-content/themes/sofia/ajax.php?clearCookieCity=done",
      type: "GET",
      success: function(response){}
    });

    $('#sCity, [name="sCity"]').val('');
    updateLoc();
  });

  // Clear category - active filters
  $('.category-clear').click(function(){
    $.ajax({
      url: "oc-content/themes/sofia/ajax.php?clearCookieCategory=done",
      type: "GET",
      success: function(response){}
    });

    $('#sCategory').val('');
    $("#sCategory option:first").attr('selected','selected');
    $('#uniform-sCategory span').text($('#sCategory option').first().text());
  });

  // Clear minimum price - active filters
  $('.pricemin-clear').click(function(){
    $.ajax({
      url: "oc-content/themes/sofia/ajax.php?clearCookiePriceMin=done",
      type: "GET",
      success: function(response){}
    });

    $('#sPriceMin').val('');
  });

  // Clear maximum price - active filters
  $('.pricemax-clear').click(function(){
    $.ajax({
      url: "oc-content/themes/sofia/ajax.php?clearCookiePriceMax=done",
      type: "GET",
      success: function(response){}
    });

    $('#sPriceMax').val('');
  });

  $('.s-filter .fa-close').click(function(){
    $(this).parent().fadeOut(300);
  });

  function updateLoc() {
    var loc = [$('[name="sCountry"]').val(), $('[name="sRegion"]').val(), $('[name="sCity"]').val()];
    loc = $.grep(loc, function(n){ return(n) });
    loc = loc.join(', ');

    if (loc == '') {
      loc = $('.h-my-loc .font').attr('rel');
    }

    $('.h-my-loc .font').hide(150);
    $('.h-my-loc .font').text(loc);
    $('.h-my-loc .font').delay(150).show(150);
  }

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

  var d_width = $('body').outerWidth();
  var l_width = $('#login-wrap').outerWidth();

  $('#login-wrap').css('margin-left', '0px');
  $('#login-wrap').css('left', (d_width - l_width)/2 + 'px');

  if($('#contact-wrap').length) {
    var c_width = $('#contact-wrap').outerWidth();
    $('#contact-wrap').css('margin-left', '0px');
    $('#contact-wrap').css('left', (d_width - c_width)/2 + 'px');
  }
}); 