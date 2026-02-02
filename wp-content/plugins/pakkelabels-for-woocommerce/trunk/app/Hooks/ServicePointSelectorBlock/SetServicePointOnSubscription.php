<?php

namespace Shipmondo\Hooks\ServicePointSelectorBlock;

use Automattic\WooCommerce\StoreApi\Exceptions\RouteException;
use ShipmondoForWooCommerce\Plugin\Controllers\ShippingMethodsController;
use ShipmondoForWooCommerce\Plugin\ShippingMethods\Shipmondo;
use WC_Subscriptions_Cart;

class SetServicePointOnSubscription
{
	public static function register()
	{
		add_action('woocommerce_checkout_create_subscription', [static::class, 'setServicePointOnSubscription'], 10, 4);
	}

	public static function setServicePointOnSubscription($subscription, $postedData, $order, $cart)
	{
		if(!$cart->needs_shipping()) {
			// The subscription does not need shipping
			$subscription->delete_meta_data('shipmondo_pickup_point');
			$subscription->delete_meta_data('shipmondo_pickup_points');
			return;
		}

		$servicePoints = $order->get_meta('shipmondo_pickup_points') ?? [];

		if(empty($servicePoints)) {
			// No service point delivery
			return;
		}

		// We need to make sure we only get recurring shipping packages
		WC_Subscriptions_Cart::set_calculation_type( 'recurring_total' );
		WC_Subscriptions_Cart::set_recurring_cart_key( $cart->recurring_cart_key );

		static::validateServicePoints($servicePoints, $cart);

		if(empty($servicePoints)) {
			// No service point delivery
			return;
		}

		foreach($cart->get_shipping_packages() as $packageKey => $package) {
			if(empty($servicePoints[$packageKey])) {
				continue;
			}

			$chosenMethod = ShippingMethodsController::getChosenShippingMethodForPackage($packageKey);

			if($chosenMethod === null || !is_a($chosenMethod, Shipmondo::class) || !$chosenMethod->isServicePointDelivery()) {
				continue;
			}

			$shippingInfo = [
				'name' => $servicePoints[$packageKey]['name'],
				'address_1' => $servicePoints[$packageKey]['address_1'],
				'city' => $servicePoints[$packageKey]['city'],
				'postcode' => $servicePoints[$packageKey]['postcode'],
				'country' => $servicePoints[$packageKey]['country'],
				'carrier_code' => $servicePoints[$packageKey]['carrier_code'],
				'id' => $servicePoints[$packageKey]['id']
			];

			$subscription->update_meta_data("shipmondo_pickup_point", $shippingInfo);

			WC_Subscriptions_Cart::set_calculation_type( 'none' );
			WC_Subscriptions_Cart::set_recurring_cart_key( 'none' );

			return;
		}

		WC_Subscriptions_Cart::set_calculation_type( 'none' );
		WC_Subscriptions_Cart::set_recurring_cart_key( 'none' );

		$subscription->delete_meta_data('shipmondo_pickup_point');
	}

	private static function validateServicePoints(array $servicePoints, $cart) :void
	{
		foreach($cart->get_shipping_packages() as $packageKey => $package) {
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