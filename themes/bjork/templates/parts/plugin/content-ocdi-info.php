<?php
/**
 * One Click Demo Import integration: Info content.
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

<div class="theme-demo-info">

	<h2><?php esc_html_e( 'Theme demo information', 'bjork' ); ?></h2>

	<p>
		<?php esc_html_e( 'By importing this demo content you get the exact copy of the theme demo website.', 'bjork' ); ?>
		(<a href="https://themedemos.webmandesign.eu/bjork/"><?php esc_html_e( 'Preview the theme demo website &raquo;', 'bjork' ); ?></a>)
	</p>

</div>

<div class="media-files-quality-info">
	<h3><?php esc_html_e( 'Media files quality', 'bjork' ); ?></h3>

	<p>
		<?php esc_html_e( 'Please note that imported media files (such as images, video and audio files) are of low quality to prevent copyright infringement.', 'bjork' ); ?>
		<?php esc_html_e( 'Please read "Credits" section of theme documentation for reference where the demo media files were obtained from.', 'bjork' ); ?>

		<a href="https://webmandesign.github.io/docs/bjork/#credits"><?php
			esc_html_e( 'Get media for your website &raquo;', 'bjork' );
		?></a>
	</p>
</div>

<div class="ocdi__demo-import-notice">
	<h3><?php esc_html_e( 'Install demo required plugins!', 'bjork' ); ?></h3>

	<p>
		<?php esc_html_e( 'Please read the information about the theme demo required plugins first.', 'bjork' ); ?>
		<?php esc_html_e( 'If you do not install and activate the demo required plugins, some of the content will not be imported.', 'bjork' ); ?>

		<a href="https://github.com/webmandesign/demo-content/blob/master/bjork/readme.md#required-plugins" title="<?php esc_attr_e( 'Read the information before you run the theme demo content import process.', 'bjork' ); ?>"><strong><?php
			esc_html_e( 'View the list of required plugins &raquo;', 'bjork' );
		?></strong></a>
	</p>

	<p><em>
		<?php esc_html_e( '(Note that this set of plugins may differ from plugins recommended under Appearance &rarr; Install Plugins!)', 'bjork' ); ?>
	</em></p>
</div>
