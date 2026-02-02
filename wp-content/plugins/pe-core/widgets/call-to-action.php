<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeCallToAction extends Widget_Base
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
        return 'pecalltoaction';
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
        return __('Call To Action', 'pe-core');
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
        return 'eicon-call-to-action pe-widget';
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
                'label' => __('Call to Action', 'pe-core'),
            ]
        );

        $this->add_control(
            'cta_title',
            [
                'label' => esc_html__('CTA Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Write title here', 'pe-core'),
                'default' => esc_html__('Lorem ipsum .', 'pe-core'),
                'description' => esc_html__('Leave it empty if you do not want to display title', 'pe-core'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'cta_text',
            [
                'label' => esc_html__('CTA Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => esc_html__('Write your text here', 'pe-core'),
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consequat egestas nisi. Vestibulum malesuada fermentum nibh. Donec venenatis, neque et pellentesque efficitur, lectus est preti.', 'pe-core'),
                'description' => esc_html__('Leave it empty if you do not want to display text', 'pe-core'),
                'rows' => 5,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'cta_icon_set',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'cta_icon',
            [
                'type' => \Elementor\Controls_Manager::ICONS,
                'description' => esc_html__('Leave it empty if you do not want to display icon', 'pe-core'),
                'condition' => [
                    'cta_icon_set' => 'true',

                ],
            ]
        );

        $this->add_control(
            'cta_image_set',
            [
                'label' => esc_html__('Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );


        $this->add_control(
            'cta_inner_image',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'cta_image_set' => 'true',

                ],
            ]
        );


        $this->add_control(
            'cta_button_set',
            [
                'label' => esc_html__('Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $cond = ['cta_button_set' => 'true'];
        pe_button_settings($this, true, $cond);

        $this->add_control(
            'interaction',
            [
                'label' => esc_html__('Interaction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
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
            'cta_link',
            [
                'label' => esc_html__('Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow', 'custom_attributes'],
                'default' => [
                    'is_external' => false,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => false,
                'description' => esc_html__('Leave it empty if you do not want to display link', 'pe-core'),
                'condition' => ['interaction' => 'link'],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'styles',
            [

                'label' => esc_html__('Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background Image/Video', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );



        $this->add_control(
            'background_type',
            [
                'label' => esc_html__('Background Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => esc_html__('Image', 'pe-core'),
                    'video' => esc_html__('Video', 'pe-core'),
                ],
                'condition' => [
                    'background' => 'true',
                ],

            ]
        );

        $this->add_control(
            'cta_bg_image',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'background_type' => 'image',
                    'background' => 'true',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'cta_bg_image_size',
                'exclude' => ['custom'],
                'include' => [],
                'default' => 'large',
            ]
        );

        pe_video_settings($this, 'background_type', 'video');

        $this->add_control(
            'hover_color_change',
            [
                'label' => esc_html__('Color Change On Hover', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'prefix_class' => 'color--change--',
                'return_value' => 'true',
                'default' => 'false',
            ]
        );




        $this->add_responsive_control(
            'texts_vertical_alignment',
            [
                'label' => esc_html__('Items Vertical Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Start', 'pe-core'),
                        'icon' => 'eicon-justify-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-justify-space-around-v',
                    ],
                    'end' => [
                        'title' => esc_html__('End', 'pe-core'),
                        'icon' => 'eicon-justify-end-v',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Justify', 'pe-core'),
                        'icon' => 'eicon-justify-space-between-v',
                    ],
                ],
                'default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .cta--wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'texts_horizontal_alignment',
            [
                'label' => esc_html__('Items Horizontal Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Start', 'pe-core'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                    'end' => [
                        'title' => esc_html__('End', 'pe-core'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                ],
                'default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .cta--wrapper' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Texts Horizontal Align', 'pe-core'),
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
                    '{{WRAPPER}} .cta--wrapper' => 'text-align: {{VALUE}};',
                ],
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

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
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
                    '{{WRAPPER}} .pe--call--to--action' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label' => esc_html__('Items Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
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
                    '{{WRAPPER}} .cta--wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        objetAbsolutePositioning($this, '.cta--icon', 'cta_icon_', 'Icon');

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'bg_filters',
                'selector' => '{{WRAPPER}} .cta--background',
            ]
        );

        $this->add_control(
            'has_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'has--bg',
                'prefix_class' => '',
                'default' => 'has--bg',
            ]
        );


        $this->add_control(
            'bg_backdrop',
            [
                'label' => esc_html__('Backdrop Filter', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
                'render_type' => 'template',
                'prefix_class' => 'bg_backdrop_',
                'condition' => [
                    'has_bg' => 'has--bg',
                ],

            ]
        );

        $this->add_responsive_control(
            'bg_backdrop_blur',
            [
                'label' => esc_html__('Bluriness', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'condition' => [
                    'has_bg' => 'has--bg',
                    'bg_backdrop' => 'true',
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--call--to--action' => '--backdropBlur: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .pe--call--to--action',
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .pe--call--to--action' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',

                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding (Box)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe--call--to--action' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_content',
            [
                'label' => esc_html__('Padding (Content)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .cta--wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'image_Styles',
            [

                'label' => esc_html__('Inner Image Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'cta_image_set' => 'true',

                ],
            ]
        );

        $this->add_control(
            'custom_image_pos',
            [
                'label' => esc_html__('Custom Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => '',
                'render_type' => 'template',
                'prefix_class' => 'custom--image--pos--',
            ]
        );


        $this->add_responsive_control(
            'image_position',
            [
                'label' => esc_html__('Image Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'top' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                ],
                'default' => 'bottom',
                'render_type' => 'template',
                'prefix_class' => 'custom--image--pos--',
                'toggle' => false,
                'condition' => [
                    'custom_image_pos' => 'true',

                ],
            ]
        );


        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
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
                    '{{WRAPPER}} .cta--image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
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
                    '{{WRAPPER}} .cta--image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .cta--image' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',

                ],
            ]
        );

        $this->add_responsive_control(
            'image_margins',
            [
                'label' => esc_html__('Margin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .cta--image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .cta--image',
            ]
        );

        $this->end_controls_section();

        pe_button_style_settings($this, 'Inner Button', 'inner_button');

        $this->start_controls_section(
            'order_items',
            [

                'label' => esc_html__('Order Items', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'title_order',
            [
                'label' => esc_html__('Title Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .cta--title' => 'order: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'text_order',
            [
                'label' => esc_html__('Text Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .cta--text' => 'order: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'image_order',
            [
                'label' => esc_html__('Image Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .cta--image' => 'order: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'button_order',
            [
                'label' => esc_html__('Button Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .cta--button' => 'order: {{VALUE}};',
                ],

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'typographies',
            [

                'label' => esc_html__('Typographies', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_tag',
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
                    ],
                    'p' => [
                        'title' => esc_html__('P', 'pe-core'),
                        'icon' => ' eicon-editor-p',
                    ]

                ],
                'default' => 'h6',
                'toggle' => true,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .cta--title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Text Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .cta--text',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'icon_typography',
                'label' => esc_html__('Icon Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .cta--icon',
            ]
        );



        $this->end_controls_section();

        pe_text_animation_settings($this);
        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $text = $settings['cta_text'];

        $tag = 'p';
        if (!empty($settings['cta_link']['url'])) {
            $this->add_link_attributes('cta_link', $settings['cta_link']);
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


        $anim = pe_text_animation($this);
        ?>

        <div class="pe--call--to--action <?php echo $settings['interaction'] ?>" <?php echo $scrollAttributes ?>>


            <?php if ($settings['background'] === 'true') { ?>

                <div class="cta--background">

                    <?php if ($settings['background_type'] === 'image') {
                        echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'cta_bg_image_size', 'cta_bg_image');

                    } else {
                        echo pe_video_render($this, false);
                    }
                    ?>
                </div>

            <?php } ?>

            <?php if (!empty($settings['cta_link']['url'])) { ?>

                <a <?php echo $this->get_render_attribute_string('cta_link'); ?>>

                <?php } ?>

                <div class="cta--wrapper">

                    <div class="cta--title" <?php echo $anim ?>>
                        <?php echo '<' . $settings['title_tag'] . '>' . do_shortcode($settings['cta_title']) . '</' . $settings['title_tag'] . '>' ?>

                    </div>
                    <div class="cta--text" <?php echo $anim ?>>

                        <?php echo '<p class="no-margin">' . do_shortcode($settings['cta_text']) . '</p>' ?>

                    </div>

                    <?php if ($settings['cta_button_set'] === 'true') { ?>
                        <div class="cta--button">

                            <?php pe_button_render($this); ?>

                        </div>

                    <?php } ?>

                    <?php if ($settings['cta_image_set'] === 'true' && $settings['custom_image_pos'] !== 'true') { ?>
                        <div class="cta--image">

                            <?php echo '<img src="' . $settings['cta_inner_image']['url'] . '">' ?>

                        </div>

                    <?php } ?>

                    <?php if (isset($settings['cta_icon'])) { ?>
                        <div class="cta--icon">
                            <?php

                            ob_start();
                            \Elementor\Icons_Manager::render_icon($settings['cta_icon'], ['aria-hidden' => 'true']);
                            $icon = ob_get_clean();
                            echo $icon;
                            ?>
                        </div>
                    <?php } ?>

                </div>

                <?php if ($settings['cta_image_set'] === 'true' && $settings['custom_image_pos'] === 'true') { ?>
                    <div class="cta--image">

                        <?php echo '<img src="' . $settings['cta_inner_image']['url'] . '">' ?>

                    </div>

                <?php } ?>


                <?php if (!empty($settings['cta_link']['url'])) { ?>
                </a>
            <?php } ?>

        </div>

        <?php
    }

}
