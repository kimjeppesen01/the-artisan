<?php

namespace Shipmondo\Services;

class ServicePointService
{
	public static function getServicePoints($agent, $address, $zipcode, $country) {
		$apiResponse = ShipmondoApiService::callServicePointsAPI([
			'agent' => $agent,
			'address' => $address,
			'zipcode' => $zipcode,
			'country' => $country
		]);

		if(is_wp_error($apiResponse)) {
			return $apiResponse;
		}

		$body = json_decode(wp_remote_retrieve_body($apiResponse), true);
		$responseCode = wp_remote_retrieve_response_code($apiResponse);

		if($responseCode !== 200) {
			return new WP_Error('service_points_api_error', $body->message, ['status' => $responseCode]);
		}

		return $body;
	}

	public static function setSelectedServicePointSession($shippingAgent, $index, $servicePoint) {
		$session = WC()->session->get('shipmondo_current_selection');

		$session[$index] = array(
			'agent' => $shippingAgent,
			'selection' => $servicePoint
		);

		WC()->session->set('shipmondo_current_selection', $session);
	}
}