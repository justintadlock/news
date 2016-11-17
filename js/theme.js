jQuery( window ).ready( function() {

	/*
	 * Adds classes to the `<label>` element based on the type of form element the label belongs
	 * to. This allows theme devs to style specifically for certain labels (think, icons).
	 */

	jQuery( '#container input, #container textarea, #container select' ).each(

		function() {
			var input_type = 'input';
			var input_id   = jQuery( this ).attr( 'id' );
			var label      = '';

			if ( jQuery( this ).is( 'input' ) )
				input_type = jQuery( this ).attr( 'type' );

			else if ( jQuery( this ).is( 'textarea' ) )
				input_type = 'textarea';

			else if ( jQuery( this ).is( 'select' ) )
				input_type = 'select';

			jQuery( this ).parent( 'label' ).addClass( 'label-' + input_type );

			if ( input_id )
				jQuery( 'label[for="' + input_id + '"]' ).addClass( 'label-' + input_type );

			if ( 'checkbox' === input_type || 'radio' === input_type ) {
				jQuery( this ).parent( 'label' ).removeClass( 'font-secondary' ).addClass( 'font-primary' );

				if ( input_id )
					jQuery( 'label[for="' + input_id + '"]' ).removeClass( 'font-secondary' ).addClass( 'font-primary' );

			}
		}
	);

	// Focus labels for form elements.
	jQuery( 'input, select, textarea' ).on( 'focus blur',
		function() {
			var focus_id   = jQuery( this ).attr( 'id' );

			if ( focus_id )
				jQuery( 'label[for="' + focus_id + '"]' ).toggleClass( 'focus' );
			else
				jQuery( this ).parents( 'label' ).toggleClass( 'focus' );
		}
	);

	// Add class to links with an image.
	jQuery( 'a' ).has( 'img' ).addClass( 'has-image' );
	jQuery( 'a' ).has( 'svg' ).addClass( 'has-svg' );

	// Custom-colored line-through.
	jQuery( 'del, strike, s' ).wrap( '<span class="line-through" />' );

	// Adds a class to the comments container if we have a nav (paginated comments).
	jQuery( '.comments-nav' ).parents( '#comments' ).addClass( 'has-comments-nav' );

	// Hide separator for no comments span.
	jQuery( 'span.comments-link' ).prev( '.sep' ).hide();

} );
