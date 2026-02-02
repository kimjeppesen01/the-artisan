<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeCompareTable extends Widget_Base
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
        return 'pecomparetable';
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
        return __('Compare Table (Saren)', 'pe-core');
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
        return 'eicon-table pe-widget';
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
        return ['pe-content'];
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
                'label' => __('Compare Table', 'pe-core'),
            ]
        );

        $this->add_control(
            'table_title',
            [
                'label' => esc_html__('Table Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('Leave it empty if you do not want to display table title.', 'pe-core'),
                'default' => esc_html__('Compare Products.', 'pe-core'),
                'ai' => false,
            ]
        );

        $this->add_control(
            'sku',
            [
                'label' => esc_html__('SKU', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'dimensions',
            [
                'label' => esc_html__('Dimensions', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'saren_weight',
            [
                'label' => esc_html__('Weight', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'stock',
            [
                'label' => esc_html__('Stock', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $wcAttributes = wc_get_attribute_taxonomies();

        foreach ($wcAttributes as $key => $attr) {

            $this->add_control(
                $attr->attribute_name,
                [
                    'label' => esc_html__($attr->attribute_label, 'pe-core'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Show', 'pe-core'),
                    'label_off' => esc_html__('Hide', 'pe-core'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'frontend_available' => true,
                ]
            );

        }

        $this->add_control(
            'compare_empty_title',
            [
                'label' => esc_html__('Empty Table Headline', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Your Comparison List is Empty
                ', 'pe-core'),
                'label_block' => false,
            ]
        );

        $this->add_control(
            'compare_empty_sub',
            [
                'label' => esc_html__('Empty Table Subtext', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Add products to compare and see their features side by side. Keep exploring our store to find the best match for you!', 'pe-core'),
                'label_block' => true,
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'styles',
            [

                'label' => esc_html__('Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--compare--table--title h6',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'table_typography',
                'label' => esc_html__('Table Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} pe--compare--table--labels, {{WRAPPER}} .pe-compare-item-vars ',
            ]
        );


        $this->add_control(
            'add-to-cart-button',
            [
                'label' => esc_html__('Add To Cart Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'view-product-button',
            [
                'label' => esc_html__('View Product Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius (Images)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .pe--compare--items--wrap .pe-compare-item .pe-compare-image img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',

                ],
            ]
        );

        $this->add_responsive_control(
            'items_width',
            [
                'label' => esc_html__('Width (Items)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em', 'rem', 'custom'],
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
                    'vw' => [
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
                    '{{WRAPPER}} .pe--compare--container' => '--itemsWidth: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'labels_width',
            [
                'label' => esc_html__('Width (Labels Column)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em', 'rem', 'custom'],
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
                    'vw' => [
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
                    '{{WRAPPER}} .pe--compare--table--labels' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_gap',
            [
                'label' => esc_html__('Gap (Items)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em', 'rem', 'custom'],
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
                    'vw' => [
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
                    '{{WRAPPER}} .pe--compare--container' => '--itemsGap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'images_height',
            [
                'label' => esc_html__('Height (Images)', 'pe-core'),
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
                    '{{WRAPPER}} .pe--compare--items--wrap .pe-compare-item .pe-compare-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();
        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (is_user_logged_in()) {

            $user_id = get_current_user_id();
            $compare = get_user_meta($user_id, 'pe_compare', true);
            $compare = is_array($compare) ? $compare : [];

        } else {
            $compare = isset($_COOKIE['pe_compare']) ? json_decode(stripslashes($_COOKIE['pe_compare']), true) : [];
            $compare = is_array($compare) ? $compare : [];
        }

        if (isset($_GET['comp'])) {
            $compare = is_array($compare) ? $compare : [];
        }



        echo '<div class="pe--compare--empty">
            <h5>' . esc_html($settings['compare_empty_title']) . '</h5>
            <p>' . esc_html($settings['compare_empty_sub']) . '</p>
            </div>';



        $wcAttributes = wc_get_attribute_taxonomies();
        ?>

        <div class="pe--compare--container">

            <div class="pe--compare--container--side">

                <div class="pe--compare--table--title">
                    <h6><?php echo !empty($settings['table_title']) ? $settings['table_title'] : '' ?></h6>
                </div>

                <div class="pe--compare--table--labels">

                    <?php

                    if ($settings['sku'] === 'yes') {
                        echo '<div class="pe--compare--label compare--sku">' . esc_html('SKU', 'pe-core') . '</div>';
                    }
                    if ($settings['dimensions'] === 'yes') {
                        echo '<div class="pe--compare--label compare--dimensions">' . esc_html('Dimensions', 'pe-core') . '</div>';
                    }
                    if ($settings['saren_weight'] === 'yes') {
                        echo '<div class="pe--compare--label compare--weight">' . esc_html('Weight', 'pe-core') . '</div>';
                    }
                    if ($settings['stock'] === 'yes') {
                        echo '<div class="pe--compare--label compare--stock">' . esc_html('Stock', 'pe-core') . '</div>';
                    }

                    foreach ($wcAttributes as $key => $attr) {
                        if ($settings[$attr->attribute_name] === 'yes') {
                            echo '<div class="pe--compare--label compare--' . $attr->attribute_name . '">' . $attr->attribute_label . '</div>';
                        }
                    }
                    ?>

                </div>

            </div>

            <div class="pe--compare--container--main">

                <div class="pe--compare--items--wrap">

                    <?php foreach ($compare as $product_id):
                        $product = wc_get_product($product_id);
                        $product_link = get_permalink($product_id);
                        if (!$product)
                            continue;

                        sarenCompareItemRender($settings, $product, $product_id, $product_link);

                    endforeach; ?>

                </div>

            </div>

        </div>

        <?php

    }

}
