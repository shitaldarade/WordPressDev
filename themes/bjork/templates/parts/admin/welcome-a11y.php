<?php
/**
 * Admin "Welcome" page content component.
 *
 * Accessibility tips.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.4
 * @version  1.0.15
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WebManDesign\Bjork\Welcome\Component' ) ) {
	return;
}

?>

<div class="welcome__section welcome__section--a11y" id="welcome-a11y">

	<h2>
		<span class="welcome__icon dashicons dashicons-universal-access-alt"></span>
		<?php esc_html_e( 'Create an Accessible Website', 'bjork' ); ?>
	</h2>

	<p>
		<?php esc_html_e( 'Make your website inclusive and accessible to anyone.', 'bjork' ); ?>
		<?php esc_html_e( 'This theme will help you create a disabilities friendly and barrier-less user experience.', 'bjork' ); ?>
		<?php esc_html_e( 'When building your content, just follow web accessibility best practices.', 'bjork' ); ?>
	</p>

	<div class="welcome__column">
		<h3><?php esc_html_e( 'Simplicity', 'bjork' ); ?></h3>
		<p><?php esc_html_e( 'Keep your text simple. Paragraphs with more than four lines are more difficult to read. Use lists and spacing in your content.', 'bjork' ); ?></p>
	</div>

	<div class="welcome__column">
		<h3><?php esc_html_e( 'Hierarchy', 'bjork' ); ?></h3>
		<p><?php esc_html_e( 'Keep proper headings hierarchy, do not skip heading levels: H2 should be followed by H3 and so on.', 'bjork' ); ?></p>
	</div>

	<div class="welcome__column">
		<h3><?php esc_html_e( 'Images', 'bjork' ); ?></h3>
		<p><?php esc_html_e( 'Adding images to posts and pages makes your content easier to remember.', 'bjork' ); ?></p>
	</div>

	<div class="welcome__column">
		<h3><?php esc_html_e( 'Alternatives', 'bjork' ); ?></h3>
		<p>
			<?php esc_html_e( 'Set alt text to images (do this in the media library or directly in post editor).', 'bjork' ); ?>
			<?php esc_html_e( 'Provide text alternatives for videos and sound.', 'bjork' ); ?>
		</p>
	</div>

	<hr>

	<p><a href="https://webmandesign.github.io/docs/bjork/#accessibility"><?php esc_html_e( 'More info in theme documentation &rarr;', 'bjork' ); ?></a></p>

</div>
