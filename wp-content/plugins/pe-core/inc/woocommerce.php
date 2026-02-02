<?php
function saren_login_register_shortcode($atts)
{

    $atts = shortcode_atts(
        array(
            'redirect_url' => '',
        ),
        $atts
    );


    if (is_user_logged_in() && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        return __('You are already logged in.', 'woocommerce');
    } else {

        $redirect_url = esc_url($atts['redirect_url']);
        $wooFormAttrs = [];
        ob_start();

        if ($redirect_url) {

            $wooFormAttrs = [
                'redirect' => $redirect_url,
            ];

        }

        ?>
        <div class="u-columns col2-set saren--login-sec login--active" id="customer_login">

            <div class="u-column1 col-1 login--col">

                <p><?php esc_html_e('Login', 'woocommerce'); ?></p>

                <?php woocommerce_login_form($wooFormAttrs); ?>

                <?php if (\Elementor\Plugin::$instance->editor->is_edit_mode()) { ?>
                    <form class="woocommerce-form woocommerce-form-login login" method="post">
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>&nbsp;<span
                                    class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
                                id="username" autocomplete="username"
                                value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                        </p>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span
                                    class="required">*</span></label>
                            <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password"
                                id="password" autocomplete="current-password" />
                        </p>
                        <p class="form-row">

                            <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login"
                                value="Login"><?php echo esc_html('Login', 'woocommerce') ?></button>
                        </p>
                    </form>
                <?php } ?>

                <div data-event="lost--password" class="lost--password-heading login--form--heading">
                    <p><?php esc_html_e('Lost your password?', 'woocommerce'); ?></p>
                </div>

            </div>

            <div class="u-column1 col-1 lost--password--col">

                <?php echo do_shortcode('[custom_lost_password]'); ?>

            </div>
            <div class="u-column1 col-1 register--col">

                <p><?php esc_html_e('Register', 'woocommerce'); ?></p>

                <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>

                    <?php do_action('woocommerce_register_form_start'); ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_firstname"><?php esc_html_e('First Name', 'woocommerce'); ?>&nbsp;<span
                                class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="firstname"
                            id="reg_firstname"
                            value="<?php echo (!empty($_POST['firstname'])) ? esc_attr(wp_unslash($_POST['firstname'])) : ''; ?>" />
                    </p>


                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_lastname"><?php esc_html_e('Last Name', 'woocommerce'); ?>&nbsp;<span
                                class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="lastname"
                            id="reg_lastname"
                            value="<?php echo (!empty($_POST['lastname'])) ? esc_attr(wp_unslash($_POST['lastname'])) : ''; ?>" />
                    </p>


                    <?php if ('no' === get_option('woocommerce_registration_generate_username')): ?>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span
                                    class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
                                id="reg_username"
                                value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" />
                        </p>
                    <?php endif; ?>


                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span
                                class="required">*</span></label>
                        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email"
                            id="reg_email"
                            value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" />
                    </p>


                    <?php if ('no' === get_option('woocommerce_registration_generate_password')): ?>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span
                                    class="required">*</span></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password"
                                id="reg_password" />
                        </p>
                    <?php endif; ?>

                    <?php do_action('woocommerce_register_form'); ?>

                    <p class="woocommerce-form-row form-row">
                        <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                        <button type="submit" class="woocommerce-Button button" name="register"
                            value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
                    </p>

                    <?php do_action('woocommerce_register_form_end'); ?>

                </form>

            </div>
            <div class="u-column1 col-1">

                <div data-event="login" class="login-heading login--form--heading">
                    <p><?php esc_html_e('Already have a n account? Login', 'woocommerce'); ?></p>
                </div>

                <div data-event="register" class="register-heading login--form--heading">
                    <p><?php esc_html_e('New client? Create an account', 'woocommerce'); ?></p>
                </div>

                <?php
                $enable_guest_checkout = get_option('woocommerce_enable_guest_checkout');
                if ($enable_guest_checkout) { ?>
                    <div class="saren--continue--as--guest scag--button login--form--heading">
                        <p><?php esc_html_e('Continue As Guest', 'woocommerce'); ?></p>
                    </div>

                <?php } ?>



            </div>

        </div>
        <?php
        return ob_get_clean();
    }
}
add_shortcode('saren_login_register', 'saren_login_register_shortcode');



function brand_taxonomy()
{

    $labels = array(
        'name' => _x('Brands', 'taxonomy general name', 'pe-core'),
        'singular_name' => _x('Brand', 'taxonomy singular name', 'pe-core'),
        'search_items' => __('Search Brands', 'pe-core'),
        'all_items' => __('All Brands', 'pe-core'),
        'parent_item' => __('Parent Brand', 'pe-core'),
        'parent_item_colon' => __('Parent Brand:', 'pe-core'),
        'edit_item' => __('Edit Brand', 'pe-core'),
        'update_item' => __('Update Brand', 'pe-core'),
        'add_new_item' => __('Add New Brand', 'pe-core'),
        'new_item_name' => __('New Brand Name', 'pe-core'),
        'menu_name' => __('Brand', 'pe-core'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'brand'),
    );

    register_taxonomy('brand', 'product', $args);
}


add_action('init', 'brand_taxonomy', 0);


function saren_file_upload_form()
{
    ob_start();
    ?>
    <div class="saren--file--upload">
        <input type="file" name="file--input[]" accept=".jpg, .jpeg, .png, .ai, .psd, .pdf, .eps" id="file--input"
            class="inputfile" data-multiple-caption="{count} files selected" multiple />
        <label for="file--input"><span></span>
            <?php
            echo file_get_contents(get_template_directory_uri() . '/assets/img/upload.svg');
            ?>
            <span class="upload--main"><?php echo esc_html('Upload your design files', 'WooCommerce') ?></span>

        </label>
    </div>
    <?php
    return ob_get_clean();
}

