<?php
/**
 * Admin Controller
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Admin {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_init', [$this, 'handle_actions']);
        add_action('admin_notices', [$this, 'admin_notices']);

        // AJAX handlers
        add_action('wp_ajax_ab2b_send_portal_link', [$this, 'ajax_send_portal_link']);
        add_action('wp_ajax_ab2b_regenerate_key', [$this, 'ajax_regenerate_key']);
        add_action('wp_ajax_ab2b_update_order_status', [$this, 'ajax_update_order_status']);
        add_action('wp_ajax_ab2b_delete_item', [$this, 'ajax_delete_item']);
    }

    /**
     * Add admin menu
     */
    public function add_menu() {
        // Main menu
        add_menu_page(
            __('B2B Portal', 'artisan-b2b-portal'),
            __('B2B Portal', 'artisan-b2b-portal'),
            'manage_options',
            'ab2b-dashboard',
            [$this, 'render_dashboard'],
            'dashicons-store',
            30
        );

        // Dashboard submenu
        add_submenu_page(
            'ab2b-dashboard',
            __('Dashboard', 'artisan-b2b-portal'),
            __('Dashboard', 'artisan-b2b-portal'),
            'manage_options',
            'ab2b-dashboard',
            [$this, 'render_dashboard']
        );

        // Orders submenu
        add_submenu_page(
            'ab2b-dashboard',
            __('Orders', 'artisan-b2b-portal'),
            __('Orders', 'artisan-b2b-portal'),
            'manage_options',
            'ab2b-orders',
            [$this, 'render_orders']
        );

        // Customers submenu
        add_submenu_page(
            'ab2b-dashboard',
            __('Customers', 'artisan-b2b-portal'),
            __('Customers', 'artisan-b2b-portal'),
            'manage_options',
            'ab2b-customers',
            [$this, 'render_customers']
        );

        // Products submenu
        add_submenu_page(
            'ab2b-dashboard',
            __('Products', 'artisan-b2b-portal'),
            __('Products', 'artisan-b2b-portal'),
            'manage_options',
            'ab2b-products',
            [$this, 'render_products']
        );

        // Settings submenu
        add_submenu_page(
            'ab2b-dashboard',
            __('Settings', 'artisan-b2b-portal'),
            __('Settings', 'artisan-b2b-portal'),
            'manage_options',
            'ab2b-settings',
            [$this, 'render_settings']
        );
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_assets($hook) {
        // Only load on our pages
        if (strpos($hook, 'ab2b') === false) {
            return;
        }

        wp_enqueue_style(
            'ab2b-admin',
            AB2B_PLUGIN_URL . 'assets/admin/css/admin.css',
            [],
            AB2B_VERSION
        );

        wp_enqueue_script(
            'ab2b-admin',
            AB2B_PLUGIN_URL . 'assets/admin/js/admin.js',
            ['jquery'],
            AB2B_VERSION,
            true
        );

        wp_localize_script('ab2b-admin', 'ab2b_admin', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('ab2b_admin_nonce'),
            'strings'  => [
                'confirm_delete'   => __('Are you sure you want to delete this?', 'artisan-b2b-portal'),
                'confirm_status'   => __('Change order status?', 'artisan-b2b-portal'),
                'link_sent'        => __('Portal link sent successfully!', 'artisan-b2b-portal'),
                'key_regenerated'  => __('Access key regenerated!', 'artisan-b2b-portal'),
                'error'            => __('An error occurred. Please try again.', 'artisan-b2b-portal'),
            ],
        ]);

        // Enqueue media for image uploads
        if (strpos($hook, 'ab2b-products') !== false) {
            wp_enqueue_media();
        }
    }

    /**
     * Handle form actions
     */
    public function handle_actions() {
        if (!isset($_POST['ab2b_action'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['ab2b_nonce'] ?? '', 'ab2b_admin_action')) {
            wp_die(__('Security check failed.', 'artisan-b2b-portal'));
        }

        $action = sanitize_text_field($_POST['ab2b_action']);

        switch ($action) {
            case 'save_customer':
                $this->handle_save_customer();
                break;
            case 'save_product':
                $this->handle_save_product();
                break;
            case 'save_settings':
                $this->handle_save_settings();
                break;
        }
    }

    /**
     * Handle save customer
     */
    private function handle_save_customer() {
        $id = isset($_POST['customer_id']) ? (int) $_POST['customer_id'] : 0;

        $data = [
            'company_name'  => sanitize_text_field($_POST['company_name'] ?? ''),
            'contact_name'  => sanitize_text_field($_POST['contact_name'] ?? ''),
            'email'         => sanitize_email($_POST['email'] ?? ''),
            'phone'         => sanitize_text_field($_POST['phone'] ?? ''),
            'address'       => sanitize_textarea_field($_POST['address'] ?? ''),
            'is_active'     => isset($_POST['is_active']) ? 1 : 0,
            'notes'         => sanitize_textarea_field($_POST['notes'] ?? ''),
        ];

        if ($id > 0) {
            $result = AB2B_Customer::update($id, $data);
            $customer_id = $id;
        } else {
            $result = AB2B_Customer::create($data);
            $customer_id = is_wp_error($result) ? 0 : $result;
        }

        // Save customer products and pricing (only for existing customers)
        if ($customer_id > 0 && !is_wp_error($result)) {
            require_once AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-customer-pricing.php';

            // Process customer products (exclusive assignments)
            if (isset($_POST['customer_products']) && is_array($_POST['customer_products'])) {
                $all_products = AB2B_Product::get_all();
                $all_product_ids = wp_list_pluck($all_products, 'id');

                foreach ($all_product_ids as $product_id) {
                    $product_data = isset($_POST['customer_products'][$product_id]) ? $_POST['customer_products'][$product_id] : null;

                    if ($product_data && !empty($product_data['enabled'])) {
                        // Assign product to customer
                        AB2B_Customer_Pricing::assign_product($customer_id, $product_id, [
                            'custom_name'        => sanitize_text_field($product_data['custom_name'] ?? ''),
                            'custom_description' => '',
                            'is_exclusive'       => !empty($product_data['exclusive']) ? 1 : 0,
                        ]);
                    } else {
                        // Remove product assignment
                        AB2B_Customer_Pricing::remove_product($customer_id, $product_id);
                    }
                }
            }

            // Process customer prices
            if (isset($_POST['customer_prices']) && is_array($_POST['customer_prices'])) {
                foreach ($_POST['customer_prices'] as $weight_id => $price) {
                    $weight_id = (int) $weight_id;
                    if ($price === '' || $price === null) {
                        AB2B_Customer_Pricing::remove_custom_price($customer_id, $weight_id);
                    } else {
                        AB2B_Customer_Pricing::set_custom_price($customer_id, $weight_id, (float) $price);
                    }
                }
            }
        }

        if (is_wp_error($result)) {
            set_transient('ab2b_admin_error', $result->get_error_message(), 30);
        } else {
            set_transient('ab2b_admin_success', __('Customer saved successfully.', 'artisan-b2b-portal'), 30);
        }

        wp_redirect(admin_url('admin.php?page=ab2b-customers'));
        exit;
    }

    /**
     * Handle save product
     */
    private function handle_save_product() {
        $id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

        $data = [
            'name'              => sanitize_text_field($_POST['name'] ?? ''),
            'description'       => wp_kses_post($_POST['description'] ?? ''),
            'short_description' => sanitize_textarea_field($_POST['short_description'] ?? ''),
            'image_id'          => (int) ($_POST['image_id'] ?? 0),
            'hover_image_id'    => (int) ($_POST['hover_image_id'] ?? 0),
            'is_active'         => isset($_POST['is_active']) ? 1 : 0,
            'sort_order'        => (int) ($_POST['sort_order'] ?? 0),
        ];

        // Parse weights
        $weights = [];
        if (!empty($_POST['weights']) && is_array($_POST['weights'])) {
            foreach ($_POST['weights'] as $weight) {
                if (!empty($weight['weight_label']) && isset($weight['price'])) {
                    $weights[] = [
                        'id'            => isset($weight['id']) ? (int) $weight['id'] : 0,
                        'weight_label'  => sanitize_text_field($weight['weight_label']),
                        'weight_value'  => (int) ($weight['weight_value'] ?? 0),
                        'weight_unit'   => sanitize_text_field($weight['weight_unit'] ?? 'g'),
                        'price'         => (float) $weight['price'],
                        'is_active'     => isset($weight['is_active']) ? 1 : 0,
                        'sort_order'    => (int) ($weight['sort_order'] ?? 0),
                    ];
                }
            }
        }
        $data['weights'] = $weights;

        if ($id > 0) {
            $result = AB2B_Product::update($id, $data);
        } else {
            $result = AB2B_Product::create($data);
        }

        if (is_wp_error($result)) {
            set_transient('ab2b_admin_error', $result->get_error_message(), 30);
        } else {
            set_transient('ab2b_admin_success', __('Product saved successfully.', 'artisan-b2b-portal'), 30);
        }

        wp_redirect(admin_url('admin.php?page=ab2b-products'));
        exit;
    }

    /**
     * Handle save settings
     */
    private function handle_save_settings() {
        $settings = [
            'min_days_before'            => (int) ($_POST['min_days_before'] ?? 2),
            'order_notification_email'   => sanitize_email($_POST['order_notification_email'] ?? ''),
            'admin_emails'               => sanitize_textarea_field($_POST['admin_emails'] ?? ''),
            'send_customer_confirmation' => isset($_POST['send_customer_confirmation']) ? '1' : '0',
            'company_name'               => sanitize_text_field($_POST['company_name'] ?? ''),
            'company_logo'               => esc_url_raw($_POST['company_logo'] ?? ''),
            'currency_symbol'            => sanitize_text_field($_POST['currency_symbol'] ?? 'kr.'),
            'currency_position'          => sanitize_text_field($_POST['currency_position'] ?? 'before'),
            'order_prefix'               => sanitize_text_field($_POST['order_prefix'] ?? 'B2B-'),
        ];

        update_option('ab2b_settings', $settings);
        set_transient('ab2b_admin_success', __('Settings saved successfully.', 'artisan-b2b-portal'), 30);

        wp_redirect(admin_url('admin.php?page=ab2b-settings'));
        exit;
    }

    /**
     * Admin notices
     */
    public function admin_notices() {
        $error = get_transient('ab2b_admin_error');
        if ($error) {
            echo '<div class="notice notice-error is-dismissible"><p>' . esc_html($error) . '</p></div>';
            delete_transient('ab2b_admin_error');
        }

        $success = get_transient('ab2b_admin_success');
        if ($success) {
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html($success) . '</p></div>';
            delete_transient('ab2b_admin_success');
        }
    }

    /**
     * Render dashboard
     */
    public function render_dashboard() {
        $stats = [
            'pending_orders'    => AB2B_Order::count(['status' => 'pending']),
            'confirmed_orders'  => AB2B_Order::count(['status' => 'confirmed']),
            'total_customers'   => AB2B_Customer::count(1),
            'total_products'    => AB2B_Product::count(1),
        ];

        $recent_orders = AB2B_Order::get_recent(5);
        $upcoming_deliveries = AB2B_Order::get_upcoming_deliveries(7);

        include AB2B_PLUGIN_DIR . 'includes/admin/views/dashboard.php';
    }

    /**
     * Render orders page
     */
    public function render_orders() {
        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'list';

        if ($action === 'view' && isset($_GET['id'])) {
            $order = AB2B_Order::get((int) $_GET['id']);
            if (!$order) {
                wp_die(__('Order not found.', 'artisan-b2b-portal'));
            }
            include AB2B_PLUGIN_DIR . 'includes/admin/views/orders-view.php';
        } else {
            // List orders
            $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
            $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
            $paged = isset($_GET['paged']) ? (int) $_GET['paged'] : 1;
            $per_page = 20;

            $orders = AB2B_Order::get_all([
                'status'  => $status,
                'search'  => $search,
                'limit'   => $per_page,
                'offset'  => ($paged - 1) * $per_page,
            ]);

            $total = AB2B_Order::count(['status' => $status]);
            $status_counts = AB2B_Order::count_by_status();

            include AB2B_PLUGIN_DIR . 'includes/admin/views/orders-list.php';
        }
    }

    /**
     * Render customers page
     */
    public function render_customers() {
        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'list';

        if ($action === 'edit' || $action === 'add') {
            $customer = null;
            if ($action === 'edit' && isset($_GET['id'])) {
                $customer = AB2B_Customer::get((int) $_GET['id']);
                if (!$customer) {
                    wp_die(__('Customer not found.', 'artisan-b2b-portal'));
                }
            }
            include AB2B_PLUGIN_DIR . 'includes/admin/views/customers-edit.php';
        } else {
            // List customers
            $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
            $paged = isset($_GET['paged']) ? (int) $_GET['paged'] : 1;
            $per_page = 20;

            $customers = AB2B_Customer::get_all([
                'search'  => $search,
                'limit'   => $per_page,
                'offset'  => ($paged - 1) * $per_page,
            ]);

            $total = AB2B_Customer::count();

            include AB2B_PLUGIN_DIR . 'includes/admin/views/customers-list.php';
        }
    }

    /**
     * Render products page
     */
    public function render_products() {
        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'list';

        if ($action === 'edit' || $action === 'add') {
            $product = null;
            if ($action === 'edit' && isset($_GET['id'])) {
                $product = AB2B_Product::get((int) $_GET['id']);
                if (!$product) {
                    wp_die(__('Product not found.', 'artisan-b2b-portal'));
                }
            }
            include AB2B_PLUGIN_DIR . 'includes/admin/views/products-edit.php';
        } else {
            $products = AB2B_Product::get_all();
            include AB2B_PLUGIN_DIR . 'includes/admin/views/products-list.php';
        }
    }

    /**
     * Render settings page
     */
    public function render_settings() {
        $settings = get_option('ab2b_settings', []);
        include AB2B_PLUGIN_DIR . 'includes/admin/views/settings.php';
    }

    /**
     * AJAX: Send portal link
     */
    public function ajax_send_portal_link() {
        check_ajax_referer('ab2b_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => __('Permission denied.', 'artisan-b2b-portal')]);
        }

        $customer_id = isset($_POST['customer_id']) ? (int) $_POST['customer_id'] : 0;
        $customer = AB2B_Customer::get($customer_id);

        if (!$customer) {
            wp_send_json_error(['message' => __('Customer not found.', 'artisan-b2b-portal')]);
        }

        // Send email
        require_once AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-email.php';
        $result = AB2B_Email::send_portal_link($customer);

        if ($result) {
            wp_send_json_success(['message' => __('Portal link sent successfully.', 'artisan-b2b-portal')]);
        } else {
            wp_send_json_error(['message' => __('Failed to send email.', 'artisan-b2b-portal')]);
        }
    }

    /**
     * AJAX: Regenerate access key
     */
    public function ajax_regenerate_key() {
        check_ajax_referer('ab2b_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => __('Permission denied.', 'artisan-b2b-portal')]);
        }

        $customer_id = isset($_POST['customer_id']) ? (int) $_POST['customer_id'] : 0;
        $new_key = AB2B_Customer::regenerate_key($customer_id);

        if (is_wp_error($new_key)) {
            wp_send_json_error(['message' => $new_key->get_error_message()]);
        }

        wp_send_json_success([
            'message'    => __('Access key regenerated.', 'artisan-b2b-portal'),
            'access_key' => $new_key,
            'portal_url' => AB2B_Helpers::get_portal_url($new_key),
        ]);
    }

    /**
     * AJAX: Update order status
     */
    public function ajax_update_order_status() {
        check_ajax_referer('ab2b_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => __('Permission denied.', 'artisan-b2b-portal')]);
        }

        $order_id = isset($_POST['order_id']) ? (int) $_POST['order_id'] : 0;
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';
        $admin_notes = isset($_POST['admin_notes']) ? sanitize_textarea_field($_POST['admin_notes']) : null;

        $result = AB2B_Order::update_status($order_id, $status, $admin_notes);

        if (is_wp_error($result)) {
            wp_send_json_error(['message' => $result->get_error_message()]);
        }

        wp_send_json_success([
            'message' => __('Order status updated.', 'artisan-b2b-portal'),
            'status'  => $status,
            'label'   => AB2B_Helpers::get_status_label($status),
        ]);
    }

    /**
     * AJAX: Delete item
     */
    public function ajax_delete_item() {
        check_ajax_referer('ab2b_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => __('Permission denied.', 'artisan-b2b-portal')]);
        }

        $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

        switch ($type) {
            case 'customer':
                $result = AB2B_Customer::delete($id);
                break;
            case 'product':
                $result = AB2B_Product::delete($id);
                break;
            case 'order':
                $result = AB2B_Order::delete($id);
                break;
            default:
                wp_send_json_error(['message' => __('Invalid item type.', 'artisan-b2b-portal')]);
        }

        if (is_wp_error($result)) {
            wp_send_json_error(['message' => $result->get_error_message()]);
        }

        wp_send_json_success(['message' => __('Item deleted successfully.', 'artisan-b2b-portal')]);
    }
}
