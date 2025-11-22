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
	 * Handle for the custom pre-publish sidebar
	 *
	 * @var string
	 */
	private string $custom_sidebar_handle;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->custom_sidebar_handle = 'pre-publish-sidebar';
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_assets' ) );
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'init', array( $this, 'register_theme_blocks' ) );
		add_action( 'init', array( $this, 'register_custom_sidebar_script' ) );
	}

	/**
	 * Enqueue the block editor assets that control the layout of the Block Editor.
	 */
	public function enqueue_block_assets() {
		$files = array( 'editDefaultBlocks', 'prePublishValidation' );
		foreach ( $files as $handle ) {
			$assets = require_once get_stylesheet_directory() . "/build/admin/{$handle}.asset.php";

			wp_enqueue_script(
				$handle,
				get_stylesheet_directory_uri() . "/build/admin/{$handle}.js",
				$assets['dependencies'],
				$assets['version'],
				array( 'strategy' => 'defer' )
			);
		}
	}

	/**
	 * Add theme supports for Gutenberg features
	 */
	public function theme_supports() {
		$opt_in_features = array(
			'responsive-embeds',
		);
		foreach ( $opt_in_features as $feature ) {
			add_theme_support( $feature );
		}

		$opt_out_features = array(
			'core-block-patterns',
		);
		foreach ( $opt_out_features as $feature ) {
			remove_theme_support( $feature );
		}
	}

	/**
	 * Register any theme-specific blocks
	 */
	public function register_theme_blocks() {
		// Load blocks
		$blocks_path = get_template_directory() . '/build';
		wp_register_block_types_from_metadata_collection( $blocks_path . '/js/blocks', $blocks_path . '/blocks-manifest.php' );
	}

	/**
	 * Register the custom pre-publish sidebar script
	 */
	public function register_custom_sidebar_script() {
		$filename = 'prePublishValidation';
		$assets   = require_once get_stylesheet_directory() . "/build/admin/{$filename}.asset.php";

		wp_register_script(
			$this->custom_sidebar_handle,
			get_stylesheet_directory_uri() . "/build/admin/{$filename}.js",
			$assets['dependencies'],
			$assets['version'],
			array( 'strategy' => 'defer' )
		);
	}
}
