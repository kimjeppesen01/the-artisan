<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeWooAjaxSearch extends Widget_Base
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
        return 'pewooajaxsearch';
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
        return __('AJAX Search (Woo)', 'pe-core');
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
        return 'eicon-search pe-widget';
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
                'label' => __('AJAX Search (Woo)', 'pe-core'),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'popup' => esc_html__('Popup', 'pe-core'),
                    'default' => esc_html__('Default', 'pe-core'),
                    'fullscreen' => esc_html__('Fullscreen', 'pe-core'),
                    'overlay' => esc_html__('Overlay', 'pe-core'),

                ],
            ]
        );

        $this->add_control(
            'behavior',
            [
                'label' => esc_html__('Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'open',
                'options' => [
                    'open' => esc_html__('Open', 'pe-core'),
                    'expand-on-focus' => esc_html__('Expand on focus', 'pe-core'),
                ],
                'condition' => ['style' => 'default'],
                'prefix_class' => 'default--behavior--',
                'render_type' => 'template',
            ]
        );


        popupOptions($this, ['style' => 'popup']);

        $this->add_control(
            'search_button_style',
            [
                'label' => esc_html__('Button Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'text',
                'render_type' => 'template',
                'prefix_class' => 'button--style--',
                'options' => [
                    'text' => esc_html__('Text', 'pe-core'),
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'icon_text' => esc_html__('Icon - Text', 'pe-core'),
                ],
                'condition' => ['style!' => 'default'],
            ]
        );

        $this->add_control(
            'search_button_text',
            [
                'label' => esc_html__('Button text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => false,
                'placeholder' => esc_html__('Write text here', 'pe-core'),
                'default' => esc_html__('Search', 'pe-core'),
                'ai' => false,
                'condition' => ['search_button_style' => ['text', 'icon_text']],
            ]
        );

        $this->add_control(
            'search_button_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'style!' => 'default',
                    'search_button_style' => ['icon', 'icon_text']
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
                    '{{WRAPPER}} .saren--woo--ajax--search--button' => '--iconSize: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pe--search--pop--button' => '--iconSize: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'style!' => 'default',
                    'search_button_style' => ['icon', 'icon_text']
                ],
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => esc_html__('Input Placeholder', 'pe-core'),
                'default' => esc_html__('Search...', 'pe-core'),
            ]
        );

        $this->add_control(
            'results_count',
            [
                'label' => esc_html__('Results Count per Search', 'pe-core'),
                'description' => esc_html__('Max number of results.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 4,
            ]
        );

        $this->add_responsive_control(
            'results_orientation',
            [
                'label' => esc_html__('Results Oritentation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex' => [
                        'title' => esc_html__('Grid', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'grid' => [
                        'title' => esc_html__('Flex', 'pe-core'),
                        'icon' => ' eicon-h-align-right',
                    ],
                ],
                'default' => 'grid',
                'prefix_class' => 'results__orientation-%s',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .saren--ajax--search--result' => 'display: {{VALUE}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'grid_columns',
            [
                'label' => esc_html__('Grid Columns', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 12,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--ajax--search--result' => 'grid-template-columns: repeat({{SIZE}} ,  1fr)',
                ],
                'condition' => [
                    'results_orientation' => 'grid',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_orientation',
            [
                'label' => esc_html__('Items Oritentation', 'pe-core'),
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
                'default' => 'column',
                'prefix_class' => 'items__orientation-%s',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .saren--search--product a' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more',
            [
                'label' => __('Load More Results', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'popular_searches',
            [
                'label' => __('Popular Searches (Tags)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'pe-core'),
                'label_off' => __('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $tags = get_terms([
            'taxonomy' => 'product_tag',
            'hide_empty' => false,
        ]);

        $options = [];

        if (!empty($tags) && !is_wp_error($tags)) {
            foreach ($tags as $tag) {
                $options[$tag->term_id] = $tag->name;
            }
        }

        $this->add_control(
            'select_tags',
            [
                'label' => __('Select Tags to Display', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $options,
                'condition' => [
                    'popular_searches' => 'yes',
                ],

            ]
        );

        $this->add_control(
            'tags_randomize',
            [
                'label' => __('Randomize Tags', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'popular_searches' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'max_tags',
            [
                'label' => esc_html__('Max Visible', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 20,
                'step' => 1,
                'default' => 5,
                'condition' => [
                    'popular_searches' => 'yes',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'button_settings',
            [
                'label' => esc_html__('Load More Button Settings', 'pe-core'),
                'condition' => [
                    'load_more' => 'yes',

                ],


            ]
        );

        pe_button_settings($this, false, false);

        $this->end_controls_section();

        pe_cursor_settings($this);

        $this->start_controls_section(
            'search_styles',
            [
                'label' => esc_html__('Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'form_alignment',
            [
                'label' => esc_html__('Form Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} form#saren-woo-ajax-search-form' => 'align-items: {{VALUE}};',
                ],
                'default' => 'start',
                'toggle' => false,
            ]
        );

        objetAbsolutePositioning($this, '.saren--woo--search--icon', 'search_icon', 'Search Icon');


        objectStyles($this, 'widget_input_', 'Input', 'input#saren-woo-search-input', true, false, false, true, false);

        $this->add_control(
            'inputs_bg',
            [
                'label' => __('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'search--input--has--bg',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'input_width',
            [
                'label' => esc_html__('Input Width', 'pe-core'),
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
                    '{{WRAPPER}} .saren-woo-ajax-search-input' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        objectStyles($this, 'resutls_styles', 'Results', '#saren-woo-search-results', true, false, false, true, false);

        $this->add_responsive_control(
            'results_width',
            [
                'label' => esc_html__('Results Width', 'pe-core'),
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
                    '{{WRAPPER}} .saren--woo--ajax--search div#saren-woo-search-results' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'results_max_height',
            [
                'label' => esc_html__('Results Max Height', 'pe-core'),
                'description' => esc_html__('Usefull when using ajax load more.', 'pe-core'),
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
                    '{{WRAPPER}} .saren--woo--ajax--search div#saren-woo-search-results' => 'max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'results_gap',
            [
                'label' => esc_html__('Results Gap', 'pe-core'),
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
                    '{{WRAPPER}} .saren--ajax--search--result' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'results_position',
            [
                'label' => esc_html__('Results Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'absolute',
                'options' => [
                    'absolute' => esc_html__('Absolute', 'pe-core'),
                    'static' => esc_html__('Static', 'pe-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}}  div#saren-woo-search-results' => 'position: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'product_styles',
            [
                'label' => esc_html__('Products Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        objectStyles($this, 'products_styles', 'Products', '.saren--search--product', true, false, false, true, false);

        $this->add_control(
            'search_products_bg',
            [
                'label' => __('Products Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'search--products--has--bg',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'search_products_backgground_color',
            [
                'label' => esc_html__('Background Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .saren--search--product' => '--secondaryBackground: {{VALUE}}',
                ],
                'condition' => ['search_products_bg' => 'search--products--has--bg'],
            ]
        );

        $this->add_control(
            'search_products_backgground_color_switched',
            [
                'label' => esc_html__('Background Color (Switched)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    'body.layout--switched {{WRAPPER}} .saren--search--product' => '--secondaryBackground: {{VALUE}}',
                ],
                'condition' => ['search_products_bg' => 'search--products--has--bg'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .saren--search--product--title p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__('Price Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .product-price',
            ]
        );

        $this->add_responsive_control(
            'products_width',
            [
                'label' => esc_html__('Products Width', 'pe-core'),
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
                    '{{WRAPPER}} .saren--search--product' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'product_images_width',
            [
                'label' => esc_html__('Images Width', 'pe-core'),
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
                    '{{WRAPPER}} .saren--search--product--image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'product_images_height',
            [
                'label' => esc_html__('Images Height', 'pe-core'),
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
                    '{{WRAPPER}} .saren--search--product--image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();

        objectStyles($this, 'tags_', 'Tags', 'span.search-tag.pe--styled--object', true, ['popular_searches' => 'yes']);

        objectStyles($this, 'search_but_', 'Button', '.saren--woo--ajax--search--button.pe--styled--object , {{WRAPPER}} .pe--pop--button.pe--styled--object', true, ['style!' => 'default']);

        $this->start_controls_section(
            'popup_styles_sec',
            [
                'label' => esc_html__('Popup Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['style' => 'popup'],
            ]
        );

        popupStyles($this, ['style' => 'popup']);

        $this->end_controls_section();

        pe_button_style_settings($this, 'Load More Button', 'load_more_button', ['load_more' => 'yes',]);
        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $style = $settings['style'];

        $object = '';

        if ($settings['search_button_style'] === 'icon') {

            if ($settings['search_button_icon']['value']) {
                ob_start();
                \Elementor\Icons_Manager::render_icon($settings['search_button_icon'], ['aria-hidden' => 'true']);
                $object = ob_get_clean();

            } else {
                $svgPath = plugin_dir_path(__FILE__) . '../assets/img/search.svg';
                $object = file_get_contents($svgPath);
            }

        } else if ($settings['search_button_style'] === 'text') {

            $object = $settings['search_button_text'];

        } else if ($settings['search_button_style'] === 'icon_text') {

            if ($settings['search_button_icon']['value']) {
                ob_start();
                \Elementor\Icons_Manager::render_icon($settings['search_button_icon'], ['aria-hidden' => 'true']);
                $icon = ob_get_clean();

            } else {
                $svgPath = plugin_dir_path(__FILE__) . '../assets/img/search.svg';
                $icon = file_get_contents($svgPath);
            }
            $object = '<span>' . $icon . '</span><span>' . $settings['search_button_text'] . '</span>';

        }

        ?>

        <div class="saren--woo--ajax--search <?php echo 'search--' . $style ?>"
            data-results-count="<?php echo $settings['results_count'] ?>">
            <?php if ($style !== 'default' && $style !== 'popup') { ?>

                <?php if ($settings['search_button_style'] === 'icon') { ?>

                    <div class="saren--woo--ajax--search--button pe--styled--object" <?php echo pe_cursor($this); ?>>

                        <?php echo $object; ?>

                    </div>
                <?php } else if ($settings['search_button_style'] === 'text') {

                    echo ' <div class="saren--woo--ajax--search--button pe--styled--object" ' . pe_cursor($this) . '>
                       ' . $object . '
                        </div>';

                }

                echo ' <span class="ajax--search--overlay"></span>'; ?>

                <form id="saren-woo-ajax-search-form">

                    <div class="saren-woo-ajax-search-input">
                        <input type="text" id="saren-woo-search-input" placeholder="<?php echo $settings['placeholder'] ?>"
                            autocomplete="off">
                        <?php
                        $svgPath = plugin_dir_path(__FILE__) . '../assets/img/search.svg';
                        echo file_get_contents($svgPath);
                        ?>
                    </div>

                    <div id="saren-woo-search-results" class="search--results-wrap" data-lenis-prevent>

                        <div class="s--woo--search--results"></div>

                        <?php if ($settings['load_more'] === 'yes') { ?>
                            <div class="search--products--load--more saren--search--pagination">

                                <?php pe_button_render($this); ?>

                            </div>
                        <?php } ?>

                    </div>
                </form>

            <?php } else if ($style === 'popup') { ?>

                    <div class="pe--search--pop--button pe--pop--button pe--styled--object"><?php echo $object ?></div>

                <?php if ($settings['back_overlay'] === 'true') { ?>
                        <span class="pop--overlay"></span>
                <?php } ?>


                    <div class="pe--search--popup pe--styled--popup">

                        <span class="pop--close">

                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                <path
                                    d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z" />
                            </svg>

                        </span>

                        <form id="saren-woo-ajax-search-form">

                            <div class="saren-woo-ajax-search-input">
                                
                                <input type="text" id="saren-woo-search-input" class="s--woo--search--input"
                                    placeholder="<?php echo $settings['placeholder'] ?>" autocomplete="off">
                                <div class="saren--woo--search--icon s--search">
                                    <?php
                                    $svgPath = plugin_dir_path(__FILE__) . '../assets/img/search.svg';
                                    echo file_get_contents($svgPath);
                                    ?>

                                </div>

                                <div class="saren--woo--search--icon s--wait">
                                    <?php
                                    $svgPath = plugin_dir_path(__FILE__) . '../assets/img/wait.svg';
                                    echo file_get_contents($svgPath);
                                    ?>

                                </div>

                            </div>

                        <?php if ($settings['popular_searches'] === 'yes') {
                            $tags = $settings['select_tags'];
                            ?>
                                <div class="woo--ajax--search--tags">
                                <?php if (!empty($tags)) {

                                    if ($settings['tags_randomize']) {

                                        $random_keys = array_rand($tags, min($settings['max_tags'], count($tags))); // Ensure we don't try to get more than the available tags
                
                                        if (!is_array($random_keys)) {
                                            $random_keys = [$random_keys];
                                        }

                                        foreach ($random_keys as $key) {
                                            $tag_id = $tags[$key];
                                            $term = get_term($tag_id);
                                            
                                            if (!is_wp_error($term) && $term !== null) {
                                                $term_name = $term->name;
                                                echo '<span data-val="' . esc_attr($term_name) . '" class="search-tag pe--styled--object"><span>' . esc_html($term_name) . '</span></span>';
                                            }
                                        }

                                    } else {

                                        foreach ($tags as $tag) {
                                            $term_name = get_term($tag)->name;
                                            echo '<span data-val="' . $term_name . '" class="search-tag pe--styled--object"><span>' . $term_name . '</span></span>';
                                        }
                                    }
                                } ?>

                                </div>
                        <?php } ?>

                            <div id="saren-woo-search-results" class="search--results-wrap" data-lenis-prevent>

                                <div class="s--woo--search--results"></div>

                            <?php if ($settings['load_more'] === 'yes') { ?>
                                    <div class="search--products--load--more saren--search--pagination">

                                    <?php pe_button_render($this); ?>

                                    </div>
                            <?php } ?>

                            </div>
                        </form>
                    </div>


            <?php } else if ($style === 'default') { ?>

                        <form id="saren-woo-ajax-search-form">

                            <div class="saren-woo-ajax-search-input">
                                <input type="text" id="saren-woo-search-input" class="s--woo--search--input"
                                    placeholder="<?php echo $settings['placeholder'] ?>" autocomplete="off">
                                <div class="saren--woo--search--icon s--search">
                                <?php
                                $svgPath = plugin_dir_path(__FILE__) . '../assets/img/search.svg';
                                echo file_get_contents($svgPath);
                                ?>

                                </div>

                                <div class="saren--woo--search--icon s--wait">
                                <?php
                                $svgPath = plugin_dir_path(__FILE__) . '../assets/img/wait.svg';
                                echo file_get_contents($svgPath);
                                ?>

                                </div>

                            </div>

                    <?php if ($settings['popular_searches'] === 'yes') {
                        $tags = $settings['select_tags'];
                        ?>
                                <div class="woo--ajax--search--tags">
                            <?php if (!empty($tags)) {

                                if ($settings['tags_randomize']) {

                                    $random_keys = array_rand($tags, min($settings['max_tags'], count($tags))); // Ensure we don't try to get more than the available tags
            
                                    if (!is_array($random_keys)) {
                                        $random_keys = [$random_keys];
                                    }

                                    foreach ($random_keys as $key) {
                                        $term = get_term($tags[$key]);
                                        if (!is_wp_error($term) && $term) {
                                            $term_name = $term->name;
                                            echo '<span data-val="' . esc_attr($term_name) . '" class="search-tag pe--styled--object"><span>' . esc_html($term_name) . '</span></span>';
                                        }
                                    }

                                } else {

                                    foreach ($tags as $tag) {
                                        $term_name = get_term($tag)->name;
                                        echo '<span data-val="' . $term_name . '" class="search-tag pe--styled--object"><span>' . $term_name . '</span></span>';
                                    }
                                }
                            } ?>

                                </div>
                    <?php } ?>

                            <div id="saren-woo-search-results" class="search--results-wrap" data-lenis-prevent>

                                <div class="s--woo--search--results"></div>

                        <?php if ($settings['load_more'] === 'yes') { ?>
                                    <div class="search--products--load--more saren--search--pagination">

                                <?php pe_button_render($this); ?>

                                    </div>
                        <?php } ?>

                            </div>

                        </form>

            <?php } ?>

        </div>



    <?php }

}
