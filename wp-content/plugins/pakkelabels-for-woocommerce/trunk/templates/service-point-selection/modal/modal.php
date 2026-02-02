<?php
	/**
	 * @var $servicePoints array
	 * @var $selectedServicePoint array
	 */

	use ShipmondoForWooCommerce\Plugin\Plugin;
?>

<div class="shipmondo-modal shipmondo-hidden service_points_modal" tabindex="-1" role="dialog" aria-labelledby="<?php print __('service point window', 'pakkelabels-for-woocommerce'); ?>">
    <div class="shipmondo-modal_wrapper">
		<?php Plugin::getTemplate('service-point-selection.modal.content', ['servicePoints' => $servicePoints, 'selectedServicePoint' => $selectedServicePoint]); ?>
    </div>
</div>