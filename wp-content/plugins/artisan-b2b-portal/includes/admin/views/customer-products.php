<?php
/**
 * Customer Products Management View
 * Manage which products are assigned to which customers
 */
if (!defined('ABSPATH')) exit;

require_once AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-customer-pricing.php';

// Get all active customers and products
$customers = AB2B_Customer::get_all(['is_active' => 1]);
$products = AB2B_Product::get_all(['is_active' => 1]);

// Get current filter
$filter_customer = isset($_GET['customer_id']) ? (int) $_GET['customer_id'] : 0;
$filter_product = isset($_GET['product_id']) ? (int) $_GET['product_id'] : 0;

// Get all customer product assignments
$all_assignments = [];
foreach ($customers as $customer) {
    $customer_products = AB2B_Customer_Pricing::get_customer_products($customer->id);
    foreach ($customer_products as $cp) {
        $all_assignments[] = [
            'customer_id' => $customer->id,
            'customer_name' => $customer->company_name,
            'product_id' => $cp->product_id,
            'custom_name' => $cp->custom_name,
            'is_exclusive' => $cp->is_exclusive,
        ];
    }
}

// Filter assignments if needed
if ($filter_customer > 0) {
    $all_assignments = array_filter($all_assignments, function($a) use ($filter_customer) {
        return $a['customer_id'] == $filter_customer;
    });
}
if ($filter_product > 0) {
    $all_assignments = array_filter($all_assignments, function($a) use ($filter_product) {
        return $a['product_id'] == $filter_product;
    });
}

// Index products by ID for lookup
$products_by_id = [];
foreach ($products as $product) {
    $products_by_id[$product->id] = $product;
}
?>

