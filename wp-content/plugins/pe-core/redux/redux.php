<?php
if (!class_exists("Redux")) {
    return;
}

$opt_name = "pe-redux";

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = [
    "display_name" => $theme->get("Name") . " Options",
    "display_version" => $theme->get("Version"),
    "menu_title" => esc_html__("Theme Options", "pe-core"),
    "customizer" => false,
    "dev_mode" => false,
    'output' => true,
    'output_variables' => true
];


Redux::setArgs($opt_name, $args);
// Redux::set_extensions($opt_name, __DIR__ . '/extensions');
Redux::get_extensions($opt_name);

Redux::setSection($opt_name, [
    "title" => esc_html__("Site General", "pe-core"),
    "id" => "site_general",
    "icon" => "eicon-site-logo",
    "fields" => [
        [
            "id" => "page_transitions",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("Page Transitions", "pe-core"),
            "subtitle" => __(
                "AJAX page transitions will be enabled for entire website.",
                "pe-core"
            ),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => false,
        ],
        [
            "id" => "page_loader",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("Page Loader", "pe-core"),
            "subtitle" => __(
                "Page loader will be shown at first load. Disabling it during website building may speed up things.",
                "pe-core"
            ),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => false,
        ],

        [
            "id" => "smooth_scroll",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("Smooth Scroll", "pe-core"),
            "subtitle" => __("GSAP smooth scroll will be enabled.", "pe-core"),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => false,
        ],

        [
            "id" => "mouse_cursor",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("Mouse Cursor", "pe-core"),
            "subtitle" => __(
                "An interactive mouse cursor will be follow the default mouse cursor.",
                "pe-core"
            ),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => false,
        ],

        [
            "id" => "noise--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],

        [
            'id' => 'grain-options-heading',
            'type' => 'raw',
            'title' => esc_html__('Grain Options', 'pe-core'),
        ],

        [
            "id" => "grain_overlay",
            "type" => "switch",
            "class" => "pr--50 label--block no--border has--padd",
            "title" => __("Grain Overlay", "pe-core"),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => false,
        ],
        [
            'id' => 'overlay_opacity',
            'type' => 'slider',
            "class" => "pr--50 label--block no--border",
            'title' => esc_html__('Overlay Opacity', 'pe-core'),
            'display_value' => 'label',
            'min' => 1,
            'max' => 100,
            'default' => 10,
            'step' => 1
        ],
        [
            "id" => "default--colors--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'default-colors-heading',
            'type' => 'raw',
            'title' => esc_html__('Default Site Colors', 'pe-core'),
        ],
        [
            "id" => "main_color",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Main Color", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used in primary texts.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--mainColor" => " :root , :root body.layout--switched .header--switched , .e-con",
            ],
        ],
        [
            "id" => "secondary_color",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Secondary Color", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used in secondary texts.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--secondaryColor" => " :root , :root body.layout--switched .header--switched , .e-con",
            ],
        ],
        [
            "id" => "main_background",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Main Background", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used as background color of the site.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--mainBackground" => " :root , :root body.layout--switched .header--switched , .e-con",
            ],
        ],
        [
            "id" => "secondary_background",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__(
                "Secondary Background",
                "pe-core"
            ),
            "subtitle" => esc_html__(
                "Will be used on backgrounded elements background.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--secondaryBackground" => " :root , :root body.layout--switched .header--switched , .e-con",
            ],
        ],
        [
            "id" => "lines_color",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__(
                "Lines Color",
                "pe-core"
            ),
            "subtitle" => esc_html__(
                "Mostly used for lines,borders etc.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--linesColor" => " :root , :root body.layout--switched .header--switched , .e-con",
            ],
        ],
        [
            "id" => "switched--colors--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'switched-colors-heading',
            'type' => 'raw',
            'title' => esc_html__('Switched Site Colors', 'pe-core'),
        ],
        [
            "id" => "secondary_main_color",
            "type" => "color",
            "title" => esc_html__("Main Color", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used in primary texts.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--mainColor" => ".layout--colors , .e-con.layout--switched .e-con,
                .e-con.layout--switched,
                .header--switched,
                .header--switched .e-con,
                .layout--colors,
                :root body.layout--switched,
                :root body.layout--switched .e-con",
            ],
        ],
        [
            "id" => "secondary_secondary_color",
            "type" => "color",
            "title" => esc_html__("Secondary Color", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used in secondary texts.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--secondaryColor" => ".layout--colors , .e-con.layout--switched .e-con,
                .e-con.layout--switched,
                .header--switched,
                .header--switched .e-con,
                .layout--colors,
                :root body.layout--switched,
                :root body.layout--switched .e-con",
            ],
        ],
        [
            "id" => "secondary_main_background",
            "type" => "color",
            "title" => esc_html__("Main Background", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used as background color of the site.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--mainBackground" => ".layout--colors , .e-con.layout--switched .e-con,
                .e-con.layout--switched,
                .header--switched,
                .header--switched .e-con,
                .layout--colors,
                :root body.layout--switched,
                :root body.layout--switched .e-con",
            ],
        ],
        [
            "id" => "secondary_secondary_background",
            "type" => "color",
            "title" => esc_html__(
                "Secondary Background",
                "pe-core"
            ),
            "subtitle" => esc_html__(
                "Will be used on backgrounded elements background.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--secondaryBackground" => ".layout--colors , .e-con.layout--switched .e-con,
                .e-con.layout--switched,
                .header--switched,
                .header--switched .e-con,
                .layout--colors,
                :root body.layout--switched,
                :root body.layout--switched .e-con",
            ],
        ],

        [
            "id" => "switched_lines_color",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__(
                "Lines Color",
                "pe-core"
            ),
            "subtitle" => esc_html__(
                "Mostly used for lines,borders etc.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--linesColor" => ".layout--colors , .e-con.layout--switched .e-con,
                .e-con.layout--switched,
                .header--switched,
                .header--switched .e-con,
                .layout--colors,
                :root body.layout--switched,
                :root body.layout--switched .e-con",
            ],
        ],

        [
            "id" => "site--branding--options",
            "type" => "section",
            "subsection" => true,
            "indent" => false,
        ],
        [
            'id' => 'site-branding-heading',
            'type' => 'raw',
            'title' => esc_html__('Site Branding', 'pe-core'),
        ],

        [
            "id" => "main_site_logo",
            "type" => "media",
            "url" => true,
            "class" => "pr--logo pr--fill--box",
            "preview_size" => "full",
            "title" => esc_html__("Main Site Logo", "pe-core"),
            "subtitle" => esc_html__("Upload your main logo here.", "pe-core"),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
        ],

        [
            "id" => "secondary_site_logo",
            "type" => "media",
            "url" => true,
            "class" => "pr--logo pr--fill--box",
            "preview_size" => "full",
            "title" => esc_html__("Secondary Site Logo", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used when site/header layout has switched.",
                "pe-core"
            ),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
        ],

        [
            "id" => "main_sticky_logo",
            "type" => "media",
            "url" => true,
            "preview_size" => "full",
            "class" => "pr--logo pr--fill--box",
            "title" => esc_html__("Main Sticky Logo", "pe-core"),
            "subtitle" => esc_html__(
                "Upload your main sticky logo here.",
                "pe-core"
            ),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
        ],

        [
            "id" => "secondary_sticky_logo",
            "type" => "media",
            "url" => true,
            "preview_size" => "full",
            "class" => "pr--logo pr--fill--box",
            "title" => esc_html__("Secondary Sticky Logo", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used when site/header layout has switched.",
                "pe-core"
            ),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
        ],
        [
            "id" => "main_mobile_logo",
            "type" => "media",
            "url" => true,
            "preview_size" => "full",
            "class" => "pr--logo pr--fill--box",
            "title" => esc_html__("Main Mobile Logo", "pe-core"),
            "subtitle" => esc_html__(
                "Leave it empty if you want to display main logo at mobile devices.",
                "pe-core"
            ),
        ],
        [
            "id" => "secondary_mobile_logo",
            "type" => "media",
            "url" => true,
            "preview_size" => "full",
            "class" => "pr--logo pr--fill--box",
            "title" => esc_html__("Secondary Mobile Logo", "pe-core"),
            "subtitle" => esc_html__(
                "Leave it empty if you want to display main logo at mobile devices.",
                "pe-core"
            ),
        ],
    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Header/Footer", "pe-core"),
    "icon" => "eicon-header",
    "id" => "header_footer_options",
    "fields" => [
        [
            "id" => "header-options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'header-opt-heading',
            'type' => 'raw',
            'title' => esc_html__('Header Settings', 'pe-core'),
        ],
        [
            "id" => "header_type",
            "type" => "button_set",
            "title" => __("Header Type", "pe-core"),
            "subtitle" => esc_html__("Select header type.", "pe-core"),
            "options" => [
                "default" => "Default",
                "template" => "Template",
            ],
            "default" => "default",
        ],
        [
            "id" => "select-header-template",
            "type" => "select",
            "select2" => false,
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("Select Header Template", 'pe-core'),
            "subtitle" => esc_html__(
                "Select Elementor header template.",
                "pe-core"
            ),
            "required" => ["header_type", "not", "default"],
            "validate_callback" => "pe_translate_elementor_template"
        ],
        [
            "id" => "header_layout",
            "type" => "button_set",
            "title" => __("Header Layout", "pe-core"),
            "subtitle" => esc_html__("Select header layout.", "pe-core"),
            "options" => [
                "default" => "Default",
                "switched" => "Switched",
            ],
            "default" => "default",
        ],
        [
            "id" => "header_behavior",
            "type" => "button_set",
            "title" => __("Header Behavior", "pe-core"),
            "options" => [
                "static" => "Static",
                "sticky" => "Sticky",
                "fixed" => "Fixed",
            ],
            "default" => "fixed",
        ],
        [
            "id" => "auto_switch_header",
            "type" => "switch",
            "title" => __("Auto Switch Header", "pe-core"),
            "subtitle" => esc_html__("Normally headers automatically adjusts it's layout between dark/light regarding to the container layouts in the viewport. You can disable it by switching this option off. (Usefull if you'r using a static colored header)", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => true,
        ],
        [
            "id" => "header_background",
            "type" => "color",
            "title" => esc_html__("Header Background Color", "pe-core"),
            "subtitle" => esc_html__(
                "Pick a background color for site header.",
                "pe-core"
            ),
            "output" => [
                "background-color" => ".site-header",
            ],
            "default" => "transparent",
            "validate" => "color",
        ],

        [
            "id" => "switched_header_background",
            "type" => "color",
            "title" => esc_html__("Header Background Color (Switched)", "pe-core"),
            "subtitle" => esc_html__(
                "Pick a background color for switched site header.",
                "pe-core"
            ),
            "output" => [
                "background-color" => ".layout--switched .site-header,  .site-header.header--switched",
            ],
            "default" => "transparent",
            "validate" => "color",
        ],

        [
            "id" => "sticky_header_background",
            "type" => "color",
            "title" => esc_html__("Sticky Header Background Color", "pe-core"),
            "subtitle" => esc_html__(
                "Pick a background color for site header.",
                "pe-core"
            ),
            "validate" => "color",
            "default" => "transparent",
            "output" => [
                "background-color" => ".header--sticked",
                "important" => true,
            ],
        ],
        [
            "id" => "switched_sticky_header_background",
            "type" => "color",
            "title" => esc_html__("Sticky Header Background Color (switched)", "pe-core"),
            "subtitle" => esc_html__(
                "Pick a background color for site header.",
                "pe-core"
            ),
            "validate" => "color",
            "default" => "transparent",
            "output" => [
                "background-color" => ".header--switched.header--sticked",
                "important" => true,
            ],
        ],

        [
            "id" => "footer--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'footer-opt-heading',
            'type' => 'raw',
            'title' => esc_html__('Footer Settings', 'pe-core'),
        ],

        [
            "id" => "footer_fixed",
            "type" => "switch",
            "title" => __("Fixed Footer", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => false,
        ],
        [
            "id" => "footer_template",
            "type" => "button_set",
            "title" => __("Footer Type", "pe-core"),
            "subtitle" => esc_html__("Select header layout.", "pe-core"),
            "options" => [
                "default" => "Default",
                "template" => "Template",
            ],
            "default" => "default",
        ],
        [
            "id" => "footer-link",
            "type" => "text",
            "title" => __("Footer Link", "pe-core"),
            "default" => "https://pethemes.com",
            "required" => ["footer_template", "=", "default"],
        ],
        [
            "id" => "footer-text",
            "type" => "text",
            "default" => __("Pe Themes", "pe-core"),
            "title" => __("Footer Text", "pe-core"),
            "required" => ["footer_template", "=", "default"],
        ],
        [
            "id" => "select-footer-template",
            "type" => "select",
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("Select Footer Template", 'pe-core'),
            "subtitle" => esc_html__("Select Elementor footer template.", "pe-core"),
            "required" => ["footer_template", "not", "default"],
            "validate_callback" => "pe_translate_elementor_template"
        ],


    ],
]);

Redux::setSection($opt_name, [
    "title" => __("Posts/Pages", "pe-core"),
    "id" => "posts-pages",
    "subsection" => false,
    "icon" => "eicon-single-page",
    "fields" => [
        [
            "id" => "portfolio--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'portfolio-heading',
            'type' => 'raw',
            'title' => esc_html__('Portfolio Settings', 'pe-core'),
        ],
        [
            "id" => "project_hero_template",
            "type" => "select",
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("Global Project Hero Template", 'pe-core'),
            "subtitle" => __("Settings can be changed from portfolio edit pages.", 'pe-core'),
            "validate_callback" => "pe_translate_elementor_template"

        ],
        [
            "id" => "portfolio-slug",
            "type" => "text",
            "title" => __("Custom Portfolio Slug", "pe-core"),
            "subtitle" => __(
                'Leave it empty if you want to continue using "portfolio" slug. ',
                "pe-core"
            ),
            "description" => __(
                "If you can not view your portfolio posts after you changed this, please update your permalink settings once.",
                "pe-core"
            ),
        ],
        [
            "id" => "show_next_project",
            "type" => "switch",
            "title" => __("Next Project Section", "pe-core"),
            "on" => __("Show", "pe-core"),
            "off" => __("Hide", "pe-core"),
            "default" => true,
        ],
        [
            "id" => "next_project_template",
            "type" => "select",
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("Next Project Template", 'pe-core'),
            "required" => ["show_next_project", "=", "true"],
            "validate_callback" => "pe_translate_elementor_template"

        ],
        [
            "id" => "post--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'post-settings',
            'type' => 'raw',
            'title' => esc_html__('Post Settings', 'pe-core'),
        ],
        [
            "id" => "single_post_template",
            "type" => "select",
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("Single Post Template", 'pe-core'),
            "subtitle" => __("You can create/customize templates via 'Templates' section on side menu of the dashboard.", 'pe-core'),
            "validate_callback" => "pe_translate_elementor_template"
        ],
        [
            'id' => '404-settings',
            'type' => 'raw',
            'title' => esc_html__('404 Page', 'pe-core'),
        ],
        [
            "id" => "404_page_template",
            "type" => "select",
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("404 Page Template", 'pe-core'),
            "subtitle" => __("You can create/customize templates via 'Templates' section on side menu of the dashboard.", 'pe-core'),
            "validate_callback" => "pe_translate_elementor_template"
        ],

    ],
]);

Redux::setSection(
    $opt_name,
    array(
        'title' => __('Shop', 'pe-core'),
        'id' => 'shop',
        'icon' => 'eicon-woocommerce',
    )
);




Redux::set_section(
    $opt_name,
    array(
        'title' => esc_html__('Archives', 'pe-core'),
        'id' => 'archive--opts-2',
        'subsection' => true,
        'customizer_width' => '450px',
        'fields' => [
            [
                "id" => "shop--archive--optionss",
                "type" => "section",
                "subsection" => true,
                "indent" => true,
            ],
            [
                'id' => 'shop-headings',
                'type' => 'raw',
                'title' => esc_html__('Shop Archive', 'pe-core'),
            ],
            [
                'id' => 'show_shop_title',
                'type' => 'switch',
                'title' => __('Show Shop Title', 'pe-core'),
                'on' => __('Yes', 'pe-core'),
                'off' => __('No', 'pe-core'),
                'default' => false,
            ],
            [
                'id' => 'archive_style',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Archive Style', 'pe-core'),
                'options' => [
                    'grid' => esc_html__('Grid', 'pe-core'),
                    'masonry' => esc_html__('Masonry', 'pe-core'),
                    'list' => esc_html__('List', 'pe-core')
                ],
                'default' => ['grid']
            ],
            [
                'id' => 'shop_grid_columns',
                'type' => 'slider',
                'title' => esc_html__('Grid Columns', 'pe-core'),
                'display_value' => 'label',
                'min' => 1,
                'max' => 8,
                'default' => 4,
                'step' => 1,
                'output_variables' => true,
                'required' => [
                    ['archive_style', '=', 'grid'],
                ]
            ],
            [
                'id' => 'shop_posts_per_page',
                'type' => 'slider',
                'title' => esc_html__('Posts Per Page', 'pe-core'),
                'desc' => esc_html__('-1 for unlimited', 'pe-core'),
                'display_value' => 'label',
                'min' => -1,
                'max' => 30,
                'default' => -1,
                'step' => 1,
            ],

            [
                'id' => 'shop_order_by',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Order By', 'pe-core'),
                'options' => [
                    'id' => esc_html__('ID', 'pe-core'),
                    'title' => esc_html__('Title', 'pe-core'),
                    'date' => esc_html__('Date', 'pe-core'),
                    'author' => esc_html__('Author', 'pe-core'),
                    'type' => esc_html__('Type', 'pe-core'),
                    'random' => esc_html__('Random', 'pe-core'),
                ],
                'default' => ['date']
            ],
            [
                'id' => 'shop_order',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Order', 'pe-core'),
                'options' => [
                    'ASC' => esc_html__('ASC', 'pe-core'),
                    'DESC' => esc_html__('DESC', 'pe-core'),

                ],
                'default' => ['ASC']
            ],
            [
                "id" => "excluded_products",
                'title' => esc_html__('Exclude Products', 'pe-core'),
                "type" => "select",
                "select2" => true,
                "multi" => true,
                "data" => "posts",
                "args" => [
                    "post_type" => ["product"],
                    "posts_per_page" => -1,
                ],
            ],
            [
                'id' => 'highlight_products',
                'type' => 'switch',
                'title' => esc_html__('Highlight Products', 'pe-core'),
                'on' => esc_html__('Yes', 'pe-core'),
                'off' => esc_html__('No', 'pe-core'),
                'default' => false
            ],
            [
                'id' => 'highlight_by',
                'type' => 'select',
                'title' => esc_html__('Hightlight By;', 'pe-core'),
                'options' => [
                    'key' => esc_html__('Key', 'pe-core'),
                    'product' => esc_html__('Product', 'pe-core'),
                ],
                'default' => ['key'],
                'required' => ['highlight_products', '=', true],
            ],
            [
                "id" => "highlighted_products",
                'title' => esc_html__('Highlighted Products;', 'pe-core'),
                "type" => "select",
                "select2" => true,
                "multi" => true,
                "data" => "posts",
                "args" => [
                    "post_type" => ["product"],
                    "posts_per_page" => -1,
                ],
                'required' => [
                    ['highlight_by', '=', 'product'],
                ],
            ],

            [
                'id' => 'highlight_keys',
                'type' => 'text',
                'title' => esc_html__('Highlight by Index', 'pe-core'),
                'default' => '',
                'required' => ['highlight_by', '=', 'key'],
            ],
            [
                "id" => "category_filters",
                "type" => "switch",
                "title" => __("Category Filters", "pe-core"),
                "on" => __("Yes", "pe-core"),
                "off" => __("No", "pe-core"),
                "default" => false,
            ],
            [
                "id" => "cats_for_filters",
                "title" => esc_html__("Select Categories", "pe-core"),
                "type" => "select",
                "select2" => true,
                "multi" => true,
                "data" => "terms",
                "args" => [
                    "taxonomy" => "product_cat",
                    "hide_empty" => true, // Boş kategorileri gizleme
                ],
                "required" => [
                    ["category_filters", "=", true],
                ],
            ],
            [
                'id' => 'grid_switcher',
                'type' => 'switch',
                'title' => __('Grid Switcher', 'pe-core'),
                'on' => __('Yes', 'pe-core'),
                'off' => __('No', 'pe-core'),
                'default' => false,
                'class' => 'grid--switcher--',
            ],
            [
                'id' => 'g_switcher_style',
                'type' => 'select',
                'title' => esc_html__('Grid Switcher Style', 'pe-core'),
                'multi' => false,
                'options' => [
                    'switch' => esc_html__('Switch', 'pe-core'),
                    'simple' => esc_html__('Simple', 'pe-core'),
                ],
                'default' => 'simple',

                'select2' => ['allowClear' => false],
                'required' => ['grid_switcher', '=', true],
            ],
            [
                'id' => 'grid_switch_columns',
                'type' => 'select',
                'title' => esc_html__('Grid Switch Columns', 'pe-core'),
                'multi' => true,
                'options' => [
                    '1' => esc_html__('1 Column', 'pe-core'),
                    '2' => esc_html__('2 Columns', 'pe-core'),
                    '3' => esc_html__('3 Columns', 'pe-core'),
                    '4' => esc_html__('4 Columns', 'pe-core'),
                    '5' => esc_html__('5 Columns', 'pe-core'),
                    '6' => esc_html__('6 Columns', 'pe-core'),
                ],
                'default' => ['2', '3'],
                'select2' => true,
                'required' => ['grid_switcher', '=', true],
            ],
            [
                "id" => "sorting",
                "type" => "switch",
                "title" => esc_html__("Sorting", "pe-core"),
                "on" => esc_html__("Yes", "pe-core"),
                "off" => esc_html__("No", "pe-core"),
                "default" => true,
            ],
            [
                'id' => 'additional_filters',
                'title' => esc_html__('Additional Filters', 'pe-core'),
                'type' => 'switch',
                'on' => esc_html__('Yes', 'pe-core'),
                'off' => esc_html__('No', 'pe-core'),
            ],

            [
                'id' => 'filters_behavior',
                'title' => esc_html__('Filters Behavior', 'pe-core'),
                'type' => 'button_set',
                'options' => [
                    'always-show' => esc_html__('Always Show', 'pe-core'),
                    'popup' => esc_html__('Popup', 'pe-core'),
                    'dropdown' => esc_html__('Dropdown', 'pe-core'),
                    'sidebar' => esc_html__('Sidebar', 'pe-core'),
                ],
                'default' => 'always-show',
                'requried' => ['additional_filters', '=', true]
            ],
            [
                'id' => 'select_additonal_filtersa',
                'type' => 'select',
                'title' => esc_html__('Additonal Filters', 'pe-core'),
                'multi' => true,
                'sortable' => true,
                'data' => 'callback',
                'args' => 'filtersArr',
                'select2' => true,
                'required' => ['additional_filters', '=', true],
            ],
            [
                "id" => "select_brands",
                "title" => esc_html__("Select Brands", "pe-core"),
                "type" => "select",
                "select2" => true,
                "multi" => true,
                "data" => "terms",
                "args" => [
                    "taxonomy" => "brand",
                    "hide_empty" => true, // Boş kategorileri gizleme
                ],
                "required" => [
                    ["select_additonal_filtersa", "=", 'brands'],
                ],
            ],

            [
                'id' => 'min_price',
                'type' => 'text',
                'title' => esc_html__('Min Price', 'pe-core'),
                'default' => '0',
                "required" => [
                    ["select_additonal_filtersa", "=", 'price'],
                ],
            ],

            [
                'id' => 'max_price',
                'type' => 'text',
                'title' => esc_html__('Max Price', 'pe-core'),
                'default' => '1000',
                "required" => [
                    ["select_additonal_filtersa", "=", 'price'],
                ],
            ],


            [
                "id" => "select_tags",
                "title" => esc_html__("Select Tags", "pe-core"),
                "type" => "select",
                "select2" => true,
                "multi" => true,
                "data" => "terms",
                "args" => [
                    "taxonomy" => "product_tag",
                    "hide_empty" => true, // Boş kategorileri gizleme
                ],
                "required" => [
                    ["select_additonal_filtersa", "=", 'tag'],
                ],
            ],

            [
                "id" => "select_side_cats",
                "title" => esc_html__("Select Cats", "pe-core"),
                "type" => "select",
                "select2" => true,
                "multi" => true,
                "data" => "terms",
                "args" => [
                    "taxonomy" => "product_cat",
                    "hide_empty" => true, // Boş kategorileri gizleme
                ],
                "required" => [
                    ["select_additonal_filtersa", "=", 'categories'],
                ],
            ],
            [
                'id' => 'filters_button_text',
                'type' => 'text',
                'title' => esc_html__('Filters Button Text', 'pe-core'),
            ],
            [
                'id' => 'pagination_style',
                'title' => esc_html__('Pagination', 'pe-core'),
                'type' => 'select',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'ajax-load-more' => esc_html__('AJAX Load More', 'pe-core'),
                    'infinite-scroll' => esc_html__('Infinite Scroll', 'pe-core'),
                ],
                'default' => 'none'
            ],
            [
                "id" => "shop--product--settings",
                "type" => "section",
                "subsection" => true,
                "indent" => true,
            ],
            [
                'id' => 'shop-product-settings-heading',
                'type' => 'raw',
                'title' => esc_html__('Shop Products', 'pe-core'),
            ],
            [
                'id' => 'products_style',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Style', 'pe-core'),
                'options' => [
                    'classic' => esc_html__('Classic', 'pe-core'),
                    'metro' => esc_html__('Metro', 'pe-core'),
                    'card' => esc_html__('Card', 'pe-core'),
                    'sharp' => esc_html__('Sharp', 'pe-core'),
                    'detailed' => esc_html__('Detailed', 'pe-core'),

                ],
                'default' => ['classic']
            ],
            [
                'id' => 'products_metas_position',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Metas Position', 'pe-core'),
                'options' => [
                    'column-reverse' => esc_html__('Top', 'pe-core'),
                    'column' => esc_html__('Bottom', 'pe-core'),

                ],
                'default' => ['column'],
            ],
            [
                'id' => 'products_metas_orientation',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Metas Orientation', 'pe-core'),
                'options' => [
                    'column' => esc_html__('Vertical', 'pe-core'),
                    'row' => esc_html__('Horizontal', 'pe-core'),

                ],
                'default' => ['row']
            ],
            [
                "id" => "show_price",
                "type" => "switch",
                "title" => __("Show Price", "pe-core"),
                "on" => __("Yes", "pe-core"),
                "off" => __("No", "pe-core"),
                "default" => true,
            ],
            [
                "id" => "show_wishlist",
                "type" => "switch",
                "title" => __("Show Wishlist", "pe-core"),
                "on" => __("Yes", "pe-core"),
                "off" => __("No", "pe-core"),
                "default" => true,
            ],
            [
                'id' => 'wishlist_type',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Wishlist Type', 'pe-core'),
                'options' => [
                    'yith' => esc_html__('YITH', 'pe-core'),
                    'built-in' => esc_html__('Built In (Saren)', 'pe-core'),

                ],
                'default' => ['built-in'],
                'required' => ['show_wishlist', '=', true],
            ],
            [
                "id" => "show_compare",
                "type" => "switch",
                "title" => __("Show Compare", "pe-core"),
                "on" => __("Yes", "pe-core"),
                "off" => __("No", "pe-core"),
                "default" => true,
            ],
            [
                'id' => 'compare_type',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Compare Type', 'pe-core'),
                'options' => [
                    'yith' => esc_html__('YITH', 'pe-core'),
                    'built-in' => esc_html__('Built In (Saren)', 'pe-core'),

                ],
                'default' => ['built-in'],
                'required' => ['show_compare', '=', true],
            ],
            [
                "id" => "view_button",
                "type" => "switch",
                "title" => __("View Button", "pe-core"),
                "on" => __("Yes", "pe-core"),
                "off" => __("No", "pe-core"),
                "default" => true,
            ],
            [
                "id" => "short__desc",
                "type" => "switch",
                "title" => esc_html__("Short Description", "pe-core"),
                "on" => esc_html__("Show", "pe-core"),
                "off" => esc_html__("Hide", "pe-core"),
                "default" => false,
            ],
            [
                "id" => "show_add_to_cart",
                "type" => "switch",
                "title" => __("Show Add To Cart", "pe-core"),
                "on" => __("Yes", "pe-core"),
                "off" => __("No", "pe-core"),
                "default" => true,
            ],
            [
                'id' => 'add_to_cart_style',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Add to Cart Style', 'pe-core'),
                'options' => [
                    'wide' => esc_html__('Wide', 'pe-core'),
                    'icon' => esc_html__('Icon', 'pe-core'),

                ],
                'default' => ['wide']
            ],
            [
                'id' => 'add-to-cart-variables',
                'title' => esc_html__('Add To Cart Behavior (Variables)', 'pe-core'),
                'type' => 'select',
                'default' => 'popup',
                'class' => 'image-hover-',
                'options' => [
                    'popup' => esc_html__('Popup', 'pe-core'),
                    'fast' => esc_html__('Fast', 'pe-core'),
                ],
            ],
            [
                'id' => 'add-to-cart-vars',
                'type' => 'select',
                'title' => esc_html__('Add to cart variable', 'pe-core'),
                'multi' => false,
                'data' => 'callback',
                'args' => 'selectVars',
                'select2' => false,
                'required' => ['add-to-cart-variables', '=', 'fast'],
            ],
            [
                'id' => 'actions_orientation',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Actions Orientation', 'pe-core'),
                'options' => [
                    'column' => esc_html__('Vertical', 'pe-core'),
                    'row' => esc_html__('Horizontal', 'pe-core'),

                ],
                'default' => ['row']
            ],
            [
                'id' => 'actions_visibility',
                'type' => 'select',
                'multi' => false,
                'select2' => ['allowClear' => false],
                'title' => esc_html__('Actions Visibility', 'pe-core'),
                'options' => [
                    'hover' => esc_html__('Hover', 'pe-core'),
                    'visible' => esc_html__('Visible', 'pe-core'),

                ],
                'default' => ['hover']
            ],
            [
                "id" => "product_gallery",
                "type" => "switch",
                "title" => __("Product Gallery", "pe-core"),
                "on" => __("Yes", "pe-core"),
                "off" => __("No", "pe-core"),
                "default" => false,
            ],
            [
                'id' => 'image_hover',
                'title' => esc_html__('Hover', 'pe-core'),
                'type' => 'select',
                'default' => 'image',
                'class' => 'image-hover-',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'image' => esc_html__('Image', 'pe-core'),
                    'zoom-in' => esc_html__('Zoom In', 'pe-core'),
                    'zoom-out' => esc_html__('Zoom Out', 'pe-core'),
                ],
                'required' => ['product_gallery', '!=', true],
            ],
            [
                "id" => "show_categories",
                "type" => "switch",
                "title" => esc_html__("Show Categories", "pe-core"),
                "on" => esc_html__("Yes", "pe-core"),
                "off" => esc_html__("No", "pe-core"),
                "default" => true,

            ],
            [
                "id" => "single_categories_to_show",
                "title" => esc_html__("Select Categories", "pe-core"),
                "type" => "select",
                "select2" => true,
                "multi" => true,
                "data" => "terms",
                "args" => [
                    "taxonomy" => "product_cat",
                    "hide_empty" => true, // Boş kategorileri gizleme
                ],
                "required" => [
                    ["show_categories", "=", true],
                ],
            ],
            [
                "id" => "show_tags",
                "type" => "switch",
                "title" => esc_html__("Show Tags", "pe-core"),
                "on" => esc_html__("Yes", "pe-core"),
                "off" => esc_html__("No", "pe-core"),
                "default" => false,

            ],
            [
                "id" => "single_tags_to_show",
                "title" => esc_html__("Select Tags", "pe-core"),
                "type" => "select",
                "select2" => true,
                "multi" => true,
                "data" => "terms",
                "args" => [
                    "taxonomy" => "product_tag",
                    "hide_empty" => true, // Boş kategorileri gizleme
                ],
                "required" => [
                    ["show_tags", "=", true],
                ],
            ],
            [
                "id" => "show_variations",
                "type" => "switch",
                "title" => esc_html__("Show Variations", "pe-core"),
                "on" => esc_html__("Yes", "pe-core"),
                "off" => esc_html__("No", "pe-core"),
                "default" => false,

            ],
            [
                'id' => 'single_attributes_to_show',
                'type' => 'select',
                'title' => esc_html__('Select Variations', 'pe-core'),
                'multi' => true,
                'data' => 'callback',
                'args' => 'selectVars',
                'select2' => true,
                'required' => ['show_variations', '=', true],
            ],
            [
                "id" => "variations_swatches",
                "type" => "switch",
                "title" => esc_html__("Variations Swatches", "pe-core"),
                "on" => esc_html__("Yes", "pe-core"),
                "off" => esc_html__("No", "pe-core"),
                "default" => false,

                'required' => ['show_variations', '=', true],
            ],
        ],
    )
);


