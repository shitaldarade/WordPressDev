<?php
/**
 * Post meta info in page header: date, author, comments.
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

<div class="entry-meta page-meta"><?php

	get_template_part( 'templates/parts/meta/entry-meta-item', 'date' );
	get_template_part( 'templates/parts/meta/entry-meta-item', 'author' );
	get_template_part( 'templates/parts/meta/entry-meta-item', 'comments' );

?></div>
