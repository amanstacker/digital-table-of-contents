jQuery(document).ready(function($) {
    $(".dtoc-sliding-sticky-container").each(function() {
        let $container = $(this);
        let isLeft = $container.hasClass("dtoc-left-top") ||
                     $container.hasClass("dtoc-left-middle") ||
                     $container.hasClass("dtoc-left-bottom");

        // If it's closed initially, correct safe offset and show
        if ($container.hasClass("dtoc-closed")) {
            if (isLeft) {
                $container.css("left", -$container.outerWidth());
            } else {
                $container.css("right", -$container.outerWidth());
            }
            $container.css("visibility", "visible");
        }
    });

    $(".dtoc-sliding-sticky-toggle-btn").on("click", function() {
        let $container = $(this).closest(".dtoc-sliding-sticky-container");
        let isLeft = $container.hasClass("dtoc-left-top") ||
                     $container.hasClass("dtoc-left-middle") ||
                     $container.hasClass("dtoc-left-bottom");

        if ($container.hasClass("dtoc-open")) {
            // Closing
            if (isLeft) {
                $container.animate(
                    { left: -$container.outerWidth() },
                    400,
                    function() { $container.removeClass("dtoc-open").addClass("dtoc-closed"); }
                );
            } else {
                $container.animate(
                    { right: -$container.outerWidth() },
                    400,
                    function() { $container.removeClass("dtoc-open").addClass("dtoc-closed"); }
                );
            }
        } else {
            // Opening
            if (isLeft) {
                $container.animate(
                    { left: 0 },
                    400,
                    function() { $container.removeClass("dtoc-closed").addClass("dtoc-open"); }
                );
            } else {
                $container.animate(
                    { right: 0 },
                    400,
                    function() { $container.removeClass("dtoc-closed").addClass("dtoc-open"); }
                );
            }
        }
        
    });

    // Optional: fix offset dynamically on resize
    $(window).on("resize", function() {
        $(".dtoc-sliding-sticky-container.dtoc-closed").each(function() {
            let $container = $(this);
            let isLeft = $container.hasClass("dtoc-left-top") ||
                         $container.hasClass("dtoc-left-middle") ||
                         $container.hasClass("dtoc-left-bottom");

            if (isLeft) {
                $container.css("left", -$container.outerWidth());
            } else {
                $container.css("right", -$container.outerWidth());
            }
        });
    });
});
