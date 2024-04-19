<?php
/**
 * WooCommerce product categories loop.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$taxonomy = 'product_cat'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$args     = array( 'parent' => 0 );

if ( is_tax( $taxonomy ) ) {
	$args['parent'] = get_queried_object_id();
}

$terms = get_terms( $taxonomy, $args );

if (
	is_wp_error( $terms )
	|| empty( $terms )
	|| ! function_exists( 'wc_get_template' )
) {
	return;
}

/**
 * Filters WooCommerce category loop columns number.
 *
 * @since  1.0.4
 *
 * @param  int $columns
 */
$columns = absint( apply_filters( 'bjork/loop_categories_product/columns', absint( wc_get_loop_prop( 'columns' ) ) ) );

?>

<h2 class="screen-reader-text"><?php esc_html_e( 'List of categories', 'bjork' ); ?></h2>

<ul class="products products-categories columns-<?php echo esc_attr( $columns ); ?>">
	<?php

	// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	foreach ( $terms as $term ) {
		wc_get_template( 'content-product_cat.php', array(
			'category' => $term,
		) );
	}

	?>
</ul>
