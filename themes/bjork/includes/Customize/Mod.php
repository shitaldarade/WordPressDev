<?php
/**
 * Theme mod class.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Customize;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Mod {

	/**
	 * Soft cached theme mods.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @var     mixed
	 */
	public static $mods = false;

	/**
	 * Get theme mod or fall back to default automatically.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/get_theme_mod/
	 *
	 * @since  1.0.0
	 *
	 * @param  string $name
	 * @param  array  $option_setup
	 *
	 * @return  mixed  Stored or default theme mod value of any type.
	 */
	public static function get( string $name, array $option_setup = array() ) {

		// Pre

			/**
			 * Bypass filter for WebManDesign\Bjork\Customize\Mod::get().
			 *
			 * Returning a non-null value will short-circuit the method,
			 * returning the passed value instead.
			 *
			 * @since  1.0.0
			 *
			 * @param  mixed  $pre           Default: false. If not false, method returns this value.
			 * @param  string $name          Theme mod name.
			 * @param  array  $option_setup  Optional single theme option setup array.
			 */
			$pre = apply_filters( 'pre/bjork/customize/mod/get', null, $name, $option_setup );

			if ( null !== $pre ) {
				return $pre;
			}


		// Variables

			$output = false;

			if ( false === self::$mods ) {
				// Soft cache theme mods in class property.
				self::$mods = get_theme_mods();
			}


		// Processing

			if ( isset( self::$mods[ $name ] ) ) {

				/**
				 * Theme option has been modified,
				 * so we don't need the default value.
				 */
				$output = self::$mods[ $name ];

			} else {

				/**
				 * We haven't found a modified theme option,
				 * so we need its default value.
				 */
				if ( empty( $option_setup ) ) {

					/**
					 * We don't have single theme option passed,
					 * get the default value checking all theme options.
					 */
					foreach ( Options::get() as $option ) {
						if (
							isset( $option['id'] )
							&& $name === $option['id']
							&& isset( $option['default'] )
						) {
							$output = $option['default'];
							$option_setup = $option;
							break;
						}
					}

				} else {

					/**
					 * We have single theme option passed,
					 * get the default value from it.
					 */
					if (
						isset( $option_setup['default'] )
						&& isset( $option_setup['id'] )
						&& $name === $option_setup['id']
					) {
						$output = $option_setup['default'];
					}

				}

				/**
				 * @link  https://developer.wordpress.org/reference/functions/get_theme_mod/
				 */
				if ( is_string( $output ) ) {
					// Only run the replacement if an sprintf() string format pattern was found.
					if ( preg_match( '#(?<!%)%(?:\d+\$?)?s#', $output ) ) {
						$output = sprintf(
							$output,
							get_template_directory_uri(),
							get_stylesheet_directory_uri()
						);
					}
				}

			}


		// Output

			return apply_filters( "theme_mod_{$name}", $output, $option_setup );

	} // /get

}
