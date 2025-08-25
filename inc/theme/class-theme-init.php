<?php
/**
 * Class: Theme Init
 *
 * Handle Theme Needs
 *
 * @package MacrosBySara
 */

namespace MacrosBySara;

/**
 * Class: Theme Init
 */
class Theme_Init {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->load_files();
		add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );
	}

	/**
	 * Load Required Files
	 */
	private function load_files() {
		$base_path   = get_template_directory() . '/inc';
		$theme_files = array(
			'gutenberg-handler' => 'Gutenberg_Handler',
			'cpt-handler'       => 'CPT_Handler',
		);
		foreach ( $theme_files as $file => $class ) {
			require_once $base_path . "/theme/class-{$file}.php";
			if ( $class ) {
				$class = __NAMESPACE__ . "\\{$class}";
				new $class();

			}
		}
	}
}
