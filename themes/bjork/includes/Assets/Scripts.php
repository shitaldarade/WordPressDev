<?php
/**
 * Theme scripts component.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.16
 */

namespace WebManDesign\Bjork\Assets;

use WebManDesign\Bjork\Component_Interface;
use WebManDesign\Bjork\Header\Component as Header;
use WebManDesign\Bjork\Customize\Mod;
use WebManDesign\Bjork\Tool\AMP;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Scripts implements Component_Interface {

	/**
	 * Initialization.
	 *
	 * @since    1.0.0
	 * @version  1.0.4
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Actions

				add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_inline', 0 );
				add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_inline_nav_mobile', BJORK_ENQUEUE_PRIORITY + 9 );
				add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_inline_no_js_class', BJORK_ENQUEUE_PRIORITY + 9 );
				add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_inline_scroll', BJORK_ENQUEUE_PRIORITY + 9 );

				add_action( 'comment_form_before', __CLASS__ . '::enqueue_comment_reply' );

	} // /init

	/**
	 * Placeholders for adding inline scripts.
	 *
	 * @since  1.0.4
	 *
	 * @return  void
	 */
	public static function enqueue_inline() {

		// Processing

			// Placeholder for adding localize scripts early.
			wp_register_script( 'bjork-scripts-before', '' );
			wp_enqueue_script( 'bjork-scripts-before' );

			// Placeholder for adding footer scripts.
			wp_register_script( 'bjork-scripts-footer', '', array(), false, true );
			wp_enqueue_script( 'bjork-scripts-footer' );

	} // /enqueue

	/**
	 * Enqueue comment reply script the right way.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function enqueue_comment_reply() {

		// Requirements check

			if ( AMP::is_amp() ) {
				return;
			}


		// Processing

			if (
				is_singular()
				&& comments_open()
				&& get_option( 'thread_comments' )
			) {
				/**
				 * This script should be registered by now
				 * with `wp_default_scripts()`.
				 */
				wp_enqueue_script( 'comment-reply' );
			}

	} // /enqueue_comment_reply

	/**
	 * Mobile navigation toggling.
	 *
	 * Minified script is copied from `assets/js/navigation-mobile.min.js`
	 * and enqueued inline in the footer to prevent external file load.
	 *
	 * For unminified script:
	 * @see  assets/js/navigation-mobile.js
	 *
	 * @since    1.0.4
	 * @version  1.0.15
	 *
	 * @return  void
	 */
	public static function enqueue_inline_nav_mobile() {

		// Requirements check

			if (
				AMP::is_amp()
				|| ! Header::is_enabled()
				|| ! Mod::get( 'navigation_mobile' )
			) {
				return;
			}


		// Processing

			wp_add_inline_script(
				'bjork-scripts-footer',
				'"use strict";!function(){var e=document.getElementById("site-navigation");if(e){var t=document.getElementById("menu-toggle");if(t)document.getElementById("menu-primary")?(t.onclick=function(){n()},document.addEventListener("keydown",(function(o){if(e.classList.contains("toggled")){var l=e.querySelectorAll("a, button, input:not([type=hidden]), select"),a=l[0],i=l[l.length-1],s=document.activeElement,c=9===o.keyCode,d=27===o.keyCode,u=o.shiftKey;d&&(o.preventDefault(),n(),t.focus()),!u&&c&&i===s&&(o.preventDefault(),a.focus()),u&&c&&a===s&&(o.preventDefault(),i.focus()),c&&a===i&&o.preventDefault()}}))):t.style.display="none"}function n(){e.classList.toggle("toggled"),document.body.classList.toggle("has-navigation-toggled"),document.documentElement.classList.toggle("lock-scroll"),-1!==e.className.indexOf("toggled")?t.setAttribute("aria-expanded","true"):t.setAttribute("aria-expanded","false")}}();'
			);

	} // /enqueue_inline_nav_mobile

	/**
	 * Remove "no-js" class from elements.
	 *
	 * @since    1.0.4
	 * @version  1.0.16
	 *
	 * @return  void
	 */
	public static function enqueue_inline_no_js_class() {

		// Requirements check

			if ( AMP::is_amp() ) {
				return;
			}


		// Processing

			wp_add_inline_script(
				'bjork-scripts-footer',
				Factory::strip( "
					( function() {
						'use strict';

						document.querySelectorAll( '.no-js' ).forEach( function( e ) { e.classList.remove( 'no-js' ) } );
					} )();
				" )
			);

	} // /enqueue_inline_no_js_class

	/**
	 * Has user scrolled the page?
	 *
	 * @since  1.0.4
	 *
	 * @return  void
	 */
	public static function enqueue_inline_scroll() {

		// Requirements check

			if ( AMP::is_amp() ) {
				return;
			}


		// Processing

			wp_add_inline_script(
				'bjork-scripts-footer',
				Factory::strip( "
					( function() {
						'use strict';

						var
							lastScrollTop = window.scrollY,
							ticking       = false;

						function bjorkScroll() {
							var scrolledY = window.scrollY;

							if ( scrolledY < lastScrollTop ) {
								document.body.classList.add( 'has-scrolled-up' );
							} else {
								document.body.classList.remove( 'has-scrolled-up' );
							}

							if ( scrolledY > 1 ) {
								document.body.classList.add( 'has-scrolled' );
							} else {
								document.body.classList.remove( 'has-scrolled' );
								document.body.classList.remove( 'has-scrolled-up' );
							}

							lastScrollTop = scrolledY;
						}

						bjorkScroll();

						window.addEventListener( 'scroll', function( e ) {
							if ( ! ticking ) {
								window.requestAnimationFrame( function() {
									bjorkScroll();
									ticking = false;
								} );
								ticking = true;
							}
						} );
					} )();
				" )
			);

	} // /enqueue_inline_scroll

}
