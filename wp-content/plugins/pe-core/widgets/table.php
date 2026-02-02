<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeTable extends Widget_Base
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
        return 'petable';
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
        return __('Table', 'pe-core');
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
        return 'eicon-table pe-widget';
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
                'label' => __('Infinite Tabs', 'pe-core'),
            ]
        );

        $this->add_control(
            'table_columns',
            [
                'label' => esc_html__('Table Columns', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '1' => esc_html__('1', 'pe-core'),
                    '2' => esc_html__('2', 'pe-core'),
                    '3' => esc_html__('3', 'pe-core'),
                    '4' => esc_html__('4', 'pe-core'),
                    '5' => esc_html__('5', 'pe-core'),
                ],
            ]
        );

        for ($col = 2; $col <= 6; $col++) {
            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'is_link',
                [
                    'label' => esc_html__('Linked?', 'pe-core'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'pe-core'),
                    'label_off' => esc_html__('No', 'pe-core'),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );


            $repeater->add_control(
                'link_url',
                [
                    'label' => esc_html__('Link URL', 'pe-core'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => esc_html__('https://your-link.com', 'pe-core'),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => false,
                        'nofollow' => false,
                    ],
                    'condition' => [
                        'is_link' => 'yes',
                    ],
                ]
            );


            for ($i = 1; $i <= $col; $i++) {
                $repeater->add_control(
                    'column_' . $i,
                    [
                        'label' => esc_html__('Column ' . $i, 'pe-core'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'label_block' => true,
                        'ai' => false,
                        'default' => esc_html__('Default ' . $i, 'pe-core'),
                    ]
                );
            }

            $repeater->add_control(
                'has_image',
                [
                    'label' => esc_html__('Has Image?', 'pe-core'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'pe-core'),
                    'label_off' => esc_html__('No', 'pe-core'),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $repeater->add_control(
                'image',
                [
                    'label' => esc_html__('Choose Image', 'pe-core'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'has_image' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'table_rows_' . $col,
                [
                    'label' => esc_html__('Table Rows' . $col . ' Columns', 'pe-core'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'condition' => [
                        'table_columns' => strval($col),
                    ],
                ]
            );
        }


        $this->add_control(
            'titles_row',
            [
                'label' => esc_html__('Titles Row', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );


        for ($i = 2; $i <= 6; $i++) {

            $this->add_control(
                'title_row_' . $i,
                [
                    'label' => esc_html__('Title for column ' . ($i - 1) . '', 'pe-core'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'ai' => false,
                    'condition' => [
                        'titles_row' => 'yes'
                    ],
                ]
            );
        }

        $this->add_control(
            'add_icon',
            [
                'label' => esc_html__('Add Icon', 'pe-core'),
                'description' => esc_html__('An icon will be inserted at the last column of each row.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'add_icon' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'hovers',
            [
                'label' => esc_html__('Hover Effects', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'table__hover',
                'default' => 'table__hover',
            ]
        );
        $this->end_controls_section();

        pe_cursor_settings($this);
        pe_text_animation_settings($this);


        $this->start_controls_section(
            'table_styles',
            [
                'label' => esc_html__('Table Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'titles_typography',
                'label' => esc_html__('Titles Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .table--title--row span'
            ]
        );

        $this->add_control(
            'is_underlined',
            [
                'label' => esc_html__('Underlined?', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'prefix_class' => 'table--underlined-',
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'is_bg',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'prefix_class' => 'table--background-',
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_responsive_control(
            'items_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .pe--table--wrapper' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',

                ],
            ]
        );

        $this->add_responsive_control(
            'items_padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pe--table--wrapper .pe--table--row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // Kolonlar için kontrolleri ekleyelim
        for ($i = 1; $i <= 6; $i++) {

            $this->start_controls_section(
                'column_styles_' . $i,
                [
                    'label' => esc_html__('Column ' . $i . ' Styles', 'pe-core'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_responsive_control(
                'column_width_' . $i,
                [
                    'label' => esc_html__('Width', 'pe-core'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .pe--table--row > span:nth-child(' . $i . ')' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'column_typography_' . $i,
                    'label' => esc_html__('Column ' . $i . ' Typography', 'pe-core'),
                    'selector' => '{{WRAPPER}} .pe--table--row > span:nth-child(' . $i . ')'
                ]
            );

            $this->add_responsive_control(
                'column_alignment_' . $i,
                [
                    'label' => esc_html__(' Column ' . $i . ' Alignment', 'pe-core'),
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
                        'justify' => [
                            'title' => esc_html__('Justify', 'pe-core'),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'default' => is_rtl() ? 'right' : 'left',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .pe--table--row > span:nth-child(' . $i . ')' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            objectStyles($this, 'column_' . $i, ' Column ' . $i, '.pe--table--row:not(.table--title--row) > span:nth-child(' . $i . ') span', false, false, false, false);

            pe_color_options($this, '.pe--table--row > span:nth-child(' . $i . ')', 'column_' . $i, false);

            $this->end_controls_section();
        }

        $this->start_controls_section(
            'image',
            [
                'label' => esc_html__('Image', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
                    'unit' => 'px',
                    'size' => 250,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--table--row--image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .pe--table--row--image' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );
        $this->end_controls_section();
        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $columns = $settings['table_columns'];
        $cursor = pe_cursor($this);
        $animation = pe_text_animation($this);

        ob_start();

        \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']);

        $icon = ob_get_clean();

        // Seçilen kolon sayısına göre doğru Repeater'ı kullanın
        switch ($columns) {
            case '2':
                $rows = $settings['table_rows_2'];
                break;
            case '3':
                $rows = $settings['table_rows_3'];
                break;
            case '4':
                $rows = $settings['table_rows_4'];
                break;
            case '5':
                $rows = $settings['table_rows_5'];
                break;
            case '6':
                $rows = $settings['table_rows_6'];
                break;
            default:
                $rows = [];

        } ?>

        <div class="pe--table <?php echo 'table__col__' . $settings['table_columns'] . ' ' . $settings['hovers'] ?>">
            <div class="pe--table--wrapper">

                <?php

                if ($settings['titles_row'] === 'yes') { ?>


                    <div class="pe--table--row table--title--row">
                        <?php
                        for ($i = 2; $i <= ($columns + 1); $i++) {

                            echo '<span ' . $animation . ' >' . $settings['title_row_' . $i] . '</span>';

                        }
                        if ($settings['add_icon'] === 'yes') {
                            echo '<span></span>';
                        }



                        ?>
                    </div>

                <?php }
                foreach ($rows as $key => $row) {

                    $row_class = 'pe--table--row row__' . $key;
                    if ($row['is_link'] === 'yes') {
                        $link_url = esc_url($row['link_url']['url']);
                        $target = $row['link_url']['is_external'] ? ' target="_blank"' : '';
                        $nofollow = $row['link_url']['nofollow'] ? ' rel="nofollow"' : '';
                        echo '<a ' . $cursor . '  class="' . esc_attr($row_class) . '" href="' . $link_url . '"' . $target . $nofollow . '>';
                    } else {
                        echo '<div class="' . esc_attr($row_class) . '">';
                    }

                    for ($i = 1; $i <= $columns; $i++) {
                        $column_key = 'column_' . $i;
                        echo '<span ' . $animation . ' ><span class="pe--styled--object">' . esc_html($row[$column_key]) . '</span></span>';
                    }


                    if ($settings['add_icon'] === 'yes') {
                        echo '<span><span class="pe--styled--object">' . $icon . '</span></span>';
                    }

                    if ($row['has_image'] === 'yes') { ?>

                        <div class="pe--table--row--image">
                            <?php
                            echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($row, 'thumbnail', 'image');
                            ?>
                        </div>

                    <?php }

                    if ($row['is_link'] === 'yes') {
                        echo '</a>';
                    } else {
                        echo '</div>';
                    }
                }

                ?>

            </div>


        </div>

        <?php
    }



}
