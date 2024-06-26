<?php
/**
 * WooCommerce integration: Loop component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.11
 */

namespace WebManDesign\Bjork\Plugin\WooCommerce;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Loop as _Loop;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Loop implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Removing

				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

				remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );

				remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );

				remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
				remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title' );

			// Actions

				add_action( 'woocommerce_before_shop_loop', __CLASS__ . '::categories', 5 );
				add_action( 'woocommerce_before_shop_loop', __CLASS__ . '::products_sorting' );
				add_action( 'woocommerce_before_shop_loop', __CLASS__ . '::active_filters',  20 );
				add_action( 'woocommerce_before_shop_loop', __CLASS__ . '::shop_loop_title', 100 );

				add_action( 'woocommerce_shop_loop_item_title', __CLASS__ . '::loop_product_title' );
				add_action( 'woocommerce_shop_loop_subcategory_title', __CLASS__ . '::loop_category_title' );

				add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 5 );

				add_action( 'woocommerce_before_subcategory_title', __CLASS__ . '::category_label', 95 );

				add_action( 'woocommerce_after_subcategory', __CLASS__ . '::category_button', 20 );

				add_action( 'woocommerce_after_shop_loop', __CLASS__ . '::active_filters', -10 );
				add_action( 'woocommerce_after_shop_loop', __CLASS__ . '::products_sorting', 5 );
				add_action( 'woocommerce_after_shop_loop', __CLASS__ . '::pagination' );

			// Filters

				add_filter( 'woocommerce_pagination_args', __CLASS__ . '::pagination_args' );

				add_filter( 'the_title', __CLASS__ . '::search_results_product_title', 10, 2 );

				add_filter( 'bjork/entry/media/get_image_size', __CLASS__ . '::product_media_size', 20 );

	} // /init

	/**
	 * Product image size in search.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $image_size
	 *
	 * @return  string
	 */
	public static function product_media_size( string $image_size ): string {

		// Processing

			if (
				is_search()
				&& 'product' === get_post_type()
			) {
				$image_size = 'woocommerce_thumbnail';
			}


		// Output

			return $image_size;

	} // /product_media_size

	/**
	 * Display list of (sub)categories.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function categories() {

		// Requirements check

			if (
				is_paged()
				|| is_filtered()
				|| is_search()
				|| ! ( is_shop() || is_tax( 'product_cat' ) )
				|| ( is_shop() && 'both' !== get_option( 'woocommerce_shop_page_display' ) )
				|| ( is_tax( 'product_cat' ) && 'both' !== get_option( 'woocommerce_category_archive_display' ) )
			) {
				return;
			}


		// Output

			get_template_part( 'templates/parts/loop/loop', 'categories-product' );

			add_filter( 'pre_option_woocommerce_shop_page_display',        '__return_empty_string' );
			add_filter( 'pre_option_woocommerce_category_archive_display', '__return_empty_string' );

	} // /categories

	/**
	 * Category description top.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function category_label() {

		// Output

			echo '<p class="category-label">' . esc_html__( 'Shop category', 'bjork' ) . '</p>';

	} // /category_label

	/**
	 * Category description bottom.
	 *
	 * @since  1.0.0
	 *
	 * @param  object|int|string $category
	 *
	 * @return  void
	 */
	public static function category_button( $category = null ) {

		// Variables

			$term_link = get_term_link( $category, 'product_cat' );


		// Requirements check

			if ( empty( $term_link ) || is_wp_error( $term_link ) ) {
				return;
			}


		// Output

			echo '<a href="' . esc_url( $term_link ) . '" class="button">' . esc_html__( 'Shop now &rarr;', 'bjork' ) . '</a>';

	} // /category_button

	/**
	 * Products sorting.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function products_sorting() {

		// Output

			echo '<div class="products-sorting">';
				woocommerce_result_count();
				woocommerce_catalog_ordering();
			echo '</div>';

	} // /products_sorting

	/**
	 * Active filters.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function active_filters() {

		// Variables

			$widget = 'WC_Widget_Layered_Nav_Filters';


		// Requirements check

			if ( ! class_exists( $widget ) ) {
				return;
			}


		// Output

			echo '<div class="products-active-filters">';
				the_widget( $widget );
			echo '</div>';

	} // /active_filters

	/**
	 * Pagination.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  void
	 */
	public static function pagination() {

		// Requirements check

			if ( ! function_exists( 'woocommerce_pagination' ) ) {
				return;
			}


		// Processing

			ob_start();
			woocommerce_pagination();

			$pagination = str_replace(
				'<nav class="woocommerce-pagination',
				'<nav aria-label="' . esc_attr__( 'Products Navigation', 'bjork' ) . '" data-current="' . esc_attr( wc_get_loop_prop( 'current_page' ) ) . '" data-total="' . esc_attr( wc_get_loop_prop( 'total_pages' ) ) . '" class="pagination woocommerce-pagination',
				ob_get_clean()
			);


		// Output

			echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	} // /pagination

	/**
	 * Pagination setup.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args
	 *
	 * @return  array
	 */
	public static function pagination_args( array $args = array() ): array {

		// Processing

			$args['type'] = 'plain';

			$args['prev_text'] =
				esc_html_x( '&laquo;', 'Pagination text (visible): previous.', 'bjork' )
				. '<span class="screen-reader-text"> '
				. esc_html_x( 'Previous page', 'Pagination text (hidden): previous.', 'bjork' )
				. '</span>';

			$args['next_text'] =
				'<span class="screen-reader-text">'
				. esc_html_x( 'Next page', 'Pagination text (hidden): next.', 'bjork' )
				. ' </span>'
				. esc_html_x( '&raquo;', 'Pagination text (visible): next.', 'bjork' );


		// Output

			return _Loop\Pagination::get_args_filtered( $args, 'woocommerce' );

	} // /pagination_args

	/**
	 * Products list title.
	 *
	 * Adding heading to non-titled lists to improve accessibility.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function shop_loop_title() {

		// Output

			echo '<h2 class="screen-reader-text">' . esc_html__( 'List of products', 'bjork' ) . '</h2>';

	} // /shop_loop_title

	/**
	 * Show the product title in the product loop.
	 *
	 * By default this is an H2. Changing it to H3.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function loop_product_title() {

		// Output

			ob_start();
			woocommerce_template_loop_product_title();

			echo str_replace( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				array( '<h2', '</h2' ),
				array( '<h3', '</h3' ),
				ob_get_clean()
			);

	} // /loop_product_title

	/**
	 * Show the subcategory title in the product loop.
	 *
	 * By default this is an H2. Changing it to H3.
	 *
	 * @since  1.0.0
	 *
	 * @param  object $category
	 *
	 * @return  void
	 */
	public static function loop_category_title( $category ) {

		// Output

			ob_start();
			woocommerce_template_loop_category_title( $category );

			echo str_replace( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				array( '<h2', '</h2' ),
				array( '<h3', '</h3' ),
				ob_get_clean()
			);

	} // /loop_category_title

	/**
	 * Price in product title in global search.
	 *
	 * @since    1.0.0
	 * @version  1.0.11
	 *
	 * @param  string   $title The post title.
	 * @param  int/null $id    The post ID.
	 *
	 * @return  string
	 */
	public static function search_results_product_title( string $title, $id = 0 ): string {

		// Requirements check

			if (
				empty( $id )
				|| ! is_search()
				|| is_post_type_archive( 'product' )
				|| 'product' !== get_post_type( $id )
			) {
				return $title;
			}


		// Variables

			$product = wc_setup_product_data( $id );


		// Output

			return $title . ' <span class="price">' . $product->get_price_html() . '</span>';

	} // /search_results_product_title

}
