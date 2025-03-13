# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-03-20

### Added
- Initial release of WordPress Job Application & Evaluation System
- Job post management with rich-text editor
- Candidate portal with secure resume uploads
- Custom evaluation sheets with scoring logic
- Role-based access control (HR/Interviewer/Applicant)
- CSV exports and automatic data retention
- reCAPTCHA integration
- Email notifications system
- Custom fields for job posts
- Bulk actions for applications
- Email templates customization
- API endpoints for integration
- WP-CLI commands for management
- Multilingual support

### Security
- Strict MIME type validation for file uploads
- Size limit enforcement (2MB default)
- Non-executable upload directory
- Input sanitization and output escaping
- Nonce verification on all forms
- Role capability checks
- XSS protection
- CSRF protection
- SQL injection prevention
- GDPR compliance features
- Data retention policies
- Privacy policy integration

### Database
- Applications table with status tracking
- Evaluations table with scoring system
- Proper indexing for performance
- Timestamp tracking for all records

### Development
- WordPress coding standards compliance
- Comprehensive documentation
- Unit and integration tests
- Code style checking
- Development environment setup

[1.0.0]: https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/releases/tag/v1.0.0 