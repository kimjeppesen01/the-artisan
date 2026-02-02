<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeIcon extends Widget_Base
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
        return 'peicon';
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
        return __('Pe Icon', 'pe-core');
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
        return 'eicon-favorite pe-widget';
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
                'label' => __('Icon', 'pe-core'),
            ]
        );


        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%' , 'vw' , 'vh' , 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pe--icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pe--icon svg' => 'width: {{SIZE}}{{UNIT}};',
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
            'interaction',
            [
                'label' => esc_html__('Interaction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('None', 'pe-core'),
                    'pe--link' => esc_html__('Link', 'pe-core'),
                    'pe--scroll--button' => esc_html__('Scroll', 'pe-core'),
                    //            'popup' => esc_html__('Popup (Template)', 'pe-core'),

                ],
                'label_block' => true
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow', 'custom_attributes'],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => true,
                'condition' => ['interaction' => 'pe--link'],
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
            'add_caption',
            [
                'label' => esc_html__('Add Caption', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'caption_style',
            [
                'label' => esc_html__('Caption Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'simple',
                'options' => [
                    'simple' => esc_html__('Simple', 'pe-core'),
                    'hover' => esc_html__('Hover', 'pe-core'),
                ],
                'label_block' => false,
                'condition' => ['add_caption' => 'yes'],
                'prefix_class' => 'caption__style--'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'caption_typography',
                'label' => esc_html__('Caption Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--icon--caption',
                'condition' => ['add_caption' => 'yes'],
            ]
        );

        $this->add_control(
            'caption_text',
            [
                'label' => esc_html__('Caption Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Write your text here', 'pe-core'),
                'default' => esc_html('Lorem ipsum', 'pe-core'),
                'condition' => ['add_caption' => 'yes'],
            ]
        );

        $this->add_responsive_control(
            'caption_alignment',
            [
                'label' => esc_html__('Caption Alignment', 'pe-core'),
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
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .pe--icon--caption' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'icon_direction',
            [
                'label' => esc_html__('Icon Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'pe-core'),
                        'icon' => 'eicon-arrow-right',
                    ],
                    'columnas' => [
                        'title' => esc_html__('Column', 'pe-core'),
                        'icon' => 'eicon-arrow-down',
                    ],
                ],
                'default' => 'row',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .pe--icon:has(.pe--icon--caption)' => 'flex-direction: {{VALUE}};',
                    '{{WRAPPER}} .pe--icon.pe--styled--object.pe--link>a' => 'flex-direction: {{VALUE}};',
                ],
                'condition' => ['add_caption' => 'yes'],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Spacings', 'pe-core'),
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
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--icon:has(.pe--icon--caption)' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['add_caption' => 'yes'],
            ]
        );
        
        $this->add_responsive_control(
            'custom_width',
            [
                'label' => esc_html__('Custom Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%' , 'vw' , 'em'],
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
                    'vw' => [
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
                    '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
             
            ]
        );
       
        $this->add_responsive_control(
            'custom_height',
            [
                'label' => esc_html__('Custom Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%' , 'vh' , 'em'],
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
                    'vh' => [
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
                    '{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
                ],
             
            ]
        );

        $this->end_controls_section();

        // Tab Title Control
        $this->start_controls_section(
            'motion_section',
            [
                'label' => __('Motion Effects', 'pe-core'),
            ]
        );

        $this->add_control(
            'motion',
            [
                'label' => esc_html__('Motion Effects', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('None', 'pe-core'),
                    'icon--motion me--rotate' => esc_html__('Rotate', 'pe-core'),
                    'icon--motion me--flip-x' => esc_html__('Flip X', 'pe-core'),
                    'icon--motion me--flip-y' => esc_html__('Flip Y', 'pe-core'),
                    'icon--motion me--slide-left' => esc_html__('Slide Left', 'pe-core'),
                    'icon--motion me--slide-right' => esc_html__('Slide Right', 'pe-core'),
                    'icon--motion me--slide-up' => esc_html__('Slide Up', 'pe-core'),
                    'icon--motion me--slide-down' => esc_html__('Slide Down', 'pe-core'),
                    'icon--motion me--hearth-beat' => esc_html__('Heartbeat', 'pe-core'),

                ],
                'label_block' => true
            ]
        );
        
        $this->add_control(
            'rotate_direction',
            [
                'label' => esc_html__('Rotate Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'clockwise',
                'options' => [
                    'clockwise' => esc_html__('Clockwise', 'pe-core'),
                    'counter--clockwise' => esc_html__('Counter Clockwise', 'pe-core'),
                ],
                'label_block' => true,
                'prefix_class' => 'rotate--dir--',
                'render_type' => 'template',
                'condition' => ['motion' => 'icon--motion me--rotate'],
            ]
        );

        $this->add_control(
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

        $this->add_control(
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


        $this->end_controls_section();

        pe_cursor_settings($this);

        objectStyles($this, 'icon_', 'Icon', '.pe--styled--object', false);



        $this->start_controls_section(
            'svg_styles',
            [
                'label' => esc_html__('SVG Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,

            ]
        );

        $this->add_control(
            'svg_styles_notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>Effective when using SVG icons.</span></div>',

            ]
        );


        $this->add_control(
            'fill_with_site_colors',
            [
                'label' => esc_html__('Fill with site colors.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => 'icon--fill--',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'hover_behavior',
            [
                'label' => esc_html__('Hover Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'invert',
                'options' => [
                    'revert' => esc_html__('Revert', 'pe-core'),
                    'invert' => esc_html__('Invert', 'pe-core'),

                ],
                'condition' => ['fill_with_site_colors!' => 'yes'],
                'label_block' => true,
                'prefix_class' => 'icon--hover--',
            ]
        );

        $this->end_controls_section();

        pe_color_options($this);

    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $classes = [];

        array_push($classes, [$settings['interaction']]);
        $buttonClasses = implode(' ', array_filter($classes[0]));

        ob_start();

        \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']);

        $icon = ob_get_clean();

        // Button Link
        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('link', $settings['link']);
        }

        // Motion Atrributes
        $this->add_render_attribute(
            'motion_attributes',
            [
                'data-duration' => $settings['motion_duration'],
                'data-delay' => $settings['motion_repeat_delay'],

            ]
        );
        $motionAttributes = $settings['motion'] !== 'none' ? $this->get_render_attribute_string('motion_attributes') : '';


        //Scroll Button Attributes
        $this->add_render_attribute(
            'scroll_attributes',
            [
                'data-scroll-to' => $settings['scroll_target'],
                'data-scroll-duration' => $settings['scroll_duration'],

            ]
        );

        $scrollAttributes = $settings['interaction'] === 'pe--scroll--button' ? $this->get_render_attribute_string('scroll_attributes') : '';

        $cursor = pe_cursor($this);


        ?>

        <div class="pe--icon pe--styled--object <?php echo esc_attr($buttonClasses); ?>" <?php echo $scrollAttributes ?>>

            <?php if (!empty($settings['link']['url'])) { ?>

                <a <?php echo $this->get_render_attribute_string('link'); ?>             <?php echo $cursor ?>>

                <?php } ?>

                <div class="pe--icon--wrap <?php echo $settings['motion'] ?>" <?php echo $motionAttributes ?>>

                    <?php echo $icon; ?>

                </div>

                <?php if ($settings['add_caption'] === 'yes') { ?>

                    <div class="pe--icon--caption">

                        <?php echo $settings['caption_text'] ?>

                    </div>

                <?php } ?>
                <?php if (!empty($settings['link']['url'])) { ?>
                </a>
            <?php } ?>

        </div>

        <?php
    }

}
