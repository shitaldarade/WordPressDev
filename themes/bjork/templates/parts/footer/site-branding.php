<?php
/**
 * Displays footer site branding.
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
	(bool) get_theme_support( 'custom-logo', 'unlink-homepage-logo' )
	&& is_front_page()
	&& ! is_paged()
) {
	$site_title = get_bloginfo( 'name', 'display' );
} else {
	$site_title = '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name', 'display' ) . '</a>';
}

?>

<div class="site-branding">
	<?php the_custom_logo(); ?>

	<div class="site-branding-text">
		<p class="site-title"><?php
			echo $site_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?></p>
	</div>
</div>
