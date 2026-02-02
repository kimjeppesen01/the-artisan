<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeCircleText extends Widget_Base
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
        return 'pecircletext';
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
        return __('Circular Text', 'pe-elementor');
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
        return 'eicon-undo pe-widget';
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
                'label' => __('Circular Text', 'pe-core'),
            ]
        );

        $this->add_control(
            'circle_text',
            [
                'label' => esc_html__('Circle Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'placeholder' => 'Write Your Circle Text Here'
            ]
        );



        $this->add_control(
            'center_icon',
            [
                'label' => esc_html__('Center Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'pe-core'),
                'label_off' => esc_html__('Off', 'pe-core'),
                'return_value' => 'on'
            ]
        );


        $this->add_control(
            'words_seperator',
            [
                'label' => esc_html__('Seperator', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'pe-core'),
                'label_off' => esc_html__('Off', 'pe-core'),
                'return_value' => 'on'
            ]
        );

        $this->add_control(
            'icon_click',
            [
                'label' => esc_html__('Interaction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'on'
            ]
        );

        $this->add_control(
            'target_type',
            [
                'label' => esc_html__('Target Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'target' => esc_html__('Scroll Target Id', 'pe-core'),
                    'url' => esc_html__('URL', 'pe-core')
                ],
                'default' => 'target',
                'condition' => [
                    'icon_click' => 'on'
                ]
            ]
        );

        $this->add_control(
            'target_id',
            [
                'label' => esc_html__('Target ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 1,
                'placeholder' => esc_html__('Write Target ID', 'pe-core'),
                'condition' => [
                    'icon_click' => 'on',
                    'target_type' => 'target'
                ]
            ]
        );

        $this->add_control(
            'target_url',
            [
                'label' => esc_html__('URL', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true
                ],
                'condition' => [
                    'target_type' => 'url',
                    'icon_click' => 'on'
                ]
            ]
        );

        $this->add_control(
            'data_icon',
            [
                'label' => esc_html__('Center Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'center_icon' => 'on',
                ],
            ]
        );



        $this->add_control(
            'data_seperator',
            [
                'label' => esc_html__('Seperator Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'words_seperator' => 'on'
                ]
            ]
        );

        $this->add_control(
            'rotate-direction',
            [
                'label' => esc_html__('Counter Clockwise', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'pe-core'),
                'label_off' => esc_html__('Off', 'pe-core'),
                'return_value' => 'counter-clockwise'
            ]
        );

        $this->add_responsive_control(
            'data_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 200
            ]
        );

        $this->add_control(
            'data_duration',
            [
                'label' => esc_html__('Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20
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
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'default' => is_rtl() ? 'right' : 'left',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],

            ]
        );



        $this->end_controls_section();

        pe_cursor_settings($this);

        $this->start_controls_section(
            'circle_text_styles',
            [

                'label' => esc_html__('Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Text', 'pe-core'),
                'selector' => '{{WRAPPER}} .circle-text',
            ]
        );

        $this->add_control(
            'seperator_size',
            [
                'label' => esc_html__('Seperator Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 30,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .circle-seperator .circle-char i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .circle-seperator .circle-char svg' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'center_icon_size',
            [
                'label' => esc_html__('Center Icon Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 30,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .circular-text-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .circular-text-icon svg' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );


        $this->end_controls_section();


        objectStyles($this, 'pe-circular-text', 'Background', '.pe-circular-text::after', false);


        pe_color_options($this);



    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $cursor = pe_cursor($this);

        ?>

        <div class="pe-circular-text <?php echo $settings['rotate-direction'] ?>" <?php echo "data-duration=" . $settings['data_duration'] . " " . 'data-height=' . $settings['data_height'] . ' ';
           if ('target' === $settings['target_type']) {
               echo 'data-target=' . $settings['target_id'];
           } ?>>

            <div class="circular-text-wrap">

                <div class="circular-text-content">

                    <div class="circle-text"> <?php echo $settings['circle_text'] ?> </div>


                    <?php if ('on' === $settings['words_seperator']) {


                        echo '<div class="circle-seperator circle-word"> <div class="circle-char">';

                        \Elementor\Icons_Manager::render_icon($settings['data_seperator'], ['aria-hidden' => 'true']);


                        echo '</div> </div>';

                    } ?>


                </div>

            </div>


            <?php

            if ('on' === $settings['center_icon']) {

                echo "<div class='circular-text-icon'>";

                if ('url' === $settings['target_type']) {

                    if (!empty($settings['target_url']['url'])) {
                        $this->add_link_attributes('target_url', $settings['target_url']);

                        echo '<a ' . $this->get_render_attribute_string('target_url') . ' ' . $cursor . '>';
                    }

                }

                \Elementor\Icons_Manager::render_icon($settings['data_icon'], ['aria-hidden' => 'true']);

                if (!empty($settings['target_url']['url'])) {
                    echo '</a>';
                }

                echo "</div>";

            }

            ?>

        </div>

        <?php
    }

}
