/**
 * Customize preview scripts.
 *
 * No need for dynamic change of 'blogname' and 'blogdescription' as these are being
 * treated as partial refresh (so there is an edit icon displayed in customizer).
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.4
 */

/**
 * Theme mods.
 *
 * Customizer scripts use jQuery.
 * @requires  jQuery
 */
( function( $ ) {
	'use strict';

	wp.customize( 'header_textcolor', function( value ) {
		value
			.bind( function( to ) {
				if ( 'blank' === to ) {
					$( 'body' )
						.addClass( 'is-hidden-site-title' );
				} else {
					$( 'body' )
						.removeClass( 'is-hidden-site-title' );
				}
			} );
	} );

} )( jQuery );

/**
 * Customizer live preview helper functions.
 *
 * @see  WebManDesign\Bjork\Customize\RGBA::customize_preview()
 */
( function( window ) {
	'use strict';

	window.bjork = window.bjork || {};

	/**
	 * Theme customizer preview helper functions.
	 *
	 * @since  1.0.0
	 */
	window.bjork.Customize = {

		/**
		 * Convert hex color into RGB array.
		 *
		 * @since  1.0.0
		 */
		hexToRgbArray : function( $hex = '' ) {
			var
				$rgb = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec( $hex );

			return ( $rgb ) ? ( [
				parseInt( $rgb[1], 16 ),
				parseInt( $rgb[2], 16 ),
				parseInt( $rgb[3], 16 )
			] ) : ( [] );
		},

		/**
		 * Convert hex color into RGB string.
		 *
		 * RGB values are separated with comma.
		 *
		 * @since  1.0.0
		 */
		hexToRgb : function( $hex = '' ) {
			return this.hexToRgbArray( $hex ).join();
		}

	}
} )( window );
