<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class peProductCards extends Widget_Base
{
    public function get_name()
    {
        return 'peproductcards';
    }

    public function get_title()
    {
        return __('Pe Products Cards', 'pe-core');
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
            'infinite__scroll',
            [
                'label' => esc_html__('Infinite', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'infinite--active',
                'render_type' => 'template',
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

        $this->start_controls_section(
            'style',
            [
                'label' => esc_html__('Carousel Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'images_width',
            [
                'label' => esc_html__('Images Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product--cards .products--wrapper .product--item' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'images_height',
            [
                'label' => esc_html__('Images Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'em', 'rem'],
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
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product--cards .products--wrapper .product--item' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'thumbs_bordered',
            [
                'label' => esc_html__('Bordered Thumbnails', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'thumbs--bordered',
                'prefix_class' => ''
            ]
        );

        $this->add_responsive_control(
            'thumbs_width',
            [
                'label' => esc_html__('Thumbnails Width', 'pe-core'),
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
                    '{{WRAPPER}} .product--cards .navigation--image--wrapper .navigation--image' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'thumbs_height',
            [
                'label' => esc_html__('Thumbnails Height', 'pe-core'),
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
                    '{{WRAPPER}} .product--cards .navigation--image--wrapper .navigation--image' => 'height: {{SIZE}}{{UNIT}}'
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_responsive_control(
            'thumbs_gap',
            [
                'label' => esc_html__('Thumbnails ƒGap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
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
                    '{{WRAPPER}} .product--cards .navigation--image--wrapper' => 'gap: {{SIZE}}{{UNIT}}'
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_responsive_control(
            'thumbs_radius',
            [
                'label' => esc_html__('Thumbnails Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .product--cards .navigation--image--wrapper .navigation--image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnails_filters',
                'label' => esc_html__('Thumbnails Filters', 'pe-core'),
                'selector' => '{{WRAPPER}} .product--cards .navigation--image--wrapper .navigation--image',
            ]
        );





        $this->end_controls_section();


        pe_product_styles($this);

        pe_cursor_settings($this);
        pe_general_animation_settings($this);



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
        $the_query = new \WP_Query(saren_product_query_args(($this)));
        ?>

        <div class="product--cards anim-multiple" data-speed="<?php echo $speed; ?>"
            data-pin-target="<?php echo $settings['pinned--elements']; ?>" <?php echo pe_general_animation($this); ?>>
            <div class="products--wrapper">

                <?php
                while ($the_query->have_posts()):
                    $the_query->the_post();
                    $classes = 'saren--single--product inner--anim carousel--item ' . $settings['product_style'] . ' sp--archive--' . $settings['products_archive_style'];
                    ?>

                    <div class="product--item">
                        <?php sarenProductRender($settings, wc_get_product(), $classes, true, true);
                        ?>
                    </div>
                <?php endwhile; ?>

            </div>

            <div class="navigation--image--wrapper">
                <?php while ($the_query->have_posts()):
                    $the_query->the_post(); ?>

                    <div class="navigation--image">

                        <img src="<?php echo get_the_post_thumbnail_url() ?>">

                    </div>

                <?php endwhile;
                wp_reset_query(); ?>
            </div>
        </div>


        <?php
    }
}
