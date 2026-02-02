<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeSlider extends Widget_Base {
 
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
    return 'pe-slider';
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
    return __( 'Pe Slider', 'pe-core' );
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
    return 'eicon-accordion pe-widget';
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
                'label' => __( 'Slider', 'pe-core' ),
            ]
        );
        
        $this->add_control(
            'direction',
            [
                'label' => esc_html__('Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical' => esc_html__('Vertical', 'pe-core'),
                    '' => esc_html__('Horizontal', 'pe-core')
                ]
            ]
        );
       
       $this->add_control(
        'nav_type', 
           [
               'label' => esc_html__('Navigation Type', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SELECT,
               'options' => [
                   'nav_scroll' => esc_html__('Scroll', 'pe-core'),
                   'nav_button' => esc_html__('Buttons', 'pe-core')
               ],
               'default' => 'nav_scrool'
           ]
       );
       
       $this->add_control(
        'button_type',
           [
               'label' => esc_html__('Button Type', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SELECT,
               'options' => [
                   'text' => esc_html__('Text', 'pe-core'),
                   'icon' => esc_html__('Icon', 'pe-core')
               ],
               'deafult' => 'icon',
               'condition' => [
                   'nav_type' => 'nav_button'
               ]
           ]
       );
       
       $this->add_control(
        'next_button_text',
           [
               'label' => esc_html__('Next Text', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => 'Next',
               'placeholder' => esc_html__('Write Your Next Button Text', 'pe-core'),
               'condition' => [
                   'nav_type' => 'nav_button',
                   'button_type' => 'text'
               ]
           ]
       );
       
       $this->add_control(
        'prev_button_text',
           [
               'label' => esc_html__('Prev Text', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => 'Prev',
               'placeholder' => esc_html__('Write Your Next Button Text', 'pe-core'),
               'condition' => [
                   'nav_type' => 'nav_button',
                   'button_type' => 'text'
               ]
           ]
       );
       
        $this->add_control(
            'next_button_icon',
            [
                'label' => esc_html__('Next Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                   'nav_type' => 'nav_button',
                   'button_type' => 'icon'
               ]
            ]
        );
       
       $this->add_control(
            'prev_button_icon',
            [
                'label' => esc_html__('Prev Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                   'nav_type' => 'nav_button',
                   'button_type' => 'icon'
               ]
            ]
        );
       
       $this->add_control(
        'vertical_nav_alignment',
           [
               'label' => esc_html__('Vertical Nav Alignment', 'pe-core'),
               'type' => \Elementor\Controls_Manager::CHOOSE,
               'options' => [
                   'top' => [
                       'label' => esc_html__('Top', 'pe-core'),
                       'icon' => 'eicon-v-align-top'
                   ],
                   'bottom' => [
                       'label' => esc_html__('Bottom', 'pe-core'),
                       'icon' => 'eicon-v-align-bottom'
                   ]
               ],
               'default' => 'top',
           ]
       );
       
       $this->add_control(
        'parallax',
           [
               'label' => esc_html__('Parallax', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SWITCHER,
               'return_value' => 'parallax',
               'default' => 'parallax'
           ]
       );
       
       $this->add_control(
        'fraction',
           [
               'label' => esc_html__('Fraction', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SWITCHER,
               'return_value' => 'fraction',
               'default' => 'fraction'
           ]
       );

       $this->add_responsive_control(
        'height',
        [
            'label' => esc_html__('Height', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['vh' , 'px', '%'],
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
                '{{WRAPPER}} .pe-slider' => 'height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .pe-slider img' => 'height: 100%;object-fit: cover',

            ],
        ]
    );
       
       $this->add_control(
        'pin_target',
           [
               'label' => esc_html__('Pin Target', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'placeholder' => esc_html__('#pinTarget', 'pe-core'),
           ]
       );
       
       $this->add_control(
        'speed',
           [
               'label' => esc_html__('Speed', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => 5000,
           ]
       );
       
       $this->add_control(
        'slider_type',
           [
               'label' => esc_html__('Type', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SELECT,
               'default' => 'custom',
               'options' => [
                   'blog' => esc_html__('Blog Post', 'pe-core'),
                   'project' => esc_html__('Project', 'pe-core'),
                   'page' => esc_html__('Page', 'pe-core'),
                   'custom' => esc_html__('Custom', 'pe-core')
               ],
           ]
       );
       

        $repeaterBlog = new \Elementor\Repeater();
       
        $options = [];

        $projects = get_posts( [
            'post_type'  => 'post',
            'numberposts' => -1
        ] );

        foreach ( $projects as $project ) {
            $options[ $project->ID ] = $project->post_title;
        }
       
    
       
       
        $repeaterBlog->add_control(
         'post',
          [
             'label' => __( 'Blog Post', 'pe-core' ),
             'type' => \Elementor\Controls_Manager::SELECT,
             'multiple' => true,
             'options' => $options,
            ]
        );    
       
		$this->add_control(
			'select_post',
			[
				'label' => esc_html__( 'Blog Posts', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeaterBlog->get_controls(),
                'condition' => [
                    'slider_type' => 'blog'
                ]
			]
		);
       
       
       $repeaterProject = new \Elementor\Repeater();
               $options = [];

        $projects = get_posts( [
            'post_type'  => 'portfolio',
            'numberposts' => -1
        ] );

        foreach ( $projects as $project ) {
            $options[ $project->ID ] = $project->post_title;
        }
       
       $repeaterProject->add_control(
			'project',
			[
				'label' => __( 'Select Project', 'pe-core'),
				'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
			]
		);
       
       	$this->add_control(
			'select_project',
			[
				'label' => esc_html__( 'Projects', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeaterProject->get_controls(),
                'condition' => [
                    'slider_type' => 'project'
                ]
			]
		);
       
       
       $repeaterPage = new \Elementor\Repeater();
       
    
               $options = [];

        $projects = get_pages();

        foreach ( $projects as $project ) {
            $options[ $project->ID ] = $project->post_title;
        }
       
       
        $repeaterPage->add_control(
			'page',
			[
				'label' => __( 'Select Page', 'pe-core'),
				'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
			]
		);
       
       	$this->add_control(
			'select_page',
			[
				'label' => esc_html__( 'Pages', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeaterPage->get_controls(),
                'condition' => [
                    'slider_type' => 'page'
                ]
			]
		);
       
       $repeaterCustom = new \Elementor\Repeater();
       
       $repeaterCustom->add_control(
        'custom_featured_image_type',
           [
               'label' => esc_html__('Custom Featured Image Type', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SELECT,
               'default' => 'Image',
               'options' => [
                   'image' => esc_html__('Image', 'pe-core'),
                   'video' => esc_html__('Video', 'pe-core')
               ]
           ]
       );
       
       $repeaterCustom->add_control(
        'custom_link',
           [
               'label' => esc_html__('Link', 'pe-core'),
               'type' => \Elementor\Controls_Manager::URL,
               'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'label_block' => true,
           ]
       );
       
       $repeaterCustom->add_control(
        'custom_featured_image',
           [
               'label' => esc_html__('Featured Image', 'pe-core'),
               'type' => \Elementor\Controls_Manager::MEDIA,
               'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
               'condition' => ['custom_featured_image_type' => 'image']
           ]
       );

       $repeaterCustom->add_control(
        'custom_featured_video_provider',
           [
               'label' => esc_html__('Video Provider', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SELECT,
               'default' => 'self',
               'options' => [
                   'self' => esc_html__('Self Hosted', 'pe-core'),
                   'vimeo' => esc_html__('Vimeo', 'pe-core'),
                   'youtube' => esc_html__('Youtube', 'pe-core')
               ],
               'condition' => [
                   'custom_featured_image_type' => 'video'
               ]
           ]
       );
       
       $repeaterCustom->add_control(
        'custom_self_video',
           [
               'label' => esc_html__('Self Video', 'pe-core'),
               'type' => \Elementor\Controls_Manager::MEDIA,
               'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
               'condition' => [
                   'custom_featured_image_type' => 'video',
                   'custom_featured_video_provider' => 'self'
               ]
           ]
       );
       
       $repeaterCustom->add_control(
        'custom_vimeo_id',
           [
               'label' => esc_html__('Vimeo ID', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'placeholder' => esc_html__('Vimeo ID', 'pe-core'),
               'condition' => [
                   'custom_featured_image_type' => 'video',
                   'custom_featured_video_provider' => 'vimeo'
               ]
           ]
       );
       
       $repeaterCustom->add_control(
        'custom_youtube_id',
           [
               'label' => esc_html__('Youtube ID', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'placeholder' => esc_html__('Youtube ID', 'pe-core'),
               'condition' => [
                   'custom_featured_image_type' => 'video',
                   'custom_featured_video_provider' => 'youtube'
               ]
           ]
       );
       
       $repeaterCustom->add_control(
        'custom_title',
           [
               'label' => esc_html__('Title', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'placeholder' => esc_html__('Write Your Title Here', 'pe-core'),
               'label_block' => true
           ]
       );
       
       $repeaterCustom->add_control(
        'custom_category',
           [
               'label' => esc_html__('Category', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'placeholder' => esc_html__('Write Your Category Here','pe-core'),
               'label_block' => true
           ]
       );
       
       $repeaterCustom->add_control(
        'custom_content',
           [
               'label' => esc_html__('Content', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXTAREA,
               'placeholder' => esc_html__('Write Your Content Here', 'pe-core')
           ]
        );
       
       
       $repeaterCustom->add_control(
        'custom_color',
           [
               'label' => esc_html__('Slide Content Color'),
               'type' => \Elementor\Controls_Manager::COLOR,
           ]
       );
       
       $this->add_control(
        'custom_slide',
           [
               'label' => esc_html__('Custom Slide', 'pe-core'),
               'type' => \Elementor\Controls_Manager::REPEATER,
               'fields' => $repeaterCustom->get_controls(),
                'condition' => [
                    'slider_type' => 'custom'
                ]
           ]
       );
       
       
           
       
        $this->end_controls_section();

       pe_cursor_settings($this);
       
        $this->start_controls_section(
			'Style',
			[
				'label' => esc_html__( 'Style', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
    
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typograpy',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .slide-title'
            ]
        );
       
       $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'category_typography',
               'label' => esc_html__('Category Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .slide-category'
           ]
       );
       
       $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'content_typography',
               'label' => esc_html__('Content Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .slide-content'
           ]
       );
       
       $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'nav_typography',
               'label' => esc_html__('Navigate Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .navigate-button'
           ]
       );
       
       $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'fraction_typography',
               'label' => esc_html__('Content Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .pe-fraction span'
           ]
       );
              
       
       
        $this->end_controls_section();
       
       
       
        pe_color_options($this);
       
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $cursor = pe_cursor($this);
        
?>
<div class="pe-slider <?php echo $settings['nav_type'] . ' ' . $settings['parallax'] ?>" data-speed=<?php echo $settings['speed']; ?> data-pin-target=<?php echo $settings['pin_target']; ?> >

    <?php if ($settings['vertical_nav_alignment'] === 'top') { ?>

    <div class="pe-slide-nav-wrap">

        <?php if ($settings['nav_type'] === 'nav_button') { ?>

        <div class="navigation">

            <?php if ($settings['button_type'] === 'text') { ?>

            <div class="navigate-button prev">

                <?php echo $settings['prev_button_text']; ?>

            </div>

            <div class="navigate-button next">

                <?php echo $settings['next_button_text']; ?>

            </div>

            <?php } else if ($settings['button_type'] === 'icon') { ?>

            <div class="navigate-button prev">

                <?php \Elementor\Icons_Manager::render_icon( $settings['prev_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>


            </div>

            <div class="navigate-button next">

                <?php \Elementor\Icons_Manager::render_icon( $settings['next_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>

            </div>


            <?php } ?>


        </div>


        <?php } ?>

        <?php if ($settings['fraction'] === 'fraction') { ?>

        <div class="pe-fraction">

            <span class="active">1</span>

            /

            <span class="total"></span>


        </div>

        <?php } ?>



    </div>

    <?php } ?>

    <div class="slider-wrapper">

        <?php 
        
        
    if ($settings['slider_type'] === 'custom') {
        
        foreach ($settings['custom_slide'] as $item) { ?>

        <div class="pe-slide" style="color: <?php echo $item['custom_color']; ?> ">

            <a href="<?php echo $item['custom_link'] ?>" target="_blank" <?php echo $cursor ?>> </a>

            <div class="slide-image">

                <?php if ($item['custom_featured_image_type'] === 'image'){?>

                <img src="<?php echo $item['custom_featured_image']['url'] ?>">

                <?php } else if ($item['custom_featured_image_type'] === 'video') {
                
            if ('self' === $item['custom_featured_video_provider']) { ?>

                <div class="pe-video p-self no-interactions" data-controls="false">

                    <video autoplay playsinline muted loop style="width: 100%;display: block" class="p-video">
                        <source src="<?php echo $item['custom_self_video']['url'] ?>">
                    </video>

                </div>


                <?php } else if ('vimeo' === $item['custom_featured_video_provider']) { ?>


                <div class="pe-video p-vimeo no-interactions" data-controls="false" data-autoplay=true data-muted=true data-loop=true>

                    <div class="p-video" data-plyr-provider="vimeo" data-plyr-embed-id="<?php echo $item['custom_vimeo_id'] ?>"></div>

                </div>


                <?php } else if ('youtube' === $item['custom_featured_video_provider']) {?>

                <div class="pe-video no-interactions p-youtube" data-controls="false" data-autoplay=true data-muted=true data-loop=true>

                    <div class="p-video" data-plyr-provider="youtube" data-plyr-embed-id="<?php echo $item['custom_youtube_id'] ?>"></div>

                </div>



                <?php } } ?>

            </div>

            <div class="item-wrap">

                <div class="slide-meta">

                    <div class="slide-title text-h6">

                        <?php echo $item['custom_title']; ?>

                    </div>

                    <div class="slide-category">

                        <?php echo $item['custom_category']; ?>

                    </div>

                    <div class="slide-content">

                        <?php echo $item['custom_content']; ?>

                    </div>

                </div>

            </div>

        </div>


        <?php }
    
    } else if ('project' === $settings['slider_type']) { ?>


        <?php foreach ($settings['select_project'] as $project) { ?>



        <div class="pe-slide">

            <a href="<?php echo esc_url(get_the_permalink($project['project'])) ?>" style='color: <?php echo get_field('primary_color', $project['project']) ?>' target="_blank" <?php echo $cursor ?>>

                <div class="slide-image">

                    <?php if (get_field('featured_image_type', $project['project']) === 'image') { ?>

                    <img src="<?php echo get_the_post_thumbnail_url($project['project']); ?>">

                    <?php } else if (get_field('featured_image_type', $project['project']) === 'video' ) { if (get_field('video_provider', $project['project']) === 'self' ) { ?>

                    <div class="pe-video p-self no-interactions" data-controls="false">

                        <video autoplay playsinline muted loop style="width: 100%;display: block" class="p-video">

                            <source src="<?php echo get_field('self_video', $project['project']); ?>">

                        </video>

                    </div>

                    <?php } else if (get_field('video_provider', $project['project']) === 'vimeo') { ?>

                    <div class="pe-video p-vimeo no-interactions" data-controls="false" data-autoplay=true data-muted=true data-loop=true>

                        <div class="p-video" data-plyr-provider="vimeo" data-plyr-embed-id="<?php echo esc_attr(get_field('video_id' , $project['project'])) ?>"></div>

                    </div>

                    <?php } else if (get_field('video_provider', $project['project']) === 'youtube') { ?>

                    <div class="pe-video p-youtube no-interactions" data-controls="false" data-autoplay=true data-muted=true data-loop=true>

                        <div class="p-video" data-plyr-provider="vimeo" data-plyr-embed-id="<?php echo esc_attr(get_field('video_id' , $project['project'])) ?>"></div>

                    </div>

                    <?php } } ?>

                </div>

                <div class="item-wrap">

                    <div class="slide-meta">

                        <div class="slide-title text-h6">

                            <?php echo get_the_title($project['project']) ?>

                        </div>

                        <div class='slide-category'>

                            <?php
                        $terms = get_the_terms( $project['project'], 'project-categories' );

                        if ($terms) {

                        foreach($terms as $term) {

                        echo esc_html($term->name);

                        } }
                        ?>

                        </div>

                        <div class="slide-content">

                            <?php echo get_field('project_excerpt', $project['project']); ?>

                        </div>


                    </div>

                </div>
            </a>

        </div>



        <?php } } else if ('blog' === $settings['slider_type']) { ?>

        <?php foreach ($settings['select_post'] as $post) { ?>

        <div class="pe-slide">

            <a href="<?php echo esc_url(get_the_permalink($post['post'])) ?>" style="color: <?php echo get_field('primary_color', $post['post']) ?>" target="_blank" <?php echo $cursor ?>>

                <div class="slide-image">

                    <img src="<?php echo get_the_post_thumbnail_url($post['post']) ?>">

                </div>

                <div class="item-wrap">

                    <div class="slide-meta">

                        <div class="slide-title">

                            <?php echo get_the_title($post['post']); ?>

                        </div>

                        <div class="slide-category">

                            <?php
                        $terms = get_the_terms( $post['post'], 'category' );

                        if ($terms) {

                        foreach($terms as $term) {

                        echo esc_html($term->name);

                        } }
                        ?>

                        </div>

                        <div class="slide-content">

                            <?php echo get_field('post_excerpt', $post['post']); ?>

                        </div>


                    </div>


                </div>
            </a>
        </div>

        <?php } } else if ('page' === $settings['slider_type']) { ?>

        <?php foreach ($settings['select_page'] as $page) {  ?>

        <div class="pe-slide">

            <a href="<?php echo esc_url(get_the_permalink($page['page'])) ?>" style="color: <?php echo get_field('primary_color', $page['page']) ?>" target="_blank" <?php echo $cursor ?>>

                <div class="slide-image">

                    <img src="<?php echo get_the_post_thumbnail_url($page['page']) ?>">

                </div>

                <div class="item-wrap">

                    <div class="slide-meta">

                        <div class="slide-title">

                            <?php echo get_the_title($page['page']); ?>

                        </div>

                        <div class="slide-content">

                            <?php echo get_field('page_excerpt', $page['page']); ?>


                        </div>


                    </div>


                </div>

            </a>

        </div>

        <?php  }  } ?>

    </div>

    <?php if ($settings['vertical_nav_alignment'] === 'bottom') { ?>

    <div class="pe-slide-nav-wrap">

        <?php if ($settings['nav_type'] === 'nav_button') { ?>

        <div class="navigation">

            <?php if ($settings['button_type'] === 'text') { ?>

            <div class="navigate-button prev">

                <?php echo $settings['prev_button_text']; ?>

            </div>

            <div class="navigate-button next">

                <?php echo $settings['next_button_text']; ?>

            </div>

            <?php } else if ($settings['button_type'] === 'icon') { ?>

            <div class="navigate-button prev">

                <?php \Elementor\Icons_Manager::render_icon( $settings['prev_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>


            </div>

            <div class="navigate-button next">

                <?php \Elementor\Icons_Manager::render_icon( $settings['next_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>

            </div>


            <?php } ?>


        </div>


        <?php }

        if ($settings['fraction'] === 'fraction') { ?>

        <div class="pe-fraction">

            <span class="active">1</span>

            /

            <span class="total"></span>


        </div>

        <?php } ?>



    </div>

    <?php } ?>

</div>



<?php 
    }

}
