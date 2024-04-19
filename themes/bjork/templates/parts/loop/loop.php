<?php
/**
 * Default WordPress loop content.
 *
 * Jetpack Infinite Scroll requires `id="posts"`.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Fires before posts list container opening tag.
 *
 * @since  1.0.0
 */
do_action( 'bjork/postslist/before' );

?>

<div id="posts" class="posts posts-list">

	<?php

	do_action( 'tha_content_while_before' );

	while ( have_posts() ) :
		the_post();

		/**
		 * Include the Post-Type-specific template for the content, by default.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
		 *
		 * Or, use the `bjork/content/get_content_type` filter hook to modify the content type.
		 * @see  WebManDesign\Bjork\Content\Component::get_content_type()
		 */
		get_template_part( 'templates/parts/content/content', Content\Component::get_content_type( 'loop' ) );

	endwhile;

	do_action( 'tha_content_while_after' );

	?>

</div>

<?php

/**
 * Fires after posts list container closing tag.
 *
 * @since  1.0.0
 */
do_action( 'bjork/postslist/after' );
