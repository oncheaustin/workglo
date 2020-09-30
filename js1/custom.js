$(document).ready(function() { 
	$('#carousel-example-generic').carousel();
      var owl = $("#fd2");
	  owl.owlCarousel({
         
          itemsCustom : [
            [0, 1],
			[360, 1],
            [450, 2],
            [600, 3],
            [768, 3],
            [1000, 4],
            [1200, 4],
            [1400, 4],
            [1600, 4]
          ],
          navigation : true
     
      });
    });

	
