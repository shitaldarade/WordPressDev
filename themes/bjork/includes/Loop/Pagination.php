<?php
/**
 * Pagination component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Loop;

use WebManDesign\Bjork\Component_Interface;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Pagination implements Component_Interface {

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

				add_action( 'bjork/postslist/after', __CLASS__ . '::posts' );

			// Filters

				add_filter( 'navigation_markup_template', __CLASS__ . '::comments', 10, 2 );

	} // /init

	/**
	 * Get filtered pagination arguments.
	 *
	 * @since  1.0.0
	 *
	 * @param  array  $args
	 * @param  string $context
	 *
	 * @return  array
	 */
	public static function get_args_filtered( array $args = array(), string $context = '' ): array {

		// Output

			/**
			 * Filters theme pagination arguments.
			 *
			 * @since  1.0.0
			 *
			 * @param  array  $args     See paginate_links() function args. Default: array().
			 * @param  string $context  Optional context. Default: ''.
			 */
			return (array) apply_filters( 'bjork/loop/pagination/get_args_filtered', $args, $context );

	} // /get_args_filtered

	/**
	 * Pagination.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  void
	 */
	public static function posts() {

		// Pre

			/**
			 * Bypass filter for WebManDesign\Bjork\Loop\Pagination::posts().
			 *
			 * Returning a non-false value will short-circuit the method.
			 * Null is returned by the short-circuit all the time.
			 * If filtered value is string, it will be echoed before the
			 * null is returned.
			 *
			 * @since  1.0.0
			 *
			 * @param  mixed $pre  Default: false. If value is string, method echo the value.
			 */
			$pre = apply_filters( 'pre/bjork/loop/pagination/posts', false );

			if ( false !== $pre ) {
				if ( is_string( $pre ) ) {
					echo $pre; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				return null;
			}


		// Variables

			$args = self::get_args_filtered(
				array(
					'prev_text' =>
						esc_html_x( '&laquo;', 'Pagination text (visible): previous.', 'bjork' ) . '<span class="screen-reader-text"> '
						. esc_html_x( 'Previous page', 'Pagination text (hidden): previous.', 'bjork' ) . '</span>',
					'next_text' =>
						'<span class="screen-reader-text">' . esc_html_x( 'Next page', 'Pagination text (hidden): next.', 'bjork' )
						. ' </span>' . esc_html_x( '&raquo;', 'Pagination text (visible): next.', 'bjork' ),
				),
				'loop'
			);

			$pagination = paginate_links( $args );


		// Processing

			if ( $pagination ) {
				$total   = ( isset( $GLOBALS['wp_query']->max_num_pages ) ) ? ( $GLOBALS['wp_query']->max_num_pages ) : ( 1 );
				$current = absint( max( get_query_var( 'paged' ), 1 ) );

				$pagination =
					'<nav class="pagination" aria-label="' . esc_attr__( 'Posts navigation', 'bjork' ) . '" data-current="' . esc_attr( $current ) . '" data-total="' . esc_attr( $total ) . '">'
					. $pagination
					. '</nav>';
			}


		// Output

			echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	} // /posts

	/**
	 * Comments pagination.
	 *
	 * From simple next/previous links to full pagination.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $template  The default template.
	 * @param  string $class     The class passed by the calling function.
	 *
	 * @return  string
	 */
	public static function comments( string $template, string $class ): string {

		// Requirements check

			if ( 'comment-navigation' !== $class ) {
				return $template;
			}


		// Variables

			$args = self::get_args_filtered(
				array(
					'prev_text' =>
						esc_html_x( '&laquo;', 'Pagination text (visible): previous.', 'bjork' ) . '<span class="screen-reader-text"> '
						. esc_html_x( 'Previous page', 'Pagination text (hidden): previous.', 'bjork' ) . '</span>',
					'next_text' =>
						'<span class="screen-reader-text">' . esc_html_x( 'Next page', 'Pagination text (hidden): next.', 'bjork' )
						. ' </span>' . esc_html_x( '&raquo;', 'Pagination text (visible): next.', 'bjork' ),
				),
				'comments'
			);

			$pagination = paginate_comments_links( array_merge( $args, array( 'echo' => false ) ) );

			$total   = get_comment_pages_count();
			$current = ( get_query_var( 'cpage' ) ) ? ( absint( get_query_var( 'cpage' ) ) ) : ( 1 );


		// Processing

			// Modifying navigation wrapper classes.
			$template = str_replace(
				'<nav class="navigation',
				'<nav class="navigation pagination comment-pagination',
				$template
			);

			// Adding responsive view HTML helper attributes.
			$template = str_replace(
				'<nav',
				'<nav data-current="' . esc_attr( $current ) . '" data-total="' . esc_attr( $total ) . '"',
				$template
			);

			// Displaying pagination HTML in the template.
			$template = str_replace(
				'<div class="nav-links">%3$s</div>',
				'<div class="nav-links">' . $pagination . '</div>',
				$template
			);


		// Output

			return (string) $template;

	} // /comments

}
