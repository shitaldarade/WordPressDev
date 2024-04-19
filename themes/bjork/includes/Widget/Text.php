<?php
/**
 * Widget enhancement: Text.
 *
 * Altering native WordPress Text widget by adding a featured
 * image and a custom icon element. Also wrapping the widget
 * content within a `div.widget-text-content`.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Widget;

use WebManDesign\Bjork\Assets;
use WP_Widget_Text;
use FLBuilderModel;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Text extends WP_Widget_Text {

	/**
	 * Constructor.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public function __construct() {

		// Processing

			parent::__construct();

			// Actions

				add_action( 'admin_print_scripts-widgets.php', __CLASS__ . '::enqueue' );

				add_action( 'wp_head', __CLASS__ . '::style_icon_fallback', 5 );

				add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_front_end' );

	} // /__construct

	/**
	 * Register this widget.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function register_widget() {

		// Processing

			unregister_widget( 'WP_Widget_Text' );

			register_widget( __CLASS__ );

	} // /register_widget

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args      Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param  array $instance  Settings for the current Text widget instance.
	 *
	 * @return  void
	 */
	public function widget( $args, $instance ) {

		// Variables

			$widget_media = array_filter( array(
				'icon'  => ( isset( $instance['icon'] ) ) ? ( trim( $instance['icon'] ) ) : ( '' ),
				'image' => ( isset( $instance['image'] ) ) ? ( $instance['image'] ) : ( 0 ),
			) );


		// Requirements check

			if ( empty( $widget_media ) ) {
				parent::widget( $args, $instance );
				return;
			}


		// Processing

			// Adding widget media before widget title.
			$args['before_widget'] .= self::get_widget_media_image( $widget_media );
			$args['before_widget'] .= self::get_widget_media_icon( $widget_media );

			// Wrapping widget title and content with custom div.
			$args['before_widget'] .= '<div class="widget-text-content">';
			$args['after_widget']   = '</div>' . $args['after_widget'];

			/**
			 * Filters enhanced Text widget arguments array.
			 *
			 * Enhancements added image and icon to `before_widget` key,
			 * and also wrapped the content within a `div.widget-text-content`.
			 *
			 * @since  1.0.0
			 *
			 * @param  array $args      Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
			 * @param  array $instance  Settings for the current Text widget instance.
			 */
			$args = (array) apply_filters( 'bjork/widget/text/args', $args, $instance );


		// Output

			// Now everything is set and we can output the widget HTML.
			parent::widget( $args, $instance );

	} // /widget

	/**
	 * Get output HTML of widget media: Image.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $widget_media  Media setup array.
	 *
	 * @return  string
	 */
	public static function get_widget_media_image( array $widget_media = array() ): string {

		// Requirements check

			if ( empty( $widget_media['image'] ) ) {
				return '';
			}


		// Variables

			$output = '';

			/**
			 * Filters Text widget thumbnail image size.
			 *
			 * @since  1.0.0
			 *
			 * @param  string $image_size
			 * @param  array  $widget_media  Widget media setup array.
			 */
			$image_size = (string) apply_filters( 'bjork/widget/text/image_size', 'thumbnail', $widget_media );


		// Processing

			$output .= '<figure class="widget-text-media widget-text-media-image">';

			if ( is_numeric( $widget_media['image'] ) ) {
				$output .= wp_get_attachment_image( absint( $widget_media['image'] ), $image_size );
			} else {
				$output .= '<img '
				         . 'src="' . esc_url( $widget_media['image'] ) . '" '
				         . 'alt="" '
				         . '/>';
			}

			$output .= '</figure>';


		// Output

			return $output;

	} // /get_widget_media_image

	/**
	 * Get output HTML of widget media: Icon.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $widget_media  Media setup array.
	 *
	 * @return  string
	 */
	public static function get_widget_media_icon( array $widget_media = array() ): string {

		// Requirements check

			if ( empty( $widget_media['icon'] ) ) {
				return '';
			}


		// Variables

			$output = '';


		// Processing

			$output .= '<div class="widget-text-media widget-text-media-icon">';
			$output .= '<span class="widget-symbol ' . esc_attr( $widget_media['icon'] ) . '" aria-hidden="true"></span>';
			$output .= '</div>';


		// Output

			return $output;

	} // /get_widget_media_icon

	/**
	 * Outputs the settings form.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $instance  Current settings.
	 *
	 * @return  void
	 */
	public function form( $instance ) {

		// Processing

			parent::form( $instance );


		// Output

			/**
			 * Warning:
			 * Do not use static method call here (self::X), keep using $this->X!
			 */
			$this->field_icon( $instance );
			$this->field_image( $instance );

	} // /form

	/**
	 * Option field: Icon.
	 *
	 * Warning:
	 * Do not feel tempted to make this a static method!
	 *
	 * @since  1.0.0
	 *
	 * @param  array $instance  Current settings.
	 *
	 * @return  void
	 */
	public function field_icon( array $instance = array() ) {

		// Variables

			if ( ! isset( $instance['icon'] ) ) {
				$instance['icon'] = '';
			}


		// Output

			?>

			<p class="text-widget-media-icon">
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>">
					<strong><?php esc_html_e( 'Set icon CSS class:', 'bjork' ); ?></strong><br>
					<span class="description" style="display: inline-block; padding: 0 0 .38em">
						<em>
							<?php

							printf(
								/* translators: %s: suggested plugin name. */
								esc_html__( 'For displaying icons on your website use a plugin, such as %s.', 'bjork' ),
								'<a href="https://wordpress.org/plugins/font-awesome/">' . esc_html_x( 'Font Awesome', 'Plugin name.', 'bjork' ) . '</a>'
							);

							?>
						</em>
					</span>
				</label>
				<input type="text" class="widefat text-widget-media-icon-class" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" value="<?php echo esc_attr( $instance['icon'] ); ?>" />
			</p>

			<?php

	} // /field_icon

	/**
	 * Option field: Image.
	 *
	 * Warning:
	 * Do not feel tempted to make this a static method!
	 *
	 * @since  1.0.0
	 *
	 * @param  array $instance  Current settings.
	 *
	 * @return  void
	 */
	public function field_image( array $instance = array() ) {

		// Variables

			if ( ! isset( $instance['image'] ) ) {
				$instance['image'] = 0;
			}


		// Output

			?>

			<p class="text-widget-media-image">
				<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>">
					<strong><?php esc_html_e( 'Set image:', 'bjork' ); ?></strong><br>
					<span class="description" style="display: inline-block; padding: 0 0 .38em">
						<em>
							<?php esc_html_e( 'Choose a featured image for this widget.', 'bjork' ); ?>
						</em>
					</span>
				</label>
				<br>
				<button class="button button-hero text-widget-media-image-select"><?php esc_html_e( 'Select image', 'bjork' ); ?></button>
				<input type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>" />
				<span class="text-widget-media-image-preview"<?php if ( empty( $instance['image'] ) ) { echo ' style="display: none;"'; } ?>>
					<img src="<?php

						if ( is_numeric( $instance['image'] ) ) {
							$image_url = wp_get_attachment_image_src( absint( $instance['image'] ) );
							if ( $image_url ) {
								echo esc_url( $image_url[0] );
							}
						} elseif ( $instance['image'] ) {
							echo esc_url( $instance['image'] );
						}

						?>" alt="<?php esc_attr_e( 'Widget featured image', 'bjork' ); ?>" />
					<button class="button text-widget-media-image-remove">
						<span class="screen-reader-text"><?php esc_html_e( 'Remove image', 'bjork' ); ?></span>
					</button>
				</span>
			</p>

			<?php

	} // /field_image

	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $new_instance  New settings for this instance as input by the user via WP_Widget::form().
	 * @param  array $old_instance  Old settings for this instance.
	 *
	 * @return  array
	 */
	public function update( $new_instance, $old_instance ): array {

		// Variables

			$instance = parent::update( $new_instance, $old_instance );

			if ( ! isset( $new_instance['icon'] ) ) {
				$new_instance['icon'] = '';
			}

			if ( ! isset( $new_instance['image'] ) ) {
				$new_instance['image'] = '';
			}


		// Processing

			$instance['icon']  = esc_attr( $new_instance['icon'] );
			$instance['image'] = ( is_numeric( $new_instance['image'] ) ) ? ( absint( $new_instance['image'] ) ) : ( esc_url_raw( $new_instance['image'] ) );


		// Output

			return $instance;

	} // /update

	/**
	 * Enqueue assets.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function enqueue() {

		// Processing

			// Styles

				Assets\Factory::style_enqueue( array(
					'handle'   => 'bjork-widget-text',
					'src'      => get_theme_file_uri( 'assets/css/options-widget-text.css' ),
					'add_data' => array(
						'precache' => true,
					),
				) );

			// Scripts

				wp_enqueue_media();

				Assets\Factory::script_enqueue( array(
					'handle'   => 'bjork-widget-text',
					'src'      => get_theme_file_uri( 'assets/js/widget-text.min.js' ),
					'deps'     => array( 'media-upload' ),
					'add_data' => array(
						'precache' => true,
					),
				) );

	} // /enqueue

	/**
	 * Enqueue assets on front end.
	 *
	 * This only happens after fulfilling conditional check.
	 * The condition is filterable for more flexibility.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function enqueue_front_end() {

		// Processing

			if (
				/**
				 * Filters when to enqueue Text widget enhancement styles and scripts on frontend.
				 *
				 * The default condition loads the assets when Beaver Builder page builder
				 * plugin's edit interface is active.
				 *
				 * The filter makes widget enhancement functionality optionally compatible
				 * with any (page builder) plugin.
				 *
				 * @since  1.0.0
				 *
				 * @param  bool $can_enqueue
				 */
				(bool) apply_filters( 'bjork/widget/text/enqueue_front_end', (
					is_callable( 'FLBuilderModel::is_builder_active' )
					&& FLBuilderModel::is_builder_active()
				) )
			) {
				self::enqueue();
			}

	} // /enqueue_front_end

	/**
	 * Icon fallback styles.
	 *
	 * For cases when no icons font is loaded.
	 *
	 * IMPORTANT:
	 * This has to be loaded early enough, before the icons font stylesheet
	 * is enqueued (with a plugin)! And as we don't know the stylesheet handle,
	 * we ca not use `wp_add_inline_style()`.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function style_icon_fallback() {

		// Output

			echo '<style id="bjork-text-widget-icon-fallback">'
			   . '.widget-symbol::before { content: "👍"; font-family: inherit; }'
			   . '</style>';

	} // /style_icon_fallback

}
