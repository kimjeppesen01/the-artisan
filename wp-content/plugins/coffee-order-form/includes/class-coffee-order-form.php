<?php
class Coffee_Order_Form {
    
    public function __construct() {
        // Register shortcode
        add_shortcode('coffee_order_form', array($this, 'render_shortcode'));
        
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        
        // Register REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }
    
    /**
     * Render the shortcode
     */
    public function render_shortcode($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'emails' => '',
            'customer_name' => 'Customer',
            'customer_email' => '',
            'edit_key' => 'admin123',
            'products' => 'Product A,Product B,Product C',
            'company_logo' => '',
            'min_days_before' => '2', // Minimum days before delivery
        ), $atts);
        
        // Generate unique ID for this form instance
        $form_id = 'cof-' . uniqid();
        
        // Get current page/post ID for storing data
        $page_id = get_the_ID();
        
        ob_start();
        ?>
        <div id="<?php echo esc_attr($form_id); ?>" 
             class="coffee-order-form-container" 
             data-emails="<?php echo esc_attr($atts['emails']); ?>"
             data-customer="<?php echo esc_attr($atts['customer_name']); ?>"
             data-customer-email="<?php echo esc_attr($atts['customer_email']); ?>"
             data-edit-key="<?php echo esc_attr($atts['edit_key']); ?>"
             data-products="<?php echo esc_attr($atts['products']); ?>"
             data-company-logo="<?php echo esc_attr($atts['company_logo']); ?>"
             data-min-days-before="<?php echo esc_attr($atts['min_days_before']); ?>"
             data-page-id="<?php echo esc_attr($page_id); ?>">
            <!-- Form will be rendered here by JavaScript -->
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Enqueue CSS and JavaScript
     */
    public function enqueue_assets() {
        wp_enqueue_style(
            'coffee-order-form-css',
            COF_PLUGIN_URL . 'assets/css/style.css',
            array(),
            '2.1.0'
        );
        
        wp_enqueue_script(
            'coffee-order-form-js',
            COF_PLUGIN_URL . 'assets/js/form.js',
            array('jquery'),
            '2.1.0',
            true
        );
        
        // Pass REST API URL to JavaScript
        wp_localize_script('coffee-order-form-js', 'cofData', array(
            'restUrl' => rest_url('coffee-order/v1/'),
            'nonce' => wp_create_nonce('wp_rest')
        ));
    }
    
    /**
     * Register REST API endpoints
     */
    public function register_rest_routes() {
        // Submit new order (Table 1)
        register_rest_route('coffee-order/v1', '/submit', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_order_submission'),
            'permission_callback' => '__return_true'
        ));
        
