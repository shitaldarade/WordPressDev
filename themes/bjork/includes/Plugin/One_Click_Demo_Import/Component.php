<?php
/**
 * One Click Demo Import integration component.
 *
 * @link  https://wordpress.org/plugins/one-click-demo-import/
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.13
 */

namespace WebManDesign\Bjork\Plugin\One_Click_Demo_Import;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Setup\Media;
use Jetpack;
use WooCommerce;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Component implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since    1.0.0
	 * @version  1.0.13
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Actions

				add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles', 99 );

				add_action( 'pt-ocdi/before_content_import', __CLASS__ . '::before' );
				add_action( 'pt-ocdi/before_widgets_import', __CLASS__ . '::before_widgets_import' );
				add_action( 'pt-ocdi/after_import',          __CLASS__ . '::after' );

			// Filters

				add_filter( 'pt-ocdi/import_files', __CLASS__ . '::files' );

				add_filter( 'ocdi/register_plugins', __CLASS__ . '::plugins' );

				add_filter( 'pt-ocdi/plugin_intro_text', __CLASS__ . '::info' );
				add_action( 'pt-ocdi/plugin_intro_text', __CLASS__ . '::jetpack_custom_posts' );

				add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

	} // /init

	/**
	 * Import files setup
	 *
	 * @since  1.0.0
	 *
	 * @return  array
	 */
	public static function files() {

		// Output

			return array(
				array(
					'import_file_name'       => esc_html__( 'Theme demo content', 'bjork' ),
					'import_file_url'        => 'https://raw.githubusercontent.com/webmandesign/demo-content/master/bjork/demo-content-bjork.xml',
					'import_widget_file_url' => 'https://raw.githubusercontent.com/webmandesign/demo-content/master/bjork/demo-widgets-bjork.wie',
					'preview_url'            => 'https://themedemos.webmandesign.eu/bjork/',
				),
			);

	} // /files

	/**
	 * Recommend plugins.
	 *
	 * @since  1.0.13
	 *
	 * @return  array
	 */
	public static function plugins() {

		// Output

			return array(
				array(
					'name'        => esc_html_x( 'CoBlocks', 'Plugin name.', 'bjork' ),
					'slug'        => 'coblocks',
					'required'    => false,
					'preselected' => true,
				),
				array(
					'name'        => esc_html_x( 'Jetpack', 'Plugin name.', 'bjork' ),
					'slug'        => 'jetpack',
					'required'    => false,
					'preselected' => true,
				),
				array(
					'name'        => esc_html_x( 'WooCommerce', 'Plugin name.', 'bjork' ),
					'slug'        => 'woocommerce',
					'required'    => false,
					'preselected' => true,
				),
				array(
					'name'        => esc_html_x( 'Classic Widgets', 'Plugin name.', 'bjork' ),
					'slug'        => 'classic-widgets',
					'required'    => false,
					'preselected' => true,
				),
			);

	} // /plugins

	/**
	 * Info texts.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $text  Default intro text.
	 *
	 * @return  string
	 */
	public static function info( string $text ): string {

		// Processing

			ob_start();
			get_template_part( 'templates/parts/plugin/content-ocdi', 'info' );


		// Output

			return $text . ob_get_clean();

	} // /info

	/**
	 * Before import actions.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function before() {

		// Variables

			$image_sizes = Media::get_image_sizes();


		// Processing

			// Image sizes.
			foreach ( Media::get_default_image_sizes() as $size ) {
				if ( isset( $image_sizes[ $size ] ) ) {
					update_option( $size . '_size_w', $image_sizes[ $size ]['width'] );
					update_option( $size . '_size_h', $image_sizes[ $size ]['height'] );
					update_option( $size . '_crop', $image_sizes[ $size ]['crop'] );
				}
			}

			// WooCommerce image sizes.
			self::woocommerce_image_sizes();

	} // /before

	/**
	 * After import actions.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function after() {

		// Processing

			self::front_and_blog_page();
			self::menu_locations();
			self::woocommerce_pages();

	} // /after

	/**
	 * Setup front and blog page.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function front_and_blog_page() {

		// Processing

			update_option( 'show_on_front', 'page' );

			$page = get_page_by_path( 'home-1' );
			if ( $page ) {
				update_option( 'page_on_front', $page->ID );
			}

			$page = get_page_by_path( 'blog' );
			if ( $page ) {
				update_option( 'page_for_posts', $page->ID );
			}

	} // /front_and_blog_page

	/**
	 * Setup navigation menu locations.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function menu_locations() {

		// Variables

			$menu            = array();
			$menu['primary'] = get_term_by( 'slug', 'primary', 'nav_menu' );
			$menu['social']  = get_term_by( 'slug', 'social-links', 'nav_menu' );


		// Processing

			set_theme_mod( 'nav_menu_locations', array(
				'primary' => ( isset( $menu['primary']->term_id ) ) ? ( $menu['primary']->term_id ) : ( null ),
				'social'  => ( isset( $menu['social']->term_id ) ) ? ( $menu['social']->term_id ) : ( null ),
			) );

	} // /menu_locations

	/**
	 * Remove all widgets from sidebars first.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function before_widgets_import() {

		// Processing

			delete_option( 'sidebars_widgets' );

	} // /before_widgets_import

	/**
	 * Setup WooCommerce pages.
	 *
	 * Have to use alternative page slugs in theme demo content
	 * to prevent issues with WooCommerce setup wizard created pages.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function woocommerce_pages() {

		// Requirements check

			if ( ! class_exists( 'WooCommerce' ) ) {
				return;
			}


		// Processing

			$page = get_page_by_path( 'shop' );
			if ( $page ) {
				update_option( 'woocommerce_shop_page_id', $page->ID );
			}

			$page = get_page_by_path( 'shop/cart' );
			if ( $page ) {
				update_option( 'woocommerce_cart_page_id', $page->ID );
			}

			$page = get_page_by_path( 'shop/checkout' );
			if ( $page ) {
				update_option( 'woocommerce_checkout_page_id', $page->ID );
			}

			$page = get_page_by_path( 'shop/terms-and-conditions' );
			if ( $page ) {
				update_option( 'woocommerce_terms_page_id', $page->ID );
			}

			$page = get_page_by_path( 'shop/my-account' );
			if ( $page ) {
				update_option( 'woocommerce_myaccount_page_id', $page->ID );
			}

	} // /woocommerce_pages

	/**
	 * Setup WooCommerce image sizes.
	 *
	 * Must be set before the images are imported to generate correct sizes.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function woocommerce_image_sizes() {

		// Requirements check

			if ( ! class_exists( 'WooCommerce' ) ) {
				return;
			}


		// Variables

			$single        = array( 600, 600, true );
			$thumbnail     = array( 600, 600, true );
			$gallery_thumb = array( 120, 120, true );


		// Processing

			update_option( 'woocommerce_single_image_width', $single[0] );
			add_image_size( 'woocommerce_single',
				$single[0],
				$single[1],
				$single[2]
			);

			update_option( 'woocommerce_thumbnail_image_width', $thumbnail[0] );
			add_image_size( 'woocommerce_thumbnail',
				$thumbnail[0],
				$thumbnail[1],
				$thumbnail[2]
			);

			add_image_size( 'woocommerce_gallery_thumbnail',
				$gallery_thumb[0],
				$gallery_thumb[1],
				$gallery_thumb[2]
			);

			// Cropping setup.
			if ( $thumbnail[2] ) {
				if ( $thumbnail[0] === $thumbnail[1] ) {
					update_option( 'woocommerce_thumbnail_cropping', '1:1' );
				} elseif ( function_exists( 'wc_decimal_to_fraction' ) ) {
					$ratio    = $thumbnail[0] / $thumbnail[1];
					$fraction = wc_decimal_to_fraction( $ratio );
					if ( $fraction ) {
						update_option( 'woocommerce_thumbnail_cropping', 'custom' );
						update_option( 'woocommerce_thumbnail_cropping_custom_width', $fraction[0] );
						update_option( 'woocommerce_thumbnail_cropping_custom_height', $fraction[1] );
					}
				}
			} else {
				update_option( 'woocommerce_thumbnail_cropping', 'uncropped' );
			}

	} // /woocommerce_image_sizes

	/**
	 * Enable Jetpack custom post types message.
	 *
	 * This will display the message only if the "Custom content types"
	 * module is not active already.
	 * On page reload we attempt to activate the module automatically.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $text  Default intro text.
	 *
	 * @return  string
	 */
	public static function jetpack_custom_posts( string $text ): string {

		// Requirements check

			if (
				is_callable( 'Jetpack::is_module_active' )
				&& Jetpack::is_module_active( 'custom-content-types' )
			) {
				return $text;
			}


		// Processing

			// This will activate the post types automatically, but page reload is required.
			if ( is_callable( 'Jetpack::activate_module' ) ) {
				/**
				 * Fires before a module is activated.
				 *
				 * @param  string $module    Module slug.
				 * @param  bool   $exit      Should we exit after the module has been activated. Default to true.
				 * @param  bool   $redirect  Should the user be redirected after module activation? Default to true.
				 */
				Jetpack::activate_module( 'custom-content-types', false, false );
			}

			ob_start();
			get_template_part( 'templates/parts/plugin/content-ocdi', 'jetpack-custom-posts' );


		// Output

			return $text . ob_get_clean();

	} // /jetpack_custom_posts

	/**
	 * OCDI plugin admin page styles.
	 *
	 * @since    1.0.0
	 * @version  1.0.13
	 *
	 * @return  void
	 */
	public static function styles() {

		// Processing

			wp_add_inline_style(
				'ocdi-main-css',
				'.ocdi__content-container { max-width: 1024px; }'
			);

	} // /styles

}
