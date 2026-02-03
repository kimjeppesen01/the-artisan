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
                            <th><label for="email"><?php esc_html_e('Email', 'artisan-b2b-portal'); ?> *</label></th>
                            <td>
                                <input type="email" name="email" id="email" class="regular-text"
                                       value="<?php echo $is_edit ? esc_attr($customer->email) : ''; ?>" required>
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
                            <th><label for="address"><?php esc_html_e('Address', 'artisan-b2b-portal'); ?></label></th>
                            <td>
                                <textarea name="address" id="address" rows="3" class="large-text"><?php echo $is_edit ? esc_textarea($customer->address) : ''; ?></textarea>
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
            </div>

            <div class="ab2b-form-sidebar">
                <?php if ($is_edit) : ?>
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
