<?php
/**
 * Entry header for singular views.
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

if ( ! Content\Component::show_primary_title() ) {
	return;
}

$paged_info = Content\Component::get_paged_info();

?>

<header class="entry-header page-header">
	<div class="page-header-content">
		<?php do_action( 'bjork/page_header/top' ); ?>
		<div class="entry-header-text page-header-text">
			<h1 class="entry-title page-title"><?php
				the_title();
				echo $paged_info; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?></h1>
			<?php

			get_template_part( 'templates/parts/meta/entry-meta-page-header', get_post_type( get_the_ID() ) );

			if (
				empty( $paged_info )
				&& has_excerpt()
				&& ! Entry\Component::is_paged()
			) {
				echo str_replace( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'entry-summary',
					'entry-summary page-summary',
					get_the_excerpt()
				);
			}

			?>
		</div>
		<?php do_action( 'bjork/page_header/bottom' ); ?>
	</div>
</header>
