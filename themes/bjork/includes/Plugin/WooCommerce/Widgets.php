<?php
/**
 * WooCommerce integration: Widgets component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Plugin\WooCommerce;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Sidebar;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Widgets implements Component_Interface {

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

			// Removing

				remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );

			// Actions

				add_action( 'woocommerce_widget_product_item_start', __CLASS__ . '::setup_widget_product_html_modifications' );
				add_action( 'woocommerce_widget_product_item_end',   __CLASS__ . '::setup_widget_product_html_modifications' );

				add_action( 'widgets_init', __CLASS__ . '::register_widget_areas', 1 );

				add_action( 'tha_content_bottom', __CLASS__ . '::sidebar_shop', 85 );

				add_action( 'woocommerce_after_single_product_summary', __CLASS__ . '::sidebar_product', 40 );

			// Filters

				add_filter( 'body_class', __CLASS__ . '::body_class' );

				add_filter( 'get_product_search_form', __CLASS__ . '::product_search_form' );

				if ( is_callable( 'WebManDesign\Bjork\Sidebar\Component::widget_tag_cloud_args' ) ) {
					add_filter( 'woocommerce_product_tag_cloud_widget_args', 'WebManDesign\Bjork\Sidebar\Component::widget_tag_cloud_args' );
				}

	} // /init

	/**
	 * Product widget area: registration.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function register_widget_areas() {

		// Processing

			register_sidebar(
				array(
					'id'   => 'shop',
					'name' => esc_html__( 'Shop Sidebar', 'bjork' ),
				)
				+ Sidebar\Component::get_sidebar_args( 'shop' )
			);

			register_sidebar(
				array(
					'id'          => 'product',
					'name'        => esc_html__( 'Product', 'bjork' ),
					'description' => esc_html__( 'This widget area is displayed on single product page, just above the related products list.', 'bjork' ),
				)
				+ Sidebar\Component::get_sidebar_args( 'product' )
			);

	} // /register_widget_areas

	/**
	 * Product widgets area: display.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function sidebar_product() {

		// Output

			get_sidebar( 'product' );

	} // /sidebar_product

	/**
	 * Shop sidebar: display.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function sidebar_shop() {

		// Output

			if ( is_shop() || is_product_taxonomy() ) {
				get_sidebar( 'shop' );
			}

	} // /sidebar_shop

	/**
	 * Fixing search field ID for multiple display.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $html
	 *
	 * @return  string
	 */
	public static function product_search_form( string $html ): string {

		// Output

			return str_replace( 'woocommerce-product-search-field', 'woocommerce-product-search-field-' . esc_attr( uniqid() ), $html );

	} // /product_search_form

	/**
	 * Setup Product widget output HTML.
	 *
	 * @since  1.0.4
	 *
	 * @return  void
	 */
	public static function setup_widget_product_html_modifications() {

		// Processing

			if ( doing_action( 'woocommerce_widget_product_item_start' ) ) {
				add_filter( 'woocommerce_product_get_rating_html', __CLASS__ . '::append_line_break' );
			} else {
				remove_filter( 'woocommerce_product_get_rating_html', __CLASS__ . '::append_line_break' );
			}

	} // /setup_widget_product_html_modifications

	/**
	 * Appends `<br>` to HTML string.
	 *
	 * @since  1.0.4
	 *
	 * @param  string $html
	 *
	 * @return  string
	 */
	public static function append_line_break( string $html ): string {

		// Processing

			if ( ! empty( $html ) ) {
				$html .= '<br>';
			}


		// Output

			return $html;

	} // /append_line_break

	/**
	 * Active sidebar HTML body class.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $classes
	 *
	 * @return  array
	 */
	public static function body_class( array $classes ): array {

		// Variables

			$sidebar = 'shop';


		// Processing

			if ( is_shop() || is_product_taxonomy() ) {
				if ( is_active_sidebar( $sidebar ) ) {
					$classes[] = 'has-widgets-in-' . $sidebar;
				} else {
					$classes[] = 'no-widgets-in-' . $sidebar;
				}
			}


		// Output

			return $classes;

	} // /body_class

}
