<?php
/**
 * WooCommerce integration component.
 *
 * @link  https://wordpress.org/plugins/woocommerce/
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Plugin\WooCommerce;

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

			Setup::init();

			Assets::init();
			Customize::init();
			Loop::init();
			Pages::init();
			Single::init();
			Widgets::init();
			Wrappers::init();

	} // /init

}
