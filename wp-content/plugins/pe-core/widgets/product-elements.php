<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peProductElements extends Widget_Base
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
        return 'peproductelements';
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
        return __('Product Elements', 'pe-core');
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
        return 'eicon-product-meta pe-widget';
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


        // Tab Title Control
        $this->start_controls_section(
            'section_tab_title',
            [
                'label' => __('Product Elements', 'pe-core'),
            ]
        );

        $this->add_control(
            'field_type',
            [
                'label' => esc_html__('Field Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'title',
                'options' => [
                    'title' => esc_html__('Title', 'pe-core'),
                    'price' => esc_html__('Price', 'pe-core'),
                    'attributes' => esc_html__('Attributes', 'pe-core'),
                    'description' => esc_html__('Description', 'pe-core'),
                    'short-description' => esc_html__('Short Description', 'pe-core'),
                    'add-to-cart' => esc_html__('Add To Cart Form', 'pe-core'),
                    'rating' => esc_html__('Rating', 'pe-core'),
                    'sku' => esc_html__('SKU', 'pe-core'),
                    'stock' => esc_html__('Stock', 'pe-core'),
                    'categories' => esc_html__('Categories', 'pe-core'),
                    'brands' => esc_html__('Brands', 'pe-core'),
                    'tags' => esc_html__('Tags', 'pe-core'),
                    'data-tabs' => esc_html__('Details', 'pe-core'),
                    'add-wishlist' => esc_html__('Add To Wishlist (YITH)', 'pe-core'),
                    'add-wishlist-saren' => esc_html__('Add To Wishlist (Built-in)', 'pe-core'),
                    'add-compare' => esc_html__('Add To Compare', 'pe-core'),
                    'add-compare-saren' => esc_html__('Add To Compare (Built-in)', 'pe-core'),
                    'fbt' => esc_html__('Frequently Bought Together', 'pe-core'),
                    'additional-info' => esc_html__('Additonal Information', 'pe-core'),
                    'custom-tabs' => esc_html__('Custom Tab Content', 'pe-core'),
                    'countdown-sale' => esc_html__('Sale Countdown', 'pe-core'),

                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'wishlist_use_custom_icon',
            [
                'label' => esc_html__('Use Custom Icons', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'field_type' => ['add-wishlist-saren'],
                ],
            ]
        );

        $this->add_control(
            'wishlist_add_icon',
            [
                'label' => esc_html__('Add Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'material-icons md-arrow_outward',
                    'library' => 'material-design-icons',
                ],
                'condition' => [
                    'field_type' => ['add-wishlist-saren'],
                    'wishlist_use_custom_icon' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'wishlist_added_icon',
            [
                'label' => esc_html__('Added Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'material-icons md-arrow_outward',
                    'library' => 'material-design-icons',
                ],
                'condition' => [
                    'field_type' => ['add-wishlist-saren'],
                    'wishlist_use_custom_icon' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'wishlist_show_caption',
            [
                'label' => esc_html__('Show caption', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'field_type' => ['add-wishlist-saren'],

                ],
            ]
        );


        $this->add_control(
            'wishlist_add_caption',
            [
                'label' => esc_html__('Add Caption', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Add to wishlist.', 'pe-core'),
                'ai' => false,
                'condition' => [
                    'field_type' => ['add-wishlist-saren'],
                    'wishlist_show_caption' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'wishlist_added_caption',
            [
                'label' => esc_html__('Added Caption', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Remove from wishlist.', 'pe-core'),
                'ai' => false,
                'condition' => [
                    'field_type' => ['add-wishlist-saren'],
                    'wishlist_show_caption' => ['yes'],
                ],
            ]
        );


        $this->add_control(
            'compare_use_custom_icon',
            [
                'label' => esc_html__('Use Custom Icons', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'field_type' => ['add-compare-saren'],
                ],
            ]
        );

        $this->add_control(
            'compare_add_icon',
            [
                'label' => esc_html__('Add Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'material-icons md-arrow_outward',
                    'library' => 'material-design-icons',
                ],
                'condition' => [
                    'field_type' => ['add-compare-saren'],
                ],
            ]
        );

        $this->add_control(
            'compare_added_icon',
            [
                'label' => esc_html__('Added Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'material-icons md-arrow_outward',
                    'library' => 'material-design-icons',
                ],
                'condition' => [
                    'field_type' => ['add-compare-saren'],
                    'compare_use_custom_icon' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'compare_show_caption',
            [
                'label' => esc_html__('Show caption', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'field_type' => ['add-compare-saren'],
                ],
            ]
        );


        $this->add_control(
            'compare_add_caption',
            [
                'label' => esc_html__('Add Caption', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Add to compare.', 'pe-core'),
                'ai' => false,
                'condition' => [
                    'field_type' => ['add-compare-saren'],
                    'compare_show_caption' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'compare_added_caption',
            [
                'label' => esc_html__('Added Caption', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Remove from compare.', 'pe-core'),
                'ai' => false,
                'condition' => [
                    'field_type' => ['add-compare-saren'],
                    'compare_show_caption' => ['yes'],
                ],
            ]
        );


        $this->add_control(
            'countdown_text',
            [
                'label' => esc_html__('Countdown Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'field_type' => ['countdown-sale'],
                ],
            ]
        );

        $this->add_control(
            'fbt_text',
            [
                'label' => esc_html__('Frequently Bought Togerher Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'field_type' => ['fbt'],
                ],
            ]
        );

        $customTabsSelect = [];
        $excludeTabsSelect = [];

        $tabs = get_posts([
            'post_type' => 'woo_product_tab',
            'numberposts' => -1
        ]);

        foreach ($tabs as $tab) {
            $customTabsSelect[$tab->ID] = $tab->post_title;
            $excludeTabsSelect[$tab->post_name] = $tab->post_title;
        }

        $this->add_control(
            'select_tab_to_display',
            [
                'label' => __('Select Tab', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $customTabsSelect,
                'condition' => [
                    'field_type' => ['custom-tabs'],
                ],
            ]
        );



        $this->add_control(
            'exclude_tabs',
            [
                'label' => esc_html__('Exclude Tabs', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => $excludeTabsSelect,
                'condition' => [
                    'field_type' => ['data-tabs'],
                ],
            ]
        );

        $this->add_control(
            'field_style',
            [
                'label' => esc_html__('Field Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal' => esc_html__('Normal', 'pe-core'),
                    'popup' => esc_html__('Popup', 'pe-core'),
                ],
                'label_block' => true,
                'condition' => [
                    'field_type' => ['description', 'short-description', 'data-tabs', 'custom-tabs', 'additional-info'],
                ],
            ]
        );

        $this->add_control(
            'popup_title',
            [
                'label' => esc_html__('Popup Title', 'pe-core'),
                'default' => esc_html__('Description', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'field_type' => ['description', 'short-description', 'data-tabs', 'additional-info'],
                    'field_style' => 'popup'
                ],
            ]
        );

        popupOptions($this, ['field_style' => 'popup']);

        $this->add_control(
            'template_popup_style',
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
            ]
        );

        $this->add_control(
            'template_popup_text',
            [
                'label' => esc_html__('Button Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => false,
                'placeholder' => esc_html__('Write text here', 'pe-core'),
                'default' => esc_html__('Poppu', 'pe-core'),
                'ai' => false,
                'condition' => ['template_popup_style' => ['text', 'icon_text']],
            ]
        );

        $this->add_control(
            'template_popup_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'template_popup_style' => ['icon', 'icon_text']
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
                    '{{WRAPPER}} .pe--pop--button' => '--iconSize: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'template_popup_style' => ['icon', 'icon_text']
                ],
            ]
        );


        $displayAttributes = array();

        $attributes1 = wc_get_attribute_taxonomies();

        foreach ($attributes1 as $key => $attribute) {
            $displayAttributes[$attribute->attribute_id] = $attribute->attribute_label;
        }

        $this->add_control(
            'attributes_to_display',
            [
                'label' => __('Attributes to display.', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $displayAttributes,
                'condition' => ['field_type' => 'attributes']
            ]
        );

        $this->add_control(
            'datas-style',
            [
                'label' => esc_html__('Details Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'tabs',
                'options' => [
                    'tabs' => esc_html__('Tabs', 'pe-core'),
                    'accordion' => esc_html__('Accordion', 'pe-core'),
                ],
                'label_block' => false,
                'prefix_class' => 'data--style--',
                'condition' => ['field_type' => 'data-tabs'],
            ]
        );

        $this->add_control(
            'accordion_active_first',
            [
                'label' => esc_html__('First Item Active?', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'accordion--first--active',
                'prefix_class' => '',
                'render_type' => 'template',
                'default' => '',
                'condition' => [
   
                    'datas-style' => 'accordion'
                ],
            ]
        );

        $this->add_control(
            'add-to-cart-behavior',
            [
                'label' => esc_html__('Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal' => esc_html__('Normal', 'pe-core'),
                    'configurator' => esc_html__('Configurator', 'pe-core'),
                ],
                'prefix_class' => 'add--',
                'label_block' => false,
                'condition' => ['field_type' => 'add-to-cart'],
            ]
        );

        $this->add_control(
            'add_to_cart_sticky',
            [
                'label' => esc_html__('Sticky Add To Cart', 'pe-core'),
                'description' => esc_html__('Scroll down to page for displaying sticky add to cart section.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'sticky--atc--active',
                'prefix_class' => '',
                'render_type' => 'template',
                'default' => '',
                'condition' => ['field_type' => 'add-to-cart'],
            ]
        );

        $this->add_control(
            'add_to_cart_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'pe-core'),
                    'rounded' => esc_html__('Rounded', 'pe-core'),
                    'sharp' => esc_html__('Sharp', 'pe-core'),
                ],
                'label_block' => false,
                'prefix_class' => 'atc--style--',
                'condition' => [
                    'add-to-cart-behavior' => 'normal',
                    'field_type' => 'add-to-cart'
                ],
            ]
        );

        $this->add_control(
            'add_to_cart_order',
            [
                'label' => esc_html__('Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical' => esc_html__('Vertical', 'pe-core'),
                    'horizontal' => esc_html__('Horizontal', 'pe-core'),
                ],
                'label_block' => false,
                'prefix_class' => 'atc--order--',
                'condition' => [
                    'add-to-cart-behavior' => 'normal',
                    'field_type' => 'add-to-cart'
                ],
            ]
        );

        $this->add_control(
            'fbt_direction',
            [
                'label' => esc_html__('FBT Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'pe-core'),
                        'icon' => 'eicon-arrow-right',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'pe-core'),
                        'icon' => 'eicon-arrow-down',
                    ],
                ],
                'default' => 'row',
                'toggle' => false,
                'prefix_class' => 'ftb--dir--',
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .saren--fbt--products' => 'flex-direction: {{VALUE}};',
                    '{{WRAPPER}} .saren--fbt-products-wrapper' => 'flex-direction: {{VALUE}};',
                ],
                'condition' => ['field_type' => 'fbt'],

            ]
        );


        $this->add_control(
            'text_type',
            [
                'label' => esc_html__('Text Size', 'pe-core'),
                'description' => esc_html__('This option will not change HTML tag of the element, this option only for typographic scaling.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'text-p' => [
                        'title' => esc_html__('P', 'pe-core'),
                        'icon' => ' eicon-editor-paragraph',
                    ],
                    'text-h1' => [
                        'title' => esc_html__('H1', 'pe-core'),
                        'icon' => ' eicon-editor-h1',
                    ],
                    'text-h2' => [
                        'title' => esc_html__('H2', 'pe-core'),
                        'icon' => ' eicon-editor-h2',
                    ],
                    'text-h3' => [
                        'title' => esc_html__('H3', 'pe-core'),
                        'icon' => ' eicon-editor-h3',
                    ],
                    'text-h4' => [
                        'title' => esc_html__('H4', 'pe-core'),
                        'icon' => ' eicon-editor-h4',
                    ],
                    'text-h5' => [
                        'title' => esc_html__('H5', 'pe-core'),
                        'icon' => ' eicon-editor-h5',
                    ],
                    'text-h6' => [
                        'title' => esc_html__('H6', 'pe-core'),
                        'icon' => ' eicon-editor-h6',
                    ]

                ],
                'default' => 'text-p',
                'toggle' => true,

            ]
        );

        $this->add_control(
            'paragraph_size',
            [
                'label' => esc_html__('Paragraph Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Normal', 'pe-core'),
                    'p-small' => esc_html__('Small', 'pe-core'),
                    'p-large' => esc_html__('Large', 'pe-core'),

                ],
                'label_block' => true,
                'condition' => ['text_type' => 'text-p'],
            ]
        );

        $this->add_control(
            'heading_size',
            [
                'label' => esc_html__('Heading Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Normal', 'pe-core'),
                    'md-title' => esc_html__('Medium', 'pe-core'),
                    'big-title' => esc_html__('Large', 'pe-core'),

                ],
                'label_block' => true,
                'condition' => ['text_type' => 'text-h1'],
            ]
        );

        $this->add_control(
            'remove_breaks',
            [
                'label' => esc_html__('Remove Breaks on Mobile', 'pe-core'),
                'description' => esc_html__('On mobile screens "br" tags will be removed.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide-br-mobile',
                'default' => '',

            ]
        );

        $this->add_control(
            'remove_margins',
            [
                'label' => esc_html__('Remove Margins', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'no-margin',
                'default' => '',

            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' => esc_html__('Use Secondary Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'use--sec--color',
                'default' => '',

            ]
        );


        $this->add_control(
            'get_data',
            [
                'label' => esc_html__('Get Data From', 'pe-core'),
                'description' => esc_html__('You can select "Next/Prev product when creating product paginations." ', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'current',
                'options' => [
                    'current' => esc_html__('Current Product', 'pe-core'),
                    'next' => esc_html__('Next Product', 'pe-core'),
                    'prev' => esc_html__('Previous Product', 'pe-core'),

                ],
                'label_block' => false,
            ]
        );
        $this->end_controls_section();

        pe_text_animation_settings($this);

        $this->start_controls_section(
            'additonal_options',
            [

                'label' => esc_html__('Additional Options', 'pe-core'),

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
        $this->add_control(
            'preview_product',
            [
                'label' => __('Preview Product', 'pe-core'),
                'label_block' => true,
                'description' => __('Select product to preview.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->add_control(
            'insert_text_before',
            [
                'label' => esc_html__('Insert Text Before', 'pe-core'),
                'description' => esc_html__('Leave it empty if you do not want to display text before the element.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'insert_text_after',
            [
                'label' => esc_html__('Insert Text After', 'pe-core'),
                'description' => esc_html__('Leave it empty if you do not want to display text after the element.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'countdown_styles_sec',
            [
                'label' => esc_html__('Countdown Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['field_type' => 'countdown-sale'],
            ]
        );


        $this->add_responsive_control(
            'countowns_direction',
            [
                'label' => esc_html__('Attributes Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'pe-core'),
                        'icon' => 'eicon-arrow-right',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'pe-core'),
                        'icon' => 'eicon-arrow-down',
                    ],
                ],
                'default' => 'row',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .saren--sale--countdown' => 'flex-direction: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'counts_typography',
                'label' => esc_html__('Counts Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .saren--sale--countdown > span ',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'count_texts_typography',
                'label' => esc_html__('Count Texts Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .saren--sale--countdown > span::after ',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'count_text_typography',
                'label' => esc_html__('Text Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .ct-text',
            ]
        );

        $this->add_responsive_control(
            'countdowns_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
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
                    'rem' => [
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
                    '{{WRAPPER}} .saren--product--element.element--countdown-sale' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'counts_gap',
            [
                'label' => esc_html__('Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
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
                    'rem' => [
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
                    '{{WRAPPER}} .saren--sale--countdown ' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'counts_border',
                'selector' => '{{WRAPPER}} .saren--sale--countdown span',
                'important' => true
            ]
        );


        $this->add_responsive_control(
            'counts_has_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .saren--sale--countdown span' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $this->add_control(
            'counts_has_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .saren--sale--countdown span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'count_text_alignment',
            [
                'label' => esc_html__('Text Alignment', 'pe-core'),
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
                    '{{WRAPPER}} .ct-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $wishlistCond = ['field_type' => 'add-wishlist-saren'];
        objectStyles($this, 'wishlist_saren_', 'Wishlist Button', '.pe-wishlist-btn.pe--styled--object', true, $wishlistCond, true);

        $compareCond = ['field_type' => 'add-compare-saren'];
        objectStyles($this, 'compare_saren_', 'Compare Button', '.pe-compare-btn.pe--styled--object', true, $compareCond, true);

        $this->start_controls_section(
            'popup_styles_sec',
            [
                'label' => esc_html__('Popup Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['field_style' => 'popup'],
            ]
        );

        popupStyles($this, ['field_style' => 'popup']);

        $cond = ['field_style' => 'popup'];

        objectStyles($this, 'pop_', 'Popup Button', '.pe--pop--button.pe--styled--object', true, $cond, false);

        $this->end_controls_section();

        $this->start_controls_section(
            'fbt_styles',
            [
                'label' => esc_html__('FBT Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['field_type' => 'fbt'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'fbt_text_typography',
                'label' => esc_html__('Text Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .fbt-text',
            ]
        );
        $this->add_responsive_control(
            'fbt_text_alignment',
            [
                'label' => esc_html__('Text Alignment', 'pe-core'),
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
                    '{{WRAPPER}} .fbt-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'fbt_items_bg',
            [
                'label' => esc_html__('Items Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'fbt--items--bg',
                'prefix_class' => '',
                'default' => 'fbt--items--bg',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'fbt_items_border',
                'selector' => '{{WRAPPER}} .fbt-product-item , {{WRAPPER}} .fbt-totals',
                'important' => true
            ]
        );

        $this->add_responsive_control(
            'fbt_items_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .fbt-product-item' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                    '{{WRAPPER}} .fbt-totals' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $this->add_responsive_control(
            'fbt_items_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .fbt-product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .fbt-totals' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'elo_typography',
                'label' => esc_html__('Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .saren--product--element , {{WRAPPER}} .saren--product--element p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'detils_titles_typography',
                'label' => esc_html__('Titles Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .wc-tabs > li > a ,{{WRAPPER}} .swc--item--title',
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
                    'justify' => [
                        'title' => esc_html__('Justify', 'pe-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .saren--product--element' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_align_last',
            [
                'label' => esc_html__('Justify Last Line?', 'pe-core'),
                'description' => esc_html__('On mobile screens "br" tags will be removed.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'justify-last',
                'default' => false,
                'condition' => ['alignment' => 'justify'],
            ]
        );


        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
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
                    '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // $this->add_responsive_control(
        //     'tab_height',
        //     [
        //         'label' => esc_html__('Tab Height', 'pe-core'),
        //         'type' => \Elementor\Controls_Manager::SLIDER,
        //         'size_units' => ['px', '%', 'em', 'vh', 'custom'],
        //         'range' => [
        //             'px' => [
        //                 'min' => 0,
        //                 'max' => 1000,
        //                 'step' => 5,
        //             ],
        //             '%' => [
        //                 'min' => 0,
        //                 'max' => 100,
        //                 'step' => 1,
        //             ],
        //             'vh' => [
        //                 'min' => 0,
        //                 'max' => 100,
        //                 'step' => 1,
        //             ],
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
        //         ],
        //     ]
        // );

        $this->end_controls_section();

        $this->start_controls_section(
            'datas_styles',
            [

                'label' => esc_html__('Datas Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['field_type' => ['add-to-cart', 'data-tabs']],
            ]
        );

        $this->add_control(
            'data_list_style',
            [
                'label' => esc_html__('List Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'nested',
                'options' => [
                    'nested' => esc_html__('Nested', 'pe-core'),
                    'ordered' => esc_html__('Ordered', 'pe-core'),
                ],
                'label_block' => false,
                'prefix_class' => 'datas--list--',
                'condition' => ['datas-style' => 'accordion'],
            ]
        );

        $this->add_control(
            'data_list_underlined',
            [
                'label' => esc_html__('Underline', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'datas--underlined',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'data_list_has_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'datas--has--bg',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'data_list_icon',
            [
                'label' => esc_html__('Show Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'datas--show--icon',
                'prefix_class' => '',
                'default' => 'datas--show--icon',
            ]
        );

        $this->add_responsive_control(
            'data_list_gap',
            [
                'label' => esc_html__('Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swc--accordion' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'variation_styles',
            [

                'label' => esc_html__('Variation Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['field_type' => ['add-to-cart']],
            ]
        );


        $this->add_responsive_control(
            'variations_spacing',
            [
                'label' => esc_html__('Variations Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .variations tr' => 'padding-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => ['field_type' => ['add-to-cart']],
            ]
        );

        $this->add_control(
            'variations_alignment',
            [
                'label' => esc_html__('Variations Alignment', 'pe-core'),
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
                    'space-between' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren-variation-radio-buttons' => 'justify-content: {{VALUE}};',
                ],
                'default' => 'start',
                'toggle' => false,
            ]
        );



        $this->add_control(
            'variations_seperator',
            [
                'label' => esc_html__('Variations Seperator', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'variations--seperator',
                'prefix_class' => '',
                'default' => '',
                'condition' => ['field_type' => ['add-to-cart']],

            ]
        );

        $this->add_control(
            'variations_labels',
            [
                'label' => esc_html__('Hide Variations Labels', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide',
                'prefix_class' => 'variations_labels_',
                'default' => '',
                'condition' => ['field_type' => ['add-to-cart']],
            ]
        );

        $this->add_control(
            'show_selection',
            [
                'label' => esc_html__('Show Selection', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'show',
                'prefix_class' => 'variation--selection--',
                'default' => '',
                'condition' => [
                    'field_type' => ['add-to-cart'],
                    'variations_labels!' => ['hide']
                ],
            ]
        );

        $this->add_control(
            'variations_labels_inline',
            [
                'label' => esc_html__('Variations Labels Inline', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => 'variations_labels_inline_',
                'default' => 'no',
                'condition' => ['field_type' => ['add-to-cart']],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'variations_title_typography',
                'label' => esc_html__('Variation Titles Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} table.variations th.label',
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'variations_terms_typography',
                'label' => esc_html__('Terms Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .variation_labels .saren-variation-radio-buttons .attr--label',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'variations_description_typography',
                'label' => esc_html__('Variation Descriptions Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .saren--attr--desc',
            ]
        );

        $this->add_control(
            'labels_oly',
            [
                'label' => esc_html__('Variation Labels Styles', 'pe-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'vr_labels--pop--active',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'var_items_spacings',
            [
                'label' => esc_html__('Items Spacings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em', 'rem'],
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
                    '{{WRAPPER}}.vr_labels--pop--active .variation_labels .saren-variation-radio-buttons' => 'gap: {{SIZE}}{{UNIT}};',

                ],
            ]
        );

        $this->add_responsive_control(
            'var_items_width',
            [
                'label' => esc_html__('Items Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em', 'rem'],
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
                    '{{WRAPPER}}.vr_labels--pop--active .variation_labels .saren-variation-radio-buttons .radio--parent' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.vr_labels--pop--active .variation_labels .saren-variation-radio-buttons .radio--parent .attr--label' => 'width: 100%;',
                ],
            ]
        );

        $this->add_control(
            'vr_labels_items_alignment',
            [
                'label' => esc_html__('Items Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.vr_labels--pop--active .saren-variation-radio-buttons .radio--parent .attr--label' => 'text-align: {{VALUE}};',
                ],
                'default' => 'start',
                'toggle' => false,
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'vr_labels_border',
                'selector' => '{{WRAPPER}}.vr_labels--pop--active .saren-variation-radio-buttons .radio--parent .attr--label',
                'important' => true
            ]
        );

        echo variationStyles($this, 'vr_labels', 'variation_labels');

        $this->end_popover();

        $this->add_control(
            'labels_with_images',
            [
                'label' => esc_html__('Variation Image Labels Styles', 'pe-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'vr_labels_images--pop--active',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->start_popover();

        echo variationStyles($this, 'vr_labels_images', 'variation_image_label');

        $this->end_popover();

        $this->add_control(
            'colors_only',
            [
                'label' => esc_html__('Variation Colors Styles', 'pe-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'vr_colors_only--pop--active',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->start_popover();


        $this->add_responsive_control(
            'var__colors_items_spacings',
            [
                'label' => esc_html__('Items Spacings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em', 'rem'],
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
                    '{{WRAPPER}}.vr_colors_only--pop--active .variation_color_only .saren-variation-radio-buttons' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'vr_colors_labels_border',
                'selector' => '{{WRAPPER}}.colors--labels--visible .variation_color_only .saren-variation-radio-buttons label.radio--parent',
            ]
        );


        echo variationStyles($this, 'vr_colors_only', 'variation_color_only');

        $this->end_popover();

        $this->add_control(
            'variations_prices',
            [
                'label' => esc_html__('Variations Prices Styles', 'pe-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'vr_prices--pop--active',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->start_popover();


        $this->add_responsive_control(
            'prices_alignment',
            [
                'label' => esc_html__('Prices Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-justify-end-v',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                ],
                'default' => 'bottom',
                'prefix_class' => 'price--align--',
                'toggle' => true,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'vr_prices_border',
                'selector' => '{{WRAPPER}} .saren-variation-radio-buttons:has(.attr--meta) label.radio--parent',
            ]
        );

        $this->add_control(
            'vr_prices_selected_border_color',
            [
                'label' => esc_html__('Selection Border Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .saren-variation-radio-buttons:has(.attr--meta) label.radio--parent:has(input:checked)' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        echo variationStyles($this, 'vr_prices', 'variations tr:has(.attr--price)');

        $this->end_popover();

        $this->end_controls_section();

        $this->start_controls_section(
            'configurator_styles',
            [

                'label' => esc_html__('Configurator Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['add-to-cart-behavior' => 'configurator'],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'conf_titles_typography',
                'label' => esc_html__('Titles Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .svc--title h6',
            ]
        );

        $this->add_responsive_control(
            'conf_titles_alignment',
            [
                'label' => esc_html__('Titles Alignment', 'pe-core'),
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
                'default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sv--configurator--titles' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'conf_spacing',
            [
                'label' => esc_html__('Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--variations--configurator' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $cond = ['add-to-cart-behavior' => 'configurator'];

        objectStyles($this, 'conf_button_', 'Button', '.svc--button', true, $cond, false);


        $this->end_controls_section();



        $this->start_controls_section(
            'button_styles',
            [

                'label' => esc_html__('Add to Cart Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['field_type' => ['add-to-cart']],
            ]
        );

        $this->add_control(
            'add_button_style',
            [
                'label' => esc_html__('Button Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'pe-core'),
                    'simple' => esc_html__('Simple', 'pe-core'),
                ],
                'label_block' => false,
                'render_type' => 'template',
                'prefix_class' => 'add--button--style--',
                'condition' => ['field_type' => 'add-to-cart'],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'woo_button_border',
                'selector' => '{{WRAPPER}} .saren--cart--form',
                'important' => true
            ]
        );


        $this->add_responsive_control(
            'woo_button_has_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--form , {{WRAPPER}} .saren--cart--form::after' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $this->add_control(
            'woo_button_has_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'woo_button_bg_color',
            [
                'label' => esc_html__('Background Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--form::before' => 'background: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'woo_button_hover_bg_color',
            [
                'label' => esc_html__('Background Color (Hover)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--form::after' => 'background: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'woo_button_color',
            [
                'label' => esc_html__('Text Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--form' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .saren--cart--form svg' => 'fill: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'woo_button_hover_color',
            [
                'label' => esc_html__('Hover Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--form:hover' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .saren--cart--form:hover svg' => 'fill: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'woo_button_has_backdrop',
            [
                'label' => esc_html__('Backdrop Filter', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'woo--but--has--backdrop',
                'prefix_class' => '',
                'default' => '',
            ]
        );


        $this->add_responsive_control(
            'woo_button_bg_backdrop_blur',
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
                    'woo_button_has_backdrop' => 'woo--but--has--backdrop',
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--cart--form::after, {{WRAPPER}} .saren--cart--form::before' => '--backdropBlur: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'woo_button_backdrop_color',
            [
                'label' => esc_html__('Backdrop Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.woo--but--has--backdrop .saren--cart--form::before, {{WRAPPER}}.woo--but--has--backdrop .saren--cart--form::after' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'woo_button_has_backdrop' => 'woo--but--has--backdrop',
                ],
            ]
        );

        // $this->add_control(
        //     'quantity_position',
        //     [
        //         'label' => esc_html__('Quantity Position', 'pe-core'),
        //         'type' => \Elementor\Controls_Manager::SELECT,
        //         'default' => 'inline',
        //         'options' => [
        //             'inline' => esc_html__('Inline', 'pe-core'),
        //             'out' => esc_html__('Out', 'pe-core'),
        //         ],
        //         'label_block' => false,
        //         'prefix_class' => 'quantity--pos--',
        //         'condition' => ['field_type' => 'add-to-cart'],
        //     ]
        // );


        $this->add_control(
            'woo_hide_quantity',
            [
                'label' => esc_html__('Disable Quantity', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'woo--quantity--hide',
                'prefix_class' => '',
                'default' => '',
            ]
        );


        $this->add_responsive_control(
            'quantity_radius',
            [
                'label' => esc_html__('Quantity Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .saren--quantity--control' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
                'condition' => ['woo_hide_quantity!' => ['woo--quantity--hide']],
            ]
        );

        $this->add_control(
            'quantity_padding',
            [
                'label' => esc_html__('Quantity Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .saren--quantity--control>span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['woo_hide_quantity!' => ['woo--quantity--hide']],
            ]
        );


        $this->add_responsive_control(
            'quantity_spacing',
            [
                'label' => esc_html__('Quantity Spacings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--quantity--control' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['woo_hide_quantity!' => ['woo--quantity--hide']],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'extra_options_typography',
                'label' => esc_html__('Extra Options Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .product-extra-options ',
            ]
        );

        $this->add_responsive_control(
            'extra_text_border_radius',
            [
                'label' => esc_html__('Extra Option (Text) Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .extra-option.option--text label input[type="text"]' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'sticky_atc_styles',
            [

                'label' => esc_html__('Sticky Add to Cart Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'field_type' => ['add-to-cart'],
                    'add_to_cart_sticky' => ['sticky--atc--active'],
                ],
            ]
        );

        $this->add_responsive_control(
            'sticky_atc_alignment',
            [
                'label' => esc_html__('Alignment', 'pe-core'),
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
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '.saren--sticky--add--to--cart' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sticky_atc_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
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
                    'rem' => [
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
                    '.saren--sticky--add--to--cart .saren--sticky--atc--wrap' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'sticky_atc_spacings',
            [
                'label' => esc_html__('Spacings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '.saren--sticky--add--to--cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sticky_atc_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '.saren--sticky--add--to--cart .saren--sticky--atc--wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sticky_atc_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '.saren--sticky--add--to--cart .saren--sticky--atc--wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'sticky_atc_border',
                'selector' => '.saren--sticky--add--to--cart .saren--sticky--atc--wrap',
                'important' => true
            ]
        );

        $this->add_control(
            'sticky_atc_bg',
            [
                'label' => esc_html__('Background Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '.saren--sticky--add--to--cart .saren--sticky--atc--wrap' => '--secondaryBackground: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'sticky_atc_color',
            [
                'label' => esc_html__('Texts Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '.saren--sticky--add--to--cart .saren--sticky--atc--wrap' => '--mainColor: {{VALUE}}',
                ],

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sticky_atc_title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '.saren--sticky--add--to--cart .saren--sticky--atc--meta h6 ',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sticky_atc_price_typography',
                'label' => esc_html__('Price Typography', 'pe-core'),
                'selector' => '.saren--sticky--add--to--cart .saren--sticky--atc--meta p ',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sticky_atc_inputs_typography',
                'label' => esc_html__('Inputs Typography', 'pe-core'),
                'selector' => '.saren--sticky--add--to--cart .pe-select , .saren--sticky--add--to--cart form.variations_form.saren--sticky--atc button.single_add_to_cart_button.button.alt span.var--add',
            ]
        );

        $this->add_responsive_control(
            'sticky_atc_image_width',
            [
                'label' => esc_html__('Image Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
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
                    'rem' => [
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
                    '.saren--sticky--atc--image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sticky_atc_inputs_width',
            [
                'label' => esc_html__('Inputs Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
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
                    'rem' => [
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
                    '.saren--sticky--add--to--cart .pe-select , .saren--sticky--add--to--cart .saren--cart--form' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sticky_atc_items_padding',
            [
                'label' => esc_html__('Inputs Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '.saren--sticky--add--to--cart form.variations_form.saren--sticky--atc .saren--cart--form , form.variations_form.saren--sticky--atc>div>div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'sticky_atc_items_radius',
            [
                'label' => esc_html__('Inputs Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '.saren--sticky--add--to--cart form.variations_form.saren--sticky--atc .saren--cart--form , form.variations_form.saren--sticky--atc>div>div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        pe_color_options($this);

        $cond = ['field_type' => ['add-wishlist', 'add-compare']];

        objectStyles($this, 'yith_', 'Button', '.saren--product--element a', false, $cond);

        $this->start_controls_section(
            'additonal_styles',
            [

                'label' => esc_html__('Additional Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,

            ]
        );

        $this->add_control(
            'upload_input_style',
            [
                'label' => esc_html__('Upload Input Style', 'pe-core'),
                'description' => esc_html__('Only visible if the file uploads allowed for the product.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'square',
                'options' => [
                    'square' => esc_html__('Square', 'pe-core'),
                    'wide' => esc_html__('Wide', 'pe-core'),
                ],
                'label_block' => false,
                'prefix_class' => 'upload--style--',
                'condition' => ['field_type' => 'add-to-cart'],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'attr__styles',
            [

                'label' => esc_html__('Attributes', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['field_type' => 'attributes'],

            ]
        );

        $this->add_control(
            'attributes_direction',
            [
                'label' => esc_html__('Attributes Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'pe-core'),
                        'icon' => 'eicon-arrow-right',
                    ],
                    'columnas' => [
                        'title' => esc_html__('Column', 'pe-core'),
                        'icon' => 'eicon-arrow-down',
                    ],
                ],
                'default' => 'row',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .element--attributes--display' => 'flex-direction: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'attributes_spacing',
            [
                'label' => esc_html__('Attributes Spacings', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .element--attributes--display' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'attributes_justify',
            [
                'label' => esc_html__('Attributes Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Start', 'pe-core'),
                        'icon' => 'eicon-justify-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-justify-space-around-v',
                    ],
                    'end' => [
                        'title' => esc_html__('End', 'pe-core'),
                        'icon' => 'eicon-justify-end-v',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Justify', 'pe-core'),
                        'icon' => 'eicon-justify-space-between-v',
                    ],
                ],
                'default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .element--attributes--display' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $attrCond = ['field_type' => 'attributes'];

        objectStyles($this, 'attr_styles_', 'Attributes', '.pe--styled--object', false, $attrCond);

        $tagsCond = ['field_type' => 'tags'];
        objectStyles($this, 'tags_styles_', 'Tags', '.product--element--tag.pe--styled--object', false, $tagsCond);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            'attributes',
            [
                'class' => [$settings['text_type'], $settings['paragraph_size'], $settings['heading_size'], $settings['remove_margins'], $settings['remove_breaks'], $settings['text_align_last'], $settings['secondary_color']],
            ]
        );

        $type = $settings['field_type'];

        $loop = new \WP_Query([
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'order' => 'ASC',
            'post__in' => $settings['preview_product'] ? array($settings['preview_product']) : '',
        ]);
        wp_reset_postdata();


        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            while ($loop->have_posts()):
                $loop->the_post();
                $id = get_the_ID();
            endwhile;
            wp_reset_query();
        } else {

            $id = get_the_ID();
        }

        $product = wc_get_product($id);

        ?>

                                <div data-barba-prevent="all" class="saren--product--element <?php echo 'element--' . $type ?>">

                                    <?php if (!empty($settings['insert_text_before'])) {
                                        echo '<span class="element--text--before">' . $settings['insert_text_before'] . '</span>';
                                    } ?>

                                    <?php
                                    if ($product) {

                                        if ($settings['field_style'] === 'popup') {

                                            $object = '';
                                            $title = '';

                                            if ($type === 'custom-tabs') {
                                                $tab_id = $settings['select_tab_to_display'];
                                                if ($tab_id) {
                                                    $title = get_the_title($tab_id);
                                                }
                                            } else {
                                                $title = $settings['popup_title'];
                                            }

                                            if ($settings['template_popup_style'] === 'icon') {

                                                if ($settings['template_popup_icon']['value']) {
                                                    ob_start();
                                                    \Elementor\Icons_Manager::render_icon($settings['template_popup_icon'], ['aria-hidden' => 'true']);
                                                    $object = ob_get_clean();

                                                } else {
                                                    $svgPath = plugin_dir_path(__FILE__) . '../assets/img/popup.svg';
                                                    $object = file_get_contents($svgPath);
                                                }

                                            } else if ($settings['template_popup_style'] === 'text') {
                                                $object = $title;
                                            } else if ($settings['template_popup_style'] === 'icon_text') {

                                                if ($settings['template_popup_icon']['value']) {
                                                    ob_start();
                                                    \Elementor\Icons_Manager::render_icon($settings['template_popup_icon'], ['aria-hidden' => 'true']);
                                                    $icon = ob_get_clean();

                                                } else {
                                                    $svgPath = plugin_dir_path(__FILE__) . '../assets/img/popup.svg';
                                                    $icon = file_get_contents($svgPath);
                                                }
                                                $object = '<span>' . $icon . '</span><span>' . $title . '</span>';

                                            }

                                            ?>

                                                                    <div class="pe--pop--button ctab--pop--button pe--styled--object"><?php echo $object ?>
                                                                    </div>
                                                                    <div class="pe--styled--popup">
                                                                        <span class="pop--close">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                                                                <path
                                                                                    d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z" />
                                                                            </svg>
                                                                        </span>

                                                                        <?php
                                                                        if ($type === 'additional-info') {

                                                                            echo woocommerce_product_additional_information_tab();

                                                                        } else if ($type === 'description') {

                                                                            echo $product->get_description();

                                                                        } else if ($type === 'short-description') {

                                                                            echo $product->get_short_description();

                                                                        } else if ($type === 'data-tabs') {

                                                                            woocommerce_output_product_data_tabs();

                                                                        } else if ($type === 'custom-tabs') {

                                                                            $tab_id = $settings['select_tab_to_display'];

                                                                            if ($tab_id) {

                                                                                if (is_built_with_elementor($tab_id)) {
                                                                                    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tab_id);
                                                                                } else {
                                                                                    echo get_post_field('post_content', $tab_id);
                                                                                }

                                                                            }

                                                                        }
                                                                        ?>

                                                                    </div>

                                                                    <?php if ($settings['back_overlay'] === 'true') { ?>
                                                                                    <span class="pop--overlay"></span>
                                                                    <?php } ?>


                                                    <?php }

                                        if ($type === 'title') {
                                            echo '<p ' . $this->get_render_attribute_string('attributes') . pe_text_animation($this) . '>' . get_the_title($id) . '</p>';

                                        } else if ($type === 'custom-tabs' && $settings['field_style'] !== 'popup') {

                                            $tab_id = $settings['select_tab_to_display'];
                                            if (is_built_with_elementor($tab_id)) {
                                                echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tab_id);
                                            } else {
                                                echo get_post_field('post_content', $tab_id);
                                            }

                                        } else if ($type === 'price') {

                                            $original_price = $product->get_regular_price();
                                            $sale_price = $product->get_sale_price();

                                            if ($sale_price && $original_price > $sale_price) {
                                                $discount_percentage = round((($original_price - $sale_price) / $original_price) * 100);
                                                $discount_text = '<span class="discount-percentage">-' . $discount_percentage . '%</span>';
                                            } else {
                                                $discount_text = '';
                                            }

                                            echo '<p ' . $this->get_render_attribute_string('attributes') . pe_text_animation($this) . '>' . $discount_text . $product->get_price_html() . '</p>';

                                        } else if ($type === 'countdown-sale') {

                                            if ($product->is_type('variable')) {

                                                $available_variations = $product->get_available_variations();
                                                if (!empty($available_variations)) {
                                                    $first_variation = wc_get_product($available_variations[0]['variation_id']);
                                                    $product = $first_variation;
                                                }
                                            }

                                            if ($product->is_on_sale() && $product->get_date_on_sale_to()) {

                                                $regular_price = $product->get_regular_price();
                                                $sale_price = $product->get_sale_price();

                                                if (!empty($settings['countdown_text'])) {
                                                    echo '<span class="ct-text">' . $settings['countdown_text'] . '</span>';
                                                }

                                                if ($sale_price && $regular_price > $sale_price) {

                                                    $sale_end = $product->get_date_on_sale_to();
                                                    if ($sale_end) {
                                                        $sale_end_timestamp = $sale_end->getTimestamp();
                                                    } else {
                                                        $sale_end_timestamp = time();
                                                    } ?>

                                                                                                                                                    <div class="saren--sale--countdown" data-endtime="<?php echo $sale_end_timestamp; ?>">
                                                                                                                                                        <span data-text="days" class="days"></span>
                                                                                                                                                        <span data-text="hours" class="hours"></span>
                                                                                                                                                        <span data-text="minutes" class="minutes"></span>
                                                                                                                                                        <span data-text="seconds" class="seconds"></span>
                                                                                                                                                    </div>
                                                                                    <?php }
                                            }

                                        } else if ($type === 'attributes') {
                                            $attributes = $settings['attributes_to_display'];

                                            if (!empty($attributes)) {
                                                echo '<div class="element--attributes--display">';

                                                foreach ($attributes as $attribute) {
                                                    $vars = wc_get_attribute($attribute);
                                                    $taxonomy = esc_attr($vars->slug);
                                                    $taxName = $vars->name;

                                                    $terms = wc_get_product_terms($product->get_id(), $taxonomy, array('fields' => 'all'));

                                                    if (!empty($terms)) {

                                                        foreach ($terms as $term) {
                                                            echo '<div class="pe--styled--object"><span>' . $taxName . ': </span><span>' . esc_html($term->name) . '</span></div>';
                                                        }
                                                    }
                                                }

                                                echo '</div>';
                                            }
                                        } else if ($type === 'additional-info' && $settings['field_style'] !== 'popup') {

                                            echo woocommerce_product_additional_information_tab();

                                        } else if ($type === 'description' && $settings['field_style'] !== 'popup') {

                                            echo '<p ' . $this->get_render_attribute_string('attributes') . pe_text_animation($this) . '>' . $product->get_description() . '</p>';


                                        } else if ($type === 'add-wishlist') {

                                            echo '<span data-barba-prevent="all">' . do_shortcode('[yith_wcwl_add_to_wishlist]') . '</span>';

                                        } else if ($type === 'add-wishlist-saren') {

                                            peWishlistButton($product->get_id(), $settings);

                                        } else if ($type === 'add-compare-saren') {

                                            peCompareButton($product->get_id(), $settings);

                                        } else if ($type === 'add-compare') {

                                            $svgPath = get_template_directory() . '/assets/img/compare.svg';
                                            $icon = file_get_contents($svgPath);

                                            echo '<span class="pe--compare--wrap" data-barba-prevent="all">
                    <span class="compare--svg">' . $icon . '</span>'
                                                . do_shortcode('[yith_compare_button]') . '
                    </span>';

                                        } else if ($type === 'short-description' && $settings['field_style'] !== 'popup') {

                                            echo '<p ' . $this->get_render_attribute_string('attributes') . pe_text_animation($this) . '>' . $product->get_short_description() . '</p>';
                                        } else if ($type === 'add-to-cart') {

                                            if ($settings['add_to_cart_sticky'] === 'sticky--atc--active') {
                                                update_post_meta($product->get_id(), 'sticky_add_to_cart', true);
                                                if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                                                    sarenStickyAddToCart($product);
                                                }
                                            } else {
                                                update_post_meta($product->get_id(), 'sticky_add_to_cart', false);
                                            }


                                            if ($product->is_type('simple')) {
                                                woocommerce_simple_add_to_cart();
                                            } elseif ($product->is_type('subscription')) {
                                                woocommerce_simple_add_to_cart();
                                            } elseif ($product->is_type('variable')) {
                                                woocommerce_variable_add_to_cart();
                                            } elseif ($product->is_type('grouped')) {
                                                woocommerce_grouped_add_to_cart();
                                            } elseif ($product->is_type('external')) {
                                                woocommerce_external_add_to_cart();
                                            }

                                        } else if ($type === 'rating' && $product->get_average_rating()) {
                                            echo wc_get_rating_html($product->get_average_rating());
                                            echo '<span class="ratings--count">( ' . esc_html($product->get_rating_count()) . ' ' . esc_html('Ratings', 'pe-core') . ')</span>';
                                        } else if ($type === 'stock') {
                                            echo wc_get_stock_html($product);
                                        } else if ($type === 'sku') {
                                            echo '<p ' . $this->get_render_attribute_string('attributes') . pe_text_animation($this) . '>' . $product->get_sku() . '</p>';
                                        } else if ($type === 'categories') {
                                            $categories = wp_get_post_terms($product->get_id(), 'product_cat');
                                            foreach ($categories as $category) {
                                                echo $category->name . '';
                                            }
                                        } else if ($type === 'brands') {
                                            $brands = wp_get_post_terms($product->get_id(), 'brand');
                                            foreach ($brands as $brand) {
                                                echo $brand->name . '';
                                            }
                                        } else if ($type === 'tags') {
                                            $tags = wp_get_post_terms($product->get_id(), 'product_tag');
                                            foreach ($tags as $tag) {
                                                echo '<span class="product--element--tag pe--styled--object"><span>' . $tag->name . '</span></span>';
                                            }


                                        } else if ($type === 'data-tabs' && $settings['field_style'] !== 'popup') {

                                            if (!empty($settings['exclude_tabs'])) {

                                                $excluded = $settings['exclude_tabs'];
                                                echo '<style>';
                                                foreach ($excluded as $ex) {
                                                    echo '.tab-title-' . $ex . '{
                            display: none;
                        }';

                                                    echo '#tab-title-' . $ex . '{
                            display: none;
                        }';

                                                    echo '.woocommerce-Tabs-panel--' . $ex . '{
                            display: none !important;
                        }';

                                                }
                                                echo '</style>';

                                            }
                                            woocommerce_output_product_data_tabs();

                                        } else if ($type === 'fbt') {

                                            $fbt_data = get_post_meta($product->get_id(), '_fbt_data', true);

                                            if (!empty($fbt_data)) {
                                                echo '<div class="saren--fbt-products">';
                                                if (!empty($settings['fbt_text'])) {
                                                    echo '<span class="fbt-text">' . $settings['fbt_text'] . '</span>';
                                                }

                                                echo '<form method="post" class="fbt-form">';
                                                echo '<div class="saren--fbt--products">';
                                                echo '<div class="saren--fbt-products-wrapper">';

                                                $total_price = 0;

                                                foreach ($fbt_data as $item) {
                                                    $product_id = $item['product_id'];
                                                    $product = wc_get_product($product_id);

                                                    if ($product) {
                                                        $total_price += $product->get_price();

                                                        echo '<div class="fbt-product-item">';
                                                        echo '<input type="checkbox" name="fbt_products[]" value="' . esc_attr($product_id) . '" class="fbt-checkbox" checked>';
                                                        echo '<div class="fbt-product-image">';
                                                        echo $product->get_image();
                                                        echo '</div>';
                                                        echo '<div class="fbt-product-details">';
                                                        echo '<a href="' . esc_url(get_permalink($product_id)) . '" target="_blank">' . esc_html($product->get_name()) . '</a>';
                                                        echo '<span class="fbt-price">' . wc_price($product->get_price()) . '</span>';

                                                        if ($product->is_type('variable')) {
                                                            $variations = $product->get_available_variations();

                                                            if (!empty($variations)) {
                                                                echo '<select name="fbt_variations[' . esc_attr($product_id) . ']" class="fbt-variation-select">';
                                                                echo '<option value="">' . __('Select variation', 'pe-core') . '</option>';

                                                                foreach ($variations as $variation) {
                                                                    $variation_id = $variation['variation_id'];
                                                                    $variation_obj = wc_get_product($variation_id);
                                                                    $variation_price = $variation_obj->get_price();
                                                                    $attributes = $variation['attributes'];
                                                                    $variation_name = [];

                                                                    foreach ($attributes as $attribute_name => $attribute_value) {
                                                                        $taxonomy = str_replace('attribute_', '', $attribute_name);
                                                                        $term = get_term_by('slug', $attribute_value, $taxonomy);

                                                                        if ($term) {
                                                                            $variation_name[] = $term->name;
                                                                        } else {
                                                                            $variation_name[] = ucfirst(str_replace('-', ' ', $attribute_value));
                                                                        }
                                                                    }


                                                                    echo '<option value="' . esc_attr($variation_id) . '" data-price="' . esc_attr($variation_price) . '">' . esc_html(implode(', ', $variation_name)) . '</option>';
                                                                }

                                                                echo '</select>';
                                                            }
                                                        }



                                                        echo '</div>';
                                                        echo '<span class="fbt--plus">' . file_get_contents(get_template_directory_uri() . '/assets/img/add.svg') . '</span>';
                                                        echo '</div>';

                                                    }
                                                }

                                                echo '</div>';
                                                echo '<div class="fbt-totals">';
                                                echo '<div class="fbt-total-price">';
                                                echo '<span>' . __('Total:', 'saren') . ' </span>';
                                                echo '<span class="fbt-total-value">' . wc_price($total_price) . '</span>';
                                                echo '</div>';
                                                echo '<div class="fbt-info"></div>';
                                                echo '<button type="submit" class="button fbt-add-to-cart">' . __('Add Selected to Cart', 'saren') . '</button>';
                                                echo '</div>';
                                                echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                            }

                                        }
                                    }
                                    ?>

                                    <?php if (!empty($settings['insert_text_after'])) {

                                        echo '<span class="element--text--after">' . $settings['insert_text_after'] . '</span>';

                                    } ?>

                                </div>

                                <?php
    }

}