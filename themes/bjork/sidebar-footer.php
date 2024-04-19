<?php
/**
 * Primary widget area in site footer.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$sidebar = 'footer';

if ( ! is_active_sidebar( $sidebar ) ) {
	return;
}

?>

<div class="footer-widgets-section site-footer-section">
	<div class="footer-widgets-content site-footer-content">
		<?php do_action( 'tha_sidebars_before', $sidebar ); ?>

		<aside id="footer-widgets" class="widget-area footer-widgets" aria-label="<?php echo esc_attr_x( 'Footer content', 'Sidebar aria label', 'bjork' ); ?>">
			<?php

			do_action( 'tha_sidebar_top', $sidebar );
			dynamic_sidebar( $sidebar );
			do_action( 'tha_sidebar_bottom', $sidebar );

			?>
		</aside>

		<?php do_action( 'tha_sidebars_after', $sidebar ); ?>
	</div>
</div>
