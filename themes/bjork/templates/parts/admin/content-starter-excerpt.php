<?php
/**
 * Starter content: Excerpt.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! is_admin() ) {
	return;
}

?>

<p>
	<?php echo esc_html_x( 'This is a page/post excerpt text.', 'Theme starter content', 'bjork' ); ?>
	Lorem ipsum dolor sit amet consectetur, adipiscing elit phasellus posuere nulla, nostra eget platea dapibus.
</p>
