import { useBlockProps, InspectorControls, HeightControl } from '@wordpress/block-editor';
import { Panel, PanelBody, SelectControl } from '@wordpress/components';
import Blob from '../_shared/Blob';

export default function Edit( { attributes, setAttributes } ) {
	const { blobType } = attributes;
	const color = `var(--wp--preset--color--${ attributes.textColor || 'primary' })`;
	const blockProps = useBlockProps( { style: {
		'--fill-color': color,
		height: attributes.height,
	} } );
	return <>
		<InspectorControls>
			<PanelBody title="Blob Color">
				<SelectControl
					label="Blob Shape"
					options={ [
						{ label: 'Blob 1', value: '1' },
						{ label: 'Blob 2', value: '2' },
						{ label: 'Blob 3', value: '3' },
						{ label: 'Blob 4', value: '4' },
						{ label: 'Blob 5', value: '5' },
					] }
					onChange={ ( value ) => setAttributes( { blobType: parseInt( value ) } ) }
				/>
			</PanelBody>
		</InspectorControls>
		<InspectorControls group="styles">
			<PanelBody title="Blob Dimensions">
				<HeightControl
					label="Blob Height"
					value={ attributes.height }
					onChange={ ( value ) => setAttributes( { height: value } ) }
				/>
			</PanelBody>
		</InspectorControls>

		<div { ...blockProps }>
			<Blob blobType={ blobType } />
		</div>
	</>;
}
