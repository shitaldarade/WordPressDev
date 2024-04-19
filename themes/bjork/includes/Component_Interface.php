<?php
/**
 * Theme component interface.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

interface Component_Interface {

	/**
	 * Component initialization.
	 *
	 * Usually contains hooks to integrate with WordPress
	 * and/or loads additional sub-components.
	 */
	public static function init();

}
