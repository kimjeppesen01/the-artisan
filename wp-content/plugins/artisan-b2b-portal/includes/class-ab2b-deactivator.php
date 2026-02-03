<?php
/**
 * Plugin Deactivator
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Deactivator {

    /**
     * Run deactivation tasks
     */
    public static function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();

        // Clear any scheduled events
        wp_clear_scheduled_hook('ab2b_daily_cleanup');
    }
}
