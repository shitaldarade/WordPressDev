<?php
/**
 * Theme upgrade action component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Setup;

use WebManDesign\Bjork\Component_Interface;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Upgrade implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Actions

				add_action( 'init', __CLASS__ . '::action' );

	} // /init

	/**
	 * Do action on theme version change.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function action() {

		// Variables

			$current_theme_version = get_transient( 'bjork_version' );
			$new_theme_version     = wp_get_theme( 'bjork' )->get( 'Version' );


		// Processing

			if (
				empty( $current_theme_version )
				|| $new_theme_version != $current_theme_version
			) {

				/**
				 * Fires when theme is being upgraded.
				 *
				 * @since  1.0.0
				 *
				 * @param  string $new_theme_version
				 * @param  string $current_theme_version
				 */
				do_action( 'bjork/upgrade', $new_theme_version, $current_theme_version );
				set_transient( 'bjork_version', $new_theme_version );
			}

	} // /action

}
