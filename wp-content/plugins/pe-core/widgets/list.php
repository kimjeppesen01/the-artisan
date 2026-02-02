<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeList extends Widget_Base
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
        return 'pelist';
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
        return __('List', 'pe-core');
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
        return 'eicon-bullet-list pe-widget';
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


        $registered = wp_get_nav_menus();
        $menus = [];

        if ($registered) {
            foreach ($registered as $menu) {

                $name = $menu->name;
                $id = $menu->term_id;

                $menus[$name] = $name;

            }
        }

        // Tab Title Control
        $this->start_controls_section(
            'section_tab_title',
            [
                'label' => __('List', 'pe-core'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_type',
            [
                'label' => esc_html__('Item Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'icon' => esc_html__('Icon', 'pe-core'),
                    'text' => esc_html__('Text', 'pe-core'),
                ],
            ]
        );

        $repeater->add_control(
            'list_text',
            [
                'label' => esc_html__('Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Lorem ipsum dolor sit amet.', 'pe-core'),
                'label_block' => true,
                'condition' => ['item_type' => 'text']
            ]
        );

        $repeater->add_control(
            'list_icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => ['item_type' => 'icon']
            ]
        );

        $repeater->add_control(
            'list_caption',
            [
                'label' => esc_html__('Caption', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('Leave it empty if you dont want to display caption.', 'pe-core'),
                'label_block' => true,
                'condition' => ['item_type' => 'text']
            ]
        );


        $repeater->add_control(
            'linked',
            [
                'label' => esc_html__('Linked', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'deafult' => 'no'
            ]
        );

        $repeater->add_control(
            'link',
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
                'condition' => ['linked' => 'yes'],
            ]
        );

        $this->add_control(
            'list',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_type' => 'text',
                        'list_text' => esc_html__('Lorem ipsum dolor sit amet...', 'pe-core'),
                    ],
                    [
                        'item_type' => 'text',
                        'list_text' => esc_html__('Lorem ipsum dolor sit amet...', 'pe-core'),
                    ],
                ],
                'title_field' => '{{{ list_text }}}',
            ]
        );

        $this->add_control(
            'list--style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'list--nested',
                'options' => [
                    'list--nested' => esc_html__('Nested', 'pe-core'),
                    'list--ordered' => esc_html__('Ordered', 'pe-core'),
                ],
            ]
        );

        $this->add_responsive_control(
            'list--direciton',
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
                'default' => 'column',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .pe--list ul' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items--alignment',
            [
                'label' => esc_html__('Items Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pe-core'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Justify', 'pe-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .pe--list ul' => 'justify-content: {{VALUE}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'items--gap',
            [
                'label' => esc_html__('Items Gap', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%', 'rem', 'em'],
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
                    'rem' => [
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
                    '{{WRAPPER}} .pe--list ul' => 'gap:  {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_typography',
                'label' => esc_html__('Items Typohraphy', 'pe-core'),
                'selector' => '{{WRAPPER}} ul > li',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'caption_typography',
                'label' => esc_html__('Captions Typohraphy', 'pe-core'),
                'selector' => '{{WRAPPER}} .list--caption',
            ]
        );

        $this->add_control(
            'caption_color',
            [
                'label' => esc_html__('Caption Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .list--caption' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->end_controls_section();

        pe_cursor_settings($this);
        pe_text_animation_settings($this, true);

        objectStyles($this, 'list_item_', 'Items', '.pe--styled--object', false);

        pe_color_options($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $cursor = pe_cursor($this);

        ?>

        <div class="pe--list">

            <ul>
                <?php foreach ($settings['list'] as $item) {
                    $object = '';
                    if ($item['item_type'] === 'icon') {
                        ob_start();
                        \Elementor\Icons_Manager::render_icon($item['list_icon'], ['aria-hidden' => 'true']);
                        $object = ob_get_clean();
                    } else {

                        if (!empty($item['list_caption'])) {
                            $capt = '<span class="list--caption">' . $item['list_caption'] . '</span>';
                        } else {
                            $capt = '';
                        }

                        $object = $item['list_text'] . $capt;
                    }

                    ?>
                    <li class="pe--styled--object" <?php echo $cursor; ?>>
                        <?php
                        if (!empty($item['link']['url'])) {
                            $url = $item['link']['url'];
                            $target = $item['link']['is_external'] ? '_blank' : '_self';

                            echo '<a target="' . $target . '" href="' . $url . '">' . $object . '</a>';
                        } else {
                            echo $object;
                        }
                        ?>


                    </li>
                <?php } ?>
            </ul>


        </div>


    <?php }

}
