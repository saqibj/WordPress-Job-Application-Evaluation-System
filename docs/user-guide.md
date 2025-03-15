# User Guide

## Initial Setup
1. **Plugin Activation**
   - Required pages are created automatically
   - Default settings are configured
   - User roles are established

2. **Page Management**
   - Access via Settings → Plugin Pages
   - View existing page locations
   - Customize page titles
   - Create/Update pages as needed
   - Monitor page status and links

3. **Configuration**
   - Set resume size limit (default: 2MB)
   - Adjust data retention period (default: 365 days)
   - Enable/disable testing mode
   - Configure default settings

## Managing Job Listings
1. **Create Jobs**: Navigate to Jobs → Add New
2. **Add Details**: Fill in job title, description, and location
3. **Publish**: Make jobs visible on the frontend

## Processing Applications
- View applications under **Applications** menu
- Filter by status: New/In Review/Archived
- Assign interviewers via bulk actions
- View applicant contact details including phone numbers

## Conducting Evaluations
1. Interviewers access dashboard via `[cjm_dashboard]`
2. Click **Evaluate** on assigned applications
3. Complete evaluation form with:
   - Section ratings (1-5)
   - Detailed comments
   - Overall recommendation

## Configuration
1. Set reCAPTCHA keys in **Settings → Job System**
2. Adjust data retention period (default: 365 days)
3. Modify resume size limit (max 5MB)
4. Set default country code for phone numbers
5. Configure testing mode for development

## Shortcodes
- `[cjm_jobs]`: Display job listings
- `[cjm_apply job_id="123"]`: Application form
- `[cjm_dashboard]`: Interviewer evaluation portal
- `[cjm_registration_form]`: Applicant registration form with phone validation

## Reports
- Export CSV data from HR dashboard
- View candidate comparison charts
- Track evaluation progress metrics
- Access applicant contact information including phone numbers