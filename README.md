# 📋 WordPress Job Application & Evaluation System

[![GitHub License](https://img.shields.io/github/license/saqibj/WordPress-Job-Application-Evaluation-System)](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/blob/main/LICENSE)
[![GitHub Issues](https://img.shields.io/github/issues/saqibj/WordPress-Job-Application-Evaluation-System)](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/issues)
[![WordPress Compatibility](https://img.shields.io/badge/WordPress-6.0%2B-blue)](https://wordpress.org/)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-purple)](https://php.net/)
[![Code Style](https://img.shields.io/badge/code%20style-WordPress-blue)](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)

A complete recruitment management system for WordPress with job postings, candidate applications, and structured evaluations.

📚 [Documentation](docs/) | 📖 [User Manual](MANUAL.md) | 🐛 [Report Issue](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/issues)

## 🌟 Features

### Core Functionality
- **Job Post Management** with rich-text editor
- **Candidate Portal** with secure resume uploads (PDF/DOCX)
- **Custom Evaluation Sheets** with scoring logic
- **Role-Based Access Control** (HR/Interviewer/Applicant)
- **CSV Exports** & automatic data retention
- **reCAPTCHA Integration** & email notifications

### Advanced Features
- **Custom Fields** for job posts
- **Bulk Actions** for applications
- **Email Templates** customization
- **API Endpoints** for integration
- **WP-CLI Commands** for management
- **Multilingual Support**

## 🚀 Quick Installation

### Requirements
- WordPress 6.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

### Installation Steps
1. Download the [latest release](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/releases)
2. Install via WordPress Admin → Plugins → Add New → Upload
3. Activate and configure:
   ```markdown
   - Create page with `[cjm_jobs]` shortcode
   - Set reCAPTCHA keys in plugin settings
   - Assign interviewer roles to users
   ```

## 🛠️ Usage

### For HR Managers
- Manage jobs from WordPress admin
- Track applications with status filters
- Export evaluations to CSV
- Bulk assign interviewers
- Configure email notifications
- Set up evaluation criteria

### For Interviewers
1. Access dashboard via `[cjm_dashboard]`
2. Evaluate candidates using:
   - 5-point rating system
   - Customizable criteria
   - Comments/feedback fields
3. Submit evaluations automatically saved
4. View evaluation history
5. Export individual reports

### For Applicants
- Browse jobs at `/jobs/`
- Submit applications with resume
- Receive email confirmation
- Track application status
- View interview feedback

## 🧩 Customization

### Modify Evaluation Criteria
```php
// Add custom evaluation section
add_filter('cjm_evaluation_sections', function($sections) {
    $sections['custom_skills'] = [
        'label' => 'Domain Expertise',
        'weight' => 1.2,
        'criteria' => [
            'industry_knowledge' => __('Industry Knowledge'),
            'certifications' => __('Relevant Certifications')
        ]
    ];
    return $sections;
});
```

### Template Overrides
Create in your theme:
```
your-theme/
└── company-jobs/
    ├── job-listing.php
    ├── evaluation-form.php
    └── application-success.php
```

### Available Filters
```php
// Modify resume upload size limit
add_filter('cjm_resume_size_limit', function($size) {
    return 5; // 5MB
});

// Customize email templates
add_filter('cjm_email_template', function($template, $type) {
    return 'custom-' . $type . '.php';
}, 10, 2);
```

## 📦 Database Structure

```sql
-- Applications Table
CREATE TABLE wp_cjm_applications (
    application_id BIGINT UNSIGNED AUTO_INCREMENT,
    job_id BIGINT UNSIGNED NOT NULL,
    candidate_email VARCHAR(100) NOT NULL,
    resume_path VARCHAR(255) NOT NULL,
    status ENUM('new','reviewed','archived') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (application_id),
    KEY job_id (job_id),
    KEY status (status)
);

-- Evaluations Table
CREATE TABLE wp_cjm_evaluations (
    evaluation_id BIGINT UNSIGNED AUTO_INCREMENT,
    application_id BIGINT UNSIGNED NOT NULL,
    criterion VARCHAR(100) NOT NULL,
    rating TINYINT UNSIGNED,
    comments TEXT,
    evaluator_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (evaluation_id),
    KEY application_id (application_id),
    KEY evaluator_id (evaluator_id)
);
```

## 🔒 Security

### File Upload Protection
- Strict MIME type validation
- Size limit enforcement (2MB default)
- Non-executable upload directory
- Virus scanning integration
- Secure file naming

### Data Security
- Input sanitization/output escaping
- Nonce verification on all forms
- Role capability checks
- XSS protection
- CSRF protection
- SQL injection prevention

### Privacy Compliance
- GDPR compliant
- Data retention policies
- Export/delete functionality
- Privacy policy integration

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/your-feature`)
3. Commit changes (`git commit -m 'Add feature'`)
4. Push to branch (`git push origin feature/your-feature`)
5. Open a [Pull Request](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/pulls)

### Development Setup
```bash
# Clone repository
git clone https://github.com/saqibj/WordPress-Job-Application-Evaluation-System.git

# Install dependencies
composer install

# Run tests
composer test

# Check code style
composer check-style
```

### Code Style
This project follows WordPress Coding Standards. To maintain code quality:

1. Install PHP_CodeSniffer:
```bash
composer require --dev squizlabs/php_codesniffer wp-coding-standards/wpcs
```

2. Configure PHP_CodeSniffer:
```bash
# Set WordPress Coding Standards as default
phpcs --config-set installed_paths vendor/wp-coding-standards/wpcs
```

3. Run code style checks:
```bash
# Check code style
composer check-style

# Fix code style issues
composer fix-style
```

## 📜 License

GNU GPLv3 © 2024 [Saqib Jawaid](https://github.com/saqibj). See [LICENSE](LICENSE) for details.

## 📝 Changelog

See [CHANGELOG.md](CHANGELOG.md) for a list of all changes.

---

**Need Help?**  
[Open a GitHub Issue](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/issues) | [Read Documentation](docs/) | [Join Discord](https://discord.gg/example)
```

