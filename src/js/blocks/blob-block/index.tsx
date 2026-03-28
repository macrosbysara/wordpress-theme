import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import './style.scss';
import block from './block.json';
import Edit from './edit';
import Blob from '../_shared/Blob';

registerBlockType( block.name, {
	edit: Edit,
	save: ( { attributes } ) => {
		const { blobType } = attributes;
		const color = `var(--wp--preset--color--${ attributes.textColor || 'primary' })`;
		const blockProps = useBlockProps.save( { style: {
			'--fill-color': color,
			height: attributes.height,
		} } );
		return <div { ...blockProps }><Blob blobType={ blobType } /></div>;
	},
	icon: <svg className="mbs-blob-3" viewBox="0 0 247 427" fill="none"
		xmlns="http://www.w3.org/2000/svg">
		<g clipPath="url(#clip0_3_10)">
			<path fillRule="evenodd" clipRule="evenodd" d="M246.525 273.062C246.136 268.067 245.503 263.034 244.625 257.971C239.213 226.831 222.387 199.416 209.736 170.916C203.259 156.32 197.589 141.195 195.232 125.328C192.741 108.57 195.247 91.5725 191.887 74.8672C189.639 63.6978 186.445 52.7738 181.215 42.6352C160.813 3.09918 108.119 -11.0315 69.0428 9.12982C57.6442 15.0098 42.8819 24.8885 35.0486 35.1711C3.3631 76.7791 22.2954 129.174 33.1043 174.615C38.0011 195.192 44.3448 220.143 39.2563 241.154C28.0402 287.452 -20.9754 331.193 10.2543 381.771C31.8559 416.76 81.3628 430.094 120.02 425.914C154.692 422.167 183.049 410.731 206.963 385.018C236.14 353.641 249.769 314.643 246.525 273.062Z" fill="#214F4C" />
		</g>
		<defs>
			<clipPath id="clip0_3_10">
				<rect width="246.994" height="426.655" fill="white" />
			</clipPath>
		</defs>
	</svg>,
} );
