<?php
defined('ABSPATH') || exit;

if (isset($_POST['cjm_save_settings']) && check_admin_referer('cjm_settings_nonce')) {
    // Save settings
    update_option('cjm_resume_size_limit', absint($_POST['resume_size_limit']));
    update_option('cjm_data_retention', absint($_POST['data_retention']));
    update_option('cjm_recaptcha_site_key', sanitize_text_field($_POST['recaptcha_site_key']));
    update_option('cjm_recaptcha_secret_key', sanitize_text_field($_POST['recaptcha_secret_key']));
    update_option('cjm_testing_mode', isset($_POST['testing_mode']) ? 1 : 0);
    update_option('cjm_default_country_code', sanitize_text_field($_POST['default_country_code']));
    
    echo '<div class="notice notice-success"><p>' . esc_html__('Settings saved successfully.', 'job-eval-system') . '</p></div>';
}

$resume_size_limit = get_option('cjm_resume_size_limit', 2);
$data_retention = get_option('cjm_data_retention', 365);
$recaptcha_site_key = get_option('cjm_recaptcha_site_key', '');
$recaptcha_secret_key = get_option('cjm_recaptcha_secret_key', '');
$testing_mode = get_option('cjm_testing_mode', 0);
$default_country_code = get_option('cjm_default_country_code', '+1');

// Country codes array
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

<div class="wrap">
    <h1><?php echo esc_html__('Settings', 'job-eval-system'); ?></h1>

    <form method="post" action="">
        <?php wp_nonce_field('cjm_settings_nonce'); ?>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="resume_size_limit">
                        <?php echo esc_html__('Resume Size Limit (MB)', 'job-eval-system'); ?>
                    </label>
                </th>
                <td>
                    <input type="number" 
                           id="resume_size_limit" 
                           name="resume_size_limit" 
                           value="<?php echo esc_attr($resume_size_limit); ?>" 
                           min="1" 
                           max="10" 
                           class="small-text">
                    <p class="description">
                        <?php echo esc_html__('Maximum allowed size for resume uploads in megabytes.', 'job-eval-system'); ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="data_retention">
                        <?php echo esc_html__('Data Retention (Days)', 'job-eval-system'); ?>
                    </label>
                </th>
                <td>
                    <input type="number" 
                           id="data_retention" 
                           name="data_retention" 
                           value="<?php echo esc_attr($data_retention); ?>" 
                           min="30" 
                           class="small-text">
                    <p class="description">
                        <?php echo esc_html__('Number of days to keep application data before automatic cleanup.', 'job-eval-system'); ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <?php echo esc_html__('Testing Mode', 'job-eval-system'); ?>
                </th>
                <td>
                    <label for="testing_mode">
                        <input type="checkbox" 
                               name="testing_mode" 
                               id="testing_mode"
                               value="1"
                               <?php checked($testing_mode, 1); ?>>
                        <?php echo esc_html__('Enable Testing Mode', 'job-eval-system'); ?>
                    </label>
                    <p class="description">
                        <?php echo esc_html__('When enabled, reCAPTCHA verification will be disabled for testing purposes. DO NOT enable on production sites!', 'job-eval-system'); ?>
                    </p>
                    <?php if ($testing_mode): ?>
                        <div class="notice notice-warning inline">
                            <p>
                                <strong><?php echo esc_html__('Warning:', 'job-eval-system'); ?></strong>
                                <?php echo esc_html__('Testing mode is enabled. reCAPTCHA verification is currently disabled.', 'job-eval-system'); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="recaptcha_site_key">
                        <?php echo esc_html__('reCAPTCHA Site Key', 'job-eval-system'); ?>
                    </label>
                </th>
                <td>
                    <input type="text" 
                           id="recaptcha_site_key" 
                           name="recaptcha_site_key" 
                           value="<?php echo esc_attr($recaptcha_site_key); ?>" 
                           class="regular-text">
                    <p class="description">
                        <?php echo esc_html__('Google reCAPTCHA v2 site key for form protection.', 'job-eval-system'); ?>
                        <?php if ($testing_mode): ?>
                            <span class="description" style="color: #856404;">
                                <?php echo esc_html__('(Currently disabled due to testing mode)', 'job-eval-system'); ?>
                            </span>
                        <?php endif; ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="recaptcha_secret_key">
                        <?php echo esc_html__('reCAPTCHA Secret Key', 'job-eval-system'); ?>
                    </label>
                </th>
                <td>
                    <input type="password" 
                           id="recaptcha_secret_key" 
                           name="recaptcha_secret_key" 
                           value="<?php echo esc_attr($recaptcha_secret_key); ?>" 
                           class="regular-text">
                    <p class="description">
                        <?php echo esc_html__('Google reCAPTCHA v2 secret key for form protection.', 'job-eval-system'); ?>
                        <?php if ($testing_mode): ?>
                            <span class="description" style="color: #856404;">
                                <?php echo esc_html__('(Currently disabled due to testing mode)', 'job-eval-system'); ?>
                            </span>
                        <?php endif; ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="default_country_code">
                        <?php echo esc_html__('Default Country Code', 'job-eval-system'); ?>
                    </label>
                </th>
                <td>
                    <select name="default_country_code" 
                            id="default_country_code" 
                            class="regular-text">
                        <?php foreach ($country_codes as $code => $country): ?>
                            <option value="<?php echo esc_attr($code); ?>" 
                                    <?php selected($default_country_code, $code); ?>>
                                <?php echo esc_html($country['flag'] . ' ' . $country['name'] . ' (' . $code . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="description">
                        <?php echo esc_html__('Select the default country code for phone numbers in registration form.', 'job-eval-system'); ?>
                    </p>
                </td>
            </tr>
        </table>

        <p class="submit">
            <input type="submit" 
                   name="cjm_save_settings" 
                   class="button button-primary" 
                   value="<?php echo esc_attr__('Save Settings', 'job-eval-system'); ?>">
        </p>
    </form>
</div>

<style>
.form-table th {
    width: 250px;
}

.form-table input[type="number"] {
    width: 80px;
}

.description {
    margin-top: 5px;
    color: #646970;
}

.notice.inline {
    margin: 5px 0 0;
    display: inline-block;
}

.form-table select {
    max-width: 400px;
    font-size: 14px;
}

.form-table select option {
    padding: 4px;
}
</style> 