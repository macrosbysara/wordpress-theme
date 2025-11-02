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
	 * Constructor
	 */
	public function __construct() {
		$this->load_files();
		// add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'wp_speculation_rules_configuration', array( $this, 'handle_speculative_loading' ) );
	}

	/**
	 * Load Required Files
	 */
	private function load_files() {
		$base_path   = get_stylesheet_directory() . '/inc';
		$theme_files = array(
			'gutenberg-handler' => 'Gutenberg_Handler',
		);
		foreach ( $theme_files as $file => $class ) {
			require_once $base_path . "/theme/class-{$file}.php";
			if ( $class ) {
				$class = __NAMESPACE__ . "\\{$class}";
				new $class();

			}
		}
		$plugin_files = array(
			'acf-handler' => array(
				'class' => 'ACF_Handler',
				'dir'   => 'acf',
			),
		);
		foreach ( $plugin_files as $file => $data ) {
			require_once $base_path . "/plugins/{$data['dir']}/class-{$file}.php";
			if ( $data['class'] ) {
				$class = __NAMESPACE__ . "\\{$data['class']}";
				new $class();

			}
		}
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
