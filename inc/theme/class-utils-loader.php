<?php
/**
 * Utils Loader
 *
 * @package MacrosBySara
 */

namespace MacrosBySara;

/**
 * Class: Utils Loader
 */
class Utils_Loader {
	/**
	 * Base path for utils
	 *
	 * @var string $base_path
	 */
	public string $base_path;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->base_path = get_stylesheet_directory() . '/inc';
	}

	/**
	 * Load Required Files
	 */
	public function load_files() {

		// Require Navwalker
		require_once $this->base_path . '/theme/navwalkers/class-navwalker.php';

		// Theme Utils
		$theme_files = array(
			'gutenberg-handler' => 'Gutenberg_Handler',
			'rest-router'       => 'Rest_Router',
		);
		$this->load_utils( '/theme', $theme_files );
		$this->load_acf_utils();
	}

	/**
	 * Load Utils
	 *
	 * @param string $path  Path to utils.
	 * @param array  $files Array of files to load.
	 */
	private function load_utils( string $path, array $files ) {
		foreach ( $files as $file => $class ) {
			require_once $this->base_path . "{$path}/class-{$file}.php";
			if ( $class ) {
				$class = __NAMESPACE__ . "\\{$class}";
				new $class();
			}
		}
	}

	/**
	 * Load ACF Utils
	 */
	private function load_acf_utils() {
		$plugin_files = array(
			'acf-handler' => array(
				'class' => 'ACF_Handler',
				'dir'   => 'acf',
			),
		);
		foreach ( $plugin_files as $file => $data ) {
			require_once $this->base_path . "/plugins/{$data['dir']}/class-{$file}.php";
			if ( $data['class'] ) {
				$class = __NAMESPACE__ . "\\{$data['class']}";
				new $class();

			}
		}
	}
}
