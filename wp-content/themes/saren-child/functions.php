<?php
/**
 * Theme functions file
 */

/**
 * Enqueue parent theme styles first
 * Replaces previous method using @import
 * <http://codex.wordpress.org/Child_Themes>
 */

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style', 99 );

function enqueue_parent_theme_style() {
	wp_enqueue_style( 'saren-parent-style', get_template_directory_uri().'/style.css' );
}

// Make shipping phone field required at checkout
add_filter('woocommerce_shipping_fields', 'make_shipping_phone_required', 10, 1);
function make_shipping_phone_required($fields) {
    $fields['shipping_phone']['required'] = true;
    return $fields;
}

// 2 for 1 discount code
add_action('woocommerce_cart_calculate_fees', 'bogo_discount_cheapest_free');
function bogo_discount_cheapest_free() {
    if (is_admin() && !defined('DOING_AJAX')) return;
    
    // Only apply if the specific coupon is used
    if (!WC()->cart->has_discount('member2025')) return;
    
    // Prevent using both coupons at the same time
    if (WC()->cart->has_discount('christmas25')) {
        wc_add_notice('You cannot use both discount codes at the same time. Please remove one coupon.', 'error');
        WC()->cart->remove_coupon('christmas25');
        return;
    }
    
    $cart_items = WC()->cart->get_cart();
    $prices = array();
    
    // Collect prices only from products in "Kaffe" or "Coffee" categories
    foreach ($cart_items as $item) {
        $product = $item['data'];
        $product_id = $item['product_id'];
        
        // Handle variable products
        if ($product->is_type('variation')) {
            $product_id = $product->get_parent_id();
        }
        
        // Check if product belongs to "Kaffe" or "Coffee" category (use lowercase slugs)
        if (has_term(array('kaffe', 'coffee'), 'product_cat', $product_id)) {
            $price_excl_tax = wc_get_price_excluding_tax($product);
            $quantity = $item['quantity'];
            
            for ($i = 0; $i < $quantity; $i++) {
                $prices[] = $price_excl_tax;
            }
        }
    }
    
    // Only apply if there are at least 2 eligible items
    if (count($prices) < 2) return;
    
    // Sort prices ascending (cheapest first)
    sort($prices);
    
    // Calculate how many free items (1 free for every 2 purchased)
    $free_items = floor(count($prices) / 2);
    
    // Sum up the discount (cheapest items become free)
    $total_discount = 0;
    for ($i = 0; $i < $free_items; $i++) {
        $total_discount += $prices[$i];
    }
    
    if ($total_discount > 0) {
        // Add fee as taxable - WooCommerce will add VAT to match the product's tax
        WC()->cart->add_fee('Exclusive (Buy 1 Get 1 Free)', -$total_discount, true);
    }
}

// 25% discount code for Coffee/Kaffe categories
add_action('woocommerce_cart_calculate_fees', 'coffee_25_percent_discount');
function coffee_25_percent_discount() {
    if (is_admin() && !defined('DOING_AJAX')) return;
    
    // Only apply if the specific coupon is used
    if (!WC()->cart->has_discount('christmas25')) return;
    
    // Prevent using both coupons at the same time
    if (WC()->cart->has_discount('member2025')) {
        wc_add_notice('You cannot use both discount codes at the same time. Please remove one coupon.', 'error');
        WC()->cart->remove_coupon('member2025');
        return;
    }
    
    $cart_items = WC()->cart->get_cart();
    $total_eligible = 0;
    
    // Collect prices only from products in "Kaffe" or "Coffee" categories
    foreach ($cart_items as $item) {
        $product = $item['data'];
        $product_id = $item['product_id'];
        
        // Handle variable products
        if ($product->is_type('variation')) {
            $product_id = $product->get_parent_id();
        }
        
        // Check if product belongs to "Kaffe" or "Coffee" category (use lowercase slugs)
        if (has_term(array('kaffe', 'coffee'), 'product_cat', $product_id)) {
            $price_excl_tax = wc_get_price_excluding_tax($product);
            $quantity = $item['quantity'];
            
            $total_eligible += $price_excl_tax * $quantity;
        }
    }
    
    // Calculate 25% discount
    $discount_amount = $total_eligible * 0.25;
    
    if ($discount_amount > 0) {
        // Add fee as taxable - WooCommerce will add VAT to match the product's tax
        WC()->cart->add_fee('25% Christmas discount', -$discount_amount, true);
    }
}
/**
 * ------------------------------------------------------------------------
 * - Free shipping on subscription:
 * ------------------------------------------------------------------------
 */
