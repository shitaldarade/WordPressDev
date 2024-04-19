<?php // phpcs:ignore WPThemeReview.Templates.ReservedFileNamePrefix.ReservedTemplatePrefixFound
/**
 * Page header, for archive pages.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
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
			<h1 class="page-title"><?php the_archive_title( '', $paged_info ); ?></h1>
			<?php

			if ( empty( $paged_info ) ) {
				the_archive_description( '<div class="archive-description page-summary">', '</div>' );
			}

			?>
		</div>
		<?php do_action( 'bjork/page_header/bottom' ); ?>
	</div>
</header>
