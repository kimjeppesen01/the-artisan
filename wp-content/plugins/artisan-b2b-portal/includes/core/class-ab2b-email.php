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
        add_action('ab2b_customer_updated', [__CLASS__, 'send_customer_updated_notification'], 10, 2);
    }

    /**
     * Send portal access link to customer
     */
    public static function send_portal_link($customer) {
        $company_name = ab2b_get_option('company_name', get_bloginfo('name'));
        $company_logo = ab2b_get_option('company_logo', '');
        $company_address = ab2b_get_option('company_address', '');
        $company_cvr = ab2b_get_option('company_cvr', '');
        $company_contact = ab2b_get_option('company_contact_email', '') ?: get_option('admin_email');

        // Determine which URL to use: custom slug (with password) or access key
        $has_custom_url = !empty($customer->url_slug) && !empty($customer->password_hash);

        if ($has_custom_url) {
            $portal_url = AB2B_Helpers::get_portal_url(null, $customer->url_slug);
        } else {
            $portal_url = AB2B_Helpers::get_portal_url($customer->access_key);
        }

        $subject = sprintf(__('Your B2B Portal Access - %s', 'artisan-b2b-portal'), $company_name);

        ob_start();
        ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?php esc_attr_e('Welcome to Your B2B Portal', 'artisan-b2b-portal'); ?> — <?php echo esc_attr($company_name); ?></title>
  <style>
    body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
    img { -ms-interpolation-mode:bicubic; border:0; outline:none; text-decoration:none; max-width:100%; height:auto; }
    body { margin:0!important; padding:0!important; background-color:#eceae6; font-family:'DM Sans',Arial,sans-serif; }
    @media only screen and (max-width: 620px) {
      .wrapper { width: 100% !important; max-width: 100% !important; padding: 16px !important; }
      .inner { width: 100% !important; }
    }
  </style>
</head>
<body style="margin:0;padding:0;background-color:#eceae6;font-family:'DM Sans',Arial,sans-serif;">

<div style="display:none;font-size:1px;color:#eceae6;line-height:1px;max-height:0;opacity:0;overflow:hidden;">
  <?php esc_html_e('Welcome to your B2B portal', 'artisan-b2b-portal'); ?>
</div>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#eceae6;">
  <tr><td align="center" style="padding:32px 16px;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" class="inner" style="max-width:600px;width:100%;">

      <!-- Header -->
      <tr>
        <td style="background-color:#1a1068;padding:32px 40px 28px;border-radius:4px 4px 0 0;">
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td valign="middle">
                <?php if ($company_logo) : ?>
                <img src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr($company_name); ?>" width="140" style="display:block;max-width:140px;height:auto;filter:brightness(0) invert(1);" />
                <?php else : ?>
                <span style="font-family:'DM Sans',Arial,sans-serif;font-size:24px;font-weight:600;color:#ffffff;"><?php echo esc_html($company_name); ?></span>
                <?php endif; ?>
              </td>
              <td valign="middle" align="right">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="background-color:#1db8c2;border-radius:3px;padding:7px 16px;">
                      <span style="font-family:'DM Sans',Arial,sans-serif;font-size:11px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:#ffffff;">&#10003;&nbsp; <?php esc_html_e('Portal Access', 'artisan-b2b-portal'); ?></span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr><td style="background-color:#1db8c2;height:4px;font-size:0;line-height:0;">&nbsp;</td></tr>

      <!-- Content -->
      <tr>
        <td style="background-color:#ffffff;padding:36px 40px 28px;">
          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:22px;font-weight:500;color:#1a1068;margin:0 0 10px;line-height:1.3;">
            <?php esc_html_e('Welcome to Your B2B Portal', 'artisan-b2b-portal'); ?>
          </p>
          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:14px;font-weight:300;color:#555;margin:0 0 20px;line-height:1.75;">
            <?php printf(esc_html__('Hello %s,', 'artisan-b2b-portal'), esc_html($customer->contact_name ?: $customer->company_name)); ?>
          </p>
          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:14px;font-weight:300;color:#555;margin:0 0 24px;line-height:1.75;">
            <?php esc_html_e('You can now access your B2B ordering portal using the link below. From there you can browse products, place orders, and track your order history.', 'artisan-b2b-portal'); ?>
          </p>

          <?php if ($has_custom_url) : ?>
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #e4e0d8;border-radius:4px;overflow:hidden;margin-bottom:20px;">
            <tr>
              <td style="padding:18px 22px;background-color:#f9f7f4;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#1db8c2;margin:0 0 8px;"><?php esc_html_e('Your Login Details', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:500;color:#1a1068;margin:0 0 4px;"><?php esc_html_e('Portal URL:', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:300;color:#555;margin:0 0 12px;word-break:break-all;">
                  <a href="<?php echo esc_url($portal_url); ?>" style="color:#1db8c2;text-decoration:none;"><?php echo esc_html($portal_url); ?></a>
                </p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:500;color:#1a1068;margin:0;"><?php esc_html_e('Password:', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:300;color:#555;margin:0;"><?php esc_html_e('Use the password provided by your account manager.', 'artisan-b2b-portal'); ?></p>
              </td>
            </tr>
          </table>
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fff8e6;border-left:4px solid #e6a800;border-radius:0 4px 4px 0;margin-bottom:24px;">
            <tr>
              <td style="padding:14px 18px;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:14px;font-weight:600;color:#333;margin:0;line-height:1.6;">
                  <?php esc_html_e('Please log in immediately. After logging in, you can set your own password in the Account section for a more secure login.', 'artisan-b2b-portal'); ?>
                </p>
              </td>
            </tr>
          </table>
          <?php endif; ?>

          <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
              <td style="background-color:#1a1068;border-radius:4px;padding:14px 32px;">
                <a href="<?php echo esc_url($portal_url); ?>" style="font-family:'DM Sans',Arial,sans-serif;font-size:15px;font-weight:600;color:#ffffff;text-decoration:none;display:inline-block;">
                  <?php echo $has_custom_url ? esc_html__('Log in Now', 'artisan-b2b-portal') : esc_html__('Access Your Portal', 'artisan-b2b-portal'); ?>
                </a>
              </td>
            </tr>
          </table>

          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:300;color:#888;margin:24px 0 8px;line-height:1.6;">
            <?php esc_html_e('If the button doesn\'t work, copy this link into your browser:', 'artisan-b2b-portal'); ?>
          </p>
          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:400;color:#555;margin:0 0 24px;word-break:break-all;line-height:1.5;">
            <?php echo esc_url($portal_url); ?>
          </p>

          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:300;color:#888;margin:0;padding-top:20px;border-top:1px solid #e4e0d8;line-height:1.6;">
            <?php if ($has_custom_url) : ?>
              <?php esc_html_e('Keep your password secure and do not share it with others.', 'artisan-b2b-portal'); ?>
            <?php else : ?>
              <?php esc_html_e('This link is unique to your account. Please do not share it with others.', 'artisan-b2b-portal'); ?>
            <?php endif; ?>
          </p>
        </td>
      </tr>

      <!-- Footer -->
      <tr><td style="background-color:#1db8c2;height:4px;font-size:0;line-height:0;">&nbsp;</td></tr>
      <tr>
        <td style="background-color:#1a1068;padding:24px 40px;border-radius:0 0 4px 4px;">
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td valign="middle">
                <?php if ($company_logo) : ?>
                <img src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr($company_name); ?>" width="80" style="display:block;max-width:80px;height:auto;filter:brightness(0) invert(1);opacity:.7;" />
                <?php else : ?>
                <span style="font-family:'DM Sans',Arial,sans-serif;font-size:16px;font-weight:600;color:rgba(255,255,255,.7);"><?php echo esc_html($company_name); ?></span>
                <?php endif; ?>
              </td>
              <td valign="middle" align="right">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:11px;font-weight:300;color:rgba(255,255,255,.5);margin:0;line-height:1.6;text-align:right;">
                  <?php if ($company_address) : ?><?php echo esc_html($company_address); ?><br><?php endif; ?>
                  <?php if ($company_cvr) : ?>CVR: <?php echo esc_html($company_cvr); ?> &nbsp;·&nbsp; <?php endif; ?>
                  <a href="mailto:<?php echo esc_attr($company_contact); ?>" style="color:rgba(255,255,255,.7);text-decoration:none;"><?php echo esc_html($company_contact); ?></a>
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </td></tr>
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
     * Send password reset email with new temporary password
     *
     * @param object $customer Customer object
     * @param string $new_password The new unhashed password to send
     */
    public static function send_password_reset($customer, $new_password) {
        $company_name = ab2b_get_option('company_name', get_bloginfo('name'));
        $company_logo = ab2b_get_option('company_logo', '');
        $portal_url = AB2B_Helpers::get_portal_url(null, $customer->url_slug ?: '');

        $subject = sprintf(__('Your New Portal Password - %s', 'artisan-b2b-portal'), $company_name);

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
                            <?php esc_html_e('Your New Portal Password', 'artisan-b2b-portal'); ?>
                        </h2>

                        <p style="color: #666; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                            <?php printf(esc_html__('Hello %s,', 'artisan-b2b-portal'), esc_html($customer->contact_name ?: $customer->company_name)); ?>
                        </p>

                        <p style="color: #666; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                            <?php esc_html_e('A new password has been generated for your B2B portal account. Use the details below to log in.', 'artisan-b2b-portal'); ?>
                        </p>

                        <div style="background-color: #f8f8f8; border-radius: 8px; padding: 20px; margin: 20px 0;">
                            <p style="color: #333; font-weight: bold; margin: 0 0 10px;">
                                <?php esc_html_e('Your New Password:', 'artisan-b2b-portal'); ?>
                            </p>
                            <p style="color: #1a1068; font-size: 18px; font-weight: 600; margin: 0 0 15px; font-family: monospace; letter-spacing: 2px;">
                                <?php echo esc_html($new_password); ?>
                            </p>
                            <p style="color: #666; margin: 5px 0 0;">
                                <strong><?php esc_html_e('Portal URL:', 'artisan-b2b-portal'); ?></strong><br>
                                <a href="<?php echo esc_url($portal_url); ?>" style="color: #333;"><?php echo esc_url($portal_url); ?></a>
                            </p>
                        </div>

                        <div style="text-align: center; margin: 30px 0;">
                            <a href="<?php echo esc_url($portal_url); ?>" style="display: inline-block; padding: 15px 30px; background-color: #333; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 5px; font-size: 16px;">
                                <?php esc_html_e('Log In to Portal', 'artisan-b2b-portal'); ?>
                            </a>
                        </div>

                        <p style="color: #999; font-size: 13px; line-height: 1.6; margin: 20px 0 0; padding-top: 20px; border-top: 1px solid #eee;">
                            <?php esc_html_e('We recommend changing this password after logging in via your Account settings.', 'artisan-b2b-portal'); ?>
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
     * Send order acknowledgement to customer (professional template)
     */
    public static function send_order_acknowledgement($order_id) {
        $order = AB2B_Order::get($order_id);
        if (!$order || !$order->customer) return;

        $message = self::build_order_email_html($order, 'acknowledgement');
        if (empty($message)) return false;

        $company_name = ab2b_get_option('company_name', get_bloginfo('name'));
        $subject = sprintf(__('Order Confirmation — %s', 'artisan-b2b-portal'), $order->order_number);

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $company_name . ' <' . get_option('admin_email') . '>',
        ];

        $to = (!empty($order->customer->billing_email) && is_email($order->customer->billing_email))
            ? $order->customer->billing_email
            : $order->customer->email;
        return wp_mail($to, $subject, $message, $headers);
    }

    /**
     * Build professional order email HTML (Artisan-style template)
     *
     * @param object $order Order with items and customer
     * @param string $type 'acknowledgement' or 'status'
     * @param string|null $status_label For status emails: Confirmed, Shipped, Cancelled
     * @param string|null $status_message For status emails
     * @return string HTML
     */
    private static function build_order_email_html($order, $type = 'acknowledgement', $status_label = null, $status_message = null) {
        $c = $order->customer;
        $company_name = ab2b_get_option('company_name', get_bloginfo('name'));
        $company_logo = ab2b_get_option('company_logo', 'https://theartisan.dk/wp-content/uploads/2024/02/Copenhagen-Large-scaled.png');
        $admin_email = get_option('admin_email');
        $account_name = ab2b_get_option('account_manager_name', '') ?: __('Your account manager', 'artisan-b2b-portal');
        $account_email = ab2b_get_option('account_manager_email', '') ?: $admin_email;
        $account_phone = ab2b_get_option('account_manager_phone', '') ?: '';
        $payment_terms = ab2b_get_option('payment_terms', __('Net 14 days', 'artisan-b2b-portal'));
        $bank_name = ab2b_get_option('bank_name', '');
        $bank_reg = ab2b_get_option('bank_reg_nr', '');
        $bank_account = ab2b_get_option('bank_account_nr', '');
        $company_address = ab2b_get_option('company_address', 'Fredensgade 1, st. 2200 Kbh N');
        $company_cvr = ab2b_get_option('company_cvr', '41 22 62 45');
        $company_contact = ab2b_get_option('company_contact_email', '') ?: $admin_email;
        $company_phone = ab2b_get_option('company_phone', '+45 53 57 58 02');

        $shipping_cost = isset($order->shipping_cost) ? (float) $order->shipping_cost : 0;
        $subtotal = (float) $order->subtotal;
        $delivery_method = isset($order->delivery_method) ? $order->delivery_method : 'shipping';
        $is_international = ($delivery_method === 'international');
        $vat = $is_international ? 0 : (($subtotal + $shipping_cost) * 0.25);
        $total = $subtotal + $shipping_cost + $vat;

        $bill_city_postcode = trim(trim($c->city ?? '') . ', ' . trim($c->postcode ?? ''), ', ');
        $bill_cvr = !empty($c->cvr_number) ? 'CVR: ' . $c->cvr_number : '';
        $address_line = trim(($c->address ?? '') . ($bill_city_postcode ? ', ' . $bill_city_postcode : ''), ', ');
        $billing_parts = array_filter([
            $c->company_name ?? '',
            $bill_cvr,
            $address_line,
        ]);
        $billing_line = implode(' · ', $billing_parts);
        $del_company = $c->delivery_company ?? $c->company_name ?? '';
        $del_contact = $c->delivery_contact ?? $c->contact_name ?? '';
        $del_addr = $c->delivery_address ?? $c->address ?? '';
        $del_city_postcode = trim(trim($c->delivery_city ?? $c->city ?? '') . ', ' . trim($c->delivery_postcode ?? $c->postcode ?? ''), ', ');

        $is_status = ($type === 'status');
        $badge_text = $is_status ? '&#10003;&nbsp; ' . $status_label : '&#10003;&nbsp; Order Confirmed';
        $greeting_name = $c->company_name ?? '';
        $contact_name = $c->contact_name ?: $c->company_name;
        $greeting_body = $is_status
            ? sprintf(__('Hello %s,', 'artisan-b2b-portal'), esc_html($contact_name)) . "\n\n" . $status_message
            : __("We've received your order and it is now being processed. You will receive a separate notification once your order has been dispatched. Please review the details below and contact us if anything requires adjustment.", 'artisan-b2b-portal');

        ob_start();
        ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?php echo $is_status ? esc_attr($status_label) : esc_attr__('Order Confirmation', 'artisan-b2b-portal'); ?> — <?php echo esc_attr($company_name); ?></title>
  <style>
    body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
    img { -ms-interpolation-mode:bicubic; border:0; outline:none; text-decoration:none; }
    body { margin:0!important; padding:0!important; background-color:#eceae6; font-family:'DM Sans',Arial,sans-serif; }
  </style>
</head>
<body style="margin:0;padding:0;background-color:#eceae6;">

<div style="display:none;font-size:1px;color:#eceae6;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;">
  <?php echo esc_html($order->order_number); ?> <?php echo $is_status ? esc_html($status_label) : esc_html__('confirmed — your coffee is being prepared for dispatch.', 'artisan-b2b-portal'); ?>
</div>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#eceae6;">
  <tr><td align="center" style="padding:32px 16px;">

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width:600px;">

      <!-- Header -->
      <tr>
        <td style="background-color:#1a1068;padding:32px 40px 28px;border-radius:4px 4px 0 0;">
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td valign="middle">
                <?php if ($company_logo) : ?>
                <img src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr($company_name); ?>"
                     width="140" style="display:block;width:140px;height:auto;filter:brightness(0) invert(1);" />
                <?php else : ?>
                <span style="font-family:'DM Sans',Arial,sans-serif;font-size:24px;font-weight:600;color:#ffffff;"><?php echo esc_html($company_name); ?></span>
                <?php endif; ?>
              </td>
              <td valign="middle" align="right">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="background-color:#1db8c2;border-radius:3px;padding:7px 16px;">
                      <span style="font-family:'DM Sans',Arial,sans-serif;font-size:11px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:#ffffff;"><?php echo $badge_text; ?></span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr><td style="background-color:#1db8c2;height:4px;font-size:0;line-height:0;">&nbsp;</td></tr>

      <!-- Greeting -->
      <tr>
        <td style="background-color:#ffffff;padding:36px 40px 28px;">
          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:22px;font-weight:500;color:#1a1068;margin:0 0 10px;line-height:1.3;">
            <?php echo $is_status ? esc_html__('Order Update', 'artisan-b2b-portal') : sprintf(esc_html__('Thank you for your order, %s.', 'artisan-b2b-portal'), esc_html($greeting_name)); ?>
          </p>
          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:14px;font-weight:300;color:#555;margin:0;line-height:1.75;">
            <?php echo nl2br(esc_html($greeting_body)); ?>
          </p>
        </td>
      </tr>

      <!-- Order meta + Bill To / Deliver To -->
      <tr>
        <td style="background-color:#ffffff;padding:0 40px 32px;">
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #e4e0d8;border-radius:4px;overflow:hidden;">
            <tr>
              <td width="50%" valign="top" style="padding:18px 22px;border-right:1px solid #e4e0d8;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#1db8c2;margin:0 0 5px;"><?php esc_html_e('Order Number', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:16px;font-weight:600;color:#1a1068;margin:0;">#<?php echo esc_html($order->order_number); ?></p>
              </td>
              <td width="50%" valign="top" style="padding:18px 22px;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#1db8c2;margin:0 0 5px;"><?php esc_html_e('Order Date', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:16px;font-weight:600;color:#1a1068;margin:0;"><?php echo esc_html(date_i18n('l, M j, Y', strtotime($order->created_at))); ?></p>
              </td>
            </tr>
            <tr>
              <td width="50%" valign="top" style="padding:18px 22px;border-top:1px solid #e4e0d8;border-right:1px solid #e4e0d8;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#1db8c2;margin:0 0 5px;"><?php esc_html_e('Bill To', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:500;color:#1a1068;margin:0 0 2px;"><?php echo esc_html($c->company_name ?? ''); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:300;color:#555;margin:0;line-height:1.6;">
                  <?php echo esc_html($c->contact_name ?? ''); ?><br>
                  <?php echo esc_html($c->address ?? ''); ?><br>
                  <?php echo esc_html($bill_city_postcode); ?><br>
                  <?php echo esc_html($bill_cvr); ?>
                </p>
              </td>
              <td width="50%" valign="top" style="padding:18px 22px;border-top:1px solid #e4e0d8;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#1db8c2;margin:0 0 5px;"><?php esc_html_e('Deliver To', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:500;color:#1a1068;margin:0 0 2px;"><?php echo esc_html($del_company); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:300;color:#555;margin:0;line-height:1.6;">
                  <?php echo esc_html($del_contact); ?><br>
                  <?php echo esc_html($del_addr); ?><br>
                  <?php echo esc_html($del_city_postcode); ?>
                </p>
              </td>
            </tr>
          </table>

          <?php if ($billing_line) : ?>
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:16px;background-color:#f9f7f4;border-left:3px solid #1db8c2;border-radius:0 4px 4px 0;">
            <tr>
              <td style="padding:12px 18px;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#1db8c2;margin:0 0 4px;"><?php esc_html_e('Billing', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:400;color:#333;margin:0;line-height:1.5;word-break:break-word;"><?php echo esc_html($billing_line); ?></p>
              </td>
            </tr>
          </table>
          <?php endif; ?>
        </td>
      </tr>

      <!-- Order items -->
      <tr>
        <td style="background-color:#ffffff;padding:0 40px 8px;">
          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#1db8c2;margin:0 0 12px;"><?php esc_html_e('Order Summary', 'artisan-b2b-portal'); ?></p>
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr style="background-color:#1a1068;">
              <td style="padding:11px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:#ffffff;"><?php esc_html_e('Product', 'artisan-b2b-portal'); ?></td>
              <td style="padding:11px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.65);width:100px;"><?php esc_html_e('Weight', 'artisan-b2b-portal'); ?></td>
              <td style="padding:11px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.65);width:52px;text-align:center;"><?php esc_html_e('Qty', 'artisan-b2b-portal'); ?></td>
              <td style="padding:11px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.65);width:76px;text-align:right;"><?php esc_html_e('Unit Price', 'artisan-b2b-portal'); ?></td>
              <td style="padding:11px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.65);width:76px;text-align:right;"><?php esc_html_e('Total', 'artisan-b2b-portal'); ?></td>
            </tr>
            <?php foreach ($order->items as $i => $item) :
              $row_bg = ($i % 2 === 0) ? '#ffffff' : '#f9f7f4';
            ?>
            <tr style="background-color:<?php echo $row_bg; ?>;">
              <td style="padding:14px 14px;border-bottom:1px solid #e4e0d8;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:500;color:#1a1068;margin:0;"><?php echo esc_html($item->product_name); ?></p>
              </td>
              <td style="padding:14px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:300;color:#888;border-bottom:1px solid #e4e0d8;"><?php echo esc_html($item->weight_label); ?></td>
              <td style="padding:14px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:400;color:#333;text-align:center;border-bottom:1px solid #e4e0d8;"><?php echo esc_html($item->quantity); ?></td>
              <td style="padding:14px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:400;color:#333;text-align:right;border-bottom:1px solid #e4e0d8;"><?php echo esc_html(AB2B_Helpers::format_price($item->unit_price)); ?></td>
              <td style="padding:14px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:600;color:#1a1068;text-align:right;border-bottom:1px solid #e4e0d8;"><?php echo esc_html(AB2B_Helpers::format_price($item->line_total)); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr style="background-color:#ffffff;">
              <td colspan="2" style="padding:0;border-top:2px solid #1a1068;"></td>
              <td colspan="3" style="padding:0;border-top:2px solid #1a1068;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td style="padding:10px 14px 4px;font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:300;color:#888;"><?php esc_html_e('Subtotal (excl. VAT)', 'artisan-b2b-portal'); ?></td>
                    <td style="padding:10px 14px 4px;font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:400;color:#333;text-align:right;"><?php echo esc_html(AB2B_Helpers::format_price($subtotal)); ?></td>
                  </tr>
                  <?php if ($vat > 0) : ?>
                  <tr>
                    <td style="padding:4px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:300;color:#888;"><?php esc_html_e('VAT (25%)', 'artisan-b2b-portal'); ?></td>
                    <td style="padding:4px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:400;color:#333;text-align:right;"><?php echo esc_html(AB2B_Helpers::format_price($vat)); ?></td>
                  </tr>
                  <?php else : ?>
                  <tr>
                    <td style="padding:4px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:300;color:#888;"><?php esc_html_e('VAT', 'artisan-b2b-portal'); ?></td>
                    <td style="padding:4px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:400;color:#333;text-align:right;"><?php esc_html_e('Reverse VAT', 'artisan-b2b-portal'); ?></td>
                  </tr>
                  <?php endif; ?>
                  <tr>
                    <td style="padding:4px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:300;color:#888;"><?php esc_html_e('Delivery', 'artisan-b2b-portal'); ?></td>
                    <td style="padding:4px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:400;color:#333;text-align:right;"><?php echo $shipping_cost > 0 ? esc_html(AB2B_Helpers::format_price($shipping_cost)) : esc_html__('Free', 'artisan-b2b-portal'); ?></td>
                  </tr>
                  <tr style="background-color:#1a1068;">
                    <td style="padding:12px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:#ffffff;"><?php esc_html_e('Total', 'artisan-b2b-portal'); ?></td>
                    <td style="padding:12px 14px;font-family:'DM Sans',Arial,sans-serif;font-size:15px;font-weight:700;color:#1db8c2;text-align:right;"><?php echo esc_html(AB2B_Helpers::format_price($total)); ?></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <?php if (!$is_status && ($payment_terms || $bank_name || $bank_reg || $bank_account)) : ?>
      <!-- Payment & Dispatch -->
      <tr>
        <td style="background-color:#ffffff;padding:28px 40px 32px;">
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td width="50%" valign="top" style="padding-right:16px;border-right:1px solid #e4e0d8;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#1db8c2;margin:0 0 8px;"><?php esc_html_e('Payment Terms', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:500;color:#1a1068;margin:0 0 4px;"><?php echo esc_html($payment_terms); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:300;color:#888;margin:0;line-height:1.65;">
                  <?php esc_html_e('Invoice will be issued separately.', 'artisan-b2b-portal'); ?><br>
                  <?php if ($bank_name || $bank_reg || $bank_account) : ?>
                  <?php esc_html_e('Bank:', 'artisan-b2b-portal'); ?> <?php echo esc_html($bank_name); ?><br>
                  <?php if ($bank_reg) : ?>Reg. nr.: <?php echo esc_html($bank_reg); ?><?php endif; ?>
                  <?php if ($bank_reg && $bank_account) : ?> &nbsp;·&nbsp; <?php endif; ?>
                  <?php if ($bank_account) : ?>Konto: <?php echo esc_html($bank_account); ?><?php endif; ?>
                  <?php endif; ?>
                </p>
              </td>
              <td width="50%" valign="top" style="padding-left:16px;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#1db8c2;margin:0 0 8px;"><?php esc_html_e('Estimated Dispatch', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:500;color:#1a1068;margin:0 0 4px;"><?php echo esc_html(date_i18n('l, M j, Y', strtotime($order->delivery_date))); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:12px;font-weight:300;color:#888;margin:0;line-height:1.65;">
                  <?php esc_html_e('Roasted to order. Dispatched every Friday. Tracking info sent separately.', 'artisan-b2b-portal'); ?>
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <?php endif; ?>

      <?php if (!empty($order->special_instructions)) : ?>
      <!-- Order notes -->
      <tr>
        <td style="background-color:#ffffff;padding:0 40px 32px;">
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f9f7f4;border-left:3px solid #1db8c2;border-radius:0 3px 3px 0;">
            <tr>
              <td style="padding:14px 18px;">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:#1db8c2;margin:0 0 5px;"><?php esc_html_e('Order Notes', 'artisan-b2b-portal'); ?></p>
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:300;color:#555;margin:0;line-height:1.7;"><?php echo nl2br(esc_html($order->special_instructions)); ?></p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <?php endif; ?>

      <!-- Contact strip -->
      <tr>
        <td style="background-color:#ffffff;padding:0 40px 36px;">
          <div style="height:1px;background-color:#e4e0d8;margin-bottom:24px;font-size:0;line-height:0;">&nbsp;</div>
          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:300;color:#555;margin:0;line-height:1.8;">
            <?php esc_html_e('Questions about this order? Contact your account manager directly:', 'artisan-b2b-portal'); ?>
          </p>
          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:13px;font-weight:500;color:#1a1068;margin:6px 0 0;">
            <?php echo esc_html($account_name); ?>
            <?php if ($account_email) : ?> &nbsp;&nbsp; <a href="mailto:<?php echo esc_attr($account_email); ?>" style="color:#1db8c2;text-decoration:none;font-weight:400;"><?php echo esc_html($account_email); ?></a><?php endif; ?>
            <?php if ($account_phone) : ?> &nbsp;&nbsp; <a href="tel:<?php echo esc_attr($account_phone); ?>" style="color:#1db8c2;text-decoration:none;font-weight:400;"><?php echo esc_html($account_phone); ?></a><?php endif; ?>
          </p>
        </td>
      </tr>

      <!-- Footer -->
      <tr><td style="background-color:#1db8c2;height:4px;font-size:0;line-height:0;">&nbsp;</td></tr>
      <tr>
        <td style="background-color:#1a1068;padding:24px 40px;border-radius:0 0 4px 4px;">
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td valign="middle">
                <?php if ($company_logo) : ?>
                <img src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr($company_name); ?>" width="100" style="display:block;width:100px;height:auto;filter:brightness(0) invert(1);opacity:.6;" />
                <?php else : ?>
                <span style="font-family:'DM Sans',Arial,sans-serif;font-size:18px;font-weight:600;color:rgba(255,255,255,.6);"><?php echo esc_html($company_name); ?></span>
                <?php endif; ?>
              </td>
              <td valign="middle" align="right">
                <p style="font-family:'DM Sans',Arial,sans-serif;font-size:11px;font-weight:300;color:rgba(255,255,255,.45);margin:0;line-height:1.7;text-align:right;">
                  <?php echo esc_html($company_name); ?> &nbsp;·&nbsp; <?php echo esc_html($company_address); ?><br>
                  <?php if ($company_cvr) : ?>CVR: <?php echo esc_html($company_cvr); ?> &nbsp;·&nbsp; <?php endif; ?>
                  <a href="mailto:<?php echo esc_attr($company_contact); ?>" style="color:rgba(255,255,255,.7);text-decoration:none;"><?php echo esc_html($company_contact); ?></a>
                  <?php if ($company_phone) : ?> &nbsp;·&nbsp; <?php echo esc_html($company_phone); ?><?php endif; ?>
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td style="padding:16px 0 0;text-align:center;">
          <p style="font-family:'DM Sans',Arial,sans-serif;font-size:10px;font-weight:300;color:#aaa;margin:0;line-height:1.6;">
            <?php esc_html_e('This is an automated order confirmation. Please do not reply directly to this email.', 'artisan-b2b-portal'); ?>
            <?php esc_html_e('For support, contact us at', 'artisan-b2b-portal'); ?>
            <a href="mailto:<?php echo esc_attr($company_contact); ?>" style="color:#1db8c2;text-decoration:none;"><?php echo esc_html($company_contact); ?></a>
          </p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
        <?php
        return ob_get_clean();
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
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                    <strong><?php esc_html_e('Delivery Method:', 'artisan-b2b-portal'); ?></strong>
                                    <span style="float: right;">
                                        <?php
                                        $admin_delivery_method = isset($order->delivery_method) ? $order->delivery_method : 'shipping';
                                        echo $admin_delivery_method === 'pickup'
                                            ? esc_html__('Pick up', 'artisan-b2b-portal')
                                            : ($admin_delivery_method === 'international'
                                                ? esc_html__('International', 'artisan-b2b-portal')
                                                : esc_html__('Delivery', 'artisan-b2b-portal'));
                                        ?>
                                    </span>
                                </td>
                            </tr>
                        </table>

                        <?php
                        $c = $order->customer;
                        $bill_city_postcode = trim(trim($c->city ?? '') . ', ' . trim($c->postcode ?? ''), ', ');
                        $bill_lines = array_filter([
                            $c->company_name ?? '',
                            $c->contact_name ?? '',
                            $c->address ?? '',
                            $bill_city_postcode,
                            !empty($c->cvr_number) ? 'CVR: ' . ($c->cvr_number) : '',
                        ]);
                        $admin_address_line = trim(($c->address ?? '') . ($bill_city_postcode ? ', ' . $bill_city_postcode : ''), ', ');
                        $admin_billing_parts = array_filter([
                            $c->company_name ?? '',
                            !empty($c->cvr_number) ? 'CVR: ' . $c->cvr_number : '',
                            $admin_address_line,
                        ]);
                        $admin_billing_line = implode(' · ', $admin_billing_parts);
                        $del_city_postcode = trim(trim($c->delivery_city ?? $c->city ?? '') . ', ' . trim($c->delivery_postcode ?? $c->postcode ?? ''), ', ');
                        $del_lines = array_filter([
                            $c->delivery_company ?? $c->company_name ?? '',
                            $c->delivery_contact ?? $c->contact_name ?? '',
                            $c->delivery_address ?? $c->address ?? '',
                            $del_city_postcode,
                        ]);
                        ?>
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px; background: #f9f9f9; border-radius: 6px; overflow: hidden;">
                            <tr><td colspan="2" style="padding: 8px 12px; background: #eee; font-weight: 600;"><?php esc_html_e('Bill To', 'artisan-b2b-portal'); ?></td></tr>
                            <tr><td colspan="2" style="padding: 10px 12px; line-height: 1.5; white-space: pre-line;"><?php echo esc_html(implode("\n", $bill_lines) ?: '—'); ?></td></tr>
                            <?php if (!empty($admin_billing_line)) : ?>
                            <tr><td colspan="2" style="padding: 6px 12px 10px; border-top: 1px solid #e0e0e0; font-size: 13px; color: #333;"><strong><?php esc_html_e('Billing', 'artisan-b2b-portal'); ?>:</strong> <?php echo esc_html($admin_billing_line); ?></td></tr>
                            <?php endif; ?>
                            <tr><td colspan="2" style="padding: 8px 12px; background: #eee; font-weight: 600;"><?php esc_html_e('Deliver To', 'artisan-b2b-portal'); ?></td></tr>
                            <tr><td colspan="2" style="padding: 10px 12px; line-height: 1.5; white-space: pre-line;"><?php echo esc_html(implode("\n", $del_lines) ?: '—'); ?></td></tr>
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
                                <?php $admin_shipping = isset($order->shipping_cost) ? (float) $order->shipping_cost : 0; ?>
                                <?php if ($admin_shipping > 0) : ?>
                                    <tr>
                                        <td colspan="3" align="right"><?php esc_html_e('Subtotal:', 'artisan-b2b-portal'); ?></td>
                                        <td align="right"><?php echo esc_html(AB2B_Helpers::format_price($order->subtotal)); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right"><?php esc_html_e('Shipping:', 'artisan-b2b-portal'); ?></td>
                                        <td align="right"><?php echo esc_html(AB2B_Helpers::format_price($admin_shipping)); ?></td>
                                    </tr>
                                <?php endif; ?>
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
     * Send status change notification to customer (professional template)
     */
    public static function send_status_notification($order_id, $new_status, $old_status) {
        $notify_statuses = ['confirmed', 'shipped', 'cancelled'];
        if (!in_array($new_status, $notify_statuses)) return;

        $order = AB2B_Order::get($order_id);
        if (!$order || !$order->customer) return;

        $status_label = AB2B_Helpers::get_status_label($new_status);
        $status_messages = [
            'confirmed' => __('Great news! Your order has been confirmed and is being prepared.', 'artisan-b2b-portal'),
            'shipped'   => __('Your order is on its way! It will arrive on the scheduled delivery date.', 'artisan-b2b-portal'),
            'cancelled' => __('Your order has been cancelled. If you have any questions, please contact us.', 'artisan-b2b-portal'),
        ];
        $message_text = $status_messages[$new_status] ?? '';

        $html = self::build_order_email_html($order, 'status', $status_label, $message_text);
        if (empty($html)) return false;

        $company_name = ab2b_get_option('company_name', get_bloginfo('name'));
        $subject = sprintf(__('Order %s — %s', 'artisan-b2b-portal'), $order->order_number, $status_label);

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $company_name . ' <' . get_option('admin_email') . '>',
        ];

        $to = (!empty($order->customer->billing_email) && is_email($order->customer->billing_email))
            ? $order->customer->billing_email
            : $order->customer->email;
        return wp_mail($to, $subject, $html, $headers);
    }

    /**
     * Send notification when customer updates their details
     * Notifies admin and sends confirmation to customer
     */
    public static function send_customer_updated_notification($customer_id, $updated_fields) {
        $customer = AB2B_Customer::get($customer_id);
        if (!$customer) return;

        $company_name = ab2b_get_option('company_name', get_bloginfo('name'));
        $company_logo = ab2b_get_option('company_logo', '');

        $admin_email = get_option('admin_email');

        // Build list of changed fields for admin
        $field_labels = [
            'company_name'      => __('Company Name', 'artisan-b2b-portal'),
            'contact_name'      => __('Contact Name', 'artisan-b2b-portal'),
            'email'             => __('Email', 'artisan-b2b-portal'),
            'billing_email'     => __('Billing Email', 'artisan-b2b-portal'),
            'phone'             => __('Phone', 'artisan-b2b-portal'),
            'address'           => __('Address', 'artisan-b2b-portal'),
            'city'              => __('City', 'artisan-b2b-portal'),
            'postcode'          => __('Postcode', 'artisan-b2b-portal'),
            'cvr_number'        => __('CVR Number', 'artisan-b2b-portal'),
            'delivery_company'  => __('Delivery Company', 'artisan-b2b-portal'),
            'delivery_contact'  => __('Delivery Contact', 'artisan-b2b-portal'),
            'delivery_address'  => __('Delivery Address', 'artisan-b2b-portal'),
            'delivery_city'     => __('Delivery City', 'artisan-b2b-portal'),
            'delivery_postcode' => __('Delivery Postcode', 'artisan-b2b-portal'),
        ];

        $changes_html = '';
        foreach ($updated_fields as $key => $val) {
            $label = $field_labels[$key] ?? $key;
            $changes_html .= '<tr><td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>' . esc_html($label) . ':</strong></td><td style="padding: 8px 0; border-bottom: 1px solid #eee;">' . esc_html($val) . '</td></tr>';
        }

        // Email to admin
        $admin_subject = sprintf(__('[B2B Portal] Customer %s updated their details', 'artisan-b2b-portal'), $customer->company_name);

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
                <tr>
                    <td style="padding: 30px; text-align: center; background: #333;">
                        <h1 style="color: #fff; margin: 0; font-size: 22px;"><?php echo esc_html($company_name); ?></h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px;">
                        <h2 style="margin: 0 0 20px; color: #333;"><?php esc_html_e('Customer Details Updated', 'artisan-b2b-portal'); ?></h2>
                        <p><?php printf(esc_html__('%s has updated their account details in the B2B portal.', 'artisan-b2b-portal'), esc_html($customer->company_name)); ?></p>
                        <table width="100%" cellpadding="0" cellspacing="0" style="background: #f8f8f8; border-radius: 8px; margin-top: 20px;">
                            <?php echo $changes_html; ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px; background: #f8f8f8; text-align: center;">
                        <p style="color: #999; font-size: 12px; margin: 0;">&copy; <?php echo date('Y'); ?> <?php echo esc_html($company_name); ?></p>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        <?php
        $admin_message = ob_get_clean();
        $headers = ['Content-Type: text/html; charset=UTF-8', 'From: ' . $company_name . ' <' . $admin_email . '>'];
        wp_mail($admin_email, $admin_subject, $admin_message, $headers);

        // Confirmation email to customer
        $customer_subject = sprintf(__('Your account details have been updated - %s', 'artisan-b2b-portal'), $company_name);

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
                <tr>
                    <td style="padding: 30px; text-align: center; background: #333;">
                        <h1 style="color: #fff; margin: 0; font-size: 22px;"><?php echo esc_html($company_name); ?></h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px;">
                        <h2 style="margin: 0 0 20px; color: #333;"><?php esc_html_e('Account Updated', 'artisan-b2b-portal'); ?></h2>
                        <p><?php printf(esc_html__('Hello %s,', 'artisan-b2b-portal'), esc_html($customer->contact_name ?: $customer->company_name)); ?></p>
                        <p><?php esc_html_e('This is to confirm that your account details have been successfully updated in our B2B portal.', 'artisan-b2b-portal'); ?></p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px; background: #f8f8f8; text-align: center;">
                        <p style="color: #999; font-size: 12px; margin: 0;">&copy; <?php echo date('Y'); ?> <?php echo esc_html($company_name); ?></p>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        <?php
        $customer_message = ob_get_clean();
        wp_mail($customer->email, $customer_subject, $customer_message, $headers);
    }
}

// Initialize email hooks
AB2B_Email::init();
