<?php

namespace Shipmondo\Hooks\ServicePointSelectorBlock;

use Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema;
use Automattic\WooCommerce\StoreApi\Schemas\V1\CheckoutSchema;
use Automattic\WooCommerce\StoreApi\StoreApi;
use Shipmondo\Interfaces\HookLoaderInterface;

class ExtendStoreApiWithSelectedServicePoint implements HookLoaderInterface
{
	public static function register() {
		add_filter('woocommerce_blocks_loaded', [static::class, 'registerEndpointData'], 10, 2);
	}

	public static function registerEndpointData() {
		StoreApi::container()->get(ExtendSchema::class)->register_endpoint_data([
			'endpoint' => CheckoutSchema::IDENTIFIER,
			'namespace' => 'shipmondo',
			'schema_callback' => [static::class, 'getSchema'],
			'schema_type' => ARRAY_A
		]);
	}

	public static function getSchema() {
		return [
			'selected_service_points' => [
				'description' => __('Selected service points to send the package to', 'pakkelabels-for-woocommerce'),
				'type' => 'object',
				'additionalProperties' => [
					'type' => 'object',
					'properties' => [
						'id' => [
							'description' => __('The ID of the service point', 'pakkelabels-for-woocommerce'),
							'type' => 'string',
							'readonly' => true
						],
						'name' => [
							'description' => __('The name of the service point', 'pakkelabels-for-woocommerce'),
							'type' => 'string',
							'readonly' => true
						],
						'address' => [
							'description' => __('The address of the service point', 'pakkelabels-for-woocommerce'),
							'type' => 'string',
							'readonly' => true
						],
						'zipcode'=> [
							'description' => __('The zipcode of the service point', 'pakkelabels-for-woocommerce'),
							'type' => 'string',
							'readonly' => true
						],
						'city' => [
							'description' => __('The city of the service point', 'pakkelabels-for-woocommerce'),
							'type' => 'string',
							'readonly' => true
						],
						'country' => [
							'description' => __('The country of the service point', 'pakkelabels-for-woocommerce'),
							'type' => 'string',
							'readonly' => true
						],
						'agent' => [
							'description' => __('The carrier code of the service point', 'pakkelabels-for-woocommerce'),
							'type' => 'string',
							'readonly' => true
						]
					]
				]
			]
		];
	}
}