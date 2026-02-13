<?php
/**
 * Admin Dashboard View
 */
if (!defined('ABSPATH')) exit;
?>

<div class="wrap ab2b-admin-wrap">
    <h1><?php esc_html_e('B2B Portal Dashboard', 'artisan-b2b-portal'); ?></h1>

    <div class="ab2b-dashboard-stats">
        <div class="ab2b-stat-box ab2b-stat-pending">
            <span class="ab2b-stat-icon dashicons dashicons-clock"></span>
            <div class="ab2b-stat-content">
                <span class="ab2b-stat-number"><?php echo esc_html($stats['pending_orders']); ?></span>
                <span class="ab2b-stat-label"><?php esc_html_e('Pending Orders', 'artisan-b2b-portal'); ?></span>
            </div>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&status=pending')); ?>" class="ab2b-stat-link">
                <?php esc_html_e('View', 'artisan-b2b-portal'); ?> &rarr;
            </a>
        </div>

        <div class="ab2b-stat-box ab2b-stat-confirmed">
            <span class="ab2b-stat-icon dashicons dashicons-yes-alt"></span>
            <div class="ab2b-stat-content">
                <span class="ab2b-stat-number"><?php echo esc_html($stats['confirmed_orders']); ?></span>
                <span class="ab2b-stat-label"><?php esc_html_e('Confirmed Orders', 'artisan-b2b-portal'); ?></span>
            </div>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&status=confirmed')); ?>" class="ab2b-stat-link">
                <?php esc_html_e('View', 'artisan-b2b-portal'); ?> &rarr;
            </a>
        </div>

        <div class="ab2b-stat-box ab2b-stat-customers">
            <span class="ab2b-stat-icon dashicons dashicons-groups"></span>
            <div class="ab2b-stat-content">
                <span class="ab2b-stat-number"><?php echo esc_html($stats['total_customers']); ?></span>
                <span class="ab2b-stat-label"><?php esc_html_e('Active Customers', 'artisan-b2b-portal'); ?></span>
            </div>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers')); ?>" class="ab2b-stat-link">
                <?php esc_html_e('Manage', 'artisan-b2b-portal'); ?> &rarr;
            </a>
        </div>

        <div class="ab2b-stat-box ab2b-stat-products">
            <span class="ab2b-stat-icon dashicons dashicons-products"></span>
            <div class="ab2b-stat-content">
                <span class="ab2b-stat-number"><?php echo esc_html($stats['total_products']); ?></span>
                <span class="ab2b-stat-label"><?php esc_html_e('Active Products', 'artisan-b2b-portal'); ?></span>
            </div>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-products')); ?>" class="ab2b-stat-link">
                <?php esc_html_e('Manage', 'artisan-b2b-portal'); ?> &rarr;
            </a>
        </div>
    </div>

    <div class="ab2b-dashboard-columns">
        <div class="ab2b-dashboard-column">
            <div class="ab2b-dashboard-card">
                <h2><?php esc_html_e('Recent Orders', 'artisan-b2b-portal'); ?></h2>
                <?php if (empty($recent_orders)) : ?>
                    <p class="ab2b-no-data"><?php esc_html_e('No orders yet.', 'artisan-b2b-portal'); ?></p>
                <?php else : ?>
                    <table class="ab2b-mini-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Order', 'artisan-b2b-portal'); ?></th>
                                <th><?php esc_html_e('Customer', 'artisan-b2b-portal'); ?></th>
                                <th><?php esc_html_e('Status', 'artisan-b2b-portal'); ?></th>
                                <th><?php esc_html_e('Total', 'artisan-b2b-portal'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_orders as $order) : ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&action=view&id=' . $order->id)); ?>">
                                            <?php echo esc_html($order->order_number); ?>
                                        </a>
                                    </td>
                                    <td><?php echo esc_html($order->company_name); ?></td>
                                    <td>
                                        <span class="ab2b-status <?php echo esc_attr(AB2B_Helpers::get_status_class($order->status)); ?>">
                                            <?php echo esc_html(AB2B_Helpers::get_status_label($order->status)); ?>
                                        </span>
                                    </td>
                                    <td><?php echo esc_html(AB2B_Helpers::format_price($order->total)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p class="ab2b-view-all">
                        <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders')); ?>">
                            <?php esc_html_e('View all orders', 'artisan-b2b-portal'); ?> &rarr;
                        </a>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="ab2b-dashboard-column">
            <div class="ab2b-dashboard-card">
                <h2><?php esc_html_e('Upcoming Deliveries', 'artisan-b2b-portal'); ?></h2>
                <?php if (empty($upcoming_deliveries)) : ?>
                    <p class="ab2b-no-data"><?php esc_html_e('No upcoming deliveries.', 'artisan-b2b-portal'); ?></p>
                <?php else : ?>
                    <table class="ab2b-mini-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Date', 'artisan-b2b-portal'); ?></th>
                                <th><?php esc_html_e('Method', 'artisan-b2b-portal'); ?></th>
                                <th><?php esc_html_e('Customer', 'artisan-b2b-portal'); ?></th>
                                <th><?php esc_html_e('Order', 'artisan-b2b-portal'); ?></th>
                                <th><?php esc_html_e('Status', 'artisan-b2b-portal'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($upcoming_deliveries as $order) :
                                $method = isset($order->delivery_method) ? $order->delivery_method : 'shipping';
                                $method_label = $method === 'pickup'
                                    ? __('Pick up', 'artisan-b2b-portal')
                                    : ($method === 'international'
                                        ? __('International', 'artisan-b2b-portal')
                                        : __('Delivery', 'artisan-b2b-portal'));
                                $method_class = 'ab2b-method-' . esc_attr($method);
                            ?>
                                <tr>
                                    <td>
                                        <strong><?php echo esc_html(date_i18n('D, M j', strtotime($order->delivery_date))); ?></strong>
                                    </td>
                                    <td>
                                        <span class="ab2b-delivery-method-badge <?php echo $method_class; ?>"><?php echo esc_html($method_label); ?></span>
                                    </td>
                                    <td><?php echo esc_html($order->company_name); ?></td>
                                    <td>
                                        <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&action=view&id=' . $order->id)); ?>">
                                            <?php echo esc_html($order->order_number); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="ab2b-status <?php echo esc_attr(AB2B_Helpers::get_status_class($order->status)); ?>">
                                            <?php echo esc_html(AB2B_Helpers::get_status_label($order->status)); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="ab2b-dashboard-card">
                <h2><?php esc_html_e('Quick Links', 'artisan-b2b-portal'); ?></h2>
                <ul class="ab2b-quick-links">
                    <li>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers&action=add')); ?>">
                            <span class="dashicons dashicons-plus-alt2"></span>
                            <?php esc_html_e('Add New Customer', 'artisan-b2b-portal'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-products&action=add')); ?>">
                            <span class="dashicons dashicons-plus-alt2"></span>
                            <?php esc_html_e('Add New Product', 'artisan-b2b-portal'); ?>
                        </a>
                    </li>
                    <li>
                        <?php
                        $portal_page_id = get_option('ab2b_portal_page_id');
                        $portal_url = $portal_page_id ? get_permalink($portal_page_id) : home_url('/b2b-portal/');
                        ?>
                        <a href="<?php echo esc_url($portal_url); ?>" target="_blank">
                            <span class="dashicons dashicons-external"></span>
                            <?php esc_html_e('View Portal Page', 'artisan-b2b-portal'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-settings')); ?>">
                            <span class="dashicons dashicons-admin-settings"></span>
                            <?php esc_html_e('Portal Settings', 'artisan-b2b-portal'); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
