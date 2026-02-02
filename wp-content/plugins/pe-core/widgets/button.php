<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeButton extends Widget_Base
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
        return 'pebutton';
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
        return __('Button', 'pe-core');
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
        return 'eicon-button pe-widget';
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

        if (class_exists("Redux")) {
            $option = get_option('pe-redux');
        } else {
            $option = false;
        }

        $this->start_controls_section(
            'section_project_title',
            [
                'label' => __('Button', 'pe-core'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Write your text here', 'pe-core'),
                'default' => esc_html('Button', 'pe-core')
            ]
        );

        $this->add_control(
            'interaction',
            [
                'label' => esc_html__('Interaction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'link',
                'options' => [
                    'link' => esc_html__('Link', 'pe-core'),
                    'pe--scroll--button' => esc_html__('Scroll To', 'pe-core'),
                ],

            ]
        );

        $this->add_control(
            'scroll_target',
            [
                'label' => esc_html__('Scroll To', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Eg: #aboutContainer', 'pe-core'),
                'description' => esc_html__('Enter a target ID or exact number of desired scroll position ("0" for scrolling top)', 'pe-core'),
                'condition' => ['interaction' => 'pe--scroll--button'],
            ]
        );

        $this->add_control(
            'scroll_duration',
            [
                'label' => esc_html__('Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'step' => 0.1,
                'default' => 1,
                'description' => esc_html__('Seconds', 'pe-core'),
                'condition' => ['interaction' => 'pe--scroll--button'],
            ]
        );


        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow', 'custom_attributes'],
                'default' => [
                    'url' => 'http://',
                    'is_external' => false,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => false,
                'condition' => ['interaction' => 'link'],
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => esc_html__('Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => $option ? $option['button_size'] : 'pb--normal',
                'options' => [
                    'pb--small' => esc_html__('Small', 'pe-core'),
                    'pb--normal' => esc_html__('Normal', 'pe-core'),
                    'pb--medium' => esc_html__('Medium', 'pe-core'),
                    'pb--large' => esc_html__('Large', 'pe-core'),
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'pb--background',
                'default' => $option ? $option['button_background'] : '',
            ]
        );

        $this->add_control(
            'bordered',
            [
                'label' => esc_html__('Bordered', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'pb--bordered',
                'default' => $option ? $option['button_bordered'] : '',
            ]
        );



        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .pe--button a',
                'condition' => ['bordered' => 'pb--bordered'],
            ]
        );


        $this->add_control(
            'marquee',
            [
                'label' => esc_html__('Marquee', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'pb--marquee',
                'default' => $option ? $option['button_marquee'] : '',
            ]
        );

        $this->add_control(
            'marquee_direction',
            [
                'label' => esc_html__('Marquee Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left-to-right' => [
                        'title' => esc_html__('Left To Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'right-to-left' => [
                        'title' => esc_html__('Right To Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                ],
                'default' => 'right-to-left',
                'toggle' => false,
                'label_block' => false,
                'condition' => ['marquee' => 'pb--marquee'],
            ]
        );

        $this->add_control(
            'marquee_duration',
            [
                'label' => esc_html__('Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 60,
                'step' => 1,
                'default' => 5,
                'condition' => ['marquee' => 'pb--marquee'],
                'selectors' => [
                    '{{WRAPPER}} .pb--marquee__inner' => '--duration: {{VALUE}}s;',
                ],
            ]
        );

        $this->add_control(
            'underlined',
            [
                'label' => esc_html__('Underlined', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'pb--underlined',
                'default' => $option ? $option['button_underlined'] : '',
                'condition' => ['marquee!' => 'pb--marquee'],
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' => esc_html__('Show Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'pb--icon',
                'default' => $option ? $option['button_show_icon'] : '',
            ]
        );


        $this->add_control(
            'icon',
            [
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'material-icons md-arrow_outward',
                    'library' => 'material-design-icons',
                ],
                'condition' => ['show_icon' => 'pb--icon'],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'icon__left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'icon__right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => $option ? $option['button_icon_position'] : 'icon__left',
                'toggle' => false,
                'condition' => ['show_icon' => 'pb--icon'],

            ]
        );


        $this->end_controls_section();

        pe_cursor_settings($this);
        pe_general_animation_settings($this);

        $this->start_controls_section(
            'button_styles',
            [

                'label' => esc_html__('Button Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'button_width',
            [
                'label' => esc_html__('Button Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0, 
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--button--wrapper a' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pe--button' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pe--button--wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'items_alignment',
            [
                'label' => esc_html__('Items Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pb__main' => 'justify-content: {{VALUE}};',
                ],
                'default' => 'start',
                'toggle' => false,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .pe--button',
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--button i' => 'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe--button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'underline_height',
            [
                'label' => esc_html__('Underline Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 60,
                'step' => 1,
                'condition' => ['underlined' => 'pb--underlined'],
                'selectors' => [
                    '{{WRAPPER}} .pe--button.pb--underlined .pe--button--wrapper a::after' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe--button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'color_options',
            [
                'label' => esc_html__('Colors', 'pe-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->end_controls_section();



        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $classes = [];

        array_push($classes, [$settings['background'], $settings['bordered'], $settings['underlined'], $settings['marquee'], $settings['show_icon'], $settings['icon_position'], $settings['button_size'], $settings['interaction']]);
        $mainClasses = implode(' ', array_filter($classes[0]));

        ob_start();

        \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']);

        $icon = ob_get_clean();

        $buttonText = $settings['button_text'];

        $buttonHTML = ($settings['icon_position'] === 'icon__left' ? $icon : '') . $buttonText . ($settings['icon_position'] === 'icon__right' ? $icon : '');

        // Button Link
        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('link', $settings['link']);
        }


        //Scroll Button Attributes
        $this->add_render_attribute(
            'scroll_attributes',
            [
                'data-scroll-to' => $settings['scroll_target'],
                'data-scroll-duration' => $settings['scroll_duration'],

            ]
        );

        $scrollAttributes = $settings['interaction'] === 'pe--scroll--button' ? $this->get_render_attribute_string('scroll_attributes') : '';


        ?>

        <div class="pe--button <?php echo esc_attr($mainClasses) ?>" <?php echo $scrollAttributes . ' ' . pe_general_animation($this) ?>>

            <div class="pe--button--wrapper">

                <?php if (!empty($settings['link']['url'])) { ?>

                    <a <?php echo $this->get_render_attribute_string('link') . pe_cursor($this); ?>>

                    <?php } else {
                    echo '<a href="#.">';
                } ?>

                    <span class="pb__main"><?php echo $buttonHTML ?>

                        <?php if ($settings['underlined'] !== 'pb--underlined') {
                            if ($settings['background'] === 'pb--background' || $settings['bordered'] === 'pb--bordered') {
                                ?>


                                <span class="pb__hover"><?php echo $buttonHTML ?></span>

                            <?php }
                        } ?>

                    </span>


                    <?php if ($settings['marquee'] === 'pb--marquee') { ?>

                        <div class="pb--marquee--wrap <?php echo $settings['marquee_direction'] ?>" aria-hidden="true">
                            <div class="pb--marquee__inner">
                                <span><?php echo $buttonHTML ?></span>
                                <span><?php echo $buttonHTML ?></span>
                                <span><?php echo $buttonHTML ?></span>
                                <span><?php echo $buttonHTML ?></span>
                            </div>
                        </div>

                    <?php } ?>


                </a>



            </div>

        </div>

        <?php

    }

}
