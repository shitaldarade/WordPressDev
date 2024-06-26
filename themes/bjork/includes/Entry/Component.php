<?php
/**
 * Entry component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.9
 */

namespace WebManDesign\Bjork\Entry;

use WebManDesign\Bjork\Component_Interface;
use WP_Post;

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

			// Post CSS class.
			Post_Class::init();
			// Entry components.
			Media::init();
			Summary::init();
			Navigation::init();
			// Page templates.
			Page_Template::init();

			// Post type support.
			add_post_type_support( 'page', 'excerpt' );
			add_post_type_support( 'attachment:audio', 'thumbnail' );
			add_post_type_support( 'attachment:video', 'thumbnail' );
			add_post_type_support( 'attachment', 'custom-fields' );

			// Actions

				add_action( 'tha_entry_top', __CLASS__ . '::header', 20 );

				add_action( 'tha_entry_bottom', __CLASS__ . '::meta' );

	} // /init

	/**
	 * Entry header.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function header() {

		// Output

			if ( self::is_singular() ) {
				get_template_part( 'templates/parts/component/entry-header-singular', get_post_type() );
			} else {
				get_template_part( 'templates/parts/component/entry-header', get_post_type() );
			}

	} // /header

	/**
	 * Entry meta top.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  void
	 */
	public static function meta() {

		// Variables

			$post_type = get_post_type( get_the_ID() );


		// Output

			if ( self::is_singular() && doing_action( 'tha_entry_bottom' ) ) {
				if ( Page_Template::is_no_intro() || Page_Template::is_content_only() ) {
					get_template_part( 'templates/parts/meta/entry-meta-top', $post_type );
					get_template_part( 'templates/parts/meta/entry-meta-bottom', $post_type );
				} else {
					get_template_part( 'templates/parts/meta/entry-meta-bottom', $post_type );
				}
			} else {
				get_template_part( 'templates/parts/meta/entry-meta-top', $post_type );
			}

	} // /meta

	/**
	 * Boolean for checking if single entry is displayed.
	 *
	 * @since    1.0.0
	 * @version  1.0.9
	 *
	 * @param  int $post_id
	 *
	 * @return  bool
	 */
	public static function is_singular( int $post_id = 0 ): bool {

		// Variables

			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}


		// Output

			return is_singular() && get_queried_object_id() === $post_id;

	} // /is_singular

	/**
	 * Boolean for checking if paged or parted.
	 *
	 * @since  1.0.0
	 *
	 * @return  bool
	 */
	public static function is_paged(): bool {

		// Variables

			global $page, $paged;

			$paginated = max( absint( $page ), absint( $paged ) );


		// Output

			return 1 < $paginated;

	} // /is_paged

	/**
	 * Returns specific entry container class.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $context  Context of the entry container class, such as "content".
	 *
	 * @return  string
	 */
	public static function get_entry_class( string $context = 'content' ): string {

		// Variables

			$output = 'entry-' . sanitize_html_class( $context );


		// Processing

			if ( self::is_singular() ) {
				$output .= ' ' . $output . '-singular';
			}


		// Output

			return $output;

	} // /get_entry_class

	/**
	 * Checks for more tag in post content.
	 *
	 * If more tag present, also retrieve its custom text value.
	 *
	 * @since  1.0.0
	 *
	 * @param  null|int|WP_Post $post
	 *
	 * @return  bool|string
	 */
	public static function has_more_tag( $post = null ) {

		// Pre

			/**
			 * Bypass filter for WebManDesign\Bjork\Entry\Component::has_more_tag().
			 *
			 * Returning a non-null value will short-circuit the method,
			 * returning the passed value instead.
			 *
			 * @since  1.0.0
			 *
			 * @param  mixed $pre  Default: null. If not null, method returns the value.
			 */
			$pre = apply_filters( 'pre/bjork/entry/has_more_tag', null, $post );

			if ( null !== $pre ) {
				return $pre;
			}


		// Variables

			$output = false;

			if ( empty( $post ) ) {
				$post = $GLOBALS['post'];
			} elseif ( is_numeric( $post ) ) {
				$post = get_post( $post );
			}


		// Requirements check

			if ( ! $post instanceof WP_Post ) {
				return;
			}


		// Processing

			if ( preg_match( '/<!--more(.*?)?-->/', $post->post_content, $matches ) ) {
				$output = true;
				if ( ! empty( $matches[1] ) ) {
					$output = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );
				}
			}


		// Output

			return $output;

	} // /has_more_tag

}
