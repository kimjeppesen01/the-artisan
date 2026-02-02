<?php
	/**
	 * @var $servicePoints array
	 * @var $selectedServicePoint array
	 */
?>
<div class="service_points_dropdown">
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