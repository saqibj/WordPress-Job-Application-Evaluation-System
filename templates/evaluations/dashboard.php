<div class="cjm-evaluation-dashboard">
    <h1><?php _e('Interviewer Dashboard') ?></h1>
    
    <?php if (!empty($applications)) : ?>
        <table class="cjm-applications-table">
            <thead>
                <tr>
                    <th><?php _e('Candidate') ?></th>
                    <th><?php _e('Position') ?></th>
                    <th><?php _e('Status') ?></th>
                    <th><?php _e('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application) : ?>
                <tr>
                    <td><?php echo esc_html($application->candidate_name); ?></td>
                    <td><?php echo get_the_title($application->job_id); ?></td>
                    <td>
                        <span class="status-<?php echo $application->status; ?>">
                            <?php echo ucfirst(str_replace('_', ' ', $application->status)); ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?php echo get_permalink($application->application_id); ?>?action=evaluate" 
                           class="button">
                            <?php _e('Evaluate') ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p><?php _e('No assigned applications for evaluation.'); ?></p>
    <?php endif; ?>
</div>