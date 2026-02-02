<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peLanguageCurrencySwitcher extends Widget_Base
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
        return 'pelanguagecurrencyswitcher';
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
        return __('Pe Language/Currency Switcher', 'pe-core');
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
        return 'eicon-select pe-widget';
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
        return ['pe-header'];
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
                'label' => __('Language/Currency Switcher', 'pe-core'),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'switcher',
                'render_type' => 'template',
                'prefix_class' => 'ls--switcher--',
                'options' => [
                    'switcher' => esc_html__('Switcher', 'pe-core'),
                    'dropdown' => esc_html__('Dropdown', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => esc_html__('Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'language',
                'options' => [
                    'language' => esc_html__('Language', 'pe-core'),
                    'currency' => esc_html__('Currency', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'currency_show_elements',
            [
                'label' => esc_html__('Show Currency As:', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'name',
                'multiple' => true,
                'options' => [
                    'name' => esc_html__('Name', 'pe-core'),
                    'code' => esc_html__('Code', 'pe-core'),
                    'symbol' => esc_html__('Symbol', 'pe-core'),
                ],
                'condition' => ['type' => 'currency']
            ]
        );


        $this->add_control(
            'show_flags',
            [
                'label' => __('Show Flags', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => ['type' => 'language']
            ]
        );


        $this->add_control(
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
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'has_border',
            [
                'label' => esc_html__('Bordered', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'has--bordered',
                'prefix_class' => '',
                'default' => 'has--bordered',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_border',
                'label' => esc_html__('Border', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--language--currency--switcher.lcs--dropdown .wcml-dropdown li',
                'condition' => [
                    'has_border' => 'has--bordered',
                    'style' => 'dropdown'
                ],
            ]
        );
    

        $this->add_control(
            'has_rounded',
            [
                'label' => esc_html__('Rounded', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'has--rounded',
                'prefix_class' => '',
                'default' => 'has--rounded',
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
                'default' => '',
            ]
        );

        $this->add_control(
            'has_bg_color',
            [
                'label' => esc_html__('Background Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pe--account--pop--button::after' => 'background-color: {{VALUE}}',
                ],
                'condition' => ['has_bg' => 'has--bg'],
            ]
        );

        $this->add_responsive_control(
            'has_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .wpml-ls-legacy-dropdown a' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                    '{{WRAPPER}} .wcml-dropdown li' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
                'condition' => ['has_bg' => 'has--bg'],
            ]
        );

        $this->add_control(
            'has_padding',
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
                    '{{WRAPPER}} .wpml-ls-legacy-dropdown a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} a.wcml-cs-item-toggle ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['has_bg' => 'has--bg'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sw_typography',
                'label' => esc_html__('Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--language--currency--switcher ul li a span ',
            ]
        );

        $this->end_controls_section();
        pe_cursor_settings($this);
        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $type = $settings['type'];
        $style = $settings['style'];



        ?>

        <div data-barba-prevent="all"
            class="pe--language--currency--switcher <?php echo 'lcs--' . $type . ' lcs--' . $style ?>">

            <span class="lcs--follower"></span>

            <?php if ($type === 'language') {

                $args = [
                    'type' => $style === 'dropdown' ? 'widget' : 'custom',
                    'flags' => $settings['show_flags'] === 'yes' ? 1 : 0,
                    'native' => 0,
                ];

                do_action('wpml_language_switcher', $args);

            } else if ($type === 'currency') {
                $format = [];

                foreach ($settings['currency_show_elements'] as $element) {
                    if ($element === 'name') {
                        $format[] = '%name%';
                    } elseif ($element === 'code') {
                        $format[] = '%code%';
                    } elseif ($element === 'symbol') {
                        $format[] = '(%symbol%)';
                    }
                }

                $format_string = implode(' ', $format);

                $args = [
                    'format' => $format_string,
                    'switcher_style' => $style === 'dropdown' ? 'wcml-dropdown' : 'wcml-horizontal-list'
                ];
                do_action('wcml_currency_switcher', $args);

            } ?>


        </div>

        <?php
    }

}
