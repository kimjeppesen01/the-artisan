<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeSinglePost extends Widget_Base {
 
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
    return 'pesinglepost';
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
    return __( 'Single Post', 'pe-core' );
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
    return 'eicon-post-content pe-widget';
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

      
      $options = [];

        $projects = get_posts( [
            'post_type'  => 'post',
            'numberposts' => -1
        ] );

        foreach ( $projects as $project ) {
            $options[ $project->ID ] = $project->post_title;
        }
      
        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Single Post', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

      
        $this->add_control(
			'select_post',
			[
				'label' => __( 'Select Post', 'pe-core'),
				'label_block' => true,
                'description' => __('Select post which will display in the widget.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
			]
		);
       
       

       
        $this->add_control(
            'thumb',
            [
                'label' => esc_html__('Show Thumbnail', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",

                
            ]
        );
       
       $this->add_control(
            'date',
            [
                'label' => esc_html__('Show Date', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",

                
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

                
            ]
        );

       
        $this->add_control(
            'excerpt',
            [
                'label' => esc_html__('Excerpt', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",

                
            ]
        );
       
       $this->add_control(
            'button',
            [
                'label' => esc_html__('Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",
            ]
        );
       
       
       $this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Read More Text', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type your button text here', 'pe-core' ),
				'default' => esc_html__( 'Read More', 'pe-core' ),
                 'condition' => ['button' => 'true'],
			]
		);

       
       $this->add_control(
            'custom_height',
            [
                'label' => esc_html__('Custom Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',

                
            ]
        );
       
       $this->add_responsive_control(
			'post_height',
			[
				'label' => esc_html__( 'Height', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
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
					'{{WRAPPER}} .thmb'=> 'height: {{SIZE}}{{UNIT}};',
				],
                  'condition' => ['custom_height' => 'yes'],
			]
		);
       



		$this->end_controls_section();
       
            pe_cursor_settings($this);

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
                'has-anim fadeIn' => esc_html__('Fade In', 'pe-core'),
                'has-anim fadeUp' => esc_html__('Fade Up', 'pe-core'),
                'has-anim fadeDown' => esc_html__('Fade Down', 'pe-core'),
                'has-anim fadeLeft' => esc_html__('Fade Left', 'pe-core'),
                'has-anim fadeRight' => esc_html__('Fade Right', 'pe-core'),
                'has-anim scaleIn' => esc_html__('Scale In', 'pe-core'),
                'has-anim slideUp' => esc_html__('Slide Up', 'pe-core'),
                'has-anim slideLeft' => esc_html__('Slide Left', 'pe-core'),
                'has-anim slideRight' => esc_html__('Slide Right', 'pe-core'),
                'has-anim maskUp' => esc_html__('Mask Up', 'pe-core'),
                'has-anim maskDown' => esc_html__('Mask Down', 'pe-core'),
                'has-anim maskLeft' => esc_html__('Mask Left', 'pe-core'),
                'has-anim maskRight' => esc_html__('Mask Right', 'pe-core'),

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
 
       
           $this->start_controls_section(
			'project_elements',
			[
                
				'label' => esc_html__( 'Style', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
       
        $this->add_control(
			'text_type',
			[
				'label' => esc_html__( 'Title Type', 'pe-core' ),
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
				'default' => 'h6',
				'toggle' => true,
			]
		);
       
         $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'ttitle_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .post-title',
			]
		);
       
       
        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',

                
            ]
        );
       

       
       $this->add_control(
			'button_style',
			[
				'label' => esc_html__( 'Button Style', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'underline',
				'options' => [
					'underline' => esc_html__( 'Underline', 'pe-core' ),
					'outline' => esc_html__( 'Outline', 'pe-core' ),
					'fill' => esc_html__( 'Fill', 'pe-core' ),
		
				],
                'condition' => ['button' => 'true'],

			]
		);
     $this->add_control(
        'show_icon',
           [
                'label' => esc_html__('Show Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
               'condition' => ['button' => 'true'],
           ]
       );
              
         $this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
                 'condition' => [
                     'show_icon' => 'yes',
                     'button' => 'true'
                 ],
			]
		);
       
         $this->add_control(
			'icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'icon-left' => [
						'title' => esc_html__( 'Left', 'pe-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'icon-right' => [
						'title' => esc_html__( 'Right', 'pe-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'icon-right',
				'toggle' => false,
                 'condition' => [
                     'show_icon' => 'yes',
                     'button' => 'true'
                 ],

			]
		);
       
       
        $this->end_controls_section();

        $this->start_controls_section(
            'blog_posts_typography',
            [
                'label' => esc_html__('Typography', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--single--post .post-title'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => esc_html__('Excerpt', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--single--post .post-excerpt p'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Button', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--single--post .post-button a'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'label' => esc_html__('Category', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--single--post .post-categories a'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'label' => esc_html__('Date', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--single--post .post-date'
            ]
        );







        $this->end_controls_section();
       

       
       pe_color_options($this);

       
       
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
           $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';
         $classes = [];
        
          $classes[] = 'pe--single--post psp--elementor ' . $animation . '';
        
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


        
        $id = $settings['select_post'];
        $thumb = $settings['thumb'];
        $date = $settings['date'];
        $category = $settings['cat'];
        $excerpt = $settings['excerpt'];
        $button = $settings['button'];
        $read = $settings['button_text'];
        
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 1,
            'post__in'=> array($id),
            'post__not_in' => get_option("sticky_posts"),
            );
        
        
         $loop = new \WP_Query( $args ); 
            
        $cursor = pe_cursor($this);
        
?>

<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>  <?php echo $animationSettings; ?>>

    <?php if($thumb) { 
            
        echo '<div class="thmb">';
            
            pe_post_thumbnail(); 
        
         echo '</div>';
        }?>



    <?php if ($date || $category) { ?>

    <!-- Meta -->
    <div class="post-meta">

        <?php if ($category) { ?>
        <div class="post-categories"><?php 		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'pe-core' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( '%1$s', 'pe-core' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

		} ?>
        </div>

        <?php } ?>

        <?php if ($date) { ?>
        <div class="post-date">
            <?php pe_posted_on(); ?>
        </div>
        <?php } ?>

    </div>
    <!--/ Meta -->

    <?php } ?>


    <!-- Post Details -->
    <div class="post-details">



        <!-- Title -->
        <a href="<?php echo esc_url( get_permalink() ) ?>" <?php echo $cursor ?>>


            <?php echo '<'. $settings['text_type'] .' class="post-title entry-title">' . get_the_title() . '</'. $settings['text_type'] .'>'; ?>


        </a>
        <!--/ Title -->

        <?php if ($excerpt) { ?>
        <div class="post-excerpt">
            <?php the_excerpt() ?>
        </div>
        <?php } ?>


        <?php if ($button) { 
            
             $iconPos = '';
        
        if ($settings['show_icon'] === 'yes') {
            
              $iconPos = $settings['icon_position'] ;
        }
        
             $buttonClasses = $settings['button_style'] .' '. $iconPos
        
        ?>
        <!-- Button -->
        <div class="post-button">

            <!--  Button -->
            <div class="pe-button <?php echo esc_attr($buttonClasses); ?>">


                <a href="<?php echo esc_url( get_permalink() ) ?>" <?php echo $cursor ?>><?php echo esc_html($read) ?></a>

            </div>
            <!--/ Button -->

        </div>
        <!--/ Button -->

        <?php } ?>

    </div>
    <!--/ Post Details -->

</article>


<?php endwhile; wp_reset_query(); ?>


<?php 
    }

}
