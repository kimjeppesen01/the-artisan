<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peSocialShare extends Widget_Base
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
        return 'pesocialshare';
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
        return __('Social Share', 'pe-core');
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
        return 'eicon-share pe-widget';
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
                'label' => __('Share', 'pe-core'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'select_platform',
            [
                'label' => esc_html__('Select Platform', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'facebook',
                'options' => [
                    'facebook' => esc_html__('Facebook', 'pe-core'),
                    'whatsapp' => esc_html__('WhatsApp', 'pe-core'),
                    'x-twitter' => esc_html__('X (Twitter)', 'pe-core'),
                    'telegram' => esc_html__('Telegram', 'pe-core'),
                    'pinterest' => esc_html__('Pinterest', 'pe-core'),
                    'linked-in' => esc_html__('LinkedIn', 'pe-core'),
                ],
                'label_block' => false,
            ]
        );

        $repeater->add_control(
            'platform_custom_icon',
            [
                'label' => esc_html__('Custom Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'description' => esc_html__('Leave it empty if you want to display default icon.', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'platform_custom_text',
            [
                'label' => esc_html__('Custom Text', 'pe-core'),
                'description' => esc_html__('Leave it empty if you want to display default text.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'socials',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'shares_style',
            [
                'label' => __('Style', 'pe-core'),
                'label_block' => false,
                'default' => 'share-icons',
                'type' => \Elementor\Controls_Manager::SELECT,

                'options' => [
                    'share-icons' => esc_html__('Icons', 'pe-core'),
                    'share-texts' => esc_html__('Texts', 'pe-core'),
                ],
            ]
        );

        $this->add_responsive_control(
            'shares_direction',
            [
                'label' => esc_html__('Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'pe-core'),
                        'icon' => 'eicon-arrow-right',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'pe-core'),
                        'icon' => 'eicon-arrow-down',
                    ],
                ],
                'default' => 'row',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .saren--social-share-buttons' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'shares_gap',
            [
                'label' => esc_html__('Items Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em', 'rem'],
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
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .saren--social-share-buttons' => 'gap: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        objectStyles($this, 'socials_', 'Button', '.pe--styled--object', true, false, false);


        $this->end_controls_section();

        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $current_url = get_permalink();
        $current_title = get_the_title();


        $icons = [
            'facebook' => file_get_contents(plugin_dir_path(__FILE__) . '../assets/img/fb.svg'),
            'x-twitter' => file_get_contents(plugin_dir_path(__FILE__) . '../assets/img/x.svg'),
            'linkedin' => file_get_contents(plugin_dir_path(__FILE__) . '../assets/img/linkedin.svg'),
            'pinterest' => file_get_contents(plugin_dir_path(__FILE__) . '../assets/img/pinterest.svg'),
            'whatsapp' => file_get_contents(plugin_dir_path(__FILE__) . '../assets/img/wp.svg'),
            'telegram' => file_get_contents(plugin_dir_path(__FILE__) . '../assets/img/telegram.svg'),
        ];

        echo '<ul class="saren--social-share-buttons">';

        $socials = $settings['socials'];
        $shares_style = $settings['shares_style'];


        foreach ($socials as $social) {

            echo '<li class="social-share-item">';
            $platform = $social['select_platform'];
            $customIcon = $social['platform_custom_icon'];
            $customText = $social['platform_custom_text'];

            if ($platform === 'facebook') {

                // Facebook
                echo '<button class="social-share-button pe--styled--object" data-url="https://www.facebook.com/sharer/sharer.php?u=' . urlencode($current_url) . '" data-network="Facebook">';
                if ($shares_style === 'share-icons') {
                    echo '<span class="share--icon">' . $icons['facebook'] . '</span>';
                } else {
                    echo esc_html('Facebook', 'pe-core');
                }
                echo '</button>';

            }

            if ($platform === 'x-twitter') {

                // Twitter (X)
                echo '<button class="social-share-button pe--styled--object" data-url="https://twitter.com/intent/tweet?url=' . urlencode($current_url) . '&text=' . urlencode($current_title) . '" data-network="Twitter">';
                if ($shares_style === 'share-icons') {
                    echo '<span class="share--icon">' . $icons['x-twitter'] . '</span>';
                } else {
                    echo esc_html('X', 'pe-core');
                }
                echo '</button>';
            }

            if ($platform === 'linkedin') {
                // LinkedIn
                echo '<button class="social-share-button pe--styled--object" data-url="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($current_url) . '&title=' . urlencode($current_title) . '" data-network="LinkedIn">';
                if ($shares_style === 'share-icons') {
                    echo '<span class="share--icon">' . $icons['linkedin'] . '</span>';
                } else {
                    echo esc_html('LinkedIn', 'pe-core');
                }
                echo '</button>';

            }

            if ($platform === 'pinterest') {

                // Pinterest
                echo '<button class="social-share-button pe--styled--object" data-url="https://pinterest.com/pin/create/button/?url=' . urlencode($current_url) . '&description=' . urlencode($current_title) . '" data-network="Pinterest">';
                if ($shares_style === 'share-icons') {
                    echo '<span class="share--icon">' . $icons['pinterest'] . '</span>';
                } else {
                    echo esc_html('Pinterest', 'pe-core');
                }
                echo '</button>';

            }

            if ($platform === 'whatsapp') {
                // WhatsApp 
                echo '<button class="social-share-button pe--styled--object" data-url="https://api.whatsapp.com/send?text=' . urlencode($current_title . ' ' . $current_url) . '" data-network="WhatsApp">';
                if ($shares_style === 'share-icons') {
                    echo '<span class="share--icon">' . $icons['whatsapp'] . '</span>';
                } else {
                    echo esc_html('WhatsApp', 'pe-core');
                }
                echo '</button>';

            }

            if ($platform === 'telegram') {
                // Telegram
                echo '<button class="social-share-button pe--styled--object" data-url="https://telegram.me/share/url?url=' . urlencode($current_url) . '&text=' . urlencode($current_title) . '" data-network="Telegram">';
                if ($shares_style === 'share-icons') {
                    echo '<span class="share--icon">' . $icons['telegram'] . '</span>';
                } else {
                    echo esc_html('Telegram', 'pe-core');
                }
                echo '</button>';


            }
            echo '</li>';

        }

        echo '</ul>';


    }

}
