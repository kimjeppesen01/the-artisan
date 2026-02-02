<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peAccount extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'peaccount';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Account/Login', 'pe-core');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-my-account pe-widget';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['pe-dynamic'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function _register_controls()
    {


        // Tab Title Control
        $this->start_controls_section(
            'section_tab_title',
            [
                'label' => __('Account/Login', 'pe-core'),
            ]
        );


        $this->add_control(
            'acc_button_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'render_type' => 'template',
                'prefix_class' => 'button--style--',
                'options' => [
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core'),
                    'icon_text' => esc_html__('Icon - Text', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'acc_text',
            [
                'label' => esc_html__('Account Text', 'pe-core'),
                'default' => esc_html__('Account', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => ['acc_button_style' => ['text', 'icon_text']],
            ]
        );

        $this->add_control(
            'acc_login_text',
            [
                'label' => esc_html__('Login Text', 'pe-core'),
                'description' => esc_html__('Will be used when the visitor not logged in.', 'pe-core'),
                'default' => esc_html__('Login', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => ['acc_button_style' => ['text', 'icon_text']],
            ]
        );

        $this->add_control(
            'acc_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => ['acc_button_style' => ['icon', 'icon_text']],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '0' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--account--pop--button' => '--iconSize: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pe--account--button--icon' => '--iconSize: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pe--account--wrap > a' => '--iconSize: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['acc_button_style' => ['icon', 'icon_text']],
            ]
        );


        $this->add_control(
            'acc_button_behavior',
            [
                'label' => esc_html__('Button Behavior', 'pe-core'),
                'description' => esc_html__('When user not logged in.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'to-page',
                'options' => [
                    'to-page' => esc_html__('To Page', 'pe-core'),
                    'open-popup' => esc_html__('Open Popup', 'pe-core'),
                ],
            ]
        );

        popupOptions($this, ['acc_button_behavior' => 'open-popup']);

        $this->add_control(
            'acc_dropdown_style',
            [
                'label' => esc_html__('Dropdown Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom',
                'prefix_class' => 'acc--dropdown--',
                'options' => [
                    'bottom' => esc_html__('Bottom', 'pe-core'),
                    'right' => esc_html__('Right', 'pe-core'),
                ],
            ]
        );


        $this->add_control(
            'acc_link',
            [
                'label' => esc_html__('Login Page Link', 'pe-core'),
                'description' => esc_html__('The login page URL needed (when user logged in the button will be redirected automatically to "My Account" page).', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow', 'custom_attributes'],
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'label_block' => true,
                'condition' => ['acc_button_behavior' => 'to-page'],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'dropdown_styles',
            [
                'label' => esc_html__('Dropdown Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );



        $this->add_control(
            'dropdown_on_editor',
            [
                'label' => esc_html__('Show Dropdown (Editor)', 'pe-core'),
                'description' => esc_html__('Useful when editing dropdown.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'dropdown--editor',
                'prefix_class' => '',
                'render_type' => 'template',
                'default' => '',
            ]
        );

        $this->add_control(
            'dropdown_has_backdrop',
            [
                'label' => esc_html__('Backdrop Filter', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'dropdown--has--backdrop',
                'prefix_class' => '',
                'default' => '',
            ]
        );


        $this->add_responsive_control(
            'dropdown_bg_backdrop_blur',
            [
                'label' => esc_html__('Bluriness', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'condition' => [
                    'dropdown_has_backdrop' => 'dropdown--has--backdrop',
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--account--dropdown' => '--backdropBlur: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'dropdown_backdrop_color',
            [
                'label' => esc_html__('Backdrop Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pe--account--dropdown' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'dropdown_has_backdrop' => 'dropdown--has--backdrop',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_border',
                'label' => esc_html__('Dropdown Border', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--account--dropdown',
            ]
        );

        $this->add_responsive_control(
            'dropdown_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pe--account--dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'dropdown_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pe--account--dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        objetAbsolutePositioning($this, '.pe--account--dropdown', 'dropdown_', 'Dropdown');

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_items_border',
                'label' => esc_html__('Items Border', 'pe-core'),
                'selector' => '{{WRAPPER}} nav.woocommerce-MyAccount-navigation ul li',
            ]
        );

        $this->add_responsive_control(
            'dropdown_items_border_radius',
            [
                'label' => esc_html__('Items Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} nav.woocommerce-MyAccount-navigation ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'dropdown_items_padding',
            [
                'label' => esc_html__('Items Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} nav.woocommerce-MyAccount-navigation ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        objectStyles($this, 'account_pop_', 'Button', '.pe--account--pop--button.pe--styled--object', true);
        $this->start_controls_section(
            'input_styles',
            [
                'label' => esc_html__('Input Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'inputs_alignment',
            [
                'label' => esc_html__('Inputs Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} input[type=text],
                    {{WRAPPER}} input[type=email],
                    {{WRAPPER}} input[type=password],
                    {{WRAPPER}} .woocommerce-form-login__rememberme,
                    {{WRAPPER}} .lost--password-heading.login--form--heading p' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        objetAbsolutePositioning($this, '.saren--login-sec form label:not(.woocommerce-form-login__rememberme)', 'form_labels', 'Form Labels');


        objectStyles($this, 'widget_input_', 'Input', 'input', true, false, false, true);
        $this->end_controls_section();
        objectStyles($this, 'widget_input__button_', 'Input Button', '.saren--login-sec button.woocommerce-button ,{{WRAPPER}} .saren--login-sec .login--form--heading', true, false, true, true);


        $this->start_controls_section(
            'popup_styles_sec',
            [
                'label' => esc_html__('Popup Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['acc_button_behavior' => 'open-popup'],
            ]
        );

        popupStyles($this, ['acc_button_behavior' => 'open-popup']);
        $this->end_controls_section();

        pe_color_options($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (!class_exists('WooCommerce')) { 
            return false;
        }

        $account_page_url = wc_get_page_permalink('myaccount');

        $object = '';

        if ($settings['acc_button_style'] === 'text') {

            if (is_user_logged_in()) {
                $object = $settings['acc_text'];
            } else {
                $object = $settings['acc_login_text'];
            }

        } else if ($settings['acc_button_style'] === 'icon') {
            if ($settings['acc_icon']['value']) {
                ob_start();
                \Elementor\Icons_Manager::render_icon($settings['acc_icon'], ['aria-hidden' => 'true']);
                $object = ob_get_clean();

            } else {
                $svgPath = plugin_dir_path(__FILE__) . '../assets/img/person.svg';
                $object = file_get_contents($svgPath);
            }

        } else if ($settings['acc_button_style'] === 'icon_text') {
            if ($settings['acc_icon']['value']) {
                ob_start();
                \Elementor\Icons_Manager::render_icon($settings['acc_icon'], ['aria-hidden' => 'true']);
                $icon = ob_get_clean();
            }

            if (is_user_logged_in()) {
                $text = $settings['acc_text'];
            } else {
                $text = $settings['acc_login_text'];
            }
            $object = '<span>' . $icon . '</span><span>' . $text . '</span>';
        }

        $loggedIn = false;

        if (\Elementor\Plugin::$instance->editor->is_edit_mode() && $settings['dropdown_on_editor'] !== 'dropdown--editor') {
            $loggedIn = false;
        } else if (is_user_logged_in()) {
            $loggedIn = true;
        }

        ?>

        <div class="pe--account <?php echo $loggedIn ? 'is--logged--in' : ''; ?>">
            <div class="pe--account--wrap">

                <?php if (!$loggedIn) {
                    if ($settings['acc_button_behavior'] === 'to-page' && !$loggedIn) {
                        if (!empty($settings['acc_link']['url'])) {
                            $this->add_link_attributes('acc_link', $settings['acc_link']);
                        }
                        ?>

                        <a class="pe--account--button--icon pe--account--pop--button pe--styled--object" <?php echo $this->get_render_attribute_string('acc_link'); ?>><?php echo $object ?></a>

                    <?php }
                    if ($settings['acc_button_behavior'] === 'open-popup') { ?>

                        <div class="pe--account--pop--button pe--pop--button pe--styled--object"><?php echo $object ?></div>

                        <?php if ($settings['back_overlay'] === 'true') { ?>
                            <span class="pop--overlay"></span>
                        <?php } ?>


                        <div class="pe--account--login--popup pe--styled--popup">

                            <span class="pop--close">

                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path
                                        d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z" />
                                </svg>

                            </span>

                            <?php echo do_shortcode('[saren_login_register]'); ?>

                        </div>

                    <?php }

                } else {

                    if ($settings['acc_button_behavior'] === 'to-page' && $loggedIn) { ?>
                        <a class="pe--account--button--icon pe--account--pop--button pe--styled--object" href="<?php echo $account_page_url; ?>"><?php echo $object ?></a>
                    <?php }

                    if ($settings['acc_button_behavior'] === 'open-popup' && $loggedIn) { ?>

                        <div class="pe--account--pop--button pe--styled--object"><?php echo $object ?></div>

                        <?php if (function_exists('woocommerce_account_navigation')) { ?>

                            <div class="pe--account--dropdown">
                                <?php woocommerce_account_navigation(); ?>
                            </div>
                        <?php }

                    }
                } ?>




            </div>

        </div>



        <?php
    }

}
