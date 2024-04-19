<?php
/**
 * Widget component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Widget;

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

			// Actions

				if ( class_exists( 'WP_Widget_Recent_Posts' ) ) {
					add_action( 'widgets_init', __NAMESPACE__ . '\Recent_Posts::register_widget' );
				}

				if ( class_exists( 'WP_Widget_Text' ) ) {
					add_action( 'widgets_init', __NAMESPACE__ . '\Text::register_widget' );
				}

			// Filters

				add_filter( 'monster-widget-config', __CLASS__ . '::monster_widget' );

	} // /init

	/**
	 * Monster widget compatibility.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $widgets
	 *
	 * @return  array
	 */
	public static function monster_widget( array $widgets ):array {

		// Processing

			foreach ( $widgets as $key => $widget ) {
				if ( isset( $widget[0] ) ) {
					if ( 'WP_Widget_Recent_Posts' === $widget[0] ) {
						$widgets[ $key ][0] = __NAMESPACE__ . '\Recent_Posts';
					} elseif ( 'WP_Widget_Text' === $widget[0] ) {
						$widgets[ $key ][0] = __NAMESPACE__ . '\Text';
					}
				}
			}


		// Output

			return $widgets;

	} // /monster_widget

}
