<?php
/**
 * Plugin Name: Artisan B2B Portal
 * Plugin URI: https://theartisan.dk
 * Description: B2B ordering portal for wholesale coffee customers with admin dashboard, product management, and customer portal.
 * Version: 2.0.0
 * Author: The Artisan
 * Author URI: https://theartisan.dk
 * Text Domain: artisan-b2b-portal
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('AB2B_VERSION', '2.0.0');
define('AB2B_PLUGIN_FILE', __FILE__);
define('AB2B_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AB2B_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AB2B_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Autoloader for plugin classes
 */
spl_autoload_register(function ($class) {
    // Only handle our plugin classes
    if (strpos($class, 'AB2B_') !== 0) {
        return;
    }

    // Convert class name to file path
    $class_file = str_replace('AB2B_', '', $class);
    $class_file = strtolower($class_file);
    $class_file = str_replace('_', '-', $class_file);

    // Build possible file paths
    $paths = [
        AB2B_PLUGIN_DIR . 'includes/class-ab2b-' . $class_file . '.php',
        AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-' . $class_file . '.php',
        AB2B_PLUGIN_DIR . 'includes/admin/class-ab2b-' . $class_file . '.php',
        AB2B_PLUGIN_DIR . 'includes/public/class-ab2b-' . $class_file . '.php',
        AB2B_PLUGIN_DIR . 'includes/api/class-ab2b-' . $class_file . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

/**
 * Plugin activation hook
 */
function ab2b_activate() {
    require_once AB2B_PLUGIN_DIR . 'includes/class-ab2b-activator.php';
    AB2B_Activator::activate();
}
register_activation_hook(__FILE__, 'ab2b_activate');

/**
 * Plugin deactivation hook
 */
function ab2b_deactivate() {
    require_once AB2B_PLUGIN_DIR . 'includes/class-ab2b-deactivator.php';
    AB2B_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'ab2b_deactivate');

/**
 * Initialize the plugin
 */
function ab2b_init() {
    // Load text domain
    load_plugin_textdomain('artisan-b2b-portal', false, dirname(AB2B_PLUGIN_BASENAME) . '/languages');

    // Run DB migrations if needed
    ab2b_maybe_migrate();

    // Initialize core classes
    require_once AB2B_PLUGIN_DIR . 'includes/class-ab2b-loader.php';
    require_once AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-helpers.php';

    // Initialize admin
    if (is_admin()) {
        require_once AB2B_PLUGIN_DIR . 'includes/admin/class-ab2b-admin.php';
        new AB2B_Admin();
    }

    // Initialize public/frontend
    require_once AB2B_PLUGIN_DIR . 'includes/public/class-ab2b-public.php';
    new AB2B_Public();

    // Initialize REST API
    require_once AB2B_PLUGIN_DIR . 'includes/api/class-ab2b-rest-api.php';
    new AB2B_Rest_Api();

    // Initialize email system (registers hooks for order notifications)
    require_once AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-email.php';
}
add_action('plugins_loaded', 'ab2b_init');

/**
 * Get plugin option with default
 */
function ab2b_get_option($key, $default = '') {
    $options = get_option('ab2b_settings', []);
    return isset($options[$key]) ? $options[$key] : $default;
}

/**
 * Update plugin option
 */
function ab2b_update_option($key, $value) {
    $options = get_option('ab2b_settings', []);
    $options[$key] = $value;
    update_option('ab2b_settings', $options);
}

/**
 * Get table name with prefix
 */
function ab2b_table($table) {
    global $wpdb;
    return $wpdb->prefix . 'ab2b_' . $table;
}

/**
 * Run database migrations if needed
 */
function ab2b_maybe_migrate() {
    $db_version = get_option('ab2b_db_version', '1.0.0');

    if (version_compare($db_version, '2.1.0', '<')) {
        global $wpdb;
        $table = $wpdb->prefix . 'ab2b_orders';

        // Add delivery_method column
        $col = $wpdb->get_results("SHOW COLUMNS FROM {$table} LIKE 'delivery_method'");
        if (empty($col)) {
            $wpdb->query("ALTER TABLE {$table} ADD COLUMN delivery_method VARCHAR(20) DEFAULT 'shipping' AFTER delivery_date");
        }

        // Add shipping_cost column
        $col = $wpdb->get_results("SHOW COLUMNS FROM {$table} LIKE 'shipping_cost'");
        if (empty($col)) {
            $wpdb->query("ALTER TABLE {$table} ADD COLUMN shipping_cost DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER delivery_method");
        }

        update_option('ab2b_db_version', '2.1.0');
    }

    if (version_compare($db_version, '2.2.0', '<')) {
        global $wpdb;
        $table = $wpdb->prefix . 'ab2b_customers';
        $cols = ['city', 'postcode', 'cvr_number', 'delivery_company', 'delivery_contact', 'delivery_address', 'delivery_city', 'delivery_postcode'];
        foreach ($cols as $col) {
            $exists = $wpdb->get_results($wpdb->prepare("SHOW COLUMNS FROM {$table} LIKE %s", $col));
            if (empty($exists)) {
                $def = ($col === 'delivery_address') ? "TEXT" : "VARCHAR(255) DEFAULT ''";
                $wpdb->query("ALTER TABLE {$table} ADD COLUMN {$col} {$def}");
            }
        }
        update_option('ab2b_db_version', '2.2.0');
    }
}
