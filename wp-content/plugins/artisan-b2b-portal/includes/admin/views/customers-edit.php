<?php
/**
 * Customer Edit View
 */
if (!defined('ABSPATH')) exit;

$is_edit = !empty($customer);
$page_title = $is_edit ? __('Edit Customer', 'artisan-b2b-portal') : __('Add New Customer', 'artisan-b2b-portal');
?>

<div class="wrap ab2b-admin-wrap">
    <h1><?php echo esc_html($page_title); ?></h1>

    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="ab2b-form">
        <?php wp_nonce_field('ab2b_admin_action', 'ab2b_nonce'); ?>
        <input type="hidden" name="ab2b_action" value="save_customer">
        <?php if ($is_edit) : ?>
            <input type="hidden" name="customer_id" value="<?php echo esc_attr($customer->id); ?>">
        <?php endif; ?>

        <div class="ab2b-form-columns">
            <div class="ab2b-form-main">
                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Customer Information', 'artisan-b2b-portal'); ?></h2>

                    <table class="form-table">
                        <tr>
                            <th><label for="company_name"><?php esc_html_e('Company Name', 'artisan-b2b-portal'); ?> *</label></th>
                            <td>
                                <input type="text" name="company_name" id="company_name" class="regular-text"
                                       value="<?php echo $is_edit ? esc_attr($customer->company_name) : ''; ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="contact_name"><?php esc_html_e('Contact Name', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="text" name="contact_name" id="contact_name" class="regular-text"
                                       value="<?php echo $is_edit ? esc_attr($customer->contact_name) : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="email"><?php esc_html_e('Contact / Login Email', 'artisan-b2b-portal'); ?> *</label></th>
                            <td>
                                <input type="email" name="email" id="email" class="regular-text"
                                       value="<?php echo $is_edit ? esc_attr($customer->email) : ''; ?>" required>
                                <p class="description"><?php esc_html_e('Used for login, password reset, and account notifications.', 'artisan-b2b-portal'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="invoice_email"><?php esc_html_e('Invoice Email', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="email" name="invoice_email" id="invoice_email" class="regular-text"
                                       value="<?php echo $is_edit ? esc_attr($customer->invoice_email ?? '') : ''; ?>"
                                       placeholder="<?php esc_attr_e('Optional', 'artisan-b2b-portal'); ?>">
                                <p class="description"><?php esc_html_e('Order confirmations and invoices sent here. Leave blank to use contact email.', 'artisan-b2b-portal'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="phone"><?php esc_html_e('Phone', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="tel" name="phone" id="phone" class="regular-text"
                                       value="<?php echo $is_edit ? esc_attr($customer->phone) : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="address"><?php esc_html_e('Bill To – Address', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <textarea name="address" id="address" rows="2" class="large-text" placeholder="<?php esc_attr_e('Street address', 'artisan-b2b-portal'); ?>"><?php echo $is_edit ? esc_textarea($customer->address ?? '') : ''; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="city"><?php esc_html_e('Bill To – City', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="text" name="city" id="city" class="regular-text" value="<?php echo $is_edit ? esc_attr($customer->city ?? '') : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="postcode"><?php esc_html_e('Bill To – Postcode', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="text" name="postcode" id="postcode" class="regular-text" value="<?php echo $is_edit ? esc_attr($customer->postcode ?? '') : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="cvr_number"><?php esc_html_e('CVR Number', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="text" name="cvr_number" id="cvr_number" class="regular-text" value="<?php echo $is_edit ? esc_attr($customer->cvr_number ?? '') : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" style="padding-top: 1.5em;"><strong><?php esc_html_e('Deliver To', 'artisan-b2b-portal'); ?></strong></th>
                        </tr>
                        <tr>
                            <th><label for="delivery_company"><?php esc_html_e('Delivery – Company', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="text" name="delivery_company" id="delivery_company" class="regular-text" value="<?php echo $is_edit ? esc_attr($customer->delivery_company ?? '') : ''; ?>">
                                <p class="description"><?php esc_html_e('Leave blank to use billing details.', 'artisan-b2b-portal'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="delivery_contact"><?php esc_html_e('Delivery – Contact', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="text" name="delivery_contact" id="delivery_contact" class="regular-text" value="<?php echo $is_edit ? esc_attr($customer->delivery_contact ?? '') : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="delivery_address"><?php esc_html_e('Delivery – Address', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <textarea name="delivery_address" id="delivery_address" rows="2" class="large-text"><?php echo $is_edit ? esc_textarea($customer->delivery_address ?? '') : ''; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="delivery_city"><?php esc_html_e('Delivery – City', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="text" name="delivery_city" id="delivery_city" class="regular-text" value="<?php echo $is_edit ? esc_attr($customer->delivery_city ?? '') : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="delivery_postcode"><?php esc_html_e('Delivery – Postcode', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <input type="text" name="delivery_postcode" id="delivery_postcode" class="regular-text" value="<?php echo $is_edit ? esc_attr($customer->delivery_postcode ?? '') : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="notes"><?php esc_html_e('Notes', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <textarea name="notes" id="notes" rows="3" class="large-text"><?php echo $is_edit ? esc_textarea($customer->notes) : ''; ?></textarea>
                                <p class="description"><?php esc_html_e('Internal notes (not visible to customer).', 'artisan-b2b-portal'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Status', 'artisan-b2b-portal'); ?></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="is_active" value="1"
                                           <?php checked(!$is_edit || $customer->is_active); ?>>
                                    <?php esc_html_e('Active (can access portal)', 'artisan-b2b-portal'); ?>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php if ($is_edit) :
                    require_once AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-customer-pricing.php';
                    $all_products = AB2B_Product::get_all(['is_active' => 1]);
                    $customer_prices = AB2B_Customer_Pricing::get_customer_price_map($customer->id);
                    $customer_products = AB2B_Customer_Pricing::get_customer_products($customer->id);
                    $assigned_product_ids = wp_list_pluck($customer_products, 'product_id');
                ?>
                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Custom Pricing & Exclusive Products', 'artisan-b2b-portal'); ?></h2>
                    <p class="description"><?php esc_html_e('Set special prices for this customer. Leave blank to use default price. Mark products as "Exclusive" to make them only visible to this customer.', 'artisan-b2b-portal'); ?></p>

                    <div class="ab2b-pricing-section">
                        <?php foreach ($all_products as $product) :
                            $is_assigned = in_array($product->id, $assigned_product_ids);
                            $customer_product = null;
                            if ($is_assigned) {
                                foreach ($customer_products as $cp) {
                                    if ($cp->product_id == $product->id) {
                                        $customer_product = $cp;
                                        break;
                                    }
                                }
                            }
                        ?>
                        <div class="ab2b-pricing-product <?php echo $is_assigned ? 'ab2b-product-assigned' : ''; ?>">
                            <div class="ab2b-pricing-product-header">
                                <label class="ab2b-pricing-toggle">
                                    <input type="checkbox" name="customer_products[<?php echo esc_attr($product->id); ?>][enabled]" value="1"
                                           <?php checked($is_assigned); ?> class="ab2b-toggle-product">
                                    <strong><?php echo esc_html($product->name); ?></strong>
                                </label>
                                <label class="ab2b-exclusive-toggle">
                                    <input type="checkbox" name="customer_products[<?php echo esc_attr($product->id); ?>][exclusive]" value="1"
                                           <?php checked($customer_product && $customer_product->is_exclusive); ?>>
                                    <span class="ab2b-exclusive-badge"><?php esc_html_e('Exclusive', 'artisan-b2b-portal'); ?></span>
                                </label>
                            </div>

                            <div class="ab2b-pricing-product-body">
                                <div class="ab2b-custom-name-row">
                                    <label><?php esc_html_e('Custom Product Name (optional)', 'artisan-b2b-portal'); ?></label>
                                    <input type="text" name="customer_products[<?php echo esc_attr($product->id); ?>][custom_name]"
                                           value="<?php echo $customer_product ? esc_attr($customer_product->custom_name) : ''; ?>"
                                           placeholder="<?php echo esc_attr($product->name); ?>" class="regular-text">
                                </div>

                                <?php if (!empty($product->weights)) : ?>
                                <table class="ab2b-pricing-table widefat">
                                    <thead>
                                        <tr>
                                            <th><?php esc_html_e('Weight', 'artisan-b2b-portal'); ?></th>
                                            <th><?php esc_html_e('Default Price', 'artisan-b2b-portal'); ?></th>
                                            <th><?php esc_html_e('Custom Price', 'artisan-b2b-portal'); ?></th>
                                            <th><?php esc_html_e('Discount', 'artisan-b2b-portal'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($product->weights as $weight) :
                                            $custom_price = isset($customer_prices[$weight->id]) ? $customer_prices[$weight->id] : '';
                                            $discount_pct = '';
                                            if ($custom_price !== '' && $weight->price > 0) {
                                                $discount_pct = round((($weight->price - $custom_price) / $weight->price) * 100, 1);
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo esc_html($weight->weight_label); ?></td>
                                            <td class="ab2b-default-price"><?php echo esc_html(AB2B_Helpers::format_price($weight->price)); ?></td>
                                            <td>
                                                <input type="number" step="0.01" min="0"
                                                       name="customer_prices[<?php echo esc_attr($weight->id); ?>]"
                                                       value="<?php echo $custom_price !== '' ? esc_attr($custom_price) : ''; ?>"
                                                       placeholder="<?php echo esc_attr($weight->price); ?>"
                                                       class="small-text ab2b-custom-price-input"
                                                       data-default="<?php echo esc_attr($weight->price); ?>">
                                            </td>
                                            <td class="ab2b-discount-display">
                                                <?php if ($discount_pct !== '' && $discount_pct > 0) : ?>
                                                    <span class="ab2b-discount-badge">-<?php echo esc_html($discount_pct); ?>%</span>
                                                <?php elseif ($discount_pct !== '' && $discount_pct < 0) : ?>
                                                    <span class="ab2b-markup-badge">+<?php echo esc_html(abs($discount_pct)); ?>%</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="ab2b-form-sidebar">
                <?php
                // Show Portal Access (key-based URL) only when NOT using custom URL + password.
                // When both url_slug and password are set, customers use the custom URL instead.
                $has_custom_login = $is_edit && !empty($customer->url_slug) && !empty($customer->password_hash);
                ?>
                <?php if ($is_edit && !$has_custom_login) : ?>
                    <div class="ab2b-form-card">
                        <h2><?php esc_html_e('Portal Access', 'artisan-b2b-portal'); ?></h2>

                        <div class="ab2b-portal-link-box">
                            <label><?php esc_html_e('Access Key', 'artisan-b2b-portal'); ?></label>
                            <code id="access-key"><?php echo esc_html($customer->access_key); ?></code>

                            <label><?php esc_html_e('Portal URL', 'artisan-b2b-portal'); ?></label>
                            <input type="text" id="portal-url" readonly class="regular-text"
                                   value="<?php echo esc_url(AB2B_Helpers::get_portal_url($customer->access_key)); ?>">

                            <div class="ab2b-portal-actions">
                                <button type="button" class="button ab2b-copy-url" data-target="#portal-url">
                                    <?php esc_html_e('Copy URL', 'artisan-b2b-portal'); ?>
                                </button>
                                <button type="button" class="button ab2b-send-link" data-customer-id="<?php echo esc_attr($customer->id); ?>">
                                    <?php esc_html_e('Send to Customer', 'artisan-b2b-portal'); ?>
                                </button>
                            </div>

                            <hr>

                            <button type="button" class="button button-link-delete ab2b-regenerate-key" data-customer-id="<?php echo esc_attr($customer->id); ?>">
                                <?php esc_html_e('Regenerate Access Key', 'artisan-b2b-portal'); ?>
                            </button>
                            <p class="description"><?php esc_html_e('This will invalidate the current link.', 'artisan-b2b-portal'); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Custom URL & Password', 'artisan-b2b-portal'); ?></h2>
                    <p class="description" style="margin-bottom: 15px;"><?php esc_html_e('Create a memorable URL with password protection.', 'artisan-b2b-portal'); ?></p>

                    <p>
                        <label for="url_slug" style="display: block; margin-bottom: 5px; font-weight: 500;"><?php esc_html_e('Custom URL Slug', 'artisan-b2b-portal'); ?></label>
                        <input type="text" name="url_slug" id="url_slug" class="regular-text" style="width: 100%;"
                               value="<?php echo $is_edit ? esc_attr($customer->url_slug ?? '') : ''; ?>"
                               pattern="[a-z0-9\-]+"
                               placeholder="<?php esc_attr_e('e.g. company-name', 'artisan-b2b-portal'); ?>">
                        <span class="description"><?php esc_html_e('Lowercase letters, numbers, hyphens only.', 'artisan-b2b-portal'); ?></span>
                    </p>

                    <?php if ($is_edit && !empty($customer->url_slug)) : ?>
                        <p style="margin-top: 10px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;"><?php esc_html_e('Custom Portal URL', 'artisan-b2b-portal'); ?></label>
                            <input type="text" id="custom-portal-url" readonly class="regular-text" style="width: 100%;"
                                   value="<?php echo esc_url(AB2B_Helpers::get_portal_url(null, $customer->url_slug)); ?>">
                            <button type="button" class="button ab2b-copy-url" data-target="#custom-portal-url" style="margin-top: 5px;">
                                <?php esc_html_e('Copy Custom URL', 'artisan-b2b-portal'); ?>
                            </button>
                        </p>
                    <?php endif; ?>

                    <p style="margin-top: 15px;">
                        <label for="customer_password" style="display: block; margin-bottom: 5px; font-weight: 500;"><?php esc_html_e('Password', 'artisan-b2b-portal'); ?></label>
                        <input type="password" name="customer_password" id="customer_password" class="regular-text" style="width: 100%;" autocomplete="new-password">
                        <?php if ($is_edit && !empty($customer->password_hash)) : ?>
                            <span class="description" style="color: green;">&#10003; <?php esc_html_e('Password set. Leave blank to keep current.', 'artisan-b2b-portal'); ?></span>
                        <?php else : ?>
                            <span class="description"><?php esc_html_e('Required when using custom URL.', 'artisan-b2b-portal'); ?></span>
                        <?php endif; ?>
                    </p>
                </div>

                <?php if ($is_edit) : ?>
                    <div class="ab2b-form-card">
                        <h2><?php esc_html_e('Customer Details', 'artisan-b2b-portal'); ?></h2>
                        <ul class="ab2b-meta-list">
                            <li>
                                <span class="ab2b-meta-label"><?php esc_html_e('Created', 'artisan-b2b-portal'); ?></span>
                                <span class="ab2b-meta-value"><?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($customer->created_at))); ?></span>
                            </li>
                            <li>
                                <span class="ab2b-meta-label"><?php esc_html_e('Last Updated', 'artisan-b2b-portal'); ?></span>
                                <span class="ab2b-meta-value"><?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($customer->updated_at))); ?></span>
                            </li>
                            <?php
                            $order_count = AB2B_Order::count(['customer_id' => $customer->id]);
                            ?>
                            <li>
                                <span class="ab2b-meta-label"><?php esc_html_e('Total Orders', 'artisan-b2b-portal'); ?></span>
                                <span class="ab2b-meta-value">
                                    <?php if ($order_count > 0) : ?>
                                        <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&customer_id=' . $customer->id)); ?>">
                                            <?php echo esc_html($order_count); ?>
                                        </a>
                                    <?php else : ?>
                                        0
                                    <?php endif; ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="ab2b-form-card">
                    <h2><?php esc_html_e('Actions', 'artisan-b2b-portal'); ?></h2>
                    <p>
                        <button type="submit" class="button button-primary button-large">
                            <?php echo $is_edit ? esc_html__('Update Customer', 'artisan-b2b-portal') : esc_html__('Add Customer', 'artisan-b2b-portal'); ?>
                        </button>
                    </p>
                    <p>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-customers')); ?>" class="button">
                            <?php esc_html_e('Cancel', 'artisan-b2b-portal'); ?>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
