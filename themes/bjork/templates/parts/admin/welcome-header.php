<?php
/**
 * Admin "Welcome" page content component.
 *
 * Header.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.15
 */

namespace WebManDesign\Bjork;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WebManDesign\Bjork\Welcome\Component' ) ) {
	return;
}

?>

<div class="welcome__section welcome__header">

	<h1>
		<?php echo wp_get_theme( 'bjork' )->display( 'Name' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
		<small><?php echo BJORK_THEME_VERSION; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></small>
	</h1>

	<p class="welcome__intro">
		<?php

		printf(
			/* translators: 1: theme name, 2: theme developer link. */
			esc_html__( 'Congratulations and thank you for choosing %1$s theme by %2$s!', 'bjork' ),
			'<strong>' . wp_get_theme( 'bjork' )->display( 'Name' ) . '</strong>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'<a href="' . esc_url( wp_get_theme( 'bjork' )->get( 'AuthorURI' ) ) . '"><strong>WebMan Design</strong></a>'
		);

		?>
		<?php esc_html_e( 'Information on this page introduces the theme and provides useful tips.', 'bjork' ); ?>
	</p>

	<nav class="welcome__nav">
		<ul>
			<li><a href="#welcome-a11y">Accessibility</a></li>
			<li><a href="#welcome-update">Updates</a></li>
			<li><a href="#welcome-guide">Quickstart</a></li>
			<li><a href="#welcome-demo">Demo content</a></li>
		</ul>
	</nav>

	<p>
		<a href="https://webmandesign.github.io/docs/bjork/" class="button button-hero button-primary"><?php esc_html_e( 'Documentation &rarr;', 'bjork' ); ?></a>
		<a href="https://support.webmandesign.eu/forums/forum/bjork/" class="button button-hero button-primary"><?php esc_html_e( 'Support Forum &rarr;', 'bjork' ); ?></a>
	</p>

	<p class="welcome__alert welcome__alert--tip">
		<strong class="welcome__badge"><?php echo esc_html_x( 'Tip:', 'Notice, hint.', 'bjork' ); ?></strong>
		<?php echo Welcome\Component::get_info_like(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
	</p>

</div>
