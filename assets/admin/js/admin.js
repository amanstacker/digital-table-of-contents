
function getParameterByName(name, url) {
    if (!url){
    url = window.location.href;    
    } 
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return "";
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function dtocGetHeaderIcon(options = {}) {
    if (!options.header_icon || options.header_icon === 'none') return '';

    let iconHtml = '';
    let cStyle = '';

    // Accessibility setup
    const addAccessibility = options.accessibility === 1;
    const ariaLabel = 'Icon';

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
        options.title_font_size &&
        !isNaN(options.title_font_size) &&
        Number(options.title_font_size) > 0 &&
        options.title_font_size_unit
    ) {
        style += `font-size:${options.title_font_size}${options.title_font_size_unit};`;
    }

    // Font weight
    if (
        options.title_font_weight_mode === 'custom' &&
        options.title_font_weight &&
        !isNaN(options.title_font_weight) &&
        Number(options.title_font_weight) > 0
    ) {
        style += `font-weight:${options.title_font_weight};`;
    }

    // Padding (only if mode is custom and any value > 0)
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
            style += `margin-top:${options.container_margin_top}${unit};`;
            style += `margin-right:${options.container_margin_right}${unit};`;
            style += `margin-bottom:${options.container_margin_bottom}${unit};`;
            style += `margin-left:${options.container_margin_left}${unit};`;
        }
    }

    // Padding
    if (options.container_padding_mode) {
        if (options.container_padding_mode === 'auto') {
            style += 'padding:auto;';
        } else if (options.container_padding_mode === 'custom') {
            const unit = options.container_padding_unit || 'px';
            style += `padding-top:${options.container_padding_top}${unit};`;
            style += `padding-right:${options.container_padding_right}${unit};`;
            style += `padding-bottom:${options.container_padding_bottom}${unit};`;
            style += `padding-left:${options.container_padding_left}${unit};`;
        }
    }

    // Border type (style)
    if (options.border_type && options.border_type !== 'default') {
        style += `border-style:${options.border_type};`;
    }

    // Border color
    if (options.border_color) {
        style += `border-color:${options.border_color};`;
    }

    // Border width (custom mode only)
    if (options.border_width_mode === 'custom' && options.border_width_unit) {
        const unit = options.border_width_unit;
        style += `border-top-width:${options.border_width_top}${unit};`;
        style += `border-right-width:${options.border_width_right}${unit};`;
        style += `border-bottom-width:${options.border_width_bottom}${unit};`;
        style += `border-left-width:${options.border_width_left}${unit};`;
    }

    // Border radius (custom mode only)
    if (options.border_radius_mode === 'custom' && options.border_radius_unit) {
        const unit = options.border_radius_unit;
        style += `border-top-left-radius:${options.border_radius_top_left}${unit};`;
        style += `border-top-right-radius:${options.border_radius_top_right}${unit};`;
        style += `border-bottom-right-radius:${options.border_radius_bottom_right}${unit};`;
        style += `border-bottom-left-radius:${options.border_radius_bottom_left}${unit};`;
    }

    return style;
}

jQuery(document).ready(function($){

  // accordion js starts here

    var acc = document.getElementsByClassName("dtoc-accordion-header");
    var i;

    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function(e) {
        e.preventDefault();
        this.classList.toggle("dtoc-active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        } 
      });
    }
  // accordion js ends here

    $(".dtoc-tabs a").click(function(e){
        e.preventDefault();
        var href = $(this).attr('href');     
                   
        var currentTab = getParameterByName('tab',href);
        console.log(currentTab);
        if(!currentTab){
          currentTab = "general";
        }                                                                
        $(this).siblings().removeClass("nav-tab-active");
        $(this).addClass("nav-tab-active");
        $(".dtoc-settings-form-wrap").find(".dtoc-"+currentTab).siblings().hide();
        $(".dtoc-settings-form-wrap .dtoc-"+currentTab).show();
        window.history.pushState("", "", href);
    }); 

    $(".dtoc-placement-checked").on("click", function(e){
      e.stopPropagation();
    });

    // Select2 starts here

        $(".dtoc-placement-ope").on("click", function(e){
          e.preventDefault();
          var opt_text = $(this).text();          
          if(opt_text === 'OR'){
            $(this).text('AND');
            $(this).parent().find('input').val('AND');
          }
          if(opt_text === 'AND'){
            $(this).text('OR');
            $(this).parent().find('input').val('OR');
          }          
        });
   
        $('.dtoc-placement-select2').select2({
            ajax: {                
                url: dtoc_admin_cdata.ajaxurl,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  console.log($(this).find(":selected").data("name"));
                  return {
                    action: 'dtoc_categories_action', // AJAX action for admin-ajax.php
                    security: dtoc_admin_cdata.dtoc_ajax_nonce,
                    q: params.term, // search term                    
                  };
                },
                processResults: function (data, params) {                              
                  return {
                    results: data.results                    
                  };
                },
                cache: true
            },
            minimumInputLength: 1, // the minimum of symbols to input before perform a search
            maximumSelectionLength: 100,
            placeholder: "Search...",
        });
    
    // Select2 ends here
});




