<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peYithWidgets extends Widget_Base
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
        return 'peyithwidgets';
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
        return __('YITH Widgets', 'pe-core');
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
        return 'eicon-heart-o pe-widget';
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
        return ['pe-dynamic'];
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
                'label' => __('Site Logo', 'pe-core'),
            ]
        );

        $this->add_control(
            'yith_type',
            [
                'label' => esc_html__('Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'wishlist',
                'options' => [
                    'wishlist' => esc_html__('Wishlist', 'pe-core'),
                    'compare' => esc_html__('Compare', 'pe-core'),
                ],
            ]
        );


        $this->add_control(
            'yith_icon',
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
                    '{{WRAPPER}} .pe--yith--pop--button' => '--iconSize: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'yith_button_behavior',
            [
                'label' => esc_html__('Button Behavior', 'pe-core'),
                'description' => esc_html__('When user not logged in.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'to-page',
                'options' => [
                    'to-page' => esc_html__('To Page', 'pe-core'),
                    'open-popup' => esc_html__('Open Popup', 'pe-core'),
                ],
            ]
        );

        popupOptions($this, ['yith_button_behavior' => 'open-popup']);


        $this->add_control(
            'yith_link',
            [
                'label' => esc_html__('Login Page Link', 'pe-core'),
                'description' => esc_html__('The login page URL needed (when user logged in the button will be redirected automatically to "My Account" page).', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow', 'custom_attributes'],
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'label_block' => true,
                'condition' => ['yith_button_behavior' => 'to-page'],
            ]
        );


        $this->end_controls_section();

        objectStyles($this, 'account_pop_', 'Button', '.pe--styled--object', false);

        $this->start_controls_section(
            'popup_styles_sec',
            [
                'label' => esc_html__('Popup Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['yith_button_behavior' => 'open-popup'],
            ]
        );

        popupStyles($this, ['yith_button_behavior' => 'open-popup']);
        $this->end_controls_section();

        pe_color_options($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $type = $settings['yith_type'];

        $object = '';

        if ($settings['yith_icon']['value']) {
            ob_start();
            \Elementor\Icons_Manager::render_icon($settings['yith_icon'], ['aria-hidden' => 'true']);
            $object = ob_get_clean();
        } else {

            if ($type === 'wishlist') {
                $svgPath = plugin_dir_path(__FILE__) . '../assets/img/favorite.svg';
            } else if ($type === 'compare') {
                $svgPath = plugin_dir_path(__FILE__) . '../assets/img/compare.svg';

            }
            $object = file_get_contents($svgPath);
        }

        ?>

        <div class="pe--yith--widget" data-barba-prevent="all">
            <div class="pe--yith--widget--wrap">
                <?php

                if ($settings['yith_button_behavior'] === 'to-page') {
                    if (!empty($settings['yith_link']['url'])) {
                        $this->add_link_attributes('yith_link', $settings['yith_link']);
                    }
                    ?>

                    <a class="pe--yith--pop--button  pe--styled--object" <?php echo $this->get_render_attribute_string('yith_link'); ?>><?php echo $object ?></a>

                <?php }

                if ($settings['yith_button_behavior'] === 'open-popup') { ?>

                    <div class="pe--yith--pop--button pe--pop--button pe--styled--object"><?php echo $object ?></div>

                    <?php if ($settings['back_overlay'] === 'true') { ?>
                <span class="pop--overlay"></span>
            <?php } ?>


                    <div class="pe--yith--popup pe--styled--popup <?php echo 'popup--' . $type ?>">

                        <span class="pop--close">

                            <?php echo file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/close.svg'); ?>

                        </span>

                        <?php

                        if ($type === 'wishlist') {
                            echo do_shortcode('[yith_wcwl_wishlist]');
                        } else if ($type === 'compare') {
                            global $yith_woocompare;
                            $url = $yith_woocompare->obj->view_table_url();

                            echo '<div class="saren--compare--table" data-url="' . $url . '"></div>';

                        }
                        ?>

                    </div>

                <?php }

                ?>

            </div>

        </div>

        <?php
    }

}