function saren_add_file_to_cart($cart_item_data, $product_id, $variation_id)
{
    if (isset($_FILES['file--input']) && !empty($_FILES['file--input']['name'][0])) {
        $allowed_file_types = array('jpg', 'jpeg', 'png', 'ai', 'psd', 'pdf', 'eps');
        $allowed_mime_types = array('image/jpeg', 'image/png', 'application/pdf', 'image/vnd.adobe.photoshop', 'application/postscript', 'application/illustrator');
        $max_file_size = 5 * 1024 * 1024;
        $file_urls = array();

        foreach ($_FILES['file--input']['name'] as $key => $value) {
            if ($_FILES['file--input']['name'][$key]) {

                $file_extension = strtolower(pathinfo($_FILES['file--input']['name'][$key], PATHINFO_EXTENSION));
                if (!in_array($file_extension, $allowed_file_types)) {
                    wc_add_notice(__('Invalıed file type: ' . esc_html($file_extension), 'woocommerce'), 'error');
                    continue;
                }

                $file_mime = mime_content_type($_FILES['file--input']['tmp_name'][$key]);
                if (!in_array($file_mime, $allowed_mime_types)) {
                    wc_add_notice(__('Invalid MIME type: ' . esc_html($file_mime), 'woocommerce'), 'error');
                    continue;
                }


                if ($_FILES['file--input']['size'][$key] > $max_file_size) {
                    wc_add_notice(__('File size is very large: ' . esc_html($_FILES['file--input']['name'][$key]), 'woocommerce'), 'error');
                    continue;
                }

                $upload = wp_upload_bits($_FILES['file--input']['name'][$key], null, file_get_contents($_FILES['file--input']['tmp_name'][$key]));

                if (!$upload['error']) {
                    $file_urls[] = $upload['url'];
                } else {
                    wc_add_notice(__('An error occured when uploading the file: ' . esc_html($_FILES['file--input']['name'][$key]), 'woocommerce'), 'error');
                }
            }
        }

        if (!empty($file_urls)) {
            $cart_item_data['saren_file_urls'] = $file_urls;
        }
    }
    return $cart_item_data;
}
add_filter('woocommerce_add_cart_item_data', 'saren_add_file_to_cart', 10, 3);


function saren_display_files_in_cart($item_data, $cart_item)
{
    if (isset($cart_item['saren_file_urls'])) {
        foreach ($cart_item['saren_file_urls'] as $file_url) {
            $item_data[] = array(
                'key' => __('File', 'woocommerce'),
                'value' => '<a href="' . esc_url($file_url) . '" target="_blank">' . __('View File', 'woocommerce') . '</a>',
            );
        }
    }
    return $item_data;
}
add_filter('woocommerce_get_item_data', 'saren_display_files_in_cart', 10, 2);

function saren_add_files_to_order($item, $cart_item_key, $values, $order)
{
    if (isset($values['saren_file_urls'])) {
        foreach ($values['saren_file_urls'] as $file_url) {
            $item->add_meta_data(__('File', 'woocommerce'), $file_url, true);
        }
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'saren_add_files_to_order', 10, 4);

function saren_display_files_in_order($item_id, $item, $order, $plain_text)
{
    $file_urls = wc_get_order_item_meta($item_id, 'File', false);

    if (!empty($file_urls)) {
        foreach ($file_urls as $file_url) {
            echo '<p><strong>' . __('File', 'woocommerce') . ':</strong> <a href="' . esc_url($file_url) . '" target="_blank">' . __('View File', 'woocommerce') . '</a></p>';
        }
    }
}
add_action('woocommerce_order_item_meta_end', 'saren_display_files_in_order', 10, 4);


function saren_save_extra_register_fields($customer_id)
{
    if (isset($_POST['firstname'])) {
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['firstname']));
    }


    if (isset($_POST['lastname'])) {
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['lastname']));
    }
}
add_action('woocommerce_created_customer', 'saren_save_extra_register_fields');

function saren_save_redirect_url()
{
    if (!is_user_logged_in() && (is_account_page() || is_checkout())) {
        if (!session_id()) {
            session_start();
        }
        $_SESSION['saren_redirect_url'] = esc_url($_SERVER['REQUEST_URI']);
    }
}
add_action('template_redirect', 'saren_save_redirect_url');


function saren_render_sorting_dropdown()
{
    $orderby_options = array(
        'menu_order' => __('Default sorting', 'woocommerce'),
        'popularity' => __('Popularity', 'woocommerce'),
        'rating' => __('Average rating', 'woocommerce'),
        'date' => __('Newness', 'woocommerce'),
        'price' => __('Price: low to high', 'woocommerce'),
        'price-desc' => __('Price: high to low', 'woocommerce'),
    );

    $current_orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'menu_order';

    echo '<div class="pe-select">';
    echo '<select name="orderby" class="orderby">';

    foreach ($orderby_options as $id => $name) {
        echo '<option value="' . esc_attr($id) . '" ' . selected($current_orderby, $id, false) . '>' . esc_html($name) . '</option>';
    }
    echo '</select>';
    echo '</div>';
}


function handle_woo_scripts()
{
    wp_deregister_script('wc-add-to-cart-variation');
    wp_deregister_script('wc-single-product');


    wp_register_script(
        'wc-add-to-cart-variation',
        WC()->plugin_url() . '/assets/js/frontend/add-to-cart-variation.min.js',
        array('jquery', 'wp-util', 'jquery-blockui'),
        WC()->version,
        true
    );

    wp_register_script(
        'wc-single-product',
        WC()->plugin_url() . '/assets/js/frontend/single-product.min.js',
        array('jquery'),
        WC()->version,
        true
    );

    wp_enqueue_script('wc-add-to-cart-variation');
    wp_enqueue_script('wc-single-product');

}

add_action('wp_enqueue_scripts', 'handle_woo_scripts', 5);


