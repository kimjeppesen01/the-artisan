<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeAccordion extends Widget_Base
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
        return 'peaccordion';
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
        return __('Accordion', 'pe-core');
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
        return 'eicon-accordion pe-widget';
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
                'label' => __('Accordion', 'pe-core'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'accordion_title',
            [
                'label' => esc_html__('Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title', 'pe-core'),
                'label_block' => true,
            ]
        );


        $repeater->add_control(
            'accordion_content',
            [
                'label' => esc_html__('Content', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('List Content', 'pe-core'),
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consequat egestas nisi. Vestibulum malesuada fermentum nibh. Donec venenatis, neque et pellentesque efficitur, lectus est preti.', 'pe-core'),
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'accordion_image',
            [
                'label' => esc_html__('Accordion Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );


        $this->add_control(
            'accordion',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'accordion_title' => esc_html__('Title #1', 'pe-core'),
                        'accordion_content' => esc_html__('Item content. Click the edit button to change this text.', 'pe-core'),
                    ],
                    [
                        'accordion_title' => esc_html__('Title #2', 'pe-core'),
                        'accordion_content' => esc_html__('Item content. Click the edit button to change this text.', 'pe-core'),
                    ],
                ],
                'title_field' => '{{{ accordion_title }}}',
            ]
        );

        $this->add_control(
            'list_type',
            [
                'label' => esc_html__('List Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'ac--nested',
                'options' => [
                    'ac--ordered' => esc_html__('Ordered', 'pe-core'),
                    'ac--nested' => esc_html__('Nested', 'pe-core'),

                ],
                'label_block' => false,
            ]
        );

        $this->add_control(
            'accordion_images',
            [
                'label' => esc_html__('Accordion Images', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'render_type' => 'template',
                'prefix_class' => 'accordion--images--',
                'default' => 'false',

            ]
        );

        $this->add_control(
            'open_multiple',
            [
                'label' => esc_html__('Open Multiple', 'pe-core'),
                'description' => esc_html__('Multiple items can be active at a time if you switch to "Yes".', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'open--multiple',
                'default' => 'false',

            ]
        );

        $this->add_control(
            'open_first',
            [
                'label' => esc_html__('Active First', 'pe-core'),
                'description' => esc_html__('First item will be active as default.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'active--first',
                'default' => 'false',

            ]
        );

        $this->add_control(
            'toggle_style',
            [
                'label' => esc_html__('Toggle Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'toggle--plus',
                'options' => [
                    'toggle--plus' => esc_html__('Plus', 'pe-core'),
                    'toggle--dot' => esc_html__('Dot', 'pe-core'),
                    'toggle--custom' => esc_html__('Custom', 'pe-core'),

                ],
                'label_block' => false,
            ]
        );

        $this->add_control(
            'accordion_open_icon',
            [
                'label' => esc_html__('Open Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'skin' => 'inline',
                'separator' => 'before',
                'label_block' => false,
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'toggle_style' => 'toggle--custom',
                ]
            ]
        );

        $this->add_control(
            'accordion_close_icon',
            [
                'label' => esc_html__('Close Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'skin' => 'inline',
                'separator' => 'before',
                'label_block' => false,
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'toggle_style' => 'toggle--custom',
                ]
            ]
        );

        $this->add_control(
            'toggle_bg',
            [
                'label' => esc_html__('Toggle Background', 'pe-core'),
                'description' => esc_html__('You can adjust colors from "Style" tab above.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'toggle--bg',
                'default' => 'false',

            ]
        );

        $this->add_control(
            'underlined',
            [
                'label' => esc_html__('Underlined?', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'ac--underlined',
                'default' => 'false',

            ]
        );

        $this->add_control(
            'toggle_icon_position',
            [
                'label' => esc_html__('Title Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                ],
                'default' => 'row',
                'prefix_class' => 'acc--icon--',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .pe-accordion-item-title' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_animate',
            [
                'label' => __('Animations', 'pe-core'),
            ]
        );

        $this->add_control(
            'select_animation',
            [
                'label' => esc_html__('Select Title Animation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'description' => esc_html__('Will be used as intro animation.', 'pe-core'),
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'charsUp' => esc_html__('Chars Up', 'pe-core'),
                    'charsDown' => esc_html__('Chars Down', 'pe-core'),
                    'charsRight' => esc_html__('Chars Right', 'pe-core'),
                    'charsLeft' => esc_html__('Chars Left', 'pe-core'),
                    'wordsUp' => esc_html__('Words Up', 'pe-core'),
                    'wordsDown' => esc_html__('Words Down', 'pe-core'),
                    'linesUp' => esc_html__('Lines Up', 'pe-core'),
                    'linesDown' => esc_html__('Lines Down', 'pe-core'),
                    'charsScaleUp' => esc_html__('Chars Scale Up', 'pe-core'),
                    'charsScaleDown' => esc_html__('Chars Scale Down', 'pe-core'),
                    'charsFlipUp' => esc_html__('Chars Flip Up', 'pe-core'),
                    'charsFlipDown' => esc_html__('Chars Flip Down', 'pe-core'),
                    'linesMask' => esc_html__('Lines Mask', 'pe-core'),
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'more_options',
            [
                'label' => esc_html__('Animation Options', 'pe-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs(
            'animation_options_tabs'
        );

        $this->start_controls_tab(
            'basic_tab',
            [
                'label' => esc_html__('Basic', 'pe-core'),
            ]
        );

        $this->add_control(
            'duration',
            [
                'label' => esc_html__('Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'step' => 0.1,
                'default' => 1.5
            ]
        );

        $this->add_control(
            'delay',
            [
                'label' => esc_html__('Delay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 0.1,
                'default' => 0
            ]
        );

        $this->add_control(
            'stagger',
            [
                'label' => esc_html__('Stagger', 'pe-core'),
                'description' => esc_html__('Delay between animated elements (for multiple element animation types)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.01,
                'default' => 0.1,
            ]
        );


        $this->add_control(
            'scrub',
            [
                'label' => esc_html__('Scrub', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
                'description' => esc_html__('Animation will follow scrolling behavior of the page.', 'pe-core'),


            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'advanced_tab',
            [
                'label' => esc_html__('Advanced', 'pe-core'),
            ]
        );

        $this->add_control(
            'anim_start',
            [
                'label' => esc_html__('Animation Start Point', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'description' => esc_html__('Animation will be triggered when the element enters the desired point of the view.', 'pe-core'),
                'options' => [
                    'top top' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-v-align-middle'
                    ],
                    'top bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => ' eicon-v-align-bottom',
                    ],
                ],
                'default' => 'top bottom',
                'toggle' => false,
            ]
        );

        $this->add_control(
            'start_offset',
            [
                'label' => esc_html__('Start Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
            ]
        );

        $this->add_control(
            'anim_end',
            [
                'label' => esc_html__('Animation End Point', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'description' => esc_html__('Animation will be end when the element enters the desired point of the view. (For scrubbed/pinned animations)', 'pe-core'),
                'options' => [
                    'bottom bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'center center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-v-align-middle'
                    ],
                ],
                'default' => 'bottom bottom',
                'toggle' => false,
            ]
        );


        $this->add_control(
            'end_offset',
            [
                'label' => esc_html__('End Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'accordion_styles',
            [
                'label' => esc_html__('Accordion Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'accordion_orientation',
            [
                'label' => esc_html__('Orientation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                ],
                'default' => 'row',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .pe--accordion' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'accordion_alignment',
            [
                'label' => esc_html__('Accordion Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'pe-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],

                ],
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .pe--accordion' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'accordion_width',
            [
                'label' => esc_html__('Accordion Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', 'em', 'rem' , '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
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
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--accordion--wrapper' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'accordion_images_width',
            [
                'label' => esc_html__('Images Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', 'em', 'rem' , '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--accordion--images--wrapper' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );


        $this->add_responsive_control(
            'accordion_gap',
            [
                'label' => esc_html__('Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', 'em', 'rem' , '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--accordion' => 'gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--accordion .pe-accordion-item-title p'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Content', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--accordion .pe-accordion-item-content p'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'order_typography',
                'label' => esc_html__('Order', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--accordion .pe-accordion-item-title .ac-order',
                'condition' => [
                    'list_type' => 'ac--ordered'
                ]
            ]
        );

        $this->add_control(
            'seperate_size',
            [
                'label' => esc_html__('Icon Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--accordion .accordion-toggle' => 'font-size: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'active_background',
            [
                'label' => esc_html__('Active Item Background', 'pe-core'),
                'description' => esc_html__('First item will be active as default.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'active--bg',
                'default' => '',
                'prefix_class' => '',

            ]
        );
        
        $this->add_responsive_control(
            'active_item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pe-accordion-item.accordion--active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} !important;',
                ],
            ]
        );
    

        $this->end_controls_section();

        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $classes = [];

        array_push($classes, [$settings['list_type'], $settings['open_multiple'], $settings['open_first'], $settings['toggle_style'], $settings['toggle_bg'], $settings['underlined']]);
        $mainClasses = implode(' ', array_filter($classes[0]));

        //Animations 

        $start = $settings['start_offset'] ? $settings['start_offset']['size'] : 0;
        $end = $settings['end_offset'] ? $settings['end_offset']['size'] : 0;

        $dataset = '{' .
            'duration=' . $settings['duration'] . '' .
            ';delay=' . $settings['delay'] . '' .
            ';stagger=' . $settings['stagger'] . '' .
            ';scrub=' . $settings['scrub'] . '' .
            ';start=' . $start . '' .
            ';startpov=' . $settings['anim_start'] . '' .
            ';end=' . $end . '' .
            ';endpov=' . $settings['anim_end'] . '' .
            ';parented=' . 'true' . '' .
            '}';

        $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';

        $this->add_render_attribute(
            'animation_attributes',
            [
                'data-animate' => 'true',
                'data-animation' => [$animation],
                'data-settings' => [$dataset],
            ]
        );

        $animationAttributes = $settings['select_animation'] !== 'none' ? $this->get_render_attribute_string('animation_attributes') : '';

        $tde = $settings['select_animation'] !== 'none' ? ' tde__parent' : '';




        ?>

        <div class="pe--accordion <?php echo esc_attr($mainClasses) ?>">

            <?php if ($settings['accordion_images'] === 'yes') { ?>

                <div class="pe--accordion--images--wrapper">

                    <?php foreach ($settings['accordion'] as $key => $item) {
                        $key++;
                        if (($settings['open_first'] === 'active--first') && ($key == 1)) {

                            $active = 'accordion--image--active';
                        } else {
                            $active = '';
                        } ?>

                        <div class="pe--accordion--image image__<?php echo $key . ' ' . $active ?>">

                            <img src="<?php echo $item['accordion_image']['url'] ?>">

                        </div>

                    <?php } ?>


                </div>


            <?php } ?>
            <div class="pe--accordion--wrapper">

                <?php foreach ($settings['accordion'] as $key => $item) {

                    $key++;
                    $order = $key;
                    $key < 10 ? $order = '(0' . $key . ')' : $order = '(' . $key . ')';
                    $active = '';

                    if (($settings['open_first'] === 'active--first') && ($key == 1)) {
                        $active = 'accordion--active';
                    }
                    ?>

                    <div class="pe-accordion-item <?php echo esc_attr($active . $tde . ' item__' . $key) ?>"
                        data-index="<?php echo $key; ?>">

                        <div class="pe-accordion-item-title">

                            <?php if ($settings['list_type'] === 'ac--ordered') { ?>
                                <span class="ac-order" <?php echo $animationAttributes ?>><?php echo $order; ?></span>
                            <?php } ?>

                            <p <?php echo $animationAttributes ?>><?php echo $item['accordion_title'] ?></p>

                            <span class="accordion-toggle <?php echo esc_attr($settings['toggle_style']) ?>">

                                <?php if ($settings['toggle_style'] === 'toggle--custom') { ?>

                                    <span class="ac--togle ac-toggle-open">
                                        <?php \Elementor\Icons_Manager::render_icon($settings['accordion_open_icon'], ['aria-hidden' => 'true']); ?>
                                    </span>

                                    <span class="ac--togle ac-toggle-close">
                                        <?php \Elementor\Icons_Manager::render_icon($settings['accordion_close_icon'], ['aria-hidden' => 'true']); ?>
                                    </span>

                                <?php } else if ($settings['toggle_style'] === 'toggle--plus') { ?>

                                        <span></span>
                                        <span></span>

                                <?php } else if ($settings['toggle_style'] === 'toggle--dot') { ?>

                                            <span></span>

                                <?php } ?>

                            </span>

                        </div>

                        <div class="pe-accordion-item-content">

                            <?php if (($key === 1) && ($settings['open_first'] === 'active--first')) { ?>

                                <p <?php echo $animationAttributes ?>><?php echo $item['accordion_content'] ?></p>

                            <?php } else { ?>

                                <p><?php echo $item['accordion_content'] ?></p>

                            <?php } ?>

                        </div>

                    </div>
                <?php } ?>

            </div>

        </div>


        <?php
    }

}
