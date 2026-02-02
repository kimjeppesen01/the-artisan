<?php


function pe_general_animation_settings($widget, $tab = false, $container = false)
{


    $widget->start_controls_section(
        'section_animate',
        [
            'label' => __('Animations', 'pe-core'),
            'tab' => $tab,
        ]
    );


    $widget->add_control(
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


    $widget->add_control(
        'gen_start_scale',
        [
            'label' => esc_html__('Start Scale', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 5,
            'step' => 0.1,
            'default' => 0,
            'condition' => [
                'select_animation' => ['scaleUp', 'scaleDown'],
            ],

        ]
    );

    $widget->add_control(
        'gen_end_scale',
        [
            'label' => esc_html__('End Scale', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 1,
            'step' => 0.1,
            'default' => 1,
            'condition' => [
                'select_animation' => ['scaleUp', 'scaleDown'],
            ],

        ]
    );

    $widget->add_control(
        'view',
        [
            'label' => esc_html__('View', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HIDDEN,
            'default' => 'animated',
            'prefix_class' => 'will__',
            'condition' => ['select_animation!' => 'none'],
        ]
    );

    $widget->add_control(
        'more_options',
        [
            'label' => esc_html__('Animation Options', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $widget->start_controls_tabs(
        'animation_options_tabs'
    );

    $widget->start_controls_tab(
        'basic_tab',
        [
            'label' => esc_html__('Basic', 'pe-core'),
        ]
    );

    $widget->add_control(
        'duration',
        [
            'label' => esc_html__('Duration', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0.1,
            'step' => 0.1,
            'default' => 1.5
        ]
    );

    $widget->add_control(
        'delay',
        [
            'label' => esc_html__('Delay', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'step' => 0.1,
            'default' => 0
        ]
    );

    $widget->add_control(
        'stagger',
        [
            'label' => esc_html__('Stagger', 'pe-core'),
            'description' => esc_html__('Delay between animated elements (for multiple element animation types)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => -5,
            'max' => 5,
            'step' => 0.01,
            'default' => 0.1,
        ]
    );


    $widget->add_control(
        'scrub',
        [
            'label' => esc_html__('Scrub', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'prefix_class' => 'scrubbed__',
            'default' => 'false',
            'description' => esc_html__('Animation will follow scrolling behavior of the page.', 'pe-core'),
        ]
    );

    $widget->add_control(
        'pin',
        [
            'label' => esc_html__('Pin', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'prefix_class' => 'pinned__',
            'default' => 'false',
            'description' => esc_html__('Animation will be pinned to window during animation.', 'pe-core'),
        ]
    );

    $widget->add_control(
        'mobile_pin',
        [
            'label' => esc_html__('Pin Mobile Devices', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'prefix_class' => 'mobile__pin__',
            'default' => 'false',
            'condition' => [
                'pin' => 'true',
            ],
            'description' => esc_html__('Pinning large sections/containers at mobile devices may cause issues.', 'pe-core'),
        ]
    );

    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'advanced_tab',
        [
            'label' => esc_html__('Advanced', 'pe-core'),
        ]
    );

    $widget->add_control(
        'pinned_target',
        [
            'label' => esc_html__('Pin Target', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Eg: #container2', 'pe-core'),
            'description' => esc_html__('You can enter a container id/class which the element will be pinned during animation.', 'pe-core'),

        ]
    );


    $widget->add_control(
        'start_references',
        [
            'label' => esc_html__('Start References', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'references_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>	
	           This references below are adjusts the animation start/end positions on the screen. <b>For Example: If you select <u>'Top' for item reference point</u> and <u>'Bottom' for the window reference point</u>; animation will start when item's top edge enters the window's bottom edge.</b></div>",


        ]
    );

    $widget->add_control(
        'item_ref_start',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
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
            'default' => 'top',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_start',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
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
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'end_references',
        [
            'label' => esc_html__('End References', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'end_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>For scrubbed/pinned animations only.</div>",
        ]
    );

    $widget->add_control(
        'item_ref_end',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
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
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_end',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
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
            'default' => 'top',
            'toggle' => false,
        ]
    );



    $widget->add_control(
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

    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();

}

function pe_general_animation($widget)
{

    $settings = $widget->get_settings_for_display();

    $out = $settings['animate_out'] ? $settings['animate_out'] : 'false';

    $dataset = '{' .
        'duration=' . $settings['duration'] . '' .
        ';delay=' . $settings['delay'] . '' .
        ';stagger=' . $settings['stagger'] . '' .
        ';pin=' . $settings['pin'] . '' .
        ';mobilePin=' . $settings['mobile_pin'] . '' .
        ';pinTarget=' . $settings['pinned_target'] . '' .
        ';scrub=' . $settings['scrub'] . '' .
        ';item_ref_start=' . $settings['item_ref_start'] . '' .
        ';window_ref_start=' . $settings['window_ref_start'] . '' .
        ';item_ref_end=' . $settings['item_ref_end'] . '' .
        ';window_ref_end=' . $settings['window_ref_end'] . '' .
        ';out=' . $out . '' .
        '}';

    $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';

    //Scroll Button Attributes
    $widget->add_render_attribute(
        'animation_settings',
        [
            'data-anim-general' => 'true',
            'data-animation' => $animation,
            'data-settings' => $dataset,

        ]
    );

    $animationSettings = $settings['select_animation'] !== 'none' ? $widget->get_render_attribute_string('animation_settings') : '';
    return $animationSettings;

}

function pe_image_animation_settings($widget)
{

    $widget->start_controls_section(
        'section_animate',
        [
            'label' => __('Animations', 'pe-core'),
        ]
    );

    $widget->add_control(
        'select_animation',
        [
            'label' => esc_html__('Select Animation', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'none',
            'description' => esc_html__('Will be used as intro animation.', 'pe-core'),
            'options' => [
                'none' => esc_html__('None', 'pe-core'),
                'scale' => esc_html__('Scale', 'pe-core'),
                'block' => esc_html__('Block', 'pe-core'),
                'mask' => esc_html__('Mask', 'pe-core'),

            ],
            'label_block' => true,
        ]
    );

    $widget->add_control(
        'mask_type',
        [
            'label' => esc_html__('Mask Type', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'square',
            'options' => [
                'square' => esc_html__('Square', 'pe-core'),
                'circle' => esc_html__('Circle', 'pe-core'),
                'triangle' => esc_html__('Triangle', 'pe-core'),
                'rhombus' => esc_html__('Rhombus', 'pe-core'),
                'hexagon' => esc_html__('Hexagon', 'pe-core'),
                'left_arrow' => esc_html__('Left Arrow', 'pe-core'),
                'right_arrow' => esc_html__('Right Arrow', 'pe-core'),
                'left_chevron' => esc_html__('Left Chevron', 'pe-core'),
                'right_chevron' => esc_html__('Right Chevron', 'pe-core'),
                'star' => esc_html__('Star', 'pe-core'),
                'close' => esc_html__('Close', 'pe-core'),
            ],
            'label_block' => true,
            'condition' => [
                'select_animation' => 'mask',
            ]
        ]
    );

    $widget->add_control(
        'square_mask_start',
        [
            'label' => esc_html__('Start Mask', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['%'],
            'default' => [
                'top' => 10,
                'right' => 20,
                'bottom' => 23,
                'left' => 50,
                'unit' => '%',
                'isLinked' => false,
            ],
            'condition' => [
                'mask_type' => 'square',
                'select_animation' => 'mask',
            ]
        ]
    );

    $widget->add_control(
        'square_mask_end',
        [
            'label' => esc_html__('End Mask', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['%'],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => '%',
                'isLinked' => false,
            ],
            'condition' => [
                'mask_type' => 'square',
                'select_animation' => 'mask',
            ]
        ]
    );

    $widget->add_control(
        'square_mask_radius',
        [
            'label' => esc_html__('Square Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'condition' => [
                'mask_type' => 'square',
                'select_animation' => 'mask',
            ]
        ]
    );



    $widget->start_controls_tabs(
        'circle_tabs',
        [
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]

    );

    $widget->start_controls_tab(
        'circle_start_tab',
        [
            'label' => esc_html__('Start', 'pe-core'),
        ]
    );

    $widget->add_responsive_control(
        'circle_size_start',
        [
            'label' => esc_html__('Circle Size', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
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
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );

    $widget->add_responsive_control(
        'circle_top_pos_start',
        [
            'label' => esc_html__('Circle Top Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
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
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );

    $widget->add_responsive_control(
        'circle_left_pos_start',
        [
            'label' => esc_html__('Circle Left Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
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
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );


    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'circle_end_tab',
        [
            'label' => esc_html__('End', 'pe-core'),
        ]
    );

    $widget->add_responsive_control(
        'circle_size_end',
        [
            'label' => esc_html__('Circle Size', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
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
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );

    $widget->add_responsive_control(
        'circle_top_pos_end',
        [
            'label' => esc_html__('Circle Top Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
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
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );

    $widget->add_responsive_control(
        'circle_left_pos_end',
        [
            'label' => esc_html__('Circle Left Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
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
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );


    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->add_control(
        'transform_origin',
        [
            'label' => esc_html__('Animation Origin', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top left' => [
                    'title' => esc_html__('Top Left', 'pe-core'),
                    'icon' => 'material-icons md-north_west',
                ],
                'top center' => [
                    'title' => esc_html__('Top Center', 'pe-core'),
                    'icon' => 'material-icons md-north'
                ],
                'top right' => [
                    'title' => esc_html__('Top Right', 'pe-core'),
                    'icon' => 'material-icons md-north_east',
                ],
                'left center' => [
                    'title' => esc_html__('Left', 'pe-core'),
                    'icon' => 'material-icons md-west',
                ],
                'center center' => [
                    'title' => esc_html__('Center Center', 'pe-core'),
                    'icon' => 'material-icons md-filter_center_focus',
                ],
                'right center' => [
                    'title' => esc_html__('Right', 'pe-core'),
                    'icon' => 'material-icons md-east',
                ],
                'bottom left' => [
                    'title' => esc_html__('Bottom Left', 'pe-core'),
                    'icon' => 'material-icons md-south_west',
                ],
                'bottom center' => [
                    'title' => esc_html__('Bottom Center', 'pe-core'),
                    'icon' => 'material-icons md-south'
                ],
                'bottom right' => [
                    'title' => esc_html__('Bottom Right', 'pe-core'),
                    'icon' => 'material-icons md-south_east',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .single-image[data-anim-image=true]' => 'transform-origin: {{VALUE}};',
                '{{WRAPPER}} .single-image[data-anim-image=true] img' => 'transform-origin: {{VALUE}};',
            ],
            'default' => 'center center',
            'label_block' => true,
            'toggle' => false,
            'condition' => [
                'select_animation' => 'scale',
            ]
        ]
    );

    $widget->add_control(
        'start_scale',
        [
            'label' => esc_html__('Start Scale', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 100,
            'step' => 0.1,
            'default' => 0,
            'condition' => [
                'select_animation' => 'scale',
            ]

        ]
    );

    $widget->add_control(
        'end_scale',
        [
            'label' => esc_html__('End Scale', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 100,
            'step' => 0.1,
            'default' => 1,
            'condition' => [
                'select_animation' => 'scale',
            ]

        ]
    );

    $widget->add_control(
        'block_direction',
        [
            'label' => esc_html__('Image Type', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'up' => esc_html__('Up', 'pe-core'),
                'down' => esc_html__('Down', 'pe-core'),
                'left' => esc_html__('Left', 'pe-core'),
                'right' => esc_html__('Right', 'pe-core'),
            ],
            'default' => 'up',
            'condition' => [
                'select_animation' => 'block',
            ],
            'label_block' => true
        ]
    );

    $widget->add_control(
        'block_color',
        [
            'label' => esc_html__('Block Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .single-image[data-animation=block]::after' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'select_animation' => 'block',
            ],
        ]
    );


    $widget->add_control(
        'inner_scale',
        [
            'label' => esc_html__('Inner Scale', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'true',
        ]
    );

    $widget->add_control(
        'ia_more_options',
        [
            'label' => esc_html__('Animation Options', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $widget->start_controls_tabs(
        'animation_options_tabs'
    );

    $widget->start_controls_tab(
        'basic_tab',
        [
            'label' => esc_html__('Basic', 'pe-core'),
        ]
    );

    $widget->add_control(
        'duration',
        [
            'label' => esc_html__('Duration', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0.1,
            'step' => 0.1,
            'default' => 1.5
        ]
    );

    $widget->add_control(
        'delay',
        [
            'label' => esc_html__('Delay', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'step' => 0.1,
            'default' => 0
        ]
    );

    $widget->add_control(
        'stagger',
        [
            'label' => esc_html__('Stagger', 'pe-core'),
            'description' => esc_html__('Delay between animated elements (for multiple element animation types)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'step' => 0.01,
            'default' => 0.1,
        ]
    );


    $widget->add_control(
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

    $widget->add_control(
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

    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'advanced_tab',
        [
            'label' => esc_html__('Advanced', 'pe-core'),
        ]
    );


    $widget->add_control(
        'anim_pin_target',
        [
            'label' => esc_html__('Pin Target', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Eg: #container2', 'pe-core'),
            'description' => esc_html__('You can enter a container id/class which the element will be pinned during animation.', 'pe-core'),

        ]
    );


    $widget->add_control(
        'start_references',
        [
            'label' => esc_html__('Start References', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'references_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>	
	           This references below are adjusts the animation start/end positions on the screen. <b>For Example: If you select <u>'Top' for item reference point</u> and <u>'Bottom' for the window reference point</u>; animation will start when item's top edge enters the window's bottom edge.</b></div>",


        ]
    );

    $widget->add_control(
        'item_ref_start',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
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
            'default' => 'top',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_start',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
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
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'end_references',
        [
            'label' => esc_html__('End References', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'end_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>For scrubbed/pinned animations only.</div>",
        ]
    );

    $widget->add_control(
        'item_ref_end',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
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
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_end',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
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
            'default' => 'top',
            'toggle' => false,
        ]
    );


    $widget->add_control(
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


    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();


}

function pe_image_animation($widget)
{

    $settings = $widget->get_settings_for_display();

    $out = $settings['animate_out'] ? $settings['animate_out'] : 'false';


    if ($settings['mask_type'] === 'square') {

        $squareStart = ';square_start=inset(' . $settings['square_mask_start']['top'] . '% ' . $settings['square_mask_start']['right'] . '% ' . $settings['square_mask_start']['bottom'] . '% ' . $settings['square_mask_start']['left'] . '% ' . 'round ' . $settings['square_mask_radius'] . 'px)';

        $squareEnd = ';square_end=inset(' . $settings['square_mask_end']['top'] . '% ' . $settings['square_mask_end']['right'] . '% ' . $settings['square_mask_end']['bottom'] . '% ' . $settings['square_mask_end']['left'] . '% ' . 'round ' . $settings['square_mask_radius'] . 'px)';

    } else {

        $squareStart = '';
        $squareEnd = '';
    }


    if ($settings['mask_type'] === 'circle') {

        $circleStart = ';circle_start=circle(' . $settings['circle_size_start']['size'] . '% at ' . $settings['circle_left_pos_start']['size'] . '% ' . $settings['circle_top_pos_start']['size'] . '%)';

        $circleEnd = ';circle_end=circle(' . $settings['circle_size_end']['size'] . '% at ' . $settings['circle_left_pos_end']['size'] . '% ' . $settings['circle_top_pos_end']['size'] . '%)';

    } else {

        $circleStart = '';
        $circleEnd = '';
    }


    $dataset = '{' .
        'duration=' . $settings['duration'] . '' .
        ';delay=' . $settings['delay'] . '' .
        ';stagger=' . $settings['stagger'] . '' .
        ';pin=' . $settings['pin'] . '' .
        ';pinTarget=' . $settings['anim_pin_target'] . '' .
        ';scrub=' . $settings['scrub'] . '' .
        ';item_ref_start=' . $settings['item_ref_start'] . '' .
        ';window_ref_start=' . $settings['window_ref_start'] . '' .
        ';item_ref_end=' . $settings['item_ref_end'] . '' .
        ';window_ref_end=' . $settings['window_ref_end'] . '' .
        ';out=' . $out . '' .
        ';start_scale=' . $settings['start_scale'] . '' .
        ';end_scale=' . $settings['end_scale'] . '' .
        ';inner_scale=' . $settings['inner_scale'] . '' .
        ';block_direction=' . $settings['block_direction'] . '' .
        ';mask_start=' . $settings['mask_type'] . '' . $squareStart . $squareEnd . $circleStart . $circleEnd .
        '}';



    $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';

    //Scroll Button Attributes
    $widget->add_render_attribute(
        'animation_settings',
        [
            'data-anim-image' => 'true',
            'data-animation' => $animation,
            'data-animation-direction' => $settings['block_direction'],
            'data-settings' => $dataset,

        ]
    );

    $animationSettings = $settings['select_animation'] !== 'none' ? $widget->get_render_attribute_string('animation_settings') : '';

    return $animationSettings;



}

function pe_text_animation_settings($widget, $multiple = false)
{


    $widget->start_controls_section(
        'section_animate',
        [
            'label' => __('Animations', 'pe-core'),
        ]
    );

    $widget->add_control(
        'insert2_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>"Line" based animations deprecated because of inserted elements.</span></div>',
            'condition' => ['additional' => 'insert'],
        ]
    );

    $widget->add_control(
        'dynamic2_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>Scrubbing/pinning deprecated because of the dynamic word.</span></div>',
            'condition' => ['additional' => 'dynamic'],
        ]
    );

    $widget->add_control(
        'select_animation',
        [
            'label' => esc_html__('Select Animation', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'none',
            'description' => esc_html__('Will be used as intro animation.', 'pe-core'),
            'options' => [
                'none' => esc_html__('None', 'pe-core'),
                'charsUp' => esc_html__('Chars Up', 'pe-core'),
                'charsDown' => esc_html__('Chars Down', 'pe-core'),
                'charsRight' => esc_html__('Chars Right', 'pe-core'),
                'charsLeft' => esc_html__('Chars Left', 'pe-core'),
                'wordsUp' => esc_html__('Words Up', 'pe-core'),
                'wordsDown' => esc_html__('Words Down', 'pe-core'),
                'linesUp' => esc_html__('Lines Up', 'pe-core'),
                'linesDown' => esc_html__('Lines Down', 'pe-core'),
                'charsScaleUp' => esc_html__('Chars Scale Up', 'pe-core'),
                'charsScaleDown' => esc_html__('Chars Scale Down', 'pe-core'),
                'charsFlipUp' => esc_html__('Chars Flip Up', 'pe-core'),
                'charsFlipDown' => esc_html__('Chars Flip Down', 'pe-core'),
                'linesMask' => esc_html__('Lines Mask', 'pe-core'),
                'linesHighlight' => esc_html__('Highlight Lines', 'pe-core'),
            ],
            'label_block' => true,
        ]
    );

    $widget->add_control(
        'more_options',
        [
            'label' => esc_html__('Animation Options', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $widget->start_controls_tabs(
        'animation_options_tabs'
    );

    $widget->start_controls_tab(
        'basic_tab',
        [
            'label' => esc_html__('Basic', 'pe-core'),
        ]
    );

    $widget->add_control(
        'duration',
        [
            'label' => esc_html__('Duration', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0.1,
            'step' => 0.1,
            'default' => 1.5
        ]
    );

    $widget->add_control(
        'delay',
        [
            'label' => esc_html__('Delay', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'step' => 0.1,
            'default' => 0
        ]
    );

    $widget->add_control(
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


    $widget->add_control(
        'scrub',
        [
            'label' => esc_html__('Scrub', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'false',
            'description' => esc_html__('Animation will follow scrolling behavior of the page.', 'pe-core'),
            'condition' => ['additional!' => 'dynamic'],


        ]
    );

    $widget->add_control(
        'pin',
        [
            'label' => esc_html__('Pin', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'false',
            'description' => esc_html__('Animation will be pinned to window during animation.', 'pe-core'),
            'condition' => ['additional!' => 'dynamic'],

        ]
    );

    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'advanced_tab',
        [
            'label' => esc_html__('Advanced', 'pe-core'),
        ]
    );


    $widget->add_control(
        'pin_target',
        [
            'label' => esc_html__('Pin Target', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Eg: #container2', 'pe-core'),
            'description' => esc_html__('You can enter a container id/class which the element will be pinned during animation.', 'pe-core'),

        ]
    );


    $widget->add_control(
        'start_references',
        [
            'label' => esc_html__('Start References', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'references_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>	
	           This references below are adjusts the animation start/end positions on the screen. <b>For Example: If you select <u>'Top' for item reference point</u> and <u>'Bottom' for the window reference point</u>; animation will start when item's top edge enters the window's bottom edge.</b></div>",


        ]
    );

    $widget->add_control(
        'item_ref_start',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
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
            'default' => 'top',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_start',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
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
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'end_references',
        [
            'label' => esc_html__('End References', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'end_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>For scrubbed/pinned animations only.</div>",
        ]
    );

    $widget->add_control(
        'item_ref_end',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
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
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_end',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
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
            'default' => 'top',
            'toggle' => false,
        ]
    );


    $widget->add_control(
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


    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();



}

function pe_text_animation($widget, $multiple = false)
{

    $settings = $widget->get_settings_for_display();

    $out = $settings['animate_out'] ? $settings['animate_out'] : 'false';

    if ($widget->get_name() === 'petextwrapper') {
        $inserted = $settings['additional'] === 'insert' ? 'true' : 'false';
    } else {
        $inserted = false;
    }

    $dataset = '{' .
        'duration=' . $settings['duration'] . '' .
        ';delay=' . $settings['delay'] . '' .
        ';stagger=' . $settings['stagger'] . '' .
        ';pin=' . $settings['pin'] . '' .
        ';pinTarget=' . $settings['pin_target'] . '' .
        ';scrub=' . $settings['scrub'] . '' .
        ';item_ref_start=' . $settings['item_ref_start'] . '' .
        ';window_ref_start=' . $settings['window_ref_start'] . '' .
        ';item_ref_end=' . $settings['item_ref_end'] . '' .
        ';window_ref_end=' . $settings['window_ref_end'] . '' .
        ';out=' . $out . '' .
        ';inserted=' . $inserted . '' .
        '}';


    $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';

    $widget->add_render_attribute(
        'animation_attributes',
        [
            'data-animate' => 'true',
            'data-animation' => [$animation],
            'data-settings' => [$dataset],
        ]
    );

    $animationAttributes = $settings['select_animation'] !== 'none' ? $widget->get_render_attribute_string('animation_attributes') : '';

    return $animationAttributes;

}

function pe_button_settings($widget, $link = false, $condition = false, $prefix = '')
{

    $widget->add_control(
        $prefix . 'button_text',
        [
            'label' => esc_html__('Button Text', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Write your text here', 'pe-core'),
            'default' => esc_html('Button', 'pe-core'),
            'condition' => $condition,
        ]
    );

    if ($link) {
        $widget->add_control(
            $prefix . 'link',
            [
                'label' => esc_html__('Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow', 'custom_attributes'],
                'default' => [
                    'url' => 'http://',
                    'is_external' => false,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => false,
                'condition' => $condition,
            ]
        );
    }

    $widget->add_control(
        $prefix . 'button_size',
        [
            'label' => esc_html__('Size', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'pb--normal',
            'options' => [
                'pb--normal' => esc_html__('Normal', 'pe-core'),
                'pb--medium' => esc_html__('Medium', 'pe-core'),
                'pb--large' => esc_html__('Large', 'pe-core'),
            ],
            'condition' => $condition,
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'button_alignment',
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
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        $prefix . 'button_background',
        [
            'label' => esc_html__('Background', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pb--background',
            'default' => 'pb--background',
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        $prefix . 'bordered',
        [
            'label' => esc_html__('Bordered', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pb--bordered',
            'default' => 'false',
            'condition' => $condition,
        ]

    );


    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => $prefix . 'button_border',
            'selector' => '{{WRAPPER}} .pe--button a',
            'condition' => [
                $condition,
                'bordered' => 'pb--bordered'
            ],
        ]
    );

    $widget->add_control(
        $prefix . 'marquee',
        [
            'label' => esc_html__('Marquee', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pb--marquee',
            'default' => 'false',
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        $prefix . 'marquee_direction',
        [
            'label' => esc_html__('Marquee Direction', 'pe-core'),
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
            'default' => 'right-to-left',
            'toggle' => false,
            'label_block' => false,
            'condition' => [
                $condition,
                'marquee' => 'pb--marquee'
            ]
        ]
    );



    $widget->add_control(
        $prefix . 'marquee_duration',
        [
            'label' => esc_html__('Duration', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 60,
            'step' => 1,
            'default' => 5,
            'condition' => ['marquee' => 'pb--marquee'],
            'selectors' => [
                '{{WRAPPER}} .pb--marquee__inner' => '--duration: {{VALUE}}s;',
            ],
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        $prefix . 'underlined',
        [
            'label' => esc_html__('Underlined', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pb--underlined',
            'default' => 'false',
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        $prefix . 'show_icon',
        [
            'label' => esc_html__('Show Icon', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pb--icon',
            'default' => 'pb--icon',
            'condition' => $condition,
        ]
    );


    $widget->add_control(
        $prefix . 'icon',
        [
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'material-icons md-arrow_outward',
                'library' => 'material-design-icons',
            ],
            'condition' => [
                'show_icon' => 'pb--icon'
            ],
        ]
    );

    $widget->add_control(
        $prefix . 'icon_position',
        [
            'label' => esc_html__('Icon Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'icon__left' => [
                    'title' => esc_html__('Left', 'pe-core'),
                    'icon' => 'eicon-text-align-left',
                ],
                'icon__right' => [
                    'title' => esc_html__('Right', 'pe-core'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'icon__right',
            'toggle' => false,
            'condition' => [
                'show_icon' => 'pb--icon'
            ],

        ]
    );


}

function pe_button_style_settings($widget, $name = 'Button', $prefix = '', $condition = false)
{


    $widget->start_controls_section(
        $prefix . '_button_styles',
        [

            'label' => esc_html__($name . ' Styles', 'pe-core'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => $condition,
        ]
    );


    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => $prefix . '_button_typography',
            'selector' => '{{WRAPPER}} .pe--button',
        ]
    );

    $widget->add_responsive_control(
        $prefix . '_border-radius',
        [
            'label' => esc_html__('Border Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .pe--button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . '_border-width',
        [
            'label' => esc_html__('Border Width', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'condition' => ['bordered' => 'pb--bordered'],
            'selectors' => [
                '{{WRAPPER}} .pe--button a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . '_underline_height',
        [
            'label' => esc_html__('Underline Height', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 60,
            'step' => 1,
            'condition' => ['underlined' => 'pb--underlined'],
            'selectors' => [
                '{{WRAPPER}} .pe--button.pb--underlined .pe--button--wrapper a::after' => 'height: {{VALUE}}px;',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . '_padding',
        [
            'label' => esc_html__('Padding', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .pe--button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );


    $widget->add_control(
        $prefix . '_color_options',
        [
            'label' => esc_html__('Colors', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $widget->start_controls_tabs(
        $prefix . '_button_c_options_tabs'
    );

    $widget->start_controls_tab(
        $prefix . '_main_tab',
        [
            'label' => esc_html__('Default', 'pe-core'),
        ]
    );

    $widget->add_control(
        $prefix . '_default_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-control-field-description">If you apply custom colors; this widget will no longer change on layout switching unless you set switched color options from the "Switched" tab above.</div>',


        ]
    );


    $widget->add_control(
        $prefix . '_button_main_color',
        [
            'label' => esc_html__('Main Color', 'pe-core'),
            'description' => esc_html__('Used for borders, icon/text color, hover background color etc.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button a' => '--mainColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_button_main_background',
        [
            'label' => esc_html__('Main Background Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button a' => '--secondaryBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_advanced_colors',
        [
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label' => esc_html__('Advanced Colors', 'pe-core'),
            'label_off' => esc_html__('Default', 'pe-core'),
            'label_on' => esc_html__('Custom', 'pe-core'),
            'return_value' => 'adv--styled',
        ]
    );

    $widget->start_popover();

    $widget->add_control(
        $prefix . '_adv_text_color',
        [
            'label' => esc_html__('Text Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a span' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_icon_color',
        [
            'label' => esc_html__('Icon Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a span i' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_background_color',
        [
            'label' => esc_html__('Background Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a' => 'background-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_border_color',
        [
            'label' => esc_html__('Border Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a' => 'border-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_hover_text_color',
        [
            'label' => esc_html__('Text (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a:hover span' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_hover_icon_color',
        [
            'label' => esc_html__('Icon (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a:hover span i' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_hover_background_color',
        [
            'label' => esc_html__('Background (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled .pe--button--wrapper a::before' => 'background-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_hover_border_color',
        [
            'label' => esc_html__('Border (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a:hover' => 'border-color: {{VALUE}}',
            ]
        ]
    );

    $widget->end_popover();


    $widget->end_controls_tab();

    $widget->start_controls_tab(
        $prefix . '_secondary_tab',
        [
            'label' => esc_html__('Switched', 'pe-core'),

        ]
    );

    $widget->add_control(
        $prefix . '_switched_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-control-field-description">This settings will be used when the page layout switched from default.</div>',


        ]
    );

    $widget->add_control(
        $prefix . '_button_secondary_color',
        [
            'label' => esc_html__('Main Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button a' => '--mainColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_button_secondary_background',
        [
            'label' => esc_html__('Main Background Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button a' => '--secondaryBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_advanced_secondary_colors',
        [
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label' => esc_html__('Advanced Colors', 'pe-core'),
            'label_off' => esc_html__('Default', 'pe-core'),
            'label_on' => esc_html__('Custom', 'pe-core'),
            'return_value' => 'adv--styled',
        ]
    );

    $widget->start_popover();

    $widget->add_control(
        $prefix . '_adv_secondary_text_color',
        [
            'label' => esc_html__('Text Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a span' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_secondary_icon_color',
        [
            'label' => esc_html__('Icon Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a span i' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_secondary_background_color',
        [
            'label' => esc_html__('Background Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a' => 'background-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_secondary_border_color',
        [
            'label' => esc_html__('Border Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a:hover' => 'border-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_secondary_hover_text_color',
        [
            'label' => esc_html__('Text (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a:hover span' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_secondary_hover_icon_color',
        [
            'label' => esc_html__('Icon (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a:hover span i' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_secondary_hover_background_color',
        [
            'label' => esc_html__('Background (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled .pe--button--wrapper a::before' => 'background-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_adv_secondary_hover_border_color',
        [
            'label' => esc_html__('Border (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a:hover' => 'border-color: {{VALUE}}',
            ]
        ]
    );

    $widget->end_popover();

    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();



}

function pe_button_render($widget, $attributes = false, $cursor = false)
{
    $settings = $widget->get_settings_for_display();
    $classes = [];

    array_push($classes, [$settings['button_background'], $settings['bordered'], $settings['underlined'], $settings['marquee'], $settings['show_icon'], $settings['icon_position'], $settings['button_size']]);
    $mainClasses = implode(' ', array_filter($classes[0]));

    ob_start();

    \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']);

    $icon = ob_get_clean();

    $buttonText = $settings['button_text'];

    $buttonHTML = ($settings['icon_position'] === 'icon__left' ? $icon : '') . $buttonText . ($settings['icon_position'] === 'icon__right' ? $icon : '');

    $linkAttrs = '';
    // Button Link
    if (!empty($settings['link']['url'])) {
        $widget->add_link_attributes('link', $settings['link']);
        $linkAttrs = $widget->get_render_attribute_string('link');
    } else if ($attributes) {

        $widget->add_render_attribute(
            'button_attributes',
            $attributes
        );

        $linkAttrs = $widget->get_render_attribute_string('button_attributes');

    }

    if ($cursor) {

        //Cursor
        ob_start();

        \Elementor\Icons_Manager::render_icon($settings['cursor_icon'], ['aria-hidden' => 'true']);

        $cursorIcon = ob_get_clean();

        $widget->add_render_attribute(
            'cursor_settings',
            [
                'data-cursor' => "true",
                'data-cursor-type' => $settings['cursor_type'],
                'data-cursor-text' => $settings['cursor_text'],
                'data-cursor-icon' => $cursorIcon,
            ]
        );

        $cursor = $settings['cursor_type'] !== 'none' ? $widget->get_render_attribute_string('cursor_settings') : '';
        //Cursor

    } else {
        $cursor = false;
    }

    ?>

        <div class="pe--button <?php echo esc_attr($mainClasses) ?>">

            <div class="pe--button--wrapper">

                <?php if ($linkAttrs) { ?>

                        <a <?php echo $linkAttrs . $cursor; ?>>

                    <?php } else {

                    echo '<a href="#.">';

                } ?>

                    <span class="pb__main"><?php echo $buttonHTML ?>

                        <?php if ($settings['underlined'] !== 'pb--underlined') {
                            if ($settings['button_background'] === 'pb--background' || $settings['bordered'] === 'pb--bordered') {
                                ?>


                                        <span class="pb__hover"><?php echo $buttonHTML ?></span>

                                <?php }
                        } ?>

                    </span>

                    <?php if ($settings['marquee'] === 'pb--marquee') { ?>
                            <div class="pb--marquee--wrap <?php echo $settings['marquee_direction'] ?>" aria-hidden="true">
                                <div class="pb--marquee__inner">
                                    <span><?php echo $buttonHTML ?></span>
                                    <span><?php echo $buttonHTML ?></span>
                                    <span><?php echo $buttonHTML ?></span>
                                    <span><?php echo $buttonHTML ?></span>
                                </div>
                            </div>
                    <?php } ?>

                    <?php if (!empty($settings['link']['url'])) { ?>
                        </a>
                <?php } else {
                        echo '</a>';
                    } ?>


            </div>

        </div>


<?php }

function pe_cursor_settings($widget, $drag = false)
{

    $widget->start_controls_section(
        'cursor_interactions',
        [
            'label' => __('Cursor Interactions', 'pe-core'),
        ]
    );


    if ($drag) {

        $widget->add_control(
            'cursor_drag',
            [
                'label' => esc_html__('Cursor Drag Interaction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'cursor_drag',
                'prefix_class' => '',
                'default' => false,
            ]
        );

    }

    $widget->add_control(
        'cursor_type',
        [
            'label' => esc_html__('Interaction', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'none' => esc_html__('None', 'pe-core'),
                'default' => esc_html__('Default', 'pe-core'),
                'text' => esc_html__('Text', 'pe-core'),
                'icon' => esc_html__('Icon', 'pe-core'),
            ],


        ]
    );

    $widget->add_control(
        'cursor_icon',
        [
            'label' => esc_html__('Icon', 'pe-core'),
            'description' => esc_html__('Only Material Icons allowed, do not select Font Awesome icons.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-circle',
                'library' => 'fa-solid',
            ],
            'condition' => ['cursor_type' => 'icon'],
        ]
    );

    $widget->add_control(
        'cursor_text',
        [
            'label' => esc_html__('Text', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'condition' => ['cursor_type' => 'text'],
        ]
    );




    $widget->end_controls_section();


}

function pe_cursor($widget)
{

    $settings = $widget->get_settings_for_display();

    ob_start();

    \Elementor\Icons_Manager::render_icon($settings['cursor_icon'], ['aria-hidden' => 'true']);

    $cursorIcon = ob_get_clean();

    $widget->add_render_attribute(
        'cursor_settings',
        [
            'data-cursor' => "true",
            'data-cursor-type' => $settings['cursor_type'],
            'data-cursor-text' => $settings['cursor_text'],
            'data-cursor-icon' => $cursorIcon,
        ]
    );

    $cursor = $settings['cursor_type'] !== 'none' ? $widget->get_render_attribute_string('cursor_settings') : '';

    return $cursor;

}

function pe_color_options($widget, $selector = '', $prefix = '', $section = true)
{

    if ($section) {

        $widget->start_controls_section(
            $prefix . '_widget_colors',
            [

                'label' => esc_html__('Colors', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    }

    $widget->start_controls_tabs(
        $prefix . '_widget_colors_tabs'
    );

    $widget->start_controls_tab(
        $prefix . '_widget_default_colors_tab',
        [
            'label' => esc_html__('Default', 'pe-core'),
        ]
    );

    $widget->add_control(
        $prefix . '_widget_default_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-control-field-description">If you apply custom colors; this widget will no longer change colors on layout switching unless you set switched color options from the "Switched" tab above.</div>',
        ]
    );


    $widget->add_control(
        $prefix . '_widget_main_texts_color',
        [
            'label' => esc_html__('Main Color', 'pe-core'),
            'description' => esc_html__('Used for text/icon color, borders, hover background color etc.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ' . $selector => '--mainColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_widget_secondary_texts_color',
        [
            'label' => esc_html__('Secondary Color', 'pe-core'),
            'description' => esc_html__('Generally used for sub-texts but in some cases may be used as hover colors.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ' . $selector => '--secondaryColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_widget_main_background_color',
        [
            'label' => esc_html__('Main Background Color', 'pe-core'),
            'description' => esc_html__('Used as main background color when it necessary.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ' . $selector => '--mainBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_widget_secondary_background_color',
        [
            'label' => esc_html__('Secondary Background Color', 'pe-core'),
            'description' => esc_html__('Most of times this color will be used inner element backgrounds. Such as; inline buttons/switchers etc.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ' . $selector => '--secondaryBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_widget_main_lines_color',
        [
            'label' => esc_html__('Lines Color', 'pe-core'),
            'description' => esc_html__('Used for lines, borders etc..', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ' . $selector => '--linesColor: {{VALUE}}',
            ]
        ]
    );

    $widget->end_controls_tab();

    $widget->start_controls_tab(
        $prefix . '_widget_switched_colors_tab',
        [
            'label' => esc_html__('Switched', 'pe-core'),

        ]
    );

    $widget->add_control(
        $prefix . '_widget_switched_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-control-field-description">This settings will be used when the page layout switched from default.</div>',


        ]
    );

    $widget->add_control(
        $prefix . '_widget_switched_main_texts_color',
        [
            'label' => esc_html__('Main Color', 'pe-core'),
            'description' => esc_html__('Used for text/icon color, borders, hover background color etc.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} ' . $selector => '--mainColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_widget_switched_secondary_texts_color',
        [
            'label' => esc_html__('Secondary Color', 'pe-core'),
            'description' => esc_html__('Generally used for sub-texts but in some cases may be used as hover colors.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} ' . $selector => '--secondaryColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_widget_switched_main_background_color',
        [
            'label' => esc_html__('Main Background Color', 'pe-core'),
            'description' => esc_html__('Used as main background color when it necessary.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} ' . $selector => '--mainBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_widget_switched_secondary_background_color',
        [
            'label' => esc_html__('Secondary Background Color', 'pe-core'),
            'description' => esc_html__('Most of times this color will be used inner element backgrounds. Such as; inline buttons/switchers etc.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} ' . $selector => '--secondaryBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        $prefix . '_widget_switched_lines_color',
        [
            'label' => esc_html__('Lines Color', 'pe-core'),
            'description' => esc_html__('Used for lines, borders etc..', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} ' . $selector => '--linesColor: {{VALUE}}',
            ]
        ]
    );


    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    if ($section) {
        $widget->end_controls_section();
    }
}

function pe_video_settings($widget, $conditionId = false, $conditionVal = false, $prefix = '')
{


    $widget->add_control(
        'video_provider',
        [
            'label' => esc_html__('Video Provider', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'self',
            'options' => [
                'self' => esc_html__('Self', 'pe-core'),
                'vimeo' => esc_html__('Vimeo', 'pe-core'),
                'youtube' => esc_html__('Youtube', 'pe-core'),
            ],
            'condition' => [
                $conditionId => $conditionVal,

            ]
        ]
    );

    $widget->add_control(
        'self_video',
        [
            'label' => esc_html__('Choose Video', 'pe-core'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'media_types' => ['video'],
            'condition' => [
                'video_provider' => 'self',
                $conditionId => $conditionVal,

            ]
        ]
    );

    $widget->add_control(
        'youtube_id',
        [
            'label' => esc_html__('Video ID', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Enter video od here.', 'pe-core'),
            'condition' => [
                'video_provider' => ['youtube'],
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'vimeo_id',
        [
            'label' => esc_html__('Video ID', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Enter video od here.', 'pe-core'),
            'condition' => [
                'video_provider' => ['vimeo'],
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'controls',
        [
            'label' => esc_html__('Controls', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'true',
            'condition' => [
                $conditionId => $conditionVal,
            ]
        ]
    );


    $widget->add_control(
        'select_controls',
        [
            'label' => esc_html__('Select Controls', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple' => true,
            'options' => [
                'play' => esc_html__('Play', 'pe-core'),
                'current-time' => esc_html__('Current Time', 'pe-core'),
                'duration' => esc_html__('Duration', 'pe-core'),
                'progress' => esc_html__('Progress Bar', 'pe-core'),
                'mute' => esc_html__('Mute', 'pe-core'),
                'volume' => esc_html__('Volume', 'pe-core'),
                'captions' => esc_html__('Captions', 'pe-core'),
                'settings' => esc_html__('Settings', 'pe-core'),
                'pip' => esc_html__('PIP', 'pe-core'),
                'airplay' => esc_html__('Airplay (Safari Only)', 'pe-core'),
                'fullscreen' => esc_html__('Fullscreen', 'pe-core'),
            ],
            'default' => ['play', 'current-time', 'duration', 'progress', 'mute', 'volume', 'fullscreen'],
            'condition' => [
                'controls' => ['true'],
                $conditionId => $conditionVal,
            ]
        ]
    );


    $widget->add_control(
        'autoplay',
        [
            'label' => esc_html__('Autoplay', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'word_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
           <span>When autoplay is enabled, many browsers require the video to be "muted" for it to autoplay properly.</div>',
            'condition' => [
                'autoplay' => 'true',
                $conditionId => $conditionVal,
            ],


        ]
    );

    $widget->add_control(
        'muted',
        [
            'label' => esc_html__('Muted', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'loop',
        [
            'label' => esc_html__('Loop', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'lightbox',
        [
            'label' => esc_html__('Play in Lightbox', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'controls' => ['true'],
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'play_button',
        [
            'label' => esc_html__('Play Button', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'icon',
            'options' => [
                'icon' => esc_html__('Icon', 'pe-core'),
                'text' => esc_html__('Text', 'pe-core'),
            ],
            'condition' => [
                'controls' => ['true'],
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'play_text',
        [
            'label' => esc_html__('Play Text', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('PLAY', 'pe-core'),
            'condition' => [
                'play_button' => ['text'],
                'controls' => ['true'],
                $conditionId => $conditionVal,
            ],

        ]
    );

    $widget->add_control(
        'player_skin',
        [
            'label' => esc_html__('Player Skin', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'global',
            'options' => [
                'global' => esc_html__('Use Global', 'pe-core'),
                'skin--simple' => esc_html__('Simple', 'pe-core'),
                'skin--rounded' => esc_html__('Rounded', 'pe-core'),
                'skin--minimal' => esc_html__('Minimal', 'pe-core'),
            ],
            'condition' => [
                $conditionId => $conditionVal,

            ]
        ]
    );

}

function pe_video_render($widget, $repeater = false)
{

    if ($repeater) {
        $settings = $repeater;
    } else {
        $settings = $widget->get_settings_for_display();
    }


    $skin = $settings['player_skin'];
    $provider = $settings['video_provider'];
    $video_id = '';

    if ($provider === 'youtube') {

        $video_id = $settings['youtube_id'];
    }

    if ($provider === 'vimeo') {

        $video_id = $settings['vimeo_id'];
    }

    $controls = [];
    if ($settings['select_controls']) {
        foreach ($settings['select_controls'] as $control) {

            array_push($controls, $control);
        }
    }
    ?>

        <?php ob_start(); ?>
        <div class="pe-video pe-<?php echo $provider . ' ' . $skin ?>" data-controls="<?php echo implode(',', $controls) ?>"
            data-autoplay="<?php echo $settings['autoplay'] ?>" data-muted="<?php echo $settings['muted'] ?>"
            data-loop="<?php echo $settings['loop'] ?>" data-lightbox="<?php echo $settings['lightbox'] ?>">

            <?php if ($settings['lightbox'] === 'true') { ?>
                    <div class="pe--lightbox--close x-icon">

                        <div class="pl--close--icon">
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . '../assets/img/close.svg'); ?>">
                        </div>

                    </div>
            <?php }

            if ($settings['controls'] === 'true') {

                if ($settings['play_button'] === 'icon') { ?>

                            <div class="pe--large--play icons">

                                <div class="pe--play">

                                    <svg xmlns="http://www.w3.org/2000/svg" height="100%" width="100%" viewBox="0 -960 960 960" width="24">
                                        <path d="M320-200v-560l440 280-440 280Z" />
                                    </svg>

                                </div>

                            </div>

                    <?php } else { ?>

                            <div class="pe--large--play texts">
                                <div class="pe--play">
                                    <?php echo esc_html($settings['play_text']); ?>
                                </div>
                            </div>

                    <?php }
            } ?>

            <?php if ($provider === 'self') { ?>

                    <video class="p-video" playsinline loop autoplay>
                        <source src="<?php echo esc_url($settings['self_video']['url']) ?>">
                    </video>


            <?php } else { ?>

                    <div class="p-video" data-plyr-provider="<?php echo $provider ?>" data-plyr-embed-id="<?php echo $video_id ?>">
                    </div>

            <?php } ?>


        </div>
        <?php

        $video = ob_get_clean();
        return $video;

}

function pe_product_styles($widget, $condition = false)
{


    $widget->start_controls_section(
        'single_product_styles',
        [

            'label' => esc_html__('Product Styles', 'pe-core'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => $condition,
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Image_Size::get_type(),
        [
            'name' => 'product_images_size',
            'exclude' => [],
            'include' => [],
            'default' => 'large',
        ]
    );


    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_typography',
            'label' => esc_html__('Title Typohraphy', 'pe-core'),
            'selector' => '{{WRAPPER}} .product-name',
        ]
    );

    $widget->add_control(
        'title_order',
        [
            'label' => esc_html__('Title Order', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .product-name' => 'order: {{VALUE}};',
            ],

        ]
    );


    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'price_typography',
            'label' => esc_html__('Price Typohraphy', 'pe-core'),
            'selector' => '{{WRAPPER}} .woocommerce-Price-amount',
        ]
    );

    $widget->add_control(
        'price_order',
        [
            'label' => esc_html__('Price Order', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .product-price' => 'order: {{VALUE}};',
            ],

        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'short_desc_typography',
            'label' => esc_html__('Short Desc Typohraphy', 'pe-core'),
            'selector' => '{{WRAPPER}} .product-short-desc',
        ]
    );

    $widget->add_control(
        'short_desc_order',
        [
            'label' => esc_html__('Short Desc Order', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .product-short-desc' => 'order: {{VALUE}};',
            ],

        ]
    );


    $widget->add_responsive_control(
        'prouct_metas_alignment',
        [
            'label' => esc_html__('Metas Alignment', 'pe-core'),
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
                '{{WRAPPER}} .saren--product--meta' => 'text-align: {{VALUE}};',
            ],
        ]
    );


    $widget->add_control(
        'metas_order',
        [
            'label' => esc_html__('Metas Order', 'pe-core'),
            'description' => esc_html__('Title & Price', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .saren--product--main' => 'order: {{VALUE}};',
            ],

        ]
    );


    $widget->add_control(
        'extras_order',
        [
            'label' => esc_html__('Extras Order', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .saren--product--extras' => 'order: {{VALUE}};',
            ],

        ]
    );


    $widget->add_responsive_control(
        'metas_gap',
        [
            'label' => esc_html__('Metas Gap', 'pe-core'),
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
                '{{WRAPPER}} .saren--product--meta' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );


    $widget->add_responsive_control(
        'metas_padding',
        [
            'label' => esc_html__('Metas Padding', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .saren--product--meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
            ],
        ]
    );

    $widget->add_responsive_control(
        'metas_radius',
        [
            'label' => esc_html__('Metas Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .saren--product--meta' => '--radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'single_product_border',
            'selector' => '{{WRAPPER}} .saren--single--product',
        ]
    );

    $widget->add_responsive_control(
        'border_radius',
        [
            'label' => esc_html__('Border Radius (Image)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} .saren--product--image--wrap' => '--radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden',

            ],
        ]
    );

    $widget->add_responsive_control(
        'border_radius_producy',
        [
            'label' => esc_html__('Border Radius (Product)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} .saren--single--product' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden',

            ],
        ]
    );

    $widget->add_responsive_control(
        'single_product_width',
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
                'vw' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .saren--single--product' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'single_product_height',
        [
            'label' => esc_html__('Height', 'pe-core'),
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
            ],
            'selectors' => [
                '{{WRAPPER}} .saren--single--product' => 'min-height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .saren--single--product' => 'height: {{SIZE}}{{UNIT}};',

            ],
        ]
    );


    $widget->add_control(
        'image_position',
        [
            'label' => esc_html__('Image Position', 'pe-core'),
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
            'default' => 'center',
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}} .saren--product--image img' => 'object-position: {{VALUE}};',
            ],
        ]
    );

    $widget->add_control(
        'actions_alignment',
        [
            'label' => esc_html__('Actions Alignment', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'start' => [
                    'title' => esc_html__('Left', 'pe-core'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-h-align-center'
                ],
                'end' => [
                    'title' => esc_html__('Right', 'pe-core'),
                    'icon' => ' eicon-h-align-right',
                ],
            ],
            'default' => is_rtl() ? 'right' : 'left',
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}} .saren--product--actions' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'actions_orientation' => 'row',
            ],
        ]
    );


    objectStyles($widget, 'product_action_styles', 'Product Actions', '.saren--product-quick-action , {{WRAPPER}} .saren--single--atc .saren--cart--form', false, false, false, true);
    objetAbsolutePositioning($widget, '.saren--product--actions', 'actions_pos_', 'Product Actions');

    $widget->add_control(
        'actions_orientation',
        [
            'label' => esc_html__('Actions Oritentation', 'pe-core'),
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
            'prefix_class' => 'actions__orientation-',
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}} .saren--product--actions' => 'flex-direction: {{VALUE}};',
            ],
            'condition' => $condition,
        ]
    );


    $widget->add_control(
        'actions_hovers',
        [
            'label' => esc_html__('Actions Hovers', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'prefix_class' => 'actions--hovers--',
            'default' => 'yes',
        ]
    );

    objetAbsolutePositioning($widget, '.sale--badge', 'sale_badge', 'Sale Badge');

    $widget->add_control(
        'totals_colors',
        [
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label' => esc_html__('Sale Badge Styles', 'pe-core'),
            'label_off' => esc_html__('Default', 'pe-core'),
            'label_on' => esc_html__('Custom', 'pe-core'),
            'return_value' => 'sale--badge--styled',
            'prefix_class' => '',
        ]
    );

    $widget->start_popover();

    $widget->add_control(
        'sale_badge_bg_color',
        [
            'label' => esc_html__('Background Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.sale--badge--styled .sale--badge' => 'background-color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_control(
        'sale_badge_text_color',
        [
            'label' => esc_html__('Text Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.sale--badge--styled .sale--badge' => 'color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'sale_badge_border',
            'label' => esc_html__('Borders', 'pe-core'),
            'selector' => '{{WRAPPER}}.sale--badge--styled .sale--badge',
        ]
    );

    $widget->add_responsive_control(
        'sale_badge_border_radius',
        [
            'label' => esc_html__('Border Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}}.sale--badge--styled .sale--badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'sale_badge_padding',
        [
            'label' => esc_html__('Padding', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}}.sale--badge--styled .sale--badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}};',
            ],
        ]
    );


    $widget->end_popover();



    $widget->end_controls_section();

    $widget->start_controls_section(
        'fast_add_to_cart_styles',
        [

            'label' => esc_html__('Fast Add To Cart Styles', 'pe-core'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => ['add-to-cart-variables' => 'fast'],
            'frontend_available' => true,

        ]
    );

    $widget->add_control(
        'fast_vars_show_titles',
        [
            'label' => esc_html__('Show Titles', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'default' => 'yes',
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'fast_vars_bg',
        [
            'label' => esc_html__('Background (Block)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'prefix_class' => 'fast--vars--has--bg--',
            'default' => 'yes',
        ]
    );

    $widget->add_control(
        'fast_vars_items_bg',
        [
            'label' => esc_html__('Background (Items)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'prefix_class' => 'fast--vars--items--has--bg--',
            'default' => 'yes',
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'fast_vars_typoraphy',
            'label' => esc_html__('Variations Typography', 'pe-core'),
            'selector' => '{{WRAPPER}} .single--product--vars li',
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'fast_vars_border',
            'label' => esc_html__('Borders', 'pe-core'),
            'selector' => '{{WRAPPER}} .single--product--vars li',
        ]
    );

    $widget->add_responsive_control(
        'fast_vars_border_radius',
        [
            'label' => esc_html__('Border Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .single--product--vars li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'fast_vars_padding',
        [
            'label' => esc_html__('Padding', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .single--product--vars li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}};',
            ],
        ]
    );


    $widget->end_controls_section();

    $widget->start_controls_section(
        'quick_add_popup_styles',
        [
            'label' => esc_html__('Quick Add To Cart Styles', 'pe-core'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => ['add-to-cart-variables' => 'popup'],
        ]
    );

    popupStyles($widget, ['add-to-cart-variables' => 'popup'] , '.quick-atc-popup' , 'quick_atc_pop_');

    $widget->add_responsive_control(
        'quick_atc_image_width',
        [
            'label' => esc_html__('Image Width', 'pe-core'),
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
                '{{WRAPPER}} .saren--popup--cart-product-image' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );
    
    $widget->add_responsive_control(
        'quick_atc_image_height',
        [
            'label' => esc_html__('Image Height', 'pe-core'),
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
                '{{WRAPPER}} .saren--popup--cart-product-image' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'quick_atc_image_radius',
        [
            'label' => esc_html__('Border Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .saren--popup--cart-product-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'quick_atc_content_width',
        [
            'label' => esc_html__('Content Width', 'pe-core'),
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
                '{{WRAPPER}} .saren--popup--cart-product-meta' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );
   
    $widget->add_responsive_control(
        'content_padding',
        [
            'label' => esc_html__('Padding', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .saren--popup--cart-product-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'quick_atc_title_typography',
            'label' => esc_html__('Title Typography', 'pe-core'),
            'selector' => '{{WRAPPER}} .spcp--title',
        ]
    );
   
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'quick_atc_desc_typography',
            'label' => esc_html__('Description Typography', 'pe-core'),
            'selector' => '{{WRAPPER}} .spcp--desc',
        ]
    );
  
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'quick_atc_price_typography',
            'label' => esc_html__('Price Typography', 'pe-core'),
            'selector' => '{{WRAPPER}} .spcp--price',
        ]
    );

    flexOptions($widget , false , '.saren--popup--cart--product' , 'quick_atc_product' , 'Product');
    
    flexOptions($widget , false , '.saren--popup--cart-product-meta' , 'quick_atc_product_meta' , 'Product Meta');
    
    flexOptions($widget , false , '.saren--popup--cart--product tbody' , 'quick_atc_product_vars_table' , 'Product Variations Table');
    
    flexOptions($widget , false , '.saren-variation-radio-buttons' , 'quick_atc_product_vars' , 'Product Variations');

    $widget->end_controls_section();

    $widget->start_controls_section(
        'extras_styles',
        [

            'label' => esc_html__('Extras Styles', 'pe-core'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => $condition,

        ]
    );

    $widget->add_control(
        'extras_orientation',
        [
            'label' => esc_html__('Extras Oritentation', 'pe-core'),
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
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}} .saren--product--extras' => 'flex-direction: {{VALUE}};',
                '{{WRAPPER}} .saren--single--product--attributes' => 'flex-direction: {{VALUE}};',
            ],
            'prefix_class' => 'extras__orientation-',
        ]
    );


    $widget->add_responsive_control(
        'prouct_extras_alignment_column',
        [
            'label' => esc_html__('Alignments', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'start' => [
                    'title' => esc_html__('Left', 'pe-core'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-text-align-center'
                ],
                'end' => [
                    'title' => esc_html__('Right', 'pe-core'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'start',
            'toggle' => true,
            'selectors' => [
                '{{WRAPPER}} .saren--product--extras' => 'align-items: {{VALUE}};',
                '{{WRAPPER}} .saren--single--product--attributes' => 'align-items: {{VALUE}};',
            ],
            'condition' => [
                'extras_orientation' => 'column',
            ],
        ]
    );

    $widget->add_responsive_control(
        'prouct_extras_alignment_row',
        [
            'label' => esc_html__('Alignments', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'start' => [
                    'title' => esc_html__('Left', 'pe-core'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-text-align-center'
                ],
                'end' => [
                    'title' => esc_html__('Right', 'pe-core'),
                    'icon' => 'eicon-text-align-right',
                ],
                'space-between' => [
                    'title' => esc_html__('Justigy', 'pe-core'),
                    'icon' => 'eicon-text-align-justify',
                ],
            ],
            'default' => 'space-between',
            'toggle' => true,
            'selectors' => [
                '{{WRAPPER}} .saren--product--extras' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'extras_orientation' => 'row',
            ],
        ]
    );

    $widget->add_responsive_control(
        'extras_gap',
        [
            'label' => esc_html__('Extras Gap', 'pe-core'),
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
                '{{WRAPPER}} .saren--product--extras' => 'gap: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .saren--single--product.detailed .saren--product--extras>div.saren--single--product--attributes' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );


    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'product_cats_typoraphy',
            'label' => esc_html__('Categories Typography', 'pe-core'),
            'selector' => '{{WRAPPER}} .saren--product--cats',
        ]
    );

    $widget->add_control(
        'product_cats_color',
        [
            'label' => esc_html__('Categories Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .saren--product--cats' => 'color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'product_tags_typoraphy',
            'label' => esc_html__('Tags Typography', 'pe-core'),
            'selector' => '{{WRAPPER}} .saren--product--tags',
        ]
    );

    $widget->add_control(
        'product_tags_color',
        [
            'label' => esc_html__('Tags Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .saren--product--tags' => 'color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'varitations_typoraphy',
            'label' => esc_html__('Variations Typography', 'pe-core'),
            'selector' => '{{WRAPPER}} .saren--product--extras > div.saren--single--product--attributes .single--product--attributes:not(.attr--dt--variation_color_only) > span',
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'single_variations_border',
            'label' => esc_html__('Borders', 'pe-core'),
            'selector' => '{{WRAPPER}} .saren--product--extras > div.saren--single--product--attributes .single--product--attributes:not(.attr--dt--variation_color_only) > span',
        ]
    );

    $widget->add_responsive_control(
        'single_variations_border_radius',
        [
            'label' => esc_html__('Border Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .saren--product--extras > div.saren--single--product--attributes .single--product--attributes:not(.attr--dt--variation_color_only) > span' => '--radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}} !important;',
            ],
        ]
    );

    $widget->add_responsive_control(
        'single_variations_padding',
        [
            'label' => esc_html__('Padding', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .saren--product--extras > div.saren--single--product--attributes .single--product--attributes:not(.attr--dt--variation_color_only) > span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'single_variations_colors_border',
            'label' => esc_html__('Borders (Colors)', 'pe-core'),
            'selector' => '{{WRAPPER}} .saren--product--extras > div.saren--single--product--attributes .single--product--attributes.attr--dt--variation_color_only > span',
        ]
    );

    $widget->add_responsive_control(
        'single_variations_colors_border_radius',
        [
            'label' => esc_html__('Border Radius (Colors)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .saren--product--extras > div.saren--single--product--attributes .single--product--attributes.attr--dt--variation_color_only > span' => '--radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
            ],
        ]
    );

    $widget->add_responsive_control(
        'single_variations_colors_size',
        [
            'label' => esc_html__('Colors Size', 'pe-core'),
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
                '{{WRAPPER}} .saren--product--extras > div.saren--single--product--attributes .single--product--attributes.attr--dt--variation_color_only > span' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );


    $widget->add_control(
        'cats_order',
        [
            'label' => esc_html__('Categories Order', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .saren--product--cats' => 'order: {{VALUE}};',
            ],

        ]
    );

    $widget->add_control(
        'tags_order',
        [
            'label' => esc_html__('Tags Order', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .saren--product--tags' => 'order: {{VALUE}};',
            ],

        ]
    );

    $widget->add_control(
        'attributes_order',
        [
            'label' => esc_html__('Attributes Order', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .saren--single--product--attributes' => 'order: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_section();

    $widget->start_controls_section(
        'wishlist_button_styles',
        [
            'label' => esc_html__('Wishlist Button', 'pe-core'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'favorite' => 'show',
                'wishlist_type' => 'built-in',
            ],

        ]
    );

    $widget->add_control(
        'wishlist_use_custom_icon',
        [
            'label' => esc_html__('Use Custom Icons', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'default' => '',
            'frontend_available' => true,
        ]
    );


    $widget->add_control(
        'wishlist_show_caption',
        [
            'label' => esc_html__('Show caption', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'default' => '',
            'frontend_available' => true,
        ]
    );


    $widget->add_control(
        'wishlist_add_caption',
        [
            'label' => esc_html__('Add Caption', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Add to wishlist.', 'pe-core'),
            'ai' => false,
            'condition' => [
                'wishlist_show_caption' => ['yes'],
            ],
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'wishlist_added_caption',
        [
            'label' => esc_html__('Added Caption', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Remove from wishlist.', 'pe-core'),
            'ai' => false,
            'condition' => [
                'wishlist_show_caption' => ['yes'],
            ],
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'wishlist_add_icon',
        [
            'label' => esc_html__('Add Icon', 'pe-core'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'material-icons md-arrow_outward',
                'library' => 'material-design-icons',
            ],
            'condition' => [
                'wishlist_use_custom_icon' => 'yes',
            ],
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'wishlist_added_icon',
        [
            'label' => esc_html__('Added Icon', 'pe-core'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'material-icons md-arrow_outward',
                'library' => 'material-design-icons',
            ],
            'condition' => [
                'wishlist_use_custom_icon' => 'yes',
            ],
            'frontend_available' => true,
        ]
    );


    objectStyles($widget, 'wishlist_saren_', 'Wishlist Button', '.pe-wishlist-btn.pe--styled--object', true, false, false);


    $widget->end_controls_section();

    $widget->start_controls_section(
        'compare_button_styles',
        [
            'label' => esc_html__('Compare Button', 'pe-core'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'compare' => 'show',
                'compare_type' => 'built-in',
            ],

        ]
    );

    $widget->add_control(
        'compare_use_custom_icon',
        [
            'label' => esc_html__('Use Custom Icons', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'default' => '',
        ]
    );

    $widget->add_control(
        'compare_show_caption',
        [
            'label' => esc_html__('Show caption', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'default' => '',
        ]
    );


    $widget->add_control(
        'compare_add_caption',
        [
            'label' => esc_html__('Add Caption', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Add to compare.', 'pe-core'),
            'ai' => false,
            'condition' => [
                'compare_show_caption' => ['yes'],
            ],
        ]
    );

    $widget->add_control(
        'compare_added_caption',
        [
            'label' => esc_html__('Added Caption', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Remove from compare.', 'pe-core'),
            'ai' => false,
            'condition' => [
                'compare_show_caption' => ['yes'],
            ],
        ]
    );


    $widget->add_control(
        'compare_add_icon',
        [
            'label' => esc_html__('Add Icon', 'pe-core'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'material-icons md-arrow_outward',
                'library' => 'material-design-icons',
            ],
            'condition' => [
                'compare_use_custom_icon' => 'yes',

            ],
        ]
    );

    $widget->add_control(
        'compare_added_icon',
        [
            'label' => esc_html__('Added Icon', 'pe-core'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'material-icons md-arrow_outward',
                'library' => 'material-design-icons',
            ],
            'condition' => [
                'compare_use_custom_icon' => 'yes',

            ],
        ]
    );


    objectStyles($widget, 'compare_saren_', 'Compare Button', '.pe-compare-btn.pe--styled--object', true, false, false);


    $widget->end_controls_section();


}

function pe_product_controls($widget, $condition = false)
{

    if (!class_exists('WooCommerce')) { 
        return false;
    }

    $widget->add_control(
        'product_style',
        [
            'label' => esc_html__('Style', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'classic',
            'options' => [
                'classic' => esc_html__('Classic', 'pe-core'),
                'metro' => esc_html__('Metro', 'pe-core'),
                'card' => esc_html__('Card', 'pe-core'),
                'sharp' => esc_html__('Sharp', 'pe-core'),
                'detailed' => esc_html__('Detailed', 'pe-core'),
            ],
            'condition' => $condition,
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'metas_position',
        [
            'label' => esc_html__('Metas Position', 'pe-core'),
            'description' => esc_html__('Includes title,price,category,description etc... (if visible)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'column-reverse' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'column' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'column',
            'prefix_class' => 'metas__pos-',
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}} .saren--product--wrap' => 'flex-direction: {{VALUE}};',
            ],

            'condition' => [
                'products_archive_style!' => 'list',
                'product_style!' => 'detailed',
            ],
            'frontend_available' => true,
        ]
    );

    $widget->add_responsive_control(
        'metas_orientation',
        [
            'label' => esc_html__('Metas Oritentation', 'pe-core'),
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
            'prefix_class' => 'metas__orientation-',
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}} .saren--product--main' => 'flex-direction: {{VALUE}};',
            ],
            'condition' => $condition,
            'frontend_available' => true,
        ]
    );

    $widget->add_responsive_control(
        'box_direction',
        [
            'label' => esc_html__('Box Direction', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'row' => [
                    'title' => esc_html__('Row', 'pe-core'),
                    'icon' => ' eicon-h-align-right',
                ],
                'column' => [
                    'title' => esc_html__('Column', 'pe-core'),
                    'icon' => 'eicon-v-align-bottom',
                ],
                'row-reverse' => [
                    'title' => esc_html__('Row-Reverse', 'pe-core'),
                    'icon' => ' eicon-h-align-left',
                ],
                'column-reverse' => [
                    'title' => esc_html__('Column-Reverse', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
            ],
            'default' => 'row',
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}} .saren--product--wrap.product--box--wrap' => 'flex-direction: {{VALUE}};',
            ],
            'condition' => [
                'product_style' => 'detailed',
            ],
            'frontend_available' => true,
        ]
    );



    $widget->add_control(
        'short__desc',
        [
            'label' => esc_html__('Short Description', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'pe-core'),
            'label_off' => esc_html__('Hide', 'pe-core'),
            'return_value' => 'show',
            'default' => 'hide',
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'price',
        [
            'label' => esc_html__('Price', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'pe-core'),
            'label_off' => esc_html__('Hide', 'pe-core'),
            'return_value' => 'show',
            'default' => 'show',
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'favorite',
        [
            'label' => esc_html__('Wishlist', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'pe-core'),
            'label_off' => esc_html__('Hide', 'pe-core'),
            'return_value' => 'show',
            'default' => 'hide',
            'frontend_available' => true,
        ]
    );


    $widget->add_control(
        'wishlist_type',
        [
            'label' => esc_html__('Wishlist Type', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'yith',
            'options' => [
                'yith' => esc_html__('YITH', 'pe-core'),
                'built-in' => esc_html__('Built-in (Saren)', 'pe-core'),
            ],
            'condition' => [
                'favorite' => 'show',
            ],
            'frontend_available' => true,
        ]
    );


    $widget->add_control(
        'compare',
        [
            'label' => esc_html__('Compare', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'pe-core'),
            'label_off' => esc_html__('Hide', 'pe-core'),
            'return_value' => 'show',
            'default' => 'hide',
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'compare_type',
        [
            'label' => esc_html__('Compare Type', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'yith',
            'options' => [
                'yith' => esc_html__('YITH', 'pe-core'),
                'built-in' => esc_html__('Built-in (Saren)', 'pe-core'),
            ],
            'condition' => [
                'compare' => 'show',
            ],
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'behavior',
        [
            'label' => esc_html__('Add to Cart', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'none',
            'render_type' => 'template',
            'prefix_class' => 'product--behavior--',
            'options' => [
                'none' => esc_html__('Hide', 'pe-core'),
                'add-to-cart' => esc_html__('Show', 'pe-core'),
            ],
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'add-to-cart-style',
        [
            'label' => esc_html__('Add To Cart Style', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'wide',
            'prefix_class' => 'add--to--cart--style--',
            'options' => [
                'wide' => esc_html__('Wide', 'pe-core'),
                'icon' => esc_html__('Icon', 'pe-core'),
            ],
            'condition' => [
                'behavior' => 'add-to-cart',
            ],
            'frontend_available' => true,
        ]
    );

    $productAttributes = array();

    $attributes1 = wc_get_attribute_taxonomies();

    foreach ($attributes1 as $key => $attribute) {
        $productAttributes[$attribute->attribute_id] = $attribute->attribute_label;
    }

    $widget->add_control(
        'add-to-cart-variables',
        [
            'label' => esc_html__('Add To Cart Behavior (Variables)', 'pe-core'),
            'description' => esc_html__('Varible products add to cart behavior.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'popup',
            'render_type' => 'template',
            'label_block' => true,
            'prefix_class' => 'add--to--cart--variables--',
            'options' => [
                'popup' => esc_html__('Popup', 'pe-core'),
                'fast' => esc_html__('Fast', 'pe-core'),
            ],
            'condition' => [
                'behavior' => 'add-to-cart',
            ],
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'add-to-cart-vars',
        [
            'label' => __('Add to cart variable.', 'pe-core'),
            'description' => __("Don't forget to set default selections for the variations that won't be displayed here; otherwise, the fast add to cart feature won't work.", 'pe-core'),
            'label_block' => false,
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => false,
            'options' => $productAttributes,
            'condition' => ['add-to-cart-variables' => 'fast'],
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'view_button',
        [
            'label' => esc_html__('View Button', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'show',
            'default' => '',
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'actions_visibility',
        [
            'label' => esc_html__('Actions Visibility', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'hover',
            'render_type' => 'template',
            'label_block' => false,
            'prefix_class' => 'actions--visiblity--',
            'options' => [
                'hover' => esc_html__('Show On Hover', 'pe-core'),
                'visible' => esc_html__('Always Show', 'pe-core'),
                'show-on-image' => esc_html__('Show on Image', 'pe-core'),
            ],
            'condition' => $condition,
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'image_hover',
        [
            'label' => esc_html__('Hover', 'pe-core'),
            'description' => esc_html__('If product type is variable quick add to cart popup will be used for add to cart event.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'image',
            'render_type' => 'template',
            'prefix_class' => 'image-hover-',
            'options' => [
                'none' => esc_html__('None', 'pe-core'),
                'image' => esc_html__('Image', 'pe-core'),
                'zoom-in' => esc_html__('Zoom In', 'pe-core'),
                'zoom-out' => esc_html__('Zoom Out', 'pe-core'),
            ],
            'condition' => [
                'product_gallery!' => 'yes',
            ],
            'frontend_available' => true,
        ]
    );


    $widget->add_control(
        'product_gallery',
        [
            'label' => esc_html__('Product Gallery', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'default' => '',
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'show_categories',
        [
            'label' => esc_html__('Show Categories', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'render_type' => 'template',
            'default' => 'no',
            'prefix_class' => 'product--cats--',
            'frontend_available' => true,
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

    $widget->add_control(
        'single_categories_to_show',
        [
            'label' => __('Select Categories', 'pe-core'),
            'description' => __('Leave it empty if you want to display all.', 'pe-core'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $productCats,
            'condition' => [
                'show_categories' => 'yes',
            ],
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'show_tags',
        [
            'label' => esc_html__('Show Tags', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'default' => 'no',
            'render_type' => 'template',
            'prefix_class' => 'product--tags--',
            'frontend_available' => true,
        ]
    );

    $productTags = array();

    $args = array(
        'hide_empty' => true,
        'taxonomy' => 'product_tag'
    );

    $tags = get_categories($args);

    foreach ($tags as $key => $tag) {
        $productTags[$tag->term_id] = $tag->name;
    }

    $widget->add_control(
        'single_tags_to_show',
        [
            'label' => __('Select Tags', 'pe-core'),
            'description' => __('Leave it empty if you want to display all.', 'pe-core'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $productTags,
            'condition' => [
                'show_tags' => 'yes',
            ],
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'show_variations',
        [
            'label' => esc_html__('Show Variations', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'default' => 'no',
            'render_type' => 'template',
            'prefix_class' => 'product--vars--',
            'frontend_available' => true,
        ]
    );


    $widget->add_control(
        'single_attributes_to_show',
        [
            'label' => __('Attributes to display.', 'pe-core'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $productAttributes,
            'frontend_available' => true,
            'condition' => ['show_variations' => 'yes']
        ]
    );

    $widget->add_control(
        'show_variations_style',
        [
            'label' => esc_html__('Variations Style', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => esc_html__('Default', 'pe-core'),
                'hover' => esc_html__('Hover', 'pe-core'),
            ],
            'render_type' => 'template',
            'prefix_class' => 'product--vars--',
            'frontend_available' => true,
            'condition' => ['show_variations' => 'yes']

        ]
    );


    $widget->add_control(
        'variations_swatches',
        [
            'label' => esc_html__('Variations Swatches', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'yes',
            'default' => 'no',
            'render_type' => 'template',
            'frontend_available' => true,
            'condition' => [
                'show_variations' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'sale_badge',
        [
            'label' => esc_html__('Sale Badge', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'pe-core'),
            'label_off' => esc_html__('Hide', 'pe-core'),
            'return_value' => 'yes',
            'default' => 'yes',
            'render_type' => 'template',
            'frontend_available' => true,
        ]
    );

    $widget->add_control(
        'sale_badge_text',
        [
            'label' => esc_html__('Sale Badge Text', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('SALE', 'pe-core'),
            'ai' => false,
            'condition' => [
                'sale_badge' => ['yes'],
            ],
            'frontend_available' => true,
        ]
    );

}

function sarenFastAddToCart($product, $settings)
{

    if ($settings['add-to-cart-variables'] === 'fast' && $product->is_type('variable')) { ?>
                <div class="saren--fast--add">

                    <?php $attribute = $settings['add-to-cart-vars'];
                    if (!empty($attribute)) {

                        $default_attributes = $product->get_default_attributes();


                        ?>
                            <div class="saren--fast--add--vars" data-product-id="<?php echo esc_attr($product->get_id()); ?>">

                                <?php

                                $vars = wc_get_attribute($attribute);
                                $variations = $product->get_available_variations();

                                if ($vars) {
                                    $taxonomy = esc_attr($vars->slug);
                                    $id = $vars->id;
                                    $display_type = get_option("wc_attribute_display_type-$id", 'default');
                                    $terms = wc_get_product_terms($product->get_id(), $taxonomy, array('fields' => 'all'));
                                    $matched_variations = [];

                                    if (!empty($default_attributes)) {
                                        foreach ($default_attributes as $key => $attr) {
                                            if ($key !== $taxonomy) {
                                                $matched_variations = array_filter($variations, function ($variation) use ($key, $attr) {
                                                    return isset($variation['attributes']['attribute_' . $key]) && $variation['attributes']['attribute_' . $key] === $attr;
                                                });
                                            }
                                        }
                                    }

                                    if (!empty($terms)) {

                                        if ($settings['fast_vars_show_titles'] == 'yes') {
                                            echo '<span class="fast--var--name">' . esc_html($vars->name) . '</span>';
                                        }

                                        ?>
                                                <ul class="single--product--vars attr--dt--<?php echo $display_type ?>">
                                                    <?php
                                                    foreach ($terms as $term) {

                                                        $variation_id = null;
                                                        $in_stock = true;

                                                        foreach ($variations as $variation) {
                                                            if (isset($variation['attributes']["attribute_$taxonomy"]) & $variation['attributes']["attribute_$taxonomy"] == $term->slug) {
                                                                $variation_id = $variation['variation_id'];
                                                                $in_stock = $variation['is_in_stock'];
                                                                break;
                                                            }
                                                        }

                                                        if (!empty($default_attributes) && $in_stock) {
                                                            $slug = $term->slug;

                                                            $match = array_filter($matched_variations, function ($matcho) use ($taxonomy, $slug) {
                                                                return isset($matcho['attributes']['attribute_' . $taxonomy]) && $matcho['attributes']['attribute_' . $taxonomy] === $slug;
                                                            });

                                                            $variation_ids = array_column($match, 'variation_id');
                                                            $variation_id = $variation_ids[0];

                                                        }
                                                        ;

                                                        if (get_field('term_color', $term)) {
                                                            echo '<li data-stock="' . $in_stock . '" style="--bg: ' . get_field('term_color', $term) . '" data-variation-id="' . esc_attr($variation_id) . '">' . esc_html($term->name) . '</li>';
                                                        } else {
                                                            echo '<li data-stock="' . $in_stock . '" data-variation-id="' . esc_attr($variation_id) . '">' . esc_html($term->name) . '
                                                            <svg class="cart-loading" width="1em" height="1em">
                                                            <use xlink:href="#cart-loading"></use>
                                                          </svg>
                                                          <svg class="cart-done" width="1em" height="1em">
                                                          <use xlink:href="#cart-done"></use>
                                                        </svg>
                                                         </li>';
                                                        }
                                                    } ?>
                                                </ul>
                                        <?php }
                                }
                                ?>
                            </div>
                            <?php
                    } ?>

                </div>
        <?php }

}

function sarenProductActions($product, $settings)
{ ?>
        <div class="saren--product--actions">

            <?php if ($settings['favorite'] === 'show') { ?>
                    <div class="saren--product-quick-action" data-barba-prevent="all"
                        data-add-caption="<?php echo $settings['wishlist_add_caption'] ?>"
                        data-added-caption="<?php echo $settings['wishlist_added_caption'] ?>">
                        <?php
                        if ($settings['wishlist_type'] === 'yith') {
                            if (class_exists('YITH_WCWL') && $settings['favorite'] === 'show') {
                                echo do_shortcode('[yith_wcwl_add_to_wishlist]');
                            }
                        } else {
                            peWishlistButton($product->get_id(), $settings);
                        }
                        ?>
                    </div>

            <?php } ?>

            <?php if ($settings['compare'] === 'show') { ?>

                    <div class="saren--product-quick-action" data-add-caption="<?php echo $settings['compare_add_caption'] ?>"
                        data-added-caption="<?php echo $settings['compare_added_caption'] ?>">
                        <?php
                        if ($settings['wishlist_type'] === 'yith') {
                            if (class_exists('YITH_WCWL') && $settings['favorite'] === 'show') {
                                $svgPath = get_template_directory() . '/assets/img/compare.svg';
                                $icon = file_get_contents($svgPath);

                                echo '<span class="pe--compare--wrap" data-barba-prevent="all">
                                  <span class="compare--svg">' . $icon . '</span>
                                  '
                                    . do_shortcode('[yith_compare_button]') . '
                                  </span>';
                            }
                        } else {
                            peCompareButton($product->get_id(), $settings);
                        }

                        ?>
                    </div>

            <?php } ?>

            <?php
            if ($settings['behavior'] !== 'none' && $settings['add-to-cart-variables'] !== 'fast') { ?>
                    <?php if ($product->is_type('variable') || $product->is_type('grouped')) { ?>
                            <div class="saren--product-quick-action" data-barba-prevent="all">
                                <button class="quick-add-to-cart-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>">

                                    <?php
                                    if ($settings['add-to-cart-style'] === 'wide') {

                                        echo '<span class="quick--text">' . esc_html('Quick Shop', 'pe-core') . '</span>';

                                    } ?>
                                    <span class="card-add-icon">
                                        <?php
                                        $svgPath = get_template_directory() . '/assets/img/cart-add.svg';
                                        $icon = file_get_contents($svgPath);
                                        echo $icon; ?>
                                    </span>

                                    <svg class="cart-loading" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960"
                                        width="1em">
                                        <path
                                            d="M480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880q17 0 28.5 11.5T520-840q0 17-11.5 28.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-17 11.5-28.5T840-520q17 0 28.5 11.5T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80Z" />
                                    </svg>
                                </button>
                            </div>
                    <?php } else { ?>
                            <div class="saren--single--atc">
                                <?php if ($settings['behavior'] === 'add-to-cart') {
                                    if ($product->is_type('simple')) {
                                        woocommerce_simple_add_to_cart();
                                    } elseif ($product->is_type('grouped')) {
                                        woocommerce_grouped_add_to_cart();
                                    } elseif ($product->is_type('external')) {
                                        woocommerce_external_add_to_cart();
                                    }
                                } ?>

                            </div>
                    <?php }
            } ?>

            <?php if ($settings['view_button'] === 'show') { ?>

                    <div class="saren--product-quick-action">
                        <?php
                        $svgPath = get_template_directory() . '/assets/img/arrow_forward.svg';
                        $icon = file_get_contents($svgPath);
                        echo '<a href="' . apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product) . '" class="pe--view--button product--barba--trigger" data-id="' . get_the_id() . '">
        <span>' . $icon . '</span>
        </a>';
                        ?>
                    </div>

            <?php } ?>
        </div>
<?php }


function sarenProductImage($product, $cursor, $settings, $actions = true, $customMedia = false)
{
    ?>

        <div class="saren--product--image--wrap">

            <?php if ((get_field('product_video') === 'vimeo' || get_field('product_video') === 'youtube' || get_field('product_video') === 'self') && get_field('use_as_featured_media') == true || (isset($settings['media_type']) && $settings['media_type'] === 'video')) {

                if (isset($settings['media_type']) && $settings['media_type'] === 'video') {
                    $provider = $settings['video_provider'];

                    $video_id = '';

                    if ($provider === 'youtube') {

                        $video_id = $settings['youtube_id'];
                    }

                    if ($provider === 'vimeo') {

                        $video_id = $settings['vimeo_id'];
                    }
                    $self_video = $settings['self_video'];

                } else {
                    $provider = get_field('product_video');
                    $video_id = get_field('video_id');
                    $self_video = get_field('self_hosted_video');
                }

                ?>

                    <div class="saren--product--video">
                        <a <?php echo $cursor ?>
                            href="<?php echo apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product); ?>"
                            data-id="<?php echo get_the_id() ?>">

                            <div class="pe-video pe-<?php echo esc_attr($provider) ?>" data-controls=false data-autoplay=true
                                data-muted=true data-loop=true>

                                <?php if ($provider === 'self') { ?>
                                        <video class="p-video" autoplay muted loop playsinline>
                                            <source src="<?php echo esc_url($self_video); ?>">
                                        </video>
                                <?php } else { ?>
                                        <div class="p-video" data-plyr-provider="<?php echo esc_attr($provider) ?>"
                                            data-plyr-embed-id="<?php echo esc_attr($video_id) ?>"></div>
                                <?php } ?>
                            </div>
                        </a>
                    </div>

                    <?php if ($settings['image_hover'] === 'image' && !$customMedia) {

                        echo '<div class="product--image--hover">' .
                            wp_get_attachment_image(get_post_thumbnail_id(), 'medium_large', false, array(
                                'loading' => 'eager',
                                'fetchpriority' => 'high',
                            ))
                            . '</div>';
                    } ?>

            <?php } else { ?>

                    <div class="saren--product--image product__image__<?php echo get_the_ID() ?>">

                        <a <?php echo $cursor ?> class="product--barba--trigger" data-id="<?php echo get_the_id() ?>"
                            href="<?php echo apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product); ?>">

                            <?php $attachment_ids = $product->get_gallery_image_ids();

                            if ($attachment_ids) { ?>

                                    <?php

                                    if ($customMedia && $settings['media_type'] === 'image') {
                                        $settings['product_images_size'] = [
                                            'id' => $settings['product_custom_image']['id'],
                                        ];
                                    } else {
                                        $settings['product_images_size'] = [
                                            'id' => get_post_thumbnail_id(),
                                        ];
                                    }

                                    $image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'product_images_size');
                                    $image_html = str_replace('<img ', '<img class="product-image-front" ', $image_html);

                                    echo $image_html;
                                    ?>

                            <?php } else { ?>
                                    <?php
                                    if ($customMedia && $settings['media_type'] === 'image') {
                                        $settings['product_images_size'] = [
                                            'id' => $settings['product_custom_image']['id'],
                                        ];
                                    } else {
                                        $settings['product_images_size'] = [
                                            'id' => get_post_thumbnail_id(),
                                        ];
                                    }
                                    \Elementor\Group_Control_Image_Size::print_attachment_image_html($settings, 'product_images_size');
                                    ?>
                            <?php } ?>
                        </a>

                    </div>

                    <?php if ($settings['product_gallery'] === 'yes') {
                        $attachment_ids = $product->get_gallery_image_ids();

                        if ($attachment_ids) {

                            echo '<div class="product--archive--gallery swiper-container">'; ?>

                                    <div class="product--archive--gallery--nav">

                                        <div class="pag--prev">
                                            <?php $svgPath = plugin_dir_path(__FILE__) . '../assets/img/chevron_down.svg';
                                            $icon = file_get_contents($svgPath);
                                            echo $icon;
                                            ?>

                                        </div>
                                        <div class="pag--next">
                                            <?php
                                            $icon = file_get_contents($svgPath);
                                            echo $icon;
                                            ?>

                                        </div>

                                    </div>

                                    <?php echo '<div class="swiper-wrapper">';

                                    $settings['product_images_size'] = [
                                        'id' => get_post_thumbnail_id(),
                                    ];

                                    ?>
                                    <?php echo '<div class="product--archvive--gallery--image swiper-slide">
                    <a href="' . apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product) . '"' . $cursor . ' class="product--barba--trigger" data-id="' . get_the_id() . '">';
                                    \Elementor\Group_Control_Image_Size::print_attachment_image_html($settings, 'product_images_size');
                                    echo '</a></div>';

                                    foreach ($attachment_ids as $key => $attachment_id) {

                                        $settings['product_images_size'] = [
                                            'id' => $attachment_id,
                                        ];

                                        echo '<div class="product--archvive--gallery--image swiper-slide">
                        <a href="' . apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product) . '"' . $cursor . ' class="product--barba--trigger" data-id="' . get_the_id() . '">';

                                        \Elementor\Group_Control_Image_Size::print_attachment_image_html($settings, 'product_images_size');

                                        echo '</a></div>';

                                    }

                                    echo '</div>';
                                    echo '</div>';

                        }

                    } ?>

                    <?php if ($settings['image_hover'] === 'image' && !$customMedia) {
                        $attachment_ids = $product->get_gallery_image_ids();

                        if ($attachment_ids) {

                            foreach ($attachment_ids as $key => $attachment_id) {
                                if ($key == 0) {
                                    echo '<div class="product--image--hover">' .
                                        wp_get_attachment_image($attachment_id, 'medium_large', false, array(
                                            'loading' => 'eager',
                                            'fetchpriority' => 'high',
                                        ))
                                        . '</div>';
                                }
                            }

                        }
                    } ?>

            <?php }

            echo sarenFastAddToCart($product, $settings);

            if ($actions && ($settings['actions_visibility'] === 'hover' || $settings['actions_visibility'] === 'show-on-image')) {
                echo sarenProductActions($product, $settings);
            } ?>

        </div>

<?php }

function sarenProductRender($settings, $product, $classes, $cursor = '', $image = true)
{
    $style = $settings['product_style'];
    $list = isset($settings['products_archive_style']) && $settings['products_archive_style'] === 'list';
    $rotate = isset($settings['rotate_navigation_types']) ? true : false;

    ?>

        <div <?php wc_product_class($classes, $product); ?> data-product-id="<?php echo get_the_ID(); ?>">
            <?php if ($settings['behavior'] === 'add-to-cart' && $product->is_type('variable')) { ?>
                    <div class="pop--behavior--center quick-add-to-cart-popup quick_pop_id-<?php echo get_the_ID(); ?>"
                        data-product-id="<?php echo get_the_ID(); ?>" style="display: none">
                        <span class="pop--overlay"></span>

                        <div class="pe--styled--popup quick-atc-popup">

                            <span class="pop--close">

                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path
                                        d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z" />
                                </svg>

                            </span>
                            <div class="saren--popup--cart--product">

                            <div class="saren--popup--cart-product-image">
                                        <img class="spcp--img" src="">
                                    </div>

                                <div class="saren--popup--cart-product-meta">
                                  
                                    <div class="saren--popup--cart-product-cont">
                                        <h6 class="spcp--price"></h6>
                                        <h4 class="spcp--title"></h4>
                                        <p class="spcp--desc no-margin"></p>
                                       
                                    </div>
                                    <div class="saren--popup--cart-product-form"></div>
                                </div>
                               

                            </div>

                        </div>
                    </div>
            <?php } ?>

            <div class="saren--product--wrap">
                <?php
                if ($product->is_on_sale() && $settings['sale_badge'] === 'yes') {
                    $regular_price = (float) $product->get_regular_price();
                    $sale_price = (float) $product->get_price();
                    $discount_percentage = calculate_discount_percentage($regular_price, $sale_price);

                    echo '<span class="sale--badge">' . $settings['sale_badge_text'];
                    if ($discount_percentage > 0) {
                        echo '<p class="discount-badge">-' . $discount_percentage . '%</p>';
                    }
                    echo '</span>';


                }

                if ($image) {
                    sarenProductImage($product, $cursor, $settings);
                }

                ?>

                <!-- Product Meta -->
                <div class="saren--product--meta">
                    <div class="saren--product--main">

                        <?php echo '<div class="product-name ' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '">' . get_the_title() . '</div>'; // Product title 
                        
                            if ($settings['price'] === 'show') {

                                if ($price_html = $product->get_price_html()) { ?>
                                        <div class="product-price"><?php echo do_shortcode($price_html); ?></div><!-- Product Price -->
                                <?php }
                            }

                            if ($settings['short__desc'] === 'show') {
                                echo '<div class="product-short-desc">' . $product->get_short_description() . '</div>';
                            }
                            ?>


                    </div>

                    <?php

                    if ($settings['actions_visibility'] === 'visible') {
                        echo sarenProductActions($product, $settings);
                    }

                    ?>


                    <div class="saren--product--extras">

                        <?php if ($settings['show_categories'] === 'yes') { ?>

                                <div class="saren--product--cats">

                                    <?php

                                    $selectedCats = $settings['single_categories_to_show'];
                                    $categories = wp_get_post_terms($product->get_id(), 'product_cat');

                                    foreach ($categories as $category) {
                                        if (!empty($selectedCats)) {
                                            if (in_array($category->term_id, $selectedCats)) {
                                                echo '<span>' . $category->name . '</span>';
                                            }
                                        } else {
                                            echo '<span>' . $category->name . '</span>';
                                        }

                                    } ?>

                                </div>

                        <?php } ?>

                        <?php if ($settings['show_tags'] === 'yes') { ?>

                                <div class="saren--product--tags">

                                    <?php

                                    $selectedTags = $settings['single_tags_to_show'];
                                    $tags = wp_get_post_terms($product->get_id(), 'product_tag');

                                    foreach ($tags as $tag) {
                                        if (!empty($selectedTags)) {
                                            if (in_array($tag->term_id, $selectedTags)) {
                                                echo '<span>' . $tag->name . '</span>';
                                            }
                                        } else {
                                            echo '<span>' . $tag->name . '</span>';
                                        }
                                    } ?>

                                </div>

                        <?php } ?>

                        <?php if ($settings['show_variations'] === 'yes') {
                            $attributes = $settings['single_attributes_to_show'];
                            $swatches = '';

                            if (!empty($attributes)) {
                                if ($settings['variations_swatches'] === 'yes') {
                                    $variations = $product->get_available_variations();
                                    $swatches = 'has--swatches';
                                }
                                ?>
                                        <div class="saren--single--product--attributes <?php echo esc_attr($swatches) ?>">
                                            <?php
                                            foreach ($attributes as $attribute) {
                                                $vars = wc_get_attribute($attribute);


                                                if ($vars) {
                                                    $taxonomy = esc_attr($vars->slug);
                                                    $id = $vars->id;
                                                    $display_type = get_option("wc_attribute_display_type-$id", 'default');
                                                    $terms = wc_get_product_terms($product->get_id(), $taxonomy, array('fields' => 'all'));

                                                    if (!empty($terms)) {

                                                        if ($settings['show_variations_style'] === 'hover') {
                                                            echo '<span class="single--product--attribute--label">+' . count($terms) . ' ' . $vars->name . '</span>';
                                                        }


                                                        ?>
                                                                    <div class="single--product--attributes attr--dt--<?php echo $display_type ?>">
                                                                        <?php
                                                                        foreach ($terms as $term) {

                                                                            $variation_id = null;

                                                                            if ($settings['variations_swatches'] === 'yes') {

                                                                                foreach ($variations as $variation) {
                                                                                    if (
                                                                                        isset($variation['attributes']["attribute_$taxonomy"]) &&
                                                                                        $variation['attributes']["attribute_$taxonomy"] == $term->slug
                                                                                    ) {
                                                                                        $variation_id = $variation['variation_id'];
                                                                                        break;
                                                                                    }
                                                                                }
                                                                            }

                                                                            $linked = '';
                                                                            if (get_post_meta($variation_id, '_linked_variation_checkbox', true)) {
                                                                                $linked_product_id = get_post_meta($variation_id, '_linked_variation_product', true);
                                                                                $linked = 'data-linked-id="' . $linked_product_id . '"';
                                                                            }

                                                                            if (get_field('term_color', $term)) {
                                                                                echo '<span class="term--has--color" ' . $linked . ' style="--bg: ' . get_field('term_color', $term) . '" data-variation-id="' . esc_attr($variation_id) . '">' . esc_html($term->name) . '</span>';
                                                                            } else {
                                                                                echo '<span ' . $linked . ' data-variation-id="' . esc_attr($variation_id) . '">' . esc_html($term->name) . '</span>';
                                                                            }
                                                                        } ?>
                                                                    </div>
                                                            <?php }
                                                }
                                            } ?>
                                        </div>
                                        <?php
                            }
                        } ?>


                    </div>

                </div>


                <!--/ Product Meta -->

            </div>
        </div>


        <?php
}

function sarenProductBox($settings, $product, $classes, $cursor = '', $image = true, $customMedia = false)
{


    $style = $settings['product_style']; ?>


        <div <?php wc_product_class($classes, $product); ?> data-product-id="<?php echo get_the_ID(); ?>">
            <?php if ($settings['behavior'] === 'add-to-cart' && $product->is_type('variable')) { ?>
                    <div class="pop--behavior--center quick-add-to-cart-popup quick_pop_id-<?php echo get_the_ID(); ?>"
                        data-product-id="<?php echo get_the_ID(); ?>" style="display: none">
                        <span class="pop--overlay"></span>

                        <div class="pe--styled--popup">

                            <span class="pop--close">

                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path
                                        d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z" />
                                </svg>

                            </span>
                            <div class="saren--popup--cart--product">

                            <div class="saren--popup--cart-product-image">
                                        <img class="spcp--img" src="">
                                    </div>

                                <div class="saren--popup--cart-product-meta">
                                
                                    <div class="saren--popup--cart-product-cont">
                                        <h6 class="spcp--price"></h6>
                                        <h4 class="spcp--title"></h4>
                                        <p class="spcp--desc no-margin"></p>
                                       
                                    </div>
                                    <div class="saren--popup--cart-product-form"></div>
                                </div>
                             

                            </div>

                        </div>
                    </div>
            <?php } ?>
            <div class="saren--product--wrap product--box--wrap">
                <?php
                if ($product->is_on_sale()) {
                    $regular_price = (float) $product->get_regular_price();
                    $sale_price = (float) $product->get_price();
                    $discount_percentage = calculate_discount_percentage($regular_price, $sale_price);

                    if ($discount_percentage > 0) {
                        echo '<p class="discount-badge">-' . $discount_percentage . '%</p>';
                    }
                }

                if ($image) {

                    sarenProductImage($product, $cursor, $settings, false, $customMedia);
                }

                ?>

                <!-- Product Meta -->
                <div class="saren--product--meta">
                    <div class="saren--product--main">

                        <?php echo '<div class="product-name ' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '">' . get_the_title() . '</div>'; // Product title 
                        
                            if ($settings['price'] === 'show') {

                                if ($price_html = $product->get_price_html()) { ?>
                                        <div class="product-price"><?php echo do_shortcode($price_html); ?></div><!-- Product Price -->
                                <?php }
                            }

                            if ($settings['short__desc'] === 'show') {
                                echo '<div class="product-short-desc">' . $product->get_short_description() . '</div>';
                            }
                            ?>


                    </div>

                    <div class="saren--product--extras">

                        <?php if ($settings['show_categories'] === 'yes') { ?>

                                <div class="saren--product--cats">

                                    <?php

                                    $selectedCats = $settings['single_categories_to_show'];
                                    $categories = wp_get_post_terms($product->get_id(), 'product_cat');

                                    foreach ($categories as $category) {
                                        if (!empty($selectedCats)) {
                                            if (in_array($category->term_id, $selectedCats)) {
                                                echo '<span>' . $category->name . '</span>';
                                            }
                                        } else {
                                            echo '<span>' . $category->name . '</span>';
                                        }

                                    } ?>

                                </div>

                        <?php } ?>

                        <?php if ($settings['show_tags'] === 'yes') { ?>

                                <div class="saren--product--tags">

                                    <?php

                                    $selectedTags = $settings['single_tags_to_show'];
                                    $tags = wp_get_post_terms($product->get_id(), 'product_tag');

                                    foreach ($tags as $tag) {
                                        if (!empty($selectedTags)) {
                                            if (in_array($tag->term_id, $selectedTags)) {
                                                echo '<span>' . $tag->name . '</span>';
                                            }
                                        } else {
                                            echo '<span>' . $tag->name . '</span>';
                                        }
                                    } ?>

                                </div>

                        <?php } ?>

                        <?php if ($settings['show_variations'] === 'yes') {
                            $attributes = $settings['single_attributes_to_show'];
                            $swatches = '';

                            if (!empty($attributes)) {
                                if ($settings['variations_swatches'] === 'yes') {
                                    $variations = $product->get_available_variations();
                                    $swatches = 'has--swatches';
                                }
                                ?>
                                        <div class="saren--single--product--attributes <?php echo esc_attr($swatches) ?>">
                                            <?php
                                            foreach ($attributes as $attribute) {
                                                $vars = wc_get_attribute($attribute);

                                                if ($vars) {
                                                    $taxonomy = esc_attr($vars->slug);
                                                    $id = $vars->id;
                                                    $display_type = get_option("wc_attribute_display_type-$id", 'default');
                                                    $terms = wc_get_product_terms($product->get_id(), $taxonomy, array('fields' => 'all'));

                                                    if (!empty($terms)) { ?>
                                                                    <div class="single--product--attributes attr--dt--<?php echo $display_type ?>">
                                                                        <?php
                                                                        foreach ($terms as $term) {

                                                                            $variation_id = null;

                                                                            if ($settings['variations_swatches'] === 'yes') {

                                                                                foreach ($variations as $variation) {
                                                                                    if (
                                                                                        isset($variation['attributes']["attribute_$taxonomy"]) &&
                                                                                        $variation['attributes']["attribute_$taxonomy"] == $term->slug
                                                                                    ) {
                                                                                        $variation_id = $variation['variation_id'];
                                                                                        break;
                                                                                    }
                                                                                }

                                                                            }
                                                                            if (get_field('term_color', $term)) {
                                                                                echo '<span style="--bg: ' . get_field('term_color', $term) . '" data-variation-id="' . esc_attr($variation_id) . '">' . esc_html($term->name) . '</span>';
                                                                            } else {
                                                                                echo '<span data-variation-id="' . esc_attr($variation_id) . '">' . esc_html($term->name) . '</span>';
                                                                            }
                                                                        } ?>
                                                                    </div>
                                                            <?php }
                                                }
                                            } ?>
                                        </div>
                                        <?php
                            }
                        } ?>


                    </div>

                    <?php echo sarenProductActions($product, $settings); ?>

                </div>


                <!--/ Product Meta -->

            </div>
        </div>

        <?php
}

function sarenProductListRender($settings, $product, $classes, $cursor = '')
{

    $style = $settings['product_style'];
    ?>

        <div <?php wc_product_class($classes, $product); ?> data-product-id="<?php echo get_the_ID(); ?>">
            <?php if ($settings['behavior'] === 'add-to-cart' && $product->is_type('variable')) { ?>
                    <div class="pop--behavior--center quick-add-to-cart-popup quick_pop_id-<?php echo get_the_ID(); ?>"
                        data-product-id="<?php echo get_the_ID(); ?>" style="display: none">
                        <span class="pop--overlay"></span>

                        <div class="pe--styled--popup">

                            <span class="pop--close">

                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path
                                        d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z" />
                                </svg>

                            </span>
                            <div class="saren--popup--cart--product">

                            <div class="saren--popup--cart-product-image">
                                        <img class="spcp--img" src="">
                                    </div>

                                <div class="saren--popup--cart-product-meta">
                                   
                                    <div class="saren--popup--cart-product-cont">
                                        <h6 class="spcp--price"></h6>
                                        <h4 class="spcp--title"></h4>
                                        <p class="spcp--desc no-margin"></p>
                                      
                                    </div>
                                    <div class="saren--popup--cart-product-form"></div>
                                </div>
                               

                            </div>

                        </div>
                    </div>
            <?php } ?>

            <div class="saren--product--wrap">
                <?php
                if ($product->is_on_sale()) {
                    $regular_price = (float) $product->get_regular_price();
                    $sale_price = (float) $product->get_price();
                    $discount_percentage = calculate_discount_percentage($regular_price, $sale_price);

                    if ($discount_percentage > 0) {
                        echo '<p class="discount-badge">-' . $discount_percentage . '%</p>';
                    }
                }

                sarenProductImage($product, $cursor, $settings, false);

                ?>

                <!-- Product Meta -->
                <div class="saren--product--meta">
                    <div class="saren--product--main">

                        <?php echo '<div class="product-name ' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '">' . get_the_title() . '</div>'; // Product title 
                        
                            if ($settings['price'] === 'show') {

                                if ($price_html = $product->get_price_html()) { ?>
                                        <div class="product-price"><?php echo do_shortcode($price_html); ?></div><!-- Product Price -->
                                <?php }
                            } ?>

                    </div>

                    <div class="saren--product--extras">

                        <?php if ($settings['show_variations'] === 'yes') {
                            $attributes = $settings['single_attributes_to_show'];

                            if (!empty($attributes)) { ?>
                                        <div class="saren--single--product--attributes">
                                            <?php

                                            foreach ($attributes as $attribute) {
                                                $vars = wc_get_attribute($attribute);
                                                if ($vars) {
                                                    $taxonomy = esc_attr($vars->slug);
                                                    $id = $vars->id;
                                                    $display_type = get_option("wc_attribute_display_type-$id", 'default');
                                                    $terms = wc_get_product_terms($product->get_id(), $taxonomy, array('fields' => 'all'));

                                                    if (!empty($terms)) { ?>
                                                                    <div class="single--product--attributes attr--dt--<?php echo $display_type ?>">
                                                                        <?php foreach ($terms as $term) {
                                                                            if (get_field('term_color', $term)) {
                                                                                echo '<span style="--bg: ' . get_field('term_color', $term) . '">' . esc_html($term->name) . '</span>';
                                                                            } else {
                                                                                echo '<span>' . esc_html($term->name) . '</span>';
                                                                            }

                                                                        } ?>
                                                                    </div>
                                                            <?php } ?>

                                                    <?php }
                                            } ?>

                                        </div>

                                <?php }
                        } ?>

                    </div>

                </div>

                <div class="list--product--meta--2">


                    <?php if ($settings['show_categories'] === 'yes') { ?>

                            <div class="saren--product--cats">

                                <?php

                                $selectedCats = $settings['single_categories_to_show'];
                                $categories = wp_get_post_terms($product->get_id(), 'product_cat');

                                foreach ($categories as $category) {
                                    if (!empty($selectedCats)) {
                                        if (in_array($category->term_id, $selectedCats)) {
                                            echo '<span>' . $category->name . '</span>';
                                        }
                                    } else {
                                        echo '<span>' . $category->name . '</span>';
                                    }

                                } ?>

                            </div>

                    <?php } ?>

                    <?php if ($settings['show_tags'] === 'yes') { ?>

                            <div class="saren--product--tags">

                                <?php

                                $selectedTags = $settings['single_tags_to_show'];
                                $tags = wp_get_post_terms($product->get_id(), 'product_tag');

                                foreach ($tags as $tag) {
                                    if (!empty($selectedTags)) {
                                        if (in_array($tag->term_id, $selectedTags)) {
                                            echo '<span>' . $tag->name . '</span>';
                                        }
                                    } else {
                                        echo '<span>' . $tag->name . '</span>';
                                    }
                                } ?>

                            </div>

                    <?php } ?>

                    <?php
                    if ($settings['short__desc'] === 'show') {
                        echo '<div class="product-short-desc">' . $product->get_short_description() . '</div>';
                    }
                    ?>
                </div>



                <?php

                echo sarenProductActions($product, $settings);

                ?>


                <!--/ Product Meta -->

            </div>
        </div>


<?php }


function saren_product_query_selection($widget, $highlights = false, $condition = false)
{

    if (!class_exists('WooCommerce')) { 
        return false;
    }

    $widget->add_control(
        'product_selection',
        [
            'label' => esc_html__('Selection', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'all',
            'options' => [
                'by--cat' => esc_html__('By Category', 'pe-core'),
                'by--hand' => esc_html__('Manual Select', 'pe-core'),
                'by--tag' => esc_html__('By Tag', 'pe-core'),
                'by--brand' => esc_html__('By Brand', 'pe-core'),
                'all' => esc_html__('Get All Products', 'pe-core'),
            ],
            'condition' => $condition,

        ]
    );

    $repeaterProducts = [];

    $products = get_posts([
        'post_type' => 'product',
        'numberposts' => -1
    ]);

    foreach ($products as $product) {
        $repeaterProducts[$product->ID] = $product->post_title;
    }

    $productsRepeater = new \Elementor\Repeater();

    $productsRepeater->add_control(
        'select_product',
        [
            'label' => __('Select Product', 'pe-core'),
            'label_block' => true,
            'description' => __('Select project which will display in the slider.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => $repeaterProducts,
        ]
    );

    $widget->add_control(
        'products_list',
        [
            'label' => esc_html__('Products', 'pe-core'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $productsRepeater->get_controls(),
            'show_label' => false,
            'condition' => [

                'product_selection' => 'by--hand',
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

    $widget->add_control(
        'product_filter_cats',
        [
            'label' => __('Categories', 'pe-core'),
            'description' => __('Select categories to display products.', 'pe-core'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $productCats,
            'condition' => [

                'product_selection' => 'by--cat',
            ],
        ]
    );

    $productTags = array();

    $args = array(
        'hide_empty' => true,
        'taxonomy' => 'product_tag'
    );

    $tags = get_categories($args);

    foreach ($tags as $key => $tag) {
        $productTags[$tag->term_id] = $tag->name;
    }

    $widget->add_control(
        'product_filter_tags',
        [
            'label' => __('Tags', 'pe-core'),
            'description' => __('Select tags to display products.', 'pe-core'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $productTags,
            'condition' => [

                'product_selection' => 'by--tag',
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
    

    $widget->add_control(
        'product_filter_brands',
        [
            'label' => __('Brand', 'pe-core'),
            'description' => __('Select brands to display products.', 'pe-core'),
            'label_block' => true,
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $productBrands,
            'condition' => [
                'product_selection' => 'by--brand',
            ],
        ]
    );

    $widget->add_control(
        'exclude_products',
        [
            'label' => esc_html__('Exclude Products', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('eg: 1458 8478 ', 'pe-core'),
            'description' => esc_html__('Enter product ids which you dont want to display in this widget.', 'pe-core'),
            'ai' => false,
            'condition' => [

                'product_selection!' => ['by--hand'],
            ],
        ]
    );

    $widget->add_control(
        'number_products',
        [
            'label' => esc_html__('Posts Per View', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 999,
            'step' => 1,
            'render_type' => 'template',
            'default' => 10,
            'condition' => [

                'product_selection!' => ['by--hand'],
            ],

        ]
    );

    $widget->add_control(
        'products_order_by',
        [
            'label' => esc_html__('Order By', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'ID' => esc_html__('ID', 'pe-core'),
                'title' => esc_html__('Title', 'pe-core'),
                'date' => esc_html__('Date', 'pe-core'),
                'author' => esc_html__('Author', 'pe-core'),
                'type' => esc_html__('Type', 'pe-core'),
                'rand' => esc_html__('Random', 'pe-core'),
            ],
            'condition' => [

                'product_selection!' => ['by--hand'],
            ],
        ]
    );

    $widget->add_control(
        'products_order',
        [
            'label' => esc_html__('Order', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
                'ASC' => esc_html__('ASC', 'pe-core'),
                'DESC' => esc_html__('DESC', 'pe-core')

            ],
            'condition' => [

                'product_selection!' => ['by--hand'],
            ],

        ]
    );

    if ($highlights) {


        $widget->add_control(
            'highlight_products',
            [
                'label' => __('Highlight Products', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $widget->add_control(
            'highlight_by',
            [
                'label' => esc_html__('Hightlight By;', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'key',
                'options' => [
                    'key' => esc_html__('Key', 'pe-core'),
                    'product' => esc_html__('Product', 'pe-core'),
                ],
                'condition' => [
                    'highlight_products' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'highlighted_products',
            [
                'label' => __('Highlighted Products', 'pe-core'),
                'description' => __('Select products that will be highlighted.', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $repeaterProducts,
                'condition' => [
                    'highlight_by' => 'product',
                ],
            ]
        );


        $widget->add_control(
            'highlight_keys',
            [
                'label' => esc_html__('Highlight by Index', 'pe-core'),
                'description' => esc_html__('Enter product keys. For example: "2,5" that means 2nd and 5th items will be highlighted.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => false,
                'condition' => [
                    'highlight_by' => 'key',
                ],
            ]
        );

    }


}

function saren_product_query_args($widget)
{

    $settings = $widget->get_settings_for_display();
    $taxQuery = [];

    if (isset($_GET['filter']) && $_GET['filter'] == true) {
        $taxQuery = [
            'relation' => 'AND',
        ];

        $attributes = wc_get_attribute_taxonomies();

        foreach ($attributes as $key => $attr) {
            $name = $attr->attribute_name;

            if (isset($_GET[$name])) {
                $taxQuery[] = [
                    'taxonomy' => 'pa_' . $name,
                    'field' => 'slug',
                    'terms' => $_GET[$name],
                    'operator' => 'AND'
                ];
            }
        }

        if (isset($_GET['product_cat']) && $_GET['product_cat'] !== 'all') {

            $taxQuery[] = [
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $_GET['product_cat'],
                'operator' => 'AND'
            ];
        }

        if (isset($_GET['product_tag'])) {

            $taxQuery[] = [
                'taxonomy' => 'product_tag',
                'field' => 'id',
                'terms' => $_GET['product_tag'],
                'operator' => 'AND'
            ];
        }

        if (isset($_GET['brand'])) {

            $taxQuery[] = [
                'taxonomy' => 'brand',
                'field' => 'id',
                'terms' => $_GET['brand'],
                'operator' => 'AND'
            ];

        }

        $attributes = wc_get_attribute_taxonomies();

        foreach ($attributes as $attribute) {
            $attr = 'pa_' . $attribute->attribute_name;
            if (isset($_GET[$attr])) {
                $taxQuery[] = [
                    'taxonomy' => $attr,
                    'field' => 'slug',
                    'terms' => array_map('sanitize_text_field', $_GET[$attr]),
                    'operator' => 'AND'
                ];
            }
        }

    }

    if (isset($_GET['min_price']) || isset($_GET['max_price'])) {
        $meta_query = array('relation' => 'AND');

        if (isset($_GET['min_price']) && !empty($_GET['min_price'])) {
            $meta_query[] = array(
                'key' => '_price',
                'value' => floatval($_GET['min_price']),
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        if (isset($_GET['max_price']) && !empty($_GET['max_price'])) {
            $meta_query[] = array(
                'key' => '_price',
                'value' => floatval($_GET['max_price']),
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }
    } else {
        $meta_query = false;
    }

    isset($_GET['offset']) ? $offset = $_GET['offset'] : $offset = 0;

    if ($settings['product_selection'] === 'by--hand') {

        $ids = [];

        foreach ($settings['products_list'] as $key => $product) {
            $ids[] = $product['select_product'];
        }

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 10,
            'post__in' => $ids,
            'orderby' => 'post__in'
        );

    } else if ($settings['product_selection'] === 'by--brand' || $settings['product_selection'] === 'by--tag' || $settings['product_selection'] === 'by--cat' || $settings['product_selection'] === 'all') {

        if ($settings['exclude_products']) {
            $excluded = explode(" ", $settings['exclude_products']);
        } else {
            $excluded = [];
        }

        $cats = $settings['product_filter_cats'];
        $tags = $settings['product_filter_tags'];
        $brands = $settings['product_filter_brands'];


        if ($settings['product_selection'] === 'by--cat' && !empty($cats)) {
            $taxQuery[] = [
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $cats,
            ];
        }

        if ($settings['product_selection'] === 'by--tag' && !empty($tags)) {
            $taxQuery[] = [
                'taxonomy' => 'product_tag',
                'field' => 'id',
                'terms' => $tags,
            ];
        }

        if ($settings['product_selection'] === 'by--brand' && !empty($brands)) {
            $taxQuery[] = [
                'taxonomy' => 'brand',
                'field' => 'id',
                'terms' => $brands,
            ];
        }

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $settings['number_products'],
            // 'offset' => $offset * (isset($settings['number_products']) ? $settings['number_products'] : 1),
            'orderby' => $settings['products_order_by'],
            'order' => $settings['products_order'],
            'post__not_in' => $excluded,
            'tax_query' => $taxQuery,
            'meta_query' => $meta_query,
        );

        if (isset($_GET['orderby'])) {
            $orderby = sanitize_text_field($_GET['orderby']);

            switch ($orderby) {
                case 'menu_order':
                    $args['orderby'] = 'menu_order title';
                    $args['order'] = 'ASC';
                    break;
                case 'popularity':
                    $args['meta_key'] = 'total_sales';
                    $args['orderby'] = 'meta_value_num';
                    break;
                case 'rating':
                    $args['meta_key'] = '_wc_average_rating';
                    $args['orderby'] = 'meta_value_num';
                    $args['order'] = 'DESC';
                    break;
                case 'date':
                    $args['orderby'] = 'date';
                    $args['order'] = 'DESC';
                    break;
                case 'price':
                    $args['meta_key'] = '_price';
                    $args['orderby'] = 'meta_value_num';
                    $args['order'] = 'ASC';
                    break;
                case 'price-desc':
                    $args['meta_key'] = '_price';
                    $args['orderby'] = 'meta_value_num';
                    $args['order'] = 'DESC';
                    break;
                default:
                    $args['orderby'] = 'menu_order';
                    $args['order'] = 'ASC';
                    break;
            }
        }

        if (isset($_GET['sale_products']) && $_GET['sale_products'] == 1) {
            $args['post__in'] = wc_get_product_ids_on_sale();
        }

    }

    if (isset($settings['is_related_query']) && $settings['is_related_query'] === 'yes' && is_product() && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {

        $product_id = get_the_ID();

        $product = wc_get_product($product_id);
        $terms_cat = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'ids'));
        $terms_tag = wp_get_post_terms($product_id, 'product_tag', array('fields' => 'ids'));

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $settings['number_products'],
            'post__not_in' => array($product_id),
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $terms_cat,
                ),
                array(
                    'taxonomy' => 'product_tag',
                    'field' => 'term_id',
                    'terms' => $terms_tag,
                ),
            ),
        );
    }

    if (isset($settings['is_fbt_query']) && $settings['is_fbt_query'] === 'yes' && is_product() && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {

        $product_id = get_the_ID();
        $product = wc_get_product($product_id);

        $fbt_data = get_post_meta($product->get_id(), '_fbt_data', true);
        if (!empty($fbt_data)) {

            $ids = [];
            foreach ($fbt_data as $key => $product) {
                $ids[] = $product['product_id'];
            }

            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => 99,
                'post__in' => $ids,
                'orderby' => 'post__in'
            );

        }
    }

    if (isset($settings['is_wishlist']) && $settings['is_wishlist'] === 'yes' && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {

        if (is_user_logged_in()) {

            $user_id = get_current_user_id();
            $wishlist = get_user_meta($user_id, 'pe_wishlist', true);
            $wishlist = is_array($wishlist) ? $wishlist : [];

        } else {
            $wishlist = isset($_COOKIE['pe_wishlist']) ? json_decode(stripslashes($_COOKIE['pe_wishlist']), true) : [];
            $wishlist = is_array($wishlist) ? $wishlist : [];
        }

        if (isset($_GET['wishlist'])) {
            $wishlist = is_array($wishlist) ? $wishlist : [];
        }

        if (!empty($wishlist)) {

            $ids = [];
            foreach ($wishlist as $product_id) {
                $ids[] = $product_id;
            }

            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => 99,
                'post__in' => $ids,
                'orderby' => 'post__in'
            );

        } else {
            $args = array(
                'post_type' => 'none',

            );
        }
    }

    return $args;

}

function variationStyles($widget, $prefix, $selector)
{


    if ($prefix === 'vr_colors_only') {

        $widget->add_control(
            'vr_colors_style',
            [
                'label' => esc_html__('Interaction Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'opacity',
                'options' => [
                    'opacity' => esc_html__('Opacity', 'pe-core'),
                    'bordered' => esc_html__('Bordered', 'pe-core'),
                ],
                'label_block' => false,
                'prefix_class' => 'colors--interaction--',
            ]
        );

        $widget->add_control(
            'vr_colors_label_vis',
            [
                'label' => esc_html__('Label Visibility', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'on--hover',
                'options' => [
                    'on--hover' => esc_html__('On Hover', 'pe-core'),
                    'hidden' => esc_html__('Hidden', 'pe-core'),
                    'visible' => esc_html__('Visible', 'pe-core'),
                ],
                'label_block' => false,
                'prefix_class' => 'colors--labels--',
            ]
        );

    }

    $widget->add_control(
        $prefix . '_selected_variation_style',
        [
            'label' => esc_html__('Selected Variation Style', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => esc_html__('Default', 'pe-core'),
                'underlined' => esc_html__('Underlined', 'pe-core'),
            ],
            'label_block' => false,
            'prefix_class' => $prefix . '_active_',

        ]
    );


    if ($prefix !== 'vr_colors_only') {



        $widget->add_control(
            $prefix . '_has_underline',
            [
                'label' => esc_html__('Unerlined', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => $prefix . '--underlined',
                'prefix_class' => '',
                'default' => '',
            ]
        );
    }
    $widget->add_control(
        $prefix . '_has_border',
        [
            'label' => esc_html__('Bordered', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => $prefix . '--bordered',
            'prefix_class' => '',
            'default' => $prefix . '--bordered',
        ]
    );

    $widget->add_control(
        $prefix . '_has_rounded',
        [
            'label' => esc_html__('Rounded', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => $prefix . '--rounded',
            'prefix_class' => '',
            'default' => $prefix . '--rounded',
        ]
    );

    if ($prefix !== 'vr_colors_only') {
        $widget->add_control(
            $prefix . '_has_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => $prefix . '--has--bg',
                'prefix_class' => '',
                'default' => $prefix . '--has--bg',
            ]
        );
    }

    $widget->add_responsive_control(
        $prefix . '_has_border_radius',
        [
            'label' => esc_html__('Border Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
            'selectors' => [
                '{{WRAPPER}}.' . $prefix . '--pop--active .' . $selector . ' .saren-variation-radio-buttons .attr--label' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                '{{WRAPPER}}.' . $prefix . '--pop--active .' . $selector . '  .saren-variation-radio-buttons:has(.attr--meta) label.radio--parent' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                '{{WRAPPER}}.' . $prefix . '--pop--active .' . $selector . ' .saren-variation-radio-buttons span.attr--color' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
            ],
        ]
    );

    if ($prefix !== 'vr_colors_only') {

        $widget->add_control(
            $prefix . '_has_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}.' . $prefix . '--pop--active .' . $selector . ' .saren-variation-radio-buttons .attr--label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.' . $prefix . '--pop--active .' . $selector . ' .saren-variation-radio-buttons:has(.attr--meta) label.radio--parent' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


    }

    if ($prefix === 'vr_colors_only') {

        $widget->add_responsive_control(
            $prefix . '_color_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
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
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.' . $prefix . '--pop--active .saren-variation-radio-buttons span.attr--color' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            $prefix . '_color_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
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
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.' . $prefix . '--pop--active .saren-variation-radio-buttons span.attr--color' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

    }

    if ($prefix === 'vr_labels_images') {

        $widget->add_responsive_control(
            $prefix . 'image__has_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}.' . $prefix . '--pop--active .variation_image_label .saren-variation-radio-buttons:has(.attr--meta) label.radio--parent .attr--thumb' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',

                ],
            ]
        );

        $widget->add_responsive_control(
            $prefix . '_metas_alignment',
            [
                'label' => esc_html__('Metas Alignment', 'pe-core'),
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
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .saren-variation-radio-buttons:has(.attr--meta) label.radio--parent' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            $prefix . '_image_width',
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
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.' . $prefix . '--pop--active .attr--thumb' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            $prefix . '_image_height',
            [
                'label' => esc_html__('Image Height', 'pe-core'),
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
                    '{{WRAPPER}}.' . $prefix . '--pop--active .attr--thumb' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



    }

}

function objectStyles($widget, $style_prefix, $style_label, $style_selector, $typo = true, $condition = false, $section = true, $simple = false, $dimensions = true)
{

    if ($section) {
        $widget->start_controls_section(
            $style_prefix . '_styles',
            [

                'label' => esc_html__($style_label . ' Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );
    } else {

        $widget->add_control(
            $style_prefix . '_elementor_bg_notice',
            [
                'label' => esc_html__($style_label . ' Styles', 'pe-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
    }



    if ($typo) {

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $style_prefix . '_typography',
                'label' => esc_html__('Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} ' . $style_selector,
            ]
        );

    }

    if (!$simple) {



        $widget->add_control(
            $style_prefix . '_has_hover',
            [
                'label' => esc_html__('Hover Effect', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'has--hover',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $widget->add_control(
            $style_prefix . '_has_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'has--bg',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $widget->add_control(
            $style_prefix . 'background_color',
            [
                'label' => esc_html__('Background Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $style_selector => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    $style_prefix . '_has_bg' => 'has--bg',
                ],
            ]
        );

        $widget->add_control(
            $style_prefix . '_has_backdrop',
            [
                'label' => esc_html__('Backdrop Filter', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'has--backdrop',
                'prefix_class' => '',
                'default' => '',
            ]
        );


        $widget->add_responsive_control(
            $style_prefix . '_bg_backdrop_blur',
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
                    $style_prefix . '_has_backdrop' => 'has--backdrop',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $style_selector => '--backdropBlur: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            $style_prefix . '_backdrop_color',
            [
                'label' => esc_html__('Backdrop Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $style_selector => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    $style_prefix . '_has_backdrop' => 'has--backdrop',
                ],
            ]
        );

    }


    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => $style_prefix . '_border',
            'selector' => '{{WRAPPER}} ' . $style_selector,
            'important' => true
        ]
    );


    $widget->add_responsive_control(
        $style_prefix . '_has_border_radius',
        [
            'label' => esc_html__('Border Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} ' . $style_selector => '--radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} !important;',
            ],
        ]
    );

    $widget->add_responsive_control(
        $style_prefix . '_has_padding',
        [
            'label' => esc_html__('Padding', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} ' . $style_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
            ],
        ]
    );

    if ($dimensions) {

        $widget->add_responsive_control(
            $style_prefix . '_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
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
                    '{{WRAPPER}} ' . $style_selector => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            $style_prefix . '_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
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
                    '{{WRAPPER}} ' . $style_selector => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

    }

    if ($section) {
        $widget->end_controls_section();
    }



}

function popupOptions($widget, $condition = false)
{
    $widget->add_control(
        'popup_behavior',
        [
            'label' => esc_html__('Popup Behavior', 'pe-core'),
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
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => 'eicon-v-align-bottom',
                ],
            ],
            'prefix_class' => 'pop--behavior--',
            'default' => 'top',
            'toggle' => false,
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        'back_overlay',
        [
            'label' => esc_html__('Overlay', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'render_type' => 'template',
            'prefix_class' => 'pop-overlay-',
            'default' => 'true',
            'description' => esc_html__('Animation will follow scrolling behavior of the page.', 'pe-core'),
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        'back_overlay_backdrop',
        [
            'label' => esc_html__('Overlay Backgrop Filter', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'prefix_class' => 'pop-overlay-backdrop-',
            'default' => '',
            'condition' => $condition,
        ]
    );

    $widget->add_responsive_control(
        'back_overlay_backdrop_blur',
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
                'back_overlay_backdrop' => 'true',
            ],
            'selectors' => [
                '{{WRAPPER}} .pop--overlay' => '--backdropBlur: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_control(
        'back_overlay_color',
        [
            'label' => esc_html__('Overlay Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} span.pop--overlay' => 'background-color: {{VALUE}}',
            ],
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        'pop_disable_scroll',
        [
            'label' => esc_html__('Disable Scroll', 'pe-core'),
            'description' => esc_html__('Page scrolling will disabled when popup is opened.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'prefix_class' => 'pop--disable--scroll--',
            'default' => 'true',
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        'popup_z_index',
        [
            'label' => esc_html__('Z-Index (Popup)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => -100,
            'max' => 99999999,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .pe--styled--popup' => 'z-index: {{VALUE}};',
            ],
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        'popup_overlay_z_index',
        [
            'label' => esc_html__('Z-Index (Overlay)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => -100,
            'max' => 99999999,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .pop--overlay' => 'z-index: {{VALUE}};',
            ],
            'condition' => $condition,
        ]
    );

    $widget->add_control(
        'template_popup_action',
        [
            'label' => esc_html__('Popup Action', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'click',
            'prefix_class' => 'pop--action--',
            'render_type' => 'template',
            'options' => [
                'click' => esc_html__('Click', 'pe-core'),
                'hover' => esc_html__('Hover', 'pe-core'),
            ],
            'condition' => $condition,
        ]
    );

}

function popupStyles($widget, $condition = false, $selector = '', $prefix = '')
{
    $widget->add_responsive_control(
        $prefix . 'pe_popup_width',
        [
            'label' => esc_html__('Width', 'pe-core'),
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
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => 'min-width: {{SIZE}}{{UNIT}};max-width: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.pop--behavior--left div#saren-woo-search-results' => 'max-width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.pop--behavior--right div#saren-woo-search-results' => 'max-width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .woocommerce-privacy-policy-text' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'pe_popup_height',
        [
            'label' => esc_html__('Height', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'vh', 'rem', 'em', 'custom'],
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
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'pe_popup_border_radius',
        [
            'label' => esc_html__('Border Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};',

            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'pe_popup_padding',
        [
            'label' => esc_html__('Padding', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => '--popPadding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'popup_content_max_height_spacing',
        [
            'label' => esc_html__('Max Height (Content)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'vh', 'custom'],
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
                'vh' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => '--contMaxHeight: {{SIZE}}{{UNIT}};',
            ],
        ]
    );


    $widget->add_responsive_control(
        $prefix . 'popup_left_spacing',
        [
            'label' => esc_html__('Left Spacing', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'vw', 'custom'],
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
                'vw' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'condition' => [
                $prefix . 'popup_behavior' => 'left',
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => '--leftSpacing: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'popup_right_spacing',
        [
            'label' => esc_html__('Right Spacing', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'vw', 'custom'],
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
                'vw' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'condition' => [
                $prefix . 'popup_behavior' => 'right',
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => '--rightSpacing: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'popup_top_spacing',
        [
            'label' => esc_html__('Top Spacing', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'vh', 'custom'],
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
                'vh' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'condition' => [
                $prefix . 'popup_behavior' => ['right', 'top', 'left'],
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => '--topSpacing: {{SIZE}}{{UNIT}};',
            ],
        ]
    );



    $widget->add_responsive_control(
        $prefix . 'popup_bottom_spacing',
        [
            'label' => esc_html__('Bottom Spacing', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'vh', 'custom'],
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
                'vh' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'condition' => [
                $prefix . 'popup_behavior' => ['right', 'bottom', 'left'],
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => '--bottomSpacing: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_control(
        $prefix . 'pop_has_backdrop',
        [
            'label' => esc_html__('Backdrop Filter', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pop--has--backdrop',
            'prefix_class' => '',
            'default' => '',
        ]
    );


    $widget->add_responsive_control(
        $prefix . 'pop_bg_backdrop_blur',
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
                'pop_has_backdrop' => 'pop--has--backdrop',
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => '--backdropBlur: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_control(
        $prefix . 'pop_backdrop_color',
        [
            'label' => esc_html__('Backdrop Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ' . $selector . '.pe--styled--popup' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                $prefix . 'pop_has_backdrop' => 'pop--has--backdrop',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'pop_close_button',
        [
            'label' => esc_html__('Close Button', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'pe-core'),
            'label_off' => esc_html__('Hide', 'pe-core'),
            'return_value' => 'show',
            'prefix_class' => 'pop--close--%s-',
            'default' => 'show',
        ]
    );


    $widget->add_control(
        $prefix . 'close_buton_position',
        [
            'label' => esc_html__('Close Button Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'inside',
            'options' => [
                'inside' => esc_html__('Inside', 'pe-core'),
                'outside' => esc_html__('Outside', 'pe-core'),
            ],
            'label_block' => false,
            'prefix_class' => 'close--button--',
            'condition' => [
                $prefix . 'pop_close_button' => 'show',
            ],
        ]
    );

    objetAbsolutePositioning($widget, '' . $selector . ' span.pop--close', $prefix . 'close_button', 'Close Button');

    $widget->add_control(
        $prefix . 'close_button_styles_pop',
        [
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label' => esc_html__('Close Button Styles', 'pe-core'),
            'label_off' => esc_html__('Default', 'pe-core'),
            'label_on' => esc_html__('Custom', 'pe-core'),
            'return_value' => 'popup--colors',
        ]
    );

    $widget->start_popover();

    $widget->add_control(
        $prefix . 'close_button_has_hover',
        [
            'label' => esc_html__('Hover Effect', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'close--button--has--hover',
            'prefix_class' => '',
            'default' => '',
        ]
    );

    $widget->add_control(
        $prefix . 'close_button_has_bg',
        [
            'label' => esc_html__('Background', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'close--button--has--bg',
            'prefix_class' => '',
            'default' => '',
        ]
    );

    $widget->add_control(
        $prefix . 'close_button_background_color',
        [
            'label' => esc_html__('Background Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} span.pop--close' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                $prefix . 'close_button_has_bg' => 'has--bg',
            ],
        ]
    );

    $widget->add_control(
        $prefix . 'close_button_has_backdrop',
        [
            'label' => esc_html__('Backdrop Filter', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'close--button--has--backdrop',
            'prefix_class' => '',
            'default' => '',
        ]
    );


    $widget->add_responsive_control(
        $prefix . 'close_button_bg_backdrop_blur',
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
                $prefix . 'close_button_has_backdrop' => 'has--backdrop',
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . ' span.pop--close' => '--backdropBlur: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_control(
        $prefix . 'close_button_backdrop_color',
        [
            'label' => esc_html__('Backdrop Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ' . $selector . ' span.pop--close' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                $prefix . 'close_button_has_backdrop' => 'has--backdrop',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => $prefix . 'close_button_border',
            'selector' => '{{WRAPPER}} ' . $selector . ' span.pop--close',
            'important' => true
        ]
    );


    $widget->add_responsive_control(
        $prefix . 'close_button_has_border_radius',
        [
            'label' => esc_html__('Border Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . ' span.pop--close' => '--radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} !important;',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'close_button_has_padding',
        [
            'label' => esc_html__('Padding', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%', 'custom'],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . ' span.pop--close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'close_button_width',
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
                'vw' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $selector . ' span.pop--close' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . 'close_button_height',
        [
            'label' => esc_html__('Height', 'pe-core'),
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
                '{{WRAPPER}} ' . $selector . ' span.pop--close' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );
    $widget->end_popover();


    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => $prefix . 'pop_border',
            'selector' => '{{WRAPPER}} ' . $selector . '.pe--styled--popup',
        ]
    );

    $widget->add_control(
        $prefix . 'popup_colorasds',
        [
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label' => esc_html__('Popup Colors', 'pe-core'),
            'label_off' => esc_html__('Default', 'pe-core'),
            'label_on' => esc_html__('Custom', 'pe-core'),
            'return_value' => 'popup--colors',
        ]
    );

    $widget->start_popover();

    pe_color_options($widget, '' . $selector . '.pe--styled--popup', $prefix . 'popup_', false);

    $widget->end_popover();


}

function widgetPinningSettings($widget)
{

    $widget->start_controls_section(
        'element_pinning',
        [
            'label' => __('Widget Pinning', 'pe-core'),
        ]
    );

    $widget->add_control(
        'pin_element',
        [
            'label' => esc_html__('Pin Widget', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'prefix_class' => 'widget-pinned_',
            'default' => '',
            'render_type' => 'template',
        ]
    );

    $widget->add_control(
        'element_pin_target',
        [
            'label' => esc_html__('Pin Target', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Eg: #container2', 'pe-core'),
            'description' => esc_html__('Leave it empty if you want to pin widget to body.', 'pe-core'),

        ]
    );

    $widget->add_control(
        'pin_mobile',
        [
            'label' => esc_html__('Pin Mobile', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => '',
            'render_type' => 'template',
        ]
    );


    $widget->add_control(
        'element_start_references',
        [
            'label' => esc_html__('Start References', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'element_references_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>	
	           This references below are adjusts the pinning start/end positions on the screen. <b>For Example: If you select <u>'Top' for item reference point</u> and <u>'Bottom' for the window reference point</u>; pinning will start when item's top edge enters the window's bottom edge.</b></div>",


        ]
    );

    $widget->add_control(
        'element_start_offset',
        [
            'label' => esc_html__('Start Offset', 'pe-core'),
            'description' => esc_html__('An offset value (px) which will be added to pinning start position. Usefull if you are using a fixed,/sticky header.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => -1000,
            'max' => 1000,
            'step' => 1,
            'default' => 0,
        ]
    );

    $widget->add_control(
        'element_item_ref_start',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
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
            'render_type' => 'template',
            'default' => 'center',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'element_window_ref_start',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
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
            'render_type' => 'template',
            'default' => 'center',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'element_end_references',
        [
            'label' => esc_html__('End References', 'pe-core'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'element_item_ref_end',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
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
            'render_type' => 'template',
            'default' => 'bottom',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'element_window_ref_end',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
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
            'render_type' => 'template',
            'default' => 'top',
            'toggle' => false,
        ]
    );

    $widget->end_controls_section();


}

function widgetPinningRender($widget)
{
    $settings = $widget->get_settings_for_display();

    $start = $settings['element_item_ref_start'] . ' ' . $settings['element_window_ref_start'] . '+=' . $settings['element_start_offset'];
    $end = $settings['element_item_ref_end'] . ' ' . $settings['element_window_ref_end'];

    $widget->add_render_attribute(
        'widget_pinning_settings',
        [
            'data-pin-start' => $start,
            'data-pin-end' => $end,
            'data-pin-target' => $settings['element_pin_target'],
            'data-pin-mobile' => $settings['pin_mobile'],
        ]
    );

    $widgetPinning = $settings['pin_element'] === 'true' ? '<div hidden ' . $widget->get_render_attribute_string('widget_pinning_settings') . ' class="widget--pin--sett"></div>' : '';
    return $widgetPinning;

}

function objetAbsolutePositioning($widget, $selector, $prefix, $label, $condition = false)
{

    $widget->add_control(
        $prefix . '_positioning',
        [
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label' => esc_html__($label . ' Positioning', 'pe-core'),
            'label_off' => esc_html__('Default', 'pe-core'),
            'label_on' => esc_html__('Custom', 'pe-core'),
            'return_value' => '-positioned',
            'prefix_class' => $prefix,
            'default' => 'no',

        ]
    );

    $widget->start_popover();

    $widget->add_responsive_control(
        $prefix . '_vertical_orientation',
        [
            'label' => esc_html__('Vertical Orientation', 'pe-core'),
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

    $widget->add_responsive_control(
        $prefix . '_vertical_offset_top',
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
                '{{WRAPPER}}.' . $prefix . '-positioned ' . $selector => 'top: {{SIZE}}{{UNIT}};bottom: unset',
            ],
            'condition' => [
                $prefix . '_vertical_orientation' => 'top'
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . '_vertical_offset_bottom',
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
                '{{WRAPPER}}.' . $prefix . '-positioned ' . $selector => 'bottom: {{SIZE}}{{UNIT}};top: unset',
            ],
            'condition' => [
                $prefix . '_vertical_orientation' => 'bottom'
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . '_transform_y',
        [
            'label' => esc_html__('Transform Y', 'pe-core'),
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
                '{{WRAPPER}}.' . $prefix . '-positioned ' . $selector => '--transformY: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . '_horizontal_orientation',
        [
            'label' => esc_html__('Horizontal Orientation', 'pe-core'),
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

    $widget->add_responsive_control(
        $prefix . '_horizontal_offset_left',
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
                '{{WRAPPER}}.' . $prefix . '-positioned ' . $selector => 'left: {{SIZE}}{{UNIT}};right: unset',
            ],
            'condition' => [
                $prefix . '_horizontal_orientation' => 'left'
            ],
        ]
    );


    $widget->add_responsive_control(
        $prefix . '_horizontal_offset_right',
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
                '{{WRAPPER}}.' . $prefix . '-positioned ' . $selector => 'right: {{SIZE}}{{UNIT}};left: unset',
            ],
            'condition' => [
                $prefix . '_horizontal_orientation' => 'right'
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . '_transform_x',
        [
            'label' => esc_html__('Transform X', 'pe-core'),
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
                '{{WRAPPER}}.' . $prefix . '-positioned ' . $selector => '--transformX: {{SIZE}}{{UNIT}};',
            ],
        ]
    );



    $widget->end_popover();

}

function sarenCompareItemRender($settings, $product, $product_id, $product_link)
{

    $wcAttributes = wc_get_attribute_taxonomies();
    ?>

        <div class="pe-compare-item saren--single--product <?php echo 'post-' . $product_id ?>">

        <div class="pop--behavior--center quick-add-to-cart-popup quick_pop_id-<?php echo $product_id; ?>"
            data-product-id="<?php echo $product_id; ?>" style="display: none">

            <span class="pop--overlay"></span>

            <div class="pe--styled--popup">

                <span class="pop--close">

                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                        <path
                            d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z" />
                    </svg>

                </span>
                <div class="saren--popup--cart--product">

                <div class="saren--popup--cart-product-image">
                            <img class="spcp--img" src="">
                        </div>


                    <div class="saren--popup--cart-product-meta">

                     
                        <div class="saren--popup--cart-product-cont">
                            <h6 class="spcp--price"></h6>
                            <h4 class="spcp--title"></h4>
                            <p class="spcp--desc no-margin"></p>
                           
                        </div>

                        <div class="saren--popup--cart-product-form"></div>

                    </div>

                   

                </div>

            </div>
        </div>

        <div class="pe-compare-image">
            <img src="<?php echo esc_url(get_the_post_thumbnail_url($product_id, 'medium')); ?>"
                alt="<?php echo esc_attr($product->get_name()); ?>">
        </div>

        <div class="pe-compare-item-meta">
            <div class="pe-compare-title">
                <p><?php echo esc_html($product->get_name()); ?></p>
            </div>
            <div class="pe-compare-price">
                <?php echo wp_kses_post($product->get_price_html()); ?>
            </div>

        </div>

        <div class="pe-compare-actions add--to--cart--style--icon">

            <?php if ($settings['add-to-cart-button'] === 'yes') { ?>

                    <?php if ($product->is_type('variable') || $product->is_type('grouped')) { ?>
                            <div class="saren--product-quick-action" data-barba-prevent="all">
                                <button class="quick-add-to-cart-btn"
                                    data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                                    <span class="card-add-icon">
                                        <?php
                                        $svgPath = get_template_directory() . '/assets/img/cart-add.svg';
                                        $icon = file_get_contents($svgPath);
                                        echo $icon; ?>
                                    </span>

                                    <svg class="cart-loading" xmlns="http://www.w3.org/2000/svg" height="1em"
                                        viewBox="0 -960 960 960" width="1em">
                                        <path
                                            d="M480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880q17 0 28.5 11.5T520-840q0 17-11.5 28.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-17 11.5-28.5T840-520q17 0 28.5 11.5T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80Z" />
                                    </svg>
                                </button>
                            </div>
                    <?php } else { ?>
                            <div class="saren--single--atc">
                                <?php
                                if ($product->is_type('simple')) {
                                    woocommerce_simple_add_to_cart();
                                } elseif ($product->is_type('grouped')) {
                                    woocommerce_grouped_add_to_cart();
                                } elseif ($product->is_type('external')) {
                                    woocommerce_external_add_to_cart();
                                }
                                ?>

                            </div>
                    <?php }

            }

            if ($settings['view-product-button'] === 'yes') { ?>

                    <div class="saren--product-quick-action">
                        <?php
                        $svgPath = get_template_directory() . '/assets/img/arrow_forward.svg';
                        $icon = file_get_contents($svgPath);
                        echo '<a href="' . $product_link . '" class="pe--view--button product--barba--trigger" data-id="' . $product_id . '">
<span>' . $icon . '</span>
</a>';
                        ?>
                    </div>
            <?php } ?>
        </div>

        <div class="pe-compare-remove">
            <a data-product-id="<?php echo $product_id ?>" class="remove-compare">
                <?php
                $svgPath = get_template_directory() . '/assets/img/remove.svg';
                $icon = file_get_contents($svgPath);
                echo $icon;
                ?>
            </a>
        </div>

        <div class="pe-compare-item-vars">

            <?php
            if ($settings['sku'] === 'yes') {
                echo '<div class="pe--compare--item--var pe-compare-item-sku"><span class="pe--compare--mobile--label">' . esc_html('SKU', 'pe-core') . '</span>' . esc_html($product->get_sku()) . '</div>';
            }

            if ($settings['dimensions'] === 'yes') {
                echo '<div class="pe--compare--item--var pe-compare-item-dimensions"><span class="pe--compare--mobile--label">' . esc_html('Dimensions', 'pe-core') . '</span>' . esc_html(wc_format_dimensions($product->get_dimensions(false))) . '</div>';
            }

            if ($settings['saren_weight'] === 'yes') {
                echo '<div class="pe--compare--item--var pe-compare-item-weight"><span class="pe--compare--mobile--label">' . esc_html('Weight', 'pe-core') . '</span>' . esc_html($product->get_weight()) . '</div>';
            }

            if ($settings['stock'] === 'yes') {
                echo '<div class="pe--compare--item--var pe-compare-item-stock">';
                echo '<span class="pe--compare--mobile--label">' . esc_html('Stock', 'pe-core') . '</span>';
                echo esc_html($product->get_stock_status());
                $stock_quantity = $product->get_stock_quantity();
                if ($stock_quantity !== null) {
                    echo '<span class="stock-quantity">(' . esc_html($stock_quantity) . ')</span>';
                }
                ;
                echo '</div>';
            }


            foreach ($wcAttributes as $key => $attr) {
                if ($settings[$attr->attribute_name] === 'yes') {
                    $vals = [];
                    $terms = wc_get_product_terms($product_id, 'pa_' . $attr->attribute_name, ['fields' => 'all']);
                    foreach ($terms as $term) {
                        $vals[] = $term->name;
                    }
                    echo '<div class="pe--compare--item--var pe-compare-item-' . $attr->attribute_name . '"><span class="pe--compare--mobile--label">' . $attr->attribute_label . '</span>' . esc_html(implode(', ', $vals)) . '</div>';
                }
            }
            ?>

        </div>

    </div>


<?php }

function flexOptions($widget, $condition = false, $selector = '', $prefix = '', $label = '')
{

    $widget->add_control(
        $prefix . '_flex_options',
        [
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label' => $label . esc_html__(' Flex Options', 'pe-core'),
            'label_off' => esc_html__('Default', 'pe-core'),
            'label_on' => esc_html__('Custom', 'pe-core'),
            'return_value' => '_flex--styled',
            'prefix_class' => $prefix,
            'condition' => $condition,
        ]
    );

    $widget->start_popover();


    $widget->add_responsive_control(
        $prefix . '_flex_direction',
        [
            'label' => esc_html__('Flex Direction', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'row' => [
                    'title' => esc_html__('Row', 'pe-core'),
                    'icon' => ' eicon-h-align-right',
                ],
                'column' => [
                    'title' => esc_html__('Column', 'pe-core'),
                    'icon' => 'eicon-v-align-bottom',
                ],
                'row-reverse' => [
                    'title' => esc_html__('Row-Reverse', 'pe-core'),
                    'icon' => ' eicon-h-align-left',
                ],
                'column-reverse' => [
                    'title' => esc_html__('Column-Reverse', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
            ],
            'default' => 'row',
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}}.'.$prefix .'_flex--styled ' . $selector => 'flex-direction: {{VALUE}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . '_justify_content_row',
        [
            'label' => esc_html__('Justify Content', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Start', 'pe-core'),
                    'icon' => 'eicon-justify-start-h'
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-justify-center-h'
                ],
                'flex-end' => [
                    'title' => esc_html__('End', 'pe-core'),
                    'icon' => 'eicon-justify-end-h'
                ],
                'space-between' => [
                    'title' => esc_html__('Space-Between', 'pe-core'),
                    'icon' => 'eicon-justify-center-h'
                ],
            ],
       
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}}.'.$prefix .'_flex--styled ' . $selector => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                $prefix . '_flex_direction' => ['row' , 'row-reverse'],
            ],
        ]
    );
    
    $widget->add_responsive_control(
        $prefix . '_align_items_row',
        [
            'label' => esc_html__('Align Items', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Start', 'pe-core'),
                    'icon' => 'eicon-align-start-v'
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-align-center-v'
                ],
                'flex-end' => [
                    'title' => esc_html__('End', 'pe-core'),
                    'icon' => 'eicon-align-end-v'
                ],
                'space-between' => [
                    'title' => esc_html__('Strecth', 'pe-core'),
                    'icon' => 'eicon-align-stretch-v'
                ],
            ],
       
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}}.'.$prefix .'_flex--styled ' . $selector => 'align-items: {{VALUE}};',
            ],
            'condition' => [
                $prefix . '_flex_direction' => ['row' , 'row-reverse'],
            ],
        ]
    );
    
    $widget->add_responsive_control(
        $prefix . '_align_items_column',
        [
            'label' => esc_html__('Align Items', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Start', 'pe-core'),
                    'icon' => 'eicon-align-start-h'
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-align-center-h'
                ],
                'flex-end' => [
                    'title' => esc_html__('End', 'pe-core'),
                    'icon' => 'eicon-align-end-h'
                ],
                'space-between' => [
                    'title' => esc_html__('Stretch', 'pe-core'),
                    'icon' => 'eicon-align-stretch-h'
                ],
            ],
       
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}}.'.$prefix .'_flex--styled ' . $selector => 'align-items: {{VALUE}};',
            ],
            'condition' => [
                $prefix . '_flex_direction' => ['column' , 'column-reverse'],
            ],
        ]
    );
    
    $widget->add_responsive_control(
        $prefix . '_justify_content_column',
        [
            'label' => esc_html__('Justify Content', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Start', 'pe-core'),
                    'icon' => 'eicon-justify-start-v'
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-justify-center-v'
                ],
                'flex-end' => [
                    'title' => esc_html__('End', 'pe-core'),
                    'icon' => 'eicon-justify-end-v'
                ],
                'space-between' => [
                    'title' => esc_html__('Space-Between', 'pe-core'),
                    'icon' => 'eicon-justify-center-v'
                ],
            ],
       
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}}.'.$prefix .'_flex--styled ' . $selector => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                $prefix . '_flex_direction' => ['column' , 'column-reverse'],
            ],
        ]
    );


    $widget->add_responsive_control(
        $prefix . '_columns_gap',
        [
            'label' => esc_html__('Columns Gap', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em' , 'custom' , 'vw' , 'vh' , 'rem'],
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
                'rem' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'vh' => [
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
            ],
            'selectors' => [
                '{{WRAPPER}}.'.$prefix .'_flex--styled ' . $selector => 'column-gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $prefix . '_rows_gap',
        [
            'label' => esc_html__('Rows Gap', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em' , 'custom' , 'vw' , 'vh' , 'rem'],
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
                'rem' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'vh' => [
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
            ],
            'selectors' => [
                '{{WRAPPER}}.'.$prefix .'_flex--styled ' . $selector => 'row-gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );



    $widget->end_popover();



}