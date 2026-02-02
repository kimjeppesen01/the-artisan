<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeTextWrapper extends Widget_Base
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
        return 'petextwrapper';
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
        return __('Pe Text Wrapper', 'pe-core');
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
        return 'eicon-animation-text pe-widget';
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
                'label' => __('Text Wrapper', 'pe-core'),
            ]
        );

        $this->add_control(
            'convert_heading',
            [
                'label' => esc_html__('Convert to Heading', 'pe-core'),
                'description' => esc_html__('The text will be converted to a heading tag (H1, H2, H3... etc.).', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'converted_heading',
                'default' => 'no',

            ]
        );

        $this->add_control(
            'heading_tag',
            [
                'label' => esc_html__('Heading Tag', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'h1' => [
                        'title' => esc_html__('H1', 'pe-core'),
                        'icon' => ' eicon-editor-h1',
                    ],
                    'h2' => [
                        'title' => esc_html__('H2', 'pe-core'),
                        'icon' => ' eicon-editor-h2',
                    ],
                    'h3' => [
                        'title' => esc_html__('H3', 'pe-core'),
                        'icon' => ' eicon-editor-h3',
                    ],
                    'h4' => [
                        'title' => esc_html__('H4', 'pe-core'),
                        'icon' => ' eicon-editor-h4',
                    ],
                    'h5' => [
                        'title' => esc_html__('H5', 'pe-core'),
                        'icon' => ' eicon-editor-h5',
                    ],
                    'h6' => [
                        'title' => esc_html__('H6', 'pe-core'),
                        'icon' => ' eicon-editor-h6',
                    ]

                ],
                'default' => 'h6',
                'toggle' => true,
                'condition' => ['convert_heading' => 'converted_heading'],
            ]
        );

        $this->add_control(
            'text_wrapper',
            [
                'label' => esc_html__('Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Write your text here', 'pe-core'),
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consequat egestas nisi. Vestibulum malesuada fermentum nibh. Donec venenatis, neque et pellentesque efficitur, lectus est preti.', 'pe-core'),
                'description' => esc_html__('HTML tags allowed.', 'pe-core'),
                'rows' => 10,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );


        $this->add_control(
            'text_type',
            [
                'label' => esc_html__('Text Size', 'pe-core'),
                'description' => esc_html__('This option will not change HTML tag of the element, this option only for typographic scaling.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'text-p' => [
                        'title' => esc_html__('P', 'pe-core'),
                        'icon' => ' eicon-editor-paragraph',
                    ],
                    'text-h1' => [
                        'title' => esc_html__('H1', 'pe-core'),
                        'icon' => ' eicon-editor-h1',
                    ],
                    'text-h2' => [
                        'title' => esc_html__('H2', 'pe-core'),
                        'icon' => ' eicon-editor-h2',
                    ],
                    'text-h3' => [
                        'title' => esc_html__('H3', 'pe-core'),
                        'icon' => ' eicon-editor-h3',
                    ],
                    'text-h4' => [
                        'title' => esc_html__('H4', 'pe-core'),
                        'icon' => ' eicon-editor-h4',
                    ],
                    'text-h5' => [
                        'title' => esc_html__('H5', 'pe-core'),
                        'icon' => ' eicon-editor-h5',
                    ],
                    'text-h6' => [
                        'title' => esc_html__('H6', 'pe-core'),
                        'icon' => ' eicon-editor-h6',
                    ]

                ],
                'default' => 'text-p',
                'toggle' => true,
                'condition' => ['convert_heading!' => 'converted_heading'],
            ]
        );

        $this->add_control(
            'paragraph_size',
            [
                'label' => esc_html__('Paragraph Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Normal', 'pe-core'),
                    'p-small' => esc_html__('Small', 'pe-core'),
                    'p-large' => esc_html__('Large', 'pe-core'),

                ],
                'label_block' => true,
                'condition' => ['text_type' => 'text-p'],
            ]
        );

        $this->add_control(
            'heading_size',
            [
                'label' => esc_html__('Heading Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Normal', 'pe-core'),
                    'md-title' => esc_html__('Medium', 'pe-core'),
                    'big-title' => esc_html__('Large', 'pe-core'),

                ],
                'label_block' => true,
                'condition' => ['text_type' => 'text-h1'],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => esc_html__('Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .text-wrapper p , {{WRAPPER}} .text-wrapper > *',
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' => esc_html__('Use Secondary Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'use--sec--color',
                'default' => '',

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
                    'justify' => [
                        'title' => esc_html__('Justify', 'pe-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .text-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_align_last',
            [
                'label' => esc_html__('Justify Last Line?', 'pe-core'),
                'description' => esc_html__('On mobile screens "br" tags will be removed.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'justify-last',
                'default' => false,
                'condition' => ['alignment' => 'justify'],
            ]
        );


        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'remove_breaks',
            [
                'label' => esc_html__('Remove Breaks on Mobile', 'pe-core'),
                'description' => esc_html__('On mobile screens "br" tags will be removed.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide-br-mobile',
                'default' => '',

            ]
        );


        $this->add_control(
            'remove_margins',
            [
                'label' => esc_html__('Remove Margins', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'no-margin',
                'default' => '',

            ]
        );


        $this->add_responsive_control(
            'text-indent',
            [
                'label' => esc_html__('Text Indent', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .text-wrapper' => '--indent: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'text_stroke',
            [
                'label' => esc_html__('Text Stroke', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => 'text-stroke-',
                'default' => 'no',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'customize_text',
            [
                'label' => __('Customize Text', 'pe-core'),
            ]
        );

        $this->add_control(
            'customize_words',
            [
                'label' => esc_html__('Customize Words', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',

            ]
        );

        $words = new \Elementor\Repeater();

        $words->add_control(
            'target_word',
            [
                'label' => esc_html__('Target Word', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Eg: ipsum', 'pe-core'),
                'description' => esc_html__('IMPORTANT NOTICE; these word must be exactly match with the word in the wrapper (case sensitivity, signs etc.).', 'pe-core'),
            ]
        );

        $words->add_control(
            'word_link',
            [
                'label' => esc_html__('Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',

            ]
        );

        $words->add_control(
            'word_link_target',
            [
                'label' => esc_html__('URL', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter target URL here', 'pe-core'),
                'condition' => ['word_link' => 'true'],
            ]
        );

        $words->add_control(
            'word_link_behavior',
            [
                'label' => esc_html__('Open in new tab?', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => '_blank',
                'default' => '_self',
                'condition' => ['word_link' => 'true'],
            ]
        );

        $words->add_control(
            'prevent_barba',
            [
                'label' => esc_html__('Prevent AJAX', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'all',
                'default' => 'false',
                'condition' => ['word_link' => 'true'],
            ]
        );

        $words->start_controls_tabs(
            'word_tabs'
        );

        $words->start_controls_tab(
            'word_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
            ]
        );

        $words->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'word_typography',
                'label' => esc_html__('Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
            ]
        );


        $words->add_control(
            'word_color',
            [
                'label' => esc_html__('Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
                ],
            ]
        );

        $words->add_control(
            'underlined_text',
            [
                'label' => esc_html__('Underlined', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'underlined',
                'default' => 'no-underline',
            ]
        );


        $words->add_responsive_control(
            'underline_height',
            [
                'label' => esc_html__('Inderline Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
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
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}::after' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['underlined_text' => 'underlined'],
            ]
        );



        $words->add_control(
            'element_bg_color',
            [
                'label' => esc_html__('Background Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--element--bg: {{VALUE}}',
                ],

            ]
        );



        $words->add_control(
            'border_style',
            [
                'label' => esc_html__('Border Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'solid' => esc_html__('Solid', 'pe-core'),
                    'double' => esc_html__('Double', 'pe-core'),
                    'dotted' => esc_html__('Dotted', 'pe-core'),
                    'dashed' => esc_html__('Dashed', 'pe-core'),
                    'groove' => esc_html__('Groove', 'pe-core'),

                ],
                'label_block' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--border-style: {{VALUE}};',
                ],
            ]
        );

        $words->add_responsive_control(
            'border_width',
            [
                'label' => esc_html__('Border Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'condition' => ['border_style!' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $words->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 0,
                    'right' => 5,
                    'bottom' => 0,
                    'left' => 5,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--pPadding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $words->add_responsive_control(
            'border-radius',
            [
                'label' => esc_html__('Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--bRadius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $words->end_controls_tab();

        $words->start_controls_tab(
            'word_transform',
            [
                'label' => esc_html__('Transform', 'pe-core'),
            ]
        );


        $words->add_responsive_control(
            'rotate',
            [
                'label' => esc_html__('Rotate', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'condition' => ['motion' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--pe-rotate: {{SIZE}}deg;',
                ],
            ]
        );

        $words->add_responsive_control(
            'scale',
            [
                'label' => esc_html__('Scale', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'condition' => ['motion' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--pe-scale: {{SIZE}};',
                ],
            ]
        );

        $words->add_responsive_control(
            'offset_x',
            [
                'label' => esc_html__('Offset X', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'condition' => ['motion' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--pe-translate-x: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $words->add_responsive_control(
            'offset_y',
            [
                'label' => esc_html__('Offset Y', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'condition' => ['motion' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--pe-translate-y: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $words->add_responsive_control(
            'margin-right',
            [
                'label' => esc_html__('Right Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'condition' => ['motion' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $words->add_responsive_control(
            'margin-left',
            [
                'label' => esc_html__('Left Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'condition' => ['motion' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $words->end_controls_tab();


        $words->start_controls_tab(
            'word_motion',
            [
                'label' => esc_html__('Motion', 'pe-core'),
            ]
        );

        $words->add_control(
            'word_notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>If you apply a motion effect to this word, you will not be able to adjust transform values anymore.</span></div>',
                'condition' => ['motion!' => 'none'],

            ]
        );


        $words->add_control(
            'motion',
            [
                'label' => esc_html__('Motion Effects', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'me--rotate' => esc_html__('Rotate', 'pe-core'),
                    'me--flip-x' => esc_html__('Flip X', 'pe-core'),
                    'me--flip-y' => esc_html__('Flip Y', 'pe-core'),
                    'me--slide-left' => esc_html__('Slide Left', 'pe-core'),
                    'me--slide-right' => esc_html__('Slide Right', 'pe-core'),
                    'me--hearth-beat' => esc_html__('Heartbeat', 'pe-core'),

                ],
                'label_block' => true
            ]
        );

        $words->add_control(
            'motion_duration',
            [
                'label' => esc_html__('Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'step' => 0.1,
                'default' => 1,
                'condition' => ['motion!' => 'none'],
            ]
        );

        $words->add_control(
            'motion_repeat_delay',
            [
                'label' => esc_html__('Repeat Delay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 0.1,
                'default' => 0,
                'condition' => ['motion!' => 'none'],
            ]
        );


        $words->end_controls_tab();

        $words->end_controls_tabs();


        $this->add_control(
            'customized_words',
            [
                'label' => esc_html__('Customize Words.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $words->get_controls(),
                'title_field' => '{{{ target_word }}}',
                'prevent_empty' => false,
                'show_label' => false,
                'condition' => ['customize_words' => 'true'],
            ]
        );

        $this->add_control(
            'customize_lines',
            [
                'label' => esc_html__('Customize Lines', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $lines = new \Elementor\Repeater();

        $lines->add_control(
            'target_line',
            [
                'label' => esc_html__('Target Line', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Eg: 1', 'pe-core'),
                'ai' => false,
                'description' => esc_html__('Enter the target paragraph line number here to customize. (Using line breaks "<br>" on your text is recommended for proper customization.)', 'pe-core'),
            ]
        );

        $lines->add_responsive_control(
            'line_alignment',
            [
                'label' => esc_html__('Line Alignment', 'pe-core'),
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
                    'justify' => [
                        'title' => esc_html__('Justify', 'pe-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};text-align-last: {{VALUE}};',
                ],
            ]
        );

        $lines->add_responsive_control(
            'line_indent_left',
            [
                'label' => esc_html__('Indent Left', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $lines->add_responsive_control(
            'line_indent_right',
            [
                'label' => esc_html__('Indent Right', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'customized_lines',
            [
                'label' => esc_html__('Customize Lines.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $lines->get_controls(),
                'title_field' => 'Line: {{{ target_line }}}',
                'prevent_empty' => false,
                'show_label' => false,
                'condition' => ['customize_lines' => 'true'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'additonal',
            [
                'label' => __('Additional Features', 'pe-core'),
            ]
        );

        $repeater = new \Elementor\Repeater();


        $repeater->add_control(
            'element_type',
            [
                'label' => esc_html__('Element Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'image' => esc_html__('Image', 'pe-core'),
                    'video' => esc_html__('Video', 'pe-core'),
                    'sup' => esc_html__('Sup-Text', 'pe-core'),
                ],
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'target_word',
            [
                'label' => esc_html__('Target Word', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'placeholder' => esc_html__('Eg: ipsum', 'pe-core'),
                'description' => esc_html__('IMPORTANT NOTICE; these word must be exactly match with the word in the wrapper (case sensitivity, signs etc.).', 'pe-core'),
            ]
        );



        $repeater->add_control(
            'insert_at',
            [
                'label' => esc_html__('Insert Element At:', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'before' => [
                        'title' => esc_html__('Before', 'pe-core'),
                        'icon' => 'eicon-chevron-left',
                    ],
                    'after' => [
                        'title' => esc_html__('After', 'pe-core'),
                        'icon' => 'eicon-chevron-right',
                    ],

                ],
                'default' => 'after',
                'toggle' => false,
            ]
        );

        $repeater->add_control(
            'element_text',
            [
                'label' => esc_html__('Sup-Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Eg: SUP', 'pe-core'),
                'ai' => false,
                'condition' => ['element_type' => 'sup'],
            ]
        );

        $repeater->add_control(
            'element_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                    'fa-regular' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                ],
                'condition' => ['element_type' => 'icon'],
            ]
        );

        $repeater->add_control(
            'element_image',
            [
                'label' => esc_html__('Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => ['element_type' => 'image'],
            ]
        );

        pe_video_settings($repeater, 'element_type', 'video');

        $repeater->add_responsive_control(
            'video_width',
            [
                'label' => esc_html__('Video Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => .1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} span.inner--video' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .inserted--ls--hold' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['element_type' => 'video'],
            ]
        );

        $repeater->add_responsive_control(
            'video_height',
            [
                'label' => esc_html__('Video Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => .1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} span.inner--video' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .inserted--ls--hold' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['element_type' => 'video'],
            ]
        );

        $repeater->add_control(
            'video-border-radius',
            [
                'label' => esc_html__('Video Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['element_type' => 'video'],
            ]
        );

        $repeater->start_controls_tabs(
            'element_tabs'
        );

        $repeater->start_controls_tab(
            'element_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'element_color',
            [
                'label' => esc_html__('Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--color: {{VALUE}}',
                ],
                'condition' => ['element_type' => 'icon'],
            ]
        );

        $repeater->add_control(
            'element_opposite_color',
            [
                'label' => esc_html__('Opposite Color', 'pe-core'),
                'description' => esc_html__('Recommended if you are using layout switcher in the page. This color will be used when the layout switched.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    'body.dark {{WRAPPER}} {{CURRENT_ITEM}}' => '--color: {{VALUE}}',
                ],
                'condition' => ['element_color!' => ''],
            ]
        );


        $repeater->add_responsive_control(
            'font_size',
            [
                'label' => esc_html__('Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['element_type' => 'icon'],
            ]
        );

        $repeater->add_responsive_control(
            'image__width',
            [
                'label' => esc_html__('Image Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['element_type' => 'image'],
            ]
        );

        $repeater->add_responsive_control(
            'image__height',
            [
                'label' => esc_html__('Image Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['element_type' => 'image'],
            ]
        );

        $repeater->add_responsive_control(
            'border-radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['element_type' => 'image'],
            ]
        );




        $repeater->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
                'condition' => ['element_type' => 'image'],
            ]
        );




        $repeater->add_control(
            'ls_default_behavior',
            [
                'label' => esc_html__('Default Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'ls--default--none',
                'options' => [
                    'ls--default--none' => esc_html__('None', 'pe-core'),
                    'ls--default--revert' => esc_html__('Revert', 'pe-core'),
                    'ls--default--invert' => esc_html__('Invert', 'pe-core'),

                ],
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'ls_behavior',
            [
                'label' => esc_html__('Layout Switch Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'ls--none',
                'options' => [
                    'ls--none' => esc_html__('None', 'pe-core'),
                    'ls--revert' => esc_html__('Revert', 'pe-core'),
                    'ls--invert' => esc_html__('Invert', 'pe-core'),

                ],
                'label_block' => true
            ]
        );


        $repeater->add_control(
            'mobile_visibility',
            [
                'label' => esc_html__('Mobile Visibility', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'pe-core'),
                'label_off' => esc_html__('Show', 'pe-core'),
                'return_value' => 'hide--on--mobile',
                'default' => 'false',
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'element__transform',
            [
                'label' => esc_html__('Transform', 'pe-core'),
            ]
        );


        $repeater->add_responsive_control(
            'element_rotate',
            [
                'label' => esc_html__('Rotate', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'condition' => ['motion' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--pe-rotate: {{SIZE}}deg;',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'element_scale',
            [
                'label' => esc_html__('Scale', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'condition' => ['motion' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--pe-scale: {{SIZE}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'element_offset_x',
            [
                'label' => esc_html__('Offset X', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'condition' => ['motion' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--pe-translate-x: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'element_offset_y',
            [
                'label' => esc_html__('Offset Y', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'condition' => ['motion' => 'none'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--pe-translate-y: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'element_margin',
            [
                'label' => esc_html__('Margin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'element_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_control(
            'vertical_alignment',
            [
                'label' => esc_html__('Vertical Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__('Middle', 'pe-core'),
                        'icon' => 'eicon-v-align-middle'
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => ' eicon-v-align-bottom',
                    ],
                ],
                'default' => 'middle',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'vertical-align: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sup__typo',
                'label' => esc_html__('Sup Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
                'condition' => ['element_type' => 'sup'],
            ]
        );


        $repeater->add_responsive_control(
            'sup_top_spacing',
            [
                'label' => esc_html__('Top Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
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
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => .1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['element_type' => 'sup'],
            ]
        );

        $repeater->add_responsive_control(
            'sup_bottom_spacing',
            [
                'label' => esc_html__('Bottom Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
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
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => .1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['element_type' => 'sup'],
            ]
        );


        $repeater->end_controls_tab();


        $repeater->start_controls_tab(
            'element_motion',
            [
                'label' => esc_html__('Motion', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'motion',
            [
                'label' => esc_html__('Motion Effects', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'me--rotate' => esc_html__('Rotate', 'pe-core'),
                    'me--flip-x' => esc_html__('Flip X', 'pe-core'),
                    'me--flip-y' => esc_html__('Flip Y', 'pe-core'),
                    'me--slide-left' => esc_html__('Slide Left', 'pe-core'),
                    'me--slide-right' => esc_html__('Slide Right', 'pe-core'),
                    'me--hearth-beat' => esc_html__('Heartbeat', 'pe-core'),

                ],
                'label_block' => true
            ]
        );


        $repeater->add_control(
            'zoom__in',
            [
                'label' => esc_html__('Pin on Scrol', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'inserted--pin',
                'default' => 'false',
                'description' => esc_html__('Only one pinned element can be used in same wrapper.', 'pe-core'),

            ]
        );

        $repeater->add_control(
            'zoom__pin__target',
            [
                'label' => esc_html__('Pin Target', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Eg: #heroContainer', 'pe-core'),
                'description' => esc_html__('A pin container needed for proper animation. (Parent container recommended)', 'pe-core'),
                'ai' => false,
                'condition' => ['zoom__in' => 'inserted--pin'],
            ]
        );

        $repeater->add_control(
            'motion_duration',
            [
                'label' => esc_html__('Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'step' => 0.1,
                'default' => 1,
                'condition' => ['motion!' => 'none'],
            ]
        );

        $repeater->add_control(
            'motion_repeat_delay',
            [
                'label' => esc_html__('Repeat Delay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 0.1,
                'default' => 0,
                'condition' => ['motion!' => 'none'],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'insert_notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>Some of the text animations will be deprecated if you insert inner elements.</span></div>',
                'condition' => ['additional' => 'insert'],
            ]
        );

        $this->add_control(
            'dynamic_notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>Scrubbing/pinning on text scroll animations will be deprecated if you convert a word to dynamic.</span></div>',
                'condition' => ['additional' => 'dynamic'],
            ]
        );


        $this->add_control(
            'additional',
            [
                'label' => esc_html__('Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'description' => esc_html__('Will be used as intro animation.', 'pe-core'),
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'insert' => esc_html__('Insert Elements', 'pe-core'),
                    'dynamic' => esc_html__('Dynamic Word', 'pe-core'),
                ],
                'label_block' => true,
            ]
        );


        $this->add_control(
            'inner_elements',
            [
                'label' => esc_html__('Insert elements into text wrapper.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ element_type }}}',
                'prevent_empty' => false,
                'show_label' => false,
                'condition' => ['additional' => 'insert'],
            ]
        );


        $this->add_control(
            'convert_target_word',
            [
                'label' => esc_html__('Target Word', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Eg: ipsum', 'pe-core'),
                'description' => esc_html__('IMPORTANT NOTICE; these word must be exactly match with the word in the wrapper (case sensitivity, signs etc.).', 'pe-core'),
                'ai' => false,
                'condition' => ['additional' => 'dynamic'],
            ]
        );

        $this->add_control(
            'dynamic_words',
            [
                'label' => esc_html__('Dynamic Words', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('lorem , ipsum , dolor , sit , amet', 'pe-core'),
                'description' => esc_html__('Separate each dynamic word with a comma (,) example shown as placeholder above.', 'pe-core'),
                'rows' => 3,
                'ai' => false,
                'condition' => ['additional' => 'dynamic'],
            ]
        );

        $this->add_control(
            'words_color',
            [
                'label' => esc_html__('Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-wrapper span.pe-dynamic-words' => '--color: {{VALUE}}',
                ],
                'condition' => ['additional' => 'dynamic'],
            ]
        );

        $this->add_control(
            'dynamic_duration',
            [
                'label' => esc_html__('Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'step' => 0.1,
                'default' => 1.5,
                'condition' => ['additional' => 'dynamic'],
            ]
        );

        $this->add_control(
            'dynamic_delay',
            [
                'label' => esc_html__('Step Delay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 0.1,
                'default' => 1,
                'condition' => ['additional' => 'dynamic'],
            ]
        );

        $this->add_control(
            'dynamic_scrub',
            [
                'label' => esc_html__('Scrub', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
                'description' => esc_html__('Animation will follow scrolling behavior of the page.', 'pe-core'),
                'condition' => ['additional' => 'dynamic'],


            ]
        );

        $this->add_control(
            'dynamic_pin',
            [
                'label' => esc_html__('Pin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
                'description' => esc_html__('Wrapper will be pinned to screen until the animation has done.', 'pe-core'),
                'condition' => ['additional' => 'dynamic'],
            ]
        );


        $this->add_responsive_control(
            'white_space',
            [
                'label' => esc_html__('White Space', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('No-Wrap', 'pe-core'),
                'label_off' => esc_html__('Wrap', 'pe-core'),
                'return_value' => 'no--wrap',
                'prefix_class' => 'white--space--',
                'default' => '',
            ]
        );

        $this->add_control(
            'slide_text',
            [
                'label' => esc_html__('Slide', 'pe-core'),
                'description' => esc_html__('Slide text on scroll.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'slide--text',
                'prefix_class' => '',
                'render_type' => 'template',
                'default' => '',
                'condition' => ['white_space' => 'no--wrap'],
            ]
        );

        $this->add_control(
            'slide_speed',
            [
                'label' => esc_html__('Speed', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 10000,
                'step' => 10,
                'default' => 1000,
                'condition' => [
                    'white_space' => 'no--wrap',
                    'slide_text' => 'slide--text'
                ],
            ]
        );

        $this->end_controls_section();

        pe_text_animation_settings($this);

        objectStyles($this, 'text_wrapper_', 'Text', '.text-wrapper', false);

        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $text = $settings['text_wrapper'];
        $arr = explode(" ", $settings['text_wrapper']);

        $this->add_render_attribute(
            'attributes',
            [
                'class' => [$settings['text_type'], $settings['paragraph_size'], $settings['heading_size'], $settings['remove_margins'], $settings['remove_breaks'], $settings['secondary_color'], $settings['text_align_last']],
            ]
        );

        $innerElements = $settings['inner_elements'];

        if ($innerElements) {

            foreach ($innerElements as $element) {

                $findWord = array_search($element['target_word'], $arr);
                $motionAttr = '';
                $motion = $element['motion'] !== 'none' ? ' ' . $element['motion'] : '';


                if ($element['motion'] !== 'none') {
                    $durr = $element['motion_duration'];
                    $dell = $element['motion_repeat_delay'];

                    $motionAttr = ' data-duration="' . $durr . '" data-delay="' . $dell . '"';
                }

                if ($findWord !== false) {

                    $elementType = $element['element_type'];
                    $insertAt = $element['insert_at'];
                    $createdElement = '';

                    if ($elementType === 'icon') {

                        ob_start();

                        \Elementor\Icons_Manager::render_icon($element['element_icon'], ['aria-hidden' => 'true']);

                        $icon = ob_get_clean();

                        $createdElement = '<span class="inner--icon' . ' ' . $element['mobile_visibility'] . ' elementor-repeater-item-' . $element['_id'] . $motion . '" ' . $motionAttr . '>' . $icon . '</span>';

                    } else if ($elementType === 'image') {

                        $image = '<img src="' . $element['element_image']['url'] . '">';

                        $img = '<span data-zoom-pin="' . $element['zoom__pin__target'] . '" class="inner--image ' . $element['mobile_visibility'] . ' ' . $element['zoom__in'] . ' ' . $element['ls_behavior'] . ' ' . $element['ls_default_behavior'] . ' elementor-repeater-item-' . $element['_id'] . $motion . '" ' . $motionAttr . '>' . $image . '</span>';
                        $createdElement = $img;

                        if ($element['zoom__in']) {
                            $createdElement = '<span class="inserted--ls--hold elementor-repeater-item-' . $element['_id'] . '">' . $img . '</span>';

                        }

                    } else if ($elementType === 'video') {


                        $video = '<span data-zoom-pin="' . $element['zoom__pin__target'] . '" class="inner--video vid--no--ratio ' . $element['mobile_visibility'] . ' ' . $element['zoom__in'] . ' ' . $element['ls_behavior'] . ' elementor-repeater-item-' . $element['_id'] . $motion . '" ' . $motionAttr . '>' . pe_video_render(false, $element) . '</span>';

                        $createdElement = $video;

                        if ($element['zoom__in']) {

                            $createdElement = '<span class="inserted--ls--hold elementor-repeater-item-' . $element['_id'] . '">' . $video . '</span>';

                        }


                    } else if ($elementType === 'sup') {

                        $createdElement = '<span class="inserted--sup--text  ' . $element['mobile_visibility'] . ' ' . 'elementor-repeater-item-' . $element['_id'] . $motion . '" ' . $motionAttr . '>' . $element['element_text'] . '</span>';
                    }

                    if ($insertAt === 'before') {

                        array_splice($arr, $findWord, 0, $createdElement);


                    } else if ($insertAt === 'after') {

                        array_splice($arr, $findWord + 1, 0, $createdElement);
                    }
                }
            }

        }

        if ($settings['additional'] === 'dynamic') {

            $convertedWord = array_search($settings['convert_target_word'], $arr);
            $dynamicWords = explode(",", $settings['dynamic_words']);

            $dynamicDur = $settings['dynamic_duration'];
            $dynamicDel = $settings['dynamic_delay'];

            $dynamicAttr = ' data-duration="' . $dynamicDur . '" data-delay="' . $dynamicDel . '" data-scrub="' . $settings['dynamic_scrub'] . '" data-pin="' . $settings['dynamic_pin'] . '"';


            $words = array_map(function ($item) {
                return "<span class='dynamic-word'>{$item}</span>";
            }, $dynamicWords);

            $lastWord = '<span class="dynamic-word">' . $arr[$convertedWord] . '</span>';

            if ($settings['dynamic_pin'] === 'true' || $settings['dynamic_scrub'] === 'true') {

                $lastWord = '';
            }

            $arr[$convertedWord] = '<span ' . $dynamicAttr . ' class="pe-dynamic-words"><span><span>' . $arr[$convertedWord] . '</span>' . implode(' ', $words) . $lastWord . '</span></span>';

        }

        $customizedWords = $settings['customized_words'];

        if ($customizedWords) {

            foreach ($customizedWords as $word) {

                $searchWord = array_search($word['target_word'], $arr);

                $motionAttr = '';
                $motion = $word['motion'] !== 'none' ? ' ' . $word['motion'] : '';

                if ($word['motion'] !== 'none') {
                    $durr = $word['motion_duration'];
                    $dell = $word['motion_repeat_delay'];

                    $motionAttr = ' data-duration="' . $durr . '" data-delay="' . $dell . '"';
                }

                $arr[$searchWord] = '<span class="' . $word['underlined_text'] . ' inner--element customized--word elementor-repeater-item-' . $word['_id'] . $motion . '" ' . $motionAttr . '>' . $arr[$searchWord] . '</span>';

                if ($word['word_link'] === 'true') {
                    $arr[$searchWord] = '<a href="' . $word['word_link_target'] . '" target="' . $word['word_link_behavior'] . '" data-barba-preent="' . $word['prevent_barba'] . '">' . $arr[$searchWord] . '</a>';
                }

            }
        }
        $text = implode(" ", $arr);

        $tag = 'p';

        if ($settings['convert_heading'] === 'converted_heading') {
            $tag = $settings['heading_tag'];
        }

        ?>

        <?php $customizedLines = $settings['customized_lines'];
        if ($customizedLines) {

            echo '<div hidden class="custom-lines-hold">';
            foreach ($customizedLines as $line) {

                echo '<span data-id="' . $line['_id'] . '" class="csl--hold elementor-repeater-item-' . $line['_id'] . '" data-line="' . $line['target_line'] . '"></span>';

            }
            echo '</div>';

        }
        ?>

        <div class="text-wrapper">

            <<?php echo $tag; ?>
                <?php echo $this->get_render_attribute_string('attributes') ?>         <?php echo pe_text_animation($this) ?>>
                <?php echo do_shortcode($text) ?></<?php echo $tag; ?>>

        </div>

        <?php
    }

}