jQuery(function($) {
	
	$('.dtoc-grid-checkbox').change(function(e){
    let checkbox = $(this);
    let checked = checkbox.prop('checked');
    let module_name = $(this).attr('name');
	let loader = $(this).parent().parent().children(".dtoc-loader");
	let settings = $(this).parent().parent().parent().children(".dtoc-grid-settings");
	loader.show();
    $.ajax({
        type: "post",
        dataType: "json",
        url: dtoc_admin_cdata.ajaxurl,
        data: {
            action: 'dtoc_update_modules_status', 
            module: module_name,
            status: checked,
			security:dtoc_admin_cdata.dtoc_ajax_nonce
        },
        success: function(response){
            if(response.status == 'success'){
                loader.hide();
				if(checked){
					settings.show();
					$('a[href="admin.php?page=dtoc_'+module_name+'"]').css('display','block');
				}else{
					settings.hide();
					$('a[href="admin.php?page=dtoc_'+module_name+'"]').css('display','none');
				}
            }else{
				 loader.hide();
			     checkbox.prop('checked',!checked);
			}
        },
        error: function(xhr, status, error){
            alert('Error occured while saving option');
            loader.hide();
			checkbox.prop('checked',!checked);
        }
    });
});


    $( ".dtoc-grid-checkbox" ).each(function( index ) {
		let name = $(this).attr('name');
		if($(this).prop("checked")){
			$(this).children('.dtoc-grid-settings').css('display','block');
			$('a[href="admin.php?page=dtoc_'+name+'"]').css('display','block');
		}else{
			$(this).children('.dtoc-grid-settings').css('display','none');
			$('a[href="admin.php?page=dtoc_'+name+'"]').css('display','none');
		}
	});
	
	if(dtoc_admin_cdata.modules_status){
		$.each(dtoc_admin_cdata.modules_status, function( index, value ) {
			if(value){
				$('a[href="admin.php?page=dtoc_'+index+'"]').css('display','block');
			}else{
				$('a[href="admin.php?page=dtoc_'+index+'"]').css('display','none');
			}
		});		
	}
	    

});

