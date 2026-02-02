<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeLottie extends Widget_Base
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
        return 'pelottie';
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
        return __('Lottie', 'pe-core');
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
        return 'eicon-animation pe-widget';
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
                'label' => __('Lottie', 'pe-core'),
            ]
        );

        $this->add_control(
            'input_type',
            [
                'label' => esc_html__('Input', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'url',
                'options' => [
                    'url' => esc_html__('URL', 'pe-core'),
                    'upload' => esc_html__('Upload', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'lottie_file',
            [
                'label' => esc_html__('Upload JSON', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://lottie.host/cfad902b-bab5-447c-8ba0-deb0bd1f3536/CDRHoL0tIA.lottie',
                ],
                'media_types' => ['json', 'lottie'],
                'condition' => ['input_type' => 'upload'],
            ]
        );

        $this->add_control(
            'lottie_url',
            [
                'label' => esc_html__('Lottie URL', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'https://lottie.host/272b60dd-462d-42a3-8ed6-fec4143633d6/X4FxBascRI.json',
                'ai' => false,
                'condition' => ['input_type' => 'url'],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'autoplay',
                'default' => 'autoplay',

            ]
        );

        $this->add_control(
            'hover',
            [
                'label' => esc_html__('Hover', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hover',
                'default' => 'hover',

            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'loop',
                'default' => 'loop',

            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 1,
                        'max' => 3,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 1
                ]
            ]
        );


        $this->add_control(
            'play_mode',
            [
                'label' => esc_html__('Play Mode', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal' => esc_html__('Normal', 'pe-core'),
                    'bounce' => esc_html__('Bounce', 'pe-core'),
                ],
                'label_block' => true
            ]
        );

        $this->add_control(
            'direction',
            [
                'label' => esc_html__('Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__('Forward', 'pe-core'),
                    '-1' => esc_html__('Backward', 'pe-core'),
                ],
                'label_block' => true
            ]
        );



        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'rem', 'em'],
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
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} dotlottie-player' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'rem', 'em'],
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
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} dotlottie-player' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        pe_cursor_settings($this);


        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $file = '';
        if ($settings['input_type'] === 'url') {
            $file = $settings['lottie_url'];
        } else {
            $file = $settings['lottie_file']['url'];
        }
        ?>


        <dotlottie-player src="<?php echo esc_url($file) ?>" background="transparent"
            speed="<?php echo $settings['speed']['size'] ?>" direction="<?php echo $settings['direction'] ?>"
            playMode="<?php echo $settings['play_mode'] ?>" <?php echo $settings['autoplay'] . ' ' . $settings['loop'] . ' ' . $settings['hover']; ?>>
        </dotlottie-player>

    <?php }

}
