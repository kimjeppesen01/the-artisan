<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeInfoBox extends Widget_Base
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
        return 'peinfobox';
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
        return __('Info Box', 'pe-core');
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
        return 'eicon-info-box pe-widget';
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
                'label' => __('Info Box', 'pe-core'),
            ]
        );

        $this->add_control(
            'info_box_title',
            [
                'label' => esc_html__('Info Box Title', 'pe-core'),
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
            'info_box_text',
            [
                'label' => esc_html__('Info Box Text', 'pe-core'),
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
            'info_box_interest_type',
            [
                'label' => esc_html__('Info Box Interest Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'image' => esc_html__('Image', 'pe-core'),
                    'video' => esc_html__('Video', 'pe-core'),
                    'icon' => esc_html__('Icon', 'pe-core'),
                ],

            ]
        );

        $this->add_control(
            'info_box_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'description' => esc_html__('Leave it empty if you do not want to display icon', 'pe-core'),
                'condition' => ['info_box_interest_type' => 'icon'],
            ]
        );

        $this->add_control(
            'info_box_image',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => ['info_box_interest_type' => 'image'],
            ]
        );


        pe_video_settings($this, 'info_box_interest_type', 'video');

        $this->add_control(
            'interest_background',
            [
                'label' => esc_html__('Interest Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'prefix_class' => '',
                'return_value' => 'interest--has--bg',
                'deafult' => 'no',
                'condition' => ['info_box_interest_type!' => 'none'],
            ]
        );


        $this->add_responsive_control(
            'infobox_direction',
            [
                'label' => esc_html__('Box Direction', 'pe-core'),
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
                    '{{WRAPPER}} .pe--info--box--wrapper' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'texts_direciton',
            [
                'label' => esc_html__('Texts Direction', 'pe-core'),
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
                'prefix_class' => 'texts--',
                'default' => 'row',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .pe--infobox--wrap' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'vertical_alignment',
            [
                'label' => esc_html__('Vertical Alignment', 'pe-core'),
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
                    '{{WRAPPER}} .pe--info--box--wrapper' => 'justify-content: {{VALUE}};',
                ],
                'condition' => ['infobox_direction' => 'column'],
            ]
        );



        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Horizontal Alignment', 'pe-core'),
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
                    '{{WRAPPER}} .pe--info--box--wrapper' => 'text-align: {{VALUE}};',
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
                    '{{WRAPPER}} .pe--info--box' => 'min-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pe--info--box' => 'height: {{SIZE}}{{UNIT}};',
                ],
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

        $this->add_responsive_control(
            'interest_order',
            [
                'label' => esc_html__('Intersest Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -10,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .pe--infobox--interest' => 'order: {{SIZE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_order',
            [
                'label' => esc_html__('Title  Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -10,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .pe--infobox--title' => 'order: {{SIZE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_order',
            [
                'label' => esc_html__('Content Order', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -10,
                'max' => 10,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .pe--infobox--content' => 'order: {{SIZE}};',
                ],

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--infobox--title p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Text Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--infobox--content p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'icon_typography',
                'label' => esc_html__('Icon Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--infobox--interest.interest--icon',
            ]
        );


        $this->add_responsive_control(
            'interest--width',
            [
                'label' => esc_html__('Interest Width', 'pe-core'),
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
                    '{{WRAPPER}} .pe--infobox--interest' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'items_alignment',
            [
                'label' => esc_html__('Items Alignment', 'pe-core'),
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
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .pe--info--box--wrapper' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'justify-items',
            [
                'label' => esc_html__('Justify Items', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Start', 'pe-core'),
                        'icon' => 'eicon-justify-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-justify-center-v',
                    ],
                    'end' => [
                        'title' => esc_html__('end', 'pe-core'),
                        'icon' => 'eicon-justify-end-v',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space-Between', 'pe-core'),
                        'icon' => 'eicon-justify-space-between-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--info--box--wrapper' => 'justify-content: {{VALUE}};',
                ],
                'default' => 'start',
                'toggle' => false,
                'condition' => [
                    'infobox_direction' => 'row',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_spacing',
            [
                'label' => esc_html__('Items Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em'],
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
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--info--box--wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'texts_spacing',
            [
                'label' => esc_html__('Texts Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em'],
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
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--infobox--wrap' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'interest_padding',
            [
                'label' => esc_html__('Interest Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pe--info--box .pe--infobox--interest' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'interest_border_radius',
            [
                'label' => esc_html__('Interest Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pe--infobox--interest::before' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
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
                    '{{WRAPPER}} .pe--info--box .pe--info--box--wrapper' => '--backdropBlur: {{SIZE}}{{UNIT}};',
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
                'default' => '',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .pe--info--box .pe--info--box--wrapper',
            ]
        );


        $this->add_responsive_control(
            'has_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pe--info--box .pe--info--box--wrapper' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $this->add_control(
            'has_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pe--info--box .pe--info--box--wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        pe_text_animation_settings($this);
        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $text = $settings['info_box_text'];

        $tag = 'p';
        if (!empty($settings['info_box_link']['url'])) {
            $this->add_link_attributes('info_box_link', $settings['info_box_link']);
        }


        $interestType = $settings['info_box_interest_type'];

        ?>

        <div class="pe--info--box">

            <div class="pe--info--box--wrapper">

                <?php if ($interestType !== 'none') { ?>
                    <div class="pe--infobox--interest interest--<?php echo $interestType ?>">
                        <?php if ($interestType === 'icon') {
                            ob_start();
                            \Elementor\Icons_Manager::render_icon($settings['info_box_icon'], ['aria-hidden' => 'true']);
                            $icon = ob_get_clean();
                            echo $icon;
                        } else if ($interestType === 'video') {
                            echo pe_video_render($this, false);
                        } else if ($interestType === 'image') {

                            $alt = isset($settings['info_box_image']['alt']) ? 'alt="' . $settings['info_box_image']['alt'] . '"' : '';
                            echo '<img ' . $alt . ' src="' . $settings['info_box_image']['url'] . '">';
                        } ?>
                    </div>
                <?php } ?>


                <div class="pe--infobox--wrap">


                    <?php if ($settings['info_box_title']) { ?>
                        <div class="pe--infobox--title">
                            <p><?php echo $settings['info_box_title'] ?></p>
                        </div>
                    <?php } ?>

                    <?php if ($settings['info_box_text']) { ?>
                        <div class="pe--infobox--content">
                            <p><?php echo $settings['info_box_text'] ?></p>
                        </div>
                    <?php } ?>


                </div>


            </div>



        </div>

        <?php
    }

}
