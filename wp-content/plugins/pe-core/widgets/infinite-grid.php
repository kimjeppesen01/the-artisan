<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeInfiniteGrid extends Widget_Base
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
        return 'peinfinitegrid';
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
        return __('Pe Infinite Grid', 'pe-core');
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
        return 'eicon-text-field pe-widget';
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
        return ['pe-showcase'];
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

        $registered = wp_get_nav_menus();
        $menus = [];

        if ($registered) {
            foreach ($registered as $menu) {

                $name = $menu->name;
                $id = $menu->term_id;

                $menus[$name] = $name;

            }
        }

        $this->start_controls_section(
            'section_project_title',
            [
                'label' => __('Showcase', 'pe-core'),
            ]
        );

        $options = [];

        $projects = get_posts([
            'post_type' => 'portfolio',
            'numberposts' => -1
        ]);

        foreach ($projects as $project) {
            $options[$project->ID] = $project->post_title;
        }

        $this->add_control(
            'column',
            [
                'label' => esc_html__('Column', 'pe-core'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => esc_html__('1 Column', 'pe-core'),
                    '2' => esc_html__('2 Columns', 'pe-core'),
                    '3' => esc_html__('3 Columns', 'pe-core'),
                    '4' => esc_html__('4 Columns', 'pe-core'),
                ]
            ]
        );

        $this->add_control(
            'grid',
            [
                'label' => esc_html__('Grid Layout', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'prefix_class'=> 'grid_lines_',
                'default' => 'yes'
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'select_project',
            [
                'label' => esc_html__('Select Project', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'options' => $options
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

        $repeater->add_control(
            'custom_title',
            [
                'label' => esc_html__('Custom Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'custom_category',
            [
                'label' => esc_html__('Custom Category', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'project_repeater',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls()
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => esc_html__('Category', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => false
            ]
        );

        $this->add_control(
            'autoplay_duration',
            [
                'label' => esc_html__('Autoplay Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 20,
                'condition' => [
                    'autoplay' => 'true',
                ]
            ]
        );



        $this->end_controls_section();

        pe_cursor_settings($this);
        pe_general_animation_settings($this);

        $this->start_controls_section(
            'style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .infinite--grid .showcase--project .project--title'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cats_typography',
                'label' => esc_html__('Category Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .infinite--grid .showcase--project .project--category',
                'condition' => [
                    'category' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'style_divider_3',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );


        $this->add_responsive_control(
            'project_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infinite--grid .showcase--project' => 'width: {{SIZE}}{{UNIT}}!important'
                ]
            ]
        );

        $this->add_responsive_control(
            'project_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 2000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .infinite--grid .showcase--project .project--image' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'vertical_gap',
            [
                'label' => esc_html__('Vertical Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 100,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .infinite--grid' => 'gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'horizontal_gap',
            [
                'label' => esc_html__('Horizontal Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 100,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .infinite--grid .showcase--project' => 'margin-bottom: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->end_controls_section();

        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if ((isset($_GET['offset']))) {

            $offset = $_GET['offset'];

        } else {
            $offset = 0;
        }


        $args = array(
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'project-categories',
                    'field' => 'term_id',
                )
            )
        );


        foreach ($settings['project_repeater'] as $item) {

            if ($item['custom_thumb'] !== 'none') {

                $custom = [
                    'type' => $item['custom_thumb'],
                    'provider' => $item['video_provider'],
                    'imageUrl' => $item['featured_image'],
                    'videoUrl' => $item['self_video'],
                    'videoId' => $item['video_id']
                ];


            } else {

                $custom = false;
            }

        }

        $cursor = pe_cursor($this);

        ?>

        <div class="infinite--grid vid--no--ratio anim-multiple" data-autoplay="<?php echo $settings['autoplay'] ?>"
            data-autoplay-duration="<?php echo $settings['autoplay_duration'] ?>"
            data-column="<?php echo $settings['column'] ?>" <?php echo pe_general_animation($this) ?>>


            <div class="infinite--grid--wrapper">
                <?php for ($i = 0; $i < $settings['column']; $i++) { ?>

                    <div class="grid--column column_<?php echo $i + 1; ?>">

                        <?php foreach ($settings['project_repeater'] as $key => $item) { ?>

                            <?php if ($key % $settings['column'] === $i) { ?>

                                <div class="showcase--project project__<?php echo $key; ?>" data-index="<?php echo $key; ?>">

                                    <a class="barba--trigger image--inner" href="<?php echo get_the_permalink($item['select_project']); ?>"
                                        data-id="<?php echo $item['select_project']; ?>" <?php echo $cursor ?>>
                                        <div class="project--image inner--anim project__image__<?php echo $item['select_project']; ?> ">
                                            <?php pe_project_image($item['select_project'], $custom, false); ?>
                                        </div>

                                        <div class="project--meta">
                                            <div class="project--title">
                                                <?php if ($item['custom_title']) {
                                                    echo $item['custom_title'];
                                                } else {
                                                    echo get_the_title($item['select_project']);
                                                } ?>
                                            </div>

                                            <?php if ($settings['category'] === 'yes') { ?>
                                                <div class="project--category">
                                                    <?php
                                                    if ($item['custom_category']) {
                                                        echo $item['custom_category'];
                                                    } else {
                                                        $terms = get_the_terms($item['select_project'], 'project-categories');

                                                        if ($terms) {

                                                            foreach ($terms as $term) {
                                                                echo esc_html($term->name);
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                        <?php } ?>

                    </div>
                <?php } ?>
            </div>
        </div>
        </div>


    <?php }



}
