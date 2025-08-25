<?php
/**
 * Gutenberg Handler
 *
 * Handle all Block-Theme related functionality (since we're currently operating in hybrid theme mode)
 *
 * @package MacrosBySara
 */

namespace MacrosBySara;

/**
 * Gutenberg Handler
 */
class Gutenberg_Handler {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
	}

	/**
	 * Add theme supports for Gutenberg features
	 */
	public function theme_supports() {
		$opt_in_features = array( 'align-wide', 'disable-custom-colors', 'responsive-embeds', 'disable-custom-gradients', 'disable-custom-font-sizes' );

		foreach ( $opt_in_features as $feature ) {
			add_theme_support( $feature );
		}
	}
}
