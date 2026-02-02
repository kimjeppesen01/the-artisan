<?php

namespace Shipmondo\Api\V1;

use Shipmondo\Services\ShipmondoApiService;
use WP_REST_Request;
use WP_REST_Response;

class ServicePoints {

	public static string $namespace = 'shipmondo';
	public static string $version = 'v1';
	public static string $resourceName = 'service-points';

	public static function registerRestRoutes() {
		register_rest_route(
			static::$namespace . '/' . static::$version,
			static::$resourceName,
			[
				'methods' => 'POST',
				'callback' => [static::class, 'getServicePoints'],
				'permission_callback' => '__return_true'
			]
		);
	}

	public static function getServicePoints(WP_REST_Request $request) {
		$apiResponse = ShipmondoApiService::callServicePointsAPI([
			'agent' => $request->get_param('agent'),
			'address' => $request->get_param('address'),
			'zipcode' => $request->get_param('zipcode'),
			'country' => $request->get_param('country')
		]);

		if(is_wp_error($apiResponse)) {
			return $apiResponse;
		}

		$body = json_decode(wp_remote_retrieve_body($apiResponse));
		$responseCode = wp_remote_retrieve_response_code($apiResponse);

		if($responseCode !== 200) {
			return new WP_REST_Response($body, $responseCode);
		}

		return new WP_REST_Response($body, '200');
	}
}