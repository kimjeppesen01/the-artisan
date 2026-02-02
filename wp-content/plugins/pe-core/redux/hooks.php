<?php

//Pe Core Custom CSS

function pe_core_custom_css()
{
    $option = get_option('pe-redux');

    if (!empty($option['css_editor'])) {

        echo '<style type="text/css">' . $option['css_editor'] . '</style>';

    }

}
add_action('wp_head', 'pe_core_custom_css');



function pe_core_activate_html()
{

    $isActivated = get_option('is_activated');
    $user = get_option('activated_username');
    $code = get_option('activated_code');
    $date = get_option('activated_purchase_date');
    $support_date = get_option('activated_support_date');


    if ($isActivated) {
        $status = 'active';

    } else {

        $status = 'inactive';
    }

    ?>

    <div class="pe_core-theme-status <?php echo esc_attr($status) ?>">

        <div class="theme-status-info">

            <?php if ($isActivated) { ?>

                <div class="active-info">

                    <h2 class="tna"><?php echo esc_html('Theme is activated.', 'pe-core') ?></h2>

                    <p>
                        <?php
                        echo esc_html("Congratulations! Your theme is activated and ready to use! You can import demo content by navigating 'Appearance -> Import Demo Content' on your dashboard.", 'pe-core');

                        ?>
                    </p>

                </div>

            <?php } else { ?>

                <div class="inactive-info">

                    <h2 class="tna"><?php echo esc_html('Theme is not activated.', 'pe-core') ?></h2>

                    <p>
                        <?php
                        echo esc_html("To start using the theme; you need to activate the theme with your purchase code from 'ThemeForest'."), 'pe-core';
                        echo '<u>' . esc_html("If you don't know how to get your purchase code ", 'pe-core');
                        echo '</u><a href="https://themes.pethemes.com/saren/docs/#sec-02-03" target="_blank"><b>' . esc_html('click here', 'pe-core') . '</b></a>';
                        echo esc_html(" to learn how to get it.", 'pe-core');



                        ?>
                    </p>



                </div>
            <?php } ?>

        </div>

        <div class="pe_core-activate">

            <form class="purchase_form" method="POST">

                <?php
                //  wp_nonce_field('pe_core_activate_action', 'pe_core_activate_nonce'); 
                ?>

                <div class="code-wrap">

                    <?php if ($isActivated) { ?>

                        <div class="activated-code-hold">

                            <input disabled class="deactivate-button" type="password" name="purchase_code"
                                placeholder="<?php echo esc_attr('Purchase Code', 'pe-core') ?>"
                                value="<?php echo esc_attr($code) ?>">

                            <input type="hidden" name="act" id="act" value="deactivate">

                        </div>

                        <button class="deactivate-button" type="submit"><?php echo esc_html('Dectivate', 'pe-core') ?></button>

                    <?php } else { ?>

                        <div class="activated-code-hold">

                            <input type="text" name="purchase_code"
                                placeholder="<?php echo esc_attr('Purchase Code', 'pe-core') ?>">

                            <input type="hidden" name="act" id="act" value="activate">
                        </div>

                        <button class="activate-button" type="submit"><?php echo esc_html('Activate', 'pe-core') ?></button>

                    <?php } ?>

                </div>

                <p class="act-warning"></p>

                <?php if ($isActivated) { ?>

                    <div class="contents-wrap">

                        <div class="cont-wrap">

                            <label for="username"><?php echo esc_html('Username', 'pe-core') ?></label><br>
                            <input id="username" type="text" name="username" value="<?php echo esc_attr($user) ?>">

                        </div>

                        <div class="cont-wrap">

                            <label for="purchase_date"><?php echo esc_html('Purcahsed At:', 'pe-core') ?></label><br>
                            <input id="purchase_date" type="text" name="purchase_date" value="<?php echo esc_attr($date) ?>">
                        </div>
                        <div class="cont-wrap">

                            <label for="support_end"><?php echo esc_html('Supported Until:', 'pe-core') ?></label><br>
                            <input id="support_end" type="text" name="support_end"
                                value="<?php echo esc_attr($support_date) ?>">
                        </div>

                    </div>

                <?php } ?>

            </form>

        </div>

    </div>

    <?php
}

add_action('redux/pe-redux/panel/before', 'pe_core_activate_html');

add_action('wp_ajax_pe_core_handle_ajax_request', 'pe_core_handle_ajax_request');
add_action('wp_ajax_nopriv_pe_core_handle_ajax_request', 'pe_core_handle_ajax_request');

