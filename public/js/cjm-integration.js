document.addEventListener('DOMContentLoaded', function() {
    // AJAX evaluation form submission
    document.querySelectorAll('.cjm-evaluation-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch(cjm_ajax.ajax_url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-WP-Nonce': cjm_ajax.nonce
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.location.reload();
                } else {
                    alert('Error: ' + data.data.message);
                }
            });
        });
    });

    // Dynamic criteria weighting interface
    document.querySelectorAll('.cjm-weight-control').forEach(input => {
        input.addEventListener('change', function() {
            document.querySelector(`.weight-value[data-criterion="${this.dataset.criterion}"]`)
                .textContent = this.value;
        });
    });
});