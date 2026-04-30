<?php
/**
 * Plugin Handler Class
 *
 * @package MacrosBySara
 */

namespace MacrosBySara\Theme;

use MacrosBySara\Plugins\ACF_Handler;
use MacrosBySara\Plugins\PMPro_Handler;

/**
 * Class: Plugin Handler
 */
class Plugin_Handler {
	/**
	 * Handle plugins by checking if they are defined and initializing them.
	 */
	public function handle_plugins() {
		$this->handle_acf();
		$this->handle_pmpro();
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

	/**
	 * Handle PMPro
	 */
	private function handle_pmpro() {
		if ( ! is_plugin_active( 'paid-memberships-pro/paid-memberships-pro.php' ) ) {
			return;
		}
		$consistency_club_levels = array( 2, 3, 4, 5 ); // Define your PMPro membership levels here
		$pmpro_handler           = new PMPro_Handler( 'cc-post', $consistency_club_levels );
		$pmpro_handler->lock_down_cpt();
		add_filter( 'pmpro_member_action_links', array( $pmpro_handler, 'edit_membership_action_links' ), 10, 2 );
	}
}
