<div class="cjm-evaluation-form">
    <h2><?php _e('Candidate Evaluation'); ?></h2>
    
    <?php foreach ($sections as $section): ?>
    <div class="evaluation-section">
        <h3><?php echo esc_html($section['label']); ?></h3>
        
        <?php foreach ($section['criteria'] as $slug => $label): ?>
        <div class="rating-field">
            <label><?php echo esc_html($label); ?></label>
            <select name="criteria[<?php echo $slug; ?>][rating]">
                <option value=""><?php _e('Select Rating'); ?></option>
                <?php foreach ([5,4,3,2,1,0] as $value): ?>
                <option value="<?php echo $value; ?>">
                    <?php echo $this->get_rating_label($value); ?>
                </option>
                <?php endforeach; ?>
            </select>
            <textarea name="criteria[<?php echo $slug; ?>][comments]" 
                placeholder="<?php _e('Comments...'); ?>"></textarea>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>

    <div class="overall-assessment">
        <h3><?php _e('Overall Recommendation'); ?></h3>
        <select name="overall_recommendation" required>
            <option value=""><?php _e('Select Recommendation'); ?></option>
            <option value="highly_recommended"><?php _e('Highly Recommended'); ?></option>
            <option value="recommended"><?php _e('Recommended'); ?></option>
            <option value="neutral"><?php _e('Neutral'); ?></option>
            <option value="not_recommended"><?php _e('Not Recommended'); ?></option>
        </select>
    </div>
</div>