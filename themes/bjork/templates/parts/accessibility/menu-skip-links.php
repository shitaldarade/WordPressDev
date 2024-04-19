<?php
/**
 * Skip links menu.
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

?>

<nav aria-label="<?php esc_attr_e( 'Skip links', 'bjork' ); ?>" class="menu-skip-links">
	<ul>
		<?php

		$links = array(
			'site-navigation' => __( 'Skip to main navigation', 'bjork' ),
			'content'         => __( 'Skip to main content', 'bjork' ),
			'colophon'        => __( 'Skip to footer', 'bjork' ),
		);

		if ( is_active_sidebar( 'shop' ) ) {
			$links['sidebar-shop'] = __( 'Skip to sidebar', 'bjork' );
		}

		foreach ( $links as $html_id => $text ) {
			echo Accessibility\Component::link_skip_to( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$html_id,
				$text,
				'',
				'<li>%s</li>'
			);
		}

		?>
	</ul>
</nav>
