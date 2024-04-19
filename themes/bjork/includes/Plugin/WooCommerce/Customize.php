<?php
/**
 * WooCommerce integration: Customize component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Plugin\WooCommerce;

use WebManDesign\Bjork\Component_Interface;
use WP_Customize_Manager;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Customize implements Component_Interface {

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

			// Actions

				add_action( 'customize_register', __CLASS__ . '::modify', 100 );

			// Filters

				add_filter( 'bjork/customize/options/get', __CLASS__ . '::options' );

	} // /init

	/**
	 * Setup partial refresh pointers.
	 *
	 * @since  1.0.4
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 *
	 * @return  void
	 */
	public static function modify( WP_Customize_Manager $wp_customize ) {

		// Processing

			// Option pointers only:

				// Sticky add to cart.
				$wp_customize->selective_refresh->add_partial( 'woocommerce_sticky_add_to_cart', array(
					'selector' => '.sticky-add-to-cart',
				) );

	} // /modify

	/**
	 * Theme options.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  array $options
	 *
	 * @return  array
	 */
	public static function options( array $options ): array {

		// Processing

			$options = array_merge( $options, array(

				970 . 'woocommerce' => array(
					'id'             => 'woocommerce',
					'type'           => 'section',
					'create_section' => esc_html_x( 'Shop', 'Customizer section title.', 'bjork' ),
					'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'bjork' ),
				),

					970 . 'woocommerce' . 100 => array(
						'type'        => 'checkbox',
						'id'          => 'woocommerce_product_block_editor',
						'label'       => esc_html__( 'Enable block editor', 'bjork' ),
						'description' => esc_html__( 'Allows you to use WordPress block editor with WooCommerce products.', 'bjork' ) . ' ' . esc_html__( '(Warning: Until block editor is not supported in WooCommerce products by default, this is still an experimental feature.)', 'bjork' ),
						'default'     => false,
						'preview_js'  => false, // This is to prevent customizer preview reload.
					),

					/**
					 * Functionality ported from Storefront theme by Automattic.
					 * @link  https://github.com/woocommerce/storefront
					 */
					970 . 'woocommerce' . 110 => array(
						'type'        => 'checkbox',
						'id'          => 'woocommerce_sticky_add_to_cart',
						'label'       => esc_html__( 'Sticky add-to-cart', 'bjork' ),
						'description' => esc_html__( 'A small content bar at the top of the browser window which includes relevant product information and an add-to-cart button. It slides into view once the standard add-to-cart button has scrolled out of view.', 'bjork' ),
						'default'     => true,
						// No need for `preview_js` here as we also need to load the scripts.
					),

			) );


		// Output

			return $options;

	} // /options

}
