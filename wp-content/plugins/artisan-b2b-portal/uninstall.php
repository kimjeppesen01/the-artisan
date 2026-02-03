<?php
/**
 * Plugin Uninstall
 * Removes all plugin data when uninstalled
 */

// Exit if not called by WordPress
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

// Only remove data if option is set (prevent accidental deletion)
$remove_data = get_option('ab2b_remove_data_on_uninstall', false);

if ($remove_data) {
    // Drop custom tables
    $tables = [
        $wpdb->prefix . 'ab2b_order_items',
        $wpdb->prefix . 'ab2b_orders',
        $wpdb->prefix . 'ab2b_product_weights',
        $wpdb->prefix . 'ab2b_products',
        $wpdb->prefix . 'ab2b_customers',
    ];

    foreach ($tables as $table) {
        $wpdb->query("DROP TABLE IF EXISTS {$table}");
    }

    // Delete options
    delete_option('ab2b_settings');
    delete_option('ab2b_db_version');
    delete_option('ab2b_portal_page_id');
    delete_option('ab2b_remove_data_on_uninstall');

    // Delete transients
    delete_transient('ab2b_activated');
    delete_transient('ab2b_admin_error');
    delete_transient('ab2b_admin_success');
}
