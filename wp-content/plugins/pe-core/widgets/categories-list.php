<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class PeCategoriesList extends Widget_Base
{
    public function get_name()
    {
        return 'pecategorieslist';
    }

    public function get_title()
    {
        return __('Pe Categories List', 'pe-core');
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
            'divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
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
            'speed',
            [
                'label' => esc_html__('Speed', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 20000,
                'step' => 100
            ]
        );


        $this->add_control(
            'image_position_type',
            [
                'label' => esc_html__('Image Position Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cursor__image',
                'options' => [
                    'cursor__image' => esc_html__('Follow Cursor', 'pe-core'),
                    'static__image' => esc_html__('Static', 'pe-core'),
                ],
            ]
        );

        $this->add_responsive_control(
            'image_left',
            [
                'label' => esc_html__('Horizontal Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
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
                'selectors' => [
                    '{{WRAPPER}} .categories--list.static__image .images--wrapper' => 'left: {{SIZE}}{{UNIT}}'
                ],
                'condition' => [
                    'image_position_type' => 'static__image'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_top',
            [
                'label' => esc_html__('Vertical Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1
                    ],
                    'vh' => [
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
                    '{{WRAPPER}} .categories--list.static__image .images--wrapper' => 'top: {{SIZE}}{{UNIT}}'
                ],
                'condition' => [
                    'image_position_type' => 'static__image'
                ]
            ]
        );


        $this->end_controls_section();



        pe_cursor_settings($this);
        pe_general_animation_settings($this);

        $this->start_controls_section(
            'style',
            [
                'label' => esc_html__('Image', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'project_width',
            [
                'label' => esc_html__('Image Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 5
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .category--image' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'equal_height',
            [
                'label' => esc_html__('Equal Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'equal__height'
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 5
                    ],
                    'vh' => [
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
                    '{{WRAPPER}} .categories--list .images--wrapper' => 'height: {{SIZE}}{{UNIT}}'
                ],
                'condition' => [
                    'equal_height' => 'equal__height'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title', 'pe-core'),
                'selector' => '{{WRAPPER}} .categories--list .product--category'
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
        ob_start();
        \Elementor\Icons_Manager::render_icon($settings['head_icon'], ['aria-hidden' => 'true']);
        $icon = ob_get_clean();
        $classes = [];

        if ($settings['speed']) {
            $speed = $settings['speed'];
        } else {
            $speed = '5000';
        }

        ?>

        <div class="categories--list anim-multiple <?php echo $settings['equal_height'] . " " . $settings['image_position_type']; ?>"
            data-speed="<?php echo $speed; ?>" data-pin-target="<?php echo $settings['pinned--elements']; ?>" <?php echo pe_general_animation($this); ?>>

            <div class="categories--wrapper">
                <?php foreach ($settings['product_filter_cats'] as $key => $item) {
                    $cato = get_term_by('id', $item, 'product_cat');
                    $category_link = get_term_link($cato);
                    ?>

                    <div class="product--category category__<?php echo $key; ?> text-h1 md-title">
                        <a <?php echo $cursor ?> href="<?php echo !is_wp_error($category_link) ? esc_url($category_link) : ''; ?>"
                            class="inner--anim">
                            <?php
                            echo $cato->name;
                            ?>
                        </a>
                    </div>
                <?php } ?>
            </div>

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
