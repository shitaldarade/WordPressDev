<?php
/**
 * Loop component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Loop;

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

			// Category filter.
			Filter::init();
			// Pagination.
			Pagination::init();

			// Actions

				add_action( 'bjork/postslist/before', __CLASS__ . '::search_form' );

	} // /init

	/**
	 * Output search form on top of search results page.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function search_form() {

		// Requirements check

			if ( ! is_search() ) {
				return;
			}


		// Output

			get_search_form( true );

	} // /search_form

}
