<?php
/**
 * Breadcrumbs section.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if (
	/**
	 * Whether to disable Breadcrumb NavXT plugin output.
	 *
	 * @since  1.0.0
	 *
	 * @param  bool $is_disabled  Default: false.
	 */
	(bool) apply_filters( 'bjork/breadcrumbs/is_disabled', false )
	|| ! function_exists( 'bcn_display' )
) {
	return;
}

/**
 * Fires before breadcrumbs container opening tag.
 *
 * @since  1.0.0
 */
do_action( 'bjork/breadcrumbs/before' );

?>

<div class="breadcrumbs-container site-footer-section">
	<nav class="breadcrumbs site-footer-content" aria-label="<?php esc_attr_e( 'Breadcrumbs navigation', 'bjork' ); ?>">
		<?php bcn_display(); ?>
	</nav>
</div>

<?php

/**
 * Fires after breadcrumbs container closing tag.
 *
 * @since  1.0.0
 */
do_action( 'bjork/breadcrumbs/after' );
