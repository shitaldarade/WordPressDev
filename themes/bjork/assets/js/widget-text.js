/**
 * Text widget enhancement scripts.
 *
 * WordPress media upload scripts use jQuery.
 * @requires  jQuery
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

( function( $ ) {

	// Image uploader.
	$( document )
		.on( 'click', '.text-widget-media-image-select', function( e ) {
			e.preventDefault();

			var
				$button     = $( this ),
				$file_frame = wp.media.frames.file_frame = wp.media( {
					library  : {
						type : 'image'
					},
					multiple : false
				} );

			$file_frame
				.on( 'select', function() {

						var
							attachment = $file_frame.state().get( 'selection' ).first().toJSON(),
							imageURL   = ( 'undefined' === typeof attachment.sizes.thumbnail ) ? ( attachment.sizes.full.url ) : ( attachment.sizes.thumbnail.url );

						$button
							.next() // Hidden input.
								.val( attachment.id )
								.trigger( 'change' )
							.next() // Image preview.
								.show()
								.find( 'img' )
									.attr( 'src', imageURL );

				} )
				.open();

		} )
		.on( 'click', '.text-widget-media-image-remove', function( e ) {
			e.preventDefault();

			$( this )
				.parent() // Image preview.
					.hide()
				.prev() // Hidden input.
					.val( '' )
					.trigger( 'change' );

		} );

} )( jQuery );
