var strict;

jQuery(document).ready(function ($) {
    /**
     * DEACTIVATION FEEDBACK FORM
     */
    // show overlay when clicked on "deactivate"
    dtoc_deactivate_link = $('.wp-admin.plugins-php tr[data-slug="digital-table-of-contents"] .row-actions .deactivate a');
    dtoc_deactivate_link_url = dtoc_deactivate_link.attr('href');

    dtoc_deactivate_link.click(function (e) {
        e.preventDefault();

        // only show feedback form once per 30 days
        var c_value = dtoc_admin_get_cookie("dtoc_keep_hidden_feedback_popup");

        if (c_value === undefined) {
            $('#dtoc-feedback-overlay').show();
        } else {
            // click on the link
            window.location.href = dtoc_deactivate_link_url;
        }
    });
    // show text fields
    
    $('input[name="dtoc_disable_reason"]').on('change', function() {
        const selectedId = $(this).attr('id');

        // Hide all textareas first
        $('.dtoc-reason-details textarea').addClass('dtoc-d-none');

        // Show the matching textarea if it exists
        $('.dtoc-reason-details textarea[data-id="' + selectedId + '"]').removeClass('dtoc-d-none');
    });


    // send form or close it
    $('#dtoc-feedback-content form').submit(function (e) {
        e.preventDefault();

        dtoc_set_feedback_cookie();

        // Send form data
        $.post(dtoc_feedback_local.ajax_url, {
            action: 'dtoc_send_feedback',
            data: $('#dtoc-feedback-content form').serialize() + "&dtoc_security_nonce=" + dtoc_feedback_local.dtoc_security_nonce
        },
                function (data) {

                    if (data == 'sent') {
                        // deactivate the plugin and close the popup
                        $('#dtoc-feedback-overlay').remove();
                        window.location.href = dtoc_deactivate_link_url;
                    } else {
                        console.log('Error: ' + data);
                        alert(data);
                    }
                }
        );
    });

    $("#dtoc-feedback-content .dtoc-only-deactivate").click(function (e) {
        e.preventDefault();

        dtoc_set_feedback_cookie();        
        $('#dtoc-feedback-overlay').remove();
        window.location.href = dtoc_deactivate_link_url;
    });

    // close form without doing anything
    $('.dtoc-fd-stop-deactivation').click(function (e) {
        e.preventDefault();
        $('#dtoc-feedback-content form')[0].reset();                
        $('.dtoc-reason-details textarea').addClass('dtoc-d-none');
        $('#dtoc-feedback-overlay').hide();
        $(".dtoc-reason-details").addClass('dtoc-display-none')        
    });

    function dtoc_admin_get_cookie(name) {
        var i, x, y, dtoc_cookies = document.cookie.split(";");
        for (i = 0; i < dtoc_cookies.length; i++)
        {
            x = dtoc_cookies[i].substr(0, dtoc_cookies[i].indexOf("="));
            y = dtoc_cookies[i].substr(dtoc_cookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");
            if (x === name)
            {
                return unescape(y);
            }
        }
    }

    function dtoc_set_feedback_cookie() {
        // set cookie for 30 days
        var exdate = new Date();
        exdate.setSeconds(exdate.getSeconds() + 2592000);
        document.cookie = "dtoc_keep_hidden_feedback_popup=1; expires=" + exdate.toUTCString() + "; path=/";
    }
});