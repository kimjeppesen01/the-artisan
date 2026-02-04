<?php
/**
 * Plugin Activator - Creates database tables and sets default options
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Activator {

    /**
     * Run activation tasks
     */
    public static function activate() {
        self::create_tables();
        self::set_default_options();
        self::create_portal_page();

        // Flush rewrite rules
        flush_rewrite_rules();

        // Set activation flag for welcome notice
        set_transient('ab2b_activated', true, 30);
    }

    /**
     * Create database tables
     */
    private static function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // Customers table
        $table_customers = $wpdb->prefix . 'ab2b_customers';
        $sql_customers = "CREATE TABLE {$table_customers} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            company_name VARCHAR(255) NOT NULL,
            contact_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50) DEFAULT '',
            address TEXT,
            access_key VARCHAR(64) NOT NULL,
            is_active TINYINT(1) DEFAULT 1,
            notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY access_key (access_key),
            KEY email (email),
            KEY is_active (is_active)
        ) {$charset_collate};";

        // Products table
        $table_products = $wpdb->prefix . 'ab2b_products';
        $sql_products = "CREATE TABLE {$table_products} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            description TEXT,
            short_description TEXT,
            image_id BIGINT(20) UNSIGNED DEFAULT 0,
            hover_image_id BIGINT(20) UNSIGNED DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            sort_order INT DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY slug (slug),
            KEY is_active (is_active),
            KEY sort_order (sort_order)
        ) {$charset_collate};";

        // Product weights table
        $table_weights = $wpdb->prefix . 'ab2b_product_weights';
        $sql_weights = "CREATE TABLE {$table_weights} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            product_id BIGINT(20) UNSIGNED NOT NULL,
            weight_label VARCHAR(50) NOT NULL,
            weight_value INT NOT NULL,
            weight_unit VARCHAR(10) DEFAULT 'g',
            price DECIMAL(10,2) NOT NULL,
            is_active TINYINT(1) DEFAULT 1,
            sort_order INT DEFAULT 0,
            PRIMARY KEY (id),
            KEY product_id (product_id),
            KEY is_active (is_active)
        ) {$charset_collate};";

        // Orders table
        $table_orders = $wpdb->prefix . 'ab2b_orders';
        $sql_orders = "CREATE TABLE {$table_orders} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            order_number VARCHAR(50) NOT NULL,
            customer_id BIGINT(20) UNSIGNED NOT NULL,
            status VARCHAR(20) DEFAULT 'pending',
            delivery_date DATE NOT NULL,
            special_instructions TEXT,
            subtotal DECIMAL(10,2) NOT NULL DEFAULT 0,
            total DECIMAL(10,2) NOT NULL DEFAULT 0,
            admin_notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY order_number (order_number),
            KEY customer_id (customer_id),
            KEY status (status),
            KEY delivery_date (delivery_date),
            KEY created_at (created_at)
        ) {$charset_collate};";

        // Order items table
        $table_items = $wpdb->prefix . 'ab2b_order_items';
        $sql_items = "CREATE TABLE {$table_items} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            order_id BIGINT(20) UNSIGNED NOT NULL,
            product_id BIGINT(20) UNSIGNED NOT NULL,
            product_weight_id BIGINT(20) UNSIGNED NOT NULL,
            product_name VARCHAR(255) NOT NULL,
            weight_label VARCHAR(50) NOT NULL,
            quantity INT NOT NULL DEFAULT 1,
            unit_price DECIMAL(10,2) NOT NULL,
            line_total DECIMAL(10,2) NOT NULL,
            PRIMARY KEY (id),
            KEY order_id (order_id),
            KEY product_id (product_id)
        ) {$charset_collate};";

        // Customer-specific products (exclusive products for certain customers)
        $table_customer_products = $wpdb->prefix . 'ab2b_customer_products';
        $sql_customer_products = "CREATE TABLE {$table_customer_products} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            customer_id BIGINT(20) UNSIGNED NOT NULL,
            product_id BIGINT(20) UNSIGNED NOT NULL,
            custom_name VARCHAR(255) DEFAULT NULL,
            custom_description TEXT,
            is_exclusive TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY customer_product (customer_id, product_id),
            KEY customer_id (customer_id),
            KEY product_id (product_id)
        ) {$charset_collate};";

        // Customer-specific pricing
        $table_customer_prices = $wpdb->prefix . 'ab2b_customer_prices';
        $sql_customer_prices = "CREATE TABLE {$table_customer_prices} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            customer_id BIGINT(20) UNSIGNED NOT NULL,
            product_weight_id BIGINT(20) UNSIGNED NOT NULL,
            custom_price DECIMAL(10,2) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY customer_weight (customer_id, product_weight_id),
            KEY customer_id (customer_id),
            KEY product_weight_id (product_weight_id)
        ) {$charset_collate};";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_customers);
        dbDelta($sql_products);
        dbDelta($sql_weights);
        dbDelta($sql_orders);
        dbDelta($sql_items);
        dbDelta($sql_customer_products);
        dbDelta($sql_customer_prices);

        // Store DB version
        update_option('ab2b_db_version', AB2B_VERSION);
    }

    /**
     * Set default plugin options
     */
    private static function set_default_options() {
        $defaults = [
            'min_days_before' => 2,
            'admin_emails' => get_option('admin_email'),
            'order_notification_email' => 'order@theartisan.dk',
            'company_name' => get_bloginfo('name'),
            'company_logo' => '',
            'currency_symbol' => 'kr.',
            'currency_position' => 'before',
            'order_prefix' => 'B2B-',
        ];

        $existing = get_option('ab2b_settings', []);
        $merged = array_merge($defaults, $existing);
        update_option('ab2b_settings', $merged);
    }

    /**
     * Create the B2B portal page
     */
    private static function create_portal_page() {
        // Check if page already exists
        $existing_page = get_option('ab2b_portal_page_id');
        if ($existing_page && get_post($existing_page)) {
            return;
        }

        // Create the portal page
        $page_id = wp_insert_post([
            'post_title'     => __('B2B Portal', 'artisan-b2b-portal'),
            'post_content'   => '[ab2b_portal]',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_author'    => get_current_user_id() ?: 1,
            'comment_status' => 'closed',
        ]);

        if ($page_id && !is_wp_error($page_id)) {
            update_option('ab2b_portal_page_id', $page_id);
        }
    }
}
