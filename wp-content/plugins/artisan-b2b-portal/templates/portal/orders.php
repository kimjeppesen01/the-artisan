<?php
/**
 * Orders Template (Standalone)
 */
if (!defined('ABSPATH')) exit;
?>

<div class="ab2b-portal ab2b-orders-only" id="ab2b-portal" data-access-key="<?php echo esc_attr($customer->access_key); ?>">
    <div class="ab2b-orders" id="ab2b-orders">
        <div class="ab2b-loading">
            <span class="ab2b-spinner"></span>
            <?php esc_html_e('Loading orders...', 'artisan-b2b-portal'); ?>
        </div>
    </div>

    <!-- Order Detail Modal -->
    <div class="ab2b-modal" id="ab2b-order-modal">
        <div class="ab2b-modal-overlay"></div>
        <div class="ab2b-modal-content ab2b-modal-wide">
            <button type="button" class="ab2b-modal-close">&times;</button>
            <div class="ab2b-modal-body" id="ab2b-order-modal-body">
                <!-- Filled by JS -->
            </div>
        </div>
    </div>
</div>
