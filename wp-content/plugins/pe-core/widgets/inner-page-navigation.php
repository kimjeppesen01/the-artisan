<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
  exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeInnerPageNavigation extends Widget_Base
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
    return 'peinnerpagenavigation';
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
    return __('Inner Page Navigation', 'pe-core');
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
    return 'eicon-post-navigation pe-widget';
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
        'label' => __('Inner Page Navigation', 'pe-core'),
      ]
    );

    $repeater = new \Elementor\Repeater();


    $repeater->add_control(
      'item_title',
      [
        'label' => esc_html__('Item Title', 'pe-core'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Item Title', 'pe-core'),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'item_target',
      [
        'label' => esc_html__('Scroll Target', 'pe-core'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__('Eg: #aboutContainer', 'pe-core'),
        'description' => esc_html__('Enter a target ID or exact number of desired scroll position ("0" for scrolling top)', 'pe-core'),
        'label_block' => true,
      ]
    );

    $this->add_control(
      'inner--nav',
      [
        'label' => esc_html__('Navigation Items', 'pe-core'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'item_title' => esc_html__('Item #1', 'pe-core'),

          ],
        ],
        'title_field' => '{{{ item_title }}}',
      ]
    );


    $this->add_control(
      'nav_style',
      [
        'label' => esc_html__('Navigation Style', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'metro',
        'prefix_class' => 'inner--nav--',
        'options' => [
          'simple' => esc_html__('Simple', 'pe-core'),
          'metro' => esc_html__('Metro', 'pe-core'),
        ],
      ]
    );


    $this->add_control(
      'active_item_style',
      [
        'label' => esc_html__('Active Item Style', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'bg',
        'prefix_class' => 'nav--active--',
        'options' => [
          'bg' => esc_html__('Background', 'pe-core'),
          'underline' => esc_html__('Underline', 'pe-core'),
        ],
      ]
    );

    $this->add_responsive_control(
      'nav_direction',
      [
        'label' => esc_html__('Navigation Direction', 'pe-core'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'column' => [
            'title' => esc_html__('Column', 'pe-core'),
            'icon' => 'eicon-v-align-bottom',
          ],
          'row' => [
            'title' => esc_html__('Row', 'pe-core'),
            'icon' => ' eicon-h-align-right',
          ],
        ],
        'default' => 'row',
        'toggle' => false,
        'prefix_class' => 'inner--nav--',
        'selectors' => [
          '{{WRAPPER}} .inner--nav--wrap' => 'flex-direction: {{VALUE}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'nav_writing_mode',
      [
        'label' => esc_html__('Items Writing Mode', 'pe-core'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'none' => [
            'title' => esc_html__('Horizontal', 'pe-core'),
            'icon' => 'eicon-caret-down',
          ],
          'vertical-lr' => [
            'title' => esc_html__('Vertical', 'pe-core'),
            'icon' => ' eicon-caret-left',
          ],
        ],
        'default' => 'none',
        'toggle' => false,
        'selectors' => [
          '{{WRAPPER}} .inner--nav--wrap>div' => 'writing-mode: {{VALUE}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'items_gap',
      [
          'label' => esc_html__('Items Gap', 'pe-core'),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'size_units' => ['px', 'vw', '%'],
          'range' => [
              'px' => [
                  'min' => 0,
                  'max' => 250,
                  'step' => 1
              ],
              'vw' => [
                  'min' => 0,
                  'max' => 100,
                  'step' => 1
              ],
              '%' => [
                  'min' => 0,
                  'max' => 100,
                  'step' => 1
              ]
          ],
          'selectors' => [
              '{{WRAPPER}} .inner--nav--wrap ' => 'gap: {{SIZE}}{{UNIT}}'
          ]
      ]
  );



    $this->add_control(
      'scroll_duration',
      [
        'label' => esc_html__('Scroll Duration', 'pe-core'),
        'description' => esc_html__('Seconds', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => 1,
            'max' => 60,
            'step' => 1,
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 1,
        ],
      ]
    );


    $this->end_controls_section();
    pe_general_animation_settings($this);

    objectStyles($this, 'nav_item_styles_', 'Nav Items', '.pe--styled--object', true, false, true);
    pe_cursor_settings($this);
    pe_color_options($this);
    widgetPinningSettings($this);

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();

    echo widgetPinningRender($this);

    ?>

    <div class="pe--inner--page--navigation" <?php echo pe_general_animation($this) ?>>

      <div class="inner--nav--wrap">
        <span class="nav--follower"> </span>
        <?php foreach ($settings['inner--nav'] as $key => $item) {

          $active = '';
          $key == 0 ? $active = 'active' : '';

          ?>

          <div class="inner--nav--element pe--styled--object pe--scroll--button <?php echo $active ?>"
            data-scroll-to="<?php echo $item['item_target'] ?>"
            data-scroll-duration="<?php echo $settings['scroll_duration']['size'] ?>">
            <?php echo $item['item_title'] ?>
          </div>

        <?php }
        ?>
      </div>

    </div>

    <?php
  }

}
