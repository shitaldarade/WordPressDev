<?php
/**
 * Google fonts component.
 *
 * Retrieves and enqueues Google Fonts.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Tool;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Assets;
use WebManDesign\Bjork\Customize\Mod;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Google_Fonts implements Component_Interface {

	/**
	 * Google Fonts stylesheet URL.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string
	 */
	private static $url = '';

	/**
	 * Array of web safe font families.
	 *
	 * List obtained from https://www.w3schools.com/cssref/css_websafe_fonts.asp
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string
	 */
	private static $web_safe_fonts = array(
		'Arial',
		'Arial Black',
		'Book Antiqua',
		'Charcoal',
		'Comic Sans MS',
		'Courier',
		'Courier New',
		'cursive',
		'Gadget',
		'Geneva',
		'Georgia',
		'Helvetica',
		'Impact',
		'Lucida Console',
		'Lucida Grande',
		'Lucida Sans Unicode',
		'Monaco',
		'monospace',
		'Palatino',
		'Palatino Linotype',
		'sans-serif',
		'serif',
		'Tahoma',
		'Times',
		'Times New Roman',
		'Trebuchet MS',
		'Verdana',
	);

	/**
	 * Suggested Google Fonts families.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 * @access   private
	 * @var      array
	 * @param    KEY   string  Font families context, such as "generic", "body", "headings".
	 * @param    VALUE array   An array of context related font family names.
	 */
	private static $suggestions = array(
		'generic' => array(
			'Abril Fatface',
			'Alegreya',
			'Alegreya Sans',
			'Anton',
			'Asap',
			'Be Vietnam',
			'Bree Serif',
			'Cabin',
			'Catamaran',
			'Cinzel Decorative',
			'Crimson Text',
			'DM Sans',
			'Domine',
			'EB Garamond',
			'Exo 2',
			'Fira Sans',
			'Fjalla One',
			'Heebo',
			'IBM Plex Sans',
			'IBM Plex Serif',
			'Josefin Sans',
			'Josefin Slab',
			'Lato',
			'Libre Baskerville',
			'Libre Franklin',
			'Literata',
			'Lora',
			'Martel',
			'Merriweather Sans',
			'Merriweather',
			'Montserrat',
			'Montserrat Alternates',
			'Montserrat Subrayada',
			'Muli',
			'Neuton',
			'Noto Sans',
			'Noto Serif',
			'Nunito',
			'Open Sans',
			'Patua One',
			'Playfair Display',
			'Poppins',
			'PT Sans Caption',
			'PT Sans',
			'PT Serif Caption',
			'PT Serif',
			'Quattrocento Sans',
			'Quattrocento',
			'Questrial',
			'Raleway',
			'Righteous',
			'Roboto Condensed',
			'Roboto Mono',
			'Roboto Slab',
			'Roboto',
			'Rubik',
			'Source Sans Pro',
			'Source Serif Pro',
			'Tajawal',
			'Teko',
			'Titillium Web',
			'Trocchi',
			'Ubuntu',
			'Vollkorn',
			'Work Sans',
			'Zilla Slab',
		),
	);

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

				add_action( 'wp_enqueue_scripts',          __CLASS__ . '::enqueue', 5 );
				add_action( 'enqueue_block_editor_assets', __CLASS__ . '::enqueue', 5 );

			// Filters

				add_filter( 'wp_resource_hints', __CLASS__ . '::resource_hints', 10, 2 );

				add_filter( 'bjork/assets/editor/setup_classic_editor/styles', __CLASS__ . '::enqueue_classic_editor' );

	} // /init

	/**
	 * Enqueue stylesheet.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function enqueue() {

		// Processing

			if ( self::get_url() ) {
				Assets\Factory::style_enqueue( array(
					'handle'   => 'bjork-google-fonts',
					'src'      => self::get_url(),
					'add_data' => array(
						'precache' => true,
					),
				) );
			}

	} // /enqueue

	/**
	 * Enqueue stylesheet into classic editor.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $styles
	 *
	 * @return  array
	 */
	public static function enqueue_classic_editor( array $styles ): array {

		// Processing

			if ( self::get_url() ) {
				$styles[-10] = str_replace( ',', '%2C', self::get_url() );
			}


		// Output

			return $styles;

	} // /enqueue_classic_editor

	/**
	 * Add preconnect for the stylesheet.
	 *
	 * @since  1.0.0
	 *
	 * @param  array  $urls           URLs to print for resource hints.
	 * @param  string $relation_type  The relation type the URLs are printed.
	 *
	 * @return  array
	 */
	public static function resource_hints( array $urls, string $relation_type ): array {

		// Processing

			if (
				'preconnect' === $relation_type
				&& wp_style_is( 'bjork-google-fonts', 'queue' )
			) {
				$urls[] = array(
					'href' => ( is_ssl() ) ? ( 'https://fonts.gstatic.com' ) : ( 'http://fonts.gstatic.com' ),
					'crossorigin',
				);
			}


		// Output

			return $urls;

	} // /resource_hints

	/**
	 * Gets stylesheet URL.
	 *
	 * @since  1.0.0
	 *
	 * @return  string
	 */
	public static function get_url(): string {

		// Processing

			if ( empty( self::$url ) ) {
				self::$url = self::set_url();
			}


		// Output

			return self::$url;

	} // /get_url

	/**
	 * Sets stylesheet URL.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  string
	 */
	public static function set_url(): string {

		// Requirements check

			if ( ! Mod::get( 'typography_google_fonts' ) ) {
				return '';
			}


		// Variables

			$url = '';

			$families = array_filter( array_unique( array(
				'headings' => (string) Mod::get( 'typography_font_headings' ),
				'body'     => (string) Mod::get( 'typography_font_global' ),
				'logo'     => (string) Mod::get( 'typography_font_site_title' ),
			) ) );


		// Processing

			if ( empty( $families ) ) {
				return '';
			}

			foreach ( $families as $context => $family ) {
				// Get the first font family only.
				if ( strpos( $family, ',' ) ) {
					$family = explode( ',', $family );
					$family = reset( $family );
				}
				$family = trim( $family, "\"' \t\n\r\0\x0B" );

				// Skip empty font family, or web safe one.
				if (
					empty( $family )
					|| false !== strpos( implode( ',', self::get_web_safe_fonts() ), $family )
				) {
					unset( $families[ $context ] );
					continue;
				}

				// Get the URL encoded family name.
				$families[ $context ] = self::get_urlencoded_family( $family, $context );
			}

			if ( ! empty( $families ) ) {
				// Set the URL base.
				$url  = ( is_ssl() ) ? ( 'https://' ) : ( 'http://' );
				$url .= 'fonts.googleapis.com/css';

				// Set the URL args/parameters.
				$query_args = array(
					'family'  => implode( '|', $families ),
					'display' => 'swap',
				);

				// Don't forget subsets if we have some.
				$subsets = (array) Mod::get( 'typography_font_language' );
				$subsets = array_diff( $subsets, array( 'latin' ) );
				if ( ! empty( $subsets ) ) {
					$query_args['subset'] = implode( ',', $subsets );
				}

				// Build the URL.
				$url = esc_url_raw( add_query_arg( $query_args, $url ) );
			}


		// Output

			return $url;

	} // /set_url

	/**
	 * Returns a font family string encoded for URL.
	 *
	 * Also applies Google Fonts font family styles.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $font_family
	 * @param  string $context
	 *
	 * @return  string
	 */
	public static function get_urlencoded_family( string $font_family, string $context = 'generic' ): string {

		// Variables

			/**
			 * Filters the Google Fonts styles.
			 *
			 * Styles are appended to font family name in Google Fonts URL.
			 * The styles are global, applied to every font family. To customize
			 * them per font family, use this filter and check the `$font_family`
			 * and/or `$context` parameter value if needed.
			 *
			 * @since  1.0.0
			 *
			 * @param  string $styles       Set to ':300,400,700' by default for better performance.
			 * @param  string $font_family
			 * @param  string $context
			 */
			$styles = (string) apply_filters( 'bjork/tool/google_fonts/styles', ':300,400,700', $font_family, $context );


		// Output

			return urldecode( $font_family . $styles );

	} // /get_urlencoded_family

	/**
	 * Returns array of suggested fonts.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $context
	 *
	 * @return  array
	 */
	public static function get_suggested_fonts( string $context = 'generic' ): array {

		// Variables

			$output = array();


		// Processing

			if ( isset( self::$suggestions[ $context ] ) ) {
				$output = self::$suggestions[ $context ];
			} elseif ( isset( self::$suggestions['generic'] ) ) {
				$output = self::$suggestions['generic'];
			}


		// Output

			return array_filter(
				/**
				 * Filters the Google Fonts suggestions array.
				 *
				 * @since  1.0.0
				 *
				 * @param  array  $suggestions
				 * @param  string $context
				 */
				(array) apply_filters( 'bjork/tool/google_fonts/suggestions', $output, $context )
			);

	} // /get_suggested_fonts

	/**
	 * Returns web safe fonts array.
	 *
	 * @since  1.0.0
	 *
	 * @return  string
	 */
	public static function get_web_safe_fonts(): array {

		// Output

			return self::$web_safe_fonts;

	} // /get_web_safe_fonts

}