// Feature 1: Free shipping for products with free_subscription shipping class
add_filter('woocommerce_package_rates', 'free_subscription_shipping', 999, 2);
function free_subscription_shipping($rates, $package) {
    $has_free_subscription = false;
    
    foreach ($package['contents'] as $item) {
        $product = $item['data'];
        $shipping_class = $product->get_shipping_class();
        
        if ($shipping_class === 'free-subscription' || $shipping_class === 'free_subscription') {
            $has_free_subscription = true;
            break;
        }
    }
    
    if ($has_free_subscription) {
        foreach ($rates as $rate_id => $rate) {
            // Shipmondo methods
            if (strpos($rate_id, 'shipmondo:') === 0) {
                $rates[$rate_id]->cost = 0;
                $rates[$rate_id]->taxes = array();
            }
            
            // Levering til adresse
            if ($rate_id === 'flat_rate:27') {
                $rates[$rate_id]->cost = 0;
                $rates[$rate_id]->taxes = array();
            }
        }
    }
    
    return $rates;
}

// Feature 2: Free shipping for orders above 320 kr (edited from 300)
add_filter('woocommerce_package_rates', 'free_shipping_above_300', 999, 2);
function free_shipping_above_300($rates, $package) {
    $cart_subtotal = 0;
    
    foreach ($package['contents'] as $item) {
        $cart_subtotal += $item['line_total'];
    }
    
    if ($cart_subtotal >= 320) {
        foreach ($rates as $rate_id => $rate) {
            // Shipmondo methods
            if (strpos($rate_id, 'shipmondo:') === 0) {
                $rates[$rate_id]->cost = 0;
                $rates[$rate_id]->taxes = array();
            }
            
            // Levering til adresse
            if ($rate_id === 'flat_rate:27') {
                $rates[$rate_id]->cost = 0;
                $rates[$rate_id]->taxes = array();
            }
        }
    }
    
    return $rates;
}
/**
 * Add a conditional message to the WooCommerce "Completed order" email.
 */
add_action( 'woocommerce_email_order_details', function( $order, $sent_to_admin, $plain_text, $email ) {

    // Only for customer emails, and only when the status is completed email.
    if ( $sent_to_admin ) return;
    if ( ! is_a( $email, 'WC_Email' ) || $email->id !== 'customer_completed_order' ) return;
    if ( ! is_a( $order, 'WC_Order' ) ) return;

    // Detect shipping method (handles multiple shipping items too)
    $has_shipmondo = false;
    foreach ( $order->get_items( 'shipping' ) as $shipping_item ) {
        $method_title = $shipping_item->get_name();         // e.g. "Shipmondo"
        $method_id    = $shipping_item->get_method_id();    // e.g. "shipmondo"

        if ( stripos( $method_title, 'shipmondo' ) !== false || stripos( $method_id, 'shipmondo' ) !== false ) {
            $has_shipmondo = true;
            break;
        }
    }

    // Message output
    if ( $plain_text ) {
        echo "\n";
        if ( $has_shipmondo ) {
            echo "Your package has been shipped with GLS and is on its way\n";
        } else {
            echo "If you purchased for pick up in the café, it is waiting for you. If you purchased giftcard, it has been delivered to the stated e-mail.\n";
        }
        echo "\n";
    } else {
        echo '<div style="margin: 12px 0 18px;">';
        if ( $has_shipmondo ) {
            echo '<p><strong>Your package has been shipped with GLS and is on its way</strong></p>';
        } else {
            echo '<p>If you purchased for pick up in the café, it is waiting for you.<br>If you purchased giftcard, it has been delivered to the stated e-mail.</p>';
        }
        echo '</div>';
    }

}, 5, 4 );

/**
 * ------------------------------------------------------------------------
 * - Breadcrumbs shortcode: [bredcrumb]
 * ------------------------------------------------------------------------
 */
