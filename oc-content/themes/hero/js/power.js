$(document).ready(function() {
  $("#owl-demo").owlCarousel({
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
 $(".demo1").bootstrapNews({
            newsPerPage: 4,
            autoplay: true,
	    pauseOnHover:true,
            direction: 'up',
            newsTickerInterval: 4000,
            onToDo: function () {
                //console.log(this);
            }
        });
$("#owl-demo7").owlCarousel({
     autoPlay: 5000,
      autoplay: true,
      items : 6,
      itemsDesktop : [1182,5],
      itemsDesktopSmall : [986,4],
      itemsTablet: [750,3],
      itemsTabletSmall: [430,2],
      itemsMobile : [280,1],
      navigation : true,
     navigationText: [
      "<i class='fa fa-chevron-left'></i>",
      "<i class='fa fa-chevron-right'></i>"
      ],
  });
  $("#owl-demo5").owlCarousel({
     autoPlay: 5000,
      navigation : true,
      navigationText: [
      "<i class='fa fa-chevron-left'></i>",
      "<i class='fa fa-chevron-right'></i>"
      ],
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true
  });
 $("#owl-demo2").owlCarousel({
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
 $('#mytabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});
});