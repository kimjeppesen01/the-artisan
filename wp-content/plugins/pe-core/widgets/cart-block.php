<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peCartBlock extends Widget_Base
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
        return 'pecartblock';
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
        return __('Cart (Block)', 'pe-core');
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
        return 'eicon-woo-cart pe-widget';
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
                'label' => __('Cart (Block)', 'pe-core'),
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
            'cart_columns',
            [
                'label' => __('Cart Columns', 'pe-core'),
                'label_block' => false,
                'default' => '2-columns',
                'type' => \Elementor\Controls_Manager::SELECT,
                'prefix_class' => 'cart-',
                'options' => [
                    '1-column' => esc_html__('1 Column', 'pe-core'),
                    '2-columns' => esc_html__('2 Columns', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'totals_sticky',
            [
                'label' => esc_html__('Sticky Cart Totals', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'totals--sticky',
                'default' => '',
                'prefix_class' => '',
                'condition' => ['cart_columns' => '1-column'],
            ]
        );


        $this->add_responsive_control(
            'cart_totals_pos_horizontal',
            [
                'label' => esc_html__('Cart Totals Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-arrow-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-arrow-right',
                    ],
                ],
                'default' => is_rtl() ? 'left' : 'right',
                'toggle' => true,
                'prefix_class' => 'cart-totals-',
                'condition' => ['cart_columns' => '2-columns'],
            ]
        );

        $this->add_control(
            'hide_cart_title',
            [
                'label' => esc_html__('Hide Cart Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide',
                'default' => 'false',
                'prefix_class' => 'cart-title-',
            ]
        );

        $this->add_responsive_control(
            'items_columns',
            [
                'label' => esc_html__('Products Columns', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px',],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 6,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tbody' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'products_style',
            [
                'label' => esc_html__('Products Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'horizontal' => [
                        'title' => esc_html__('Horizontal', 'pe-core'),
                        'icon' => 'eicon-arrow-left',
                    ],
                    'vertical' => [
                        'title' => esc_html__('Vertical', 'pe-core'),
                        'icon' => 'eicon-arrow-down',
                    ],
                ],
                'default' => 'horizontal',
                'toggle' => true,
                'prefix_class' => 'cart-products-',
            ]
        );

        $this->add_control(
            'cart_block_notice_2',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-warning'>	
	           <span>Adding some products in the cart may visually help you customizing this block. If the cart shown empty; navigate your products page and add some products to the cart.</span></div>",

            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'totals_block_styles',
            [
                'label' => esc_html__('Totals Block Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cart_title_typography',
                'label' => esc_html__('Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .saren--cart--title h4'
            ]
        );


        $this->add_control(
            'totals_has_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'prefix_class' => 'totals--bg--',
            ]
        );


        $this->add_responsive_control(
            'totals_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
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
                    '{{WRAPPER}} .pe-col-4.sm-12.cart--totals--col' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'totals_button_border',
                'selector' => '{{WRAPPER}} .cart-collaterals',
            ]
        );


        $this->add_responsive_control(
            'totals_border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .cart-collaterals' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'totals_margins',
            [
                'label' => esc_html__('Margins', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .cart--totals--col' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'totals_paddings',
            [
                'label' => esc_html__('Paddings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .cart-collaterals' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'totals_items_border-radius',
            [
                'label' => esc_html__('Inner Items Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--section ul#shipping_method li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .saren--coupon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .pe-wrapper.saren--cart--wrapper a.checkout-button.button.alt.wc-forward' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .saren--cart--wrapper form.woocommerce-shipping-calculator .form-row select, {{WRAPPER}} .saren--cart--wrapper form.woocommerce-shipping-calculator .form-row input.input-text, {{WRAPPER}} .saren--cart--wrapper form.woocommerce-shipping-calculator .form-row textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'totals_buttons_border',
                'label' => esc_html__('Buttons Border', 'pe-core'),
                'selector' => '{{WRAPPER}} a.button.checkout-button',
            ]
        );


        $this->add_responsive_control(
            'totals_buttons_border-radius',
            [
                'label' => esc_html__('Buttons Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} a.button.checkout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );


        $this->add_responsive_control(
            'totals_buttons_paddings',
            [
                'label' => esc_html__('Buttons Paddings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} a.button.checkout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );



        $this->add_control(
            'totals_colors',
            [
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label' => esc_html__('Colors', 'pe-core'),
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'adv--styled',
            ]
        );

        $this->start_popover();

        pe_color_options($this, '.cart--totals--col', 'totals_', false);

        $this->end_popover();


        $this->end_controls_section();


        $this->start_controls_section(
            'products_block_styles',
            [
                'label' => esc_html__('Products Block Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'products_block_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
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
                    '{{WRAPPER}} .pe-col-8.sm-12.form--col' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'products_gap',
            [
                'label' => esc_html__('Gap', 'pe-core'),
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
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tbody' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'product_blocks_button_border',
                'selector' => '{{WRAPPER}} .pe-col-8.sm-12.form--col',
            ]
        );


        $this->add_responsive_control(
            'product_blocks_border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe-col-8.sm-12.form--col' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'product_blocks_margins',
            [
                'label' => esc_html__('Margins', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe-col-8.sm-12.form--col' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'product_blocks_paddings',
            [
                'label' => esc_html__('Paddings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe-col-8.sm-12.form--col' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->add_control(
            'product_blocks_colors',
            [
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label' => esc_html__('Colors', 'pe-core'),
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'adv--styled',
            ]
        );

        $this->start_popover();

        pe_color_options($this, '.pe-col-8.sm-12.form--col', 'products_blocks_', false);

        $this->end_popover();


        $this->end_controls_section();

        $this->start_controls_section(
            'cart_product_styles',
            [
                'label' => esc_html__('Product Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'product_image_width',
            [
                'label' => esc_html__('Image Width', 'pe-core'),
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
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr td.product-thumbnail' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'product_image_height',
            [
                'label' => esc_html__('Image Height', 'pe-core'),
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
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr td.product-thumbnail a' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_gap',
            [
                'label' => esc_html__('Columns Gap', 'pe-core'),
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
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'products_border',
                'selector' => '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr',
            ]
        );


        $this->add_responsive_control(
            'products_border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'products__image_border-radius',
            [
                'label' => esc_html__('Image Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr td.product-thumbnail a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'products_paddings',
            [
                'label' => esc_html__('Paddings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'products_margins',
            [
                'label' => esc_html__('Margins', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Titles Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .saren--cart--wrapper table.shop_table tbody:first-child td.product-name h6'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'variations_typography',
                'label' => esc_html__('Variations Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .saren--cart--wrapper td.product-name dl.variation dd p'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'prices_typography',
                'label' => esc_html__('Prices Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} p.cart--item--price, {{WRAPPER}} span.woocommerce-Price-amount.amount'
            ]
        );

        $this->add_responsive_control(
            'contents_paddings',
            [
                'label' => esc_html__('Content Paddings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr td:not(.product-thumbnail)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr .product-remove' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_order',
            [
                'label' => esc_html__('Image Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 3,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr td.product-thumbnail' => 'order: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'details_order',
            [
                'label' => esc_html__('Details Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 3,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--wrapper table.shop_table tbody:first-child td.product-name' => 'order: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'totals_order',
            [
                'label' => esc_html__('Totals Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 3,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--wrapper .woocommerce-cart-form table.shop_table tr td.product-subtotal' => 'order: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        echo do_shortcode('[woocommerce_cart]');



    }

}
