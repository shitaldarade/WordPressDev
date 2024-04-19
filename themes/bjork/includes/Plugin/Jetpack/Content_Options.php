<?php
/**
 * Jetpack integration: Content options component.
 *
 * @link  https://jetpack.com/support/content-options/
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Plugin\Jetpack;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Entry;
use WebManDesign\Bjork\Setup;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Content_Options implements Component_Interface {

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

				add_action( 'tha_entry_bottom', __CLASS__ . '::author_bio', 20 );

			// Filters

				add_filter( 'jetpack_author_bio_avatar_size', __CLASS__ . '::author_bio_avatar_size' );

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

			$content_options = array(
				'author-bio'      => true,
				'post-details'    => array(
					'stylesheet' => 'bjork',
					'author'     => '.byline',
					'categories' => '.cat-links',
					'comment'    => '.comments-link',
					'date'       => '.posted-on',
					'tags'       => '.tags-links',
				),
			);

			add_theme_support( 'jetpack-content-options',
				/**
				 * Filters theme support args for Jetpack Content Options.
				 *
				 * @link  https://jetpack.com/support/content-options/
				 *
				 * @since  1.0.0
				 *
				 * @param  array $content_options
				 */
				(array) apply_filters( 'bjork/add_theme_support/jetpack-content-options', $content_options )
			);

	} // /after_setup_theme

	/**
	 * Display author bio.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function author_bio() {

		// Requirements check

			if (
				! function_exists( 'jetpack_author_bio' )
				|| ! Entry\Component::is_singular()
				|| post_password_required()
				// Plugin specific post type feature.
				|| ! in_array( get_post_type(), (array) Setup\Post_Type::get_feature( 'author_bio', array( 'post' ) ) )
			) {
				return;
			}


		// Output

			jetpack_author_bio();

	} // /author_bio

	/**
	 * Author bio avatar size.
	 *
	 * @since  1.0.0
	 *
	 * @return  int
	 */
	public static function author_bio_avatar_size(): int {

		// Output

			return 240;

	} // /author_bio_avatar_size

}
