import { registerPlugin } from '@wordpress/plugins';
import RenderSidebar from './pre-publish-checks/RenderSidebar';
import { postList } from '@wordpress/icons';
// import './pre-publish-checks/requireExcerpt';

registerPlugin( 'my-custom-doc-panel', {
	icon: postList,
	render: RenderSidebar,
} );
