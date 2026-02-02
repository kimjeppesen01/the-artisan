<?php

namespace Shipmondo\Hooks\ServicePointSelectorBlock;

use Shipmondo\Blocks\ServicePointSelector\ServicePointSelectorBlock;
use Shipmondo\Interfaces\HookLoaderInterface;

class RegisterBlock implements HookLoaderInterface
{
	public static function register()
	{
		add_action('woocommerce_blocks_checkout_block_registration', [static::class, 'registerServicePointSelectorBlock']);
	}

	public static function registerServicePointSelectorBlock($integrationRegistry) {
		$integrationRegistry->register(
			new ServicePointSelectorBlock()
		);
	}
}