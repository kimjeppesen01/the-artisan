<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeSingleProject extends Widget_Base
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
        return 'pesingleproject';
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
        return __('Single Project', 'pe-core');
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
        return 'eicon-image-box pe-widget';
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


        $options = [];

        $projects = get_posts([
            'post_type' => 'portfolio',
            'numberposts' => -1
        ]);

        foreach ($projects as $project) {
            $options[$project->ID] = $project->post_title;
        }

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Single Project', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'select_post',
            [
                'label' => __('Select Project', 'pe-core'),
                'label_block' => true,
                'description' => __('Select project which will display in the widget.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->add_control(
            'custom_thumb_notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>If you apply custom thumbnail for the project, the special page transition animations for this project will no longer work, The default page transition will be triggered.</span></div>',
                'condition' => ['custom_thumb!' => 'none'],
            ]
        );

        $this->add_control(
            'project_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'simple',
                'options' => [
                    'simple' => esc_html__('Simple', 'pe-core'),
                    'horizontal' => esc_html__('Horizontal', 'pe-core'),
                ],

            ]
        );


        $this->add_control(
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

        $this->add_control(
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

        $this->add_control(
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

        $this->add_control(
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

        $this->add_control(
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
            'client',
            [
                'label' => esc_html__('Client', 'pe-core'),
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
                'label' => esc_html__('Date', 'pe-core'),
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
                ],
                'condition' => ['custom_height' => 'yes'],
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
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'cursor_interactions',
            [
                'label' => __('Cursor Interactions', 'pe-core'),
            ]
        );

        $this->add_control(
            'cursor_type',
            [
                'label' => esc_html__('Interaction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'default' => esc_html__('Default', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core'),
                    'icon' => esc_html__('Icon', 'pe-core'),
                ],

            ]
        );

        $this->add_control(
            'cursor_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'description' => esc_html__('Only Material Icons allowed, do not select Font Awesome icons.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'material-icons md-arrow_outward',
                    'library' => 'material-design-icons',
                ],
                'condition' => ['cursor_type' => 'icon'],
            ]
        );

        $this->add_control(
            'cursor_text',
            [
                'label' => esc_html__('Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => ['cursor_type' => 'text'],
            ]
        );


        $this->end_controls_section();

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
            'project_elements',
            [

                'label' => esc_html__('Style', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_type',
            [
                'label' => esc_html__('Title Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'h1' => [
                        'title' => esc_html__('H1', 'pe-core'),
                        'icon' => ' eicon-editor-h1',
                    ],
                    'h2' => [
                        'title' => esc_html__('H2', 'pe-core'),
                        'icon' => ' eicon-editor-h2',
                    ],
                    'h3' => [
                        'title' => esc_html__('H3', 'pe-core'),
                        'icon' => ' eicon-editor-h3',
                    ],
                    'h4' => [
                        'title' => esc_html__('H4', 'pe-core'),
                        'icon' => ' eicon-editor-h4',
                    ],
                    'h5' => [
                        'title' => esc_html__('H5', 'pe-core'),
                        'icon' => ' eicon-editor-h5',
                    ],
                    'h6' => [
                        'title' => esc_html__('H6', 'pe-core'),
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
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .post-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cats_typography',
                'label' => esc_html__('Cats Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .post-categories',
            ]
        );

        $this->add_responsive_control(
            'border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe--single--project.psp--elementor .thmb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();


        $classes = [];
        $customThumb = $settings['custom_thumb'] !== 'none' ? 'custom__thumb' : '';

        $classes[] = 'pe--single--project psp--elementor ' . $customThumb . ' style--' . $settings['project_style'];

        // Animations 
        $start = $settings['start_offset'] ? $settings['start_offset']['size'] : 0;
        $end = $settings['end_offset'] ? $settings['end_offset']['size'] : 0;
        $out = $settings['animate_out'] ? $settings['animate_out'] : 'false';

        $dataset = '{' .
            'duration=' . $settings['duration'] . '' .
            ';delay=' . $settings['delay'] . '' .
            ';stagger=' . $settings['stagger'] . '' .
            ';pin=' . $settings['pin'] . '' .
            ';pinTarget=' . $settings['pin_target'] . '' .
            ';scrub=' . $settings['scrub'] . '' .
            ';markers=' . $settings['show_markers'] . '' .
            ';start=' . $start . '' .
            ';startpov=' . $settings['anim_start'] . '' .
            ';end=' . $end . '' .
            ';endpov=' . $settings['anim_end'] . '' .
            ';out=' . $out . '' .
            '}';

        $checkMarkers = '';

        if (\Elementor\Plugin::$instance->editor->is_edit_mode() && $settings['show_markers']) {
            $checkMarkers = ' markers-on';
        }


        $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';

        //Scroll Button Attributes
        $this->add_render_attribute(
            'animation_settings',
            [
                'data-anim-general' => 'true',
                'data-animation' => $animation,
                'data-settings' => $dataset,

            ]
        );

        $animationSettings = $settings['select_animation'] !== 'none' ? $this->get_render_attribute_string('animation_settings') : '';

        //Cursor
        ob_start();

        \Elementor\Icons_Manager::render_icon($settings['cursor_icon'], ['aria-hidden' => 'true']);

        $cursorIcon = ob_get_clean();

        $this->add_render_attribute(
            'cursor_settings',
            [
                'data-cursor' => "true",
                'data-cursor-type' => $settings['cursor_type'],
                'data-cursor-text' => $settings['cursor_text'],
                'data-cursor-icon' => $cursorIcon,
            ]
        );

        $cursor = $settings['cursor_type'] !== 'none' ? $this->get_render_attribute_string('cursor_settings') : '';
        //Cursor

        $id = $settings['select_post'];
        $category = $settings['cat'];

        $args = array(
            'post_type' => 'portfolio',
            'posts_per_page' => 1,
            'post__in' => array($id),
            'post__not_in' => get_option("sticky_posts"),
        );

        $loop = new \WP_Query($args);


        if ($settings['custom_thumb'] !== 'none') {

            $custom = [
                'type' => $settings['custom_thumb'],
                'provider' => $settings['video_provider'],
                'imageUrl' => $settings['featured_image'],
                'videoUrl' => $settings['self_video'],
                'videoId' => $settings['video_id']
            ];


        } else {

            $custom = false;
        }

        $style = $settings['project_style'];

        ?>

        <?php while ($loop->have_posts()):
            $loop->the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>             <?php echo $animationSettings; ?>             <?php echo $cursor ?>>

                <a href="<?php echo esc_url(get_permalink()) ?>">
                    <div class="thmb">

                        <?php pe_project_image($id, $custom, false); ?>

                    </div>

                </a>

                <?php 

                    if ($style === 'horizontal') {
                        echo '<div class="horizontal--meta--wrap">';
                    }
                
                 ?>


                <!-- Meta -->
                <div class="post-meta">

                    <?php if ($category && $style === 'simple') { ?>

                        <div class="post-categories">
                            <?php

                            $terms = get_the_terms($id, 'project-categories');
                            if ($terms) {

                                $term_names = array();

                                foreach ($terms as $term) {
                                    $term_names[] = esc_html($term->name);
                                }

                                $cats = implode(', ', $term_names);
                                echo $cats;
                            }

                            ?>
                        </div>

                        <?php if (get_field('client') && $settings['client'] === 'true') { ?>
								<div class="project--client">
													<?php echo get_field('client'); ?>
												</div>
											<?php } ?>

											<?php if (get_field('date') && $settings['date'] === 'true') { ?>
												<div class="project--date">
													<?php echo get_field('date'); ?>
								</div>
								<?php } ?>

                    <?php } ?>

                    <?php if ($style === 'horizontal') { ?>

                        <div class="post-data">

                            <?php if (get_field('client') && $settings['client'] === 'true') { ?>
								<div class="project--client">
													<?php echo get_field('client'); ?>
												</div>
											<?php } ?>

											<?php if (get_field('date') && $settings['date'] === 'true') { ?>
												<div class="project--date">
													<?php echo get_field('date'); ?>
								</div>
								<?php } ?>


                        </div>

                    <?php } ?>
                </div>

    
                <div class="post-details">

                   
                    <a href="<?php echo esc_url(get_permalink()) ?>">

                    <?php if ($category && $style === 'horizontal') { ?>

                <div class="post-categories">
                         <?php

                            $terms = get_the_terms($id, 'project-categories');
                        if ($terms) {

                             $term_names = array();

                              foreach ($terms as $term) {
                                $term_names[] = esc_html($term->name);
                             }
                         
                             $cats = implode(', ', $term_names);
                         echo $cats;
                           }

                          ?>
                        </div>

                        <?php } ?>


                        <?php echo '<' . $settings['text_type'] . ' class="post-title entry-title">' . get_the_title() . '</' . $settings['text_type'] . '>'; ?>


                    </a>
                    <!--/ Title -->

                </div>
                <!--/ Post Details -->

                <?php 

if ($style === 'horizontal') {
    echo '</div>';
}

?>

            </article>


        <?php endwhile;
        wp_reset_query(); ?>


        <?php
    }

}
