<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peLoginBlock extends Widget_Base
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
        return 'peloginblock';
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
        return __('Login/Register (Block)', 'pe-core');
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
        return 'eicon-ehp-forms pe-widget';
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
        return ['saren-content'];
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
                'label' => __('Login/Register Form (Block)', 'pe-core'),
            ]
        );

        $this->add_responsive_control(
            'inputs_alignment',
            [
                'label' => esc_html__('Inputs Alignment', 'pe-core'),
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
                    '{{WRAPPER}} input[type=text],
                    {{WRAPPER}} input[type=email],
                    {{WRAPPER}} input[type=password],
                    {{WRAPPER}} .woocommerce-form-login__rememberme,
                    {{WRAPPER}} .lost--password-heading.login--form--heading p,
                    {{WRAPPER}} .saren--login-sec .lost--password--col p,
                    {{WRAPPER}} .saren--login-sec .register--col p,
                    {{WRAPPER}} .saren--login-sec .login--col p' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        objetAbsolutePositioning($this, '.saren--login-sec form label:not(.woocommerce-form-login__rememberme)', 'form_labels', 'Form Labels');


        objectStyles($this, 'widget_input_', 'Input', 'input , {{WRAPPER}} button , {{WRAPPER}} .login--form--heading', true, false, false, true);


        $this->end_controls_section();

        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        $redirect_url = get_home_url(); 
        echo do_shortcode('[saren_login_register redirect_url="' . esc_url($redirect_url) . '"]');



    }

}
