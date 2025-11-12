<?php
/**
 * Rest Router
 *
 * @package MacrosBySara
 */

namespace MacrosBySara;

use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_interest_form_script' ), 100 );
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
				'permission_callback' => array( $this, 'allow_public_access' ),
				'args'                => array(
					'firstName' => array(
						'required'          => true,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'lastName'  => array(
						'required'          => true,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'email'     => array(
						'required'          => true,
						'sanitize_callback' => 'sanitize_email',
						'validate_callback' => 'is_email',
					),
					'interest'  => array(
						'required'          => true,
						'sanitize_callback' => 'sanitize_text_field',
						'validate_callback' => function ( $param ) {
							$valid_options = array(
								'macros',
								'habits',
								'one-time-macros',
								'fitness',
							);
							return in_array( $param, $valid_options, true );
						},
					),
				),
			)
		);
	}

	/**
	 * Example endpoint callback.
	 *
	 * @param WP_REST_Request $request The REST request.
	 * @return WP_REST_Response The REST response.
	 */
	public function example_endpoint_callback( WP_REST_Request $request ): WP_REST_Response {
		$first_name = $request->get_param( 'firstName' );
		$last_name  = $request->get_param( 'lastName' );
		$email      = $request->get_param( 'email' );
		$interest   = $request->get_param( 'interest' );
		$data       = array(
			'status'  => 'success',
			'message' => 'Interest form submitted successfully!',
			'data'    => array(
				'firstName' => $first_name,
				'lastName'  => $last_name,
				'email'     => $email,
				'interest'  => $interest,
			),
		);
		return rest_ensure_response( $data );
	}

	/**
	 * Enqueue interest form script with localized REST API data.
	 */
	public function enqueue_interest_form_script() {
		wp_localize_script(
			'global',
			'mbsRestApi',
			array(
				'root'  => esc_url_raw( rest_url() . $this->namespace ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
			)
		);
		wp_enqueue_script(
			'cloudflare',
			'https://challenges.cloudflare.com/turnstile/v0/api.js',
			array( 'global' ),
			null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			array(
				'strategy' => 'async',
			)
		);
	}

	/**
	 * Allow public access to the endpoint.
	 *
	 * @param WP_REST_Request $request The REST request.
	 * @return bool
	 */
	public function allow_public_access( WP_REST_Request $request ): bool {
		$nonce   = null;
		$headers = $request->get_headers();
		if ( isset( $headers['x_wp_nonce'] ) ) {
			$nonce = $headers['x_wp_nonce'];
		}
		$verified = wp_verify_nonce( $nonce[0], 'wp_rest' );
		if ( ! $verified ) {
			return false;
		}
		// Validate Cloudflare Turnstile.
		// $this->validate_turnstile(
		// sanitize_text_field( $_POST['cf-turnstile-response'] ?? '' ),
		// '0x4AAAAAAAD7F7B8D3E6B1C2D3E4F5A6B7C8D9E0F'
		// );
		return true;
	}


	/**
	 * Validate Cloudflare Turnstile response.
	 *
	 * @param string      $token    The Turnstile token from the client.
	 * @param string      $secret   The secret key for server-side validation.
	 * @param string|null $remoteip Optional. The user's IP address.
	 * @return array The validation response.
	 */
	private function validate_turnstile( $token, $secret, $remoteip = null ) {
		$url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

		$data = array(
			'secret'   => CF_TURNSTILE_SECRET,
			'response' => $token,
		);

		if ( $remoteip ) {
			$data['remoteip'] = $remoteip;
		}

		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query( $data ),
			),
		);

		$context  = stream_context_create( $options );
		$response = file_get_contents( $url, false, $context );

		if ( $response === false ) {
			return array(
				'success'     => false,
				'error-codes' => array( 'internal-error' ),
			);
		}

		return json_decode( $response, true );
	}
}
