<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeProductsArchive extends Widget_Base
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
        return 'peproductsarchive';
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
        return __('Products', 'pe-core');
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
        return 'eicon-products-archive pe-widget';
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
        return ['pe-woo'];
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


        $this->start_controls_section(
            'widget_content',
            [
                'label' => __('Query Options', 'pe-core'),
            ]
        );

        $this->add_control(
            'products_archive_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__('Grid', 'pe-core'),
                    'masonry' => esc_html__('Masonry', 'pe-core'),
                    'list' => esc_html__('List', 'pe-core'),
                ],
                'frontend_available' => true,
            ]
        );

        saren_product_query_selection($this, true);

        $this->add_responsive_control(
            'grid_columns',
            [
                'label' => esc_html__('Grid Columns', 'pe-core'),
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
                    '{{WRAPPER}} .saren--products-grid' => '--columns: {{SIZE}};',
                ],
                'condition' => [
                    'products_archive_style' => 'grid',
                ],
            ]
        );

        $this->add_control(
            'grid_switcher',
            [
                'label' => __('Grid Switcher', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'on',
                'render_type' => 'template',
                'prefix_class' => 'grid--switcher--',
                'default' => '',
            ]
        );

        $this->add_control(
            'grid_switch_columns',
            [
                'label' => esc_html__('Grid Switch Columns', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => [
                    '1' => esc_html__('1 Column', 'pe-core'),
                    '2' => esc_html__('2 Columns', 'pe-core'),
                    '3' => esc_html__('3 Columns', 'pe-core'),
                    '4' => esc_html__('4 Columns', 'pe-core'),
                    '5' => esc_html__('5 Columns', 'pe-core'),
                    '6' => esc_html__('6 Columns', 'pe-core'),
                ],
                'default' => ['2-column', '3-column'],
                'condition' => [
                    'grid_switcher' => 'on',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'product_settings',
            [
                'label' => esc_html__('Products Settings', 'pe-core'),
            ]
        );



        pe_product_controls($this);

        $this->end_controls_section();

        $this->start_controls_section(
            'product_controls',
            [
                'label' => __('Controls', 'pe-core'),
            ]
        );

        $this->add_control(
            'sorting',
            [
                'label' => __('Sorting', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'sorting_position',
            [
                'label' => __('Sorting Position', 'pe-core'),
                'label_block' => false,
                'default' => 'default',
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('Default', 'pe-core'),
                    'with-filters' => esc_html__('With Filters', 'pe-core'),
                ],
                'condition' => [
                    'additional_filters' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'sorting_label',
            [
                'label' => esc_html__('Sorting Label', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Sort by;', 'pe-core'),
                'label_block' => false,
                'condition' => [
                    'sorting_position' => 'with-filters',
                    'additional_filters' => 'yes',
                ],
            ]
        );



        $this->add_control(
            'filter_cats',
            [
                'label' => __('Category Filters', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'cats_show_count',
            [
                'label' => __('Products Count', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'pe-core'),
                'label_off' => __('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'filter_cats' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'filter_cats_style',
            [
                'label' => __('Category Filters Style', 'pe-core'),
                'label_block' => false,
                'default' => 'label',
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'label' => esc_html__('Label', 'pe-core'),
                    'image' => esc_html__('Image', 'pe-core'),
                ],
                'condition' => [
                    'filter_cats' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'filter_cats_desc',
            [
                'label' => __('Category Descriptions', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'filter_cats' => 'yes',
                    'filter_cats_style' => 'image',
                ],
            ]
        );

        $this->add_control(
            'filter_cats_counts',
            [
                'label' => __('Category Counts', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'prefix_class' => 'cat--counts--',
                'condition' => [
                    'filter_cats' => 'yes',
                    'filter_cats_style' => 'image',
                ],
            ]
        );


        $productCats = array();

        $args = array(
            'hide_empty' => true,
            'taxonomy' => 'product_cat'
        );

        $categories = get_categories($args);

        foreach ($categories as $key => $category) {
            $productCats[$category->term_id] = $category->name;
        }

        $this->add_control(
            'cats_for_filters',
            [
                'label' => __('Categories', 'pe-core'),
                'description' => __('For filtering.', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $productCats,
                'condition' => [
                    'filter_cats' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'filters_all_text',
            [
                'label' => esc_html__('View All Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('All', 'pe-core'),
                'label_block' => false,
                'condition' => [
                    'filter_cats' => 'yes',
                    'filter_cats_style' => 'label',
                ],
            ]
        );


        $this->add_control(
            'additional_filters',
            [
                'label' => __('Additonal Filters', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );



        $filtersRepeater = new \Elementor\Repeater();

        $filtersRepeater->add_control(
            'filter_label',
            [
                'label' => esc_html__('Label', 'pe-core'),
                'description' => esc_html__('Leave it empty if you dont want to display label', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => false,
            ]
        );

        $filtersRepeater->start_controls_tabs(
            'animation_options_tabs'
        );

        $filtersRepeater->start_controls_tab(
            'filters_content_tab',
            [
                'label' => esc_html__('Content', 'pe-core'),
            ]
        );

        $filtersRepeater->add_control(
            'filter_by',
            [
                'label' => __('Filter By', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'attributes' => esc_html__('Attributes', 'pe-core'),
                    'categories' => esc_html__('Categories', 'pe-core'),
                    'brands' => esc_html__('Brands', 'pe-core'),
                    'price' => esc_html__('Price', 'pe-core'),
                    'tag' => esc_html__('Tag', 'pe-core'),
                    'on-sale' => esc_html__('On Sale', 'pe-core'),
                ],
            ]
        );

        $filtersRepeater->add_control(
            'input_style',
            [
                'label' => __('Inout Style', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'classic--checkbox' => esc_html__('Checkbox', 'pe-core'),
                    'button--select' => esc_html__('Button', 'pe-core'),
                ],
                'default' => 'button--select',
                'condition' => [
                    'filter_by' => ['attributes', 'brands', 'tag', 'categories'],
                ],
            ]
        );

        $filtersRepeater->add_control(
            'show_count',
            [
                'label' => __('Products Count', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'pe-core'),
                'label_off' => __('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );


        $filtersRepeater->add_responsive_control(
            'inputs_orientation',
            [
                'label' => esc_html__('Inputs Orientation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Horizontal', 'pe-core'),
                        'icon' => 'eicon-arrow-right',
                    ],
                    'column' => [
                        'title' => esc_html__('Vertical', 'pe-core'),
                        'icon' => 'eicon-arrow-down',
                    ],
                ],
                'default' => 'column',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .pe--product--filters {{CURRENT_ITEM}} .terms-list:not(:has(.filter-term-color)) , {{WRAPPER}} .pe--product--filters {{CURRENT_ITEM}} .terms-list:not(:has(.filter-term-color) :has(.filter-term-color))' => 'flex-direction: {{VALUE}};align-items:start;',
                    '{{WRAPPER}} .pe--product--filters {{CURRENT_ITEM}} .terms-list:has(.terms--terms) .terms--terms' => 'flex-direction: {{VALUE}};',
                ],
                'condition' => [
                    'filter_by' => ['attributes', 'brands', 'tag', 'categories'],
                ],
            ]
        );

        $filtersRepeater->add_control(
            'min_price',
            [
                'label' => esc_html__('Min Price', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100000,
                'step' => 1,
                'default' => 0,
                'condition' => [
                    'filter_by' => 'price',
                ],
            ]
        );

        $filtersRepeater->add_control(
            'max_price',
            [
                'label' => esc_html__('Max Price', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100000,
                'step' => 1,
                'default' => 1000,
                'condition' => [
                    'filter_by' => 'price',
                ],
            ]
        );

        $attributeQuery = array();

        $attributes = wc_get_attribute_taxonomies();

        foreach ($attributes as $key => $attribute) {
            $attributeQuery[$attribute->attribute_id] = $attribute->attribute_label;
        }

        $filtersRepeater->add_control(
            'select_attribute',
            [
                'label' => __('Attributes', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $attributeQuery,
                'condition' => [
                    'filter_by' => 'attributes',
                ],
            ]
        );

        $tagsQuery = array();

        $tags = get_terms(array(
            'taxonomy' => 'product_tag',
            'hide_empty' => true,
        ));

        foreach ($tags as $tag) {
            $tagsQuery[$tag->term_id] = $tag->name;
        }

        $filtersRepeater->add_control(
            'select_tags',
            [
                'label' => __('Tags', 'pe-core'),
                'description' => __('Leave it empty if you want to display all.', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $tagsQuery,
                'condition' => [
                    'filter_by' => 'tag',
                ],
            ]
        );

        $productBrands = array();

        $brands = get_terms(array(
            'taxonomy' => 'brand',
            'hide_empty' => false,
        ));
        if (!is_wp_error($brands)) {
    
            foreach ($brands as $key => $brand) {
                $productBrands[$brand->term_id] = $brand->name;
            }
    
        }
        $filtersRepeater->add_control(
            'select_brands',
            [
                'label' => __('Brands', 'pe-core'),
                'description' => __('Leave it empty if you want to display all.', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $productBrands,
                'condition' => [
                    'filter_by' => 'brands',
                ],
            ]
        );

        $filtersRepeater->add_control(
            'select_side_cats',
            [
                'label' => __('Categories', 'pe-core'),
                'description' => __('Leave it empty if you want to display all.', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $productCats,
                'condition' => [
                    'filter_by' => 'categories',
                ],
            ]
        );

        $filtersRepeater->end_controls_tab();
        $filtersRepeater->start_controls_tab(
            'filters_style_tab',
            [
                'label' => esc_html__('Style', 'pe-core'),
            ]
        );

        $filtersRepeater->add_control(
            'show_labels',
            [
                'label' => __('Hide Labels', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pe--product--filters .terms-list-title' => 'display: {{VALUE}};',
                ],
            ]
        );

        $filtersRepeater->add_control(
            'labels_block',
            [
                'label' => __('Labels Block', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'prefix_class' => 'products--labels--inline-',
                'return_value' => '100%',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pe--product--filters .terms-list-title' => 'width: {{VALUE}};',
                ],
            ]
        );


        $filtersRepeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'labels_typography',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .terms-list-title, {{WRAPPER}} {{CURRENT_ITEM}} .filter--label',
                'label' => esc_html__('Labels Typography', 'pe-core'),
            ]
        );

        $filtersRepeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'inputs_typography',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .term--list--item:not(:has(.filter-term-color)) , {{WRAPPER}} {{CURRENT_ITEM}} label.classic--checkbox:has(.filter-term-color) span.term--name',
                'label' => esc_html__('Inputs Typography', 'pe-core'),
            ]
        );

        $filtersRepeater->add_responsive_control(
            'attributes_spacing',
            [
                'label' => esc_html__('Attributes Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'em'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .terms-list:not(:has(.terms--terms))' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .terms--terms' => 'gap: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );


        $filtersRepeater->add_control(
            'attributes_has_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'var(--secondaryBackground)',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .term--list--item:not(:has(input:checked))' => 'background: {{VALUE}};',
                ],
            ]
        );

        $filtersRepeater->add_responsive_control(
            'terms_alignments',
            [
                'label' => esc_html__('Alignments', 'pe-core'),
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
                    '{{WRAPPER}} {{CURRENT_ITEM}} .term--list--item' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        objectStyles($filtersRepeater, 'filters_input_', 'Input', '{{CURRENT_ITEM}} .term--list--item ', false, false, false, true);

        $filtersRepeater->end_controls_tab();

        $filtersRepeater->end_controls_tabs();

        $filtersRepeater->add_control(
            'attribute_colors',
            [
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label' => esc_html__('Colors', 'pe-core'),
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'adv--styled',
            ]
        );

        $filtersRepeater->start_popover();
        pe_color_options($filtersRepeater, '{{CURRENT_ITEM}}', 'filters__', false);
        $filtersRepeater->end_popover();

        $this->add_control(
            'filters_repeater',
            [
                'label' => esc_html__('Add Filters', 'pe-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $filtersRepeater->get_controls(),
                'show_label' => true,
                'condition' => [
                    'additional_filters' => 'yes',
                ],
                'title_field' => '{{{ filter_by }}}',
            ]
        );


        $this->add_control(
            'filters_behavior',
            [
                'label' => esc_html__('Filters Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'always-show',
                'options' => [
                    'always-show' => esc_html__('Always Show', 'pe-core'),
                    'popup' => esc_html__('Popup', 'pe-core'),
                    'dropdown' => esc_html__('Dropdown', 'pe-core'),
                    'sidebar' => esc_html__('Sidebar', 'pe-core'),
                ],
                'condition' => [
                    'additional_filters' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'filters_button_fixed',
            [
                'label' => esc_html__('Fixed Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'filters--button--fixed',
                'prefix_class' => '',
                'default' => '',
                'condition' => [
                    'filters_behavior' => 'popup',
                ],
            ]
        );

        $this->add_control(
            'filters_button_pos',
            [
                'label' => esc_html__('Button Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'filters--button--pos--',
                'default' => 'left',
                'toggle' => false,
                'condition' => [
                    'filters_behavior' => 'popup',
                ],
            ]
        );


        popupOptions($this, ['filters_behavior' => 'popup']);

        $this->add_control(
            'filters_sidebar_pin',
            [
                'label' => __('Sidebar Pin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'filters--sidebar--pin',
                'prefix_class' => '',
                'default' => 'filters--sidebar--pin',
                'condition' => [
                    'filters_behavior' => 'sidebar',
                ],
            ]
        );

        $this->add_responsive_control(
            'filters_controls_alignment',
            [
                'label' => esc_html__('Controls Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],

                ],
                'default' => is_rtl() ? 'right' : 'left',
                'prefix_class' => 'sidebar--pos--',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .pe--filters--sidebar ' => 'display: block; float: {{VALUE}};',
                ],
                'condition' => [
                    'filters_behavior' => 'sidebar',
                ],
            ]
        );

        $this->add_control(
            'filters_style',
            [
                'label' => esc_html__('Filters Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'prefix_class' => 'filters--',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'pe-core'),
                    'vertical' => esc_html__('Vertical', 'pe-core'),
                    'accordion' => esc_html__('Accordion', 'pe-core'),
                ],
                'condition' => [
                    'additional_filters' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'filters_button_text',
            [
                'label' => esc_html__('Button Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Filters', 'pe-core'),
                'label_block' => false,
                'condition' => [
                    'filters_behavior!' => 'always-show',
                ],
            ]
        );

        $this->add_control(
            'filters_button_custom_icon',
            [
                'label' => esc_html__('Filters Button Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'filters_behavior!' => ['always-show', 'sidebar'],
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'pagination',
            [
                'label' => esc_html__('Pagination', 'pe-core'),
            ]
        );

        $this->add_control(
            'pagination_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'ajax-load-more',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'ajax-load-more' => esc_html__('AJAX Load More', 'pe-core'),
                    'infinite-scroll' => esc_html__('Infinite Scroll', 'pe-core'),
                ],

            ]
        );

        $cond = ['pagination_style' => 'ajax-load-more'];
        pe_button_settings($this, false, $cond);

        $this->end_controls_section();

        $this->start_controls_section(
            'popup_styles_sec',
            [
                'label' => esc_html__('Popup Styles (Filters)', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['filters_behavior' => 'popup'],
            ]
        );

        popupStyles($this, ['filters_behavior' => 'popup'] , '.filters--wrapper');

        $this->end_controls_section();
       
       

        $this->start_controls_section(
            'products_additonal',
            [
                'label' => esc_html__('Additional Options', 'pe-core'),
            ]
        );

        $this->add_control(
            'is_related_query',
            [
                'label' => esc_html__('Is Related Products', 'pe-core'),
                'description' => esc_html__('If you switch this on, the widget will be visible only on "Single Product" pages and all other query options will be overwritten by related products query.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'is_fbt_query',
            [
                'label' => esc_html__('Is Frequentyl Bought Togeter Products', 'pe-core'),
                'description' => esc_html__('If you switch this on, the widget will be visible only on "Single Product" pages and all other query options will be overwritten by fbt products query.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => '',
                'default' => '',
            ]
        );


        $this->add_control(
            'is_wishlist',
            [
                'label' => esc_html__('Is Wishlist Products', 'pe-core'),
                'description' => esc_html__('If you switch this on, the widget will display only wishlist products.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'wishlist_empty_title',
            [
                'label' => esc_html__('Empty Wishlist Headline', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Your Wishlist is Empty
                ', 'pe-core'),
                'label_block' => false,
                'condition' => [
                    'is_wishlist' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'wishlist_empty_sub',
            [
                'label' => esc_html__('Empty Wishlist Subtext', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Looks like you haven’t added any products to your wishlist yet. Start exploring and save your favorites for later!', 'pe-core'),
                'label_block' => true,
                'condition' => [
                    'is_wishlist' => 'yes',
                ],
            ]
        );




        $this->end_controls_section();

        pe_product_styles($this);

        $this->start_controls_section(
            'filters_styles',
            [
                'label' => esc_html__('Filters Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'filters_button_typography',
                'label' => esc_html__('Filters Button Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .filters--button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'filters_labels_typography',
                'label' => esc_html__('Filter Labels Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .filter--label , {{WRAPPER}} .terms-list-title p ',
            ]
        );


        $this->add_responsive_control(
            'filters_spacing',
            [
                'label' => esc_html__('Filters Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'em'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--product--filters .filters--wrapper' => '--gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'filters_seperator',
            [
                'label' => esc_html__('Sperator', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'filters--seperated',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sorting_styles',
            [
                'label' => esc_html__('Sorting Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['sorting' => 'yes'],
            ]
        );

        $this->add_control(
            'sorting_behavior',
            [
                'label' => esc_html__('Sorting Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'prefix_class' => 'sorting--behavior--',
                'default' => 'dropdown',
                'options' => [
                    'dropdown' => esc_html__('Dropdown', 'pe-core'),
                    'open' => esc_html__('Open', 'pe-core'),
                ],

            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            'grid_swither_styles',
            [
                'label' => esc_html__('Grid Switcher Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'grid_switcher' => 'on',
                ],
            ]
        );

        $this->add_control(
            'g_switcher_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'prefix_class' => 'grid--switcher--',
                'default' => 'switch',
                'options' => [
                    'switch' => esc_html__('Switch', 'pe-core'),
                    'simple' => esc_html__('Simple', 'pe-core'),
                ],

            ]
        );


        $this->add_responsive_control(
            'g_switcher_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pe--grid--switcher' => '--radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'g_switcher_has_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pe--grid--switcher>span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'control_styles',
            [
                'label' => esc_html__('Control Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'controls_typography',
                'selector' => '{{WRAPPER}} .products--controls--bordered .select-selected,{{WRAPPER}} .saren--products--layout--switcher, {{WRAPPER}} .saren--products--filter--cats label, {{WRAPPER}} .pe--product--filters .filters--button, {{WRAPPER}} .select-selected, {{WRAPPER}} .select-items , {{WRAPPER}} .pe--product--filters.filters--popup .filters--wrapper, {{WRAPPER}} .pe--product--filters .filters--wrapper.filters--sidebar',
            ]
        );

        $this->add_control(
            'has_underline',
            [
                'label' => esc_html__('Unerlined', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'products--controls--underlined',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'has_border',
            [
                'label' => esc_html__('Bordered', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'products--controls--bordered',
                'prefix_class' => '',
                'default' => 'products--controls--bordered',
            ]
        );

        $this->add_control(
            'has_rounded',
            [
                'label' => esc_html__('Rounded', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'products--controls--rounded',
                'prefix_class' => '',
                'default' => 'products--controls--rounded',
            ]
        );

        $this->add_control(
            'has_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'controls--has--bg',
                'prefix_class' => '',
                'default' => 'controls--has--bg',
            ]
        );

        $this->add_control(
            'has_bg_color',
            [
                'label' => esc_html__('Background Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--secondaryBackground: {{VALUE}}',
                ],

            ]
        );

        $this->add_responsive_control(
            'has_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .products--controls--bordered .select-selected,{{WRAPPER}} .saren--products--layout--switcher, {{WRAPPER}} .saren--products--filter--cats label, {{WRAPPER}} .pe--product--filters .filters--button, {{WRAPPER}} .select-selected, {{WRAPPER}} .select-items , {{WRAPPER}} .pe--product--filters.filters--popup .filters--wrapper, {{WRAPPER}} .pe--product--filters .filters--wrapper.filters--sidebar' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $this->add_control(
            'has_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .products--controls--bordered .select-selected,{{WRAPPER}} .saren--products--layout--switcher, {{WRAPPER}} .saren--products--filter--cats label, {{WRAPPER}} .pe--product--filters .filters--button,  {{WRAPPER}} .pe--product--filters .filters--wrapper.filters--sidebar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'controls_alignment',
            [
                'label' => esc_html__('Controls Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Start', 'pe-core'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                    'end' => [
                        'title' => esc_html__('End', 'pe-core'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Justify', 'pe-core'),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                ],
                'default' => 'space-between',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .saren--products--grid--controls' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'controls_spacing',
            [
                'label' => esc_html__('Controls Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--products--grid--controls' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'sorting_width',
            [
                'label' => esc_html__('Sorting Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .products--sorting' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'Style',
            [
                'label' => esc_html__('Grid Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'grid_borders',
                'label' => esc_html__('Borders', 'pe-core'),
                'selector' => '{{WRAPPER}} .saren--products-grid',
            ]
        );

        $this->add_responsive_control(
            'grid_columns_gap',
            [
                'label' => esc_html__('Columns Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 12,
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--products-grid' => 'grid-gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'products_archive_style' => 'grid',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_rows_gap',
            [
                'label' => esc_html__('Rows Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 12,
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--products-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'products_archive_style' => 'grid',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_align_items',
            [
                'label' => esc_html__('Align Items', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Start', 'pe-core'),
                        'icon' => 'eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-align-center-v',
                    ],
                    'end' => [
                        'title' => esc_html__('End', 'pe-core'),
                        'icon' => 'eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Stretch', 'pe-core'),
                        'icon' => 'eicon-align-stretch-v',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .saren--products-grid' => 'align-items: {{VALUE}};',
                ],
                'condition' => [
                    'products_archive_style' => 'grid',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_justify_items',
            [
                'label' => esc_html__('Justify Items', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Start', 'pe-core'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'end' => [
                        'title' => esc_html__('End', 'pe-core'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Stretch', 'pe-core'),
                        'icon' => 'eicon-align-stretch-h',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .saren--products-grid' => 'justify-items: {{VALUE}};',
                ],
                'condition' => [
                    'products_archive_style' => 'grid',
                ],
            ]
        );



        $this->add_responsive_control(
            'masonry_items_width',
            [
                'label' => esc_html__('Masonry Items Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'vh', 'em'],
                'range' => [
                    'px' => [
                        'min' => 1,
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .archive-products-section.archive--masonry' => '--masonryItemsWidth: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'products_archive_style' => 'masonry',
                ],
            ]
        );



        $this->add_responsive_control(
            'masonry_items_gutter',
            [
                'label' => esc_html__('Items Gutter', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 1,
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .archive-products-section.archive--masonry' => '--masonryGutter: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'products_archive_style' => 'masonry',
                ],
            ]
        );

        $this->end_controls_section();

        pe_button_style_settings($this, 'Load More Button', 'load_more_button', ['pagination_style' => 'ajax-load-more',]);

        pe_cursor_settings($this);
        pe_general_animation_settings($this);
        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings();

        $the_query = new \WP_Query(saren_product_query_args($this));
        $highlighted = [];

        if ($settings['highlight_products'] === 'yes') {

            if ($settings['highlight_by'] === 'product') {

                foreach ($settings['highlighted_products'] as $highlight) {
                    $highlighted[] = $highlight;
                }

            } else if ($settings['highlight_by'] === 'key') {

                $keys = explode(",", $settings['highlight_keys']);

                foreach ($keys as $highlitedKey) {
                    $highlighted[] = $highlitedKey;
                }
            }

        }

        $cursor = pe_cursor($this);
        $pop = '';


        if ($settings['filters_style'] === 'accordion') {
            $accordionPath = plugin_dir_url(__FILE__) . '../assets/img/chevron_down.svg';
            $accordionIcon = file_get_contents($accordionPath);
        } else {
            $accordionIcon = '';
        }

        $isWishlist = '';

        if (isset($settings['is_wishlist']) && $settings['is_wishlist'] === 'yes' && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {

            $isWishlist = 'pe--wishlist is--wishlist--archive';

            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                $wishlist = get_user_meta($user_id, 'pe_wishlist', true);
                $wishlist = is_array($wishlist) ? $wishlist : [];
            } else {
                $wishlist = isset($_COOKIE['pe_wishlist']) ? json_decode(stripslashes($_COOKIE['pe_wishlist']), true) : [];
                $wishlist = is_array($wishlist) ? $wishlist : [];
            }

            if (empty($wishlist)) {
                echo '<div class="pe--wishlist pe--wishlist--cont">
                <div class="wishlist--empty">
                <h5>' . esc_html($settings['wishlist_empty_title']) . '</h5>
                <p>' . esc_html($settings['wishlist_empty_sub']) . '</p>
                </div> </div>';
            }

        }

        $data_args = htmlspecialchars(json_encode(saren_product_query_args($this)), ENT_QUOTES, 'UTF-8');

        ?>

        <div data-query-args="<?php echo $data_args ?>"
            class="archive-products-section anim-multiple <?php echo 'pag_' . $settings['pagination_style'] . ' archive--' . $settings['products_archive_style'] . ' ' . $isWishlist ?>"
            data-max-pages="<?php echo esc_attr($the_query->max_num_pages) ?>"
            data-found="<?php echo esc_attr($the_query->found_posts) ?>" <?php echo pe_general_animation($this) ?>>

            <svg style="display: none;">
                <defs>
                    <symbol id="cart-loading" viewBox="0 -960 960 960">
                        <path
                            d="M480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880q17 0 28.5 11.5T520-840q0 17-11.5 28.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-17 11.5-28.5T840-520q17 0 28.5 11.5T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80Z" />
                    </symbol>
                    <symbol id="cart-done" viewBox="0 -960 960 960">
                        <path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z" />
                    </symbol>
                </defs>
            </svg>

            <div class="saren--products--grid--controls inner--anim">


                <?php if ($settings['additional_filters'] === 'yes' && $settings['filters_behavior'] === 'dropdown') { ?>
                    <div class="filters--button pe--pop--button">
                        <?php echo esc_html($settings['filters_button_text']) ?>

                        <?php if (!empty($settings['filters_button_custom_icon']['value'])) {
                            ob_start();

                            \Elementor\Icons_Manager::render_icon($settings['filters_button_custom_icon'], ['aria-hidden' => 'true']);

                            $icon = ob_get_clean();

                            echo $icon;
                        } else { ?>

                            <svg class="filters--default--icon" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960"
                                width="1em" fill="var(--mainColor)">
                                <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                            </svg>

                        <?php } ?>

                    </div>
                <?php } ?>

                <?php if ($settings['additional_filters'] === 'yes' && $settings['filters_behavior'] === 'popup') { ?>

                    <div class="saren--product--filters">

                        <div class="pe--product--filters <?php echo 'filters--' . $settings['filters_behavior'] ?>">

                            <?php if ($settings['filters_behavior'] !== 'always-show') {
                                $pop = 'pe--styled--popup';
                                ?>

                                <div class="filters--button pe--pop--button">
                                    <?php echo esc_html($settings['filters_button_text']) ?>

                                    <?php if (!empty($settings['filters_button_custom_icon']['value'])) {
                                        ob_start();

                                        \Elementor\Icons_Manager::render_icon($settings['filters_button_custom_icon'], ['aria-hidden' => 'true']);

                                        $icon = ob_get_clean();

                                        echo $icon;
                                    } else { ?>

                                        <svg class="filters--default--icon" xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 -960 960 960" width="1em" fill="var(--mainColor)">
                                            <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                                        </svg>

                                    <?php } ?>

                                </div>
                            <?php } ?>

                            <?php if ($settings['back_overlay'] === 'true') { ?>
                                <span class="pop--overlay"></span>
                            <?php } ?>


                            <div class="filters--wrapper <?php echo esc_attr($pop) ?>">

                                <div data-lenis-prevent class="filters--wrapper--inner">

                                    <span class="pop--close">
                                        <?php echo file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/close.svg'); ?>
                                    </span>

                                    <?php
                                    if ($settings['sorting'] === 'yes' && $settings['sorting_position'] === 'with-filters') { ?>

                                        <div class="filters--item filters--sorting">

                                            <?php if (!empty($settings['sorting_label'])) {
                                                echo '<div class="filter--label">' . $settings['sorting_label'] . '</div>';
                                            } ?>

                                            <div class="products--sorting">
                                                <?php saren_render_sorting_dropdown(); ?>
                                            </div>
                                        </div>
                                    <?php }

                                    if (!empty($settings['filters_repeater'])) {

                                        foreach ($settings['filters_repeater'] as $filterItem) {

                                            $filter = $filterItem['filter_by'];
                                            $inputStyle = $filterItem['input_style'];

                                            ?>

                                            <div
                                                class="filters--item <?php echo 'filters_' . $filter . ' elementor-repeater-item-' . $filterItem['_id'] ?>">

                                                <?php if (!empty($filterItem['filter_label']) && $filter !== 'on-sale') {

                                                    echo '<div class="filter--label">' . $filterItem['filter_label'] . $accordionIcon . '</div>';

                                                } ?>

                                                <?php
                                                if ($filter === 'on-sale') { ?>

                                                    <label for="sale_products" class="classic--checkbox">
                                                        <input class="check--sale" type="checkbox" name="sale_products" id="sale_products"
                                                            value="1" />
                                                        <?php if (!empty($filterItem['filter_label'])) {

                                                            echo '<div class="filter--label">' . $filterItem['filter_label'] . '</div>';

                                                        } else {
                                                            _e('On sale products', 'saren');
                                                        } ?>
                                                    </label>

                                                <?php } else if ($filter === 'attributes') {

                                                    $selection = $filterItem['select_attribute'];

                                                    if (!empty($selection)) {

                                                        foreach ($selection as $item) {

                                                            $attribute = wc_get_attribute($item);
                                                            $taxonomy = esc_attr($attribute->slug);

                                                            $terms = get_terms(array(
                                                                'taxonomy' => $taxonomy,
                                                                'hide_empty' => false,
                                                            ));

                                                            if (!empty($terms) && !is_wp_error($terms)) {
                                                                if ($filter === 'attributes') {
                                                                    echo '<div class="terms-list">';
                                                                    echo '<div class="terms-list-title">';
                                                                    echo '<p>' . $attribute->name . '</p>';
                                                                    echo $accordionIcon;
                                                                    echo '</div><div class="terms--terms">';

                                                                    foreach ($terms as $term) {
                                                                        $count ='';
                                                                        if ($filterItem['show_count'] === 'yes') {
                                                                            $count = '<span class="filter--count">( ' . $term->count . ' )</span>';
                                                                        }

                                                                        if (get_field('term_color', $term)) {
                                                                            $color = '<span class="filter-term-color" style="background-color: ' . get_field('term_color', $term) . '"></span>';
                                                                        } else {
                                                                            $color = '';
                                                                        }

                                                                        echo '<label class="term--list--item ' . $inputStyle . '">'
                                                                            . $color .
                                                                            '<input class="" type="checkbox" name="' . $attribute->slug . '" value="' . esc_html($term->slug) . '" /><span class="term--name">' . esc_html($term->name) . $count . '</span>
                                                                    </label>';
                                                                    }
                                                                    echo '</div></div>';
                                                                }
                                                            } else {
                                                                echo '<p>No terms found for this attribute.</p>';
                                                            }

                                                        }
                                                    }



                                                } else if ($filter === 'tag' || $filter === 'brands' || $filter === 'categories') {

                                                    if ($filter === 'tag') {
                                                        $selection = $filterItem['select_tags'];
                                                        $tax = 'product_tag';
                                                    } else if ($filter === 'brands') {
                                                        $selection = $filterItem['select_brands'];
                                                        $tax = 'brand';
                                                    } else if ($filter === 'categories') {
                                                        $selection = $filterItem['select_side_cats'];
                                                        $tax = 'product_cat';
                                                    }

                                                    $taxonomy = get_terms(array(
                                                        'taxonomy' => $tax,
                                                        'hide_empty' => false,
                                                        'include' => $selection,
                                                    ));

                                                    if (!empty($taxonomy) && !is_wp_error($taxonomy)) {

                                                        echo '<div class="terms-list">';
                                                        foreach ($taxonomy as $term) {

                                                            $count ='';
                                                            if ($filterItem['show_count'] === 'yes') {
                                                                $count = '<span class="filter--count">( ' . $term->count . ' )</span>';
                                                            }

                                                            echo '<label class="term--list--item ' . $inputStyle . '">' .
                                                                '<input class="" type="checkbox" name="' . esc_html($tax) . '" value="' . esc_html($term->term_id) . '" />' . esc_html($term->name) . $count .'
                                                                </label>';
                                                        }

                                                        echo '</div>';
                                                    }

                                                } else if ($filter === 'price') { ?>

                                                                <div class="filter-price-range">

                                                                    <input type="number" id="min_price" name="min_price"
                                                                        value="<?php echo $filterItem['min_price'] ?>" />
                                                                    <input type="number" id="max_price" name="max_price"
                                                                        value="<?php echo $filterItem['max_price'] ?>" />

                                                                    <div class="filter--range--labels">

                                                                        <span class="label--price--min"><?php echo esc_html('MIN: ') ?>
                                                                <?php echo get_woocommerce_currency_symbol() ?><span><?php echo $filterItem['min_price'] ?></span></span>
                                                                        <span class="label--price--max"><?php echo esc_html('MAX: ') ?>
                                                                <?php echo get_woocommerce_currency_symbol() ?><span><?php echo $filterItem['max_price'] ?></span></span>

                                                                    </div>

                                                                    <div class="range-slider">
                                                                        <input type="range" id="range_min" min="<?php echo $filterItem['min_price'] ?>"
                                                                            max="<?php echo $filterItem['max_price'] ?>"
                                                                            value="<?php echo $filterItem['min_price'] ?>" step="1">
                                                                        <input type="range" id="range_max" min="<?php echo $filterItem['min_price'] ?>"
                                                                            max="<?php echo $filterItem['max_price'] ?>"
                                                                            value="<?php echo $filterItem['max_price'] ?>" step="1">
                                                                    </div>
                                                                </div>

                                                <?php } ?>
                                            </div>

                                        <?php }
                                    } ?>

                                </div>
                            </div>

                        </div>

                    </div>

                <?php } ?>

                <?php if ($settings['filter_cats'] === 'yes') { ?>
                    <div class="saren--products--filter--cats pe--product--filters">
                        <?php
                        $filterCats = $settings['cats_for_filters'];
                        if (!empty($filterCats)) { ?>
                            <?php

                            if ($settings['filter_cats_style'] === 'label') {
                                echo '<label class="term--list--item">
                        <input checked type="checkbox" name="product_cat" value="all" />' . $settings['filters_all_text'] . '
                                </label>';
                            }

                            if ($settings['filter_cats_style'] === 'image') {

                                echo '<div class="filter--cats--images--wrapper">';
                            }

                            foreach ($filterCats as $key => $cat) {

                                $cato = get_term_by('id', $cat, 'product_cat');

                                if ($cato) {

                                    $count ='';
                                    if ($settings['cats_show_count'] === 'yes') {
                                        $count = '<span class="filter--count">( ' . $cato->count . ' )</span>';
                                    }

                                    if ($settings['filter_cats_style'] === 'image') {

                                        echo '<label class="term--list--item">';

                                        $thumbnail_id = get_term_meta($cato->term_id, 'thumbnail_id', true);
                                        $image_url = wp_get_attachment_url($thumbnail_id);

                                        if ($image_url) {
                                            echo '<div class="archive--cat--image"><img src="' . esc_url($image_url) . '" alt="' . esc_attr($cato->name) . '" /></div>';
                                        }

                                        echo '<div class="archive--cats--dets">';

                                        echo '<input type="checkbox" name="product_cat" value="' . $cat . '" /><p data-count="' . $cato->count . '">' . $cato->name . '</p>';

                                        if ($settings['filter_cats_desc']) {
                                            echo '<p>' . esc_html($cato->description) . '</p>';
                                        }

                                        echo '</div></label>';

                                    } else {

                                        echo '<label class="term--list--item">
                                        <input type="checkbox" name="product_cat" value="' . $cat . '" />' . $cato->name . $count . '
                                                </label>';

                                    }


                                }
                            }

                            if ($settings['filter_cats_style'] === 'image') {

                                echo '</div>';
                            }

                        }
                        ?>

                    </div>

                <?php } ?>

                <?php if ($settings['grid_switcher'] === 'on') {

                    ?>

                    <div class="pe--grid--switcher products--grid--switcher">
                        <?php

                        if ($settings['g_switcher_style'] === 'switch') {
                            ?>
                            <span class="switch--follower"></span>

                        <?php } ?>

                        <?php foreach ($settings['grid_switch_columns'] as $key => $col) {

                            if ($col == $settings['grid_columns']['size']) {
                                $act = 'switch--active';
                            } else {
                                $act = '';
                            }

                            $svgPath = plugin_dir_path(__FILE__) . '../assets/img/grid-col-' . $col . '.svg';
                            $icon = file_get_contents($svgPath);

                            echo '<span data-switch-cols="' . $col . '" class="switch--item ' . $col . '--col ' . $act . '">' . $icon . '</span>';

                        } ?>

                    </div>
                <?php } ?>

                <?php if ($settings['sorting'] === 'yes' && $settings['sorting_position'] === 'default') { ?>

                    <div class="products--sorting">
                        <?php saren_render_sorting_dropdown(); ?>
                    </div>
                <?php } ?>

            </div>

            <?php if ($settings['additional_filters'] === 'yes' && $settings['filters_behavior'] === 'sidebar') { ?>
                <div class="pe--product--filters pe--filters--sidebar">
                    <div class="filters--wrapper filters--sidebar">
                        <?php
                        if (!empty($settings['filters_repeater'])) {

                            foreach ($settings['filters_repeater'] as $filterItem) {

                                $filter = $filterItem['filter_by'];
                                $inputStyle = $filterItem['input_style'];

                                ?>

                                <div
                                    class="filters--item <?php echo 'filters_' . $filter . ' elementor-repeater-item-' . $filterItem['_id'] ?>">

                                    <?php if (!empty($filterItem['filter_label']) && $filter !== 'on-sale') {

                                        echo '<div class="filter--label">' . $filterItem['filter_label'] . $accordionIcon . '</div>';

                                    } ?>

                                    <?php
                                    if ($filter === 'on-sale') { ?>

                                        <label for="sale_products" class="classic--checkbox">
                                            <input class="check--sale" type="checkbox" name="sale_products" id="sale_products" value="1" />
                                            <?php if (!empty($filterItem['filter_label'])) {

                                                echo '<div class="filter--label">' . $filterItem['filter_label'] . '</div>';

                                            } else {
                                                _e('On sale products', 'saren');
                                            } ?>
                                        </label>

                                    <?php } else if ($filter === 'attributes') {

                                        $selection = $filterItem['select_attribute'];

                                        if (!empty($selection)) {

                                            foreach ($selection as $item) {

                                                $attribute = wc_get_attribute($item);

                                                $taxonomy = esc_attr($attribute->slug);

                                                $terms = get_terms(array(
                                                    'taxonomy' => $taxonomy,
                                                    'hide_empty' => false,
                                                ));

                                                if (!empty($terms) && !is_wp_error($terms)) {
                                                    if ($filter === 'attributes') {
                                                        echo '<div class="terms-list">';
                                                        echo '<div class="terms-list-title">';
                                                        echo '<p>' . $attribute->name . '</p>';
                                                        echo $accordionIcon;
                                                        echo '</div><div class="terms--terms">';
                                                        foreach ($terms as $term) {
                                                            if (get_field('term_color', $term)) {
                                                                $color = '<span class="filter-term-color" style="background-color: ' . get_field('term_color', $term) . '"></span>';
                                                            } else {
                                                                $color = '';
                                                            }

                                                            echo '<label class="term--list--item ' . $inputStyle . '">'
                                                                . $color .
                                                                '<input class="" type="checkbox" name="' . $attribute->slug . '" value="' . esc_html($term->slug) . '" />' . esc_html($term->name) . '
                                    </label>';
                                                        }
                                                        echo '</div></div>';
                                                    }
                                                } else {
                                                    echo '<p>No terms found for this attribute.</p>';
                                                }

                                            }
                                        }



                                    } else if ($filter === 'tag' || $filter === 'brands' || $filter === 'categories') {

                                        if ($filter === 'tag') {
                                            $selection = $filterItem['select_tags'];
                                            $tax = 'product_tag';
                                        } else if ($filter === 'brands') {
                                            $selection = $filterItem['select_brands'];
                                            $tax = 'brand';
                                        } else if ($filter === 'categories') {
                                            $selection = $filterItem['select_side_cats'];
                                            $tax = 'product_cat';
                                        }

                                        $taxonomy = get_terms(array(
                                            'taxonomy' => $tax,
                                            'hide_empty' => false,
                                            'include' => $selection,
                                        ));

                                        if (!empty($taxonomy) && !is_wp_error($taxonomy)) {

                                            echo '<div class="terms-list">';
                                            foreach ($taxonomy as $term) {

                                                echo '<label class="term--list--item ' . $inputStyle . '">' .
                                                    '<input class="" type="checkbox" name="' . esc_html($tax) . '" value="' . esc_html($term->term_id) . '" />' . esc_html($term->name) . '
                                </label>';
                                            }

                                            echo '</div>';
                                        }

                                    } else if ($filter === 'price') { ?>

                                                    <div class="filter-price-range">

                                                        <input type="number" id="min_price" name="min_price"
                                                            value="<?php echo $filterItem['min_price'] ?>" />
                                                        <input type="number" id="max_price" name="max_price"
                                                            value="<?php echo $filterItem['max_price'] ?>" />

                                                        <div class="filter--range--labels">

                                                            <span class="label--price--min"><?php echo esc_html('MIN: ') ?>
                                                    <?php echo get_woocommerce_currency_symbol() ?><span><?php echo $filterItem['min_price'] ?></span></span>
                                                            <span class="label--price--max"><?php echo esc_html('MAX: ') ?>
                                                    <?php echo get_woocommerce_currency_symbol() ?><span><?php echo $filterItem['max_price'] ?></span></span>

                                                        </div>

                                                        <div class="range-slider">
                                                            <input type="range" id="range_min" min="<?php echo $filterItem['min_price'] ?>"
                                                                max="<?php echo $filterItem['max_price'] ?>" value="<?php echo $filterItem['min_price'] ?>"
                                                                step="1">
                                                            <input type="range" id="range_max" min="<?php echo $filterItem['min_price'] ?>"
                                                                max="<?php echo $filterItem['max_price'] ?>" value="<?php echo $filterItem['max_price'] ?>"
                                                                step="1">
                                                        </div>
                                                    </div>

                                    <?php } ?>
                                </div>

                            <?php }
                        } ?>

                    </div>
                </div>
            <?php } ?>

            <?php if ($settings['additional_filters'] === 'yes' && $settings['filters_behavior'] === 'dropdown') { ?>
                <div class="pe--product--filters filters--dropdown">
                    <div class="filters--wrapper filters--dropdown">

                        <div data-lenis-prevent class="filters--wrapper--inner">

                            <span class="pop--close">
                                <?php echo file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/close.svg'); ?>
                            </span>

                            <?php
                            if ($settings['sorting'] === 'yes' && $settings['sorting_position'] === 'with-filters') { ?>

                                <div class="filters--item filters--sorting">

                                    <?php if (!empty($settings['sorting_label'])) {
                                        echo '<div class="filter--label">' . $settings['sorting_label'] . '</div>';
                                    } ?>

                                    <div class="products--sorting">
                                        <?php saren_render_sorting_dropdown(); ?>
                                    </div>
                                </div>
                            <?php }

                            if (!empty($settings['filters_repeater'])) {

                                foreach ($settings['filters_repeater'] as $filterItem) {

                                    $filter = $filterItem['filter_by'];
                                    $inputStyle = $filterItem['input_style'];

                                    ?>

                                    <div
                                        class="filters--item <?php echo 'filters_' . $filter . ' elementor-repeater-item-' . $filterItem['_id'] ?>">

                                        <?php if (!empty($filterItem['filter_label']) && $filter !== 'on-sale') {

                                            echo '<div class="filter--label">' . $filterItem['filter_label'] . $accordionIcon . '</div>';

                                        } ?>

                                        <?php
                                        if ($filter === 'on-sale') { ?>

                                            <label for="sale_products" class="classic--checkbox">
                                                <input class="check--sale" type="checkbox" name="sale_products" id="sale_products" value="1" />
                                                <?php if (!empty($filterItem['filter_label'])) {

                                                    echo '<div class="filter--label">' . $filterItem['filter_label'] . '</div>';

                                                } else {
                                                    _e('On sale products', 'saren');
                                                } ?>
                                            </label>

                                        <?php } else if ($filter === 'attributes') {

                                            $selection = $filterItem['select_attribute'];

                                            if (!empty($selection)) {

                                                foreach ($selection as $item) {

                                                    $attribute = wc_get_attribute($item);
                                                    $taxonomy = esc_attr($attribute->slug);

                                                    $terms = get_terms(array(
                                                        'taxonomy' => $taxonomy,
                                                        'hide_empty' => false,
                                                    ));

                                                    if (!empty($terms) && !is_wp_error($terms)) {
                                                        if ($filter === 'attributes') {
                                                            echo '<div class="terms-list">';
                                                            echo '<div class="terms-list-title">';
                                                            echo '<p>' . $attribute->name . '</p>';
                                                            echo $accordionIcon;
                                                            echo '</div><div class="terms--terms">';

                                                            foreach ($terms as $term) {
                                                                if (get_field('term_color', $term)) {
                                                                    $color = '<span class="filter-term-color" style="background-color: ' . get_field('term_color', $term) . '"></span>';
                                                                } else {
                                                                    $color = '';
                                                                }

                                                                echo '<label class="term--list--item ' . $inputStyle . '">'
                                                                    . $color .
                                                                    '<input class="" type="checkbox" name="' . $attribute->slug . '" value="' . esc_html($term->slug) . '" /><span class="term--name">' . esc_html($term->name) . '</span>
                                    </label>';
                                                            }
                                                            echo '</div></div>';
                                                        }
                                                    } else {
                                                        echo '<p>No terms found for this attribute.</p>';
                                                    }

                                                }
                                            }



                                        } else if ($filter === 'tag' || $filter === 'brands' || $filter === 'categories') {

                                            if ($filter === 'tag') {
                                                $selection = $filterItem['select_tags'];
                                                $tax = 'product_tag';
                                            } else if ($filter === 'brands') {
                                                $selection = $filterItem['select_brands'];
                                                $tax = 'brand';
                                            } else if ($filter === 'categories') {
                                                $selection = $filterItem['select_side_cats'];
                                                $tax = 'product_cat';
                                            }

                                            $taxonomy = get_terms(array(
                                                'taxonomy' => $tax,
                                                'hide_empty' => false,
                                                'include' => $selection,
                                            ));

                                            if (!empty($taxonomy) && !is_wp_error($taxonomy)) {

                                                echo '<div class="terms-list">';
                                                foreach ($taxonomy as $term) {

                                                    echo '<label class="term--list--item ' . $inputStyle . '">' .
                                                        '<input class="" type="checkbox" name="' . esc_html($tax) . '" value="' . esc_html($term->term_id) . '" />' . esc_html($term->name) . '
                                </label>';
                                                }

                                                echo '</div>';
                                            }

                                        } else if ($filter === 'price') { ?>

                                                        <div class="filter-price-range">

                                                            <input type="number" id="min_price" name="min_price"
                                                                value="<?php echo $filterItem['min_price'] ?>" />
                                                            <input type="number" id="max_price" name="max_price"
                                                                value="<?php echo $filterItem['max_price'] ?>" />

                                                            <div class="filter--range--labels">

                                                                <span class="label--price--min"><?php echo esc_html('MIN: ') ?>
                                                        <?php echo get_woocommerce_currency_symbol() ?><span><?php echo $filterItem['min_price'] ?></span></span>
                                                                <span class="label--price--max"><?php echo esc_html('MAX: ') ?>
                                                        <?php echo get_woocommerce_currency_symbol() ?><span><?php echo $filterItem['max_price'] ?></span></span>

                                                            </div>

                                                            <div class="range-slider">
                                                                <input type="range" id="range_min" min="<?php echo $filterItem['min_price'] ?>"
                                                                    max="<?php echo $filterItem['max_price'] ?>"
                                                                    value="<?php echo $filterItem['min_price'] ?>" step="1">
                                                                <input type="range" id="range_max" min="<?php echo $filterItem['min_price'] ?>"
                                                                    max="<?php echo $filterItem['max_price'] ?>"
                                                                    value="<?php echo $filterItem['max_price'] ?>" step="1">
                                                            </div>
                                                        </div>

                                        <?php } ?>
                                    </div>

                                <?php }
                            } ?>

                        </div>
                    </div>
                </div>
            <?php } ?>

            <div
                class="saren--products-grid <?php echo $settings['products_archive_style'] === 'masonry' ? 'saren--masonry--layout' : ''; ?>">

                <?php

                $masonryItem = '';
                if ($settings['products_archive_style'] === 'masonry') {
                    echo '<span class="saren--products--masonry--sizer"></span>';
                    echo '<span class="saren--products--masonry--gutter"></span>';
                    $masonryItem = 'product--masonry--item';
                };

                $index = 0;
                while ($the_query->have_posts()):
                    $the_query->the_post();
                    $index++;

                    $isHighlighted = in_array(get_the_ID(), $highlighted) || in_array($index, $highlighted) ? 'product--highlighted' : '';
                    $classes = 'saren--single--product inner--anim carousel--item ' . $settings['product_style'] . ' ' . $masonryItem . ' ' . $isHighlighted . ' sp--archive--' . $settings['products_archive_style'];

                    if ($settings['product_style'] === 'detailed') {
                        sarenProductBox($settings, wc_get_product(), $classes, pe_cursor($this));
                    } else if ($settings['products_archive_style'] === 'list') {
                        sarenProductListRender($settings, wc_get_product(), $classes, $cursor);
                    } else {
                        sarenProductRender($settings, wc_get_product(), $classes, $cursor);
                    }

                endwhile;
                wp_reset_query();

                ?>

            </div>

            <?php if ($settings['pagination_style'] === 'ajax-load-more') { ?>

                <div class="saren--products--load--more saren--products--pagination">

                    <?php pe_button_render($this); ?>

                </div>
            <?php } else if ($settings['pagination_style'] === 'infinite-scroll') { ?>

                    <div class="saren--products--infinite--scroll saren--products--pagination">

                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960" width="1em"
                            fill="var(--mainColor)">
                            <path
                                d="M479.76-136q-70.79 0-133.45-27.04-62.66-27.04-109.45-73.82-46.78-46.79-73.82-109.45Q136-408.97 136-479.76q0-71.64 27.14-134.23 27.14-62.58 73.65-109.13 46.51-46.55 109.39-73.72Q409.06-824 479.69-824q7.81 0 12.06 4.26 4.25 4.26 4.25 11.28t-4.25 11.74Q487.5-792 480-792q-129.67 0-220.84 90.5Q168-611 168-480.5T259.16-259q91.17 91 220.84 91 131 0 221.5-91.16Q792-350.33 792-480q0-7.54 4.75-11.77 4.75-4.23 11.77-4.23t11.25 4.25q4.23 4.25 4.23 12.06 0 70.63-27.16 133.51-27.17 62.88-73.72 109.39t-109.13 73.65Q551.4-136 479.76-136Z" />
                        </svg>


                    </div>

            <?php } ?>


        </div>
    <?php }

}
