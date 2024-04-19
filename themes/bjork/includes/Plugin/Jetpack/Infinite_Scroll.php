<?php
/**
 * Jetpack integration: Infinite scroll component.
 *
 * @link  https://jetpack.com/support/infinite-scroll/
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Plugin\Jetpack;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Content;
use The_Neverending_Home_Page;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Infinite_Scroll implements Component_Interface {

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

				add_filter( 'infinite_scroll_js_settings', __CLASS__ . '::js_settings' );

				add_filter( 'pre/bjork/loop/pagination/posts', __CLASS__ . '::pagination_disable' );

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

			add_theme_support( 'infinite-scroll',
				/**
				 * Filters theme support args for Jetpack Infinite Scroll.
				 *
				 * @link  https://jetpack.com/support/infinite-scroll/
				 *
				 * @since  1.0.0
				 *
				 * @param  array $args
				 */
				(array) apply_filters( 'bjork/add_theme_support/infinite-scroll', array(
					'container'      => 'posts',
					'footer'         => false,
					'posts_per_page' => 6,
					'render'         => __CLASS__ . '::render',
					'type'           => 'click',
					'wrapper'        => false,
				) )
			);

	} // /after_setup_theme

	/**
	 * Infinite scroll JS settings array modifier.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $settings
	 *
	 * @return  array
	 */
	public static function js_settings( array $settings ): array {

		// Processing

			$settings['text'] = esc_js( __( 'Load more&hellip;', 'bjork' ) );


		// Output

			return $settings;

	} // /js_settings

	/**
	 * Disable pagination.
	 *
	 * @since  1.0.0
	 *
	 * @param  mixed $pre
	 *
	 * @return  mixed  Original pre value or true.
	 */
	public static function pagination_disable( $pre ) {

		// Processing

			if ( class_exists( 'The_Neverending_Home_Page' ) ) {
				return true;
			}


		// Output

			return $pre;

	} // /pagination_disable

	/**
	 * Infinite scroll posts renderer.
	 *
	 * Passing a context parameter into filter hook for more targeted filtering.
	 *
	 * @see  self::init()
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function render() {

		// Output

			while ( have_posts() ) :
				the_post();

				/**
				 * Include the Post-Type-specific template for the content, by default.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 *
				 * Or, use the `bjork/content/get_content_type` filter hook to modify the content type.
				 * @see  WebManDesign\Bjork\Content\Component::get_content_type()
				 */
				get_template_part( 'templates/parts/content/content', Content\Component::get_content_type( 'loop/jetpack-infinite-scroll' ) );

			endwhile;

	} // /render

}
