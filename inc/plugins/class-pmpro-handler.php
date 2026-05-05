<?php
/**
 * PMPro Handler Class
 *
 * @package MacrosBySara
 */

namespace MacrosBySara\Plugins;

use WP_Query;

/**
 * Class: PMPro Handler
 */
class PMPro_Handler {
	/**
	 * An array of PMPro membership levels that grant access to the content.
	 *
	 * @var string[] $consistency_club_levels
	 */
	private array $consistency_club_levels;

	/**
	 * The slug of the custom post type to lock.
	 *
	 * @var string $cc_post_type_slug
	 */
	private string $cc_post_type_slug;

	/**
	 * Constructor
	 *
	 * @param string $cc_post_type_slug The slug of the custom post type to lock
	 * @param int[]  $consistency_club_levels An array of PMPro membership levels that grant access to the content.
	 */
	public function __construct( string $cc_post_type_slug, array $consistency_club_levels = array() ) {
		$this->cc_post_type_slug       = $cc_post_type_slug;
		$this->consistency_club_levels = array_map( 'strval', $consistency_club_levels );
	}

	/**
	 * Check if the current user has a valid membership level.
	 *
	 * @param ?int $user_id [Optional] The ID of the user to check. Defaults to the current user.
	 * @return bool True if the user has a valid membership level, false otherwise.
	 */
	private function user_has_valid_level( ?int $user_id = null ): bool {
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		}
		return pmpro_hasMembershipLevel( $this->consistency_club_levels, $user_id );
	}

	/**
	 * Check if a post is marked as a freebie.
	 *
	 * @param ?int $post_id [Optional] The ID of the post to check. Defaults to the current post in the loop.
	 * @return bool True if the post is a freebie, false otherwise.
	 */
	private function post_is_freebie( ?int $post_id = null ): bool {
		if ( is_null( $post_id ) ) {
			$post_id = get_the_ID();
		}
		return has_term( 'freebie', 'cc-tag', $post_id );
	}

	/**
	 * Lock down CPT.
	 */
	public function lock_down_cpt() {
		add_filter( 'the_content', array( $this, 'lock_down_single_content' ) );
		add_action( 'pre_get_posts', array( $this, 'lock_down_queries' ) );
	}

	/**
	 * Lock down the content of single CPT pages.
	 *
	 * @param string $content The original content.
	 * @return string The modified content if access is denied, otherwise the original content.
	 */
	public function lock_down_single_content( $content ): string {
		if ( is_singular( $this->cc_post_type_slug ) ) {
			if ( ! $this->user_has_valid_level() && ! $this->post_is_freebie() ) {
				return '<p>You must be a member to view this content.</p>';
			}
		}
		return $content;
	}

	/**
	 * Lock down queries for the CPT archive and single pages.
	 *
	 * @param WP_Query $query The current query object.
	 */
	public function lock_down_queries( WP_Query $query ): void {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		$restricted_post_types = array( $this->cc_post_type_slug );

		if ( is_post_type_archive( $restricted_post_types ) || is_singular( $restricted_post_types ) ) {
			if ( ! $this->user_has_valid_level() && ! $this->post_is_freebie() ) {
				wp_safe_redirect( '/consistency-club' );
				exit;
			}
		}
	}
}
