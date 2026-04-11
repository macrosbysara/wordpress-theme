<?php
/**
 * FUNCTIONS.PHP
 *
 * @package MacrosBySara
 */

use MacrosBySara\Theme\Theme_Init;

$autoloader = get_stylesheet_directory() . '/vendor/autoload.php';
if ( file_exists( $autoloader ) ) {
	require_once $autoloader;
} else {
	wp_die( 'Autoloader not found. Please run composer install.' );
}
$theme = new Theme_Init();
add_action( 'after_setup_theme', array( $theme, 'bootstrap_theme' ) );