import './style.scss';
import { registerBlock } from '@wordpress/blocks';
import Edit from './edit';
import save from './save';
import icon from './blobs/blob-1.svg';

registerBlock( 'mbs/blob', {
	edit: Edit,
	save,
	icon,
} );
