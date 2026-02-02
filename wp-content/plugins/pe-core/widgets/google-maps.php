<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeGoogleMaps extends Widget_Base
{

    public function get_name()
    {
        return 'pegooglemaps';
    }

    public function get_title()
    {
        return __('Google Maps', 'pe-core');
    }

    public function get_icon()
    {
        return 'eicon-map-pin pe-widget';
    }

    public function get_categories()
    {
        return ['pe-content'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'api_notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>An API key is required to the map working in order. Please make sure you inserted your API key to <u>"Elementor > Settings > Integrations"</u> on your admin dashboard.. 
               <br>
               <br>Learn how to get a Google Maps API key: <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">API Key Documentation</a></span></div>',
            ]
        );

        $this->add_control(
            'map_style',
            [
                'label' => __('Map Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'standart',
                'options' => [
                    'standart' => __('Standart', 'pe-core'),
                    'silver' => __('Silver', 'pe-core'),
                    'dark' => __('Dark', 'pe-core'),
                    'retro' => __('Retro', 'pe-core'),
                    'night' => __('Night', 'pe-core'),
                    'custom' => __('Custom', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'custom_map_styles',
            [
                'label' => __('Custom Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'placeholder' => __('Paste your custom map styles JSON here', 'pe-core'),
                'description' => __('Learn how to create a custom map style: <a href="https://mapstyle.withgoogle.com/" target="_blank">Google Maps Styling Wizard</a>', 'pe-core'),
                'condition' => [
                    'map_style' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'map_type',
            [
                'label' => __('Map Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'single',
                'render_type' => 'template',
                'prefix_class' => 'map--type--',
                'options' => [
                    'single' => __('Single Location', 'pe-core'),
                    'multi' => __('Multi Location', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'multi_map_layout',
            [
                'label' => __('Layout', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'vertical',
                'render_type' => 'template',
                'prefix_class' => 'map--layout--',
                'options' => [
                    'vertical' => __('Vertical', 'pe-core'),
                    'horizontal' => __('Horizontal  ', 'pe-core'),
                ],
                'condition' => [
                    'map_type' => 'multi',
                ],
            ]
        );

        $this->add_control(
            'view_map_button',
            [
                'label' => esc_html__('View On Map Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'map_type' => 'multi',
                ],
            ]
        );

        $this->add_control(
            'view_map_text',
            [
                'label' => __('Button Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('View on Map', 'pe-core'),
                'placeholder' => __('Enter button text here', 'pe-core'),
                'condition' => ['map_type' => 'single',],
                'condition' => [
                    'map_type' => 'multi',
                    'view_map_button' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'locations_position',
            [
                'label' => __('Locations Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'render_type' => 'template',
                'prefix_class' => 'locations--pos--',
                'options' => [
                    'top' => __('Top', 'pe-core'),
                    'bottom' => __('Bottom', 'pe-core'),
                ],
                'condition' => [
                    'multi_map_layout' => 'horizontal',
                ],
            ]
        );

        $this->add_control(
            'latitude',
            [
                'label' => __('Latitude', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '40.712776',
                'placeholder' => __('Enter latitude', 'pe-core'),
                'condition' => ['map_type' => 'single',],
            ]
        );

        $this->add_control(
            'longitude',
            [
                'label' => __('Longitude', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '-74.005974',
                'placeholder' => __('Enter longitude', 'pe-core'),
                'condition' => ['map_type' => 'single',],
            ]
        );


        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Location Title', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'latitude',
            [
                'label' => __('Latitude', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '40.712776',
                'placeholder' => __('Enter latitude', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'longitude',
            [
                'label' => __('Longitude', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '-74.005974',
                'placeholder' => __('Enter longitude', 'pe-core'),

            ]
        );


        $repeater->add_control(
            'marker_image',
            [
                'label' => __('Marker Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://maps.gstatic.com/intl/en_us/mapfiles/marker.png',
                ],
            ]
        );

        $repeater->add_control(
            'address',
            [
                'label' => __('Address', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'placeholder' => __('Enter address here.', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'phone',
            [
                'label' => __('Phone', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Enter phone number here.', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'mail',
            [
                'label' => __('Mail', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Enter E-mail address here.', 'pe-core'),
            ]
        );

        $repeater->add_control(
            'location_image',
            [
                'label' => __('Location Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'directions_button',
            [
                'label' => esc_html__('Directions Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'pe-core'),
                'label_off' => esc_html__('Hide', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'directions_button_text',
            [
                'label' => __('Button Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Get Directions', 'pe-core'),
                'placeholder' => __('Enter button text hese', 'pe-core'),
                'condition' => ['map_type' => 'single',],
                'condition' => [
                    'directions_button' => 'yes',
                ],
            ]
        );


        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'pe-core'),
                'description' => esc_html__('Leave it empty if you want to auto assign the link based on latitite and longtitute of the location', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow', 'custom_attributes'],
                'default' => [

                    'is_external' => true,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => false,
                'condition' => [
                    'directions_button' => 'yes',
                ],
            ]
        );



        $this->add_control(
            'markers_list',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'condition' => ['map_type' => 'multi',],
                'default' => [
                    [
                        'latitude' => '40.712776',
                        'longitude' => '-74.005974',
                    ],
                    [
                        'latitude' => '40.712776',
                        'longitude' => '-84.005974',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );


        $this->add_control(
            'zoom_level',
            [
                'label' => __('Zoom Level', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => __('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} #pe--google--map' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => __('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 750,
                ],
                'selectors' => [
                    '{{WRAPPER}} #pe--google--map' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.map--layout--vertical .map--multi--locations--wrapper' => 'max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => __('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} #pe--google--map' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'marker_image',
            [
                'label' => __('Marker Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://maps.gstatic.com/intl/en_us/mapfiles/marker.png',
                ],
                'condition' => ['map_type' => 'single',],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'map_styles',
            [
                'label' => esc_html__('Map Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .marker--title h5',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'address_typography',
                'label' => esc_html__('Address Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .marker--address p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'phone_typography',
                'label' => esc_html__('Phone Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .marker--phone',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mail_typography',
                'label' => esc_html__('Mail Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .marker--mail',
            ]
        );

        $this->add_control(
            'locations_has_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'locations--has--bg',
                'prefix_class' => '',
                'default' => 'locations--has--bg',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'locations_border',
                'selector' => '{{WRAPPER}} .map--marker--details',
                'important' => true
            ]
        );


        $this->add_responsive_control(
            'locations_has_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .map--marker--details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'locations_has_padding',
            [
                'label' => esc_html__('Padding (Box)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .map--marker--details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'locations_has_padding_content',
            [
                'label' => esc_html__('Padding (Content)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .marker--title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .marker--bottom' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'locations_gap',
            [
                'label' => esc_html__('Locations Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
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
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .map--multi--locations--hold' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'map_cont_gap',
            [
                'label' => esc_html__('Map Contaiers Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
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
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--google--maps--wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $type = $settings['map_type'];


        ?>


        <?php $map_styles = '';
        if ($settings['map_style'] === 'custom') {
            $map_styles = $settings['custom_map_styles'];
        } else {
            $style_path = plugin_dir_path(__FILE__) . '../assets/maps/' . $settings['map_style'] . '.json';
            if (file_exists($style_path)) {
                $map_styles = file_get_contents($style_path);
            }
        }

        $this->add_render_attribute('map', 'data-zoom-level', esc_attr($settings['zoom_level']['size']));
        $this->add_render_attribute('map', 'data-map-styles', $map_styles);

        if ($type === 'single') {

            $marker_icon = $settings['marker_image']['url'] ? $settings['marker_image']['url'] : 'https://maps.gstatic.com/intl/en_us/mapfiles/marker.png';

            $this->add_render_attribute('map', 'data-latitude', esc_attr($settings['latitude']));
            $this->add_render_attribute('map', 'data-longitude', esc_attr($settings['longitude']));
            $this->add_render_attribute('map', 'data-marker-icon', esc_attr($marker_icon));

        } else if ($type === 'multi') {

            $markers = [];
            if (!empty($settings['markers_list'])) {
                foreach ($settings['markers_list'] as $marker) {
                    $markers[] = [
                        'latitude' => $marker['latitude'],
                        'longitude' => $marker['longitude'],
                        'icon' => !empty($marker['marker_image']['url']) ? $marker['marker_image']['url'] : 'https://maps.gstatic.com/intl/en_us/mapfiles/marker.png',
                        'title' => $marker['title'] ?? '',
                        // 'infoWindowContent' => $marker['infoWindowContent'] ?? '', // Bilgi penceresi içeriği
                    ];
                }
            }

            $this->add_render_attribute('map', 'data-markers', esc_attr(json_encode($markers)));
        }

        ?>

        <div class="pe--google--maps--wrapper">

            <?php if ($type === 'multi') { ?>

                <div data-lenis-prevent class="map--multi--locations--wrapper">
                    <div class="map--multi--locations--hold">

                        <?php

                        if (!empty($settings['markers_list'])) {
                            foreach ($settings['markers_list'] as $key => $marker) { ?>

                                <div class="map--marker--details marker__dets__<?php echo $key; ?>">

                                    <div class="marker--top">

                                        <?php if (!empty($marker['location_image']['url'])) { ?>
                                            <div class="marker--image">
                                                <img src="<?php echo esc_url($marker['location_image']['url']) ?>">
                                            </div>
                                        <?php } ?>

                                        <div class="marker--title">
                                            <h5><?php echo esc_html($marker['title']) ?></h5>
                                        </div>
                                    </div>
                                    <div class="marker--bottom">

                                        <div class="marker--address">
                                            <p class="p--large">
                                                <span class="ma--icon">

                                                    <?php
                                                    echo file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/storefront.svg');
                                                    ?>

                                                </span>
                                                <?php echo esc_html($marker['address']) ?>
                                            </p>
                                        </div>
                                        <div class="marker--phone">
                                            <span class="ma--icon">

                                                <?php
                                                echo file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/call.svg');
                                                ?>

                                            </span>
                                            <a
                                                href="tel: <?php echo esc_url($marker['phone']) ?>"><?php echo esc_html($marker['phone']) ?></a>
                                        </div>
                                        <div class="marker--mail">
                                            <span class="ma--icon">

                                                <?php
                                                echo file_get_contents(plugin_dir_url(__FILE__) . '../assets/img/mail.svg');
                                                ?>

                                            </span>
                                            <a
                                                href="mailto: <?php echo esc_url($marker['mail']) ?>"><?php echo esc_html($marker['mail']) ?></a>
                                        </div>

                                        <div class="marker--buttons">

                                            <?php if ($settings['view_map_button'] === 'yes') { ?>
                                                <div class="marker--map--view">
                                                    <div data-marker="<?php echo $key; ?>"
                                                        class="view--map--button location--button view__<?php echo $key; ?>">
                                                        <?php echo esc_html($settings['view_map_text']) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>


                                            <?php if ($marker['directions_button'] === 'yes') { ?>
                                                <div data-marker="<?php echo $key; ?>" class="marker--get--directions">
                                                    <?php if (!empty($marker['link']['url'])) {
                                                        $link = $marker['link']['url'];
                                                    } else {
                                                        $link = 'https://www.google.com/maps/dir/?api=1&destination=' . $marker['latitude'] . ',' . $marker['longitude'];
                                                    }
                                                    echo '<a href="' . $link . '" class="location--button directions--map--button" target="_blank">' . esc_html($marker['directions_button_text']) . '</a>';
                                                    ?>
                                                </div>
                                            <?php } ?>

                                        </div>

                                    </div>
                                </div>


                            <?php }
                        }

                        ?>

                    </div>
                </div>

            <?php } ?>

            <div id="pe--google--map" data-lenis-prevent <?php echo $this->get_render_attribute_string('map'); ?>></div>

        </div>

        <?php
    }

}
?>