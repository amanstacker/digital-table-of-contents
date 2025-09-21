jQuery(document).ready(function($){

  var dragThreshold = 5; // pixels to consider as drag
  var dragMoved = false;

  // ==========================
  // Toggle open/close
  // ==========================
  if (dtoc_localize_frontend_data.toggle_body == 1) {
    $(".dtoc-floating-toggle-label").on("click", function (e) {
      if (dragMoved) {
        // Suppress click caused by drag
        dragMoved = false;
        return;
      }

      var $this = $(this);
      $(".dtoc-floating-box-body").slideToggle(function () {
        var $showText = $this.find('.dtoc-show-text');
        var $hideText = $this.find('.dtoc-hide-text');
        $showText.toggle();
        $hideText.toggle();
      });
    });
  }

  // ==========================
  // Smooth scroll
  // ==========================
  // Smooth scroll starts here

   if(dtoc_localize_frontend_data.scroll_behaviour == 'smooth'){

      // Add smooth scrolling to all links
      $(".dtoc-floating-box-body a").on('click', function(event) {

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

  // ==========================
  // Floating draggable TOC
  // ==========================
  var $box = $(".dtoc-floating-box-container");
  $box.css({
    "position": "fixed",
    "top": "100px",
    "right": "20px",
    "z-index": 9999,    
  });

  var isDragging = false, offsetX = 0, offsetY = 0, startX = 0, startY = 0;

  function startDrag(x, y) {
    var pos = $box.position();
    offsetX = x - pos.left;
    offsetY = y - pos.top;
    startX = x;
    startY = y;
    isDragging = true;
    dragMoved = false;
  }

  function doDrag(x, y) {
    if (!isDragging) return;
    if (Math.abs(x - startX) > dragThreshold || Math.abs(y - startY) > dragThreshold) {
      dragMoved = true;
    }
    $box.css({
      top: (y - offsetY) + "px",
      left: (x - offsetX) + "px",
      right: "auto"
    });
  }

  function stopDrag() {
    isDragging = false;
  }

  // Mouse
  $box.on("mousedown", function(e){
    startDrag(e.clientX, e.clientY);
    $(document).on("mousemove.dtoc", function(e){
      doDrag(e.clientX, e.clientY);
    });
    e.preventDefault();
  });

  $(document).on("mouseup", function(){
    stopDrag();
    $(document).off("mousemove.dtoc");
  });

  // Touch
  $box.on("touchstart", function(e){
    var touch = e.originalEvent.touches[0];
    startDrag(touch.clientX, touch.clientY);
    $(document).on("touchmove.dtoc", function(e){
      var touch = e.originalEvent.touches[0];
      doDrag(touch.clientX, touch.clientY);
    });
  });

  $(document).on("touchend touchcancel", function(){
    stopDrag();
    $(document).off("touchmove.dtoc");
  });

});
