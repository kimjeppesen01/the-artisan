<?php

namespace Shipmondo\Hooks\ServicePointSelectorBlock;

use Automattic\WooCommerce\StoreApi\Exceptions\RouteException;
use Shipmondo\Interfaces\HookLoaderInterface;
use ShipmondoForWooCommerce\Plugin\Controllers\ShippingMethodsController;
use ShipmondoForWooCommerce\Plugin\ShippingMethods\Shipmondo;
use WC_Order;
use WP_REST_Request;

class SetServicePointOnCompletion implements HookLoaderInterface
{
	public static function register()
	{
		add_action('woocommerce_store_api_checkout_update_order_from_request', [static::class, 'setServicePointOnOrder'], 10, 2);
	}

	public static function setServicePointOnOrder(WC_Order $order, WP_REST_Request $request)
	{
		$servicePoints = $request->get_param('extensions')['shipmondo']['selected_service_points'] ?? [];

		static::validateServicePoints($servicePoints);

		if(empty($servicePoints)) {
			// No service point delivery
			return;
		}

		$shippingInfo = [];

		foreach($servicePoints as $packageKey => $servicePoint) {
			$shippingInfo[$packageKey] = [
				'name' => $servicePoint['name'],
				'address_1' => $servicePoint['address'],
				'city' => $servicePoint['city'],
				'postcode' => $servicePoint['zipcode'],
				'country' => $servicePoint['country'],
				'carrier_code' => $servicePoint['agent'],
				'id' => $servicePoint['id']
			];
		}

		$order->update_meta_data('shipmondo_pickup_points', $shippingInfo);

		foreach(wc()->shipping()->get_packages() as $packageKey => $package) {
			if(empty($servicePoints[$packageKey])) {
				continue;
			}

			$chosenMethod = ShippingMethodsController::getChosenShippingMethodForPackage($packageKey);

			if($chosenMethod === null || !is_a($chosenMethod, Shipmondo::class) || !$chosenMethod->isServicePointDelivery()) {
				continue;
			}

			$shippingInfo = [
				'name' => $servicePoints[$packageKey]['name'],
				'address_1' => $servicePoints[$packageKey]['address'],
				'city' => $servicePoints[$packageKey]['city'],
				'postcode' => $servicePoints[$packageKey]['zipcode'],
				'country' => $servicePoints[$packageKey]['country'],
				'carrier_code' => $servicePoints[$packageKey]['agent'],
				'id' => $servicePoints[$packageKey]['id']
			];

			$order->update_meta_data("shipmondo_pickup_point", $shippingInfo);

			break;
		}
	}

	private static function validateServicePoints(array $servicePoints) :void
	{
		foreach(wc()->shipping()->get_packages() as $packageKey => $package) {
			$chosenMethod = ShippingMethodsController::getChosenShippingMethodForPackage($packageKey);

			if(!is_a($chosenMethod, Shipmondo::class)) {
				continue;
			}

			if($chosenMethod->isServicePointDelivery() && empty($servicePoints[$packageKey])) {
				throw new RouteException(
					'shipmondo_service_point_missing',
					__('Service point is missing', 'pakkelabels-for-woocommerce'),
					400
				);
			}
		}
	}

}