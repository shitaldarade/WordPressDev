<?php
/**
 * Post meta info: categories and tags.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

namespace WebManDesign\Bjork;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if (
	post_password_required()
	|| ! in_array( get_post_type( get_the_ID() ), (array) Setup\Post_Type::get_feature( 'entry_meta' ) )
) {
	return;
}

?>

<footer class="entry-meta"><?php

	get_template_part( 'templates/parts/meta/entry-meta-item', 'category' );
	get_template_part( 'templates/parts/meta/entry-meta-item', 'tags' );

?></footer>
