// Application Form Handling
jQuery(function($) {
    // Application Form Submission
    $('.cjm-application-form form').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'cjm_submit_application');
        
        $.ajax({
            url: cjm_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: response => {
                if(response.success) {
                    window.location = response.data.redirect;
                } else {
                    this.prepend(`<div class="cjm-alert error">${response.data.message}</div>`);
                }
            }
        });
    });

    // Evaluation Form Interactions
    $('.cjm-evaluation-form').on('change', 'select[name^="criteria"]', function() {
        const parent = $(this).closest('.rating-field');
        parent.find('.comments').toggle(this.value > 0);
    });
});