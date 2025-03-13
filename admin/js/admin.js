jQuery(function($) {
    // Bulk action confirmations
    $('.bulk-action').on('click', function(e) {
        if (!confirm('Are you sure you want to perform this action?')) {
            e.preventDefault();
        }
    });

    // Application status quick edit
    $('.cjm-status-toggle').on('change', function() {
        const newStatus = $(this).val();
        const applicationId = $(this).data('id');
        
        $.post(ajaxurl, {
            action: 'cjm_update_status',
            application_id: applicationId,
            new_status: newStatus,
            nonce: cjm_admin.nonce
        }, function(response) {
            if (response.success) {
                location.reload();
            }
        });
    });
});