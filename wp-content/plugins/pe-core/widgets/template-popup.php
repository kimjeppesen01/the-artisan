<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeTemplatePopup extends Widget_Base
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
        return 'petemplatepopup';
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
        return __('Template Popup', 'pe-core');
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
        return 'eicon-lightbox-expand pe-widget';
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
                'label' => __('Template Popup', 'pe-core'),
            ]
        );

        $templates = [];

        $templates = get_posts([
            'post_type' => 'elementor_library',
            'numberposts' => -1
        ]);

        foreach ($templates as $template) {
            $templates[$template->ID] = $template->post_title;
        }


        $this->add_control(
            'select_template',
            [
                'label' => __('Select Template', 'pe-core'),
                'description' => __('You can create your template via "Templates > Saved Templates > Add New Template" on your admin dashboard.', 'pe-core'),
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $templates,
            ]
        );



        popupOptions($this, false);

        $this->add_control(
            'template_popup_style',
            [
                'label' => esc_html__('Button Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'text',
                'render_type' => 'template',
                'prefix_class' => 'button--style--',
                'options' => [
                    'text' => esc_html__('Text', 'pe-core'),
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'icon_text' => esc_html__('Icon - Text', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'template_popup_text',
            [
                'label' => esc_html__('Button Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => false,
                'placeholder' => esc_html__('Write text here', 'pe-core'),
                'default' => esc_html__('Poppu', 'pe-core'),
                'ai' => false,
                'condition' => ['template_popup_style' => ['text', 'icon_text']],
            ]
        );

        $this->add_control(
            'template_popup_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'template_popup_style' => ['icon', 'icon_text']
                ],

            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%', 'rem'],
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
                    '0' => [
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
                    '{{WRAPPER}} .pe--pop--button' => '--iconSize: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'template_popup_style' => ['icon', 'icon_text']
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'popup_styles_sec',
            [
                'label' => esc_html__('Popup Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        popupStyles($this, false);

        $this->end_controls_section();

        objectStyles($this, 'pop_but_', 'Button', '.pe--pop--button.pe--styled--object', false);

        pe_cursor_settings($this);

        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();


        $object = '';

        if ($settings['template_popup_style'] === 'icon') {

            if ($settings['template_popup_icon']['value']) {
                ob_start();
                \Elementor\Icons_Manager::render_icon($settings['template_popup_icon'], ['aria-hidden' => 'true']);
                $object = ob_get_clean();

            } else {
                $svgPath = plugin_dir_path(__FILE__) . '../assets/img/popup.svg';
                $object = file_get_contents($svgPath);
            }

        } else if ($settings['template_popup_style'] === 'text') {
            $object = $settings['template_popup_text'];
        } else if ($settings['template_popup_style'] === 'icon_text') {

            if ($settings['template_popup_icon']['value']) {
                ob_start();
                \Elementor\Icons_Manager::render_icon($settings['template_popup_icon'], ['aria-hidden' => 'true']);
                $icon = ob_get_clean();

            } else {
                $svgPath = plugin_dir_path(__FILE__) . '../assets/img/popup.svg';
                $icon = file_get_contents($svgPath);
            }
            $object = '<span>' . $icon . '</span><span>' . $settings['template_popup_text'] . '</span>';

        }

        ?>

        <div class="saren--template--popup">

            <?php if (\Elementor\Plugin::$instance->editor->is_edit_mode()) { ?>
                <style>
                    @media only screen and (max-width: 767px) {

                        .saren--popup--template .elementor-hidden-mobile,
                        .saren--popup--template .elementor-hidden-phone {
                            display: none !important;
                        }
                    }
                </style>
            <?php } ?>

            <div class="pe--pop--button pe--styled--object"><?php echo $object ?></div>

            <?php if ($settings['back_overlay'] === 'true') { ?>
                <span class="pop--overlay"></span>
            <?php } ?>


            <div class=" pe--styled--popup">

                <span class="pop--close">

                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                        <path
                            d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z" />
                    </svg>

                </span>

                <div class="saren--popup--template" data-lenis-prevent>

                    <?php

                    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($settings['select_template']);

                    ?>

                </div>
            </div>





        </div>


    <?php }

}
