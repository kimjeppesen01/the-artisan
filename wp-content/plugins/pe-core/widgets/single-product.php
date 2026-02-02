<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeSingleProduct extends Widget_Base
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
        return 'pesingleproduct';
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
        return __('Single Product', 'pe-core');
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
        return 'eicon-single-product pe-widget';
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


        $options = [];

        $projects = get_posts([
            'post_type' => 'product',
            'numberposts' => -1
        ]);

        foreach ($projects as $project) {
            $options[$project->ID] = $project->post_title;
        }

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Product', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'select_project',
            [
                'label' => __('Select Product', 'pe-core'),
                'label_block' => true,
                'description' => __('Select project which will display in the slider.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->add_control(
            'use_custom_media',
            [
                'label' => __('Custom Media', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'media_type',
            [
                'label' => esc_html__('Media Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => esc_html__('Image', 'pe-core'),
                    'video' => esc_html__('Video', 'pe-core'),
                ],
                'condition' => [
                    'use_custom_media' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'product_custom_image',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'use_custom_media' => 'yes',
                    'media_type' => 'image',
                ],
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
                'condition' => [
                    'use_custom_media' => 'yes',
                    'media_type' => 'video',
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
                    'use_custom_media' => 'yes',
                    'media_type' => 'video',
                    'video_provider' => 'self',
                ],
            ]
        );

        $this->add_control(
            'youtube_id',
            [
                'label' => esc_html__('Video ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter video od here.', 'pe-core'),
                'condition' => [
                    'use_custom_media' => 'yes',
                    'media_type' => 'video',
                    'video_provider' => 'youtube',
                ],
            ]
        );

        $this->add_control(
            'vimeo_id',
            [
                'label' => esc_html__('Video ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter video od here.', 'pe-core'),
                'condition' => [
                    'use_custom_media' => 'yes',
                    'media_type' => 'video',
                    'video_provider' => 'vimeo',
                ],
            ]
        );


        pe_product_controls($this);

        $displayAttributes = array();

        $attributes1 = wc_get_attribute_taxonomies();

        foreach ($attributes1 as $key => $attribute) {
            $displayAttributes[$attribute->attribute_id] = $attribute->attribute_label;
        }

        $this->add_control(
            'attributes_to_display',
            [
                'label' => __('Attributes to display.', 'pe-core'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $displayAttributes,
                'condition' => ['product_style' => 'detailed']
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            'button_settings',
            [
                'label' => esc_html__('Button Settings', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => ['behavior' => 'link-to-product']

            ]
        );

        pe_button_settings($this, false, ['behavior' => 'link-to-product']);

        $this->end_controls_section();

        pe_product_styles($this);
        pe_button_style_settings($this);

        pe_cursor_settings($this);
        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
 

        $id = $settings['select_project'];
        $classes = 'saren--single--product ' . $settings['product_style'];
        $style = $settings['product_style'];

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 1,
            'post__in' => array($id)
        );

        $the_query = new \WP_Query($args);

        while ($the_query->have_posts()):
            $the_query->the_post();
            $product = wc_get_product(get_the_ID());
            $classes = 'saren--single--product ' . $settings['product_style'];

            $customMed = $settings['use_custom_media'] === 'yes' ? true : false;

            if ($settings['product_style'] === 'detailed') {
                sarenProductBox($settings, $product, $classes, pe_cursor($this), true, $customMed);
            } else {
                sarenProductRender($settings, $product, $classes, pe_cursor($this));
            }


        endwhile;
        wp_reset_query(); ?>
        <!--/ Single Product -->
        <?php
    }

}
