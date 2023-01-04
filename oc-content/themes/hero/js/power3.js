$(document).ready(function() {
 $("#owl-demo77").owlCarousel({
      navigation : true,
      navigationText: [
      "<i class='fa fa-chevron-left'></i>",
      "<i class='fa fa-chevron-right'></i>"
      ],
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true
  });
 $('#mytabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});
});