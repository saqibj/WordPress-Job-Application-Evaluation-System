jQuery(function($) {
    // Edit Application Form Submission
    $('.cjm-application-form.edit-mode form').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const $messages = $('.cjm-alert');
        
        // Remove any existing messages
        $messages.remove();
        
        // Disable submit button
        $submitBtn.prop('disabled', true);
        
        // Create FormData object
        const formData = new FormData(this);
        
        // Add the action
        formData.append('action', 'cjm_edit_application');
        
        // AJAX submission
        $.ajax({
            url: cjm_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $form.prepend(
                        $('<div class="cjm-alert success"></div>')
                            .text(response.data.message)
                    );
                    
                    // Redirect after a short delay
                    setTimeout(function() {
                        window.location.href = response.data.redirect_url;
                    }, 1500);
                } else {
                    // Show error message
                    $form.prepend(
                        $('<div class="cjm-alert error"></div>')
                            .text(response.data.message)
                    );
                    $submitBtn.prop('disabled', false);
                }
            },
            error: function() {
                // Show generic error message
                $form.prepend(
                    $('<div class="cjm-alert error"></div>')
                        .text('An error occurred. Please try again.')
                );
                $submitBtn.prop('disabled', false);
            }
        });
    });
    
    // Phone number validation
    $('#phone').on('input', function() {
        const value = $(this).val();
        const isValid = /^\+[1-9]\d{0,14}$/.test(value);
        
        $(this).toggleClass('invalid', !isValid);
        
        if (value && !isValid) {
            if (!$(this).next('.validation-message').length) {
                $('<p class="validation-message error"></p>')
                    .text('Please enter a valid phone number with country code (e.g., +1234567890)')
                    .insertAfter(this);
            }
        } else {
            $(this).next('.validation-message').remove();
        }
    });
}); 