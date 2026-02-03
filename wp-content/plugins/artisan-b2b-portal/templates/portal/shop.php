<?php
/**
 * Shop Template (Standalone)
 */
if (!defined('ABSPATH')) exit;
?>

<div class="ab2b-portal ab2b-shop-only" id="ab2b-portal" data-access-key="<?php echo esc_attr($customer->access_key); ?>">
    <div class="ab2b-products-grid" id="ab2b-products">
        <div class="ab2b-loading">
            <span class="ab2b-spinner"></span>
            <?php esc_html_e('Loading products...', 'artisan-b2b-portal'); ?>
        </div>
    </div>

    <!-- Quick Add Modal -->
    <div class="ab2b-modal" id="ab2b-quick-add-modal">
        <div class="ab2b-modal-overlay"></div>
        <div class="ab2b-modal-content">
            <button type="button" class="ab2b-modal-close">&times;</button>
            <div class="ab2b-modal-body" id="ab2b-modal-body">
                <!-- Filled by JS -->
            </div>
        </div>
    </div>
</div>
