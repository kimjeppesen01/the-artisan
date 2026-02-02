<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeHotspotImage extends Widget_Base
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
        return 'pehotspotimage';
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
        return __('Hotspot Image', 'pe-core');
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
        return 'eicon-image-hotspot pe-widget';
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
                'label' => __('Hotspot Image', 'pe-core'),
            ]
        );

        $this->add_control(
            'hotspots_behavior',
            [
                'label' => esc_html__('Hotspots Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'click-to-open',
                'render_type' => 'template',
                'prefix_class' => '',
                'options' => [
                    'always-open' => esc_html__('Always Open', 'pe-core'),
                    'click-to-open' => esc_html__('Click to Open', 'pe-core'),
                    'hover-to-open' => esc_html__('Hover to Open', 'pe-core'),
                    'open-on-scroll' => esc_html__('Open on Scroll', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'markers_style',
            [
                'label' => esc_html__('Markers Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'dot',
                'render_type' => 'template',
                'prefix_class' => '',
                'options' => [
                    'dot' => esc_html__('Dot', 'pe-core'),
                    'line' => esc_html__('Line', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'exclude' => [],
                'include' => [],
                'default' => 'large',
            ]
        );


        $repeater = new \Elementor\Repeater();

        $repeater->start_controls_tabs(
            'hotspot_item_tabs'
        );

        $repeater->start_controls_tab(
            'hotspot_content_tab',
            [
                'label' => esc_html__('Content', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'hotspot_type',
            [
                'label' => esc_html__('Hotspot Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'manual',
                'options' => [
                    'manual' => esc_html__('Manual Entry', 'pe-core'),
                    'product' => esc_html__('Product', 'pe-core'),
                ],

            ]
        );

        $options = [];

        $products = get_posts([
            'post_type' => 'product',
            'numberposts' => -1
        ]);

        foreach ($products as $product) {
            $options[$product->ID] = $product->post_title;
        }

        $repeater->add_control(
            'select_product',
            [
                'label' => __('Select Product', 'pe-core'),
                'label_block' => true,
                'description' => __('Select product which will display in the slider.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
                'condition' => ['hotspot_type' => 'product'],
            ]
        );

        $repeater->add_control(
            'hotspot_title',
            [
                'label' => esc_html__('CTA Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Write title here', 'pe-core'),
                'default' => esc_html__('Lorem ipsum .', 'pe-core'),
                'description' => esc_html__('Leave it empty if you do not want to display title', 'pe-core'),
                'condition' => ['hotspot_type' => 'manual'],
            ]
        );

        $repeater->add_control(
            'hotspot_content',
            [
                'label' => esc_html__('CTA Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => esc_html__('Write your text here', 'pe-core'),
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consequat egestas nisi. Vestibulum malesuada fermentum nibh. Donec venenatis, neque et pellentesque efficitur, lectus est preti.', 'pe-core'),
                'description' => esc_html__('Leave it empty if you do not want to display text', 'pe-core'),
                'rows' => 5,
                'condition' => ['hotspot_type' => 'manual'],
            ]
        );
        $repeater->add_control(
            'hotspot_link',
            [
                'label' => esc_html__('Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow', 'custom_attributes'],
                'default' => [
                    'is_external' => false,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => false,
                'description' => esc_html__('Leave it empty if you do not want to display link', 'pe-core'),
                'condition' => ['hotspot_type' => 'manual'],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'hotspot_style_tab',
            [
                'label' => esc_html__('Style', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'content_pos',
            [
                'label' => esc_html__('Content Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-v-align-middle'
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => ' eicon-v-align-bottom',
                    ],
                ],
                'default' => 'bottom',
                'render_type' => 'template',
                'toggle' => false,
            ]
        );

        $repeater->add_responsive_control(
            'content_width',
            [
                'label' => esc_html__('Content Max Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .hotspot--content{{CURRENT_ITEM}}' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'content_lignment',
            [
                'label' => esc_html__('Texts Alignment', 'pe-core'),
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
                    'justify' => [
                        'title' => esc_html__('Justify', 'pe-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .hotspot--content{{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $repeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'hotspot_title_typoraphy',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ht--title',
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'hotspot_content_typoraphy',
                'label' => esc_html__('Content Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ht--content',
            ]
        );


        $repeater->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .hotspot--content{{CURRENT_ITEM}}',
                'important' => true
            ]
        );


        $repeater->add_responsive_control(
            'content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .hotspot--content{{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} !important;',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .hotspot--content{{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );


        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();


        $repeater->start_controls_tabs(
            'hotspot_marker_tipos'
        );

        $repeater->start_controls_tab(
            'dot_markers',
            [
                'label' => esc_html__('Dot', 'pe-core'),
            ]
        );


        $repeater->add_responsive_control(
            'hotspot_vertical_orientation',
            [
                'label' => esc_html__('Hotspot Vertical Orientation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom'
                    ],
                ],
                'default' => 'top',
                'toggle' => false,

            ]
        );

        $repeater->add_responsive_control(
            'hotspot_vertical_offset_top',
            [
                'label' => esc_html__('Vertical Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'em'],
                'render_type' => 'template',
                'range' => [
                    'px' => [
                        'min' => -1000,
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
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.marker-dot' => 'top: {{SIZE}}{{UNIT}};bottom: unset',
                ],
                'condition' => [
                    'hotspot_vertical_orientation' => 'top',

                ],

            ]
        );

        $repeater->add_responsive_control(
            'hotspot_vertical_offset_bottom',
            [
                'label' => esc_html__('Vertical Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'em'],
                'render_type' => 'template',
                'range' => [
                    'px' => [
                        'min' => -1000,
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
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.marker-dot' => 'bottom: {{SIZE}}{{UNIT}};top: unset',
                ],
                'condition' => [
                    'hotspot_vertical_orientation' => 'bottom',

                ],

            ]
        );

        $repeater->add_responsive_control(
            'hotspot_horizontal_orientation',
            [
                'label' => esc_html__('Hotspot Horizontal Orientation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right'
                    ],
                ],
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,


            ]
        );

        $repeater->add_responsive_control(
            'hotspot_horizontal_offset_left',
            [
                'label' => esc_html__('Horizontal Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em'],
                'render_type' => 'template',
                'range' => [
                    'px' => [
                        'min' => -1000,
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
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.marker-dot' => 'left: {{SIZE}}{{UNIT}};right: unset',
                ],
                'condition' => [
                    'hotspot_horizontal_orientation' => 'left',

                ],

            ]
        );

        $repeater->add_responsive_control(
            'hotspot_horizontal_offset_right',
            [
                'label' => esc_html__('Horizontal Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em'],
                'render_type' => 'template',
                'range' => [
                    'px' => [
                        'min' => -1000,
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
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.marker-dot' => 'right: {{SIZE}}{{UNIT}};left: unset',
                ],
                'condition' => [
                    'hotspot_horizontal_orientation' => 'right',

                ],

            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'hotspot_line_markers',
            [
                'label' => esc_html__('Lines', 'pe-core'),
            ]
        );


        $repeater->add_responsive_control(
            'point_1_x',
            [
                'label' => esc_html__('Point 1 x', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'render_type' => 'template',
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--p1x: {{SIZE}}{{UNIT}}',
                ],

            ]
        );

        $repeater->add_responsive_control(
            'point_1_y',
            [
                'label' => esc_html__('Point 1 y', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'render_type' => 'template',
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--p1y: {{SIZE}}{{UNIT}}',
                ],

            ]
        );

        $repeater->add_responsive_control(
            'point_2_x',
            [
                'label' => esc_html__('Point 2 x', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'render_type' => 'template',
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--p2x: {{SIZE}}{{UNIT}}',
                ],

            ]
        );

        $repeater->add_responsive_control(
            'point_2_y',
            [
                'label' => esc_html__('Point 2 y', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'render_type' => 'template',
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--p2y: {{SIZE}}{{UNIT}}',
                ],

            ]
        );
        $repeater->add_responsive_control(
            'point_3_x',
            [
                'label' => esc_html__('Point 3 x', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'render_type' => 'template',
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--p3x: {{SIZE}}{{UNIT}}',
                ],

            ]
        );

        $repeater->add_responsive_control(
            'point_3_y',
            [
                'label' => esc_html__('Point 3 y', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'render_type' => 'template',
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--p3y: {{SIZE}}{{UNIT}}',
                ],

            ]
        );


        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();



        $this->add_control(
            'hotspot_repeater',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls()
            ]
        );



        $this->add_control(
            'scroll_pin',
            [
                'label' => esc_html__('Pin on Scroll', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'prefix_class' => '',
                'return_value' => 'pin-on-scroll',
                'default' => '',
                'condition' => ['hotspots_behavior' => 'open-on-scroll'],
            ]
        );

        $this->add_control(
            'spots_pin_target',
            [
                'label' => esc_html__('Pin Target', 'pe-core'),
                'placeholder' => esc_html__('Eg. #worksContainer', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('Normally the container pin itself but in some cases, a custom trigger may required.', 'pe-core'),
                'ai' => false,
                'condition' => [
                    'hotspots_behavior' => 'open-on-scroll',
                    'scroll_pin' => 'pin-on-scroll',
                ],
            ]
        );

        $this->add_control(
            'animate_marker',
            [
                'label' => esc_html__('Animate Marker', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'prefix_class' => '',
                'return_value' => 'animate--marker',
                'default' => 'animate--marker',

            ]
        );


        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
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
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--hotspot--image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['vh', 'px', '%'],
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--hotspot--image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .main--hotspot--image' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'pe-core'),
                'description' => esc_html__('Leave it empty if you dont want to make the image linked.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => true,
            ]
        );


        $this->add_control(
            'image__overlay',
            [
                'label' => esc_html__('Overlay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'si--overlayed',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'overlay__color',
            [
                'label' => esc_html__('Overlay Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--overlayColor: {{VALUE}}',
                ],
                'condition' => ['image__overlay' => 'si--overlayed'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .single-image',
            ]
        );

        $this->add_control(
            'saren_refresh_widget',
            [
                'label' => esc_html__('Refresh Widget', 'pe-core'),
                'description' => esc_html__('Usefull when using pinned scroll animations. In editor if the pinned animations conflicts just refresh the widget once.', 'pe-core'),
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

        $this->end_controls_section();

        $this->start_controls_section(
            'product_settings',
            [

                'label' => esc_html__('Product Settings', 'pe-core'),

            ]
        );

        pe_product_controls($this);

        $this->end_controls_section();


        $this->start_controls_section(
            'hotspot_styles',
            [

                'label' => esc_html__('Style', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'hotspot_image_width',
            [
                'label' => esc_html__('Image Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
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
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .main--hotspot--image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_fit',
            [
                'label' => esc_html__('Image Fit', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover', 'pe-core'),
                    'contain' => esc_html__('Contain', 'pe-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .main--hotspot--image' => 'object-fit: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => esc_html__('Dots Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.hotspot--marker' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} span.hotspot--marker::after' => 'background-color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_section();
        pe_product_styles($this, false);

        pe_image_animation_settings($this);



    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $markerStyle = $settings['markers_style'];



        ?>

        <div data-pin-target="<?php echo $settings['spots_pin_target'] ?>" class="pe--hotspot--image" <?php echo pe_image_animation($this); ?>>
            <?php if ($markerStyle === 'line') { ?>

                <svg class="hotspots--line--scene" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0">
                    <?php foreach ($settings['hotspot_repeater'] as $key => $hotSpot) {
                        $key++; ?>

                        <polyline data-vertical-orientation="<?php echo $hotSpot['hotspot_vertical_orientation'] ?>"
                            data-horizontal-orientation="<?php echo $hotSpot['hotspot_horizontal_orientation'] ?>"
                            data-index="<?php echo $key ?>"
                            class="hotspot--marker marker--line  hp__marker__<?php echo $key . ' ' . $hotSpot['hotspot_type'] . ' elementor-repeater-item-' . $hotSpot['_id'] ?>"
                            class="hotspot--line" points="0 38.4 70.93 38.4 128.01 .5 192.69 .5" />

                    <?php } ?>
                </svg>

                <?php foreach ($settings['hotspot_repeater'] as $key => $hotSpot) {
                    $key++
                        ?>
                    <span data-index="<?php echo $key ?>"
                        class="hotspot--line--dot hp__line__dot__<?php echo $key . ' ' . $hotSpot['hotspot_type'] . ' elementor-repeater-item-' . $hotSpot['_id'] ?>">
                        <?php
                        $svgPath = get_template_directory() . '/assets/img/add.svg';
                        $icon = file_get_contents($svgPath);
                        echo $icon;
                        ?>
                    </span>
                <?php } ?>

            <?php } ?>

            <?php
            foreach ($settings['hotspot_repeater'] as $key => $hotSpot) {
                $key++;

                if ($markerStyle === 'dot') {
                    ?>

                    <span data-vertical-orientation="<?php echo $hotSpot['hotspot_vertical_orientation'] ?>"
                        data-horizontal-orientation="<?php echo $hotSpot['hotspot_horizontal_orientation'] ?>"
                        data-index="<?php echo $key ?>"
                        class="hotspot--marker marker-dot  hp__marker__<?php echo $key . ' ' . $hotSpot['hotspot_type'] . ' elementor-repeater-item-' . $hotSpot['_id'] ?>"></span>

                <?php }

                if ($hotSpot['hotspot_type'] === 'manual') { ?>

                    <div
                        class="hotspot--content hp__content__<?php echo $key . ' ' . ' pos--' . $hotSpot['content_pos'] . ' ' . $hotSpot['hotspot_type'] . ' ' . $hotSpot['hotspot_vertical_orientation'] . ' ' . $hotSpot['hotspot_horizontal_orientation'] . ' elementor-repeater-item-' . $hotSpot['_id'] ?>">


                        <span class="hotspot--close">
                            <?php
                            $svgPath = get_template_directory() . '/assets/img/add.svg';
                            $icon = file_get_contents($svgPath);
                            echo $icon;
                            ?>
                        </span>

                        <div class="ht--title">

                            <?php echo $hotSpot['hotspot_title'] ?>

                        </div>

                        <?php if (!empty($hotSpot['hotspot_content'])) { ?>
                            <div class="ht--content">
                                <?php echo $hotSpot['hotspot_content'] ?>
                            </div>
                        <?php } ?>
                    </div>

                <?php } else {

                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 1,
                        'post__in' => [$hotSpot['select_product']],
                        'orderby' => 'post__in'
                    );

                    $the_query = new \WP_Query($args);
                    while ($the_query->have_posts()):
                        $the_query->the_post();
                        $classes = 'saren--single--product ' . $settings['product_style']; ?>
                        
                        <div
                            class="hotspot--content hp__content__<?php echo $key . ' ' . ' pos--' . $hotSpot['content_pos'] . ' ' . $hotSpot['hotspot_type'] . ' ' . $hotSpot['hotspot_vertical_orientation'] . ' ' . $hotSpot['hotspot_horizontal_orientation'] . ' elementor-repeater-item-' . $hotSpot['_id'] ?>">

                            <span class="hotspot--close">
                                <?php
                                $svgPath = get_template_directory() . '/assets/img/add.svg';
                                $icon = file_get_contents($svgPath);
                                echo $icon;
                                ?>
                            </span>
                            
                            <?php sarenProductRender($settings, wc_get_product(), $classes); ?>
                        </div>

                    <?php endwhile;
                    wp_reset_query();
                }
            }

            ?>

            <?php
            $image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'image_size', 'image');
            $image_html = str_replace('<img ', '<img class="main--hotspot--image" ', $image_html);

            echo $image_html;
            ?>

        </div>


        <?php
    }

}
