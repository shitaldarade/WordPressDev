<?php
/**
 * Theme options component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.16
 */

namespace WebManDesign\Bjork\Customize;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Tool\Google_Fonts;
use WP_Customize_Manager;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Options implements Component_Interface {

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

				add_action( 'customize_register', __CLASS__ . '::modify', 100 );

			// Filters

				add_filter( 'bjork/customize/options/get', __CLASS__ . '::set', 5 );

	} // /init

	/**
	 * Get theme options setup array.
	 *
	 * @since  1.0.0
	 *
	 * @return  array
	 */
	public static function get(): array {

		// Output

			/**
			 * Filters customizer theme options setup array.
			 *
			 * @since  1.0.0
			 *
			 * @param  array $options
			 */
			return (array) apply_filters( 'bjork/customize/options/get', array() );

	} // /get

	/**
	 * Modify native WordPress options and setup partial refresh pointers.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 *
	 * @return  void
	 */
	public static function modify( WP_Customize_Manager $wp_customize ) {

		// Processing

			// Set live preview for predefined controls.
			$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
			$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

			// Remove obsolete custom header controls (only, not setting!).
			$wp_customize->remove_control( 'header_textcolor' );
			$wp_customize->remove_control( 'header_image' );

			// Option pointers only:

				// Page media on singular pages.
				$wp_customize->selective_refresh->add_partial( 'post_type_single_featured_image', array(
					'selector' => '.is-singular .page-media',
				) );

				// Social icons.
				$wp_customize->selective_refresh->add_partial( 'nav_menu_locations[social]', array(
					'selector' => '.social-links',
				) );

	} // /modify

	/**
	 * Sets theme options array.
	 *
	 * @since    1.0.0
	 * @version  1.0.16
	 *
	 * @param  array $options
	 *
	 * @return  array
	 */
	public static function set( array $options = array() ): array {

		// Variables

			// Predefined font families.
			$font_families = array_filter( array_merge(
				Google_Fonts::get_suggested_fonts(),
				array(
					'system',
					'sans-serif',
					'serif',
				)
			) );

			// Public post types.
			$post_types_public = get_post_types( array( 'public' => true, ), 'objects' );
			unset( $post_types_public['attachment'] );
			unset( $post_types_public['product'] );
			foreach ( $post_types_public as $key => $obj ) {
				$post_types_public[ $key ] = $obj->label;
			}
			$post_types_public_default = $post_types_public;
			// unset( $post_types_public_default['jetpack-portfolio'] );
			// unset( $post_types_public_default['jetpack-testimonial'] );
			$post_types_public_default = array_keys( $post_types_public_default );


		// Processing

			$options = array(

				/**
				 * Site identity: Logo.
				 */
				'0' . 10 . 'logo' . 10 => array(
					'section'           => 'title_tagline',
					'priority'          => 9,
					'type'              => 'number',
					'id'                => 'custom_logo_height',
					'label'             => esc_html__( 'Max logo image height (px)', 'bjork' ),
					'description'       => esc_html__( 'Do not forget to set the logo max height.', 'bjork' ) . ' ' . esc_html__( 'Upload twice as big image to make your logo ready for high DPI screens.', 'bjork' ),
					'default'           => 50,
					'sanitize_callback' => 'absint',
					'input_attrs'       => array(
						'size'     => 5,
						'maxwidth' => 3,
						'min'      => 20,
						'max'      => 500,
					),
					'css_var'           => __NAMESPACE__ . '\Sanitize::css_px',
					'preview_js'        => array(
						'css' => array(
							':root' => array(
								array(
									'property' => '--[[id]]',
									'suffix'   => 'px',
								),
							),
						),
					),
				),

				/**
				 * Theme credits.
				 */
				'0' . 90 . 'placeholder' => array(
					'id'                   => 'placeholder',
					'type'                 => 'section',
					'create_section'       => '',
					'in_panel'             => esc_html_x( 'Theme Options', 'Customizer panel title.', 'bjork' ),
					'in_panel-description' => '<h3>' . esc_html__( 'Theme Credits', 'bjork' ) . '</h3>'
						. '<p class="description">'
						. sprintf(
							/* translators: 1: linked theme name, 2: theme author name. */
							esc_html__( '%1$s is a WordPress theme developed by %2$s.', 'bjork' ),
							'<a href="' . esc_url( wp_get_theme( 'bjork' )->get( 'ThemeURI' ) ) . '"><strong>' . esc_html( wp_get_theme( 'bjork' )->get( 'Name' ) ) . '</strong></a>',
							'<strong>' . esc_html( wp_get_theme( 'bjork' )->get( 'Author' ) ) . '</strong>'
						)
						. '</p>'
						. '<p class="description">'
						. sprintf(
							/* translators: %s: theme author link. */
							esc_html__( 'You can obtain other professional WordPress themes at %s.', 'bjork' ),
							'<strong><a href="' . esc_url( wp_get_theme( 'bjork' )->get( 'AuthorURI' ) ) . '">' . esc_html( str_replace( 'http://', '', untrailingslashit( wp_get_theme( 'bjork' )->get( 'AuthorURI' ) ) ) ) . '</a></strong>'
						)
						. '</p>'
						. '<p class="description">'
						. esc_html__( 'Thank you for using a theme by WebMan Design!', 'bjork' )
						. '</p>',
				),

				/**
				 * Colors: Accent colors.
				 */
				100 . 'colors' => array(
					'id'             => 'colors_accents',
					'type'           => 'section',
					'create_section' => sprintf(
						/* translators: Customizer section title. %s = section name. */
						esc_html__( 'Colors: %s', 'bjork' ),
						esc_html_x( 'Accents', 'Customizer color section title', 'bjork' )
					),
					'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'bjork' ),
				),

					100 . 'colors' . '090' => array(
						'type'       => 'color',
						'id'         => 'color_link',
						'label'      => esc_html__( 'Global link color', 'bjork' ),
						'default'    => '#122e98',
						'css_var'    => 'maybe_hash_hex_color',
						'preview_js' => array(
							'css' => array(
								':root' => array(
									'--[[id]]',
								),
							),
						),
					),

					100 . 'colors' . 100 => array(
						'type'    => 'html',
						'content' =>
							'<h3>' . esc_html__( 'Primary accent color', 'bjork' ) . '</h3>' .
							'<p class="description">' . esc_html__( 'These colors affect buttons and other elements.', 'bjork' ) . '</p>',
					),

						100 . 'colors' . 110 => array(
							'type'       => 'color',
							'id'         => 'color_accent',
							'label'      => esc_html__( 'Accent color', 'bjork' ),
							'default'    => '#122e98',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),
						100 . 'colors' . 120 => array(
							'type'        => 'color',
							'id'          => 'color_accent_text',
							'label'       => esc_html__( 'Accent text color', 'bjork' ),
							'description' => esc_html__( 'Color of text on accent color background.', 'bjork' ),
							'default'     => '#ffffff',
							'css_var'     => 'maybe_hash_hex_color',
							'preview_js'  => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),

				/**
				 * Colors: Header.
				 */
				110 . 'colors' => array(
					'id'             => 'colors_header',
					'type'           => 'section',
					'create_section' => sprintf(
						/* translators: Customizer section title. %s = section name. */
						esc_html__( 'Colors: %s', 'bjork' ),
						esc_html_x( 'Header', 'Customizer color section title', 'bjork' )
					),
					'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'bjork' ),
				),

					/**
					 * Header colors.
					 */
					110 . 'colors' . 100 => array(
						'type'    => 'html',
						'content' => '<h3>' . esc_html__( 'Header', 'bjork' ) . '</h3>',
					),

						110 . 'colors' . 110 => array(
							'type'        => 'color',
							'id'          => 'color_header_background',
							'label'       => esc_html__( 'Background color', 'bjork' ),
							'default'     => '#ffffff',
							'css_var'     => 'maybe_hash_hex_color',
							'preview_js'  => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),
						110 . 'colors' . 120 => array(
							'type'       => 'color',
							'id'         => 'color_header_text',
							'label'      => esc_html__( 'Text color', 'bjork' ),
							'default'    => '#434346',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),
						110 . 'colors' . 130 => array(
							'type'       => 'color',
							'id'         => 'color_header_link',
							'label'      => esc_html__( 'Link color', 'bjork' ),
							'default'    => '#131316',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),

				/**
				 * Colors: Content.
				 */
				120 . 'colors' => array(
					'id'             => 'colors_content',
					'type'           => 'section',
					'create_section' => sprintf(
						/* translators: Customizer section title. %s = section name. */
						esc_html__( 'Colors: %s', 'bjork' ),
						esc_html_x( 'Content', 'Customizer color section title', 'bjork' )
					),
					'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'bjork' ),
				),

					/**
					 * Content colors.
					 */
					120 . 'colors' . 100 => array(
						'type'    => 'html',
						'content' => '<h3>' . esc_html__( 'Content', 'bjork' ) . '</h3>',
					),

						120 . 'colors' . 110 => array(
							'type'       => 'color',
							'id'         => 'color_content_background',
							'label'      => esc_html__( 'Background color', 'bjork' ),
							'default'    => '#ffffff',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),
						120 . 'colors' . 120 => array(
							'type'       => 'color',
							'id'         => 'color_content_text',
							'label'      => esc_html__( 'Text color', 'bjork' ),
							'default'    => '#434346',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),
						120 . 'colors' . 130 => array(
							'type'       => 'color',
							'id'         => 'color_content_headings',
							'label'      => esc_html__( 'Headings color', 'bjork' ),
							'default'    => '#131316',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),

				/**
				 * Colors: Footer.
				 */
				130 . 'colors' => array(
					'id'             => 'colors_footer',
					'type'           => 'section',
					'create_section' => sprintf(
						/* translators: Customizer section title. %s = section name. */
						esc_html__( 'Colors: %s', 'bjork' ),
						esc_html_x( 'Footer', 'Customizer color section title', 'bjork' )
					),
					'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'bjork' ),
				),

					/**
					 * Footer colors.
					 */
					130 . 'colors' . 100 => array(
						'type'        => 'html',
						'content'     => '<h3>' . esc_html__( 'Footer', 'bjork' ) . '</h3>',
						'description' => esc_html__( 'The main footer widgets area is displayed only if it contains some widgets.', 'bjork' ),
					),

						130 . 'colors' . 110 => array(
							'type'       => 'color',
							'id'         => 'color_footer_background',
							'label'      => esc_html__( 'Background color', 'bjork' ),
							'default'    => '#131316',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),
						130 . 'colors' . 120 => array(
							'type'       => 'color',
							'id'         => 'color_footer_text',
							'label'      => esc_html__( 'Text color', 'bjork' ),
							'default'    => '#a3a3a6',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),
						130 . 'colors' . 130 => array(
							'type'       => 'color',
							'id'         => 'color_footer_headings',
							'label'      => esc_html__( 'Headings color', 'bjork' ),
							'default'    => '#ffffff',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),
						130 . 'colors' . 140 => array(
							'type'       => 'color',
							'id'         => 'color_footer_link',
							'label'      => esc_html__( 'Link color', 'bjork' ),
							'default'    => '#ffffff',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),

					/**
					 * Site info colors.
					 */
					130 . 'colors' . 200 => array(
						'type'        => 'html',
						'content'     => '<h3>' . esc_html__( 'Site info', 'bjork' ) . '</h3>',
					),

						130 . 'colors' . 210 => array(
							'type'       => 'color',
							'id'         => 'color_site_info_background',
							'label'      => esc_html__( 'Background color', 'bjork' ),
							'default'    => '#1a1a1d',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),
						130 . 'colors' . 220 => array(
							'type'       => 'color',
							'id'         => 'color_site_info_text',
							'label'      => esc_html__( 'Text color', 'bjork' ),
							'default'    => '#a3a3a6',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),
						130 . 'colors' . 230 => array(
							'type'       => 'color',
							'id'         => 'color_site_info_link',
							'label'      => esc_html__( 'Link color', 'bjork' ),
							'default'    => '#ffffff',
							'css_var'    => 'maybe_hash_hex_color',
							'preview_js' => array(
								'css' => array(
									':root' => array(
										'--[[id]]',
									),
								),
							),
						),

				/**
				 * Layout.
				 */
				300 . 'layout' => array(
					'id'             => 'layout',
					'type'           => 'section',
					'create_section' => esc_html_x( 'Layout', 'Customizer section title.', 'bjork' ),
					'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'bjork' ),
				),

					/**
					 * Site layout.
					 */
					300 . 'layout' . 100 => array(
						'type'    => 'html',
						'content' => '<h3>' . esc_html_x( 'Site Container', 'A website container.', 'bjork' ) . '</h3>',
					),

						300 . 'layout' . 110 => array(
							'type'              => 'range',
							'id'                => 'layout_width_content',
							'label'             => esc_html__( 'Content width', 'bjork' ),
							'description'       =>
								esc_html__( 'Default value:', 'bjork' ) . ' ' . 1280
								. '<br>'
								. esc_html__( 'This width is applied on archive pages, intro section, wide-aligned blocks&hellip;', 'bjork' ),
							'default'           => 1280,
							'min'               => 880,
							'max'               => 1620,
							'step'              => 20,
							'suffix'            => 'px',
							'sanitize_callback' => 'absint',
							'css_var'           => __NAMESPACE__ . '\Sanitize::css_px',
							'preview_js'        => array(
								'css' => array(
									':root' => array(
										array(
											'property' => '--[[id]]',
											'suffix'   => 'px',
										),
									),
								),
							),
						),

						300 . 'layout' . 120 => array(
							'type'              => 'range',
							'id'                => 'layout_width_entry_content',
							'label'             => esc_html__( 'Entry content width', 'bjork' ),
							'description'       =>
								esc_html__( 'Default value:', 'bjork' ) . ' ' . 640
								. '<br>'
								. esc_html__( 'This width is applied on post and page actual content.', 'bjork' )
								. ' '
								. esc_html__( 'Set this cautiously for the best readability.', 'bjork' ),
							'default'           => 640,
							'min'               => 400,
							'max'               => 1000,
							'step'              => 10,
							'suffix'            => 'px',
							'sanitize_callback' => 'absint',
							'css_var'           => __NAMESPACE__ . '\Sanitize::css_px',
							'preview_js'        => array(
								'css' => array(
									':root' => array(
										array(
											'property' => '--[[id]]',
											'suffix'   => 'px',
										),
									),
								),
							),
						),

					/**
					 * Site header.
					 */
					300 . 'layout' . 200 => array(
						'type'    => 'html',
						'content' => '<h3>' . esc_html_x( 'Site Header', 'A website container.', 'bjork' ) . '</h3>',
					),

						300 . 'layout' . 210 => array(
							'type'        => 'multicheckbox',
							'id'          => 'layout_header_content',
							'label'       => esc_html__( 'Header content', 'bjork' ),
							'default'     => array( 'search-form' ),
							'choices' 		=> array(
								'social-links' => esc_html__( 'Display social links', 'bjork' ),
								'search-form'  => esc_html__( 'Display search form', 'bjork' ),
							),
						),

				/**
				 * Texts.
				 */
				800 . 'texts' => array(
					'id'             => 'texts',
					'type'           => 'section',
					'create_section' => esc_html_x( 'Texts', 'Customizer section title.', 'bjork' ),
					'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'bjork' ),
				),

					800 . 'texts' . 100 => array(
						'type'              => 'textarea',
						'id'                => 'texts_site_info',
						'label'             => esc_html__( 'Footer credits (copyright)', 'bjork' ),
						'description'       =>
							sprintf(
								/* translators: %s: customizer option value. */
								esc_html__( 'Set %s to disable this area.', 'bjork' ),
								'<code>-</code>'
							)
							. ' '
							. esc_html__( 'Leaving the field empty will fall back to default theme setting.', 'bjork' ),
						'default'           => '',
						'sanitize_callback' => 'wp_kses_post',
					),

				/**
				 * Typography.
				 */
				900 . 'typography' => array(
					'id'             => 'typography',
					'type'           => 'section',
					'create_section' => esc_html_x( 'Typography', 'Customizer section title.', 'bjork' ),
					'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'bjork' ),
				),

					900 . 'typography' . 100 => array(
						'type'              => 'range',
						'id'                => 'typography_size_html',
						'label'             => esc_html__( 'Basic font size in px', 'bjork' ),
						'description'       => esc_html__( 'All other font sizes are calculated automatically from this basic font size.', 'bjork' ),
						'default'           => 16,
						'min'               => 12,
						'max'               => 24,
						'step'              => 1,
						'suffix'            => 'px',
						'sanitize_callback' => 'absint',
						'css_var'           => __NAMESPACE__ . '\Sanitize::css_px',
						'preview_js'        => array(
							'css' => array(
								':root' => array(
									array(
										'property' => '--[[id]]',
										'suffix'   => 'px',
									),
								),
							),
						),
					),

					900 . 'typography' . 110 => array(
						'type'    => 'html',
						'content' =>
							'<h3>'
							. esc_html__( 'Font families setup', 'bjork' )
							. '</h3>'
							. '<p class="description">'
							. sprintf(
								/* translators: %s: customizer option values. */
								esc_html__( 'Values of %s set web safe system font families.', 'bjork' ),
								'<code>system</code>, <code>serif</code>, <code>sans-serif</code>'
							)
							. ' '
							. esc_html__( '(Don\'t forget to provide these as fallback values.)', 'bjork' )
							. '</p>'
							. '<p class="description">'
							. esc_html__( 'You can use any Google Fonts with this theme.', 'bjork' )
							. ' '
							. esc_html__( 'Just input the Google Fonts font family name into the fields below, choose language, and you are done!', 'bjork' )
							. '</p>',
					),

					900 . 'typography' . 120 => array(
						'type'              => 'text',
						'id'                => 'typography_font_global',
						'label'             => esc_html__( 'Global font', 'bjork' ),
						'description'       => esc_html__( 'Default value:', 'bjork' ) . " <code>'DM Sans', sans-serif</code>",
						'default'           => "'DM Sans', sans-serif",
						'datalist'          => $font_families,
						'sanitize_callback' => __NAMESPACE__ . '\Sanitize::fonts',
						'css_var'           => __NAMESPACE__ . '\Sanitize::css_fonts',
						'input_attrs'       => array(
							'placeholder' => 'sans-serif',
						),
					),

					900 . 'typography' . 130 => array(
						'type'              => 'text',
						'id'                => 'typography_font_headings',
						'label'             => esc_html__( 'Headings font', 'bjork' ),
						'description'       => esc_html__( 'Default value:', 'bjork' ) . ' <code>Poppins, sans-serif</code>',
						'default'           => 'Poppins, sans-serif',
						'datalist'          => $font_families,
						'sanitize_callback' => __NAMESPACE__ . '\Sanitize::fonts',
						'css_var'           => __NAMESPACE__ . '\Sanitize::css_fonts',
						'input_attrs'       => array(
							'placeholder' => 'sans-serif',
						),
					),

					900 . 'typography' . 140 => array(
						'type'              => 'text',
						'id'                => 'typography_font_site_title',
						'label'             => esc_html__( 'Site title font', 'bjork' ),
						'description'       => esc_html__( 'Default value:', 'bjork' ) . ' <code>Poppins, sans-serif</code>',
						'default'           => 'Poppins, sans-serif',
						'datalist'          => $font_families,
						'sanitize_callback' => __NAMESPACE__ . '\Sanitize::fonts',
						'css_var'           => __NAMESPACE__ . '\Sanitize::css_fonts',
						'input_attrs'       => array(
							'placeholder' => 'serif',
						),
					),

					900 . 'typography' . 150 => array(
						'type'        => 'multicheckbox',
						'id'          => 'typography_font_language',
						'label'       => esc_html__( 'Languages', 'bjork' ),
						'description' =>
							esc_html__( 'Not all Google Fonts support all languages.', 'bjork' )
							. ' '
							. esc_html__( 'Please check on Google Fonts website to make sure.', 'bjork' ),
						'default'     => array( 'latin' ),
						'choices' 		=> array(
							'latin'        => esc_html__( 'Latin', 'bjork' ),
							'latin-ext'    => esc_html__( 'Latin Extended', 'bjork' ),
							'cyrillic'     => esc_html__( 'Cyrillic', 'bjork' ),
							'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'bjork' ),
							'greek'        => esc_html__( 'Greek', 'bjork' ),
							'greek-ext'    => esc_html__( 'Greek Extended', 'bjork' ),
							'vietnamese'   => esc_html__( 'Vietnamese', 'bjork' ),
						),
						'active_callback' => __NAMESPACE__ . '\Options_Conditional::is_typography_google_fonts',
					),

					900 . 'typography' . 160 => array(
						'type'        => 'checkbox',
						'id'          => 'typography_google_fonts',
						'label'       => esc_html__( 'Enable theme Google Fonts loading', 'bjork' ),
						'description' => esc_html__( 'In case you are loading fonts via plugin, disable this option.', 'bjork' ),
						'default'     => true,
					),

				/**
				 * Others.
				 */
				950 . 'others' => array(
					'id'             => 'others',
					'type'           => 'section',
					'create_section' => esc_html_x( 'Others', 'Customizer section title.', 'bjork' ),
					'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'bjork' ),
				),

					950 . 'others' . 100 => array(
						'type'        => 'checkbox',
						'id'          => 'admin_welcome_page',
						'label'       => esc_html__( 'Show "Welcome" page', 'bjork' ),
						'description' => esc_html__( 'Under "Appearance" WordPress dashboard menu.', 'bjork' ),
						'default'     => true,
						'preview_js'  => false, // This is to prevent customizer preview reload.
					),

					950 . 'others' . 110 => array(
						'type'        => 'checkbox',
						'id'          => 'navigation_mobile',
						'label'       => esc_html__( 'Enable mobile navigation', 'bjork' ),
						'description' => esc_html__( 'If your website navigation is very simple and you do not want to use the mobile navigation functionality, you can disable it here.', 'bjork' ),
						'default'     => true,
					),

					950 . 'others' . 120 => array(
						'type'        => 'multicheckbox',
						'id'          => 'post_type_single_featured_image',
						'label'       => esc_html__( 'Featured image display', 'bjork' ),
						'description' => esc_html__( 'Choose which post type displays a featured image on singular post page (if the featured image is set).', 'bjork' ),
						'default'     => $post_types_public_default,
						'choices'     => $post_types_public,
					),

					950 . 'others' . 130 => array(
						'type'    => 'checkbox',
						'id'      => 'blog_filter',
						'label'   => esc_html__( 'Enable blog categories filter', 'bjork' ),
						'default' => false,
					),

			);


		// Output

			return (array) $options;

	} // /set

}
