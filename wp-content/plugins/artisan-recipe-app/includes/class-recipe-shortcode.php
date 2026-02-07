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

        $content = $post->post_content ?? '';
        $found = has_shortcode( $content, 'sa_recipe' );

        // Elementor stores content in postmeta
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
        $methods  = SARA_Recipe_Data::get_methods();
        $profile  = SARA_Recipe_Data::get_profile();
        $guides   = SARA_Recipe_Data::get_guides();
        $strings  = SARA_Recipe_Data::get_strings();

        // Detect page language from URL
        $current_path = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
        $default_lang = ( strpos( $current_path, 'en' ) === 0 ) ? 'en' : 'da';

        // Only pass what JS needs (method keys + grind positions, strings, lang)
        $js_methods = [];
        foreach ( $methods as $key => $m ) {
            $js_methods[ $key ] = [ 'grind' => $m['grind'] ];
        }

        wp_enqueue_script( 'sa-recipe-app' );
        wp_localize_script( 'sa-recipe-app', 'saRecipeData', [
            'methods'     => $js_methods,
            'strings'     => $strings,
            'defaultLang' => $default_lang,
        ] );

        // Make data available to the template
        $first_method = array_key_first( $methods );
        $lang = $default_lang;

        ob_start();
        include SARA_PLUGIN_DIR . 'templates/recipe.php';
        return ob_get_clean();
    }
}
