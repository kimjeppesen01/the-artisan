<?php
/**
 * Customer Model
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Customer {

    private static $table = 'ab2b_customers';

    /**
     * Get customer by ID
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
     * Get customer by access key
     */
    public static function get_by_key($access_key) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE access_key = %s AND is_active = 1",
            $access_key
        ));
    }

    /**
     * Get customer by email
     */
    public static function get_by_email($email) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE email = %s",
            $email
        ));
    }

    /**
     * Get all customers
     */
    public static function get_all($args = []) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $defaults = [
            'orderby'  => 'company_name',
            'order'    => 'ASC',
            'limit'    => 0,
            'offset'   => 0,
            'is_active' => null,
            'search'   => '',
        ];

        $args = wp_parse_args($args, $defaults);

        $where = [];
        $values = [];

        if ($args['is_active'] !== null) {
            $where[] = 'is_active = %d';
            $values[] = (int) $args['is_active'];
        }

        if (!empty($args['search'])) {
            $where[] = '(company_name LIKE %s OR contact_name LIKE %s OR email LIKE %s)';
            $search = '%' . $wpdb->esc_like($args['search']) . '%';
            $values[] = $search;
            $values[] = $search;
            $values[] = $search;
        }

        $where_sql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']) ?: 'company_name ASC';

        $limit_sql = '';
        if ($args['limit'] > 0) {
            $limit_sql = $wpdb->prepare(' LIMIT %d OFFSET %d', $args['limit'], $args['offset']);
        }

        $sql = "SELECT * FROM {$table} {$where_sql} ORDER BY {$orderby}{$limit_sql}";

        if (!empty($values)) {
            $sql = $wpdb->prepare($sql, $values);
        }

        return $wpdb->get_results($sql);
    }

    /**
     * Count customers
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
     * Create customer
     */
    public static function create($data) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $defaults = [
            'company_name'  => '',
            'contact_name'  => '',
            'email'         => '',
            'phone'         => '',
            'address'       => '',
            'access_key'    => AB2B_Helpers::generate_access_key(),
            'is_active'     => 1,
            'notes'         => '',
        ];

        $data = wp_parse_args($data, $defaults);

        // Validate required fields
        if (empty($data['company_name']) || empty($data['email'])) {
            return new WP_Error('missing_fields', __('Company name and email are required.', 'artisan-b2b-portal'));
        }

        // Validate email
        if (!is_email($data['email'])) {
            return new WP_Error('invalid_email', __('Invalid email address.', 'artisan-b2b-portal'));
        }

        // Check for duplicate email
        if (self::get_by_email($data['email'])) {
            return new WP_Error('duplicate_email', __('A customer with this email already exists.', 'artisan-b2b-portal'));
        }

        $result = $wpdb->insert($table, [
            'company_name'  => sanitize_text_field($data['company_name']),
            'contact_name'  => sanitize_text_field($data['contact_name']),
            'email'         => sanitize_email($data['email']),
            'phone'         => sanitize_text_field($data['phone']),
            'address'       => sanitize_textarea_field($data['address']),
            'access_key'    => $data['access_key'],
            'is_active'     => (int) $data['is_active'],
            'notes'         => sanitize_textarea_field($data['notes']),
        ], ['%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to create customer.', 'artisan-b2b-portal'));
        }

        return $wpdb->insert_id;
    }

    /**
     * Update customer
     */
    public static function update($id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $customer = self::get($id);
        if (!$customer) {
            return new WP_Error('not_found', __('Customer not found.', 'artisan-b2b-portal'));
        }

        $update_data = [];
        $format = [];

        if (isset($data['company_name'])) {
            $update_data['company_name'] = sanitize_text_field($data['company_name']);
            $format[] = '%s';
        }

        if (isset($data['contact_name'])) {
            $update_data['contact_name'] = sanitize_text_field($data['contact_name']);
            $format[] = '%s';
        }

        if (isset($data['email'])) {
            if (!is_email($data['email'])) {
                return new WP_Error('invalid_email', __('Invalid email address.', 'artisan-b2b-portal'));
            }
            // Check for duplicate email (excluding current customer)
            $existing = self::get_by_email($data['email']);
            if ($existing && $existing->id != $id) {
                return new WP_Error('duplicate_email', __('A customer with this email already exists.', 'artisan-b2b-portal'));
            }
            $update_data['email'] = sanitize_email($data['email']);
            $format[] = '%s';
        }

        if (isset($data['phone'])) {
            $update_data['phone'] = sanitize_text_field($data['phone']);
            $format[] = '%s';
        }

        if (isset($data['address'])) {
            $update_data['address'] = sanitize_textarea_field($data['address']);
            $format[] = '%s';
        }

        if (isset($data['is_active'])) {
            $update_data['is_active'] = (int) $data['is_active'];
            $format[] = '%d';
        }

        if (isset($data['notes'])) {
            $update_data['notes'] = sanitize_textarea_field($data['notes']);
            $format[] = '%s';
        }

        if (empty($update_data)) {
            return true;
        }

        $result = $wpdb->update($table, $update_data, ['id' => $id], $format, ['%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to update customer.', 'artisan-b2b-portal'));
        }

        return true;
    }

    /**
     * Delete customer
     */
    public static function delete($id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        // Check if customer has orders
        $orders_table = $wpdb->prefix . 'ab2b_orders';
        $has_orders = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$orders_table} WHERE customer_id = %d",
            $id
        ));

        if ($has_orders > 0) {
            return new WP_Error('has_orders', __('Cannot delete customer with existing orders. Deactivate instead.', 'artisan-b2b-portal'));
        }

        $result = $wpdb->delete($table, ['id' => $id], ['%d']);

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to delete customer.', 'artisan-b2b-portal'));
        }

        return true;
    }

    /**
     * Regenerate access key
     */
    public static function regenerate_key($id) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table;

        $new_key = AB2B_Helpers::generate_access_key();

        $result = $wpdb->update(
            $table,
            ['access_key' => $new_key],
            ['id' => $id],
            ['%s'],
            ['%d']
        );

        if ($result === false) {
            return new WP_Error('db_error', __('Failed to regenerate access key.', 'artisan-b2b-portal'));
        }

        return $new_key;
    }

    /**
     * Validate access key
     */
    public static function validate_key($access_key) {
        $customer = self::get_by_key($access_key);
        return $customer ? $customer : false;
    }
}
