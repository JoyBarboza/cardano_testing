$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    $(window).scroll(function() {

if ($(this).scrollTop()>0)
 {
    $('.top_menu').slideUp(300);
 }
else
 {
  $('.top_menu').slideDown(300);
 }
});
    
     
    
});



	
	