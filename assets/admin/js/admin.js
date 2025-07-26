
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

jQuery(document).ready(function($){

  // Hide and show child options based on parent selection starts here
//   $(".dtoc_parent_option").on("change", function (e) {
//     var id = $(this).attr("id");
//     if ($(this).prop("checked")) {
//         $(".dtoc_" + id).fadeIn(600); // 600ms slow motion effect
//     } else {
//         $(".dtoc_" + id).fadeOut(600);
//     }
// }).change();

  // Hide and show child options based on parent selection ends here

  //
  jQuery(".dtoc-colorpicker").wpColorPicker();
  // 

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
	
	if(dtoc_admin_cdata.dtoc_modules_status){
		$.each(dtoc_admin_cdata.dtoc_modules_status, function( index, value ) {
			if(value){
				$('a[href="admin.php?page=dtoc_'+index+'"]').css('display','block');
			}else{
				$('a[href="admin.php?page=dtoc_'+index+'"]').css('display','none');
			}
		});		
	}
	    

});

 document.addEventListener('DOMContentLoaded', function () {
         var editors = document.querySelectorAll('.dtoc_custom_styles');
         if(editors.length){
           editors.forEach(function(editorElement) {
                var editor = ace.edit(editorElement);
                editor.setTheme("ace/theme/monokai");
                editor.session.setMode("ace/mode/css");

                // Enable autocompletion
                   ace.require("ace/ext/language_tools");
                    editor.setOptions({
                        enableBasicAutocompletion: true,
                        enableLiveAutocompletion: true,
                        enableSnippets: true
                    });
      editor.session.on('change', function(delta) {
      // delta.start, delta.end, delta.lines, delta.action
      var custom_css_target = document.getElementById('custom_css');
          if(custom_css_target){
            console.log(editor.session.getValue());
            custom_css_target.value = editor.session.getValue(); 
          }
  });

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

    function toggleCustomIconSection() {
        if ($('#header_icon').val() === 'custom_icon') {
            $('#custom-icon-wrapper').slideDown();
        } else {
            $('#custom-icon-wrapper').slideUp();
        }
    }

    toggleCustomIconSection(); // On page load
    $('#header_icon').on('change', toggleCustomIconSection);

    // Upload button handler
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
        });

        file_frame.open();
    });

    // Show preview if already set (for saved settings)
    const existingIcon = $('#custom_icon_url').val();
    if (existingIcon) {
        $('#custom-icon-preview').attr('src', existingIcon).show();
    }
});

//React like structure without react starst here
jQuery(document).ready(function($) {

    const state = dtoc_admin_cdata.active_module_state;    
    const reactive = new Proxy(state, {
        set(target, prop, value) {
            target[prop] = value;
            updatePreview();
            return true;
        }
    });

    function updatePreview() {
        $('.preview-title').text(reactive.title || 'Default Title');
        $('.preview-box').css('background-color', reactive.bgColor);
        $('.preview-image').toggle(!!reactive.showImage);
        console.log('ddd');
        if ( reactive.display_title ) {
            
            $('.dtoc_display_title').show();
            
            if ( reactive.toggle_body ) {
                $('.dtoc_2_label_child_opt').show();
            }else{
                $('.dtoc_2_label_child_opt').hide();
            }

        }else{
            $('.dtoc_display_title').hide();
        }        

    }

    // Dynamic binding for all inputs
    
    $('.dtoc-settings-form').on('change' , '.smpg-input', function (e) {
        
        const $input = $(e.target).is('input') ? $(e.target) : $(e.target).find('input');

        const id = $input.attr('id');
        const type = $input.attr('type');
        
        if (!id) return;

        if (type === 'checkbox') {
            reactive[id] = $input.is(':checked');
        } else {
            reactive[id] = $input.val();
        }
    });

    updatePreview(); // initial render
});

//React like structure without react ends here