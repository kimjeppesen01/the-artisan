<?php
namespace Elementor\Modules\Library\Documents;
use Elementor\Core\DocumentTypes\Post;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Elementor section library document.
 *
 * Elementor section library document handler class is responsible for
 * handling a document of a section type.
 *
 * @since 2.0.0
 */
class Pe_Post extends Library_Document {

	public static function get_properties() {
		$properties = parent::get_properties();
        
        $properties['support_wp_page_templates'] = true;
		$properties['support_kit'] = true;
		$properties['show_in_finder'] = true;

		return $properties;
	}

	public static function get_type() {
		return 'pe-post';
	}

	/**
	 * Get document title.
	 *
	 * Retrieve the document title.
	 *
	 * @since 2.0.0
	 * @access public
	 * @static
	 *
	 * @return string Document title.
	 */
	public static function get_title() {
		return esc_html__( 'Pe - Post', 'elementor' );
	}

	public static function get_plural_title() {
		return esc_html__( 'Pe - Post', 'elementor' );
	}
    
    	protected function register_controls() {
		parent::register_controls();

		Post::register_hide_title_control( $this );

		Post::register_style_controls( $this );
	}
    
    

}
