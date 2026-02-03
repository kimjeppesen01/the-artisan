<?php
/**
 * Orders List View
 */
if (!defined('ABSPATH')) exit;
?>

<div class="wrap ab2b-admin-wrap">
    <h1><?php esc_html_e('Orders', 'artisan-b2b-portal'); ?></h1>

    <ul class="subsubsub">
        <li>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders')); ?>"
               class="<?php echo empty($status) ? 'current' : ''; ?>">
                <?php esc_html_e('All', 'artisan-b2b-portal'); ?>
                <span class="count">(<?php echo array_sum($status_counts); ?>)</span>
            </a> |
        </li>
        <li>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&status=pending')); ?>"
               class="<?php echo $status === 'pending' ? 'current' : ''; ?>">
                <?php esc_html_e('Pending', 'artisan-b2b-portal'); ?>
                <span class="count">(<?php echo $status_counts['pending']; ?>)</span>
            </a> |
        </li>
        <li>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&status=confirmed')); ?>"
               class="<?php echo $status === 'confirmed' ? 'current' : ''; ?>">
                <?php esc_html_e('Confirmed', 'artisan-b2b-portal'); ?>
                <span class="count">(<?php echo $status_counts['confirmed']; ?>)</span>
            </a> |
        </li>
        <li>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&status=shipped')); ?>"
               class="<?php echo $status === 'shipped' ? 'current' : ''; ?>">
                <?php esc_html_e('Shipped', 'artisan-b2b-portal'); ?>
                <span class="count">(<?php echo $status_counts['shipped']; ?>)</span>
            </a> |
        </li>
        <li>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&status=completed')); ?>"
               class="<?php echo $status === 'completed' ? 'current' : ''; ?>">
                <?php esc_html_e('Completed', 'artisan-b2b-portal'); ?>
                <span class="count">(<?php echo $status_counts['completed']; ?>)</span>
            </a> |
        </li>
        <li>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&status=cancelled')); ?>"
               class="<?php echo $status === 'cancelled' ? 'current' : ''; ?>">
                <?php esc_html_e('Cancelled', 'artisan-b2b-portal'); ?>
                <span class="count">(<?php echo $status_counts['cancelled']; ?>)</span>
            </a>
        </li>
    </ul>

    <form method="get" class="ab2b-search-form">
        <input type="hidden" name="page" value="ab2b-orders">
        <?php if ($status) : ?>
            <input type="hidden" name="status" value="<?php echo esc_attr($status); ?>">
        <?php endif; ?>
        <p class="search-box">
            <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="<?php esc_attr_e('Search orders...', 'artisan-b2b-portal'); ?>">
            <input type="submit" class="button" value="<?php esc_attr_e('Search', 'artisan-b2b-portal'); ?>">
        </p>
    </form>

    <?php if (empty($orders)) : ?>
        <div class="ab2b-no-results">
            <p><?php esc_html_e('No orders found.', 'artisan-b2b-portal'); ?></p>
        </div>
    <?php else : ?>
        <table class="wp-list-table widefat fixed striped ab2b-table ab2b-orders-table">
            <thead>
                <tr>
                    <th class="column-order"><?php esc_html_e('Order', 'artisan-b2b-portal'); ?></th>
                    <th class="column-customer"><?php esc_html_e('Customer', 'artisan-b2b-portal'); ?></th>
                    <th class="column-delivery"><?php esc_html_e('Delivery Date', 'artisan-b2b-portal'); ?></th>
                    <th class="column-status"><?php esc_html_e('Status', 'artisan-b2b-portal'); ?></th>
                    <th class="column-total"><?php esc_html_e('Total', 'artisan-b2b-portal'); ?></th>
                    <th class="column-date"><?php esc_html_e('Created', 'artisan-b2b-portal'); ?></th>
                    <th class="column-actions"><?php esc_html_e('Actions', 'artisan-b2b-portal'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr data-id="<?php echo esc_attr($order->id); ?>">
                        <td class="column-order">
                            <strong>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&action=view&id=' . $order->id)); ?>">
                                    <?php echo esc_html($order->order_number); ?>
                                </a>
                            </strong>
                        </td>
                        <td class="column-customer">
                            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers&action=edit&id=' . $order->customer_id)); ?>">
                                <?php echo esc_html($order->company_name); ?>
                            </a>
                            <br>
                            <small><?php echo esc_html($order->contact_name); ?></small>
                        </td>
                        <td class="column-delivery">
                            <strong><?php echo esc_html(date_i18n('D, M j, Y', strtotime($order->delivery_date))); ?></strong>
                        </td>
                        <td class="column-status">
                            <span class="ab2b-status <?php echo esc_attr(AB2B_Helpers::get_status_class($order->status)); ?>">
                                <?php echo esc_html(AB2B_Helpers::get_status_label($order->status)); ?>
                            </span>
                        </td>
                        <td class="column-total">
                            <?php echo esc_html(AB2B_Helpers::format_price($order->total)); ?>
                        </td>
                        <td class="column-date">
                            <?php echo esc_html(date_i18n('M j, Y', strtotime($order->created_at))); ?>
                            <br>
                            <small><?php echo esc_html(date_i18n('H:i', strtotime($order->created_at))); ?></small>
                        </td>
                        <td class="column-actions">
                            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&action=view&id=' . $order->id)); ?>" class="button button-small">
                                <?php esc_html_e('View', 'artisan-b2b-portal'); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        // Pagination
        $total_pages = ceil($total / $per_page);
        if ($total_pages > 1) :
            $base_url = admin_url('admin.php?page=ab2b-orders');
            if ($status) $base_url = add_query_arg('status', $status, $base_url);
            if ($search) $base_url = add_query_arg('s', $search, $base_url);
        ?>
            <div class="tablenav bottom">
                <div class="tablenav-pages">
                    <span class="displaying-num">
                        <?php printf(esc_html__('%s items', 'artisan-b2b-portal'), number_format_i18n($total)); ?>
                    </span>
                    <span class="pagination-links">
                        <?php if ($paged > 1) : ?>
                            <a href="<?php echo esc_url(add_query_arg('paged', $paged - 1, $base_url)); ?>" class="prev-page button">&lsaquo;</a>
                        <?php endif; ?>
                        <span class="paging-input">
                            <?php echo esc_html($paged); ?> / <?php echo esc_html($total_pages); ?>
                        </span>
                        <?php if ($paged < $total_pages) : ?>
                            <a href="<?php echo esc_url(add_query_arg('paged', $paged + 1, $base_url)); ?>" class="next-page button">&rsaquo;</a>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