function saren_lost_password_form()
{
    ob_start();
    if (isset($_POST['user_login']) && !empty($_POST['user_login'])) {
        $errors = retrieve_password();
        if (!is_wp_error($errors)) {
            echo '<p class="message">Please check your email for the confirmation link.</p>';
        } else {
            echo '<p class="error">' . $errors->get_error_message() . '</p>';
        }
    }
    ?>
    <form method="post" action="">
        <p>
            <label for="user_login"><?php echo esc_html('Username or Email:', 'pe-core') ?></label>
            <input type="text" name="user_login" id="user_login" required>
        </p>
        <p>
            <input type="submit" value="Reset Password">
        </p>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_lost_password', 'saren_lost_password_form');

add_action('wp_logout', 'auto_redirect_after_logout');

function auto_redirect_after_logout()
{

    wp_redirect(home_url());
    exit();

}

add_action('woocommerce_product_after_variable_attributes', 'add_gallery_field_to_variations', 20, 3);
function add_gallery_field_to_variations($loop, $variation_data, $variation)
{
    ?>
    <tr>
        <td>

            <div class="variation--gallery--wrap">
                <label class="variation--gallery--label"
                    for="variation_gallery_images_<?php echo $variation->ID; ?>"><b><?php echo esc_html('Variation Gallery Images', 'saren') ?></b></label>
                <ul class="variation_images_gallery_images">
                    <?php
                    $images = get_post_meta($variation->ID, 'variation_gallery_images', true);
                    $images = $images ? explode(',', $images) : [];
                    foreach ($images as $image_id) {
                        $attachment_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                        echo '<li class="image" data-attachment_id="' . esc_attr($image_id) . '">
                    <img src="' . esc_url($attachment_url) . '" />
                    <a href="#" class="delete" title="Remove image">&times;</a>
                </li>';
                    }
                    ?>
                </ul>
                <input type="hidden" class="variation_gallery_images"
                    name="variation_gallery_images[<?php echo $variation->ID; ?>]"
                    value="<?php echo implode(',', $images); ?>">
                <button type="button"
                    class="add_variation_images button"><?php echo esc_html('Add Images', 'saren') ?></button>
            </div>
        </td>

    </tr>
    <?php
}

add_action('woocommerce_save_product_variation', 'save_variation_gallery_images', 10, 2);
function save_variation_gallery_images($variation_id, $i)
{
    if (isset($_POST['variation_gallery_images'][$variation_id])) {
        update_post_meta($variation_id, 'variation_gallery_images', sanitize_text_field($_POST['variation_gallery_images'][$variation_id]));
    }
}


add_action('wp_ajax_get_variation_gallery', 'get_variation_gallery');
add_action('wp_ajax_nopriv_get_variation_gallery', 'get_variation_gallery');

function get_variation_gallery()
{
    if (!isset($_POST['variation_id'])) {
        wp_send_json_error('Variation ID missing');
    }

    $variation_id = intval($_POST['variation_id']);
    $gallery_images = get_post_meta($variation_id, 'variation_gallery_images', true);
    $single_image_id = get_post_thumbnail_id($variation_id); 

    $gallery_html = '';

    if ($gallery_images) {
        $images = explode(',', $gallery_images);

        if ($single_image_id) {
            array_unshift($images, $single_image_id);
        }

        foreach ($images as $image_id) {
            $gallery_html .= wp_get_attachment_image($image_id, 'full');
        }
    } elseif ($single_image_id) {
       
        $gallery_html .= wp_get_attachment_image($single_image_id, 'full');
    } else {
        wp_send_json_error('No images found for this variation');
    }

    wp_send_json_success($gallery_html);
}

add_action('woocommerce_variation_options', function($loop, $variation_data, $variation) {
    ?>
    <div class="options_group linked_variation">
  
        <p class="form-row form-row-full">
            <label for="linked_variation_checkbox_<?php echo $loop; ?>">
                <?php esc_html_e('Linked?', 'woocommerce'); ?>
            </label>
            <input type="checkbox" 
                   class="linked_variation_checkbox" 
                   id="linked_variation_checkbox_<?php echo $loop; ?>" 
                   name="linked_variation_checkbox[<?php echo $loop; ?>]"
                   value="yes"
                   <?php checked(get_post_meta($variation->ID, '_linked_variation_checkbox', true), 'yes'); ?> />
        </p>

      
        <p class="form-row form-row-full linked_variation_select" style="display: none;">
            <label for="linked_variation_product_<?php echo $loop; ?>">
                <?php esc_html_e('Select Linked Product', 'woocommerce'); ?>
            </label>
            <select name="linked_variation_product[<?php echo $loop; ?>]" 
                    id="linked_variation_product_<?php echo $loop; ?>">
                <option value=""><?php esc_html_e('Select a product', 'woocommerce'); ?></option>
                <?php
               
                $products = wc_get_products(array('limit' => -1));
                foreach ($products as $product) {
                    echo '<option value="' . esc_attr($product->get_id()) . '" ' . selected(get_post_meta($variation->ID, '_linked_variation_product', true), $product->get_id(), false) . '>' . esc_html($product->get_name()) . '</option>';
                }
                ?>
            </select>
        </p>
    </div>
    <?php
}, 10, 3);


add_action('woocommerce_save_product_variation', function($variation_id, $i) {
 
    if (isset($_POST['linked_variation_checkbox'][$i])) {
        update_post_meta($variation_id, '_linked_variation_checkbox', 'yes');
    } else {
        delete_post_meta($variation_id, '_linked_variation_checkbox');
    }

    if (isset($_POST['linked_variation_product'][$i]) && !empty($_POST['linked_variation_product'][$i])) {
        update_post_meta($variation_id, '_linked_variation_product', sanitize_text_field($_POST['linked_variation_product'][$i]));
    } else {
        delete_post_meta($variation_id, '_linked_variation_product');
    }
}, 10, 2);


add_filter('woocommerce_product_data_tabs', function ($tabs) {
    $tabs['fbt_tab'] = [
        'label'    => __('Frequently Bought Together', 'saren'),
        'target'   => 'fbt_products_data',
        'class'    => [],
        'priority' => 80,
    ];
    $tabs['extra_options'] = array(
        'label'    => __( 'Extra Options', 'text-domain' ),
        'target'   => 'extra_options_product_data',
        'priority' => 21,
    );
    return $tabs;
});


add_action('woocommerce_product_data_panels', function () {
    global $post;

    $fbt_data = get_post_meta($post->ID, '_fbt_data', true);

    ?>
    <div id="fbt_products_data" class="panel woocommerce_options_panel hidden">
        <div class="options_group">
            <table class="widefat fbt-repeater">
                <thead>
                    <tr>
                        <th><?php _e('Product', 'saren'); ?></th>
                        <th><?php _e('Actions', 'saren'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($fbt_data) && is_array($fbt_data)) : ?>
                        <?php foreach ($fbt_data as $item) : ?>
                            <tr>
                                <td>
                                    <select name="fbt_products[]" class="wc-product-search" style="width: 100%;" data-placeholder="Search for a product..." data-action="woocommerce_json_search_products">
                                        <?php
                                        $product_id = esc_attr($item['product_id']);
                                        $product_name = get_the_title($product_id);
                                        echo "<option value='{$product_id}' selected>{$product_name}</option>";
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="button remove-fbt-row"><?php _e('Remove', 'saren'); ?></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <button type="button" class="button add-fbt-row"><?php _e('Add Product', 'saren'); ?></button>
        </div>
    </div>
    <?php
});

add_action('woocommerce_process_product_meta', function ($post_id) {
    if (isset($_POST['fbt_products'])) {
        $products = array_map('sanitize_text_field', $_POST['fbt_products']);

        $fbt_data = [];
        foreach ($products as $product_id) {
            $fbt_data[] = [
                'product_id' => $product_id
            ];
        }

        update_post_meta($post_id, '_fbt_data', $fbt_data);
    } else {
        delete_post_meta($post_id, '_fbt_data');
    }
});

add_action('wp_ajax_fbt_add_to_cart', 'fbt_add_to_cart');
add_action('wp_ajax_nopriv_fbt_add_to_cart', 'fbt_add_to_cart');

function fbt_add_to_cart() {
    if (!isset($_POST['products']) || empty($_POST['products'])) {
        wp_send_json_error(['message' => 'No products selected.']);
    }

    $products = $_POST['products'];

    foreach ($products as $product_id) {
        WC()->cart->add_to_cart($product_id);
    }

    wp_send_json_success();
}


add_action('wp_ajax_woocommerce_ajax_add_to_cart_fbt', 'handle_fbt_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart_fbt', 'handle_fbt_ajax_add_to_cart');

function handle_fbt_ajax_add_to_cart() {
    if (isset($_POST['products'])) {
        $products = json_decode(stripslashes($_POST['products']), true);

        foreach ($products as $product) {
            $product_id = absint($product['product_id']);
            $variation_id = absint($product['variation_id']);
            $quantity = 1; 

            WC()->cart->add_to_cart($product_id, $quantity, $variation_id);
        }

        wp_send_json_success([
            'fragments' => WC_AJAX::get_refreshed_fragments(),
            'cart_hash' => WC()->cart->get_cart_hash()
        ]);
    } else {
        wp_send_json_error(['error' => 'No products selected.']);
    }

    wp_die();
}

add_action( 'init', 'register_extra_options_taxonomy' );
function register_extra_options_taxonomy() {
    $labels = array(
        'name'              => __( 'Product Extras', 'text-domain' ),
        'singular_name'     => __( 'Extra Option', 'text-domain' ),
        'search_items'      => __( 'Search Extra Options', 'text-domain' ),
        'all_items'         => __( 'All Extra Options', 'text-domain' ),
        'edit_item'         => __( 'Edit Extra Option', 'text-domain' ),
        'update_item'       => __( 'Update Extra Option', 'text-domain' ),
        'add_new_item'      => __( 'Add New Extra Option', 'text-domain' ),
        'new_item_name'     => __( 'New Extra Option Name', 'text-domain' ),
        'menu_name'         => __( 'Extra Options', 'text-domain' ),
    );

    register_taxonomy(
        'extra_options',
        'product',
        array(
            'hierarchical' => false,
            'labels'       => $labels,
            'show_ui'      => true,
            'show_admin_column' => true,
            'query_var'    => true,
            'rewrite'      => array( 'slug' => 'extra-options' ),
        )
    );
}


add_action( 'extra_options_add_form_fields', 'add_display_type_field_to_taxonomy', 10, 2 );
function add_display_type_field_to_taxonomy() {
    ?>
    <div class="form-field">
        <label for="display_type"><?php _e( 'Display Type', 'text-domain' ); ?></label>
        <select name="display_type" id="display_type">
            <option value="checkbox"><?php _e( 'Checkbox', 'text-domain' ); ?></option>
            <option value="switcher"><?php _e( 'Switcher', 'text-domain' ); ?></option>
            <option value="select"><?php _e( 'Select', 'text-domain' ); ?></option>
            <option value="text"><?php _e( 'Text', 'text-domain' ); ?></option>
        </select>
        <p class="description"><?php _e( 'Select how this option will be displayed on the product page.', 'text-domain' ); ?></p>
    </div>
    <?php
}


add_action( 'extra_options_edit_form_fields', 'edit_display_type_field_to_taxonomy', 10, 2 );
function edit_display_type_field_to_taxonomy( $term ) {
    $display_type = get_term_meta( $term->term_id, 'display_type', true );
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="display_type"><?php _e( 'Display Type', 'text-domain' ); ?></label>
        </th>
        <td>
            <select name="display_type" id="display_type">
                <option value="checkbox" <?php selected( $display_type, 'checkbox' ); ?>><?php _e( 'Checkbox', 'text-domain' ); ?></option>
                <option value="switcher" <?php selected( $display_type, 'switcher' ); ?>><?php _e( 'Switcher', 'text-domain' ); ?></option>
                <option value="select" <?php selected( $display_type, 'select' ); ?>><?php _e( 'Select', 'text-domain' ); ?></option>
                <option value="text" <?php selected( $display_type, 'text' ); ?>><?php _e( 'Text', 'text-domain' ); ?></option>
            </select>
            <p class="description"><?php _e( 'Select how this option will be displayed on the product page.', 'text-domain' ); ?></p>
        </td>
    </tr>
    <?php
}

add_action( 'extra_options_edit_form_fields', 'add_price_field_for_other_display_types', 10, 2 );
function add_price_field_for_other_display_types( $term ) {
    $display_type = get_term_meta( $term->term_id, 'display_type', true );

    if ( $display_type !== 'select' ) {
        $price = get_term_meta( $term->term_id, 'price', true );
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="price"><?php _e( 'Price', 'text-domain' ); ?></label>
            </th>
            <td>
                <input type="number" name="price" id="price" value="<?php echo esc_attr( $price ); ?>" step="0.01" min="0" />
                <p class="description"><?php _e( 'Set a price for this option. This price will be added to the product price if selected.', 'text-domain' ); ?></p>
            </td>
        </tr>
        <?php
    }
}

add_action( 'edited_extra_options', 'save_price_for_other_display_types', 10, 2 );
function save_price_for_other_display_types( $term_id ) {
    $display_type = get_term_meta( $term_id, 'display_type', true );

    if ( $display_type !== 'select' && isset( $_POST['price'] ) ) {
        update_term_meta( $term_id, 'price', floatval( $_POST['price'] ) );
    } elseif ( $display_type === 'select' ) {
        delete_term_meta( $term_id, 'price' ); 
    }
}



add_action( 'created_extra_options', 'save_display_type_field_to_taxonomy', 10, 2 );
add_action( 'edited_extra_options', 'save_display_type_field_to_taxonomy', 10, 2 );
function save_display_type_field_to_taxonomy( $term_id ) {
    if ( isset( $_POST['display_type'] ) ) {
        update_term_meta( $term_id, 'display_type', sanitize_text_field( $_POST['display_type'] ) );
    }
}

add_action( 'extra_options_edit_form_fields', 'add_select_options_management_table', 10, 2 );
function add_select_options_management_table( $term ) {
    $display_type = get_term_meta( $term->term_id, 'display_type', true );

    // Sadece "select" tipi için tabloyu göster
    if ( $display_type === 'select' ) {
        $select_options = get_term_meta( $term->term_id, 'select_options', true );

        if ( ! is_array( $select_options ) ) {
            $select_options = [];
        }
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="select_options"><?php _e( 'Select Options', 'text-domain' ); ?></label>
            </th>
            <td>
                <table class="widefat" id="select-options-table">
                    <thead>
                        <tr>
                            <th><?php _e( 'Option Name', 'text-domain' ); ?></th>
                            <th><?php _e( 'Price', 'text-domain' ); ?></th>
                            <th><?php _e( 'Actions', 'text-domain' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( ! empty( $select_options ) ) : ?>
                            <?php foreach ( $select_options as $key => $option ) : ?>
                                <tr>
                                    <td>
                                        <input type="text" name="select_options[<?php echo esc_attr( $key ); ?>][name]" value="<?php echo esc_attr( $option['name'] ); ?>" placeholder="<?php _e( 'Option Name', 'text-domain' ); ?>" />
                                    </td>
                                    <td>
                                        <input type="number" name="select_options[<?php echo esc_attr( $key ); ?>][price]" value="<?php echo esc_attr( $option['price'] ); ?>" placeholder="<?php _e( 'Price', 'text-domain' ); ?>" step="0.01" />
                                    </td>
                                    <td>
                                        <button type="button" class="button remove-row"><?php _e( 'Remove', 'text-domain' ); ?></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <p>
                    <button type="button" class="button add-row"><?php _e( 'Add Option', 'text-domain' ); ?></button>
                </p>
                <p class="description"><?php _e( 'Add options for the select dropdown. Each option can have a price.', 'text-domain' ); ?></p>
            </td>
        </tr>

        <script>
        jQuery(document).ready(function($) {
           
            $('.add-row').on('click', function() {
                var row = '<tr>' +
                    '<td><input type="text" name="select_options[new][name][]" placeholder="<?php _e( 'Option Name', 'text-domain' ); ?>" /></td>' +
                    '<td><input type="number" name="select_options[new][price][]" placeholder="<?php _e( 'Price', 'text-domain' ); ?>" step="0.01" /></td>' +
                    '<td><button type="button" class="button remove-row"><?php _e( 'Remove', 'text-domain' ); ?></button></td>' +
                    '</tr>';
                $('#select-options-table tbody').append(row);
            });
            
            $('#select-options-table').on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });
        });
        </script>
        <?php
    }
}