Redux::set_section(
    $opt_name,
    array(
        'title' => esc_html__('Archives Styles', 'pe-core'),
        'id' => 'archive--styless-2',
        'subsection' => true,
        'customizer_width' => '450px',
        'fields' => [
            [
                "id" => "product-styles-accordion-start",
                "type" => "section",
                "position" => "start",
            ],
            [
                'id' => 'shop-styles-heading',
                'type' => 'raw',
                'title' => esc_html__('Product Styles', 'pe-core'),
            ],
            [
                'id' => 'shop_page_title_alignment',
                'type' => 'button_set',
                'title' => esc_html__('Page Title Alignment', 'pe-core'),
                'options' => [
                    'left' => esc_html__('Left', 'pe-core'),
                    'center' => esc_html__('Center', 'pe-core'),
                    'right' => esc_html__('Right', 'pe-core'),
                ],
                'default' => 'center',
            ],
            [
                'id' => 'page_title_typography',
                'type' => 'typography',
                'title' => esc_html__('Page Title Typography', 'pe-core'),
                'output' => array('h1.woocommerce-products-header__title.page-title'),
                'font-family' => false,
                'text-align' => false,
                'color' => false,
                'font-subsets' => false,
                'text-decoration' => true,
                'text-transform' => true,
            ],
            [
                'id' => 'title_typography',
                'type' => 'typography',
                'title' => esc_html__('Title Typography', 'pe-core'),
                'output' => array('.woo-products-archive .saren--products-grid .product-name'),
                'font-family' => false,
                'text-align' => false,
                'color' => false,
                'font-subsets' => false,
                'text-decoration' => true,
            ],
            [
                'id' => 'price_typography',
                'type' => 'typography',
                'title' => esc_html__('Price Typography', 'pe-core'),
                'output' => array('.woo-products-archive .saren--products-grid .product-price'),
                'font-family' => false,
                'text-align' => false,
                'color' => false,
                'font-subsets' => false,
                'text-decoration' => true,
            ],
            [
                'id' => 'short_desc_typography',
                'type' => 'typography',
                'title' => esc_html__('Short Description Typography', 'pe-core'),
                'output' => array('.woo-products-archive .saren--products-grid .product-short-desc'),
                'font-family' => false,
                'text-align' => false,
                'color' => false,
                'font-subsets' => false,
                'text-decoration' => true,
            ],
            [
                'id' => 'prouct_metas_alignment',
                'type' => 'button_set',
                'title' => esc_html__('Metas Alignment', 'pe-core'),
                'options' => [
                    'start' => esc_html__('Left', 'pe-core'),
                    'center' => esc_html__('Center', 'pe-core'),
                    'end' => esc_html__('Right', 'pe-core')
                ],
                'default' => 'start',
                'output' => [
                    'element' => '.woo-products-archive .saren--products-grid .saren--product--main',
                    'property' => 'align-items'
                ]
            ],
            [
                'id' => 'archive_metas_gap',
                'type' => 'slider',
                'title' => esc_html__('Metas Gap', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'display_value' => 'px',
                "class" => "archive--metas--gap",
                'output_variables' => true,
            ],
            [
                'id' => 'metas_padding',
                'type' => 'spacing',
                'output' => array('.woo-products-archive .saren--products-grid .saren--product--meta'),
                'mode' => 'padding',
                'units' => array('em', 'px'),
                'units_extended' => 'false',
                'title' => esc_html__('Metas Padding', 'pe-core'),
            ],
            [
                'id' => 'single_product_border',
                'type' => 'border',
                'title' => esc_html__('Border', 'pe-core'),
                'output' => array('.woo-products-archive .saren--products-grid .saren--single--product'),
            ],
            [
                'id' => 'border_radius_product_image',
                'type' => 'spacing',
                'output_variables' => true,
                'units' => array('px'),
                'units_extended' => 'false',
                'title' => esc_html__('Border Radius (Image)', 'pe-core'),
            ],
            [
                'id' => 'border_radius_product',
                'type' => 'spacing',
                'output_variables' => true,
                'units' => array('px'),
                'units_extended' => 'false',
                'title' => esc_html__('Border Radius (Product)', 'pe-core'),
            ],
            [
                'id' => 'single_product_width',
                'type' => 'slider',
                'title' => esc_html__('Width', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],
            [
                'id' => 'single_product_height',
                'type' => 'slider',
                'title' => esc_html__('Height', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],
            [
                'id' => 'image_position',
                'type' => 'button_set',
                'title' => esc_html__('Image Position', 'pe-core'),
                'options' => [
                    'top' => esc_html__('Top', 'pe-core'),
                    'center' => esc_html__('Center', 'pe-core'),
                    'bottom' => esc_html__('Bottom', 'pe-core')
                ],
                'default' => 'top',
                'output' => [
                    'element' => '.saren--products-grid .saren--product--image img',
                    'property' => 'object-position'
                ]
            ],
            [
                'id' => 'product__actions__heading_space',
                'type' => 'raw'
            ],
            [
                'id' => 'product__actions__heading',
                'title' => esc_html__('Product Actions Styles', 'pe-core'),
                'type' => 'raw'
            ],
            [
                'id' => 'actions_alignment',
                'type' => 'button_set',
                'title' => esc_html__('Actions Alignment', 'pe-core'),
                'options' => [
                    'start' => esc_html__('Left', 'pe-core'),
                    'center' => esc_html__('Center', 'pe-core'),
                    'end' => esc_html__('Right', 'pe-core')
                ],
                'default' => 'start',
                'output' => [
                    'element' => '.saren--products-grid .saren--product-quick-action , .saren--products-grid .saren--single--atc .saren--cart--form',
                    'property' => 'object-position'
                ]
            ],
            [
                'id' => 'product_action_styles_border',
                'type' => 'border',
                'title' => esc_html__('Border', 'pe-core'),
                'output' => array('.saren--products-grid .saren--product-quick-action , .saren--products-grid .saren--single--atc .saren--cart--form', ),
            ],
            [
                'id' => 'product_action_styles_has_border_radius',
                'type' => 'spacing',
                'output' => [
                    'element' => array('.saren--products-grid .saren--product-quick-action , .saren--products-grid .saren--single--atc .saren--cart--form', ),
                    'property' => '--radius'
                ],
                'mode' => 'border-radius',
                'units' => array('px', 'em', 'rem', '%', ),
                'units_extended' => 'false',
                'title' => esc_html__('Border Radius', 'pe-core'),
            ],
            [
                'id' => 'product_action_styles_has_padding',
                'type' => 'spacing',
                'output' => [
                    'element' => array('.saren--products-grid .saren--product-quick-action , .saren--products-grid .saren--single--atc .saren--cart--form', ),
                    'property' => '--radius'
                ],
                'mode' => 'padding',
                'units' => array('px', 'em', 'rem', '%', ),
                'units_extended' => 'false',
                'title' => esc_html__('Padding', 'pe-core'),
            ],
            [
                'id' => 'product_action_styles_width',
                'type' => 'slider',
                'title' => esc_html__('Width', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],
            [
                'id' => 'product_action_styles_height',
                'type' => 'slider',
                'title' => esc_html__('Height', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],


            [
                "id" => "extras-styles-accordion-start",
                "type" => "section",
                "position" => "start",
            ],
            [
                'id' => 'extras-styles-heading',
                'type' => 'raw',
                'title' => esc_html__('Extras Styles', 'pe-core'),
            ],
            [
                'id' => 'extras_orientation',
                'type' => 'button_set',
                'title' => esc_html__('Extras Orientation', 'pe-core'),
                'options' => [
                    'column' => esc_html__('Column', 'pe-core'),
                    'row' => esc_html__('Row', 'pe-core')
                ],
                'default' => 'column',
                'output_variables' => true
            ],
            [
                'id' => 'prouct_extras_alignment_column',
                'title' => esc_html__('Alignment', 'pe-core'),
                'type' => 'button_set',
                'options' => [
                    'start' => esc_html__('Left', 'pe-core'),
                    'center' => esc_html__('Center', 'pe-core'),
                    'right' => esc_html__('Right', 'pe-core')
                ],
                'default' => 'start',
                'required' => ['extras_orientation', '=', 'column'],
            ],

            [
                'id' => 'prouct_extras_alignment_row',
                'title' => esc_html__('Alignment', 'pe-core'),
                'type' => 'button_set',
                'options' => [
                    'start' => esc_html__('Left', 'pe-core'),
                    'center' => esc_html__('Center', 'pe-core'),
                    'right' => esc_html__('Right', 'pe-core'),
                    'space-between' => esc_html__('Space Between', 'pe-core')
                ],
                'default' => 'space-between',
                'output' => [
                    'element' => '.saren--products-grid .saren--product--extras, .saren--products-grid .saren--single--product--attributes',
                    'property' => 'justify-content'
                ],
                'required' => ['extras_orientation', '=', 'row'],
            ],
            [
                'id' => 'extras_gap',
                'type' => 'slider',
                'title' => esc_html__('Extras Gap', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],
            [
                'id' => 'product_tags_typoraphy',
                'type' => 'typography',
                'title' => esc_html__('Tags Typography', 'pe-core'),
                'output' => array('.saren--products-grid .saren--product--tags')
            ],
            [
                'id' => 'product_tags_color',
                'title' => esc_html__('Tags Color', 'pe-core'),
                'type' => 'color',
                'output' => [
                    'element' => '.saren--products-grid .saren--product--tags',
                    'property' => 'color'
                ],
            ],
            [
                'id' => 'varitations_typoraphy',
                'type' => 'typography',
                'title' => esc_html__('Variations Typography', 'pe-core'),
                'output' => array('.saren--products-grid .saren--product--extras > div.saren--single--product--attributes .single--product--attributes:not(.attr--dt--variation_color_only) > span')
            ],
            [
                'id' => 'single_variations_border',
                'type' => 'border',
                'title' => esc_html__('Varitaions Border', 'pe-core'),
                'output' => array('.saren--products-grid  .saren--product--extras > div.saren--single--product--attributes .single--product--attributes:not(.attr--dt--variation_color_only) > span'),
            ],
            [
                'id' => 'single_variations_border_radius',
                'type' => 'spacing',
                'output' => [
                    'element' => array('.saren--products-grid  .saren--product--extras > div.saren--single--product--attributes .single--product--attributes:not(.attr--dt--variation_color_only) > span'),
                    'property' => 'border-radius'
                ],
                'mode' => 'border-radius',
                'units' => array('px', 'em', 'rem', '%', ),
                'units_extended' => 'false',
                'title' => esc_html__('Varitaions Border Radius', 'pe-core'),
            ],
            [
                'id' => 'single_variations_colors_border',
                'type' => 'border',
                'title' => esc_html__('Varitaions (Colors) Border', 'pe-core'),
                'output' => array('.saren--products-grid  .saren--product--extras > div.saren--single--product--attributes .single--product--attributes.attr--dt--variation_color_only > span'),
            ],
            [
                'id' => 'single_variations_colors_border_radius',
                'type' => 'spacing',
                'output' => [
                    'element' => array('.saren--products-grid  .saren--product--extras > div.saren--single--product--attributes .single--product--attributes.attr--dt--variation_color_only > span'),
                    'property' => 'border-radius'
                ],
                'mode' => 'border-radius',
                'units' => array('px', 'em', 'rem', '%', ),
                'units_extended' => 'false',
                'title' => esc_html__('Varitaions (Colors) Border Radius', 'pe-core'),
            ],
            [
                'id' => 'single_variations_colors_size',
                'type' => 'slider',
                'title' => esc_html__('Colors Size', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],
            [
                'id' => 'cats_order',
                'type' => 'text',
                'title' => esc_html__('Categories Order', 'pe-core')
            ],
            [
                'id' => 'tags_order',
                'type' => 'text',
                'title' => esc_html__('Tags Order', 'pe-core')
            ],
            [
                'id' => 'attributes_order',
                'type' => 'text',
                'title' => esc_html__(' Order', 'pe-core')
            ],
            [
                'id' => 'extras-styles-accordion-end',
                'type' => 'accordion',
                'position' => 'end'
            ],
            [
                "id" => "filters-styles-accordion-start",
                "type" => "section",
                "position" => "start",
            ],
            [
                'id' => 'wishlist-button-styles-heading',
                'type' => 'raw',
                'title' => esc_html__('Wishlist Button', 'pe-core'),
            ],
            [
                'id' => 'wishlist_use_custom_icon',
                'type' => 'button_set',
                'title' => esc_html__('Use Custom Icons', 'pe-core'),
                'options' => [
                    'yes' => esc_html__('Yes', 'pe-core'),
                    'no' => esc_html__('No', 'pe-core'),
                ],
                'default' => 'no',
            ],

            [
                'id' => 'wishlist_show_caption',
                'type' => 'button_set',
                'title' => esc_html__('Show Caption', 'pe-core'),
                'options' => [
                    'yes' => esc_html__('Yes', 'pe-core'),
                    'no' => esc_html__('No', 'pe-core'),
                ],
                'default' => 'no',
            ],

            [
                'id' => 'wishlist_add_icon',
                'type' => 'icon_select',
                'title' => esc_html__('Add Icon', 'pe-core'),
                'required' => ['wishlist_use_custom_icon', '=', 'yes']
            ],

            [
                'id' => 'wishlist_added_icon',
                'type' => 'icon_select',
                'title' => esc_html__('Added Icon', 'pe-core'),
                'required' => ['wishlist_use_custom_icon', '=', 'yes']
            ],

            [
                'id' => 'wishlist_add_caption',
                'type' => 'text',
                'title' => __('Add Catption', 'pe-core'),
                'default' => esc_html__('Add to wishlist.', 'pe-core'),
                'required' => [
                    ['wishlist_show_caption', '=', 'yes'],
                ]
            ],
            [
                'id' => 'wishlist_added_caption',
                'type' => 'text',
                'title' => __('Added Catption', 'pe-core'),
                'default' => esc_html__('Remove from wishlist.', 'pe-core'),
                'required' => [
                    ['wishlist_show_caption', '=', 'yes'],
                ]
            ],
            [
                'id' => 'wishlist-button-styles-accordion-end',
                'type' => 'accordion',
                'position' => 'end'
            ],
            [
                'id' => 'filters-styles-heading',
                'type' => 'raw',
                'title' => esc_html__('Filters Styles', 'pe-core'),
            ],
            [
                'id' => 'filters_spacing',
                'type' => 'slider',
                'title' => esc_html__('Filters Spacing', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],
            [
                'id' => 'filters_sepeator',
                'type' => 'switch',
                'title' => esc_html__('Filters Seperator', 'pe-core')
            ],
            [
                'id' => 'filters-styles-accordion-end',
                'type' => 'accordion',
                'position' => 'end'
            ],
            [
                "id" => "controls-styles-accordion-start",
                "type" => "section",
                "position" => "start",
            ],
            [
                'id' => 'controls-styles-heading',
                'type' => 'raw',
                'title' => esc_html__('Controls Styles', 'pe-core'),
            ],
            [
                "id" => "controls_typography",
                "type" => "typography",
                "title" => __("Controls Typography", "pe-core"),
                "google" => true,
                "font-backup" => true,
                "letter-spacing" => true,
                'output' => array('.woo-products-archive .pe--product--filters label, .woo-products-archive .filters--button.pe--pop--button , .woo-products-archive .select-items div, .woo-products-archive .select-selected'),
                "units" => "px",
            ],
            [
                "id" => 'has_border',
                'type' => 'switch',
                'title' => esc_html__('Border', 'pe-core')
            ],
            [
                "id" => 'has_rounded',
                'type' => 'switch',
                'title' => esc_html__('Rounded', 'pe-core')
            ],
            [
                "id" => 'has_bg',
                'type' => 'switch',
                'title' => esc_html__('Backgroudn', 'pe-core')
            ],
            [
                'id' => 'has_bg_color',
                'title' => esc_html__('Backgorund Color', 'pe-core'),
                'type' => 'color',
            ],
            [
                'id' => 'has_border_radius',
                'type' => 'spacing',
                'output' => array('.saren--products-grid .products--controls--bordered .select-selected,{{WRAPPER}} .saren--products--layout--switcher'),
                'mode' => 'border-radius',
                'units' => array('px'),
                'units_extended' => 'false',
                'title' => esc_html__('Border Radius ', 'pe-core'),
            ],
            [
                'id' => 'has_padding',
                'type' => 'spacing',
                'output' => array('.woo-products-archive .pe--product--filters label, .woo-products-archive .filters--button.pe--pop--button , .woo-products-archive .select-items div, .woo-products-archive .select-selected'),
                'mode' => 'padding',
                'units' => array('px'),
                'units_extended' => true,
                'title' => esc_html__('Padding ', 'pe-core'),
            ],
            [],
            [
                'id' => 'controls_alignment',
                'type' => 'button_set',
                'title' => esc_html__('Controls Alignment', 'pe-core'),
                'options' => [
                    'start' => esc_html__('Start', 'pe-core'),
                    'center' => esc_html__('Center', 'pe-core'),
                    'end' => esc_html__('End', 'pe-core'),
                    'space-between' => esc_html__('Space Between', 'pe-core'),
                ],
                'default' => 'space-between',
                'output' => [
                    'element' => '.saren--products--grid--controls',
                    'property' => 'justify-content'
                ]
            ],
            [
                'id' => 'controls_spacing',
                'type' => 'slider',
                'title' => esc_html__('Controls Spacing', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],
            [
                'id' => 'control-styles-accordion-end',
                'type' => 'accordion',
                'position' => 'end'
            ],
            [
                "id" => "grid-styles-accordion-start",
                "type" => "section",
                "position" => "start",
            ],
            [
                'id' => 'grid-styles-heading',
                'type' => 'raw',
                'title' => esc_html__('Grid Styles', 'pe-core'),
            ],
            [
                'id' => 'shop_wrapper_paddings',
                'type' => 'spacing',
                'output' => ['.section.woo-products-archive .pe-wrapper'],
                'mode' => 'padding',
                'units' => array('px', 'em', 'rem', '%', ),
                'units_extended' => 'false',
                'title' => esc_html__('Wrapper Padding', 'pe-core'),
            ],
            [
                'id' => 'grid_borders',
                'type' => 'border',
                'title' => esc_html__('Borders', 'pe-core'),
                'output' => array('.saren--products-grid'),
            ],
            [
                'id' => 'grid_columns_gap',
                'type' => 'slider',
                'title' => esc_html__('Grid Columns Gap', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'output_variables' => true,
                "class" => "products--archive--grid--gap--third",
            ],

            [
                'id' => 'grid_rows_gap',
                'type' => 'slider',
                'title' => esc_html__('Grid Rows Gap', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],
            [
                'id' => 'masonry_items_width',
                'type' => 'slider',
                'title' => esc_html__('Masonry Items Width', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],
            [
                'id' => 'masonry_items_gutter',
                'type' => 'slider',
                'title' => esc_html__('Masonry Items Gutter', 'pe-core'),
                'min' => 0,
                'max' => 1000,
                'step' => 1
            ],
            [
                'id' => 'grid-styles-accordion-end',
                'type' => 'accordion',
                'position' => 'end'
            ],
        ]

    )

);

Redux::set_section(
    $opt_name,
    array(
        'title' => esc_html__('Single Product', 'pe-core'),
        'id' => 'single-product--opts',
        'subsection' => true,
        'customizer_width' => '450px',

        'fields' => [
            [
                "id" => "single--product",
                "type" => "section",
                "subsection" => true,
                "indent" => true,
            ],
            [
                'id' => 'single--product--options',
                'type' => 'raw',
                'title' => esc_html__('Single Product', 'pe-core'),
            ],
            array(
                'id' => 'single-product-layout',
                'type' => 'button_set',
                'title' => __('Single Product Layout', 'pe-core'),
                'options' => array(
                    'default' => 'Default',
                    'custom' => 'Custom',
                ),
                'default' => 'default',

            ),
            [
                "id" => "select-single-product-template",
                "type" => "select",
                "select2" => false,
                "data" => "posts",
                "args" => [
                    "post_type" => ["elementor_library"],
                    "posts_per_page" => -1,
                ],
                "title" => __("Select Single Product Template", 'pe-core'),
                "subtitle" => esc_html__(
                    "Select Elementor single product template.",
                    "pe-core"
                ),
                'required' => [
                    ['single-product-layout', '=', 'custom'],
                ],
                "validate_callback" => "pe_translate_elementor_template"
            ],
            array(
                'id' => 'product_gallery_type',
                'type' => 'button_set',
                'title' => __('Product Gallery Type', 'pe-core'),
                'subtitle' => __('If you select "sticky" product meta will be pinned to product gallery.', 'pe-core'),
                'options' => array(
                    'gal-static' => 'Static',
                    'gal-sticky' => 'Sticky',
                ),
                'default' => 'gal-static',
                'required' => [
                    ['single-product-layout', '=', 'default'],
                ]
            ),
            array(
                'id' => 'image-sizes',
                'type' => 'select',
                'title' => esc_html__('Gallery Image Heights', 'pe-core'),
                'options' => array(
                    'img-default' => 'Theme Default',
                    'img-masonry' => 'Masonry',
                ),
                'default' => 'img-default',
                'required' => [
                    ['single-product-layout', '=', 'default'],
                ]
            ),

            array(
                'id' => 'pgal-image-height',
                'type' => 'slider',
                'title' => esc_html__('Image Height (vh)', 'pe-core'),
                "default" => 50,
                "min" => 1,
                "step" => 1,
                "max" => 100,
                'display_value' => 'vh',
                'output_variables' => true,
                'required' => [
                    ['image-sizes', '!=', 'img-masonry'],
                    ['single-product-layout', '=', 'default'],
                ]

            ),


            array(
                'id' => 'pgal-mobile-width',
                'type' => 'slider',
                'title' => esc_html__('Gallery Width (vw)', 'pe-core'),
                'subtitle' => __('For mobile screens', 'pe-core'),
                "default" => 50,
                "min" => 1,
                "step" => 1,
                "max" => 100,
                'display_value' => 'vh',
                'output_variables' => true,
                'required' => [
                    ['image-sizes', '!=', 'img-masonry'],
                    ['single-product-layout', '=', 'default'],
                ]
            ),
            array(
                'id' => 'image-cols',
                'type' => 'select',
                'title' => esc_html__('Gallery Image Columns', 'pe-core'),
                'options' => array(
                    'gal-col-1' => '1 Column',
                    'gal-col-2' => '2 Columns',
                ),
                'default' => 'gal-col-2',
                'required' => [
                    ['image-sizes', '!=', 'img-masonry'],
                    ['single-product-layout', '=', 'default'],
                ]

            ),
            array(
                'id' => 'show_related_products',
                'type' => 'switch',
                'title' => __('Related Products', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => false,
                'subtitle' => __('Switch "Hide" if you dont want to display related products.', 'pe-core'),
                'required' => [
                    ['single-product-layout', '=', 'default'],
                ]
            ),



            array(
                'id' => 'related_products_title_show',
                'type' => 'switch',
                'title' => __('Related Products Title', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display related products title.', 'pe-core'),
                'required' => [
                    ['single-product-layout', '=', 'default'],
                ]
            ),

            array(
                'id' => 'related_products_title',
                'type' => 'text',
                'title' => __('Related Products Title', 'pe-core'),
                'subtitle' => __('Enter related products title', 'pe-core'),
                'default' => __('Related Products', 'pe-core'),
                'required' => [
                    ['single-product-layout', '=', 'default'],
                ]
            ),

            array(
                'id' => 'show_sku',
                'type' => 'switch',
                'title' => __('SKU', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display product SKU.', 'pe-core'),
                'required' => [
                    ['single-product-layout', '=', 'default'],
                ]
            ),

            array(
                'id' => 'show_product_category',
                'type' => 'switch',
                'title' => __('Category', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display product category.', 'pe-core'),
                'required' => [
                    ['single-product-layout', '=', 'default'],
                ]
            ),

            array(
                'id' => 'show_product_tags',
                'type' => 'switch',
                'title' => __('Tags', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display product tags.', 'pe-core'),
                'required' => [
                    ['single-product-layout', '=', 'default'],
                ]
            ),

            array(
                'id' => 'show_short_description',
                'type' => 'switch',
                'title' => __('Short Description', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display product short description.', 'pe-core'),
                'required' => [
                    ['single-product-layout', '=', 'default'],
                ]
            ),

            array(
                'id' => 'add_to_cart_qty',
                'type' => 'switch',
                'title' => __('Add to Cart Button Quantity', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display product quantity option on add to cart button.', 'pe-core'),
                'required' => [
                    ['single-product-layout', '=', 'default'],
                ]
            ),
        ],
    )
);

Redux::set_section(
    $opt_name,
    array(
        'title' => esc_html__('Checkout Fields', 'pe-core'),
        'id' => 'checkout-fields',
        'subsection' => true,
        'customizer_width' => '450px',

        'fields' => [
            [
                'id' => 'checkout-fields-repeater',
                'type' => 'repeater',
                'bind_title' => 'field_id',
                'group_values' => true, // Group all fields below within the repeater ID
                'title' => esc_html__('Checkout Fields', 'pe-core'),
                'desc' => esc_html__('Click on "Add" button and edit the preferences of fields by id. ', 'pe-core'),
                'fields' => [
                    [
                        'id' => 'field_form',
                        'type' => 'select',
                        'multi' => false,
                        'title' => esc_html__('Field Form', 'pe-core'),
                        'options' => [
                            'billing' => esc_html__('Billing', 'pe-core'),
                            'shipping' => esc_html__('Shipping', 'pe-core'),
                        ],
                        'default' => 'billing',
                        'select2' => ['allowClear' => false],
                    ],
                    [
                        'id' => 'field_id',
                        'type' => 'text',
                        'title' => __('Field ID', 'pe-core'),
                        'desc' => __('Unique ID for the field (e.g., billing_phone).', 'pe-core'),
                    ],
                    [
                        'id' => 'field_label',
                        'type' => 'text',
                        'title' => __('Field Label', 'pe-core'),
                        'desc' => __('The label for the field.', 'pe-core'),
                    ],
                    [
                        'id' => 'field_required',
                        'type' => 'switch',
                        'title' => __('Required', 'pe-core'),
                        'on' => __('Yes', 'pe-core'),
                        'off' => __('No', 'pe-core'),
                    ],
                    [
                        'id' => 'field_priority',
                        'type' => 'text',
                        'title' => __('Priority', 'pe-core'),
                        'desc' => __('The order of the field on the checkout page.', 'pe-core'),
                    ],



                ],

            ],
            [
                'id' => 'field_id_list',
                'type' => 'raw',
                'title' => esc_html__('Available WooCommerce field ids', 'pe-core'),
                'content' => '<div class="list--of--ids">
                
               <ul>
               <li><strong>Billing Fields</strong></li>
                <li>billing_first_name</li>
                <li>billing_last_name</li>
                <li>billing_company</li>
                <li>billing_address_1</li>
                <li>billing_address_2</li>
                <li>billing_city</li>
                <li>billing_postcode</li>
                <li>billing_country</li>
                <li>billing_state</li>
                <li>billing_email</li>
                <li>billing_phone</li>
                </ul>
             
                <ul>
               <li><strong>Shipping Fields</strong></li>
                <li>shipping_first_name</li>
                <li>shipping_last_name</li>
                <li>shipping_company</li>
                <li>shipping_address_1</li>
                <li>shipping_address_2</li>
                <li>shipping_city</li>
                <li>shipping_postcode</li>
                <li>shipping_country</li>
                <li>shipping_state</li>
                </ul>

                </div>' // Now let's set that in the raw field.
            ]
        ],

    )
);


Redux::setSection($opt_name, [
    "title" => esc_html__("Page Loader", "pe-core"),
    "id" => "pageLoader",
    "icon" => "eicon-spinner",
    "fields" => [
        [
            "id" => "loader--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            "id" => "loader_type",
            'type' => 'image_select',
            'title' => esc_html__('Loader Type', 'pe-core'),
            "class" => "pe--image--select",
            'options' => array(
                'overlay' => array(
                    'alt' => 'Overlay',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--1.png',
                    'title' => 'Overlay'
                ),
                'fade' => array(
                    'alt' => 'Fade',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--2.png',
                    'title' => 'Fade'
                ),
                'slide' => array(
                    'alt' => 'Slide',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--3.png',
                    'title' => 'Slide'
                ),
                'columns' => array(
                    'alt' => 'Columns',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--4.png',
                    'title' => 'Columns'
                ),
                'rows' => array(
                    'alt' => 'Rows',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--5.png',
                    'title' => 'Rows'
                ),
                'blocks' => array(
                    'alt' => 'Blocks',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--6.png',
                    'title' => 'Blocks'
                )
            ),
            "default" => "overlay",
        ],

        [
            "id" => "fade_simple",
            "type" => "switch",
            "title" => __("Simple Fade", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => false,
            'required' => ['loader_type', '=', 'fade']
        ],
        [
            "id" => "fade_direction",
            "type" => "button_set",
            "title" => __("Fade Direction", "pe-core"),
            "options" => [
                "up" => "Up",
                "down" => "Down",
                "center" => "Center",
                "left" => "Left",
                "right" => "Right",
            ],
            "default" => "center",
            'required' => [
                'fade_simple',
                '!=',
                true,
            ]
        ],
        [
            "id" => "stagger_from",
            "type" => "select",
            "title" => __("Stagger From", "pe-core"),
            'select2' => ['allowClear' => false],
            "options" => [
                "start" => "Start",
                "center" => "Center",
                "end" => "End",
                "random" => "Random",
            ],
            "default" => "random",
            'required' => [
                'loader_type',
                '=',
                ['columns', 'rows', 'blocks'],
            ]

        ],
        [
            "id" => "blocks_aimation",
            "type" => "select",
            "title" => __("Blocks Animation", "pe-core"),
            'select2' => ['allowClear' => false],
            "options" => [
                "scale" => "Scale",
                "fade" => "Fade",
                "left" => "Left",
                "right" => "Right",
                "top" => "Top",
                "bottom" => "Bottom",
            ],
            "class" => "pe--field--third",
            "default" => "scale",
            'required' => [
                'loader_type',
                '=',
                ['blocks'],
            ]

        ],
        [
            "id" => "columns_direction",
            "type" => "button_set",
            "title" => __("Columns Direction", "pe-core"),
            "options" => [
                "up" => "Up",
                "down" => "Down",
            ],
            "default" => "up",
            'required' => [
                'loader_type',
                '=',
                'columns',
            ]

        ],
        [
            "id" => "rows_direction",
            "type" => "button_set",
            "title" => __("Rows Direction", "pe-core"),
            "options" => [
                "left" => "Left",
                "right" => "Right",
            ],
            "default" => "left",
            'required' => [
                'loader_type',
                '=',
                'rows',
            ]

        ],
        [
            "id" => "loader_direction",
            "type" => "button_set",
            "title" => __("Loader Direction", "pe-core"),
            "options" => [
                "up" => "Up",
                "down" => "Down",
                "left" => "Left",
                "right" => "Right",
            ],
            "default" => "left",
            'required' => [
                'loader_type',
                '=',
                ['overlay', 'slide'],
            ]

        ],
        [
            'id' => 'loader__blocks__rows',
            'type' => 'slider',
            'title' => esc_html__('Blocks Grid Rows', 'pe-core'),
            'display_value' => 'label',
            'min' => 3,
            'max' => 20,
            'default' => 4,
            'step' => 1,
            'output_variables' => true,
            "class" => "pe--field--third",
            'required' => ['loader_type', '=', 'blocks']
        ],
        [
            'id' => 'loader__blocks__columns',
            'type' => 'slider',
            'title' => esc_html__('Blocks Grid Columns', 'pe-core'),
            'display_value' => 'label',
            'min' => 3,
            'max' => 20,
            'default' => 3,
            'step' => 1,
            'output_variables' => true,
            "class" => "pe--field--third",
            'required' => ['loader_type', '=', 'blocks']
        ],
        [
            'id' => 'loader__columns__number',
            'type' => 'slider',
            'title' => esc_html__('Columns Number', 'pe-core'),
            'display_value' => 'label',
            'min' => 3,
            'max' => 20,
            'default' => 6,
            'step' => 1,
            'required' => ['loader_type', '=', 'columns']
        ],
        [
            'id' => 'loader__rows__number',
            'type' => 'slider',
            'title' => esc_html__('Rows Number', 'pe-core'),
            'display_value' => 'label',
            'min' => 3,
            'max' => 20,
            'default' => 6,
            'step' => 1,
            'required' => ['loader_type', '=', 'rows']
        ],
        [
            "id" => "loader_curved",
            "type" => "switch",
            "title" => __("Curved Overlay", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => false,
            'required' => ['loader_type', '=', 'overlay']
        ],
        [
            'id' => 'loader_curve',
            'type' => 'dimensions',
            'height' => false,
            'units' => array('em', 'px', '%'),
            'title' => esc_html__('Curve Size', 'pe-core'),
            'required' => ['loader_curved', '=', true],
            'output_variables' => true,
        ],
        [
            'id' => 'loader_duration',
            'type' => 'slider',
            'title' => esc_html__('Loader Duration', 'pe-core'),
            'subtitle' => esc_html__('Minimum loader time by ms.', 'pe-core'),
            'display_value' => 'label',
            'min' => 1000,
            'max' => 10000,
            'default' => 3500,
            'step' => 100
        ],


        [
            'id' => 'loader_elements',
            'type' => 'select',
            'multi' => true,
            'title' => esc_html__('Loader Elements', 'pe-core'),
            'options' => [
                'caption' => esc_html__('Caption', 'pe-core'),
                'logo' => esc_html__('Logo', 'pe-core'),
                'counter' => esc_html__('Counter', 'pe-core'),
                'progressbar' => esc_html__('Progressbar', 'pe-core'),
            ],
            'default' => ['counter']
        ],
        [
            "id" => "loader_logo",
            "type" => "media",
            "url" => true,
            "class" => "pr--logo pr--fill--box",
            "preview_size" => "full",
            "title" => esc_html__("Loader Logo", "pe-core"),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
            'required' => ['loader_elements', '=', 'logo']
        ],
        [
            "id" => "show_perc",
            "type" => "switch",
            "title" => __("Show Percentage", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => false,
            'required' => ['loader_elements', '=', 'progressbar']
        ],
        [
            'id' => 'caption_style',
            'type' => 'select',
            'multi' => false,
            'title' => esc_html__('Caption Style', 'pe-core'),
            'options' => [
                'simple' => esc_html__('Simple', 'pe-core'),
                'marquee' => esc_html__('Marquee', 'pe-core'),
                'repeater' => esc_html__('Repeater', 'pe-core'),
            ],
            "default" => 'simple',
            'required' => ['loader_elements', '=', 'caption']
        ],
        [
            'id' => 'caption_animation',
            'type' => 'select',
            'multi' => false,
            'title' => esc_html__('Animation', 'pe-core'),
            'options' => [
                'progress' => esc_html__('Progress', 'pe-core'),
                'fade' => esc_html__('Fade', 'pe-core'),
                'chars' => esc_html__('Chars', 'pe-core'),
                'words' => esc_html__('Words', 'pe-core'),
            ],
            "default" => 'fade',
            'required' => ['caption_style', '=', ['simple']]
        ],
        [
            "id" => "loader_caption",
            "type" => "text",
            "title" => esc_html__("Loader Caption", "pe-core"),
            "default" => esc_html__("Loading, please wait..", "pe-core"),
            'required' => ['caption_style', '=', ['simple', 'marquee']]
        ],
        [
            "id" => "repeater_captions",
            "type" => "text",
            "title" => esc_html__("Loader Caption", "pe-core"),
            "placeholder" => esc_html__("Loading , Please , Wait", "pe-core"),
            "description" => esc_html__("Seperate each text with a comma (,)", "pe-core"),
            'required' => ['caption_style', '=', ['repeater']]
        ],


        [
            "id" => "loader--styles",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'loader-styles-heading',
            'type' => 'raw',
            'title' => esc_html__('Loader Styles', 'pe-core'),
        ],

        [
            'id' => 'only--home',
            'type' => 'switch',
            'title' => __('Only on Homepage', 'pe-core'),
            'on' => __('Yes', 'pe-core'),
            'off' => __('No', 'pe-core'),
            'default' => false,
            'subtitle' => esc_html__('Page loader will be running only on homepage.', 'pe-core'),
        ],
        [
            'id' => 'disable--for--admin',
            'type' => 'switch',
            'title' => __('Disable for Admins', 'pe-core'),
            'on' => __('Yes', 'pe-core'),
            'off' => __('No', 'pe-core'),
            'default' => false,
            'subtitle' => esc_html__('Usefull when editing/customizing the website.', 'pe-core'),
        ],

        [
            "id" => "loader_background",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Loader Background Color", "pe-core"),
            "validate" => "color",
            "output" => [
                "--secondaryBackground" => ".pe--page--loader",
                "important" => true,
            ],
            "transparent" => false,
        ],

        [
            "id" => "loader_colors",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Loader Texts Color", "pe-core"),
            "validate" => "color",
            "output" => [
                "--mainColor" => ".pe--page--loader",
                "important" => true,
            ],
            "transparent" => false,
        ],
        [
            "id" => "counter_v_align",
            "type" => "button_set",
            "title" => __("Counter Vertical Align", "pe-core"),

            "options" => [
                "top" => "Top",
                "middle" => "Middle",
                "bottom" => "Bottom",
            ],
            "default" => "bottom",
            'required' => ['loader_elements', '=', 'counter']
        ],
        [
            "id" => "counter_h_align",
            "type" => "button_set",
            "title" => __("Counter Horizontal Align", "pe-core"),
            "options" => [
                "left" => "Left",
                "center" => "Center",
                "right" => "Right",
            ],
            "default" => "right",
            'required' => ['loader_elements', '=', 'counter']
        ],
        [
            "id" => "counter_size",
            "type" => "typography",
            "class" => 'label--block',
            'font-family' => false,
            'font-style' => false,
            'font-weight' => false,
            'text-align' => false,
            'line-height' => false,
            'color' => false,
            'preview' => false,
            "title" => esc_html__("Counter Size", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [".page--loader--count"],
            "units" => "px",
            "default" => false,
            'required' => ['loader_elements', '=', 'counter'],

        ],
        [
            "id" => "caption_v_align",
            "type" => "button_set",
            "title" => __("Caption Vertical Align", "pe-core"),

            "options" => [
                "top" => "Top",
                "middle" => "Middle",
                "bottom" => "Bottom",
            ],
            "default" => "middle",
            'required' => ['loader_elements', '=', 'caption']
        ],
        [
            "id" => "caption_h_align",
            "type" => "button_set",
            "title" => __("Caption Horizontal Align", "pe-core"),
            "options" => [
                "left" => "Left",
                "center" => "Center",
                "right" => "Right",
            ],
            "default" => "center",
            'required' => ['loader_elements', '=', 'caption']
        ],
        [
            "id" => "caption_size",
            "type" => "typography",
            "class" => 'label--block',
            'font-family' => true,
            'font-style' => true,
            'font-weight' => true,
            'text-align' => true,
            'line-height' => true,
            'letter-spacing' => true,
            'color' => false,
            'preview' => false,
            "title" => esc_html__("Caption Typography", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [".page--loader--caption"],
            "units" => "px",
            "default" => false,
            'required' => ['loader_elements', '=', 'caption'],

        ],
        [
            "id" => "logo_v_align",
            "type" => "button_set",
            "title" => __("Logo Vertical Align", "pe-core"),

            "options" => [
                "top" => "Top",
                "middle" => "Middle",
                "bottom" => "Bottom",
            ],
            "default" => "middle",
            'required' => ['loader_elements', '=', 'logo']
        ],
        [
            "id" => "logo_h_align",
            "type" => "button_set",
            "title" => __("Logo Horizontal Align", "pe-core"),
            "options" => [
                "left" => "Left",
                "center" => "Center",
                "right" => "Right",
            ],
            "default" => "center",
            'required' => ['loader_elements', '=', 'logo']
        ],
        [
            'id' => 'loader_logo_width',
            'type' => 'dimensions',
            'height' => false,
            'units' => array('em', 'px', '%'),
            'title' => esc_html__('Logo Width', 'pe-core'),
            'required' => ['loader_elements', '=', 'logo'],
            "output" => [
                "width" => ".page--loader--logo",
            ],
        ],

    ],
]);

Redux::setSection($opt_name, [
    "title" => __("Page Transitions", "pe-core"),
    "id" => "page_transitions",
    "icon" => "eicon-page-transition",
    "fields" => [
        [
            "id" => "transitions--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            "id" => "transition_type",
            'type' => 'image_select',
            "class" => "pe--image--select",
            "title" => __("Transition Type", "pe-core"),
            'options' => array(
                'overlay' => array(
                    'alt' => 'Overlay',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--1.png',
                    'title' => 'Overlay'
                ),
                'fade' => array(
                    'alt' => 'Fade',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--2.png',
                    'title' => 'Fade'
                ),
                'slide' => array(
                    'alt' => 'Slide',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--3.png',
                    'title' => 'Slide'
                ),
                'columns' => array(
                    'alt' => 'Columns',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--4.png',
                    'title' => 'Columns'
                ),
                'rows' => array(
                    'alt' => 'Rows',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--5.png',
                    'title' => 'Rows'
                ),
                'blocks' => array(
                    'alt' => 'Blocks',
                    'img' => plugin_dir_url(__FILE__) . '../assets/img/opt--loader--6.png',
                    'title' => 'Blocks'
                )
            ),
            "default" => "overlay",
        ],
        [
            "id" => "transition_direction",
            "type" => "button_set",
            "title" => __("Transition Direction", "pe-core"),
            "options" => [
                "up" => "Up",
                "down" => "Down",
                "left" => "Left",
                "right" => "Right",
            ],
            "default" => "up",
            'required' => [
                'transition_type',
                '=',
                ['overlay', 'slide'],
            ]
        ],
        [
            "id" => "transitions_fade_simple",
            "type" => "switch",
            "title" => __("Simple Fade", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => false,
            'required' => ['transition_type', '=', 'fade']
        ],
        [
            "id" => "transitions_fade_direction",
            "type" => "button_set",
            "title" => __("Fade Direction", "pe-core"),
            "options" => [
                "up" => "Up",
                "down" => "Down",
                "center" => "Center",
                "left" => "Left",
                "right" => "Right",
            ],
            "default" => "center",
            'required' => [
                'transitions_fade_simple',
                '!=',
                true,
            ]
        ],

        [
            "id" => "transitions_stagger_from",
            "type" => "select",
            "title" => __("Stagger From", "pe-core"),
            'select2' => ['allowClear' => false],
            "options" => [
                "start" => "Start",
                "center" => "Center",
                "end" => "End",
                "random" => "Random",
            ],
            "default" => "random",
            'required' => [
                'transition_type',
                '=',
                ['columns', 'rows', 'blocks'],
            ]

        ],
        [
            "id" => "transitions_blocks_aimation",
            "type" => "select",
            "title" => __("Blocks Animation", "pe-core"),
            'select2' => ['allowClear' => false],
            "options" => [
                "scale" => "Scale",
                "fade" => "Fade",
                "left" => "Left",
                "right" => "Right",
                "top" => "Top",
                "bottom" => "Bottom",
            ],
            "class" => "pe--field--third",
            "default" => "scale",
            'required' => [
                'transition_type',
                '=',
                ['blocks'],
            ]

        ],
        [
            "id" => "transitions_columns_direction",
            "type" => "button_set",
            "title" => __("Columns Direction", "pe-core"),
            "options" => [
                "up" => "Up",
                "down" => "Down",
            ],
            "default" => "up",
            'required' => [
                'transition_type',
                '=',
                'columns',
            ]

        ],
        [
            "id" => "transitions_rows_direction",
            "type" => "button_set",
            "title" => __("Rows Direction", "pe-core"),
            "options" => [
                "left" => "Left",
                "right" => "Right",
            ],
            "default" => "left",
            'required' => [
                'transition_type',
                '=',
                'rows',
            ]

        ],
        [
            'id' => 'transitions__blocks__rows',
            'type' => 'slider',
            'title' => esc_html__('Blocks Grid Rows', 'pe-core'),
            'display_value' => 'label',
            'min' => 3,
            'max' => 20,
            'default' => 4,
            'step' => 1,
            'output_variables' => true,
            "class" => "pe--field--third",
            'required' => ['transition_type', '=', 'blocks']
        ],
        [
            'id' => 'transitions__blocks__columns',
            'type' => 'slider',
            'title' => esc_html__('Blocks Grid Columns', 'pe-core'),
            'display_value' => 'label',
            'min' => 3,
            'max' => 20,
            'default' => 3,
            'step' => 1,
            'output_variables' => true,
            "class" => "pe--field--third",
            'required' => ['transition_type', '=', 'blocks']
        ],
        [
            'id' => 'transitions__columns__number',
            'type' => 'slider',
            'title' => esc_html__('Columns Number', 'pe-core'),
            'display_value' => 'label',
            'min' => 3,
            'max' => 20,
            'default' => 6,
            'step' => 1,
            'required' => ['transition_type', '=', 'columns']
        ],
        [
            'id' => 'transitions__rows__number',
            'type' => 'slider',
            'title' => esc_html__('Rows Number', 'pe-core'),
            'display_value' => 'label',
            'min' => 3,
            'max' => 20,
            'default' => 6,
            'step' => 1,
            'required' => ['transition_type', '=', 'rows']
        ],

        [
            "id" => "transitions_curved",
            "type" => "switch",
            "title" => __("Curved Overlay", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => false,
            'required' => ['transition_type', '=', 'overlay']
        ],
        [
            'id' => 'transitions_curve',
            'type' => 'dimensions',
            'height' => false,
            'units' => array('em', 'px', '%'),
            'title' => esc_html__('Curve Size', 'pe-core'),
            'required' => ['transitions_curved', '=', true],
            'output_variables' => true,
        ],
        [
            'id' => 'transition_elements',
            'type' => 'select',
            'multi' => true,
            'title' => esc_html__('Transition Elements', 'pe-core'),
            'options' => [
                'caption' => esc_html__('Caption', 'pe-core'),
                'logo' => esc_html__('Logo', 'pe-core'),
            ],
            'default' => ['caption']
        ],
        [
            'id' => 'caption_type',
            'type' => 'select',
            'multi' => false,
            'title' => esc_html__('Caption Type', 'pe-core'),
            'options' => [
                'simple' => esc_html__('Simple', 'pe-core'),
                'marquee' => esc_html__('Marquee', 'pe-core'),
                'repeater' => esc_html__('Repeater', 'pe-core'),
            ],
            'default' => 'simple',
            'required' => ['transition_elements', '=', 'caption']
        ],
        [
            'id' => 'transition_caption_animation',
            'type' => 'select',
            'multi' => false,
            'title' => esc_html__('Animation', 'pe-core'),
            'options' => [
                'progress' => esc_html__('Progress', 'pe-core'),
                'fade' => esc_html__('Fade', 'pe-core'),
                'chars' => esc_html__('Chars', 'pe-core'),
                'words' => esc_html__('Words', 'pe-core'),
            ],
            "default" => 'fade',
            'required' => ['caption_type', '=', ['simple']]
        ],
        [
            "id" => "transition_caption",
            "type" => "text",
            "title" => esc_html__("Transition Caption", "pe-core"),
            "default" => esc_html__("Loading, please wait..", "pe-core"),
            'required' => ['caption_type', '=', ['simple', 'marquee']]
        ],
        [
            "id" => "transition_repeater_captions",
            "type" => "text",
            "title" => esc_html__("Loader Caption", "pe-core"),
            "placeholder" => esc_html__("Loading , Please , Wait", "pe-core"),
            "description" => esc_html__("Seperate each text with a comma (,)", "pe-core"),
            'required' => ['caption_type', '=', ['repeater']]
        ],

        [
            "id" => "transition_logo",
            "type" => "media",
            "url" => true,
            "class" => "pr--logo pr--fill--box",
            "preview_size" => "full",
            "title" => esc_html__("Transition Logo", "pe-core"),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
            'required' => ['transition_elements', '=', 'logo']
        ],

        [
            "id" => "transitions--styles",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'transitions-styles-heading',
            'type' => 'raw',
            'title' => esc_html__('Page Transitions Styles', 'pe-core'),
        ],

        [
            "id" => "transition_background",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Transition Background Color", "pe-core"),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--secondaryBackground" => ".page--transitions",
                "important" => true,
            ],
        ],
        [
            "id" => "transition_colors",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Transition Texts Color", "pe-core"),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--mainColor" => ".pt--element",
                "important" => true,
            ],
        ],
        [
            "id" => "trans_caption_v_align",
            "type" => "button_set",
            "title" => __("Caption Vertical Align", "pe-core"),

            "options" => [
                "top" => "Top",
                "middle" => "Middle",
                "bottom" => "Bottom",
            ],
            "default" => "middle",
            'required' => ['transition_elements', '=', 'caption']
        ],
        [
            "id" => "trans_caption_h_align",
            "type" => "button_set",
            "title" => __("Caption Horizontal Align", "pe-core"),
            "options" => [
                "left" => "Left",
                "center" => "Center",
                "right" => "Right",
            ],
            "default" => "center",
            'required' => ['transition_elements', '=', 'caption']
        ],
        [
            "id" => "trans_caption_size",
            "type" => "typography",
            "class" => 'label--100',
            'font-family' => true,
            'font-style' => true,
            'font-weight' => true,
            'text-align' => true,
            'line-height' => true,
            'letter-spacing' => true,
            'color' => false,
            'preview' => false,
            "title" => esc_html__("Caption Typography", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [".page--transition--caption"],
            "units" => "px",
            "default" => false,
            'required' => ['transition_elements', '=', 'caption'],

        ],
        [
            "id" => "trans_logo_v_align",
            "type" => "button_set",
            "title" => __("Logo Vertical Align", "pe-core"),

            "options" => [
                "top" => "Top",
                "middle" => "Middle",
                "bottom" => "Bottom",
            ],
            "default" => "middle",
            'required' => ['transition_elements', '=', 'logo']
        ],
        [
            "id" => "trans_logo_h_align",
            "type" => "button_set",
            "title" => __("Logo Horizontal Align", "pe-core"),
            "options" => [
                "left" => "Left",
                "center" => "Center",
                "right" => "Right",
            ],
            "default" => "center",
            'required' => ['transition_elements', '=', 'logo']
        ],
        [
            'id' => 'trans_loader_logo_width',
            'type' => 'dimensions',
            'height' => false,
            'units' => array('em', 'px', '%'),
            'title' => esc_html__('Logo Width', 'pe-core'),
            "output" => [
                "width" => ".pt--logo",
                "important" => true,
            ],
            'required' => ['transition_elements', '=', 'logo'],
        ]
    ],
]);


Redux::setSection($opt_name, [
    "title" => esc_html__("Smooth Scroll", "pe-core"),
    "id" => "smoothScroll",
    "icon" => "eicon-scroll",
    "fields" => [
        [
            "id" => "smooth--scroll--settings",
            "type" => "section",
            "subsection" => true,
            "indent" => false,
        ],
        [
            'id' => 'smooth-scroll-heading',
            'type' => 'raw',
            'title' => esc_html__('Smooth Scroll', 'pe-core'),
        ],

        [
            "id" => "smooth_strength",
            "type" => "text",
            "title" => __("Smooth Strength", "pe-core"),
            "default" => "0.8",
        ],
        [
            "id" => "normalize_scroll",
            "type" => "switch",
            "title" => __("Normalize Scroll", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => true,
            "subtitle" => __(
                "It forces scrolling to be done on the JavaScript thread, ensuring it is synchronized and the address bar doesnt show/hide on mobile devices.",
                "pe-core"
            ),
        ],

        [
            "id" => "smooth_speed",
            "type" => "text",
            "title" => __("Speed", "pe-core"),
            "default" => "1",
        ],

    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Mouse Cursor", "pe-core"),
    "id" => "mouseCursor",
    "icon" => "eicon-circle-o",
    "fields" => [
        [
            "id" => "mouse--cursor--settings",
            "type" => "section",
            "subsection" => true,
            "indent" => false,
        ],
        [
            'id' => 'mouse-cursor-heading',
            'type' => 'raw',
            'title' => esc_html__('Mouse Cursor', 'pe-core'),
        ],
        [
            "id" => "mouse_cursor_type",
            "type" => "button_set",
            "title" => __("Mouse Cursor", "pe-core"),
            "options" => [
                "none" => "None",
                "dot" => "Dot",
                "circle" => "Circle",
            ],
            "default" => "none",
        ],


        [
            "id" => "cursor_loading",
            "type" => "switch",
            "title" => __("Loading Animation", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => true,
        ],

        [
            "id" => "cursor_color",
            "type" => "color",
            "color_alpha" => true,
            "title" => __("Cursor Color", "pe-core"),
            "output" => [
                "fill" => "div#mouseCursor.dot .main-circle",
                "stroke" => "div#mouseCursor.circle .main-circle",
                "important" => true,
            ],
        ],

        [
            "id" => "cursor_text_color",
            "type" => "color",
            "color_alpha" => true,
            "title" => __("Cursor Text Color", "pe-core"),
            "output" => [
                "color" => "mouse-cursor-text",
                "important" => true,
            ],
        ],

        [
            "id" => "cursor_icon_color",
            "type" => "color",
            "color_alpha" => true,
            "title" => __("Cursor Icon Color", "pe-core"),
            "output" => [
                "color" => "mouse-cursor-icon",
                "important" => true,
            ],
        ],
    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Popups", "pe-core"),
    "id" => "popup--settings",
    "icon" => "eicon-lightbox-expand",
    "fields" => [
        [
            "id" => "popups",
            "type" => "section",
            "subsection" => true,
            "indent" => false,
        ],
        [
            'id' => 'popups-repeater',
            'type' => 'repeater',
            'group_values' => true, // Group all fields below within the repeater ID
            //'item_name'    => '', // Add a repeater block name to the Add and Delete buttons
            //'bind_title'   => '', // Bind the repeater block title to this field ID
            //'static'       => 2, // Set the number of repeater blocks to be output
            //'limit'        => 2, // Limit the number of repeater blocks a user can create
            //'sortable'     => false, // Allow the users to sort the repeater blocks or not
            'title' => esc_html__('Popups', 'pe-core'),
            'fields' => [
                [
                    "id" => "select-popup-template",
                    "type" => "select",
                    "select2" => true,
                    "data" => "posts",
                    "args" => [
                        "post_type" => ["elementor_library"],
                        "posts_per_page" => -1,
                    ],
                    "validate_callback" => "pe_translate_elementor_template",
                    "title" => __("Select Popup Template", 'pe-core'),
                    "subtitle" => esc_html__(
                        "Select Elementor popup template.",
                        "pe-core"
                    ),
                ],
                [
                    'id' => "popup-show-on",
                    'type' => 'select',
                    "select2" => false,
                    'title' => esc_html__('Popup Visibility', 'pe-core'),
                    'options' => [
                        'everywhere' => esc_html__('Everywhere', 'pe-core'),
                        'pages' => esc_html__('Pages', 'pe-core'),
                        'posts' => esc_html__('Posts', 'pe-core'),
                        'products' => esc_html__('Products', 'pe-core'),
                        'portfolios' => esc_html__('Portfolios', 'pe-core'),
                    ],
                    'default' => 'everywhere',
                    'multi' => false
                ],
                [
                    "id" => "select-popup-pages",
                    "type" => "select",
                    "select2" => true,
                    "data" => "posts",
                    "args" => [
                        "post_type" => ["page"],
                        "posts_per_page" => -1,
                    ],
                    "title" => __("Select Pages", 'pe-core'),
                    "desc" => __("Leave it empty if you want to display popup on all pages.", 'pe-core'),
                    "required" => ["popup-show-on", "=", "pages"],
                    'multi' => true
                ],
                [
                    "id" => "select-popup-posts",
                    "type" => "select",
                    "select2" => true,
                    "data" => "posts",
                    "args" => [
                        "post_type" => ["post"],
                        "posts_per_page" => -1,
                    ],
                    "title" => __("Select Posts", 'pe-core'),
                    "desc" => __("Leave it empty if you want to display popup on all posts.", 'pe-core'),
                    "required" => ["popup-show-on", "=", "posts"],
                    'multi' => true
                ],
                [
                    "id" => "select-popup-products",
                    "type" => "select",
                    "select2" => true,
                    "data" => "posts",
                    "args" => [
                        "post_type" => ["product"],
                        "posts_per_page" => -1,
                    ],
                    "title" => __("Select Products", 'pe-core'),
                    "desc" => __("Leave it empty if you want to display popup on all products.", 'pe-core'),
                    "required" => ["popup-show-on", "=", "products"],
                    'multi' => true
                ],
                [
                    'id' => 'popup_display_delay',
                    'type' => 'slider',
                    'title' => esc_html__('Display Delay (ms)', 'pe-core'),
                    'display_value' => 'label',
                    'min' => 0,
                    'max' => 10000,
                    'default' => 2000,
                    'step' => 1,

                ],

                [
                    'id' => 'popup_disable_scroll',
                    'type' => 'switch',
                    'title' => esc_html__('Disable Scroll', 'pe-core')
                ],

                [
                    'id' => 'popup_overlay',
                    'type' => 'switch',
                    'title' => esc_html__('Overlay', 'pe-core')
                ],
                [
                    'id' => "popup_animation",
                    'type' => 'select',
                    "select2" => false,
                    'title' => esc_html__('Popup Animation', 'pe-core'),
                    'options' => [
                        'center' => esc_html__('Center', 'pe-core'),
                        'left' => esc_html__('Left', 'pe-core'),
                        'right' => esc_html__('Right', 'pe-core'),
                        'top' => esc_html__('Top', 'pe-core'),
                        'bottom' => esc_html__('Bottom', 'pe-core'),
                    ],
                    'default' => 'center',
                    'multi' => false
                ],
                [
                    'id' => 'popup_disabled',
                    'type' => 'switch',
                    'title' => esc_html__('Disabled?', 'pe-core'),
                    'default' => false
                ],

            ],

        ]

    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Styling", "pe-core"),
    "id" => "colors",
    "icon" => "eicon-global-colors",
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("General Optıons", "pe-core"),
    "id" => "general-colors",
    "subsection" => true,
    "fields" => [
        [
            "id" => "custom_fonts",
            "type" => "custom_fonts",
            "title" => esc_html__("Custom Fonts", "pe-core"),
        ],
        [
            "id" => "body-background",
            "type" => "background",
            "title" => esc_html__("Body Background", "pe-core"),
            "subtitle" => esc_html__(
                "Body background with image, color, etc.",
                "pe-core"
            ),
            "output" => ["body", "important" => true],
        ],
        [
            "id" => "body_typo",
            "type" => "typography",
            "title" => __("Body Typography", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "letter-spacing" => true,
            "output" => ["body"],
            "units" => "px",
        ],
        [
            "id" => "link_colors",
            "type" => "link_color",
            "title" => esc_html__("Links Colors", "pe-core"),
            "output" => ["#page a"],
        ],

        [
            "id" => "p_typo",
            "type" => "typography",
            "title" => __("Paragraph", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["p:not(.text-h1, .text-h2, .text-h3 , .text-h4 ,  .text-h5 , .text-h6)"],
            "units" => "px",
            "letter-spacing" => true,
        ],

        [
            "id" => "h1_typo",
            "type" => "typography",
            "title" => __("Heading 1", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["h1 , p.text-h1 , .text-h1.big-title, h1.big-title"],
            "units" => "px",
            "letter-spacing" => true,
        ],

        [
            "id" => "h2_typo",
            "type" => "typography",
            "title" => __("Heading 2", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["h2 , p.text-h2"],
            "units" => "px",
            "letter-spacing" => true,
        ],

        [
            "id" => "h3_typo",
            "type" => "typography",
            "title" => __("Heading 3", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["h3 , p.text-h3"],
            "units" => "px",
            "letter-spacing" => true,
        ],

        [
            "id" => "h4_typo",
            "type" => "typography",
            "title" => __("Heading 4", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["h4 , p.text-h4"],
            "units" => "px",
            "letter-spacing" => true,
        ],

        [
            "id" => "h5_typo",
            "type" => "typography",
            "title" => __("Heading 5", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["h5 , p.text-h5"],
            "units" => "px",
            "letter-spacing" => true,
        ],

        [
            "id" => "h6_typo",
            "type" => "typography",
            "title" => __("Heading 6", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [" h6 , p.text-h6"],
            "units" => "px",
            "letter-spacing" => true,
        ],
    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Header", "pe-core"),
    "id" => "header-colors",
    "subsection" => true,
    "fields" => [
        [
            "id" => "sticky_header_bg_color",
            "type" => "color",
            "title" => __("Sticky Header Background Color.", "pe-core"),
            "subtitle" => __("Set sticky header background color", "pe-core"),
            "output" => [
                "background-color" => ".header--sticked",
                "important" => true,
            ],

        ],

        [
            "id" => "fs_menu_bg_color",
            "type" => "color",
            "title" => __("Fullscreen Menu Background Color.", "pe-core"),
            "subtitle" => __("Set fullscreen menu background color", "pe-core"),
            "output" => [
                "background-color" => ".fullscreen_menu::before",
                "important" => true,
            ],
        ],

        [
            "id" => "fs_menu_item_typo",
            "type" => "typography",
            "title" => __("Menu Item Typography", "pe-core"),
            "subtitle" => __("For fullscreen menu.", "pe-core"),
            "color" => false,
            "google" => true,
            "font-backup" => true,
            "output" => [
                ".site-navigation.fullscreen .menu.main-menu > li.menu-item",
            ],
            "units" => "px",
        ],

        [
            "id" => "fs_menu_item_color",
            "type" => "color",
            "title" => __("Menu item color.", "pe-core"),
            "subtitle" => __("For fullscreen menu", "pe-core"),
            "output" => [
                "color" =>
                    ".site-header .site-navigation.fullscreen .menu.main-menu > li.menu-item a::before",
                "background-color" => ".site-header.menu_dark .sub-togg-line",
                "important" => true,
            ],
        ],

        [
            "id" => "fs_menu_item_transparent_color",
            "type" => "color",
            "title" => __("Menu item transparent color.", "pe-core"),
            "subtitle" => __("For fullscreen menu", "pe-core"),
            "output" => [
                "color" =>
                    ".site-header .site-navigation.fullscreen .menu.main-menu > li.menu-item a",
                "important" => true,
            ],
        ],

        [
            "id" => "menu_toggle_color",
            "type" => "color",
            "title" => __("Menu toggle background color.", "pe-core"),
            "subtitle" => __("For fullscreen menu.", "pe-core"),
            "output" => [
                "background-color" => ".site-header .toggle-line",
                "important" => true,
            ],
        ],

        [
            "id" => "classic_menu_item_typo",
            "type" => "typography",
            "title" => __("Menu Item Typography", "pe-core"),
            "subtitle" => __("For classic menu.", "pe-core"),
            "color" => false,
            "google" => true,
            "font-backup" => true,
            "output" => ["#primary-menu .menu-item"],
            "units" => "px",
        ],

        [
            "id" => "classic_menu_dark_item_color",
            "type" => "color",
            "title" => __("Menu item color.(Dark)", "pe-core"),
            "subtitle" => __("For classic menu (dark layout)", "pe-core"),
            "default" => "rgba(25, 27, 29, .6)",
            "output" => [
                "color" => ".site-navigation.classic .menu.main-menu > li > a",
                "important" => true,
            ],
        ],

        [
            "id" => "classic_menu_dark_item_hover_color",
            "type" => "color",
            "title" => __("Menu item hover color(Dark).", "pe-core"),
            "subtitle" => __("For classic menu (dark layout)", "pe-core"),
            "default" => "#191b1d",
        ],
        [
            "id" => "classic_menu_dark_item_active_color",
            "type" => "color",
            "title" => __("Menu item active color(Dark).", "pe-core"),
            "subtitle" => __("For classic menu (dark layout)", "pe-core"),
            "default" => "#191b1d",
            "output" => [
                "color" =>
                    ".site-header .site-navigation.classic .menu.main-menu li.current-menu-item > a",
                "important" => true,
            ],
        ],
        [
            "id" => "classic_menu_light_item_color",
            "type" => "color",
            "title" => __("Menu item color.(Light)", "pe-core"),
            "subtitle" => __("For classic menu (light layout)", "pe-core"),
            "default" => "hsla(0,0%,100%,.2)",
            "output" => [
                "color" =>
                    ".site-header.light .site-navigation.classic .menu.main-menu > li > a",
                "important" => true,
            ],
        ],

        [
            "id" => "classic_menu_light_item_hover_color",
            "type" => "color",
            "title" => __("Menu item hover color(Light).", "pe-core"),
            "subtitle" => __("For classic menu (light layout)", "pe-core"),
            "default" => "#ffffff",
        ],

        [
            "id" => "classic_menu_light_item_active_color",
            "type" => "color",
            "title" => __("Menu item active color(Light).", "pe-core"),
            "subtitle" => __("For classic menu (light layout)", "pe-core"),
            "default" => "#ffffff",
            "output" => [
                "color" =>
                    ".site-header.light .site-navigation.classic .menu.main-menu li.current-menu-item > a",
                "important" => true,
            ],
        ],

        [
            "id" => "classic_menu_submenu_item_color",
            "type" => "color",
            "title" => __("Submenu Item Color.", "pe-core"),
            "subtitle" => __("For classic menu.", "pe-core"),
            "output" => [
                "color" => ".sub-menu a",
                "important" => true,
            ],
        ],

        [
            "id" => "classic_submenu_background_color",
            "type" => "color",
            "title" => __("Submenu background color.", "pe-core"),
            "subtitle" => __("For classic menu.", "pe-core"),
            "output" => [
                "background-color" => ".site-navigation.classic .sub-menu",
                "important" => true,
            ],
        ],

        [
            "id" => "git_button_typo",
            "type" => "typography",
            "title" => __("CTA Typography", "pe-core"),
            "subtitle" => __("For fullscreen menu.", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [
                ".site-header.menu_dark .git-button a",
                ".site-header.menu_light .git-button a",
            ],
            "units" => "px",
        ],

        [
            "id" => "social_links_typo",
            "type" => "typography",
            "title" => __("Social Links Typography", "pe-core"),
            "subtitle" => __("For fullscreen menu.", "pe-core"),
            "google" => true,
            "color" => false,
            "font-backup" => true,
            "output" => [
                ".site-header.menu_dark .social-list li a",
                ".site-header.menu_light .social-list li a",
            ],
            "units" => "px",
        ],
    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Footer", "pe-core"),
    "id" => "footer-styles",
    "subsection" => true,
    "fields" => [
        [
            "id" => "footer-background",
            "type" => "background",
            "title" => esc_html__("Footer Background", "pe-core"),
            "subtitle" => esc_html__(
                "Footer background with image, color, etc.",
                "pe-core"
            ),
            "output" => [".site-footer", "important" => true],
        ],

        [
            "id" => "footer_menu_typo",
            "type" => "typography",
            "title" => __("Footer Menu Typography", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [
                "#footer.dark .footer-menu ul li a",
                "#footer.light .footer-menu ul li a",
            ],
            "units" => "px",
        ],

        [
            "id" => "copyright_text_typo",
            "type" => "typography",
            "title" => __("Copyright Text Typography", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [
                "#footer.dark .copyright-text",
                "#footer.light .copyright-text",
            ],
            "units" => "px",
        ],

        [
            "id" => "mail_button_typo",
            "type" => "typography",
            "title" => __("Mail Button Typography", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [
                "#footer.dark .big-button a",
                "#footer.light .big-button a",
                ".big-button a::after",
            ],
            "units" => "px",
        ],
    ],
]);
Redux::setSection($opt_name, [
    "title" => esc_html__("Global Widget Styles", "pe-core"),
    "id" => "global-widget-styles",
    "subsection" => true,
    "icon" => "eicon-elementor-circle",
    "fields" => [
        [
            "id" => "global-opts-accordion",
            "type" => "accordion",
            "title" => "Accordion",
            "subtitle" => 'Global settings for "accordion" widget.',
            "position" => "start",
        ],

        [
            "id" => "accordion_list_type",
            "type" => "select",
            "title" => __("List Type", "pe-core"),
            "multi" => false,
            "options" => [
                "ac--ordered" => "Ordered",
                "ac--nested" => "Nested",
            ],
            "default" => "ac--nested",
        ],
        [
            'id' => "accordion_open_first",
            'type' => 'button_set',
            'title' => esc_html__('Active First', 'pe-core'),
            'subtitle' => esc_html__('First item will be active as default', 'pe-core'),
            'options' => [
                'active--firt' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => 'ac--ordered',
            'multi' => false
        ],
        [
            'id' => 'accordion_toggle_style',
            'type' => 'select',
            'multi' => false,
            'title' => esc_html__('Toggle Style', 'pe-core'),
            'options' => [
                'toggle--plus' => esc_html__('Plus', 'pe-core'),
                'toggle--dot' => esc_html__('Dot', 'pe-core'),
                'toggle--custom' => esc_html__('Custom', 'pe-core')
            ],
            'default' => 'toggle--plus'
        ],
        [
            'id' => 'accordion_open_icon',
            'type' => 'icon_select',
            'title' => esc_html__('Open Icon', 'pe-core'),
            "required" => ["accordion_toggle_style", "=", "toggle--custom"],
            'default' => 'fas fa-plus'
        ],
        [
            'id' => 'accordion_close_icon',
            'type' => 'icon_select',
            'title' => esc_html__('Close Icon', 'pe-core'),
            "required" => ["accordion_toggle_style", "=", "toggle--custom"],
            'default' => 'fas fa-plus'
        ],
        [
            'id' => 'accordion_toggle_bg',
            'type' => 'button_set',
            'title' => esc_html__('Toggle Background', 'pe-core'),
            'subtitle' => esc_html__('You can adjust colors from "Style" tab above.', 'pe-core'),
            'multi' => false,
            'options' => [
                'toggle--bg' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ]
        ],
        [
            'id' => 'accordion_underlined',
            'type' => 'button_set',
            'title' => esc_html__('Underlined?', 'pe-core'),
            'multi' => false,
            'options' => [
                'ac--underlined' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => ''
        ],
        [
            "id" => "global-opts-accordion-end",
            "type" => "accordion",
            "position" => "end",
        ],
        [
            "id" => "global-opts-blogposts",
            "type" => "accordion",
            "title" => "Blog Posts",
            "position" => "start",
        ],

        [
            "id" => "global-opts-blogposts-end",
            "type" => "accordion",
            "position" => "end",
        ],
        [
            'id' => 'global-opts-button',
            'type' => 'accordion',
            'title' => esc_html__('Button', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'button_size',
            'type' => 'select',
            'multi' => false,
            'options' => [
                'pb--small' => esc_html__('Small', 'pe-core'),
                'pb--normal' => esc_html__('Normal', 'pe-core'),
                'pb--medium' => esc_html__('Medium', 'pe-core'),
                'pb--large' => esc_html__('Large', 'pe-core')
            ],
            'default' => 'pb--normal'
        ],
        [
            'id' => 'button_alignment',
            'type' => 'button_set',
            'title' => esc_html__('Alignment', 'pe-core'),
            'options' => [
                'left' => esc_html__('Left', 'pe-core'),
                'center' => esc_html__('Center', 'pe-core'),
                'right' => esc_html__('Right', 'pe-core')
            ],
            'multi' => false,
            'default' => 'left'
        ],
        [
            'id' => 'button_background',
            'type' => 'button_set',
            'title' => esc_html__('Background', 'pe-core'),
            'multi' => false,
            'options' => [
                'pb--background' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => 'pb--background'
        ],
        [
            'id' => 'button_bordered',
            'type' => 'button_set',
            'title' => esc_html__('Bordered', 'pe-core'),
            'multi' => false,
            'options' => [
                'pb--bordered' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'button_marquee',
            'type' => 'button_set',
            'title' => esc_html__('Marquee', 'pe-core'),
            'multi' => false,
            'options' => [
                'pb--marquee' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'button_underlined',
            'type' => 'button_set',
            'title' => esc_html__('Underlined', 'pe-core'),
            'multi' => false,
            'options' => [
                'pb--underlined' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => '',
            'required' => ['button_marquee', 'not', 'pb--marquee']
        ],
        [
            'id' => 'button_show_icon',
            'type' => 'button_set',
            'title' => esc_html__('Show Icon', 'pe-core'),
            'multi' => false,
            'options' => [
                'pb--icon' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => 'pb--icon'
        ],

        [
            'id' => 'button_icon_position',
            'title' => esc_html__('Icon Position', 'pe-cor'),
            'type' => 'button_set',
            'options' => [
                'icon__left' => esc_html__('Left', 'pe-core'),
                'icon__right' => esc_html__('Right', 'pe-core'),
            ],
            'default' => 'icon__right',
            'required' => ['button_show_icon', '=', 'pb--icon']
        ],
        [
            'id' => 'button_border_radius',
            'type' => 'spacing',
            'output' => array('.pe--button a'),
            'title' => esc_html__('Border Radius', 'pe-core'),
            'units' => ['px', '%', 'em'],
            'units_extended' => true,
            'default' => [
                'border-top-width' => '1px',
                'border-right-width' => '1px',
                'border-bottom-width' => '1px',
                'border-left-width' => '1px',
                'units' => 'px'
            ]
        ],
        [
            'id' => 'button_border_width',
            'type' => 'spacing',
            'title' => esc_html__('Border Width', 'pe-core'),
            'units' => ['px'],
            'units_extended' => true,
            'default' => [
                'border-top-width' => '1px',
                'border-right-width' => '1px',
                'border-bottom-width' => '1px',
                'border-left-width' => '1px',
                'units' => 'px'
            ]
        ],
        [
            'id' => 'button_underline_height',
            'type' => 'slider',
            'title' => esc_html__('Underline Height', 'pe-core'),
            "default" => 1,
            "min" => 0.1,
            "step" => 0.1,
            "max" => 5,
            'display_value' => 'label'
        ],
        [
            'id' => 'button_padding',
            'type' => 'spacing',
            'title' => esc_html__('Padding', 'pe-core'),
            'units' => ['px', '%'],
            'units_extended' => true,
            'default' => [
                'padding-top' => '30px',
                'padding-right' => '30px',
                'padding-bottom' => '30px',
                'padding-left' => '30px',
                'units' => 'px'
            ]
        ],
        [
            'id' => 'global-opts-button-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-carousel',
            'type' => 'accordion',
            'position' => 'start',
            'title' => esc_html__('Carousel')
        ],
        [
            'id' => 'carousel_items_width',
            'type' => 'slider',
            'title' => esc_html__('Items Width', 'pe-core'),
            'display_value' => 'label',
            'min' => 0,
            'max' => 1000,
            'step' => 1
        ],
        [
            'id' => 'carousel_items_gap',
            'type' => 'slider',
            'title' => esc_html__('Space Between Items', 'pe-core'),
            'display_value' => 'label',
            'min' => 0,
            'max' => 1000,
            'step' => 1
        ],
        [
            'id' => 'carousel_items_pos',
            'type' => 'button_set',
            'title' => esc_html__('Items Position', 'pe-core'),
            'options' => [
                'start' => esc_html__('Top', 'pe-core'),
                'center' => esc_html__('Middle', 'pe-core'),
                'end' => esc_html__('Bottom', 'pe-core')
            ],
            'multi' => false,
            'default' => 'center'
        ],
        [
            'id' => 'carousel_equal_height',
            'type' => 'switch',
            'title' => esc_html__('Custom Height', 'pe-core'),
            'default' => false
        ],
        [
            'id' => 'carousel_item_height',
            'type' => 'slider',
            'title' => esc_html__('Item Height', 'pe-core'),
            'min' => 0,
            'max' => 1000,
            'step' => 1,
            'display_value' => 'label',
            'required' => ['carousel_equal_height', '=', 'true']
        ],
        [
            'id' => 'global-opts-carousel-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-circletext',
            'type' => 'accordion',
            'title' => esc_html__('Circle Text', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'circletext_center_icon',
            'type' => 'button_set',
            'title' => esc_html__('Center Icon', 'pe-core'),
            'options' => [
                'on' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'circletext_center_icon_select',
            'type' => 'icon_select',
            'title' => esc_html__('Icon', 'pe-core'),
            'required' => ['circletext_center_icon', '=', 'on']
        ],
        [
            'id' => 'circletext_words_seperator',
            'type' => 'button_set',
            'title' => esc_html__('Words Seperator', 'pe-core'),
            'options' => [
                'on' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'circletext_words_seperator_select',
            'type' => 'icon_select',
            'title' => esc_html__('Seperator', 'pe-core'),
            'required' => ['circletext_words_seperator', '=', 'on']
        ],
        [
            'id' => 'circletext_rotate_direction',
            'type' => 'button_set',
            'title' => esc_html__('Rotate Direction', 'pe-core'),
            'multi' => false,
            'options' => [
                'counter_clockwise' => esc_html__('Left', 'pe-core'),
                '' => esc_html__('Right', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'circetext_height',
            'type' => 'slider',
            'title' => esc_html__('Height', 'pe-core'),
            'min' => 20,
            'max' => 1000,
            'step' => 1,
            'default' => 200,
            'display_value' => 'label'
        ],
        [
            'id' => 'circletext_blur_bg',
            'type' => 'button_set',
            'title' => esc_html__('Blur Background', 'pe-core'),
            'multi' => false,
            'options' => [
                'blur-bg' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'circletext_color_bg',
            'type' => 'button_set',
            'title' => esc_html__('Color Background', 'pe-core'),
            'multi' => false,
            'options' => [
                'has-bg' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'circletext_alignment',
            'type' => 'button_set',
            'title' => esc_html__('Alignment', 'pe-core'),
            'multi' => false,
            'options' => [
                'left' => esc_html__('Left', 'pe-core'),
                'center' => esc_html__('Center', 'pe-core'),
                'right' => esc_html__('Right', 'pe-core'),
            ],
            'default' => 'left'
        ],
        [
            'id' => 'global-opts-circletext-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-clients',
            'type' => 'accordion',
            'title' => esc_html__('Clients', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'clients_type',
            'type' => 'select',
            'title' => esc_html__('Type', 'pe-core'),
            'multi' => false,
            'options' => [
                'pe--clients--grid' => esc_html__('Grid', 'pe-core'),
                'pe--clients-carousel' => esc_html__('Carousel', 'pe-core'),
            ],
            'default' => 'pe--clients--grid'
        ],
        [
            'id' => 'clients_columns',
            'type' => 'slider',
            'title' => esc_html__('Columns', 'pe-core'),
            'min' => 0,
            'max' => 12,
            'step' => 1,
            'default' => 3,
            'display_value' => 'label',
            'required' => ['clients_type', '=', 'pe--clients--grid']
        ],
        [
            'id' => 'clients_columns_spacing',
            'type' => 'slider',
            'title' => esc_html__('Columns Spacing', 'pe-core'),
            'min' => 0,
            'max' => 500,
            'step' => 1,
            'default' => 20,
            'display_value' => 'label',
            'required' => ['clients_type', '=', 'pe--clients--grid']
        ],
        [
            'id' => 'clients_background',
            'type' => 'button_set',
            'title' => esc_html__('Background', 'pe-core'),
            'multi' => false,
            'options' => [
                'has-bg' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'clients_hover',
            'type' => 'button_set',
            'title' => esc_html__('Hover', 'pe-core'),
            'multi' => false,
            'options' => [
                'has-hover' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => '',
            'required' => ['clients_background', '=', 'has-bg']
        ],
        [
            'id' => 'clients_hover_switch',
            'type' => 'button_set',
            'title' => esc_html__('Switch logos at hover', 'pe-core'),
            'multi' => false,
            'options' => [
                'hover-switch-logos' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => '',
            'required' => ['clients_background', '=', 'has-bg']
        ],
        [
            'id' => 'clients_captions',
            'type' => 'button_set',
            'title' => esc_html__('Captions', 'pe-core'),
            'multi' => false,
            'options' => [
                'show-captions' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => 'show-captions',
        ],
        [
            'id' => 'global-opts-clients-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-icon',
            'type' => 'accordion',
            'title' => esc_html__('Icon', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'icon_size',
            'type' => 'slider',
            'title' => esc_html__('Size', 'pe-core'),
            'min' => 0,
            'max' => 1000,
            'step' => 1,
            'default' => 50,
            'display_value' => 'label'
        ],
        [
            'id' => 'icon_alignment',
            'type' => 'button_set',
            'title' => esc_html__('Alignment', 'pe-core'),
            'multi' => 'false',
            'options' => [
                'left' => esc_html__('Left', 'pe-core'),
                'center' => esc_html__('Center', 'pe-core'),
                'right' => esc_html__('Right', 'pe-core')
            ],
            'default' => 'left'
        ],
        [
            'id' => 'icon_background',
            'type' => 'button_set',
            'title' => esc_html__('Background', 'pe-core'),
            'multi' => false,
            'options' => [
                'has-bg' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => 'has-bg'
        ],
        [
            'id' => 'icon_background_size',
            'type' => 'slider',
            'title' => esc_html__('Background Size', 'pe-core'),
            'min' => 0,
            'max' => 1000,
            'step' => 1,
            'default' => 100,
            'display_value' => 'label',
            'required' => ['icon_background', '=', 'has-bg']
        ],
        [
            'id' => 'icon_hover_effects',
            'type' => 'button_set',
            'title' => esc_html__('Hover Effects', 'pe-core'),
            'multi' => false,
            'options' => [
                'has-hover' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ]
        ],
        [
            'id' => 'global-opts-icon-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-marquee',
            'type' => 'accordion',
            'title' => esc_html__('Marquee', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'marquee_text_type',
            'type' => 'select',
            'title' => esc_html__('Text Type', 'pe-core'),
            'options' => [
                'h1' => esc_html__('H1', 'pe-core'),
                'h2' => esc_html__('H2', 'pe-core'),
                'h3' => esc_html__('H3', 'pe-core'),
                'h4' => esc_html__('H4', 'pe-core'),
                'h5' => esc_html__('H5', 'pe-core'),
                'h6' => esc_html__('H6', 'pe-core'),
            ],
            'default' => 'h1'
        ],
        [
            'id' => 'marquee_heading_size',
            'type' => 'select',
            'title' => esc_html__('Heading Size', 'pe-core'),
            'multi' => false,
            'options' => [
                '' => esc_html__('Normal', 'pe-core'),
                'md-title' => esc_html__('Medium', 'pe-core'),
                'big-title' => esc_html__('Large', 'pe-core')
            ],
            'required' => ['marquee_text_type', '=', 'h1']
        ],
        [
            'id' => 'marquee_seperator_type',
            'type' => 'select',
            'title' => esc_html__('Seperator Type', 'pe-core'),
            'multi' => false,
            'options' => [
                'none' => esc_html__('None', 'pe-core'),
                'icon' => esc_html__('Icon', 'pe-core'),
                'image' => esc_html__('Image', 'pe-core')
            ]
        ],
        [
            'id' => 'marquee_seperator_size',
            'type' => 'slider',
            'title' => esc_html__('Seperator Size', 'pe-core'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 50,
            'display_value' => 'label',
            'required' => ['marquee_seperator_type', '=', 'icon']
        ],
        [
            'id' => 'marquee_seperator_margin',
            'type' => 'slider',
            'title' => esc_html__('Seperator Margin', 'pe-core'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 50,
            'display_value' => 'label',
            'required' => ['marquee_seperator_type', '=', 'icon']
        ],
        [
            'id' => 'marquee_image_size',
            'type' => 'slider',
            'title' => esc_html__('Image Size', 'pe-core'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 50,
            'display_value' => 'label',
            'required' => ['marquee_seperator_type', '=', 'image']
        ],
        [
            'id' => 'marquee_image_margin',
            'type' => 'slider',
            'title' => esc_html__('Seperator Margin', 'pe-core'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 50,
            'display_value' => 'label',
            'required' => ['marquee_seperator_type', '=', 'image']
        ],
        [
            'id' => 'global-opts-marquee-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-singlepost',
            'type' => 'accordion',
            'title' => esc_html__('Single Post', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'singlepost_thumb',
            'type' => 'switch',
            'title' => esc_html__('Thumbnail', 'pe-core')
        ],
        [
            'id' => 'singlepost_date',
            'type' => 'switch',
            'title' => esc_html__('Date', 'pe-core')
        ],
        [
            'id' => 'singlepost_cats',
            'type' => 'switch',
            'title' => esc_html__('Category', 'pe-core')
        ],
        [
            'id' => 'singlepost_excerpt',
            'type' => 'switch',
            'title' => esc_html__('Excerpt', 'pe-core')
        ],
        [
            'id' => 'singlepost_button',
            'type' => 'switch',
            'title' => esc_html__('Button', 'pe-core')
        ],
        [
            'id' => 'global-opts-singlepost-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-singleproject',
            'type' => 'accordion',
            'title' => esc_html__('Single Project', 'pe-core'),
            'position' => 'start',
        ],
        [
            'id' => 'singleproject_cat',
            'type' => 'switch',
            'title' => esc_html__('Category', 'pe-core')
        ],
        [
            'id' => 'singleproject_title_pos',
            'type' => 'button_set',
            'title' => esc_html__('Title Pos', 'pe-core'),
            'options' => [
                'column-reverse' => esc_html__('Top', 'pe-core'),
                'column' => esc_html__('Bottom', 'pe-core')
            ],
            'default' => 'column'
        ],
        [
            'id' => 'singleproject_border_radius',
            'type' => 'spacing',
            'title' => esc_html__('Border Radius', 'pe-core'),
            'units' => ['px', '%'],
            'units_extended' => true,
            'default' => [
                'border-top-left-radius' => '30px',
                'border-top-right-radius' => '30px',
                'border-bottom-right-radius' => '30px',
                'border-bottom-left-radius' => '30px',
                'units' => 'px'
            ]
        ],
        [
            'id' => 'global-opts-singleproject-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-testimonials',
            'type' => 'accordion',
            'title' => esc_html__('Testimonials', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'testimonials_style',
            'type' => 'select',
            'title' => esc_html__('Style', 'pe-core'),
            'multi' => false,
            'options' => [
                'test--dynamic' => esc_html__('Dynamic', 'pe-core'),
                'test--carousel' => esc_html__('Carousel', 'pe-core')
            ],
            'default' => 'test--dynamic'
        ],
        [
            'id' => 'testimonials_text_alignment',
            'type' => 'button_set',
            'multi' => false,
            'title' => esc_html__('Text Alignment', 'pe-core'),
            'options' => [
                'column-reverse' => esc_html__('Top', 'pe-core'),
                'column' => esc_html__('Bottom', 'pe-core')
            ],
            'default' => 'column'
        ],
        [
            'id' => 'global-opts-testimonials-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-video',
            'type' => 'accordion',
            'title' => esc_html__('Video', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'video_select_controls',
            'type' => 'select',
            'multi' => true,
            'title' => esc_html__('Select Controls', 'pe-core'),
            'options' => [
                'play' => esc_html__('Play', 'pe-core'),
                'current-time' => esc_html__('Current Time', 'pe-core'),
                'duration' => esc_html__('Duration', 'pe-core'),
                'progress' => esc_html__('Progress Bar', 'pe-core'),
                'mute' => esc_html__('Mute', 'pe-core'),
                'volume' => esc_html__('Volume', 'pe-core'),
                'captions' => esc_html__('Captions', 'pe-core'),
                'settings' => esc_html__('Settings', 'pe-core'),
                'pip' => esc_html__('PIP', 'pe-core'),
                'airplay' => esc_html__('Airplay (Safari Only)', 'pe-core'),
                'fullscreen' => esc_html__('Fullscreen', 'pe-core'),
            ],
            'default' => ['play', 'current-time', 'duration', 'progress', 'mute', 'volume', 'fullscreen'],
        ],
        [
            'id' => 'video_autoplay',
            'title' => esc_html__('Autoplay', 'pe-core'),
            'type' => 'switch',
        ],
        [
            'id' => 'video_muted',
            'title' => esc_html__('Muted', 'pe-core'),
            'type' => 'switch',
        ],
        [
            'id' => 'video_loop',
            'title' => esc_html__('Loop', 'pe-core'),
            'type' => 'switch',
        ],
        [
            'id' => 'video_lightbox',
            'title' => esc_html__('Lightbox', 'pe-core'),
            'type' => 'switch',
        ],
        [
            'id' => 'global-opts-video-end',
            'type' => 'accordion',
            'position' => 'end'
        ]

    ],
]);
Redux::setSection($opt_name, [
    "title" => esc_html__("Additonal Options", "pe-core"),
    "id" => "additonal--settings",
    "icon" => "eicon-settings",
    "fields" => [
        [
            "id" => "additonals",
            "type" => "section",
            "subsection" => true,
            "indent" => false,
        ],
        [
            "id" => "pe_google_maps_api",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("Google Maps API", "pe-core"),
            "subtitle" => __(
                "Switching off this option will be remove Google Maps API integration.",
                "pe-core"
            ),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => true,
        ],
        [
            "id" => "show_acf_dashboard",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("ACF", "pe-core"),
            "subtitle" => __(
                "You can switch this on if you want to display ACF on your dashboard.",
                "pe-core"
            ),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => false,
        ],
        [
            "id" => "pe_lotties",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("Lottie Animations", "pe-core"),
            "subtitle" => __(
                "If you switch this off Lottie animations will no longer usable on your website.",
                "pe-core"
            ),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => true,
        ],



    ],
]);
Redux::setSection($opt_name, [
    "title" => esc_html__("Custom CSS/JS", "pe-core"),
    "id" => "fullscreen-foasasddoter",
    "icon" => "eicon-custom-css",
    "fields" => [
        [
            "id" => "css_editor",
            "type" => "ace_editor",
            "title" => __("CSS", "pe-core"),
            "subtitle" => __("Write your custom CSS code here.", "pe-core"),
            "mode" => "css",
            "theme" => "monokai",
        ],
        [
            "id" => "js_editor",
            "type" => "ace_editor",
            "title" => __("JavaScript", "pe-core"),
            "subtitle" => __("Write your custom JS code here.", "pe-core"),
            "mode" => "javascript",
            "theme" => "chrome",
        ],
    ],
]);



if (!function_exists('pe_translate_elementor_template')) {
    function pe_translate_elementor_template($field, $value, $existing_value)
    {
        if (function_exists('icl_object_id')) {
            $translated_id = icl_object_id($value, 'elementor_library', true, ICL_LANGUAGE_CODE);
            return ['value' => $translated_id];
        }
        return ['value' => $value];
    }
}

if (class_exists('WooCommerce')) {
    function filtersArr()
    {

        $arr = [
            'attributes' => esc_html__('Attributes', 'pe-core'),
            'categories' => esc_html__('Categories', 'pe-core'),
            'brands' => esc_html__('Brands', 'pe-core'),
            'price' => esc_html__('Price', 'pe-core'),
            'tag' => esc_html__('Tag', 'pe-core'),
            'on-sale' => esc_html__('On Sale', 'pe-core')
        ];

        $attributes = wc_get_attribute_taxonomies();
        foreach ($attributes as $key => $attribute) {
            $arr[$attribute->attribute_name] = $attribute->attribute_label;
        }

        return $arr;
    }

    function selectVars()
    {
        $arr = [];
        $attributes = wc_get_attribute_taxonomies();

        foreach ($attributes as $key => $attribute) {
            $arr[$attribute->attribute_id] = $attribute->attribute_label;
        }

        return $arr;
    }
}