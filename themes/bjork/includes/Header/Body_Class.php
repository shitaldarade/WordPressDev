<?php
/**
 * HTML body class component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.12
 */

namespace WebManDesign\Bjork\Header;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Customize\Mod;
use WebManDesign\Bjork\Content;
use WebManDesign\Bjork\Loop;
use WP_Post;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Body_Class implements Component_Interface {

	/**
	 * Soft cache for body classes array.
	 *
	 * @since   1.0.12
	 * @access  private
	 * @var     string
	 */
	private static $body_classes = array();

	/**
	 * Initialization.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Filters

				add_filter( 'body_class', __CLASS__ . '::body_class', 98 );

				add_filter( 'admin_body_class', __CLASS__ . '::body_class_admin' );

	} // /init

	/**
	 * HTML body classes.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  array $classes
	 *
	 * @return  array
	 */
	public static function body_class( array $classes ): array {

		// Processing

			// JS fallback.
			$classes[] = 'no-js';

			// Is mobile navigation enabled?
			if ( Mod::get( 'navigation_mobile' ) ) {
				$classes[] = 'has-navigation-mobile';
			}

			// Is site title text hidden?
			if ( 'blank' === get_header_textcolor() ) {
				$classes[] = 'is-hidden-site-title';
			}

			// Singular entry?
			if ( is_singular() ) {
				$classes[] = 'is-singular';

				// Has featured image?
				if ( has_post_thumbnail() ) {
					$classes[] = 'has-post-thumbnail';
				}
			} else {

				// Add a class of hfeed to non-singular pages.
				$classes[] = 'hfeed';
			}

			// Has more than 1 published author?
			if ( is_multi_author() ) {
				$classes[] = 'group-blog';
			}

			// Is primary title displayed?
			if ( Content\Component::show_primary_title() ) {
				$classes[] = 'has-primary-title';
			} else {
				$classes[] = 'no-primary-title';
			}

			// Sort classes alphabetically.
			asort( $classes );


		// Output

			return array_unique( $classes );

	} // /body_class

	/**
	 * HTML body classes in admin area.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $classes
	 *
	 * @return  string
	 */
	public static function body_class_admin( string $classes ): string {

		// Requirements check

			global $post;

			if (
				! is_admin()
				|| ! $post instanceof WP_Post
			) {
				return $classes;
			}


		// Processing

			$content_color = sanitize_hex_color_no_hash( Mod::get( 'color_content_background' ) );

			/**
			 * Color darkness code inspiration:
			 * @link  https://github.com/mexitek/phpColors
			 */
			if ( 6 === strlen( $content_color ) ) {
				$r = hexdec( $content_color[0] . $content_color[1] );
				$g = hexdec( $content_color[2] . $content_color[3] );
				$b = hexdec( $content_color[4] . $content_color[5] );

				$content_color_darkness = ( $r * 299 + $g * 587 + $b * 114 ) / 1000;

				if ( 130 >= $content_color_darkness ) {
					$classes .= ' is-dark-theme';
				}
			}


		// Output

			return $classes;

	} // /body_class_admin

	/**
	 * Retrieves soft cached array of body classes.
	 *
	 * @since  1.0.12
	 *
	 * @param  mixed $classes  Optional additional classes.
	 *
	 * @return  array
	 */
	public static function get_body_class( $classes = array() ): array {

		// Variables

			if ( ! is_array( $classes ) ) {
				$classes = array();
			}

			if ( empty( self::$body_classes ) ) {
				if ( ! doing_filter( 'body_class' ) ) {
					self::$body_classes = get_body_class();
				}
			}


		// Output

			if ( empty( $classes ) ) {
				return self::$body_classes;
			} else {
				return array_unique( array_merge( self::$body_classes, $classes ) );
			}

	} // /get_body_class

}