add_action( 'edited_extra_options', 'save_select_options_management_table', 10, 2 );
function save_select_options_management_table( $term_id ) {
    $display_type = get_term_meta( $term_id, 'display_type', true );

    // Sadece "select" tipi için verileri kaydet
    if ( $display_type === 'select' && isset( $_POST['select_options'] ) ) {
        $select_options = [];

        if ( isset( $_POST['select_options']['new']['name'] ) ) {
            foreach ( $_POST['select_options']['new']['name'] as $key => $name ) {
                $price = $_POST['select_options']['new']['price'][ $key ] ?? 0;
                $select_options[] = [
                    'name'  => sanitize_text_field( $name ),
                    'price' => floatval( $price ),
                ];
            }
        }

        // Eski seçenekleri kaydet
        if ( isset( $_POST['select_options'] ) && is_array( $_POST['select_options'] ) ) {
            foreach ( $_POST['select_options'] as $key => $option ) {
                if ( isset( $option['name'] ) ) {
                    $select_options[ $key ] = [
                        'name'  => sanitize_text_field( $option['name'] ),
                        'price' => floatval( $option['price'] ?? 0 ),
                    ];
                }
            }
        }

        update_term_meta( $term_id, 'select_options', $select_options );
    } else {
        delete_term_meta( $term_id, 'select_options' );
    }
}
add_action( 'woocommerce_product_data_panels', 'add_extra_options_fields' );

