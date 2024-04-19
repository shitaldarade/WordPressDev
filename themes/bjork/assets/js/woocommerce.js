/**
 * WooCommerce frontend scripts.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.10
 */

( function() {
	'use strict';

	// Add class of tabs count on tab selector wrapper.

		var
			wcTabs = document.getElementsByClassName( 'woocommerce-tabs' );

		if ( wcTabs.length ) {
			var
				wcTabsCount = wcTabs[0].querySelectorAll( '.tabs li' ).length;

			wcTabs[0].classList.add( 'tabs-count-' + wcTabsCount );
		}

	// Apply additional classes and attributes into reviews pagination.

		var
			wcReviewsPagination = document.querySelectorAll( '#reviews .woocommerce-pagination' );

		if ( wcReviewsPagination.length ) {
			wcReviewsPagination.forEach( function( pagination ){
				pagination.classList.add( 'pagination' );
				pagination.classList.add( 'comment-navigation' );
				pagination.setAttribute( 'data-current', pagination.querySelectorAll( '.current' )[0].textContent );
				pagination.setAttribute( 'data-total', pagination.querySelectorAll( '.page-numbers:not(.prev):not(.next)' ).length );
			} );
		}

} )();
