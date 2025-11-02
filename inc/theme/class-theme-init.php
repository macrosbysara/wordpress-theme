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
	 * Utils Loader
	 *
	 * @var Utils_Loader $loader
	 */
	private Utils_Loader $loader;

	/**
	 * Constructor
	 */
	public function __construct() {
		require_once get_stylesheet_directory() . '/inc/theme/class-utils-loader.php';
		$this->loader = new Utils_Loader();
		$this->loader->load_files();
		$this->disable_discussion();
		add_action( 'after_setup_theme', array( $this, 'configure_theme_support' ) );
		add_action( 'init', array( $this, 'alter_post_types' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'wp_speculation_rules_configuration', array( $this, 'handle_speculative_loading' ) );
	}

	/** Remove comments, pings and trackbacks support from posts types. */
	private function disable_discussion() {
		// Close comments on the front-end
		add_filter( 'comments_open', '__return_false', 20, 2 );
		add_filter( 'pings_open', '__return_false', 20, 2 );

		// Hide existing comments.
		add_filter( 'comments_array', '__return_empty_array', 10, 2 );

		// Remove comments page in menu.
		add_action(
			'admin_menu',
			function () {
				remove_menu_page( 'edit-comments.php' );
			}
		);

		// Remove comments links from admin bar.
		add_action(
			'init',
			function () {
				if ( is_admin_bar_showing() ) {
					remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
				}
			}
		);
	}

	/** Registers Theme Supports */
	public function configure_theme_support() {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );

		register_nav_menus(
			array(
				'primary_menu' => 'Primary Menu',
				'footer_menu'  => 'Footer Menu',
			)
		);
	}

	/** Alter Post Types. */
	public function alter_post_types() {
		add_post_type_support( 'page', 'excerpt' );
	}


	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts(): void {
		$files = array(
			'bootstrap' => array(
				'js'  => '/vendors/bootstrap',
				'css' => '/vendors/bootstrap',
			),
			'global'    => array(
				'js'  => 'global',
				'css' => 'global',
			),
		);
		foreach ( $files as $handle => $paths ) {
			$assets = require_once get_stylesheet_directory() . "/build/{$paths['js']}.asset.php";

			$deps = $assets['dependencies'];
			if ( 'bootstrap' !== $handle ) {
				// Ensure bootstrap JS loads after jQuery
				$deps = array_merge( $deps, array( 'bootstrap' ) );
			}
			wp_enqueue_script(
				$handle,
				get_stylesheet_directory_uri() . '/build' . $paths['js'] . '.js',
				$deps,
				$assets['version'],
				array( 'strategy' => 'defer' )
			);
			wp_enqueue_style(
				$handle,
				get_stylesheet_directory_uri() . '/build' . $paths['css'] . '.css',
				$deps,
				$assets['version'],
			);
		}
	}

	/**
	 * Handle speculative loading
	 *
	 * @param ?array $config the configuration array. Null if user is logged-in.
	 * @return ?array The new config file, or null
	 */
	public function handle_speculative_loading( $config ) {
		if ( is_array( $config ) ) {
			$config['mode']      = 'auto';
			$config['eagerness'] = 'moderate';
		}
		return $config;
	}
}
