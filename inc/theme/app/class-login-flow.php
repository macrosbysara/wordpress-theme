<?php
/**
 * JWT WP Login Flow
 *
 * @package MacrosBySara\Theme\App
 */

namespace MacrosBySara\Theme\App;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Class: JWT WP Login Controller
 */
class Jwt_Wp_Login_Controller {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action(
			'rest_api_init',
			function () {
				register_rest_route(
					'app/v1',
					'/wp-login-sync',
					array(
						'methods'             => 'POST',
						'callback'            => array( $this, 'handle' ),
						'permission_callback' => '__return_true', // JWT handles auth
					)
				);
			}
		);
	}

	/**
	 * Handle the WP login sync request.
	 *
	 * @param WP_REST_Request $request The REST request.
	 * @return WP_REST_Response The REST response.
	 */
	public function handle( WP_REST_Request $request ): WP_REST_Response {
		$user_id = get_current_user_id();

		if ( 0 === $user_id ) {
			return new WP_REST_Response(
				array( 'message' => 'Invalid JWT' ),
				401
			);
		}

		wp_set_current_user( $user_id );
		wp_set_auth_cookie( $user_id, true );
		do_action( 'wp_login', wp_get_current_user()->user_login, wp_get_current_user() );

		return new WP_REST_Response(
			array( 'success' => true ),
			200
		);
	}
}