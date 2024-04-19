<?php
/**
 * Tool component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Tool;

use WebManDesign\Bjork\Component_Interface;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Component implements Component_Interface {

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

			// Loading individual tool components.
			AMP::init();
			Google_Fonts::init();
			KSES::init();
			Page_Builder::init();
			Starter_Content::init();
			Wrapper::init();
			Update_Notification::init();

	} // /init

}
