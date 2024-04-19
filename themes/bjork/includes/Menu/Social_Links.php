<?php
/**
 * Social links menu component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.13
 */

namespace WebManDesign\Bjork\Menu;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Customize\Mod;
use WP_Post;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Social_Links implements Component_Interface {

	/**
	 * Contains an array of icon SVG codes.
	 *
	 * @var array
	 */
	private static $svg_icons = array();

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

				add_action( 'after_setup_theme', __CLASS__ . '::register' );

				add_action( 'tha_header_top', __CLASS__ . '::the_menu', 30 );
				add_action( 'bjork/site_info/before', __CLASS__ . '::the_menu', 20 );

				add_action( 'wp_update_nav_menu', __CLASS__ . '::cache_flush' );
				add_action( 'customize_save_after', __CLASS__ . '::cache_flush' );
				add_action( 'bjork/upgrade', __CLASS__ . '::cache_flush' );

			// Filters

				add_filter( 'walker_nav_menu_start_el', __CLASS__ . '::nav_menu_item', 10, 4 );

				add_filter( 'pre_wp_nav_menu', __CLASS__ . '::get_menu_by_name', 10, 2 );

	} // /init

	/**
	 * Register custom menus.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function register() {

		// Processing

			register_nav_menus( array(
				'social' => esc_html_x( 'Social Links', 'Navigational menu location', 'bjork' ),
			) );

	} // /register

	/**
	 * Display social links menu.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function the_menu() {

		// Requirements check

			if (
				doing_action( 'tha_header_top' )
				&& ! in_array( 'social-links', (array) Mod::get( 'layout_header_content' ) )
			) {
				return;
			}


		// Output

			get_template_part( 'templates/parts/menu/menu', 'social' );

	} // /the_menu

	/**
	 * Get social links menu HTML.
	 *
	 * @since    1.0.0
	 * @version  1.0.11
	 *
	 * @return  string
	 */
	public static function get_menu(): string {

		// Requirements check

			if ( ! has_nav_menu( 'social' ) ) {
				return '';
			}


		// Variables

			$output = wp_cache_get(
				self::get_cache_key(),
				self::get_cache_group()
			);


		// Processing

			if ( empty( $output ) || is_customize_preview() ) {
				$output = wp_nav_menu( array(
					'theme_location' => 'social',
					'container'      => false,
					'menu_class'     => 'menu-social-links',
					'depth'          => 1,
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span><!--{{icon}}-->',
					'fallback_cb'    => false,
					'echo'           => false,
					// Custom argument to prevent infinite loop.
					'stop_pre_wp_nav_menu' => true,
				) );

				$output = str_replace(
					' id=',
					' data-id=',
					$output
				);

				if ( ! is_customize_preview() ) {
					wp_cache_set(
						self::get_cache_key(),
						$output,
						self::get_cache_group(),
						7 * 24 * 60 * 60
					);
				}
			}


		// Output

			return (string) $output;

	} // /get_menu

	/**
	 * Get social links menu HTML by menu name.
	 *
	 * Useful when displaying social menu as widget, for example.
	 *
	 * @since    1.0.0
	 * @version  1.0.11
	 *
	 * @param  string|null $output  Nav menu output to short-circuit with. Default null.
	 * @param  stdClass    $args    An object containing wp_nav_menu() arguments.
	 *
	 * @return  string
	 */
	public static function get_menu_by_name( $output, $args ) {

		// Requirements check

			if (
				empty( $args->menu->term_id )
				|| isset( $args->stop_pre_wp_nav_menu )
			) {
				return $output;
			}


		// Variables

			$locations = get_nav_menu_locations();


		// Processing

			if (
				isset( $locations['social'] )
				&& $locations['social'] === $args->menu->term_id
			) {
				$output = self::get_menu();
			}


		// Output

			return $output;

	} // /get_menu_by_name

	/**
	 * Get social icon SVG.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $icon
	 *
	 * @return  string
	 */
	public static function get_icon_svg( string $icon ): string {

		// Processing

			if (
				! isset( self::$svg_icons[ $icon ] )
				&& file_exists( get_theme_file_path( '/assets/images/svg/icon-' . $icon . '.svg' ) )
			) {
				ob_start();
				require_once get_theme_file_path( '/assets/images/svg/icon-' . $icon . '.svg' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
				$svg = trim( ob_get_clean() );

				// Add extra attributes to SVG code.
				$replace = '<svg class="svg-icon" width="1.5em" aria-hidden="true" role="img" focusable="false" ';
				$svg = preg_replace( '/^<svg /', $replace, $svg );
				// Remove newlines & tabs.
				$svg = preg_replace( "/([\n\t]+)/", ' ', $svg );
				// Remove white space between tags.
				$svg = preg_replace( '/>\s*</', '><', $svg );

				// Soft cache the SVG code.
				self::$svg_icons[ $icon ] = $svg;
			}


		// Output

			return self::$svg_icons[ $icon ];

	} // /get_icon_svg

	/**
	 * Get social icons domain mappings array.
	 *
	 * @since    1.0.0
	 * @version  1.0.13
	 *
	 * @return  array
	 */
	public static function get_icon_map(): array {

		// Output

			return array(
				'/feed'          => 'feed',
				'500px.com'      => '500px',
				'amazon.'        => 'amazon',
				'apple.'         => 'apple',
				'bandcamp.'      => 'bandcamp',
				'behance.'       => 'behance',
				'bitbucket.'     => 'bitbucket',
				'codepen.'       => 'codepen',
				'deviantart.'    => 'deviantart',
				'digg.'          => 'digg',
				'dribbble.'      => 'dribbble',
				'dropbox.'       => 'dropbox',
				'facebook.'      => 'facebook',
				'fb.'            => 'facebook',
				'flickr.com'     => 'flickr',
				'foursquare.'    => 'foursquare',
				'getpocket.'     => 'pocket',
				'github.'        => 'github',
				'goodreads.'     => 'goodreads',
				'google.'        => 'google',
				'instagram.'     => 'instagram',
				'itunes.'        => 'apple',
				'lastfm.'        => 'lastfm',
				'linkedin.'      => 'linkedin',
				'mailto:'        => 'mail',
				'medium.'        => 'medium',
				'meetup.'        => 'meetup',
				'paypal.'        => 'paypal',
				'pinterest.'     => 'pinterest',
				'reddit.'        => 'reddit',
				'skype.'         => 'skype',
				'skype:'         => 'skype',
				'slack.'         => 'slack',
				'slideshare.'    => 'slideshare',
				'snapchat.'      => 'snapchat',
				'soundcloud.'    => 'soundcloud',
				'spotify.'       => 'spotify',
				'stackoverflow.' => 'stack-overflow',
				'stumbleupon.'   => 'stumbleupon',
				'tel:'           => 'phone',
				'tiktok.'        => 'tiktok',
				'themeforest.'   => 'envato',
				'trello.'        => 'trello',
				'tripadvisor.'   => 'tripadvisor',
				'tumblr.'        => 'tumblr',
				'twitch.'        => 'twitch',
				'twitter.'       => 'twitter',
				'vimeo.'         => 'vimeo',
				'vine.'          => 'vine',
				'vk.'            => 'vk',
				'wa.me'          => 'whatsapp',
				'webmandesign.'  => 'webmandesign',
				'wordpress.'     => 'wordpress',
				'xing.'          => 'xing',
				'yelp.'          => 'yelp',
				'youtu.be'       => 'youtube',
				'youtube.'       => 'youtube',
			);

	} // /get_icon_map

	/**
	 * Display SVG icons in social links menu.
	 *
	 * Note that the menu has to be set to output `<!--{{icon}}-->` placeholders!
	 *
	 * @since    1.0.0
	 * @version  1.0.8
	 *
	 * @param  string  $item_output The menu item output.
	 * @param  WP_Post $item        Menu item object.
	 * @param  int     $depth       Depth of the menu.
	 * @param  object  $args        An object of wp_nav_menu() arguments.
	 *
	 * @return  string
	 */
	public static function nav_menu_item( string $item_output, $item, int $depth, $args ): string {

		// Requirements check

			if (
				! $item instanceof WP_Post
				|| false === strpos( $item_output, '<!--{{icon}}-->' )
			) {
				return $item_output;
			}


		// Variables

			$icon = 'chain';


		// Processing

			foreach ( self::get_icon_map() as $url => $svg_icon ) {
				if ( false !== strpos( $item_output, $url ) ) {
					$icon = $svg_icon;
					break;
				}
			}


		// Output

			return str_replace(
				'<!--{{icon}}-->',
				'<!--{{icon}}-->' . self::get_icon_svg( $icon ),
				$item_output
			);

	} // /nav_menu_item

	/**
	 * Flush social menu cache.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function cache_flush() {

		// Processing

			wp_cache_delete(
				self::get_cache_key(),
				self::get_cache_group()
			);

	} // /cache_flush

	/**
	 * Get social menu cache key.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function get_cache_key() {

		// Processing

			return 'bjork_cache_social_links';

	} // /get_cache_key

	/**
	 * Get social menu cache group.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function get_cache_group() {

		// Processing

			return 'bjork_' . get_bloginfo( 'language' );

	} // /get_cache_group

}
