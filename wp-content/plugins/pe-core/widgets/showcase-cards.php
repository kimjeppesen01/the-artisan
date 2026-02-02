<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeShowcaseCards extends Widget_Base
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
        return 'peshowcasecards';
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
        return __('Pe Showcase Cards', 'pe-core');
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
        return 'eicon-posts-carousel pe-widget';
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
        return ['pe-showcase'];
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

        $this->start_controls_section(
            'section_project_title',
            [
                'label' => __('Showcase Cards', 'pe-core'),
            ]
        );

        saren_product_query_selection($this);

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 20000,
                'step' => 100,
                'default' => 10000
            ]
        );


        $this->add_control(
            'popover-toggle',
            [
                'label' => esc_html__('Contents', 'pe-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'pe-core'),
                'label_on' => esc_html__('Custom', 'pe-core'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'pinned--elements',
            [
                'label' => esc_html__('Pinned Elements Class', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'ai' => false,
                'placeholder' => 'Eg. ".outer-widgets"',
                'description' => esc_html__('Elements which has the class you entered will be pinned during the showcase scroll. You can add elements classes via "Advances -> CSS Classes" on the widget options.', 'pe-core'),
            ]
        );



        $this->end_controls_section();


        $this->start_controls_section(
            'section_product_settings',
            [
                'label' => __('Product Settings', 'pe-core'),
            ]
        );

        pe_product_controls($this);

        $this->end_controls_section();

        pe_product_styles($this);

        $this->start_controls_section(
            'button_settings',
            [
                'label' => esc_html__('Button Settings', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,

            ]
        );

        pe_button_settings($this, false, false);

        $this->end_controls_section();
        pe_cursor_settings($this);
        pe_general_animation_settings($this);

        $this->start_controls_section(
            'style',
            [
                'label' => esc_html__('Image', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );




        $this->add_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 500,
                        'max' => 1000,
                        'step' => 1
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--cards .showcase--cards--images--wrapper .product--image' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 900,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase--cards .showcase--cards--images--wrapper .product--image' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .showcase--cards .product--image',
            ]
        );


        $this->end_controls_section();
        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $cursor = pe_cursor($this);

        if ($settings['speed']) {
            $speed = $settings['speed'];
        } else {
            $speed = 10000;
        }

        $the_query = new \WP_Query(saren_product_query_args(($this)));
        ?>

        <div class="showcase--cards anim-multiple" <?php echo pe_general_animation($this); ?> data-speed="<?php echo $speed; ?>"
            data-pin-target="<?php echo $settings['pinned--elements']; ?>">

            <div class="showcase--cards--metas--wrapper inner--anim">

                <?php
                while ($the_query->have_posts()):
                    $the_query->the_post();
                    $classes = 'saren--single--product metas--only'
                        ?>

                    <div class="product--meta meta__<?php echo get_the_ID(); ?>">
                        <?php sarenProductRender($settings, wc_get_product(), $classes, true, false);
                        sarenProductActions(wc_get_product(), $settings);
                            ?>
                    </div>
                <?php endwhile;
                ?>

            </div>

            <div class="showcase--cards--images--wrapper inner--anim">

                <?php
                while ($the_query->have_posts()):
                    $the_query->the_post();

                    sarenProductImage(wc_get_product(), $cursor, $settings, false); ?>

                <?php endwhile;
                wp_reset_query();
                ?>

            </div>
        <?php }


}