function pe_core_handle_ajax_request()
{


    // if (!isset($_POST['pe_core_activate_nonce']) || !wp_verify_nonce($_POST['pe_core_activate_nonce'], 'pe_core_activate_action')) {
    //     echo json_encode(array("is_valid" => false, "message" => "Nonce verification failed."));
    //     wp_die(); 
    // }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $purchaseCode = $_POST['purchase_code'];

        $act = $_POST['act']; // Get the action (activate or deactivate)

        $url = "http://themes.pethemes.com/nayla/activate/index.php?purchase_code=" . $purchaseCode;

        $response = wp_remote_get($url);


        if (is_wp_error($response)) {

            echo "Error: " . $response->get_error_message();

        } else {

            $body = wp_remote_retrieve_body($response);
            $envatoCheck = json_decode($body);

            if ($envatoCheck) {

                $username = isset($envatoCheck->buyer) ? $envatoCheck->buyer : false;

                $purchaseDate = isset($envatoCheck->sold_at) ? substr($envatoCheck->sold_at, 0, 10) : false;
                $supportDate = isset($envatoCheck->supported_until) ? substr($envatoCheck->supported_until, 0, 10) : false;
                $activeURL = site_url();

                if ($username) {

                    $conn = "http://themes.pethemes.com/nayla/activate/connect.php?purchase_code=" . $purchaseCode . '&username=' . $username . '&purchase_date=' . $purchaseDate . '&supported_until=' . $supportDate . '&url=' . $activeURL . '&act=' . $act;

                    $response = wp_remote_get($conn);

                    if (is_wp_error($response)) {
                        $error_message = $response->get_error_message();
                        $result = array(
                            "is_valid" => false,
                            "error" => $error_message
                        );
                        echo json_encode($result);
                    } else {
                        $body = wp_remote_retrieve_body($response);
                        $decoded_body = json_decode($body, true); // Decode the response as an array

                        if ($decoded_body) {
                            // If the response is a valid JSON
                            $message = isset($decoded_body['message']) ? $decoded_body['message'] : '';
                            $is_exists = isset($decoded_body['is_exists']) ? $decoded_body['is_exists'] : '';
                            $url = isset($decoded_body['URL']) ? $decoded_body['URL'] : false;
                            $added = isset($decoded_body['is_added']) ? $decoded_body['is_added'] : false;
                        }

                        $result = array(
                            "is_valid" => true,
                            "username" => $username,
                            "sold_at" => $purchaseDate,
                            "supported" => $supportDate,
                            "message" => $message,
                            "is_exists" => $is_exists,
                            "url" => $url,
                            "act" => $act,
                            'conm' => $conn,
                            'added' => $added
                        );


                        if ($added) {

                            update_option('is_activated', true);
                            update_option('activated_username', $username);
                            update_option('activated_purchase_date', $purchaseDate);
                            update_option('activated_support_date', $supportDate);
                            update_option('activated_code', $purchaseCode);

                        }



                        if ($is_exists && $act === 'deactivate') {

                            update_option('is_activated', false);
                            update_option('activated_username', '');
                            update_option('activated_purchase_date', '');
                            update_option('activated_support_date', '');
                            update_option('activated_code', '');
                        }

                        echo json_encode($result);
                    }

                } else {

                    $result = array(
                        "is_valid" => false,
                        "message" => "Purchase code is not valid. If you think there's a mistake please contact with <a href='https://pethemes.ticksy.com' target='_blank'>theme support</a>"
                    );

                    echo json_encode($result);

                }
            } else {

                echo "Error";
            }
        }

        wp_die();
    }
}


function check_is_still_active()
{

    $isActivated = get_option('is_activated');


    if ($isActivated) {

        $user = get_option('activated_username');
        $date = get_option('activated_purchase_date');
        $support_date = get_option('activated_support_date');
        $acturl = site_url();


        $purchase_code = get_option('activated_code');
        $url = "http://themes.pethemes.com/nayla/activate/index.php?purchase_code=" . $purchase_code;

        $response = wp_remote_get($url);

        if (is_wp_error($response)) {

            echo "Error: " . $response->get_error_message();

        } else {

            $body = wp_remote_retrieve_body($response);
            $envatoCheck = json_decode($body);
            $username = isset($envatoCheck->buyer) ? $envatoCheck->buyer : false;
            $susername = isset($envatoCheck->busyer) ? $envatoCheck->busyer : false;

            if (!$username) {

                $act = 'deactivate';

                $conn = "http://themes.pethemes.com/nayla/activate/connect.php?purchase_code=" . $purchase_code . '&username=' . $user . '&purchase_date=' . $date . '&supported_until=' . $support_date . '&url=' . $acturl . '&act=' . $act;

                wp_remote_post($conn);

                update_option('is_activated', false);
                update_option('activated_username', '');
                update_option('activated_purchase_date', '');
                update_option('activated_support_date', '');
                update_option('activated_code', '');

            } else {
                return;
            }

        }

    }

}
add_action('redux/page/pe-redux/load', 'check_is_still_active');

function wpb_admin_notice_warn()
{
    $isActivated = get_option('is_activated');

    if (!$isActivated) {

        echo '<div class="notice notice-error">
        <h3>Theme is not activated.</h3>
     <p>For using theme features such as <b>One Click Demo Import , Custom Elementor Widgets , Theme Options</b> you need to activate the theme with your purchase code. Please navigate to <b>"Theme Options"</b> panel and activate your copy.</p>
      </div>';

    }

}
add_action('admin_notices', 'wpb_admin_notice_warn');


add_action('redux/page/pe-redux/sections/after', 'pe_core_disabled');


function pe_core_disabled()
{

    $isActivated = get_option('is_activated');

    if (!$isActivated) {
        ?>

        <div class="pe_core-settings-disabled"></div>
        <div class="nsd-warn">
            <h4>You need to activate the theme with your purchase code to gain access to theme options.</h4>
        </div>

        <?php
    }

}