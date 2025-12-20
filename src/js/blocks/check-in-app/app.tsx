import { createRoot } from '@wordpress/element';
import CheckInApp from './app/App';
const rootElement = document.getElementById( 'root' );
if ( rootElement ) {
	const root = createRoot( rootElement );
	root.render( <CheckInApp /> );
}
