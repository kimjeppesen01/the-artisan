<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peCheckoutBlock extends Widget_Base
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
        return 'pecheckoutblock';
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
        return __('Checkout (Block)', 'pe-core');
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
        return 'eicon-checkout pe-widget';
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
            'checkout_style',
            [
                'label' => __('Style', 'pe-core'),
                'label_block' => false,
                'default' => 'simple',
                'type' => \Elementor\Controls_Manager::SELECT,
                'prefix_class' => 'checkout-type-',
                'render_type' => 'template',
                'options' => [
                    'simple' => esc_html__('Simple', 'pe-core'),
                    'accordion' => esc_html__('Accordion', 'pe-core'),
                    'tabs' => esc_html__('Tabs', 'pe-core'),
                ],
            ]
        );

        $this->add_responsive_control(
            'summmary_position',
            [
                'label' => esc_html__('Order Summary Position', 'pe-core'),
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
                'render_type' => 'template',
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'prefix_class' => 'order-summary-',
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
            'order_summary_styles',
            [
                'label' => esc_html__('Order Summary Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'table_titles_typography',
                'label' => esc_html__('Table Titles Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} #order_review_heading, {{WRAPPER}} thead , {{WRAPPER}} tfoot tr th'
            ]
        );
       
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_titles_typography',
                'label' => esc_html__('Product Titles Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .cart_item .product-name'
            ]
        );
       
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_variatios_typography',
                'label' => esc_html__('Product Variations Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .product-name .variation p'
            ]
        );

        $this->add_responsive_control(
            'order_summary_width',
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
                    '{{WRAPPER}} .pe-col-4.sm-12.order--col' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
      
        $this->add_responsive_control(
            'order_summary_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%', 'rem' , 'custom'],
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
                    '{{WRAPPER}} .pe-col-4.sm-12.order--col' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'order_summary_border',
                'selector' => '{{WRAPPER}} .pe-col-4.sm-12.order--col',
            ]
        );


        $this->add_responsive_control(
            'order_summary_border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe-col-4.sm-12.order--col' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'order_summary_margins',
            [
                'label' => esc_html__('Margins', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe-col-4.sm-12.order--col' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'order_summary_paddings',
            [
                'label' => esc_html__('Paddings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe-col-4.sm-12.order--col' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->add_responsive_control(
            'order_summary_items_border-radius',
            [
                'label' => esc_html__('Inner Items Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--checkout--wrapper td.product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .saren--coupon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'order_summary_colors',
            [
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label' => esc_html__('Order Summary Colors', 'pe-core'),
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'summary--adv--styled',
            ]
        );

        $this->start_popover();

        pe_color_options($this, '.pe-col-4.sm-12.order--col', 'summary_', false);

        $this->end_popover();


        $this->end_controls_section();


        $this->start_controls_section(
            'form_block_styles',
            [
                'label' => esc_html__('Form Block Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'form_block_width',
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

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'form_block_button_border',
                'selector' => '{{WRAPPER}} .pe-col-8.sm-12.form--col',
            ]
        );


        $this->add_responsive_control(
            'form_block_border-radius',
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
            'form_block_margins',
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
            'form_block_paddings',
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

        pe_color_options($this, '.pe-col-8.sm-12.form--col', 'products_blocks_', false);

        $this->end_popover();


        $this->end_controls_section();

        $this->start_controls_section(
            'form_elements_styles',
            [
                'label' => esc_html__('Form Elements Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );



        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'elements_border',
                'selector' => '{{WRAPPER}} .checkout--accordion--content:has(.saren--address--card), {{WRAPPER}} .saren--checkout--wrapper ul#shipping_method li , 
                {{WRAPPER}} .woocommerce-checkout #payment ul.payment_methods li',
            ]
        );


        $this->add_responsive_control(
            'elements_border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .checkout--accordion--content:has(.saren--address--card), {{WRAPPER}} .saren--checkout--wrapper ul#shipping_method li , 
                    {{WRAPPER}} .woocommerce-checkout #payment ul.payment_methods li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );


        $this->add_responsive_control(
            'elements_paddings',
            [
                'label' => esc_html__('Paddings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .checkout--accordion--content:has(.saren--address--card), {{WRAPPER}} .saren--checkout--wrapper ul#shipping_method li , 
                {{WRAPPER}} .woocommerce-checkout #payment ul.payment_methods li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'elements_margins',
            [
                'label' => esc_html__('Margins', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .checkout--accordion--content:has(.saren--address--card), {{WRAPPER}} .saren--checkout--wrapper ul#shipping_method li , 
                {{WRAPPER}} .woocommerce-checkout #payment ul.payment_methods li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'titles_typography',
                'label' => esc_html__('Titles Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .checkout--accordion--title h6'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'form_inputs_styles',
            [
                'label' => esc_html__('Form Inputs Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );



        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'form_inputs_border',
                'selector' => '{{WRAPPER}} form.saren--checkout--form .form-row select, 
                {{WRAPPER}} form.saren--checkout--form .form-row input.input-text, 
                {{WRAPPER}} form.saren--checkout--form .form-row textarea, {{WRAPPER}} .saren--accordion--button',
            ]
        );

        $this->add_responsive_control(
            'form_inputs_border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} form.saren--checkout--form .form-row select, 
                {{WRAPPER}} form.saren--checkout--form .form-row input.input-text, 
                {{WRAPPER}} form.saren--checkout--form .form-row textarea,
                {{WRAPPER}} form.saren--checkout--form  .select2-selection--single,
                {{WRAPPER}} .saren--accordion--button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        


        $this->add_responsive_control(
            'form_inputs_paddings',
            [
                'label' => esc_html__('Paddings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} form.saren--checkout--form .form-row select, 
                {{WRAPPER}} form.saren--checkout--form .form-row input.input-text, 
                {{WRAPPER}} form.saren--checkout--form .form-row textarea,
                {{WRAPPER}} .saren--accordion--button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} form.saren--checkout--form .form-row label' => 'top: {{TOP}}{{UNIT}};left:{{LEFT}}{{UNIT}};',

                ],
            ]
        );

        $this->add_responsive_control(
            'form_inputs_margins',
            [
                'label' => esc_html__('Margins', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} form.saren--checkout--form .form-row select, 
                {{WRAPPER}} form.saren--checkout--form .form-row input.input-text, 
                {{WRAPPER}} form.saren--checkout--form .form-row textarea,
                {{WRAPPER}} .saren--accordion--button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'form_inputs_typography',
                'label' => esc_html__('Inputs Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} form.saren--checkout--form .form-row select, 
                {{WRAPPER}} form.saren--checkout--form .form-row input.input-text, 
                {{WRAPPER}} form.saren--checkout--form .form-row textarea,
                {{WRAPPER}} .saren--accordion--button'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'form_inputs_labels_typography',
                'label' => esc_html__('Input Labels Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} form.saren--checkout--form .form-row label'
            ]
        );

        $this->add_control(
            'form_inputs_colors',
            [
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label' => esc_html__('Colors', 'pe-core'),
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'adv--styled',
            ]
        );

        $this->start_popover();

        pe_color_options($this, 'form.saren--checkout--form .form-row select, 
        {{WRAPPER}} form.saren--checkout--form .form-row input.input-text, 
        {{WRAPPER}} form.saren--checkout--form .form-row textarea', 'form_inputs_blocks_', false);

        $this->end_popover();

        $this->end_controls_section();


        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        echo do_shortcode('[woocommerce_checkout]');



    }

}
