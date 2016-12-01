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

	// Menu focus.
	jQuery( '.menu li a' ).on( 'focus blur',
		function() {
			jQuery( this ).parents().toggleClass( 'focus' );
		}
	);

	jQuery( '.menu li' ).on( 'hover', function() {
		jQuery( this ).toggleClass( 'focus' );
	} );

	//
	jQuery( '.news-tabs .news-tabs-content' ).hide();
	jQuery( '.news-tabs .news-tabs-content:first-child' ).show();
	jQuery( '.news-tabs-nav :first-child' ).attr( 'aria-selected', 'true' );

	jQuery( '.news-tabs-nav li a' ).click(
		function( j ) {
			j.preventDefault();

			var href = jQuery( this ).attr( 'href' );

			jQuery( this ).parents( '.news-tabs' ).find( '.news-tabs-content' ).hide();

			jQuery( this ).parents( '.news-tabs' ).find( href ).show();

			jQuery( this ).parents( '.news-tabs' ).find( '.news-tabs-title' ).attr( 'aria-selected', 'false' );

			jQuery( this ).parent().attr( 'aria-selected', 'true' );
		}
	);

} );
