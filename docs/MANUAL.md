# 📘 WordPress Job Application & Evaluation System  

**User Guide & Workflow Manual**  
**Version: 1.0.3**

---

## 🌟 Overview  
This plugin transforms WordPress into a complete recruitment management system. Manage job postings, accept applications with resumes, and conduct structured candidate evaluations.  

**Key Features**:  
- Job posting management  
- Comprehensive application forms
- Education and work history tracking
- Skills and qualifications assessment
- Legal compliance and e-signatures
- Interviewer evaluation dashboard  
- Automated notifications  
- CSV exports & reporting  

---

## 📝 Application Form Fields

### 1. Personal Information
- Full Name (required)
- Date of Birth
- Work Authorization Status (required)

### 2. Contact Details
- Email Address (required)
- Phone Number with country code (required)
- LinkedIn/Portfolio URL (optional)

### 3. Education History
- Highest Degree (required)
  - High School
  - Bachelor's
  - Master's
  - PhD
- Institution Name (required)

### 4. Work Experience
- Employment Type
  - Full-Time
  - Part-Time
  - Contract
- Previous Jobs
  - Company Name
  - Job Title
  - Start Date
  - Dynamic entries for multiple positions

### 5. Skills & Qualifications
- Technical Skills (required)
  - Predefined options including:
    - Python, Java, JavaScript
    - PHP, SQL, Excel
    - Project Management, Agile
- Language Proficiency (required)
  - English (Fluent)
  - Spanish (Intermediate)
  - Other options

### 6. Attachments
- Resume/CV (required)
  - PDF, DOC, DOCX formats
  - Size limit configurable
- Cover Letter (optional)
  - Same format restrictions as resume

### 7. Legal & Compliance
- Background Check Consent
- EEO Self-Identification
  - Gender options
  - "Prefer not to say" option
- Electronic Signature
- Information Accuracy Certification

---

## 👥 User Roles & Permissions  

| Role               | Capabilities                                  |  
|--------------------|-----------------------------------------------|  
| **HR Manager**     | Create jobs, assign interviewers, view reports |  
| **Interviewer**    | Evaluate assigned candidates                  |  
| **Applicant**      | Browse jobs, submit applications              |  

---

## 🛠️ Setup Guide  

### 1. Installation  
1. **Install Plugin**: Upload via *Plugins → Add New → Upload*  
2. **Activate**: Activate the plugin  
   - Required pages are automatically created during activation
   - Default settings are configured automatically

### 2. Configure Settings  
1. Navigate to **Job Applications → Settings**  
2. Configure General Settings:  
   - **Resume Size Limit** (default: 2MB)  
   - **Data Retention Period** (default: 365 days)  
   - **Testing Mode** (disables reCAPTCHA for development)

### 3. Manage Plugin Pages
1. Go to **Job Applications → Settings → Plugin Pages**
2. View and manage automatically created pages:
   - **Jobs Page**: Lists all job postings (`[cjm_jobs]`)
   - **Apply Page**: Application form (`[cjm_apply]`)
   - **Dashboard Page**: Interviewer portal (`[cjm_dashboard]`)
   - **Registration Page**: Applicant signup (`[cjm_registration_form]`)
3. Customize page titles if needed
4. Create/Update pages with custom names
5. View current page locations and links

---

## 📋 Core Workflows  

### A. Job Management (HR)  
1. **Access Admin Area**:
   - All plugin functions are now consolidated under the "Job Applications" menu
   - Navigate using the logical submenu structure:
     - Dashboard: Overview and quick stats
     - Jobs: Manage job listings
     - Applications: Review submissions
     - Evaluations: View assessments
     - Reports: Analytics and exports
     - Settings: Configure plugin options

2. **Create a Job**:  
   - Go to *Job Applications → Jobs → Add New*  
   - Add title, description, and metadata (location, salary, etc.)  
   - Publish to display on the jobs page  

