```markdown
# 📋 WordPress Job Application & Evaluation System

[![GitHub License](https://img.shields.io/github/license/saqibj/WordPress-Job-Application-Evaluation-System)](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/blob/main/LICENSE)
[![GitHub Issues](https://img.shields.io/github/issues/saqibj/WordPress-Job-Application-Evaluation-System)](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/issues)
[![WordPress Compatibility](https://img.shields.io/badge/WordPress-6.0%2B-blue)](https://wordpress.org/)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-purple)](https://php.net/)

A complete recruitment management system for WordPress with job postings, candidate applications, and structured evaluations.

👉 **Live Demo** | 📚 [Documentation](docs/) | 🐛 [Report Issue](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/issues)

![Plugin Interface](assets/screenshot.png)

## 🌟 Features

- **Job Post Management** with rich-text editor
- **Candidate Portal** with secure resume uploads (PDF/DOCX)
- **Custom Evaluation Sheets** with scoring logic
- **Role-Based Access Control** (HR/Interviewer/Applicant)
- **CSV Exports** & automatic data retention
- **reCAPTCHA Integration** & email notifications

## 🚀 Quick Installation

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

### For Interviewers
1. Access dashboard via `[cjm_dashboard]`
2. Evaluate candidates using:
   - 5-point rating system
   - Customizable criteria
   - Comments/feedback fields
3. Submit evaluations automatically saved

### For Applicants
- Browse jobs at `/jobs/`
- Submit applications with resume
- Receive email confirmation

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

## 📦 Database Structure

```sql
-- Applications Table
CREATE TABLE wp_cjm_applications (
    application_id BIGINT UNSIGNED AUTO_INCREMENT,
    job_id BIGINT UNSIGNED NOT NULL,
    candidate_email VARCHAR(100) NOT NULL,
    resume_path VARCHAR(255) NOT NULL,
    status ENUM('new','reviewed','archived') DEFAULT 'new',
    PRIMARY KEY (application_id)
);

-- Evaluations Table
CREATE TABLE wp_cjm_evaluations (
    evaluation_id BIGINT UNSIGNED AUTO_INCREMENT,
    application_id BIGINT UNSIGNED NOT NULL,
    criterion VARCHAR(100) NOT NULL,
    rating TINYINT UNSIGNED,
    comments TEXT,
    PRIMARY KEY (evaluation_id)
);
```

## 🔒 Security

- **File Upload Protection**
  - Strict MIME type validation
  - Size limit enforcement (2MB default)
  - Non-executable upload directory
- **Data Security**
  - Input sanitization/output escaping
  - Nonce verification on all forms
  - Role capability checks

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/your-feature`)
3. Commit changes (`git commit -m 'Add feature'`)
4. Push to branch (`git push origin feature/your-feature`)
5. Open a [Pull Request](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/pulls)

## 📜 License

GNU GPLv3 © 2024 [Saqib Jawaid](https://github.com/saqibj). See [LICENSE](LICENSE) for details.

---

**Need Help?**  
[Open a GitHub Issue](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/issues) | [Read Documentation](docs/)
```

This version includes:
1. Updated GitHub-specific links and badges
2. GPL-3.0 license compliance
3. GitHub Issues for support
4. Cleaner structure with quick navigation
5. Actual repository URL integration
6. Simplified contribution guidelines
7. Security best practices highlighted
8. Clear database schema visualization

Features optimized for GitHub:
- Repository-specific shields.io badges
- Direct links to issues/PRs
- GitHub-flavored markdown
- Simplified installation steps
- Mobile-friendly formatting