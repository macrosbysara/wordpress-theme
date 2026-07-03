<?php
/**
 * Class: Theme Init
 *
 * Handle Theme Needs
 *
 * @package MacrosBySara
 */

namespace MacrosBySara\Theme;

/**
 * Class: Theme Init
 */
class Theme_Init {
	/**
	 * Bootstrap the theme by setting up supports and disabling comments.
	 */
	public function bootstrap_theme() {
		$this->disable_discussion();
		$this->configure_theme_support();
		$this->configure_gutenberg_support();
		$plugin_handler = new Plugin_Handler();
		$plugin_handler->handle_plugins();
		$router = new Rest_Router();
		add_action( 'rest_api_init', array( $router, 'register_routes' ) );
		add_action( 'init', array( $this, 'alter_post_types' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'wp_speculation_rules_configuration', array( $this, 'handle_speculative_loading' ) );
	}

	/** Remove comments and pings support from posts types. */
	private function disable_discussion() {
		// Close comments on the front-end
		add_filter( 'comments_open', '__return_false', 20, 2 );
		add_filter( 'pings_open', '__return_false', 20, 2 );

		// Hide existing comments.
		add_filter( 'comments_array', '__return_empty_array', 10, 2 );

		// Remove comments page in menu.
		add_action(
			'admin_menu',
			fn() =>  remove_menu_page( 'edit-comments.php' )
		);

		// Remove comments links from admin bar.
		add_action(
			'init',
			fn() => is_admin_bar_showing() && remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 )
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

	/**
	 * Configure Gutenberg support by enqueuing block editor assets and adding theme supports for Gutenberg features.
	 */
	public function configure_gutenberg_support() {
		$gutenberg_handler = new Gutenberg_Handler();
		$gutenberg_handler->theme_supports();
		add_action( 'enqueue_block_editor_assets', array( $gutenberg_handler, 'enqueue_block_assets' ) );
		add_action( 'init', array( $gutenberg_handler, 'register_theme_blocks' ) );
		add_action( 'wp_enqueue_scripts', array( $gutenberg_handler, 'enqueue_frontend_block_assets' ) );
	}

	/** Alter Post Types. */
	public function alter_post_types() {
		add_post_type_support( 'page', 'excerpt' );
		$args = get_post_type_object( 'cc-post' );
		$icon = get_theme_file_path( 'assets/cc-icon-white.svg' );
		register_post_type(
			'cc-post',
			array_merge(
				(array) $args,
				array(
					'menu_icon' => 'data:image/svg+xml;base64, ' . base64_encode( file_get_contents( $icon ) ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode, WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
				)
			)
		);
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts(): void {
		$files       = array(
			'bootstrap' => array(
				'css' => 'vendors/bootstrap',
			),
			'global'    => array(
				'js'  => 'global',
				'css' => 'global',
			),
		);
		$site_assets = require get_stylesheet_directory() . '/build/global.asset.php';
		wp_enqueue_script(
			'global',
			get_stylesheet_directory_uri() . '/build/global.js',
			$site_assets['dependencies'],
			$site_assets['version'],
			array( 'strategy' => 'defer' )
		);
		wp_enqueue_style(
			'global',
			get_stylesheet_directory_uri() . '/build/global.css',
			$site_assets['dependencies'],
			$site_assets['version'],
		);
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
