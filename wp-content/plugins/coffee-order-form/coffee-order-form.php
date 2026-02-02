<?php
/**
 * Plugin Name: Coffee Order Form
 * Description: Custom order form component with email notifications
 * Version: 1.0
 * Author: Your Name
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('COF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('COF_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files (we'll create these next)
require_once COF_PLUGIN_DIR . 'includes/class-coffee-order-form.php';

// Initialize the plugin
function cof_init() {
    $coffee_order_form = new Coffee_Order_Form();
}
add_action('plugins_loaded', 'cof_init');