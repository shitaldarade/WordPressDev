<?php
/**
 * Jetpack integration: Custom post types component.
 *
 * @link  https://jetpack.com/support/custom-content-types/
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Plugin\Jetpack;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Tool\Taxonomy;
use WebManDesign\Bjork\Entry;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Post_Types implements Component_Interface {

	/**
	 * Customizer options for testimonials.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @var     array
	 */
	public static $testimonials_mod = array();

	/**
	 * Initialization.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function init() {

		// Variables

			self::$testimonials_mod = get_theme_mod( 'jetpack_testimonials' );


		// Processing

			// Actions

				add_action( 'after_setup_theme', __CLASS__ . '::after_setup_theme' );

				add_action( 'bjork/postslist/before', __CLASS__ . '::sub_terms_filter' );
				add_action( 'bjork/postslist/before', __CLASS__ . '::portfolio_filter' );

				add_action( 'tha_entry_top', __CLASS__ . '::meta', 20 );

			// Filters

				add_filter( 'bjork/setup/post_type/get_feature', __CLASS__ . '::add_post_type', 10, 2 );

				add_filter( 'bjork/content/get_content_type',   __CLASS__ . '::testimonial_content_type', 10, 2 );
				add_filter( 'bjork/entry/media/get_image_size', __CLASS__ . '::testimonial_media_size', 20 );

				add_filter( 'jetpack_portfolio_thumbnail_size', __CLASS__ . '::portfolio_media_size' );
				add_filter( 'bjork/entry/media/get_image_size', __CLASS__ . '::portfolio_media_size', 20 );

				add_filter( 'get_the_archive_title',       __CLASS__ . '::testimonials_archive_title', 99 );
				add_filter( 'get_the_archive_description', __CLASS__ . '::testimonials_archive_description', 99 );

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

			add_theme_support( 'jetpack-portfolio' );
				add_post_type_support( 'jetpack-portfolio', array(
					'excerpt',
				) );

			add_theme_support( 'jetpack-testimonial' );

	} // /after_setup_theme

	/**
	 * Add support for Jetpack CPTs.
	 *
	 * @since  1.0.0
	 *
	 * @param  array  $post_types
	 * @param  string $feature
	 *
	 * @return  array
	 */
	public static function add_post_type( array $post_types, string $feature = '' ): array {

		// Processing

			if ( 'continue_reading' === $feature ) {
				$post_types[] = 'jetpack-portfolio';
			}

			if ( 'post_navigation' === $feature ) {
				$post_types[] = 'jetpack-portfolio';
				$post_types[] = 'jetpack-testimonial';
			}


		// Output

			return $post_types;

	} // /add_post_type

	/**
	 * Testimonials: Content type to display.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $content_type  By default this is a post type.
	 * @param  string $context
	 *
	 * @return  string
	 */
	public static function testimonial_content_type( string $content_type, string $context = '' ): string {

		// Processing

			if (
				'loop' === $context
				&& 'jetpack-testimonial' === $content_type
			) {
				$content_type = 'full';
			}


		// Output

			return $content_type;

	} // /testimonial_content_type

	/**
	 * Testimonial image size in loop.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $image_size
	 *
	 * @return  string
	 */
	public static function testimonial_media_size( string $image_size ): string {

		// Processing

			if (
				! Entry\Component::is_singular()
				&& 'jetpack-testimonial' === get_post_type()
			) {
				$image_size = 'thumbnail';
			}


		// Output

			return $image_size;

	} // /testimonial_media_size

	/**
	 * Testimonials archive: title.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $title
	 *
	 * @return  string
	 */
	public static function testimonials_archive_title( string $title ): string {

		// Processing

			if (
				is_post_type_archive( 'jetpack-testimonial' )
				&& ! empty( self::$testimonials_mod['page-title'] )
			) {
				$title = self::$testimonials_mod['page-title'];
			}


		// Output

			return $title;

	} // /testimonials_archive_title

	/**
	 * Testimonials archive: description.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $description
	 *
	 * @return  string
	 */
	public static function testimonials_archive_description( string $description ): string {

		// Processing

			if (
				is_post_type_archive( 'jetpack-testimonial' )
				&& ! empty( self::$testimonials_mod['page-content'] )
			) {
				$description = self::$testimonials_mod['page-content'];
			}


		// Output

			return $description;

	} // /testimonials_archive_description

	/**
	 * Portfolio project image size in loop.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $image_size
	 *
	 * @return  string
	 */
	public static function portfolio_media_size( string $image_size ): string {

		// Processing

			if (
				! Entry\Component::is_singular()
				&& 'jetpack-portfolio' === get_post_type()
			) {
				$image_size = 'medium';
			}


		// Output

			return $image_size;

	} // /portfolio_media_size

	/**
	 * Portfolio: Display custom taxonomy archives links.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function portfolio_filter() {

		// Requirements check

			if (
				! is_callable( 'WebManDesign\Bjork\Tool\Taxonomy::get_filter_nav' )
				|| ! is_post_type_archive( 'jetpack-portfolio' )
			) {
				return;
			}


		// Variables

			$terms = get_terms(
				/**
				 * Filters get_terms() arguments for Jetpack Portfolio post type filter links.
				 *
				 * @link  https://developer.wordpress.org/reference/functions/get_terms/
				 *
				 * @since  1.0.0
				 *
				 * @param  array $args  Array of get_terms() arguments.
				 */
				(array) apply_filters( 'bjork/plugin/jetpack/post_types/portfolio_filter/get_terms_args', array(
					'taxonomy' => 'jetpack-portfolio-type',
					'orderby'  => 'name',
					'parent'   => 0,
				) )
			);

			if ( is_wp_error( $terms ) || empty( $terms ) ) {
				return;
			}


		// Output

			echo Taxonomy::get_filter_nav( $terms ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	} // /portfolio_filter

	/**
	 * Taxonomy filter: Sub-terms links.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function sub_terms_filter() {

		// Requirements check

			if (
				! is_callable( 'WebManDesign\Bjork\Tool\Taxonomy::get_filter_nav' )
				|| ! is_tax()
				|| 'jetpack-portfolio' !== get_post_type()
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

			echo Taxonomy::get_filter_nav( $terms, true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	} // /sub_terms_filter

	/**
	 * Entry meta top.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function meta() {

		// Output

			if (
				! Entry\Component::is_singular()
				&& 'jetpack-portfolio' === get_post_type()
			) {
				the_terms(
					get_the_ID(),
					'jetpack-portfolio-type',
					'<div class="project-types"><span>' . _x( 'Types: ', 'Portfolio types.', 'bjork' ) . '</span>',
					', ',
					'</div>'
				);
			}

	} // /meta

}
