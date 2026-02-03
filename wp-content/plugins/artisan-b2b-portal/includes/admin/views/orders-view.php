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

                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Product', 'artisan-b2b-portal'); ?></th>
                                <th><?php esc_html_e('Weight', 'artisan-b2b-portal'); ?></th>
                                <th class="column-quantity"><?php esc_html_e('Qty', 'artisan-b2b-portal'); ?></th>
                                <th class="column-price"><?php esc_html_e('Unit Price', 'artisan-b2b-portal'); ?></th>
                                <th class="column-total"><?php esc_html_e('Total', 'artisan-b2b-portal'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order->items as $item) : ?>
                                <tr>
                                    <td>
                                        <strong><?php echo esc_html($item->product_name); ?></strong>
                                    </td>
                                    <td><?php echo esc_html($item->weight_label); ?></td>
                                    <td class="column-quantity"><?php echo esc_html($item->quantity); ?></td>
                                    <td class="column-price"><?php echo esc_html(AB2B_Helpers::format_price($item->unit_price)); ?></td>
                                    <td class="column-total"><?php echo esc_html(AB2B_Helpers::format_price($item->line_total)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="ab2b-order-total-label"><?php esc_html_e('Total', 'artisan-b2b-portal'); ?></td>
                                <td class="ab2b-order-total-value"><strong><?php echo esc_html(AB2B_Helpers::format_price($order->total)); ?></strong></td>
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
