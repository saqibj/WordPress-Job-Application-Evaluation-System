jQuery(function($) {
    // Toggle reCAPTCHA fields based on checkbox
    $('#cjm_enable_recaptcha').on('change', function() {
        $('.recaptcha-settings').toggle(this.checked);
    });

    // File size limit validation
    $('#cjm_resume_size_limit').on('input', function() {
        const val = parseInt(this.value);
        if (val > 5) {
            alert('Maximum allowed size: 5MB');
            this.value = 5;
        }
    });
});