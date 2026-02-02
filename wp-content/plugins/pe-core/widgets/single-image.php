<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeSingleImage extends Widget_Base
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
        return 'pesingleimage';
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
        return __('Single Image', 'pe-core');
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
        return 'eicon-image pe-widget';
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
                'label' => __('Image', 'pe-core'),
            ]
        );

        $this->add_control(
            'image',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'exclude' => [],
                'include' => [],
                'default' => 'full',
            ]
        );


        $this->add_control(
            'type',
            [
                'label' => esc_html__('Image Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'single--image' => esc_html__('Single', 'pe-core'),
                    'parallax--image' => esc_html__('Parallax', 'pe-core'),
                    'masked--image' => esc_html__('Masked', 'pe-core'),
                    'zoomed--image' => esc_html__('Zoomed', 'pe-core'),
                ],
                'default' => 'single--image',
                'label_block' => true
            ]
        );

        $this->add_control(
            'zoom_direction',
            [
                'label' => esc_html__('Zoom Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'zoom--vertical' => [
                        'title' => esc_html__('Vertical', 'pe-core'),
                        'icon' => 'eicon-arrow-up',
                    ],
                    'zoom--horizontal' => [
                        'title' => esc_html__('Horizontal', 'pe-core'),
                        'icon' => 'eicon-arrow-left'
                    ],
                ],
                'default' => 'zoom--horizontal',
                'toggle' => true,
                'label_block' => true,
                'condition' => [
                    'type' => 'zoomed--image',
                ]
            ]
        );

        $this->add_control(
            'zoomed__before__image',
            [
                'label' => esc_html__('Before Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'type' => 'zoomed--image',
                ]
            ]
        );

        $this->add_control(
            'zoomed__after__image',
            [
                'label' => esc_html__('After Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'type' => 'zoomed--image',
                ]
            ]
        );


        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
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


        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['vh', 'px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .single--image' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .parallax--image' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .single--image img' => 'height: 100%;object-fit: cover',

                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .single-image' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                    '{{WRAPPER}} .single-image.zoomed--image > div' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'pe-core'),
                'description' => esc_html__('Leave it empty if you dont want to make the image linked.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => true,
            ]
        );


        $this->add_control(
            'image__overlay',
            [
                'label' => esc_html__('Overlay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'si--overlayed',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'overlay__color',
            [
                'label' => esc_html__('Overlay Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--overlayColor: {{VALUE}}',
                ],
                'condition' => ['image__overlay' => 'si--overlayed'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .single-image',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'cursor_interactions',
            [
                'label' => __('Cursor Interactions', 'pe-core'),
            ]
        );

        $this->add_control(
            'cursor_type',
            [
                'label' => esc_html__('Interaction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core'),
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'none' => esc_html__('None', 'pe-core'),

                ],

            ]
        );

        $this->add_control(
            'cursor_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'description' => esc_html__('Only Material Icons allowed, do not select Font Awesome icons.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
                'condition' => ['cursor_type' => 'icon'],
            ]
        );

        $this->add_control(
            'cursor_text',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => ['cursor_type' => 'text'],
            ]
        );


        $this->end_controls_section();

        pe_image_animation_settings($this);



    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $type = $settings['type'];

        $classes = [];

        array_push($classes, [$settings['type'], $settings['zoom_direction'], $settings['image__overlay']]);
        $imageClasses = implode(' ', array_filter($classes[0]));

        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('link', $settings['link']);
        }


        ?>

        <div class="single-image <?php echo $imageClasses ?>" <?php echo pe_image_animation($this); ?>>

            <?php if ($type === 'zoomed--image') { ?>

                <div class="single--image--wrapper zoomed--before">

                    <?php
                    echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'image_size', 'zoomed__before__image');
                    ?>

                </div>

                <div class="single--image--wrapper zoomed--center">

                    <?php
                    echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'image_size', 'image');
                    ?>

                </div>


                <div class="single--image--wrapper zoomed--after">

                    <?php
                    echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'image_size', 'zoomed__after__image');
                    ?>

                </div>
            <?php } else { ?>
                <?php if (!empty($settings['link']['url'])) { ?>

                    <a <?php echo $this->get_render_attribute_string('link') . pe_cursor($this); ?>>

                    <?php } 
                    echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'image_size', 'image');
                     if (!empty($settings['link']['url'])) {
                        echo '</a>';
                    } ?>


                <?php } ?>
        </div>


        <?php
    }

}
