<?php
/**
 * Products List View
 */
if (!defined('ABSPATH')) exit;
?>

<div class="wrap ab2b-admin-wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e('Products', 'artisan-b2b-portal'); ?></h1>
    <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-products&action=add')); ?>" class="page-title-action">
        <?php esc_html_e('Add New', 'artisan-b2b-portal'); ?>
    </a>

    <?php if (empty($products)) : ?>
        <div class="ab2b-no-results">
            <p><?php esc_html_e('No products found.', 'artisan-b2b-portal'); ?></p>
            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-products&action=add')); ?>" class="button button-primary">
                <?php esc_html_e('Add Your First Product', 'artisan-b2b-portal'); ?>
            </a>
        </div>
    <?php else : ?>
        <table class="wp-list-table widefat fixed striped ab2b-table ab2b-products-table">
            <thead>
                <tr>
                    <th class="column-image"><?php esc_html_e('Image', 'artisan-b2b-portal'); ?></th>
                    <th class="column-name"><?php esc_html_e('Name', 'artisan-b2b-portal'); ?></th>
                    <th class="column-weights"><?php esc_html_e('Weights & Prices', 'artisan-b2b-portal'); ?></th>
                    <th class="column-status"><?php esc_html_e('Status', 'artisan-b2b-portal'); ?></th>
                    <th class="column-order"><?php esc_html_e('Order', 'artisan-b2b-portal'); ?></th>
                    <th class="column-actions"><?php esc_html_e('Actions', 'artisan-b2b-portal'); ?></th>
                </tr>
            </thead>
            <tbody id="ab2b-products-sortable">
                <?php foreach ($products as $product) : ?>
                    <tr data-id="<?php echo esc_attr($product->id); ?>">
                        <td class="column-image">
                            <?php if ($product->image_id) : ?>
                                <?php echo wp_get_attachment_image($product->image_id, [60, 60], false, ['class' => 'ab2b-product-thumb']); ?>
                            <?php else : ?>
                                <span class="ab2b-no-image dashicons dashicons-format-image"></span>
                            <?php endif; ?>
                        </td>
                        <td class="column-name">
                            <strong>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-products&action=edit&id=' . $product->id)); ?>">
                                    <?php echo esc_html($product->name); ?>
                                </a>
                            </strong>
                            <?php if ($product->short_description) : ?>
                                <p class="ab2b-description"><?php echo esc_html(wp_trim_words($product->short_description, 10)); ?></p>
                            <?php endif; ?>
                        </td>
                        <td class="column-weights">
                            <?php if (!empty($product->weights)) : ?>
                                <ul class="ab2b-weights-list">
                                    <?php foreach ($product->weights as $weight) : ?>
                                        <li<?php echo !$weight->is_active ? ' class="ab2b-inactive"' : ''; ?>>
                                            <span class="ab2b-weight-label"><?php echo esc_html($weight->weight_label); ?></span>
                                            <span class="ab2b-weight-price"><?php echo esc_html(AB2B_Helpers::format_price($weight->price)); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <span class="ab2b-no-weights"><?php esc_html_e('No weights defined', 'artisan-b2b-portal'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="column-status">
                            <?php if ($product->is_active) : ?>
                                <span class="ab2b-status ab2b-status-confirmed"><?php esc_html_e('Active', 'artisan-b2b-portal'); ?></span>
                            <?php else : ?>
                                <span class="ab2b-status ab2b-status-cancelled"><?php esc_html_e('Inactive', 'artisan-b2b-portal'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="column-order">
                            <span class="ab2b-sort-handle dashicons dashicons-menu"></span>
                            <?php echo esc_html($product->sort_order); ?>
                        </td>
                        <td class="column-actions">
                            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-products&action=edit&id=' . $product->id)); ?>" class="button button-small">
                                <?php esc_html_e('Edit', 'artisan-b2b-portal'); ?>
                            </a>
                            <button type="button" class="button button-small button-link-delete ab2b-delete-item" data-type="product" data-id="<?php echo esc_attr($product->id); ?>">
                                <?php esc_html_e('Delete', 'artisan-b2b-portal'); ?>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
