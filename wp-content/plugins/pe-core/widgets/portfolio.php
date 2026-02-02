<?php

namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
	exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PePortfolio extends Widget_Base
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
		return 'peportfolio';
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
		return __('Portfolio', 'pe-core');
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
		return 'eicon-posts-grid pe-widget';
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
			'widget_content',
			[
				'label' => __('Portfolio Settings', 'pe-core'),
			]
		);

		$options = array();

		$args = array(
			'hide_empty' => true,
			'taxonomy' => 'project-categories'
		);

		$categories = get_categories($args);

		foreach ($categories as $key => $category) {
			$options[$category->term_id] = $category->name;
		}

		$this->add_control(
			'filter_cats',
			[
				'label' => __('Categories', 'pe-core'),
				'description' => __('Select portfolio categories to display projects.', 'pe-core'),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $options,
			]
		);

		$this->add_control(
			'exclude_projects',
			[
				'label' => esc_html__('Exclude Projects', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__('eg: 1458 8478 ', 'pe-core'),
				'description' => esc_html__('Enter projects ids which you dont want to display in this widget.', 'pe-core'),
				'ai' => false
			]
		);

		$this->add_control(
			'number_posts',
			[
				'label' => esc_html__('Posts Per View', 'pe-core'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 999,
				'step' => 1,
				'render_type' => 'template',
				'default' => 10,
				'selectors' => [
					'{{WRAPPER}} .portfolio--grid ' => '--pCount: {{VALUE}}',
				],

			]
		);

		$this->add_control(
			'order_by',
			[
				'label' => esc_html__('Order By', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'ID' => esc_html__('ID', 'pe-core'),
					'title' => esc_html__('Title', 'pe-core'),
					'date' => esc_html__('Date', 'pe-core'),
					'author' => esc_html__('Author', 'pe-core'),
					'type' => esc_html__('Type', 'pe-core'),
					'rand' => esc_html__('Random', 'pe-core'),

				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__('Order', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC' => esc_html__('ASC', 'pe-core'),
					'DESC' => esc_html__('DESC', 'pe-core')

				],

			]
		);

		$this->add_control(
			'portfolio_style',
			[
				'label' => esc_html__('Style', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'portfolio--grid',
				'options' => [
					'portfolio--grid' => esc_html__('Grid', 'pe-core'),
					'portfolio--list' => esc_html__('List', 'pe-core')

				],

			]
		);

		$this->add_control(
			'style_switcher',
			[
				'label' => __('Style Switcher', 'pe-core '),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pe-core '),
				'label_off' => __('No', 'pe-core '),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switcher_style',
			[
				'label' => esc_html__('Switcher Style', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'switcher--brackets',
				'options' => [
					'switcher--switcher' => esc_html__('Switcher', 'pe-core'),
					'switcher--brackets' => esc_html__('Brackets', 'pe-core')

				],
				'condition' => ['style_switcher' => 'yes'],

			]
		);

		$this->add_control(
			'switch_grid_text',
			[
				'label' => esc_html__('Switch Grid Text', 'pe-core'),
				'default' => esc_html__('Grid', 'pe-core'),
				'ai' => false,
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => ['style_switcher' => 'yes'],
			]
		);

		$this->add_control(
			'switch_list_text',
			[
				'label' => esc_html__('Switch List Text', 'pe-core'),
				'default' => esc_html__('List', 'pe-core'),
				'ai' => false,
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => ['style_switcher' => 'yes'],
			]
		);

		$this->add_control(
			'load_more',
			[
				'label' => __('AJAX Load More', 'pe-core '),
				'description' => esc_html__('Only visual. Button wont work on editor; please check it on live page.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pe-core '),
				'label_off' => __('No', 'pe-core '),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);


		$this->add_control(
			'filterable',
			[
				'label' => __('Filterable', 'pe-core '),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pe-core '),
				'label_off' => __('No', 'pe-core '),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'view_all_text',
			[
				'label' => esc_html__('View All Text', 'pe-core'),
				'default' => esc_html__('All Projects', 'pe-core'),
				'ai' => false,
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => ['filterable' => 'yes'],
			]
		);

		$this->add_control(
			'show_counts',
			[
				'label' => __('Show Projects Count', 'pe-core '),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pe-core '),
				'label_off' => __('No', 'pe-core '),
				'return_value' => 'show--conts',
				'default' => 'show--counts',
				'condition' => ['filterable' => 'yes'],
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'project_settings',
			[
				'label' => __('Project Settings', 'pe-core'),
			]
		);

		$this->add_control(
			'project_hover',
			[
				'label' => esc_html__('Hover Animation', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__('None', 'pe-core'),
					'bulge' => esc_html__('Bulge', 'pe-core'),
					'zoom' => esc_html__('Zoom', 'pe-core'),
				],

			]
		);

		$this->add_control(
			'category',
			[
				'label' => __('Category', 'pe-core '),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'pe-core '),
				'label_off' => __('Hide', 'pe-core '),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

		$this->add_control(
			'excerpt',
			[
				'label' => __('Excerpt', 'pe-core '),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'pe-core '),
				'label_off' => __('Hide', 'pe-core '),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

		$this->add_control(
			'client',
			[
				'label' => __('Client', 'pe-core '),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'pe-core '),
				'label_off' => __('Hide', 'pe-core '),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

		$this->add_control(
			'date',
			[
				'label' => __('Date', 'pe-core '),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'pe-core '),
				'label_off' => __('Hide', 'pe-core '),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'load_more_settings',
			[
				'label' => __('Load More Settings', 'pe-core'),
				'condition' => ['load_more' => 'yes'],
			]
		);

		pe_button_settings($this);


		$this->end_controls_section();

		pe_cursor_settings($this);
		pe_general_animation_settings($this);


		$this->start_controls_section(
			'portfolio_sty',
			[
				'label' => esc_html__('Style', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'grid_columns',
			[
				'label' => esc_html__('Grid Columns', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['fr'],
				'range' => [
					'fr' => [
						'min' => 1,
						'max' => 6,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'fr',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio--grid div.portfolio--projects--wrapper' => 'grid-template-columns: repeat({{SIZE}}, minmax(100px, 1fr));',
					'{{WRAPPER}} .portfolio--grid ' => '--pGrid: {{SIZE}}',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__('Columns Gap', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'vw', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio--grid div.portfolio--projects--wrapper' => 'column-gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .portfolio--grid ' => '--pGap: {{SIZE}}px',
				],
			]
		);

		$this->add_responsive_control(
			'row_height',
			[
				'label' => esc_html__('Row Height', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'vh', '%', 'vw'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'vh',
					'size' => 75,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio--grid div.portfolio--projects--wrapper' => 'grid-auto-rows: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .portfolio--grid ' => '--rowHeight: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => esc_html__('Rows Gap', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'vw', '%', 'vh'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio--grid div.portfolio--projects--wrapper' => 'row-gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .portfolio--grid ' => '--rowGap: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'list_icon',
			[
				'label' => esc_html__('List Icon', 'pe-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'material-icons md-arrow_outward',
					'library' => 'material-design-icons',
				],
			]
		);

		$this->end_controls_section();

		pe_color_options($this);

		pe_button_style_settings($this, 'Load More Button');
	}

	protected function render()
	{
		$settings = $this->get_settings();

		$excluded = explode(" ", $settings['exclude_projects']);

		$cats = $settings['filter_cats'];

		isset($_GET['offset']) ? $offset = $_GET['offset'] : $offset = 0;

		$args = array(
			'post_type' => 'portfolio',
			'post_status' => 'publish',
			'posts_per_page' => $settings['number_posts'],
			'orderby' => $settings['order_by'],
			'order' => $settings['order'],
			'post__not_in' => $excluded,
			'offset' => $offset * $settings['number_posts'],
			'tax_query' => array(
				array(
					'taxonomy' => 'project-categories',
					'field' => 'term_id',
					'terms' => isset($_GET['cat']) ? $_GET['cat'] : $cats,
				)
			)

		);


		$loop = new \WP_Query($args);
		wp_reset_postdata();
		global $wp;

		$cursor = pe_cursor($this);
		$hover = $settings['project_hover'];




		?>


		<div class="pe--portfolio generate--grid anim-multiple <?php echo $settings['show_counts'] . ' ' . $settings['portfolio_style'] ?>"
			data-max-pages="<?php echo esc_attr($loop->max_num_pages) ?>" <?php echo pe_general_animation($this) ?>>


			<input type="hidden" name="url" value="<?php echo home_url($wp->request); ?>">
			<input type="hidden" name="offset" value="0">
			<input type="hidden" name="cat" value="">

			<div class="portfolio--controls inner--anim">

				<?php if ($settings['filterable'] === 'yes') { ?>
					<div class="portfolio--filters">

						<div data-length="<?php echo '[' . $loop->found_posts . ']'; ?>" class="filter--active" data-cat="all">
							<?php echo esc_html($settings['view_all_text']) ?>
						</div>

						<ul class="filter--cat--list">

							<?php

							echo '<li data-length="[' . $loop->found_posts . ']" class="filter--cat cat_all active">' . $settings['view_all_text'] . '</li>';

							foreach ($cats as $key => $cat) {

								$cato = get_term_by('id', $cat, 'project-categories');

								echo '<li data-length="[' . $cato->count . ']" data-id="' . $cat . '" class="filter--cat cat_' . $cato->slug . '">' . $cato->name . '</li>';
							}
							?>

						</ul>

					</div>
				<?php } ?>

				<?php if ($settings['style_switcher'] === 'yes') { ?>
					<div class="pe--switcher <?php echo $settings['switcher_style'] ?>">

						<div class="ps--switch">
							<?php if ($settings['switcher_style'] === 'switcher--switcher') { ?>
								<span class="ps--follower"></span>
							<?php } ?>
							<span class="ps--grid"><?php echo esc_html($settings['switch_grid_text']) ?></span>
							<span class="ps--list"><?php echo esc_html($settings['switch_list_text']) ?></span>

						</div>

					</div>
				<?php } ?>

			</div>

			<div class="portfolio--projects--wrapper">

				<div class="static--grid grid--for__<?php echo $this->get_id() ?>">

					<?php

					$horrs = $settings['number_posts'] / $settings['grid_columns']['size'];

					?>

					<?php for ($i = 1; $i < $settings['grid_columns']['size']; $i++) {

						echo '<span class="gn--line gn--line_' . $i . '" style="--line:' . $i . '"></span>';
						echo '<span class="gn--line gn--line_' . $i . '" style="--line:' . $i . '"></span>';
					} ?>


					<?php for ($i = 1; $i < ceil($horrs); $i++) {

						echo '<span class="gn--line-hor gn--line_' . $i . '" style="--line:' . $i . '"></span>';
						echo '<span class="gn--line-hor gn--line_' . $i . '" style="--line:' . $i . '"></span>';
					} ?>



				</div>

				<?php

				while ($loop->have_posts()):
					$loop->the_post(); ?>

					<div class="portfolio--project inner--anim" data-id="<?php the_ID(); ?>">

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<a class="barba--trigger" href="<?php echo get_the_permalink() ?>" <?php echo $cursor ?>
								data-id="<?php the_ID(); ?>">

								<div class="project--image project__image__<?php the_ID() ?>">

									<?php pe_project_image(get_the_ID(), false, $hover) ?>

								</div>

								<div class="project--details">

									<div class="project--tc">

										<div class="project--title"><?php echo get_the_title(); ?></div>

										<?php if ($settings['category'] === 'true') { ?>

											<div class="project--cat">

												<?php

												$terms = get_the_terms(get_The_ID(), 'project-categories');
												if ($terms) {

													$term_names = array();

													foreach ($terms as $term) {
														$term_names[] = esc_html($term->name);
													}

													$cats = implode(', ', $term_names);
													echo $cats;
												}

												?>

											</div>

										<?php } ?>

									</div>

									<div class="project--meta">

										<?php if (get_field('client') && $settings['client'] === 'true') { ?>
											<div class="project--client">
												<?php echo get_field('client'); ?>
											</div>
										<?php } ?>

										<?php if (get_field('date') && $settings['date'] === 'true') { ?>
											<div class="project--date">
												<?php echo get_field('date'); ?>
											</div>
										<?php } ?>



									</div>

									<div class="project--list--icon">

										<?php \Elementor\Icons_Manager::render_icon($settings['list_icon'], ['aria-hidden' => 'true']); ?>

									</div>


								</div>

							</a>

						</article>

					</div>

				<?php endwhile;
				wp_reset_query();

				?>

			</div>

			<div class="portfolio--list--images--wrapper">


				<?php while ($loop->have_posts()):
					$loop->the_post(); ?>


					<div class="list-img image_<?php echo get_the_ID(); ?>">
					<div class="project-image">

						<?php pe_project_image(get_the_ID(), false, $hover) ?>
						</div>
					</div>

				<?php endwhile;
				wp_reset_query(); ?>



			</div>


			<?php if ($settings['load_more'] === 'yes') { ?>

				<div class="portfolio--pagination" style="text-align: center">

					<?php pe_button_render($this); ?>

				</div>

			<?php } ?>

		</div>


		<?php
	}
}
