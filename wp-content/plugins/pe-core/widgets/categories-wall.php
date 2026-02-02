<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class PeCategoriesWall extends Widget_Base
{
    public function get_name()
    {
        return 'pecategorieswall';
    }

    public function get_title()
    {
        return __('Pe Categories Wall', 'pe-core');
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

        $productCats = array();

        $args = array(
            'hide_empty' => true,
            'taxonomy' => 'product_cat'
        );

        $categories = get_categories($args);

        foreach ($categories as $key => $category) {
            $productCats[$category->term_id] = $category->name;
        }

        $this->add_control(
            'product_filter_cats',
            [
                'label' => __('Categories', 'pe-core'),
                'description' => __('Select portfolio categories to display projects.', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $productCats,

            ]
        );

        $this->add_control(
            'sup_caption',
            [
                'label' => esc_html__('Sup Caption', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'index__active'
            ]
        );

        $this->add_control(
            'sup_caption_type',
            [
                'label' => 'Sup Caption Type',
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'index' => 'Index',
                    'product--count' => 'Products Count',
                ],
                'default' => 'index',
            ]
        );
        $this->add_control(
            'cat_descs',
            [
                'label' => esc_html__('Descriptions', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'cat--descs',
                'prefix_class' => '',
                'default' => 'cat--descs',
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

        $this->add_responsive_control(
            'horizontal_align',
            [
                'label' => esc_html__('Horizontal Align', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .categories--wall .categories--wrapper' => 'justify-content: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'vertical_align',
            [
                'label' => esc_html__('Vertical Align', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'pe-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .categories--wall' => 'justify-content: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'content_width',
            [
                'label' => esc_html__('Content Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 70,
                    'unit' => '%'
                ],
                'selectors' => [
                    '{{WRAPPER}} .categories--wall .categories--wrapper' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => esc_html__('Margin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .categories--wall .categories--wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'vertical_gap',
            [
                'label' => esc_html__('Vertical Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 250,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .categories--wall .categories--wrapper' => 'row-gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'horizontal_gap',
            [
                'label' => esc_html__('Horizontal Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 250,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .categories--wall .categories--wrapper' => 'column-gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Sup Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .categories--wall .product--category'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sup_typography',
                'label' => esc_html__('Sup Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .categories--wall .product--category sup'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .categories--wall .category--image',
            ]
        );

        $this->end_controls_section();


        pe_color_options($this);
    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        $cursor = pe_cursor($this);



        ?>

        <div class="categories--wall anim-multiple" <?php echo pe_general_animation($this); ?>>
            <div class="categories--wrapper">

                <?php foreach ($settings['product_filter_cats'] as $key => $item) {
                    $cato = get_term_by('id', $item, 'product_cat');
                    if (!$cato) {
                        return false;
                    }
                    $category_link = get_term_link($cato);
                    ?>

                    <div class="product--category text-h3" data-index="<?php echo $key; ?>">

                        <a <?php echo $cursor ?> href="<?php echo !is_wp_error($category_link) ? esc_url($category_link) : ''; ?>"
                            class="inner--anim">

                            <?php if ($settings['sup_caption'] === 'index__active') {

                                ?>
                                <sup class="cat--index">
                                    <?php
                                    if ($settings['sup_caption_type'] === 'index') {
                                        $key = $key + 1;
                                        if ($key < 10) {
                                            echo '0' . $key;
                                        } else {
                                            echo $key;
                                        }
                                    } else {
                                        if ($cato->count < 10) {
                                            echo '0' . $cato->count;
                                        } else {
                                            echo $cato->count;
                                        }
                                    }
                                    ?>
                                </sup>
                            <?php }
                            echo $cato->name;
                            ?>
                        </a>
                    </div>
                <?php } ?>

            </div>

            <?php if ($settings['cat_descs'] === 'cat--descs') { ?>

                <div class="descs--wrapper">

                    <?php foreach ($settings['product_filter_cats'] as $key => $item) {
                        $category = get_term_by('id', $item, 'product_cat');
                        ?>

                        <div data-index="<?php echo $key; ?>" class="category--desc desc__<?php echo $key; ?>">

                            <?php echo esc_html($category->description) ?>

                        </div>

                    <?php } ?>


                </div>
            <?php } ?>

            <div class="images--wrapper">
                <?php foreach ($settings['product_filter_cats'] as $key => $item) { ?>
                    <div class="category--image image__<?php echo $key; ?>">
                        <?php
                        $cato = get_term_by('id', $item, 'product_cat');
                        $thumbnail_id = get_term_meta($cato->term_id, 'thumbnail_id', true);
                        $image_url = wp_get_attachment_url($thumbnail_id);

                        if ($image_url) {
                            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($cato->name) . '" />';
                        }

                        ?>
                    </div>
                <?php } ?>
            </div>

        </div>

        <?php
    }
}
