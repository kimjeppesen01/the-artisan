<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeInteractiveGrid extends Widget_Base
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
        return 'peinteractivegrid';
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
        return __('Interactive Grid', 'pe-core');
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
        return 'eicon-apps pe-widget';
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

        $this->start_controls_section(
            'section_project_title',
            [
                'label' => __('Interactive Grid', 'pe-core'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_image',
            [
                'label' => esc_html__('Featured Image', 'pe-core'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_content',
            [
                'label' => esc_html__('Content', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label' => esc_html__('Item Link', 'pe-core'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow', 'custom_attributes'],
                'default' => [
                    'url' => 'http://',
                    'is_external' => false,
                    'nofollow' => true,
                ],
                'label_block' => false,
            ]
        );


        $repeater->add_responsive_control(
            'vertical_align_self',
            [
                'label' => esc_html__('Vertical Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'pe-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'align-self: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'horizontal_align_self',
            [
                'label' => esc_html__('Horizontal Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'pe-core'),
                        'icon' => 'eicon-justify-space-around-v',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'justify-self: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'rotate',
            [
                'label' => esc_html__('Rotate', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );

        $repeater->add_control(
            'highlight_indexes',
            [
                'label' => esc_html__('Highlight Indexes', 'pe-core'),
                'description' => esc_html__('Enter highliht indexes you want to display in this item.', 'pe-core'),
                'placeholder' => esc_html__('Example 1,3,4', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'highlight_item',
            [
                'label' => __('Highlight Item', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'highlight_text',
            [
                'label' => esc_html__('Highlight Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('HOT', 'pe-core'),
                'label_block' => false,
                'condition' => ['highlight_item' => 'yes']
            ]
        );


        $this->add_control(
            'grid_repeater',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->add_control(
            'expand_items',
            [
                'label' => __('Expand Items', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core'),
                'label_off' => __('No', 'pe-core'),
                'return_value' => 'yes',
                'prefix_class' => 'expand--items--',
                'render_type' => 'template',
                'default' => 'no',
            ]
        );


        $this->add_responsive_control(
            'grid_columns',
            [
                'label' => esc_html__('Grid Columns', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 12,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .interactive--grid--wrapper' => 'grid-template-columns: repeat({{SIZE}}, 1fr);'
                ],
            ]
        );

        $this->add_responsive_control(
            'row_height',
            [
                'label' => esc_html__('Row Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .pe--interactive--grid .interactive--grid--wrapper' => 'grid-auto-rows: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'items_width',
            [
                'label' => esc_html__('Items Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .interactive--grid--item' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'items_gap',
            [
                'label' => esc_html__('Columns Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'em'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .pe--interactive--grid .interactive--grid--wrapper' => 'grid-gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'items_row_gap',
            [
                'label' => esc_html__('Rows Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh', 'em'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ],
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .pe--interactive--grid .interactive--grid--wrapper' => 'row-gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .grid--item--image img',
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'section_highlights',
            [
                'label' => __('Highlights', 'pe-core'),
            ]
        );

        $highlightsRepeater = new \Elementor\Repeater();

        $highlightsRepeater->add_control(
            'highlight_caption',
            [
                'label' => esc_html__('Caption', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $highlightsRepeater->add_control(
            'highlight_icon',
            [
                'label' => esc_html__('Highlight Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'highlights_repeater',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $highlightsRepeater->get_controls()
            ]
        );

        $this->end_controls_section();

        pe_cursor_settings($this);
        pe_general_animation_settings($this);

        objectStyles($this, 'grid--item_', 'Grid Item', '.pe--styled--object', false);

        pe_color_options($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $cursor = pe_cursor($this);
        $animation = pe_general_animation($this)

            ?>

        <div class="pe--interactive--grid">

            <div class="interactive--grid--wrapper">

                <?php foreach ($settings['grid_repeater'] as $key => $item) {
                    $highlights = explode(',', $item['highlight_indexes']);
                    ?>

                    <div <?php echo $animation ?>
                        class="interactive--grid--item  <?php echo 'elementor-repeater-item-' . $item['_id'] ?>">

                        <div class="grid--item--inner grid--item--state pe--styled--object">

                            <?php if ($settings['expand_items'] === 'yes') { ?>
                                <div class="grid--item--content grid--item--state">

                                    <div class="grid--item--meta grid--item--state">

                                        <h6 class="grid--item--title no-margin"> <?php echo $item['item_title']; ?></h6>
                                        <p class="p-small grid--item--sub"> <?php echo $item['item_content']; ?></p>

                                    </div>

                                    <div class="grid--item--highlights">

                                        <?php foreach ($settings['highlights_repeater'] as $key => $highlight) {
                                            $key++;

                                            if (in_array($key, $highlights)) {

                                                echo '<div class="item--highlight">';

                                                ob_start();
                                                \Elementor\Icons_Manager::render_icon($highlight['highlight_icon'], ['aria-hidden' => 'true']);
                                                $icon = ob_get_clean();
                                                echo '<span>' . $icon . '</span>';
                                                echo '<span>' . $highlight['highlight_caption'] . '</span>';

                                                echo '</div>';
                                            }

                                        } ?>

                                    </div>

                                </div>
                            <?php } ?>

                            <?php if ($item['highlight_item'] === 'yes') { ?>
                                <span class="item--highlight"><?php echo esc_html($item['highlight_text']) ?></span>
                            <?php } ?>

                            <div class="grid--item--image grid--item--state">
                                <?php if ($settings['expand_items'] === 'yes') { ?>
                                    <div class="grid--item--close--icon">
                                        <?php
                                        $svgPath = plugin_dir_path(__FILE__) . '../assets/img/close.svg';
                                        echo file_get_contents($svgPath);
                                        ?>

                                    </div>
                                <?php } ?>


                                <?php if (!empty($item['item_link']['url'])) {
                                    $url = $item['item_link']['url'];
                                    $target = $item['item_link']['is_external'] ? '_blank' : '_self';

                                    echo '<a target="' . $target . '" href="' . $url . '" ' . $cursor . '>';
                                } ?>
                                <?php
                                $alt = isset($item['item_image']['alt']) ? 'alt="' . $item['item_image']['alt'] . '"' : '';
                                echo '<img class="grid--item--state" ' . $alt . ' src="' . $item['item_image']['url'] . '">';
                                ?>
                                <?php if (!empty($item['item_link']['url'])) {
                                    echo '</a>';
                                } ?>

                                <p class="grid--item--sec--title grid--item--state no-margin"> <?php echo $item['item_title']; ?>
                                </p>


                            </div>


                            <?php if ($settings['expand_items'] !== 'yes') { ?>
                                <div class="grid--item--highlights">
                                    <?php foreach ($settings['highlights_repeater'] as $key => $highlight) {
                                        $key++;

                                        if (in_array($key, $highlights)) {

                                            echo '<div class="item--highlight">';

                                            ob_start();
                                            \Elementor\Icons_Manager::render_icon($highlight['highlight_icon'], ['aria-hidden' => 'true']);
                                            $icon = ob_get_clean();
                                            echo '<span>' . $icon . '</span>';
                                            echo '<span>' . $highlight['highlight_caption'] . '</span>';

                                            echo '</div>';
                                        }

                                    } ?>
                                </div>
                            <?php } ?>



                        </div>


                    </div>
                <?php } ?>

            </div>



        </div>



    <?php }



}
