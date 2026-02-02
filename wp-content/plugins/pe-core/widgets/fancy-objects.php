<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peFancyObjects extends Widget_Base
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
        return 'pefancyobjects';
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
        return __('Fancy Objects', 'pe-core');
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
        return 'eicon-posts-ticker pe-widget';
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
                'label' => __('Fancy Objects', 'pe-core'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'object_type',
            [
                'label' => esc_html__('Object Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'image' => esc_html__('Image', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core'),

                ],
                'label_block' => false,
            ]
        );

        $repeater->add_control(
            'object_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => ['object_type' => 'icon']
            ]
        );

        $repeater->add_control(
            'object_image',
            [
                'label' => esc_html__('Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => ['object_type' => 'image']
            ]
        );

        $repeater->add_control(
            'object_text',
            [
                'label' => esc_html__('Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Lorem upsum.', 'pe-core'),
                'label_block' => true,
                'condition' => ['object_type' => 'text']
            ]
        );

        $repeater->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Image Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
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
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'condition' => ['object_type' => 'image'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
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
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'condition' => ['object_type' => 'icon'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'fancy_text_color',
            [
                'label' => esc_html__('Text Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--mainColor: {{VALUE}}',
                ],

            ]
        );

        $repeater->add_control(
            'fancy_has_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'has--bg',
                'default' => '',
            ]
        );

        $repeater->add_control(
            'fancy_background_color',
            [
                'label' => esc_html__('Background Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--secondaryBackground: {{VALUE}}',
                ],
                'condition' => [
                    'object_type' => 'text',
                    'fancy_has_bg' => 'has--bg',
                ],
            ]
        );


        $repeater->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'fancy_border',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}'
            ]
        );

        $repeater->add_responsive_control(
            'fancy_has_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'fancy_has_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'padding-top: {{TOP}}{{UNIT}};padding-right: {{RIGHT}}{{UNIT}};padding-left: {{LEFT}}{{UNIT}};padding-bottom: {{BOTTOM}}{{UNIT}}',
                ],
            ]
        );

        $repeater->start_controls_tabs(
            'object_options'
        );

        $repeater->start_controls_tab(
            'positioning',
            [
                'label' => esc_html__('Position', 'pe-core'),
            ]
        );
        $repeater->add_responsive_control(
            'object_vertical_orientation',
            [
                'label' => esc_html__('Vertical Orientation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom'
                    ],
                ],
                'default' => 'top',
                'toggle' => false,
            ]
        );

        $repeater->add_responsive_control(
            'object_vertical_offset_top',
            [
                'label' => esc_html__('Vertical Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
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
                    'vh' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fancy--object--wrap:has({{CURRENT_ITEM}})' => 'top: {{SIZE}}{{UNIT}};bottom: unset',
                ],
                'condition' => [
                    'object_vertical_orientation' => 'top'
                ],
            ]
        );

        $repeater->add_responsive_control(
            'object_vertical_offset_bottom',
            [
                'label' => esc_html__('Vertical Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
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
                    'vh' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fancy--object--wrap:has({{CURRENT_ITEM}})' => 'bottom: {{SIZE}}{{UNIT}};top: unset',
                ],
                'condition' => [
                    'object_vertical_orientation' => 'bottom'
                ],
            ]
        );

        $repeater->add_responsive_control(
            'object_transform_y',
            [
                'label' => esc_html__('Transform Y', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
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
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fancy--object--wrap:has({{CURRENT_ITEM}})' => '--transformY: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'object_horizontal_orientation',
            [
                'label' => esc_html__('Horizontal Orientation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right'
                    ],
                ],
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
            ]
        );

        $repeater->add_responsive_control(
            'object_horizontal_offset_left',
            [
                'label' => esc_html__('Horizontal Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
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
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fancy--object--wrap:has({{CURRENT_ITEM}})' => 'left: {{SIZE}}{{UNIT}};right: unset',
                ],
                'condition' => [
                    'object_horizontal_orientation' => 'left'
                ],
            ]
        );


        $repeater->add_responsive_control(
            'object_horizontal_offset_right',
            [
                'label' => esc_html__('Horizontal Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
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
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fancy--object--wrap:has({{CURRENT_ITEM}})' => 'right: {{SIZE}}{{UNIT}};left: unset',
                ],
                'condition' => [
                    'object_horizontal_orientation' => 'right'
                ],
            ]
        );

        $repeater->add_responsive_control(
            'object_transform_x',
            [
                'label' => esc_html__('Transform X', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
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
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .fancy--object--wrap:has({{CURRENT_ITEM}})' => '--transformX: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'motions',
            [
                'label' => esc_html__('Motion', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'motion_type',
            [
                'label' => esc_html__('Motion', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'render_type' => 'template',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'rotate' => esc_html__('Rotate', 'pe-core'),
                    'floating' => esc_html__('Floating', 'pe-core'),
                    'mousemove' => esc_html__('Mouse Move', 'pe-core'),
                    'parallax' => esc_html__('Parallax', 'pe-core'),
                ],
                'label_block' => false,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'fancy_objects',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'object_type' => 'icon',
                    ],
                    [
                        'object_type' => 'image',

                    ],
                    [
                        'object_type' => 'text',

                    ],
                ],
                'title_field' => '{{{ object_type }}} : {{{ object_text }}}',
            ]
        );



        $this->add_responsive_control(
            'scene_width',
            [
                'label' => esc_html__('Scene Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'rem'],
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
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--fancy--objects' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'scene_height',
            [
                'label' => esc_html__('Scene Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'rem'],
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
                    'vh' => [
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
                    '{{WRAPPER}} .pe--fancy--objects' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'absolute_notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>For absolute positioning of the scene please go "Advanced" tab above the widget settings.</span></div>',
            ]
        );

        $this->add_control(
            'events_target',
            [
                'label' => esc_html__('Mouse Events Target', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('Eg. "#heroContainer".', 'pe-core'),
                'label_block' => true,
            ]
        );


        $this->add_control(
            'entrance_animation',
            [
                'label' => esc_html__('Entrance Animation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'render_type' => 'template',
                'prefix_class' => 'entrance--',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'scaleUp' => esc_html__('Scale Up', 'pe-core'),
                    'fadeIn' => esc_html__('Fade In', 'pe-core'),
                    'slideUp' => esc_html__('Slide Up', 'pe-core'),
                    'slideDown' => esc_html__('Slide Down', 'pe-core'),
                ],
                'label_block' => false,
            ]
        );

        $this->add_responsive_control(
            'entrance_delay',
            [
                'label' => esc_html__('Entrance Animation Delay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 30,
                'step' => 0.1,
                'default' => 0,
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'accordion_typography',
            [
                'label' => esc_html__('Typographies', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );


        $this->end_controls_section();
        
        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $classes = [];


        ?>

        <div class="pe--fancy--objects" data-entrance-delay="<?php echo $settings['entrance_delay']; ?>"
            data-events-target="<?php echo $settings['events_target'] ?>">

            <div class="fancy--objects--wrapper">

                <?php foreach ($settings['fancy_objects'] as $key => $object) {
                    $key++;

                    $type = $object['object_type'];
                    $bg = $object['fancy_has_bg'];
                    ; ?>

                    <div class="fancy--object--wrap">

                        <div
                            class="fancy--object object--<?php echo $bg . ' ' . $type . ' elementor-repeater-item-' . $object['_id'] . ' motion--' . $object['motion_type'] ?> ">


                            <?php if ($type === 'icon') {

                                ob_start();
                                \Elementor\Icons_Manager::render_icon($object['object_icon'], ['aria-hidden' => 'true']);
                                $icon = ob_get_clean();
                                echo $icon;

                            } else if ($type === 'image') {

                                $alt = isset($object['object_image']['alt']) ? 'alt="' . $object['object_image']['alt'] . '"' : '';
                                echo '<img ' . $alt . ' src="' . $object['object_image']['url'] . '">';

                            } else if ($type === 'text') {
                                echo esc_html($object['object_text']);
                            }
                            ?>

                        </div>
                    </div>

                <?php } ?>

            </div>

        </div>

        <?php
    }

}
