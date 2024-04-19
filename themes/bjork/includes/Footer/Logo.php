<?php
/**
 * Footer logo component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.12
 */

namespace WebManDesign\Bjork\Footer;

use WebManDesign\Bjork\Component_Interface;
use WP_Customize_Cropped_Image_Control;
use WP_Customize_Manager;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Logo implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since  1.0.12
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Actions

				add_action( 'customize_register', __CLASS__ . '::customize_register', 100 );

				add_action( 'bjork/site_info/before', __CLASS__ . '::display' );

	} // /init

	/**
	 * Add new custom logo options for overlaid header templates.
	 *
	 * @since  1.0.12
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 *
	 * @return  void
	 */
	public static function customize_register( WP_Customize_Manager $wp_customize ) {

		// Variables

			$custom_logo_args = get_theme_support( 'custom-logo' );


		// Processing

			$wp_customize->add_setting(
				'custom_logo_footer',
				array(
					'theme_supports'    => array( 'custom-logo' ),
					'transport'         => 'postMessage',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Cropped_Image_Control(
					$wp_customize,
					'custom_logo_footer',
					array(
						'label'         => esc_html__( 'Logo in site footer', 'bjork' ),
						'section'       => 'title_tagline',
						'priority'      => 8,
						'height'        => isset( $custom_logo_args[0]['height'] ) ? $custom_logo_args[0]['height'] : null,
						'width'         => isset( $custom_logo_args[0]['width'] ) ? $custom_logo_args[0]['width'] : null,
						'flex_height'   => isset( $custom_logo_args[0]['flex-height'] ) ? $custom_logo_args[0]['flex-height'] : null,
						'flex_width'    => isset( $custom_logo_args[0]['flex-width'] ) ? $custom_logo_args[0]['flex-width'] : null,
						'button_labels' => array(
							'select'       => esc_html__( 'Select logo', 'bjork' ),
							'change'       => esc_html__( 'Change logo', 'bjork' ),
							'remove'       => esc_html__( 'Remove', 'bjork' ),
							'default'      => esc_html__( 'Default', 'bjork' ),
							'placeholder'  => esc_html__( 'No logo selected', 'bjork' ),
							'frame_title'  => esc_html__( 'Select logo', 'bjork' ),
							'frame_button' => esc_html__( 'Choose logo', 'bjork' ),
						),
					)
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'custom_logo_footer',
				array(
					'selector'            => '.site-footer .custom-logo-link',
					'render_callback'     => array( $wp_customize, '_render_custom_logo_partial' ),
					'container_inclusive' => true,
				)
			);

	} // /customize_register

	/**
	 * Display footer logo.
	 *
	 * @since  1.0.12
	 *
	 * @return  void
	 */
	public static function display() {

		// Output

			add_filter( 'theme_mod_custom_logo', function( $value ) {
				if ( $logo_footer = get_theme_mod( 'custom_logo_footer' ) ) {
					return $logo_footer;
				} else {
					return $value;
				}
			} );

			get_template_part( 'templates/parts/footer/site', 'branding' );

	} // /display

}
