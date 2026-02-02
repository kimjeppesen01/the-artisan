<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeProjectField extends Widget_Base
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
        return 'peprojectfield';
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
        return __('Project Field', 'pe-core');
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
        return 'eicon-post-info pe-widget';
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
        return ['pe-dynamic'];
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


        // Tab Title Control
        $this->start_controls_section(
            'section_tab_title',
            [
                'label' => __('Project Fields', 'pe-core'),
            ]
        );

        $this->add_control(
            'field_type',
            [
                'label' => esc_html__('Field Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'title',
                'options' => [
                    'title' => esc_html__('Title', 'pe-core'),
                    'category' => esc_html__('Category', 'pe-core'),
                    'meta' => esc_html__('Meta', 'pe-core'),

                ],
                'label_block' => true,
            ]
        );

        $projectFields = [];

        $groups = acf_get_field_groups(["post_type" => "portfolio"]);

        foreach ($groups as $group) {

            $fields = acf_get_fields($group);

            foreach ($fields as $index => $field) {
                if ($group["title"] === "Project Details") {

                    foreach ($fields as $meta) {
                        $projectFields[$meta["name"]] = $meta["label"];
                    }

                    break;

                }
            }

            continue;
        }


        $this->add_control("project_fields", [
            "label" => esc_html__("Select Meta", "textdomain"),
            "type" => \Elementor\Controls_Manager::SELECT,
            "label_block" => true,
            "multiple" => false,
            "options" => $projectFields,
            'condition' => ['field_type' => 'meta'],
        ]);


        $this->add_control(
            'text_type',
            [
                'label' => esc_html__('Text Size', 'pe-core'),
                'description' => esc_html__('This option will not change HTML tag of the element, this option only for typographic scaling.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'text-p' => [
                        'title' => esc_html__('P', 'pe-core'),
                        'icon' => ' eicon-editor-paragraph',
                    ],
                    'text-h1' => [
                        'title' => esc_html__('H1', 'pe-core'),
                        'icon' => ' eicon-editor-h1',
                    ],
                    'text-h2' => [
                        'title' => esc_html__('H2', 'pe-core'),
                        'icon' => ' eicon-editor-h2',
                    ],
                    'text-h3' => [
                        'title' => esc_html__('H3', 'pe-core'),
                        'icon' => ' eicon-editor-h3',
                    ],
                    'text-h4' => [
                        'title' => esc_html__('H4', 'pe-core'),
                        'icon' => ' eicon-editor-h4',
                    ],
                    'text-h5' => [
                        'title' => esc_html__('H5', 'pe-core'),
                        'icon' => ' eicon-editor-h5',
                    ],
                    'text-h6' => [
                        'title' => esc_html__('H6', 'pe-core'),
                        'icon' => ' eicon-editor-h6',
                    ]

                ],
                'default' => 'text-p',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'paragraph_size',
            [
                'label' => esc_html__('Paragraph Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Normal', 'pe-core'),
                    'p-small' => esc_html__('Small', 'pe-core'),
                    'p-large' => esc_html__('Large', 'pe-core'),

                ],
                'label_block' => true,
                'condition' => ['text_type' => 'text-p'],
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
                'condition' => ['text_type' => 'text-h1'],
            ]
        );

        $this->add_control(
            'remove_breaks',
            [
                'label' => esc_html__('Remove Breaks on Mobile', 'pe-core'),
                'description' => esc_html__('On mobile screens "br" tags will be removed.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide-br-mobile',
                'default' => '',

            ]
        );

        $this->add_control(
            'remove_margins',
            [
                'label' => esc_html__('Remove Margins', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'no-margin',
                'default' => '',

            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' => esc_html__('Use Secondary Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'use--sec--color',
                'default' => '',

            ]
        );


        $this->add_control(
            'get_data',
            [
                'label' => esc_html__('Get Data From', 'pe-core'),
                'description' => esc_html__('You can select "Next/Prev project when creating project paginations." ', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'current',
                'options' => [
                    'current' => esc_html__('Current Project', 'pe-core'),
                    'next' => esc_html__('Next Project', 'pe-core'),
                    'prev' => esc_html__('Previous Project', 'pe-core'),

                ],
                'label_block' => false,
            ]
        );
        $this->end_controls_section();

        pe_text_animation_settings($this);

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
                'name' => 'typography',
                'label' => esc_html__('Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .text-wrapper p',
            ]
        );


        $this->add_responsive_control(
            'alignment',
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
                    'justify' => [
                        'title' => esc_html__('Justify', 'pe-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .text-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_align_last',
            [
                'label' => esc_html__('Justify Last Line?', 'pe-core'),
                'description' => esc_html__('On mobile screens "br" tags will be removed.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'justify-last',
                'default' => false,
                'condition' => ['alignment' => 'justify'],
            ]
        );


        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
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
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            'attributes',
            [
                'class' => [$settings['text_type'], $settings['paragraph_size'] , $settings['heading_size'], $settings['remove_margins'], $settings['remove_breaks'] , $settings['text_align_last'] , $settings['secondary_color']],
            ]
        );

        $text = 'dummy';
        $type = $settings['field_type'];

        $loop = new \WP_Query([
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'order' => 'ASC'
        ]);
        wp_reset_postdata();


        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            while ($loop->have_posts()):
                $loop->the_post();
                $id = get_the_ID();
            endwhile;
            wp_reset_query();
        } else {
            global $wp_query;
            
            $id = $wp_query->post->ID;
            $previous_post = get_previous_post();
            $next_post = get_next_post();

            if ($settings['get_data'] === 'next') {

                if (!$next_post) {
                    while ($loop->have_posts()):
                        $loop->the_post();
                        $id = get_the_ID();
                    endwhile;
                }  else {
                    $id = $next_post->ID;
                }

            } else if ($settings['get_data'] === 'prev') {
                $id =  $previous_post->ID;
            }

        }

        if ($type === 'title') {

            $text = get_the_title($id);

        } else if ($type === 'category') {


            $terms = get_the_terms($id, 'project-categories');

            if ($terms) {

                $term_names = array();

                foreach ($terms as $term) {
                    $term_names[] = esc_html($term->name);
                }

                $text = implode(', ', $term_names);
            }

        } else if ($type === 'meta') {

            $text = get_field($settings["project_fields"], $id);


        }
        ;

        ?>

        <div class="text-wrapper">

            <p <?php echo $this->get_render_attribute_string('attributes') ?><?php echo pe_text_animation($this) ?>>
                <?php echo $text; ?>
            </p>

        </div>

        <?php
    }

}
