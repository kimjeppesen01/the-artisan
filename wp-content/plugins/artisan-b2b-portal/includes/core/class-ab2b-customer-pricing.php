<?php
/**
 * Customer Pricing Model - Handles customer-specific products and prices
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Customer_Pricing {

    private static $products_table = 'ab2b_customer_products';
    private static $prices_table = 'ab2b_customer_prices';

    /**
     * Get customer-specific products (exclusive products assigned to customer)
     */
    public static function get_customer_products($customer_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$products_table;
        $products_table = $wpdb->prefix . 'ab2b_products';

        return $wpdb->get_results($wpdb->prepare(
            "SELECT cp.*, p.name as original_name, p.description as original_description,
                    p.short_description as original_short_description, p.image_id, p.hover_image_id, p.slug
             FROM {$table} cp
             LEFT JOIN {$products_table} p ON cp.product_id = p.id
             WHERE cp.customer_id = %d
             ORDER BY p.sort_order ASC",
            $customer_id
        ));
    }

    /**
     * Get exclusive product IDs for a customer
     */
    public static function get_exclusive_product_ids($customer_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$products_table;

        return $wpdb->get_col($wpdb->prepare(
            "SELECT product_id FROM {$table} WHERE customer_id = %d AND is_exclusive = 1",
            $customer_id
        ));
    }

    /**
     * Check if product is exclusive to any customer
     */
    public static function is_exclusive_product($product_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$products_table;

        return (bool) $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE product_id = %d AND is_exclusive = 1",
            $product_id
        ));
    }

    /**
     * Check if customer has access to product
     */
    public static function customer_has_product_access($customer_id, $product_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$products_table;

        // Check if product is exclusive
        $is_exclusive = self::is_exclusive_product($product_id);

        if (!$is_exclusive) {
            return true; // Non-exclusive products are available to all
        }

        // Check if customer has this exclusive product
        return (bool) $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE customer_id = %d AND product_id = %d",
            $customer_id,
            $product_id
        ));
    }

    /**
     * Get customer's custom product data
     */
    public static function get_customer_product($customer_id, $product_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$products_table;

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE customer_id = %d AND product_id = %d",
            $customer_id,
            $product_id
        ));
    }

    /**
     * Assign product to customer
     */
    public static function assign_product($customer_id, $product_id, $data = []) {
        global $wpdb;
        $table = $wpdb->prefix . self::$products_table;

        $defaults = [
            'custom_name'        => null,
            'custom_description' => null,
            'is_exclusive'       => 0,
        ];

        $data = wp_parse_args($data, $defaults);

        // Check if already exists
        $existing = self::get_customer_product($customer_id, $product_id);

        if ($existing) {
            // Update
            return $wpdb->update(
                $table,
                [
                    'custom_name'        => $data['custom_name'],
                    'custom_description' => $data['custom_description'],
                    'is_exclusive'       => (int) $data['is_exclusive'],
                ],
                [
                    'customer_id' => $customer_id,
                    'product_id'  => $product_id,
                ],
                ['%s', '%s', '%d'],
                ['%d', '%d']
            );
        }

        // Insert
        return $wpdb->insert($table, [
            'customer_id'        => (int) $customer_id,
            'product_id'         => (int) $product_id,
            'custom_name'        => $data['custom_name'],
            'custom_description' => $data['custom_description'],
            'is_exclusive'       => (int) $data['is_exclusive'],
        ], ['%d', '%d', '%s', '%s', '%d']);
    }

    /**
     * Remove product from customer
     */
    public static function remove_product($customer_id, $product_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$products_table;

        // Also remove any custom prices for this product
        self::remove_product_prices($customer_id, $product_id);

        return $wpdb->delete($table, [
            'customer_id' => $customer_id,
            'product_id'  => $product_id,
        ], ['%d', '%d']);
    }

    /**
     * Get customers assigned to a product
     */
    public static function get_product_customers($product_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$products_table;
        $customers_table = $wpdb->prefix . 'ab2b_customers';

        return $wpdb->get_results($wpdb->prepare(
            "SELECT cp.*, c.company_name, c.contact_name, c.email
             FROM {$table} cp
             LEFT JOIN {$customers_table} c ON cp.customer_id = c.id
             WHERE cp.product_id = %d
             ORDER BY c.company_name ASC",
            $product_id
        ));
    }

    // =========== PRICING METHODS ===========

    /**
     * Get all custom prices for a customer
     */
    public static function get_customer_prices($customer_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$prices_table;
        $weights_table = $wpdb->prefix . 'ab2b_product_weights';
        $products_table = $wpdb->prefix . 'ab2b_products';

        return $wpdb->get_results($wpdb->prepare(
            "SELECT cp.*, pw.weight_label, pw.price as original_price, pw.product_id, p.name as product_name
             FROM {$table} cp
             LEFT JOIN {$weights_table} pw ON cp.product_weight_id = pw.id
             LEFT JOIN {$products_table} p ON pw.product_id = p.id
             WHERE cp.customer_id = %d
             ORDER BY p.name ASC, pw.sort_order ASC",
            $customer_id
        ));
    }

    /**
     * Get custom price for a specific weight
     */
    public static function get_custom_price($customer_id, $weight_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$prices_table;

        return $wpdb->get_var($wpdb->prepare(
            "SELECT custom_price FROM {$table} WHERE customer_id = %d AND product_weight_id = %d",
            $customer_id,
            $weight_id
        ));
    }

    /**
     * Get all custom prices for customer organized by weight_id
     */
    public static function get_customer_price_map($customer_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$prices_table;

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT product_weight_id, custom_price FROM {$table} WHERE customer_id = %d",
            $customer_id
        ));

        $map = [];
        foreach ($results as $row) {
            $map[$row->product_weight_id] = (float) $row->custom_price;
        }

        return $map;
    }

    /**
     * Set custom price for customer
     */
    public static function set_custom_price($customer_id, $weight_id, $price) {
        global $wpdb;
        $table = $wpdb->prefix . self::$prices_table;

        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$table} WHERE customer_id = %d AND product_weight_id = %d",
            $customer_id,
            $weight_id
        ));

        if ($existing) {
            return $wpdb->update(
                $table,
                ['custom_price' => (float) $price],
                [
                    'customer_id'       => $customer_id,
                    'product_weight_id' => $weight_id,
                ],
                ['%f'],
                ['%d', '%d']
            );
        }

        return $wpdb->insert($table, [
            'customer_id'       => (int) $customer_id,
            'product_weight_id' => (int) $weight_id,
            'custom_price'      => (float) $price,
        ], ['%d', '%d', '%f']);
    }

    /**
     * Remove custom price
     */
    public static function remove_custom_price($customer_id, $weight_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$prices_table;

        return $wpdb->delete($table, [
            'customer_id'       => $customer_id,
            'product_weight_id' => $weight_id,
        ], ['%d', '%d']);
    }

    /**
     * Remove all prices for a product from a customer
     */
    public static function remove_product_prices($customer_id, $product_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$prices_table;
        $weights_table = $wpdb->prefix . 'ab2b_product_weights';

        return $wpdb->query($wpdb->prepare(
            "DELETE cp FROM {$table} cp
             INNER JOIN {$weights_table} pw ON cp.product_weight_id = pw.id
             WHERE cp.customer_id = %d AND pw.product_id = %d",
            $customer_id,
            $product_id
        ));
    }

    /**
     * Bulk update prices for a customer
     */
    public static function bulk_update_prices($customer_id, $prices) {
        foreach ($prices as $weight_id => $price) {
            if ($price === '' || $price === null) {
                self::remove_custom_price($customer_id, $weight_id);
            } else {
                self::set_custom_price($customer_id, $weight_id, $price);
            }
        }
        return true;
    }

    /**
     * Copy pricing from one customer to another
     */
    public static function copy_pricing($from_customer_id, $to_customer_id) {
        $prices = self::get_customer_prices($from_customer_id);

        foreach ($prices as $price) {
            self::set_custom_price($to_customer_id, $price->product_weight_id, $price->custom_price);
        }

        return true;
    }
}
