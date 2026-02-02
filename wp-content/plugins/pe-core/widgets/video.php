<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeVideo extends Widget_Base
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
        return 'pevideo';
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
        return __('Pe Video', 'pe-core');
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
        return 'eicon-youtube pe-widget';
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
                'label' => __('Video Settings', 'pe-core'),
            ]
        );

        $this->add_control(
            'video_provider',
            [
                'label' => esc_html__('Video Provider', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'self',
                'options' => [
                    'self' => esc_html__('Self', 'pe-core'),
                    'vimeo' => esc_html__('Vimeo', 'pe-core'),
                    'youtube' => esc_html__('Youtube', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'self_video',
            [
                'label' => esc_html__('Choose Video', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'condition' => [
                    'video_provider' => ['self']
                ]
            ]
        );

        $this->add_control(
            'youtube_id',
            [
                'label' => esc_html__('Video ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter video od here.', 'pe-core'),
                'condition' => [
                    'video_provider' => ['youtube']
                ]
            ]
        );

        $this->add_control(
            'vimeo_id',
            [
                'label' => esc_html__('Video ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter video od here.', 'pe-core'),
                'condition' => [
                    'video_provider' => ['vimeo']
                ]
            ]
        );

        $this->add_control(
            'controls',
            [
                'label' => esc_html__('Controls', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );


        $this->add_control(
            'select_controls',
            [
                'label' => esc_html__('Select Controls', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => [
                    'play' => esc_html__('Play', 'pe-core'),
                    'current-time' => esc_html__('Current Time', 'pe-core'),
                    'duration' => esc_html__('Duration', 'pe-core'),
                    'progress' => esc_html__('Progress Bar', 'pe-core'),
                    'mute' => esc_html__('Mute', 'pe-core'),
                    'volume' => esc_html__('Volume', 'pe-core'),
                    'captions' => esc_html__('Captions', 'pe-core'),
                    'settings' => esc_html__('Settings', 'pe-core'),
                    'pip' => esc_html__('PIP', 'pe-core'),
                    'airplay' => esc_html__('Airplay (Safari Only)', 'pe-core'),
                    'fullscreen' => esc_html__('Fullscreen', 'pe-core'),
                ],
                'default' => ['play', 'current-time', 'duration', 'progress', 'mute', 'volume', 'fullscreen'],
                'condition' => [
                    'controls' => ['true']
                ]
            ]
        );


        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'word_notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>When autoplay is enabled, many browsers require the video to be "muted" for it to autoplay properly.</div>',
                'condition' => ['autoplay' => 'true'],

            ]
        );

        $this->add_control(
            'muted',
            [
                'label' => esc_html__('Muted', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'lightbox',
            [
                'label' => esc_html__('Play in Lightbox', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
                'condition' => [
                    'controls' => ['true']
                ]
            ]
        );

        $this->add_control(
            'play_button',
            [
                'label' => esc_html__('Play Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core'),
                ],
                'condition' => [
                    'controls' => ['true']
                ]
            ]
        );

        $this->add_control(
            'play_text',
            [
                'label' => esc_html__('Play Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('PLAY', 'pe-core'),
                'condition' => [
                    'play_button' => ['text'],
                    'controls' => ['true']
                ],

            ]
        );

        $this->add_control(
            'video_poster',
            [
                'label' => esc_html__('Video Poster', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'poster_image',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'video_poster' => ['true'],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'Style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'player_skin',
            [
                'label' => esc_html__('Player Skin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'global',
                'options' => [
                    'global' => esc_html__('Use Global', 'pe-core'),
                    'skin--simple' => esc_html__('Simple', 'pe-core'),
                    'skin--rounded' => esc_html__('Rounded', 'pe-core'),
                    'skin--minimal' => esc_html__('Minimal', 'pe-core'),
                ],
            ]
        );


        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['vh', 'vw', 'px', '%'],
                'render_type' => 'template',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe-video' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['vw', 'vh', 'px', '%'],
                'render_type' => 'template',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'vh' => [
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
                    '{{WRAPPER}} .pe-video' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'player_main_color',
            [
                'label' => esc_html__('Main Skin Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pe-video' => '--plyr-color-main: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'player_secondary_color',
            [
                'label' => esc_html__('Secondary Skin Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pe-video' => '--plyr-color-secondary: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'player_progress_bg',
            [
                'label' => esc_html__('Progress Buffered Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pe-video' => '--plyr-video-progress-buffered-background: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'controls_spacing',
            [
                'label' => esc_html__('Controls Spacing', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 250,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe-video' => '--plyr-control-spacing: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'controls_font-size',
            [
                'label' => esc_html__('Controls Font Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe-video' => '--plyr-font-size-small: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .pe-video' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .pe-video',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'play_text_typography',
                'label' => esc_html__('Play Text Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--play',
                'condition' => [
                    'play_button' => ['text'],
                    'controls' => ['true']
                ],
            ]
        );



        $this->end_controls_section();
        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $skin = $settings['player_skin'];
        $provider = $settings['video_provider'];
        $video_id = '';

        if ($provider === 'youtube') {

            $video_id = $settings['youtube_id'];
        }

        if ($provider === 'vimeo') {

            $video_id = $settings['vimeo_id'];
        }

        $controls = [];
        if ($settings['select_controls']) {
            foreach ($settings['select_controls'] as $control) {

                array_push($controls, $control);

            }


        }

        $this->add_render_attribute(
            'parent_attributes',
            [
                'class' => ['pe-video', 'pe-' . $provider, $skin],
                'data-controls' => implode(',', $controls),
                'data-autoplay' => $settings['autoplay'],
                'data-muted' => $settings['muted'],
                'data-loop' => $settings['loop'],
                'data-lightbox' => $settings['lightbox'],
            ]
        );

        $this->add_render_attribute(
            'embed_attributes',
            [
                'class' => ['p-video'],
                'data-plyr-provider' => $provider,  
                'data-plyr-embed-id' => $video_id,
            ]
        );

        ?>


        <!-- Video -->
        <div <?php echo $this->get_render_attribute_string('parent_attributes') ?>>

            <?php if ($settings['lightbox'] === 'true') { ?>
                <div class="pe--lightbox--close x-icon">

                    <div class="pl--close--icon">
                        <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . '../assets/img/close.svg'); ?>">
                    </div>

                </div>
            <?php }

            if ($settings['controls'] === 'true') {

                if ($settings['play_button'] === 'icon') { ?>

                    <div class="pe--large--play icons">

                        <div class="pe--play">

                            <svg xmlns="http://www.w3.org/2000/svg" height="100%" width="100%" viewBox="0 -960 960 960" width="24">
                                <path d="M320-200v-560l440 280-440 280Z" />
                            </svg>

                        </div>

                    </div>

                <?php } else { ?>

                    <div class="pe--large--play texts">
                        <div class="pe--play">
                            <?php echo esc_html($settings['play_text']); ?>
                        </div>
                    </div>

                <?php }
            } ?>

            <?php if ($settings['video_poster'] === 'true') { ?>

                <div class="pe--video--poster">

                    <?php
                    echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'full', 'poster_image');
                    ?>

                </div>

            <?php } ?>

            <?php if ($provider === 'self') { ?>

                <video class="p-video" playsinline loop autoplay>
                    <source src="<?php echo esc_url($settings['self_video']['url']) ?>">
                </video>


            <?php } else { ?>

                <div <?php echo $this->get_render_attribute_string('embed_attributes') ?>></div>

            <?php } ?>


        </div>
        <!--/ Video -->

        <?php if ($settings['lightbox'] === 'true') { ?>
            <div class="pe--lightbox--hold"></div>
        <?php }

    }

}