3. **Manage Applications**:  
   - View submissions under *Job Applications → Applications*  
   - Filter by status: `New`, `In Review`, `Archived`  
   - Assign interviewers via bulk actions  

---

### B. Application Process (Applicant)  
1. **Browse Jobs**:  
   - Visit the `/jobs/` page  
   - Click *View Details* to see job requirements  

2. **Submit Application**:  
   - Click *Apply* on the job page  
   - Fill in:  
     - Name, email  
     - Phone number (E.164 format with country code)  
     - Upload resume (PDF/DOCX only)  
     - Complete reCAPTCHA  
   - Receive confirmation email  

---

### C. Evaluation Workflow (Interviewer)  
1. **Access Dashboard**:  
   - Log in and visit the page with `[cjm_dashboard]`  
   - Or access via *Job Applications → Evaluations* in admin area

2. **Evaluate Candidates**:  
   - Click *Evaluate* next to an assigned candidate  
   - Rate criteria using the 5-point scale:  
     - **Core Competencies** (Analytical skills, communication)  
     - **Role-Specific Skills** (Technical expertise)  
     - **Behavioral Attributes** (Teamwork, cultural fit)  
   - Add comments for each criterion  
   - Submit overall recommendation (`Highly Recommended` to `Not Recommended`)  

3. **Save Progress**:  
   - Evaluations auto-save draft versions  
   - Final submission triggers HR notification  

---

### D. Reporting & Analytics (HR)  
1. **Access Reports**:
   - Navigate to *Job Applications → Reports*
   - Choose from available report types:
     - Application Statistics
     - Evaluation Analytics
     - Export Data

2. **Export Data**:  
   - From *Job Applications → Applications*, select candidates → *Export to CSV*  
   - Includes: Candidate info, scores, recommendation  

3. **View Statistics**:  
   - Average scores per job role  
   - Evaluation completion rates  
   - Candidate comparison charts  

---

## 🔔 Notifications  
| Trigger                    | Recipient       | Content                                  |  
|----------------------------|-----------------|------------------------------------------|  
| New application submitted  | HR              | Candidate details + resume link          |  
| Evaluation completed       | HR              | Score summary + recommendation           |  
| Application received       | Applicant       | Confirmation + next steps                |  
| Assigned to evaluate       | Interviewer     | Candidate info + deadline reminder       |  

---

## 🧹 Data Management  
- **Automatic Cleanup**: Applications older than retention period are deleted  
- **Manual Archiving**: Bulk archive/delete from *Applications* list  
- **Backup**: Export CSV before bulk actions  

---

## 🛠️ Troubleshooting  

| Issue                          | Solution                                   |  
|--------------------------------|--------------------------------------------|  
| Application not submitting     | Check reCAPTCHA keys + file size limits    |  
| Missing evaluations            | Verify interviewer assignments             |  
| Resume upload failed           | Ensure file is PDF/DOCX and under size limit |  

---

## 🧩 Customization  

### 1. Modify Evaluation Criteria  
Edit `includes/evaluations/criteria/core-competencies.php`:  
```php  
add_filter('cjm_evaluation_criteria', function($criteria) {  
    $criteria['new_section'] = [  
        'label' => 'Custom Skills',  
        'criteria' => ['custom_skill' => __('Custom Skill')]  
    ];  
    return $criteria;  
});  
```  

### 2. Template Overrides  
Create in your theme:  
```  
your-theme/company-jobs/  
├── application-form.php  
└── evaluation-dashboard.php  
```  

### 3. Styling  
Add CSS to your theme's `style.css`:  
```css  
.cjm-job-listing {  
    border: 1px solid #eee;  
    padding: 20px;  
    margin-bottom: 30px;  
}  
```  

---

## 📞 Support  
- **Documentation**: See `/docs/` folder  
- **Issues**: [GitHub Issues](https://github.com/saqibj/WordPress-Job-Application-Evaluation-System/issues)  

---

This manual covers core workflows. For advanced customization, refer to developer documentation or contact support.