<?php namespace ShipmondoForWooCommerce\Plugin;

use Shipmondo\Services\ShipmondoApiService;
use ShipmondoForWooCommerce\Plugin\Controllers\LegacyController;
use ShipmondoForWooCommerce\Plugin\Controllers\SettingsController;

class ShipmondoAPI {

    public static function getServicePoints($agent, $zipcode, $country = '') {
        $data = array(
            'agent' => $agent,
            'zipcode' => $zipcode,
        );

        if(!empty($country)) {
            $data['country'] = $country;
        }

        $pickup_pints = ShipmondoApiService::callServicePointsAPI($data);

        if(is_wp_error($pickup_pints)) {
            return $pickup_pints;
        }

        $body = json_decode($pickup_pints['body']);

        if(!isset($body->message)) {
            return $body;
        }

        return array();
    }
}