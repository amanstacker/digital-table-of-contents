jQuery(document).ready(function($) {
    
    var $tocPanel = $(".dtoc-sliding-sticky-mobile-container");
    var $tocHeader = $tocPanel.find(".dtoc-sliding-sticky-mobile-header");
        
    if (dtoc_localize_frontend_sticky_mobile.toggle_initial) {
        $tocPanel.addClass("active"); 
    } else {
        $tocPanel.removeClass("active");
    }

    // Toggle on header click
    $tocHeader.on("click", function(e) {
        e.preventDefault();
        $tocPanel.toggleClass("active");
    });
});
