<?php
/**
 * Order View Page
 */
if (!defined('ABSPATH')) exit;
?>

<div class="wrap ab2b-admin-wrap">
    <h1>
        <?php printf(esc_html__('Order %s', 'artisan-b2b-portal'), esc_html($order->order_number)); ?>
        <span class="ab2b-status <?php echo esc_attr(AB2B_Helpers::get_status_class($order->status)); ?>">
            <?php echo esc_html(AB2B_Helpers::get_status_label($order->status)); ?>
        </span>
    </h1>

    <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders')); ?>" class="page-title-action">
        &larr; <?php esc_html_e('Back to Orders', 'artisan-b2b-portal'); ?>
    </a>

    <div class="ab2b-order-view">
        <div class="ab2b-order-columns">
            <div class="ab2b-order-main">
                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Order Items', 'artisan-b2b-portal'); ?></h2>

                    <table class="wp-list-table widefat fixed striped" id="order-items-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Product', 'artisan-b2b-portal'); ?></th>
                                <th><?php esc_html_e('Weight', 'artisan-b2b-portal'); ?></th>
                                <th class="column-quantity"><?php esc_html_e('Qty', 'artisan-b2b-portal'); ?></th>
                                <th class="column-price"><?php esc_html_e('Unit Price', 'artisan-b2b-portal'); ?></th>
                                <th class="column-total"><?php esc_html_e('Total', 'artisan-b2b-portal'); ?></th>
                                <th class="column-actions" style="width: 100px;"><?php esc_html_e('Actions', 'artisan-b2b-portal'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order->items as $item) : ?>
                                <tr data-item-id="<?php echo esc_attr($item->id); ?>">
                                    <td class="item-product-name">
                                        <strong><?php echo esc_html($item->product_name); ?></strong>
                                    </td>
                                    <td class="item-weight-label"><?php echo esc_html($item->weight_label); ?></td>
                                    <td class="column-quantity item-quantity"><?php echo esc_html($item->quantity); ?></td>
                                    <td class="column-price item-unit-price"><?php echo esc_html(AB2B_Helpers::format_price($item->unit_price)); ?></td>
                                    <td class="column-total item-line-total"><?php echo esc_html(AB2B_Helpers::format_price($item->line_total)); ?></td>
                                    <td class="column-actions">
                                        <button type="button" class="button button-small ab2b-edit-order-item"
                                                data-item-id="<?php echo esc_attr($item->id); ?>"
                                                data-product-name="<?php echo esc_attr($item->product_name); ?>"
                                                data-weight-label="<?php echo esc_attr($item->weight_label); ?>"
                                                data-quantity="<?php echo esc_attr($item->quantity); ?>"
                                                data-unit-price="<?php echo esc_attr($item->unit_price); ?>">
                                            <?php esc_html_e('Edit', 'artisan-b2b-portal'); ?>
                                        </button>
                                        <button type="button" class="button button-small button-link-delete ab2b-delete-order-item"
                                                data-item-id="<?php echo esc_attr($item->id); ?>">
                                            <?php esc_html_e('Delete', 'artisan-b2b-portal'); ?>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <?php
                            $shipping_cost = isset($order->shipping_cost) ? (float) $order->shipping_cost : 0;
                            $delivery_method = isset($order->delivery_method) ? $order->delivery_method : 'shipping';
                            ?>
                            <?php if ($shipping_cost > 0) : ?>
                                <tr>
                                    <td colspan="5" class="ab2b-order-total-label"><?php esc_html_e('Subtotal', 'artisan-b2b-portal'); ?></td>
                                    <td><?php echo esc_html(AB2B_Helpers::format_price($order->subtotal)); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="ab2b-order-total-label"><?php esc_html_e('Shipping', 'artisan-b2b-portal'); ?></td>
                                    <td><?php echo esc_html(AB2B_Helpers::format_price($shipping_cost)); ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="5" class="ab2b-order-total-label"><?php esc_html_e('Total', 'artisan-b2b-portal'); ?></td>
                                <td class="ab2b-order-total-value"><strong id="order-total-display"><?php echo esc_html(AB2B_Helpers::format_price($order->total)); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <?php if (!empty($order->special_instructions)) : ?>
                    <div class="ab2b-form-card">
                        <h2><?php esc_html_e('Special Instructions', 'artisan-b2b-portal'); ?></h2>
                        <p><?php echo nl2br(esc_html($order->special_instructions)); ?></p>
                    </div>
                <?php endif; ?>

                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Admin Notes', 'artisan-b2b-portal'); ?></h2>
                    <form id="admin-notes-form">
                        <textarea id="admin-notes" rows="3" class="large-text"><?php echo esc_textarea($order->admin_notes); ?></textarea>
                        <p>
                            <button type="button" class="button ab2b-save-notes" data-order-id="<?php echo esc_attr($order->id); ?>">
                                <?php esc_html_e('Save Notes', 'artisan-b2b-portal'); ?>
                            </button>
                            <span class="ab2b-notes-saved" style="display:none; color: green; margin-left: 10px;">
                                <?php esc_html_e('Saved!', 'artisan-b2b-portal'); ?>
                            </span>
                        </p>
                    </form>
                </div>
            </div>

            <div class="ab2b-order-sidebar">
                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Order Details', 'artisan-b2b-portal'); ?></h2>
                    <ul class="ab2b-meta-list">
                        <li>
                            <span class="ab2b-meta-label"><?php esc_html_e('Order Number', 'artisan-b2b-portal'); ?></span>
                            <span class="ab2b-meta-value"><?php echo esc_html($order->order_number); ?></span>
                        </li>
                        <li>
                            <span class="ab2b-meta-label"><?php esc_html_e('Created', 'artisan-b2b-portal'); ?></span>
                            <span class="ab2b-meta-value"><?php echo esc_html(date_i18n('M j, Y H:i', strtotime($order->created_at))); ?></span>
                        </li>
                        <li>
                            <span class="ab2b-meta-label"><?php esc_html_e('Delivery Date', 'artisan-b2b-portal'); ?></span>
                            <span class="ab2b-meta-value"><strong><?php echo esc_html(date_i18n('l, M j, Y', strtotime($order->delivery_date))); ?></strong></span>
                        </li>
                        <li>
                            <span class="ab2b-meta-label"><?php esc_html_e('Delivery Method', 'artisan-b2b-portal'); ?></span>
                            <span class="ab2b-meta-value">
                                <?php
                                $method = isset($order->delivery_method) ? $order->delivery_method : 'shipping';
                                echo $method === 'pickup'
                                    ? esc_html__('Pick up', 'artisan-b2b-portal')
                                    : esc_html__('Shipping', 'artisan-b2b-portal');
                                ?>
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Customer', 'artisan-b2b-portal'); ?></h2>
                    <?php if ($order->customer) : ?>
                        <ul class="ab2b-meta-list">
                            <li>
                                <span class="ab2b-meta-label"><?php esc_html_e('Company', 'artisan-b2b-portal'); ?></span>
                                <span class="ab2b-meta-value">
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers&action=edit&id=' . $order->customer->id)); ?>">
                                        <?php echo esc_html($order->customer->company_name); ?>
                                    </a>
                                </span>
                            </li>
                            <li>
                                <span class="ab2b-meta-label"><?php esc_html_e('Contact', 'artisan-b2b-portal'); ?></span>
                                <span class="ab2b-meta-value"><?php echo esc_html($order->customer->contact_name); ?></span>
                            </li>
                            <li>
                                <span class="ab2b-meta-label"><?php esc_html_e('Email', 'artisan-b2b-portal'); ?></span>
                                <span class="ab2b-meta-value">
                                    <a href="mailto:<?php echo esc_attr($order->customer->email); ?>">
                                        <?php echo esc_html($order->customer->email); ?>
                                    </a>
                                </span>
                            </li>
                            <?php if ($order->customer->phone) : ?>
                                <li>
                                    <span class="ab2b-meta-label"><?php esc_html_e('Phone', 'artisan-b2b-portal'); ?></span>
                                    <span class="ab2b-meta-value"><?php echo esc_html($order->customer->phone); ?></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Update Status', 'artisan-b2b-portal'); ?></h2>
                    <div class="ab2b-status-update">
                        <select id="order-status" class="regular-text">
                            <option value="pending" <?php selected($order->status, 'pending'); ?>><?php esc_html_e('Pending', 'artisan-b2b-portal'); ?></option>
                            <option value="confirmed" <?php selected($order->status, 'confirmed'); ?>><?php esc_html_e('Confirmed', 'artisan-b2b-portal'); ?></option>
                            <option value="shipped" <?php selected($order->status, 'shipped'); ?>><?php esc_html_e('Shipped', 'artisan-b2b-portal'); ?></option>
                            <option value="completed" <?php selected($order->status, 'completed'); ?>><?php esc_html_e('Completed', 'artisan-b2b-portal'); ?></option>
                            <option value="cancelled" <?php selected($order->status, 'cancelled'); ?>><?php esc_html_e('Cancelled', 'artisan-b2b-portal'); ?></option>
                        </select>
                        <button type="button" class="button button-primary ab2b-update-status" data-order-id="<?php echo esc_attr($order->id); ?>">
                            <?php esc_html_e('Update', 'artisan-b2b-portal'); ?>
                        </button>
                    </div>
                    <p class="description">
                        <?php esc_html_e('Customer will be notified when status changes.', 'artisan-b2b-portal'); ?>
                    </p>
                </div>

                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Actions', 'artisan-b2b-portal'); ?></h2>
                    <p>
                        <button type="button" class="button button-link-delete ab2b-delete-item" data-type="order" data-id="<?php echo esc_attr($order->id); ?>" data-redirect="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders')); ?>">
                            <?php esc_html_e('Delete Order', 'artisan-b2b-portal'); ?>
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Order Item Modal -->
<div id="ab2b-edit-item-modal" class="ab2b-modal" style="display: none;">
    <div class="ab2b-modal-overlay"></div>
    <div class="ab2b-modal-content">
        <div class="ab2b-modal-header">
            <h2><?php esc_html_e('Edit Order Item', 'artisan-b2b-portal'); ?></h2>
            <button type="button" class="ab2b-modal-close">&times;</button>
        </div>
        <div class="ab2b-modal-body">
            <form id="edit-order-item-form">
                <input type="hidden" id="edit-item-id" name="item_id" value="">

                <table class="form-table">
                    <tr>
                        <th><label for="edit-product-name"><?php esc_html_e('Product Name', 'artisan-b2b-portal'); ?></label></th>
                        <td><input type="text" id="edit-product-name" name="product_name" class="regular-text" required></td>
                    </tr>
                    <tr>
                        <th><label for="edit-weight-label"><?php esc_html_e('Weight/Variant', 'artisan-b2b-portal'); ?></label></th>
                        <td><input type="text" id="edit-weight-label" name="weight_label" class="regular-text" required></td>
                    </tr>
                    <tr>
                        <th><label for="edit-quantity"><?php esc_html_e('Quantity', 'artisan-b2b-portal'); ?></label></th>
                        <td><input type="number" id="edit-quantity" name="quantity" class="small-text" min="1" required></td>
                    </tr>
                    <tr>
                        <th><label for="edit-unit-price"><?php esc_html_e('Unit Price', 'artisan-b2b-portal'); ?></label></th>
                        <td><input type="number" id="edit-unit-price" name="unit_price" class="small-text" step="0.01" min="0" required></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="ab2b-modal-footer">
            <button type="button" class="button ab2b-modal-cancel"><?php esc_html_e('Cancel', 'artisan-b2b-portal'); ?></button>
            <button type="button" class="button button-primary" id="save-order-item"><?php esc_html_e('Save Changes', 'artisan-b2b-portal'); ?></button>
        </div>
    </div>
</div>

<style>
/* Modal Styles */
.ab2b-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 100000;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ab2b-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
}
.ab2b-modal-content {
    position: relative;
    background: #fff;
    border-radius: 4px;
    box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow: auto;
}
.ab2b-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #ddd;
}
.ab2b-modal-header h2 {
    margin: 0;
    font-size: 18px;
}
.ab2b-modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #666;
    padding: 0;
    line-height: 1;
}
.ab2b-modal-close:hover {
    color: #000;
}
.ab2b-modal-body {
    padding: 20px;
}
.ab2b-modal-body .form-table th {
    padding: 10px 10px 10px 0;
    width: 120px;
}
.ab2b-modal-body .form-table td {
    padding: 10px 0;
}
.ab2b-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 15px 20px;
    border-top: 1px solid #ddd;
    background: #f6f6f6;
}
.column-actions {
    text-align: right;
}
.column-actions .button {
    margin-left: 5px;
}
</style>
