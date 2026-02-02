<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeCarousel extends Widget_Base
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
        return 'pecarousel';
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
        return __('Carousel', 'pe-core');
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
        return 'eicon-slider-push pe-widget';
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


        $productCats = array();

        $args = array(
            'hide_empty' => true,
            'taxonomy' => 'product_cat'
        );

        $categories = get_categories($args);

        foreach ($categories as $key => $category) {
            $productCats[$category->term_id] = $category->name;
        }

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Carousel Content', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'carousel_type',
            [
                'label' => esc_html__('Carousel Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'product',
                'options' => [
                    'portfolio' => esc_html__('Projects', 'pe-core'),
                    'post' => esc_html__('Posts', 'pe-core'),
                    'product' => esc_html__('Products', 'pe-core'),
                    'images' => esc_html__('Images', 'pe-core'),
                    'taxonomy' => esc_html__('Taxonomies', 'pe-core'),
                ],

            ]
        );

        $this->add_control(
            'taxonomy_type',
            [
                'label' => esc_html__('Taxonomy Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'brand',
                'options' => [
                    'product_cat' => esc_html__('Product Categories', 'pe-core'),
                    'product_tag' => esc_html__('Tags', 'pe-core'),
                    'brand' => esc_html__('Brands', 'pe-core'),
                ],
                'condition' => ['carousel_type' => 'taxonomy'],

            ]
        );

        $this->add_control(
            'show_label',
            [
                'label' => esc_html__('Taxonomy Labels', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => "true",
                'default' => "true",
                'condition' => [
                    'carousel_type' => 'taxonomy',
                ],
            ]
        );

        $this->add_control(
            'show_desc',
            [
                'label' => esc_html__('Taxonomy Description', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => "true",
                'default' => "true",
                'condition' => [
                    'carousel_type' => 'taxonomy',
                ],
            ]
        );

        $this->add_control(
            'taxonomy_cat_select',
            [
                'label' => __('Categories', 'pe-core'),
                'description' => __('Select categories.', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $productCats,
                'condition' => [
                    'carousel_type' => 'taxonomy',
                    'taxonomy_type' => 'product_cat',
                ],
            ]
        );
        $cond = ['carousel_type' => 'product'];
        saren_product_query_selection($this, false, $cond);

        $portfolios = [];

        $projects = get_posts([
            'post_type' => 'portfolio',
            'numberposts' => -1
        ]);

        foreach ($projects as $project) {
            $portfolios[$project->ID] = $project->post_title;
        }

        $repeater = new \Elementor\Repeater();


        $repeater->add_control(
            'select_project',
            [
                'label' => __('Select Project', 'pe-core'),
                'label_block' => true,
                'description' => __('Select project which will display in the slider.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $portfolios,
            ]
        );


        $repeater->add_control(
            'custom_thumb_notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>If you apply custom thumbnail for the project, the special page transition animations for this project will no longer work, The default page transition will be triggered.</span></div>',
                'condition' => ['custom_thumb!' => 'none'],
            ]
        );


        $repeater->add_control(
            'custom_thumb',
            [
                'label' => esc_html__('Custom Thumbnail', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'image' => esc_html__('Image', 'pe-core'),
                    'video' => esc_html__('Video', 'pe-core'),
                ],

            ]
        );

        $repeater->add_control(
            'featured_image',
            [
                'label' => esc_html__('Featured Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'custom_thumb' => 'image',
                ]
            ]
        );

        $repeater->add_control(
            'video_provider',
            [
                'label' => esc_html__('Video Provider', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'vimeo',
                'options' => [
                    'self' => esc_html__('Self-Hosted', 'pe-core'),
                    'vimeo' => esc_html__('Vimeo', 'pe-core'),
                    'youtube' => esc_html__('YouTube', 'pe-core'),
                ],
                'condition' => [
                    'custom_thumb' => 'video',
                ]
            ]
        );

        $repeater->add_control(
            'video_id',
            [
                'label' => esc_html__('Video ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'condition' => [
                    'video_provider!' => 'self',
                    'custom_thumb' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'self_video',
            [
                'label' => esc_html__('Self-Hosted Video', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'video_provider' => 'self',
                    'custom_thumb' => 'video',
                ]
            ]
        );


        $this->add_control(
            'projects_list',
            [
                'label' => esc_html__('Projects', 'pe-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => false,
                'condition' => ['carousel_type' => 'portfolio'],
            ]
        );


        $this->add_control(
            'cat',
            [
                'label' => esc_html__('Category', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",
                'condition' => ['carousel_type' => 'portfolio']
            ]
        );

        $this->add_control(
            'title_pos',
            [
                'label' => esc_html__('Title Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'column-reverse' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'column' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'column',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} article' => 'flex-direction: {{VALUE}};',
                ],
                'condition' => ['carousel_type' => 'portfolio']
            ]
        );

        $this->add_control(
            'carousel_images',
            [
                'label' => esc_html__('Add Images', 'pe-core'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'show_label' => false,
                'default' => [],
                'condition' => ['carousel_type' => 'images'],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'product_settings',
            [
                'label' => esc_html__('Products Settings', 'pe-core'),
                'condition' => ['carousel_type' => 'product'],
            ]
        );

        pe_product_controls($this);

        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_settings',
            [
                'label' => esc_html__('Carousel Settings', 'pe-core'),
            ]
        );


        $this->add_control(
            'carousel_id',
            [
                'label' => esc_html__('Carousel ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('An id will required if the carousel controls from other widgets will be used.', 'pe-core'),
                'ai' => false,
            ]
        );


        $this->add_control(
            'carousel_behavior',
            [
                'label' => esc_html__('Carousel Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cr--drag',
                'options' => [
                    'cr--drag' => esc_html__('Drag', 'pe-core'),
                    'cr--scroll' => esc_html__('Scroll', 'pe-core'),
                    'cr--loop--autoplay' => esc_html__('Looped Autoplay', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'loop_direction',
            [
                'label' => esc_html__('Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left-to-right' => [
                        'title' => esc_html__('Left To Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'right-to-left' => [
                        'title' => esc_html__('Right To Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                ],
                'default' => 'left-to-right',
                'toggle' => true,
                'label_block' => true,
                'condition' => [
                    'carousel_behavior' => 'cr--loop--autoplay'
                ]
            ]
        );


        $this->add_control(
            'loop_speed',
            [
                'label' => esc_html__('Speed', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 30,
                'condition' => [
                    'carousel_behavior' => 'cr--loop--autoplay'
                ]
            ]
        );

        $this->add_control(
            'loop_speed_up',
            [
                'label' => esc_html__('Speed Up On Scroll', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'true',
                'condition' => [
                    'carousel_behavior' => 'cr--loop--autoplay'
                ]
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'prefix_class' => '',
                'return_value' => 'pause--on--hover',
                'render_type' => 'template',
                'default' => 'pause--on--hover',
                'condition' => [
                    'carousel_behavior' => 'cr--loop--autoplay'
                ]
            ]
        );


        $this->add_control(
            'carousel_trigger',
            [
                'label' => esc_html__('Carousel Trigger', 'pe-core'),
                'placeholder' => esc_html__('Eg. #worksContainer', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('Normally the carousel pin itself but in some cases, a custom trigger may required.', 'pe-core'),
                'ai' => false,
                'condition' => ['carousel_behavior' => 'cr--scroll'],
            ]
        );

        $this->add_responsive_control(
            'items_width',
            [
                'label' => esc_html__('Items Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .carousel--wrapper' => '--itemsWidth: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_height',
            [
                'label' => esc_html__('Items Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', 'vh', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .carousel--item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_gapo',
            [
                'label' => esc_html__('Space Between Items', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .carousel--wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_pos',
            [
                'label' => esc_html__('Items Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'pe-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .carousel--wrapper' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'equal_height',
            [
                'label' => esc_html__('Custom Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',
                'prefix_class' => "eq--height--"
            ]
        );

        $this->add_responsive_control(
            'item_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .thmb' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .single-image' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .saren--product--image' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'equal_height' => 'yes'
                ],
            ]
        );


        // $this->add_control(
        //     'parallax',
        //     [
        //         'label' => esc_html__('Parallax Images', 'pe-core'),
        //         'type' => \Elementor\Controls_Manager::SWITCHER,
        //         'label_on' => esc_html__('Yes', 'pe-core'),
        //         'label_off' => esc_html__('No', 'pe-core'),
        //         'return_value' => 'parallax--images',
        //         'render_type' => 'template',
        //         'prefix_class' => '',
        //         'default' => '',
        //     ]
        // );



        $this->end_controls_section();

        pe_cursor_settings($this, true);

        $this->start_controls_section(
            'section_animate',
            [
                'label' => __('Animations', 'pe-core'),
            ]
        );

        $this->add_control(
            'select_animation',
            [
                'label' => esc_html__('Select Animation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'description' => esc_html__('Will be used as intro animation.', 'pe-core'),
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'fadeIn' => esc_html__('Fade In', 'pe-core'),
                    'fadeUp' => esc_html__('Fade Up', 'pe-core'),
                    'fadeDown' => esc_html__('Fade Down', 'pe-core'),
                    'fadeLeft' => esc_html__('Fade Left', 'pe-core'),
                    'fadeRight' => esc_html__('Fade Right', 'pe-core'),
                    'slideUp' => esc_html__('Slide Up', 'pe-core'),
                    'slideLeft' => esc_html__('Slide Left', 'pe-core'),
                    'slideRight' => esc_html__('Slide Right', 'pe-core'),
                    'scaleUp' => esc_html__('Scale Up', 'pe-core'),
                    'scaleDown' => esc_html__('Scale Down', 'pe-core'),
                    'maskUp' => esc_html__('Mask Up', 'pe-core'),
                    'maskDown' => esc_html__('Mask Down', 'pe-core'),
                    'maskLeft' => esc_html__('Mask Left', 'pe-core'),
                    'maskRight' => esc_html__('Mask Right', 'pe-core'),

                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'more_options',
            [
                'label' => esc_html__('Animation Options', 'pe-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs(
            'animation_options_tabs'
        );

        $this->start_controls_tab(
            'basic_tab',
            [
                'label' => esc_html__('Basic', 'pe-core'),
            ]
        );

        $this->add_control(
            'duration',
            [
                'label' => esc_html__('Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'step' => 0.1,
                'default' => 1.5
            ]
        );

        $this->add_control(
            'delay',
            [
                'label' => esc_html__('Delay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 0.1,
                'default' => 0
            ]
        );

        $this->add_control(
            'stagger',
            [
                'label' => esc_html__('Stagger', 'pe-core'),
                'description' => esc_html__('Delay between animated elements (for multiple element animation types)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.01,
                'default' => 0.1,
            ]
        );


        $this->add_control(
            'scrub',
            [
                'label' => esc_html__('Scrub', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
                'description' => esc_html__('Animation will follow scrolling behavior of the page.', 'pe-core'),
            ]
        );

        $this->add_control(
            'pin',
            [
                'label' => esc_html__('Pin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
                'description' => esc_html__('Animation will be pinned to window during animation.', 'pe-core'),
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'advanced_tab',
            [
                'label' => esc_html__('Advanced', 'pe-core'),
            ]
        );

        $this->add_control(
            'show_markers',
            [
                'label' => esc_html__('Markers', 'pe-core'),
                'description' => esc_html__('Shows (only in editor) animation start and end points and adjust them.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'default' => 'false',
                'return_value' => 'true',

            ]
        );

        $this->add_control(
            'anim_start',
            [
                'label' => esc_html__('Animation Start Point', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'description' => esc_html__('Animation will be triggered when the element enters the desired point of the view.', 'pe-core'),
                'options' => [
                    'top top' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-v-align-middle'
                    ],
                    'top bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => ' eicon-v-align-bottom',
                    ],
                ],
                'default' => 'top bottom',
                'toggle' => false,
            ]
        );

        $this->add_control(
            'start_offset',
            [
                'label' => esc_html__('Start Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
            ]
        );

        $this->add_control(
            'anim_end',
            [
                'label' => esc_html__('Animation End Point', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'description' => esc_html__('Animation will be end when the element enters the desired point of the view. (For scrubbed/pinned animations)', 'pe-core'),
                'options' => [
                    'bottom bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'center center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-v-align-middle'
                    ],
                ],
                'default' => 'bottom bottom',
                'toggle' => false,
            ]
        );


        $this->add_control(
            'end_offset',
            [
                'label' => esc_html__('End Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
            ]
        );


        $this->add_control(
            'pin_target',
            [
                'label' => esc_html__('Pin Target', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Eg: #container2', 'pe-core'),
                'description' => esc_html__('You can enter a container id/class which the element will be pinned during animation.', 'pe-core'),

            ]
        );

        $this->add_control(
            'animate_out',
            [
                'label' => esc_html__('Animate Out', 'pe-core'),
                'description' => esc_html__('Animation will be played backwards when leaving from viewport. (For scrubbed/pinned animations)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'default' => 'false',
                'return_value' => 'true',

            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'products_additonal',
            [
                'label' => esc_html__('Additional Options', 'pe-core'),
                'condition' => ['carousel_type' => 'product']
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


        $this->end_controls_section();

        $cond = ['carousel_type' => 'product'];
        pe_product_styles($this, $cond);


        $this->start_controls_section(
            'carousel_image_styles',
            [

                'label' => esc_html__('Image Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['carousel_type' => 'images'],
            ]
        );

        $cond = ['carousel_type' => 'images'];

        objectStyles($this, 'carousel_images_', 'Images', '.single-image', false, $cond, false);



        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_styles',
            [

                'label' => esc_html__('Carousel Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $taxCond = ['carousel_type' => 'taxonomy'];

        objectStyles($this, 'taxonomy_images', 'Taxonomy Images', '.pe--styled--object', false, $taxCond, false);


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'carousel_borders',
                'label' => esc_html__('Carousel Borders', 'pe-core'),
                'selector' => '{{WRAPPER}} .carousel--wrapper',
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'iamge__filters',
                'selector' => '{{WRAPPER}} img',
            ]
        );

        $this->add_responsive_control(
            'tax_images_width',
            [
                'label' => esc_html__('Taxonomy Images Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'rem', 'em', 'custom'],
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
                    '{{WRAPPER}} .carousel--item.cr--item.cr--taxonomy--brand a img, {{WRAPPER}} .carousel--item.cr--taxonomy--product_cat a img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['carousel_type' => 'taxonomy'],
            ]
        );

        $this->add_responsive_control(
            'tax_images_height',
            [
                'label' => esc_html__('Taxonomy Images Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'rem', 'em', 'custom'],
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
                    '{{WRAPPER}} .carousel--item.cr--item.cr--taxonomy--brand a img, {{WRAPPER}} .carousel--item.cr--taxonomy--product_cat a img' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['carousel_type' => 'taxonomy'],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cr_title_typography',
                'label' => esc_html__('Title', 'pe-core'),
                'selector' => '{{WRAPPER}} .carousel--item .post-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cr_descs_typography',
                'label' => esc_html__('Descriptions', 'pe-core'),
                'selector' => '{{WRAPPER}} .carousel--term--desc p',
            ]
        );


        $this->add_responsive_control(
            'cr_descs_alignment',
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
                    '{{WRAPPER}} .carousel--term--desc' => 'text-align: {{VALUE}};',
                ],

            ]
        );


        objetAbsolutePositioning($this, '.carousel--term--name', 'term_name', 'Label');


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cr_at_typography',
                'label' => esc_html__('Category', 'pe-core'),
                'selector' => '{{WRAPPER}} .carousel--term--name',
            ]
        );

        $this->add_control(
            'cats_padding',
            [
                'label' => esc_html__('Category Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                // 'default' => [
                //     'top' => 0.5,
                //     'right' => 1,
                //     'bottom' => 0.5,
                //     'left' => 1,
                //     'unit' => 'em',
                //     'isLinked' => false
                // ],
                'selectors' => [
                    '{{WRAPPER}} .carousel--item .post-meta .post-categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'cats_radius',
            [
                'label' => esc_html__('Category Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                // 'default' => [
                //     'top' => 50,
                //     'right' => 50,
                //     'bottom' => 50,
                //     'left' => 50,
                //     'unit' => 'px',
                //     'isLinked' => true
                // ],
                'selectors' => [
                    '{{WRAPPER}} .carousel--item.pe--styled--object' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'images_radius',
            [
                'label' => esc_html__('Images Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .carousel--item .single-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}'
                ]
            ]
        );


        $this->end_controls_section();


        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings();
        $type = $settings['carousel_type'];
        $carouselClasses = [];


        $carouselId = $settings['carousel_id'] ? $settings['carousel_id'] : 'cr--' . $this->get_id();


        array_push($carouselClasses, ['pe--carousel', 'cr--' . $settings['carousel_type'], $settings['carousel_behavior']]);
        $mainClasses = implode(' ', array_filter($carouselClasses[0]));

        $this->add_render_attribute(
            'loop_attributes',
            [
                'data-direction' => $settings['loop_direction'],
                'data-speed' => $settings['loop_speed'],
                'data-speed-up' => $settings['loop_speed_up'],

            ]
        );
        $loopSettings = $settings['carousel_behavior'] === 'cr--loop--autoplay' ? $this->get_render_attribute_string('loop_attributes') : '';
        $cursor = pe_cursor($this);

        ?>

        <div class="<?php echo $mainClasses; ?>" data-trigger='<?php echo $settings['carousel_trigger'] ?>'>

            <div class="carousel--wrapper <?php echo esc_attr($carouselId) ?> cr--drag anim-multiple pinned__anim" <?php echo $loopSettings; ?>>

                <?php if ($type === 'portfolio') {


                    foreach ($settings['projects_list'] as $key => $project) {

                        $id = $project['select_project'];
                        $category = $settings['cat'];

                        $classes = [];

                        $customThumb = $project['custom_thumb'] !== 'none' ? 'custom__thumb' : '';
                        $classes[] = 'pe--single--project psp--elementor ' . $customThumb . '';

                        if ($project['custom_thumb'] !== 'none') {

                            $custom = [
                                'type' => $project['custom_thumb'],
                                'provider' => $project['video_provider'],
                                'imageUrl' => $project['featured_image'],
                                'videoUrl' => $project['self_video'],
                                'videoId' => $project['video_id']
                            ];

                        } else {

                            $custom = false;
                        }
                        ?>

                        <!-- Carusel Item -->
                        <div class="carousel--item inner--anim" data-index="<?php echo esc_attr($key) ?>">

                            <article id="post-<?php the_ID($id); ?>" <?php post_class($classes, $id); ?>                 <?php echo $cursor ?>>

                                <a class="barba--trigger" data-id="<?php echo esc_attr($id) ?>"
                                    href="<?php echo esc_url(get_permalink($id)) ?>" <?php echo $cursor ?>>
                                    <div class="thmb project__image__<?php echo $id ?>">

                                        <?php pe_project_image($id, $custom, true); ?>

                                    </div>

                                </a>




                                <!-- Post Details -->
                                <div class="post-details">

                                    <!-- Title -->
                                    <a href="<?php echo esc_url(get_permalink($id)) ?>" <?php echo $cursor ?>>

                                        <?php echo '<h6 class="post-title entry-title">' . get_the_title($id) . '</h6>'; ?>

                                    </a>
                                    <!--/ Title -->

                                    <!-- Meta -->
                                    <div class="post-meta">

                                        <?php if ($category) { ?>

                                            <div class="post-categories">
                                                <?php

                                                $terms = get_the_terms($id, 'project-categories');
                                                if ($terms) {

                                                    $term_names = array();

                                                    foreach ($terms as $term) {
                                                        $term_names[] = $term->name;
                                                    }

                                                    $cats = implode(', ', $term_names);
                                                    echo $cats;
                                                }

                                                ?>
                                            </div>

                                        <?php } ?>

                                    </div>
                                    <!--/ Meta -->


                                </div>
                                <!--/ Post Details -->

                            </article>

                        </div>
                        <!--/ Carusel Item -->


                    <?php }
                } else if ($type === 'product') {

                    $the_query = new \WP_Query(saren_product_query_args(($this)));

                    while ($the_query->have_posts()):
                        $the_query->the_post();
                        $classes = 'saren--single--product cr--item carousel--item ' . $settings['product_style'];

                        sarenProductRender($settings, wc_get_product(), $classes, $cursor);

                    endwhile;
                    wp_reset_query(); ?>

                <?php } else if ($type === 'taxonomy') {

                    $taxType = $settings['taxonomy_type'];

                    if ($taxType === 'product_cat' && !empty($settings['taxonomy_cat_select'])) {

                        $postsIn = $settings['taxonomy_cat_select'];

                    } else {
                        $postsIn = false;
                    }

                    $terms = get_terms(array(
                        'taxonomy' => $taxType,
                        'hide_empty' => true,
                        'include' => $postsIn
                    ));

                    foreach ($terms as $key => $term) {

                        $name = $term->name;
                        if ($settings['taxonomy_type'] === 'brand') {

                            if (get_field('brand_image', $term)) {
                                $image_id = get_field('brand_image', $term)['ID'];
                                $image = wp_get_attachment_image($image_id, 'medium', false, array(
                                ));
                            } else {
                                $image = false;
                            }


                        } else if ($settings['taxonomy_type'] === 'product_cat') {

                            $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                            $image = wp_get_attachment_image($thumbnail_id, 'medium', false, array(
                            ));

                        }
                        ?>
                                <!-- Carusel Item -->
                                <div class="carousel--item pe--styled--object cr--item cr--taxonomy--<?php echo $settings['taxonomy_type'] ?> term_<?php echo $term->term_id ?>"
                                    data-index="<?php echo esc_attr($key) ?>">

                            <?php if ($image) {

                                echo '<a href="' . get_term_link($term) . '" ' . $cursor . '>' . $image;

                                if ($settings['show_label']) {
                                    echo '<span class="carousel--term--name">' . $name . '</span>';
                                }

                                if ($settings['show_desc']) {
                                    echo '<span class="carousel--term--desc">' . term_description($term) . '</span>';
                                }

                                echo '</a>';

                            } else {
                                echo '<a href="' . get_the_permalink($term) . '"><span class="carousel--term--name">' . $name . '</span></a>';
                            } ?>
                                </div>
                                <!--/ Carusel Item -->
                        <?php

                    }

                } ?>

                <?php

                if ($type === 'images') {

                    foreach ($settings['carousel_images'] as $key => $image) {
                        $key++ ?>

                        <!-- Carusel Item -->
                        <div class="carousel--item" data-index="<?php echo esc_attr($key) ?>">

                            <div class="single-image"><img src="<?php echo esc_url($image['url']) ?>"></div>

                        </div>
                        <!--/ Carusel Item -->

                    <?php }
                } ?>

            </div>

        </div>

        <?php
    }

}