<?php
/**
 * Rest Router
 *
 * @package MacrosBySara
 */

namespace MacrosBySara\Theme;

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
				'callback'            => array( $this, 'handle_interest_form' ),
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
	public function handle_interest_form( WP_REST_Request $request ): WP_REST_Response {
		$first_name     = $request->get_param( 'firstName' );
		$last_name      = $request->get_param( 'lastName' );
		$email          = $request->get_param( 'email' );
		$interest       = $request->get_param( 'interest' );
		$client_success = wp_mail( $email, 'Interest Form Submission', "Hey {$first_name}, thanks for your interest in $interest! I'll be in touch soon.", array( 'Reply-To' => 'hello@macrosbysara.com' ) );
		$admin_success  = wp_mail( 'hello@macrosbysara.com', 'Interest Form Submission', "{$first_name} {$last_name} ({$email}) is interested in {$interest}." );
		$success        = $client_success && $admin_success;
		$data           = array(
			'data' => array(
				'status'    => 200,
				'firstName' => $first_name,
				'lastName'  => $last_name,
				'email'     => $email,
				'interest'  => $interest,
			),
		);
		if ( ! $success ) {
			$data['message'] = 'Failed to send email.';
			$data['code']    = 500;
		} else {
			$data['message'] = 'Interest form submitted successfully!';
			$data['code']    = 200;
		}
		return rest_ensure_response( $data );
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
		return true;
	}


	/**
	 * Validate Cloudflare Turnstile response.
	 *
	 * @param string      $token    The Turnstile token from the client.
	 * @param string|null $remoteip Optional. The user's IP address.
	 * @return bool True if validation is successful, false otherwise.
	 */
	private function cloudflare_validation( string $token, ?string $remoteip = null ): bool {
		$url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

		$data = array(
			'secret'   => CF_TURNSTILE_SECRET,
			'response' => $token,
		);

		if ( $remoteip ) {
			$data['remoteip'] = $remoteip;
		}

		$response = wp_remote_post(
			$url,
			array(
				'headers' => array( 'Content-Type' => 'application/x-www-form-urlencoded' ),
				'body'    => $data,
				'timeout' => 10,
			)
		);
		if ( is_wp_error( $response ) ) {
			return false;
		}

		$response      = wp_remote_retrieve_body( $response );
		$response_data = json_decode( $response, true );
		return $response_data['success'] ?? false;
	}
}
