<?php
/**
 * Email Handler
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Email {

    /**
     * Constructor - register hooks
     */
    public static function init() {
        add_action('ab2b_order_created', [__CLASS__, 'send_order_notification']);
        add_action('ab2b_order_created', [__CLASS__, 'send_order_acknowledgement']);
        add_action('ab2b_order_status_changed', [__CLASS__, 'send_status_notification'], 10, 3);
    }

    /**
     * Send portal access link to customer
     */
    public static function send_portal_link($customer) {
        $portal_url = AB2B_Helpers::get_portal_url($customer->access_key);
        $company_name = ab2b_get_option('company_name', get_bloginfo('name'));
        $company_logo = ab2b_get_option('company_logo', '');

        $subject = sprintf(__('Your B2B Portal Access - %s', 'artisan-b2b-portal'), $company_name);

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
                <tr>
                    <td style="padding: 40px 30px; text-align: center; background: linear-gradient(135deg, #333 0%, #1a1a1a 100%);">
                        <?php if ($company_logo) : ?>
                            <img src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr($company_name); ?>" style="max-width: 200px; height: auto;">
                        <?php else : ?>
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;"><?php echo esc_html($company_name); ?></h1>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 40px 30px;">
                        <h2 style="margin: 0 0 20px; color: #333; font-size: 22px;">
                            <?php esc_html_e('Welcome to Your B2B Portal', 'artisan-b2b-portal'); ?>
                        </h2>

                        <p style="color: #666; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                            <?php printf(esc_html__('Hello %s,', 'artisan-b2b-portal'), esc_html($customer->contact_name ?: $customer->company_name)); ?>
                        </p>

                        <p style="color: #666; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                            <?php esc_html_e('You can now access your B2B ordering portal using the link below. From there you can browse products, place orders, and track your order history.', 'artisan-b2b-portal'); ?>
                        </p>

                        <div style="text-align: center; margin: 30px 0;">
                            <a href="<?php echo esc_url($portal_url); ?>" style="display: inline-block; padding: 15px 30px; background-color: #333; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 5px; font-size: 16px;">
                                <?php esc_html_e('Access Your Portal', 'artisan-b2b-portal'); ?>
                            </a>
                        </div>

                        <p style="color: #999; font-size: 14px; line-height: 1.6; margin: 20px 0 0;">
                            <?php esc_html_e('If the button above doesn\'t work, copy and paste this link into your browser:', 'artisan-b2b-portal'); ?>
                        </p>
                        <p style="color: #666; font-size: 14px; word-break: break-all; margin: 5px 0 20px;">
                            <?php echo esc_url($portal_url); ?>
                        </p>

                        <p style="color: #999; font-size: 13px; line-height: 1.6; margin: 20px 0 0; padding-top: 20px; border-top: 1px solid #eee;">
                            <?php esc_html_e('This link is unique to your account. Please do not share it with others.', 'artisan-b2b-portal'); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 30px; background-color: #f8f8f8; text-align: center;">
                        <p style="color: #999; font-size: 12px; margin: 0;">
                            &copy; <?php echo date('Y'); ?> <?php echo esc_html($company_name); ?>
                        </p>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        <?php
        $message = ob_get_clean();

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $company_name . ' <' . get_option('admin_email') . '>',
        ];

        return wp_mail($customer->email, $subject, $message, $headers);
    }

    /**
     * Send order acknowledgement to customer
     */
    public static function send_order_acknowledgement($order_id) {
        $order = AB2B_Order::get($order_id);
        if (!$order || !$order->customer) return;

        $company_name = ab2b_get_option('company_name', get_bloginfo('name'));
        $company_logo = ab2b_get_option('company_logo', '');

        $subject = sprintf(
            __('Order Received - %s', 'artisan-b2b-portal'),
            $order->order_number
        );

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
                <tr>
                    <td style="padding: 40px 30px; text-align: center; background: linear-gradient(135deg, #333 0%, #1a1a1a 100%);">
                        <?php if ($company_logo) : ?>
                            <img src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr($company_name); ?>" style="max-width: 200px; height: auto;">
                        <?php else : ?>
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;"><?php echo esc_html($company_name); ?></h1>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 40px 30px;">
                        <div style="text-align: center; margin-bottom: 30px;">
                            <span style="font-size: 48px;">✓</span>
                        </div>

                        <h2 style="margin: 0 0 10px; color: #333; font-size: 22px; text-align: center;">
                            <?php esc_html_e('Order Received!', 'artisan-b2b-portal'); ?>
                        </h2>

                        <p style="color: #666; font-size: 16px; line-height: 1.6; margin: 0 0 20px; text-align: center;">
                            <?php printf(esc_html__('Hello %s,', 'artisan-b2b-portal'), esc_html($order->customer->contact_name ?: $order->customer->company_name)); ?>
                        </p>

                        <p style="color: #666; font-size: 16px; line-height: 1.6; margin: 0 0 30px; text-align: center;">
                            <?php esc_html_e('Thank you for your order! We have received it and will process it shortly. You will receive another email when your order is confirmed.', 'artisan-b2b-portal'); ?>
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f8f8; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                            <tr>
                                <td style="padding: 15px;">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding: 8px 0;">
                                                <strong><?php esc_html_e('Order Number:', 'artisan-b2b-portal'); ?></strong>
                                                <span style="float: right;"><?php echo esc_html($order->order_number); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 8px 0; border-top: 1px solid #e0e0e0;">
                                                <strong><?php esc_html_e('Delivery Date:', 'artisan-b2b-portal'); ?></strong>
                                                <span style="float: right;"><?php echo esc_html(date_i18n('l, M j, Y', strtotime($order->delivery_date))); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 8px 0; border-top: 1px solid #e0e0e0;">
                                                <strong><?php esc_html_e('Total:', 'artisan-b2b-portal'); ?></strong>
                                                <span style="float: right; font-weight: bold;"><?php echo esc_html(AB2B_Helpers::format_price($order->total)); ?></span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <h3 style="margin: 20px 0 10px; color: #333;"><?php esc_html_e('Order Items', 'artisan-b2b-portal'); ?></h3>
                        <table width="100%" cellpadding="8" cellspacing="0" style="border: 1px solid #eee; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f8f8f8;">
                                    <th align="left" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Product', 'artisan-b2b-portal'); ?></th>
                                    <th align="left" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Weight', 'artisan-b2b-portal'); ?></th>
                                    <th align="center" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Qty', 'artisan-b2b-portal'); ?></th>
                                    <th align="right" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Total', 'artisan-b2b-portal'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order->items as $item) : ?>
                                    <tr>
                                        <td style="border-bottom: 1px solid #eee;"><?php echo esc_html($item->product_name); ?></td>
                                        <td style="border-bottom: 1px solid #eee;"><?php echo esc_html($item->weight_label); ?></td>
                                        <td align="center" style="border-bottom: 1px solid #eee;"><?php echo esc_html($item->quantity); ?></td>
                                        <td align="right" style="border-bottom: 1px solid #eee;"><?php echo esc_html(AB2B_Helpers::format_price($item->line_total)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" align="right" style="font-weight: bold;"><?php esc_html_e('Total:', 'artisan-b2b-portal'); ?></td>
                                    <td align="right" style="font-weight: bold; font-size: 16px;"><?php echo esc_html(AB2B_Helpers::format_price($order->total)); ?></td>
                                </tr>
                            </tfoot>
                        </table>

                        <?php if (!empty($order->special_instructions)) : ?>
                            <div style="margin-top: 20px; padding: 15px; background-color: #fff9e6; border-left: 3px solid #ffc107;">
                                <strong><?php esc_html_e('Special Instructions:', 'artisan-b2b-portal'); ?></strong>
                                <p style="margin: 10px 0 0;"><?php echo nl2br(esc_html($order->special_instructions)); ?></p>
                            </div>
                        <?php endif; ?>

                        <div style="text-align: center; margin-top: 30px;">
                            <a href="<?php echo esc_url(AB2B_Helpers::get_portal_url($order->customer->access_key)); ?>" style="display: inline-block; padding: 12px 25px; background-color: #333; color: #ffffff; text-decoration: none; border-radius: 5px;">
                                <?php esc_html_e('View Your Orders', 'artisan-b2b-portal'); ?>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 30px; background-color: #f8f8f8; text-align: center;">
                        <p style="color: #999; font-size: 12px; margin: 0;">
                            &copy; <?php echo date('Y'); ?> <?php echo esc_html($company_name); ?>
                        </p>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        <?php
        $message = ob_get_clean();

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $company_name . ' <' . get_option('admin_email') . '>',
        ];

        return wp_mail($order->customer->email, $subject, $message, $headers);
    }

    /**
     * Send order notification to admin
     */
    public static function send_order_notification($order_id) {
        $order = AB2B_Order::get($order_id);
        if (!$order) return;

        // Get primary order notification email
        $order_email = ab2b_get_option('order_notification_email', '');

        // Get additional admin emails
        $admin_emails = ab2b_get_option('admin_emails', '');
        $additional_emails = array_filter(array_map('trim', explode("\n", $admin_emails)));

        // Build email list
        $emails = [];
        if (!empty($order_email)) {
            $emails[] = $order_email;
        }
        $emails = array_merge($emails, $additional_emails);

        // Fallback to WordPress admin email if nothing is configured
        if (empty($emails)) {
            $emails[] = get_option('admin_email');
        }

        // Remove duplicates
        $emails = array_unique(array_filter($emails));

        if (empty($emails)) return;

        $company_name = ab2b_get_option('company_name', get_bloginfo('name'));

        $subject = sprintf(
            __('New B2B Order %s from %s', 'artisan-b2b-portal'),
            $order->order_number,
            $order->customer->company_name
        );

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
                <tr>
                    <td style="padding: 30px; background: linear-gradient(135deg, #333 0%, #1a1a1a 100%);">
                        <h1 style="color: #ffffff; margin: 0; font-size: 20px;">
                            <?php esc_html_e('New B2B Order', 'artisan-b2b-portal'); ?>
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                    <strong><?php esc_html_e('Order Number:', 'artisan-b2b-portal'); ?></strong>
                                    <span style="float: right;"><?php echo esc_html($order->order_number); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                    <strong><?php esc_html_e('Customer:', 'artisan-b2b-portal'); ?></strong>
                                    <span style="float: right;"><?php echo esc_html($order->customer->company_name); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                    <strong><?php esc_html_e('Contact:', 'artisan-b2b-portal'); ?></strong>
                                    <span style="float: right;"><?php echo esc_html($order->customer->contact_name); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                    <strong><?php esc_html_e('Email:', 'artisan-b2b-portal'); ?></strong>
                                    <span style="float: right;">
                                        <a href="mailto:<?php echo esc_attr($order->customer->email); ?>"><?php echo esc_html($order->customer->email); ?></a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                    <strong><?php esc_html_e('Delivery Date:', 'artisan-b2b-portal'); ?></strong>
                                    <span style="float: right; font-weight: bold; color: #333;">
                                        <?php echo esc_html(date_i18n('l, M j, Y', strtotime($order->delivery_date))); ?>
                                    </span>
                                </td>
                            </tr>
                        </table>

                        <h3 style="margin: 20px 0 10px; color: #333;"><?php esc_html_e('Order Items', 'artisan-b2b-portal'); ?></h3>
                        <table width="100%" cellpadding="8" cellspacing="0" style="border: 1px solid #eee; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f8f8f8;">
                                    <th align="left" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Product', 'artisan-b2b-portal'); ?></th>
                                    <th align="left" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Weight', 'artisan-b2b-portal'); ?></th>
                                    <th align="center" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Qty', 'artisan-b2b-portal'); ?></th>
                                    <th align="right" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Total', 'artisan-b2b-portal'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order->items as $item) : ?>
                                    <tr>
                                        <td style="border-bottom: 1px solid #eee;"><?php echo esc_html($item->product_name); ?></td>
                                        <td style="border-bottom: 1px solid #eee;"><?php echo esc_html($item->weight_label); ?></td>
                                        <td align="center" style="border-bottom: 1px solid #eee;"><?php echo esc_html($item->quantity); ?></td>
                                        <td align="right" style="border-bottom: 1px solid #eee;"><?php echo esc_html(AB2B_Helpers::format_price($item->line_total)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" align="right" style="font-weight: bold;"><?php esc_html_e('Total:', 'artisan-b2b-portal'); ?></td>
                                    <td align="right" style="font-weight: bold; font-size: 16px;"><?php echo esc_html(AB2B_Helpers::format_price($order->total)); ?></td>
                                </tr>
                            </tfoot>
                        </table>

                        <?php if (!empty($order->special_instructions)) : ?>
                            <div style="margin-top: 20px; padding: 15px; background-color: #fff9e6; border-left: 3px solid #ffc107;">
                                <strong><?php esc_html_e('Special Instructions:', 'artisan-b2b-portal'); ?></strong>
                                <p style="margin: 10px 0 0;"><?php echo nl2br(esc_html($order->special_instructions)); ?></p>
                            </div>
                        <?php endif; ?>

                        <div style="text-align: center; margin-top: 30px;">
                            <a href="<?php echo esc_url(admin_url('admin.php?page=ab2b-orders&action=view&id=' . $order->id)); ?>" style="display: inline-block; padding: 12px 25px; background-color: #333; color: #ffffff; text-decoration: none; border-radius: 5px;">
                                <?php esc_html_e('View Order in Dashboard', 'artisan-b2b-portal'); ?>
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        <?php
        $message = ob_get_clean();

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $company_name . ' <' . get_option('admin_email') . '>',
        ];

        foreach ($emails as $email) {
            wp_mail($email, $subject, $message, $headers);
        }
    }

    /**
     * Send status change notification to customer
     */
    public static function send_status_notification($order_id, $new_status, $old_status) {
        // Only send for certain status changes
        $notify_statuses = ['confirmed', 'shipped', 'cancelled'];
        if (!in_array($new_status, $notify_statuses)) return;

        $order = AB2B_Order::get($order_id);
        if (!$order || !$order->customer) return;

        $company_name = ab2b_get_option('company_name', get_bloginfo('name'));
        $company_logo = ab2b_get_option('company_logo', '');
        $status_label = AB2B_Helpers::get_status_label($new_status);

        $subject = sprintf(
            __('Order %s - %s', 'artisan-b2b-portal'),
            $order->order_number,
            $status_label
        );

        // Status-specific messages
        $status_messages = [
            'confirmed' => __('Great news! Your order has been confirmed and is being prepared.', 'artisan-b2b-portal'),
            'shipped'   => __('Your order is on its way! It will arrive on the scheduled delivery date.', 'artisan-b2b-portal'),
            'cancelled' => __('Your order has been cancelled. If you have any questions, please contact us.', 'artisan-b2b-portal'),
        ];

        $status_colors = [
            'confirmed' => '#28a745',
            'shipped'   => '#007bff',
            'cancelled' => '#dc3545',
        ];

        $message_text = $status_messages[$new_status] ?? '';
        $status_color = $status_colors[$new_status] ?? '#333';

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
                <tr>
                    <td style="padding: 40px 30px; text-align: center; background: linear-gradient(135deg, #333 0%, #1a1a1a 100%);">
                        <?php if ($company_logo) : ?>
                            <img src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr($company_name); ?>" style="max-width: 200px; height: auto;">
                        <?php else : ?>
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;"><?php echo esc_html($company_name); ?></h1>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 40px 30px;">
                        <div style="text-align: center; margin-bottom: 30px;">
                            <span style="display: inline-block; padding: 10px 25px; background-color: <?php echo esc_attr($status_color); ?>; color: #ffffff; border-radius: 25px; font-weight: bold; text-transform: uppercase; font-size: 14px;">
                                <?php echo esc_html($status_label); ?>
                            </span>
                        </div>

                        <h2 style="margin: 0 0 10px; color: #333; font-size: 22px; text-align: center;">
                            <?php esc_html_e('Order Update', 'artisan-b2b-portal'); ?>
                        </h2>

                        <p style="color: #666; font-size: 16px; line-height: 1.6; margin: 0 0 20px; text-align: center;">
                            <?php printf(esc_html__('Hello %s,', 'artisan-b2b-portal'), esc_html($order->customer->contact_name ?: $order->customer->company_name)); ?>
                        </p>

                        <p style="color: #666; font-size: 16px; line-height: 1.6; margin: 0 0 30px; text-align: center;">
                            <?php echo esc_html($message_text); ?>
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f8f8; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                            <tr>
                                <td style="padding: 15px;">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding: 8px 0;">
                                                <strong><?php esc_html_e('Order Number:', 'artisan-b2b-portal'); ?></strong>
                                                <span style="float: right;"><?php echo esc_html($order->order_number); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 8px 0; border-top: 1px solid #e0e0e0;">
                                                <strong><?php esc_html_e('Delivery Date:', 'artisan-b2b-portal'); ?></strong>
                                                <span style="float: right;"><?php echo esc_html(date_i18n('l, M j, Y', strtotime($order->delivery_date))); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 8px 0; border-top: 1px solid #e0e0e0;">
                                                <strong><?php esc_html_e('Total:', 'artisan-b2b-portal'); ?></strong>
                                                <span style="float: right; font-weight: bold;"><?php echo esc_html(AB2B_Helpers::format_price($order->total)); ?></span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <h3 style="margin: 20px 0 10px; color: #333;"><?php esc_html_e('Order Items', 'artisan-b2b-portal'); ?></h3>
                        <table width="100%" cellpadding="8" cellspacing="0" style="border: 1px solid #eee; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f8f8f8;">
                                    <th align="left" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Product', 'artisan-b2b-portal'); ?></th>
                                    <th align="left" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Weight', 'artisan-b2b-portal'); ?></th>
                                    <th align="center" style="border-bottom: 1px solid #eee;"><?php esc_html_e('Qty', 'artisan-b2b-portal'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order->items as $item) : ?>
                                    <tr>
                                        <td style="border-bottom: 1px solid #eee;"><?php echo esc_html($item->product_name); ?></td>
                                        <td style="border-bottom: 1px solid #eee;"><?php echo esc_html($item->weight_label); ?></td>
                                        <td align="center" style="border-bottom: 1px solid #eee;"><?php echo esc_html($item->quantity); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div style="text-align: center; margin-top: 30px;">
                            <a href="<?php echo esc_url(AB2B_Helpers::get_portal_url($order->customer->access_key)); ?>" style="display: inline-block; padding: 12px 25px; background-color: #333; color: #ffffff; text-decoration: none; border-radius: 5px;">
                                <?php esc_html_e('View in Portal', 'artisan-b2b-portal'); ?>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 30px; background-color: #f8f8f8; text-align: center;">
                        <p style="color: #999; font-size: 12px; margin: 0;">
                            &copy; <?php echo date('Y'); ?> <?php echo esc_html($company_name); ?>
                        </p>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        <?php
        $message = ob_get_clean();

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $company_name . ' <' . get_option('admin_email') . '>',
        ];

        return wp_mail($order->customer->email, $subject, $message, $headers);
    }
}

// Initialize email hooks
AB2B_Email::init();
