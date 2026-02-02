<?php namespace ShipmondoForWooCommerce\Plugin\Controllers;

use Shipmondo\Services\ServicePointService;
use ShipmondoForWooCommerce\Lib\Abstracts\Controller;
use ShipmondoForWooCommerce\Lib\Tools\Loader;
use ShipmondoForWooCommerce\Plugin\ShipmondoAPI;
use ShipmondoForWooCommerce\Plugin\Plugin;
use ShipmondoForWooCommerce\Plugin\ShippingMethods\Shipmondo;

class ServicePointsController extends Controller {

    /**
	 * @author Morning Train - Martin Schadegg Brønniche <ms@morningtrain.dk>
	 * @since 1.2.0
	 */
    protected function registerActions() {
        Loader::addAction('wp_enqueue_scripts', $this, 'enqueueScripts');
	    Loader::addAction('wp_ajax_shipmondo_set_selection_session', $this, 'setSelectionSession');
	    Loader::addAction('wp_ajax_nopriv_shipmondo_set_selection_session', $this, 'setSelectionSession');

	    Loader::addAction('woocommerce_after_shipping_rate', static::class, 'displayServicePointFinder', 10, 2);
	    Loader::addAction('woocommerce_checkout_create_order_shipping_item', static::class, 'updateOrderMeta', 10, 4);

		Loader::addAction('woocommerce_checkout_process', static::class, 'validateServicePointSelection');
    }

	/**
	 *
	 * @return void
	 */
	protected function registerFilters() {
		parent::registerFilters();

		Loader::addFilter('woocommerce_order_get_formatted_shipping_address', static::class, 'displayPickupPointAfterDeliveryAddress', 10, 3);
	}

	/**
	 * @param string $address
	 * @param array $raw_address
	 * @param \WC_Order $order
	 *
	 * @return mixed|string
	 */
	public static function displayPickupPointAfterDeliveryAddress($address, $raw_address, $order) {
		$info = $order->get_meta('shipmondo_pickup_point');

		if(!empty($info)) {
			if(!empty($address)) {
				$address .= '<br><br>';
			}

			$info['company'] = $info['name'];

			$address .= __('Pickup Point:', 'pakkelabels-for-woocommerce') . '<br>';

			$address .= WC()->countries->get_formatted_address( $info );
		}

		return $address;
	}

	/**
	 * Set session with current pickup point selection

	 * @author Morning Train - Martin Schadegg Brønniche <ms@morningtrain.dk>
	 * @since 2.2.0
	 */
    public function setSelectionSession() {
		ServicePointService::setSelectedServicePointSession($_POST['agent'], $_POST['shipping_index'], $_POST['selection']);

    	exit();
    }

    /*
     * Enqueue Scripts and styling if on checkout page
	 * @author Morning Train - Martin Schadegg Brønniche <ms@morningtrain.dk>
	 * @since 1.2.0
	 */
    public function enqueueScripts() {
        if($this->isCheckout()) {
	        $scriptAssetsPath = Plugin::getRoot('public/build/js/shipmondo-service-point.asset.php');

	        $scriptAssets = file_exists( $scriptAssetsPath ) ? require $scriptAssetsPath : ['dependencies' => [], 'version' => Plugin::getVersion()];

	        $scriptHandle = 'shipmondo-service-point-script';

	        wp_enqueue_script(
		        $scriptHandle,
		        Plugin::getFileURL('shipmondo-service-point.js', ['public/build/js']),
		        $scriptAssets['dependencies'],
		        $scriptAssets['version'],
		        true
	        );

			wp_localize_script($scriptHandle, 'shipmondo', [
				'getServicePointsUrl' => get_rest_url(null, 'shipmondo/v1/service-points'),
				'ajax_url' => admin_url('admin-ajax.php'),
				'icon_url' => Plugin::getFileURL('picker_default.png', array('images')),
				'icon_url_selected' => Plugin::getFileURL('picker_green.png', array('images')),
				'select_shop_text' => __('Choose pickup point', 'pakkelabels-for-woocommerce'),
				'google_maps_api_key' => SettingsController::getGoogleMapsAPIKey(),
			]);

	        $styleAssetsPath = Plugin::getRoot('public/build/css/shipmondo-service-point.asset.php');

	        $styleAssets = file_exists( $styleAssetsPath ) ? require $styleAssetsPath : ['dependencies' => [], 'version' => Plugin::getVersion()];

			wp_enqueue_style(
				'shipmondo-service-point-style',
		        Plugin::getFileURL('shipmondo-service-point.css', ['public/build/css']),
				$styleAssets['dependencies'],
				$styleAssets['version']
	        );
        }
    }

    /*
     * Check if is checkout and not payment page and order recieved page
     */
    private function isCheckout() {
    	return is_checkout() && !is_wc_endpoint_url('order-received') && !is_wc_endpoint_url('order-pay');
    }

