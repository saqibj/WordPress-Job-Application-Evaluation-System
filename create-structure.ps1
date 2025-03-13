$baseDir = "wordpress-job-eval-system"

# Create base directory
New-Item -Path $baseDir -ItemType Directory -Force | Out-Null

# Create directory structure
$directories = @(
    "$baseDir/admin/css",
    "$baseDir/admin/js",
    "$baseDir/includes/post-types",
    "$baseDir/includes/shortcodes",
    "$baseDir/includes/security",
    "$baseDir/includes/database",
    "$baseDir/includes/notifications",
    "$baseDir/includes/evaluations/criteria",
    "$baseDir/includes/uploads",
    "$baseDir/includes/cron",
    "$baseDir/public/css",
    "$baseDir/public/js",
    "$baseDir/templates/jobs",
    "$baseDir/templates/applications",
    "$baseDir/templates/evaluations",
    "$baseDir/templates/emails",
    "$baseDir/languages",
    "$baseDir/tests/unit",
    "$baseDir/tests/integration",
    "$baseDir/docs",
    "$baseDir/vendor"
)

foreach ($dir in $directories) {
    New-Item -Path $dir -ItemType Directory -Force | Out-Null
    Write-Host "Created directory: $dir"
}

# Create files
$files = @(
    # Admin files
    "$baseDir/admin/css/admin.css",
    "$baseDir/admin/js/admin.js",
    "$baseDir/admin/class-settings.php",
    "$baseDir/admin/applications-list.php",
    "$baseDir/admin/evaluations-view.php",
    
    # Post types
    "$baseDir/includes/post-types/class-jobs.php",
    "$baseDir/includes/post-types/class-applications.php",
    "$baseDir/includes/post-types/class-evaluations.php",
    
    # Shortcodes
    "$baseDir/includes/shortcodes/class-jobs-shortcode.php",
    "$baseDir/includes/shortcodes/class-application-form.php",
    "$baseDir/includes/shortcodes/class-dashboard.php",
    
    # Security
    "$baseDir/includes/security/class-sanitization.php",
    "$baseDir/includes/security/class-validation.php",
    "$baseDir/includes/security/class-nonces.php",
    
    # Database
    "$baseDir/includes/database/class-db-applications.php",
    "$baseDir/includes/database/class-db-evaluations.php",
    "$baseDir/includes/database/schema.php",
    
    # Notifications
    "$baseDir/includes/notifications/class-emailer.php",
    "$baseDir/includes/notifications/notifications.php",
    
    # Evaluations
    "$baseDir/includes/evaluations/class-scoring.php",
    "$baseDir/includes/evaluations/calculator.php",
    "$baseDir/includes/evaluations/criteria/core-competencies.php",
    "$baseDir/includes/evaluations/criteria/role-specific.php",
    "$baseDir/includes/evaluations/criteria/behavioral.php",
    
    # Uploads
    "$baseDir/includes/uploads/class-file-handler.php",
    "$baseDir/includes/uploads/resume-validator.php",
    
    # Cron
    "$baseDir/includes/cron/cleanup.php",
    
    # Template loader
    "$baseDir/includes/template-loader.php",
    
    # Public
    "$baseDir/public/css/frontend.css",
    "$baseDir/public/js/frontend.js",
    "$baseDir/public/class-public-init.php",
    
    # Templates
    "$baseDir/templates/jobs/archive-job.php",
    "$baseDir/templates/jobs/single-job.php",
    "$baseDir/templates/applications/form-application.php",
    "$baseDir/templates/applications/success.php",
    "$baseDir/templates/evaluations/form-evaluation.php",
    "$baseDir/templates/evaluations/dashboard.php",
    "$baseDir/templates/evaluations/summary.php",
    "$baseDir/templates/emails/new-application.html",
    "$baseDir/templates/emails/evaluation-complete.html",
    "$baseDir/templates/emails/candidate-notification.html",
    
    # Languages
    "$baseDir/languages/job-eval-system.pot",
    
    # Docs
    "$baseDir/docs/user-guide.md",
    "$baseDir/docs/developer-api.md",
    
    # Root files
    "$baseDir/uninstall.php",
    "$baseDir/readme.txt",
    "$baseDir/job-eval-system.php"
)

foreach ($file in $files) {
    New-Item -Path $file -ItemType File -Force | Out-Null
    Write-Host "Created file: $file"
}

Write-Host "Directory structure and files created successfully!" 