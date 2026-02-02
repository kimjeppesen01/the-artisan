<?php
	/**
	 * @var $servicePoints array
	 * @var $selectedServicePoint array
	 */
?>
<div class="shipmondo-modal_content">
	<button class="shipmondo-modal_close">
		<span aria-hidden="true">&times;</span>
	</button>
    <div class="shipmondo-modal_header">
        <h4><?php echo _x('Select service point', 'Modal header', 'pakkelabels-for-woocommerce'); ?></h4>
    </div>
	<div class="service_points_map" data-service_points="<?php echo htmlentities(json_encode($servicePoints), ENT_QUOTES, 'UTF-8'); ?>">

	</div>
	<div class="service_points_list">
		<?php
			foreach($servicePoints as $servicePoint) {
				$address = sprintf(_x('%1$s, %2$s %3$s', 'Address display: %1$s - street and number, %2$s zipcode and %3$s city', 'pakkelabels-for-woocommerce'),
					$servicePoint['address'],
					$servicePoint['zipcode'],
					$servicePoint['city']
				);

				$distance = sprintf(_x('%s km', 'Distance display', 'pakkelabels-for-woocommerce'),
					number_format($servicePoint['distance']/1000, 2, '.', '')
				);

				?>
				<div class="service_point<?php echo $servicePoint['id'] === $selectedServicePoint['id'] ? ' selected' : ''; ?>"
				     data-id="<?php echo $servicePoint['id']; ?>"
				     data-service_point="<?php echo htmlentities(json_encode($servicePoint), ENT_QUOTES, 'UTF-8'); ?>"
				     data-address="<?php echo htmlentities($address, ENT_QUOTES, 'UTF-8'); ?>"
				     data-distance="<?php echo htmlentities($distance, ENT_QUOTES, 'UTF-8'); ?>"
				>
					<div class="header">
						<span class="name"><?php echo $servicePoint['name']; ?></span>
					</div>
					<div class="location">
						<div class="address_info">
							<?php
								echo $address;
							?>
						</div>
						<div class="distance">
							<?php
								echo $distance;
							?>
						</div>
					</div>
				</div>
				<?php
			}
		?>
	</div>
	<div class="shipmondo-modal_footer">
		<div class="powered_by_shipmondo">
			<p><?php _e('Powered by Shipmondo', 'pakkelabels-for-woocommerce'); ?></p>
		</div>
	</div>
</div>
<div class="shipmondo-modal-checkmark">
    <svg class="shipmondo-checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="shipmondo-checkmark_circle" cx="26" cy="26" r="25" fill="none"/><path class="shipmondo-checkmark_check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
</div>