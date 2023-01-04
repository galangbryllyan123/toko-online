$(document).ready(function() {
$('.user_type div').click(function() {
						if($(this).hasClass('all')) {
							$('input#sCompany').val('');
						}
						
						if($(this).hasClass('personal')) {
							$('input#sCompany').val(0);
						}
						
						if($(this).hasClass('firm')) {
							$('input#sCompany').val(1);
						}
						
						$('.box button').click();
					});
      
$("#owl-demo33").owlCarousel({
    items : 6,
    itemsDesktop : [1182,5],
    itemsDesktopSmall : [986,4],
    itemsTablet: [750,3],
    itemsTabletSmall: [430,2],
    itemsMobile : [280,1],
    autoPlay: 5000,
    autoplay: true,
    lazyLoad : true,
    navigation : true,
     navigationText: [
      "<i class='fa fa-chevron-left'></i>",
      "<i class='fa fa-chevron-right'></i>"
      ],
  }); 
$(".flashmessage .ico-close").click(function(){$(this).parent().hide();});
});