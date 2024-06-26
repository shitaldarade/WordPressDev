<?php
/**
 * The header for our theme.
 *
 * @link  https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

do_action( 'tha_html_before' );

?>

<html <?php language_attributes(); ?>>


<head>

<?php

do_action( 'tha_head_top' );
do_action( 'tha_head_bottom' );

wp_head();
wp_enqueue_style( 'style', get_stylesheet_uri() );

?>

</head>


<body <?php body_class(); ?>>

<?php

wp_body_open();

do_action( 'tha_body_top' );

do_action( 'tha_header_before' );
do_action( 'tha_header_top' );
do_action( 'tha_header_bottom' );
do_action( 'tha_header_after' );

do_action( 'tha_content_before' );
do_action( 'tha_content_top' );
