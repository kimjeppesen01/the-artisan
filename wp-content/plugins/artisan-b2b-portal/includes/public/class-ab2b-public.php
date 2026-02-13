<?php
/**
 * Public Frontend Controller
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Public {

    private $customer = null;
    private $needs_password = false;
    private $password_customer_slug = null;
    private $login_error = null;

    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('init', [$this, 'register_shortcodes']);
        add_action('init', [$this, 'handle_password_login']);
        add_action('init', [$this, 'handle_password_reset']);
        add_action('init', [$this, 'handle_email_login']);
        add_action('init', [$this, 'handle_forgot_password_by_email']);
        add_action('template_redirect', [$this, 'check_portal_access']);
    }

    /**
     * Handle password form submission
     */
    public function handle_password_login() {
        if (!isset($_POST['ab2b_customer_login'])) {
            return;
        }

        // Verify nonce
        if (!isset($_POST['ab2b_login_nonce']) || !wp_verify_nonce($_POST['ab2b_login_nonce'], 'ab2b_customer_login')) {
            return;
        }

        $customer_slug = sanitize_text_field($_POST['ab2b_customer_slug'] ?? '');
        $password = $_POST['ab2b_password'] ?? '';

        if (empty($customer_slug) || empty($password)) {
            return;
        }

        $customer = AB2B_Customer::get_by_slug($customer_slug);
        if (!$customer) {
            return;
        }

        if (AB2B_Customer::verify_password($customer->id, $password)) {
            // Set cookie with access key for session
            setcookie('ab2b_access_key', $customer->access_key, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
            $this->customer = $customer;

            // Redirect to remove password from URL and show portal
            $portal_url = AB2B_Helpers::get_portal_url(null, $customer_slug);
            wp_safe_redirect($portal_url);
            exit;
        }

        // Password incorrect – stay on login page and show error
        $this->login_error = __('Incorrect password. Please try again.', 'artisan-b2b-portal');
    }

    /**
     * Handle email-based login – user enters email + password, no URL slug needed
     */
    public function handle_email_login() {
        if (!isset($_POST['ab2b_email_login'])) {
            return;
        }

        if (!isset($_POST['ab2b_email_login_nonce']) || !wp_verify_nonce($_POST['ab2b_email_login_nonce'], 'ab2b_email_login')) {
            return;
        }

        $email = sanitize_email($_POST['ab2b_email'] ?? '');
        $password = $_POST['ab2b_password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->login_error = __('Please enter your email and password.', 'artisan-b2b-portal');
            return;
        }

        if (!is_email($email)) {
            $this->login_error = __('Please enter a valid email address.', 'artisan-b2b-portal');
            return;
        }

        $customer = AB2B_Customer::get_by_email($email);
        if (!$customer || !$customer->is_active) {
            $this->login_error = __('No account found with this email. Please check your details or contact your account manager.', 'artisan-b2b-portal');
            return;
        }

        if (empty($customer->password_hash)) {
            $this->login_error = __('This account uses a link-based login. Please use the personal link from your account manager.', 'artisan-b2b-portal');
            return;
        }

        if (!AB2B_Customer::verify_password($customer->id, $password)) {
            $this->login_error = __('Incorrect password. Please try again.', 'artisan-b2b-portal');
            return;
        }

        // Ensure customer has url_slug – auto-generate from company name if missing
        $customer_slug = $customer->url_slug;
        if (empty($customer_slug) && !empty($customer->company_name)) {
            $customer_slug = AB2B_Helpers::create_slug($customer->company_name);
            if (!empty($customer_slug)) {
                $existing = AB2B_Customer::get_by_slug($customer_slug);
                if ($existing && $existing->id != $customer->id) {
                    $customer_slug = $customer_slug . '-' . $customer->id;
                }
                AB2B_Customer::set_url_slug($customer->id, $customer_slug);
            }
        }
        if (empty($customer_slug)) {
            $customer_slug = 'c' . $customer->id;
            AB2B_Customer::set_url_slug($customer->id, $customer_slug);
        }

        setcookie('ab2b_access_key', $customer->access_key, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
        $portal_url = AB2B_Helpers::get_portal_url(null, $customer_slug);
        wp_safe_redirect($portal_url);
        exit;
    }

    /**
     * Handle password reset request – generate new password and email to customer
     */
    public function handle_password_reset() {
        if (!isset($_POST['ab2b_password_reset'])) {
            return;
        }

        if (!isset($_POST['ab2b_reset_nonce']) || !wp_verify_nonce($_POST['ab2b_reset_nonce'], 'ab2b_password_reset')) {
            return;
        }

        $customer_slug = sanitize_text_field($_POST['ab2b_customer_slug'] ?? '');
        if (empty($customer_slug)) {
            return;
        }

        $customer = AB2B_Customer::get_by_slug($customer_slug);
        if (!$customer || empty($customer->email)) {
            return;
        }

        if (empty($customer->password_hash)) {
            return;
        }

        $new_password = wp_generate_password(12, true, false);
        $result = AB2B_Customer::set_password($customer->id, $new_password);

        if ($result !== false) {
            AB2B_Email::send_password_reset($customer, $new_password);
        }

        $portal_url = AB2B_Helpers::get_portal_url(null, $customer_slug);
        $portal_url = add_query_arg('ab2b_reset_sent', '1', $portal_url);
        wp_safe_redirect($portal_url);
        exit;
    }

    /**
     * Register shortcodes
     */
    public function register_shortcodes() {
        add_shortcode('ab2b_portal', [$this, 'render_portal']);
        add_shortcode('ab2b_shop', [$this, 'render_shop']);
        add_shortcode('ab2b_cart', [$this, 'render_cart']);
        add_shortcode('ab2b_orders', [$this, 'render_orders']);
    }

    /**
     * Check portal access on page load
     */
    public function check_portal_access() {
        // Only check on portal page
        $portal_page_id = get_option('ab2b_portal_page_id');
        if (!$portal_page_id || !is_page($portal_page_id)) {
            return;
        }

        // Check for direct access key first
        $access_key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';

        if ($access_key) {
            $customer = AB2B_Customer::validate_key($access_key);
            if ($customer) {
                // Store in session/cookie
                setcookie('ab2b_access_key', $access_key, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
                $this->customer = $customer;
                return;
            }
        }

        // Check for customer slug via ?customer=
        $customer_slug = isset($_GET['customer']) ? sanitize_text_field($_GET['customer']) : '';

        if ($customer_slug) {
            $customer = AB2B_Customer::get_by_slug($customer_slug);
            if ($customer) {
                // Check if already authenticated via cookie
                $cookie_key = isset($_COOKIE['ab2b_access_key']) ? sanitize_text_field($_COOKIE['ab2b_access_key']) : '';
                if ($cookie_key && $cookie_key === $customer->access_key) {
                    $this->customer = $customer;
                    return;
                }

                // Needs password authentication
                $this->needs_password = true;
                $this->password_customer_slug = $customer_slug;
                return;
            }
        }

        // Check cookie for regular access
        $access_key = isset($_COOKIE['ab2b_access_key']) ? sanitize_text_field($_COOKIE['ab2b_access_key']) : '';
        if ($access_key) {
            $customer = AB2B_Customer::validate_key($access_key);
            if ($customer) {
                $this->customer = $customer;
            }
        }
    }

    /**
     * Get current customer
     */
    private function get_current_customer() {
        if ($this->customer) {
            return $this->customer;
        }

        // Check cookie
        $access_key = isset($_COOKIE['ab2b_access_key']) ? sanitize_text_field($_COOKIE['ab2b_access_key']) : '';

        // Check URL param
        if (!$access_key && isset($_GET['key'])) {
            $access_key = sanitize_text_field($_GET['key']);
        }

        if ($access_key) {
            $this->customer = AB2B_Customer::validate_key($access_key);
        }

        return $this->customer;
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_assets() {
        // Only load on pages with our shortcodes
        global $post;
        if (!$post) return;

        $shortcodes = ['ab2b_portal', 'ab2b_shop', 'ab2b_cart', 'ab2b_orders'];
        $has_shortcode = false;

        foreach ($shortcodes as $shortcode) {
            if (has_shortcode($post->post_content, $shortcode)) {
                $has_shortcode = true;
                break;
            }
        }

        if (!$has_shortcode) return;

        wp_enqueue_style(
            'ab2b-portal',
            AB2B_PLUGIN_URL . 'assets/public/css/portal.css',
            [],
            AB2B_VERSION
        );

        wp_enqueue_script(
            'ab2b-portal',
            AB2B_PLUGIN_URL . 'assets/public/js/portal.js',
            ['jquery'],
            AB2B_VERSION,
            true
        );

        $customer = $this->get_current_customer();
        $access_key = $customer ? $customer->access_key : '';

        wp_localize_script('ab2b-portal', 'ab2b_portal', [
            'api_url'    => rest_url('ab2b/v1'),
            'access_key' => $access_key,
            'is_authenticated' => (bool) $customer,
            'customer'   => $customer ? [
                'company_name' => $customer->company_name,
                'contact_name' => $customer->contact_name,
                'email'        => $customer->email,
            ] : null,
            'min_days'   => ab2b_get_option('min_days_before', 2),
            'currency'   => ab2b_get_option('currency_symbol', 'kr.'),
            'shipping'   => [
                'domestic'         => (float) ab2b_get_option('shipping_domestic', 100),
                'international'    => (float) ab2b_get_option('shipping_international', 125),
                'international_7kg' => (float) ab2b_get_option('shipping_international_7kg', 190),
                'weight_threshold_kg' => (float) ab2b_get_option('weight_threshold_kg', 7),
            ],
            'strings'    => [
                'add_to_cart'      => __('Add to Cart', 'artisan-b2b-portal'),
                'added'            => __('Added!', 'artisan-b2b-portal'),
                'cart_empty'       => __('Your cart is empty.', 'artisan-b2b-portal'),
                'select_weight'    => __('Select weight', 'artisan-b2b-portal'),
                'quantity'         => __('Quantity', 'artisan-b2b-portal'),
                'delivery_date'         => __('Delivery Date', 'artisan-b2b-portal'),
                'available_from_date'   => __('Available from date', 'artisan-b2b-portal'),
                'friday_only'           => __('Delivery available on Fridays only.', 'artisan-b2b-portal'),
                'friday_only_pickup'    => __('Ready for pick up from the selected Friday.', 'artisan-b2b-portal'),
                'pickup_any_day'        => __('Select when you\'d like to pick up.', 'artisan-b2b-portal'),
                'pickup_date_min'       => __('Please select a date at least %d days in advance.', 'artisan-b2b-portal'),
                'place_order'      => __('Place Order', 'artisan-b2b-portal'),
                'placing_order'    => __('Placing Order...', 'artisan-b2b-portal'),
                'order_success'    => __('Order placed successfully!', 'artisan-b2b-portal'),
                'error'            => __('An error occurred. Please try again.', 'artisan-b2b-portal'),
                'no_orders'        => __('No orders yet.', 'artisan-b2b-portal'),
                'view_details'     => __('View Details', 'artisan-b2b-portal'),
                'loading'          => __('Loading...', 'artisan-b2b-portal'),
                'remove'           => __('Remove', 'artisan-b2b-portal'),
                'total'            => __('Total', 'artisan-b2b-portal'),
                'special_instructions' => __('Special Instructions', 'artisan-b2b-portal'),
                'edit_order'           => __('Edit Order', 'artisan-b2b-portal'),
                'delete_order'         => __('Delete Order', 'artisan-b2b-portal'),
                'delete_order_confirm' => __('Are you sure you want to delete this order?', 'artisan-b2b-portal'),
                'update_order'         => __('Update Order', 'artisan-b2b-portal'),
                'updating_order'       => __('Updating...', 'artisan-b2b-portal'),
                'order_updated'        => __('Order updated successfully!', 'artisan-b2b-portal'),
                'order_deleted'        => __('Order deleted.', 'artisan-b2b-portal'),
                'reverse_vat'          => __('Reverse VAT applies', 'artisan-b2b-portal'),
                'saving'               => __('Saving...', 'artisan-b2b-portal'),
                'profile_updated'      => __('Your details have been updated.', 'artisan-b2b-portal'),
                'save_changes'         => __('Save Changes', 'artisan-b2b-portal'),
                'update_password'      => __('Update Password', 'artisan-b2b-portal'),
                'password_mismatch'    => __('New passwords do not match.', 'artisan-b2b-portal'),
                'password_too_short'   => __('Password must be at least 8 characters.', 'artisan-b2b-portal'),
            ],
        ]);
    }

    /**
     * Render full portal (tabs: shop, cart, orders)
     */
    public function render_portal($atts) {
        // Check if needs password login
        if ($this->needs_password && $this->password_customer_slug) {
            return $this->render_password_form($this->password_customer_slug);
        }

        $customer = $this->get_current_customer();

        if ( ! $customer ) {
            return $this->render_email_login_form();
        }

        ob_start();
        include AB2B_PLUGIN_DIR . 'templates/portal/portal.php';
        return ob_get_clean();
    }

    /**
     * Render password login form
     */
    private function render_password_form($customer_slug) {
        $customer = AB2B_Customer::get_by_slug($customer_slug);
        if ( ! $customer ) {
            return $this->render_welcome();
        }
        $company_name = $customer->company_name;
        $reset_sent = isset($_GET['ab2b_reset_sent']) && $_GET['ab2b_reset_sent'] === '1';
        $can_reset = !empty($customer->password_hash) && !empty($customer->email);
        $has_notice = $reset_sent || $this->login_error;

        ob_start();
        ?>
        <div class="ab2b-login-wrap" id="ab2b-login-wrap">
            <div class="ab2b-login-form ab2b-login-form--saren<?php echo $has_notice ? ' ab2b-login-form--has-notice' : ''; ?>">
                <p class="ab2b-login-title"><?php esc_html_e( 'B2B Portal Login', 'artisan-b2b-portal' ); ?></p>
                <?php if ( $company_name ) : ?>
                    <p class="ab2b-login-company"><?php echo esc_html( $company_name ); ?></p>
                <?php endif; ?>

                <?php if ( $this->login_error ) : ?>
                    <p class="ab2b-login-notice ab2b-login-notice--error"><?php echo esc_html( $this->login_error ); ?></p>
                <?php endif; ?>

                <?php if ( $reset_sent ) : ?>
                    <p class="ab2b-login-notice ab2b-login-notice--success"><?php esc_html_e( 'A new password has been sent to the email on file. Check your inbox and log in below.', 'artisan-b2b-portal' ); ?></p>
                <?php endif; ?>

                <form method="post" class="ab2b-password-form" action="">
                    <?php wp_nonce_field( 'ab2b_customer_login', 'ab2b_login_nonce' ); ?>
                    <input type="hidden" name="ab2b_customer_slug" value="<?php echo esc_attr( $customer_slug ); ?>">
                    <input type="hidden" name="ab2b_customer_login" value="1">

                    <p class="form-row form-row-wide">
                        <label for="ab2b_password"><?php esc_html_e( 'Password', 'artisan-b2b-portal' ); ?> <span class="required">*</span></label>
                        <input type="password" name="ab2b_password" id="ab2b_password" class="input-text" autocomplete="current-password" required autofocus>
                    </p>

                    <p class="form-row">
                        <button type="submit" class="ab2b-btn ab2b-btn-primary" name="login"><?php esc_html_e( 'Log in', 'artisan-b2b-portal' ); ?></button>
                    </p>
                </form>

                <?php if ( $can_reset ) : ?>
                <div class="ab2b-login-reset">
                    <p class="ab2b-login-help"><?php esc_html_e( 'Forgot your password?', 'artisan-b2b-portal' ); ?></p>
                    <form method="post" class="ab2b-reset-form" action="">
                        <?php wp_nonce_field( 'ab2b_password_reset', 'ab2b_reset_nonce' ); ?>
                        <input type="hidden" name="ab2b_customer_slug" value="<?php echo esc_attr( $customer_slug ); ?>">
                        <input type="hidden" name="ab2b_password_reset" value="1">
                        <button type="submit" class="ab2b-btn ab2b-btn-link"><?php esc_html_e( 'Email me a new password', 'artisan-b2b-portal' ); ?></button>
                    </form>
                </div>
                <?php else : ?>
                <p class="ab2b-login-help"><?php esc_html_e( 'Forgot your password? Contact your account manager.', 'artisan-b2b-portal' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Render shop only
     */
    public function render_shop($atts) {
        $customer = $this->get_current_customer();

        if ( ! $customer ) {
            return $this->render_welcome();
        }

        ob_start();
        include AB2B_PLUGIN_DIR . 'templates/portal/shop.php';
        return ob_get_clean();
    }

    /**
     * Render cart only
     */
    public function render_cart($atts) {
        $customer = $this->get_current_customer();

        if ( ! $customer ) {
            return $this->render_welcome();
        }

        ob_start();
        include AB2B_PLUGIN_DIR . 'templates/portal/cart.php';
        return ob_get_clean();
    }

    /**
     * Render orders only
     */
    public function render_orders($atts) {
        $customer = $this->get_current_customer();

        if ( ! $customer ) {
            return $this->render_welcome();
        }

        ob_start();
        include AB2B_PLUGIN_DIR . 'templates/portal/orders.php';
        return ob_get_clean();
    }

    /**
     * Render email + password login form – single entry point, no URL/slug required
     */
    private function render_email_login_form() {
        $reset_sent = isset($_GET['ab2b_reset_sent']) && $_GET['ab2b_reset_sent'] === '1';
        $has_notice = $reset_sent || $this->login_error;

        ob_start();
        ?>
        <div class="ab2b-login-wrap" id="ab2b-login-wrap">
            <div class="ab2b-login-form ab2b-login-form--saren ab2b-login-form--email<?php echo $has_notice ? ' ab2b-login-form--has-notice' : ''; ?>">
                <p class="ab2b-login-title"><?php esc_html_e( 'B2B Portal', 'artisan-b2b-portal' ); ?></p>
                <p class="ab2b-login-subtitle"><?php esc_html_e( 'Sign in with your email and password', 'artisan-b2b-portal' ); ?></p>

                <?php if ( $this->login_error ) : ?>
                    <p class="ab2b-login-notice ab2b-login-notice--error"><?php echo esc_html( $this->login_error ); ?></p>
                <?php endif; ?>

                <?php if ( $reset_sent ) : ?>
                    <p class="ab2b-login-notice ab2b-login-notice--success"><?php esc_html_e( 'A new password has been sent to your email. Check your inbox and sign in below.', 'artisan-b2b-portal' ); ?></p>
                <?php endif; ?>

                <form method="post" class="ab2b-password-form ab2b-email-login-form" action="">
                    <?php wp_nonce_field( 'ab2b_email_login', 'ab2b_email_login_nonce' ); ?>
                    <input type="hidden" name="ab2b_email_login" value="1">

                    <p class="form-row form-row-wide">
                        <label for="ab2b_login_email"><?php esc_html_e( 'Email', 'artisan-b2b-portal' ); ?> <span class="required">*</span></label>
                        <input type="email" name="ab2b_email" id="ab2b_login_email" class="input-text" value="<?php echo esc_attr( isset($_POST['ab2b_email']) ? sanitize_email($_POST['ab2b_email']) : '' ); ?>" autocomplete="email" required autofocus>
                    </p>

                    <p class="form-row form-row-wide">
                        <label for="ab2b_password"><?php esc_html_e( 'Password', 'artisan-b2b-portal' ); ?> <span class="required">*</span></label>
                        <input type="password" name="ab2b_password" id="ab2b_password" class="input-text" autocomplete="current-password" required>
                    </p>

                    <p class="form-row">
                        <button type="submit" class="ab2b-btn ab2b-btn-primary" name="login"><?php esc_html_e( 'Sign in', 'artisan-b2b-portal' ); ?></button>
                    </p>
                </form>

                <div class="ab2b-login-reset">
                    <p class="ab2b-login-help"><?php esc_html_e( 'Forgot your password?', 'artisan-b2b-portal' ); ?></p>
                    <form method="post" class="ab2b-reset-form ab2b-forgot-email-form" action="">
                        <?php wp_nonce_field( 'ab2b_forgot_password_email', 'ab2b_forgot_email_nonce' ); ?>
                        <input type="hidden" name="ab2b_forgot_password_email" value="1">
                        <input type="email" name="ab2b_forgot_email" placeholder="<?php esc_attr_e( 'Enter your email', 'artisan-b2b-portal' ); ?>" class="input-text ab2b-forgot-email-input" required>
                        <button type="submit" class="ab2b-btn ab2b-btn-link"><?php esc_html_e( 'Email me a new password', 'artisan-b2b-portal' ); ?></button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Handle forgot password from email login page – no slug needed
     */
    public function handle_forgot_password_by_email() {
        if (!isset($_POST['ab2b_forgot_password_email'])) {
            return;
        }

        if (!isset($_POST['ab2b_forgot_email_nonce']) || !wp_verify_nonce($_POST['ab2b_forgot_email_nonce'], 'ab2b_forgot_password_email')) {
            return;
        }

        $email = sanitize_email($_POST['ab2b_forgot_email'] ?? '');
        if (empty($email) || !is_email($email)) {
            $this->login_error = __('Please enter a valid email address.', 'artisan-b2b-portal');
            return;
        }

        $customer = AB2B_Customer::get_by_email($email);
        if (!$customer || !$customer->is_active || empty($customer->email)) {
            $this->login_error = __('No account found with this email.', 'artisan-b2b-portal');
            return;
        }

        if (empty($customer->password_hash)) {
            $this->login_error = __('This account uses a link-based login. Please use the personal link from your account manager.', 'artisan-b2b-portal');
            return;
        }

        $new_password = wp_generate_password(12, true, false);
        $result = AB2B_Customer::set_password($customer->id, $new_password);

        if ($result !== false) {
            AB2B_Email::send_password_reset($customer, $new_password);
        }

        $portal_url = AB2B_Helpers::get_portal_url();
        $portal_url = add_query_arg('ab2b_reset_sent', '1', $portal_url);
        wp_safe_redirect($portal_url);
        exit;
    }

    /**
     * Render welcome / landing message when no customer is found (e.g. /b2b-portal with no key/slug).
     */
    private function render_welcome() {
        ob_start();
        ?>
        <div class="ab2b-welcome">
            <div class="ab2b-welcome__inner">
                <div class="ab2b-welcome__icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="64" height="64"><path d="M0-240v-63q0-43 44-70t116-27q13 0 25 .5t23 2.5q-14 21-21 44t-7 50v53H0Zm240 0v-63q0-44 24.5-74.5T307-410q32-11 65-17.5t68-6.5q34 0 67 6.5t65 17.5q37 16 61.5 46.5T724-303v63H240Zm540 0v-53q0-26-6.5-49T753-386q11-2 22.5-2.5t23.5-.5q72 0 116 26.5t44 70.5v63H780ZM307-490q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42Zm346 0q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM0-120v-63q0-44 44-71t116-27q13 0 25 1t24 3q-15 20-23 42.5T182-183H0Zm240 0v-63q0-45 24.5-75.5T307-410q32-11 65-17t68-6q34 0 67 6t65 17q37 15 61.5 46t24.5 75v63H240Zm540 0v-63q0-45-24.5-75.5T653-410q-32-11-65-17t-68-6q-34 0-67 6t-65 17q-37 15-61.5 46T246-183v63h534Zm-99-360q66 0 108-42t42-108q0-66-42-108t-108-42q-66 0-108 42t-42 108q0 66 42 108t108 42ZM154-440q-72 0-116-26.5T-6-537v-63q0-43 44-70t116-27q13 0 25 .5t23 2.5q-14 21-21 44t-7 50v53H154Zm652 0v-53q0-26 6.5-49t20.5-44q-11-2-22.5-2.5T779-590q-72 0-116 26.5T619-483v63h187Zm-326-40q-23 0-38.5-15.5T426-534q0-23 15.5-38.5T480-588q23 0 38.5 15.5T534-534q0 23-15.5 38.5T480-480Z" fill="currentColor"/></svg>
                </div>
                <h1 class="ab2b-welcome__title"><?php esc_html_e( 'B2B Portal', 'artisan-b2b-portal' ); ?></h1>
                <p class="ab2b-welcome__lead"><?php esc_html_e( 'Welcome. Use the personal link from your account manager to sign in and place orders.', 'artisan-b2b-portal' ); ?></p>
                <p class="ab2b-welcome__note"><?php esc_html_e( 'If you don’t have a link or need access, please contact us.', 'artisan-b2b-portal' ); ?></p>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
