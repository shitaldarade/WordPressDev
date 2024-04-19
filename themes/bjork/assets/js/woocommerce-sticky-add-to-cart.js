/**
 * WooCommerce product sticky add-to-cart.
 *
 * Functionality ported from Storefront theme by Automattic.
 * @link  https://github.com/woocommerce/storefront
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 *
 * @global $bjorkStickyAddToCartParams
 */

( function() {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function() {

		var
			stickyAddToCart = document.getElementsByClassName( 'sticky-add-to-cart' );

		if ( ! stickyAddToCart.length ) {
			return;
		}

		if ( typeof $bjorkStickyAddToCartParams === 'undefined' ) {
			return;
		}

		var
			trigger = document.getElementsByClassName( $bjorkStickyAddToCartParams.trigger_class );

		if ( trigger.length > 0 ) {
			var
				product_id = null,
				stickyAddToCartToggle = function() {
					if ( ( trigger[0].getBoundingClientRect().top + trigger[0].scrollHeight ) < 0 ) {
						stickyAddToCart[0].classList.add( 'sticky-add-to-cart-show' );
						stickyAddToCart[0].classList.remove( 'sticky-add-to-cart-hide' );
					} else if ( stickyAddToCart[0].classList.contains( 'sticky-add-to-cart-show' ) ) {
						stickyAddToCart[0].classList.add( 'sticky-add-to-cart-hide' );
						stickyAddToCart[0].classList.remove( 'sticky-add-to-cart-show' );
					}
				};

			stickyAddToCartToggle();

			window.addEventListener( 'scroll', function() {
				stickyAddToCartToggle();
			} );

			document.body.classList.forEach( function( item ){
				if ( 'postid-' === item.substring( 0, 7 ) ) {
					product_id = item.replace( /[^0-9]/g, '' );
				}
			} );

			if ( product_id ) {
				var
					product = document.getElementById( 'product-' + product_id );

				if ( product ) {
					if (
						! product.classList.contains( 'product-type-simple' )
						&& ! product.classList.contains( 'product-type-external' )
					) {

						var
							selectOptions = document.getElementsByClassName( 'sticky-add-to-cart-button' );

						selectOptions[0].addEventListener( 'click', function( event ) {
							event.preventDefault();
							document.getElementById( 'product-' + product_id ).scrollIntoView();
						} );

					}
				}
			}
		}

	} );
} )();
