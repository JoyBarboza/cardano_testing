 $(document).ready(function(){

        $("#menubar").click(function(){
        $(".menu").toggle();
    });  

     $("#owl-demo").owlCarousel({
			items : 6,
			lazyLoad : true,
			navigation : true
          });


          //scroll bar custom
        jQuery(document).ready(
            function() {
                jQuery("html").niceScroll({
                    cursorcolor: "#00bdcd"
                });
            }
        );

        



    });
	

	
	