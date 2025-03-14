# 📘 WordPress Job Application & Evaluation System  
**User Guide & Workflow Manual**  

---

## 🌟 Overview  
This plugin transforms WordPress into a complete recruitment management system. Manage job postings, accept applications with resumes, and conduct structured candidate evaluations.  

**Key Features**:  
- Job posting management  
- Candidate application portal  
- Interviewer evaluation dashboard  
- Automated notifications  
- CSV exports & reporting  

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
3. **Create Pages**:  
   - *Jobs Page*: Add `[cjm_jobs]` shortcode  
   - *Application Page*: Add `[cjm_apply]` shortcode  
   - *Interviewer Dashboard*: Add `[cjm_dashboard]` shortcode  

### 2. Configure Settings  
1. Navigate to **Jobs → Settings**  
2. Configure:  
   - **reCAPTCHA Keys** (required for application forms)  
   - **Resume Size Limit** (default: 2MB)  
   - **Data Retention Period** (default: 365 days)  
   - **Default Country Code** (for phone number registration)

---

## 📋 Core Workflows  

### A. Job Management (HR)  
1. **Create a Job**:  
   - Go to *Jobs → Add New*  
   - Add title, description, and metadata (location, salary, etc.)  
   - Publish to display on the jobs page  

2. **Manage Applications**:  
   - View submissions under *Applications*  
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
1. **Export Data**:  
   - From *Applications*, select candidates → *Export to CSV*  
   - Includes: Candidate info, scores, recommendation  

2. **View Statistics**:  
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