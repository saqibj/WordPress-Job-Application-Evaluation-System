class CJM_Activator {
    public static function activate() {
        self::create_roles();
        // ... other activation code ...
    }

    private static function create_roles() {
        add_role('cjm_interviewer', __('Interviewer'), [
            'read' => true,
            'edit_cjm_evaluations' => true,
        ]);
        
        if ($admin = get_role('administrator')) {
            $admin->add_cap('manage_cjm_evaluations');
        }
    }
} 