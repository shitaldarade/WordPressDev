<?php
/**
 * Admin "Welcome" page content component.
 *
 * Theme demo.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.15
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WebManDesign\Bjork\Welcome\Component' ) ) {
	return;
}

?>

<div class="welcome__section welcome__section--demo" id="welcome-demo">

	<h2>
		<span class="welcome__icon dashicons dashicons-database-add"></span>
		<?php esc_html_e( 'Theme Demo Content', 'bjork' ); ?>
	</h2>

	<?php if ( get_option( 'fresh_site' ) ) : ?>
	<div class="welcome__section--child">
		<h3><?php esc_html_e( 'WordPress starter content', 'bjork' ); ?></h3>

		<p>
			<?php esc_html_e( 'This theme contains a predefined starter content.', 'bjork' ); ?>
			<?php esc_html_e( 'So, if you haven\'t created any content yet, just open the customizer to preview the starter content.', 'bjork' ); ?>
			<?php esc_html_e( 'Once you publish your customizer settings, the starter content will be imported into your website automatically.', 'bjork' ); ?>
		</p>

		<p><em><small><?php esc_html_e( '(Note that WordPress starter content works only with fresh installation of WordPress.)', 'bjork' ); ?></small></em>		</p>

		<p><a class="button button-hero" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Customize', 'bjork' ); ?></a></p>
	</div>
	<?php endif; ?>

	<div class="welcome__section--child">
		<h3><?php esc_html_e( 'Full theme demo content', 'bjork' ); ?></h3>

		<p>
			<?php esc_html_e( 'You can install a full theme demo content to match the theme demo website.', 'bjork' ); ?>
			<a href="https://themedemos.webmandesign.eu/bjork/"><?php esc_html_e( '(Preview the demo &rarr;)', 'bjork' ); ?></a>
			<?php esc_html_e( 'This provides a comprehensive start for building your own website.', 'bjork' ); ?>
		</p>

		<?php if ( class_exists( 'OCDI_Plugin' ) ) : ?>
			<p>
				<a class="button button-hero" href="<?php echo esc_url( 'themes.php?page=pt-one-click-demo-import' ); ?>"><?php esc_html_e( 'Install demo content', 'bjork' ); ?></a>
				&ensp;
				<small><em><?php esc_html_e( '(Appearance &rarr; Import Demo Data)', 'bjork' ); ?></em></small>
			</p>
		<?php else : ?>
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>"><?php esc_html_e( 'Use "One Click Demo Import" plugin &rarr;', 'bjork' ); ?></a></p>
		<?php endif; ?>
	</div>

</div>
