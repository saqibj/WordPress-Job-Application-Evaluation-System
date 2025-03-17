# 📋 WordPress Job Application & Evaluation System

[![GitHub License](https://img.shields.io/github/license/saqibj/WordPress-Job-Application-Evaluation-System)](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/blob/main/LICENSE)
[![GitHub Issues](https://img.shields.io/github/issues/saqibj/WordPress-Job-Application-Evaluation-System)](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/issues)
[![WordPress Compatibility](https://img.shields.io/badge/WordPress-6.0%2B-blue)](https://wordpress.org/)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-purple)](https://php.net/)
[![Code Style](https://img.shields.io/badge/code%20style-WordPress-blue)](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
[![Version](https://img.shields.io/badge/version-1.0.4-green)](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/releases)

**Version: 1.0.4**

A comprehensive recruitment management system for WordPress that streamlines the entire hiring process from job posting to candidate evaluation.

📚 [Documentation](docs/) | 📖 [User Manual](docs/MANUAL.md) | 🐛 [Report Issue](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/issues)

## 🌟 Key Features

- **Automated Setup**
  - Automatic page creation during activation
  - Default settings configuration
  - User role establishment

- **Job Management**
  - Create and manage job postings
  - Custom fields for job details
  - Organized job listing page

- **Application System**
  - Comprehensive application forms
  - Education history tracking
  - Work experience management
  - Technical skills selection
  - Language proficiency tracking
  - EEO self-identification
  - Legal compliance and e-signature
  - Secure file uploads
  - Phone number validation with country codes
  - Registration system with E.164 format support

- **Evaluation Process**
  - Structured evaluation forms
  - Scoring system
  - Interviewer dashboard
  - Bulk actions support

- **Security & Compliance**
  - Secure file uploads with MIME validation
  - Role-based access control
  - GDPR compliant data handling
  - Automatic data cleanup

## 🚀 Quick Start

1. **Installation**
   - Upload and activate the plugin
   - Required pages are automatically created:
     - Jobs Listing
     - Application Form
     - Interviewer Dashboard
     - Registration Page

2. **Initial Configuration**
   - Navigate to *Job Applications → Settings*
   - Set resume size limit (default: 2MB)
   - Configure data retention period
   - Enable testing mode if needed

3. **Create Job Postings**
   - Go to *Job Applications → Jobs → Add New*
   - Add title, description, and metadata
   - Publish to make visible on frontend

## ⚙️ Configuration Options

| Section            | Key Settings                          |
|--------------------|---------------------------------------|
| **General**        | Resume size limit, Data retention     |
| **Pages**          | Manage plugin-created pages           |
| **Security**       | File upload validation, Access roles  |
| **Notifications**  | Email templates, Recipient settings   |

## 📖 Documentation

- [User Manual](docs/MANUAL.md) - Detailed workflow guide
- [Technical Docs](docs/) - Developer documentation
- [Changelog](CHANGELOG.md) - Version history
- [Report Issue](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/issues) - Bug reports

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

## 🤝 Contributing

Contributions are welcome! Please read our [Contributing Guidelines](CONTRIBUTING.md) for details.

## 📝 License

This project is licensed under the GPL-3.0 License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Saqib Jawaid** - *Initial work* - [saqibj](https://github.com/saqibj)

## 🙏 

- WordPress Plugin Development Team
- Contributors and testers
- Open source community

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