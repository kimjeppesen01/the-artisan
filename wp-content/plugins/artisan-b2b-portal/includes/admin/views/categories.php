<?php
/**
 * Categories Management View
 */
if (!defined('ABSPATH')) exit;

require_once AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-category.php';

$action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'list';
$categories = AB2B_Category::get_all_with_counts();
?>

<div class="wrap ab2b-admin-wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e('Product Categories', 'artisan-b2b-portal'); ?></h1>
    <hr class="wp-header-end">

    <div style="display: flex; gap: 30px; margin-top: 20px;">
        <!-- Add Category Form -->
        <div style="flex: 0 0 300px;">
            <div class="ab2b-form-card" style="background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 4px;">
                <h2 style="margin-top: 0;"><?php esc_html_e('Add New Category', 'artisan-b2b-portal'); ?></h2>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('ab2b_admin_action', 'ab2b_nonce'); ?>
                    <input type="hidden" name="ab2b_action" value="save_category">

                    <p>
                        <label for="category_name" style="display: block; margin-bottom: 5px; font-weight: 500;">
                            <?php esc_html_e('Name', 'artisan-b2b-portal'); ?> *
                        </label>
                        <input type="text" name="name" id="category_name" class="regular-text" style="width: 100%;" required>
                    </p>

                    <p>
                        <label for="category_slug" style="display: block; margin-bottom: 5px; font-weight: 500;">
                            <?php esc_html_e('Slug', 'artisan-b2b-portal'); ?>
                        </label>
                        <input type="text" name="slug" id="category_slug" class="regular-text" style="width: 100%;"
                               placeholder="<?php esc_attr_e('Auto-generated from name', 'artisan-b2b-portal'); ?>">
                    </p>

                    <p>
                        <label for="category_sort" style="display: block; margin-bottom: 5px; font-weight: 500;">
                            <?php esc_html_e('Sort Order', 'artisan-b2b-portal'); ?>
                        </label>
                        <input type="number" name="sort_order" id="category_sort" class="small-text" value="0" min="0">
                    </p>

                    <p>
                        <button type="submit" class="button button-primary"><?php esc_html_e('Add Category', 'artisan-b2b-portal'); ?></button>
                    </p>
                </form>
            </div>
        </div>

        <!-- Categories Table -->
        <div style="flex: 1;">
            <?php if (empty($categories)) : ?>
                <div style="text-align: center; padding: 40px; background: #fff; border: 1px solid #ccd0d4; border-radius: 4px;">
                    <h3><?php esc_html_e('No categories yet', 'artisan-b2b-portal'); ?></h3>
                    <p><?php esc_html_e('Create your first category using the form on the left.', 'artisan-b2b-portal'); ?></p>
                </div>
            <?php else : ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Name', 'artisan-b2b-portal'); ?></th>
                            <th><?php esc_html_e('Slug', 'artisan-b2b-portal'); ?></th>
                            <th><?php esc_html_e('Products', 'artisan-b2b-portal'); ?></th>
                            <th><?php esc_html_e('Sort Order', 'artisan-b2b-portal'); ?></th>
                            <th style="width: 100px;"><?php esc_html_e('Actions', 'artisan-b2b-portal'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $cat) : ?>
                            <tr>
                                <td>
                                    <strong><?php echo esc_html($cat->name); ?></strong>
                                    <div class="row-actions">
                                        <span class="inline-edit">
                                            <a href="#" class="ab2b-edit-category"
                                               data-id="<?php echo esc_attr($cat->id); ?>"
                                               data-name="<?php echo esc_attr($cat->name); ?>"
                                               data-slug="<?php echo esc_attr($cat->slug); ?>"
                                               data-sort="<?php echo esc_attr($cat->sort_order); ?>">
                                                <?php esc_html_e('Edit', 'artisan-b2b-portal'); ?>
                                            </a>
                                        </span>
                                    </div>
                                </td>
                                <td><code><?php echo esc_html($cat->slug); ?></code></td>
                                <td><?php echo esc_html($cat->product_count); ?></td>
                                <td><?php echo esc_html($cat->sort_order); ?></td>
                                <td>
                                    <button type="button" class="button button-small button-link-delete ab2b-delete-category"
                                            data-id="<?php echo esc_attr($cat->id); ?>"
                                            data-name="<?php echo esc_attr($cat->name); ?>">
                                        <?php esc_html_e('Delete', 'artisan-b2b-portal'); ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="ab2b-edit-category-modal" style="display: none;">
        <div class="ab2b-modal-backdrop" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9998;"></div>
        <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 30px; border-radius: 8px; z-index: 9999; width: 100%; max-width: 400px; box-shadow: 0 5px 30px rgba(0,0,0,0.3);">
            <h2 style="margin-top: 0;"><?php esc_html_e('Edit Category', 'artisan-b2b-portal'); ?></h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('ab2b_admin_action', 'ab2b_nonce'); ?>
                <input type="hidden" name="ab2b_action" value="save_category">
                <input type="hidden" name="category_id" id="edit_category_id" value="">

                <p>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">
                        <?php esc_html_e('Name', 'artisan-b2b-portal'); ?> *
                    </label>
                    <input type="text" name="name" id="edit_category_name" class="regular-text" style="width: 100%;" required>
                </p>

                <p>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">
                        <?php esc_html_e('Slug', 'artisan-b2b-portal'); ?>
                    </label>
                    <input type="text" name="slug" id="edit_category_slug" class="regular-text" style="width: 100%;">
                </p>

                <p>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">
                        <?php esc_html_e('Sort Order', 'artisan-b2b-portal'); ?>
                    </label>
                    <input type="number" name="sort_order" id="edit_category_sort" class="small-text" min="0">
                </p>

                <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="button ab2b-close-edit-modal"><?php esc_html_e('Cancel', 'artisan-b2b-portal'); ?></button>
                    <button type="submit" class="button button-primary"><?php esc_html_e('Update Category', 'artisan-b2b-portal'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Edit category
    $('.ab2b-edit-category').on('click', function(e) {
        e.preventDefault();
        $('#edit_category_id').val($(this).data('id'));
        $('#edit_category_name').val($(this).data('name'));
        $('#edit_category_slug').val($(this).data('slug'));
        $('#edit_category_sort').val($(this).data('sort'));
        $('#ab2b-edit-category-modal').show();
    });

    // Close edit modal
    $('.ab2b-close-edit-modal, #ab2b-edit-category-modal .ab2b-modal-backdrop').on('click', function() {
        $('#ab2b-edit-category-modal').hide();
    });

    // Delete category
    $('.ab2b-delete-category').on('click', function() {
        var name = $(this).data('name');
        var id = $(this).data('id');

        if (!confirm('Delete category "' + name + '"?')) {
            return;
        }

        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
                action: 'ab2b_delete_item',
                nonce: ab2b_admin.nonce,
                type: 'category',
                id: id
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.data.message || 'Error');
                }
            }
        });
    });
});
</script>
