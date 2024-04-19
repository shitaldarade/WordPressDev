<?php
/**
 * WooCommerce product more link HTML.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if (
	! is_search()
	|| is_post_type_archive( 'product' )
) {
	return;
}

?>

<div class="link-more-container">
	<a href="<?php the_permalink(); ?>" class="link-more" aria-label="<?php

		echo esc_attr( sprintf(
			/* translators: %s: Name of current product */
			__( 'View product %s', 'bjork' ),
			the_title_attribute( array( 'echo' => false ) )
		) );

	?>"><?php

	esc_html_e( 'View product&hellip;', 'bjork' );

	?></a>
</div>
