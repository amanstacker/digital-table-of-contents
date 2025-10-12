// React-like structure without React starts here

jQuery(document).ready(function($) {

    const default_state = dtoc_admin_modules_cdata.module_default_state;    
    const current_state = dtoc_admin_modules_cdata.module_state;        
    
    // Proxy to trigger on any top-level set
    const options = new Proxy(current_state, {
        set(target, prop, value) {
            target[prop] = value;
            updateSettings();
            updateShortcode();
            renderLivePreview();

            return true;
        }
    });

function dtocBoxContainerStyle(options = {}) {

    let style = '';
    
    // Background color
    if (options.bg_color) {
        style += `background-color:${options.bg_color};`;
    }

    // Width
    if (options.container_width_mode) {
        switch (options.container_width_mode) {
            case 'auto':
                style += 'width:auto;';
                break;
            case 'full':
                style += 'width:100%;';
                break;
            case 'fit-content':
                style += 'width:fit-content;';
                break;
            case 'custom':
                if (options.container_width && options.container_width_unit) {
                    style += `width:${options.container_width}${options.container_width_unit};`;
                }
                break;
        }
    }

    // Height
    if (options.container_height_mode) {
        switch (options.container_height_mode) {
            case 'auto':
                style += 'height:auto;';
                break;
            case 'full':
                style += 'height:100%;';
                break;
            case 'fit-content':
                style += 'height:fit-content;';
                break;
            case 'custom':
                if (options.container_height && options.container_height_unit) {
                    style += `height:${options.container_height}${options.container_height_unit};`;
                }
                break;
        }
    }

    // Margin
    if (options.container_margin_mode) {
        if (options.container_margin_mode === 'auto') {
            style += 'margin:auto;';
        } else if (options.container_margin_mode === 'custom') {
            const unit = options.container_margin_unit || 'px';
            style += `margin-top:${options.container_margin_top || 0}${unit};`;
            style += `margin-right:${options.container_margin_right || 0}${unit};`;
            style += `margin-bottom:${options.container_margin_bottom || 0}${unit};`;
            style += `margin-left:${options.container_margin_left || 0}${unit};`;
        }
    }

    // Padding
    if (options.container_padding_mode) {
        if (options.container_padding_mode === 'auto') {
            style += 'padding:auto;';
        } else if (options.container_padding_mode === 'custom') {
            const unit = options.container_padding_unit || 'px';
            style += `padding-top:${options.container_padding_top || 0}${unit};`;
            style += `padding-right:${options.container_padding_right || 0}${unit};`;
            style += `padding-bottom:${options.container_padding_bottom || 0}${unit};`;
            style += `padding-left:${options.container_padding_left || 0}${unit};`;
        }
    }

    // Border style
    if (options.border_type && options.border_type !== 'default') {
        style += `border-style:${options.border_type};`;
    }

    // Border color
    if (options.border_color) {
        style += `border-color:${options.border_color};`;
    }

    // Border width
    if (options.border_width_mode === 'custom' && options.border_width_unit) {
        const unit = options.border_width_unit;
        style += `border-top-width:${options.border_width_top || 0}${unit};`;
        style += `border-right-width:${options.border_width_right || 0}${unit};`;
        style += `border-bottom-width:${options.border_width_bottom || 0}${unit};`;
        style += `border-left-width:${options.border_width_left || 0}${unit};`;
    }

    // Border radius
    if (options.border_radius_mode === 'custom' && options.border_radius_unit) {
        const unit = options.border_radius_unit;
        style += `border-top-left-radius:${options.border_radius_top_left || 0}${unit};`;
        style += `border-top-right-radius:${options.border_radius_top_right || 0}${unit};`;
        style += `border-bottom-right-radius:${options.border_radius_bottom_right || 0}${unit};`;
        style += `border-bottom-left-radius:${options.border_radius_bottom_left || 0}${unit};`;
    }

    return style;
}

function dtocGetHeaderIcon(options = {}) {
    if (!options.header_icon || options.header_icon === 'none') return '';

    let iconHtml = '';
    let cStyle = '';

    // Accessibility setup
    const addAccessibility = options.accessibility === 1;
    const ariaLabel = 'Toggle Table of Contents';

    // Border style
    if (options.icon_border_type && options.icon_border_type !== 'default') {
        cStyle += `border-style:${options.icon_border_type};`;
    }

    // Border color
    if (options.icon_border_color) {
        cStyle += `border-color:${options.icon_border_color};`;
    }

    // Border width
    if (options.icon_border_width_mode === 'custom') {
        ['top', 'right', 'bottom', 'left'].forEach(side => {
            const key = `icon_border_width_${side}`;
            if (options[key] != null && options.icon_border_width_unit) {
                cStyle += `border-${side}-width:${options[key]}${options.icon_border_width_unit};`;
            }
        });
    }

    // Border radius
    if (options.icon_border_radius_mode === 'custom') {
        const corners = {
            top_left: 'top-left',
            top_right: 'top-right',
            bottom_right: 'bottom-right',
            bottom_left: 'bottom-left'
        };
        for (let key in corners) {
            const field = `icon_border_radius_${key}`;
            if (options[field] != null && options.icon_border_radius_unit) {
                cStyle += `border-${corners[key]}-radius:${options[field]}${options.icon_border_radius_unit};`;
            }
        }
    }

    // Margin
    if (options.icon_margin_mode === 'custom') {
        ['top', 'right', 'bottom', 'left'].forEach(side => {
            const key = `icon_margin_${side}`;
            if (options[key] != null && options.icon_margin_unit) {
                cStyle += `margin-${side}:${options[key]}${options.icon_margin_unit};`;
            }
        });
    }

    // Padding
    if (options.icon_padding_mode === 'custom') {
        ['top', 'right', 'bottom', 'left'].forEach(side => {
            const key = `icon_padding_${side}`;
            if (options[key] != null && options.icon_padding_unit) {
                cStyle += `padding-${side}:${options[key]}${options.icon_padding_unit};`;
            }
        });
    }

    // Size
    let iconWidth = '';
    let iconHeight = '';
    if (options.icon_size_mode === 'custom') {
        iconWidth = options.icon_width ? options.icon_width + (options.icon_size_unit || 'px') : '';
        iconHeight = options.icon_height ? options.icon_height + (options.icon_size_unit || 'px') : '';
        if (iconWidth) cStyle += `width:${iconWidth};`;
        if (iconHeight) cStyle += `height:${iconHeight};`;
    }

    const bgColor = options.icon_bg_color || 'transparent';
    const fgColor = options.icon_fg_color || '#000';

    // ICON HTML OUTPUT
    switch (options.header_icon) {
        case 'list_icon':
            if (options.icon_size_mode === 'custom') {
                iconWidth = options.icon_width ? options.icon_width + (options.icon_size_unit || 'px') : '35px';
                iconHeight = options.icon_height ? options.icon_height + (options.icon_size_unit || 'px') : '35px';
            } else {
                iconWidth = '35px';
                iconHeight = '35px';
            }

            iconHtml = `<span class="dtoc_icon_toggle"${addAccessibility ? ` role="button" aria-label="${ariaLabel}"` : ''}>
                <svg style="${cStyle}" width="${iconWidth}" height="${iconHeight}" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true">
                    <rect x="1" y="1" width="46" height="46" rx="4" stroke="#aaa" fill="${bgColor}"></rect>
                    <circle cx="10" cy="14" r="1.5" fill="${fgColor}"></circle>
                    <rect x="14" y="13" width="14" height="2" rx="1" fill="${fgColor}"></rect>
                    <circle cx="10" cy="24" r="1.5" fill="${fgColor}"></circle>
                    <rect x="14" y="23" width="14" height="2" rx="1" fill="${fgColor}"></rect>
                    <circle cx="10" cy="34" r="1.5" fill="${fgColor}"></circle>
                    <rect x="14" y="33" width="14" height="2" rx="1" fill="${fgColor}"></rect>
                    <path d="M36 18L32 22H40L36 18Z" fill="${fgColor}"></path>
                    <path d="M36 30L40 26H32L36 30Z" fill="${fgColor}"></path>
                </svg>
            </span>`;
            break;

        case 'plus_minus':
            iconHtml = `<span class="dtoc_icon_toggle" style="${cStyle}"${addAccessibility ? ` role="button" aria-label="${ariaLabel}"` : ''}>
                <span class="dtoc_icon_brackets">[</span>
                <span class="dtoc-show-text dtoc-plus">+</span>
                <span class="dtoc-hide-text dtoc-minus">-</span>
                <span class="dtoc_icon_brackets">]</span>
            </span>`;
            break;

        case 'show_hide':
            iconHtml = `<span class="dtoc_icon_toggle" style="${cStyle}"${addAccessibility ? ` role="button" aria-label="${ariaLabel}"` : ''}>
                <span class="dtoc_icon_brackets">[</span>
                <span class="dtoc-show-text">${options.show_text || 'Show'}</span>
                <span class="dtoc-hide-text">${options.hide_text || 'Hide'}</span>
                <span class="dtoc_icon_brackets">]</span>
            </span>`;
            break;

        case 'custom_icon':
            iconHtml = `<span class="dtoc_icon_toggle" style="${cStyle}"${addAccessibility ? ` role="button" aria-label="${ariaLabel}"` : ''}>
                <img src="${options.custom_icon_url || ''}" alt="${addAccessibility ? ariaLabel : 'Icon'}" />
            </span>`;
            break;
    }

    return iconHtml;
}

function dtocGetTitleStyle(options = {}) {
    let style = '';

    // Background color
    if (options.title_bg_color) {
        style += `background:${options.title_bg_color};`;
    }

    // Foreground color
    if (options.title_fg_color) {
        style += `color:${options.title_fg_color};`;
    }

    // Font size
    if (
        options.title_font_size_mode === 'custom' &&
        options.title_font_size != null &&
        !isNaN(options.title_font_size) &&
        options.title_font_size > 0 &&
        options.title_font_size_unit
    ) {
        style += `font-size:${options.title_font_size}${options.title_font_size_unit};`;
    }

    // Font weight
    if (
        options.title_font_weight_mode === 'custom' &&
        options.title_font_weight != null &&
        !isNaN(options.title_font_weight) &&
        options.title_font_weight > 0
    ) {
        style += `font-weight:${options.title_font_weight};`;
    }

    // Padding (custom mode)
    if (options.title_padding_mode === 'custom') {
        const top = parseInt(options.title_padding_top) || 0;
        const right = parseInt(options.title_padding_right) || 0;
        const bottom = parseInt(options.title_padding_bottom) || 0;
        const left = parseInt(options.title_padding_left) || 0;

        if (top > 0 || right > 0 || bottom > 0 || left > 0) {
            const unit = options.title_padding_unit || 'px';
            style += `padding:${top}${unit} ${right}${unit} ${bottom}${unit} ${left}${unit};`;
        }
    }

    return style;
}

    function dtocGetCustomStyle(options) {
	// Extract list style type safely
	const listStyleType = options?.list_style_type || 'decimal';

	// Default TOC CSS
	const defaultCSS = `
		.dtoc-box-container {                    
			display: table;       
			width: fit-content;     
			max-width: 100%;            
			overflow: hidden;
			height: fit-content;
			font-size: 20px;
			font-family: auto;
			line-height: 1.25;
		}        

		.dtoc-toggle-label {
			display: flex;    
			justify-content: space-between;        
			font-weight: 600;
			font-size: 100%;   
			padding: 10px;     
		}        

		span.dtoc_icon_toggle svg {
			vertical-align: middle;
		}

		.dtoc_icon_toggle img {
			width: 30px;
		}

		.dtoc_icon_toggle {
			font-weight: 400;
			font-size: 90%;
		}

		.dtoc-box-container ul {
			margin: auto;
			padding-left: 20px;
			list-style-type: ${listStyleType};
		}

		.dtoc-box-container ul ul {
			margin: revert;
			padding-left: 25px;
			list-style-type: ${listStyleType};
		}

		.dtoc-box-container ul li {
			font-size: 100%;
			margin-bottom: 0;
		}

		.dtoc-box-container a {                        
			text-decoration: none;                                    
		}         

		.dtoc-box-body {
			padding: 10px;
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


function dtocGetTocLinkStyle(options = {}, type = '') {
    
	let css = '.dtoc-box-body .dtoc-link {';

	if (type === 'sliding_sticky') {
		css = '.dtoc-sliding-sticky-box-body .dtoc-link {';
	}

	// Link color
	if (options.link_color) {
		css += `color: ${options.link_color};`;
	}

	// Padding
	if (options.link_padding_mode) {
		if (options.link_padding_mode === 'auto') {
			css += 'padding: auto;';
		} else if (options.link_padding_mode === 'custom') {
			const unit = options.link_padding_unit || 'px';
			const top = options.link_padding_top ? `${parseInt(options.link_padding_top)}${unit}` : `0${unit}`;
			const right = options.link_padding_right ? `${parseInt(options.link_padding_right)}${unit}` : `0${unit}`;
			const bottom = options.link_padding_bottom ? `${parseInt(options.link_padding_bottom)}${unit}` : `0${unit}`;
			const left = options.link_padding_left ? `${parseInt(options.link_padding_left)}${unit}` : `0${unit}`;
			css += `padding: ${top} ${right} ${bottom} ${left};`;
		}
	}

	// Margin
	if (options.link_margin_mode) {
		if (options.link_margin_mode === 'auto') {
			css += 'margin: auto;';
		} else if (options.link_margin_mode === 'custom') {
			const unit = options.link_margin_unit || 'px';
			const top = options.link_margin_top ? `${parseInt(options.link_margin_top)}${unit}` : `0${unit}`;
			const right = options.link_margin_right ? `${parseInt(options.link_margin_right)}${unit}` : `0${unit}`;
			const bottom = options.link_margin_bottom ? `${parseInt(options.link_margin_bottom)}${unit}` : `0${unit}`;
			const left = options.link_margin_left ? `${parseInt(options.link_margin_left)}${unit}` : `0${unit}`;
			css += `margin: ${top} ${right} ${bottom} ${left};`;
		}
	}

	css += '}';

	// Hover color
	if (options.link_hover_color) {
		if (type === 'sliding_sticky') {
			css += ' .dtoc-sliding-sticky-box-body .dtoc-link:hover {';
		} else {
			css += ' .dtoc-box-body .dtoc-link:hover {';
		}
		css += `color: ${options.link_hover_color};`;
		css += '}';
	}

	// Visited color
	if (options.link_visited_color) {
		if (type === 'sliding_sticky') {
			css += ' .dtoc-sliding-sticky-box-body .dtoc-link:visited {';
		} else {
			css += ' .dtoc-box-body .dtoc-link:visited {';
		}
		css += `color: ${options.link_visited_color};`;
		css += '}';
	}

	// Return full style element
	return `<style id="dtoc-link-css">${css}</style>`;
}


    function renderLivePreview(){

            $('.dtoc-preview-body').append('');
        	                        
            const html = `${dtocGetCustomStyle( options ) + dtocGetTocLinkStyle( options, 'incontent' ) }
            
                <div class="dtoc-box-container" style="${dtocBoxContainerStyle(options)}">
                ${options.display_title ? `
                    <div class="dtoc-toggle-label" style="${dtocGetTitleStyle(options)}">
                        <span class="dtoc-title-str">${
                            options.header_text === 'Table of Contents'
                                ? 'Table of Contents'
                                : options.header_text
                        }</span>
                        ${dtocGetHeaderIcon(options)}
                    </div>` : ''}                    
                    <div class="dtoc-box-body dtoc-box-on-js-body">
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
                `;
            $('.dtoc-preview-body').append(html);
    }


    function updateShortcode() {
    let params = [];

    for (let key in options) {
        if (!options.hasOwnProperty(key)) continue;

        let currentVal = options[key];
        let defaultVal = default_state?.[key] ?? '';

        // Special handling for headings_include → always include 1 to 6
        if (key === 'headings_include' && typeof currentVal === 'object') {
            let fixedObj = {};
            for (let i = 1; i <= 6; i++) {
                fixedObj[i] = currentVal[i] ? 1 : 0; // force 0/1
            }
            if (JSON.stringify(fixedObj) !== JSON.stringify(defaultVal)) {
                params.push(`${key}=${JSON.stringify(fixedObj)}`);
            }
        }
        else if (typeof currentVal === 'object' && currentVal !== null) {
            if (JSON.stringify(currentVal) !== JSON.stringify(defaultVal)) {
                params.push(`${key}=${JSON.stringify(currentVal)}`);
            }
        } 
        else {
            if (!isNaN(currentVal) && currentVal !== '' && currentVal !== null) {
                currentVal = Number(currentVal);
            }
            if (!isNaN(defaultVal) && defaultVal !== '' && defaultVal !== null) {
                defaultVal = Number(defaultVal);
            }

            if (currentVal !== defaultVal) {
                if (typeof currentVal === 'number' || typeof currentVal === 'boolean') {
                    params.push(`${key}=${currentVal}`);
                } else {
                    params.push(`${key}='${currentVal}'`);
                }
            }
        }
    }

    const shortcode = `[digital_toc${params.length ? ' ' + params.join(' ') : ''}]`;
    $('#dtoc_shortcode_source_textarea').val(shortcode);
}


    function updateSettings() {
        if (options.jump_links) {
            $('.dtoc_jump_links').show();
        } else {
            $('.dtoc_jump_links').hide();
        }

        if (options.display_title) {
            $('.dtoc_display_title').show();

            if (options.toggle_body) {
                $('.dtoc_display_title.dtoc_2_label_child_opt').show();
                $('.dtoc_display_title.dtoc_3_label_child_opt').hide();

                if (options.header_icon === 'show_hide') {
                    $('.dtoc_display_title.dtoc_3_label_child_opt').show();
                }
                if (options.header_icon === 'custom_icon') {
                    $('#custom-icon-wrapper').show();
                } else {
                    $('#custom-icon-wrapper').hide();
                }

            } else {
                $('.dtoc_display_title.dtoc_2_label_child_opt').hide();
            }

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

    // Change handler
    $('.dtoc-settings-form').on('change', '.smpg-input', function (e) {
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
    updateShortcode();
    renderLivePreview();
});


//React like structure without react ends here