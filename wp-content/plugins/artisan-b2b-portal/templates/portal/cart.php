<?php
/**
 * Cart Template (Standalone)
 */
if (!defined('ABSPATH')) exit;
?>

<div class="ab2b-portal ab2b-cart-only" id="ab2b-portal" data-access-key="<?php echo esc_attr($customer->access_key); ?>">
    <div class="ab2b-cart" id="ab2b-cart">
        <div class="ab2b-cart-empty">
            <span class="ab2b-empty-icon">🛒</span>
            <p><?php esc_html_e('Your cart is empty.', 'artisan-b2b-portal'); ?></p>
        </div>
    </div>
</div>
