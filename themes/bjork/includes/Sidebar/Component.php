<?php
/**
 * Sidebar component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Sidebar;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Entry;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Component implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Actions

				add_action( 'widgets_init', __CLASS__ . '::register', 1 );

				add_action( 'tha_footer_top',    __CLASS__ . '::footer', 20 );

			// Filters

				add_filter( 'widget_tag_cloud_args', __CLASS__ . '::widget_tag_cloud_args' );

				add_filter( 'show_recent_comments_widget_style', '__return_false' );

	} // /init

	/**
	 * Register sidebars.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function register() {

		// Variables

			$widget_areas = array(

				'footer' => array(
					'name'        => esc_html__( 'Footer Widgets', 'bjork' ),
					'description' => esc_html__( 'Widgetized area displaying the main website footer content.', 'bjork' ),
				),

			);


		// Processing

			foreach( $widget_areas as $id => $args ) {
				$id = sanitize_title( $id );
				register_sidebar(
					array( 'id' => $id )
					+ $args
					+ self::get_sidebar_args( $id )
				);
			}

	} // /register

	/**
	 * Returns common sidebar setup arguments.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $sidebar  Sidebar ID for reference.
	 * @param  array  $args     Modifier arguments array.
	 *
	 * @return  array
	 */
	public static function get_sidebar_args( string $sidebar = '', array $args = array() ): array {

		// Variables

			$args = wp_parse_args( $args, array(
				'container_class' => 'widget',
				'title_class'     => 'widget-title',
			) );


		// Output

			/**
			 * Filters common, global sidebar arguments.
			 *
			 * The modifier arguments array sets container and widget title classes.
			 *
			 * @since  1.0.0
			 *
			 * @param  string $sidebar  Sidebar ID for reference.
			 * @param  array  $args     Modifier arguments array.
			 */
			return (array) apply_filters( 'bjork/sidebar/get_sidebar_args', array(
				'before_widget' => '<section id="%1$s" class="' . $args['container_class'] . ' %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="' . $args['title_class'] . '">',
				'after_title'   => '</h2>',
			), $sidebar, $args );

	} // /get_sidebar_args

	/**
	 * Footer sidebar.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function footer() {

		// Output

			get_sidebar( 'footer' );

	} // /footer

	/**
	 * Modifies tag cloud widget arguments for constant font size.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args
	 *
	 * @return  array
	 */
	public static function widget_tag_cloud_args( array $args ): array {

		// Variables

			$args['largest']  = .8;
			$args['smallest'] = .8;
			$args['unit']     = 'em';
			$args['format']   = 'list'; // For better accessibility.


		// Output

			return $args;

	} // /widget_tag_cloud_args

}
