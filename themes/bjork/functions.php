<?php
/**
 * Loading theme functionality.
 *
 * @link  https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Check that the site meets the minimum requirements:

	define( 'BJORK_WP_VERSION', '5.2' );
	define( 'BJORK_PHP_VERSION', '7.0' );

	if (
		version_compare( $GLOBALS['wp_version'], BJORK_WP_VERSION, '<' )
		|| version_compare( PHP_VERSION, BJORK_PHP_VERSION, '<' )
	) {
		require_once get_template_directory() . '/includes/Compatibility.php';
		return;
	}

// Constants:

	define( 'BJORK_THEME_VERSION', wp_get_theme( 'bjork' )->get( 'Version' ) );

	define( 'BJORK_PATH', trailingslashit( get_template_directory() ) );
		define( 'BJORK_PATH_INCLUDES', BJORK_PATH . 'includes/' );
		define( 'BJORK_PATH_VENDOR',   BJORK_PATH . 'vendor/' );

	if ( ! defined( 'BJORK_ENQUEUE_PRIORITY' ) ) {
		/**
		 * Theme assets enqueue priority.
		 *
		 * To rise the priority use:
		 * =========================
		 * + 1...9 for core theme assets setup,
		 * + 10...98 for additional assets setup,
		 * + 99 for modifications, such as deregistering and dequeuing.
		 */
		define( 'BJORK_ENQUEUE_PRIORITY', 11 );
	}

// Load theme functionality.
require_once BJORK_PATH_INCLUDES . 'Autoload.php';
WebManDesign\Bjork\Theme::init();
