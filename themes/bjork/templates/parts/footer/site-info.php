<?php
/**
 * Site info / footer credits area.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$site_info_text = trim( (string) Customize\Mod::get( 'texts_site_info' ) );

if (
	'-' === $site_info_text
	&& ! is_customize_preview()
) {
	return;
}

?>

<div class="site-info-section site-footer-section">
	<div class="site-info-content site-footer-content">
		<?php

		/**
		 * Fires before actual site info container opening tag.
		 *
		 * @since  1.0.0
		 */
		do_action( 'bjork/site_info/before' );

		?>

		<div class="site-info">
			<?php
			if ( empty( $site_info_text ) ) :
				?>

				&copy; <?php echo date_i18n( 'Y' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				<span class="sep"> &bull; </span>
				<?php

				printf(
					/* translators: 1: linked CMS name (WordPress), 2: theme name. */
					esc_html__( 'Powered by %1$s and %2$s.', 'bjork' ),
					'<a rel="nofollow" href="' . esc_url( __( 'https://wordpress.org/', 'bjork' ) ) . '">WordPress</a>',
					'<a rel="nofollow" href="' . esc_url( wp_get_theme( 'bjork' )->get( 'ThemeURI' ) ) . '">' . wp_get_theme( 'bjork' )->display( 'Name' ) . '</a>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);

			else :

				/**
				 * No need to apply `wp_kses_post()` on output here as it is already validated and escaped
				 * when saving customizer option and would slow down the website rendering here.
				 */
				echo $site_info_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			endif;
			?>
		</div>

		<?php

		/**
		 * Fires after actual site info container closing tag.
		 *
		 * @since  1.0.0
		 */
		do_action( 'bjork/site_info/after' );

		?>
	</div>
</div>
