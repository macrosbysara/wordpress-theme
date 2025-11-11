<?php
/**
 * Rest Router
 *
 * @package MacrosBySara
 */

namespace MacrosBySara;

use WP_REST_Controller;
use WP_REST_Server;

/**
 * Class: Rest Router
 */
class Rest_Router extends WP_REST_Controller {
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->namespace = 'mbs/v1';
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register routes.
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace . '/forms',
			'/interest-form',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'example_endpoint_callback' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Example endpoint callback.
	 *
	 * @param WP_REST_Request $request The REST request.
	 * @return WP_REST_Response The REST response.
	 */
	public function example_endpoint_callback( $request ) {
		$data = array(
			'message' => 'Interest form submitted successfully!',
		);
		return rest_ensure_response( $data );
	}
}
