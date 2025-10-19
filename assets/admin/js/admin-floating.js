// React-like structure without React starts here

jQuery(document).ready(function($) {

    const default_state = dtoc_admin_modules_cdata.module_default_state;    
    const current_state = dtoc_admin_modules_cdata.module_state;        
    console.log(dtoc_admin_modules_cdata);

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
		.dtoc-box-container {                    
			display: table;       
			width: fit-content;     
			max-width: 100%;            
			overflow: hidden;
			height: fit-content;
			font-size: 18px;
			font-family: auto;
			line-height: 1.25;
		}        
        .dtoc-title-str{
            padding-right:10px;
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
			padding-left: 25px;
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

    function renderLivePreview() {
    $('.dtoc-preview-body').html('');

    // Determine scroll behavior based on jump_links
    const scrollBehavior = options.jump_links ? options.scroll_behavior : 'auto';

    // TOC container alignment
    let tocContainerStyle = dtocBoxContainerStyle(options);
    if (options.alignment === 'left') tocContainerStyle += ' margin-left: 0; margin-right: auto;';
    else if (options.alignment === 'center') tocContainerStyle += ' margin-left: auto; margin-right: auto;';
    else if (options.alignment === 'right') tocContainerStyle += ' margin-left: auto; margin-right: 0;';

    // TOC hierarchy classes
    const hierarchyClass = options.hierarchy ? 'dtoc-hierarchy' : '';

    // Helper to generate TOC links
    function getTocLink(headingId, headingClass, headingText) {
        const href = options.jump_links ? `#${headingId}` : 'javascript:void(0)';
        return `<li><a href="${href}" class="dtoc-link ${headingClass}">${headingText}</a></li>`;
    }

    // Build TOC HTML
    const tocHtml = `${dtocGetCustomStyle(options) + dtocGetTocLinkStyle(options, 'incontent')}
        <div class="dtoc-box-container ${hierarchyClass}" style="${tocContainerStyle}">
            ${options.display_title ? `
                <div class="dtoc-toggle-label" style="${dtocGetTitleStyle(options)}">
                    <span class="dtoc-title-str">${
                        options.header_text === 'Table of Contents'
                            ? 'Table of Contents'
                            : options.header_text
                    }</span>
                    ${dtocGetHeaderIcon(options)}
                </div>` : ''}                    
            <div class="dtoc-box-body" style="${
                options.toggle_body
                    ? (options.toggle_initial === 'show' ? '' : 'display:none;')
                    : ''
            }">
                <ul>
                    ${getTocLink('heading1', 'dtoc-heading-1', 'Introduction')}
                    ${getTocLink('heading2', 'dtoc-heading-2', 'Key Features Overview')}
                    ${getTocLink('heading3', 'dtoc-heading-3', 'Modular TOC System')}
                    ${getTocLink('heading4', 'dtoc-heading-4', 'Auto Insertion & Positioning')}
                    ${getTocLink('heading5', 'dtoc-heading-5', 'Heading Hierarchy Support')}
                    ${getTocLink('heading6', 'dtoc-heading-2', 'Smooth Scrolling & Accessibility')}
                    ${getTocLink('heading7', 'dtoc-heading-3', 'Rendering Styles & Icons')}
                    ${getTocLink('heading8', 'dtoc-heading-4', 'Full Customization & CSS')}
                    ${getTocLink('heading9', 'dtoc-heading-5', 'Import / Export & Reset')}
                    ${getTocLink('heading10', 'dtoc-heading-3', 'Shortcode Module')}
                    ${getTocLink('heading11', 'dtoc-heading-4', 'Available Modules')}
                    ${getTocLink('heading12', 'dtoc-heading-2', 'Conclusion & Testing')}
                </ul>
            </div>
        </div>
    `;

    // Build content HTML (wrap removed)
    const contentHtml = `
        <div class="dtoc-demo-content">
            <h1 id="heading1">Introduction</h1>
            <p>This section introduces the Digital TOC plugin and demonstrates live preview behavior.</p>
            <h2 id="heading2">Key Features Overview</h2>
            <p>Digital TOC offers a modular system with full customization and accessibility features.</p>
            <h3 id="heading3">Modular TOC System</h3>
            <p>Each TOC feature is separated into modules for easier management and flexibility.</p>
            <h4 id="heading4">Auto Insertion & Positioning</h4>
            <p>Automatically insert TOC before/after headings, top/bottom, or after a specific paragraph.</p>
            <h5 id="heading5">Heading Hierarchy Support</h5>
            <p>Supports H1 to H6 headings for proper hierarchical TOC generation.</p>
            <h2 id="heading6">Smooth Scrolling & Accessibility</h2>
            <p>Enables smooth scrolling and adds ARIA attributes for better accessibility.</p>
            <h3 id="heading7">Rendering Styles & Icons</h3>
            <p>Choose CSS or JavaScript rendering with multiple icon styles.</p>
            <h4 id="heading8">Full Customization & CSS</h4>
            <p>Customize colors, backgrounds, borders, links, and add custom CSS if needed.</p>
            <h5 id="heading9">Import / Export & Reset</h5>
            <p>Backup and transfer TOC settings, or reset plugin data completely.</p>
            <h3 id="heading10">Shortcode Module</h3>
            <p>Insert TOC anywhere using a simple shortcode with live preview.</p>
            <h4 id="heading11">Available Modules</h4>
            <p>In-Content, Mobile, Shortcode, Sliding Sticky, and Floating TOC modules available.</p>
            <h2 id="heading12">Conclusion & Testing</h2>
            <p>All headings are jump-link enabled, making it easy to test TOC hierarchy and toggle behavior.</p>
        </div>
    `;

    // Apply scroll behavior and max height
    $('.dtoc-preview-body').css({
        'max-height': '600px',        
        'overflow-y': 'auto',
        'scroll-behavior': scrollBehavior
    });
    $('.dtoc-demo-content').css({
        'max-height': '600px',
        'overflow-y': 'auto',
        'scroll-behavior': options.jump_links ? options.scroll_behavior : 'auto'
    });
        
    $('.dtoc-preview-body').append(tocHtml + contentHtml);

    // TOC toggle functionality
    if (options.toggle_body) {
        $('.dtoc-toggle-label').off('click').on('click', function () {
            const $container = $(this).closest('.dtoc-box-container');
            const $body = $container.find('.dtoc-box-body');
            $body.slideToggle(200);
            $(this).toggleClass('dtoc-open');
        });
    }

    // Jump link click behavior
    if (options.jump_links) {
        $('.dtoc-link').off('click').on('click', function (e) {
            e.preventDefault();
            const target = $($(this).attr('href'));
            if (target.length) {
                $('.dtoc-demo-content').animate(
                    { scrollTop: target.offset().top - $('.dtoc-demo-content').offset().top + $('.dtoc-demo-content').scrollTop() },
                    400
                );
            }
        });
    }


    // Make TOC draggable inside the preview
    const $tocBox = $('.dtoc-box-container');
    $tocBox.css({
        'cursor': 'move',
        'position': 'absolute',
        'z-index': 99
    });

    let isDragging = false;
    let offsetX, offsetY;

    $tocBox.off('mousedown').on('mousedown', function (e) {
        isDragging = true;
        offsetX = e.pageX - $(this).offset().left;
        offsetY = e.pageY - $(this).offset().top;
        $(this).css('opacity', 0.85);
    });

    $(document).off('mousemove').on('mousemove', function (e) {
        if (isDragging) {
            const $preview = $('.dtoc-preview-body');
            const previewOffset = $preview.offset();
            const maxLeft = previewOffset.left + $preview.width() - $tocBox.outerWidth();
            const maxTop = previewOffset.top + $preview.height() - $tocBox.outerHeight();

            // Constrain movement inside preview
            let left = Math.min(Math.max(e.pageX - offsetX, previewOffset.left), maxLeft);
            let top = Math.min(Math.max(e.pageY - offsetY, previewOffset.top), maxTop);

            $tocBox.css({
                left: left - previewOffset.left + 'px',
                top: top - previewOffset.top + 'px'
            });
        }
    });

    $(document).off('mouseup').on('mouseup', function () {
        if (isDragging) {
            isDragging = false;
            $tocBox.css('opacity', 1);
        }
    });
    
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