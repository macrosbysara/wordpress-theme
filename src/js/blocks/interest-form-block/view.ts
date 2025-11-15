
const forms = document.querySelectorAll<HTMLFormElement>( '.wp-block-mbs-interest-form' );
if ( forms.length ) {
	forms.forEach( ( form ) => {
		form.addEventListener( 'submit', async ( event ) => {
			event.preventDefault();
			const formData = new FormData( form );
			const responseArea = form.querySelector<HTMLDivElement>( '.response-area' );

			try {
				setIsLoading( true, form );
				const headers = {
					'X-WP-Nonce': window.mbsRestApi.nonce,
				};
				const response = await fetch( `${ window.mbsRestApi.root }/forms/interest-form`, {
					method: form.method,
					headers,
					body: formData,
				} );

				if ( response.ok ) {
					const responseData = await response.json();
					const responseArea = form.querySelector<HTMLDivElement>( '.response-area' );
					if ( responseArea ) {
						responseArea.innerHTML = ``;
						responseArea.innerHTML = `<p class="response-${ responseData.data.status === 200 ? 'success' : 'error' }">${ responseData.message }</p>`;
					}
					// form.reset();
				} else if ( responseArea ) {
					responseArea.innerHTML = ``;
					responseArea.innerHTML = '<p class="response-error">There was an error submitting the form. Please try again later.</p>';
				} else {
					// eslint-disable-next-line no-alert
					alert( 'There was an error submitting the form. Please try again later.' );
				}
			} catch ( error ) {
				// eslint-disable-next-line no-alert
				alert( 'There was an error submitting the form. Please try again later.' );
			} finally {
				setIsLoading( false, form );
			}
		} );
	} );
}

/**
 * Enable or disable form controls during loading state
 * @param isLoading loading state
 * @param form      the form
 */
function setIsLoading( isLoading: boolean, form:HTMLFormElement ) {
	const controls = form.querySelectorAll<HTMLInputElement | HTMLSelectElement | HTMLButtonElement>(
		'input, select, button'
	);
	controls.forEach( ( control ) => {
		( control as HTMLInputElement | HTMLSelectElement | HTMLButtonElement ).disabled = isLoading;
	} );
}