<div class="wrap ab2b-admin-wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e('Customer Products', 'artisan-b2b-portal'); ?></h1>
    <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customer-products&action=add')); ?>" class="page-title-action">
        <?php esc_html_e('Assign Product to Customer', 'artisan-b2b-portal'); ?>
    </a>
    <hr class="wp-header-end">

    <p class="description">
        <?php esc_html_e('Manage unique product assignments for each customer. Exclusive products are only visible to the assigned customer.', 'artisan-b2b-portal'); ?>
    </p>

    <!-- Filters -->
    <div class="ab2b-filters" style="margin: 20px 0; padding: 15px; background: #fff; border: 1px solid #ccd0d4; border-radius: 4px;">
        <form method="get" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <input type="hidden" name="page" value="ab2b-customer-products">

            <div>
                <label for="customer_id" style="display: block; margin-bottom: 5px; font-weight: 500;">
                    <?php esc_html_e('Filter by Customer', 'artisan-b2b-portal'); ?>
                </label>
                <select name="customer_id" id="customer_id" style="min-width: 200px;">
                    <option value=""><?php esc_html_e('All Customers', 'artisan-b2b-portal'); ?></option>
                    <?php foreach ($customers as $customer) : ?>
                        <option value="<?php echo esc_attr($customer->id); ?>" <?php selected($filter_customer, $customer->id); ?>>
                            <?php echo esc_html($customer->company_name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="product_id" style="display: block; margin-bottom: 5px; font-weight: 500;">
                    <?php esc_html_e('Filter by Product', 'artisan-b2b-portal'); ?>
                </label>
                <select name="product_id" id="product_id" style="min-width: 200px;">
                    <option value=""><?php esc_html_e('All Products', 'artisan-b2b-portal'); ?></option>
                    <?php foreach ($products as $product) : ?>
                        <option value="<?php echo esc_attr($product->id); ?>" <?php selected($filter_product, $product->id); ?>>
                            <?php echo esc_html($product->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <button type="submit" class="button"><?php esc_html_e('Filter', 'artisan-b2b-portal'); ?></button>
                <?php if ($filter_customer || $filter_product) : ?>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customer-products')); ?>" class="button">
                        <?php esc_html_e('Clear', 'artisan-b2b-portal'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Assignments Table -->
    <?php if (empty($all_assignments)) : ?>
        <div class="ab2b-empty-state" style="text-align: center; padding: 40px; background: #fff; border: 1px solid #ccd0d4; border-radius: 4px;">
            <span style="font-size: 48px;">📦</span>
            <h3><?php esc_html_e('No customer product assignments found', 'artisan-b2b-portal'); ?></h3>
            <p><?php esc_html_e('Start by assigning products to specific customers.', 'artisan-b2b-portal'); ?></p>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customer-products&action=add')); ?>" class="button button-primary">
                <?php esc_html_e('Assign Product', 'artisan-b2b-portal'); ?>
            </a>
        </div>
    <?php else : ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th class="column-customer"><?php esc_html_e('Customer', 'artisan-b2b-portal'); ?></th>
                    <th class="column-product"><?php esc_html_e('Product', 'artisan-b2b-portal'); ?></th>
                    <th class="column-custom-name"><?php esc_html_e('Custom Name', 'artisan-b2b-portal'); ?></th>
                    <th class="column-exclusive"><?php esc_html_e('Exclusive', 'artisan-b2b-portal'); ?></th>
                    <th class="column-actions" style="width: 150px;"><?php esc_html_e('Actions', 'artisan-b2b-portal'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_assignments as $assignment) :
                    $product = isset($products_by_id[$assignment['product_id']]) ? $products_by_id[$assignment['product_id']] : null;
                    if (!$product) continue;
                ?>
                    <tr>
                        <td>
                            <strong>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers&action=edit&id=' . $assignment['customer_id'])); ?>">
                                    <?php echo esc_html($assignment['customer_name']); ?>
                                </a>
                            </strong>
                        </td>
                        <td>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-products&action=edit&id=' . $assignment['product_id'])); ?>">
                                <?php echo esc_html($product->name); ?>
                            </a>
                        </td>
                        <td>
                            <?php if (!empty($assignment['custom_name'])) : ?>
                                <span class="ab2b-custom-name"><?php echo esc_html($assignment['custom_name']); ?></span>
                            <?php else : ?>
                                <span class="description">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($assignment['is_exclusive']) : ?>
                                <span class="ab2b-badge ab2b-badge-exclusive" style="background: #6f42c1; color: #fff; padding: 3px 8px; border-radius: 3px; font-size: 11px; font-weight: 600;">
                                    <?php esc_html_e('Exclusive', 'artisan-b2b-portal'); ?>
                                </span>
                            <?php else : ?>
                                <span class="description"><?php esc_html_e('No', 'artisan-b2b-portal'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers&action=edit&id=' . $assignment['customer_id'])); ?>" class="button button-small">
                                <?php esc_html_e('Edit', 'artisan-b2b-portal'); ?>
                            </a>
                            <button type="button" class="button button-small button-link-delete ab2b-remove-assignment"
                                    data-customer-id="<?php echo esc_attr($assignment['customer_id']); ?>"
                                    data-product-id="<?php echo esc_attr($assignment['product_id']); ?>">
                                <?php esc_html_e('Remove', 'artisan-b2b-portal'); ?>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Quick Add Modal -->
    <div id="ab2b-add-assignment-modal" style="display: none;">
        <div class="ab2b-modal-backdrop" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9998;"></div>
        <div class="ab2b-modal-content" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 30px; border-radius: 8px; z-index: 9999; width: 100%; max-width: 500px; box-shadow: 0 5px 30px rgba(0,0,0,0.3);">
            <h2 style="margin-top: 0;"><?php esc_html_e('Assign Product to Customer', 'artisan-b2b-portal'); ?></h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('ab2b_admin_action', 'ab2b_nonce'); ?>
                <input type="hidden" name="ab2b_action" value="assign_customer_product">

                <p>
                    <label for="modal_customer_id" style="display: block; margin-bottom: 5px; font-weight: 500;">
                        <?php esc_html_e('Customer', 'artisan-b2b-portal'); ?> *
                    </label>
                    <select name="customer_id" id="modal_customer_id" required style="width: 100%;">
                        <option value=""><?php esc_html_e('Select Customer...', 'artisan-b2b-portal'); ?></option>
                        <?php foreach ($customers as $customer) : ?>
                            <option value="<?php echo esc_attr($customer->id); ?>">
                                <?php echo esc_html($customer->company_name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>

                <p>
                    <label for="modal_product_id" style="display: block; margin-bottom: 5px; font-weight: 500;">
                        <?php esc_html_e('Product', 'artisan-b2b-portal'); ?> *
                    </label>
                    <select name="product_id" id="modal_product_id" required style="width: 100%;">
                        <option value=""><?php esc_html_e('Select Product...', 'artisan-b2b-portal'); ?></option>
                        <?php foreach ($products as $product) : ?>
                            <option value="<?php echo esc_attr($product->id); ?>">
                                <?php echo esc_html($product->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>

                <p>
                    <label for="modal_custom_name" style="display: block; margin-bottom: 5px; font-weight: 500;">
                        <?php esc_html_e('Custom Product Name (Optional)', 'artisan-b2b-portal'); ?>
                    </label>
                    <input type="text" name="custom_name" id="modal_custom_name" style="width: 100%;"
                           placeholder="<?php esc_attr_e('Leave blank to use default product name', 'artisan-b2b-portal'); ?>">
                </p>

                <p>
                    <label style="display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="is_exclusive" value="1">
                        <span><?php esc_html_e('Exclusive (only this customer can see this product)', 'artisan-b2b-portal'); ?></span>
                    </label>
                </p>

                <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="button ab2b-close-modal"><?php esc_html_e('Cancel', 'artisan-b2b-portal'); ?></button>
                    <button type="submit" class="button button-primary"><?php esc_html_e('Assign Product', 'artisan-b2b-portal'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Show modal when clicking "Assign Product to Customer"
    $('a[href*="action=add"]').on('click', function(e) {
        e.preventDefault();
        $('#ab2b-add-assignment-modal').show();
    });

    // Close modal
    $('.ab2b-close-modal, .ab2b-modal-backdrop').on('click', function() {
        $('#ab2b-add-assignment-modal').hide();
    });

    // Remove assignment
    $('.ab2b-remove-assignment').on('click', function() {
        if (!confirm('<?php esc_html_e('Remove this product assignment?', 'artisan-b2b-portal'); ?>')) {
            return;
        }

        var $btn = $(this);
        var customerId = $btn.data('customer-id');
        var productId = $btn.data('product-id');

        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
                action: 'ab2b_remove_customer_product',
                nonce: '<?php echo wp_create_nonce('ab2b_admin_nonce'); ?>',
                customer_id: customerId,
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    $btn.closest('tr').fadeOut(function() {
                        $(this).remove();
                    });
                } else {
                    alert(response.data.message || 'Error removing assignment');
                }
            },
            error: function() {
                alert('Error removing assignment');
            }
        });
    });
});
</script>