function custom_breadcrumb() {
    if (is_front_page()) { return ''; } // no breadcrumb on homepage

    global $post;
    ob_start();

    echo '<nav class="breadcrumb" aria-label="Breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">';

    $position = 1; // start at 1 since we're skipping Home

    // Single posts
    if (is_single()) {
        // Category (first category only; adjust if you need hierarchy/primary-cat)
        $category = get_the_category();
        if ($category) {
            $cat_link = get_category_link($category[0]->term_id);
            echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a href="' . esc_url($cat_link) . '" itemprop="item"><span itemprop="name">' . esc_html($category[0]->name) . '</span></a>';
            echo '<meta itemprop="position" content="' . $position++ . '" />';
            echo '</span>';
        }

        // Current post (ACF override if present)
        $custom_label = function_exists('get_field') ? get_field('breadcrumb_label', $post->ID) : '';
        $title = $custom_label ?: get_the_title();
        echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html($title) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</span>';

    // Hierarchical pages
    } elseif (is_page() && !is_front_page()) {
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        foreach ($ancestors as $ancestor) {
            $ancestor_label = function_exists('get_field') ? get_field('breadcrumb_label', $ancestor) : '';
            $ancestor_title = $ancestor_label ?: get_the_title($ancestor);
            echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a href="' . esc_url(get_permalink($ancestor)) . '" itemprop="item"><span itemprop="name">' . esc_html($ancestor_title) . '</span></a>';
            echo '<meta itemprop="position" content="' . $position++ . '" />';
            echo '</span>';
        }

        $custom_label = function_exists('get_field') ? get_field('breadcrumb_label', $post->ID) : '';
        $title = $custom_label ?: get_the_title();
        echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html($title) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</span>';

    // Archives
    } elseif (is_archive()) {
        echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html(post_type_archive_title('', false)) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</span>';

    // Search
    } elseif (is_search()) {
        echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">Search results for: ' . esc_html(get_search_query()) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</span>';
    }

    echo '</nav>';

    return ob_get_clean();
}
add_shortcode('breadcrumb', 'custom_breadcrumb');

/**
 * Make the right-hand `.saren--coupon` apply coupons by creating & submitting
 * a real POST form to the cart with the correct WooCommerce nonce.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( function_exists( 'is_cart' ) && is_cart() ) {
		// Ensure jQuery is present (and give us the cart URL + a fresh nonce)
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'saren-coupon', false, array( 'jquery' ), null, true );
		wp_enqueue_script( 'saren-coupon' );

		wp_localize_script( 'saren-coupon', 'sarenCoupon', array(
			'actionUrl' => wc_get_cart_url(),                  // e.g. https://theartisan.dk/shop-cart/
			'nonce'     => wp_create_nonce( 'woocommerce-cart' ),
			'referer'   => wc_get_cart_url(),
		) );

		wp_add_inline_script( 'saren-coupon', "
			jQuery(function($){
				$(document).on('click', '.saren--coupon [name=\"apply_coupon\"]', function(e){
					e.preventDefault();

					// Read code from your right-hand field
					var code = ($('#saren_coupon_code').val() || '').trim();
					if (!code) return;

					// Build a tiny form that posts exactly what Woo expects
					var form = document.createElement('form');
					form.method = 'POST';
					form.action = sarenCoupon.actionUrl;

					function add(name, value){
						var i = document.createElement('input');
						i.type = 'hidden';
						i.name = name;
						i.value = value;
						form.appendChild(i);
					}

					add('coupon_code', code);
					add('apply_coupon', 'Apply coupon');

					// Prefer the existing nonce on the page (if present), else use our fresh one
					var pageNonce = document.querySelector('[name=\"woocommerce-cart-nonce\"]');
					add('woocommerce-cart-nonce', pageNonce ? pageNonce.value : sarenCoupon.nonce);

					// Referer helps some setups
					add('_wp_http_referer', sarenCoupon.referer);

					document.body.appendChild(form);
					form.submit();
				});
			});
		" );
	}
}, 20 );

/**
 * Custom color to checkout
 
add_action( 'init', function () {
	delete_transient( 'wc_stripe_appearance' );
	delete_transient( 'wc_stripe_blocks_appearance' );
});*/

/**
 * Stripe UPE (Woo Stripe / WooPayments) — Payment form appearance
 * Text: #191919, Placeholder: #8a8a8a
 */
/**
 * Stripe/WooPayments appearance — text #191919, placeholder #8a8a8a
 * Works with BOTH: WooPayments (WooPay) and WooCommerce Stripe Gateway (UPE).
 */
