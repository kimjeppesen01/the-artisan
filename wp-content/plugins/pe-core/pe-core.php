<?php
/**
 * Plugin Name: Pe Core
 * Plugin URI: http://www.pethemes.com
 * Description: A core plugin for PeThemes's WordPress themes.
 * Version: 1.6.6
 * Author: PeThemes
 * Author URI: http://www.pethemes.com
 */

require_once('pe-elementor.php');
require_once('inc/elementor.php');
require_once('inc/theme-functions.php');
require_once('inc/theme-tags.php');
require_once('inc/short-controls.php');
require_once('inc/portfolio.php');
require_once('inc/woocommerce.php');
require_once('inc/acf.php');
require_once('redux/redux.php');
require_once('redux/hooks.php');

function pe_core_styles()
{
    $plugin_url = plugin_dir_url(__FILE__);

    if (is_rtl()) {
        wp_enqueue_style('admin-rtl-styles', $plugin_url . "/assets/css/admin-rtl.css");
    } else {
        wp_enqueue_style('admin-styles', $plugin_url . "/assets/css/admin.css");
    }

    wp_enqueue_script('admin-scripts', $plugin_url . "/assets/js/admin.js", ['jquery', 'select2'], '1.0', true);

}
add_action('admin_enqueue_scripts', 'pe_core_styles');

add_action('admin_enqueue_scripts', 'pe_core_enqueue_custom_ajax_script');

function pe_core_enqueue_custom_ajax_script()
{
    wp_enqueue_script('pe_core-custom-ajax', plugin_dir_url(__FILE__) . "/assets/js/activator.js", array('jquery'), null, true);

    wp_localize_script('pe_core-custom-ajax', 'pe_core_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}

defined('ABSPATH') || exit;
