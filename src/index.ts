import './styles/main.scss';
/**
 * Create copyright text with a dynamic date and URL campaign builder for GA inside a div with the ID of 'copyright.'
 */
function myCopyright( brandName: string, builder: string, site: string ): void {
	const copyright = document.getElementById( 'copyright' );
	if ( ! copyright ) {
		return;
	}
	const thisYear = new Date().getFullYear();
	const builderLink = `<a href="https://${ site }" target ="_blank" style="text-decoration:underline;">${ builder }</a>`;
	copyright.innerHTML = `<p>&copy; ${ thisYear } ${ brandName } All Rights Reserved.<br/>Site built by ${ builderLink }</p>`;
	copyright.innerHTML = builderLink;
}
window.addEventListener( 'DOMContentLoaded', () => {
	myCopyright( 'Sara Roelke', 'K.J. Roelke', 'www.kjroelke.online' );
} );