function add_extra_options_fields() {
    global $post;

    // Ürüne atanmış ekstra seçenekleri al
    $selected_terms = get_post_meta( $post->ID, '_extra_options', true );

    // Eğer $selected_terms bir array değilse, boş bir array olarak ayarla
    if ( ! is_array( $selected_terms ) ) {
        $selected_terms = array();
    }

    ?>
    <div id="extra_options_product_data" class="panel woocommerce_options_panel hidden">
        <div class="options_group">
            <p class="form-field">
                <label for="extra_options"><?php _e( 'Extra Options', 'text-domain' ); ?></label>
                <select id="extra_options" name="extra_options[]" multiple="multiple" style="width: 100%;" class="wc-enhanced-select">
                    <?php
                    // Tüm "extra_options" terimlerini al
                    $terms = get_terms( array(
                        'taxonomy'   => 'extra_options',
                        'hide_empty' => false,
                    ) );

                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                        foreach ( $terms as $term ) {
                            // Seçili terimleri kontrol et ve seçili olanlara "selected" ekle
                            $is_selected = false;

                            // Eğer seçili terimlerde mevcutsa kontrol et
                            foreach ( $selected_terms as $selected ) {
                                if ( isset( $selected['key'] ) && $selected['key'] == $term->term_id ) {
                                    $is_selected = true;
                                    break;
                                }
                            }

                            echo '<option value="' . esc_attr( $term->term_id ) . '"' . ( $is_selected ? ' selected' : '' ) . '>' . esc_html( $term->name ) . '</option>';
                        }
                    }
                    ?>
                </select>
                <p class="description"><?php _e( 'Select the extra options for this product.', 'text-domain' ); ?></p>
            </p>
        </div>
    </div>
    <?php
}

add_action( 'woocommerce_process_product_meta', 'save_extra_options_for_product' );

function save_extra_options_for_product( $post_id ) {
    if ( isset( $_POST['extra_options'] ) && is_array( $_POST['extra_options'] ) ) {
        $extra_options = array();

        foreach ( $_POST['extra_options'] as $term_id ) {
            $term = get_term( $term_id, 'extra_options' );
            $price = get_term_meta( $term_id, 'price', true );

            if ( $term ) {
                $extra_options[] = array(
                    'key'   => $term_id,
                    'label' => $term->name,
                    'price' => floatval( $price ),
                    'value' => 0, 
                );
            }
        }

        update_post_meta( $post_id, '_extra_options', $extra_options );
    } else {
    
        delete_post_meta( $post_id, '_extra_options' );
    }
}

