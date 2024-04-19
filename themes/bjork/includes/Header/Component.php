<?php
/**
 * Header component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Header;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Customize\Mod;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Component implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// HTML body class.
			Body_Class::init();
			// HTML head.
			Head::init();
			// Containers.
			Container::init();

			// Actions

				add_action( 'wp', __CLASS__ . '::disable', 30 );

				add_action( 'tha_html_before', __CLASS__ . '::doctype' );

				add_action( 'tha_header_top', __CLASS__ . '::site_branding' );
				add_action( 'tha_header_top', __CLASS__ . '::search_form', 40 );

				add_action( 'bjork/search_form', 'get_search_form' );

			// Filters

				add_filter( 'pre/bjork/accessibility/link_skip_to', __CLASS__ . '::skip_links_no_header', 10, 2 );

	} // /init

	/**
	 * Disable theme header.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function disable() {

		// Requirements check

			if ( self::is_enabled() ) {
				return;
			}


		// Processing

			remove_all_actions( 'tha_header_before' );
			remove_all_actions( 'tha_header_top' );
			remove_all_actions( 'tha_header_bottom' );
			remove_all_actions( 'tha_header_after' );

	} // /disable

	/**
	 * Is header disabled?
	 *
	 * @since  1.0.0
	 *
	 * @return  bool
	 */
	public static function is_disabled(): bool {

		// Output

			/**
			 * Filters the header disabling.
			 *
			 * @since  1.0.0
			 *
			 * @param  bool $disabled  If true, header is not displayed. Default: false.
			 */
			return (bool) apply_filters( 'bjork/header/is_disabled', false );

	} // /is_disabled

	/**
	 * Is header enabled?
	 *
	 * @since  1.0.0
	 *
	 * @return  bool
	 */
	public static function is_enabled(): bool {

		// Output

			/**
			 * Filters the header enabling.
			 *
			 * Filtering the negated output of `Header::is_disabled()` here
			 * so we can decide to use either "disabled" or "enabled" filter depending
			 * on circumstances.
			 *
			 * @since  1.0.0
			 *
			 * @param  bool $enabled  If true, header is displayed. Default: ! Header::is_disabled().
			 */
			return (bool) apply_filters( 'bjork/header/is_enabled', ! self::is_disabled() );

	} // /is_enabled

	/**
	 * Skip links: Remove header related links.
	 *
	 * When we display no header, remove all related skip links.
	 *
	 * @since  1.0.0
	 *
	 * @param  mixed  $pre  Pre output.
	 * @param  string $id   Link target element ID.
	 *
	 * @return  mixed  Original pre value or empty string.
	 */
	public static function skip_links_no_header( $pre, string $id ) {

		// Processing

			if (
				/**
				 * Disable header related skip links?
				 *
				 * @since  1.0.0
				 *
				 * @param  bool $disable  Default: Header::is_disabled().
				 */
				(bool) apply_filters( 'bjork/skip_links_no_header', self::is_disabled() )
				&& in_array( $id, array( 'site-navigation' ) )
			) {
				$pre = '';
			}


		// Output

			return $pre;

	} // /skip_links_no_header

	/**
	 * HTML doctype.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function doctype() {

		// Output

			echo '<!DOCTYPE html>';

	} // /doctype

	/**
	 * Logo, site branding.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function site_branding() {

		// Output

			get_template_part( 'templates/parts/header/site', 'branding' );

	} // /site_branding

	/**
	 * Search form.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function search_form() {

		// Requirements check

			if ( ! in_array( 'search-form', (array) Mod::get( 'layout_header_content' ) ) ) {
				return;
			}


		// Output

			do_action( 'bjork/search_form', array( 'echo' => true ) );

	} // /search_form

}
