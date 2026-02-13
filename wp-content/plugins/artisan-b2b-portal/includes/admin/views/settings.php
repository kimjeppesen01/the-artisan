<?php
/**
 * Settings Page View
 */
if (!defined('ABSPATH')) exit;
?>

<div class="wrap ab2b-admin-wrap">
    <h1><?php esc_html_e('B2B Portal Settings', 'artisan-b2b-portal'); ?></h1>

    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="ab2b-form">
        <?php wp_nonce_field('ab2b_admin_action', 'ab2b_nonce'); ?>
        <input type="hidden" name="ab2b_action" value="save_settings">

        <div class="ab2b-form-card">
            <h2><?php esc_html_e('Shipping', 'artisan-b2b-portal'); ?></h2>

            <table class="form-table">
                <tr>
                    <th><label for="shipping_domestic"><?php esc_html_e('Domestic Shipping', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <input type="number" name="shipping_domestic" id="shipping_domestic" class="small-text" step="0.01" min="0"
                               value="<?php echo esc_attr($settings['shipping_domestic'] ?? 100); ?>"> kr.
                        <p class="description"><?php esc_html_e('Cost for domestic delivery.', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="shipping_international"><?php esc_html_e('International Shipping', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <input type="number" name="shipping_international" id="shipping_international" class="small-text" step="0.01" min="0"
                               value="<?php echo esc_attr($settings['shipping_international'] ?? 125); ?>"> kr.
                        <p class="description"><?php esc_html_e('Cost for international delivery (under weight threshold).', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="shipping_international_7kg"><?php esc_html_e('International Shipping (7kg+)', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <input type="number" name="shipping_international_7kg" id="shipping_international_7kg" class="small-text" step="0.01" min="0"
                               value="<?php echo esc_attr($settings['shipping_international_7kg'] ?? 190); ?>"> kr.
                        <p class="description"><?php esc_html_e('Cost for international delivery when cart weight is 7 kg or more.', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="weight_threshold_kg"><?php esc_html_e('Weight Threshold (kg)', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <input type="number" name="weight_threshold_kg" id="weight_threshold_kg" class="small-text" step="0.1" min="0"
                               value="<?php echo esc_attr($settings['weight_threshold_kg'] ?? 7); ?>">
                        <p class="description"><?php esc_html_e('Cart weight (kg) above which the higher international rate applies.', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="ab2b-form-card">
            <h2><?php esc_html_e('Order Settings', 'artisan-b2b-portal'); ?></h2>

            <table class="form-table">
                <tr>
                    <th><label for="min_days_before"><?php esc_html_e('Minimum Days Before Delivery', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <input type="number" name="min_days_before" id="min_days_before" class="small-text" min="0" max="30"
                               value="<?php echo esc_attr($settings['min_days_before'] ?? 2); ?>">
                        <p class="description"><?php esc_html_e('Minimum number of days before the delivery date that orders can be placed.', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="order_prefix"><?php esc_html_e('Order Number Prefix', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <input type="text" name="order_prefix" id="order_prefix" class="regular-text"
                               value="<?php echo esc_attr($settings['order_prefix'] ?? 'B2B-'); ?>">
                        <p class="description"><?php esc_html_e('Prefix for order numbers (e.g., B2B-).', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="ab2b-form-card">
            <h2><?php esc_html_e('Notifications', 'artisan-b2b-portal'); ?></h2>

            <table class="form-table">
                <tr>
                    <th><label for="order_notification_email"><?php esc_html_e('Order Notification Email', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <input type="email" name="order_notification_email" id="order_notification_email" class="regular-text"
                               value="<?php echo esc_attr($settings['order_notification_email'] ?? ''); ?>"
                               placeholder="order@yourdomain.com">
                        <p class="description"><?php esc_html_e('Email address to receive new order notifications. Leave blank to use admin emails below.', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="admin_emails"><?php esc_html_e('Admin Notification Emails', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <textarea name="admin_emails" id="admin_emails" rows="3" class="large-text"><?php echo esc_textarea($settings['admin_emails'] ?? ''); ?></textarea>
                        <p class="description"><?php esc_html_e('Additional email addresses to receive order notifications. One per line.', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="send_customer_confirmation"><?php esc_html_e('Customer Order Confirmation', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <label>
                            <input type="checkbox" name="send_customer_confirmation" id="send_customer_confirmation" value="1"
                                   <?php checked($settings['send_customer_confirmation'] ?? '1', '1'); ?>>
                            <?php esc_html_e('Send confirmation email to customer when order is confirmed', 'artisan-b2b-portal'); ?>
                        </label>
                    </td>
                </tr>
            </table>
        </div>

        <div class="ab2b-form-card">
            <h2><?php esc_html_e('Company Information', 'artisan-b2b-portal'); ?></h2>

            <table class="form-table">
                <tr>
                    <th><label for="company_name"><?php esc_html_e('Company Name', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <input type="text" name="company_name" id="company_name" class="regular-text"
                               value="<?php echo esc_attr($settings['company_name'] ?? ''); ?>">
                        <p class="description"><?php esc_html_e('Used in email templates.', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="company_logo"><?php esc_html_e('Company Logo URL', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <input type="url" name="company_logo" id="company_logo" class="large-text"
                               value="<?php echo esc_url($settings['company_logo'] ?? ''); ?>">
                        <p class="description"><?php esc_html_e('Logo URL for email headers.', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="ab2b-form-card">
            <h2><?php esc_html_e('Currency', 'artisan-b2b-portal'); ?></h2>

            <table class="form-table">
                <tr>
                    <th><label for="currency_symbol"><?php esc_html_e('Currency Symbol', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <input type="text" name="currency_symbol" id="currency_symbol" class="small-text"
                               value="<?php echo esc_attr($settings['currency_symbol'] ?? 'kr.'); ?>">
                    </td>
                </tr>
                <tr>
                    <th><label for="currency_position"><?php esc_html_e('Currency Position', 'artisan-b2b-portal'); ?></label></th>
                    <td>
                        <select name="currency_position" id="currency_position">
                            <option value="before" <?php selected($settings['currency_position'] ?? 'before', 'before'); ?>><?php esc_html_e('Before (kr. 100)', 'artisan-b2b-portal'); ?></option>
                            <option value="after" <?php selected($settings['currency_position'] ?? 'before', 'after'); ?>><?php esc_html_e('After (100 kr.)', 'artisan-b2b-portal'); ?></option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>

        <div class="ab2b-form-card">
            <h2><?php esc_html_e('Portal Page', 'artisan-b2b-portal'); ?></h2>

            <table class="form-table">
                <tr>
                    <th><?php esc_html_e('Portal Page', 'artisan-b2b-portal'); ?></th>
                    <td>
                        <?php
                        $portal_page_id = get_option('ab2b_portal_page_id');
                        if ($portal_page_id && get_post($portal_page_id)) :
                            $page = get_post($portal_page_id);
                        ?>
                            <p>
                                <strong><?php echo esc_html($page->post_title); ?></strong>
                                <a href="<?php echo esc_url(get_edit_post_link($portal_page_id)); ?>" class="button button-small"><?php esc_html_e('Edit', 'artisan-b2b-portal'); ?></a>
                                <a href="<?php echo esc_url(get_permalink($portal_page_id)); ?>" class="button button-small" target="_blank"><?php esc_html_e('View', 'artisan-b2b-portal'); ?></a>
                            </p>
                        <?php else : ?>
                            <p class="description"><?php esc_html_e('Portal page not found. Create a page with the [ab2b_portal] shortcode.', 'artisan-b2b-portal'); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?php esc_html_e('Shortcode', 'artisan-b2b-portal'); ?></th>
                    <td>
                        <code>[ab2b_portal]</code>
                        <p class="description"><?php esc_html_e('Use this shortcode to display the full B2B portal.', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
            </table>
        </div>

        <p class="submit">
            <button type="submit" class="button button-primary button-large">
                <?php esc_html_e('Save Settings', 'artisan-b2b-portal'); ?>
            </button>
        </p>
    </form>
</div>
