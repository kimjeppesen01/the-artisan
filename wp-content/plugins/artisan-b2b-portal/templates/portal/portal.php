<?php
/**
 * Main Portal Template (Tabbed Interface)
 */
if (!defined('ABSPATH')) exit;
?>

<div class="ab2b-portal" id="ab2b-portal" data-access-key="<?php echo esc_attr($customer->access_key); ?>">

    <div class="ab2b-portal-header">
        <div class="ab2b-portal-welcome">
            <h2><?php printf(esc_html__('Welcome, %s', 'artisan-b2b-portal'), esc_html($customer->company_name)); ?></h2>
            <p class="ab2b-portal-subtitle"><?php esc_html_e('Place orders and track your deliveries', 'artisan-b2b-portal'); ?></p>
        </div>
        <div class="ab2b-cart-indicator" id="ab2b-cart-indicator">
            <span class="ab2b-cart-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="24" height="24">
                    <path d="M292.31-115.38q-25.31 0-42.66-17.35-17.34-17.35-17.34-42.65 0-25.31 17.34-42.66 17.35-17.34 42.66-17.34 25.31 0 42.65 17.34 17.35 17.35 17.35 42.66 0 25.3-17.35 42.65-17.34 17.35-42.65 17.35Zm375.38 0q-25.31 0-42.65-17.35-17.35-17.35-17.35-42.65 0-25.31 17.35-42.66 17.34-17.34 42.65-17.34t42.66 17.34q17.34 17.35 17.34 42.66 0 25.3-17.34 42.65-17.35 17.35-42.66 17.35ZM80-820v-40h97.92l163.85 344.62h265.38q6.93 0 12.31-3.47 5.39-3.46 9.23-9.61L768.54-780h45.61L662.77-506.62q-8.69 14.62-22.61 22.93t-30.47 8.31H324l-48.62 89.23q-6.15 9.23-.38 20 5.77 10.77 17.31 10.77h435.38v40H292.31q-35 0-52.35-29.39-17.34-29.38-.73-59.38l60.15-107.23L152.31-820H80Z"/>
                </svg>
            </span>
            <span class="ab2b-cart-count">0</span>
        </div>
    </div>

    <div class="ab2b-portal-tabs">
        <button class="ab2b-tab active" data-tab="shop">
            <span class="ab2b-tab-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20" height="20">
                    <path d="M226.15-80q-27.15 0-46.65-19.5Q160-119 160-146.15v-427.7q0-27.15 19.5-46.65Q199-640 226.15-640H320v-10.77q0-66.92 46.54-113.46T480-810.77q67.15 0 113.58 46.54Q640-717.69 640-650.77V-640h93.85q27.15 0 46.65 19.5Q800-601 800-573.85v427.7q0 27.15-19.5 46.65Q761-80 733.85-80H226.15Zm0-40h507.7q9.23 0 16.92-7.69 7.69-7.69 7.69-16.93v-427.69q0-9.23-7.69-16.92-7.69-7.69-16.92-7.69H640v130.77h-40v-130.77H360v130.77h-40v-130.77H226.15q-9.23 0-16.92 7.69-7.69 7.69-7.69 16.92v427.69q0 9.24 7.69 16.93 7.69 7.69 16.92 7.69ZM360-640h240v-10.77q0-50-35-85t-85-35q-50 0-85 35t-35 85V-640ZM201.54-120v-480 480Z"/>
                </svg>
            </span>
            <?php esc_html_e('Shop', 'artisan-b2b-portal'); ?>
        </button>
        <button class="ab2b-tab" data-tab="cart">
            <span class="ab2b-tab-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20" height="20">
                    <path d="M292.31-115.38q-25.31 0-42.66-17.35-17.34-17.35-17.34-42.65 0-25.31 17.34-42.66 17.35-17.34 42.66-17.34 25.31 0 42.65 17.34 17.35 17.35 17.35 42.66 0 25.3-17.35 42.65-17.34 17.35-42.65 17.35Zm375.38 0q-25.31 0-42.65-17.35-17.35-17.35-17.35-42.65 0-25.31 17.35-42.66 17.34-17.34 42.65-17.34t42.66 17.34q17.34 17.35 17.34 42.66 0 25.3-17.34 42.65-17.35 17.35-42.66 17.35ZM80-820v-40h97.92l163.85 344.62h265.38q6.93 0 12.31-3.47 5.39-3.46 9.23-9.61L768.54-780h45.61L662.77-506.62q-8.69 14.62-22.61 22.93t-30.47 8.31H324l-48.62 89.23q-6.15 9.23-.38 20 5.77 10.77 17.31 10.77h435.38v40H292.31q-35 0-52.35-29.39-17.34-29.38-.73-59.38l60.15-107.23L152.31-820H80Z"/>
                </svg>
            </span>
            <?php esc_html_e('Cart', 'artisan-b2b-portal'); ?>
            <span class="ab2b-tab-badge" id="cart-tab-count" style="display:none;">0</span>
        </button>
        <button class="ab2b-tab" data-tab="orders">
            <span class="ab2b-tab-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20" height="20">
                    <path d="M200-120v-680h360l16 80h184v400H590l-16-80H240v280h-40Zm300-440Zm86 160h134v-280H546l-16-80H240v280h330l16 80Z"/>
                </svg>
            </span>
            <?php esc_html_e('Orders', 'artisan-b2b-portal'); ?>
        </button>
    </div>

    <div class="ab2b-portal-content">
        <!-- Shop Tab -->
        <div class="ab2b-tab-content active" id="tab-shop">
            <!-- Shop Controls Bar (category filters + grid/list toggle) -->
            <div class="ab2b-shop-controls" id="ab2b-shop-controls" style="display: none;">
                <div class="ab2b-category-filters" id="ab2b-category-filters">
                    <!-- Filled by JS -->
                </div>
                <div class="ab2b-view-toggle">
                    <button type="button" class="ab2b-view-btn active" data-view="grid" title="<?php esc_attr_e('Grid view', 'artisan-b2b-portal'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20" height="20"><path d="M120-520v-320h320v320H120Zm0 400v-320h320v320H120Zm400-400v-320h320v320H520Zm0 400v-320h320v320H520ZM200-600h160v-160H200v160Zm400 0h160v-160H600v160Zm0 400h160v-160H600v160ZM200-200h160v-160H200v160Zm400-400Zm0 240Zm-240 0Zm0-240Z"/></svg>
                    </button>
                    <button type="button" class="ab2b-view-btn" data-view="list" title="<?php esc_attr_e('List view', 'artisan-b2b-portal'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20" height="20"><path d="M280-600v-80h560v80H280Zm0 160v-80h560v80H280Zm0 160v-80h560v80H280ZM160-600q-17 0-28.5-11.5T120-640q0-17 11.5-28.5T160-680q17 0 28.5 11.5T200-640q0 17-11.5 28.5T160-600Zm0 160q-17 0-28.5-11.5T120-480q0-17 11.5-28.5T160-520q17 0 28.5 11.5T200-480q0 17-11.5 28.5T160-440Zm0 160q-17 0-28.5-11.5T120-320q0-17 11.5-28.5T160-360q17 0 28.5 11.5T200-320q0 17-11.5 28.5T160-280Z"/></svg>
                    </button>
                </div>
            </div>
            <div class="ab2b-products-grid" id="ab2b-products">
                <div class="ab2b-loading">
                    <span class="ab2b-spinner"></span>
                    <?php esc_html_e('Loading products...', 'artisan-b2b-portal'); ?>
                </div>
            </div>
        </div>

        <!-- Cart Tab -->
        <div class="ab2b-tab-content" id="tab-cart">
            <div class="ab2b-cart" id="ab2b-cart">
                <div class="ab2b-cart-empty">
                    <span class="ab2b-empty-icon">🛒</span>
                    <p><?php esc_html_e('Your cart is empty.', 'artisan-b2b-portal'); ?></p>
                    <button type="button" class="ab2b-btn ab2b-btn-primary" data-tab="shop">
                        <?php esc_html_e('Start Shopping', 'artisan-b2b-portal'); ?>
                    </button>
                </div>
            </div>
        </div>

        <!-- Orders Tab -->
        <div class="ab2b-tab-content" id="tab-orders">
            <div class="ab2b-orders" id="ab2b-orders">
                <div class="ab2b-loading">
                    <span class="ab2b-spinner"></span>
                    <?php esc_html_e('Loading orders...', 'artisan-b2b-portal'); ?>
                </div>
            </div>
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
