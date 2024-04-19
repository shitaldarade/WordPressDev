<?php
/**
 * Blog taxonomy filter.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Loop;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Customize\Mod;
use WebManDesign\Bjork\Tool\Taxonomy;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Filter implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function init() {

		// Requirements check

			if ( ! Mod::get( 'blog_filter' ) ) {
				return;
			}


		// Processing

			// Actions

				add_action( 'bjork/postslist/before', __CLASS__ . '::sub_categories' );
				add_action( 'bjork/postslist/before', __CLASS__ . '::categories' );

	} // /init

	/**
	 * Blog categories filter.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function categories() {

		// Requirements check

			if (
				! is_callable( 'WebManDesign\Bjork\Tool\Taxonomy::get_filter_nav' )
				|| ! is_home()
			) {
				return;
			}


		// Variables

			$terms = get_terms(
				/**
				 * Filters get_terms() arguments for blog category filter links.
				 *
				 * @link  https://developer.wordpress.org/reference/functions/get_terms/
				 *
				 * @since  1.0.0
				 *
				 * @param  array $args  Array of get_terms() arguments.
				 */
				(array) apply_filters( 'bjork/loop/filter/categories/get_terms_args', array(
					'taxonomy' => 'category',
					'orderby'  => 'name',
					'parent'   => 0,
				) )
			);

			if (
				is_wp_error( $terms )
				|| empty( $terms )
				|| 1 === count( $terms )
			) {
				return;
			}


		// Output

			echo Taxonomy::get_filter_nav( $terms, false, __( 'Category filter', 'bjork' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	} // /categories

	/**
	 * Blog sub-categories filter.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function sub_categories() {

		// Requirements check

			if (
				! is_callable( 'WebManDesign\Bjork\Tool\Taxonomy::get_filter_nav' )
				|| ! is_category()
			) {
				return;
			}


		// Variables

			$parent = get_queried_object();
			$terms  = array();


		// Processing

			if ( is_taxonomy_hierarchical( $parent->taxonomy ) ) {
				$terms = get_terms( array(
					'taxonomy' => $parent->taxonomy,
					'orderby'  => 'name',
					'parent'   => $parent->term_id,
				) );

				if ( is_wp_error( $terms ) ) {
					return;
				}
			}


		// Output

			echo Taxonomy::get_filter_nav( $terms, true, __( 'Category filter', 'bjork' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	} // /sub_categories

}
