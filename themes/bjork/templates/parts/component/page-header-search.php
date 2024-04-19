<?php // phpcs:ignore WPThemeReview.Templates.ReservedFileNamePrefix.ReservedTemplatePrefixFound
/**
 * Page header for search results page.
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

?>

<header class="page-header">
	<div class="page-header-content">
		<?php do_action( 'bjork/page_header/top' ); ?>
		<div class="page-header-text">
			<h1 class="page-title"><?php

			printf(
				/* translators: %s: search query. */
				esc_html__( 'Search Results for: %s', 'bjork' ),
				'<span>' . get_search_query() . '</span>'
			);

			echo Content\Component::get_paged_info(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			?></h1>
		</div>
		<?php do_action( 'bjork/page_header/bottom' ); ?>
	</div>
</header>
