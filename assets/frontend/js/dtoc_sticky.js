jQuery(document).ready(function($) {
    $(".dtoc-sticky-toggle-btn").on("click", function() {
        let $container = $(this).closest(".dtoc-sticky-container");

        // Detect if TOC is on the left side
        let isLeft = $container.hasClass("dtoc-left-top") ||
                     $container.hasClass("dtoc-left-middle") ||
                     $container.hasClass("dtoc-left-bottom");

        if ($container.hasClass("dtoc-open")) {
            // Closing
            if (isLeft) {
                $container.animate(
                    { left: -$container.outerWidth() },
                    400,
                    function() { $container.removeClass("dtoc-open"); }
                );
            } else {
                $container.animate(
                    { right: -$container.outerWidth() },
                    400,
                    function() { $container.removeClass("dtoc-open"); }
                );
            }
        } else {
            // Opening
            if (isLeft) {
                $container.animate(
                    { left: 0 },
                    400,
                    function() { $container.addClass("dtoc-open"); }
                );
            } else {
                $container.animate(
                    { right: 0 },
                    400,
                    function() { $container.addClass("dtoc-open"); }
                );
            }
        }
    });
});
