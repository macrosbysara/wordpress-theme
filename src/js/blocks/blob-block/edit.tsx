import { useBlockProps } from '@wordpress/block-editor';
import blob1 from './blobs/blob-1.svg';
import blob2 from './blobs/blob-2.svg';
import blob3 from './blobs/blob-3.svg';
import blob4 from './blobs/blob-4.svg';
import blob5 from './blobs/blob-5.svg';
export default function Edit( props ) {
	const blockProps = useBlockProps();
	return <div { ...blockProps }></div>;
}