        // Get confirmed orders (Table 2)
        register_rest_route('coffee-order/v1', '/orders/(?P<page_id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_confirmed_orders'),
            'permission_callback' => '__return_true'
        ));
        
        // Update confirmed orders (Table 2 - admin only)
        register_rest_route('coffee-order/v1', '/orders/(?P<page_id>\d+)', array(
            'methods' => 'POST',
            'callback' => array($this, 'update_confirmed_orders'),
            'permission_callback' => '__return_true'
        ));
    }
    
    /**
     * Handle new order submission from Table 1
     */
    public function handle_order_submission($request) {
        $params = $request->get_json_params();
        
        $orders = $params['orders'];
        $emails = $params['emails'];
        $customer = $params['customer'];
        $page_id = $params['page_id'];
        
        // Validate
        if (empty($orders) || empty($emails)) {
            return new WP_Error('missing_data', 'Missing required data', array('status' => 400));
        }
        
        // Send email
        $email_sent = $this->send_order_email($orders, $emails, $customer);
        
        // Save orders to Table 2 (confirmed orders) with Pending status
        $this->add_orders_to_confirmed($page_id, $orders);
        
        if ($email_sent) {
            return array(
                'success' => true, 
                'message' => 'Order submitted successfully! You can see your order in the confirmation table below.'
            );
        } else {
            return new WP_Error('email_failed', 'Order saved but email failed to send', array('status' => 500));
        }
    }
    
    /**
     * Add new orders to confirmed orders table
     */
    private function add_orders_to_confirmed($page_id, $new_orders) {
        // Get existing confirmed orders
        $confirmed_orders = get_post_meta($page_id, '_cof_confirmed_orders', true);
        if (!is_array($confirmed_orders)) {
            $confirmed_orders = array();
        }
        
        // Add new orders with additional fields
        foreach ($new_orders as $order) {
            $confirmed_order = array(
                'id' => uniqid(),
                'order_date' => current_time('Y-m-d'),
                'delivery_date' => $order['delivery_date'],
                'product' => $order['product'],
                'weight' => $order['weight'],
                'amount' => $order['amount'],
                'status' => 'Pending'
            );
            $confirmed_orders[] = $confirmed_order;
        }
        
        // Save back to post meta
        update_post_meta($page_id, '_cof_confirmed_orders', $confirmed_orders);
    }
    
    /**
     * Get confirmed orders for a page
     */
    public function get_confirmed_orders($request) {
        $page_id = $request['page_id'];
        
        $confirmed_orders = get_post_meta($page_id, '_cof_confirmed_orders', true);
        
        if (!is_array($confirmed_orders)) {
            $confirmed_orders = array();
        }
        
        return array(
            'success' => true,
            'orders' => $confirmed_orders
        );
    }
    
    /**
     * Update confirmed orders (admin edit mode)
     */
    public function update_confirmed_orders($request) {
        $params = $request->get_json_params();
        $page_id = $request['page_id'];
        $new_orders = $params['orders'];
        $edit_key = $params['edit_key'];
        $provided_key = $params['provided_key'];
        $customer_email = $params['customer_email'];
        $customer_name = $params['customer_name'];
        $company_logo = $params['company_logo'];
        
        // Verify edit key
        if ($edit_key !== $provided_key) {
            return new WP_Error('unauthorized', 'Invalid edit key', array('status' => 403));
        }
        
        // Get old orders to detect status changes
        $old_orders = get_post_meta($page_id, '_cof_confirmed_orders', true);
        if (!is_array($old_orders)) {
            $old_orders = array();
        }
        
        // Detect newly confirmed orders
        $newly_confirmed = $this->detect_newly_confirmed($old_orders, $new_orders);
        
        // Save new orders
        update_post_meta($page_id, '_cof_confirmed_orders', $new_orders);
        
        // Send notification if there are newly confirmed orders
        if (!empty($newly_confirmed) && !empty($customer_email)) {
            $this->send_confirmation_email($newly_confirmed, $customer_email, $customer_name, $company_logo);
        }
        
        return array(
            'success' => true,
            'message' => 'Orders updated successfully' . (!empty($newly_confirmed) ? ' and customer notified!' : '')
        );
    }
    
    /**
     * Detect which orders changed from Pending to Confirmed
     */
    private function detect_newly_confirmed($old_orders, $new_orders) {
        $newly_confirmed = array();
        
        // Create a map of old orders by ID
        $old_map = array();
        foreach ($old_orders as $old_order) {
            if (isset($old_order['id'])) {
                $old_map[$old_order['id']] = $old_order;
            }
        }
        
        // Check each new order
        foreach ($new_orders as $new_order) {
            $order_id = $new_order['id'];
            
            // If order exists in old orders
            if (isset($old_map[$order_id])) {
                $old_status = $old_map[$order_id]['status'];
                $new_status = $new_order['status'];
                
                // Status changed from Pending to Confirmed
                if ($old_status === 'Pending' && $new_status === 'Confirmed') {
                    $newly_confirmed[] = $new_order;
                }
            }
        }
        
        return $newly_confirmed;
    }
    
    /**
     * Send order email (to admin when customer submits)
     */
    private function send_order_email($orders, $emails, $customer) {
        $email_addresses = array_map('trim', explode(',', $emails));
        
        $subject = 'New Coffee Order from ' . $customer;
        
        // Build email body
        $message = '<html><body style="font-family: Arial, sans-serif;">';
        $message .= '<h2 style="color: #333;">New Coffee Order</h2>';
        $message .= '<p><strong>Customer:</strong> ' . esc_html($customer) . '</p>';
        $message .= '<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;">';
        $message .= '<thead><tr style="background-color: #f0f0f0;">';
        $message .= '<th>Delivery Date</th><th>Product</th><th>Weight</th><th>Amount</th>';
        $message .= '</tr></thead><tbody>';
        
        foreach ($orders as $order) {
            $message .= '<tr>';
            $message .= '<td>' . esc_html($order['delivery_date']) . '</td>';
            $message .= '<td>' . esc_html($order['product']) . '</td>';
            $message .= '<td>' . esc_html($order['weight']) . '</td>';
            $message .= '<td>' . esc_html($order['amount']) . '</td>';
            $message .= '</tr>';
        }
        
        $message .= '</tbody></table>';
        $message .= '</body></html>';
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        return wp_mail($email_addresses, $subject, $message, $headers);
    }
    
    /**
     * Send beautifully styled confirmation email to customer
     */
    private function send_confirmation_email($orders, $customer_email, $customer_name, $company_logo = '') {
        $subject = 'Order Confirmation - Your Coffee Order Has Been Confirmed!';
        
        // Build beautiful HTML email
        $message = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    font-family: Arial, Helvetica, sans-serif;
                    background-color: #f4f4f4;
                }
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                }
                .header {
                    background: linear-gradient(135deg, #228F9F 0%, #274465 100%);
                    padding: 40px 20px;
                    text-align: center;
                }
                .logo {
                    max-width: 200px;
                    height: auto;
                    margin-bottom: 20px;
                }
                .header h1 {
                    color: #ffffff;
                    margin: 0;
                    font-size: 28px;
                    font-weight: bold;
                }
                .content {
                    padding: 40px 30px;
                }
                .greeting {
                    font-size: 18px;
                    color: #333333;
                    margin-bottom: 20px;
                }
                .message-text {
                    font-size: 16px;
                    color: #666666;
                    line-height: 1.6;
                    margin-bottom: 30px;
                }
                .order-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                }
                .order-table thead {
                    background: #667eea;
                }
                .order-table th {
                    color: white;
                    padding: 15px 10px;
                    text-align: left;
                    font-weight: 600;
                    font-size: 14px;
                }
                .order-table td {
                    padding: 15px 10px;
                    border-bottom: 1px solid #e0e0e0;
                    color: #333333;
                    font-size: 14px;
                }
                .order-table tr:last-child td {
                    border-bottom: none;
                }
                .order-table tbody tr:hover {
                    background-color: #f8f9fa;
                }
                .status-badge {
                    display: inline-block;
                    padding: 5px 12px;
                    border-radius: 20px;
                    font-size: 12px;
                    font-weight: bold;
                }
                .status-confirmed {
                    background-color: #d4edda;
                    color: #155724;
                }
                .status-pending {
                    background-color: #fff3cd;
                    color: #856404;
                }
                .footer {
                    background-color: #f8f9fa;
                    padding: 30px;
                    text-align: center;
                    color: #666666;
                    font-size: 14px;
                    border-top: 3px solid #667eea;
                }
                .footer p {
                    margin: 5px 0;
                }
                .highlight-box {
                    background: #f0f7ff;
                    border-left: 4px solid #667eea;
                    padding: 15px;
                    margin: 20px 0;
                    border-radius: 4px;
                }
                .highlight-box p {
                    margin: 0;
                    color: #333333;
                    font-size: 14px;
                }
                @media only screen and (max-width: 600px) {
                    .content {
                        padding: 20px 15px;
                    }
                    .order-table th,
                    .order-table td {
                        padding: 10px 5px;
                        font-size: 12px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">';
        
        // Add logo if provided
        if (!empty($company_logo)) {
            $message .= '<img src="' . esc_url($company_logo) . '" alt="Company Logo" class="logo">';
        }
        
        $message .= '
                    <h1>✓ Order Confirmed</h1>
                </div>
                
                <div class="content">
                    <div class="greeting">
                        Hello ' . esc_html($customer_name) . ',
                    </div>
                    
                    <div class="message-text">
                        Great news! We\'ve confirmed your coffee order. Below are the details of your confirmed items:
                    </div>
                    
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Delivery Date</th>
                                <th>Product</th>
                                <th>Weight</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>';
        
        // Add each order row
        foreach ($orders as $order) {
            $delivery_date = date('M j, Y', strtotime($order['delivery_date']));
            $status_class = $order['status'] === 'Confirmed' ? 'status-confirmed' : 'status-pending';
            
            $message .= '
                            <tr>
                                <td><strong>' . esc_html($delivery_date) . '</strong></td>
                                <td>' . esc_html($order['product']) . '</td>
                                <td>' . esc_html($order['weight']) . '</td>
                                <td>' . esc_html($order['amount']) . '</td>
                                <td><span class="status-badge ' . $status_class . '">' . esc_html($order['status']) . '</span></td>
                            </tr>';
        }
        
        $message .= '
                        </tbody>
                    </table>
                    
                    <div class="highlight-box">
                        <p><strong>📦 What\'s next?</strong> Your order is being prepared and will be delivered on the scheduled date.</p>
                    </div>
                    
                    <div class="message-text">
                        If you have any questions about your order, please don\'t hesitate to contact us.
                    </div>
                    
                    <div class="message-text" style="margin-top: 30px;">
                        Thank you for your business!<br>
                        <strong>The Team</strong>
                    </div>
                </div>
                
                <div class="footer">
                    <p><strong>Order Notification</strong></p>
                    <p>This is an automated confirmation email.</p>
                    <p style="margin-top: 15px; color: #999999; font-size: 12px;">
                        © ' . date('Y') . ' - All rights reserved
                    </p>
                </div>
            </div>
        </body>
        </html>';
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        return wp_mail($customer_email, $subject, $message, $headers);
    }
}