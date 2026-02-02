<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class peshowcaseverticalslider extends Widget_Base
{
    public function get_name()
    {
        return 'peshowcaseverticalslider';
    }

    public function get_title()
    {
        return __('Pe Showcase Vertical Slider', 'pe-core');
    }

    public function get_icon()
    {
        return 'eicon-posts-carousel pe-widget';
    }

    public function get_categories()
    {
        return ['pe-showcase'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_project_title',
            [
                'label' => __('Showcase', 'pe-core'),
            ]
        );

        saren_product_query_selection($this);

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 20000,
                'step' => 100,
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
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => esc_html__('Category', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes'
            ]
        );


        $this->add_control(
            'parallax',
            [
                'label' => esc_html__('Parallax', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'parallax__on',
                'prefix_class' => ''
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

        $this->start_controls_tabs(
            'image_styles'
        );

        $this->start_controls_tab(
            'scroll_image',
            [
                'label' => esc_html__('Navigate', 'pe-core')
            ]
        );

        $this->add_control(
            'scroll_image_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 25,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--vertical--slider' => '--zoomWidth: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'scroll_image_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 25,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--vertical--slider' => '--zoomHeight: {{SIZE}}{{UNIT}}'
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'scroll_image_gap',
            [
                'label' => esc_html__('Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--vertical--slider' => '--zoomGap: {{SIZE}}{{UNIT}}'
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_responsive_control(
            'scroll_image_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .showcase--vertical--slider .showcase--vertical--scroll--cards .scroll--card--image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .showcase--vertical--slider .scroll--scope' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'scroll_wrap_position',
            [
                'label' => esc_html__('Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 1500,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => -25,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => -25,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--vertical--slider .showcase--vertical--scroll--wrapper' => 'left: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'scroll_card_filter',
                'selector' => '{{WRAPPER}} .showcase--vertical--slider .showcase--vertical--scroll--wrapper .scroll--card--image',
            ]
        );



        $this->end_controls_tab();

        $this->start_controls_tab(
            'product__image',
            [
                'label' => esc_html__('Product', 'pe-core')
            ]
        );

        $this->add_responsive_control(
            'product_image_width',
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
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--vertical--slider .showcase--product' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'product_image_height',
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
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--vertical--slider .showcase--product' => 'height: {{SIZE}}{{UNIT}}'
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_responsive_control(
            'product_image_gap',
            [
                'label' => esc_html__('Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 250,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 25,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 25,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--vertical--slider' => '--productGap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'product_image_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .showcase--vertical--slider .showcase--vertical--products--wrapper .showcase--product .product--image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'product_wrap_position',
            [
                'label' => esc_html__('Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 1500,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => -25,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => -25,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--vertical--slider .showcase--vertical--products--wrapper' => 'left: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'product_showcase',
                'selector' => '{{WRAPPER}} .showcase--vertical--slider .showcase--product .product--image',
            ]
        );




        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'divider_0',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );



        $this->end_controls_section();


        pe_color_options($this);

    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        if ($settings['speed']) {
            $speed = $settings['speed'];
        } else {
            $speed = 5000;
        }

        ?>

        <div class="showcase--vertical--slider anim-multiple" <?php echo pe_general_animation($this) ?>
            data-speed="<?php echo $speed; ?>" data-pin-target="<?php echo $settings['pinned--elements']; ?>">
            <div class="showcase--vertical--products--wrapper">
                <?php
                $the_query = new \WP_Query(saren_product_query_args(($this)));

                while ($the_query->have_posts()):
                    $the_query->the_post();
                    $classes = 'saren--single--product showcase--product ' . $settings['product_style'];

                    sarenProductRender($settings, wc_get_product(), $classes);

                endwhile;
                wp_reset_query();
                ?>
            </div>

            <div class="showcase--vertical--scroll--wrapper">
                <span class="scroll--scope"></span>
                <div class="showcase--vertical--scroll--cards">

                    <?php while ($the_query->have_posts()):
                        $the_query->the_post(); ?>

                        <div class="scroll--card--image" data-index="">

                            <?php sarenProductImage(wc_get_product(), '', $settings, false) ?>

                        </div>

                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>


            </div>


        </div>



        <?php
    }
}
