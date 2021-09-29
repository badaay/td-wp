( function( $ ) {
	$( document ).on( "click touchstart",  '.cptchpls_reload_button, .wpcf7-submit', function() {
		cptchpls_reload( $( this ) );
	}).on( "touchstart", function( event ) {
		if ( cptchpls_vars.enlarge == '1' ) {
			var element = $( event.target );
			if ( element.hasClass( 'cptchpls_img' ) ) {
				event.preventDefault();
				element.toggleClass( 'cptchpls_reduce' );
				$( '.cptchpls_img' ).not( element ).removeClass( 'cptchpls_reduce' );
			} else {
				$( '.cptchpls_img' ).removeClass( 'cptchpls_reduce' );
			}
		}
	});
})(jQuery);

/**
 * Reload captcha
 */
function cptchpls_reload( object, event ) {
	(function($) {
		var captcha = object.hasClass( '.cptchpls_reload_button' ) ? object.parent().parent( '.cptchpls_wrap' ) : object.closest( 'form' ).find( '.cptchpls_wrap' );
		if ( captcha.length ) {
			captcha.find( '.cptchpls_reload_button' ).addClass( 'cptchpls_active' );
			var captcha_block = captcha.parent(),
				input         = captcha.find( 'input:text' ),
				input_name    = input.attr( 'name' ),
				input_class   = input.attr( 'class' ).replace( /cptchpls_input/, '' ).replace( /^\s+|\s+$/g, '' ),
				form_slug     = captcha_block.find( 'input[name="cptchpls_form"]' ).val(); 
			$.ajax({
				type: 'POST',
				url: cptchpls_vars.ajaxurl,
				data: {
					action:              'cptchpls_reload',
					cptchpls_nonce:       cptchpls_vars.nonce,
					cptchpls_input_name:  input_name,
					cptchpls_input_class: input_class,
					cptchpls_form_slug:   form_slug
				},
				success: function( result ) {
					captcha_block.find( 'input[type="hidden"], .cptchpls_reload_button_wrap, .cptchpls_reload_button' ).remove();
					if ( input_class === '' )
						captcha.replaceWith( result ); /* for default forms */
					else 
						captcha_block.replaceWith( result ); /* for custom forms */
				},
				error : function ( xhr, ajaxOptions, thrownError ) {
					alert( xhr.status );
					alert( thrownError );
				}
			});
		}
	})(jQuery);
}