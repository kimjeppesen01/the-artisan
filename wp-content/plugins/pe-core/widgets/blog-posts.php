<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeBlogPosts extends Widget_Base
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
        return 'peblogposts';
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
        return __('Blog Posts', 'pe-core');
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




        $options = [];


        $this->start_controls_section(
            'widget_content',
            [
                'label' => __('Loop Settings', 'pe-core'),
            ]
        );



        $options = array();

        $args = array(
            'hide_empty' => true,
        );

        $categories = get_categories($args);

        foreach ($categories as $key => $category) {
            $options[$category->term_id] = $category->name;
        }

        $this->add_control(
            'filter_cats',
            [
                'label' => __('Categories', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $options,
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
                'default' => 10,
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
            'filterable',
            [
                'label' => __('Filterable?', 'pe-core '),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'pe-core '),
                'label_off' => __('No', 'pe-core '),
                'return_value' => 'yes',
                'default' => 'yes',
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
            'load_more_text',
            [
                'label' => esc_html__('Load More Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Write your text here', 'pe-core'),
                'default' => esc_html__('Load More Posts', 'pe-core'),
                'condition' => ['load_more' => 'yes'],
            ]
        );

        $this->add_control(
            'all_text',
            [
                'label' => esc_html__('Show All Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Write your text here', 'pe-core'),
                'default' => esc_html__('All', 'pe-core'),
                'condition' => ['filterable' => 'yes'],
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
                        'max' => 12,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'fr',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pe--posts--grid' => '--columns: {{SIZE}};',
                ],
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'posts_settings',
            [
                'label' => __('Posts Settings', 'pe-core'),
            ]
        );

        $this->add_control(
            'post_style',
            [
                'label' => esc_html__('Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post_vertical',
                'options' => [
                    'post_vertical' => esc_html__('Vertical', 'pe-core'),
                    'post_horizontal' => esc_html__('Horizontal', 'pe-core'),
                ],
            ]

        );

        $this->add_control(
            'bordered',
            [
                'label' => esc_html__('Bordered?', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "bordered",
                'default' => "false",
                'condition' => ['post_style' => 'post_horizontal'],


            ]
        );


        $this->add_control(
            'post_layout',
            [
                'label' => esc_html__('Project Layout', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'dark',
                'options' => [
                    'dark' => esc_html__('Dark', 'pe-core'),
                    'light' => esc_html__('Light', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'thumb',
            [
                'label' => esc_html__('Thumbnail', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",


            ]
        );

        $this->add_control(
            'date',
            [
                'label' => esc_html__('Date', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",


            ]
        );

        $this->add_control(
            'cat',
            [
                'label' => esc_html__('Category', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",


            ]
        );

        $this->add_control(
            'excerpt',
            [
                'label' => esc_html__('Excerpt', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",


            ]
        );

        $this->add_control(
            'button',
            [
                'label' => esc_html__('Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",
            ]
        );


        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Read More Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Type your button text here', 'pe-core'),
                'default' => esc_html__('Read More', 'pe-core'),
                'condition' => ['button' => 'true'],
            ]
        );



        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'pe-core'),
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
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .single-blog-post' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_height',
            [
                'label' => esc_html__('Custom Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',


            ]
        );

        $this->add_responsive_control(
            'project_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .thmb' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['custom_height' => 'yes'],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .pe--single--post.psp--elementor .thmb' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};overflow: hidden',
                ],
            ]
        );



        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'pe-core'),
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
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .single-blog-post' => 'float: {{VALUE}};',
                ],
            ]
        );




        $this->end_controls_section();


        pe_cursor_settings($this);
        pe_general_animation_settings($this);


        $this->start_controls_section(
            'project_elements',
            [

                'label' => esc_html__('Style', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_type',
            [
                'label' => esc_html__('Title Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'h1' => [
                        'title' => esc_html__('H1', 'pe-core'),
                        'icon' => ' eicon-editor-h1',
                    ],
                    'h2' => [
                        'title' => esc_html__('H2', 'pe-core'),
                        'icon' => ' eicon-editor-h2',
                    ],
                    'h3' => [
                        'title' => esc_html__('H3', 'pe-core'),
                        'icon' => ' eicon-editor-h3',
                    ],
                    'h4' => [
                        'title' => esc_html__('H4', 'pe-core'),
                        'icon' => ' eicon-editor-h4',
                    ],
                    'h5' => [
                        'title' => esc_html__('H5', 'pe-core'),
                        'icon' => ' eicon-editor-h5',
                    ],
                    'h6' => [
                        'title' => esc_html__('H6', 'pe-core'),
                        'icon' => ' eicon-editor-h6',
                    ]

                ],
                'default' => 'h6',
                'toggle' => true,
            ]
        );




        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',


            ]
        );


        $this->add_control(
            'button_style',
            [
                'label' => esc_html__('Button Style', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'underline',
                'options' => [
                    'underline' => esc_html__('Underline', 'pe-core'),
                    'outline' => esc_html__('Outline', 'pe-core'),
                    'fill' => esc_html__('Fill', 'pe-core'),

                ],
                'condition' => ['button' => 'true'],

            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' => esc_html__('Show Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => ['button' => 'true'],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                    'button' => 'true'
                ],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'icon-left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'icon-right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'icon-right',
                'toggle' => false,
                'condition' => [
                    'show_icon' => 'yes',
                    'button' => 'true'
                ],

            ]
        );



        $this->end_controls_section();



        pe_color_options($this);

        $this->start_controls_section(
            'blog_posts_typography',
            [
                'label' => esc_html__('Typography', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--single--post .post-title'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => esc_html__('Excerpt', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--single--post .post-excerpt p'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Button', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--single--post .post-button a'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'label' => esc_html__('Category', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--single--post .post-categories a'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'label' => esc_html__('Date', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe--single--post .post-date'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'load_more_typography',
                'label' => esc_html__('Load More', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe-load-more a'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'filter_typography',
                'label' => esc_html__('Filter', 'pe-core'),
                'selector' => '{{WRAPPER}} .filters-list .post-filter'
            ]
        );






        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings();

        $classes = [];

        $classes[] = 'pe--single--post psp--elementor ' . $settings['post_style'] . '';


        //Cursor
        ob_start();

        \Elementor\Icons_Manager::render_icon($settings['cursor_icon'], ['aria-hidden' => 'true']);

        $cursorIcon = ob_get_clean();


        $cursor = pe_cursor($this);

        $thumb = $settings['thumb'];
        $date = $settings['date'];
        $category = $settings['cat'];
        $excerpt = $settings['excerpt'];
        $button = $settings['button'];
        $read = $settings['button_text'];

        if ($settings['filter_cats']) {
            $cats = $settings['filter_cats'];
        } else {

            $cats = [];

            $args = array(
                'hide_empty' => false,
            );

            foreach (get_categories($args) as $gt) {

                $cats[] = $gt->term_id;
            }

        }

        if ((isset($_GET['offset']))) {

            $offset = $_GET['offset'];

        } else {
            $offset = 0;
        }

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $settings['number_posts'],
            'orderby' => $settings['order_by'],
            'order' => $settings['order'],
            'cat' => $cats,
            'paged' => 1,
            'offset' => $offset * $settings['number_posts'],
        );

        global $wp;
        $loadMoreLink = home_url($wp->request) . '/?offset=' . ($offset + 1);



        $loop = new \WP_Query($args);
        wp_reset_postdata();



        ?>

        <div class="pe--posts--grid" data-total="<?php echo $loop->found_posts; ?>">

            <?php if ($settings['filterable'] === 'yes') { ?>

                <div class="grid--filters">

                    <ul class="filters-list">

                        <li class="post-filter active" data-category="all"><?php echo esc_html($settings['all_text']); ?></li>

                        <?php
                        foreach ($cats as $key => $cat) {

                            $cato = get_category($cat);

                            ?>
                            <li class="post-filter" data-category="<?php echo $cato->slug; ?>"><?php echo $cato->name; ?></li>

                        <?php }

                        ?>

                    </ul>

                </div>

            <?php } ?>



            <div class="grid--posts--wrapper anim-multiple" <?php echo pe_general_animation($this) ?>>

                <?php while ($loop->have_posts()):
                    $loop->the_post();

                    $terms = get_the_terms(get_the_ID(), 'category');
                    $cats = [];

                    if ($terms) {

                        foreach ($terms as $term) {

                            $cats[] = 'cat_' . esc_html($term->slug) . ' ';

                        }
                    }

                    ?>

                    <div class="grid--post--item inner--anim <?php echo implode($cats) ?>">


                        <article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>             <?php echo $cursor ?>>


                            <?php if ($thumb) {

                                echo '<div class="thmb">';

                                pe_post_thumbnail();

                                echo '</div>';
                            } ?>


                            <!-- Post Details -->
                            <div class="post-details">


                                <?php if ($date || $category) { ?>

                                    <!-- Meta -->
                                    <div class="post-meta">

                                        <?php if ($category) { ?>
                                            <div class="post-categories"><?php 		// Hide category and tag text for pages.
                                                                if ('post' === get_post_type()) {
                                                                    /* translators: used between list items, there is a space after the comma */
                                                                    $categories_list = get_the_category_list(esc_html__(', ', 'pe-core'));
                                                                    if ($categories_list) {
                                                                        /* translators: 1: list of categories. */
                                                                        printf('<span class="cat-links">' . esc_html__('%1$s', 'pe-core') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                                    }

                                                                } ?>
                                            </div>

                                        <?php } ?>

                                        <?php if ($date) { ?>
                                            <div class="post-date">
                                                <?php pe_posted_on(); ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <!--/ Meta -->

                                <?php } ?>



                                <!-- Title -->
                                <a href="<?php echo esc_url(get_permalink()) ?>" <?php echo $cursor ?>>


                                    <?php echo '<' . $settings['text_type'] . ' class="post-title entry-title">' . get_the_title() . '</' . $settings['text_type'] . '>'; ?>


                                </a>
                                <!--/ Title -->

                                <?php if ($excerpt) { ?>
                                    <div class="post-excerpt">
                                        <?php the_excerpt() ?>
                                    </div>
                                <?php } ?>


                                <?php if ($button) {

                                    $iconPos = '';

                                    if ($settings['show_icon'] === 'yes') {

                                        $iconPos = $settings['icon_position'];
                                    }

                                    $buttonClasses = $settings['button_style'] . ' ' . $iconPos

                                        ?>
                                    <!-- Button -->
                                    <div class="post-button">

                                        <!--  Button -->
                                        <div class="pe-button <?php echo esc_attr($buttonClasses); ?>">


                                            <a href="<?php echo esc_url(get_permalink()) ?>" <?php echo $cursor ?>><?php echo esc_html($read) ?></a>

                                        </div>
                                        <!--/ Button -->

                                    </div>
                                    <!--/ Button -->

                                <?php } ?>

                            </div>
                            <!--/ Post Details -->


                        </article>

                    </div>

                <?php endwhile;
                wp_reset_query(); ?>

            </div>

            <?php if ($settings['load_more'] === 'yes') { ?>

                <div class="pe-load-more">

                    <div class="pbp--load-more">

                        <a href="<?php echo esc_html($loadMoreLink); ?>" <?php echo $cursor ?>>
                            <?php echo esc_html($settings['load_more_text']) ?>
                        </a>

                    </div>

                </div>
            <?php } ?>


        </div>

        <?php
    }

}
