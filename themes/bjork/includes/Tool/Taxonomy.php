<?php
/**
 * Taxonomy class.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Tool;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Taxonomy {

	/**
	 * Returns list of taxonomy term links.
	 *
	 * @since  1.0.0
	 *
	 * @param  array  $terms
	 * @param  bool   $show_parents  Whether to show parents links at the beginning.
	 * @param  string $aria_label    Navigation container ARIA label.
	 *
	 * @return  string
	 */
	public static function get_filter_nav( array $terms, bool $show_parents = false, string $aria_label = '' ): string {

		// Requirements check

			if ( empty( $terms ) && ! $show_parents ) {
				return '';
			}


		// Variables

			$output = array();

			$post_type_obj  = get_post_type_object( get_post_type() );
			$post_type_name = ( isset( $post_type_obj->labels->name ) ) ? ( $post_type_obj->labels->name ) : ( esc_html_x( 'Posts', 'Articles.', 'bjork' ) );

			if ( $aria_label ) {
				$aria_label = ' aria-label="' . esc_attr( $aria_label ) . '"';
			}


		// Processing

			if ( is_tax() && $show_parents ) {
				$output[] = '<a href="' . esc_url( get_post_type_archive_link( get_post_type() ) ) . '" class="link-back link-all">' . esc_html_x( 'All', 'All posts.', 'bjork' ) . '</a>';

				$term_object = get_queried_object();

				if ( is_taxonomy_hierarchical( $term_object->taxonomy ) ) {
					$parents = array_reverse( (array) get_ancestors( $term_object->term_id, $term_object->taxonomy, 'taxonomy' ) );

					foreach ( $parents as $term_id ) {
						$term = get_term( $term_id );
						$output[] = '<a href="' . esc_url( get_term_link( $term ) ) . '" class="link-back link-parent" title="' . esc_attr( sprintf(
							/* translators: %s: Parent taxonomy term name. */
							__( 'Back to "%s"', 'bjork' ),
							$term->name
						) ) . '">' . esc_html( $term->name ) . '</a>';
					}
				}
			}

			foreach ( $terms as $term ) {
				/**
				 * Filters content of taxonomy term link HTML title parameter.
				 *
				 * @since  1.0.0
				 *
				 * @param  string       $link_attribute_title
				 * @param  WP_Post_Type $post_type_obj
				 * @param  WP_Term      $term
				 */
				$title = (string) apply_filters( 'bjork/tool/taxonomy/get_filter_nav/link_attribute_title', sprintf(
					/* translators: %1$s: Post type name. %2$s: Taxonomy term name. */
					__( 'View all %1$s filed under "%2$s"', 'bjork' ),
					$post_type_name,
					$term->name
				), $post_type_obj, $term );

				if ( $title ) {
					$title = ' title="' . esc_attr( $title ) . '"';
				}

				$output[] = '<a href="' . esc_url( get_term_link( $term ) ) . '"' . $title . '>' . esc_html( $term->name ) . '</a>';
			}

			if ( ! empty( $output ) ) {
				$output = '<nav class="taxonomy-filter"' . $aria_label . '><ul><li>' . implode( '</li><li>', (array) $output ) . '</li></ul></nav>';
			} else {
				$output = '';
			}


		// Output

			return $output;

	} // /get_filter_nav

}
