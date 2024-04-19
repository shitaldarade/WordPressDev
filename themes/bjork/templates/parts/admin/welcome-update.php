<?php
/**
 * Admin "Welcome" page content component.
 *
 * Theme update guide.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.15
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if (
	! class_exists( 'WebManDesign\Bjork\Welcome\Component' )
	|| function_exists( 'envato_market' )
) {
	return;
}

?>

<div class="welcome__section welcome__section--update" id="welcome-update">

	<h2>
		<span class="welcome__icon dashicons dashicons-update"></span>
		<?php esc_html_e( 'Automatic Theme Updates', 'bjork' ); ?>
	</h2>

	<p>
		<?php esc_html_e( 'WordPress can automatically update only themes from WordPress.org repository.', 'bjork' ); ?>
		<?php esc_html_e( 'As you have obtained this premium theme via Envato Market, you need to enable automatic theme updates with a dedicated plugin.', 'bjork' ); ?>
	</p>

	<p><a href="https://webmandesign.github.io/docs/bjork/#update"><?php esc_html_e( 'Get automatic theme updates &rarr;', 'bjork' ); ?></a></p>

</div>
