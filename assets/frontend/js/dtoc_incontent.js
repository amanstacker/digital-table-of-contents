jQuery(document).ready(function($){

 if (dtoc_localize_frontend_data.toggle_body == 1) {
  $(".dtoc-toggle-label").click(function () {
    var $this = $(this);
    
    $(".dtoc-box-on-js-body").slideToggle( function () {
      // This runs after slideToggle finishes
      var $showText = $this.find('.dtoc-show-text');
      var $hideText = $this.find('.dtoc-hide-text');

      $showText.toggle();
      $hideText.toggle();
    });
  });
}

   // Smooth scroll starts here

   if(dtoc_localize_frontend_data.scroll_behaviour == 'smooth'){

      // Add smooth scrolling to all links
      $(".dtoc-box-on-js-body a").on('click', function(event) {

         // Make sure this.hash has a value before overriding default behavior
      if (this.hash !== "") {
		
		var hash = this.hash;
		
		if(!document.querySelector(hash)){
			return ;
		}
         // Prevent default anchor click behavior
         event.preventDefault();

         // Store hash
         

         // Using jQuery's animate() method to add smooth page scroll
         // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
         $('html, body').animate({
            scrollTop: $(hash).offset().top
         }, 800, function(){

            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
         });
         } // End if
      });
      
   }

   //Smooth scroll ends here

});