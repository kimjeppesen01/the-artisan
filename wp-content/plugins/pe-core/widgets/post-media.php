<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PePostMedia extends Widget_Base {
 
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
    return 'pepostmedia';
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
    return __( 'Post Image', 'pe-core' );
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
    return 'eicon-image pe-widget';
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
    return [ 'pe-dynamic' ];
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
                'label' => __( 'Post Image', 'pe-core' ),
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

       
       $this->add_control(
        'alignment',
           [
               'label' => esc_html__('Alignment', 'pe-core'),
               'type' => \Elementor\Controls_Manager::CHOOSE,
               'options' => [
                   'align-left' => [
                       'title' => esc_html__('Left', 'pe-core'),
                       'icon' => 'eicon-text-align-left',
                   ],
                   'align-center' => [
                       'title' => esc_html__('Center', 'pe-core'),
                       'icon' => 'eicon-text-align-center'
                   ],
                   'align-right' => [
                       'title' => esc_html__('Right', 'pe-core'),
                       'icon' => 'eicon-text-align-right',
                   ],
               ],
               'default' => 'align-left',
               'toggle' => true,
               'label_block' => true
           ]
       );
       
      $this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
					'{{WRAPPER}} .single-image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
       
       $this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors' => [
					'{{WRAPPER}} .single-image' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
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
            ]
            );
        
       
//       $this->add_responsive_control(
//			'height',
//			[
//				'label' => esc_html__( 'Height', 'pe-core' ),
//				'type' => \Elementor\Controls_Manager::SLIDER,
//				'size_units' => [ 'px', 'vh' ],
//				'range' => [
//					'px' => [
//						'min' => 0,
//						'max' => 1000,
//						'step' => 5,
//					],
//					'vh' => [
//						'min' => 0,
//						'max' => 100,
//                        'step' => 1,
//					],
//				],
//				'selectors' => [
//					'{{WRAPPER}} .single-image' => 'height: {{SIZE}}{{UNIT}};',
//				],
//			]
//		);
       


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

	   	pe_image_animation_settings($this);

       
    }

    protected function render() {
        $settings = $this->get_settings_for_display();


		global $wp_query;
      
   	
		
	 $args = array(  
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'order' => 'ASC'
    );

    $loop = new \WP_Query( $args ); 
    wp_reset_postdata(); 
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		
   		 while ( $loop->have_posts() ) : $loop->the_post();  
		
			$id = get_the_ID();
        
 			endwhile; wp_reset_query();

 			} else {
				$id = $wp_query->post->ID;
			}
		
        
?>

<div class="single-image <?php echo $settings['parallax'] ?>" <?php echo pe_image_animation($this); ?>>

	<?php 
		
        saren_post_thumbnail($id);
 
	?>


</div>


<?php 
    }

}
