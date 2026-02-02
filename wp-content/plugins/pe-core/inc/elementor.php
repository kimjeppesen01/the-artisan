<?php

function container_colors($element, $section_id, $args)
{

	if (('section' === $element->get_name() || 'container' === $element->get_name()) && 'section_background' === $section_id) {

		$element->start_controls_section(
			'custom_section',
			[
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'label' => esc_html__('Container Colors', 'pe-core'),
			]
		);

		$element->add_control(
			'container_layout',
			[
				'label' => 'Container Layout',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'layout--default' => 'Default',
					'layout--switched' => 'Switched',
				],
				'default' => 'layout--default',
				'prefix_class' => '',
				'condition' => ['switch_on_enter!' => 'switch_on_enter'],
			]
		);


		$element->add_control(
			'switch_on_enter',
			[
				'label' => esc_html__('Switch Layout on Enter', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'switch_on_enter',
				'prefix_class' => '',
				'default' => false,
				'condition' => ['container_layout!' => 'layout--switched'],
			]
		);



		$element->start_controls_tabs(
			'element_tabs'
		);

		$element->start_controls_tab(
			'colors_default',
			[
				'label' => esc_html__('Default', 'pe-core'),
			]
		);

		$element->add_control(
			'main_color',
			[
				'label' => esc_html__('Main Texts Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} , {{WRAPPER}} .e-con' => '--mainColor: {{VALUE}}',
				],
			]
		);

		$element->add_control(
			'secondary_color',
			[
				'label' => esc_html__('Secondary Texts Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} , {{WRAPPER}} .e-con' => '--secondaryColor: {{VALUE}}',
				],
			]
		);

		$element->add_control(
			'lines_color',
			[
				'label' => esc_html__('Lines Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} , {{WRAPPER}} .e-con' => '--linesColor: {{VALUE}}',
				],
			]
		);

		$element->end_controls_tab();

		$element->start_controls_tab(
			'colors_switched',
			[
				'label' => esc_html__('Switched', 'pe-core'),
			]
		);

		$element->add_control(
			'switched_main_color',
			[
				'label' => esc_html__('Main Texts Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'body.layout--switched {{WRAPPER}} , .header--switched {{WRAPPER}} ,body.layout--switched {{WRAPPER}} .e-con , .header--switched {{WRAPPER}} .e-con' => '--mainColor: {{VALUE}}',
				],
			]
		);

		$element->add_control(
			'switched_secondary_color',
			[
				'label' => esc_html__('Secondary Texts Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'body.layout--switched {{WRAPPER}} , .header--switched {{WRAPPER}} ,body.layout--switched {{WRAPPER}} .e-con , .header--switched {{WRAPPER}} .e-con' => '--secondaryColor: {{VALUE}}',
				],
			]
		);

		$element->add_control(
			'switched_lines_color',
			[
				'label' => esc_html__('Lines Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'body.layout--switched {{WRAPPER}} , .header--switched {{WRAPPER}} ,body.layout--switched {{WRAPPER}} .e-con , .header--switched {{WRAPPER}} .e-con' => '--linesColor: {{VALUE}}',
				],
			]
		);

		$element->end_controls_tab();

		$element->end_controls_tabs();

		$element->end_controls_section();




	}

}
add_action('elementor/element/before_section_start', 'container_colors', 10, 4);

