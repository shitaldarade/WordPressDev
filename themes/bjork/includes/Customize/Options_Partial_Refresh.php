<?php
/**
 * Theme option partial refresh component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.10
 */

namespace WebManDesign\Bjork\Customize;

use WebManDesign\Bjork\Component_Interface;
use WP_Customize_Manager;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Options_Partial_Refresh implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since    1.0.0
	 * @version  1.0.1
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Actions

				add_action( 'after_setup_theme', __CLASS__ . '::after_setup_theme' );

				add_action( 'customize_register', __CLASS__ . '::setup', 100 );

	} // /init

	/**
	 * After setup theme.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function after_setup_theme() {

		// Processing

			// Customizer: Add theme support for selective widget refresh.
			add_theme_support( 'customize-selective-refresh-widgets' );

	} // /after_setup_theme

	/**
	 * Setup partial refresh.
	 *
	 * @since    1.0.0
	 * @version  1.0.1
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 *
	 * @return  void
	 */
	public static function setup( WP_Customize_Manager $wp_customize ) {

		// Processing

			// Site title.
			$wp_customize->selective_refresh->add_partial( 'blogname', array(
				'selector'        => '.site-title',
				'render_callback' => __CLASS__ . '::render__blogname',
			) );

			// Site description.
			$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => __CLASS__ . '::render__blogdescription',
			) );

			// Site info (footer credits).
			$wp_customize->get_setting( 'texts_site_info' )->transport = 'postMessage';
			$wp_customize->selective_refresh->add_partial( 'texts_site_info', array(
				'selector'            => '.site-info',
				'render_callback'     => __CLASS__ . '::render__texts_site_info',
				'container_inclusive' => false,
			) );

	} // /setup

	/**
	 * Render the site title for the selective refresh partial
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function render__blogname() {

		// Output

			bloginfo( 'name' );

	} // /render__blogname

	/**
	 * Render the site tagline for the selective refresh partial
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function render__blogdescription() {

		// Output

			bloginfo( 'description' );

	} // /render__blogdescription

	/**
	 * Render the site info in the footer for the selective refresh partial.
	 *
	 * @since    1.0.0
	 * @version  1.0.10
	 *
	 * @return  void
	 */
	public static function render__texts_site_info() {

		// Variables

			// No need to use WebManDesign\Bjork\Customize\Mod::get() here.
			$site_info_text = trim( get_theme_mod( 'texts_site_info' ) );


		// Output

			if ( empty( $site_info_text ) ) {
				esc_html_e( 'Please set your website credits text or the theme default one will be displayed.', 'bjork' );
			} elseif ( '-' == $site_info_text ) {
				echo '<style>.site-info-section { display: none; }</style>';
			} else {
				echo (string) $site_info_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

	} // /render__texts_site_info

}
