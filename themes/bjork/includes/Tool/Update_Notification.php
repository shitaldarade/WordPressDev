<?php
/**
 * (Just) Theme update notification component.
 *
 * This code only enables WordPress native theme update notification but
 * it does not allow theme auto-update functionality.
 * The theme still needs to be updated manually via FTP! Or use a plugin
 * such as Envato Market for automatic theme updates in case the theme was
 * obtained from ThemeForest.net.
 *
 * Connects to remote server for most recent JSON update data once in 24 hours.
 *
 * Data are being cached in transient as they are global for the website.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.13
 */

namespace WebManDesign\Bjork\Tool;

use WebManDesign\Bjork\Component_Interface;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Update_Notification implements Component_Interface {

	/**
	 * Theme slug.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string
	 */
	private static $theme = 'bjork';

	/**
	 * Name of cached data transient.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string
	 */
	private static $transient_cache_name = 'bjork_update_data';

	/**
	 * Time until cache transient expires, in seconds. (Time To Live)
	 *
	 * @since    1.0.0
	 * @version  1.0.13
	 * @access   private
	 * @var      string
	 */
	private static $transient_cache_ttl = 3 * DAY_IN_SECONDS;

	/**
	 * URL where to check for update data.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 * @access   private
	 * @var      string
	 */
	private static $remote_url = 'https://raw.githubusercontent.com/webmandesign/updates/master/themes/versions.json';

	/**
	 * Soft cached retrieved remote data.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string
	 */
	private static $remote_data = null;

	/**
	 * Initialization.
	 *
	 * @since    1.0.0
	 * @version  1.0.13
	 *
	 * @return  void
	 */
	public static function init() {

		// Requirements check

			if ( ! current_user_can( 'update_themes' ) ) {
				return;
			}


		// Processing

			// Actions

				add_action( 'switch_theme',  __CLASS__ . '::transient_cache_flush' );
				add_action( 'bjork/upgrade', __CLASS__ . '::transient_cache_flush' );

			// Filters

				add_filter( 'site_transient_' . 'update_themes', __CLASS__ . '::set' );

	} // /init

	/**
	 * Enable theme update notification when needed.
	 *
	 * Should be hooked onto `site_transient_update_themes`.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  $data  Transient value.
	 *
	 * @return  object
	 */
	public static function set( $data ) {

		// Variables

			$current_version = self::get_update_data();


		// Processing

			if (
				isset( $data->checked[ self::$theme ] )
				&& ! empty( $current_version )
				&& version_compare( BJORK_THEME_VERSION, $current_version, '<' )
			) {

				// WordPress update data structure.
				$data->response[ self::$theme ] = array(
					'theme'       => self::$theme,
					'new_version' => esc_attr( $current_version ),
					'url'         => 'https://webmandesign.github.io/docs/bjork/#update',
					'package'     => false,
				);

				// Tell WordPress, there is a new theme update.
				set_site_transient( 'update_themes', $data );

				// Flush the transient cache.
				delete_transient( self::$transient_cache_name );

				// We don't have to run this again.
				remove_filter( current_filter(), __METHOD__ );

			}


		// Output

			return $data;

	} // /set

	/**
	 * Get remote server theme update JSON data.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  mixed  Cache transient value or array of data.
	 */
	private static function get_update_data() {

		// Variables

			// Get cached data from transient first.
			$data = get_transient( self::$transient_cache_name );


		// Processing

			if ( empty( $data ) ) {

				// This can be overrode with remote data.
				$ttl = self::$transient_cache_ttl;

				// Make sure to call remote server just once.
				if ( null === self::$remote_data ) {
					self::$remote_data = wp_remote_get( self::$remote_url );
				}

				if (
					! is_wp_error( self::$remote_data )
					&& isset( self::$remote_data['body'] )
				) {
					$data_remote = json_decode( self::$remote_data['body'], true );

					// Controlling TTL with remote data.
					if ( isset( $data_remote['ttl'] ) ) {
						$ttl = $data_remote['ttl'];
					}

					// If the theme data exist, pull them out.
					if ( isset( $data_remote[ self::$theme ] ) ) {
						$data = $data_remote[ self::$theme ];
					}
				}

				// If no data received, set a dummy one to prevent remote data check before TTL.
				if ( empty( $data ) ) {
					$data = '0.0.0';
				}

				// Cache the data in transient.
				set_transient( self::$transient_cache_name, $data, $ttl );
			}


		// Output

			return $data;

	} // /get_update_data

	/**
	 * Flush the transient of cached update data.
	 *
	 * @since  1.0.13
	 *
	 * @return  void
	 */
	public static function transient_cache_flush() {

		// Processing

			delete_transient( self::$transient_cache_name );

	} // /transient_cache_flush

}
