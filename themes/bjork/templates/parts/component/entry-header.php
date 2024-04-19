<?php
/**
 * Entry header.
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

<header class="entry-header">
	<h2 class="entry-title">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2>
</header>
