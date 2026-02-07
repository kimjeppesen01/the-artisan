<?php
/**
 * Plugin Name: Artisan Recipe App
 * Description: Interactive coffee brewing guide — mobile-first, QR-scannable universal recipe page.
 * Version:     2.0.0
 * Author:      The Artisan
 * Text Domain: artisan-recipe
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'SARA_VERSION', '2.0.0' );
define( 'SARA_PLUGIN_FILE', __FILE__ );
define( 'SARA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SARA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', 'sara_init' );

function sara_init() {
    require_once SARA_PLUGIN_DIR . 'includes/class-recipe-data.php';
    require_once SARA_PLUGIN_DIR . 'includes/class-recipe-shortcode.php';

    new SARA_Recipe_Shortcode();
}
