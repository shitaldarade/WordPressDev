<?php
/**
 * Plugin compatibility/integration component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Plugin;

use WebManDesign\Bjork\Component_Interface;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Component implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Plugin recommendations.
			TGMPA::init();

			// Loading plugins:

				if ( class_exists( 'OCDI_Plugin' ) && is_admin() ) {
					One_Click_Demo_Import\Component::init();
				}

				if ( class_exists( 'FLBuilder' ) ) {
					Beaver_Builder\Component::init();
				}

				if ( function_exists( 'bcn_display' ) ) {
					Breadcrumb_NavXT\Component::init();
				}

				if ( class_exists( 'Jetpack' ) ) {
					Jetpack\Component::init();
				}

				if ( class_exists( 'WooCommerce' ) ) {
					WooCommerce\Component::init();
				}

	} // /init

}
