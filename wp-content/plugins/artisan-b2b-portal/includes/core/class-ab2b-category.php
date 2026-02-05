<?php
/**
 * Category Model
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Category {

    private static $table = 'ab2b_categories';
    private static $pivot_table = 'ab2b_product_categories';

    /**
     * Get category by ID
     */
    public static function get($id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE id = %d",
            $id
        ));
    }

    /**
     * Get all categories
     */
    public static function get_all($args = []) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $defaults = [
            'orderby' => 'sort_order',
            'order'   => 'ASC',
        ];

        $args = wp_parse_args($args, $defaults);
        $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']) ?: 'sort_order ASC';

        return $wpdb->get_results("SELECT * FROM {$table} ORDER BY {$orderby}");
    }

    /**
     * Create category
     */
    public static function create($data) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        if (empty($data['name'])) {
            return new WP_Error('missing_name', __('Category name is required.', 'artisan-b2b-portal'));
        }

        $slug = !empty($data['slug']) ? $data['slug'] : sanitize_title($data['name']);

        $result = $wpdb->insert($table, [
            'name'       => sanitize_text_field($data['name']),
            'slug'       => $slug,
            'sort_order' => isset($data['sort_order']) ? (int) $data['sort_order'] : 0,
        ], ['%s', '%s', '%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to create category.', 'artisan-b2b-portal'));
        }

        return $wpdb->insert_id;
    }

    /**
     * Update category
     */
    public static function update($id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $update_data = [];
        $format = [];

        if (isset($data['name'])) {
            $update_data['name'] = sanitize_text_field($data['name']);
            $format[] = '%s';
        }

        if (isset($data['slug'])) {
            $update_data['slug'] = sanitize_title($data['slug']);
            $format[] = '%s';
        }

        if (isset($data['sort_order'])) {
            $update_data['sort_order'] = (int) $data['sort_order'];
            $format[] = '%d';
        }

        if (empty($update_data)) {
            return true;
        }

        $result = $wpdb->update($table, $update_data, ['id' => $id], $format, ['%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to update category.', 'artisan-b2b-portal'));
        }

        return true;
    }

    /**
     * Delete category
     */
    public static function delete($id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        $pivot = $wpdb->prefix . self::$pivot_table;

        // Remove all product associations
        $wpdb->delete($pivot, ['category_id' => $id], ['%d']);

        // Delete category
        $result = $wpdb->delete($table, ['id' => $id], ['%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to delete category.', 'artisan-b2b-portal'));
        }

        return true;
    }

    /**
     * Get categories for a product
     */
    public static function get_product_categories($product_id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        $pivot = $wpdb->prefix . self::$pivot_table;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT c.* FROM {$table} c
             INNER JOIN {$pivot} pc ON c.id = pc.category_id
             WHERE pc.product_id = %d
             ORDER BY c.sort_order ASC",
            $product_id
        ));
    }

    /**
     * Get category IDs for a product
     */
    public static function get_product_category_ids($product_id) {
        global $wpdb;
        $pivot = $wpdb->prefix . self::$pivot_table;

        return $wpdb->get_col($wpdb->prepare(
            "SELECT category_id FROM {$pivot} WHERE product_id = %d",
            $product_id
        ));
    }

    /**
     * Set categories for a product (replaces existing)
     */
    public static function set_product_categories($product_id, $category_ids) {
        global $wpdb;
        $pivot = $wpdb->prefix . self::$pivot_table;

        // Remove existing
        $wpdb->delete($pivot, ['product_id' => $product_id], ['%d']);

        // Add new
        if (!empty($category_ids) && is_array($category_ids)) {
            foreach ($category_ids as $cat_id) {
                $cat_id = (int) $cat_id;
                if ($cat_id > 0) {
                    $wpdb->insert($pivot, [
                        'product_id'  => (int) $product_id,
                        'category_id' => $cat_id,
                    ], ['%d', '%d']);
                }
            }
        }

        return true;
    }

    /**
     * Get all categories with product counts
     */
    public static function get_all_with_counts() {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        $pivot = $wpdb->prefix . self::$pivot_table;

        return $wpdb->get_results(
            "SELECT c.*, COUNT(pc.product_id) as product_count
             FROM {$table} c
             LEFT JOIN {$pivot} pc ON c.id = pc.category_id
             GROUP BY c.id
             ORDER BY c.sort_order ASC"
        );
    }

    /**
     * Get all categories that have active products (for frontend filtering)
     */
    public static function get_active_categories() {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        $pivot = $wpdb->prefix . self::$pivot_table;
        $products = $wpdb->prefix . 'ab2b_products';

        return $wpdb->get_results(
            "SELECT DISTINCT c.id, c.name, c.slug, c.sort_order
             FROM {$table} c
             INNER JOIN {$pivot} pc ON c.id = pc.category_id
             INNER JOIN {$products} p ON pc.product_id = p.id AND p.is_active = 1
             ORDER BY c.sort_order ASC"
        );
    }
}
