<?php
/**
 * TGMPA plugin recommendations component.
 *
 * @link  http://tgmpluginactivation.com
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.13
 */

namespace WebManDesign\Bjork\Plugin;

use WebManDesign\Bjork\Component_Interface;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class TGMPA implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function init() {

		// Requirements check

			/**
			 * Whether to enable TGMPA plugin recommendations.
			 *
			 * @link  http://tgmpluginactivation.com/
			 *
			 * @since  1.0.0
			 *
			 * @param  bool $enabled  Default: is_admin().
			 */
			if ( (bool) apply_filters( 'bjork/enable_plugin_suggestions', is_admin() ) ) {
				require BJORK_PATH_VENDOR . 'tgmpa/class-tgm-plugin-activation.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			} else {
				return;
			}


		// Processing

			// Actions

				add_action( 'tgmpa_register', __CLASS__ . '::setup' );

				add_action( 'admin_notices', __CLASS__ . '::notice' );

			// Filters

				add_filter( 'tgmpa_notice_action_links', __CLASS__ . '::notification_links' );

				add_filter( 'tgmpa_table_columns', __CLASS__ . '::table_columns' );

				add_filter( 'tgmpa_table_data_item', __CLASS__ . '::table_data', 10, 2 );

	} // /init

	/**
	 * Setup recommend plugins.
	 *
	 * @link  https://github.com/thomasgriffin/TGM-Plugin-Activation/blob/master/example.php
	 *
	 * @since    1.0.0
	 * @version  1.0.13
	 *
	 * @return  void
	 */
	public static function setup() {

		// Processing

			$setup['plugins'] = array(

				'envato-market' => array(
					'name'        => 'Envato Market',
					'description' => esc_html__( 'For enabling automatic theme updates.', 'bjork' ) . ' <strong>' . esc_html__( 'This plugin is actually really recommended.', 'bjork' ) . '</strong>',
					'slug'        => 'envato-market',
					'required'    => false,
					'source'      => 'http://envato.github.io/wp-envato-market/dist/envato-market.zip',
				),

				'beaver-builder' => array(
					'name'        => 'Beaver Builder',
					'description' => esc_html__( 'Easy to use drag-and-drop page builder for creating complex page layouts.', 'bjork' ) . ' ' . esc_html__( 'Feel free to use whatever page builder you are familiar with, though.', 'bjork' ) . ' ' . esc_html__( 'The theme will handle any page builder.', 'bjork' ) . '<br><br><em>' . esc_html__( 'With full block editor compatibility you may not even need any page builder, actually :)', 'bjork' ) . '</em>',
					'slug'        => 'beaver-builder-lite-version',
					'required'    => false,
					'is_callable' => 'FLBuilder::init',
				),

				'classic-widgets' => array(
					'name'        => esc_html_x( 'Classic Widgets', 'Plugin name.', 'bjork' ),
					'description' => '<mark><strong>' . esc_html__( 'Improves widgets management screen.', 'bjork' ) . '</strong></mark><br>' . esc_html__( 'Restores the previous WordPress widgets settings screens.', 'bjork' ) . ' ' . esc_html__( 'Sidebars and widgets are not going to be used in fully block themes in the future, so if your website still uses sidebars, it is better to use this plugin to enable classic user interface.', 'bjork' ),
					'slug'        => 'classic-widgets',
					'required'    => false,
				),

				'improving-search-form-accessibility' => array(
					'name'        => 'Improving Search Form Accessibility',
					'description' => esc_html__( 'Fixes common accessibility issue with WordPress search form.', 'bjork' ),
					'slug'        => 'improving-search-form-accessibility',
					'required'    => false,
				),

				'jetpack' => array(
					'name'        => 'Jetpack',
					'description' => __( 'Adding portfolio and testimonials functionality.', 'bjork' ),
					'slug'        => 'jetpack',
					'required'    => false,
				),

				'one-click-demo-import' => array(
					'name'        => 'One Click Demo Import',
					'description' => __( 'For installing theme demo content easily.', 'bjork' ),
					'slug'        => 'one-click-demo-import',
					'required'    => false,
				),

				'woocommerce' => array(
					'name'        => 'WooCommerce',
					'description' => __( 'Adding e-commerce functionality.', 'bjork' ),
					'slug'        => 'woocommerce',
					'required'    => false,
				),

			);

			/**
			 * Filters TGMPA plugins setup array.
			 *
			 * Consist of plugins setup arrays where required keys are `name` and `slug`.
			 * If the source is NOT from the .org repository, then `source` is also required.
			 * And config setup array.
			 *
			 * @example
			 *   array(
			 *     'plugins' => array( ... ),
			 *     'config'  => array(),
			 *   )
			 *
			 * @link  https://github.com/TGMPA/TGM-Plugin-Activation/blob/master/example.php
			 *
			 * @since  1.0.0
			 *
			 * @param  array $plugins
			 */
			$setup = (array) apply_filters( 'bjork/tgmpa_plugins/setup', $setup );

			if ( isset( $setup['plugins'] ) ) {
				if ( isset( $setup['config'] ) ) {
					tgmpa( $setup['plugins'], $setup['config'] );
				} else {
					tgmpa( $setup['plugins'] );
				}
			}

	} // /setup

	/**
	 * Admin notification links.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $action_links
	 *
	 * @return  array
	 */
	public static function notification_links( array $action_links = array() ): array {

		// Processing

			$action_links[] = '<a href="https://webmandesign.github.io/docs/bjork/#plugins">' . esc_html__( 'Other useful plugins &raquo;', 'bjork' ) . '</a>';


		// Output

			return $action_links;

	} // /notification_links

	/**
	 * TGMPA plugins table: Columns.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $columns
	 *
	 * @return  array
	 */
	public static function table_columns( array $columns = array() ): array {

		// Processing

			$columns = array_merge(
				array_slice( $columns, 0, 2 ),
				array( 'description' => esc_html__( 'Description', 'bjork' ) ),
				array_slice( $columns, 2 )
			);


		// Output

			return $columns;

	} // /table_columns

	/**
	 * TGMPA plugins table: Plugin description.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  array $table_data
	 * @param  array $plugin
	 *
	 * @return  array
	 */
	public static function table_data( array $table_data = array(), array $plugin = array() ): array {

		// Processing

			$table_data['description'] = '';

			if ( isset( $plugin['description'] ) ) {
				$table_data['description'] = wp_kses( $plugin['description'], 'option_description' );
			}


		// Output

			return $table_data;

	} // /table_data

	/**
	 * Display admin notice.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function notice() {

		// Variables

			$current_screen = get_current_screen();


		// Requirements check

			if (
				! is_admin()
				|| ! isset( $current_screen->id )
				|| 'appearance_page_tgmpa-install-plugins' !== $current_screen->id
				|| isset( $_GET['plugin'] )
				|| ( isset( $_GET['plugin_status'] ) && 'all' !== $_GET['plugin_status'] )
			) {
				return;
			}


		// Output

			?>

			<div class="notice-info notice is-dismissible" style="padding: 1em 2em;">
				<h2>
					<?php echo esc_html_x( 'Recommended, not required', 'Plugins.', 'bjork' ); ?>
				</h2>
				<p>
					<?php esc_html_e( 'Please note that these are just recommended plugins, not required ones.', 'bjork' ); ?>
					<?php esc_html_e( 'Install only those plugins you will use.', 'bjork' ); ?>
					<?php echo esc_html_x( 'Or install the ones you prefer.', 'Plugins.', 'bjork' ); ?> <br>
					<?php esc_html_e( 'For example, if you are not building an eCommerce website, there is no need to install WooCommerce plugin suggested below.', 'bjork' ); ?>
				</p>
			</div>

			<?php

	} // /notice

}
