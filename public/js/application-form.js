jQuery(function($) {
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

    // Dynamic job entries
    let jobCount = 1;
    
    $('#add-job').on('click', function() {
        const newJob = `
            <div class="job-entry">
                <input type="text" 
                       name="jobs[${jobCount}][company]" 
                       placeholder="${cjm_i18n.company_name}">
                <input type="text" 
                       name="jobs[${jobCount}][title]" 
                       placeholder="${cjm_i18n.job_title}">
                <input type="date" 
                       name="jobs[${jobCount}][start_date]" 
                       placeholder="${cjm_i18n.start_date}">
                <button type="button" class="remove-job button-secondary">
                    ${cjm_i18n.remove}
                </button>
            </div>
        `;
        
        $('#previous-jobs').append(newJob);
        jobCount++;
    });

    // Remove job entry
    $(document).on('click', '.remove-job', function() {
        $(this).closest('.job-entry').remove();
    });

    // Form validation
    $('#jobApplicationForm').on('submit', function(e) {
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        
        // Check required checkboxes
        const requiredCheckboxes = $form.find('input[type="checkbox"][required]');
        let isValid = true;
        
        requiredCheckboxes.each(function() {
            if (!$(this).is(':checked')) {
                isValid = false;
                const $label = $('label[for="' + $(this).attr('id') + '"]');
                if (!$label.next('.validation-message').length) {
                    $('<p class="validation-message error"></p>')
                        .text(cjm_i18n.required_field)
                        .insertAfter($label);
                }
            }
        });

        // Check technical skills (at least one required)
        const skillsChecked = $form.find('input[name="skills[]"]:checked').length;
        if (skillsChecked === 0) {
            isValid = false;
            const $skillsSection = $('.skills-grid');
            if (!$skillsSection.next('.validation-message').length) {
                $('<p class="validation-message error"></p>')
                    .text(cjm_i18n.select_one_skill)
                    .insertAfter($skillsSection);
            }
        }

        // Check file size for resume
        const resume = $('#resume')[0].files[0];
        if (resume) {
            const maxSize = cjm_i18n.max_resume_size * 1024 * 1024; // Convert MB to bytes
            if (resume.size > maxSize) {
                isValid = false;
                const $resumeInput = $('#resume');
                if (!$resumeInput.next('.validation-message').length) {
                    $('<p class="validation-message error"></p>')
                        .text(cjm_i18n.file_too_large)
                        .insertAfter($resumeInput);
                }
            }
        }

        if (!isValid) {
            e.preventDefault();
            return false;
        }

        // Disable submit button to prevent double submission
        $submitBtn.prop('disabled', true);
    });
}); 