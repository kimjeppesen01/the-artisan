<?php

namespace Shipmondo\Blocks\ServicePointSelector;

use Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface;
use ShipmondoForWooCommerce\Plugin\Controllers\SettingsController;
use ShipmondoForWooCommerce\Plugin\Plugin;

class ServicePointSelectorBlock implements IntegrationInterface {
	public function get_name() {
		return 'shipmondo-service-point-selector';
	}

	public function initialize() {
		$this->registerFrontendScripts();
		$this->registerEditorScripts();

		$this->registerStyles();
	}

	public function registerFrontendScripts() {
		$scriptAssetsPath = Plugin::getRoot('public/build/blocks/service-point-selector/view.asset.php');

		$scriptAssets = file_exists( $scriptAssetsPath ) ? require $scriptAssetsPath : ['dependencies' => [], 'version' => Plugin::getVersion()];

		$handle = 'shipmondo-service-point-selector-block-view';

		wp_register_script(
			$handle,
			Plugin::getFileURL('service-point-selector/view.js', ['public/build/blocks']),
			$scriptAssets['dependencies'],
			$scriptAssets['version'],
			true
		);

		wp_set_script_translations($handle, 'pakkelabels-for-woocommerce');
	}

	public function registerEditorScripts() {
		$scriptAssetsPath = Plugin::getRoot('public/build/blocks/service-point-selector/edit.asset.php');

		$scriptAssets = file_exists( $scriptAssetsPath ) ? require $scriptAssetsPath : ['dependencies' => [], 'version' => Plugin::getVersion()];

		$handle = 'shipmondo-service-point-selector-block-edit';

		wp_register_script(
			$handle,
			Plugin::getFileURL('service-point-selector/edit.js', ['public/build/blocks']),
			$scriptAssets['dependencies'],
			$scriptAssets['version'],
			true
		);

		wp_set_script_translations($handle, 'pakkelabels-for-woocommerce');
	}

	public function registerStyles() {
		$scriptAssetsPath = Plugin::getRoot('public/build/blocks/service-point-selector/view.asset.php');

		$scriptAssets = file_exists( $scriptAssetsPath ) ? require $scriptAssetsPath : ['version' => Plugin::getVersion()];

		wp_enqueue_style(
			'shipmondo-service-point-selector-block-style',
			Plugin::getFileURL('service-point-selector/style-view.css', ['public/build/blocks']),
			[],
			$scriptAssets['version']
		);
	}

	public function get_script_handles() {
		return ['shipmondo-service-point-selector-block-view'];
	}

	public function get_editor_script_handles() {
		return ['shipmondo-service-point-selector-block-edit'];
	}

	public function get_script_data() {
		return array(
			'selector_type' => SettingsController::getSelectionType(),
			'maps_settings' => [
				'maps_icon' => Plugin::getFileURL('picker_default.png', array('images')),
				'maps_icon_selected' => Plugin::getFileURL('picker_green.png', array('images')),
				'google_maps_api_key' => SettingsController::getGoogleMapsAPIKey(),
				'store_country' => wc_get_base_location()['country']
			]
		);
	}
}