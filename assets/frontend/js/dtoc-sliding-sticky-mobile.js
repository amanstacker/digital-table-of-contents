jQuery(document).ready(function($) {
    var $tocPanel = $(".dtoc-sliding-sticky-mobile-container");
    var $tocHeader = $tocPanel.find(".dtoc-sliding-sticky-mobile-header");

    $tocHeader.on("click", function(e) {
        e.preventDefault();
        $tocPanel.toggleClass("active");
    });
});
