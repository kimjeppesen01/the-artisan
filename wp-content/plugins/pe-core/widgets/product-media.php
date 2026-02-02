<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peProductMedia extends Widget_Base
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
        return 'productmedia';
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
        return __('Product Media', 'pe-core');
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
        return 'eicon-product-images pe-widget';
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
                'label' => __('Product Media', 'pe-core'),
            ]
        );

        $this->add_control(
            'media_type',
            [
                'label' => esc_html__('Media Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'featured',
                'options' => [
                    'featured' => esc_html__('Featured Image/Video', 'pe-core'),
                    'gallery' => esc_html__('Gallery', 'pe-core'),
                    'video' => esc_html__('Product Video', 'pe-core'),
                ],

            ]
        );

        $this->add_control(
            'gallery_type',
            [
                'label' => esc_html__('Gallery Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'carousel',
                'options' => [
                    'slideshow' => esc_html__('Slideshow', 'pe-core'),
                    'carousel' => esc_html__('Carousel', 'pe-core'),
                ],
                'condition' => ['media_type' => 'gallery'],

            ]
        );

        $this->add_control(
            'slider_direction',
            [
                'label' => esc_html__('Slider Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'horizontal' => [
                        'title' => esc_html__('Horizontal', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'vertical' => [
                        'title' => esc_html__('Vertical', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom'
                    ],
                ],
                'default' => 'horizontal',
                'toggle' => false,
                'prefix_class' => 'swiper--',
                'render_type' => 'template',
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                ],
            ]
        );


        $this->add_control(
            'swiper_parallax',
            [
                'label' => esc_html__('Parallax Slideshow', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'swiper_parallax',
                'prefix_class' => '',
                'render_type' => 'template',
                'default' => '',
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_control(
            'swiper_wheel',
            [
                'label' => esc_html__('Mousewheel Navigation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'swiper_wheel',
                'prefix_class' => '',
                'default' => '',
                'render_type' => 'template',
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_control(
            'swiper_loop',
            [
                'label' => esc_html__('Loop', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'swiper_loop',
                'prefix_class' => '',
                'default' => '',
                'render_type' => 'template',
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_parallax!' => 'swiper_parallax',
                ],
            ]
        );

        $this->add_control(
            'swiper_thumbnails',
            [
                'label' => esc_html__('Thumbnails Navigation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                ],
            ]
        );



        $this->add_control(
            'parallax',
            [
                'label' => esc_html__('Parallax Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'parallax--image',
                'default' => '',
                'condition' => ['media_type' => 'featured'],
            ]
        );

        $this->add_control(
            'gallery_id',
            [
                'label' => esc_html__('Gallery ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'placeholder' => esc_html__('Eg: product_gallery', 'pe-core'),
                'description' => esc_html__('Required when adding control widgets.', 'pe-core'),
                'condition' => ['media_type' => 'gallery'],
            ]
        );

        $this->add_control(
            'carousel_direction',
            [
                'label' => esc_html__('Carousel Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'horizontal' => [
                        'title' => esc_html__('Horizontal', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'vertical' => [
                        'title' => esc_html__('Vertical', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom'
                    ],
                ],
                'default' => 'horizontal',
                'toggle' => false,
                'prefix_class' => 'carousel--',
                'render_type' => 'template',
                'condition' => [
                    'gallery_type' => 'carousel',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_control(
            'carousel_grid',
            [
                'label' => esc_html__('Grid Carousel', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'carousel--grid',
                'default' => '',
                'prefix_class' => '',
                'condition' => [
                    'gallery_type' => 'carousel',
                    'media_type' => 'gallery',
                    'carousel_direction' => 'vertical',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid--columns',
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
                    '{{WRAPPER}} .product--gallery--wrapper' => '--cols: {{SIZE}} !important;',
                ],
                'condition' => [
                    'gallery_type' => 'carousel',
                    'media_type' => 'gallery',
                    'carousel_direction' => 'vertical',
                    'carousel_grid' => 'carousel--grid',
                ],
            ]
        );

        $this->add_control(
            'gallery_behavior',
            [
                'label' => esc_html__('Carousel Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'drag',
                'prefix_class' => 'cr--',
                'options' => [
                    'scroll' => esc_html__('Scroll', 'pe-core'),
                    'drag' => esc_html__('Drag', 'pe-core'),
                ],
                'condition' => [
                    'gallery_type' => 'carousel',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_responsive_control(
            'images_position',
            [
                'label' => esc_html__('Images Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'pe-core'),
                        'icon' => 'eicon-v-align-middle'
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => ' eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .product--gallery--wrapper' => 'align-items: {{VALUE}};',
                ],
                'condition' => [
                    'gallery_type' => 'carousel',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_control(
            'pin_target',
            [
                'label' => esc_html__('Pin Target', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'placeholder' => esc_html__('Eg: #mainContainer', 'pe-core'),
                'description' => esc_html__('You can enter a container id/class which the element will be pinned during animation.', 'pe-core'),
                'condition' => [
                    'gallery_behavior' => 'scroll',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Scroll Speed', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 100,
                'default' => 5000,
                'condition' => [
                    'gallery_behavior' => 'scroll',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_control(
            'variable_images',
            [
                'label' => esc_html__('Variable Images', 'pe-core'),
                'description' => esc_html__('Variation images will be shown on the featured image when selected.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => '',
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
                    '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['media_type' => 'featured'],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'vw'],
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
                    '{{WRAPPER}} .product-featured-image' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .saren--product--video' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['media_type' => ['featured', 'video']],
            ]
        );

        $this->add_responsive_control(
            's_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'vw'],
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
                    '{{WRAPPER}} .product-featured-image' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .saren--product--video' => 'width  : {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['media_type' => ['featured', 'video']],
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
                        'icon' => 'eicon-text-align-center',
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
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
                'condition' => ['media_type' => 'featured'],
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

        $this->add_control(
            'linked',
            [
                'label' => esc_html__('Linked?', 'pe-core'),
                'description' => esc_html__('Image will be linked to the product.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',

            ]
        );

        $this->add_control(
            'include_featured',
            [
                'label' => esc_html__('Include Featured Media to Gallery', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [

                    'media_type' => 'gallery',
                ],

            ]
        );

        $this->add_control(
            'product_images_zoom',
            [
                'label' => esc_html__('Images Zoom', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'no-zoom',
                'prefix_class' => 'zoom--',
                'render_type' => 'template',
                'options' => [
                    'no-zoom' => esc_html__('No Zoom', 'pe-core'),
                    'zoom-inner' => esc_html__('Inner', 'pe-core'),
                    'zoom-outer' => esc_html__('Outer', 'pe-core'),
                ],
                'label_block' => false,
                'condition' => [
                    'media_type' => ['gallery', 'featured'],

                ],
            ]
        );

        $this->add_control(
            'product_images_lightbox',
            [
                'label' => esc_html__('Lightbox', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'render_type' => 'template',
                'prefix_class' => 'images--lightbox--',
                'default' => '',
                'condition' => [
                    'media_type' => ['gallery', 'featured'],
                    'gallery_type' => 'carousel',
                    'product_images_zoom' => 'no-zoom'
                ],
            ]
        );

        $this->add_control(
            'lightbox_button',
            [
                'label' => esc_html__('Lightbox Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'render_type' => 'template',
                'default' => '',
                'condition' => [
                    'media_type' => ['gallery', 'featured'],
                    'gallery_type' => 'carousel',
                    'product_images_lightbox' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'lightbox_button_custom_icon',
            [
                'label' => esc_html__('Custom Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'media_type' => ['gallery', 'featured'],
                    'gallery_type' => 'carousel',
                    'product_images_lightbox' => 'yes',
                    'lightbox_button' => 'yes'
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

        $this->add_responsive_control(
            'slideshow_width',
            [
                'label' => esc_html__('Slideshow Width', 'pe-core'),
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
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product--gallery' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_responsive_control(
            'sldieshow_height',
            [
                'label' => esc_html__('Slideshow Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh' , 'custom'],
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .product--gallery' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_order',
            [
                'label' => esc_html__('Thumbnails Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'column' => [
                        'title' => esc_html__('Vertical', 'pe-core'),
                        'icon' => 'eicon-navigation-vertical',
                    ],
                    'row' => [
                        'title' => esc_html__('Horizontal', 'pe-core'),
                        'icon' => 'eicon-navigation-horizontal'
                    ],
                ],
                'default' => 'row',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .gallery--slideshow--thumbnails' => 'flex-direction: {{VALUE}};',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true'
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_size',
            [
                'label' => esc_html__('Thumbnails Size', 'pe-core'),
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
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gs--thumb' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true'
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_gap',
            [
                'label' => esc_html__('Thumbnails Gap', 'pe-core'),
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
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery--slideshow--thumbnails' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true'
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_vertical_orientation',
            [
                'label' => esc_html__('Thumbnails Vertical Orientation', 'pe-core'),
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
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true'
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_vertical_offset_top',
            [
                'label' => esc_html__('Vertical Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery--slideshow--thumbnails' => 'top: {{SIZE}}{{UNIT}};bottom: unset',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true',
                    'thumbs_vertical_orientation' => 'top'
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_vertical_offset_bottom',
            [
                'label' => esc_html__('Vertical Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery--slideshow--thumbnails' => 'bottom: {{SIZE}}{{UNIT}};top: unset',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true',
                    'thumbs_vertical_orientation' => 'bottom'
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_transform_y',
            [
                'label' => esc_html__('Thumbs Transform Y', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery--slideshow--thumbnails' => '--transformY: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_horizontal_orientation',
            [
                'label' => esc_html__('Thumbnails Horizontal Orientation', 'pe-core'),
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
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true'
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_horizontal_offset_left',
            [
                'label' => esc_html__('Horizontal Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery--slideshow--thumbnails' => 'left: {{SIZE}}{{UNIT}};right: unset',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true',
                    'thumbs_horizontal_orientation' => 'left'
                ],
            ]
        );


        $this->add_responsive_control(
            'thumbs_horizontal_offset_right',
            [
                'label' => esc_html__('Horizontal Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery--slideshow--thumbnails' => 'right: {{SIZE}}{{UNIT}};left: unset',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true',
                    'thumbs_horizontal_orientation' => 'right'
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_transform_x',
            [
                'label' => esc_html__('Thumbs Transform X', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery--slideshow--thumbnails' => '--transformX: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true',
                ],
            ]
        );


        $this->add_responsive_control(
            'images_height',
            [
                'label' => esc_html__('Images Height', 'pe-core'),
                'description' => esc_html__('Leave it empty if you want to display images with different heights', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .product--gallery--image' => 'height: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'gallery_type' => 'carousel',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_responsive_control(
            'images_width',
            [
                'label' => esc_html__('Items Width', 'pe-core'),
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
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product--gallery.gallery--carousel .product--gallery--wrapper .product--gallery--image' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'gallery_type' => 'carousel',
                    'media_type' => 'gallery',
                ],
            ]
        );

        $this->add_responsive_control(
            'images_gap',
            [
                'label' => esc_html__('Space Between Images', 'pe-core'),
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
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product--gallery--wrapper' => 'gap: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'gallery_type' => 'carousel',
                    'media_type' => 'gallery',
                ],
            ]
        );


        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .product--gallery.gallery--carousel .product--gallery--wrapper .product--gallery--image' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                    '{{WRAPPER}} .product--gallery.swiper-container' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                    '{{WRAPPER}} .product-featured-image' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                    '{{WRAPPER}} .pe-video' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius (Thumbs)',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'condition' => [
                    'gallery_type' => 'slideshow',
                    'media_type' => 'gallery',
                    'swiper_thumbnails' => 'true',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery--slideshow--thumbnails .gs--thumb' => '--radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'images_border',
                'selector' => '{{WRAPPER}} .product--gallery--image',
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} img , {{WRAPPER}} .saren--product--video',
            ]
        );

        $this->add_control(
            'images_fit',
            [
                'label' => esc_html__('Images Fit', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover', 'pe-core'),
                    'contain' => esc_html__('Contain', 'pe-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .product--gallery.gallery--slideshow .product--gallery--image.swiper-slide img' => 'object-fit: {{VALUE}};',
                ],

            ]
        );

        $cond = ['swiper_thumbnails' => 'true'];


        $ligthtboxButtonCond = [
            [
                'media_type' => ['gallery', 'featured'],
                'gallery_type' => 'carousel',
                'product_images_lightbox' => 'yes',
                'lightbox_button' => 'yes'
            ],
        ];

        objectStyles($this, 'lightbox_button', 'Lightbox Button', '.saren--lightbox--button.pe--styled--object', true, $ligthtboxButtonCond, false, false);
        objetAbsolutePositioning($this, '.saren--lightbox--button.pe--styled--object', 'lightbox_button', 'Lightbox Button', $ligthtboxButtonCond);

        $this->add_responsive_control(
            'lightbox_button_icon_size',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'vw'],
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
                    '{{WRAPPER}} .product-featured-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['media_type' => ['featured', 'video']],
            ]
        );


        $this->end_controls_section();

        pe_cursor_settings($this);
        pe_general_animation_settings($this);
        objectStyles($this, 'thumbs_', 'Thumbnails', '.gs--thumb.pe--styled--object', false, $cond);


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

        $this->end_controls_section();

        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $loop = new \WP_Query([
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'order' => 'ASC',
            'order_by' => 'date',
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
            global $wp_query;
            $id = $wp_query->post->ID;
            $previous_post = get_previous_post();
            $next_post = get_next_post();

            if ($settings['get_data'] === 'next') {

                if (!$next_post) {
                    while ($loop->have_posts()):
                        $loop->the_post();
                        $id = get_the_ID();
                    endwhile;
                } else {
                    $id = $next_post->ID;
                }

            } else if ($settings['get_data'] === 'prev') {
                $id = $previous_post->ID;
            }

        }

        $type = $settings['media_type'];

        if ($settings['get_data'] === 'current') {
            $classes = 'p--featured featured__' . $id;
        } else {
            $classes = 'product__image__' . $id;
        }

        $product = wc_get_product(get_the_ID());
        ?>


        <?php if ($type === 'featured') { ?>

            <?php if ($settings['linked'] === 'yes') { ?>

                <a <?php echo pe_cursor($this) ?> data-id="<?php echo esc_attr($id) ?>" class="product--barba--trigger"
                    href="<?php echo esc_url(get_the_permalink($id)) ?>">

                <?php } ?>

                <div class="pe--product-image product-featured-image <?php echo esc_attr($classes . ' ' . $settings['parallax']) ?>"
                    <?php echo pe_general_animation($this) ?>>

                    <?php if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                        while ($loop->have_posts()):
                            $loop->the_post(); ?>

                            <img src="<?php echo esc_attr(get_the_post_thumbnail_url(get_the_ID())); ?>">
                            <?php


                        endwhile;
                        wp_reset_query();

                    } else { ?>

                        <?php if ((get_field('product_video') === 'vimeo' || get_field('product_video') === 'youtube' || get_field('product_video') === 'self') && get_field('use_as_featured_media') == true) {
                            $provider = get_field('product_video');
                            $video_id = get_field('video_id');
                            $self_video = get_field('self_hosted_video');
                            ?>

                            <div class="saren--product--video">


                                <div class="product--single--media" class="pe-video pe-<?php echo esc_attr($provider) ?>"
                                    data-controls=false data-autoplay=true data-muted=true data-loop=true>

                                    <?php if ($provider === 'self') { ?>
                                        <video class="p-video" autoplay muted loop playsinline>
                                            <source src="<?php echo esc_url($self_video); ?>">
                                        </video>
                                    <?php } else { ?>
                                        <div class="p-video" data-plyr-provider="<?php echo esc_attr($provider) ?>"
                                            data-plyr-embed-id="<?php echo esc_attr($video_id) ?>"></div>
                                    <?php } ?>
                                </div>

                            </div>

                        <?php } else {
                            echo wp_get_attachment_image(get_post_thumbnail_id(), 'full', false, array(
                                'class' => 'product--single--media',
                                'loading' => 'eager',
                                'fetchpriority' => 'high',
                            ));
                        } ?>

                    <?php }

                    ?>
                </div>

                <?php if ($settings['linked'] === 'yes') { ?>
                </a>
            <?php } ?>

        <?php } else if ($type === 'gallery' && $product) {

            $attachment_ids = $product->get_gallery_image_ids();
            $type = $settings['gallery_type'];

            $this->add_render_attribute(
                'gallery_attributes',
                [
                    'class' => ['anim-multiple product--gallery', $type === 'slideshow' ? 'swiper-container' : '', 'gallery--' . $type],
                ]
            );

            $this->add_render_attribute(
                'wrapper_attributes',
                [
                    'class' => ['product--gallery--wrapper', $type === 'slideshow' ? 'swiper-wrapper' : '', 'cr--' . $settings['gallery_behavior']],
                    'data-pin-target' => $settings['pin_target'],
                    'data-id' => $settings['gallery_id'],
                    'data-speed' => $settings['speed']
                ]
            );

            $this->add_render_attribute(
                'item_attributes',
                [
                    'class' => ['product--gallery--image', 'inner--anim', $type === 'slideshow' ? 'swiper-slide cr--item' : '', $type === 'carousel' ? 'cr--item' : ''],
                ]
            );

            if ($type === 'slideshow' && $settings['swiper_thumbnails'] === 'true') { ?>

                    <div class="gallery--slideshow--thumbnails anim-multiple" <?php echo pe_general_animation($this) ?>>

                    <?php if ($settings['include_featured'] === 'yes') { ?>

                            <div class="inner--anim gs--thumb pe--styled--object gs_thumb_0 active" data-id=0>

                            <?php if ((get_field('product_video') === 'vimeo' || get_field('product_video') === 'youtube' || get_field('product_video') === 'self') && get_field('use_as_featured_media') == true) {
                                $provider = get_field('product_video');
                                $video_id = get_field('video_id');
                                $self_video = get_field('self_hosted_video');
                                ?>

                                    <div class="saren--product--video">


                                        <div class="pe-video pe-<?php echo esc_attr($provider) ?>" data-controls=false data-autoplay=true
                                            data-muted=true data-loop=true>

                                        <?php if ($provider === 'self') { ?>
                                                <video class="p-video" autoplay muted loop playsinline>
                                                    <source src="<?php echo esc_url($self_video['url']); ?>">
                                                </video>
                                        <?php } else { ?>
                                                <div class="p-video" data-plyr-provider="<?php echo esc_attr($provider) ?>"
                                                    data-plyr-embed-id="<?php echo esc_attr($video_id) ?>"></div>
                                        <?php } ?>
                                        </div>

                                    </div>

                            <?php } else {
                                echo wp_get_attachment_image(get_post_thumbnail_id(), 'medium_large', false, array(
                                    'class' => 'img--zoom ' . $settings['product_images_zoom'],
                                    'loading' => 'eager',
                                    'fetchpriority' => 'high',
                                ));
                            } ?>

                            </div>
                    <?php } ?>
                    <?php foreach ($attachment_ids as $key => $attachment_id) {
                        $settings['include_featured'] === 'yes' ? $key++ : '';
                        ?>
                            <div class="inner--anim gs--thumb pe--styled--object gs_thumb_<?php echo $key ?>" data-id=<?php echo $key ?>>
                            <?php echo wp_get_attachment_image($attachment_id, 'medium_large', false, array(
                                'loading' => 'eager',
                                'fetchpriority' => 'high',
                            )) ?>
                            </div>

                    <?php } ?>

                    </div>

            <?php } ?>

                <div <?php echo pe_general_animation($this) ?><?php echo $this->get_render_attribute_string('gallery_attributes') ?>>

                <?php if ($settings['product_images_lightbox'] === 'yes') { ?>

                        <div class="saren--lightbox--controls">
                            <span class="saren--lightbox--close">
                            <?php echo file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/close.svg'); ?></span>
                            <span class="saren--lightbox--prev">
                            <?php echo file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/arrow_back.svg'); ?></span>
                            <span class="saren--lightbox--next">
                            <?php echo file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/arrow_forward.svg'); ?></span>
                            <span class="saren--lightbox--overlay"></span>
                        </div>

                <?php } ?>

                <?php if ($settings['product_images_lightbox'] === 'yes' && $settings['lightbox_button'] === 'yes') { ?>
                        <div class="saren--lightbox--button pe--styled--object">
                            <?php
                            if ($settings['lightbox_button_custom_icon']['value']) {
                                ob_start();
                                \Elementor\Icons_Manager::render_icon($settings['lightbox_button_custom_icon'], ['aria-hidden' => 'true']);
                                $lightboxIcon = ob_get_clean();
                            } else {
                                $lightboxIcon = file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/zoom_out.svg');
                            }

                            echo $lightboxIcon;

                            ?></span>
                        </div>
                <?php } ?>


                <?php if ($settings['product_images_zoom'] === 'zoom-outer') {
                    echo '<div class="product--image--zoom--wrap"></div>';
                } ?>

                    <div <?php echo $this->get_render_attribute_string('wrapper_attributes') ?>>
                    <?php if ($settings['include_featured'] === 'yes') { ?>

                            <div class="product--gallery--image cr--item swiper-slide featured__<?php echo get_the_ID() ?>" data-cr="1">

                            <?php if ($settings['product_images_zoom'] === 'zoom-outer') {
                                echo '<span class="outer--zoom--follower"></span>';
                            } ?>


                            <?php if ($settings['swiper_parallax'] === 'swiper_parallax') { ?>
                                    <div class="swiper-parallax-wrap">
                                        <div class="slide-bgimg">
                                    <?php } ?>

                                    <?php if ((get_field('product_video') === 'vimeo' || get_field('product_video') === 'youtube' || get_field('product_video') === 'self') && get_field('use_as_featured_media') == true) {
                                        $provider = get_field('product_video');
                                        $video_id = get_field('video_id');
                                        $self_video = get_field('self_hosted_video');
                                        ?>

                                            <div class="saren--product--video">

                                                <div class="pe-video pe-<?php echo esc_attr($provider) ?>" data-controls=false
                                                    data-autoplay=true data-muted=true data-loop=true>

                                                <?php if ($provider === 'self') { ?>
                                                        <video class="p-video" autoplay muted loop playsinline>
                                                            <source src="<?php echo esc_url($self_video['url']); ?>">
                                                        </video>
                                                <?php } else { ?>
                                                        <div class="p-video" data-plyr-provider="<?php echo esc_attr($provider) ?>"
                                                            data-plyr-embed-id="<?php echo esc_attr($video_id) ?>"></div>
                                                <?php } ?>
                                                </div>

                                            </div>

                                    <?php } else {
                                        if ($settings['product_images_zoom'] !== 'no-zoom') {
                                            
                                            echo wp_get_attachment_image(get_post_thumbnail_id(), 'medium_large', false, array(
                                                'class' => 'img--zoom ' . $settings['product_images_zoom'],
                                                'loading' => 'eager',
                                                'fetchpriority' => 'high',
                                            ));
                                        }

                                        echo wp_get_attachment_image(get_post_thumbnail_id(), 'medium_large', false, array(
                                            'loading' => 'eager',
                                            'fetchpriority' => 'high',
                                        ));
                                    }
                                    if ($settings['swiper_parallax'] === 'swiper_parallax') { ?>
                                        </div>
                                    </div>

                            <?php } ?>

                            </div>

                    <?php } ?>

                        <?php
                        foreach ($attachment_ids as $key => $attachment_id) { ?>

                            <div <?php echo $this->get_render_attribute_string('item_attributes') ?>
                                data-cr="<?php echo $settings['include_featured'] === 'yes' ? $key + 1 : $key ?>">

                            <?php if ($settings['product_images_zoom'] === 'zoom-outer') {
                                echo '<span class="outer--zoom--follower"></span>';
                            } ?>

                            <?php if ($settings['swiper_parallax'] === 'swiper_parallax') { ?>
                                    <div class="swiper-parallax-wrap">
                                        <div class="slide-bgimg">
                                    <?php }
                            if ($settings['product_images_zoom'] !== 'no-zoom') {

                                $classs = 'img--zoom ' . $settings['product_images_zoom'];

                                echo wp_get_attachment_image($attachment_id, 'medium_large', false, array(
                                    'class' => $classs,
                                    'loading' => 'eager',
                                    'fetchpriority' => 'high',
                                ));
                            }

                            echo wp_get_attachment_image($attachment_id, 'medium_large', false, array(
                                'loading' => 'eager',
                                'fetchpriority' => 'high',
                            ));

                            if ($settings['swiper_parallax'] === 'swiper_parallax') { ?>
                                        </div>
                                    </div>
                            <?php } ?>
                            </div>

                    <?php } ?>

                    </div>

                </div>

        <?php } else if ($type === 'video') {
            if (get_field('product_video') === 'vimeo' || get_field('product_video') === 'youtube' || get_field('product_video') === 'self') {
                $provider = get_field('product_video');
                $video_id = get_field('video_id');
                $self_video = get_field('self_hosted_video');
                ?>

                        <div class="saren--product--video">

                            <div class="pe-video pe-<?php echo esc_attr($provider) ?>" data-controls=false data-autoplay=true data-muted=true
                                data-loop=true>

                        <?php if ($provider === 'self') { ?>
                                    <video class="p-video" autoplay muted loop playsinline>
                                        <source src="<?php echo esc_url($self_video); ?>">
                                    </video>
                        <?php } else { ?>
                                    <div class="p-video" data-plyr-provider="<?php echo esc_attr($provider) ?>"
                                        data-plyr-embed-id="<?php echo esc_attr($video_id) ?>"></div>
                        <?php } ?>
                            </div>

                        </div>
                <?php
            }
        }

    }

}
