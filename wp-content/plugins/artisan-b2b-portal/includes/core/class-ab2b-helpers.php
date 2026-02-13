<?php
/**
 * Helper functions
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Helpers {

    /**
     * Generate unique access key
     */
    public static function generate_access_key() {
        return wp_generate_uuid4();
    }

    /**
     * Generate order number
     */
    public static function generate_order_number() {
        $prefix = ab2b_get_option('order_prefix', 'B2B-');
        $timestamp = time();
        $random = wp_rand(100, 999);
        return $prefix . $timestamp . $random;
    }

    /**
     * Format price
     */
    public static function format_price($amount) {
        $symbol = ab2b_get_option('currency_symbol', 'kr.');
        $position = ab2b_get_option('currency_position', 'before');
        $formatted = number_format((float)$amount, 2, ',', '.');

        if ($position === 'before') {
            return $symbol . ' ' . $formatted;
        }
        return $formatted . ' ' . $symbol;
    }

    /**
     * Get next available Friday
     */
    public static function get_next_friday($min_days = 2) {
        $today = new DateTime();
        $today->modify('+' . $min_days . ' days');

        // Find next Friday
        $day_of_week = (int) $today->format('N');
        if ($day_of_week <= 5) {
            $days_until_friday = 5 - $day_of_week;
        } else {
            $days_until_friday = 12 - $day_of_week;
        }

        if ($days_until_friday > 0) {
            $today->modify('+' . $days_until_friday . ' days');
        }

        return $today->format('Y-m-d');
    }

    /**
     * Validate date is a Friday
     */
    public static function is_valid_friday($date, $min_days = 2) {
        $delivery = new DateTime($date);
        $min_date = new DateTime();
        $min_date->modify('+' . $min_days . ' days');

        // Check if it's a Friday
        if ((int) $delivery->format('N') !== 5) {
            return false;
        }

        // Check if it's at least min_days in the future
        if ($delivery < $min_date) {
            return false;
        }

        return true;
    }

    /**
     * Get minimum date (today + min_days) – any day, used for pickup
     */
    public static function get_min_date($min_days = 2) {
        $today = new DateTime();
        $today->modify('+' . $min_days . ' days');
        return $today->format('Y-m-d');
    }

    /**
     * Validate date meets minimum lead time (any day) – used for pickup
     */
    public static function is_valid_date($date, $min_days = 2) {
        $delivery = new DateTime($date);
        $min_date = new DateTime();
        $min_date->modify('+' . $min_days . ' days');
        return $delivery >= $min_date;
    }

    /**
     * Get status label
     */
    public static function get_status_label($status) {
        $labels = [
            'pending'   => __('Pending', 'artisan-b2b-portal'),
            'confirmed' => __('Confirmed', 'artisan-b2b-portal'),
            'shipped'   => __('Shipped', 'artisan-b2b-portal'),
            'completed' => __('Completed', 'artisan-b2b-portal'),
            'cancelled' => __('Cancelled', 'artisan-b2b-portal'),
        ];
        return isset($labels[$status]) ? $labels[$status] : ucfirst($status);
    }

    /**
     * Get status color class
     */
    public static function get_status_class($status) {
        $classes = [
            'pending'   => 'ab2b-status-pending',
            'confirmed' => 'ab2b-status-confirmed',
            'shipped'   => 'ab2b-status-shipped',
            'completed' => 'ab2b-status-completed',
            'cancelled' => 'ab2b-status-cancelled',
        ];
        return isset($classes[$status]) ? $classes[$status] : '';
    }

    /**
     * Sanitize and validate email
     */
    public static function validate_email($email) {
        $email = sanitize_email($email);
        return is_email($email) ? $email : false;
    }

    /**
     * Get portal URL for customer
     *
     * @param string|null $access_key The access key (used for direct access link)
     * @param string|null $url_slug   The custom URL slug (used for password-protected access)
     * @return string
     */
    public static function get_portal_url($access_key = null, $url_slug = null) {
        $page_id = get_option('ab2b_portal_page_id');
        if (!$page_id) {
            $url = home_url('/b2b-portal/');
        } else {
            $url = get_permalink($page_id);
        }

        if ($url_slug) {
            return add_query_arg('customer', $url_slug, $url);
        }

        if ($access_key) {
            return add_query_arg('key', $access_key, $url);
        }

        return $url;
    }

    /**
     * Log message (for debugging)
     */
    public static function log($message, $level = 'info') {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            if (is_array($message) || is_object($message)) {
                $message = print_r($message, true);
            }
            error_log("[AB2B {$level}] " . $message);
        }
    }

    /**
     * Get product image URL
     */
    public static function get_product_image_url($image_id, $size = 'medium') {
        if (!$image_id) {
            return AB2B_PLUGIN_URL . 'assets/public/images/placeholder.png';
        }
        $image = wp_get_attachment_image_src($image_id, $size);
        return $image ? $image[0] : AB2B_PLUGIN_URL . 'assets/public/images/placeholder.png';
    }

    /**
     * Create slug from string
     */
    public static function create_slug($string) {
        return sanitize_title($string);
    }
}
