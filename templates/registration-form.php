<?php defined('ABSPATH') || exit; ?>

<div class="cjm-registration-form">
    <form id="cjm-register-form" method="post">
        <?php wp_nonce_field('cjm_registration_nonce'); ?>
        
        <div class="form-row">
            <label for="first_name">
                <?php echo esc_html__('First Name', 'job-eval-system'); ?>
                <span class="required">*</span>
            </label>
            <input type="text" 
                   id="first_name" 
                   name="first_name" 
                   required>
        </div>

        <div class="form-row">
            <label for="last_name">
                <?php echo esc_html__('Last Name', 'job-eval-system'); ?>
                <span class="required">*</span>
            </label>
            <input type="text" 
                   id="last_name" 
                   name="last_name" 
                   required>
        </div>

        <div class="form-row">
            <label for="email">
                <?php echo esc_html__('Email Address', 'job-eval-system'); ?>
                <span class="required">*</span>
            </label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   required>
        </div>

        <div class="form-row">
            <label for="phone">
                <?php echo esc_html__('Phone Number', 'job-eval-system'); ?>
                <span class="required">*</span>
            </label>
            <div class="phone-input-group">
                <?php
                $default_country_code = get_option('cjm_default_country_code', '+1');
                $country_codes = [
                    '+93' => ['name' => 'Afghanistan', 'flag' => '🇦🇫'],
                    '+355' => ['name' => 'Albania', 'flag' => '🇦🇱'],
                    '+213' => ['name' => 'Algeria', 'flag' => '🇩🇿'],
                    '+244' => ['name' => 'Angola', 'flag' => '🇦🇴'],
                    '+54' => ['name' => 'Argentina', 'flag' => '🇦🇷'],
                    '+61' => ['name' => 'Australia', 'flag' => '🇦🇺'],
                    '+43' => ['name' => 'Austria', 'flag' => '🇦🇹'],
                    '+994' => ['name' => 'Azerbaijan', 'flag' => '🇦🇿'],
                    '+973' => ['name' => 'Bahrain', 'flag' => '🇧🇭'],
                    '+32' => ['name' => 'Belgium', 'flag' => '🇧🇪'],
                    '+975' => ['name' => 'Bhutan', 'flag' => '🇧🇹'],
                    '+55' => ['name' => 'Brazil', 'flag' => '🇧🇷'],
                    '+359' => ['name' => 'Bulgaria', 'flag' => '🇧🇬'],
                    '+1' => ['name' => 'Canada/United States', 'flag' => '🇨🇦🇺🇸'],
                    '+56' => ['name' => 'Chile', 'flag' => '🇨🇱'],
                    '+86' => ['name' => 'China', 'flag' => '🇨🇳'],
                    '+57' => ['name' => 'Colombia', 'flag' => '🇨🇴'],
                    '+385' => ['name' => 'Croatia', 'flag' => '🇭🇷'],
                    '+53' => ['name' => 'Cuba', 'flag' => '🇨🇺'],
                    '+420' => ['name' => 'Czech Republic', 'flag' => '🇨🇿'],
                    '+45' => ['name' => 'Denmark', 'flag' => '🇩🇰'],
                    '+20' => ['name' => 'Egypt', 'flag' => '🇪🇬'],
                    '+372' => ['name' => 'Estonia', 'flag' => '🇪🇪'],
                    '+251' => ['name' => 'Ethiopia', 'flag' => '🇪🇹'],
                    '+358' => ['name' => 'Finland', 'flag' => '🇫🇮'],
                    '+33' => ['name' => 'France', 'flag' => '🇫🇷'],
                    '+220' => ['name' => 'Gambia', 'flag' => '🇬🇲'],
                    '+995' => ['name' => 'Georgia', 'flag' => '🇬🇪'],
                    '+49' => ['name' => 'Germany', 'flag' => '🇩🇪'],
                    '+30' => ['name' => 'Greece', 'flag' => '🇬🇷'],
                    '+36' => ['name' => 'Hungary', 'flag' => '🇭🇺'],
                    '+354' => ['name' => 'Iceland', 'flag' => '🇮🇸'],
                    '+91' => ['name' => 'India', 'flag' => '🇮🇳'],
                    '+62' => ['name' => 'Indonesia', 'flag' => '🇮🇩'],
                    '+98' => ['name' => 'Iran', 'flag' => '🇮🇷'],
                    '+964' => ['name' => 'Iraq', 'flag' => '🇮🇶'],
                    '+353' => ['name' => 'Ireland', 'flag' => '🇮🇪'],
                    '+972' => ['name' => 'Israel', 'flag' => '🇮🇱'],
                    '+39' => ['name' => 'Italy', 'flag' => '🇮🇹'],
                    '+81' => ['name' => 'Japan', 'flag' => '🇯🇵'],
                    '+962' => ['name' => 'Jordan', 'flag' => '🇯🇴'],
                    '+7' => ['name' => 'Kazakhstan/Russia', 'flag' => '🇰🇿🇷🇺'],
                    '+254' => ['name' => 'Kenya', 'flag' => '🇰🇪'],
                    '+965' => ['name' => 'Kuwait', 'flag' => '🇰🇼'],
                    '+996' => ['name' => 'Kyrgyzstan', 'flag' => '🇰🇬'],
                    '+371' => ['name' => 'Latvia', 'flag' => '🇱🇻'],
                    '+961' => ['name' => 'Lebanon', 'flag' => '🇱🇧'],
                    '+218' => ['name' => 'Libya', 'flag' => '🇱🇾'],
                    '+370' => ['name' => 'Lithuania', 'flag' => '🇱🇹'],
                    '+352' => ['name' => 'Luxembourg', 'flag' => '🇱🇺'],
                    '+60' => ['name' => 'Malaysia', 'flag' => '🇲🇾'],
                    '+960' => ['name' => 'Maldives', 'flag' => '🇲🇻'],
                    '+223' => ['name' => 'Mali', 'flag' => '🇲🇱'],
                    '+222' => ['name' => 'Mauritania', 'flag' => '🇲🇷'],
                    '+52' => ['name' => 'Mexico', 'flag' => '🇲🇽'],
                    '+976' => ['name' => 'Mongolia', 'flag' => '🇲🇳'],
                    '+212' => ['name' => 'Morocco', 'flag' => '🇲🇦'],
                    '+95' => ['name' => 'Myanmar', 'flag' => '🇲🇲'],
                    '+977' => ['name' => 'Nepal', 'flag' => '🇳🇵'],
                    '+31' => ['name' => 'Netherlands', 'flag' => '🇳🇱'],
                    '+64' => ['name' => 'New Zealand', 'flag' => '🇳🇿'],
                    '+234' => ['name' => 'Nigeria', 'flag' => '🇳🇬'],
                    '+47' => ['name' => 'Norway', 'flag' => '🇳🇴'],
                    '+968' => ['name' => 'Oman', 'flag' => '🇴🇲'],
                    '+92' => ['name' => 'Pakistan', 'flag' => '🇵🇰'],
                    '+51' => ['name' => 'Peru', 'flag' => '🇵🇪'],
                    '+63' => ['name' => 'Philippines', 'flag' => '🇵🇭'],
                    '+48' => ['name' => 'Poland', 'flag' => '🇵🇱'],
                    '+351' => ['name' => 'Portugal', 'flag' => '🇵🇹'],
                    '+974' => ['name' => 'Qatar', 'flag' => '🇶🇦'],
                    '+40' => ['name' => 'Romania', 'flag' => '🇷🇴'],
                    '+966' => ['name' => 'Saudi Arabia', 'flag' => '🇸🇦'],
                    '+221' => ['name' => 'Senegal', 'flag' => '🇸🇳'],
                    '+381' => ['name' => 'Serbia', 'flag' => '🇷🇸'],
                    '+65' => ['name' => 'Singapore', 'flag' => '🇸🇬'],
                    '+421' => ['name' => 'Slovakia', 'flag' => '🇸🇰'],
                    '+386' => ['name' => 'Slovenia', 'flag' => '🇸🇮'],
                    '+27' => ['name' => 'South Africa', 'flag' => '🇿🇦'],
                    '+82' => ['name' => 'South Korea', 'flag' => '🇰🇷'],
                    '+34' => ['name' => 'Spain', 'flag' => '🇪🇸'],
                    '+94' => ['name' => 'Sri Lanka', 'flag' => '🇱🇰'],
                    '+41' => ['name' => 'Switzerland', 'flag' => '🇨🇭'],
                    '+963' => ['name' => 'Syria', 'flag' => '🇸🇾'],
                    '+886' => ['name' => 'Taiwan', 'flag' => '🇹🇼'],
                    '+992' => ['name' => 'Tajikistan', 'flag' => '🇹🇯'],
                    '+255' => ['name' => 'Tanzania', 'flag' => '🇹🇿'],
                    '+66' => ['name' => 'Thailand', 'flag' => '🇹🇭'],
                    '+216' => ['name' => 'Tunisia', 'flag' => '🇹🇳'],
                    '+90' => ['name' => 'Turkey', 'flag' => '🇹🇷'],
                    '+993' => ['name' => 'Turkmenistan', 'flag' => '🇹🇲'],
                    '+256' => ['name' => 'Uganda', 'flag' => '🇺🇬'],
                    '+380' => ['name' => 'Ukraine', 'flag' => '🇺🇦'],
                    '+971' => ['name' => 'United Arab Emirates', 'flag' => '🇦🇪'],
                    '+44' => ['name' => 'United Kingdom', 'flag' => '🇬🇧'],
                    '+998' => ['name' => 'Uzbekistan', 'flag' => '🇺🇿'],
                    '+58' => ['name' => 'Venezuela', 'flag' => '🇻🇪'],
                    '+84' => ['name' => 'Vietnam', 'flag' => '🇻🇳'],
                    '+967' => ['name' => 'Yemen', 'flag' => '🇾🇪'],
                    '+260' => ['name' => 'Zambia', 'flag' => '🇿🇲'],
                    '+263' => ['name' => 'Zimbabwe', 'flag' => '🇿🇼'],
                ];

                // Sort by country name
                uasort($country_codes, function($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
                ?>
                <select id="country_code" 
                        name="country_code" 
                        required 
                        class="country-select">
                    <option value=""><?php echo esc_html__('Select Country', 'job-eval-system'); ?></option>
                    <?php foreach ($country_codes as $code => $country): ?>
                        <option value="<?php echo esc_attr($code); ?>" 
                                <?php selected($default_country_code, $code); ?>>
                            <?php echo esc_html($country['flag'] . ' ' . $country['name'] . ' (' . $code . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       required 
                       pattern="[0-9]{6,14}"
                       class="phone-number"
                       placeholder="123456789">
            </div>
            <p class="description">
                <?php echo esc_html__('Enter phone number in E.164 format without spaces or special characters. Example: For US number (555) 123-4567, enter 5551234567', 'job-eval-system'); ?>
            </p>
        </div>

        <div class="form-row">
            <label for="password">
                <?php echo esc_html__('Password', 'job-eval-system'); ?>
                <span class="required">*</span>
            </label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required 
                   minlength="8">
            <p class="description">
                <?php echo esc_html__('Password must be at least 8 characters long.', 'job-eval-system'); ?>
            </p>
        </div>

        <div class="form-row">
            <button type="submit" class="button button-primary">
                <?php echo esc_html__('Register', 'job-eval-system'); ?>
            </button>
        </div>

        <div id="registration-message" class="hidden"></div>
    </form>

    <p class="login-link">
        <?php
        echo sprintf(
            /* translators: %s: login URL */
            esc_html__('Already have an account? %s', 'job-eval-system'),
            '<a href="' . esc_url(wp_login_url()) . '">' . esc_html__('Log in', 'job-eval-system') . '</a>'
        );
        ?>
    </p>
</div>

<style>
.cjm-registration-form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
}

.form-row {
    margin-bottom: 15px;
}

.form-row label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.form-row input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.phone-input-group {
    display: flex;
    gap: 10px;
    margin-bottom: 5px;
}

.country-select {
    width: 200px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fff;
    font-size: 14px;
}

.country-select option {
    padding: 4px;
    font-size: 14px;
}

.phone-number {
    flex: 1;
}

.required {
    color: #dc3545;
}

.description {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

#registration-message {
    margin-top: 15px;
    padding: 10px;
    border-radius: 4px;
}

#registration-message.error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

#registration-message.success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.hidden {
    display: none;
}

.login-link {
    text-align: center;
    margin-top: 20px;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Get default country code from settings
    var defaultCountryCode = '<?php echo esc_js($default_country_code); ?>';
    
    // Set default country code if not already selected
    if (!$('#country_code').val()) {
        $('#country_code').val(defaultCountryCode);
    }

    function formatPhoneNumber() {
        var countryCode = $('#country_code').val();
        var phoneNumber = $('#phone').val().replace(/\D/g, '');
        return countryCode + phoneNumber;
    }

    $('#cjm-register-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $message = $('#registration-message');
        var $submit = $form.find('button[type="submit"]');
        
        // Format phone number in E.164 format
        var formattedPhone = formatPhoneNumber();
        
        $submit.prop('disabled', true);
        $message.removeClass('error success').addClass('hidden');
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'cjm_register_applicant',
                nonce: $form.find('input[name="_wpnonce"]').val(),
                email: $form.find('input[name="email"]').val(),
                password: $form.find('input[name="password"]').val(),
                first_name: $form.find('input[name="first_name"]').val(),
                last_name: $form.find('input[name="last_name"]').val(),
                phone: formattedPhone
            },
            success: function(response) {
                if (response.success) {
                    $message
                        .removeClass('error')
                        .addClass('success')
                        .html(response.data.message)
                        .removeClass('hidden');
                    
                    setTimeout(function() {
                        window.location.href = response.data.redirect_url;
                    }, 2000);
                } else {
                    $message
                        .removeClass('success')
                        .addClass('error')
                        .html(response.data.message)
                        .removeClass('hidden');
                    $submit.prop('disabled', false);
                }
            },
            error: function() {
                $message
                    .removeClass('success')
                    .addClass('error')
                    .html('<?php echo esc_js(__('An error occurred. Please try again.', 'job-eval-system')); ?>')
                    .removeClass('hidden');
                $submit.prop('disabled', false);
            }
        });
    });

    // Real-time phone number validation
    $('#phone').on('input', function() {
        var phoneNumber = $(this).val().replace(/\D/g, '');
        $(this).val(phoneNumber);
    });
});
</script> 