function convert_containers($element, $section_id, $args)
{

	if (('container' === $element->get_name()) && 'section_layout_additional_options' === $section_id) {

		$element->start_controls_section(
			'convert_section',
			[
				'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
				'label' => esc_html__('Convert Container', 'pe-core'),
				'condition' => ['container_type' => 'flex'],

			]
		);

		$element->add_control(
			'container_refresh_widget',
			[
				'label' => esc_html__('Refresh Container', 'pe-core'),
				'description' => esc_html__('Usefull when using pinned scroll animations. In editor if the pinned animations conflicts just refresh the widget once.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'refresh' => [
						'title' => esc_html__('Refresh Container', 'pe-core'),
						'icon' => 'eicon-sync',
					],
				],
				'default' => 'refresh',
				'render_type' => 'template',
				'toggle' => true,

			]
		);


		$element->add_control(
			'convert_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>When converting containers; create inner containers and their contents first and than select convert type, selecting convert type before building content may hard to navigate between items in the editor.</span></div>',
				'condition' => ['convert_container!' => 'convert--none'],
			]
		);


		$element->add_control(
			'convert_container',
			[
				'label' => 'Convert Container',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'convert--none' => 'None',
					'convert--layered' => 'Layered',
					'convert--carousel' => 'Carousel',
					'convert--tabs' => 'Tabs',
					'convert--accordion' => 'Accordion',
				],
				'default' => 'convert--none',
				'render_type' => 'template',
				'prefix_class' => '',
			]
		);

		$element->add_control(
			'container_carousel_id',
			[
				'label' => esc_html__('Carousel ID', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__('An id will required if the carousel controls from other widgets will be used.', 'pe-core'),
				'ai' => false,
				'prefix_class' => '',
				'condition' => ['convert_container' => 'convert--carousel'],
			]
		);


		$element->add_control(
			'container_carousel_behavior',
			[
				'label' => esc_html__('Carousel Behavior', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'cr--drag',
				'options' => [
					'cr--drag' => esc_html__('Drag', 'pe-core'),
					'cr--scroll' => esc_html__('Scroll', 'pe-core'),
				],
				'prefix_class' => '',
				'condition' => ['convert_container' => 'convert--carousel'],
			]
		);

		$element->add_responsive_control(
			'container_carousel_start',
			[
				'label' => esc_html__('Carousel Start Position', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'vw'],
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
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--carouselStart: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
				'condition' => ['container_carousel_behavior' => 'cr--scroll'],
			]
		);

		$element->add_control(
			'highligh_active_item',
			[
				'label' => esc_html__('Highlight Active', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'container--highlight--active',
				'prefix_class' => '',
				'default' => false,
				'condition' => ['convert_container' => 'convert--carousel'],
			]
		);

		$element->add_control(
			'container_carousel_trigger',
			[
				'label' => esc_html__('Carousel Trigger', 'pe-core'),
				'placeholder' => esc_html__('Eg. #worksContainer', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__('Normally the carousel pin itself but in some cases, a custom trigger may required.', 'pe-core'),
				'ai' => false,
				'prefix_class' => 'carousel_trigger_',
				'condition' => ['container_carousel_behavior' => 'cr--scroll'],
			]
		);

		$element->add_control(
			'scroll_speed',
			[
				'label' => esc_html__('Scroll Speed', 'pe-core'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'step' => 100,
				'default' => 1000,
				'prefix_class' => 'layered_speed_',
				'condition' => ['convert_container' => 'convert--layered'],
			]
		);

		$element->add_control(
			'pin_target',
			[
				'label' => esc_html__('Pin Target', 'pe-core'),
				'placeholder' => esc_html__('Eg. #worksContainer', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__('Normally the container pin itself but in some cases, a custom trigger may required.', 'pe-core'),
				'ai' => false,
				'prefix_class' => 'layered_target_',
				'condition' => ['convert_container' => 'convert--layered'],
			]
		);

		$element->add_control(
			'layered_out_animation',
			[
				'label' => esc_html__('Out Animation', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'layered_out_anim',
				'prefix_class' => '',
				'default' => false,
				'condition' => ['convert_container' => 'convert--layered'],
			]
		);

		$element->add_control(
			'cursor_drag',
			[
				'label' => esc_html__('Cursor Drag Interaction', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'cursor_drag',
				'prefix_class' => '',
				'default' => false,
				'condition' => ['convert_container' => 'convert--carousel'],
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'container_tab_title',
			[
				'label' => esc_html__('Title', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Title', 'pe-core'),
				'label_block' => true,
			]
		);

		$element->add_control(
			'container_tab_titles',
			[
				'label' => esc_html__('Tab Titles', 'pe-core'),
				'description' => esc_html__('Please enter titles in accordance with the order of the containers, ensuring that the number of titles matches the number of containers within the tabs.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'container_tab_title' => esc_html__('Title #1', 'pe-core'),
					],
					[
						'container_tab_title' => esc_html__('Title #2', 'pe-core'),
					],
				],
				'title_field' => '{{{ container_tab_title }}}',
				'condition' => ['convert_container' => 'convert--tabs'],
			]
		);

		$element->add_control(
			'tab_titles_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-control-field-description">Please enter titles in accordance with the order of the containers, ensuring that the number of titles matches the number of containers within the tabs</div>',
				'condition' => ['convert_container' => 'convert--tabs'],
			]
		);

		$element->add_responsive_control(
			'title_alignment',
			[
				'label' => esc_html__('Titles Alignment', 'pe-core'),
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
				'condition' => ['convert_container' => 'convert--tabs'],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .container--tab--titles--wrap' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$element->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'tabs_title_typography',
				'label' => esc_html__('Title Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .container--tab--title',
				'condition' => ['convert_container' => 'convert--tabs'],
			]
		);


		$element->add_responsive_control(
			'tab_titles_gap',
			[
				'label' => esc_html__('Titles Gap', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'condition' => [
					'background_type' => ['color']
				],
				'selectors' => [
					'{{WRAPPER}} .container--tab--titles--wrap' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['convert_container' => 'convert--tabs'],
			]
		);


		$element->add_control(
			'show_seperator',
			[
				'label' => esc_html__('Show Seperator', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'show--seperator',
				'default' => 'false',
				'prefix_class' => '',
				'condition' => ['convert_container' => 'convert--tabs'],

			]
		);

		$element->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'tabs_seperator_typography',
				'label' => esc_html__('Seperator Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .tabs--seperator',
				'condition' => [
					'show_seperator' => 'show--seperator',
					'convert_container' => 'convert--tabs'
				]
			]
		);


		$element->add_control(
			'accordion_type',
			[
				'label' => esc_html__('Accordion Type', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'ac--nested',
				'options' => [
					'ac--ordered' => esc_html__('Ordered', 'pe-core'),
					'ac--nested' => esc_html__('Nested', 'pe-core'),
				],
				'prefix_class' => 'container--',
				'label_block' => false,
				'condition' => ['convert_container' => 'convert--accordion'],
			]
		);

		$element->add_control(
			'open_first',
			[
				'label' => esc_html__('Active First', 'pe-core'),
				'description' => esc_html__('First item will be active as default.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'active--first',
				'default' => 'false',
				'prefix_class' => '',
				'condition' => ['convert_container' => 'convert--accordion'],

			]
		);

		$element->add_control(
			'toggle_style',
			[
				'label' => esc_html__('Toggle Style', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'toggle--plus',
				'options' => [
					'toggle--plus' => esc_html__('Plus', 'pe-core'),
					'toggle--dot' => esc_html__('Dot', 'pe-core'),
					// 'toggle--custom' => esc_html__('Custom', 'pe-core'),
				],
				'label_block' => false,
				'prefix_class' => 'ac--',
				'condition' => ['convert_container' => 'convert--accordion'],
			]
		);

		// $element->add_control(
		// 	'accordion_open_icon',
		// 	[
		// 		'label' => esc_html__('Open Icon', 'pe-core'),
		// 		'type' => \Elementor\Controls_Manager::ICONS,
		// 		'skin' => 'inline',
		// 		'separator' => 'before',
		// 		'label_block' => false,
		// 		'default' => [
		// 			'value' => 'fas fa-plus',
		// 			'library' => 'fa-solid',
		// 		],
		// 		'condition' => [
		// 			'toggle_style' => 'toggle--custom',
		// 			'convert_container' => 'convert--accordion'
		// 		]
		// 	]
		// );

		// $element->add_control(
		// 	'accordion_close_icon',
		// 	[
		// 		'label' => esc_html__('Close Icon', 'pe-core'),
		// 		'type' => \Elementor\Controls_Manager::ICONS,
		// 		'skin' => 'inline',
		// 		'separator' => 'before',
		// 		'label_block' => false,
		// 		'default' => [
		// 			'value' => 'fas fa-plus',
		// 			'library' => 'fa-solid',
		// 		],
		// 		'condition' => [
		// 			'toggle_style' => 'toggle--custom',
		// 			'convert_container' => 'convert--accordion'
		// 		]
		// 	]
		// );

		$element->add_control(
			'underlined',
			[
				'label' => esc_html__('Underlined?', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'ac--underlined',
				'default' => 'false',
				'prefix_class' => '',
				'condition' => ['convert_container' => 'convert--accordion'],
			]
		);

		$element->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'accordion_title_typography',
				'label' => esc_html__('Title Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .container--accordion--title',
				'condition' => ['convert_container' => 'convert--accordion'],
			]
		);
		$element->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'order_typography',
				'label' => esc_html__('Order Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} span.ac-order',
				'condition' => [
					'accordion_type' => 'ac--ordered',
					'convert_container' => 'convert--accordion'
				]
			]
		);

		$element->end_controls_section();



		$element->start_controls_section(
			'cursor_interactions',
			[
				'label' => __('Cursor Interactions', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
			]
		);

		$element->add_control(
			'cursor_type',
			[
				'label' => esc_html__('Interaction', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__('None', 'pe-core'),
					'default' => esc_html__('Default', 'pe-core'),
					'text' => esc_html__('Text', 'pe-core'),
					'icon' => esc_html__('Icon', 'pe-core'),
				],

			]
		);

		$element->add_control(
			'cursor_icon',
			[
				'label' => esc_html__('Icon', 'pe-core'),
				'description' => esc_html__('Only Material Icons allowed, do not select Font Awesome icons.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
				'condition' => ['cursor_type' => 'icon'],
			]
		);

		$element->add_control(
			'cursor_text',
			[
				'label' => esc_html__('Text', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => ['cursor_type' => 'text'],
			]
		);


		$element->end_controls_section();

		$element->start_controls_section(
			'container_behaviors',
			[
				'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
				'label' => esc_html__('Container Behaviors', 'pe-core'),

			]
		);

		$element->add_control(
			'build_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-danger">	
				   <span>The animation is disabled at the editor view due to performance reasons. Can be viewed only at front-end of the page. </span></div>',
				'condition' => ['build_on_scroll' => 'build--on--scroll'],
			]
		);

		$element->add_control(
			'build_on_scroll',
			[
				'label' => esc_html__('Build Grid on Scroll', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'build--on--scroll',
				'prefix_class' => '',
				'default' => false,
				'condition' => ['container_type' => 'grid'],
			]
		);

		$element->add_control(
			'build_type',
			[
				'label' => esc_html__('Build Type', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'slide-up',
				'options' => [
					'slide-up' => esc_html__('Slide Up', 'pe-core'),
					'slide-down' => esc_html__('Slide Down', 'pe-core'),
					'slide-left' => esc_html__('Slide Left', 'pe-core'),
					'slide-right' => esc_html__('Slide Right', 'pe-core'),
					'scale-up' => esc_html__('Scale Up', 'pe-core'),
					'fade' => esc_html__('Simple Fade', 'pe-core'),
				],
				'prefix_class' => 'build_type_',
				'label_block' => false,
				'condition' => [
					'build_on_scroll' => 'build--on--scroll',
					'container_type' => 'grid'
				],
			]
		);


		$element->add_control(
			'build_on_scroll_target',
			[
				'label' => esc_html__('Parent Target', 'pe-core'),
				'placeholder' => esc_html__('Eg. #worksContainer', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__('A parent container is required to make it work.', 'pe-core'),
				'ai' => false,
				'prefix_class' => 'build_pin_container_',
				'condition' => [
					'build_on_scroll' => 'build--on--scroll',
					'container_type' => 'grid'
				],
			]
		);

		$element->add_control(
			'animate_inners',
			[
				'label' => esc_html__('Animate Inner Elements', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'animate--inners',
				'prefix_class' => '',
				'default' => false,
				'condition' => [
					'build_on_scroll' => 'build--on--scroll',
					'container_type' => 'grid'
				],
			]
		);

		$element->add_control(
			'stagger_from',
			[
				'label' => esc_html__('Start From', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'start',
				'options' => [
					'start' => esc_html__('Start', 'pe-core'),
					'center' => esc_html__('Center', 'pe-core'),
					'end' => esc_html__('End', 'pe-core'),
				],
				'prefix_class' => 'stagger_from_',
				'label_block' => false,
				'condition' => [
					'build_on_scroll' => 'build--on--scroll',
					'container_type' => 'grid'
				],
			]
		);

		$element->add_control(
			'build_stagger',
			[
				'label' => esc_html__('Stagger', 'pe-core'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0.1,
				'max' => 10,
				'step' => 0.1,
				'prefix_class' => 'build_stagger_',
				'default' => 0.5,
				'condition' => [
					'build_on_scroll' => 'build--on--scroll',
					'container_type' => 'grid'
				],
			]
		);

		$element->add_control(
			'build_speed',
			[
				'label' => esc_html__('Building Speed', 'pe-core'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 20000,
				'step' => 100,
				'prefix_class' => 'build_speed_',
				'default' => 1000,
				'condition' => [
					'build_on_scroll' => 'build--on--scroll',
					'container_type' => 'grid'
				],
			]
		);

		$element->add_control(
			'parallax_container',
			[
				'label' => esc_html__('Parallax Container', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'parallax__container',
				'render_type' => 'template',
				'prefix_class' => '',
				'default' => false,
			]
		);

		$element->add_control(
			'parallax_direction',
			[
				'label' => esc_html__('Parallax Direction', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'up',
				'render_type' => 'template',
				'description' => esc_html__('Will be used as intro animation.', 'pe-core'),
				'options' => [
					'left' => esc_html__('Left', 'pe-core'),
					'right' => esc_html__('Right', 'pe-core'),
					'up' => esc_html__('Up', 'pe-core'),
					'down' => esc_html__('Down', 'pe-core'),
				],
				'prefix_class' => 'parallax_direction_',
				'label_block' => true,
				'condition' => ['parallax_container' => 'parallax__container'],
			]
		);

		$element->add_control(
			'parallax_strength',
			[
				'label' => esc_html__('Parallax Strength', 'pe-core'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'render_type' => 'template',
				'prefix_class' => 'parallax_strength_',
				'default' => 10,
				'condition' => ['parallax_container' => 'parallax__container'],
			]
		);

		$element->add_control(
			'backward_container',
			[
				'label' => esc_html__('Backward Container', 'pe-core'),
				'description' => esc_html__('The next container will come above this container at the end.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'backward__container',
				'render_type' => 'template',
				'prefix_class' => '',
				'default' => false,
			]
		);


		$element->add_control(
			'backward_mobile',
			[
				'label' => esc_html__('Backward at Mobile', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'yes',
				'prefix_class' => 'backward__mobile-',
				'default' => 'no',
				'condition' => ['backward_container' => 'backward__container'],
			]
		);

		$element->add_control(
			'pin_container',
			[
				'label' => esc_html__('Pin Container', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'true',
				'prefix_class' => 'pinned_',
				'render_type' => 'template',
				'default' => false,
			]
		);


		$element->add_control(
			'pin_container_target',
			[
				'label' => esc_html__('Pin Target', 'pe-core'),
				'placeholder' => esc_html__('Eg. #worksContainer', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__('Leave it empty if you want to pin container to body.', 'pe-core'),
				'ai' => false,
				'prefix_class' => 'pin_container_',
				'condition' => ['pin_container' => 'true'],
			]
		);

		$element->add_control(
			'ct_pin_mobile',
			[
				'label' => esc_html__('Pin Mobile', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'true',
				'default' => '',
				'render_type' => 'template',
				'condition' => ['pin_container' => 'true'],
			]
		);

		$element->add_control(
			'container_pin_header',
			[
				'label' => esc_html__('Disable Header Pinning', 'pe-core'),
				'description' => esc_html__('Normally the pin keeps header until completed if it starts on top of the page, you can disable header pin setting this option to "yes".', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'true',
				'default' => '',
				'render_type' => 'template',
				'prefix_class' => 'header--pin--disabled--',
				'condition' => ['pin_container' => 'true'],
			]
		);


		$element->add_control(
			'ct_element_start_references',
			[
				'label' => esc_html__('Start References', 'pe-core'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => ['pin_container' => 'true'],
			]
		);

		$element->add_control(
			'ct_element_references_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>	
				   This references below are adjusts the pinning start/end positions on the screen. <b>For Example: If you select <u>'Top' for item reference point</u> and <u>'Bottom' for the window reference point</u>; pinning will start when item's top edge enters the window's bottom edge.</b></div>",
				'condition' => ['pin_container' => 'true'],


			]
		);

		$element->add_control(
			'ct_element_start_offset',
			[
				'label' => esc_html__('Start Offset', 'pe-core'),
				'description' => esc_html__('An offset value (px) which will be added to pinning start position. Usefull if you are using a fixed,/sticky header.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -1000,
				'max' => 1000,
				'step' => 1,
				'default' => 0,
				'condition' => ['pin_container' => 'true'],
			]
		);

		$element->add_control(
			'ct_element_item_ref_start',
			[
				'label' => esc_html__('Item Reference Point', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__('Top', 'pe-core'),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__('Center', 'pe-core'),
						'icon' => 'eicon-v-align-middle'
					],
					'bottom' => [
						'title' => esc_html__('Bottom', 'pe-core'),
						'icon' => ' eicon-v-align-bottom',
					],
				],
				'render_type' => 'template',
				'default' => 'center',
				'toggle' => false,
				'condition' => ['pin_container' => 'true'],
			]
		);

		$element->add_control(
			'ct_element_window_ref_start',
			[
				'label' => esc_html__('Window Reference Point', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__('Top', 'pe-core'),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__('Center', 'pe-core'),
						'icon' => 'eicon-v-align-middle'
					],
					'bottom' => [
						'title' => esc_html__('Bottom', 'pe-core'),
						'icon' => ' eicon-v-align-bottom',
					],
				],
				'render_type' => 'template',
				'default' => 'center',
				'toggle' => false,
				'condition' => ['pin_container' => 'true'],
			]
		);

		$element->add_control(
			'ct_element_end_references',
			[
				'label' => esc_html__('End References', 'pe-core'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => ['pin_container' => 'true'],
			]
		);

		$element->add_control(
			'ct_element_item_ref_end',
			[
				'label' => esc_html__('Item Reference Point', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__('Top', 'pe-core'),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__('Center', 'pe-core'),
						'icon' => 'eicon-v-align-middle'
					],
					'bottom' => [
						'title' => esc_html__('Bottom', 'pe-core'),
						'icon' => ' eicon-v-align-bottom',
					],
				],
				'render_type' => 'template',
				'default' => 'bottom',
				'toggle' => false,
				'condition' => ['pin_container' => 'true'],
			]
		);

		$element->add_control(
			'ct_element_window_ref_end',
			[
				'label' => esc_html__('Window Reference Point', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__('Top', 'pe-core'),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__('Center', 'pe-core'),
						'icon' => 'eicon-v-align-middle'
					],
					'bottom' => [
						'title' => esc_html__('Bottom', 'pe-core'),
						'icon' => ' eicon-v-align-bottom',
					],
				],
				'render_type' => 'template',
				'default' => 'top',
				'toggle' => false,
				'condition' => ['pin_container' => 'true'],
			]
		);


		$element->add_control(
			'highlight_inners',
			[
				'label' => esc_html__('Highlight Inners', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'description' => esc_html__('Inner elements of this container will be highlighted on scroll.', 'pe-core'),
				'return_value' => 'highlight--inners',
				'render_type' => 'template',
				'prefix_class' => '',
				'default' => '',
				'condition' => ['pin_container' => 'true'],
			]
		);



		$element->end_controls_section();


	}

}
add_action('elementor/element/before_section_start', 'convert_containers', 10, 4);

function container_animations($element, $section_id, $args)
{
	if (('section' === $element->get_name() || 'container' === $element->get_name()) && 'section_layout_additional_options' === $section_id) {
		pe_general_animation_settings($element, \Elementor\Controls_Manager::TAB_LAYOUT, true);
	}

}
add_action('elementor/element/before_section_start', 'container_animations', 10, 3);

function container_notice($element, $section_id, $args)
{
	if (('container' === $element->get_name()) && 'section_layout_container' === $section_id) {

		$element->add_control(
			'converted_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-danger">	
				   <span>This container has been converted. You can view converting preferences via <u>"Convert Container"</u> section below.</span></div>',
				'condition' => ['convert_container!' => 'convert--none'],
			]
		);

	}

	if (('container' === $element->get_name()) && 'section_layout_additional_options' === $section_id) {

		$element->add_control(
			'container_title',
			[
				'label' => esc_html__('Container Title', 'pe-core'),
				'label_block' => true,
				'render_type' => 'template',
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter container title here.', 'pe-core'),
				'description' => esc_html__('If this container is a sub-element of a container that has been converted to an accordion or tab, a title must be entered.', 'pe-core'),
				'ai' => false

			]
		);

	}
}
add_action('elementor/element/after_section_start', 'container_notice', 10, 4);

function widget_header_visibility($element, $section_id, $args)
{
	if (('container' !== $element->get_name()) && '_section_style' === $section_id) {

		$element->add_control(
			'widget_header_visibility',
			[
				'label' => esc_html__('Widget Visibility (for Headers)', 'pe-core'),
				'description' => esc_html__('Affective only if the container used in an header template.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'always--show',
				'label_block' => true,
				'prefix_class' => 'wd--',
				'options' => [
					'always--show' => esc_html__('Default', 'pe-core'),
					'show--sticky' => esc_html__('When heeader stkicked/fixed.', 'pe-core'),
					'show--on--top' => esc_html__('When header on top.', 'pe-core'),
				],
			]
		);

		$element->add_control(
			'get_widget_state',
			[
				'label' => esc_html__('Get State on Move', 'pe-core'),
				'description' => esc_html__('Usefull if you want to adjust element position on header move.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'element--get--state',
				'default' => '',
				'prefix_class' => '',
				'condition' => [
					'widget_header_visibility' => 'always--show'
				]
			]
		);

		$element->add_control(
			'disable_visibility_at_mobile',
			[
				'label' => esc_html__('Disable Visiblity at Mobile', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'vis--disabled--at--mobile',
				'default' => '',
				'prefix_class' => '',
				'condition' => [
					'widget_header_visibility!' => 'always--show'
				]
			]
		);

	}

}
add_action('elementor/element/before_section_end', 'widget_header_visibility', 10, 4);

function container_additional_settings($element, $section_id, $args)
{

	if ('container' === $element->get_name() && 'section_layout_additional_options' === $section_id) {

		$element->add_control(
			'nav_visibility',
			[
				'label' => esc_html__('Show Container:', 'pe-core'),
				'description' => esc_html__('Affective only if the container used in an header template.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'always--show',
				'prefix_class' => 'wd--',
				'options' => [
					'always--show' => esc_html__('Always', 'pe-core'),
					'show--sticky' => esc_html__('When heeader stkicked/fixed.', 'pe-core'),
					'show--on--top' => esc_html__('When header on top.', 'pe-core'),
				],
			]
		);

		$element->add_control(
			'get_container_state',
			[
				'label' => esc_html__('Get State on Move', 'pe-core'),
				'description' => esc_html__('Usefull if you want to adjust element position on header move.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'element--get--state',
				'default' => '',
				'prefix_class' => '',
				'condition' => [
					'nav_visibility' => 'always--show'
				]
			]
		);

		$element->add_control(
			'disable_visibility_at_mobile',
			[
				'label' => esc_html__('Disable Visiblity at Mobile', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'vis--disabled--at--mobile',
				'default' => '',
				'prefix_class' => '',
				'condition' => [
					'nav_visibility!' => 'always--show'
				]
			]
		);

		$element->add_control(
			'pointer_events',
			[
				'label' => esc_html__('Pointer Events', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'auto',
				'prefix_class' => 'container--pointer--events--',
				'options' => [
					'auto' => esc_html__('Auto', 'pe-core'),
					'all' => esc_html__('All', 'pe-core'),
					'none' => esc_html__('None', 'pe-core'),
				],
			]
		);

	}

}
add_action('elementor/element/after_section_start', 'container_additional_settings', 10, 3);

function container_background_settings($element, $section_id, $args)
{

	if ('container' === $element->get_name() && 'section_background' === $section_id) {

		$element->add_control(
			'pe_background_sec',
			[
				'label' => esc_html__('Theme Backgrounds', 'pe-core'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$element->add_control(
			'background_type',
			[
				'label' => 'Background Type',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'color' => 'Color',
					'gradient' => 'Gradient',
					'video' => 'Video',
					'image' => 'Image',
				],
				'default' => 'none',
				'prefix_class' => 'bg--',
			]
		);

		$element->add_control(
			'cont_background_image',
			[
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'background_type' => 'image',
				],
			]
		);

		$element->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'cont_background_image_size', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => ['custom'],
				'include' => [],
				'default' => 'large',
				'condition' => [
					'background_type' => 'image',
				],
			]
		);

		$element->add_control(
			'bg_behavior',
			[
				'label' => 'Background Behavior',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'static' => 'Static',
					'parallax' => 'Parallax',
					'zoom-in' => 'Zoom In',
					'zoom-out' => 'Zoom Out',
				],
				'default' => 'static',
				'render_type' => 'template',
				'prefix_class' => 'bg--behavior--',
				'condition' => [
					'background_type' => ['image']
				]
			]
		);

		$element->add_control(
			'transparent_bg',
			[
				'label' => esc_html__('Transparent Image', 'pe-core'),
				'description' => esc_html__('Switch this "On" if you uploaded an image with alpha channel (such as PNG, WEBP..)', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'true',
				'default' => 'false',
				'prefix_class' => 'bg_transparent_',
				'condition' => [
					'background_type' => ['image']
				]

			]
		);

		$element->add_control(
			'fixed_bg',
			[
				'label' => esc_html__('Fixed Background', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'true',
				'default' => 'false',
				'render_type' => 'template',
				'prefix_class' => 'bg_fixed_',
				'condition' => [
					'background_type' => ['image', 'video']
				]

			]
		);

		$element->add_responsive_control(
			'bg_position',
			[
				'label' => esc_html__('Background Position', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__('Top', 'pe-core'),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__('Middle', 'pe-core'),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__('Bottom', 'pe-core'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => true,
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .container--bg .cont--bg--wrap img' => 'object-position: {{VALUE}};',
				],
				'condition' => [
					'background_type' => ['image']
				]
			]
		);


		$element->add_control(
			'video_provider',
			[
				'label' => 'Video Provider',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'self' => 'Self',
					'vimeo' => 'Vimeo',
					'youtube' => 'Youtube',
				],
				'default' => 'self',
				'prefix_class' => '',
				'condition' => [
					'background_type' => ['video']
				]
			]
		);

		$element->add_control(
			'sec_video',
			[
				'label' => esc_html__('Choose Video', 'pe-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => ['mp4'],

				'condition' => [
					'video_provider' => ['self'],
					'background_type' => ['video']
				]
			]
		);

		$element->add_control(
			'youtube_id',
			[
				'label' => esc_html__('Video ID', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__('Youtube video ID', 'pe-core'),
				'condition' => [
					'video_provider' => ['youtube'],
					'background_type' => ['video']

				]

			]
		);

		$element->add_control(
			'vimeo_id',
			[
				'label' => esc_html__('Video ID', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__('Vimeo video ID', 'pe-core'),
				'condition' => [
					'video_provider' => ['vimeo'],
					'background_type' => ['video']
				]

			]
		);

		$element->add_control(
			'video_poster',
			[
				'label' => esc_html__('Video Poster', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'true',
				'default' => 'false',
				'condition' => [

					'background_type' => ['video']
				]
			]
		);

		$element->add_control(
			'poster_image',
			[
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'video_poster' => ['true'],
				],
			]
		);



		$element->start_controls_tabs(
			'bg_color_Tabs'
		);

		$element->start_controls_tab(
			'bg_default',
			[
				'label' => esc_html__('Default', 'pe-core'),
				'condition' => [
					'background_type' => ['color']
				]
			]
		);

		$element->add_control(
			'main_background',
			[
				'label' => esc_html__('Main Background', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--mainBackground: {{VALUE}} !important',
				],
				'condition' => [
					'background_type' => ['color']
				]

			]
		);

		$element->add_control(
			'secondary_background',
			[
				'label' => esc_html__('Secondary Background', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--secondaryBackground: {{VALUE}} !important',
				],
				'condition' => [
					'background_type' => ['color']
				]

			]
		);


		$element->end_controls_tab();

		$element->start_controls_tab(
			'bg_switched',
			[
				'label' => esc_html__('Switched', 'pe-core'),
				'condition' => [
					'background_type' => ['color']
				]
			]
		);

		$element->add_control(
			'switched_main_background',
			[
				'label' => esc_html__('Main Background', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.header--switched {{WRAPPER}} , .header--switched {{WRAPPER}} .e-con' => '--mainBackground: {{VALUE}} !important',
					'body.layout--switched {{WRAPPER}}' => '--mainBackground: {{VALUE}} !important',
					'body.layout--switched .reverse__' . $element->get_id() => '--mainBackground: {{VALUE}} !important',
				],
				'condition' => [
					'background_type' => ['color']
				]

			]
		);

		$element->add_control(
			'switched_secondary_background',
			[
				'label' => esc_html__('Secondary Background', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.header--switched {{WRAPPER}} , .header--switched {{WRAPPER}} .e-con' => '--secondaryBackground: {{VALUE}} !important',
					'body.layout--switched {{WRAPPER}}' => '--secondaryBackground: {{VALUE}} !important',
				],
				'condition' => [
					'background_type' => ['color']
				]

			]
		);


		$element->end_controls_tab();

		$element->end_controls_tabs();


		$element->add_control(
			'bg_backdrop',
			[
				'label' => esc_html__('Backdrop Filter', 'pe-core'),
				'description' => esc_html__('For "classic" background type only.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'true',
				'default' => 'false',
				'render_type' => 'template',
				'prefix_class' => 'bg_backdrop_',
				'condition' => [
					'background_type' => ['color']
				]

			]
		);

		$element->add_responsive_control(
			'bg_backdrop_blur',
			[
				'label' => esc_html__('Bluriness', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'condition' => [
					'background_type' => 'color',
					'bg_backdrop' => 'true',
				],
				'selectors' => [
					'{{WRAPPER}}' => '--backdropBlur: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->add_control(
			'curved_bg',
			[
				'label' => esc_html__('Curved Background', 'pe-core'),
				'description' => esc_html__('For "classic" background type only.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'true',
				'default' => 'false',
				'render_type' => 'template',
				'prefix_class' => 'curved_',
				'condition' => [
					'background_type' => ['color']
				]

			]
		);

		$element->add_responsive_control(
			'curves',
			[
				'label' => esc_html__('Curves', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__('Top', 'pe-core'),
						'icon' => 'eicon-v-align-top',
					],
					'both' => [
						'title' => esc_html__('Both', 'pe-core'),
						'icon' => 'eicon-justify-space-between-v'
					],
					'bottom' => [
						'title' => esc_html__('Bottom', 'pe-core'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'both',
				'condition' => [
					'curved_bg' => ['true']
				]
			]
		);

		$element->add_responsive_control(
			'curve',
			[
				'label' => esc_html__('Curve Size', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 75,
				],
				'condition' => [
					'curved_bg' => ['true']
				],
				'selectors' => [
					'{{WRAPPER}} .bg--reverse-layer' => '--curveWidth: {{SIZE}}{{UNIT}};--curveHeight: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$element->add_control(
			'gradient_type',
			[
				'label' => __('Gradient Type', 'saren'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'linear',
				'options' => [
					'linear' => __('Linear', 'saren'),
					'radial' => __('Radial', 'saren'),
				],
				'condition' => [
					'background_type' => ['gradient']
				]
			]
		);

		$element->add_control(
			'color_1',
			[
				'label' => __('Color 1', 'saren'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ff0000',
				'condition' => [
					'background_type' => ['gradient']
				]
			]
		);

		$element->add_control(
			'color_1_location',
			[
				'label' => __('Color 1 Location', 'saren'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'condition' => [
					'background_type' => ['gradient']
				]
			]
		);

		$element->add_control(
			'color_2',
			[
				'label' => __('Color 2', 'saren'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#0000ff',
				'condition' => [
					'background_type' => ['gradient']
				]
			]
		);

		$element->add_control(
			'color_2_location',
			[
				'label' => __('Color 2 Location', 'saren'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'condition' => [
					'background_type' => ['gradient']
				]
			]
		);

		$element->add_control(
			'gradient_angle',
			[
				'label' => __('Gradient Angle', 'saren'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'deg' => [
						'min' => 0,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'deg',
					'size' => 45,
				],
				'condition' => [
					'background_type' => ['gradient'],
					'gradient_type' => 'linear',
				]
			]
		);

		$element->add_control(
			'gradient_position',
			[
				'label' => __('Radial Gradient Position', 'saren'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'center' => __('Center', 'saren'),
					'top left' => __('Top Left', 'saren'),
					'top right' => __('Top Right', 'saren'),
					'bottom left' => __('Bottom Left', 'saren'),
					'bottom right' => __('Bottom Right', 'saren'),
				],
				'default' => 'center',
				'condition' => [
					'background_type' => ['gradient'],
					'gradient_type' => 'radial',
				]
			]
		);

		$element->add_control(
			'animated_gradient',
			[
				'label' => __('Animated Gradient?', 'saren'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'saren'),
				'label_off' => __('No', 'saren'),
				'default' => 'no',
				'render_type' => 'template',
				'return_value' => 'animated--gradient',
				'prefix_class' => '',
				'condition' => [
					'background_type' => ['gradient']
				]
			]
		);

		$element->add_control(
			'gradient_animation_duration',
			[
				'label' => esc_html__('Animation Speed', 'pe-core'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'default' => 5,
				'render_type' => 'template',
				'prefix_class' => 'gradient_animation_duration_',
				'condition' => [
					'background_type' => ['gradient'],
					'animated_gradient' => 'animated--gradient',
				]
			]
		);


		$element->add_control(
			'color_3',
			[
				'label' => __('Color 3 (Animated Gradient)', 'saren'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#00ff00',
				'condition' => [
					'background_type' => ['gradient'],
					'animated_gradient' => 'animated--gradient',
				]
			]
		);

		$element->add_control(
			'color_3_location',
			[
				'label' => __('Color 3 Location (Animated Gradient)', 'saren'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'condition' => [
					'background_type' => ['gradient'],
					'animated_gradient' => 'animated--gradient', // Sadece animasyonlu gradient için
				]
			]
		);

		$element->add_control(
			'color_4',
			[
				'label' => __('Color 4 (Animated Gradient)', 'saren'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ff00ff',
				'condition' => [
					'background_type' => ['gradient'],
					'animated_gradient' => 'animated--gradient', // Sadece animasyonlu gradient için
				]
			]
		);

		$element->add_control(
			'color_4_location',
			[
				'label' => __('Color 4 Location (Animated Gradient)', 'saren'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'condition' => [
					'background_type' => ['gradient'],
					'animated_gradient' => 'animated--gradient', // Sadece animasyonlu gradient için
				]
			]
		);

		$element->add_control(
			'gradient_angle_animated',
			[
				'label' => __('Gradient Angle (Animated Gradient)', 'saren'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'deg' => [
						'min' => 0,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'deg',
					'size' => 45,
				],
				'condition' => [
					'background_type' => ['gradient'],
					'animated_gradient' => 'animated--gradient',
					'gradient_type' => 'linear', // Yalnızca linear için göster
				]
			]
		);

		$element->add_control(
			'gradient_position_animated',
			[
				'label' => __('Radial Gradient Position (Animated Gradient)', 'saren'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'center' => __('Center', 'saren'),
					'top left' => __('Top Left', 'saren'),
					'top right' => __('Top Right', 'saren'),
					'bottom left' => __('Bottom Left', 'saren'),
					'bottom right' => __('Bottom Right', 'saren'),
				],
				'default' => 'center',
				'condition' => [
					'background_type' => ['gradient'],
					'animated_gradient' => 'animated--gradient',
					'gradient_type' => 'radial', // Yalnızca radial için göster
				]
			]
		);

		$element->add_control(
			'adjust_margins',
			[
				'label' => esc_html__('Adjust Margins', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'adjust--margins',
				'default' => '',
				'prefix_class' => '',
				'condition' => [
					'curved_bg' => ['true']
				],
			]
		);

		$element->add_control(
			'background_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>	
	           <span>If you use Elementor's default background settings for a background adjustment, you won't be able to use some theme features for this container. For example, curved backgrounds, color changes in layout switch, etc</span></div>",
				'condition' => [
					'background_background' => ['classic', 'gradient', 'video', 'slideshow'],
				],

			]
		);

		$element->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'cont_bg_filters',
				'selector' => '{{WRAPPER}} .container--bg',
				'condition' => [
					'background_type!' => ['none']
				]
			]
		);

		$element->add_control(
			'elementor_bg_notice',
			[
				'label' => esc_html__('Elementor Backgrounds', 'pe-core'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);




	}

	if ('container' === $element->get_name() && 'section_border' === $section_id) {

		$element->add_control(
			'animate_radius',
			[
				'label' => esc_html__('Animate Radius', 'pe-core'),
				'description' => esc_html__('For "classic" background type only.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'animate--radius',
				'default' => 'no',
				'prefix_class' => '',
				'render_type' => 'template',

			]
		);


	}

	if ('container' === $element->get_name() && 'section_border' === $section_id) {

		$element->add_control(
			'integared_width',
			[
				'label' => esc_html__('Intergrate Width', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'yes',
				'default' => 'no',
				'render_type' => 'template',

			]
		);


	}


}
add_action('elementor/element/after_section_start', 'container_background_settings', 10, 3);

function container_attributes($element)
{

	if ($element->get_settings('integared_width') === 'yes') {

		$element->add_render_attribute(
			'_wrapper',
			[
				'class' => 'integared--width',

			]
		);

	}
	if ($element->get_settings('convert_container') === 'convert--carousel') {

		$element->add_render_attribute(
			'_wrapper',
			[
				'class' => $element->get_settings('container_carousel_behavior') . ' carousel_id_' . $element->get_settings('container_carousel_id'),
				'data-carousel-id' => $element->get_settings('container_carousel_id') ? $element->get_settings('container_carousel_id') : 'cr--' . $element->get_id(),
				'data-trigger' => $element->get_settings('container_carousel_trigger')

			]
		);

	}

	if ($element->get_settings('cursor_type') !== 'none') {

		ob_start();

		\Elementor\Icons_Manager::render_icon($element->get_settings('cursor_icon'), ['aria-hidden' => 'true']);

		$cursorIcon = ob_get_clean();

		$element->add_render_attribute(
			'_wrapper',
			[
				'data-cursor' => "true",
				'data-cursor-type' => $element->get_settings('cursor_type'),
				'data-cursor-text' => $element->get_settings('cursor_text'),
				'data-cursor-icon' => $cursorIcon,

			]
		);


	}

	if ($element->get_settings('select_animation') !== 'none') {

		// Animations 
		$out = $element->get_settings('animate_out') ? $element->get_settings('animate_out') : 'false';

		$dataset = '{' .
			'duration=' . $element->get_settings('duration') . '' .
			';delay=' . $element->get_settings('delay') . '' .
			';stagger=' . $element->get_settings('stagger') . '' .
			';pin=' . $element->get_settings('pin') . '' .
			';mobilePin=' . $element->get_settings('mobile_pin') . '' .
			';pinTarget=' . $element->get_settings('pinned_target') . '' .
			';scrub=' . $element->get_settings('scrub') . '' .
			';item_ref_start=' . $element->get_settings('item_ref_start') . '' .
			';window_ref_start=' . $element->get_settings('window_ref_start') . '' .
			';item_ref_end=' . $element->get_settings('item_ref_end') . '' .
			';window_ref_end=' . $element->get_settings('window_ref_end') . '' .
			';start_scale=' . $element->get_settings('gen_start_scale') . '' .
			';end_scale=' . $element->get_settings('gen_end_scale') . '' .
			';out=' . $out . '' .
			'}';

		$checkMarkers = '';

		if (\Elementor\Plugin::$instance->editor->is_edit_mode() && $element->get_settings('show_markers')) {
			$checkMarkers = ' markers-on';
		}

		$animation = $element->get_settings('select_animation') !== 'none' ? $element->get_settings('select_animation') : '';

		//Scroll Button Attributes
		$element->add_render_attribute(
			'_wrapper',
			[
				'data-anim-general' => 'true',
				'data-animation' => $animation,
				'data-settings' => $dataset,
			]
		);

	}

	if ($element->get_settings('container_title')) {

		//Scroll Button Attributes
		$element->add_render_attribute(
			'_wrapper',
			[
				'data-title' => $element->get_settings('container_title'),
			]
		);

	}

	if ($element->get_settings('pin_container') === 'true') {

		$start = $element->get_settings('ct_element_item_ref_start') . ' ' . $element->get_settings('ct_element_window_ref_start') . '+=' . $element->get_settings('ct_element_start_offset');
		$end = $element->get_settings('ct_element_item_ref_end') . ' ' . $element->get_settings('ct_element_window_ref_end');

		$element->add_render_attribute(
			'_wrapper',
			[
				'data-pin-start' => $start,
				'data-pin-end' => $end,
				'data-pin-mobile' => $element->get_settings('ct_pin_mobile'),

			]
		);

	}

	// if ($element->get_settings('convert_container') === 'convert--accordion') {


	// 	$element->add_render_attribute(
	// 		'_wrapper',
	// 		[
	// 			'data-accordion-length' => count($element->get_children()),
	// 		]
	// 	);

	// }



}
add_action('elementor/frontend/container/before_render', 'container_attributes');


function container_backgrounds($element)
{
	$id = $element->get_id();
	$settings = $element->get_settings_for_display();
	if ($element->get_settings('background_type') === 'video') {
		$provider = $element->get_settings('video_provider');

		if ($provider === 'vimeo') {

			$video_id = $element->get_settings('vimeo_id');

		} else if ($provider === 'youtube') {

			$video_id = $element->get_settings('youtube_id');
		} else {

			$video_id = false;
		}
		?>
		<div class="container--bg bg--for--<?php echo $id ?>">

			<div class="pe-video n-<?php echo $provider; ?> no-interactions" data-controls="false" data-autoplay=true
				data-muted=true data-loop=true>

				<?php if ($settings['video_poster'] === 'true') { ?>

					<div class="pe--video--poster">

						<?php
						echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'full', 'poster_image');
						?>

					</div>

				<?php } ?>


				<?php if ($provider !== 'self') { ?>

					<div class="p-video" data-plyr-provider="<?php echo $provider; ?>" data-plyr-embed-id="<?php echo $video_id ?>">
					</div>

				<?php } else { ?>

					<video autoplay muted playsinline loop class="p-video">
						<source src="<?php echo $element->get_settings('sec_video')['url']; ?>">
					</video>

				<?php } ?>
			</div>

		</div>

		<?php

	} else if ($element->get_settings('background_type') === 'image') { ?>
			<div class="container--bg bg--for--<?php echo $id ?>">
				<div class="cont--bg--wrap">
				<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($element->get_settings_for_display(), 'cont_background_image_size', 'cont_background_image'); ?>
				</div>
			</div>

	<?php } else if ($element->get_settings('background_type') === 'gradient') {

		$gradient_type = $settings['gradient_type'];
		$color_1 = $settings['color_1'];
		$color_1_location = $settings['color_1_location']['size'];
		$color_2 = $settings['color_2'];
		$color_2_location = $settings['color_2_location']['size'];

		if ($settings['gradient_type'] === 'linear') {

			$gradientBeh = $settings['gradient_angle']['size'] . 'deg';
		} else {
			$gradientBeh = 'at ' . $settings['gradient_position'];
		}
		$gradient_css_1 = "{$gradient_type}-gradient({$gradientBeh}, {$color_1} {$color_1_location}%, {$color_2} {$color_2_location}%)";

		if (isset($settings['animated_gradient']) && $settings['animated_gradient'] === 'animated--gradient') {
			$color_3 = $settings['color_3'];
			$color_3_location = $settings['color_3_location']['size'];
			$color_4 = $settings['color_4'];
			$color_4_location = $settings['color_4_location']['size'];
			$gradient_angle_animated = $settings['gradient_angle_animated']['size'];

			if ($settings['gradient_type'] === 'linear') {
				$gradientBeh2 = $settings['gradient_angle_animated']['size'] . 'deg';
			} else {
				$gradientBeh2 = 'at ' . $settings['gradient_position_animated'];
			}

			$gradient_css_2 = "{$gradient_type}-gradient({$gradientBeh}, {$color_3} {$color_3_location}%, {$color_4} {$color_4_location}%)";

			$b2_gradient = "--b2: {$gradient_css_2};";
		} else {
			$b2_gradient = '';
		}

		?>

				<div style="--b1: <?php echo $gradient_css_1 ?>; <?php echo $b2_gradient ?>"
					class="container--bg cont--bg--gradient <?php echo isset($settings['animated_gradient']) && $settings['animated_gradient'] === 'yes' ? 'animated' : ''; ?> bg--for--<?php echo $id ?>">
				</div>

	<?php }

	if ($element->get_settings('curved_bg') === 'true' && $element->get_settings('background_type') === 'color' && $element->get_settings('curves') !== 'bottom') {

		$size = $element->get_settings('curve')['size'] . $element->get_settings('curve')['unit'];

		echo '<div style="--curveMargin:' . $size . '" class="reverse--hold rh--top ' . $element->get_settings('adjust_margins') . ' reverse__' . $element->get_id() . '"><span style="--curveWidth:' . $size . ';--curveHeight:' . $size . '" class="bg--reverse-layer rl-top rl-left"></span>';
		echo '<span  style="--curveWidth:' . $size . ';--curveHeight:' . $size . '"class="bg--reverse-layer rl-top rl-right"></span></div>';

	}

	if ($element->get_settings('convert_container') === 'convert--tabs') { ?>

		<div class="container--tab--titles--wrap container--tab--titles__<?php echo $element->get_id(); ?>">
			<?php foreach ($element->get_settings('container_tab_titles') as $key => $title) {
				$key++;
				$seperator = '<span class="tabs--seperator">/</span>';
				$active = $key == 1 ? 'active' : '';

				echo '<div class="container--tab--title ' . $active . '" data-index="' . $key . '">' . $title['container_tab_title'] . '</div>' . $seperator;
			} ?>

		</div>
		<?php

	}

	if ($element->get_settings('container_title')) { ?>

		<div class="container--accordion--title" data-id="<?php echo $element->get_id(); ?>">

			<span class="ac-order">1</span>

			<?php echo $element->get_settings('container_title') ?>

			<!-- <span class="accordion-toggle toggle--custom"> -->

			<!-- toggle custom  -->
			<!-- <span class="ac--togle ac-toggle-open"></span> -->

			<!-- <span class="ac--togle ac-toggle-close"></span> -->
			<!-- toggle custom  -->
			<!-- </span> -->

			<span class="accordion-toggle toggle--plus">

				<!-- toggle plus  -->
				<span></span>
				<span></span>
				<!-- toggle plus  -->
			</span>

			<span class="accordion-toggle toggle--dot">

				<!-- toggle dot  -->
				<span></span>
				<!-- toggle dot  -->

			</span>

		</div>

		<?php
	}

}
add_action('elementor/frontend/container/before_render', 'container_backgrounds');

function reverse_backgrounds($element)
{

	if ($element->get_settings('curved_bg') === 'true' && $element->get_settings('background_type') === 'color' && $element->get_settings('curves') !== 'top') {

		$size = $element->get_settings('curve')['size'] . $element->get_settings('curve')['unit'];

		echo '<div style="--curveMargin:' . $size . '" class="reverse--hold rh--bottom ' . $element->get_settings('adjust_margins') . ' reverse__' . $element->get_id() . '"><span style="--curveWidth:' . $size . ';--curveHeight:' . $size . '" class="bg--reverse-layer rl-bottom rl-left"></span>';
		echo '<span style="--curveWidth:' . $size . ';--curveHeight:' . $size . '" class="bg--reverse-layer rl-bottom rl-right"></span></div>';
	}

}
add_action('elementor/frontend/container/after_render', 'reverse_backgrounds');

function container_render($template, $element)
{

	ob_start();

	?>

	<# if ( 'true'===settings.pin_container ) { let start=settings.ct_element_item_ref_start + ' ' +
		settings.ct_element_window_ref_start + '+=' +settings.ct_element_start_offset, end=settings.ct_element_item_ref_end
	+ ' ' + settings.ct_element_window_ref_end, pinMobile=settings.ct_pin_mobile; #>

		<div class="container--pin--sett" data-pin-start="{{start}}" data-pin-end="{{end}}" data-pin-mobile="{{pinMobile}}">
		</div>

		<# } #>

			<# if ( 'true'===settings.curved_bg && 'color'===settings.background_type && 'bottom' !==settings.curves ) { #>
				<div class="reverse--hold">
					<span class="bg--reverse-layer rl-top rl-left"></span>
					<span class="bg--reverse-layer rl-top rl-right"></span>
				</div>
				<# } #>

					<# if ( 'video'===settings.background_type ) { let provider=settings.video_provider; if
						(provider==='vimeo' ) { var video_id=settings.vimeo_id; } else if (provider==='youtube' ) { var
						video_id=settings.youtube_id; } else { var video_id=false; } let poster=settings.video_poster; #>

						<div class="container--bg">

							<div class="pe-video n-{{provider}} no-interactions" data-controls="false" data-autoplay=true
								data-muted=true data-loop=true>

								<# if ( 'true'===poster ) { #>

									<div class="pe--video--poster">
										<img src="{{settings.poster_image.url}}">
									</div>

									<# } #>

										<# if ( 'self' !==provider ) { #>

											<div class="p-video" data-plyr-provider="{{provider}}"
												data-plyr-embed-id="{{video_id}}">
											</div>

											<# } else { #>

												<video autoplay muted playsinline loop class="p-video">
													<source src="{{settings.sec_video.url}}">
												</video>

												<# } #>
							</div>

						</div>
						<# } else if ('image'===settings.background_type) { #>

							<div class="container--bg">
								<div class="cont--bg--wrap">
									<img src="{{settings.cont_background_image.url}}">
								</div>
							</div>

							<# } else if ('gradient'===settings.background_type) { let gradient_type=settings.gradient_type;
								let color_1=settings.color_1; let color_1_location=settings.color_1_location.size; let
								color_2=settings.color_2; let color_2_location=settings.color_2_location.size; let
								color_3=settings.color_3; let color_3_location=settings.color_3_location.size; let
								color_4=settings.color_4; let color_4_location=settings.color_4_location.size; let
								gradient_beh; let gradient_beh2; if (settings.gradient_type==='linear' ) {
								gradient_beh=settings.gradient_angle.size + 'deg' ;
								gradient_beh2=settings.gradient_angle.size + 'deg' ; } else { gradient_beh='at ' +
								settings.gradient_position; gradient_beh2='at ' + settings.gradient_position_animated; } #>

								<div style="--b1:{{gradient_type}}-gradient({{gradient_beh}}, {{color_1}}
								{{color_1_location}}%, {{color_2}} {{color_2_location}}%);--b2:{{gradient_type}}-gradient({{gradient_beh2}}, {{color_3}}
								{{color_3_location}}%, {{color_4}} {{color_4_location}}%)" class="container--bg cont--bg--gradient">
								</div>

								<# } #>

									<?php

									$acc = ob_get_clean();

									ob_start(); ?>

									<# if ( 'true'===settings.curved_bg && 'color'===settings.background_type && 'top'
										!==settings.curves ) { #>

										<div class="reverse--hold">
											<span class="bg--reverse-layer rl-bottom rl-left"></span>
											<span class="bg--reverse-layer rl-bottom rl-right"></span>
										</div>
										<# } #>

											<?php $dcc = ob_get_clean();

											ob_start(); ?>
											<# if ( 'none' !==settings.select_animation ) { let
												anim=settings.select_animation, duration=settings.duration,
												delay=settings.delay, stagger=settings.stagger, pin=settings.pin,
												pinTarget=settings.pinned_target, scrub=settings.scrub,
												item_ref_start=settings.item_ref_start,
												window_ref_start=settings.window_ref_start,
												item_ref_end=settings.item_ref_end, window_ref_end=settings.window_ref_end,
												start_scale=settings.gen_start_scale, end_scale=settings.gen_end_scale,
												out=settings.animate_out; #>
												<div hidden class="container--anim--hold" data-anim-general=true
													data-animation="{{anim}}"
													data-settings="{duration={{duration}};delay={{delay}};stagger={{stagger}};pin={{pin}};pinTarget={{pinTarget}};scrub={{scrub}};item_ref_start={{item_ref_start}};window_ref_start={{window_ref_start}};item_ref_end={{item_ref_end}};window_ref_end={{window_ref_end}};out={{out}}}">
												</div>
												<# } #>

													<?php $anim = ob_get_clean();

													ob_start(); ?>

													<# if ( 'convert--tabs'===settings.convert_container) { #>
														<div class="container--tab--titles--wrap">
															<# _.each( settings.container_tab_titles, function( item, index
																) { index++; let active=index==1 ? 'active' : '' ; #>

																<div class="container--tab--title {{active}}"
																	data-index="{{index}}">{{
																	item.container_tab_title }}</div>
																<span class="tabs--seperator">/</span>

																<# } ); #>
														</div>
														<# } #>

															<?php $tabbed = ob_get_clean();


															ob_start(); ?>

															<# if ( settings.container_title) { let
																title=settings.container_title; #>
																<div class="container--accordion--title" data-id="">

																	<span class="ac-order">1</span>

																	{{title}}

																	<span class="accordion-toggle toggle--plus">
																		<span></span>
																		<span></span>
																	</span>

																	<span class="accordion-toggle toggle--dot">
																		<span></span>
																	</span>

																</div>
																<# } #>

																	<?php $accordion = ob_get_clean();


																	return $acc . $anim . $tabbed . $accordion . $template . $dcc;
}

add_action("elementor/container/print_template", "container_render", 10, 2);