add_filter( 'woocommerce_add_cart_item_data', 'save_extra_options_to_cart', 10, 2 );

function save_extra_options_to_cart( $cart_item_data, $product_id ) {
    if ( isset( $_POST['extra_options'] ) && is_array( $_POST['extra_options'] ) ) {
        $selected_options = array();

        foreach ( $_POST['extra_options'] as $term_id => $value ) {
            $term = get_term( $term_id, 'extra_options' );
            $price = get_term_meta( $term_id, 'price', true );
            $display_type = get_term_meta( $term_id, 'display_type', true );

            if ( $term ) {
                if ( $display_type === 'checkbox' || $display_type === 'switcher' ) {
                    // Checkbox veya Switcher: Sadece seçili olanları ekle
                    if ( intval( $value ) === 1 ) {
                        $selected_options[] = array(
                            'key'   => $term_id,
                            'label' => $term->name,
                            'price' => floatval( $price ),
                            'value' => intval( $value ),
                        );
                    }
                } elseif ( $display_type === 'text' ) {
                    // Text: Eğer kullanıcı bir değer girmişse
                    if ( ! empty( $value ) ) {
                        $selected_options[] = array(
                            'key'   => $term_id,
                            'label' => $term->name,
                            'price' => floatval( $price ),
                            'value' => sanitize_text_field( $value ),
                        );
                    }
                } elseif ( $display_type === 'select' ) {
                    // Select: Seçilen değeri al
                    $select_options = get_term_meta( $term_id, 'select_options', true );
                    if ( ! empty( $select_options ) && is_array( $select_options ) ) {
                        foreach ( $select_options as $select_option ) {
                            if ( $select_option['name'] === $value ) {
                                $selected_options[] = array(
                                    'key'   => $term_id,
                                    'label' => $term->name . ' - ' . $value,
                                    'price' => floatval( $select_option['price'] ),
                                    'value' => sanitize_text_field( $value ),
                                );
                                break;
                            }
                        }
                    }
                }
            }
        }

        // Eğer seçilen ekstra seçenekler varsa, sepete ekle
        if ( ! empty( $selected_options ) ) {
            $cart_item_data['extra_options'] = $selected_options;
        }
    }

    return $cart_item_data;
}


add_action( 'woocommerce_before_calculate_totals', 'update_cart_price_with_extra_options', 10, 1 );

function update_cart_price_with_extra_options( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {

        if ( isset( $cart_item['extra_price_added'] ) && $cart_item['extra_price_added'] === true ) {
            continue;
        }

        if ( isset( $cart_item['extra_options'] ) && is_array( $cart_item['extra_options'] ) ) {
            $extra_price = 0;

            foreach ( $cart_item['extra_options'] as $option ) {
                if ( isset( $option['price'] ) ) {
                    $extra_price += floatval( $option['price'] );
                }
            }

            if ( $extra_price > 0 ) {
                $cart_item['data']->set_price( $cart_item['data']->get_price() + $extra_price );
            }

            $cart_item['extra_price_added'] = true;
        }
    }
}


add_action( 'woocommerce_checkout_create_order_line_item', 'save_extra_options_to_order', 10, 4 );

function save_extra_options_to_order( $item, $cart_item_key, $values, $order ) {
    if ( isset( $values['extra_options'] ) ) {
        $formatted_options = array();

        foreach ( $values['extra_options'] as $option ) {
            $formatted_options[] = sprintf(
                '%s (+%s)',
                $option['label'],
                wc_price( $option['price'] )
            );

        }

        $item->add_meta_data( 'Extra Options', implode( ', ', $formatted_options ) );

    }
}


function extraOptionsProductRender($product_id) {

		
		$extra_options = get_post_meta($product_id, '_extra_options', true);

		
		if (empty($extra_options) || !is_array($extra_options)) {
			return;
		}

		echo '<div class="product-extra-options">';

		foreach ($extra_options as $option) {
			$term_id = $option['key'];
			$label = $option['label'];
			$price = $option['price'];
			$display_type = get_term_meta($term_id, 'display_type', true);

			echo '<div class="extra-option option--' . $display_type . '">';
			echo '<label>';

			if ($display_type === 'checkbox' || $display_type === 'switcher') {
                if ($display_type === 'switcher') {
                    echo '<span class="extra--switcher">
                        <span></span>
                    </span>';
                }
				echo '<input type="hidden" name="extra_options[' . esc_attr($term_id) . ']" value="0">';
				echo '<input type="checkbox" name="extra_options[' . esc_attr($term_id) . ']" value="1"> ';
                echo '<span class="extra--label">' . esc_html($label) . '</span>';
                if (!empty($price)) {
                    echo '<span class="extra--price">+' . wc_price($price) . '</span>';
                }
    
			} elseif ($display_type === 'text') {
                echo '<span class="extra--label">' . esc_html($label) . '</span>';
                if (!empty($price)) {
                    echo '<span class="extra--price">+' . wc_price($price) . '</span>';
                }    
				echo '<input type="text" name="extra_options[' . esc_attr($term_id) . ']" placeholder=" "> ';
			} elseif ($display_type === 'select') {
                echo '<span class="extra--label">' . esc_html($label) . '</span>';

				$select_options = get_term_meta($term_id, 'select_options', true);

				if (!empty($select_options) && is_array($select_options)) {

					echo '<select name="extra_options[' . esc_attr($term_id) . ']">';
					foreach ($select_options as $select_option) {
						echo '<option value="' . esc_attr($select_option['name']) . '">' . esc_html($select_option['name']) . ' (+ ' . wc_price($select_option['price']) . ')</option>';
					}
					echo '</select>';
				}
			}
		
			echo '</label>';
			echo '</div>';
		}

		echo '</div>';


}

add_filter('woocommerce_ajax_variation_threshold', function($threshold) {
    return 60; 
}, 10);

