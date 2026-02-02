<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeTeamMember extends Widget_Base
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
        return 'peteammember';
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
        return __('Team Member', 'pe-core');
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
        return 'eicon-person pe-widget';
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
                'label' => __('Team Member', 'pe-core'),
            ]
        );


        $this->add_control(
            'member_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'member--card',
                'options' => [
                    'member--basic' => esc_html__('Basic', 'pe-core'),
                    'member--card' => esc_html__('Card', 'pe-core'),

                ],

            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__('Member Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_control(
            'team_member_name',
            [
                'label' => esc_html__('Name - Surname', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'placeholder' => esc_html__('John Doe', 'pe-core'),
            ]
        );

        $this->add_control(
            'team_member_title',
            [
                'label' => esc_html__('Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'placeholder' => esc_html__('Market Analyst', 'pe-core'),
            ]
        );

        $this->add_control(
            'team_member_summary',
            [
                'label' => esc_html__('Summary', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'ai' => false,
                'placeholder' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consequat egestas nisi. Vestibulum malesuada fermentum nibh. Donec venenatis, neque et pellentesque efficitur, lectus est preti.', 'pe-core'),
                'rows' => 10,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'social_style',
            [
                'label' => esc_html__('Socials', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => esc_html__('Text', 'pe-core'),
                    'icons' => esc_html__('Icon', 'pe-core'),

                ],

            ]
        );

        $repeater->add_control(
            'social_link',
            [
                'label' => esc_html__('Social Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'placeholder' => esc_html__('http://linkedin.com/your-adress', 'pe-core'),
            ]
        );
       
        $repeater->add_control(
            'social_text',
            [
                'label' => esc_html__('Social Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'placeholder' => esc_html__('Instagram', 'pe-core'),
                'condition' => [
                    'social_style' => 'text',
                ]
            ]
        );


        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__('Social Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'social_style' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'team_member_socials',
            [
                'label' => esc_html__('Social Links', 'pe-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls()
            ]
        );



        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
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
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .team--member--image' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                    '{{WRAPPER}} .team--member--summ' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );



        $this->add_control(
            'website_link',
            [
                'label' => esc_html__('Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => true,
                'condition' => [
                    'interaction' => 'link',
                ]
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'cursor_interactions',
            [
                'label' => __('Cursor Interactions', 'pe-core'),
            ]
        );

        $this->add_control(
            'cursor_type',
            [
                'label' => esc_html__('Interaction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core'),
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'none' => esc_html__('None', 'pe-core'),

                ],

            ]
        );

        $this->add_control(
            'cursor_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'description' => esc_html__('Only Material Icons allowed, do not select Font Awesome icons.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
                'condition' => ['cursor_type' => 'icon'],
            ]
        );

        $this->add_control(
            'cursor_text',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => ['cursor_type' => 'text'],
            ]
        );


        $this->end_controls_section();

        pe_image_animation_settings($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();


        ?>

        <div class="pe--team--member <?php echo $settings['member_style'] ?>">

            <div class="team--member--wrapper">

                <?php if ($settings['member_style'] === 'member--card') { ?>

                    <div class="team--member--cont">

                        <div class="team--member--name">
                            <?php echo esc_html($settings['team_member_name']) ?>
                        </div>
                        <div class="team--member--title">
                            <?php echo esc_html($settings['team_member_title']) ?>
                        </div>

                    </div>

                <?php } ?>

                <div class="team--member--image">

                    <?php
                   
                   $alt = $settings['image']['alt'] ? 'alt="' . $settings['image']['alt'] . '"':'';
        
                   echo '<img ' . $alt .' src="' . $settings['image']['url'] . '">';
                    ?>

                </div>

                <?php if ($settings['member_style'] === 'member--simple') { ?>

                    <div class="team--member--cont">

                        <div class="team--member--name">
                            <?php echo esc_html($settings['team_member_name']) ?>
                        </div>
                        <div class="team--member--title">
                            <?php echo esc_html($settings['team_member_title']) ?>
                        </div>

                    </div>

                <?php } ?>


                <div class="team--member--socials">

                    <ul><?php foreach ($settings['team_member_socials'] as $social) {

                        if ($social['social_style'] === 'icon') {
                        ob_start();

                        \Elementor\Icons_Manager::render_icon($social['icon'], ['aria-hidden' => 'true']);

                        $icon = ob_get_clean();

                        echo '<li class="sc--' . $social['social_style'] . '"><a target="_blank" href="' . $social['social_link'] . '">' . $icon . '</a></li>';
                    } else {
                        
                        echo '<li class="sc--' . $social['social_style'] . '"><a class="underlined" target="_blank" href="' . $social['social_link'] . '">' . $social['social_text'] . '</a></li>';
                    }
                    } ?>

                    </ul>

                </div>

                <div class="team--member--toggle">

                    <span></span>
                    <span></span>

                </div>

                <div class="team--member--summ">

                    <?php echo esc_html($settings['team_member_summary']) ?>

                </div>

            </div>

        </div>



        <?php
    }

}
