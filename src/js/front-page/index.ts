document.addEventListener( 'wpcf7submit', function( event ) {
	const form = event.target;
	const location = form.closest( '.x-form-integration' )?.getAttribute( 'data-form-location' ) || 'unknown';
	const formId = form.closest( '[data-wpcf7-id]' )?.getAttribute( 'data-wpcf7-id' ) || null;

	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push( {
		event: 'cf7_form_submit',
		formLocation: `home-${ location }`,
		formId,
	} );
}, false );
