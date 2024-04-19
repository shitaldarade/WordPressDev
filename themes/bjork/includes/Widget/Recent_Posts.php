<?php
/**
 * Widget enhancement: Recent Posts.
 *
 * Altering native WordPress Recent Posts widget by adding an option
 * to choose posts from specific category and changing the output HTML
 * from unordered list to a list of articles.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork\Widget;

use WP_Widget_Recent_Posts;
use WP_Query;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Recent_Posts extends WP_Widget_Recent_Posts {

	/**
	 * Register this widget.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function register_widget() {

		// Processing

			unregister_widget( 'WP_Widget_Recent_Posts' );

			register_widget( __CLASS__ );

	} // /register_widget

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args      Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param  array $instance  Settings for the current Recent Posts widget instance.
	 *
	 * @return  void
	 */
	public function widget( $args, $instance ) {

		// Variables

			$output = '';

			$instance = wp_parse_args( $instance, array(
				'number'    => 5,
				'show_date' => false,
				'title'     => '',
				'category'  => '',
			) );

			if ( empty( $instance['title'] ) ) {
				$instance['title'] = esc_html__( 'Recent Posts', 'bjork' );
			}

			$heading_tag = ( strpos( $args['after_title'], 'h2' ) ) ? ( 'h3' ) : ( 'h4' );

			$posts_container_class = "widget-recent-entries-list";
			if ( $instance['show_date'] ) {
				$posts_container_class .= " entry-date-enabled";
			}

			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}

			// Categories functionality.
			$cat = array();
			if ( ! empty( $instance['category'] ) ) {
				if ( is_numeric( $instance['category'] ) ) {
					$cat = array( 'cat' => absint( $instance['category'] ) );
				} elseif ( is_string( $instance['category'] ) ) {
					$cat = array( 'category_name' => sanitize_title( $instance['category'] ) );
				}
			}


		// Processing

			/**
			 * Fires before "Recent posts" widget output.
			 *
			 * And before the output is even set.
			 *
			 * @since  1.0.0
			 *
			 * @param  array $args      Widget arguments.
			 * @param  array $instance  Widget instance.
			 */
			do_action( 'bjork/widget/recent_posts/before', $args, $instance );

			/**
			 * Filter the arguments for the Recent Posts widget.
			 *
			 * @since 3.4.0
			 * @since 4.9.0 Added the `$instance` parameter.
			 *
			 * @see WP_Query::get_posts()
			 *
			 * @param array $args     An array of arguments used to retrieve the recent posts.
			 * @param array $instance Array of settings for the current widget.
			 */
			$r = new WP_Query(
				apply_filters(
					'widget_posts_args',
					array_merge(
						array(
							'posts_per_page'      => absint( $instance['number'] ),
							'no_found_rows'       => true,
							'post_status'         => 'publish',
							'ignore_sticky_posts' => true,
						),
						(array) $cat
					),
					$instance
				)
			);

			if ( ! $r->have_posts() ) {
				return;
			}

			// Title.
			$instance['title'] = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base, $args );
			if ( trim( $instance['title'] ) ) {
				$output .= $args['before_title'] . $instance['title'] . $args['after_title'];
			}

			$output .= '<div class="' . esc_attr( $posts_container_class ) . '">';

			while ( $r->have_posts() ) {
				$r->the_post();

				$output .= '<article class="' . esc_attr( implode( ' ', (array) get_post_class() ) ) . '">';

				// Post date
				if ( $instance['show_date'] ) {
					$output .= '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="entry-date-link">';
					$output .= '<time datetime="' . esc_attr( get_the_date( DATE_W3C ) ) . '" class="published entry-date" title="' . esc_attr( get_the_date() ) . ' | ' . esc_attr( get_the_time() ) . '">';
					$output .= '<span class="day">' . esc_html( get_the_date( 'd' ) ) . '</span> ';
					$output .= '<span class="month">' . esc_html( get_the_date( 'M' ) ) . '</span> ';
					$output .= '</time>';
					$output .= '</a>';
				}

				$output .= '<div class="entry-content">';

					$aria_current = '';
					if ( get_queried_object_id() === get_the_ID() ) {
						$aria_current = ' aria-current="page"';
					}

					// Post title.
					$post_title = get_the_title();
					$output    .= '<' . tag_escape( $heading_tag ) . ' class="entry-title">';
					$output    .= '<a href="' . esc_url( get_permalink() ) . '"' . $aria_current . '>';
					$output    .= ( ! empty( $post_title ) ) ? ( $post_title ) : ( esc_html__( '(no title)', 'bjork' ) );
					$output    .= '</a>';
					$output    .= '</' . tag_escape( $heading_tag ) . '>';

					// Post excerpt.
					$output .= get_the_excerpt();

				$output .= '</div>';

				$output .= '</article>';
			}

			wp_reset_postdata();

			$output .= '</div>';


		// Output

			if ( $output ) {
				echo $args['before_widget'] . $output . $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/**
			 * Fires after "Recent posts" widget output.
			 *
			 * @since  1.0.0
			 *
			 * @param  array $args      Widget arguments.
			 * @param  array $instance  Widget instance.
			 */
			do_action( 'bjork/widget/recent_posts/after', $args, $instance );

	} // /widget

	/**
	 * Outputs the settings form
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
			$this->field_category( $instance );

	} // /form

	/**
	 * Option field: Category
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
	public function field_category( array $instance = array() ) {

		// Variables

			if ( ! isset( $instance['category'] ) ) {
				$instance['category'] = '';
			}


		// Output

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
					<?php esc_html_e( 'From category:', 'bjork' ); ?>
				</label>
				<?php

				wp_dropdown_categories( array(
					'name'              => $this->get_field_name( 'category' ),
					'id'                => $this->get_field_id( 'category' ),
					'show_option_none'  => '-',
					'option_none_value' => '',
					'orderby'           => 'name',
					'value_field'       => 'slug',
					'show_count'        => true,
					'hide_empty'        => false,
					'hierarchical'      => true,
					'selected'          => $instance['category'],
				) );

				?>
			</p>

			<?php

	} // /field_category

	/**
	 * Handles updating settings for the current widget instance
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

			if ( ! isset( $new_instance['category'] ) ) {
				$new_instance['category'] = '';
			}


		// Processing

			$instance['category'] = ( is_numeric( $new_instance['category'] ) ) ? ( absint( $new_instance['category'] ) ) : ( sanitize_title( (string) $new_instance['category'] ) );


		// Output

			return $instance;

	} // /update

}
