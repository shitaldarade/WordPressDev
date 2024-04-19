<?php
/**
 * Entry media component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Entry;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Customize\Mod;
use WebManDesign\Bjork\Content;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Media implements Component_Interface {

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

				add_action( 'wp', __CLASS__ . '::set_display' );

			// Filters

				add_filter( 'pre/bjork/entry/media/display', __CLASS__ . '::disable_single' );

				add_filter( 'bjork/entry/media/get_image_size', __CLASS__ . '::size' );

				add_filter( 'bjork/entry/media/image_featured/link_url', __CLASS__ . '::link' );

	} // /init

	/**
	 * Entry thumbnail (featured image) display size.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $image_size
	 *
	 * @return  string
	 */
	public static function size( string $image_size ): string {

		// Processing

			if ( Component::is_singular() ) {
				$image_size = 'thumbnail';
			} else {
				$image_size = 'bjork-thumbnail';
			}


		// Output

			return $image_size;

	} // /size

	/**
	 * Get entry media image size.
	 *
	 * @since  1.0.0
	 *
	 * @return  string
	 */
	public static function get_image_size(): string {

		// Output

			/**
			 * Filters post media image size.
			 *
			 * @since  1.0.0
			 *
			 * @param  string $image_size  Default: 'thumbnail'.
			 */
			return (string) apply_filters( 'bjork/entry/media/get_image_size', 'thumbnail' );

	} // /get_image_size

	/**
	 * Set entry media display.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function set_display() {

		// Processing

			if ( Component::is_singular() ) {
				add_action( 'bjork/page_header/bottom', __CLASS__ . '::display' );
			} else {
				add_action( 'tha_entry_top', __CLASS__ . '::display' );
			}

	} // /set_display

	/**
	 * Entry media display.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function display() {

		// Pre

			/**
			 * Bypass filter for WebManDesign\Bjork\Entry\Media::display().
			 *
			 * Returning a non-false value will short-circuit the method.
			 * Null is returned by the short-circuit all the time.
			 * If filtered value is string, it will be echoed before the
			 * null is returned.
			 *
			 * @since  1.0.0
			 *
			 * @param  mixed $pre  Default: false. If string, it is echoed.
			 */
			$pre = apply_filters( 'pre/bjork/entry/media/display', false );

			if ( false !== $pre ) {
				if ( is_string( $pre ) ) {
					echo $pre; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				return;
			}


		// Variables

			$output = self::image_featured( self::get_image_size() );
			$class  = ( Component::is_singular() ) ? ( 'entry-media page-media' ) : ( 'entry-media' );


		// Output

			if ( $output ) {
				echo '<div class="' . esc_attr( $class ) . '">' . $output . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

	} // /display

	/**
	 * Featured image.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  string $image_size
	 *
	 * @return  string
	 */
	public static function image_featured( string $image_size ): string {

		// Pre

			/**
			 * Bypass filter for WebManDesign\Bjork\Entry\Media::image_featured().
			 *
			 * Returning a non-false value will short-circuit the method,
			 * returning the passed value instead.
			 *
			 * @since  1.0.0
			 *
			 * @param  mixed  $pre         Default: false. If not false, method returns this value.
			 * @param  string $image_size  Image size to display.
			 */
			$pre = apply_filters( 'pre/bjork/entry/media/image_featured', false, $image_size );

			if ( false !== $pre ) {
				return $pre;
			}


		// Variables

			$output   = $attachment_image = '';
			$post_id  = get_the_ID();
			$image_id = ( is_attachment() ) ? ( $post_id ) : ( get_post_thumbnail_id( $post_id ) );


		// Processing

			if (
				has_post_thumbnail( $post_id )
				|| (
					is_attachment()
					&& $attachment_image = wp_get_attachment_image( $image_id, $image_size )
				)
			) {

				if ( Component::is_singular( $post_id ) || is_attachment() ) {
					$link_url = wp_get_attachment_image_src( $image_id, 'full' );
					$link_url = $link_url[0];
				} else {
					$link_url = get_permalink();
				}

				/**
				 * Filters featured image link URL.
				 *
				 * @since  1.0.0
				 *
				 * @param  string   $link_url  Image link URL.
				 * @param  int/null $post_id   Post ID.
				 * @param  int/null $image_id  Thumbnail ID.
				 */
				$link_url = (string) apply_filters( 'bjork/entry/media/image_featured/link_url', $link_url, $post_id, $image_id );

				$output .= '<figure class="post-thumbnail">';

					if ( ! empty( $link_url ) ) {
						$output .= '<a href="' . esc_url( $link_url ) . '">';
					}

					if ( $attachment_image ) {
						$output .= $attachment_image;
					} else {
						$output .= get_the_post_thumbnail( null, $image_size );
					}

					if ( ! empty( $link_url ) ) {
						$output .= '</a>';
					}

				$output .= '</figure>';

			}


		// Output

			return $output;

	} // /image_featured

	/**
	 * Entry thumbnail link.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  string/null $link_url
	 *
	 * @return  string
	 */
	public static function link( $link_url ): string {

		// Processing

			if ( Component::is_singular() ) {
				$link_url = '';
			}


		// Output

			return (string) $link_url;

	} // /link

	/**
	 * Disable media on single post page if needed.
	 *
	 * @since  1.0.0
	 *
	 * @param  mixed $pre
	 *
	 * @return  mixed
	 */
	public static function disable_single( $pre ) {

		// Processing

			if (
				( Component::is_singular() && ! Content\Component::show_primary_title() )
				|| ( Component::is_singular() && ! in_array( get_post_type(), (array) Mod::get( 'post_type_single_featured_image' ) ) )
				|| is_attachment()
			) {
				$pre = '';
			}


		// Output

			return $pre;

	} // /disable_single

}
