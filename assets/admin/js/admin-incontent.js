// React-like structure without React starts here

jQuery(document).ready(function($) {

    const default_state = dtoc_admin_modules_cdata.module_default_state;    
    const current_state = dtoc_admin_modules_cdata.module_state;        
    console.log(dtoc_admin_modules_cdata);

    // Proxy to trigger on any top-level set
    const reactive = new Proxy(current_state, {
        set(target, prop, value) {
            target[prop] = value;
            updatePreview();
            updateShortcode();
            return true;
        }
    });

    function updateShortcode() {
    let params = [];

    for (let key in reactive) {
        if (!reactive.hasOwnProperty(key)) continue;

        let currentVal = reactive[key];
        let defaultVal = default_state[key];

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


    function updatePreview() {
        if (reactive.jump_links) {
            $('.dtoc_jump_links').show();
        } else {
            $('.dtoc_jump_links').hide();
        }

        if (reactive.display_title) {
            $('.dtoc_display_title').show();

            if (reactive.toggle_body) {
                $('.dtoc_display_title.dtoc_2_label_child_opt').show();
                $('.dtoc_display_title.dtoc_3_label_child_opt').hide();

                if (reactive.header_icon === 'show_hide') {
                    $('.dtoc_display_title.dtoc_3_label_child_opt').show();
                }
                if (reactive.header_icon === 'custom_icon') {
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
            const value = reactive[$select.attr('id')];
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
            if (!reactive[dataId]) {
                reactive[dataId] = {};
            }
            const number = $input.data('number');
            if (number !== undefined) {
                const updated = { ...reactive[dataId] }; // clone object
                updated[number] = $input.is(':checked') ? 1 : 0;
                reactive[dataId] = updated; // replace → triggers Proxy set()
            }
        }
        else if ($input.is(':checkbox')) {
            reactive[dataId] = $input.is(':checked') ? 1 : 0;
        }
        else if ($input.is(':radio')) {
            reactive[dataId] = $input.val();
        }
        else {
            reactive[dataId] = $input.val();
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
                reactive.custom_css = editor.session.getValue(); // bind to state
            });
        });
    }

    updatePreview();
    updateShortcode();
});


//React like structure without react ends here