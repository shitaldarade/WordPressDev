<?php
/**
 * Breadcrumb NavXT integration component.
 *
 * @link  https://wordpress.org/plugins/breadcrumb-navxt/
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Plugin\Breadcrumb_NavXT;

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

			// Actions

				add_action( 'tha_footer_top', __CLASS__ . '::display', 5 );

	} // /init

	/**
	 * Breadcrumbs HTML.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  void
	 */
	public static function display() {

		// Output

			get_template_part( 'templates/parts/component/section', 'breadcrumbs' );

	} // /display

}
