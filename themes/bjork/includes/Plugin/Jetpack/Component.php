<?php
/**
 * Jetpack integration component.
 *
 * @link  https://wordpress.org/plugins/jetpack/
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.13
 */

namespace WebManDesign\Bjork\Plugin\Jetpack;

use WebManDesign\Bjork\Component_Interface;
use Automattic\Jetpack\Status;
use Jetpack;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Component implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since    1.0.0
	 * @version  1.0.13
	 *
	 * @return  void
	 */
	public static function init() {

		// Requirements check

			if ( ! Jetpack::is_active() && ! ( new Status() )->is_offline_mode() ) {
				return;
			}


		// Processing

			Setup::init();

			Assets::init();

			Content_Options::init();
			Infinite_Scroll::init();
			Post_Types::init();

	} // /init

}
