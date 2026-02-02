<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeTabs extends Widget_Base {
 
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
    return 'peinfinitetabs';
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
    return __( 'Pe Tabs', 'pe-core' );
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
    return 'eicon-tabs pe-widget';
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
                'label' => __( 'Infinite Tabs', 'pe-core' ),
            ]
        );

        $repeater = new \Elementor\Repeater();


		$repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__( 'Tab Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'pe-core' ),
				'label_block' => true,
			]
		);
       
              
        $repeater->add_control(
			'content_columns',
			[
				'label' => __( 'Content Columns', 'pe-core'),
				'label_block' => true,
                'default' => '1-1-1-1',
                'type' => \Elementor\Controls_Manager::SELECT,
              	'options' => [
					'1-1-1-1' => esc_html__( '25% / 25% / 25% / 25%', 'pe-core' ),
					'1-1-2' => esc_html__( '25% / 25% / 50%', 'pe-core' ),
                    '2-1-1' => esc_html__( '50% / 25% / 25%', 'pe-core' ),
					'2-2' => esc_html__( '50% / 50%', 'pe-core' ),
					'1-3' => esc_html__( '25% / 75%', 'pe-core' ),
					'3-1' => esc_html__(  '75% / 25%', 'pe-core' ),
				],
			]
		);
       
		$repeater->add_control(
			'1-1-1-1_1_content',
			[
				'label' => esc_html__( 'Column 1 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                'condition' => ['content_columns' => '1-1-1-1'],
			]
		);
       
       $repeater->add_control(
			'1-1-1-1_2_content',
			[
				'label' => esc_html__( 'Column 2 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '1-1-1-1'],
			]
		);
       
       $repeater->add_control(
			'1-1-1-1_3_content',
			[
				'label' => esc_html__( 'Column 3 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '1-1-1-1'],
			]
		);
       
       $repeater->add_control(
			'1-1-1-1_4_content',
			[
				'label' => esc_html__( 'Column 4 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '1-1-1-1'],
			]
		);
       
       $repeater->add_control(
			'1-1-2_1_content',
			[
				'label' => esc_html__( 'Column 1 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '1-1-2'],
			]
		);
       
       $repeater->add_control(
			'1-1-2_2_content',
			[
				'label' => esc_html__( 'Column 2 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '1-1-2'],
			]
		);
       
       $repeater->add_control(
			'1-1-2_3_content',
			[
				'label' => esc_html__( 'Column 3 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '1-1-2'],
			]
		);
       
       $repeater->add_control(
			'2-1-1_1_content',
			[
				'label' => esc_html__( 'Column 1 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '2-1-1'],
			]
		);
       
       $repeater->add_control(
			'2-1-1_2_content',
			[
				'label' => esc_html__( 'Column 2 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '2-1-1'],
			]
		);
       
       $repeater->add_control(
			'2-1-1_3_content',
			[
				'label' => esc_html__( 'Column 3 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '2-1-1'],
			]
		);
       
       $repeater->add_control(
			'2-2_1_content',
			[
				'label' => esc_html__( 'Column 1 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '2-2'],
			]
		);
       
       $repeater->add_control(
			'2-2_2_content',
			[
				'label' => esc_html__( 'Column 2 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '2-2'],
			]
		);
       
       $repeater->add_control(
			'1-3_1_content',
			[
				'label' => esc_html__( 'Column 1 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '1-3'],
			]
		);
       
       $repeater->add_control(
			'1-3_2_content',
			[
				'label' => esc_html__( 'Column 2 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '1-3'],
			]
		);
       
       $repeater->add_control(
			'3-1_1_content',
			[
				'label' => esc_html__( 'Column 1 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '3-1'],
			]
		);
       
       $repeater->add_control(
			'3-1_2_content',
			[
				'label' => esc_html__( 'Column 2 Content', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                  'condition' => ['content_columns' => '3-1'],
			]
		);
       
       

		$this->add_control(
			'infinite_tabs',
			[
				'label' => esc_html__( 'Infinite Tabs', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => esc_html__( 'Tab Title #1', 'pe-core' ),
						'tab_content_normal' => esc_html__( 'Item content. Click the edit button to change this text.', 'pe-core' ),
					],
                    [
						'tab_title' => esc_html__( 'Tab Title #2', 'pe-core' ),
						'tab_content_normal' => esc_html__( 'Item content. Click the edit button to change this text.', 'pe-core' ),
					],
                    
                    [
						'tab_title' => esc_html__( 'Tab Title #3', 'pe-core' ),
						'tab_content_normal' => esc_html__( 'Item content. Click the edit button to change this text.', 'pe-core' ),
					],

				],
				'title_field' => '{{{ tab_title }}}',
			]
		);
       
       	$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Titles Typography', 'pe-core' ),
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .tab-title',
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
                'default' => '',
                'description' => esc_html__( 'Will be used as intro animation.', 'pe-core' ),
                'options' => [
                    '' => esc_html__('None', 'pe-core'),
                'has-anim-text charsUp' => esc_html__('Chars Up', 'pe-core'),
                'has-anim-text charsDown' => esc_html__('Chars Down', 'pe-core'),
                'has-anim-text charsRight' => esc_html__('Chars Right', 'pe-core'),
                'has-anim-text charsLeft' => esc_html__('Chars Left', 'pe-core'),
                'has-anim-text wordsUp' => esc_html__('Words Up', 'pe-core'),
                'has-anim-text wordsDown' => esc_html__('Words Down', 'pe-core'),
                'has-anim-text linesUp' => esc_html__('Lines Up', 'pe-core'),
                'has-anim-text linesDown' => esc_html__('Lines Down', 'pe-core'),
                'has-anim-text charsFadeOn' => esc_html__('Chars Fade On', 'pe-core'),
                'has-anim-text wordsFadeOn' => esc_html__('Words Fade On', 'pe-core'),
                'has-anim-text linesFadeOn' => esc_html__('Lines Fade On', 'pe-core'),
                'has-anim-text charsScaleUp' => esc_html__('Chars Scale Up', 'pe-core'),
                'has-anim-text charsScaleDown' => esc_html__('Chars Scale Down', 'pe-core'),
                'has-anim-text charsRotateIn' => esc_html__('Chars Rotate In', 'pe-core'),
                'has-anim-text charsFlipUp' => esc_html__('Chars Flip Up', 'pe-core'),
                'has-anim-text charsFlipDown' => esc_html__('Chars Flip Down', 'pe-core'),
                'has-anim-text linesMask' => esc_html__('Lines Mask', 'pe-core'),
                'has-anim-text slideLeft' => esc_html__('Slide Left', 'pe-core'),
                'has-anim-text slideRight' => esc_html__('Slide Right', 'pe-core'),
            ],
            'label_block' => true
        ]
        );
       
       $this->add_control(
        'fade',
           [
                'label' => esc_html__('Fade', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'fade',

           ]
       );
       
        $this->add_control(
        'data_duration',
           [
               'label'=> esc_html__('Duration', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0.1,
               'step' => 0.1,
               'default' => 1.5
           ]
       );
       
       $this->add_control(
        'data_delay',
           [
               'label'=> esc_html__('Delay', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0,
               'step' => 0.1,
               'default' => 0
           ]
       );

       $this->add_control(
        'data_stagger',
           [
               'label' => esc_html__('Stagger', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0,
               'max' => 1,
               'step' => 0.01,
               'default' => 0.1
           ]
       );
       
       $this->add_control(
        'data_scrub',
           [
                'label' => esc_html__('Scrub', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
               	'default' => 'false',

           ]
       );
       
       $this->add_control(
        'data_pin',
           [
                'label' => esc_html__('Pin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
               	'default' => 'false',
                'condition' => ['select_animation' => 'text-h1'],

           ]
       );
     
        $this->end_controls_section();

       
       $this->start_controls_section(
			'Style',
			[
                
				'label' => esc_html__( 'Style', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
       
       

       
        $this->end_controls_section();
       
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $tabs = $settings['infinite_tabs'];
        
          $animation = $settings['select_animation'] . ' ' . $settings['fade'];
        $animationAttributes = 'data-stagger="' .  $settings['data_stagger'] . '" data-duration="' . $settings['data_duration'] . '"' . 'data-delay="' .  $settings['data_delay'] . '"' . 'data-scrub="' .  $settings['data_scrub'] . '" data-pin="' .  $settings['data_pin'] . '"';


?>

<!-- Pee Infinite Tabs -->
<div class="pe-infinite-tabs" data-duration='0.5'>


    <!-- Tab Titles Wrap -->
    <ul class="tab-title-wrap">

        <?php foreach ( $tabs as $key => $item ) { ?>

        <li class="tab-title md-title <?php echo $animation; ?> <?php if ($key == 0) { echo 'active'; }  ?>" <?php echo $animationAttributes ?>>
            <?php echo esc_html($item['tab_title']) ?>
        </li>

        <?php } ?>

    </ul>
    <!--/Tab Titles Wrap -->

    <!-- Tab Contents Wrap -->
    <div class="tab-contents-wrap">
        
           <?php foreach ( $tabs as $key => $item ) { 
            
        ?>
            
                <!-- Tab Content -->
        <div class="tab-content <?php if ($key == 0) { echo 'active'; }  ?>">
            
            <?php $cols = $item['content_columns']; ?>
            
            <?php if ($cols === '1-1-1-1') { ?>
            
            <div class="c-col-3 sm-12">
                
                <?php echo do_shortcode($item['1-1-1-1_1_content']) ?>
            
            </div>
            <div class="c-col-3 sm-12">
            
                <?php echo do_shortcode($item['1-1-1-1_2_content']) ?>
                
            </div>
            <div class="c-col-3 sm-12">
                
                <?php echo do_shortcode($item['1-1-1-1_3_content']) ?>
            
            </div>
            <div class="c-col-3 sm-12">
                
                <?php echo do_shortcode($item['1-1-1-1_4_content']) ?>
            
            </div>
            <?php } ?>
            
                        <?php if ($cols === '1-1-2') { ?>
            
            <div class="c-col-3 sm-12">
                
                  <?php echo do_shortcode($item['1-1-2_1_content']) ?>
            
            </div>
            <div class="c-col-3 sm-12">
                
                      <?php echo do_shortcode($item['1-1-2_2_content']) ?>
            
            </div>
            <div class="c-col-6 sm-12">
                
      <?php echo do_shortcode($item['1-1-2_3_content']) ?>

            </div>

            <?php } ?>
            
            <?php if ($cols === '2-1-1') { ?>
            
            <div class="c-col-6 sm-12">
                
                 <?php echo do_shortcode($item['2-1-1_1_content']) ?>
            
            </div>
            <div class="c-col-3 sm-12">
            
                 <?php echo do_shortcode($item['2-1-1_2_content']) ?>
            
            </div>
            <div class="c-col-3 sm-12">
            
                 <?php echo do_shortcode($item['2-1-1_3_content']) ?>
            
            </div>

            <?php } ?>
            
            <?php if ($cols === '2-2') { ?>
            
            <div class="c-col-6 sm-12">
            
                 <?php echo do_shortcode($item['2-2_1_content']) ?>
            
            </div>
            <div class="c-col-6 sm-12">
                
                   <?php echo do_shortcode($item['2-2_2_content']) ?>
            
            </div>

            <?php } ?>
            
            <?php if ($cols === '1-3') { ?>
            
            <div class="c-col-3 sm-12">
            
               <?php echo do_shortcode($item['1-3_1_content']) ?>
            
            </div>
            <div class="c-col-9 sm-12">
                
                   <?php echo do_shortcode($item['1-3_2_content']) ?>
            
            </div>

            <?php } ?>
            
            <?php if ($cols === '3-1') { ?>
            
            <div class="c-col-9 sm-12">
                
                   <?php echo do_shortcode($item['3-1_1_content']) ?>
            
            </div>
            <div class="c-col-3 sm-12">
                
                 <?php echo do_shortcode($item['3-1_2_content']) ?>
            
            </div>

            <?php } ?>
            
            
        </div>
        <!--/Tab Content -->

        
        <?php } ?>



    </div>
    <!--/Tab Contents Wrap -->

</div>
<!--/Pe Infinite Tabs -->






<?php 
    }

}