function saren_get_stripe_appearance_obj() {
	$appearance             = new stdClass();
	$appearance->variables  = (object) [
		'colorText'            => '#191919',
		'colorTextPlaceholder' => '#8a8a8a',
		'colorBackground'      => '#ffffff',
		'fontSizeBase'         => '16px',
		'fontFamily'           => 'system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif',
		'borderRadius'         => '12px',
	];
	$appearance->rules      = (object) [
		'.Input'               => (object) [ 'color' => '#191919' ],
		'.Input::placeholder'  => (object) [ 'color' => '#8a8a8a' ],
		'.Input:focus'         => (object) [ 'boxShadow' => '0 0 0 2px rgba(0,0,0,.08)' ],
		'.Input--invalid'      => (object) [ 'color' => '#191919', 'boxShadow' => '0 0 0 2px rgba(176,0,32,.25)' ],
		'.Error'               => (object) [ 'color' => '#b00020' ],
	];
	// Optional extras:
	$appearance->labels            = 'floating'; // 'above' or 'floating'
	$appearance->disableAnimations = false;

	return $appearance;
}

/** WooPayments (WooPay) — Stripe Payment Element appearance */
add_filter( 'wcpay_elements_appearance', function( $appearance ) {
	// Ensure object shape
	if ( ! is_object( $appearance ) ) { $appearance = new stdClass(); }
	if ( empty( $appearance->variables ) ) { $appearance->variables = new stdClass(); }
	if ( empty( $appearance->rules ) ) { $appearance->rules = new stdClass(); }

	$new = saren_get_stripe_appearance_obj();
	$appearance->variables = $new->variables;
	$appearance->rules     = $new->rules;
	// labels/disableAnimations supported by WCPay too:
	$appearance->labels            = $new->labels;
	$appearance->disableAnimations = $new->disableAnimations;

	return $appearance;
}, 50 );

/** WooCommerce Stripe Gateway (UPE) — applies to both shortcode and block checkout */
add_filter( 'wc_stripe_upe_params', function( $params ) {
	$appearance = saren_get_stripe_appearance_obj();
	$params['appearance']       = $appearance; // shortcode checkout
	$params['blocksAppearance'] = $appearance; // block checkout
	return $params;
}, 50 );

/**
 * Clear ALL relevant Stripe/WooPayments appearance transients ONCE,
 * so you immediately see changes without waiting for cache expiry.
 */
add_action( 'init', function () {
	if ( get_option( 'saren_stripe_appearance_flushed' ) ) {
		return;
	}
	// WooCommerce Stripe Gateway
	delete_transient( 'wc_stripe_appearance' );         // shortcode
	delete_transient( 'wc_stripe_blocks_appearance' );  // blocks

	// WooPayments (WooPay)
	delete_transient( 'wcpay_upe_appearance' );
	delete_transient( 'wcpay_wc_blocks_upe_appearance' );
	delete_transient( 'wcpay_upe_add_payment_method_appearance' );
	delete_transient( 'wcpay_upe_bnpl_product_page_appearance' );
	delete_transient( 'wcpay_upe_bnpl_classic_cart_appearance' );
	delete_transient( 'wcpay_upe_bnpl_cart_block_appearance' );

	// Mark flushed so it doesn’t run every request
	update_option( 'saren_stripe_appearance_flushed', 1 );
}, 1 );

/**
 * Language switcher function
 */
function get_language_switch_url() {
    if (!is_singular()) {
        // If not viewing a single post/page/product, fallback to homepage or other URL
        return home_url('/');
    }

    global $post;

    // Get current page URL path
    $current_url = home_url(add_query_arg(array(), $GLOBALS['wp']->request));
    $current_path = parse_url($current_url, PHP_URL_PATH);

    // Read ACF fields for translated URLs
    $translated_en_url = get_field('translated_en_url', $post->ID);
    $translated_da_url = get_field('translated_da_url', $post->ID);

    // Determine current language by URL prefix (adjust if needed)
    if (strpos($current_path, '/da/') === 0) {
        // On Danish page — switch to English if available
        if ($translated_en_url) {
            return esc_url($translated_en_url);
        } else {
            // Fallback English homepage or similar
            return home_url('/en/');
        }
    } elseif (strpos($current_path, '/en/') === 0) {
        // On English page — switch to Danish if available
        if ($translated_da_url) {
            return esc_url($translated_da_url);
        } else {
            // Fallback Danish homepage or similar
            return home_url('/da/');
        }
    } else {
        // If no language prefix in URL, fallback to default (Danish homepage)
        return home_url('/da/');
    }
}
/**
 * Shortcode to call the switcher in html
*/

