<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class peProductsSlideshow extends Widget_Base
{
    public function get_name()
    {
        return 'peproductslideshow';
    }

    public function get_title()
    {
        return __('Pe Products Slideshow', 'pe-core');
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
                'min' => 0.5,
                'max' => 10,
                'step' => 0.01,
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
            'navigation_options',
            [
                'label' => esc_html__('Navigation', 'pe-core'),
            ]
        );

        $this->add_control(
            'nav_type',
            [
                'label' => esc_html__('Navigation Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core')
                ]
            ]
        );

        $this->add_control(
            'prev_icon',
            [
                'label' => esc_html__('Prev Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'nav_type' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'next_icon',
            [
                'label' => esc_html__('Next Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'nav_type' => 'icon'
                ]
            ]
        );


        $this->add_control(
            'prev_text',
            [
                'label' => esc_html__('Prev Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('PREV', 'pe-core'),
                'condition' => [
                    'nav_type' => 'text'
                ]
            ]
        );

        $this->add_control(
            'next_text',
            [
                'label' => esc_html__('Next Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('NEXT', 'pe-core'),
                'condition' => [
                    'nav_type' => 'text'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 250,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 0.1,
                        'max' => 10,
                        'step' => 0.01
                    ],
                    'rem' => [
                        'min' => 0.1,
                        'max' => 10,
                        'step' => 0.01
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .products--slideshow .slider--navigation i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .products--slideshow .slider--navigation svg' => 'width: {{SIZE}}{{UNIT}}'
                ],
                'condition' => [
                    'nav_type' => 'icon'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'nav_text_typography',
                'selector' => '{{WRAPPER}} .products--slideshow .slider--navigation .slider--nav--item',
                'condition' => [
                    'nav_type' => 'text'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_gap',
            [
                'label' => esc_html__('Item Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 250,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .products--slideshow .slider--navigation' => 'gap: {{SIZE}}{{UNIT}}',

                ],
                'condition' => [
                    'nav_type' => 'icon'
                ]
            ]
        );

        objetAbsolutePositioning($this, '.products--slideshow .slider--navigation', 'navigation', 'Navigation');


        $this->end_controls_section();
        pe_product_styles($this);

        pe_cursor_settings($this);
        pe_general_animation_settings($this);


        $this->start_controls_section(
            'gallery_image_styles',
            [
                'label' => esc_html__('Gallery Images', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'gallery_image_options',
        );

        $this->start_controls_tab(
            'gallery_1',
            [
                'label' => esc_html__('Gallery 1', 'pe-core')
            ]
        );

        objetAbsolutePositioning($this, '.products--slideshow .product--image--gallery.image--gallery--left--to--right', 'gallery_1', 'Gallery 1');

        $this->add_responsive_control(
            'gallery_1_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .image--gallery--left--to--right' => 'width: {{SIZE}}{{UNIT}}'
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'gallery_1_height',
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
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .image--gallery--left--to--right' => 'height: {{SIZE}}{{UNIT}}'
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'gallery_1_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .image--gallery--left--to--right .parallax--wrap img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'gallery_1_filter',
                'selector' => '{{WRAPPER}} .image--gallery--left--to--right .parallax--wrap',
            ]
        );

        $this->add_control(
            'gallery_1_index',
            [
                'label' => esc_html__('Z Index', 'pe-core')
            ]
        );



        $this->end_controls_tab();

        $this->start_controls_tab(
            'gallery_2',
            [
                'label' => esc_html('Gallery 2', 'pe-core')
            ]
        );

        objetAbsolutePositioning($this, '.products--slideshow .product--image--gallery.image--gallery--right--to--left', 'gallery_2', 'Gallery 2');

        $this->add_responsive_control(
            'gallery_2_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .image--gallery--right--to--left' => 'width: {{SIZE}}{{UNIT}}'
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'gallery_2_height',
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
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .image--gallery--right--to--left' => 'height: {{SIZE}}{{UNIT}}'
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'gallery_2_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .image--gallery--right--to--left .parallax--wrap img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'gallery_2_filter',
                'selector' => '{{WRAPPER}} .image--gallery--right--to--left .parallax--wrap',
            ]
        );



        $this->end_controls_tab();


        $this->end_controls_tabs();

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
            $speed = 1.2;
        }

        $the_query = new \WP_Query(saren_product_query_args(($this)));

        ?>

        <div class="products--slideshow anim-multiple" <?php echo pe_general_animation($this); ?>
            data-speed="<?php echo $speed; ?>">

            <div class="product--image--gallery image--gallery--right--to--left">
                <div class="image--gallery--wrapper">
                    <?php while ($the_query->have_posts()):
                        $the_query->the_post();
                        $product = wc_get_product();
                        $attachment_ids = $product->get_gallery_image_ids();
                        echo '<div class="product--gallery--image">' . wp_get_attachment_image($attachment_ids[0], 'full') . '</div>';

                        ?>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="product--image--gallery image--gallery--left--to--right">
                <div class="image--gallery--wrapper">
                    <?php while ($the_query->have_posts()):
                        $the_query->the_post();
                        $product = wc_get_product();

                        $attachment_ids = $product->get_gallery_image_ids();
                        echo '<div class="product--gallery--image">' . wp_get_attachment_image($attachment_ids[1], 'full') . '</div>';

                        ?>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="product--wrapper">
                <div class="product--vertical--carousel--wrap">
                    <?php
                    while ($the_query->have_posts()):
                        $the_query->the_post();
                        $classes = 'saren--single--product main--carousel--item'
                            ?>

                        <div class="product--item">
                            <?php sarenProductRender($settings, wc_get_product(), $classes, true, true);
                            ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class=slider--navigation>

                <?php if ($settings['nav_type'] === 'text') { ?>

                    <span class="slider--nav--item nav--prev"><?php echo $settings['prev_text']; ?></span>
                    <span class="slider--nav--item nav--next"><?php echo $settings['next_text']; ?></span>

                <?php } else { ?>

                    <span class="slider--nav--item nav--prev">
                        <?php \Elementor\Icons_Manager::render_icon($settings['prev_icon'], ['aria-hidden' => 'true']); ?></span>
                    <span
                        class="slider--nav--item nav--next"><?php \Elementor\Icons_Manager::render_icon($settings['next_icon'], ['aria-hidden' => 'true']); ?></span>

                <?php } ?>


            </div>
        </div>



        <?php
    }
}

