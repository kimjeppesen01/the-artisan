<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peReviews extends Widget_Base
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
        return 'pereviews';
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
        return __('Reviews', 'pe-core');
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
        return 'eicon-review pe-widget';
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

        // Tab Title Control
        $this->start_controls_section(
            'section_tab_title',
            [
                'label' => __('Reviews', 'pe-core'),
            ]
        );

        $this->add_control(
            'reviews_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slideshow',
                'render_type' => 'template',
                'prefix_class' => 'reviews--swiper--',
                'options' => [
                    'slideshow' => esc_html__('Slideshow', 'pe-core'),
                    'carousel' => esc_html__('Carousel', 'pe-core'),
                ],
                'label_block' => false,
            ]
        );

        $this->add_control(
            'reviews_per_view',
            [
                'label' => esc_html__('Reviews Per View', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 4,
                ],
                'condition' => [
                    'reviews_style' => ['carousel'],
                ],
            ]
        );

        $this->add_control(
            'slides_gap',
            [
                'label' => esc_html__('Items Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 1,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 0,
                ],
                'condition' => [
                    'reviews_style' => ['carousel'],
                ],
            ]
        );

        $this->add_control(
            'entries',
            [
                'label' => esc_html__('Entries', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'manual',
                'options' => [
                    'manual' => esc_html__('Manual', 'pe-core'),
                    'auto' => esc_html__('Auto', 'pe-core'),

                ],
                'label_block' => false,
            ]
        );

        $this->add_control(
            'minimum_rating',
            [
                'label' => esc_html__('Minimum Rating', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 1,
                        'max' => 5,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 4,
                ],
                'condition' => [
                    'entries' => ['auto'],
                ],
            ]
        );

        $this->add_control(
            'ratings_count',
            [
                'label' => esc_html__('Count', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 999,
                'step' => 1,
                'render_type' => 'template',
                'default' => 10,
                'condition' => [
                    'entries' => ['auto'],
                ],

            ]
        );



        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'avatar',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Name', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('John Doe', 'pe-core'),
            ]
        );


        $repeater->add_control(
            'comment',
            [
                'label' => esc_html__('Comment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('List Content', 'pe-core'),
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consequat egestas nisi. Vestibulum malesuada fermentum nibh. Donec venenatis, neque et pellentesque efficitur, lectus est preti.', 'pe-core'),

            ]
        );

        $repeater->add_control(
            'rating',
            [
                'label' => esc_html__('Rating', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 1,
                        'max' => 5,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 5,
                ],
            ]
        );


        $this->add_control(
            'manual_entries',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'name' => esc_html__('John Doe', 'pe-core'),
                        'comment' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consequat egestas nisi. Vestibulum malesuada fermentum nibh. Donec venenatis, neque et pellentesque efficitur, lectus est preti.', 'pe-core'),
                    ],
                ],
                'title_field' => '{{{ name }}}',
                'condition' => ['entries' => 'manual'],
            ]
        );

        $this->add_control(
            'slider_id',
            [
                'label' => esc_html__('Slider ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );


        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'reviews--has--bg',
                'prefix_class' => '',
                'default' => '',

            ]
        );

        $this->add_control(
            'bordered',
            [
                'label' => esc_html__('Bordered?', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'reviews--has--border',
                'prefix_class' => '',
                'default' => '',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'reviews_border',
                'selector' => '{{WRAPPER}} .swiper-slide.saren--rating--slide',
                'condition' => ['bordered' => 'reviews--has--border'],
            ]
        );



        $this->end_controls_section();

        pe_cursor_settings($this);

        $this->start_controls_section(
            'Style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'spacings',
            [
                'label' => esc_html__('Items Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        'vw' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                        'vh' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide.saren--rating--slide' => 'row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide.saren--rating--slide' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => esc_html__('Name Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .sr--user--name'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Comment Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .sr--comment p.p--large'
            ]
        );



        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Content Size'),
                'selector' => '{{WRAPPER}} .pt-content p'
            ]
        );


        $this->add_control(
            'avatar_width',
            [
                'label' => esc_html__('Avatar Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 25
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .sr--user--image' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'avatar_height',
            [
                'label' => esc_html__('Avatar Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 25
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .sr--user--image' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'avatar_border_radius',
            [
                'label' => esc_html__('Avatar Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_unit' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sr--user--image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'rating_order',
            [
                'label' => esc_html__('Rating Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .sr--rating' => 'order: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'product_title_order',
            [
                'label' => esc_html__('Comment Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide.saren--rating--slide a' => 'order: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'comment_order',
            [
                'label' => esc_html__('Comment Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .sr--comment' => 'order: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'user_order',
            [
                'label' => esc_html__('User Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .sr--user' => 'order: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'stars_color',
            [
                'label' => esc_html__('Stars Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sr--rating svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        pe_color_options($this);


    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $entry = $settings['entries'];

        $star = file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/star.svg');
        $starFill = file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/star-fill.svg');

        if ($entry === 'auto') {

            $args = array(
                'post_type' => 'product',
                'status' => 'approve',
                'number' => $settings['ratings_count'],
                'orderby' => 'comment_date',
                'order' => 'DESC'
            );
            $comments = get_comments($args);
        } else if ($entry === 'manual') {
            $comments = $settings['manual_entries'];
        }

        if (!empty($comments)) { ?>

            <div data-per-view="<?php echo esc_attr($settings['reviews_per_view']['size']) ?>"
                data-gap="<?php echo esc_attr($settings['slides_gap']['size']) ?>"
                class="swiper-container ratings--swiper <?php echo $settings['slider_id']; ?>">

                <div class="swiper-wrapper">

                    <?php
                    foreach ($comments as $comment) {

                        if ($entry === 'auto') {
                            $product = wc_get_product($comment->comment_post_ID);
                            $rating = get_comment_meta($comment->comment_ID, 'rating', true);
                            $name = esc_html($comment->comment_author);
                            $commentContent = esc_html($comment->comment_content);
                            $product = esc_html($product->get_name());
                            $productLink = get_permalink($comment->comment_post_ID);
                            $rating = !empty($rating) ? $rating . '' : '';
                            $avatar = get_avatar($comment->comment_author_email, 50);

                            if ($rating < $settings['minimum_rating']['size']) {
                                $product = false;
                            }

                        } else {

                            $product = true;
                            $rating = $comment['rating']['size'];
                            $name = $comment['name'];
                            $commentContent = $comment['comment'];
                            $avatar = '<img src="' . $comment['avatar']['url'] . '"/>';

                        } ?>

                        <?php if ($product) { ?>

                            <div class="swiper-slide cr--item saren--rating--slide">

                                <div style="--rating: <?php echo $rating ?>" class="sr--rating">

                                    <?php for ($i = 0; $i < 5; $i++) {
                                        echo '<span class="sr--star">' . $star . '</span>';
                                    }
                                    echo '<span class="sr--stars--fill">';
                                    for ($i = 0; $i < 5; $i++) {
                                        echo '<span class="sr--star-fill">' . $starFill . '</span>';
                                    }
                                    echo '</span>'
                                        ?>
                                </div>

                                <?php if ($entry === 'auto') { ?>
                                    <a href="<?php echo $productLink ?>"><?php echo $product ?></a>
                                <?php } ?>
                                <div class="sr--comment">
                                    <p class="p--large"><?php echo $commentContent ?></p>
                                </div>

                                <div class="sr--user">
                                    <div class="sr--user--image"><?php echo $avatar ?></div>
                                    <div class="sr--user--name"><?php echo $name ?></div>

                                </div>

                            </div>
                        <?php } ?>

                    <?php } ?>

                </div>

            </div>

        <?php }
    }

}
