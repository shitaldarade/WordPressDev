<?php // phpcs:ignore WPThemeReview.Templates.ReservedFileNamePrefix.ReservedTemplatePrefixFound
/**
 * Page header.
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

<header class="page-header">
	<div class="page-header-content">
		<?php do_action( 'bjork/page_header/top' ); ?>
		<div class="page-header-text">
			<h1 class="page-title"><?php

				if ( is_home() && is_front_page() ) {
					bloginfo( 'name' );
				} else {
					single_post_title();
				}

				echo $paged_info; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			?></h1>
			<?php

			// Blog page description (excerpt).
			if (
				empty( $paged_info )
				&& is_home()
				&& ! is_front_page()
			) {
				$posts_page = get_option( 'page_for_posts' );
				if ( has_excerpt( $posts_page ) ) {
					add_filter( 'pre/bjork/entry/summary/get_continue_reading_html', '__return_empty_string' );
					echo '<div class="archive-description page-summary">' . get_the_excerpt( absint( $posts_page ) ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					remove_filter( 'pre/bjork/entry/summary/get_continue_reading_html', '__return_empty_string' );
				}
			}

			?>
		</div>
		<?php do_action( 'bjork/page_header/bottom' ); ?>
	</div>
</header>