jQuery(document).ready(function($) {
    $('#dtoc-export-button').on('click', function(e) {
        e.preventDefault();
		 $('#dtoc-export-loader').show();
        $.ajax({
            url: dtoc_admin_cdata.ajaxurl,
            method: 'POST',
            data: {
                action: 'dtoc_export_options',
                nonce: dtoc_admin_cdata.dtoc_ajax_nonce // Include the nonce in the request
            },
            success: function(response) {
                if (response.success) {
                    const blob = new Blob([JSON.stringify(response.data, null, 2)], { type: 'application/json' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'dtoc-settings.json';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
	
                } else {
                    alert(response.data); // Handle error
                }
				$('#dtoc-export-loader').hide();
            },
            error: function() {
				$('#dtoc-export-loader').hide();
                alert('An error occurred while exporting the settings.');
            }
        });
    });

    // Import functionality
    $('#dtoc-import-button').on('click', function(e) {
        e.preventDefault();
        const fileInput = $('input[name="import_file"]')[0];

        if (fileInput.files.length === 0) {
            alert('Please select a file to upload.');
            return;
        }

        // Show the loader
        $('#dtoc-import-loader').show();

        const formData = new FormData();
        formData.append('action', 'dtoc_import_options');
        formData.append('nonce', dtoc_admin_cdata.dtoc_ajax_nonce);
        formData.append('import_file', fileInput.files[0]);

        $.ajax({
            url: dtoc_admin_cdata.ajaxurl,
            method: 'POST',
            data: formData,
            processData: false, // Important for file uploads
            contentType: false, // Important for file uploads
            success: function(response) {
                $('#dtoc-import-loader').hide();
                if (response.success) {
                    alert(response.data); 
                } else {
                    alert(response.data); 
                }
            },
            error: function() {
                $('#dtoc-import-loader').hide();
                alert('An error occurred while importing the settings.');
            }
        });
    });
});

/* support form request starts here */
jQuery(document).ready(function($) {
  $('#dtoc_support_submit').on('click', function(e) {
      e.preventDefault();

      var name = $('#dtoc_support_name').val();
      var email = $('#dtoc_support_email').val();
      var message = $('#dtoc_support_message').val();
      var security = dtoc_admin_cdata.dtoc_ajax_nonce;

      if (name === '' || email === '' || message === '') {
          $('#dtoc_support_response').html('<div class="notice notice-error is-dismissible"><p>All fields are required.</p></div>');
          return;
      }

      $.ajax({
          url: ajaxurl,
          type: 'POST',
          data: {
              action: 'dtoc_submit_support',
              security: security,
              name: name,
              email: email,
              message: message
          },
          beforeSend: function() {
              $('#dtoc_support_response').html('<div class="notice notice-info"><p>Submitting your request...</p></div>');
          },
          success: function(response) {
              if (response.success) {
                  $('#dtoc_support_response').html('<div class="notice notice-success is-dismissible"><p>' + response.data + '</p></div>');
                  $('#dtoc_support_name, #dtoc_support_email, #dtoc_support_message').val('');
              } else {
                  $('#dtoc_support_response').html('<div class="notice notice-error is-dismissible"><p>' + response.data + '</p></div>');
              }
          },
          error: function() {
              $('#dtoc_support_response').html('<div class="notice notice-error is-dismissible"><p>Submission failed. Please try again.</p></div>');
          }
      });
  });
});

/* support form request ends here */

/* reset plugin data starts here */

jQuery(document).ready(function ($) {

    let resetInput = $("#dtoc-reset-input");
    let resetButton = $("#dtoc-reset-button");
    let resetMessage = $("#dtoc-reset-message");
    let security = dtoc_admin_cdata.dtoc_ajax_nonce;

    resetInput.on("input", function () {
        if ($.trim(resetInput.val().toLowerCase()) === "reset") {
            resetButton.prop("disabled", false);
        } else {
            resetButton.prop("disabled", true);
        }
    });

    resetButton.on("click", function () {
        if (confirm("Are you sure you want to reset all options? This action cannot be undone.")) {
            $.ajax({
                url: ajaxurl, // WordPress AJAX URL
                type: "POST",
                data: {
                    action: "dtoc_reset_options",
                    security: security,
                },
                beforeSend: function () {
                    resetButton.prop("disabled", true);
                    resetMessage.html('<p style="color: blue;">Resetting options...</p>');
                },
                success: function (response) {
                     resetMessage.html('<p style="color: green;">' + response.data.message + '</p>');
                        setTimeout(function () {
                            location.reload(); // Reload page after 2 seconds
                        }, 2000);
                },
                error: function () {
                    resetMessage.html('<p style="color: red;">An error occurred while resetting.</p>');
                },
            });
        }
    });
});
    
/* reset plugin data ends here */

jQuery(document).ready(function($) {
    function toggleParagraphNumber() {
        if ($('#display_position').val() === 'after_paragraph_number') {
            $('.dtoc_paragraph_number').fadeIn(600);
        } else {
            $('.dtoc_paragraph_number').fadeOut(600);
        }
    }

    $('#display_position').on('change', toggleParagraphNumber);
    toggleParagraphNumber();
});


jQuery(document).ready(function($) {

    $('#custom-icon-preview').on('load', function () {
        $(this).css({
            width: '32px',
            height: '32px',
            objectFit: 'contain'
        });
    });
            
    // Show preview if already set (for saved settings)
    const existingIcon = $('#custom_icon_url').val();
    if (existingIcon) {
        $('#custom-icon-preview').attr('src', existingIcon).show();
    }
});


jQuery(document).ready(function($) {
    $('#dtoc_shortcode_source_textarea').on('click', function() {
        navigator.clipboard.writeText($(this).val()).then(function() {
            var $msg = $('#dtoc_copy_inline');
            $msg.stop(true, true).fadeIn(150);

            setTimeout(function() {
                $msg.fadeOut(150);
            }, 1500);
        }).catch(function(err) {
            console.error('Failed to copy: ', err);
        });
    });
});
