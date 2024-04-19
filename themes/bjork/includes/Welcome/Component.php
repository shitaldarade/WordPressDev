<?php
/**
 * Welcome page component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.15
 */

namespace WebManDesign\Bjork\Welcome;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Assets;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Component implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since    1.0.0
	 * @version  1.0.15
	 *
	 * @return  void
	 */
	public static function init() {

		// Requirements check

			if (
				! is_admin()
				|| ! get_theme_mod( 'admin_welcome_page', true )
			) {
				return;
			}


		// Processing

			// Actions

				add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles' );

				add_action( 'admin_menu', __CLASS__ . '::admin_menu' );

				add_action( 'load-themes.php', __CLASS__ . '::activation_notice_display' );

	} // /init

	/**
	 * Renders "Welcome" screen content.
	 *
	 * @since    1.0.0
	 * @version  1.0.15
	 *
	 * @return  void
	 */
	public static function render() {

		// Variables

			/**
			 * Filters theme "Welcome" admin page sections.
			 *
			 * @example
			 *   array(
			 *     0   => 'header',
			 *     10  => 'quickstart',
			 *     100 => 'footer',
			 *   )
			 *
			 * @since  1.0.0
			 *
			 * @param  array $sections
			 */
			$sections = (array) apply_filters( 'bjork/welcome/render/sections', array(
				0   => 'header',
				10  => 'a11y',
				15  => 'update',
				20  => 'guide',
				30  => 'demo',
				100 => 'footer',
			) );

			ksort( $sections );


		// Output

			?>

			<div class="wrap welcome__container">

				<?php

				/**
				 * Fires immediately after "Welcome" page wrapper opening tag.
				 *
				 * And before "Welcome" page sections are included.
				 *
				 * @since  1.0.0
				 */
				do_action( 'bjork/welcome/render/top' );

				foreach ( $sections as $section ) {
					get_template_part( 'templates/parts/admin/welcome', $section );
				}

				/**
				 * Fires immediately before "Welcome" page wrapper close tag.
				 *
				 * And after "Welcome" page sections are included.
				 *
				 * @since  1.0.0
				 */
				do_action( 'bjork/welcome/render/bottom' );

				?>

			</div>

			<?php

	} // /render

	/**
	 * Welcome screen CSS styles.
	 *
	 * @since  1.0.15
	 *
	 * @param  string $hook
	 *
	 * @return  void
	 */
	public static function styles( string $hook ) {

		// Requirements check

			if ( 'appearance_page_bjork-welcome' !== $hook ) {
				return;
			}


		// Processing

			Assets\Factory::style_enqueue( array(
				'handle' => 'bjork-welcome',
				'src'    => get_theme_file_uri( 'assets/css/welcome.css' ),
				'deps'   => array( 'about' ),
			) );

	} // /styles

	/**
	 * Add screen to WordPress admin menu.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function admin_menu() {

		// Processing

			add_theme_page(
				esc_html__( 'Welcome', 'bjork' ),
				esc_html__( 'Welcome', 'bjork' ),
				'edit_theme_options',
				'bjork-welcome',
				__CLASS__ . '::render'
			);

	} // /admin_menu

	/**
	 * Initiate "Welcome" admin notice after theme activation.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function activation_notice_display() {

		// Processing

			global $pagenow;

			if (
				is_admin()
				&& 'themes.php' == $pagenow
				&& isset( $_GET['activated'] )
			) {
				add_action( 'admin_notices', __CLASS__ . '::activation_notice_content', 99 );
			}

	} // /activation_notice_display

	/**
	 * Display "Welcome" admin notice after theme activation.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function activation_notice_content() {

		// Processing

			get_template_part( 'templates/parts/admin/notice', 'welcome' );

	} // /activation_notice_content

	/**
	 * Info text: Rate the theme.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  string
	 */
	public static function get_info_like(): string {

		// Output

			return
				sprintf(
					/* translators: %1$s: heart icon, %2$s: star icons. */
					esc_html__( 'If you %1$s love this theme don\'t forget to rate it %2$s.', 'bjork' ),
					'<span class="dashicons dashicons-heart" style="color: red; vertical-align: -.181em;"></span>',
					'<a href="https://themeforest.net/downloads" style="display: inline-block; color: goldenrod; vertical-align: middle;"><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span></span></a>'
				)
				. ' '
				. esc_html__( 'Thank you!', 'bjork' );

	} // /get_info_like

	/**
	 * Info text: Contact support.
	 *
	 * @since    1.0.0
	 * @version  1.0.15
	 *
	 * @return  string
	 */
	public static function get_info_support(): string {

		// Output

			return
				esc_html__( 'Have a suggestion for improvement or something is not working as it should?', 'bjork' )
				. ' <a href="https://support.webmandesign.eu/forums/forum/bjork/">'
				. esc_html__( '&rarr; Contact support', 'bjork' )
				. '</a>';

	} // /get_info_support

}
