<?php
/**
 * One Click Demo Import integration: Jetpack custom post types info content.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<div class="jetpack-info ocdi__demo-import-notice">
	<h3><?php esc_html_e( 'Jetpack Custom content types', 'bjork' ); ?></h3>

	<p>
		<?php esc_html_e( 'Please make sure your Jetpack plugin is connected and you have activated Testimonials and Portfolios "Custom content types" in Jetpack settings (navigate to Jetpack &rarr; Settings &rarr; Writing).', 'bjork' ); ?>
		<?php esc_html_e( 'If you do not activate these, the related demo content will not be imported.', 'bjork' ); ?>
	</p>
	<p><em>
		<?php esc_html_e( 'If your Jetpack plugin is connected, you may just try to reload this page and we will attempt to activate those custom content types for you automatically.', 'bjork' ); ?>
		<?php esc_html_e( 'If the operation is successful, this message will disappear and you should see 2 new items in your WordPress dashboard menu: "Portfolio" and "Testimonials".', 'bjork' ); ?>
	</em></p>

	<a href="" class="button"><?php
		esc_html_e( 'Reload this page &raquo;', 'bjork' );
	?></a>
</div>
