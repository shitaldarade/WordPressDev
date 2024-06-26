<?php
/**
 * WooCommerce integration: Wrappers component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Plugin\WooCommerce;

use WebManDesign\Bjork\Component_Interface;
use WC;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Wrappers implements Component_Interface {

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

				remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
				remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

			// Actions

				add_action( 'woocommerce_before_template_part', __CLASS__ . '::template_part_wrapper' );
				add_action( 'woocommerce_after_template_part',  __CLASS__ . '::template_part_wrapper' );

				add_action( 'woocommerce_before_single_product_summary', __CLASS__ . '::product_summary', 0 );
				add_action( 'woocommerce_after_single_product_summary',  __CLASS__ . '::product_summary', 0 );

				add_action( 'woocommerce_before_shop_loop_item_title', __CLASS__ . '::product_item_thumbnail_wrapper', 7 );
				add_action( 'woocommerce_before_shop_loop_item_title', __CLASS__ . '::close_div', 13 );
				add_action( 'woocommerce_before_subcategory_title', __CLASS__ . '::product_item_thumbnail_wrapper', 9 );
				add_action( 'woocommerce_before_subcategory_title', __CLASS__ . '::close_div', 11 );

				add_action( 'woocommerce_before_shop_loop_item_title', __CLASS__ . '::product_item_description_wrapper', 90 );
				add_action( 'woocommerce_after_shop_loop_item_title', __CLASS__ . '::close_div', 90 );
				add_action( 'woocommerce_before_subcategory_title',    __CLASS__ . '::product_item_description_wrapper', 90 );
				add_action( 'woocommerce_after_subcategory_title',    __CLASS__ . '::close_div', 90 );

				add_action( 'woocommerce_before_customer_login_form', __CLASS__ . '::login_form_wrapper' );
				add_action( 'woocommerce_after_customer_login_form',  __CLASS__ . '::close_div' );

	} // /init

	/**
	 * Template wrappers.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $template_name
	 *
	 * @return  void
	 */
	public static function template_part_wrapper( string $template_name ) {

		// Output

			switch ( $template_name ) {

				case 'cart/cart-empty.php':
					if ( WC()->cart->is_empty() ) {
						if ( doing_action( 'woocommerce_before_template_part' ) ) {
							echo '<div class="cart-empty-container">';
						} else {
							echo '</div>';
						}
					}
					break;

				default:
					break;

			}

	} // /template_part_wrapper

	/**
	 * Product summary container.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  void
	 */
	public static function product_summary() {

		// Output

			if ( doing_action( 'woocommerce_before_single_product_summary' ) ) {
				echo '<div class="summary-section"><div class="summary-content">';
			} else {
				echo '</div></div><!-- /.summary-section -->';
			}

	} // /product_summary

	/**
	 * Products list item thumbnail.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function product_item_thumbnail_wrapper() {

		// Output

			echo '<div class="thumbnail">';

	} // /product_item_thumbnail_wrapper

	/**
	 * Products list item description.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function product_item_description_wrapper() {

		// Output

			echo '<div class="description">';

	} // /product_item_description_wrapper

	/**
	 * Login form wrapper.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function login_form_wrapper() {

		// Variables

			$class = 'customer-login';

			if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) {
				$class .= ' customer-registration';
			}


		// Output

			echo '<div class="' . esc_attr( $class ) . '">';

	} // /login_form_wrapper

	/**
	 * Close div.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function close_div() {

		// Output

			echo '</div>';

	} // /close_div

}
