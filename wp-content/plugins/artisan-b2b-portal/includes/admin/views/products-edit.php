<?php
/**
 * Product Edit View
 */
if (!defined('ABSPATH')) exit;

$is_edit = !empty($product);
$page_title = $is_edit ? __('Edit Product', 'artisan-b2b-portal') : __('Add New Product', 'artisan-b2b-portal');
$weights = $is_edit && !empty($product->weights) ? $product->weights : [];

// Get categories
require_once AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-category.php';
$all_categories = AB2B_Category::get_all();
$product_category_ids = $is_edit ? AB2B_Category::get_product_category_ids($product->id) : [];
?>

<div class="wrap ab2b-admin-wrap">
    <h1><?php echo esc_html($page_title); ?></h1>

    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="ab2b-form">
        <?php wp_nonce_field('ab2b_admin_action', 'ab2b_nonce'); ?>
        <input type="hidden" name="ab2b_action" value="save_product">
        <?php if ($is_edit) : ?>
            <input type="hidden" name="product_id" value="<?php echo esc_attr($product->id); ?>">
        <?php endif; ?>

        <div class="ab2b-form-columns">
            <div class="ab2b-form-main">
                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Product Information', 'artisan-b2b-portal'); ?></h2>

                    <table class="form-table">
                        <tr>
                            <th><label for="name"><?php esc_html_e('Product Name', 'artisan-b2b-portal'); ?> *</label></th>
                            <td>
                                <input type="text" name="name" id="name" class="regular-text"
                                       value="<?php echo $is_edit ? esc_attr($product->name) : ''; ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="short_description"><?php esc_html_e('Short Description', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <textarea name="short_description" id="short_description" rows="2" class="large-text"><?php echo $is_edit ? esc_textarea($product->short_description) : ''; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="description"><?php esc_html_e('Full Description', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <?php
                                wp_editor(
                                    $is_edit ? $product->description : '',
                                    'description',
                                    [
                                        'textarea_name' => 'description',
                                        'textarea_rows' => 8,
                                        'media_buttons' => false,
                                        'teeny'         => true,
                                    ]
                                );
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="sort_order"><?php esc_html_e('Sort Order', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="number" name="sort_order" id="sort_order" class="small-text" min="0"
                                       value="<?php echo $is_edit ? esc_attr($product->sort_order) : '0'; ?>">
                                <p class="description"><?php esc_html_e('Lower numbers appear first.', 'artisan-b2b-portal'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Status', 'artisan-b2b-portal'); ?></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="is_active" value="1"
                                           <?php checked(!$is_edit || $product->is_active); ?>>
                                    <?php esc_html_e('Active (visible in shop)', 'artisan-b2b-portal'); ?>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Weights & Pricing', 'artisan-b2b-portal'); ?></h2>
                    <p class="description"><?php esc_html_e('Define the available weight options and prices for this product.', 'artisan-b2b-portal'); ?></p>

                    <table class="ab2b-weights-table widefat" id="weights-table">
                        <thead>
                            <tr>
                                <th class="column-label"><?php esc_html_e('Label', 'artisan-b2b-portal'); ?></th>
                                <th class="column-value"><?php esc_html_e('Value', 'artisan-b2b-portal'); ?></th>
                                <th class="column-unit"><?php esc_html_e('Unit', 'artisan-b2b-portal'); ?></th>
                                <th class="column-price"><?php esc_html_e('Price', 'artisan-b2b-portal'); ?></th>
                                <th class="column-active"><?php esc_html_e('Active', 'artisan-b2b-portal'); ?></th>
                                <th class="column-remove"></th>
                            </tr>
                        </thead>
                        <tbody id="weights-body">
                            <?php if (!empty($weights)) : ?>
                                <?php foreach ($weights as $index => $weight) : ?>
                                    <tr class="weight-row">
                                        <td>
                                            <input type="hidden" name="weights[<?php echo $index; ?>][id]" value="<?php echo esc_attr($weight->id); ?>">
                                            <input type="text" name="weights[<?php echo $index; ?>][weight_label]" value="<?php echo esc_attr($weight->weight_label); ?>" placeholder="e.g. 250g" class="regular-text" required>
                                        </td>
                                        <td>
                                            <input type="number" name="weights[<?php echo $index; ?>][weight_value]" value="<?php echo esc_attr($weight->weight_value); ?>" class="small-text" min="0">
                                        </td>
                                        <td>
                                            <select name="weights[<?php echo $index; ?>][weight_unit]">
                                                <option value="g" <?php selected($weight->weight_unit, 'g'); ?>>g</option>
                                                <option value="kg" <?php selected($weight->weight_unit, 'kg'); ?>>kg</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="weights[<?php echo $index; ?>][price]" value="<?php echo esc_attr($weight->price); ?>" step="0.01" min="0" class="small-text" required>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="weights[<?php echo $index; ?>][is_active]" value="1" <?php checked($weight->is_active); ?>>
                                        </td>
                                        <td>
                                            <button type="button" class="button button-link-delete ab2b-remove-weight">&times;</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <p>
                        <button type="button" class="button" id="add-weight">
                            <?php esc_html_e('+ Add Weight Option', 'artisan-b2b-portal'); ?>
                        </button>
                    </p>

                    <template id="weight-row-template">
                        <tr class="weight-row">
                            <td>
                                <input type="text" name="weights[__INDEX__][weight_label]" placeholder="e.g. 250g" class="regular-text" required>
                            </td>
                            <td>
                                <input type="number" name="weights[__INDEX__][weight_value]" class="small-text" min="0" value="250">
                            </td>
                            <td>
                                <select name="weights[__INDEX__][weight_unit]">
                                    <option value="g">g</option>
                                    <option value="kg">kg</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="weights[__INDEX__][price]" step="0.01" min="0" class="small-text" required>
                            </td>
                            <td>
                                <input type="checkbox" name="weights[__INDEX__][is_active]" value="1" checked>
                            </td>
                            <td>
                                <button type="button" class="button button-link-delete ab2b-remove-weight">&times;</button>
                            </td>
                        </tr>
                    </template>
                </div>
            </div>

            <div class="ab2b-form-sidebar">
                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Product Image', 'artisan-b2b-portal'); ?></h2>

                    <div class="ab2b-image-upload" id="image-upload">
                        <input type="hidden" name="image_id" id="image_id" value="<?php echo $is_edit ? esc_attr($product->image_id) : '0'; ?>">
                        <div class="ab2b-image-preview">
                            <?php if ($is_edit && $product->image_id) : ?>
                                <?php echo wp_get_attachment_image($product->image_id, 'medium'); ?>
                            <?php else : ?>
                                <span class="ab2b-no-image-placeholder"><?php esc_html_e('No image selected', 'artisan-b2b-portal'); ?></span>
                            <?php endif; ?>
                        </div>
                        <p>
                            <button type="button" class="button ab2b-upload-image"><?php esc_html_e('Select Image', 'artisan-b2b-portal'); ?></button>
                            <button type="button" class="button ab2b-remove-image" <?php echo (!$is_edit || !$product->image_id) ? 'style="display:none;"' : ''; ?>><?php esc_html_e('Remove', 'artisan-b2b-portal'); ?></button>
                        </p>
                    </div>
                </div>

                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Hover Image', 'artisan-b2b-portal'); ?></h2>
                    <p class="description"><?php esc_html_e('Second image shown on hover (optional).', 'artisan-b2b-portal'); ?></p>

                    <div class="ab2b-image-upload" id="hover-image-upload">
                        <input type="hidden" name="hover_image_id" id="hover_image_id" value="<?php echo $is_edit ? esc_attr($product->hover_image_id) : '0'; ?>">
                        <div class="ab2b-image-preview">
                            <?php if ($is_edit && $product->hover_image_id) : ?>
                                <?php echo wp_get_attachment_image($product->hover_image_id, 'medium'); ?>
                            <?php else : ?>
                                <span class="ab2b-no-image-placeholder"><?php esc_html_e('No image selected', 'artisan-b2b-portal'); ?></span>
                            <?php endif; ?>
                        </div>
                        <p>
                            <button type="button" class="button ab2b-upload-image"><?php esc_html_e('Select Image', 'artisan-b2b-portal'); ?></button>
                            <button type="button" class="button ab2b-remove-image" <?php echo (!$is_edit || !$product->hover_image_id) ? 'style="display:none;"' : ''; ?>><?php esc_html_e('Remove', 'artisan-b2b-portal'); ?></button>
                        </p>
                    </div>
                </div>

                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Categories', 'artisan-b2b-portal'); ?></h2>
                    <?php if (!empty($all_categories)) : ?>
                        <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px;">
                            <?php foreach ($all_categories as $cat) : ?>
                                <label style="display: block; margin-bottom: 6px; cursor: pointer;">
                                    <input type="checkbox" name="product_categories[]" value="<?php echo esc_attr($cat->id); ?>"
                                           <?php checked(in_array($cat->id, $product_category_ids)); ?>>
                                    <?php echo esc_html($cat->name); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p class="description">
                            <?php printf(
                                __('No categories yet. <a href="%s">Create one</a>.', 'artisan-b2b-portal'),
                                esc_url(admin_url('admin.php?page=ab2b-categories'))
                            ); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Actions', 'artisan-b2b-portal'); ?></h2>
                    <p>
                        <button type="submit" class="button button-primary button-large">
                            <?php echo $is_edit ? esc_html__('Update Product', 'artisan-b2b-portal') : esc_html__('Add Product', 'artisan-b2b-portal'); ?>
                        </button>
                    </p>
                    <p>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-products')); ?>" class="button">
                            <?php esc_html_e('Cancel', 'artisan-b2b-portal'); ?>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
