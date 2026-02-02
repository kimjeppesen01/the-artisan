<?php

namespace Shipmondo\Services;

use ShipmondoForWooCommerce\Plugin\Controllers\LegacyController;
use ShipmondoForWooCommerce\Plugin\Controllers\SettingsController;
use ShipmondoForWooCommerce\Plugin\Plugin;

class ShipmondoApiService
{
	private static $service_points_api_url = 'https://service-points.shipmondo.com/service-points.json';

	public static function callServicePointsAPI($data) {

		$defaults = array(
			'frontend_key' => SettingsController::getFrontendKey(),
			'country' => isset($GLOBALS['woocommerce']->countries) ? $GLOBALS['woocommerce']->countries->get_base_country() : '',
			'number' => 10,
			'request_url' => get_home_url(),
			'request_version' => LegacyController::getWooCommerceVersion(),
			'module_version' => Plugin::getVersion(),
			'shipping_module_type' => 'woocommerce',
			'wp_version' => $GLOBALS['wp_version'],
		);

		$args = wp_parse_args($data, $defaults);

		$url = add_query_arg($args, static::$service_points_api_url);

		return wp_remote_get($url);
	}
}