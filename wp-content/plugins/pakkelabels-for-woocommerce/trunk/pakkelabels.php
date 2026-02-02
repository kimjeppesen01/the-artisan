<?php
/*
 * Plugin Name: Shipmondo for WooCommerce
 * Plugin URI: https://shipmondo.com
 * Description: Shipping for WooCommerce. Choose from over 40 carriers, such as Bring, DHL, GLS, and PostNord.
 * Version: 5.0.5
 * Text Domain: pakkelabels-for-woocommerce
 * Domain Path: /languages
 * Author: Shipmondo
 * Author URI: https://shipmondo.com
 * Requires at least: 6.2
 * Tested up to: 6.7
 * WC requires at least: 8.0
 * WC tested up to: 9.6
 */


// Load composer autoload
if(file_exists(__DIR__ . '/vendor/autoload.php')) {
	require_once(__DIR__ . '/vendor/autoload.php');
}

// Boot
new Shipmondo\Tools\Boot(__DIR__ . '/app', 'Shipmondo');

// Declare compatibility with WooCommerce Custom Order Tables (HPOS)
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

if(shipmondo_is_woocommerce_active()) {
	/* Start on MVC and OOP in the plugin - Added by Morning Train */
	require_once(__DIR__ . '/lib/class.plugin-init.php');
	ShipmondoForWooCommerce\PluginInit::registerPlugin(__FILE__);

	function shipmondo_init() {
		load_plugin_textdomain('pakkelabels-for-woocommerce', false, dirname(plugin_basename(__FILE__)) . '/languages');
	}

	shipmondo_init();
}

/**
 * Is WooCommerce active
 * @return bool
 */
function shipmondo_is_woocommerce_active() {
	if(!function_exists('is_plugin_active_for_network')) {
		require_once(ABSPATH . '/wp-admin/includes/plugin.php');
	}

	return (
	        class_exists('WooCommerce')
            || in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
	        || is_plugin_active( 'woocommerce/woocommerce.php')
	        || is_plugin_active_for_network( 'woocommerce/woocommerce.php' )
	        || is_plugin_active( '__woocommerce/woocommerce.php')
	        || is_plugin_active_for_network( '__woocommerce/woocommerce.php' )
	);
}
