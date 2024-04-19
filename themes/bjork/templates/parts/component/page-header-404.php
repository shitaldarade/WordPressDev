<?php // phpcs:ignore WPThemeReview.Templates.ReservedFileNamePrefix.ReservedTemplatePrefixFound
/**
 * Page header, for error 404 page.
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

?>

<header class="page-header">
	<div class="page-header-content">
		<?php do_action( 'bjork/page_header/top' ); ?>
		<div class="page-header-text">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can not be found.', 'bjork' ); ?></h1>
		</div>
		<?php do_action( 'bjork/page_header/bottom' ); ?>
	</div>
</header>
