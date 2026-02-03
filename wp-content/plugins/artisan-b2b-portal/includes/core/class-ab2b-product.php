<?php
/**
 * Product Model
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Product {

    private static $table = 'ab2b_products';
    private static $weights_table = 'ab2b_product_weights';

    /**
     * Get product by ID
     */
    public static function get($id, $include_weights = true) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $product = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE id = %d",
            $id
        ));

        if ($product && $include_weights) {
            $product->weights = self::get_weights($id);
        }

        return $product;
    }

    /**
     * Get product by slug
     */
    public static function get_by_slug($slug) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $product = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE slug = %s",
            $slug
        ));

        if ($product) {
            $product->weights = self::get_weights($product->id);
        }

        return $product;
    }

    /**
     * Get all products
     */
    public static function get_all($args = []) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $defaults = [
            'orderby'        => 'sort_order',
            'order'          => 'ASC',
            'is_active'      => null,
            'include_weights' => true,
        ];

        $args = wp_parse_args($args, $defaults);

        $where = [];
        $values = [];

        if ($args['is_active'] !== null) {
            $where[] = 'is_active = %d';
            $values[] = (int) $args['is_active'];
        }

        $where_sql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']) ?: 'sort_order ASC';

        $sql = "SELECT * FROM {$table} {$where_sql} ORDER BY {$orderby}";

        if (!empty($values)) {
            $sql = $wpdb->prepare($sql, $values);
        }

        $products = $wpdb->get_results($sql);

        if ($args['include_weights'] && !empty($products)) {
            $product_ids = wp_list_pluck($products, 'id');
            $all_weights = self::get_weights_for_products($product_ids);

            foreach ($products as &$product) {
                $product->weights = isset($all_weights[$product->id]) ? $all_weights[$product->id] : [];
            }
        }

        return $products;
    }

    /**
     * Count products
     */
    public static function count($is_active = null) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        if ($is_active !== null) {
            return (int) $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$table} WHERE is_active = %d",
                (int) $is_active
            ));
        }

        return (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table}");
    }

    /**
     * Create product
     */
    public static function create($data) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        if (empty($data['name'])) {
            return new WP_Error('missing_name', __('Product name is required.', 'artisan-b2b-portal'));
        }

        // Generate slug
        $slug = !empty($data['slug']) ? $data['slug'] : AB2B_Helpers::create_slug($data['name']);
        $slug = self::unique_slug($slug);

        $result = $wpdb->insert($table, [
            'name'              => sanitize_text_field($data['name']),
            'slug'              => $slug,
            'description'       => isset($data['description']) ? wp_kses_post($data['description']) : '',
            'short_description' => isset($data['short_description']) ? sanitize_textarea_field($data['short_description']) : '',
            'image_id'          => isset($data['image_id']) ? (int) $data['image_id'] : 0,
            'hover_image_id'    => isset($data['hover_image_id']) ? (int) $data['hover_image_id'] : 0,
            'is_active'         => isset($data['is_active']) ? (int) $data['is_active'] : 1,
            'sort_order'        => isset($data['sort_order']) ? (int) $data['sort_order'] : 0,
        ], ['%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to create product.', 'artisan-b2b-portal'));
        }

        $product_id = $wpdb->insert_id;

        // Add weights if provided
        if (!empty($data['weights']) && is_array($data['weights'])) {
            foreach ($data['weights'] as $weight) {
                self::add_weight($product_id, $weight);
            }
        }

        return $product_id;
    }

    /**
     * Update product
     */
    public static function update($id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $product = self::get($id, false);
        if (!$product) {
            return new WP_Error('not_found', __('Product not found.', 'artisan-b2b-portal'));
        }

        $update_data = [];
        $format = [];

        if (isset($data['name'])) {
            $update_data['name'] = sanitize_text_field($data['name']);
            $format[] = '%s';
        }

        if (isset($data['slug'])) {
            $slug = AB2B_Helpers::create_slug($data['slug']);
            $update_data['slug'] = self::unique_slug($slug, $id);
            $format[] = '%s';
        }

        if (isset($data['description'])) {
            $update_data['description'] = wp_kses_post($data['description']);
            $format[] = '%s';
        }

        if (isset($data['short_description'])) {
            $update_data['short_description'] = sanitize_textarea_field($data['short_description']);
            $format[] = '%s';
        }

        if (isset($data['image_id'])) {
            $update_data['image_id'] = (int) $data['image_id'];
            $format[] = '%d';
        }

        if (isset($data['hover_image_id'])) {
            $update_data['hover_image_id'] = (int) $data['hover_image_id'];
            $format[] = '%d';
        }

        if (isset($data['is_active'])) {
            $update_data['is_active'] = (int) $data['is_active'];
            $format[] = '%d';
        }

        if (isset($data['sort_order'])) {
            $update_data['sort_order'] = (int) $data['sort_order'];
            $format[] = '%d';
        }

        if (!empty($update_data)) {
            $result = $wpdb->update($table, $update_data, ['id' => $id], $format, ['%d']);

            if ($result === false) {
                return new WP_Error('db_error', __('Failed to update product.', 'artisan-b2b-portal'));
            }
        }

        // Update weights if provided
        if (isset($data['weights']) && is_array($data['weights'])) {
            self::update_weights($id, $data['weights']);
        }

        return true;
    }

    /**
     * Delete product
     */
    public static function delete($id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        $weights_table = $wpdb->prefix . self::$weights_table;

        // Check if product is in any orders
        $items_table = $wpdb->prefix . 'ab2b_order_items';
        $has_orders = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$items_table} WHERE product_id = %d",
            $id
        ));

        if ($has_orders > 0) {
            return new WP_Error('has_orders', __('Cannot delete product with existing orders. Deactivate instead.', 'artisan-b2b-portal'));
        }

        // Delete weights first
        $wpdb->delete($weights_table, ['product_id' => $id], ['%d']);

        // Delete product
        $result = $wpdb->delete($table, ['id' => $id], ['%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to delete product.', 'artisan-b2b-portal'));
        }

        return true;
    }

    /**
     * Get weights for a product
     */
    public static function get_weights($product_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$weights_table;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$table} WHERE product_id = %d ORDER BY sort_order ASC, weight_value ASC",
            $product_id
        ));
    }

    /**
     * Get weights for multiple products
     */
    public static function get_weights_for_products($product_ids) {
        global $wpdb;
        $table = $wpdb->prefix . self::$weights_table;

        if (empty($product_ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($product_ids), '%d'));
        $sql = $wpdb->prepare(
            "SELECT * FROM {$table} WHERE product_id IN ({$placeholders}) ORDER BY sort_order ASC, weight_value ASC",
            $product_ids
        );

        $all_weights = $wpdb->get_results($sql);

        // Group by product_id
        $grouped = [];
        foreach ($all_weights as $weight) {
            if (!isset($grouped[$weight->product_id])) {
                $grouped[$weight->product_id] = [];
            }
            $grouped[$weight->product_id][] = $weight;
        }

        return $grouped;
    }

    /**
     * Get weight by ID
     */
    public static function get_weight($weight_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$weights_table;

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE id = %d",
            $weight_id
        ));
    }

    /**
     * Add weight to product
     */
    public static function add_weight($product_id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . self::$weights_table;

        if (empty($data['weight_label']) || !isset($data['price'])) {
            return new WP_Error('missing_fields', __('Weight label and price are required.', 'artisan-b2b-portal'));
        }

        $result = $wpdb->insert($table, [
            'product_id'    => (int) $product_id,
            'weight_label'  => sanitize_text_field($data['weight_label']),
            'weight_value'  => isset($data['weight_value']) ? (int) $data['weight_value'] : 0,
            'weight_unit'   => isset($data['weight_unit']) ? sanitize_text_field($data['weight_unit']) : 'g',
            'price'         => (float) $data['price'],
            'is_active'     => isset($data['is_active']) ? (int) $data['is_active'] : 1,
            'sort_order'    => isset($data['sort_order']) ? (int) $data['sort_order'] : 0,
        ], ['%d', '%s', '%d', '%s', '%f', '%d', '%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to add weight.', 'artisan-b2b-portal'));
        }

        return $wpdb->insert_id;
    }

    /**
     * Update weights for a product (replace all)
     */
    public static function update_weights($product_id, $weights) {
        global $wpdb;
        $table = $wpdb->prefix . self::$weights_table;

        // Get existing weight IDs
        $existing = self::get_weights($product_id);
        $existing_ids = wp_list_pluck($existing, 'id');

        $new_ids = [];

        foreach ($weights as $weight) {
            if (!empty($weight['id']) && in_array($weight['id'], $existing_ids)) {
                // Update existing
                $wpdb->update($table, [
                    'weight_label'  => sanitize_text_field($weight['weight_label']),
                    'weight_value'  => isset($weight['weight_value']) ? (int) $weight['weight_value'] : 0,
                    'weight_unit'   => isset($weight['weight_unit']) ? sanitize_text_field($weight['weight_unit']) : 'g',
                    'price'         => (float) $weight['price'],
                    'is_active'     => isset($weight['is_active']) ? (int) $weight['is_active'] : 1,
                    'sort_order'    => isset($weight['sort_order']) ? (int) $weight['sort_order'] : 0,
                ], ['id' => $weight['id']], ['%s', '%d', '%s', '%f', '%d', '%d'], ['%d']);

                $new_ids[] = $weight['id'];
            } else {
                // Add new
                $id = self::add_weight($product_id, $weight);
                if (!is_wp_error($id)) {
                    $new_ids[] = $id;
                }
            }
        }

        // Delete removed weights
        $to_delete = array_diff($existing_ids, $new_ids);
        if (!empty($to_delete)) {
            $placeholders = implode(',', array_fill(0, count($to_delete), '%d'));
            $wpdb->query($wpdb->prepare(
                "DELETE FROM {$table} WHERE id IN ({$placeholders})",
                $to_delete
            ));
        }

        return true;
    }

    /**
     * Generate unique slug
     */
    private static function unique_slug($slug, $exclude_id = 0) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $original_slug = $slug;
        $counter = 1;

        while (true) {
            $existing = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$table} WHERE slug = %s AND id != %d",
                $slug,
                $exclude_id
            ));

            if (!$existing) {
                break;
            }

            $slug = $original_slug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Get price range for a product
     */
    public static function get_price_range($product_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$weights_table;

        $range = $wpdb->get_row($wpdb->prepare(
            "SELECT MIN(price) as min_price, MAX(price) as max_price
             FROM {$table}
             WHERE product_id = %d AND is_active = 1",
            $product_id
        ));

        return $range;
    }
}
