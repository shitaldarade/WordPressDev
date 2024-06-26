<?php
/**
 * The template for displaying search results pages.
 *
 * @link  https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( have_posts() ) :

	get_template_part( 'templates/parts/component/page-header-search', get_query_var( 'post_type' ) );
	get_template_part( 'templates/parts/loop/loop', 'search' );

else :

	get_template_part( 'templates/parts/content/content', 'none' );

endif;
