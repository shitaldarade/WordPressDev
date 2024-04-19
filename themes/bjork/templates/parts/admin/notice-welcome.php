<?php
/**
 * Admin notice: Welcome.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WebManDesign\Bjork\Welcome\Component' ) ) {
	return;
}

$theme_name = wp_get_theme( 'bjork' )->display( 'Name' );

?>

<div class="notice notice-info is-dismissible theme-welcome-notice">

	<h2>
		<?php

		printf(
			/* translators: %s: Theme name. */
			esc_html__( 'Thank you for installing %s theme!', 'bjork' ),
			'<strong>' . $theme_name . '</strong>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);

		?>
	</h2>

	<p>
		<?php esc_html_e( 'Visit "Welcome" page for information on how to set up your website.', 'bjork' ); ?>
		<br class="linebreak">
		<?php echo Welcome\Component::get_info_like(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
	</p>

	<p class="call-to-action">
		<a href="<?php echo esc_url( admin_url( 'themes.php?page=bjork-welcome' ) ); ?>" class="button button-primary"><?php

			echo esc_html__( 'Let\'s Get Started &raquo;', 'bjork' );

		?></a>
	</p>

</div>

<style type="text/css" media="screen">

	.theme-welcome-notice {
		padding: 1.5em 1.5em 1em;
	}

	.theme-welcome-notice h2 {
		margin: 0 0 1em;
	}

	.theme-welcome-notice br:not(.linebreak) {
		display: none;
	}

	.theme-welcome-notice .dashicons {
		width: 1em;
		height: 1em;
		font-size: 1.191em;
	}

</style>
