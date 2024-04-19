<?php
/**
 * Widget area displayed on shop page and product archives.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$sidebar = 'shop';

if ( ! is_active_sidebar( $sidebar ) ) {
	return;
}

do_action( 'tha_sidebars_before', $sidebar );

?>

<aside id="sidebar-shop" class="widget-area sidebar-shop" aria-label="<?php echo esc_attr_x( 'Shop sidebar', 'Sidebar aria label', 'bjork' ); ?>">
	<?php

	do_action( 'tha_sidebar_top', $sidebar );
	dynamic_sidebar( $sidebar );
	do_action( 'tha_sidebar_bottom', $sidebar );

	?>
</aside>

<?php

do_action( 'tha_sidebars_after', $sidebar );