	/**
	 * Get current selection
	 *
	 * @param      $field_name
	 * @param null $agent
	 *
	 * @return string
	 */
    public static function getCurrentSelection($field_name, $agent, $index = 0, $default = '') {
    	$current_selection = WC()->session->get('shipmondo_current_selection', array());

    	if(empty($current_selection[$index]) || !static::isCurrentSelection($agent, $index)) {
    		return $default;
	    }

    	if(isset($current_selection[$index]['selection'][$field_name])) {
    		return $current_selection[$index]['selection'][$field_name];
	    }

    	if($field_name == 'zip_city') {
    		$parts = array(
			    static::getCurrentSelection('zipcode', $agent, $index),
			    static::getCurrentSelection('city', $agent, $index)
		    );
    		return implode(', ', $parts);
	    }

		if(empty($field_name)) {
			return $current_selection[$index]['selection'];
		}

    	return $default;
    }

	/**
	 * Is current selection
	 * @return bool
	 */
    public static function isCurrentSelection($agent, $index = 0) {
	    $current_selection = WC()->session->get('shipmondo_current_selection', array());

	    if( !isset($current_selection[$index]['agent']) ||
		    $current_selection[$index]['agent'] !== $agent ||
		    !isset($current_selection[$index]['selection'])) {
		    return false;
	    }

	    $required_fields = array(
	    	'id',
	        'name',
		    'address',
		    'zipcode',
		    'city'
	    );

	    foreach($required_fields as $field) {
	    	if(!isset($current_selection[$index]['selection'][$field])) {
	    		return false;
		    }
	    }

	    return true;
    }

	/**
	 * Display pickup point finder if ServicePoint is chosen
	 * @param $rate
	 * @param $index
	 */
	public static function displayServicePointFinder($rate, $index) {
    	$chosen_shipping_method = ShippingMethodsController::getChosenShippingMethodForPackage($index);

    	if(static::isShippingMethodServicePointDelivery($chosen_shipping_method) && $chosen_shipping_method->get_rate_id() == $rate->get_id()) {
    		$chosen_shipping_method->displayServicePointFinder($index);
	    }
	}

	/**
	 * Check if shipping method is shipmondo and is pickup point
	 * @param $shipping_method
	 *
	 * @return bool
	 */
	public static function isShippingMethodServicePointDelivery($shipping_method) {
		return $shipping_method !== null && is_a($shipping_method, Shipmondo::class) && $shipping_method->isServicePointDelivery();
	}



	/**
	 * Update order meta and shipping address with pickup point
	 * @param $item
	 * @param $package_key
	 * @param $package
	 * @param $order
	 */
	public static function updateOrderMeta($item, $package_key, $package, $order) {
		$shipping_method = ShippingMethodsController::getChosenShippingMethodForPackage($package_key);

		if($shipping_method === null || !is_a($shipping_method, Shipmondo::class) || !$shipping_method->isServicePointDelivery()) {
			return;
		}

		$shipping_info = array(
			'name' => (!empty($_POST['shop_name'][$package_key]) ? $_POST['shop_name'][$package_key] : ServicePointsController::getCurrentSelection('name', $shipping_method->getShippingAgent(), $package_key)),
			'address_1' => (!empty($_POST['shop_address'][$package_key]) ? $_POST['shop_address'][$package_key] : ServicePointsController::getCurrentSelection('address', $shipping_method->getShippingAgent(), $package_key)),
			'city' => (!empty($_POST['shop_city'][$package_key]) ? $_POST['shop_city'][$package_key] : ServicePointsController::getCurrentSelection('city', $shipping_method->getShippingAgent(), $package_key)),
			'postcode' => (!empty($_POST['shop_zip'][$package_key]) ? $_POST['shop_zip'][$package_key] : ServicePointsController::getCurrentSelection('zipcode', $shipping_method->getShippingAgent(), $package_key)),
			'country' => $order->get_shipping_country() ? $order->get_shipping_country() : $order->get_billing_country(),
			'carrier_code' => $shipping_method->getShippingAgent(),
			'id' => (!empty($_POST['shipmondo'][$package_key]) ? $_POST['shipmondo'][$package_key] : ServicePointsController::getCurrentSelection('id', $shipping_method->getShippingAgent(), $package_key))
		);

		$order->update_meta_data('shipmondo_pickup_point', $shipping_info);
	}

	public static function validateServicePointSelection() {
		if(!WC()->cart->needs_shipping()) {
			return;
		}

		// Fix problem with WooCommerce Subscriptions
		WC()->cart->calculate_totals();

		// Get WC Shipping Packages
		foreach(WC()->shipping()->get_packages() as $package_key => $package) {
			static::validateServicePointSelectionForPackage($package_key);
		}

		// WooCommerce get WC Subscriptions cart packages
		if(isset(WC()->cart->recurring_carts)) {
			foreach(WC()->cart->recurring_carts as $cart_key => $cart) {
				foreach($cart->get_shipping_packages() as $package_key => $package) {
					$key = "{$cart_key}_{$package_key}";

					static::validateServicePointSelectionForPackage($key);
				}
			}
		}
	}

	public static function validateServicePointSelectionForPackage($package_key) {
		$chosen_shipping_method = ShippingMethodsController::getChosenShippingMethodForPackage($package_key);

		if(static::isShippingMethodServicePointDelivery($chosen_shipping_method)) {
			if((empty($_POST['shipmondo']) || empty($_POST['shipmondo'][$package_key])) && !ServicePointsController::isCurrentSelection($chosen_shipping_method->getShippingAgent(), $package_key)) {
				wc_add_notice(__('Please select a pickup point before placing your order.', 'pakkelabels-for-woocommerce'), 'error');
			}
		}
	}
}