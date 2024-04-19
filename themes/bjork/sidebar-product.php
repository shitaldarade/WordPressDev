<?php
/**
 * Widget area displayed on single WooCommerce product page.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$sidebar = 'product';

if ( ! is_active_sidebar( $sidebar ) ) {
	return;
}

?>

<div class="product-widgets-section">
	<div class="product-widgets-content">
		<?php do_action( 'tha_sidebars_before', $sidebar ); ?>

		<aside id="product-widgets" class="widget-area product-widgets" aria-label="<?php echo esc_attr_x( 'Product secondary content', 'Sidebar aria label', 'bjork' ); ?>">
			<?php

			do_action( 'tha_sidebar_top', $sidebar );
			dynamic_sidebar( $sidebar );
			do_action( 'tha_sidebar_bottom', $sidebar );

			?>
		</aside>

		<?php do_action( 'tha_sidebars_after', $sidebar ); ?>
	</div>
</div>
