# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.1] - 2024-03-21

### Added
- Phone number field in registration form with E.164 format support
- Country code selection with flags and search functionality
- Default country code setting in admin panel
- Comprehensive country list with 100+ countries and their flags
- Phone number validation in E.164 format
- Testing mode toggle in admin settings

### Enhanced
- Improved registration form UI with better validation
- Added country flags and names to dropdown selections
- Enhanced phone number input validation and formatting
- Updated settings page with country code configuration
- Improved form styling with responsive design
- Added descriptive tooltips for phone number format
- Enhanced error messaging for phone validation
- Added real-time phone number formatting
- Improved accessibility for country selection

### Fixed
- Phone number validation edge cases
- Country code dropdown mobile responsiveness
- Form submission validation for phone numbers
- Error message display formatting

### Security
- Added sanitization for phone number inputs
- Enhanced validation for country code selection
- Added proper escaping for phone number display

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

[1.0.1]: https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/releases/tag/v1.0.1
[1.0.0]: https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/releases/tag/v1.0.0 