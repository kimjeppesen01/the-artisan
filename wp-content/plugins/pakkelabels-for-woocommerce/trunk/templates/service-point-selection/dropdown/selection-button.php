<?php
	/**
	 * @var $shippingMethod \ShipmondoForWooCommerce\Plugin\ShippingMethods\Shipmondo
	 * @var $index string
	 * @var $selectedServicePoint array
	 * @var $servicePoints array
	 */

	use ShipmondoForWooCommerce\Plugin\Plugin;

?>
<div class="shipmondo-original">
	<div class="shipmondo_service_point_selection selector_type-dropdown" data-shipping_agent="<?php echo $shippingMethod->getShippingAgent(); ?>" data-shipping_index="<?php echo $index; ?>" data-selected_service_point="<?php echo htmlentities(json_encode($selectedServicePoint), ENT_QUOTES, 'UTF-8'); ?>">
		<div class="selected_service_point service_point selector_type-dropdown">
			<div class="header">
				<span class="name"><?php echo $selectedServicePoint['name']; ?></span>
			</div>
			<div class="location">
				<div class="address_info">
					<?php
						echo sprintf(_x('%1$s, %2$s %3$s', 'Address display: %1$s - street and number, %2$s zipcode and %3$s city', 'pakkelabels-for-woocommerce'),
							$selectedServicePoint['address'],
							$selectedServicePoint['zipcode'],
							$selectedServicePoint['city']
						);
					?>
				</div>
				<div class="distance">
					<?php
						echo sprintf(_x('%s km', 'Distance display', 'pakkelabels-for-woocommerce'),
							number_format($selectedServicePoint['distance']/1000, 2, '.', '')
						);
					?>
				</div>
			</div>
		</div>
		<div class="shipmondo-dropdown_wrapper">
			<?php Plugin::getTemplate('service-point-selection.dropdown.content', ['servicePoints' => $servicePoints, 'selectedServicePoint' => $selectedServicePoint]); ?>
		</div>
		<div class="powered_by_shipmondo">
			<p><?php _e('Powered by Shipmondo', 'pakkelabels-for-woocommerce'); ?></p>
		</div>
		<div class="hidden_chosen_shop">
			<input type="hidden" name="shipmondo[<?php echo $index; ?>]" value="<?php echo $selectedServicePoint['id']; ?>">
			<input type="hidden" name="shop_name[<?php echo $index; ?>]" value="<?php echo $selectedServicePoint['name']; ?>">
			<input type="hidden" name="shop_address[<?php echo $index; ?>]" value="<?php echo $selectedServicePoint['address']; ?>">
			<input type="hidden" name="shop_zip[<?php echo $index; ?>]" value="<?php echo $selectedServicePoint['zipcode']; ?>">
			<input type="hidden" name="shop_city[<?php echo $index; ?>]" value="<?php echo $selectedServicePoint['city']; ?>">
		</div>
	</div>
</div>