function language_switcher_shortcode() {
    $post_id = get_the_ID();

    if (!$post_id) return '';

    $translated_en_url = get_field('translated_en_url', $post_id);
    $translated_da_url = get_field('translated_da_url', $post_id);

    if ($translated_en_url) {
        $url = $translated_en_url;
        $label = 'EN';
    } elseif ($translated_da_url) {
        $url = $translated_da_url;
        $label = 'DA';
    } else {
        return ''; // No translation set
    }

    return '<a href="' . esc_url($url) . '" class="pe--button pb--background pb--normal language-switcher">' . esc_html($label) . '</a>';

}
add_shortcode('language_switcher', 'language_switcher_shortcode');

/**
 * Add custom hreflang tags for pages, posts, and CPTs
 */
function add_custom_hreflang_tags() {
    if ( ! is_singular() ) return;

    // Be defensive when resolving the current singular object
    global $wp_query;
    $obj = is_object( $wp_query ) ? $wp_query->get_queried_object() : null;
    $post_id = ( $obj && ! empty( $obj->ID ) ) ? intval( $obj->ID ) : 0;
    if ( ! $post_id ) {
        // Last-resort fallback
        $maybe_id = get_the_ID();
        if ( $maybe_id ) $post_id = intval( $maybe_id );
    }
    if ( ! $post_id ) {
        echo "\n<!-- hreflang: no post_id in wp_head -->\n";
        return;
    }

    $current_url = get_permalink( $post_id );
    if ( ! $current_url ) {
        echo "\n<!-- hreflang: no current_url -->\n";
        return;
    }

    // Optional ACF fields
    $translated_en_url = function_exists('get_field') ? get_field('translated_en_url', $post_id) : '';
    $translated_da_url = function_exists('get_field') ? get_field('translated_da_url', $post_id) : '';

    $links = [];

    // Detect language by full URL
    $is_en = ( strpos( $current_url, home_url('/en/') ) === 0 );
    $is_da = ( strpos( $current_url, home_url('/da/') ) === 0 );

    // Danish (use da-DK if you target Denmark specifically)
    if ( $translated_da_url ) {
        $links['da-DK'] = $translated_da_url;
    } elseif ( $is_da ) {
        $links['da-DK'] = $current_url; // self
    }

    // English
    if ( $translated_en_url ) {
        $links['en'] = $translated_en_url;
    } elseif ( $is_en ) {
        $links['en'] = $current_url; // self
    }

    echo "\n<!-- hreflang: ran; langs=" . esc_html( implode(',', array_keys($links)) ) . " -->\n";

    if ( empty( $links ) ) return;

    foreach ( $links as $lang => $href ) {
        echo '<link rel="alternate" hreflang="' . esc_attr($lang) . '" href="' . esc_url($href) . "\" />\n";
    }

    // Optional x-default (e.g., choose your primary entry)
    // echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( home_url('/') ) . "\" />\n";
}
add_action('wp_head', 'add_custom_hreflang_tags', 99);

/**
 * Menu language swap
 */
add_filter('wp_nav_menu_args', function($args) {
    $url_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $lang = (strpos($url_path, 'en') === 0) ? 'en' : 'da';

    $args['menu'] = ($lang === 'en') ? 360 : 147;
    return $args;
});



/**
 * ------------------------------------------------------------------------
 * - Adds responsive labels, sorting, and search to tables with [data-table]
 * ------------------------------------------------------------------------
 */
add_action('wp_footer', function () {
  if (is_admin()) return; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // For each table marked with data-table
  document.querySelectorAll('table[data-table]').forEach(function(table){
    if (!table.tBodies.length) return;

    // Optional: auto add data-labels for mobile stacked layout
    var ths = (table.tHead && table.tHead.rows[0]) ? Array.from(table.tHead.rows[0].cells) : [];
    if (ths.length) {
      Array.from(table.tBodies[0].rows).forEach(function(tr){
        Array.from(tr.cells).forEach(function(td, i){
          if (!td.hasAttribute('data-label') && ths[i]) {
            td.setAttribute('data-label', ths[i].textContent.trim());
          }
        });
      });
    }

    // Find the closest search input in the same content block
    // Supports either .table-tools input[type="search"] or #tableSearch
    var scope = table.closest('section, .content, article, main') || document;
    var input = scope.querySelector('.table-tools input[type="search"], #tableSearch');
    if (!input) return;

    // Live filter rows on input
    var rows = Array.from(table.tBodies[0].rows);
    input.addEventListener('input', function(){
      var q = this.value.trim().toLowerCase();
      rows.forEach(function(tr){
        var txt = tr.textContent.toLowerCase();
        tr.style.display = txt.indexOf(q) !== -1 ? '' : 'none';
      });
    }, { passive: true });
  });
});
</script>
<?php
}, 99);