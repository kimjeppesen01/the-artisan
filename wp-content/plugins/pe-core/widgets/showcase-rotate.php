<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeShowcaseRotate extends Widget_Base
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
        return 'peshowcaserotate';
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
        return __('Pe Showcase Rotate', 'pe-core');
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

        $this->start_controls_section(
            'section_project_title',
            [
                'label' => __('Showcase Rotate', 'pe-core'),
            ]
        );

        saren_product_query_selection($this);

        $this->add_control(
            'rotate_navigation_types',
            [
                'label' => esc_html__('Navigation Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => [
                    'has__mousewheel' => esc_html__('MouseWheel', 'pe-core'),
                    'has__draggable' => esc_html__('Draggable', 'pe-core'),
                ],
                'description' => esc_html__('Please select at least one option. Otherwise, the animation will not work.', 'pe-core'),
                'default' => ['has__mousewheel', 'has__draggable']
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_product_settings',
            [
                'label' => __('Product Settings', 'pe-core'),
            ]
        );

        pe_product_controls($this);

        $this->end_controls_section();

        pe_product_styles($this);

        pe_cursor_settings($this);
        pe_general_animation_settings($this);

        $this->start_controls_section(
            'style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
                        'min' => 200,
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
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--rotate .showcase--product' => 'width: {{SIZE}}{{UNIT}}'
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
                        'min' => 100,
                        'max' => 1000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 75,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--rotate .showcase--product--wrapper' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'wrapper_height',
            [
                'label' => esc_html__('Wrapper Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 10000,
                        'step' => 10
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 500,
                        'step' => 10
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 500,
                        'step' => 10
                    ]
                ],
                'description' => esc_html__('When you increase this value, the spacing between the projects will increase.', 'pe-core'),
                'selectors' => [
                    '{{WRAPPER}} .showcase--rotate .showcase--rotate--wrapper' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .showcase--rotate .product--image',
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'button_settings',
            [
                'label' => esc_html__('Button Settings', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,

            ]
        );

        pe_button_settings($this, false, false);

        $this->end_controls_section();

        pe_color_options($this);



    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();



        $cursor = pe_cursor($this);

        ?>

        <div class="showcase--rotate anim-multiple<?php if ($settings['rotate_navigation_types']) {
            foreach ($settings['rotate_navigation_types'] as $item) {
                echo ' ' . $item;
            }
        } ?>" <?php echo pe_general_animation($this); ?>>

            <div class="showcase--rotate--wrapper">

                <?php
                $the_query = new \WP_Query(saren_product_query_args(($this)));
                while ($the_query->have_posts()):
                    $the_query->the_post();
                    $classes = 'saren--single--product showcase--product ' . $settings['product_style'];

                    sarenProductRender($settings, wc_get_product(), $classes, $cursor);

                endwhile;
                wp_reset_query();
                ?>
            </div>


        </div>


    <?php }



}
