<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SARA_Recipe_ACF {

    private static $methods = [
        'v60'          => [ 'da' => 'V60',          'en' => 'V60' ],
        'chemex'       => [ 'da' => 'Chemex',       'en' => 'Chemex' ],
        'aeropress'    => [ 'da' => 'AeroPress',    'en' => 'AeroPress' ],
        'french_press' => [ 'da' => 'French Press',  'en' => 'French Press' ],
    ];

    public function __construct() {
        add_action( 'acf/init', [ $this, 'register_fields' ] );
    }

    public function register_fields() {
        if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

        $fields = [];

        // Master toggle
        $fields[] = [
            'key'   => 'field_sara_has_recipe',
            'label' => 'Enable Brew Recipe',
            'name'  => 'recipe_has_recipe',
            'type'  => 'true_false',
            'ui'    => 1,
        ];

        // Build fields for each brew method
        foreach ( self::$methods as $key => $names ) {
            $label = $names['en'];
            $prefix = 'recipe_' . $key;
            $key_prefix = 'field_sara_' . $key;

            $fields[] = [
                'key'               => $key_prefix . '_tab',
                'label'             => $label,
                'type'              => 'tab',
                'conditional_logic' => [ [ [ 'field' => 'field_sara_has_recipe', 'operator' => '==', 'value' => '1' ] ] ],
            ];

            $fields[] = [
                'key'   => $key_prefix . '_coffee_g',
                'label' => $label . ' — Coffee (g)',
                'name'  => $prefix . '_coffee_g',
                'type'  => 'number',
                'default_value' => 15,
                'wrapper' => [ 'width' => '16' ],
            ];

            $fields[] = [
                'key'   => $key_prefix . '_water_ml',
                'label' => 'Water (ml)',
                'name'  => $prefix . '_water_ml',
                'type'  => 'number',
                'default_value' => 250,
                'wrapper' => [ 'width' => '16' ],
            ];

            $fields[] = [
                'key'   => $key_prefix . '_ratio',
                'label' => 'Ratio',
                'name'  => $prefix . '_ratio',
                'type'  => 'text',
                'placeholder' => '1:15',
                'wrapper' => [ 'width' => '16' ],
            ];

            $fields[] = [
                'key'   => $key_prefix . '_temp',
                'label' => 'Temp (°C)',
                'name'  => $prefix . '_temp',
                'type'  => 'number',
                'default_value' => 93,
                'wrapper' => [ 'width' => '16' ],
            ];

            $fields[] = [
                'key'   => $key_prefix . '_time',
                'label' => 'Total Time',
                'name'  => $prefix . '_time',
                'type'  => 'text',
                'placeholder' => '3:30',
                'wrapper' => [ 'width' => '16' ],
            ];

            $fields[] = [
                'key'   => $key_prefix . '_grind',
                'label' => 'Grind Position (0 = fine, 100 = coarse)',
                'name'  => $prefix . '_grind',
                'type'  => 'range',
                'min'   => 0,
                'max'   => 100,
                'step'  => 1,
                'default_value' => 35,
            ];

            $fields[] = [
                'key'   => $key_prefix . '_tip_da',
                'label' => 'Pro Tip (DA)',
                'name'  => $prefix . '_tip_da',
                'type'  => 'textarea',
                'rows'  => 2,
                'wrapper' => [ 'width' => '50' ],
            ];

            $fields[] = [
                'key'   => $key_prefix . '_tip_en',
                'label' => 'Pro Tip (EN)',
                'name'  => $prefix . '_tip_en',
                'type'  => 'textarea',
                'rows'  => 2,
                'wrapper' => [ 'width' => '50' ],
            ];

            // Steps repeater
            $fields[] = [
                'key'        => $key_prefix . '_steps',
                'label'      => 'Brew Steps',
                'name'       => $prefix . '_steps',
                'type'       => 'repeater',
                'min'        => 1,
                'max'        => 10,
                'layout'     => 'block',
                'button_label' => 'Add Step',
                'sub_fields' => [
                    [
                        'key'   => $key_prefix . '_step_title_da',
                        'label' => 'Step Title (DA)',
                        'name'  => 'title_da',
                        'type'  => 'text',
                        'wrapper' => [ 'width' => '25' ],
                    ],
                    [
                        'key'   => $key_prefix . '_step_title_en',
                        'label' => 'Step Title (EN)',
                        'name'  => 'title_en',
                        'type'  => 'text',
                        'wrapper' => [ 'width' => '25' ],
                    ],
                    [
                        'key'   => $key_prefix . '_step_desc_da',
                        'label' => 'Description (DA)',
                        'name'  => 'desc_da',
                        'type'  => 'textarea',
                        'rows'  => 2,
                        'wrapper' => [ 'width' => '20' ],
                    ],
                    [
                        'key'   => $key_prefix . '_step_desc_en',
                        'label' => 'Description (EN)',
                        'name'  => 'desc_en',
                        'type'  => 'textarea',
                        'rows'  => 2,
                        'wrapper' => [ 'width' => '20' ],
                    ],
                    [
                        'key'   => $key_prefix . '_step_time',
                        'label' => 'Timer (sec)',
                        'name'  => 'time_seconds',
                        'type'  => 'number',
                        'default_value' => 0,
                        'wrapper' => [ 'width' => '10' ],
                    ],
                ],
            ];
        }

        acf_add_local_field_group( [
            'key'      => 'group_sara_brew_recipes',
            'title'    => 'Brew Recipes',
            'fields'   => $fields,
            'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'product' ] ] ],
            'menu_order' => 20,
            'style'    => 'default',
        ] );
    }

    /**
     * Get normalized recipe data for a product.
     * Returns associative array of methods or false if no recipe.
     */
    public static function get_recipe_data( $product_id ) {
        if ( ! function_exists( 'get_field' ) ) return false;
        if ( ! get_field( 'recipe_has_recipe', $product_id ) ) return false;

        $data = [];

        foreach ( self::$methods as $key => $names ) {
            $prefix = 'recipe_' . $key;

            $steps_raw = get_field( $prefix . '_steps', $product_id );
            $steps = [];
            if ( is_array( $steps_raw ) ) {
                foreach ( $steps_raw as $s ) {
                    $steps[] = [
                        'title_da'     => $s['title_da'] ?? '',
                        'title_en'     => $s['title_en'] ?? '',
                        'desc_da'      => $s['desc_da'] ?? '',
                        'desc_en'      => $s['desc_en'] ?? '',
                        'time_seconds' => (int) ( $s['time_seconds'] ?? 0 ),
                    ];
                }
            }

            $data[ $key ] = [
                'key'       => $key,
                'name_da'   => $names['da'],
                'name_en'   => $names['en'],
                'coffee_g'  => (int) get_field( $prefix . '_coffee_g', $product_id ),
                'water_ml'  => (int) get_field( $prefix . '_water_ml', $product_id ),
                'ratio'     => get_field( $prefix . '_ratio', $product_id ) ?: '',
                'temp'      => (int) get_field( $prefix . '_temp', $product_id ),
                'time'      => get_field( $prefix . '_time', $product_id ) ?: '',
                'grind'     => (int) get_field( $prefix . '_grind', $product_id ),
                'tip_da'    => get_field( $prefix . '_tip_da', $product_id ) ?: '',
                'tip_en'    => get_field( $prefix . '_tip_en', $product_id ) ?: '',
                'steps'     => $steps,
            ];
        }

        return $data;
    }

    public static function get_methods() {
        return self::$methods;
    }
}
