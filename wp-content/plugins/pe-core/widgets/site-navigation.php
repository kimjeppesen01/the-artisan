<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
  exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeSiteNavigation extends Widget_Base
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
    return 'pesitenavigation';
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
    return __('Site Navigation', 'pe-core');
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
    return 'eicon-menu-toggle pe-widget';
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
        'label' => __('Site Navigation', 'pe-core'),
      ]
    );

    $this->add_control(
      'menu_style',
      [
        'label' => esc_html__('Navigation Style', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'classic',
        'options' => [
          'classic' => esc_html__('Classic', 'pe-core'),
          'fullscreen' => esc_html__('Fullscreen', 'pe-core'),
          'popup' => esc_html__('Popup', 'pe-core'),
        ],
      ]
    );

    $templates = [];

    $templates = get_posts([
      'post_type' => 'elementor_library',
      'numberposts' => -1
    ]);

    foreach ($templates as $template) {
      $templates[$template->ID] = $template->post_title;
    }

    $this->add_control(
      'select_template',
      [
        'label' => __('Select Menu Template', 'pe-core'),
        'description' => __('You can create your menu template via "Templates > Saved Templates > Add New Template" on your admin dashboard.', 'pe-core'),
        'label_block' => false,
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => $templates,
      ]
    );

    $this->add_responsive_control(
      'popup_position',
      [
        'label' => esc_html__('Popup Position', 'pe-core'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => esc_html__('Left', 'pe-core'),
            'icon' => 'eicon-text-align-left',
          ],
          'right' => [
            'title' => esc_html__('Right', 'pe-core'),
            'icon' => 'eicon-text-align-right',
          ],
        ],
        'default' => is_rtl() ? 'left' : 'right',
        'toggle' => false,
        'prefix_class' => 'popup--pos--',
        'condition' => [
          'menu_style' => 'popup'
        ],
        'selectors' => [
          '{{WRAPPER}} .text-wrapper' => 'text-align: {{VALUE}};',
        ],
      ]
    );


    $this->add_control(
      'overlay_style',
      [
        'label' => esc_html__('Overlay Style', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'overlay',
        'options' => [
          'slide' => esc_html__('Slide', 'pe-core'),
          'blocks' => esc_html__('Blocks', 'pe-core'),
          'overlay' => esc_html__('Overlay', 'pe-core'),
        ],
        'condition' => [
          'menu_style' => 'fullscreen'
        ]
      ]
    );


    $this->add_control(
      'blocks_count',
      [
        'label' => esc_html__('Blocks Count', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 20,
            'step' => 1,
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 4,
        ],
        'condition' => [
          'overlay_style' => 'blocks'
        ]
      ]
    );


    $this->add_control(
      'toggle_style',
      [
        'label' => esc_html__('Toggle Style', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'plus',
        'options' => [
          'hamburger' => esc_html__('Hamburger', 'pe-core'),
          'plus' => esc_html__('Plus', 'pe-core'),
          'text' => esc_html__('Text', 'pe-core'),
          'plus_text' => esc_html__('Plus + Text', 'pe-core'),
        ],
      ]
    );

    $this->add_control(
      'hamburger_style',
      [
        'label' => esc_html__('Hamburger Style', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'simple',
        'prefix_class' => 'hamburger--style--',
        'options' => [
          'stylized' => esc_html__('Stylized', 'pe-core'),
          'simple' => esc_html__('Simple', 'pe-core'),
        ],
        'condition' => [
          'toggle_style' => 'hamburger'
        ]
      ]
    );

    $this->add_responsive_control(
      'toggle_size',
      [
        'label' => esc_html__('Size', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'vw'],
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
          'vw' => [
            'min' => 0,
            'max' => 100,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .menu--toggle' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );



    $this->add_control(
      'open_text',
      [
        'label' => esc_html__('Open Text', 'pe-core'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__('Write menu open text here', 'pe-core'),
        'default' => esc_html__('MENU', 'pe-core'),
        'ai' => false,
        'condition' => [
          'toggle_style!' => 'plus'
        ]
      ]
    );

    $this->add_control(
      'close_text',
      [
        'label' => esc_html__('Close Text', 'pe-core'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__('Write menu close here', 'pe-core'),
        'default' => esc_html__('CLOSE', 'pe-core'),
        'ai' => false,
        'condition' => [
          'toggle_style!' => 'plus'
        ]
      ]
    );

    $this->add_control(
      'text_framed',
      [
        'label' => esc_html__('Framed?', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'return_value' => 'framed',
        'default' => 'framed',
        'condition' => [
          'toggle_style!' => 'plus'
        ]
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'additional',
      [

        'label' => esc_html__('Additonal Options', 'pe-core'),

      ]
    );

    $this->add_control(
      'hide_elements',
      [
        'label' => esc_html__('Hide Header Elements on Menu Open', 'pe-core'),
        'label_block' => true,
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__('Enter target element class. Eg: .layout-switcher ', 'pe-core'),
        'description' => esc_html__('You can add classes to elements via "Advanced > CSS Classes" on widget options.', 'pe-core'),
        'ai' => false,
        'dynamic' => [
          'active' => false,
        ],
      ]
    );


    $this->end_controls_section();
    pe_cursor_settings($this);

    objectStyles($this, 'menu--toggle', 'Toggle Button', '.menu--toggle');

    pe_color_options($this);

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $option = get_option('pe-redux');
    $menuClasses = 'menu main-menu';
    $style = $settings['menu_style'];
    $overlay = $settings['overlay_style'];

    if ($style === 'classic') {

      echo '<nav id="site-navigation" class="main-navigation classic">';
      wp_nav_menu(
        array(
          'theme_location' => '',
          'menu' => $settings['select_menu'],
          'container' => false,
          'menu_class' => $menuClasses
        )
      );

      echo '</nav>';

    } else if ($style === 'popup' || $style === 'fullscreen') { ?>

        <div class="site--nav nav--<?php echo $style . ' overlay--' . $overlay; ?>"
          data-hide-elements="<?php echo $settings['hide_elements'] ?>">

          <div class="menu--toggle--wrap" data-id="<?php echo $this->get_id(); ?>">

          <?php if ($settings['toggle_style'] === 'plus' || $settings['toggle_style'] === 'hamburger') { ?>
              <div class="menu--toggle toggle--<?php echo $settings['toggle_style'] ?> has--bg has--hover" <?php echo pe_cursor($this); ?>>

                <span class="toggle-line"></span>
                <span class="toggle-line"></span>

              </div>
          <?php }
          if ($settings['toggle_style'] === 'text') { ?>

              <div <?php echo pe_cursor($this); ?> class="menu--toggle toggle--text <?php echo $settings['text_framed'] ?>">

                <div class="toggle--text--wrapper">

                  <span class="open--text"><?php echo esc_html($settings['open_text']) ?></span>
                  <span class="close--text"><?php echo esc_html($settings['close_text']) ?></span>

                </div>

              </div>

          <?php } else if ($settings['toggle_style'] === 'plus_text') { ?>

                <div class="menu--toggle toggle--plus--text" <?php echo pe_cursor($this); ?>>

                  <div class="tpt--icon">

                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960" width="1em"
                      fill="var(--mainColor)">
                      <path d="M460-460H240v-40h220v-220h40v220h220v40H500v220h-40v-220Z" />
                    </svg>

                  </div>

                  <div class="toggle--text--wrapper">
                    <span class="open--text"><?php echo esc_html($settings['open_text']) ?></span>
                    <span class="close--text"><?php echo esc_html($settings['close_text']) ?></span>
                  </div>

                </div>

          <?php } ?>
          </div>

        <?php if ($overlay === 'blocks') { ?>

            <div class="nav_overlay nav--blocks <?php echo 'blocks__' . $this->get_id() ?>">

              <?php
              if (class_exists("Redux")) {

                $option = get_option('pe-redux');

                $count = $settings['blocks_count']['size'];
                for ($i = 0; $i < $count; $i++) {
                  echo '<span class="fullscreen--menu--block"  style="--index: ' . $i . '; --grid:' . $count . '"></span>';
                }

              }
              ?>

            </div>
        <?php } else if ($overlay === 'overlay') {

          echo '<span class="nav_overlay nav--overlay overlay__' . $this->get_id() . '"></span>';
          echo '<span class="nav_bg_opacity bg_op_' . $this->get_id() . '"></span>';

        } ?>

          <div class="site--menu <?php echo 'menu__' . $this->get_id() . ' menu--' . $style ?>">

            <?php

            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($settings['select_template']);

            ?>

          </div>

        </div>

    <?php }



  }

}
