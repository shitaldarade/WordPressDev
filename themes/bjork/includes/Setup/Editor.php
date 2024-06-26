<?php
/**
 * Post editor setup class.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.13
 */

namespace WebManDesign\Bjork\Setup;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Customize;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Editor implements Component_Interface {

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

	} // /init

	/**
	 * After setup theme.
	 *
	 * @since    1.0.0
	 * @version  1.0.13
	 *
	 * @return  void
	 */
	public static function after_setup_theme() {

		// Processing

			// Colors.
			add_theme_support( 'editor-color-palette', self::get_color_palette() );

			// Typography.
			add_theme_support( 'editor-font-sizes', self::get_font_sizes() );
			add_theme_support( 'custom-line-height' );

			// Alignment.
			add_theme_support( 'align-wide' );

			// Others.
			add_theme_support( 'custom-units' );
			add_theme_support( 'custom-spacing' );

			// Experimental
			/**
			 * Check `--wp--style--color--link` CSS variable.
			 * Does not work in WP 5.9 without `theme.json`,
			 * which on the other hand causes so much more issues...
			 */
			add_theme_support( 'experimental-link-color' );

	} // /after_setup_theme

	/**
	 * Get color palette setup array.
	 *
	 * Theme mod color classes:
	 * - .has-{$palette-slug}-color
	 * - .has-{$palette-slug}-background-color
	 *
	 * These should be styled in the theme stylesheet already,
	 * so no need to output any inline CSS code on front-end.
	 *
	 * @since  1.0.0
	 *
	 * @return  array
	 */
	public static function get_color_palette(): array {

		// Variables

			$palette = array();
			$colors  = $colors_unique = (array) Customize\Colors::get();


		// Processing

			$colors_unique = array_column( $colors_unique, 'color', 'id' );
			$colors_unique = array_unique( $colors_unique );
			asort( $colors_unique );

			foreach ( $colors_unique as $id => $color ) {
				$palette[] = array(
					'name'  => $colors[ $id ]['name'],
					// (Though block editor automatically changes "_" to "-", we play safe here.)
					'slug'  => str_replace( '_', '-', $colors[ $id ]['slug'] ),
					'color' => maybe_hash_hex_color( $color ),
				);
			}


		// Output

			/**
			 * Filters editor color palette setup array.
			 *
			 * @link  https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#block-color-palettes
			 *
			 * @since  1.0.0
			 *
			 * @param  array $palette
			 */
			return (array) apply_filters( 'bjork/setup/editor/get_color_palette', $palette );

	} // /get_color_palette

	/**
	 * Get font sizes setup array.
	 *
	 * These are set in `em` units within the theme stylesheet,
	 * so no need to output any inline CSS code on front-end.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  array
	 */
	public static function get_font_sizes(): array {

		// Variables

			$base_font_size = Customize\Mod::get( 'typography_size_html' );

			$sizes = array(

				array(
					'name' => _x( 'Extra Small', 'Font size.', 'bjork' ),
					'size' => round( $base_font_size * .64 ),
					'slug' => 'extra-small',
				),

				array(
					'name' => _x( 'Small', 'Font size.', 'bjork' ),
					'size' => round( $base_font_size * .8 ),
					'slug' => 'small',
				),

				array(
					'name' => _x( 'Normal', 'Font size.', 'bjork' ),
					'size' => $base_font_size,
					'slug' => 'normal', // Can not use empty value here as that would cause inline styles being applied.
				),

				array(
					'name' => _x( 'Large', 'Font size.', 'bjork' ),
					'size' => round( $base_font_size * 1.25 ),
					'slug' => 'large',
				),

				array(
					'name' => _x( 'Extra Large', 'Font size.', 'bjork' ),
					'size' => round( $base_font_size * 1.563 ),
					'slug' => 'extra-large',
				),

				array(
					'name' => _x( 'Huge', 'Font size.', 'bjork' ),
					'size' => round( $base_font_size * 3.815 ),
					'slug' => 'huge',
				),

			);


		// Output

			/**
			 * Filters editor font sizes setup array.
			 *
			 * @link  https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#block-font-sizes
			 *
			 * @since  1.0.0
			 *
			 * @param  array $sizes
			 */
			return (array) apply_filters( 'bjork/setup/editor/get_font_sizes', $sizes );

	} // /get_font_sizes

}
