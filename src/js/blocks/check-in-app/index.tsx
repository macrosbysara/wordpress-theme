import { registerBlockType } from '@wordpress/blocks';

import './style.scss';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: () => <p>The App. Nothing to see here.</p>,
	save: () => <div id="root" />,
} );
