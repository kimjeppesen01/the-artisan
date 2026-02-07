<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SARA_Recipe_Shortcode {

    public function __construct() {
        add_shortcode( 'sa_recipe', [ $this, 'render' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    public function enqueue_assets() {
        global $post;
        if ( ! $post ) return;

        $found = has_shortcode( $post->post_content, 'sa_recipe' );

        // Elementor stores content in postmeta — check there too
        if ( ! $found && class_exists( '\Elementor\Plugin' ) ) {
            $elementor_data = get_post_meta( $post->ID, '_elementor_data', true );
            if ( $elementor_data && strpos( $elementor_data, 'sa_recipe' ) !== false ) {
                $found = true;
            }
        }

        if ( ! $found ) return;

        wp_register_script(
            'sa-recipe-app',
            SARA_PLUGIN_URL . 'assets/js/recipe-app.js',
            [],
            SARA_VERSION,
            [ 'strategy' => 'defer', 'in_footer' => true ]
        );
    }

    public function render( $atts ) {
        $atts = shortcode_atts( [ 'id' => '' ], $atts, 'sa_recipe' );

        $product_id = $atts['id'] ? (int) $atts['id'] : get_the_ID();
        $product    = wc_get_product( $product_id );
        if ( ! $product ) return '';

        $recipe_data = SARA_Recipe_ACF::get_recipe_data( $product_id );
        if ( ! $recipe_data ) return '';

        // Localize data for JS
        $profile = [
            'origin'     => function_exists( 'get_field' ) ? ( get_field( 'origin_country', $product_id ) ?: '' ) : '',
            'highlights' => array_values( array_filter( [
                function_exists( 'get_field' ) ? get_field( 'highlight_1', $product_id ) : '',
                function_exists( 'get_field' ) ? get_field( 'highlight_2', $product_id ) : '',
                function_exists( 'get_field' ) ? get_field( 'highlight_3', $product_id ) : '',
            ] ) ),
            'roast_date' => function_exists( 'get_field' ) ? ( get_field( 'roast_date', $product_id ) ?: '' ) : '',
        ];

        // Get roast level from product attribute
        $roast_level = $product->get_attribute( 'pa_roast' ) ?: '';

        wp_enqueue_script( 'sa-recipe-app' );
        wp_localize_script( 'sa-recipe-app', 'saRecipeData', [
            'productId'   => $product_id,
            'productName' => $product->get_name(),
            'productUrl'  => get_permalink( $product_id ),
            'methods'     => $recipe_data,
            'profile'     => $profile,
            'roastLevel'  => $roast_level,
            'strings'     => [
                'da' => [
                    'coffee'        => 'Kaffe',
                    'water'         => 'Vand',
                    'ratio'         => 'Ratio',
                    'temp'          => 'Temperatur',
                    'time'          => 'Tid',
                    'grind_label'   => 'Formalingsgrad',
                    'fine'          => 'Fin',
                    'coarse'        => 'Grov',
                    'steps_title'   => 'Trin',
                    'pro_tip'       => 'Pro tip',
                    'start'         => 'Start',
                    'pause'         => 'Pause',
                    'reset'         => 'Nulstil',
                    'next_step'     => 'Naeste trin',
                    'done'          => 'Faerdig!',
                    'profile_title' => 'Kaffeprofil',
                    'origin'        => 'Oprindelse',
                    'roast'         => 'Ristning',
                    'notes'         => 'Smagsnoter',
                    'buy_cta'       => 'Kob denne kaffe',
                    'guides_title'  => 'Laes mere',
                    'lang_toggle'   => 'EN',
                ],
                'en' => [
                    'coffee'        => 'Coffee',
                    'water'         => 'Water',
                    'ratio'         => 'Ratio',
                    'temp'          => 'Temperature',
                    'time'          => 'Time',
                    'grind_label'   => 'Grind Size',
                    'fine'          => 'Fine',
                    'coarse'        => 'Coarse',
                    'steps_title'   => 'Steps',
                    'pro_tip'       => 'Pro tip',
                    'start'         => 'Start',
                    'pause'         => 'Pause',
                    'reset'         => 'Reset',
                    'next_step'     => 'Next step',
                    'done'          => 'Done!',
                    'profile_title' => 'Coffee Profile',
                    'origin'        => 'Origin',
                    'roast'         => 'Roast',
                    'notes'         => 'Tasting Notes',
                    'buy_cta'       => 'Buy this coffee',
                    'guides_title'  => 'Read more',
                    'lang_toggle'   => 'DA',
                ],
            ],
        ] );

        // Make data available to the template
        $methods      = SARA_Recipe_ACF::get_methods();
        $recipe       = $recipe_data;
        $product_name = $product->get_name();
        $product_url  = get_permalink( $product_id );
        $origin       = $profile['origin'];
        $highlights   = $profile['highlights'];
        $roast_date   = $profile['roast_date'];

        ob_start();
        include SARA_PLUGIN_DIR . 'templates/recipe.php';
        return ob_get_clean();
    }
}
