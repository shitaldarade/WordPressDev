<?php
/**
 * WooCommerce integration: Assets component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Plugin\WooCommerce;

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

				add_action( 'init', __CLASS__ . '::remove_gallery_noscript' );

				add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue', BJORK_ENQUEUE_PRIORITY + 5 );

				add_action( 'tha_content_top', __CLASS__ . '::print', 1 );
				add_action( 'woocommerce_product_after_tabs', __CLASS__ . '::print', 0 );

			// Filters

				add_filter( 'bjork/assets/styles/get_css_files', __CLASS__ . '::get_css_files' );

				add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

	} // /init

	/**
	 * Enqueue assets.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  void
	 */
	public static function enqueue() {

		// Processing

			if ( is_product() ) {
				_Assets\Factory::script_enqueue( array(
					'handle'   => 'bjork-woocommerce',
					'src'      => get_theme_file_uri( 'assets/js/woocommerce.min.js' ),
					'deps'     => array( 'wc-single-product' ),
					'add_data' => array(
						'precache' => true,
					),
				) );
			}

	} // /enqueue

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

			$css_files['bjork-woocommerce'] = array(
				'src'      => get_theme_file_uri( 'assets/css/woocommerce.css' ),
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
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  void
	 */
	public static function print() {

		// Processing

			if ( doing_action( 'tha_content_top' ) ) {
				_Assets\Factory::print_styles( 'bjork-woocommerce' );
			}

			if ( doing_action( 'woocommerce_product_after_tabs' ) ) {
				_Assets\Factory::print_styles( 'bjork-comments' );
			}

	} // /print

	/**
	 * Remove unnecessary `noscript` tag.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function remove_gallery_noscript() {

		// Processing

			remove_action( 'wp_head', 'wc_gallery_noscript' );

	} // /remove_gallery_noscript

}
