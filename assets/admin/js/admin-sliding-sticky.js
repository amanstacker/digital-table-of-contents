// React-like structure without React starts here

jQuery(document).ready(function($) {

    const default_state = dtoc_admin_modules_cdata.module_default_state;    
    const current_state = dtoc_admin_modules_cdata.module_state;        

    // Proxy to trigger on any top-level set
    const options = new Proxy(current_state, {
        set(target, prop, value) {
            target[prop] = value;
            updateSettings();  
            renderLivePreview();          
            return true;
        }
    });



    function dtocGetCustomStyle(options) {
	// Extract list style type safely
	const listStyleType = options?.list_style_type || 'decimal';

	// Default TOC CSS
	const defaultCSS = `
		.dtoc-sliding-sticky-container {
            position: absolute;  
            background: #f5f5f5;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.2);
            transition: transform 0.3s;
            z-index: 1000;  
            width: auto;           /* grows with content */
            max-width: 350px;      /* don’t exceed this width */  
            padding: 0; 
            margin: 0;           /* padding inside inner wrapper */
            box-sizing: border-box;  
            font-size: 18px;
			font-family: auto;
        }

/* Inner wrapper scrollable content */
.dtoc-sliding-sticky-inner {
  max-height: 100vh;
  overflow-y: auto;  
  padding: 15px; /* inner padding */
  padding-left:38px;
}

/* TOC list */
.dtoc-sliding-sticky-container ul {
  list-style-type: ${listStyleType};
  padding-left: 0;
}
.dtoc-sliding-sticky-container li {
  margin-bottom: 10px;
}
.dtoc-sliding-sticky-container a {
  text-decoration: none;
  color: #0073aa;
}

/* Toggle button */
.dtoc-sliding-sticky-toggle-btn {
  position: absolute;    
  padding: 12px 15px;
  cursor: pointer;  
  font-size: 14px;
  user-select: none;
  transition: background 0.3s;
  box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
  outline: none;      /* removes default outline */  
  border: none;
}
.dtoc-sliding-sticky-toggle-btn:hover {
  background: #005177;
}

/* Toggle button border-radius */
.dtoc-left-top .dtoc-sliding-sticky-toggle-btn,
.dtoc-left-middle .dtoc-sliding-sticky-toggle-btn,
.dtoc-left-bottom .dtoc-sliding-sticky-toggle-btn {
  border-radius: 0 0 8px 8px;
}

.dtoc-right-top .dtoc-sliding-sticky-toggle-btn,
.dtoc-right-middle .dtoc-sliding-sticky-toggle-btn,
.dtoc-right-bottom .dtoc-sliding-sticky-toggle-btn {
  border-radius: 0 0 8px 8px;
}

/* ---------------- LEFT SIDE ---------------- */
.dtoc-left-top { top: 0; left: 0; }
.dtoc-left-middle { top: 0; left: 0; }
.dtoc-left-bottom { top: 0; left: 0;}

/* Toggle button left side */
.dtoc-left-top .dtoc-sliding-sticky-toggle-btn { top: 60px; right: -54px; transform: rotate(-90deg); }
.dtoc-left-middle .dtoc-sliding-sticky-toggle-btn { top: 50%; right: -54px; transform: translateY(-50%) rotate(-90deg); }
.dtoc-left-bottom .dtoc-sliding-sticky-toggle-btn { bottom: 60px; right: -54px; transform: rotate(-90deg); }

/* ---------------- RIGHT SIDE ---------------- */
.dtoc-right-top { top: 0; right: 0; left: auto;  }
.dtoc-right-middle { top: 0; right: 0; left: auto;  }
.dtoc-right-bottom { top: 0; right: 0; left: auto;  }

/* Toggle button right side */
.dtoc-right-top .dtoc-sliding-sticky-toggle-btn { top: 60px; left: -54px; transform: rotate(90deg); }
.dtoc-right-middle .dtoc-sliding-sticky-toggle-btn { top: 50%; left: -54px; transform: translateY(-50%) rotate(90deg); }
.dtoc-right-bottom .dtoc-sliding-sticky-toggle-btn { bottom: 60px; left: -54px; transform: rotate(90deg); }

.dtoc-sliding-sticky-title-str {
  font-weight: 600;
  display: block;
  margin-bottom: 10px;
}
	`;

	// If no custom CSS provided
	if (!options.custom_css) {
		return `<style id="dtoc-custom-css">${defaultCSS}</style>`;
	}

	// Sanitize custom CSS: strip HTML tags and trim
	const customCSS = options.custom_css.replace(/<\/?[^>]+(>|$)/g, '').trim();

	// Combine default + custom CSS safely
	const finalCSS = defaultCSS + (customCSS ? `\n${customCSS}` : '');

	return `<style id="dtoc-custom-css">${finalCSS}</style>`;
}

function dtocGetToggleBtnStyle(options = {}) {
    let style = '';

    // Background color
    if (options.toggle_btn_bg_color) {
        style += `background:${options.toggle_btn_bg_color};`;
    }

    // Foreground color
    if (options.toggle_btn_fg_color) {
        style += `color:${options.toggle_btn_fg_color};`;
    }

    // Size (only if mode is custom)
    if (options.toggle_btn_size_mode === 'custom') {
        const width = options.toggle_btn_width ? parseInt(options.toggle_btn_width, 10) : 0;
        const height = options.toggle_btn_height ? parseInt(options.toggle_btn_height, 10) : 0;
        const unit = options.toggle_btn_size_unit || 'px';

        if (width > 0) style += `width:${width}${unit};`;
        if (height > 0) style += `height:${height}${unit};`;
    }

    // Border type
    if (options.toggle_btn_border_type && options.toggle_btn_border_type !== 'default') {
        style += `border-style:${options.toggle_btn_border_type};`;
    }

    // Border color
    if (options.toggle_btn_border_color) {
        style += `border-color:${options.toggle_btn_border_color};`;
    }

    // Border width (only if custom)
    if (options.toggle_btn_border_width_mode === 'custom') {
        const top = options.toggle_btn_border_width_top || 0;
        const right = options.toggle_btn_border_width_right || 0;
        const bottom = options.toggle_btn_border_width_bottom || 0;
        const left = options.toggle_btn_border_width_left || 0;

        if (top || right || bottom || left) {
            const unit = options.toggle_btn_border_width_unit || 'px';
            style += `border-width:${top}${unit} ${right}${unit} ${bottom}${unit} ${left}${unit};`;
        }
    }

    // Border radius (only if custom)
    if (options.toggle_btn_border_radius_mode === 'custom') {
        const tl = options.toggle_btn_border_radius_top_left || 0;
        const tr = options.toggle_btn_border_radius_top_right || 0;
        const br = options.toggle_btn_border_radius_bottom_right || 0;
        const bl = options.toggle_btn_border_radius_bottom_left || 0;

        if (tl || tr || br || bl) {
            const unit = options.toggle_btn_border_radius_unit || 'px';
            style += `border-radius:${tl}${unit} ${tr}${unit} ${br}${unit} ${bl}${unit};`;
        }
    }

    // Padding (only if custom)
    if (options.toggle_btn_padding_mode === 'custom') {
        const top = options.toggle_btn_padding_top || 0;
        const right = options.toggle_btn_padding_right || 0;
        const bottom = options.toggle_btn_padding_bottom || 0;
        const left = options.toggle_btn_padding_left || 0;

        if (top || right || bottom || left) {
            const unit = options.toggle_btn_padding_unit || 'px';
            style += `padding:${top}${unit} ${right}${unit} ${bottom}${unit} ${left}${unit};`;
        }
    }

    return style;
}
    function renderLivePreview(){

            $('.dtoc-preview-body').html('');
            
            const initialState = options.toggle_initial ? options.toggle_initial : 'hide';
            const initialClass = initialState === 'show' ? ' dtoc-open' : ' dtoc-closed';

            // Detect if positioned on the left
            const isLeft = options.display_position && options.display_position.includes('left');
            
            let dbcStyle = dtocBoxContainerStyle( options );
            if (initialState === 'show') {
                dbcStyle += isLeft ? 'left:0;' : 'right:0;';
            } else {
                dbcStyle += isLeft ? 'left:-300px;visibility:hidden;' : 'right:-300px;visibility:hidden;';
            }            

        	                        
            const html = `${dtocGetCustomStyle( options ) + dtocGetTocLinkStyle( options, 'sliding_sticky' ) }
                <div class="dtoc-sliding-sticky-container dtoc-${options.display_position || ''}${initialClass}" style="${dbcStyle}">
                <button type="button" class="dtoc-sliding-sticky-toggle-btn" style="${dtocGetToggleBtnStyle(options)}">${options.toggle_btn_text ? options.toggle_btn_text : 'Index'}</button>
                <div class="dtoc-sliding-sticky-inner">

                ${options.display_title ? `
                    <span class="dtoc-sliding-sticky-title-str" style="${dtocGetTitleStyle(options)}">
                ${options.header_text || ''}
                    </span>
                ` : ''}
                    <div class="dtoc-sliding-sticky-box-body">
                        <ul>
                                <li><a href="#" class="dtoc-link dtoc-heading-2" aria-label="Introduction">Introduction</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-3" aria-label="Why a TOC Is Important">Why a TOC Is Important</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-4" aria-label="Improves Readability">Improves Readability</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-5" aria-label="Enhances SEO">Enhances SEO</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-13" aria-label="Formatting Elements">Formatting Elements</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-14" aria-label="Bold, Italic, and Links">Bold, Italic, and Links</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-16" aria-label="Code Snippets">Code Snippets</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-18" aria-label="Unordered List">Unordered List</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-20" aria-label="Table Example">Table Example</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-25" aria-label="Advanced TOC Testing">Advanced TOC Testing</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-27" aria-label="Dynamic Headings (JavaScript Loaded)">Dynamic Headings (JavaScript Loaded)</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-29" aria-label="Accessibility & Performance">Accessibility & Performance</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-33" aria-label="Best Practices for Developers">Best Practices for Developers</a></li>
                                <li><a href="#" class="dtoc-link dtoc-heading-37" aria-label="Conclusion">Conclusion</a></li>
                        </ul>
                    </div>
                </div>
            </div>`;

        $('.dtoc-preview-body').append(html);

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
            
    }

    function updateSettings() {
        
        if (options.jump_links) {
            $('.dtoc_jump_links').show();
        } else {
            $('.dtoc_jump_links').hide();
        }
        if (options.toggle_body) {
            $('.dtoc_toggle_body').show();
        } else {
            $('.dtoc_toggle_body').hide();
        }

        if (options.display_title) {
            $('.dtoc_display_title').show();            
        } else {
            $('.dtoc_display_title').hide();
        }

        $('.smpg-mode-select').each(function () {
            const $select = $(this);
            const group = $select.data('group');
            const value = options[$select.attr('id')];
            const $related = $('[data-group="' + group + '"]').not($select);

            if (value === 'custom') {
                $related.show();
            } else {
                $related.hide();
            }
        });
    }

    $('.dtoc-icon-upload').on('click', function(e) {
        e.preventDefault();

        const file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload Icon',
            button: {
                text: 'Use this icon',
            },
            multiple: false
        });

        file_frame.on('select', function() {
            const attachment = file_frame.state().get('selection').first().toJSON();
            $('#custom_icon_url').val(attachment.url);
            $('#custom-icon-preview').attr('src', attachment.url).show();

            if (typeof options !== 'undefined') {
		    	options.custom_icon_url = attachment.url;
		    }
        });

        file_frame.open();
    });

    // Change handler
    $('.dtoc-settings-form').on('input change', '.smpg-input', function (e) {
        const $input = $(e.target);
        const dataId = $input.data('id') || $input.attr('id');
        if (!dataId) return;

        if ($input.is(':checkbox') && dataId === 'headings_include') {
            if (!options[dataId]) {
                options[dataId] = {};
            }
            const number = $input.data('number');
            if (number !== undefined) {
                const updated = { ...options[dataId] }; // clone object
                updated[number] = $input.is(':checked') ? 1 : 0;
                options[dataId] = updated; // replace → triggers Proxy set()
            }
        }
        else if ($input.is(':checkbox')) {
            options[dataId] = $input.is(':checked') ? 1 : 0;
        }
        else if ($input.is(':radio')) {
            options[dataId] = $input.val();
        }
        else {
            options[dataId] = $input.val();
        }
    });
     
    // Init colorpickers (guard to avoid double init)
    $('.dtoc-settings-form .dtoc-colorpicker').each(function(){
        var $inp = $(this);
        if ($inp.data('dtoc-wpcolor-inited')) return;
        $inp.data('dtoc-wpcolor-inited', true);

        $inp.wpColorPicker({
        change: function(event, ui) {
            var $t = $(this);
            if (ui && ui.color) {
            try {
                // ensures rgba/hex (alpha-aware) is set
                $t.val(ui.color.toString());
            } catch (err) {
                // fallback: leave existing input value
            }
            }
            // trigger both input & change so delegated handlers catch it
            $t.trigger('input').trigger('change');
        },
        clear: function() {
            var $t = $(this);
            $t.val('');
            $t.trigger('input').trigger('change');
        }
        });
    });

    // 🔹 Init Ace Editor inside same block
    var $editors = $('.dtoc_custom_styles');
    if ($editors.length) {
        $editors.each(function () {
            var editorElement = this;
            var editor = ace.edit(editorElement);
            editor.setTheme("ace/theme/monokai");
            editor.session.setMode("ace/mode/css");

            ace.require("ace/ext/language_tools");
            editor.setOptions({
                enableBasicAutocompletion: true,
                enableLiveAutocompletion: true,
                enableSnippets: true
            });

            var $customCssTarget = $('#custom_css');
            // Set initial value from textarea
            editor.session.setValue($customCssTarget.val());

            // Update textarea & trigger preview on change
            editor.session.on('change', function () {
                $customCssTarget.val(editor.session.getValue());
                options.custom_css = editor.session.getValue(); // bind to state
            });
        });
    }

    updateSettings();    
    renderLivePreview();
});


//React like structure without react ends here