function pe_toggle_wishlist() {
    $product_id = intval($_POST['product_id']);
   
    if (!$product_id) {
        wp_send_json_error(['message' => esc_html__('Invalid Product', 'pe-core')]);
        wp_die();
    }

    if (is_user_logged_in()) {

        $user_id = get_current_user_id();
        $wishlist = get_user_meta($user_id, 'pe_wishlist', true);
        $wishlist = is_array($wishlist) ? $wishlist : [];
            

        if (in_array($product_id, $wishlist)) {
            $wishlist = array_diff($wishlist, [$product_id]);
            $status = 'removed';
        } else {
            $wishlist[] = $product_id;
            $status = 'added';
        }

        update_user_meta($user_id, 'pe_wishlist', $wishlist);

    } else {

        $wishlist = isset($_COOKIE['pe_wishlist']) ? json_decode(stripslashes($_COOKIE['pe_wishlist']), true) : [];
        $wishlist = is_array($wishlist) ? $wishlist : [];

        if (in_array($product_id, $wishlist)) {
            $wishlist = array_diff($wishlist, [$product_id]);
            $status = 'removed';
        } else {
            $wishlist[] = $product_id;
            $status = 'added';
        }

        setcookie('pe_wishlist', json_encode($wishlist), time() + (86400 * 30), "/");
    }

    if ($status === 'added') {

        if (isset($_POST['settings'])) {

            $settings =  $_POST['settings'];

            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'post__in' => array($product_id),
            );
    
            $the_query = new \WP_Query($args);
    
            while ($the_query->have_posts()):
                $the_query->the_post();
    
            $product = wc_get_product($product_id);
            $classes = 'saren--single--product inner--anim added--to--wishlist carousel--item ' . $settings['product_style'] . ' ' .' sp--archive--' . $settings['products_archive_style'];
    
            ob_start();
            sarenProductRender($settings, $product, $classes, null); 
            $product_html = ob_get_clean();
    
            endwhile;
            wp_reset_query();
        
            wp_send_json_success([
                'status' => $status,
                'wishlist' => array_values($wishlist),
                'product_html' => $product_html,
                'settings' => $settings, 
            ]);
        } else {


        wp_send_json_success([
            'status' => $status,
            'wishlist' => array_values($wishlist),
        ]);

        }


    
    } else {

        wp_send_json_success([
            'status' => $status,
            'wishlist' => array_values($wishlist),
        ]);
    
    }


    wp_die();
}
add_action('wp_ajax_pe_toggle_wishlist', 'pe_toggle_wishlist');
add_action('wp_ajax_nopriv_pe_toggle_wishlist', 'pe_toggle_wishlist');


function peWishlistButton($id , $settings) {

    $product_id = $id;

    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $wishlist = get_user_meta($user_id, 'pe_wishlist', true);
        $wishlist = is_array($wishlist) ? $wishlist : [];

    } else {
        $wishlist = isset($_COOKIE['pe_wishlist']) ? json_decode(stripslashes($_COOKIE['pe_wishlist']), true) : [];
        $wishlist = is_array($wishlist) ? $wishlist : [];
    }

    $is_in_wishlist = in_array($product_id, $wishlist) ? 'in--wishlist' : '';

    if ($settings['wishlist_use_custom_icon'] === 'yes') {

        ob_start();
        \Elementor\Icons_Manager::render_icon($settings['wishlist_add_icon'], ['aria-hidden' => 'true']);
        $addIcon = ob_get_clean();

        ob_start();
        \Elementor\Icons_Manager::render_icon($settings['wishlist_added_icon'], ['aria-hidden' => 'true']);
        $addedIcon = ob_get_clean();

    } else {
        $svgPath = get_template_directory() . '/assets/img/bookmark.svg';
        $addIcon = file_get_contents($svgPath);

        $svgPath2 = get_template_directory_uri() . '/assets/img/bookmark-fill.svg';
        $addedIcon = file_get_contents($svgPath2);
    }

    $icon = '<span class="wishlist--add--icon">' . $addIcon . '</span><span class="wishlist--added--icon">' . $addedIcon . '</span>';
    ?>

                                    <div data-product-id="<?php echo $product_id; ?>"
                                        class="pe-wishlist-btn pe--styled--object <?php echo $is_in_wishlist; ?>" data-add-caption="<?php echo $settings['wishlist_add_caption'] ?>" data-added-caption="<?php echo $settings['wishlist_added_caption'] ?>">

                                        <div class="wishlist-icon">
            <?php echo '<span data-product-id="' . esc_attr($product_id) . '">' . $icon . '</span>'; ?>
                                        </div>

                                    </div> 
                                    <?php

}


function pe_toggle_compare() {
    $product_id = intval($_POST['product_id']);

    if (!$product_id) {
        wp_send_json_error(['message' => esc_html__('Invalid Product', 'pe-core')]);
        wp_die();
    }

    if (is_user_logged_in()) {
     
        $user_id = get_current_user_id();
        $compare = get_user_meta($user_id, 'pe_compare', true);
        $compare = is_array($compare) ? $compare : [];

        if (in_array($product_id, $compare)) {
            $compare = array_diff($compare, [$product_id]);
            $status = 'removed';
        } else {
            $compare[] = $product_id;
            $status = 'added';
        }

        update_user_meta($user_id, 'pe_compare', $compare);

    } else {
      
        $compare = isset($_COOKIE['pe_compare']) ? json_decode(stripslashes($_COOKIE['pe_compare']), true) : [];
        $compare = is_array($compare) ? $compare : [];

        if (in_array($product_id, $compare)) {
            $compare = array_diff($compare, [$product_id]);
            $status = 'removed';
        } else {
            $compare[] = $product_id;
            $status = 'added';
        }

        setcookie('pe_compare', json_encode($compare), time() + (86400 * 30), "/"); 
    }

    if ($status === 'added') {

        if (isset($_POST['settings'])) {

            $settings =  $_POST['settings'];

            $product = wc_get_product($product_id);
            $product_link = get_permalink($product_id);
    
            ob_start();
    
            sarenCompareItemRender($settings, $product, $product_id, $product_link);
    
            $product_html = ob_get_clean();
    
            wp_send_json_success([
                'status' => $status, 
                'compare' => array_values($compare),
                'product_html' => $product_html,
                'settings' => $settings
                ]
                
            );

        
        } else {

            wp_send_json_success([
                'status' => $status, 
                'compare' => array_values($compare)]
            );


        }

       
      
    } else {

        wp_send_json_success([
            'status' => $status, 
            'compare' => array_values($compare)]
        );
    }

  
    wp_die();
}

add_action('wp_ajax_pe_toggle_compare', 'pe_toggle_compare');
add_action('wp_ajax_nopriv_pe_toggle_compare', 'pe_toggle_compare'); 


