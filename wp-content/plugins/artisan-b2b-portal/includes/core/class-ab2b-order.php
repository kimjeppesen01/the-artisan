<?php
/**
 * Order Model
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Order {

    private static $table = 'ab2b_orders';
    private static $items_table = 'ab2b_order_items';

    /**
     * Get order by ID
     */
    public static function get($id, $include_items = true) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $order = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE id = %d",
            $id
        ));

        if ($order) {
            if ($include_items) {
                $order->items = self::get_items($id);
            }
            // Get customer info
            $order->customer = AB2B_Customer::get($order->customer_id);
        }

        return $order;
    }

    /**
     * Get order by order number
     */
    public static function get_by_number($order_number) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $order = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE order_number = %s",
            $order_number
        ));

        if ($order) {
            $order->items = self::get_items($order->id);
            $order->customer = AB2B_Customer::get($order->customer_id);
        }

        return $order;
    }

    /**
     * Get all orders
     */
    public static function get_all($args = []) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        $customers_table = $wpdb->prefix . 'ab2b_customers';

        $defaults = [
            'orderby'       => 'created_at',
            'order'         => 'DESC',
            'limit'         => 20,
            'offset'        => 0,
            'status'        => '',
            'customer_id'   => 0,
            'date_from'     => '',
            'date_to'       => '',
            'search'        => '',
            'include_items' => false,
        ];

        $args = wp_parse_args($args, $defaults);

        $where = [];
        $values = [];

        if (!empty($args['status'])) {
            if (is_array($args['status'])) {
                $placeholders = implode(',', array_fill(0, count($args['status']), '%s'));
                $where[] = "o.status IN ({$placeholders})";
                $values = array_merge($values, $args['status']);
            } else {
                $where[] = 'o.status = %s';
                $values[] = $args['status'];
            }
        }

        if (!empty($args['customer_id'])) {
            $where[] = 'o.customer_id = %d';
            $values[] = (int) $args['customer_id'];
        }

        if (!empty($args['date_from'])) {
            $where[] = 'o.created_at >= %s';
            $values[] = $args['date_from'] . ' 00:00:00';
        }

        if (!empty($args['date_to'])) {
            $where[] = 'o.created_at <= %s';
            $values[] = $args['date_to'] . ' 23:59:59';
        }

        if (!empty($args['search'])) {
            $where[] = '(o.order_number LIKE %s OR c.company_name LIKE %s)';
            $search = '%' . $wpdb->esc_like($args['search']) . '%';
            $values[] = $search;
            $values[] = $search;
        }

        $where_sql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $orderby = sanitize_sql_orderby('o.' . $args['orderby'] . ' ' . $args['order']) ?: 'o.created_at DESC';

        $limit_sql = '';
        if ($args['limit'] > 0) {
            $limit_sql = $wpdb->prepare(' LIMIT %d OFFSET %d', $args['limit'], $args['offset']);
        }

        $sql = "SELECT o.*, c.company_name, c.contact_name, c.email as customer_email
                FROM {$table} o
                LEFT JOIN {$customers_table} c ON o.customer_id = c.id
                {$where_sql}
                ORDER BY {$orderby}{$limit_sql}";

        if (!empty($values)) {
            $sql = $wpdb->prepare($sql, $values);
        }

        $orders = $wpdb->get_results($sql);

        if ($args['include_items'] && !empty($orders)) {
            $order_ids = wp_list_pluck($orders, 'id');
            $all_items = self::get_items_for_orders($order_ids);

            foreach ($orders as &$order) {
                $order->items = isset($all_items[$order->id]) ? $all_items[$order->id] : [];
            }
        }

        return $orders;
    }

    /**
     * Get orders for customer
     */
    public static function get_by_customer($customer_id, $args = []) {
        $args['customer_id'] = $customer_id;
        return self::get_all($args);
    }

    /**
     * Count orders
     */
    public static function count($args = []) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $where = [];
        $values = [];

        if (!empty($args['status'])) {
            $where[] = 'status = %s';
            $values[] = $args['status'];
        }

        if (!empty($args['customer_id'])) {
            $where[] = 'customer_id = %d';
            $values[] = (int) $args['customer_id'];
        }

        $where_sql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = "SELECT COUNT(*) FROM {$table} {$where_sql}";

        if (!empty($values)) {
            return (int) $wpdb->get_var($wpdb->prepare($sql, $values));
        }

        return (int) $wpdb->get_var($sql);
    }

    /**
     * Count orders by status
     */
    public static function count_by_status() {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $results = $wpdb->get_results(
            "SELECT status, COUNT(*) as count FROM {$table} GROUP BY status"
        );

        $counts = [
            'pending'   => 0,
            'confirmed' => 0,
            'shipped'   => 0,
            'completed' => 0,
            'cancelled' => 0,
        ];

        foreach ($results as $row) {
            $counts[$row->status] = (int) $row->count;
        }

        return $counts;
    }

    /**
     * Create order
     */
    public static function create($data) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        // Validate required fields
        if (empty($data['customer_id']) || empty($data['delivery_date']) || empty($data['items'])) {
            return new WP_Error('missing_fields', __('Customer, delivery date, and items are required.', 'artisan-b2b-portal'));
        }

        // Validate customer exists
        $customer = AB2B_Customer::get($data['customer_id']);
        if (!$customer) {
            return new WP_Error('invalid_customer', __('Invalid customer.', 'artisan-b2b-portal'));
        }

        // Validate delivery date
        $min_days = ab2b_get_option('min_days_before', 2);
        if (!AB2B_Helpers::is_valid_friday($data['delivery_date'], $min_days)) {
            return new WP_Error('invalid_date', __('Invalid delivery date. Must be a Friday with sufficient lead time.', 'artisan-b2b-portal'));
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($data['items'] as $item) {
            $line_total = (float) $item['unit_price'] * (int) $item['quantity'];
            $subtotal += $line_total;
        }

        // Delivery method and shipping cost
        $delivery_method = isset($data['delivery_method']) ? sanitize_text_field($data['delivery_method']) : 'shipping';
        if (!in_array($delivery_method, ['shipping', 'international', 'pickup'])) {
            $delivery_method = 'shipping';
        }
        $shipping_cost = self::calculate_shipping_cost($delivery_method, $data['items']);
        $total = $subtotal + $shipping_cost;

        // Generate order number
        $order_number = AB2B_Helpers::generate_order_number();

        // Create order
        $result = $wpdb->insert($table, [
            'order_number'          => $order_number,
            'customer_id'           => (int) $data['customer_id'],
            'status'                => 'pending',
            'delivery_date'         => $data['delivery_date'],
            'delivery_method'       => $delivery_method,
            'shipping_cost'         => $shipping_cost,
            'special_instructions'  => isset($data['special_instructions']) ? sanitize_textarea_field($data['special_instructions']) : '',
            'subtotal'              => $subtotal,
            'total'                 => $total,
            'admin_notes'           => '',
        ], ['%s', '%d', '%s', '%s', '%s', '%f', '%s', '%f', '%f', '%s']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to create order.', 'artisan-b2b-portal'));
        }

        $order_id = $wpdb->insert_id;

        // Add order items
        foreach ($data['items'] as $item) {
            self::add_item($order_id, $item);
        }

        // Trigger order created action
        do_action('ab2b_order_created', $order_id);

        return $order_id;
    }

    /**
     * Calculate shipping cost from delivery method and items
     */
    public static function calculate_shipping_cost($delivery_method, $items) {
        if ($delivery_method === 'pickup') {
            return 0.00;
        }

        $domestic = (float) ab2b_get_option('shipping_domestic', 100);
        $international = (float) ab2b_get_option('shipping_international', 125);
        $international_7kg = (float) ab2b_get_option('shipping_international_7kg', 190);
        $threshold = (float) ab2b_get_option('weight_threshold_kg', 7);

        if ($delivery_method === 'shipping') {
            return $domestic;
        }

        if ($delivery_method === 'international') {
            $total_kg = 0;
            foreach ($items as $item) {
                $weight = AB2B_Product::get_weight($item['product_weight_id']);
                if (!$weight) continue;
                $val = (float) ($weight->weight_value ?? 0) * (int) ($item['quantity'] ?? 1);
                $unit = strtolower($weight->weight_unit ?? 'g');
                if ($unit === 'kg') {
                    $total_kg += $val;
                } elseif ($unit === 'g') {
                    $total_kg += $val / 1000;
                }
            }
            return $total_kg >= $threshold ? $international_7kg : $international;
        }

        return $domestic;
    }

    /**
     * Update order status
     */
    public static function update_status($id, $new_status, $admin_notes = null) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $valid_statuses = ['pending', 'confirmed', 'shipped', 'completed', 'cancelled'];
        if (!in_array($new_status, $valid_statuses)) {
            return new WP_Error('invalid_status', __('Invalid order status.', 'artisan-b2b-portal'));
        }

        $order = self::get($id, false);
        if (!$order) {
            return new WP_Error('not_found', __('Order not found.', 'artisan-b2b-portal'));
        }

        $old_status = $order->status;

        $update_data = ['status' => $new_status];
        $format = ['%s'];

        if ($admin_notes !== null) {
            $update_data['admin_notes'] = sanitize_textarea_field($admin_notes);
            $format[] = '%s';
        }

        $result = $wpdb->update($table, $update_data, ['id' => $id], $format, ['%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to update order status.', 'artisan-b2b-portal'));
        }

        // Trigger status change action
        do_action('ab2b_order_status_changed', $id, $new_status, $old_status);

        return true;
    }

    /**
     * Update order
     */
    public static function update($id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $order = self::get($id, false);
        if (!$order) {
            return new WP_Error('not_found', __('Order not found.', 'artisan-b2b-portal'));
        }

        $update_data = [];
        $format = [];

        if (isset($data['delivery_date'])) {
            $update_data['delivery_date'] = $data['delivery_date'];
            $format[] = '%s';
        }

        if (isset($data['special_instructions'])) {
            $update_data['special_instructions'] = sanitize_textarea_field($data['special_instructions']);
            $format[] = '%s';
        }

        if (isset($data['admin_notes'])) {
            $update_data['admin_notes'] = sanitize_textarea_field($data['admin_notes']);
            $format[] = '%s';
        }

        if (!empty($update_data)) {
            $result = $wpdb->update($table, $update_data, ['id' => $id], $format, ['%d']);

            if ($result === false) {
                return new WP_Error('db_error', __('Failed to update order.', 'artisan-b2b-portal'));
            }
        }

        return true;
    }

    /**
     * Delete order
     */
    public static function delete($id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        $items_table = $wpdb->prefix . self::$items_table;

        // Delete items first
        $wpdb->delete($items_table, ['order_id' => $id], ['%d']);

        // Delete order
        $result = $wpdb->delete($table, ['id' => $id], ['%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to delete order.', 'artisan-b2b-portal'));
        }

        return true;
    }

    /**
     * Get order items
     */
    public static function get_items($order_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$items_table;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$table} WHERE order_id = %d",
            $order_id
        ));
    }

    /**
     * Get items for multiple orders
     */
    public static function get_items_for_orders($order_ids) {
        global $wpdb;
        $table = $wpdb->prefix . self::$items_table;

        if (empty($order_ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($order_ids), '%d'));
        $sql = $wpdb->prepare(
            "SELECT * FROM {$table} WHERE order_id IN ({$placeholders})",
            $order_ids
        );

        $all_items = $wpdb->get_results($sql);

        // Group by order_id
        $grouped = [];
        foreach ($all_items as $item) {
            if (!isset($grouped[$item->order_id])) {
                $grouped[$item->order_id] = [];
            }
            $grouped[$item->order_id][] = $item;
        }

        return $grouped;
    }

    /**
     * Add item to order
     */
    private static function add_item($order_id, $item) {
        global $wpdb;
        $table = $wpdb->prefix . self::$items_table;

        $line_total = (float) $item['unit_price'] * (int) $item['quantity'];

        return $wpdb->insert($table, [
            'order_id'          => (int) $order_id,
            'product_id'        => (int) $item['product_id'],
            'product_weight_id' => (int) $item['product_weight_id'],
            'product_name'      => sanitize_text_field($item['product_name']),
            'weight_label'      => sanitize_text_field($item['weight_label']),
            'quantity'          => (int) $item['quantity'],
            'unit_price'        => (float) $item['unit_price'],
            'line_total'        => $line_total,
        ], ['%d', '%d', '%d', '%s', '%s', '%d', '%f', '%f']);
    }

    /**
     * Get single order item
     */
    public static function get_item($item_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$items_table;

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE id = %d",
            $item_id
        ));
    }

    /**
     * Update order item
     */
    public static function update_item($item_id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . self::$items_table;

        $item = self::get_item($item_id);
        if (!$item) {
            return new WP_Error('not_found', __('Order item not found.', 'artisan-b2b-portal'));
        }

        $update_data = [];
        $format = [];

        if (isset($data['product_name'])) {
            $update_data['product_name'] = sanitize_text_field($data['product_name']);
            $format[] = '%s';
        }

        if (isset($data['weight_label'])) {
            $update_data['weight_label'] = sanitize_text_field($data['weight_label']);
            $format[] = '%s';
        }

        if (isset($data['quantity'])) {
            $update_data['quantity'] = (int) $data['quantity'];
            $format[] = '%d';
        }

        if (isset($data['unit_price'])) {
            $update_data['unit_price'] = (float) $data['unit_price'];
            $format[] = '%f';
        }

        // Calculate line total if quantity or unit_price changed
        $quantity = isset($data['quantity']) ? (int) $data['quantity'] : $item->quantity;
        $unit_price = isset($data['unit_price']) ? (float) $data['unit_price'] : $item->unit_price;
        $update_data['line_total'] = $quantity * $unit_price;
        $format[] = '%f';

        if (empty($update_data)) {
            return true;
        }

        $result = $wpdb->update($table, $update_data, ['id' => $item_id], $format, ['%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to update order item.', 'artisan-b2b-portal'));
        }

        // Recalculate order total
        self::recalculate_total($item->order_id);

        return true;
    }

    /**
     * Delete order item
     */
    public static function delete_item($item_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$items_table;

        $item = self::get_item($item_id);
        if (!$item) {
            return new WP_Error('not_found', __('Order item not found.', 'artisan-b2b-portal'));
        }

        // Check if this is the last item in the order
        $items_count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE order_id = %d",
            $item->order_id
        ));

        if ($items_count <= 1) {
            return new WP_Error('last_item', __('Cannot delete the last item in an order. Delete the entire order instead.', 'artisan-b2b-portal'));
        }

        $result = $wpdb->delete($table, ['id' => $item_id], ['%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to delete order item.', 'artisan-b2b-portal'));
        }

        // Recalculate order total
        self::recalculate_total($item->order_id);

        return true;
    }

    /**
     * Recalculate order total based on items
     */
    public static function recalculate_total($order_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        $items_table = $wpdb->prefix . self::$items_table;

        // Sum all line totals
        $subtotal = $wpdb->get_var($wpdb->prepare(
            "SELECT SUM(line_total) FROM {$items_table} WHERE order_id = %d",
            $order_id
        ));

        $subtotal = $subtotal ? (float) $subtotal : 0;

        // Get shipping cost from current order
        $shipping_cost = (float) $wpdb->get_var($wpdb->prepare(
            "SELECT shipping_cost FROM {$table} WHERE id = %d",
            $order_id
        ));

        $total = $subtotal + $shipping_cost;

        // Update order
        $wpdb->update(
            $table,
            [
                'subtotal' => $subtotal,
                'total'    => $total,
            ],
            ['id' => $order_id],
            ['%f', '%f'],
            ['%d']
        );

        return $total;
    }

    /**
     * Get recent orders for dashboard
     */
    public static function get_recent($limit = 10) {
        return self::get_all([
            'limit' => $limit,
            'orderby' => 'created_at',
            'order' => 'DESC',
        ]);
    }

    /**
     * Get orders for upcoming deliveries
     */
    public static function get_upcoming_deliveries($days = 7) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        $customers_table = $wpdb->prefix . 'ab2b_customers';

        $today = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime("+{$days} days"));

        return $wpdb->get_results($wpdb->prepare(
            "SELECT o.*, c.company_name, c.contact_name
             FROM {$table} o
             LEFT JOIN {$customers_table} c ON o.customer_id = c.id
             WHERE o.delivery_date BETWEEN %s AND %s
             AND o.status IN ('pending', 'confirmed')
             ORDER BY o.delivery_date ASC",
            $today,
            $end_date
        ));
    }
}
