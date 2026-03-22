import { useBlockProps, useInnerBlocksProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import Blob from '../_shared/Blob';

export default function Edit( { attributes, setAttributes } ) {
	const { blobType } = attributes;
	const color = attributes.fillColor;
	const blockProps = useBlockProps( { style: {
		'--fill-color': color,
	} } );
	const innerBlocksProps = useInnerBlocksProps( { className: 'blob-inner' }, { template: [
		[
			'core/heading',
			{
				level: 2,
				placeholder: 'Add heading…',
				textAlign: 'center',
			},
		],
		[
			'core/paragraph',
			{
				placeholder: 'Add content…',
				align: 'center',
			},
		],
	] } );
	return <>
		<InspectorControls>
			<PanelBody title="Blob Settings">
				<SelectControl
					__next40pxDefaultSize
					__nextHasNoMarginBottom
					label="Blob Shape"
					options={ [
						{ label: 'Blob 1', value: '1' },
						{ label: 'Blob 2', value: '2' },
						{ label: 'Blob 3', value: '3' },
						{ label: 'Blob 4', value: '4' },
						{ label: 'Blob 5', value: '5' },
					] }
					value={ String( blobType ) }
					onChange={ ( value ) => setAttributes( { blobType: parseInt( value ) } ) }
				/>
			</PanelBody>
		</InspectorControls>

		<div { ...blockProps }>
			<div { ...innerBlocksProps } />
		</div>
	</>;
}
