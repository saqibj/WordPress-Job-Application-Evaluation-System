<?php
defined('ABSPATH') || exit;

$current_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'overview';
?>

<div class="wrap">
    <h1><?php echo esc_html__('Reports & Analytics', 'job-eval-system'); ?></h1>

    <nav class="nav-tab-wrapper">
        <a href="?page=cjm-reports&tab=overview" 
           class="nav-tab <?php echo $current_tab === 'overview' ? 'nav-tab-active' : ''; ?>">
            <?php echo esc_html__('Overview', 'job-eval-system'); ?>
        </a>
        <a href="?page=cjm-reports&tab=evaluations" 
           class="nav-tab <?php echo $current_tab === 'evaluations' ? 'nav-tab-active' : ''; ?>">
            <?php echo esc_html__('Evaluations', 'job-eval-system'); ?>
        </a>
        <a href="?page=cjm-reports&tab=export" 
           class="nav-tab <?php echo $current_tab === 'export' ? 'nav-tab-active' : ''; ?>">
            <?php echo esc_html__('Export', 'job-eval-system'); ?>
        </a>
    </nav>

    <div class="tab-content">
        <?php
        switch ($current_tab) {
            case 'overview':
                require_once CJM_PLUGIN_PATH . 'admin/views/reports/overview.php';
                break;
            case 'evaluations':
                require_once CJM_PLUGIN_PATH . 'admin/views/reports/evaluations.php';
                break;
            case 'export':
                require_once CJM_PLUGIN_PATH . 'admin/views/reports/export.php';
                break;
        }
        ?>
    </div>
</div>

<style>
.tab-content {
    margin-top: 20px;
    background: #fff;
    padding: 20px;
    border: 1px solid #c3c4c7;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
}

.cjm-report-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.cjm-report-card {
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.cjm-report-card h3 {
    margin-top: 0;
    color: #1d2327;
}

.cjm-chart-container {
    margin: 20px 0;
    padding: 20px;
    background: #f0f0f1;
    border-radius: 5px;
}

.cjm-export-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.cjm-export-option {
    background: #fff;
    padding: 20px;
    border: 1px solid #c3c4c7;
    border-radius: 5px;
}

.cjm-export-option h4 {
    margin-top: 0;
}
</style> 