<?php
/**
 * WooCommerce integration: Single component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork\Plugin\WooCommerce;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Customize\Mod;
use WebManDesign\Bjork\Loop;
use WP_Theme;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Single implements Component_Interface {

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

				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

				remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices' );

				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );

				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

			// Actions

				add_action( 'woocommerce_before_single_product_summary', 'woocommerce_output_all_notices', -5 );
				add_action( 'woocommerce_before_single_product_summary', 'woocommerce_breadcrumb', 5 );
				add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title' );
				add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_rating', 15 );

				add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', -5 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 5 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 30 );

				add_action( 'woocommerce_after_single_product_summary', __CLASS__ . '::upsell_products', 50 );
				add_action( 'woocommerce_after_single_product_summary', __CLASS__ . '::related_products', 100 );

				// From accessibility point of view this is right after skip links.
				add_action( 'tha_body_top', __CLASS__ . '::sticky_add_to_cart', 20 );

			// Filters

				add_filter( 'use_block_editor_for_post_type', __CLASS__ . '::use_block_editor_for_post_type', 10, 2 );

				add_filter( 'bjork/content/show_primary_title', __CLASS__ . '::show_primary_title', 20 );

				add_filter( 'template_include', __CLASS__ . '::product_page_template_load', 20 );

				add_filter( 'woocommerce_format_price_range', __CLASS__ . '::price_separator' );

				add_filter( 'woocommerce_short_description', __CLASS__ . '::read_more_link', 5 );

				add_filter( 'woocommerce_comment_pagination_args', __CLASS__ . '::comment_pagination_args' );

				add_filter( 'woocommerce_upsell_display_args',          __CLASS__ . '::products_list_args' );
				add_filter( 'woocommerce_output_related_products_args', __CLASS__ . '::products_list_args' );

				add_filter( 'theme_templates', __CLASS__ . '::page_templates', 99, 4 );

	} // /init

	/**
	 * Enable block editor for products.
	 *
	 * @since  1.0.4
	 *
	 * @param  bool   $can_edit
	 * @param  string $post_type
	 *
	 * @return  bool
	 */
	public static function use_block_editor_for_post_type( bool $can_edit, string $post_type ): bool {

		// Requirements check

			if (
				'product' !== $post_type
				|| ! Mod::get( 'woocommerce_product_block_editor' )
			) {
				return $can_edit;
			}


		// Output

			return true;

	} // /use_block_editor_for_post_type

	/**
	 * Product comments pagination setup.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args
	 *
	 * @return  array
	 */
	public static function comment_pagination_args( array $args = array() ): array {

		// Processing

			$args['prev_text'] = esc_html_x( '&laquo;', 'Pagination text (visible): previous.', 'bjork' ) . '<span class="screen-reader-text"> ' . esc_html_x( 'Previous page', 'Pagination text (hidden): previous.', 'bjork' ) . '</span>';
			$args['next_text'] = '<span class="screen-reader-text">' . esc_html_x( 'Next page', 'Pagination text (hidden): next.', 'bjork' ) . ' </span>' . esc_html_x( '&raquo;', 'Pagination text (visible): next.', 'bjork' );
			$args['type']      = 'plain';


		// Output

			return Loop\Pagination::get_args_filtered( $args, 'woocommerce-comments' );

	} // /comment_pagination_args

	/**
	 * Up-sells and related products setup.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  array $args
	 *
	 * @return  array
	 */
	public static function products_list_args( array $args ): array {

		// Processing

			$args['posts_per_page'] = $args['columns'] = absint( get_option( 'woocommerce_catalog_columns', 4 ) );


		// Output

			return $args;

	} // /products_list_args

	/**
	 * Upsell products.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function upsell_products() {

		// Output

			self::product_loop_container( 'upsells' );

	} // /upsell_products

	/**
	 * Related products.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function related_products() {

		// Output

			self::product_loop_container( 'related' );

	} // /related_products

	/**
	 * Wrapping multiple product loops in a container for additional styling.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $context
	 *
	 * @return  void
	 */
	public static function product_loop_container( string $context = 'related' ) {

		// Requirements check

			if ( ! is_product() ) {
				return;
			}


		// Variables

			$output = '';

			if ( empty( $context ) ) {
				$context = 'related';
			}


		// Processing

			ob_start();

			if ( 'upsells' === $context ) {
				woocommerce_upsell_display();
			} else {
				woocommerce_output_related_products();
			}

			$output = ob_get_clean();


		// Output

			if ( $output ) {
				echo '<aside class="products-container ' . esc_attr( $context ) . '-container">' . $output . '</aside>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

	} // /product_loop_container

	/**
	 * Fix for page template assigned onto a product.
	 *
	 * This will make sure we are actually loading the product post
	 * content, and not the content defined within the page template.
	 * Basically, we make sure the page template is used to provide
	 * HTML body class and post class, but we still want to display
	 * the actual product post content.
	 *
	 * This is also a fix for WooCommerce 3.2+ version.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $template
	 *
	 * @return  string
	 */
	public static function product_page_template_load( string $template ): string {

		// Processing

			if (
				'product' === get_post_type()
				&& is_page_template()
				&& function_exists( 'wc_locate_template' )
			) {
				$template = wc_locate_template( 'single-product.php' );
			}


		// Output

			return $template;

	} // /product_page_template_load

	/**
	 * Price "from-to" separator.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  string $html
	 *
	 * @return  string
	 */
	public static function price_separator( string $html ): string {

		// Output

			return '<span class="price-range">' . str_replace(
				array(
					'&ndash;',
					'&mdash;',
				),
				array(
					'<span class="amount-separator">&ndash;</span>',
					'<span class="amount-separator">&mdash;</span>',
				),
				$html
			) . '</span>';

	} // /price_separator

	/**
	 * Excerpt read more link.
	 *
	 * IMPORTANT:
	 * With `$excerpt == $post->post_excerpt` below we make sure
	 * we are targeting product excerpt only! This is important
	 * as `woocommerce_short_description` filter this is hooked
	 * onto, is applied on other places too. Also, due to this
	 * check we need to hook the method before `wptexturize()`
	 * is applied.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $excerpt
	 *
	 * @return  string
	 */
	public static function read_more_link( string $excerpt ): string {

		// Requirements check

			if ( ! is_product() ) {
				return $excerpt;
			}


		// Variables

			global $product, $post;


		// Processing

			if (
				$excerpt === $post->post_excerpt
				&& ( $post->post_content || $product->has_attributes() )
			) {
				$excerpt .= '<p class="product-description-link-container"><a href="#product-more-info" class="product-description-link">' . esc_html__( 'More details&hellip;', 'bjork' ) . '</a></p>';

				add_action( 'woocommerce_after_single_product_summary', function() {
					echo PHP_EOL . '<a name="product-more-info"></a>' . PHP_EOL;
				}, 9 );
			}


		// Output

			return $excerpt;

	} // /read_more_link

	/**
	 * Sticky add-to-cart.
	 *
	 * Functionality ported from Storefront theme by Automattic.
	 * @link  https://github.com/woocommerce/storefront
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function sticky_add_to_cart() {

		// Requirements check

			if (
				! Mod::get( 'woocommerce_sticky_add_to_cart' )
				|| ! is_product()
			) {
				return;
			}


		// Output

			get_template_part( 'templates/parts/component/section', 'sticky-add-to-cart' );

	} // /sticky_add_to_cart

	/**
	 * Hide theme primary title on single product page.
	 *
	 * @since  1.0.0
	 *
	 * @param  bool $show
	 *
	 * @return  bool
	 */
	public static function show_primary_title( bool $show ): bool {

		// Output

			if ( is_product() ) {
				return false;
			} else {
				return $show;
			}

	} // /show_primary_title

	/**
	 * Removing page templates for products.
	 *
	 * @since  1.0.0
	 *
	 * @param  array        $post_templates
	 * @param  WP_Theme     $wp_theme
	 * @param  WP_Post|null $post
	 * @param  string       $post_type
	 *
	 * @return  array
	 */
	public static function page_templates( array $post_templates, WP_Theme $wp_theme, $post, string $post_type ): array {

		// Processing

			if ( 'product' === $post_type ) {
				unset( $post_templates['templates/content-only.php'] );
				unset( $post_templates['templates/no-intro.php'] );
			}


		// Output

			return $post_templates;

	} // /page_templates

}
