<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeMarquee extends Widget_Base {
 
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
    return 'pemarquee';
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
    return __( 'Marquee', 'pe-core' );
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
    return 'eicon-animation-text pe-widget';
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
                'label' => __( 'Marquee', 'pe-core' ),
            ]
        );

        $this->add_control(
            'marquee_text',
           [
               'label' => esc_html__('Text', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXTAREA,
               'placeholder' => esc_html__('Write your text here', 'pe-core'),
               'rows' => 3,
               'default' => esc_html('Marquee Text' , 'pe-core')
           ]
        );
       
         $this->add_control(
        'link',
           [
                'label' => esc_html__('Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',
           ]
       );
       
       
       $this->add_control(
			'marquee_link',
			[
				'label' => esc_html__( 'Link', 'pe-core' ),
				'description' => esc_html__( 'Leave it emtpy if you dont want to link marquee.', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
                 'condition' => ['link' => 'yes'],
			]
		);
       
       $this->add_control(
			'text_type',
			[
				'label' => esc_html__( 'Text Type', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'h1' => [
						'title' => esc_html__( 'H1', 'pe-core' ),
						'icon' => ' eicon-editor-h1',
					],
                    'h2' => [
						'title' => esc_html__( 'H2', 'pe-core' ),
						'icon' => ' eicon-editor-h2',
					],
                    'h3' => [
						'title' => esc_html__( 'H3', 'pe-core' ),
						'icon' => ' eicon-editor-h3',
					],
                    'h4' => [
						'title' => esc_html__( 'H4', 'pe-core' ),
						'icon' => ' eicon-editor-h4',
                    ],
                    'h5' => [
						'title' => esc_html__( 'H5', 'pe-core' ),
						'icon' => ' eicon-editor-h5',
					],
                    'h6' => [
						'title' => esc_html__( 'H6', 'pe-core' ),
						'icon' => ' eicon-editor-h6',
					]

				],
				'default' => 'h1',
				'toggle' => true,
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
                   'condition' => ['text_type' => 'h1'],
        ]
        );
       
	$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .pe-marquee *, {{WRAPPER}} .pe-marquee .seperator',
			]
		);
       
        $this->add_control(
            'seperator_type',
            [
                'label' => esc_html__('Seperator Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'image' => esc_html__('Image', 'pe-core'),
                ],
            ]
        );
       
        $this->add_control(
            'marquee_seperator',
            [
                'label' => esc_html__('Seperator', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'seperator_type' => 'icon'
                ]
            ]
        );
       
        $this->add_control(
            'marquee_image',
            [
                'label' => esc_html__('Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                'condition' => [
                    'seperator_type' => 'image'
                ]
            ]
        );
       
       $this->add_responsive_control(
        'image_width',
           [
               'label' => esc_html__('Image Width', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SLIDER,
               'size_units' => ['px'],
               'range' => [
                   'px' => [
                       'min' => 0,
                       'max' => 300,
                       'step' => 1
                   ]
               ],
               'default' => [
                   'unit' => 'px',
                   'size' => 120
               ],
               'selectors' => [
                   '{{WRAPPER}} .seperator' => 'width: {{SIZE}}{{UNIT}}'
               ],
               'condition' => [
                   'seperator_type' => 'image'
               ]
           ]
       );
       
        $this->add_responsive_control(
            'marquee_space', 
            [
                'label' => esc_html__('Space Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40
                ],
                'selectors' => [
                    '{{WRAPPER}} .seperator' => 'width: {{SIZE}}{{UNIT}}'
                ],
                'condition' => [
                    'seperator_type' => 'none'
                ]
            ]
       );
       
       $this->add_responsive_control(
			'seperator_size',
			[
				'label' => esc_html__( 'Seperator Size', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .pe-marquee .seperator i' => 'font-size: {{SIZE}}{{UNIT}}!important',
					'{{WRAPPER}} .pe-marquee .seperator svg' => 'width: {{SIZE}}{{UNIT}}',
				],
                'condition' => [ 'seperator_type' => 'icon' ]
			]
		);
       
        $this->add_responsive_control(
			'seperator_spacing',
			[
				'label' => esc_html__( 'Seperator Spacing', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .pe-marquee .marquee-wrap' => 'gap: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .pe-marquee' => 'gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_control(
            'marquee_has_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => 'marquee-bg-',
                'default' => 'no',
            ]
        );

       
        $this->end_controls_section();

       
        $this->start_controls_section(
			'animate',
			[
				'label' => esc_html__( 'Animate' , 'pe-core'),
			]
		);
       
       $this->add_control(
        'slip_direction',
           [
               'label' => esc_html__('Slip Direction', 'pe-core'),
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
               'label_block' => true
           ]
       );
       
     
      
       $this->add_control(
        'data_duration',
           [
               'label'=> esc_html__('Duration', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0.1,
               'step' => 0.1,
               'default' => 10
           ]
       );
       
        $this->add_control(
        'seperator_rotate',
           [
                'label' => esc_html__('Seperator Rotate', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'pe-core'),
                'label_off' => esc_html__('Off', 'pe-core'),
                'return_value' => 'rotating_seperator',
                'condition' => [
                    'seperator_type' => ['icon', 'image']
                ]
           ]
       );
       
       $this->add_control(
        'seperator_duration', 
           [
               'label' => esc_html__('Seperator Duration', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 1,
               'max' => 200,
               'step' => 1,
               'default' => 10
           ]
       );
       
        $this->add_control(
            'seperator_direction',
            [
                'label' => esc_html__('Counter Clockwise', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'pe-core'),
                'label_off' => esc_html__('Off', 'pe-core'),
                'return_value' => 'counter-clockwise'
            ]
        );
       
    $this->end_controls_section();
       
        $this->start_controls_section(
            'cursor_interactions',
            [
                'label' => __( 'Cursor Interactions', 'pe-core' ),
            ]
            );
       
            $this->add_control(
			'cursor_type',
			[
				'label' => esc_html__( 'Interaction', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'pe-core' ),
					'text' => esc_html__( 'Text', 'pe-core' ),
					'icon' => esc_html__( 'Icon', 'pe-core' ),
					'none' => esc_html__( 'None', 'pe-core' ),
		
				],

			]
		);
       
       	$this->add_control(
			'cursor_icon',
			[
				'label' => esc_html__( 'Icon', 'pe-core' ),
				'description' => esc_html__( 'Only Material Icons allowed, do not select Font Awesome icons.', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
                     'condition' => ['cursor_type' => 'icon'],
			]
		);
       
       $this->add_control(
			'cursor_text',
			[
				'label' => esc_html__( 'Icon', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                 'condition' => ['cursor_type' => 'text'],
			]
		);
       
       
          $this->end_controls_section();      
       
       pe_color_options($this);

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $cursorType = $settings['cursor_type'];
        $cursorInteraction = '';
        $cursorSettings = '';
        
        if ($cursorType !== 'none') {
            
            $cursorInteraction = ' cursor-' . $cursorType;
            
            if ($cursorType === 'icon') {
                
                  $str = $settings['cursor_icon']['value'];
            $delimiter = ' ';
            $icon = explode($delimiter, $str);
            
            $lib = 'data-lib="' . str_replace('-', ' ',$icon[0]) . '"';
            $ico = 'data-cursor-icon="' . $icon[1] . '"';
            $ico = 'data-cursor-icon="' . str_replace('md-', '',$icon[1]) . '"';
            
            $cursorSettings = $lib . ' ' . $ico;
                
            } else if ($cursorType === 'text') {
                
                $cursorText = 'data-cursor-text="' . $settings['cursor_text'] . '"';
                 $cursorSettings = $cursorText;
            }
          
            
        } else {
            
            $cursorInteraction = ' no-cursor-interaction';
        }

             
        ob_start();

        \Elementor\Icons_Manager::render_icon( $settings['marquee_seperator'], [ 'aria-hidden' => 'true' ] );

        $seperator_icon = ob_get_clean();
   
        

?>

<?php if ( ! empty( $settings['marquee_link']['url'] ) ) {
			$this->add_link_attributes( 'marquee_link', $settings['marquee_link'] );
             ?>

<a <?php echo $this->get_render_attribute_string( 'marquee_link' ); ?>>
    <?php }
        
        ?>
      <?php  echo '<' . $settings['text_type']; ?> class="pe-marquee <?php echo $settings['seperator_rotate'] .' '. $settings['slip_direction'] .' ' . $settings['seperator_direction']. ' ' . $cursorInteraction ?>" <?php echo 'data-duration=' . $settings['data_duration'] .' data-sepduration='. $settings['seperator_duration'];  ?> <?php echo $cursorSettings; ?>>


        <?php  echo '<span' . ' class="' . $settings['heading_size'] . '">' . $settings['marquee_text'] . '</span>' ?>

        <div class="seperator <?php echo $settings['heading_size']?>"> 

            <?php if ($settings['seperator_type'] === 'icon') { ?>

            <?php echo $seperator_icon; ?>

            <?php } else if ($settings['seperator_type'] === 'image') { ?>

            <!--                <div class="seperator-image">-->
            <?php
                    echo '<img src="' . $settings['marquee_image']['url'] . '">';
                    ?>
            <!--                </div>-->

            <?php } ?>




        </div>



   <?php echo '</'.  $settings['text_type'] . '>'; ?>
    <?php if ( ! empty( $settings['marquee_link']['url'] ) ) { echo '</a>'; } ?>

    <?php 
    }

}
