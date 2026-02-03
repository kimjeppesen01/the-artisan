<?php
/**
 * Customers List View
 */
if (!defined('ABSPATH')) exit;
?>

<div class="wrap ab2b-admin-wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e('Customers', 'artisan-b2b-portal'); ?></h1>
    <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers&action=add')); ?>" class="page-title-action">
        <?php esc_html_e('Add New', 'artisan-b2b-portal'); ?>
    </a>

    <form method="get" class="ab2b-search-form">
        <input type="hidden" name="page" value="ab2b-customers">
        <p class="search-box">
            <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="<?php esc_attr_e('Search customers...', 'artisan-b2b-portal'); ?>">
            <input type="submit" class="button" value="<?php esc_attr_e('Search', 'artisan-b2b-portal'); ?>">
        </p>
    </form>

    <?php if (empty($customers)) : ?>
        <div class="ab2b-no-results">
            <p><?php esc_html_e('No customers found.', 'artisan-b2b-portal'); ?></p>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers&action=add')); ?>" class="button button-primary">
                <?php esc_html_e('Add Your First Customer', 'artisan-b2b-portal'); ?>
            </a>
        </div>
    <?php else : ?>
        <table class="wp-list-table widefat fixed striped ab2b-table">
            <thead>
                <tr>
                    <th class="column-company"><?php esc_html_e('Company', 'artisan-b2b-portal'); ?></th>
                    <th class="column-contact"><?php esc_html_e('Contact', 'artisan-b2b-portal'); ?></th>
                    <th class="column-email"><?php esc_html_e('Email', 'artisan-b2b-portal'); ?></th>
                    <th class="column-phone"><?php esc_html_e('Phone', 'artisan-b2b-portal'); ?></th>
                    <th class="column-status"><?php esc_html_e('Status', 'artisan-b2b-portal'); ?></th>
                    <th class="column-actions"><?php esc_html_e('Actions', 'artisan-b2b-portal'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer) : ?>
                    <tr data-id="<?php echo esc_attr($customer->id); ?>">
                        <td class="column-company">
                            <strong>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers&action=edit&id=' . $customer->id)); ?>">
                                    <?php echo esc_html($customer->company_name); ?>
                                </a>
                            </strong>
                        </td>
                        <td class="column-contact"><?php echo esc_html($customer->contact_name); ?></td>
                        <td class="column-email">
                            <a href="mailto:<?php echo esc_attr($customer->email); ?>">
                                <?php echo esc_html($customer->email); ?>
                            </a>
                        </td>
                        <td class="column-phone"><?php echo esc_html($customer->phone); ?></td>
                        <td class="column-status">
                            <?php if ($customer->is_active) : ?>
                                <span class="ab2b-status ab2b-status-confirmed"><?php esc_html_e('Active', 'artisan-b2b-portal'); ?></span>
                            <?php else : ?>
                                <span class="ab2b-status ab2b-status-cancelled"><?php esc_html_e('Inactive', 'artisan-b2b-portal'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="column-actions">
                            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers&action=edit&id=' . $customer->id)); ?>" class="button button-small">
                                <?php esc_html_e('Edit', 'artisan-b2b-portal'); ?>
                            </a>
                            <button type="button" class="button button-small ab2b-send-link" data-customer-id="<?php echo esc_attr($customer->id); ?>">
                                <?php esc_html_e('Send Link', 'artisan-b2b-portal'); ?>
                            </button>
                            <button type="button" class="button button-small button-link-delete ab2b-delete-item" data-type="customer" data-id="<?php echo esc_attr($customer->id); ?>">
                                <?php esc_html_e('Delete', 'artisan-b2b-portal'); ?>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        // Pagination
        $total_pages = ceil($total / $per_page);
        if ($total_pages > 1) :
            $base_url = admin_url('admin.php?page=ab2b-customers');
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
