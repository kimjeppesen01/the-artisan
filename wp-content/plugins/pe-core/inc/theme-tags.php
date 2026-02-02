<?php if (!function_exists('pe_post_thumbnail')):
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */


	function pe_post_thumbnail()
	{
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		if (is_singular()):
			?>

			<div class="post-thumbnail single-post-image">
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail(); ?>
				</a>
			</div>

		<?php else: ?>



			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail single-post-image',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					),
					false
				);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}

endif;

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Pe-theme
 */

if (!function_exists('pe_posted_on')):
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function pe_posted_on()
	{
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr(get_the_date(DATE_W3C)),
			esc_html(get_the_date()),
			esc_attr(get_the_modified_date(DATE_W3C)),
			esc_html(get_the_modified_date())
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x('%s', 'post date', 'pe-core'),
			'<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

add_shortcode('woo_cart_but', 'woo_cart_but');

/**
 * Create Shortcode for WooCommerce Cart Menu Item
 */
function woo_cart_but($text, $count)
{
	ob_start();

	if ($count) {
		$cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
	} else {
		$cart_count = 5;
	}

	$cart_url = wc_get_cart_url();  // Set Cart URL

	if ($cart_count >= 0) {
		?>
		<div class="cart--count">
			<?php echo esc_html($cart_count); ?>
		</div>
		<?php
	}

	return ob_get_clean();
}


function pe_project_image($postid, $custom, $hover)
{
	$option = get_option('pe-redux');

	global $wp_query;
	$id = $postid;

	if ($custom) {
		$type = $custom['type'];
	} else {
		$type = get_field('media_type', $id);
	}

	if ($type === 'image') {

		$image = $custom ? $custom['imageUrl']['id'] : get_field('image', $id);
		$size = 'full';

		?>

		<?php if ($hover === 'bulge') { ?>

			<div class="pe--bulge card is-visible" data-img="<?php echo wp_get_attachment_image_url($image, $size); ?>">
				<div class="card__content">
					<canvas class="card__canvas"></canvas>
					<?php echo wp_get_attachment_image($image, $size) ?>
				</div>
			</div>

		<?php } else {
			echo wp_get_attachment_image($image, $size);
		} ?>


	<?php } else if ($type === 'video') {

		$provider = $custom ? $custom['provider'] : get_field('video_provider', $id);
		$video_id = $custom ? $custom['videoId'] : get_field('video_id', $id);
		$self_video = $custom ? $custom['videoUrl'] : get_field('self_video', $id);

		?>

			<div class="pe-video pe-<?php echo esc_attr($provider) ?>" data-controls=false data-autoplay=true data-muted=true
				data-loop=true>

			<?php if ($provider === 'self') { ?>

					<video class="p-video" autoplay muted loop playsinline>
						<source src="<?php echo esc_url($self_video['url']); ?>">
					</video>

			<?php } else { ?>

					<div class="p-video" data-plyr-provider="<?php echo esc_attr($provider) ?>"
						data-plyr-embed-id="<?php echo esc_attr($video_id) ?>"></div>


			<?php } ?>

			</div>

	<?php }

}

function sarenProductImageArchive($product, $cursor, $settings)
{
    ?>

        <div class="saren--product--image--wrap">

            <?php if ((get_field('product_video') === 'vimeo' || get_field('product_video') === 'youtube' || get_field('product_video') === 'self') && get_field('use_as_featured_media') == true) {
                $provider = get_field('product_video');
                $video_id = get_field('video_id');
                $self_video = get_field('self_hosted_video');
                ?>

                    <div class="saren--product--video">
                        <a <?php echo $cursor ?>
                            href="<?php echo apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product); ?>"
                            data-id="<?php echo get_the_id() ?>">

                            <div class="pe-video pe-<?php echo esc_attr($provider) ?>" data-controls=false data-autoplay=true
                                data-muted=true data-loop=true>

                                <?php if ($provider === 'self') { ?>
                                        <video class="p-video" autoplay muted loop playsinline>
                                            <source src="<?php echo esc_url($self_video['url']); ?>">
                                        </video>
                                <?php } else { ?>
                                        <div class="p-video" data-plyr-provider="<?php echo esc_attr($provider) ?>"
                                            data-plyr-embed-id="<?php echo esc_attr($video_id) ?>"></div>
                                <?php } ?>
                            </div>
                        </a>
                    </div>

                    <?php if ($settings['image_hover'] === 'yes' ) {
                
                            echo '<div class="product--image--hover"><img src="' . get_the_post_thumbnail_url() . '"></div>';
            } ?>

            <?php } else { ?>

                    <div class="saren--product--image product__image__<?php echo get_the_ID() ?>">

                        <a <?php echo $cursor ?> class="product--barba--trigger" data-id="<?php echo get_the_id() ?>"
                            href="<?php echo apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product); ?>">

                            <?php $attachment_ids = $product->get_gallery_image_ids();

                            if ($attachment_ids) { ?>

                                    <img class="product-image-front" src="<?php echo get_the_post_thumbnail_url(); ?>">

                            <?php } else { ?>
                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>">
                            <?php } ?>
                        </a>

                    </div>

                    <?php if ($settings['image_hover'] === 'yes' ) {
                $attachment_ids = $product->get_gallery_image_ids();
                if ($attachment_ids) {

                    foreach ($attachment_ids as $key => $attachment_id) {
                        if ($key == 0) {
                            echo '<div class="product--image--hover">' . wp_get_attachment_image($attachment_id, 'full') . '</div>';
                        }
                    }

                }
            } ?>

            <?php } ?>

            <div class="saren--product--actions" data-barba-prevent="all">

                <?php if ($settings['favorite'] === 'show') { ?>
                        <div class="saren--product-quick-action">
                            <?php
                            if (class_exists('YITH_WCWL') && $settings['favorite'] === 'show') {
                                echo do_shortcode('[yith_wcwl_add_to_wishlist]');
                            }
                            ?>
                        </div>

                <?php } ?>

                <?php if ($settings['compare'] === 'show') { ?>

                        <div class="saren--product-quick-action">
                            <?php
                            $svgPath = get_template_directory() . '/assets/img/compare.svg';
                            $icon = file_get_contents($svgPath);

                            echo '<span class="pe--compare--wrap" data-barba-prevent="all">
                                          <span class="compare--svg">' . $icon . '</span>
                                          '
                                . do_shortcode('[yith_compare_button]') . '
                                          </span>';
                            ?>
                        </div>

                <?php } ?>

                <?php
                if ($settings['behavior'] !== 'none') { ?>
                        <?php if ($product->is_type('variable')) { ?>
                                <div class="saren--product-quick-action">
             <button class="quick-add-to-cart-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
         
                            <?php
                            if ($settings['add-to-cart-style'] === 'wide') {

                                echo '<span class="quick--text">' . esc_html('Quick Shop' , 'pe-core') . '</span>';

                            } ?>
                                <span class="card-add-icon">
                                <?php
                                $svgPath = get_template_directory() . '/assets/img/cart-add.svg';
                                $icon = file_get_contents($svgPath);
                                echo $icon; ?>
                                </span>

                        <svg class="cart-loading" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960"
                            width="1em">
                            <path
                                d="M480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880q17 0 28.5 11.5T520-840q0 17-11.5 28.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-17 11.5-28.5T840-520q17 0 28.5 11.5T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80Z" />
                        </svg>
            </button>
                            </div>
                      <?php } else { ?>
                                <div class="saren--single--atc">
                                    <?php if ($settings['behavior'] === 'add-to-cart') {
                                        if ($product->is_type('simple')) {
                                            woocommerce_simple_add_to_cart();
                                        } elseif ($product->is_type('grouped')) {
                                            woocommerce_grouped_add_to_cart();
                                        } elseif ($product->is_type('external')) {
                                            woocommerce_external_add_to_cart();
                                        }
                                    } ?>

                                </div>
                        <?php }
                } ?>
            </div>

        </div>

<?php }

