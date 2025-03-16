# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.3] - 2024-03-14

### Added
- Enhanced application form with comprehensive fields
- Education history tracking
- Work experience management with dynamic job entries
- Technical skills selection
- Language proficiency tracking
- EEO self-identification options
- Legal compliance and electronic signature
- Cover letter upload option
- Background check consent
- Client-side form validation
- Dynamic job history entries
- New database tables for skills and previous jobs
- Foreign key constraints for data integrity
- Additional indexes for improved query performance

### Changed
- Improved form layout and styling
- Enhanced validation messages
- Consolidated database schema in single file
- Standardized column names and types
- Optimized table structure for better performance
- Streamlined user experience
- Improved accessibility

### Security
- Enhanced file upload validation
- Added signature verification
- Improved data sanitization
- Added foreign key constraints for referential integrity
- Standardized database field lengths for better security

### Database
- Added `cjm_previous_jobs` table for work history
- Added `cjm_skills` table for technical skills
- Enhanced `cjm_applications` table with new fields
- Added proper foreign key constraints
- Optimized indexes for common queries
- Standardized column naming conventions
- Improved data type definitions

## [1.0.2] - 2024-03-13

### Added
- Automatic page creation during plugin activation
- Page management interface in Settings
- Testing mode toggle for development
- Phone number validation with country codes
- Enhanced country code selection with flags

### Changed
- Improved plugin initialization process
- Updated documentation for automatic page creation
- Streamlined settings interface
- Enhanced error handling and validation

### Fixed
- Plugin initialization callback issues
- Post type registration and menu structure
- Phone number validation and storage
- Various linting and compatibility issues

## [1.0.1] - 2024-03-12

### Added
- Phone number field with country code selection
- E.164 format validation for phone numbers
- Country code dropdown with flags

### Changed
- Updated user registration process
- Enhanced form validation
- Improved error messages

### Fixed
- Various bug fixes and improvements
- Documentation updates

## [1.0.0] - 2024-03-11

### Added
- Initial release
- Job posting management
- Application submission system
- Evaluation workflow
- User role management
- Basic reporting features

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

[1.0.3]: https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/releases/tag/v1.0.3
[1.0.2]: https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/releases/tag/v1.0.2
[1.0.1]: https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/releases/tag/v1.0.1
[1.0.0]: https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/releases/tag/v1.0.0 