<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeShowcaseCarousel extends Widget_Base
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
        return 'peshowcasecarousel';
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
        return __('Pe Showcase Carousel', 'pe-core');
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
        return 'eicon-posts-carousel pe-widget';
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
                'label' => __('Showcase Carousel', 'pe-core'),
            ]
        );

        saren_product_query_selection($this);

        $this->add_control(
            'nav_type',
            [
                'label' => esc_html__('Navigation Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'navigate__scroll' => esc_html__('Scroll', 'pe-core'),
                    'infinite__scroll' => esc_html__('Infinite Scroll', 'pe-core'),
                    'navigate__draggable' => esc_html__('Drag', 'pe-core'),
                    'autoplay__active' => esc_html__('Autoplay', 'pe-core')
                ],
                'label_block' => true,
                'prefix_class' => '',
                'render_type' => 'template',
                'default' => 'navigate__scroll'
            ]
        );

        $this->add_control(
            'carousel_id',
            [
                'label' => esc_html__('Carousel ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'placeholder' => 'Eg. "productsCarousel"',
                'description' => esc_html__('Necessary if you will going to use external controls.', 'pe-core'),

            ]
        );

        $this->add_control(
            'autoplay_duration',
            [
                'label' => esc_html__('Autoplay Duration (s)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 30,
                'step' => 1,
                'condition' => [
                    'nav_type' => 'autoplay__active'
                ]
            ]
        );

        $this->add_control(
            'speed_on_autoplay',
            [
                'label' => esc_html__('Speed on Autoplay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'speed__on__autoplay',
                'prefix_class' => '',
                'render_type' => 'template',
                'condition' => [
                    'nav_type' => 'autoplay__active'
                ]
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Scroll Speed', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 20000,
                'step' => 100,
                'default' => 5000,
                'condition' => [
                    'nav_type' => ['navigate__scroll', 'infinite__scroll'],
                ]
            ]
        );

        $this->add_control(
            'pinned--elements',
            [
                'label' => esc_html__('Pinned Elements Class', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'placeholder' => 'Eg. ".outer-widgets"',
                'description' => esc_html__('Elements which has the class you entered will be pinned during the showcase scroll. You can add elements classes via "Advances -> CSS Classes" on the widget options.', 'pe-core'),
                'condition' => [
                    'nav_type' => ['navigate__scroll', 'infinite__scroll'],
                ]
            ]
        );




        $this->add_control(
            'parallax',
            [
                'label' => esc_html__('Parallax', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'parallax__on',
                'default' => 'parallax__on',
                'prefix_class' => '',
                'render_type' => 'template'
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
                'label' => esc_html__('Image', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'vertical_align',
            [
                'label' => esc_html__('Vertical Align', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-v-align-middle'
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom'
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--carousel' => 'justify-content: {{VALUE}}'
                ]
            ]
        );


        $this->add_responsive_control(
            'project_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 10,
                        'max' => 75,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 75,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--carousel .showcase--product' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'project_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 1
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 75,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 75,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--carousel .showcase--product' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'project_gap',
            [
                'label' => esc_html__('Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--carousel .showcase--carousel--wrapper' => 'gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .showcase--carousel .showcase--product .product--image',
            ]
        );





        $this->end_controls_section();



        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $classes = [];

        ob_start();

        if ((isset($_GET['offset']))) {

            $offset = $_GET['offset'];

        } else {
            $offset = 0;
        }

        if ($settings['autoplay_duration']) {
            $duration = $settings['autoplay_duration'];
        } else {
            $duration = 20;
        }

        $cursor = pe_cursor($this);

        if ($settings['speed']) {
            $speed = $settings['speed'];
        } else {
            $speed = 5000;
        }


        ?>

        <div class="showcase--carousel anim-multiple" <?php echo pe_general_animation($this); ?>         <?php if ($settings['nav_type'] === 'autoplay__active') { ?> data-autoplay-duration=<?php echo $duration;
                    } ?>         <?php if ($settings['nav_type'] === 'navigate__scroll' || $settings['nav_type'] === 'infinite__scroll') { ?> data-speed=<?php echo $speed; ?> data-pin-target=<?php echo $settings['pinned--elements'];
                              } ?>>
            <div class="showcase--carousel--wrapper <?php echo $settings['carousel_id'] . ' cr--scroll' ?>"
                data-id="<?php echo $settings['carousel_id']; ?>">
                <?php
                   $the_query = new \WP_Query(saren_product_query_args(($this)));

                while ($the_query->have_posts()):
                    $the_query->the_post();
                    $classes = 'saren--single--product cr--item showcase--product ' . $settings['product_style'];

                    sarenProductRender($settings, wc_get_product(), $classes);

                endwhile;
                wp_reset_query();
                ?>
            </div>
        </div>



    <?php }



}
