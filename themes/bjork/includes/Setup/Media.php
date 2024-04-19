<?php
/**
 * Media setup component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Setup;

use WebManDesign\Bjork\Component_Interface;

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

				add_action( 'after_setup_theme', __CLASS__ . '::after_setup_theme' );
				add_action( 'after_setup_theme', __CLASS__ . '::add_image_size' );

				add_action( 'admin_init', __CLASS__ . '::image_sizes_notice_display' );

			// Filters

				add_filter( 'bjork/setup/media/get_image_sizes', __CLASS__ . '::set_image_sizes' );

				add_filter( 'image_size_names_choose', __CLASS__ . '::image_sizes_select' );

	} // /init

	/**
	 * After setup theme.
	 *
	 * @link  https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function after_setup_theme() {

		// Processing

			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'post-thumbnails', array(
				'attachment:audio',
				'attachment:video',
			) );

	} // /after_setup_theme

	/**
	 * Get theme image sizes setup array.
	 *
	 * @since  1.0.0
	 *
	 * @return  array
	 */
	public static function get_image_sizes(): array {

		// Variables

			/**
			 * Filters image sizes setup array.
			 *
			 * Array key stands for image registration ID.
			 * Array values consist of single image size setup array.
			 *
			 * @since  1.0.0
			 *
			 * @param  array $image_sizes
			 */
			$image_sizes = (array) apply_filters( 'bjork/setup/media/get_image_sizes', array() );


		// Processing

			$image_sizes = array_map(
				function( $args = array() ) {
					// Parsing image size setup args.
					$args = wp_parse_args( (array) $args, array(
						'name'        => '', // Human readable image size name.
						'description' => '', // Human readable image size description.
						'width'       => 100,
						'height'      => 100,
						'crop'        => false,
					) );

					if ( ! empty( $args['name'] ) ) {
						return $args;
					}
				},
				$image_sizes
			);

			$image_sizes = array_filter( $image_sizes );


		// Output

			return $image_sizes;

	} // /get_image_sizes

	/**
	 * Setting image sizes.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  array $image_sizes
	 *
	 * @return  array
	 */
	public static function set_image_sizes( array $image_sizes ): array {

		// Variables

			global $content_width;


		// Processing

			$image_sizes = array(

				'thumbnail' => array(
					'name'        => esc_html_x( 'Thumbnail size', 'WordPress predefined image size name.', 'bjork' ),
					'description' => esc_html__( 'In attachment page preview.', 'bjork' ) . ' ' . esc_html__( 'In Text widget.', 'bjork' ) . ' ' . esc_html__( 'In page intro on singular pages.', 'bjork' ) . ' ' . esc_html__( 'In list of testimonials.', 'bjork' ),
					'width'       => 480,
					'height'      => 0,
					'crop'        => false,
				),

				'medium' => array(
					'name'        => esc_html_x( 'Medium size', 'WordPress predefined image size name.', 'bjork' ),
					'description' => esc_html__( 'In image attachment page preview.', 'bjork' ) . ' ' . esc_html__( 'In list of projects.', 'bjork' ),
					'width'       => absint( get_theme_mod( 'layout_width_entry_content', 640 ) ),
					'height'      => 0,
					'crop'        => false,
				),

				'large' => array(
					'name'        => esc_html_x( 'Large size', 'WordPress predefined image size name.', 'bjork' ),
					'description' => esc_html__( 'Not used in the theme.', 'bjork' ),
					'width'       => absint( $content_width ),
					'height'      => 0,
					'crop'        => false,
				),

				'bjork-thumbnail' => array(
					'name'        => esc_html_x( 'Posts list thumbnail size', 'Theme image size name.', 'bjork' ),
					'description' => esc_html__( 'In posts list.', 'bjork' ),
					'width'       => absint( $content_width / 2 ),
					'height'      => absint( $content_width / 4 ),
					'crop'        => true,
				),

			);


		// Output

			return $image_sizes;

	} // /set_image_sizes

	/**
	 * What are default WordPress image sizes?
	 *
	 * @since  1.0.0
	 *
	 * @return  array
	 */
	public static function get_default_image_sizes(): array {

		// Output

			return array( 'thumbnail', 'medium', 'medium_large', 'large' );

	} // /get_default_image_sizes

	/**
	 * Add custom image sizes.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function add_image_size() {

		// Variables

			$image_sizes = self::get_image_sizes();
			$predefined  = self::get_default_image_sizes();


		// Processing

			foreach ( $image_sizes as $size => $args ) {
				if ( in_array( $size, $predefined ) ) {
					continue;
				}

				add_image_size(
					$size,
					$args['width'],
					$args['height'],
					$args['crop']
				);
			}

	} // /add_image_size

	/**
	 * Adding custom image sizes to image size selector.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $sizes
	 *
	 * @return  array
	 */
	public static function image_sizes_select( array $sizes ): array {

		// Variables

			$image_sizes = self::get_image_sizes();
			$predefined  = self::get_default_image_sizes();


		// Processing

			foreach ( $image_sizes as $size => $args ) {
				if ( in_array( $size, $predefined ) || ! isset( $args[3] ) ) {
					continue;
				}

				$sizes[ $size ] = esc_html( $args[3] );
			}


		// Output

			return $sizes;

	} // /image_sizes_select

	/**
	 * Register recommended image sizes notice.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function image_sizes_notice_display() {

		// Processing

			add_settings_field(
				'recommended-image-sizes',
				'',
				__CLASS__ . '::image_sizes_notice_content',
				'media',
				'default',
				array()
			);

			register_setting(
				'media',
				'recommended-image-sizes',
				'esc_attr'
			);

	} // /image_sizes_notice_display

	/**
	 * Display recommended image sizes notice.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function image_sizes_notice_content() {

		// Processing

			get_template_part( 'templates/parts/admin/media', 'image-sizes' );

	} // /image_sizes_notice_content

}
