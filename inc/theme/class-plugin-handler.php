<?php
/**
 * Plugin Handler Class
 *
 * @package MacrosBySara
 */

namespace MacrosBySara\Theme;

use MacrosBySara\Plugins\ACF_Handler;

/**
 * Class: Plugin Handler
 */
class Plugin_Handler {
	/**
	 * Handle plugins by checking if they are defined and initializing them.
	 */
	public function handle_plugins() {
		$this->handle_acf();
	}

	/**
	 * Handle ACF by checking if it is defined and initializing the ACF Handler.
	 */
	private function handle_acf() {
		if ( ! defined( 'ACF_VERSION' ) ) {
			return;
		}
		$acf_handler = new ACF_Handler();
		$acf_handler->init_save_filters();
		add_filter( 'acf/settings/load_json', array( $acf_handler, 'load_json_paths' ) );
	}
}
