<?php
/**
 * Jetpack integration: Setup component.
 *
 * @link  https://jetpack.com/support/sharing/
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Plugin\Jetpack;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Entry;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Setup implements Component_Interface {

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

				add_action( 'after_setup_theme', __CLASS__ . '::after_setup_theme' );

			// Filters

				add_filter( 'jetpack_sharing_display_markup',           __CLASS__ . '::heading_level_up', 999 );
				add_filter( 'jetpack_relatedposts_filter_headline',     __CLASS__ . '::heading_level_up', 999 );
				add_filter( 'jetpack_relatedposts_filter_post_heading', __CLASS__ . '::heading_level_up', 999 );

				add_filter( 'sharing_show', __CLASS__ . '::sharing_show', 10, 2 );

	} // /init

	/**
	 * After setup theme.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function after_setup_theme() {

		// Processing

			// Responsive videos.
			add_theme_support( 'jetpack-responsive-videos' );

	} // /after_setup_theme

	/**
	 * Show sharing?
	 *
	 * @since  1.0.0
	 *
	 * @param  bool         $show
	 * @param  null|WP_Post $post
	 *
	 * @return  bool
	 */
	public static function sharing_show( bool $show, $post = null ): bool {

		// Processing

			if (
				in_array( 'the_excerpt', (array) $GLOBALS['wp_current_filter'] )
				|| ! Entry\Component::is_singular()
				|| post_password_required()
			) {
				$show = false;
			}


		// Output

			return $show;

	} // /sharing_show

	/**
	 * Levels up HTML heading tags on singular pages.
	 *
	 * Transforms H3 to H2 and H4 to H3.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $html
	 *
	 * @return  string
	 */
	public static function heading_level_up( string $html ): string {

		// Requirements check

			if ( ! Entry\Component::is_singular() ) {
				return $html;
			}


		// Processing

			switch ( $html ) {

				case 'h3':
					$html = tag_escape( 'h2' );
					break;

				case 'h4':
					$html = tag_escape( 'h3' );
					break;

				default:
					$html = str_replace(
						array(
							'<h3', '</h3', // 1) H3...
							'<h4', '</h4', // 2) H4...
						),
						array(
							'<h2', '</h2', // 1) ...to H2
							'<h3', '</h3', // 2) ...to H3
						),
						$html
					);
					break;

			}


		// Output

			return $html;

	} // /heading_level_up

}
