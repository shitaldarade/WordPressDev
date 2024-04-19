<?php
/**
 * Social links menu template.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$social_links = Menu\Social_Links::get_menu();

if ( empty( $social_links ) ) {
	return;
}

?>

<nav class="social-links" aria-label="<?php esc_attr_e( 'Social links', 'bjork' ); ?>">
	<?php echo $social_links; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
</nav>
