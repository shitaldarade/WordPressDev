<?php
/**
 * Jetpack integration: Assets component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Plugin\Jetpack;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Assets as _Assets;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Assets implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Actions

				add_action( 'tha_content_top', __CLASS__ . '::print', 1 );

			// Filters

				add_filter( 'bjork/assets/styles/get_css_files', __CLASS__ . '::get_css_files' );

	} // /init

	/**
	 * Register stylesheet.
	 *
	 * @since  1.0.4
	 *
	 * @param  array $css_files
	 *
	 * @return  array
	 */
	public static function get_css_files( array $css_files ): array {

		// Processing

			$css_files['bjork-jetpack'] = array(
				'src'      => get_theme_file_uri( 'assets/css/jetpack.css' ),
				'add_data' => array(
					'rtl'      => 'replace',
					'precache' => true,
				),
				'preload_callback' => '__return_true',
			);


		// Output

			return $css_files;

	} // /get_css_files

	/**
	 * Print styles in page content.
	 *
	 * @since  1.0.4
	 *
	 * @return  void
	 */
	public static function print() {

		// Processing

			_Assets\Factory::print_styles( 'bjork-jetpack' );

	} // /print

}
