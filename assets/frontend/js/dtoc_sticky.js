
    jQuery(document).ready(function($) {
            
            var $container = $(".dtoc-sticky-container.dtoc-" + dtoc_localize_frontend_sticky_data.display_position );
            var $btn = $container.find(".dtoc-sticky-toggle-btn");

            // detect position (left or right side)
            var pos = dtoc_localize_frontend_sticky_data.display_position
            var side = pos.indexOf("left") !== -1 ? "left" : "right";

            // set initial hidden state
            if (side === "left") {
                $container.css({ left: "-" + $container.outerWidth() + "px" });
            } else {
                $container.css({ right: "-" + $container.outerWidth() + "px" });
            }

            // toggle slide
            $btn.on("click", function() {
                if ($container.hasClass("dtoc-open")) {
                    if (side === "left") {
                        $container.animate({ left: "-" + $container.outerWidth() + "px" }, 300);
                    } else {
                        $container.animate({ right: "-" + $container.outerWidth() + "px" }, 300);
                    }
                    $container.removeClass("dtoc-open");
                } else {
                    if (side === "left") {
                        $container.animate({ left: "0px" }, 300);
                    } else {
                        $container.animate({ right: "0px" }, 300);
                    }
                    $container.addClass("dtoc-open");
                }
            });
    });
    