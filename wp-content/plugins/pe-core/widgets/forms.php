<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
  exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeForms extends Widget_Base
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
    return 'peforms';
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
    return __('Forms', 'pe-core');
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
    return 'eicon-form-horizontal pe-widget';
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
        'label' => __('Forms', 'pe-core'),
      ]
    );
    $this->add_control(
      'forms_info',
      [
        'type' => \Elementor\Controls_Manager::RAW_HTML,
        'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
				   <span>This widget is only for visual preferences of the form. You can configure your form via "Contact Forms" on your admin dashboard.</span> Also do not forget to setup your servers SMTP settings before sending forms.</div>',
      ]

    );

    $forms = [];

    $forms = get_posts([
      'post_type' => 'wpcf7_contact_form',
      'numberposts' => -1
    ]);

    foreach ($forms as $form) {
      $forms[$form->ID] = $form->post_title;
    }

    $this->add_control(
      'select_form',
      [
        'label' => __('Select Form', 'pe-core'),
        'label_block' => false,
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => $forms,
      ]
    );

    $this->add_control(
      'form_layout',
      [
        'label' => esc_html__('Form Layout ', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'layout--form',
        'options' => [
          'layout--form' => esc_html__('Form', 'pe-core'),
          'layout--input' => esc_html__('Single Input', 'pe-core'),
        ],
        'prefix_class' => ''
      ]
    );

    $this->add_responsive_control(
      'form_alignment',
      [
        'label' => esc_html__('Alignment', 'pe-core'),
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
        ],
        'default' => is_rtl() ? 'right' : 'left',
        'toggle' => true,
        'selectors' => [
          '{{WRAPPER}} form.wpcf7-form' => 'text-align: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'focus_actions',
      [
        'label' => esc_html__('Focus Actions ', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'default' => 'focus--label',
        'options' => [
          'focus--label' => esc_html__('Label Animate', 'pe-core'),
          'focus--outline' => esc_html__('Outline', 'pe-core'),
        ],
        'multiple' => true,
      ]
    );

    $this->add_control(
      'validate_colors',
      [
        'label' => esc_html__('Validate Colors', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'pe-core'),
        'label_off' => esc_html__('No', 'pe-core'),
        'return_value' => 'validate--colors',
        'prefix_class' => '',
        'default' => '',
      ]
    );


    $this->add_control(
      'inputs_has_bg',
      [
        'label' => esc_html__('Background', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'pe-core'),
        'label_off' => esc_html__('No', 'pe-core'),
        'return_value' => 'inputs--has--bg',
        'prefix_class' => '',
        'default' => '',
      ]
    );

    $this->add_control(
      'inputs_has_backdrop',
      [
        'label' => esc_html__('Backdrop Filter', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'pe-core'),
        'label_off' => esc_html__('No', 'pe-core'),
        'return_value' => 'inputs--has--backdrop',
        'prefix_class' => '',
        'default' => '',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'inputs_typography',
        'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .pe--form form.wpcf7-form.init p',
        'label' => esc_html__('Inputs Typography', 'pe-core'),
      ]
    );


    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'inputs_border',
        'selector' => '{{WRAPPER}} input:not(*[type="submit"]) , {{WRAPPER}} textarea'
      ]
    );


    $this->add_responsive_control(
      'inputs_has_border_radius',
      [
        'label' => esc_html__('Border Radius', 'pe-core'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%', 'custom'],
        'selectors' => [
          '{{WRAPPER}} input:not(*[type="submit"]) , {{WRAPPER}} textarea' => '--radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'inputs_has_padding',
      [
        'label' => esc_html__('Padding', 'pe-core'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%', 'custom'],
        'selectors' => [
          '{{WRAPPER}} .pe--form' => '--paddingTop: {{TOP}}{{UNIT}}; --paddingRight: {{RIGHT}}{{UNIT}}; --paddingBottom: {{BOTTOM}}{{UNIT}}; --paddingLeft: {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      '50_input_names',
      [
        'label' => esc_html__('Input Names (50% Width)', 'pe-core'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__('eg: your-name , your-surname ', 'pe-core'),
        'description' => esc_html__('Enter input names as you inserted them into form.', 'pe-core'),
        'ai' => false,
      ]
    );

    $this->add_control(
      '30_input_names',
      [
        'label' => esc_html__('Input Names (30% Width)', 'pe-core'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__('eg: your-name , your-surname ', 'pe-core'),
        'description' => esc_html__('Enter input names as you inserted them into form.', 'pe-core'),
        'ai' => false,
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'form_button_styles',
      [
        'label' => __('Button Styles', 'pe-core'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'submit_style',
      [
        'label' => esc_html__('Submit Style ', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'text',
        'render_type' => 'template',
        'options' => [
          'text' => esc_html__('Text', 'pe-core'),
          'text--icon' => esc_html__('Text + Icon', 'pe-core'),
          'icon' => esc_html__('Icon', 'pe-core'),
        ],
        'prefix_class' => 'submit--style--',

      ]
    );

    $this->add_control(
      'submit__icon',
      [
        'label' => esc_html__('Icon', 'pe-core'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'condition' => ['submit_style' => ['text--icon', 'icon']],
      ]
    );

    $this->add_control(
      'icon_position',
      [
        'label' => esc_html__('Icon Position', 'pe-core'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => esc_html__('Left', 'pe-core'),
            'icon' => 'eicon-h-align-left',
          ],
          'right' => [
            'title' => esc_html__('Row', 'pe-core'),
            'icon' => 'eicon-h-align-right',
          ],
        ],
        'default' => is_rtl() ? 'left' : 'right',
        'prefix_class' => 'icon--pos--',
        'toggle' => false,
        'condition' => ['submit_style' => 'text--icon'],

      ]
    );




    $this->add_responsive_control(
      'button_text_alignment',
      [
        'label' => esc_html__('Text Align', 'pe-core'),
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
        ],
        'default' => is_rtl() ? 'right' : 'left',
        'toggle' => true,
        'selectors' => [
          '{{WRAPPER}} p:has(input[type="submit"])' => 'text-align: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'button_main_color',
      [
        'label' => esc_html__('Button Color', 'pe-core'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} p:has(input[type="submit"])' => '--mainColor: {{VALUE}}',
        ]
      ]
    );


    objectStyles($this, 'form_button', 'Button', '.pe--form form.wpcf7-form.init input[type="submit"]', true, false, false);
    objetAbsolutePositioning($this, '.pe--form form.wpcf7-form.init p:has(input[type="submit"])', 'form_button', 'Button');

    $this->end_controls_section();
    pe_color_options($this);

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $id = $settings['select_form'];

    $classes = [];

    foreach ($settings['focus_actions'] as $act) {
      $classes[] = $act;
    }

    $inputs50 = explode(' , ', $settings['50_input_names']);
    $inputs30 = explode(' , ', $settings['30_input_names']);

    ?>

    <style>
      <?php

      if (!empty($inputs50)) {
        foreach ($inputs50 as $name) {
          echo '.pe--form p:has(input[name="' . $name . '"]) { width: 48% !important}';
        }
      }
      ;

      if (!empty($inputs30)) {
        foreach ($inputs30 as $name) {
          echo '.pe--form p:has(input[name="' . $name . '"]) { width: 31% !important}';
        }
      }
      ;

      ?>
    </style>

    <div class="pe--form <?php echo implode(' ', $classes) ?>">

      <?php

      if ($settings['submit_style'] === 'icon' || $settings['submit_style'] === 'text--icon') {

        if ($settings['submit__icon']['value']) {
          ob_start();
          \Elementor\Icons_Manager::render_icon($settings['submit__icon'], ['aria-hidden' => 'true']);
          $object = ob_get_clean();

        } else {
          $svgPath = plugin_dir_path(__FILE__) . '../assets/img/send.svg';
          $object = file_get_contents($svgPath);
        }
        ?>
        <span class="saren--form--submit--icon"><?php echo $object ?></span>

      <?php }

      ?>

      <?php echo do_shortcode('[contact-form-7 id="' . $id . '"]'); ?>

    </div>

    <?php
  }

}
