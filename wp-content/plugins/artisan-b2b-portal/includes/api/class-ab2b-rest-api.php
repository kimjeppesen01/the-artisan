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
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_customer'],
            'permission_callback' => [$this, 'check_customer_permission'],
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
        ]);

        // Settings (delivery dates)
        register_rest_route($this->namespace, '/settings', [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_settings'],
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
        $products = AB2B_Product::get_all(['is_active' => 1]);

        $data = array_map([$this, 'format_product'], $products);

        return rest_ensure_response($data);
    }

    /**
     * Get single product
     */
    public function get_product($request) {
        $product = AB2B_Product::get($request->get_param('id'));

        if (!$product || !$product->is_active) {
            return new WP_Error(
                'product_not_found',
                __('Product not found.', 'artisan-b2b-portal'),
                ['status' => 404]
            );
        }

        return rest_ensure_response($this->format_product($product));
    }

    /**
     * Format product for API response
     */
    private function format_product($product) {
        $image_url = $product->image_id
            ? wp_get_attachment_image_url($product->image_id, 'medium')
            : null;

        $hover_image_url = $product->hover_image_id
            ? wp_get_attachment_image_url($product->hover_image_id, 'medium')
            : null;

        $image_full = $product->image_id
            ? wp_get_attachment_image_url($product->image_id, 'large')
            : null;

        // Get active weights only
        $weights = [];
        if (!empty($product->weights)) {
            foreach ($product->weights as $weight) {
                if ($weight->is_active) {
                    $weights[] = [
                        'id'           => (int) $weight->id,
                        'label'        => $weight->weight_label,
                        'value'        => (int) $weight->weight_value,
                        'unit'         => $weight->weight_unit,
                        'price'        => (float) $weight->price,
                        'price_formatted' => AB2B_Helpers::format_price($weight->price),
                    ];
                }
            }
        }

        // Calculate price range
        $prices = array_column($weights, 'price');
        $price_min = !empty($prices) ? min($prices) : 0;
        $price_max = !empty($prices) ? max($prices) : 0;

        return [
            'id'                => (int) $product->id,
            'name'              => $product->name,
            'slug'              => $product->slug,
            'description'       => $product->description,
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
        ];
    }

    /**
     * Get current customer info
     */
    public function get_customer($request) {
        $customer = $request->get_param('_customer');

        return rest_ensure_response([
            'id'           => (int) $customer->id,
            'company_name' => $customer->company_name,
            'contact_name' => $customer->contact_name,
            'email'        => $customer->email,
            'phone'        => $customer->phone,
            'address'      => $customer->address,
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

            $order_items[] = [
                'product_id'        => (int) $product->id,
                'product_weight_id' => (int) $weight->id,
                'product_name'      => $product->name,
                'weight_label'      => $weight->weight_label,
                'quantity'          => (int) $item['quantity'],
                'unit_price'        => (float) $weight->price,
            ];
        }

        if (empty($order_items)) {
            return new WP_Error(
                'no_valid_items',
                __('No valid items in order.', 'artisan-b2b-portal'),
                ['status' => 400]
            );
        }

        // Create order
        $order_id = AB2B_Order::create([
            'customer_id'          => $customer->id,
            'delivery_date'        => $delivery_date,
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
     * Format order for API response
     */
    private function format_order($order, $include_items = false) {
        $data = [
            'id'                   => (int) $order->id,
            'order_number'         => $order->order_number,
            'status'               => $order->status,
            'status_label'         => AB2B_Helpers::get_status_label($order->status),
            'status_class'         => AB2B_Helpers::get_status_class($order->status),
            'delivery_date'        => $order->delivery_date,
            'delivery_date_formatted' => date_i18n('l, M j, Y', strtotime($order->delivery_date)),
            'subtotal'             => (float) $order->subtotal,
            'total'                => (float) $order->total,
            'total_formatted'      => AB2B_Helpers::format_price($order->total),
            'created_at'           => $order->created_at,
            'created_at_formatted' => date_i18n('M j, Y H:i', strtotime($order->created_at)),
        ];

        if ($include_items && !empty($order->items)) {
            $data['items'] = array_map(function($item) {
                return [
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
     * Get settings for frontend
     */
    public function get_settings($request) {
        $min_days = ab2b_get_option('min_days_before', 2);

        return rest_ensure_response([
            'min_days_before' => (int) $min_days,
            'next_friday'     => AB2B_Helpers::get_next_friday($min_days),
            'currency_symbol' => ab2b_get_option('currency_symbol', 'kr.'),
        ]);
    }
}
