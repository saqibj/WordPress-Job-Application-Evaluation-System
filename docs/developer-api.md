# Developer API Documentation
**Version:** 1.0.4  
**Last Updated:** 2024-03-20

## 📚 Table of Contents
1. [Hooks & Filters](#hooks-filters)
2. [Template Overrides](#template-overrides)
3. [Data Model](#data-model)
4. [REST API Endpoints](#rest-api)
5. [Security Practices](#security)
6. [Coding Standards](#coding-standards)

---

## 🔌 Hooks & Filters
### Action Hooks
```php
// Plugin initialization
do_action('cjm_plugin_loaded');

// Application submission
do_action('cjm_application_submitted', $application_id);

// Evaluation completed
do_action('cjm_evaluation_submitted', $evaluation_id);
```

### Filters
```php
// Modify evaluation criteria
add_filter('cjm_evaluation_sections', 'custom_evaluation_sections');

// Adjust resume size limit
add_filter('cjm_resume_size_limit', function($size) {
    return 5; // 5MB
});

// Custom email templates
add_filter('cjm_email_template', 'custom_email_template', 10, 2);
```

---

## 🎨 Template Overrides
Create these files in your theme's `company-jobs/` directory:

1. `application-form.php`  
   Override the default application form structure

2. `evaluation-dashboard.php`  
   Customize the interviewer dashboard

**Example Structure:**
```php
// In your theme's functions.php
add_filter('cjm_template_path', function($path) {
    return get_stylesheet_directory() . '/company-jobs/';
});
```

---

## 🗃️ Data Model
### Core Tables
```sql
CREATE TABLE wp_cjm_applications (
    application_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id BIGINT UNSIGNED NOT NULL,
    candidate_email VARCHAR(100) NOT NULL,
    status ENUM('new','reviewed','archived') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (job_id, status)
);

CREATE TABLE wp_cjm_evaluations (
    evaluation_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id BIGINT UNSIGNED NOT NULL,
    criterion VARCHAR(100) NOT NULL,
    rating TINYINT UNSIGNED,
    FOREIGN KEY (application_id) REFERENCES wp_cjm_applications(application_id)
);
```

---

## 🌐 REST API
### Endpoints
```php
// Get applications
/wp-json/cjm/v1/applications

// Submit evaluation
POST /wp-json/cjm/v1/evaluations

// Example request
fetch('/wp-json/cjm/v1/applications')
  .then(response => response.json())
  .then(data => console.log(data));
```

---

## 🔒 Security Practices
1. **Input Validation**
   ```php
   // In application-form.php
   $email = sanitize_email($_POST['email']);
   $phone = preg_replace('/[^0-9+]/', '', $_POST['phone']);
   ```

2. **Nonce Verification**
   ```php
   wp_verify_nonce($_POST['nonce'], 'cjm_application_nonce');
   ```

3. **Role Checks**
   ```php
   current_user_can('manage_job_posts');
   ```

---

## 📝 Coding Standards
1. Follow WordPress PHP coding standards
2. Validate all user inputs
3. Sanitize database outputs
4. Use prepared SQL statements
5. Maintain 1.0.4 version compatibility
6. Document all custom hooks

---

> **Note:** Always test customizations in a staging environment before deployment. Refer to the [WordPress Developer Handbook](https://developer.wordpress.org/) for best practices.
