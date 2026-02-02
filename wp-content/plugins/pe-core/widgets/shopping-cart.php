<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peShoppingCart extends Widget_Base
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
        return 'peshoppingcart';
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
        return __('Shopping Cart', 'pe-core');
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
        return 'eicon-cart-light pe-widget';
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
        return ['saren-header'];
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
                'label' => __('Shopping Cart', 'pe-core'),
            ]
        );

        $this->add_control(
            'behavior',
            [
                'label' => __('Behavior', 'pe-core'),
                'label_block' => false,
                'default' => 'link-to-cart',
                'type' => \Elementor\Controls_Manager::SELECT,
                'prefix_class' => 'cart-',
                'options' => [
                    'link-to-cart' => esc_html__('Link to Cart Page', 'pe-core'),
                    'mini-cart' => esc_html__('Open Mini Cart', 'pe-core'),
                ],
            ]
        );


        $this->add_control(
            'cart_style',
            [
                'label' => __('Cart Style', 'pe-core'),
                'label_block' => false,
                'default' => 'icon_text',
                'prefix_class' => 'cart--style--',
                'render_type' => 'template',
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core'),
                    'icon_text' => esc_html__('Icon + Text', 'pe-core'),
                    'count_only' => esc_html__('Count Only', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'cart_text',
            [
                'label' => esc_html__('Cart Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'default' => esc_html('CART', 'pe-core'),
                'condition' => [
                    'cart_style' => ['text', 'icon_text'],
                ],
            ]
        );

        $this->add_control(
            'hide_text_on_mobile',
            [
                'label' => esc_html__('Hide Text on Mobile', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide--cart--text--mobile',
                'prefix_class' => '',
                'default' => '',
                'condition' => [
                    'cart_style' => ['icon_text'],
                ],
            ]
        );

        popupOptions($this, ['behavior' => 'mini-cart']);


        $this->add_control(
            'custom_icon',
            [
                'label' => esc_html__('Use Custom Icon', 'pe-core'),
                'description' => esc_html__('Switch "Yes" if you want to use a custom cart icon.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
                'condition' => [
                    'cart_style' => ['icon', 'icon_text'],
                ],
            ]
        );

        $this->add_control(
            'cart_icon',
            [
                'label' => esc_html__('Cart Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'custom_icon' => 'true',
                ],
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
                    '{{WRAPPER}} .saren--cart--button' => '--iconSize: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['cart_style!' => 'text'],
            ]
        );


        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'pe-core'),
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
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'visibility',
            [
                'label' => __('Visibility', 'pe-core'),
                'label_block' => true,
                'default' => 'show-everywhere',
                'type' => \Elementor\Controls_Manager::SELECT,
                'prefix_class' => '',
                'options' => [
                    'show-only-woo' => esc_html__('Only WooCommerce Pages', 'pe-core'),
                    'show-everywhere' => esc_html__('Everywhere', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'cart_count_style',
            [
                'label' => __('Cart Count Style', 'pe-core'),
                'label_block' => false,
                'render_type' => 'template',
                'default' => 'round',
                'prefix_class' => 'count--style--',
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'round' => esc_html__('Round', 'pe-core'),
                    'square' => esc_html__('Square', 'pe-core'),
                    'simple' => esc_html__('Simple', 'pe-core'),
                    'hidden' => esc_html__('Hidden', 'pe-core'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mini_cart_styles',
            [
                'label' => esc_html__('Mini Cart', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['behavior' => 'mini-cart'],
            ]
        );



        $this->add_responsive_control(
            'cart_orientation',
            [
                'label' => esc_html__('Cart Orientation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex' => [
                        'title' => esc_html__('List', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'grid' => [
                        'title' => esc_html__('Grid', 'pe-core'),
                        'icon' => ' eicon-h-align-right',
                    ],
                ],
                'default' => 'flex',
                'prefix_class' => 'cart__orientation-',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .saren--mini--cart ul.cart_list, .woocommerce ul.product_list_widget' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_grid_columns',
            [
                'label' => esc_html__('Cart Grid Columns', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 12,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.cart__orientation-grid ul.product_list_widget' => '--columns: {{SIZE}};',
                ],
                'condition' => ['cart_orientation' => 'grid'],
            ]
        );

        $this->add_responsive_control(
            'cart_items_gap',
            [
                'label' => esc_html__('Items Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
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
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--mini--cart ul.cart_list, .woocommerce ul.product_list_widget' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_max_height',
            [
                'label' => esc_html__('Wrapper Max Height', 'pe-core'),
                'description' => esc_html__('Useful for avoiding overflows in mini cart.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'em', 'rem', 'custom'],
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
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--mini--cart ul.cart_list' => 'max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_style',
            [
                'label' => esc_html__('Items Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'column' => [
                        'title' => esc_html__('Column', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'row' => [
                        'title' => esc_html__('Row', 'pe-core'),
                        'icon' => ' eicon-h-align-right',
                    ],
                ],
                'default' => 'row',
                'prefix_class' => 'items__style-',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .saren--mini--cart ul.cart_list li, ul.product_list_widget li' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_title_typo',
                'label' => esc_html__('Item Titles Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} a.mini--cart--item--title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'variations_typo',
                'label' => esc_html__('Item Variations Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .saren--mini--cart ul.cart_list li dl dd p, .saren--mini--cart ul.product_list_widget li dl dd p',
            ]
        );

        $this->add_control(
            'item_image_popover',
            [
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label' => esc_html__('Items Image Styles', 'pe-core'),
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'popup--colors',
            ]
        );

        $this->start_popover();

        objectStyles($this, 'mini_cart_item_image_', 'Item Image', '.saren--mini--cart .mini-cart-item-image', false, false, false, true);

        $this->end_popover();


        $this->add_control(
            'underline_items',
            [
                'label' => esc_html__('Underline Items', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => 'underline--items--',
                'default' => '',
                'condition' => ['behavior' => 'mini-cart'],
            ]
        );

        $this->add_control(
            'items_bg',
            [
                'label' => esc_html__('Items Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => 'items--bg--',
                'default' => '',
                'condition' => ['behavior' => 'mini-cart'],
            ]
        );

        $this->add_responsive_control(
            'items_border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--mini--cart ul.cart_list li.woocommerce-mini-cart-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .saren--mini--cart ul.cart_list li.woocommerce-mini-cart-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} a.remove.remove_from_cart_button' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'show_cart_count',
            [
                'label' => esc_html__('Cart Count', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => 'cart--count--',
                'default' => 'yes',
                'condition' => ['behavior' => 'mini-cart'],
            ]
        );


        $this->add_control(
            'mini_cart_count_style',
            [
                'label' => __('Cart Count Style', 'pe-core'),
                'label_block' => false,
                'default' => 'simple-justify',
                'type' => \Elementor\Controls_Manager::SELECT,
                'prefix_class' => 'cart--count--',
                'options' => [
                    'simple-justify' => esc_html__('Justify-Simple', 'pe-core'),
                    'simple-start' => esc_html__('Start-Simple', 'pe-core'),
                    'sup' => esc_html__('Sup', 'pe-core'),
                ],
                'condition' => [
                    'show_cart_count' => 'yes',
                    'behavior' => 'mini-cart'
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'popup_styles_sec',
            [
                'label' => esc_html__('Popup Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['behavior' => 'mini-cart'],
            ]
        );

        popupStyles($this, ['behavior' => 'mini-cart']);
        $this->end_controls_section();

        objectStyles($this, 'cart_but_', 'Button', '.pe--styled--object', true);

        $this->start_controls_section(
            'cart_button_styles',
            [
                'label' => esc_html__('Cart Buttons Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['behavior' => 'mini-cart'],
            ]
        );

        $this->add_responsive_control(
            'buttons_orientation',
            [
                'label' => esc_html__('Buttons Orientation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Horizontal', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'column' => [
                        'title' => esc_html__('Vertical', 'pe-core'),
                        'icon' => ' eicon-v-align-bottom',
                    ],
                ],
                'default' => 'column',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .saren--mini--cart p.woocommerce-mini-cart__buttons.buttons' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_cart_button',
            [
                'label' => esc_html__('Hide Cart Button', 'pe-core'),
                'description' => esc_html__('Switch "Yes" if you want to use a custom cart icon.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide',
                'prefix_class' => 'cart--button--',
                'default' => '',
                'condition' => ['behavior' => 'mini-cart'],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .woocommerce-mini-cart__buttons a',
            ]
        );

        $this->add_responsive_control(
            'border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-mini-cart__buttons a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-mini-cart__buttons a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        objetAbsolutePositioning($this, 'p.woocommerce-mini-cart__buttons.buttons a svg', 'button_icons', 'Button Icon');


        $this->end_controls_section();

        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $option = get_option('pe-redux');

        $text = $settings['cart_text'];
        ?>

        <div class="saren--cart--button pe--pop--button pe--styled--object" data-barba-prevent='all'>
            <?php if ($settings['behavior'] === 'link-to-cart') { ?>
                <a href="<?php echo wc_get_cart_url(); ?>">
                <?php } ?>
                <div class="cart--button--inner">
                    <!-- Cart Icon  -->
                    <?php if ($settings['cart_style'] === 'icon' || $settings['cart_style'] === 'icon_text') { ?>
                        <div class="cart--button--icon">
                            <?php if ($settings['custom_icon'] !== 'true') { ?>

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                    <path
                                        d="M276.1-131.38q-22.1 0-36.95-15.06-14.84-15.06-14.84-37.16 0-22.09 15.06-36.94 15.05-14.84 37.15-14.84 22.1 0 36.94 15.05 14.85 15.06 14.85 37.16 0 22.09-15.06 36.94-15.06 14.85-37.15 14.85Zm407.38 0q-22.1 0-36.94-15.06-14.85-15.06-14.85-37.16 0-22.09 15.06-36.94 15.06-14.84 37.15-14.84 22.1 0 36.95 15.05 14.84 15.06 14.84 37.16 0 22.09-15.06 36.94-15.05 14.85-37.15 14.85ZM242.23-716 336-499.38h286.38q6.93 0 12.31-3.47 5.39-3.46 9.23-9.61l76.62-182q4.61-8.46.77-15-3.85-6.54-13.08-6.54h-466Zm-12.54-32h500.77q17.08 0 24.73 11.77 7.66 11.77 1.89 25.31L673.4-500.76q-6.32 14.76-19.21 24.07-12.88 9.31-29.5 9.31H317l-46.62 81.23q-6.15 9.23-.38 20 5.77 10.77 17.31 10.77h448.38v32H288.31q-33 0-47.73-26.16-14.73-26.15 1.65-52.61l58.15-99.23L166.31-812H88v-32h100.69l41 96ZM336-499.38h301-301Z" />
                                </svg>

                            <?php } else {

                                ob_start();

                                \Elementor\Icons_Manager::render_icon($settings['cart_icon'], ['aria-hidden' => 'true']);

                                $icon = ob_get_clean();

                                echo $icon;

                            } ?>
                        </div>
                    <?php } ?>

                    <?php if ($settings['cart_style'] === 'text' || $settings['cart_style'] === 'icon_text') { ?>
                        <div class="cart--button--text">

                            <?php echo $settings['cart_text'] ?>

                        </div>
                    <?php }

                    if ($settings['cart_count_style'] !== 'hidden') {

                        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                            echo woo_cart_but($text, false);
                        } else {
                            echo woo_cart_but($text, true);
                        }
                    }
                    ?>

                </div>

                <?php if ($settings['behavior'] === 'link-to-cart') { ?>
                </a>
            <?php } ?>
        </div>

        <?php if ($settings['behavior'] === 'mini-cart') { ?>
            <div class="saren--mini--cart pe--styled--popup">

                <span class="pop--close">

                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                        <path
                            d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z" />
                    </svg>

                </span>

                <div class="widget_shopping_cart_content">
                    <?php woocommerce_mini_cart(); ?>
                </div>
            </div>

            <?php if ($settings['back_overlay'] === 'true') { ?>
                <span class="pop--overlay"></span>
            <?php } ?>

        <?php } ?>


        <?php
    }

}
