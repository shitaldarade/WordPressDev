<?php
/**
 * KSES component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.4
 */

namespace WebManDesign\Bjork\Tool;

use WebManDesign\Bjork\Component_Interface;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class KSES implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since  1.0.4
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Filters

				add_filter( 'wp_kses_allowed_html', __CLASS__ . '::tags', 10, 2 );

	} // /init

	/**
	 * HTML tags allowed specific custom theme context.
	 *
	 * You can then use `wp_kses( $html, 'context' );`
	 *
	 * @since  1.0.4
	 *
	 * @param  array  $data
	 * @param  string $context
	 *
	 * @return  array
	 */
	public static function tags( array $tags, string $context ): array {

		// Output

			switch ( $context ) {

				case 'option_description':
					return array(
						'a' => array(
							'href'   => array(),
							'class'  => array(),
							'title'  => array(),
							'target' => array(),
						),

						'br'   => array(),
						'code' => array(),
						'em'   => array(),

						'h2' => array(
							'class' => array(),
							'id'    => array(),
						),
						'h3' => array(
							'class' => array(),
							'id'    => array(),
						),
						'h4' => array(
							'class' => array(),
							'id'    => array(),
						),
						'p' => array(
							'class' => array(),
							'id'    => array(),
						),

						'span' => array(
							'class' => array(),
						),

						'strong' => array(),
					);

				default:
					return $tags;

			}

	} // /tags

}
