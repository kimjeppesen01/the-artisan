<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeSiteLogo extends Widget_Base
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
        return 'pesitelogo';
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
        return __('Site Logo', 'pe-core');
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
        return 'eicon-logo pe-widget';
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
            'logo_behavior',
            [
                'label' => esc_html__('Logo Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'global',
                'options' => [
                    'global' => esc_html__('Use Global', 'pe-core'),
                    'custom' => esc_html__('Custom Logo', 'pe-core'),
                ],
            ]
        );

        $this->start_controls_tabs(
            'animation_options_tabs'
        );

        $this->start_controls_tab(
            'basic_tab',
            [
                'label' => esc_html__('Primary', 'pe-core'),
            ]
        );

        $this->add_control(
            'site_logo',
            [
                'label' => esc_html__('Logo', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['image'],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => ['logo_behavior' => 'custom']
            ]
        );

        $this->add_control(
            'sticky_logo',
            [
                'label' => esc_html__('Sticky Logo', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['image'],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => ['logo_behavior' => 'custom']
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'advanced_tab',
            [
                'label' => esc_html__('Secondary', 'pe-core'),
            ]
        );


        $this->add_control(
            'secondary_logo',
            [
                'label' => esc_html__('Logo', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['image'],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => ['logo_behavior' => 'custom']
            ]
        );

        $this->add_control(
            'secondary_sticky_logo',
            [
                'label' => esc_html__('Sticky Logo', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['image'],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => ['logo_behavior' => 'custom']
            ]
        );

        $this->add_control(
            'mobile_logo',
            [
                'label' => esc_html__('Logo', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['image'],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => ['logo_behavior' => 'custom']
            ]
        );

        $this->add_control(
            'secondary_mobile_logo',
            [
                'label' => esc_html__('Sticky Logo', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['image'],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => ['logo_behavior' => 'custom']
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'logo_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .site-logo' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'change_on_sticky',
            [
                'label' => esc_html__('Sticky Logo.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'change--logo',
                'prefix_class' => '',
                'label_block' => true,
                'default' => 'no',
            ]
        );

        $this->add_responsive_control(
            'siticky_logo_width',
            [
                'label' => esc_html__('Sticky Logo Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .sticky-logo' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['change_on_sticky' => 'change--logo'],
            ]
        );

        $this->add_control(
            'logo_alignment',
            [
                'label' => esc_html__('Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'align-left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'align-center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'align-right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'align-left',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'custom_link',
            [
                'label' => esc_html__('Custom Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'custom_url',
            [
                'label' => esc_html__('Custom URL', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => ['custom_link' => 'yes'],
            ]
        );



        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $option = get_option('pe-redux');

        $logo_behavior = $settings['logo_behavior'];

        if ($settings['custom_link'] === 'yes') {

            $link = $settings['custom_url'];

        } else {

            $link = home_url('/');
        }

        $mainLogo = '';
        $secondaryLogo = '';
        $stickyMainLogo = '';
        $stickySecondaryLogo = '';
        $mobileMainLogo = '';
        $mobileSecondaryLogo = '';

        if ($logo_behavior !== 'global') {

            $mainLogo = $settings['site_logo']['id'];
            $secondaryLogo = $settings['secondary_logo']['id'];
            $stickyMainLogo = $settings['sticky_logo']['id'];
            $stickySecondaryLogo = $settings['secondary_sticky_logo']['id'];
            $mobileMainLogo = $settings['mobile_logo']['id'];
            $mobileSecondaryLogo = $settings['secondary_mobile_logo']['id'];

        } else {

            $mainLogo = $option['main_site_logo']['id'];
            $secondaryLogo = $option['secondary_site_logo']['id'];
            $stickyMainLogo = $option['main_sticky_logo']['id'];
            $stickySecondaryLogo = $option['secondary_sticky_logo']['id'];

            if (isset($option['main_mobile_logo'])) {
                $mobileMainLogo = $option['main_mobile_logo']['id'];
                $mobileSecondaryLogo = $option['secondary_mobile_logo']['id'];
            }

        }

        $size = 'full';


        ?>

        <!-- Site Branding -->
        <div class="site-branding <?php echo esc_attr($settings['logo_alignment']) ?>">

            <!-- Site Logo -->
            <div class="site-logo">

                <a href="<?php echo esc_url($link); ?>">

                    <?php
                    echo wp_get_attachment_image($mainLogo, $size, false, array("class" => "main__logo"));
                    echo wp_get_attachment_image($secondaryLogo, $size, false, array("class" => "secondary__logo"));
                    ?>

                </a>

            </div>
            <!--/ Site Logo -->

            <!--/ Sticky Logo -->
            <div class="sticky-logo">

                <a href="<?php echo esc_url($link); ?>">

                    <?php
                    echo wp_get_attachment_image($stickyMainLogo, $size, false, array("class" => "sticky__main__logo"));
                    echo wp_get_attachment_image($stickySecondaryLogo, $size, false, array("class" => "sticky__secondary__logo"));
                    ?>

                </a>

            </div>
            <!--/ Sticky Logo -->
       
            <?php if ($mobileMainLogo) { ?>
                     <!--/ Mobile Logo -->
                <div class="mobile-logo">

                    <a href="<?php echo esc_url($link); ?>">

                        <?php
                        echo wp_get_attachment_image($mobileMainLogo, $size, false, array("class" => "mobile__main__logo"));
                        echo wp_get_attachment_image($mobileSecondaryLogo, $size, false, array("class" => "mobile__secondary__logo"));
                        ?>


                    </a>

                </div>
                <!--/ Mobile Logo -->
            <?php } ?>


        </div>
        <!--/ Site Branding -->


        <?php
    }

}
