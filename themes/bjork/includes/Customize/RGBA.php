<?php
/**
 * Theme options RGBA setup component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Customize;

use WebManDesign\Bjork\Component_Interface;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class RGBA implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Filters

				add_filter( 'bjork/customize/options/get', __CLASS__ . '::customize_preview', 15 );

				add_filter( 'bjork/customize/rgba/get_alphas', __CLASS__ . '::alphas' );

				add_filter( 'bjork/customize/css_variables/get_array/partial', __CLASS__ . '::css_variable', 10, 3 );

	} // /init

	/**
	 * Get alpha values (%) for CSS rgba() colors.
	 *
	 * @since  1.0.0
	 *
	 * @return  array
	 */
	public static function get_alphas(): array {

		// Output

			/**
			 * Sets an alpha value (%) for CSS rgba() color of a specific theme options.
			 *
			 * @since  1.0.0
			 *
			 * @param  array $alphas  Array of theme option id and alpha value in percent pairs.
			 */
			return (array) apply_filters( 'bjork/customize/rgba/get_alphas', array() );

	} // /get_alphas

	/**
	 * Sets alpha values (%) for CSS rgba() colors.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  array $alphas
	 *
	 * @return  array
	 */
	public static function alphas( array $alphas ): array {

		// Processing

			$alphas['color_accent_text'] =
			$alphas['color_header_text'] =
			$alphas['color_content_text'] =
			$alphas['color_footer_text'] =
			$alphas['color_site_info_text'] =
				30;


		// Output

			return (array) $alphas;

	} // /alphas

	/**
	 * Customize preview RGBA colors.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  array $options
	 *
	 * @return  array
	 */
	public static function customize_preview( array $options ): array {

		// Variables

			$alphas = self::get_alphas();


		// Processing

			foreach ( $options as $key => $option ) {
				if (
					isset( $option['css_var'] )
					&& isset( $alphas[ $option['id'] ] )
				) {
					$options[ $key ]['preview_js']['css'][':root'][] = array(
						'property'         => '--[[id]]--a' . absint( $alphas[ $option['id'] ] ),
						'prefix'           => 'rgba(',
						'suffix'           => ',' . floatval( $alphas[ $option['id'] ] / 100 ) . ')',
						'process_callback' => 'bjork.Customize.hexToRgb',
					);
				}
			}


		// Output

			return $options;

	} // /customize_preview

	/**
	 * Adding RGBA CSS variables.
	 *
	 * @since  1.0.0
	 *
	 * @param  array  $css_vars
	 * @param  array  $option
	 * @param  string $value
	 *
	 * @return  array
	 */
	public static function css_variable( array $css_vars = array(), array $option = array(), string $value = '' ): array {

		// Variables

			$alphas = self::get_alphas();


		// Processing

			if (
				isset( $option['id'] )
				&& isset( $alphas[ $option['id'] ] )
			) {
				$alphas = (array) $alphas[ $option['id'] ];
				foreach ( $alphas as $alpha ) {
					$css_vars[ '--' . sanitize_title( $option['id'] ) . '--a' . absint( $alpha ) ] = esc_attr( self::color_hex_to_rgba( (string) $value, absint( $alpha ) ) );
				}
			}


		// Output

			return (array) $css_vars;

	} // /css_variable

	/**
	 * Get rgb() or rgba() from hex color.
	 *
	 * @since  1.0.0
	 *
	 * @link  http://php.net/manual/en/function.hexdec.php
	 *
	 * @param  string $hex
	 * @param  int    $alpha  [0-100]
	 *
	 * @return  string
	 */
	public static function color_hex_to_rgba( string $hex, int $alpha = 100 ): string {

		// Variables

			$alpha  = absint( $alpha );
			$output = ( 100 === $alpha ) ? ( 'rgb(' ) : ( 'rgba(' );

			$rgb = array();

			$hex = preg_replace( '/[^0-9A-Fa-f]/', '', (string) $hex );
			$hex = substr( $hex, 0, 6 );


		// Processing

			// Converting hex color into rgb.
			$color    = (int) hexdec( $hex );
			$rgb['r'] = (int) 0xFF & ( $color >> 0x10 );
			$rgb['g'] = (int) 0xFF & ( $color >> 0x8 );
			$rgb['b'] = (int) 0xFF & $color;
			$output  .= implode( ',', $rgb );

			// Using alpha (rgba)?
			if ( 100 > $alpha ) {
				$output .= ',' . ( $alpha / 100 );
			}

			// Closing opening bracket.
			$output .= ')';


		// Output

			return (string) $output;

	} // /color_hex_to_rgba

}
