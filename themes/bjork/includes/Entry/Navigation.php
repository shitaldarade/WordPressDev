<?php
/**
 * Entry navigation component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Entry;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Setup;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Navigation implements Component_Interface {

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

				add_action( 'tha_entry_content_after', __CLASS__ . '::parted' );

				add_action( 'tha_footer_before', __CLASS__ . '::navigation' );

	} // /init

	/**
	 * Parted post navigation.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function parted() {

		// Output

			if ( is_singular() ) {
				wp_link_pages();
			}

	} // /parted

	/**
	 * Entry navigation.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function navigation() {

		// Requirements check

			if (
				! ( is_single( get_the_ID() ) || is_attachment() )
				|| ! in_array(
					get_post_type(),
					(array) Setup\Post_Type::get_feature( 'post_navigation' )
				)
			) {
				return;
			}


		// Variables

			$post_type_labels = get_post_type_labels( get_post_type_object( get_post_type() ) );

			/**
			 * Can't really use `sprintf()` here due to translation error when
			 * translator decides not to use the `%s` in translated string.
			 */
			$args = array(

				'prev_text' => '<span class="label">' . str_replace(
					'%s',
					$post_type_labels->singular_name,
					/* translators: %s: Custom post type singular label. */
					esc_html__( 'Previous %s', 'bjork' )
				) . '</span> <span class="title">%title</span>',

				'next_text' => '<span class="label">' . str_replace(
					'%s',
					$post_type_labels->singular_name,
					/* translators: %s: Custom post type singular label. */
					esc_html__( 'Next %s', 'bjork' )
				) . '</span> <span class="title">%title</span>',

			);

			if ( is_attachment() ) {
				$args = array(
					'prev_text' => '<span class="label">' . esc_html__( 'Published in', 'bjork' ) . '</span> <span class="title">%title</span>',
				);
			}


		// Output

			echo str_replace( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				' role="navigation"',
				'',
				get_the_post_navigation(
					/**
					 * Filters get_the_post_navigation() args.
					 *
					 * @link  https://developer.wordpress.org/reference/functions/get_the_post_navigation/
					 *
					 * @since  1.0.0
					 *
					 * @param  array $args
					 */
					(array) apply_filters( 'bjork/entry/navigation/args', $args )
				)
			);

	} // /navigation

}
