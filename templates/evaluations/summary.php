<div class="cjm-evaluation-summary">
    <h2>Evaluation Report: <?php echo $candidate_name; ?></h2>
    
    <div class="score-card">
        <div class="overall-score">
            <h3>Overall Score</h3>
            <div class="score-value"><?php echo $average_score; ?>/5</div>
        </div>
        
        <div class="recommendation">
            <h3>Recommendation</h3>
            <div class="badge <?php echo $recommendation; ?>">
                <?php echo ucwords(str_replace('_', ' ', $recommendation)); ?>
            </div>
        </div>
    </div>

    <?php foreach ($section_breakdown as $section): ?>
    <div class="section-breakdown">
        <h4><?php echo $section['label']; ?></h4>
        <table>
            <?php foreach ($section['criteria'] as $criterion): ?>
            <tr>
                <td><?php echo $criterion['label']; ?></td>
                <td><?php echo $criterion['average']; ?></td>
                <td><?php echo $criterion['comments']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endforeach; ?>
</div>