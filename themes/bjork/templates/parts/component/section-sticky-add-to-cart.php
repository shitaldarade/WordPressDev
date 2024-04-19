<?php
/**
 * WooCommerce product sticky add-to-cart section.
 *
 * Functionality ported from Storefront theme by Automattic.
 * @link  https://github.com/woocommerce/storefront
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$product = wc_get_product();
$show    = false;

if ( $product->is_purchasable() && $product->is_in_stock() ) {
	$show = true;
} elseif ( $product->is_type( 'external' ) ) {
	$show = true;
}

if ( ! $show ) {
	return;
}

/**
 * Filters setup parameters for sticky add-to-cart JavaScript.
 *
 * Parameters passed:
 * - string trigger_class  Scrolling to the element with this class triggers the section.
 *
 * @since  1.0.0
 *
 * @param  array $params
 */
$params = (array) apply_filters( 'bjork/plugin/woocommerce/setup/sticky_add_to_cart_params', array(
	'trigger_class' => 'entry-summary',
) );

Assets\Factory::script_enqueue( array(
	'handle'   => 'bjork-woocommerce-sticky-add-to-cart',
	'src'      => get_theme_file_uri( 'assets/js/woocommerce-sticky-add-to-cart.min.js' ),
	'deps'     => array( 'wc-single-product' ),
	'localize' => array(
		'$bjorkStickyAddToCartParams' => $params,
	),
) );

?>

<section class="sticky-add-to-cart">

	<?php echo $product->get_image( 'woocommerce_thumbnail' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>

	<div class="sticky-add-to-cart-info">
		<h2 class="sticky-add-to-cart-title"><?php
			printf(
				/* translators: %s: Product title. */
				esc_attr__( 'You are viewing: %s', 'bjork' ),
				'<strong>' . get_the_title() . '</strong>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		?></h2>
		<span class="sticky-add-to-cart-price price"><?php echo $product->get_price_html(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></span>
		<?php echo wc_get_rating_html( $product->get_average_rating() ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
	</div>

	<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="sticky-add-to-cart-button button"><?php
		echo $product->add_to_cart_text(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	?></a>

</section>
