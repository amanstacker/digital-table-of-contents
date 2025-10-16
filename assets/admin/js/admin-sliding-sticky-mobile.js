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
/* TOC Panel Common */
.dtoc-sliding-sticky-mobile-container {
  position: absolute;
  left: 0;
  right: 0;
  width: 100vw;
  max-width: 100%;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 15px 15px 0 0;
  box-shadow: 0 -2px 12px rgba(0, 0, 0, 0.3);
  max-height: 70%;
  transition: transform 0.3s ease-in-out;
  z-index: 1000;  
}

.dtoc-sliding-sticky-mobile-container ul {
  padding: 15px;
  margin: 0;
  list-style: ${listStyleType};
}
.dtoc-sliding-sticky-mobile-container li {
  margin-bottom: 10px;
}
.dtoc-sliding-sticky-mobile-container a {
  text-decoration: none;
  color: #0073aa;
}

/* Header / Handle */
.dtoc-sliding-sticky-mobile-header {
  text-align: center;
  padding: 8px;
  background: #f1f1f1;
  font-weight: bold;
  border-bottom: 1px solid #ddd;
  border-radius: 15px 15px 0 0;
  cursor: pointer;
  position: relative;  
}

/* Default arrow */
.dtoc-sliding-sticky-mobile-header::after {
  content: "";
  display: block;
  font-size: 14px;
  margin-top: 3px;
  opacity: 0.6;
}

/* =========================
   BOTTOM SHEET VARIANT
   ========================= */
.dtoc-bottom-sheet {
  bottom: 0;
  transform: translateY(calc(100% - 40px)); /* collapsed: only header visible */    
}
.dtoc-bottom-sheet.active {
  transform: translateY(0); /* expanded */
}

/* =========================
   TOP SHEET VARIANT
   ========================= */
.dtoc-top-sheet {
  top: 0;
  transform: translateY(-100%); /* collapsed: hide panel above viewport */  
}
.dtoc-top-sheet.active {
  transform: translateY(0); /* expanded: full panel slides down */
}

/* BUT: leave header visible when collapsed */
.dtoc-top-sheet .dtoc-sliding-sticky-mobile-header {
  position: absolute;
  top: 100%;   /* push header below the hidden panel */
  left: 0;
  right: 0;
  border-bottom: none;
  border-top: 1px solid #ddd;  
  background: #f1f1f1;
}

/* =========================
   Body Scroll Area
   ========================= */
.dtoc-sliding-sticky-mobile-box-body {
  overflow-y: auto;
  max-height: 300px;
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


    function renderLivePreview(){

            $('.dtoc-preview-body').html('');
                                           	                        
            const html = `
                <div class="dtoc-sliding-sticky-mobile-container dtoc-${options.display_position}" 
                    style="${dtocBoxContainerStyle(options)}">
                    
                    <div class="dtoc-sliding-sticky-mobile-header" 
                        style="${dtocGetTitleStyle(options)}">
                        ${options.header_text || ''}
                    </div>

                    ${dtocGetCustomStyle(options)}
                    ${dtocGetTocLinkStyle(options, 'sliding_sticky_mobile')}

                    <div class="dtoc-sliding-sticky-mobile-box-body">
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
              
            var $tocPanel = $(".dtoc-sliding-sticky-mobile-container");
            var $tocHeader = $tocPanel.find(".dtoc-sliding-sticky-mobile-header");

            $tocHeader.on("click", function(e) {
                e.preventDefault();
                $tocPanel.toggleClass("active");
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
    renderLivePreview();
});


//React like structure without react ends here