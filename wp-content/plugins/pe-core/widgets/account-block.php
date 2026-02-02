<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peAccountBlock extends Widget_Base
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
        return 'peaccountblock';
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
        return __('Account (Block)', 'pe-core');
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
        return ['saren-content'];
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
                'label' => __('Checkout (Block)', 'pe-core'),
            ]
        );

        $this->add_control(
            'saren_refresh_widget',
            [
                'label' => esc_html__('Refresh Widget', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'refresh' => [
                        'title' => esc_html__('Refresh Widget', 'pe-core'),
                        'icon' => 'eicon-sync',
                    ],
                ],
                'default' => 'refresh',
                'render_type' => 'template',
                'toggle' => true,

            ]
        );

        $this->add_control(
            'account_block_notice_1',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-error'>	
	           <span>If the preview not showing up refresh the page via the button above.</span></div>",

            ]
        );


        $this->add_control(
            'dashboard_style',
            [
                'label' => __('Dashboard Style', 'pe-core'),
                'label_block' => false,
                'default' => 'user-preview',
                'type' => \Elementor\Controls_Manager::SELECT,
                'prefix_class' => 'dashboard-type-',
                'render_type' => 'template',
                'options' => [
                    'user-preview' => esc_html__('User Preview', 'pe-core'),
                    'navigation' => esc_html__('Navigation', 'pe-core'),
                    'classic' => esc_html__('Classic', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'hide_user_card',
            [
                'label' => esc_html__('Hide User Card', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide',
                'default' => '',
                'prefix_class' => 'user-card-',
                'condition' => ['dashboard_style' => ['user-preview', 'navigation']],
            ]
        );

        $this->add_control(
            'hide_user_avatar',
            [
                'label' => esc_html__('Hide User Avatar', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide',
                'default' => '',
                'prefix_class' => 'user-avatar-',
                'condition' => ['dashboard_style' => ['user-preview', 'navigation']],
            ]
        );

        $this->add_control(
            'hide_user_bio',
            [
                'label' => esc_html__('Hide User Bio', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide',
                'default' => '',
                'prefix_class' => 'user-bio-',
                'condition' => ['dashboard_style' => ['user-preview', 'navigation']],
            ]
        );

        $this->add_control(
            'hide_user_url',
            [
                'label' => esc_html__('Hide User Url', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide',
                'default' => '',
                'prefix_class' => 'user-url-',
                'condition' => ['dashboard_style' => ['user-preview', 'navigation']],
            ]
        );

        $this->add_control(
            'hide_user-summary',
            [
                'label' => esc_html__("Hide User's Summary", 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide',
                'default' => '',
                'prefix_class' => 'user-summary-',
                'condition' => ['dashboard_style' => 'user-preview'],
            ]
        );

        $this->add_control(
            'hide_most-visited',
            [
                'label' => esc_html__("Hide Most Visited Product", 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide',
                'default' => '',
                'prefix_class' => 'most-visited-',
                'condition' => ['dashboard_style' => 'user-preview'],
            ]
        );

        $this->add_control(
            'hide_active-order',
            [
                'label' => esc_html__("Hide Active Order", 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide',
                'default' => '',
                'prefix_class' => 'active-order-',
                'condition' => ['dashboard_style' => 'navigation'],
            ]
        );

        $this->add_responsive_control(
            'wrapper_width',
            [
                'label' => esc_html__('Wrapper Width', 'pe-core'),
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
                    '{{WRAPPER}} .pe-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_has_bg',
            [
                'label' => esc_html__("Background", 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'has-bg',
                'default' => '',
                'prefix_class' => 'wrapper-',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_summary_border',
                'selector' => '{{WRAPPER}} .pe-wrapper',
            ]
        );


        $this->add_responsive_control(
            'wrapper_border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'wrapper_paddings',
            [
                'label' => esc_html__('Paddings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();


        $this->start_controls_section(
            'blocks_styles',
            [
                'label' => esc_html__('Blocks Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'blocks_border',
                'selector' => '{{WRAPPER}} .saren--account--dashboard .saren--account--dashboard--head>div,
                {{WRAPPER}} .saren--account--dashboard--foot>div , {{WRAPPER}} nav.woocommerce-MyAccount-navigation ul li.is-active,
                {{WRAPPER}} .saren--account--details, {{WRAPPER}} .woocommerce-MyAccount-content:not(:has(.saren--account--dashboard)),
                {{WRAPPER}}.dashboard-type-navigation .saren--account--dashboard--nav nav.woocommerce-MyAccount-navigation ul li,
                {{WRAPPER}} .saren--user--active--order',
            ]
        );


        $this->add_responsive_control(
            'form_block_border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--account--dashboard .saren--account--dashboard--head>div,
                    {{WRAPPER}} .saren--account--dashboard--foot>div , {{WRAPPER}} nav.woocommerce-MyAccount-navigation ul li.is-active,
                    {{WRAPPER}} .saren--account--details, {{WRAPPER}} .woocommerce-MyAccount-content,
                    {{WRAPPER}}.dashboard-type-navigation .saren--account--dashboard--nav nav.woocommerce-MyAccount-navigation ul li,
                    {{WRAPPER}} .saren--user--active--order' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_block_paddings',
            [
                'label' => esc_html__('Paddings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--account--dashboard .saren--account--dashboard--head>div,
                    {{WRAPPER}} .saren--account--dashboard--foot>div , {{WRAPPER}} nav.woocommerce-MyAccount-navigation ul li.is-active,
                    {{WRAPPER}} .saren--account--details, {{WRAPPER}} .woocommerce-MyAccount-content,
                    {{WRAPPER}}.dashboard-type-navigation .saren--account--dashboard--nav nav.woocommerce-MyAccount-navigation ul li,
                    {{WRAPPER}} .saren--user--active--order' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'form_block_colors',
            [
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label' => esc_html__('Colors', 'pe-core'),
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'adv--styled',
            ]
        );

        $this->start_popover();

        pe_color_options($this, ' .saren--account--dashboard .saren--account--dashboard--head>div,
        {{WRAPPER}} .saren--account--dashboard--foot>div , {{WRAPPER}} nav.woocommerce-MyAccount-navigation ul li.is-active,
        {{WRAPPER}} .saren--account--details, {{WRAPPER}} .woocommerce-MyAccount-content,
        {{WRAPPER}}.dashboard-type-navigation .saren--account--dashboard--nav nav.woocommerce-MyAccount-navigation ul li,
        {{WRAPPER}} .saren--user--active--order', 'products_blocks_', false);

        $this->end_popover();


        $this->end_controls_section();



        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        echo do_shortcode('[woocommerce_my_account]');



    }

}