function peCompareButton($id , $settings) {

    $product_id = $id;
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $compare = get_user_meta($user_id, 'pe_compare', true);
        $compare = is_array($compare) ? $compare : [];

    } else {
        $compare = isset($_COOKIE['pe_compare']) ? json_decode(stripslashes($_COOKIE['pe_compare']), true) : [];
        $compare = is_array($compare) ? $compare : [];
    }

    $is_in_compare = in_array($product_id, $compare) ? 'in--compare' : '';

    if ($settings['compare_use_custom_icon'] === 'yes') {

        ob_start();
        \Elementor\Icons_Manager::render_icon($settings['compare_add_icon'], ['aria-hidden' => 'true']);
        $addIcon = ob_get_clean();

        ob_start();
        \Elementor\Icons_Manager::render_icon($settings['compare_added_icon'], ['aria-hidden' => 'true']);
        $addedIcon = ob_get_clean();

    } else {
        $svgPath = get_template_directory() . '/assets/img/playlist-add.svg';
        $addIcon = file_get_contents($svgPath);

        $svgPath2 = get_template_directory_uri() . '/assets/img/playlist-added.svg';
        $addedIcon = file_get_contents($svgPath2);
    }

    $icon = '<span class="compare--add--icon">' . $addIcon . '</span><span class="compare--added--icon">' . $addedIcon . '</span>';
    ?>

                                    <div data-product-id="<?php echo $product_id; ?>"
                                        class="pe-compare-btn pe--styled--object <?php echo $is_in_compare; ?>" data-add-caption="<?php echo $settings['compare_add_caption'] ?>" data-added-caption="<?php echo $settings['compare_added_caption'] ?>">

                                        <div class="compare-icon">
            <?php echo '<span data-product-id="' . esc_attr($product_id) . '">' . $icon . '</span>'; ?>
                                        </div>

                                    </div> 
                                    <?php

}


function pe_get_products() {
    
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $args = isset($_POST['args']) ? json_decode(stripslashes($_POST['args']), true) : false;
    $settings = isset($_POST['settings']) ? json_decode(stripslashes($_POST['settings']), true) : false;
    
    if (!$args || !is_array($args)) {
        wp_send_json_error(['message' => esc_html__('Invalid query parameters', 'pe-core')]);
        wp_die();
    }

    $args['offset'] = $offset * $args['posts_per_page'];

    if (isset($_POST['filters'])) {

        $filters = $_POST['filters'];
          $taxQuery = [];
        $taxQuery = [
            'relation' => 'IN',
        ];

        $attributes = wc_get_attribute_taxonomies();

        foreach ($attributes as $key => $attr) {
            $name = $attr->attribute_name;

            if ($filters[$name]) {
                $taxQuery[] = [
                    'taxonomy' => 'pa_' . $name,
                    'field' => 'slug',
                    'terms' => $filters[$name],
                    'operator' => 'IN'
                ];
            }
        }

        if ($filters['product_cat'] && $filters['product_cat'] !== 'all') {

            $taxQuery[] = [
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $filters['product_cat'],
                'operator' => 'IN'
            ];
        }

        if ($filters['product_tag']) {

            $taxQuery[] = [
                'taxonomy' => 'product_tag',
                'field' => 'id',
                'terms' => $filters['product_tag'],
                'operator' => 'IN'
            ];
        }

        if ($filters['brand']) {

            $taxQuery[] = [
                'taxonomy' => 'brand',
                'field' => 'id',
                'terms' => $filters['brand'],
                'operator' => 'IN'
            ];
            
        }

        $attributes = wc_get_attribute_taxonomies();

        foreach ($attributes as $attribute) {
            $attr = 'pa_' . $attribute->attribute_name;
            if ($filters[$attr]) {
                $taxQuery[] = [
                    'taxonomy' => $attr,
                    'field' => 'slug',
                    'terms' => array_map('sanitize_text_field', $filters[$attr]),
                    'operator' => 'IN'
                ];
            }
        }

     $args['tax_query'] = $taxQuery;

     if ($filters['orderby']) {
        $orderby = sanitize_text_field($filters['orderby']);

        switch ($orderby) {
            case 'menu_order':
                $args['orderby'] = 'menu_order title';
                $args['order'] = 'ASC';
                break;
            case 'popularity':
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                break;
            case 'rating':
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'date':
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
            case 'price':
                $args['meta_key'] = '_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                break;
            case 'price-desc':
                $args['meta_key'] = '_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            default:
                $args['orderby'] = 'menu_order';
                $args['order'] = 'ASC';
                break;
        }
    }

    if ($filters['sale_products'] && $filters['sale_products'] == 1) {
        $args['post__in'] = wc_get_product_ids_on_sale();
    }

    if ($filters['min_price'] || $filters['max_price']) {
        $meta_query = array('relation' => 'AND');

        if ($filters['min_price'] && !empty($filters['min_price'])) {
            $meta_query[] = array(
                'key' => '_price',
                'value' => floatval($filters['min_price']),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        if ($filters['max_price'] && !empty($filters['max_price'])) {
            $meta_query[] = array(
                'key' => '_price',
                'value' => floatval($filters['max_price']),
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }

        $args['meta_query'] = $meta_query;
    } 

    }

    $the_query = new \WP_Query($args);
    $products = [];
    $cursor = false;

    $masonryItem =  $settings['products_archive_style'] === 'masonry' ? 'product--masonry--item' : '';

    $classes = 'saren--single--product inner--anim carousel--item ' . $settings['product_style'] . ' ' . $masonryItem . ' ' . ' sp--archive--' . $settings['products_archive_style'];$settings['products_archive_style'];

    while ($the_query->have_posts()):
        $the_query->the_post();

        ob_start();
        if ($settings['product_style'] === 'detailed') {
            sarenProductBox($settings, wc_get_product(), $classes, $cursor);
        } else if ($settings['products_archive_style'] === 'list') {
            sarenProductListRender($settings, wc_get_product(), $classes, $cursor);
        } else {
            sarenProductRender($settings, wc_get_product(), $classes, $cursor);
        }
        $product_html = ob_get_clean();
        $products[] = $product_html;

    endwhile;
    
    wp_reset_postdata();

    wp_send_json_success([
        'products' => $products,
        'settings' => $settings
    ]);

    wp_die();
}

add_action('wp_ajax_pe_get_products', 'pe_get_products');
add_action('wp_ajax_nopriv_pe_get_products', 'pe_get_products');
