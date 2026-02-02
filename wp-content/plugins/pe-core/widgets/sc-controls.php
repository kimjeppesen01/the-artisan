<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
	exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeScControls extends Widget_Base
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
		return 'pesccontrols';
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
		return __('Slider/Carousel Controls', 'pe-core');
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
		return 'eicon-carousel pe-widget';
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
				'label' => __('Slider/Carousel Controls', 'pe-core'),
			]
		);

		$this->add_control(
			'target_id',
			[
				'label' => esc_html__('Target Carousel/Slider ID', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'ai' => false,
				'description' => esc_html__('Must be exact match with the carousel/slider ID.', 'pe-core'),
			]
		);

		$this->add_control(
			'control_type',
			[
				'label' => __('Control Type', 'pe-core'),
				'label_block' => true,
				'default' => 'fraction',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'fraction' => esc_html__('Fraction', 'pe-core'),
					'progressbar' => esc_html__('Progressbar', 'pe-core'),
					'navigation' => esc_html__('Navigation', 'pe-core'),
				],

			]
		);

		$this->add_control(
			'nav_type',
			[
				'label' => __('Navigation Type', 'pe-core'),
				'label_block' => true,
				'default' => 'text',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'text' => esc_html__('Text', 'pe-core'),
					'icon' => esc_html__('Icon', 'pe-core'),
				],
				'condition' => ['control_type' => 'navigation'],

			]
		);

		$this->add_control(
			'prev_text',
			[
				'label' => esc_html__('Prev Text', 'pe-core'),
				'default' => esc_html__('PREV', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'ai' => false,
				'condition' => ['nav_type' => 'text', 'control_type' => 'navigation'],
			]
		);

		$this->add_control(
			'prev_icon',
			[
				'label' => esc_html__('Prev Icon', 'pe-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'material-icons md-arrow_backward',
					'library' => 'material-design-icons',
				],
				'condition' => ['nav_type' => 'icon'],
			]
		);

		$this->add_control(
			'next_icon',
			[
				'label' => esc_html__('Next Icon', 'pe-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'material-icons md-arrow_forward',
					'library' => 'material-design-icons',
				],
				'condition' => ['nav_type' => 'icon'],
			]
		);

		$this->add_control(
			'next_text',
			[
				'label' => esc_html__('Next Text', 'pe-core'),
				'default' => esc_html__('NEXT', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'ai' => false,
				'condition' => ['nav_type' => 'text', 'control_type' => 'navigation'],
			]
		);

		$this->add_control(
			'unitaze_numbers',
			[
				'label' => esc_html__('Unitaze Numbers', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'unitaze--numbers',
				'default' => '',
				'condition' => ['control_type' => 'fraction'],
			]
		);

		$this->add_control(
			'brackets',
			[
				'label' => esc_html__('Brackets', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'brackets--on',
				'default' => '',
			]
		);


		$this->add_control(
			'seperator',
			[
				'label' => esc_html__('Seperator', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'yes',
				'default' => '',
				'condition' => ['control_type!' => 'progressbar'],

			]
		);

		$this->add_control(
			'seperator_type',
			[
				'label' => __('Seperator Type', 'pe-core'),
				'label_block' => true,
				'default' => 'line',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'line' => esc_html__('Line', 'pe-core'),
					'slash' => esc_html__('Slash', 'pe-core'),
					'icon' => esc_html__('Icon', 'pe-core'),
				],
				'condition' => ['seperator' => 'yes'],

			]
		);


		$this->add_control(
			'seperator_icon',
			[
				'label' => esc_html__('Seperator Icon', 'pe-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'material-icons md-arrow_outward',
					'library' => 'material-design-icons',
				],
				'condition' => ['seperator_type' => 'icon' , 'seperator' => 'yes'],
			]
		);

		$this->add_responsive_control(
			'bar_width',
			[
				'label' => esc_html__('Bar Width', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'vw'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'selectors' => [
					'{{WRAPPER}} .sc--progressbar' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['control_type' => 'progressbar'],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => esc_html__('Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .sc--fraction , {{WRAPPER}} .sc--navigation span',
			]
		);

		$this->add_control(
			'fraction_color',
			[
				'label' => esc_html__('Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pe--sc--controls' => '--mainColor: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'controls_orientation',
			[
				'label' => esc_html__('Oritentation', 'pe-core'),
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
				'selectors' => [
					'{{WRAPPER}} .sc--navigation' => 'flex-direction: {{VALUE}};',
				],
				'prefix_class' => 'controls__orientation-',
			]
		);
	
	

		$this->add_responsive_control(
			'alignment',
			[
				'label' => esc_html__('Alignment', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__('Left', 'pe-core'),
						'icon' => ' eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'pe-core'),
						'icon' =>' eicon-h-align-center',
					],
					'flex-end' => [
						'title' => esc_html__('Right', 'pe-core'),
						'icon' =>' eicon-h-align-right',
					],
					'space-between' => [
						'title' => esc_html__('Space-Between', 'pe-core'),
						'icon' =>' eicon-justify-space-between-h',
					],
				],
				'default' => 'flex-start',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .sc--navigation' => 'justify-content: {{VALUE}};',
				],
			]
		);



		$this->end_controls_section();

		objectStyles($this, 'objects_', 'Object', '.pe--styled--object', false);


		pe_color_options($this);
		


	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$option = get_option('pe-redux');

		ob_start();

		\Elementor\Icons_Manager::render_icon($settings['seperator_icon'], ['aria-hidden' => 'true']);

		$icon = ob_get_clean();

		?>



		<div class="pe--sc--controls <?php echo $settings['brackets'] . ' ' . $settings['unitaze_numbers'] ?>"
			data-id='<?php echo esc_attr($settings['target_id']) ?>'>

			<?php if ($settings['control_type'] === 'fraction') { ?>
				<div class="sc--fraction">

					<span class="sc--current pe--styled--object"></span>

					<?php if ($settings['seperator'] === 'yes') {

						echo $settings['seperator_type'] === 'icon' ? $icon : '';
						echo $settings['seperator_type'] === 'line' ? '-' : '';
						echo $settings['seperator_type'] === 'slash' ? '/' : '';

					} ?>

					<span class="sc--total pe--styled--object"></span>

				</div>
			<?php } ?>

			<?php if ($settings['control_type'] === 'progressbar') { ?>

				<div class="sc--progressbar">

					<span class="sc--prog"></span>
					<span class="sc--full"></span>

				</div>

			<?php } ?>

			<?php if ($settings['control_type'] === 'navigation') { ?>

				<div class="sc--navigation <?php echo 'nav_' . $settings['nav_type'] ?>">

					<?php if ($settings['nav_type'] === 'icon') { ?>

						<span class="sc--prev pe--styled--object">

							<?php \Elementor\Icons_Manager::render_icon($settings['prev_icon'], ['aria-hidden' => 'true']); ?>

						</span>

						<?php if ($settings['seperator'] === 'yes') {

							echo $settings['seperator_type'] === 'icon' ? $icon : '';
							echo $settings['seperator_type'] === 'line' ? '-' : '';
							echo $settings['seperator_type'] === 'slash' ? '/' : '';

						} ?>

						<span class="sc--next pe--styled--object">

							<?php \Elementor\Icons_Manager::render_icon($settings['next_icon'], ['aria-hidden' => 'true']); ?>

						</span>

					<?php } else if ($settings['nav_type'] === 'text') { ?>

							<span class="sc--prev pe--styled--object"> <?php echo $settings['prev_text'] ?> </span>

						<?php if ($settings['seperator'] === 'yes') {

							echo $settings['seperator_type'] === 'icon' ? $icon : '';
							echo $settings['seperator_type'] === 'line' ? '-' : '';
							echo $settings['seperator_type'] === 'slash' ? '/' : '';

						} ?>
							<span class="sc--next pe--styled--object"> <?php echo $settings['next_text'] ?> </span>

					<?php } ?>

				</div>

			<?php } ?>

		</div>



		<?php
	}

}
