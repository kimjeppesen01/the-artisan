<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeTimeline extends Widget_Base
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
        return 'petimeline';
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
        return __('Timeline', 'pe-core');
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
        return 'eicon-time-line pe-widget';
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

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'timeline_date',
            [
                'label' => esc_html__('Date', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false
            ]
        );

        $repeater->add_control(
            'is_past',
            [
                'label' => esc_html__('Is Past?', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'is--past',
                'default' => '',
            ]
        );

        $repeater->start_controls_tabs(
            'timeline_content_top_tabs'
        );

        $repeater->start_controls_tab(
            'timeline_content_top_tab_content',
            [
                'label' => esc_html__('Content (Top)', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'content_type',
            [
                'label' => esc_html__('Content Type (Top)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'image' => esc_html__('Image', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core'),
                    'image_text' => esc_html__('Image & Text', 'pe-core'),
                ],
                'label_block' => true,
                'default' => 'none'
            ]
        );

        $repeater->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'condition' => [
                    'content_type' => ['text', 'image_text'],
                ]
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => [
                    'content_type' => ['image', 'image_text']
                ]
            ]
        );



        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'timeline_content_top_tab_style',
            [
                'label' => esc_html__('Styles (Top)', 'pe-core'),
            ]
        );

        objectStyles($repeater, 'cont_top', 'Item', '{{CURRENT_ITEM}} .content--top .pe--styled--object', true, false, false);


        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $repeater->start_controls_tabs(
            'timeline_content_bottom_tabs'
        );

        $repeater->start_controls_tab(
            'timeline_content_bottom_tab_content',
            [
                'label' => esc_html__('Content (Bottom)', 'pe-core'),
            ]
        );


        $repeater->add_control(
            'content_type_bottom',
            [
                'label' => esc_html__('Content Type (Bottom)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'image' => esc_html__('Image', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core'),
                    'image_text' => esc_html__('Image & Text', 'pe-core'),
                ],
                'label_block' => true,
                'default' => 'none'
            ]
        );

        $repeater->add_control(
            'bottom_text',
            [
                'label' => esc_html__('Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'condition' => [
                    'content_type_bottom' => ['text', 'image_text'],
                ]
            ]
        );
        
        $repeater->add_control(
            'bottom_image',
            [
                'label' => esc_html__('Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => [
                    'content_type_bottom' => ['image', 'image_text']
                ]
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'timeline_content_bottom_tab_style',
            [
                'label' => esc_html__('Styles (Bottom)', 'pe-core'),
            ]
        );

        objectStyles($repeater, 'cont_bottom', 'Item ', '{{CURRENT_ITEM}} .content--bottom .pe--styled--object', true, false, false);


        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();


        $this->add_control(
            'project_repeater',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls()
            ]
        );

        $this->add_control(
            'navigation_type',
            [
                'label' => esc_html__('Navigation Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'nav__scroll' => esc_html__('Scroll', 'pe-core'),
                    'nav__drag' => esc_html__('Drag', 'pe-core')
                ],
                'default' => 'nav__drag',
                'prefix_class' => ''
            ]
        );


        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 30000,
                'step' => 100,
                'condition' => [
                    'navigation_type' => 'nav__scroll'
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
                    'navigation_type' => 'nav__scroll'
                ]
            ]
        );

        $this->add_control(
            'start_point',
            [
                'label' => esc_html__('Start Item', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 1
            ]
        );


        $this->add_control(
            'point',
            [
                'label' => esc_html__('Point', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'border_anim',
            [
                'label' => esc_html__('Border Animation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'border__anim__active',
                'prefix_class' => '',
                'render_type' => 'template'
            ]
        );





        $this->end_controls_section();



        pe_general_animation_settings($this);

        $this->start_controls_section(
            'style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'point__bordered',
            [
                'label' => esc_html__('Bordered', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'seperator__bordered',
                'prefix_class' => '',
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .item--point' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'point__bordered' => 'seperator__bordered'
                ]
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .item--point' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'point__bordered' => 'seperator__bordered'
                ]
            ]
        );

        $this->add_control(
            'border_type',
            [
                'label' => esc_html__('Border Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'solid' => esc_html__('Solid', 'pe-core'),
                    'dashed' => esc_html__('Dashed', 'pe-core'),
                    'dotted' => esc_html__('Dotted', 'pe-core'),
                    'double' => esc_html__('Double', 'pe-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .item--point' => 'border-style: {{VALUE}};',
                ],
                'condition' => [
                    'point__bordered' => 'seperator__bordered'
                ]
            ]
        );

        $this->add_responsive_control(
            'border_width',
            [
                'label' => esc_html__('Border Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.01
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.01
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.01
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .item--point' => 'border-width: {{SIZE}}{{UNIT}}'
                ],
                'condition' => [
                    'point__bordered' => 'seperator__bordered'
                ]
            ]
        );


        $this->add_control(
            'divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );

        $this->add_responsive_control(
            'item_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 750,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--timeline .timeline--item' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );



        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => esc_html__('Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 750,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--timeline .timeline--wrapper' => 'gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'line_spacing',
            [
                'label' => esc_html__('Line Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 250,
                        'step' => 1
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 40,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 40,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--timeline .timeline--wrapper .timeline--item > div:first-child' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .pe--timeline .timeline--wrapper .timeline--item > div:nth-child(2)' => 'margin-top: {{SIZE}}{{UNIT}}'
                ]
            ]
        );


        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe--timeline img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .pe--timeline .timeline--item p',
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Image Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 75,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 75,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--timeline img' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );


        $this->end_controls_section();


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $classes = [];


        ob_start();

        $icon = ob_get_clean();
        if ((isset($_GET['offset']))) {
            $offset = $_GET['offset'];
        } else {
            $offset = 0;
        }

        if ($settings['speed']) {
            $speed = $settings['speed'];
        } else {
            $speed = 10000;
        }

        ?>

        <div class="pe--timeline" data-speed="<?php echo $speed; ?>"
            data-pin-target="<?php echo $settings['pinned--elements']; ?>">
            <div class="timeline--wrapper">
                <?php foreach ($settings['project_repeater'] as $key => $item) { ?>
                    <div
                        class="timeline--item <?php echo esc_attr($item['is_past'] . ' elementor-repeater-item-' . $item['_id']) ?>">

                        <div class="timeline--content content--top">

                            <?php if ($item['content_type'] === 'image' || $item['content_type'] === 'image_text') { ?>
                                <?php echo '<img class="pe--styled--object" src="' . $item['image']['url'] . '">'; ?>
                            <?php } ?>
                            <?php if ($item['content_type'] === 'text' || $item['content_type'] === 'image_text') { ?>
                                <p class="pe--styled--object"> <?php echo $item['text']; ?></p>
                            <?php } ?>

                        </div>

                        <div class="timeline--content content--bottom">

                            <?php if ($item['content_type_bottom'] === 'image' || $item['content_type_bottom'] === 'image_text') { ?>
                                <?php echo '<img class="pe--styled--object" src="' . $item['bottom_image']['url'] . '">'; ?>
                            <?php } ?>
                            <?php if ($item['content_type_bottom'] === 'text' || $item['content_type_bottom'] === 'image_text') { ?>
                                <p class="pe--styled--object"><?php echo $item['bottom_text']; ?></p>
                            <?php } ?>

                        </div>


                        <div class="item--point">

                            <div class="timeline--date">
                                <?php echo $item['timeline_date']; ?>
                            </div>

                        </div>


                    </div>
                <?php } ?>
            </div>

            <div class="timeline--line--wrapper"><span class="timeline--line"></span></div>

        </div>





    <?php }



}
