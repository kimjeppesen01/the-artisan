<?php
/**
 * REST API Controller
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Rest_Api {

    private $namespace = 'ab2b/v1';

    /**
     * Constructor
     */
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Register REST routes
     */
    public function register_routes() {
        // Products
        register_rest_route($this->namespace, '/products', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_products'],
            'permission_callback' => [$this, 'check_customer_permission'],
        ]);

        register_rest_route($this->namespace, '/products/(?P<id>\d+)', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_product'],
            'permission_callback' => [$this, 'check_customer_permission'],
            'args'                => [
                'id' => [
                    'required'          => true,
                    'validate_callback' => function($param) {
                        return is_numeric($param);
                    },
                ],
            ],
        ]);

        // Customer info
        register_rest_route($this->namespace, '/customer', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_customer'],
                'permission_callback' => [$this, 'check_customer_permission'],
            ],
            [
                'methods'             => 'PUT',
                'callback'            => [$this, 'update_customer'],
                'permission_callback' => [$this, 'check_customer_permission'],
            ],
        ]);

        // Orders
        register_rest_route($this->namespace, '/orders', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_orders'],
                'permission_callback' => [$this, 'check_customer_permission'],
            ],
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [$this, 'create_order'],
                'permission_callback' => [$this, 'check_customer_permission'],
            ],
        ]);

        register_rest_route($this->namespace, '/orders/(?P<id>\d+)', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_order'],
                'permission_callback' => [$this, 'check_customer_permission'],
                'args'                => [
                    'id' => [
                        'required'          => true,
                        'validate_callback' => function($param) {
                            return is_numeric($param);
                        },
                    ],
                ],
            ],
            [
                'methods'             => 'PUT',
                'callback'            => [$this, 'update_order'],
                'permission_callback' => [$this, 'check_customer_permission'],
                'args'                => [
                    'id' => [
                        'required'          => true,
                        'validate_callback' => function($param) {
                            return is_numeric($param);
                        },
                    ],
                ],
            ],
            [
                'methods'             => 'DELETE',
                'callback'            => [$this, 'delete_order'],
                'permission_callback' => [$this, 'check_customer_permission'],
                'args'                => [
                    'id' => [
                        'required'          => true,
                        'validate_callback' => function($param) {
                            return is_numeric($param);
                        },
                    ],
                ],
            ],
        ]);

        // Settings (delivery dates)
        register_rest_route($this->namespace, '/settings', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_settings'],
            'permission_callback' => [$this, 'check_customer_permission'],
        ]);

        // Categories
        register_rest_route($this->namespace, '/categories', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_categories'],
            'permission_callback' => [$this, 'check_customer_permission'],
        ]);
    }

    /**
     * Check customer permission via access key
     */
    public function check_customer_permission($request) {
        $access_key = $this->get_access_key($request);

        if (!$access_key) {
            return new WP_Error(
                'missing_access_key',
                __('Access key is required.', 'artisan-b2b-portal'),
                ['status' => 401]
            );
        }

        $customer = AB2B_Customer::validate_key($access_key);

        if (!$customer) {
            return new WP_Error(
                'invalid_access_key',
                __('Invalid or expired access key.', 'artisan-b2b-portal'),
                ['status' => 401]
            );
        }

        // Store customer in request for later use
        $request->set_param('_customer', $customer);

        return true;
    }

    /**
     * Get access key from request
     */
    private function get_access_key($request) {
        // Check header first
        $key = $request->get_header('X-AB2B-Access-Key');

        // Fall back to query parameter
        if (!$key) {
            $key = $request->get_param('access_key');
        }

        return sanitize_text_field($key);
    }

    /**
     * Get all active products
     */
    public function get_products($request) {
        $customer = $request->get_param('_customer');
        $all_products = AB2B_Product::get_all(['is_active' => 1]);

        // Filter products based on customer access (exclusivity)
        $products = [];
        foreach ($all_products as $product) {
            if (AB2B_Customer_Pricing::customer_has_product_access($customer->id, $product->id)) {
                $products[] = $product;
            }
        }

        // Get customer's price map and product customizations
        $price_map = AB2B_Customer_Pricing::get_customer_price_map($customer->id);
        $customer_products = AB2B_Customer_Pricing::get_customer_products($customer->id);

        // Index customer products by product_id
        $customer_product_map = [];
        foreach ($customer_products as $cp) {
            $customer_product_map[$cp->product_id] = $cp;
        }

        $data = array_map(function($product) use ($price_map, $customer_product_map) {
            return $this->format_product($product, $price_map, $customer_product_map);
        }, $products);

        return rest_ensure_response($data);
    }

    /**
     * Get single product
     */
    public function get_product($request) {
        $customer = $request->get_param('_customer');
        $product = AB2B_Product::get($request->get_param('id'));

        if (!$product || !$product->is_active) {
            return new WP_Error(
                'product_not_found',
                __('Product not found.', 'artisan-b2b-portal'),
                ['status' => 404]
            );
        }

        // Check if customer has access to this product
        if (!AB2B_Customer_Pricing::customer_has_product_access($customer->id, $product->id)) {
            return new WP_Error(
                'product_not_found',
                __('Product not found.', 'artisan-b2b-portal'),
                ['status' => 404]
            );
        }

        // Get customer's price map and product customizations
        $price_map = AB2B_Customer_Pricing::get_customer_price_map($customer->id);
        $customer_products = AB2B_Customer_Pricing::get_customer_products($customer->id);

        // Index customer products by product_id
        $customer_product_map = [];
        foreach ($customer_products as $cp) {
            $customer_product_map[$cp->product_id] = $cp;
        }

        return rest_ensure_response($this->format_product($product, $price_map, $customer_product_map));
    }

    /**
     * Format product for API response
     */
    private function format_product($product, $price_map = [], $customer_product_map = []) {
        $image_url = $product->image_id
            ? wp_get_attachment_image_url($product->image_id, 'large')
            : null;

        $hover_image_url = $product->hover_image_id
            ? wp_get_attachment_image_url($product->hover_image_id, 'large')
            : null;

        $image_full = $product->image_id
            ? wp_get_attachment_image_url($product->image_id, 'full')
            : null;

        // Check for customer-specific product customizations
        $custom_product = isset($customer_product_map[$product->id]) ? $customer_product_map[$product->id] : null;

        // Use custom name/description if available
        $name = ($custom_product && !empty($custom_product->custom_name))
            ? $custom_product->custom_name
            : $product->name;

        $description = ($custom_product && !empty($custom_product->custom_description))
            ? $custom_product->custom_description
            : $product->description;

        // Get active weights with customer-specific pricing
        $weights = [];
        $has_sale_pricing = false;
        if (!empty($product->weights)) {
            foreach ($product->weights as $weight) {
                if ($weight->is_active) {
                    $original_price = (float) $weight->price;
                    $custom_price = isset($price_map[$weight->id]) ? (float) $price_map[$weight->id] : null;

                    // Use custom price if set, otherwise use original
                    $current_price = ($custom_price !== null) ? $custom_price : $original_price;

                    // Check if this is a sale (custom price lower than original)
                    $is_on_sale = ($custom_price !== null && $custom_price < $original_price);
                    if ($is_on_sale) {
                        $has_sale_pricing = true;
                    }

                    $weight_data = [
                        'id'               => (int) $weight->id,
                        'label'            => $weight->weight_label,
                        'value'            => (int) $weight->weight_value,
                        'unit'             => $weight->weight_unit,
                        'price'            => $current_price,
                        'price_formatted'  => AB2B_Helpers::format_price($current_price),
                        'is_on_sale'       => $is_on_sale,
                    ];

                    // Include original price if on sale
                    if ($is_on_sale) {
                        $weight_data['original_price'] = $original_price;
                        $weight_data['original_price_formatted'] = AB2B_Helpers::format_price($original_price);
                        $weight_data['discount_percent'] = round((($original_price - $custom_price) / $original_price) * 100);
                    }

                    $weights[] = $weight_data;
                }
            }
        }

        // Calculate price range (using customer-specific prices)
        $prices = array_column($weights, 'price');
        $price_min = !empty($prices) ? min($prices) : 0;
        $price_max = !empty($prices) ? max($prices) : 0;

        return [
            'id'                => (int) $product->id,
            'name'              => $name,
            'slug'              => $product->slug,
            'description'       => $description,
            'short_description' => $product->short_description,
            'image'             => $image_url,
            'image_full'        => $image_full,
            'hover_image'       => $hover_image_url,
            'weights'           => $weights,
            'price_min'         => $price_min,
            'price_max'         => $price_max,
            'price_range'       => $price_min === $price_max
                ? AB2B_Helpers::format_price($price_min)
                : AB2B_Helpers::format_price($price_min) . ' - ' . AB2B_Helpers::format_price($price_max),
            'has_sale_pricing'  => $has_sale_pricing,
            'is_exclusive'      => ($custom_product && $custom_product->is_exclusive) ? true : false,
            'categories'        => $this->get_product_category_ids($product->id),
        ];
    }

    /**
     * Get category IDs for a product
     */
    private function get_product_category_ids($product_id) {
        require_once AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-category.php';
        return array_map('intval', AB2B_Category::get_product_category_ids($product_id));
    }

    /**
     * Get current customer info
     */
    public function get_customer($request) {
        $customer = $request->get_param('_customer');

        return rest_ensure_response([
            'id'                 => (int) $customer->id,
            'company_name'       => $customer->company_name,
            'contact_name'       => $customer->contact_name,
            'email'              => $customer->email,
            'phone'              => $customer->phone,
            'address'            => $customer->address ?? '',
            'city'               => $customer->city ?? '',
            'postcode'           => $customer->postcode ?? '',
            'cvr_number'         => $customer->cvr_number ?? '',
            'delivery_company'   => $customer->delivery_company ?? '',
            'delivery_contact'   => $customer->delivery_contact ?? '',
            'delivery_address'   => $customer->delivery_address ?? '',
            'delivery_city'      => $customer->delivery_city ?? '',
            'delivery_postcode'  => $customer->delivery_postcode ?? '',
        ]);
    }

    /**
     * Update current customer (self-service from portal)
     */
    public function update_customer($request) {
        $customer = $request->get_param('_customer');
        $body = $request->get_json_params() ?: $request->get_body_params();

        $allowed = [
            'company_name', 'contact_name', 'email', 'phone',
            'address', 'city', 'postcode', 'cvr_number',
            'delivery_company', 'delivery_contact', 'delivery_address',
            'delivery_city', 'delivery_postcode',
        ];
        $data = [];
        foreach ($allowed as $key) {
            if (isset($body[$key])) {
                if (in_array($key, ['address', 'delivery_address'])) {
                    $data[$key] = sanitize_textarea_field($body[$key]);
                } else {
                    $data[$key] = sanitize_text_field($body[$key]);
                }
            }
        }
        if (isset($data['email']) && !is_email($data['email'])) {
            return new WP_Error('invalid_email', __('Invalid email address.', 'artisan-b2b-portal'), ['status' => 400]);
        }

        if (empty($data)) {
            return new WP_Error('no_changes', __('No valid fields to update.', 'artisan-b2b-portal'), ['status' => 400]);
        }

        $result = AB2B_Customer::update($customer->id, $data);

        if (is_wp_error($result)) {
            return $result;
        }

        $updated = AB2B_Customer::get($customer->id);
        return rest_ensure_response([
            'success' => true,
            'message' => __('Your details have been updated.', 'artisan-b2b-portal'),
            'customer' => [
                'id'                 => (int) $updated->id,
                'company_name'       => $updated->company_name,
                'contact_name'       => $updated->contact_name,
                'email'              => $updated->email,
                'phone'              => $updated->phone,
                'address'            => $updated->address ?? '',
                'city'               => $updated->city ?? '',
                'postcode'           => $updated->postcode ?? '',
                'cvr_number'         => $updated->cvr_number ?? '',
                'delivery_company'   => $updated->delivery_company ?? '',
                'delivery_contact'   => $updated->delivery_contact ?? '',
                'delivery_address'   => $updated->delivery_address ?? '',
                'delivery_city'      => $updated->delivery_city ?? '',
                'delivery_postcode'  => $updated->delivery_postcode ?? '',
            ],
        ]);
    }

    /**
     * Get customer orders
     */
    public function get_orders($request) {
        $customer = $request->get_param('_customer');

        $orders = AB2B_Order::get_by_customer($customer->id, [
            'include_items' => true,
            'limit'         => 50,
        ]);

        $data = array_map([$this, 'format_order'], $orders);

        return rest_ensure_response($data);
    }

    /**
     * Get single order
     */
    public function get_order($request) {
        $customer = $request->get_param('_customer');
        $order = AB2B_Order::get($request->get_param('id'));

        if (!$order || $order->customer_id != $customer->id) {
            return new WP_Error(
                'order_not_found',
                __('Order not found.', 'artisan-b2b-portal'),
                ['status' => 404]
            );
        }

        return rest_ensure_response($this->format_order($order, true));
    }

    /**
     * Create new order
     */
    public function create_order($request) {
        $customer = $request->get_param('_customer');
        $items = $request->get_param('items');
        $delivery_date = sanitize_text_field($request->get_param('delivery_date'));
        $special_instructions = sanitize_textarea_field($request->get_param('special_instructions'));

        // Validate items
        if (empty($items) || !is_array($items)) {
            return new WP_Error(
                'invalid_items',
                __('Order items are required.', 'artisan-b2b-portal'),
                ['status' => 400]
            );
        }

        // Get customer's price map and product customizations
        $price_map = AB2B_Customer_Pricing::get_customer_price_map($customer->id);
        $customer_products = AB2B_Customer_Pricing::get_customer_products($customer->id);

        // Index customer products by product_id
        $customer_product_map = [];
        foreach ($customer_products as $cp) {
            $customer_product_map[$cp->product_id] = $cp;
        }

        // Validate and format items
        $order_items = [];
        foreach ($items as $item) {
            if (empty($item['product_id']) || empty($item['weight_id']) || empty($item['quantity'])) {
                continue;
            }

            $product = AB2B_Product::get($item['product_id']);
            $weight = AB2B_Product::get_weight($item['weight_id']);

            if (!$product || !$weight || $weight->product_id != $product->id) {
                continue;
            }

            // Check if customer has access to this product
            if (!AB2B_Customer_Pricing::customer_has_product_access($customer->id, $product->id)) {
                continue;
            }

            // Use customer-specific price if available
            $unit_price = isset($price_map[$weight->id])
                ? (float) $price_map[$weight->id]
                : (float) $weight->price;

            // Use custom product name if available
            $product_name = (isset($customer_product_map[$product->id]) && !empty($customer_product_map[$product->id]->custom_name))
                ? $customer_product_map[$product->id]->custom_name
                : $product->name;

            $order_items[] = [
                'product_id'        => (int) $product->id,
                'product_weight_id' => (int) $weight->id,
                'product_name'      => $product_name,
                'weight_label'      => $weight->weight_label,
                'quantity'          => (int) $item['quantity'],
                'unit_price'        => $unit_price,
            ];
        }

        if (empty($order_items)) {
            return new WP_Error(
                'no_valid_items',
                __('No valid items in order.', 'artisan-b2b-portal'),
                ['status' => 400]
            );
        }

        // Delivery method
        $delivery_method = sanitize_text_field($request->get_param('delivery_method'));
        if (!in_array($delivery_method, ['shipping', 'international', 'pickup'])) {
            $delivery_method = 'shipping';
        }

        // Create order
        $order_id = AB2B_Order::create([
            'customer_id'          => $customer->id,
            'delivery_date'        => $delivery_date,
            'delivery_method'      => $delivery_method,
            'special_instructions' => $special_instructions,
            'items'                => $order_items,
        ]);

        if (is_wp_error($order_id)) {
            return $order_id;
        }

        $order = AB2B_Order::get($order_id);

        return rest_ensure_response([
            'success' => true,
            'message' => __('Order placed successfully!', 'artisan-b2b-portal'),
            'order'   => $this->format_order($order, true),
        ]);
    }

    /**
     * Update pending order
     */
    public function update_order($request) {
        $customer = $request->get_param('_customer');
        $order_id = (int) $request->get_param('id');
        $order = AB2B_Order::get($order_id);

        if (!$order || $order->customer_id != $customer->id) {
            return new WP_Error(
                'order_not_found',
                __('Order not found.', 'artisan-b2b-portal'),
                ['status' => 404]
            );
        }

        $items = $request->get_param('items');
        $delivery_date = sanitize_text_field($request->get_param('delivery_date'));
        $delivery_method = sanitize_text_field($request->get_param('delivery_method'));
        $special_instructions = sanitize_textarea_field($request->get_param('special_instructions'));

        if (empty($items) || !is_array($items)) {
            return new WP_Error(
                'invalid_items',
                __('Order items are required.', 'artisan-b2b-portal'),
                ['status' => 400]
            );
        }

        $price_map = AB2B_Customer_Pricing::get_customer_price_map($customer->id);
        $customer_products = AB2B_Customer_Pricing::get_customer_products($customer->id);
        $customer_product_map = [];
        foreach ($customer_products as $cp) {
            $customer_product_map[$cp->product_id] = $cp;
        }

        $order_items = [];
        foreach ($items as $item) {
            if (empty($item['product_id']) || empty($item['weight_id']) || empty($item['quantity'])) {
                continue;
            }

            $product = AB2B_Product::get($item['product_id']);
            $weight = AB2B_Product::get_weight($item['weight_id']);

            if (!$product || !$weight || $weight->product_id != $product->id) {
                continue;
            }

            if (!AB2B_Customer_Pricing::customer_has_product_access($customer->id, $product->id)) {
                continue;
            }

            $unit_price = isset($price_map[$weight->id])
                ? (float) $price_map[$weight->id]
                : (float) $weight->price;

            $product_name = (isset($customer_product_map[$product->id]) && !empty($customer_product_map[$product->id]->custom_name))
                ? $customer_product_map[$product->id]->custom_name
                : $product->name;

            $order_items[] = [
                'product_id'        => (int) $product->id,
                'product_weight_id' => (int) $weight->id,
                'product_name'      => $product_name,
                'weight_label'      => $weight->weight_label,
                'quantity'          => (int) $item['quantity'],
                'unit_price'        => $unit_price,
            ];
        }

        if (empty($order_items)) {
            return new WP_Error(
                'no_valid_items',
                __('No valid items in order.', 'artisan-b2b-portal'),
                ['status' => 400]
            );
        }

        if (!in_array($delivery_method, ['shipping', 'international', 'pickup'])) {
            $delivery_method = 'shipping';
        }

        $result = AB2B_Order::update_full($order_id, [
            'items'                => $order_items,
            'delivery_date'        => $delivery_date,
            'delivery_method'      => $delivery_method,
            'special_instructions' => $special_instructions,
        ]);

        if (is_wp_error($result)) {
            return $result;
        }

        $order = AB2B_Order::get($order_id);

        return rest_ensure_response([
            'success' => true,
            'message' => __('Order updated successfully!', 'artisan-b2b-portal'),
            'order'   => $this->format_order($order, true),
        ]);
    }

    /**
     * Delete/cancel pending order
     */
    public function delete_order($request) {
        $customer = $request->get_param('_customer');
        $order_id = (int) $request->get_param('id');
        $order = AB2B_Order::get($order_id);

        if (!$order || $order->customer_id != $customer->id) {
            return new WP_Error(
                'order_not_found',
                __('Order not found.', 'artisan-b2b-portal'),
                ['status' => 404]
            );
        }

        if ($order->status !== 'pending') {
            return new WP_Error(
                'order_confirmed',
                __('Only pending orders can be deleted.', 'artisan-b2b-portal'),
                ['status' => 400]
            );
        }

        $result = AB2B_Order::cancel($order_id);

        if (is_wp_error($result)) {
            return $result;
        }

        return rest_ensure_response([
            'success' => true,
            'message' => __('Order deleted.', 'artisan-b2b-portal'),
        ]);
    }

    /**
     * Format order for API response
     */
    private function format_order($order, $include_items = false) {
        $delivery_method = isset($order->delivery_method) ? $order->delivery_method : 'shipping';
        $shipping_cost = isset($order->shipping_cost) ? (float) $order->shipping_cost : 0;

        $data = [
            'id'                   => (int) $order->id,
            'order_number'         => $order->order_number,
            'status'               => $order->status,
            'status_label'         => AB2B_Helpers::get_status_label($order->status),
            'status_class'         => AB2B_Helpers::get_status_class($order->status),
            'delivery_date'        => $order->delivery_date,
            'delivery_date_formatted' => date_i18n('l, M j, Y', strtotime($order->delivery_date)),
            'delivery_method'      => $delivery_method,
            'delivery_method_label' => $this->get_delivery_method_label($delivery_method),
            'shipping_cost'        => $shipping_cost,
            'shipping_cost_formatted' => AB2B_Helpers::format_price($shipping_cost),
            'subtotal'             => (float) $order->subtotal,
            'subtotal_formatted'   => AB2B_Helpers::format_price($order->subtotal),
            'total'                => (float) $order->total,
            'total_formatted'      => AB2B_Helpers::format_price($order->total),
            'created_at'           => $order->created_at,
            'created_at_formatted' => date_i18n('M j, Y H:i', strtotime($order->created_at)),
        ];

        if ($include_items && !empty($order->items)) {
            $data['items'] = array_map(function($item) {
                return [
                    'product_id'     => (int) $item->product_id,
                    'weight_id'      => (int) $item->product_weight_id,
                    'product_name'   => $item->product_name,
                    'weight_label'   => $item->weight_label,
                    'quantity'       => (int) $item->quantity,
                    'unit_price'     => (float) $item->unit_price,
                    'line_total'     => (float) $item->line_total,
                    'unit_price_formatted' => AB2B_Helpers::format_price($item->unit_price),
                    'line_total_formatted' => AB2B_Helpers::format_price($item->line_total),
                ];
            }, $order->items);

            $data['special_instructions'] = $order->special_instructions;
        }

        return $data;
    }

    /**
     * Get human-readable delivery method label
     */
    private function get_delivery_method_label($method) {
        switch ($method) {
            case 'pickup':
                return __('Pick up', 'artisan-b2b-portal');
            case 'international':
                return __('International', 'artisan-b2b-portal');
            case 'shipping':
            default:
                return __('Delivery', 'artisan-b2b-portal');
        }
    }

    /**
     * Get active categories
     */
    public function get_categories($request) {
        require_once AB2B_PLUGIN_DIR . 'includes/core/class-ab2b-category.php';
        $categories = AB2B_Category::get_active_categories();

        $data = array_map(function($cat) {
            return [
                'id'   => (int) $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
            ];
        }, $categories);

        return rest_ensure_response($data);
    }

    /**
     * Get settings for frontend
     */
    public function get_settings($request) {
        $min_days = ab2b_get_option('min_days_before', 2);

        return rest_ensure_response([
            'min_days_before'        => (int) $min_days,
            'next_friday'            => AB2B_Helpers::get_next_friday($min_days),
            'currency_symbol'        => ab2b_get_option('currency_symbol', 'kr.'),
            'shipping_domestic'      => (float) ab2b_get_option('shipping_domestic', 100),
            'shipping_international' => (float) ab2b_get_option('shipping_international', 125),
            'shipping_international_7kg' => (float) ab2b_get_option('shipping_international_7kg', 190),
            'weight_threshold_kg'    => (float) ab2b_get_option('weight_threshold_kg', 7),
        ]);
    }
}
