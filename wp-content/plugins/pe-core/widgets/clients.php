<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeClients extends Widget_Base {
 
  /**
   * Retrieve the widget name.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'peclients';
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
  public function get_title() {
    return __( 'Clients', 'pe-elementor' );
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
  public function get_icon() {
    return 'eicon-logo pe-widget';
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
  public function get_categories() {
    return [ 'pe-content' ];
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
   protected function _register_controls() {
       
       
       
       
        // Tab Title Control
        $this->start_controls_section(
            'section_tab_title',
            [
                'label' => __( 'Clients', 'pe-core' ),
            ]
        );
       
        $this->add_control(
			'type',
			[
				'label' => esc_html__( 'Type', 'pe-core' ),
				'description' => esc_html__( 'Select display type.', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'pe--clients--grid',
				'options' => [
					'pe--clients--grid' => esc_html__( 'Grid', 'pe-core' ),
					'pe--clients--carousel' => esc_html__( 'Carousel', 'pe-core' ),

				],
			]
		);

       
       	$repeater = new \Elementor\Repeater();
       
       	$repeater->add_control(
			'client_logo',
			[
              'label' => esc_html__('Client Logo', 'pe-core'),
             'type' => \Elementor\Controls_Manager::MEDIA,
             'default' => [
			     'url' => 'https://s.wordpress.org/style/images/codeispoetry.png',
             ],
			]
		);
       
       $repeater->add_control(
			'client_title',
			[
                'type' => \Elementor\Controls_Manager::TEXT,
                'label' => esc_html__('Client Title', 'pe-core'),
                        
			]
		);
       
       $repeater->add_control(
			'client_url',
			[
                       'label' => esc_html__('Client URL', 'pe-core'),
                       'type' => \Elementor\Controls_Manager::URL,
                       'options' => ['url', 'is_external', 'nofollow'],
                       'default' => [
                           'url' => '',
                           'is_external' => true,
                           'nofollow' => true
                       ],
                       'label_block' => true
			]
		);
       
        $repeater->add_control(
			'secondary_logo',
			[
				'label' => __( 'Secondary Logo', 'pe-core ' ),
				'description' => __( 'Required when layout switcher or hover logo switch enabled.', 'pe-core ' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'pe-core ' ),
				'label_off' => __( 'No', 'pe-core ' ),
				'return_value' => 'true',
				'default' => 'true',
               
			]
		);
       
        $repeater->add_control(
			'client_secondary_logo',
			[
             'type' => \Elementor\Controls_Manager::MEDIA,
             'default' => [
			     'url' => \Elementor\Utils::get_placeholder_image_src(),
                  
             ],
              'condition' => ['secondary_logo' => 'true'],
			]
		);
       
       
       
		$this->add_control(
			'client',
			[
				'label' => esc_html__( 'Clients', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'default' => [
					[
						'client_title' => esc_html__( 'Client #1', 'pe-core' ),
					],
                    [
						'client_title' => esc_html__( 'Client #2', 'pe-core' ),
					],
                    [
						'client_title' => esc_html__( 'Client #3', 'pe-core' ),
					],
				],
				'title_field' => '{{{ client_title }}}',
			]
		);

       
          $this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 12,
						'step' => 1,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .pe--clients.pe--clients--grid .pe--clients--wrapper' => '--columns: {{SIZE}};'
				],
                'condition' => [
                    'type' => 'pe--clients--grid'
                ]
			]
		);
       
       $this->add_responsive_control(
			'columns_spacing',
			[
				'label' => esc_html__( 'Columns Spacing', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%' , 'vw'],
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
					'{{WRAPPER}} .pe--clients.pe--clients--grid .pe--clients--wrapper' => '--gap: {{SIZE}}{{UNIT}}'
				],
                'condition' => [
                    'type' => 'pe--clients--grid'
                ]
			]
		);

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Images Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%' , 'vw'],
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
                    '{{WRAPPER}} .pe--clients .pe--clients--wrapper .pe-client img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
       
        $this->add_responsive_control(
            'row_height',
            [
                'label' => esc_html__('Row Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%' , 'vh', 'custom' ],
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
                    '{{WRAPPER}} .pe--clients--wrapper' => 'grid-auto-rows: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
       
        $this->add_control(
			'background',
			[
				'label' => __( 'Background', 'pe-core ' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'pe-core ' ),
				'label_off' => __( 'No', 'pe-core ' ),
				'return_value' => 'has-bg',
				'default' => 'has-bg',
               
			]
		);

        $this->add_control(
			'bordered',
			[
				'label' => __( 'Bordered?', 'pe-core ' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'pe-core ' ),
				'label_off' => __( 'No', 'pe-core ' ),
				'return_value' => 'has-bordered',
				'default' => false,
               
			]
		);
       
        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .has-bg .pe--clients--wrapper .pe-client' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'background' => 'has-bg'
                ]
            ]
        );
       
       $this->add_control(
			'hover',
			[
				'label' => __( 'Hover Effects', 'pe-core ' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'pe-core ' ),
				'label_off' => __( 'No', 'pe-core ' ),
				'return_value' => 'has-hover',
				'default' => 'false',
                 'condition' => [
                    'background' => 'has-bg'
                ]
               
			]
		);
       
       $this->add_control(
			'hover-switch',
			[
				'label' => __( 'Switch logos at hover', 'pe-core ' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'pe-core ' ),
				'label_off' => __( 'No', 'pe-core ' ),
				'return_value' => 'hover-switch-logos',
				'default' => 'false',
                 'condition' => [
                    'background' => 'has-bg'
                ]
               
			]
		);
       
       $this->add_control(
			'captions',
			[
				'label' => __( 'Captions', 'pe-core ' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'pe-core ' ),
				'label_off' => __( 'No', 'pe-core ' ),
				'return_value' => 'show-captions',
				'default' => 'true',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .pe--clients--wrapper .pe-client .client-caption',
                'condition' => [
                    'captions' => 'show-captions'
                ]
			]
		);

        $this->add_responsive_control(
			'column_width',
			[
				'label' => esc_html__( 'Column Width', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px' , 'em' , 'vw'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pe--clients.pe--clients--carousel .pe--clients--wrapper>div' => 'width: {{SIZE}}{{UNIT}};'
				],
                'condition' => [
                    'type' => 'pe--clients--carousel'
                ]
			]
		);
        $this->add_responsive_control(
			'logos_width',
			[
				'label' => esc_html__( 'Logo Size', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' , 'px' , 'em' , 'vw'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pe--clients.pe--clients--carousel .pe--clients--wrapper>div img' => 'width: {{SIZE}}{{UNIT}};'
				],
                'condition' => [
                    'type' => 'pe--clients--carousel'
                ]
			]
		);
       


        $this->add_control(
            'carousel_direction',
               [
                   'label' => esc_html__('Carousel Direction', 'pe-core'),
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
                    'type' => 'pe--clients--carousel'
                ]
               ]
           );
           

           $this->add_control(
            'carousel_speed',
               [
                   'label'=> esc_html__('Speed', 'pe-core'),
                   'type' => \Elementor\Controls_Manager::NUMBER,
                   'min' => 1,
                   'max' => 100,
                   'step' => 1,
                   'default' => 20,
                   'condition' => [
                    'type' => 'pe--clients--carousel'
                ]
               ]
           );

           $this->add_control(
            'stop_hover',
               [
                    'label' => esc_html__('Stop on Hover?', 'pe-core'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'pe-core'),
                    'label_off' => esc_html__('No', 'pe-core'),
                    'return_value' => true,
                       'default' => false,
                     'description' => esc_html__('Animation will follow scrolling behavior of the page.', 'pe-core'),
               ]
           );

           $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pe--clients .pe--clients--wrapper .pe-client' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

       
        $this->end_controls_section();
       
       
          $this->start_controls_section(
            'section_animate',
            [
                'label' => __( 'Animations', 'pe-core' ),
            ]
         );

        $this->add_control(
            'select_animation',
            [
                'label' => esc_html__('Select Animation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'description' => esc_html__( 'Will be used as intro animation.', 'pe-core' ),
                'options' => [
                'none' => esc_html__('None', 'pe-core'),
                'has-anim anim-multiple fadeIn' => esc_html__('Fade In', 'pe-core'),
                'has-anim anim-multiple fadeUp' => esc_html__('Fade Up', 'pe-core'),
                'has-anim anim-multiple fadeDown' => esc_html__('Fade Down', 'pe-core'),
                'has-anim anim-multiple fadeLeft' => esc_html__('Fade Left', 'pe-core'),
                'has-anim anim-multiple fadeRight' => esc_html__('Fade Right', 'pe-core'),
                'has-anim anim-multiple scaleIn' => esc_html__('Scale In', 'pe-core'),
                'has-anim anim-multiple slideUp' => esc_html__('Slide Up', 'pe-core'),
                'has-anim anim-multiple slideLeft' => esc_html__('Slide Left', 'pe-core'),
                'has-anim anim-multiple slideRight' => esc_html__('Slide Right', 'pe-core'),
                'has-anim anim-multiple maskUp' => esc_html__('Mask Up', 'pe-core'),
                'has-anim anim-multiple maskDown' => esc_html__('Mask Down', 'pe-core'),
                'has-anim anim-multiple maskLeft' => esc_html__('Mask Left', 'pe-core'),
                'has-anim anim-multiple maskRight' => esc_html__('Mask Right', 'pe-core'),

            ],
            'label_block' => true,
        ]
        );
       
       $this->add_control(
			'more_options',
			[
				'label' => esc_html__( 'Animation Options', 'pe-core' ),
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
		'label' => esc_html__( 'Basic', 'pe-core' ),
	   ]
       );
       
       $this->add_control(
        'duration',
           [
               'label'=> esc_html__('Duration', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0.1,
               'step' => 0.1,
               'default' => 1.5
           ]
       );
       
       $this->add_control(
        'delay',
           [
               'label'=> esc_html__('Delay', 'pe-core'),
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
		'label' => esc_html__( 'Advanced', 'pe-core' ),
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
				'label' => esc_html__( 'Start Offset', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
				'label' => esc_html__( 'End Offset', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
       
    pe_cursor_settings($this);
       
       
       pe_color_options($this);

       
    }

    protected function render() {
        $settings = $this->get_settings_for_display(); 
        $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';
         $classes = [];
        
        array_push($classes , [$settings['type'] , $settings['background'] , $settings['hover'] , $settings['hover-switch'] , $settings['captions'] ,  $settings['bordered'] , $animation]);
        $mainClasses = implode(' ' , array_filter($classes[0]));
        

        
        // Animations 
       $start = $settings['start_offset'] ? $settings['start_offset']['size'] : 0;
        $end = $settings['end_offset'] ? $settings['end_offset']['size'] : 0;
        $out = $settings['animate_out'] ? $settings['animate_out'] : 'false';
        
        $dataset = '{'. 
            'duration=' . $settings['duration'] . ''.
            ';delay=' . $settings['delay'] . ''.
            ';stagger=' . $settings['stagger'] . ''.
            ';pin=' . $settings['pin'] . ''.
            ';pinTarget=' . $settings['pin_target'] . ''.
            ';scrub=' . $settings['scrub'] . ''.
            ';markers=' . $settings['show_markers'] . ''.
            ';start=' . $start . ''.
            ';startpov=' . $settings['anim_start'] . ''.
            ';end=' . $end . ''.
            ';endpov=' . $settings['anim_end'] . ''.
            ';out=' . $out . ''.
        '}';

        $checkMarkers = '';
        
       if ( \Elementor\Plugin::$instance->editor->is_edit_mode() && $settings['show_markers'] ) {
            $checkMarkers = ' markers-on';
       }
        
       //Scroll Button Attributes
      $this->add_render_attribute(
		'animation_settings',
		  [
              'class' => [$animation],
              'data-settings' => $dataset,
              
		  ]
	   );
        $animationSettings = $settings['select_animation'] !== 'none' ? $this->get_render_attribute_string('animation_settings') :'';

              
       //Scroll Button Attributes
      $this->add_render_attribute(
		'carousel-sett',
		  [
              'data-speed' => $settings['carousel_speed'],
              'data-direction' => $settings['carousel_direction'],
              'data-hover' => $settings['stop_hover']
              
		  ]
	   );
        $carouselSett = $settings['type'] === 'pe--clients--carousel' ? $this->get_render_attribute_string('carousel-sett') :'';
        
        $cursor = pe_cursor($this);

?>


<!-- Pe Clients Grid -->
<div class="pe--clients <?php echo esc_attr($mainClasses); ?>" <?php echo $animationSettings . $carouselSett; ?>>

    <div class="pe--clients--wrapper">

        <?php if ($settings['client']) {

        foreach ( $settings['client'] as $key => $item ) { 
    ?>


        <?php if ($animation) { ?>
        <!-- Animation Wrap -->
        <div class="inner--anim">
            <!-- Animation Wrap -->
            <?php } ?>

            <!-- Client -->
            <div class="pe-client">

                <a href="<?php echo esc_url($item['client_url']['url']) ?>" <?php echo $cursor ?>>

                    <?php if ($item['secondary_logo'] === 'true') { ?>

                    <img class="secondary-img" src="<?php echo esc_url($item['client_secondary_logo']['url']) ?>">

                    <?php } ?>

                    <img class="main-img" src="<?php echo esc_url($item['client_logo']['url']) ?>">

                    <span class="client-caption"><?php echo esc_html($item['client_title']) ?></span>

                </a>

            </div>
            <!--/ Client -->


            <?php if ($animation) { ?>
            <!-- Animation Wrap End -->
        </div>
        <!-- Animation Wrap End -->
        <?php } ?>


        <?php } } ?>

    </div>


</div>
<!--/ Pe Clients Grid -->


<?php 
    }

}
