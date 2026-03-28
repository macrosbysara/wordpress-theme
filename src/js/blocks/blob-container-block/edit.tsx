import { useBlockProps, useInnerBlocksProps, InspectorControls, store as blockEditorStore, ColorPaletteControl, SpacingSizesControl } from '@wordpress/block-editor';
import { useEffect } from '@wordpress/element';
import { PanelBody, SelectControl } from '@wordpress/components';
import { blobs, BlobKey } from '../_shared/blobs';
import { useSelect } from '@wordpress/data';

export default function Edit( props ) {
	const { attributes, setAttributes, clientId: id } = props;
	const { blobType, blockId, fillColor } = attributes;

	useEffect( () => {
		if ( ! blockId ) {
			setAttributes( { blockId: id } );
		}
	}, [ id, setAttributes, blockId ] );
	const clipId = `blob-${ blockId }`;
	const path = blobs[ blobType as BlobKey ].path;
	const blockProps = useBlockProps();
	const innerBlocksProps = useInnerBlocksProps(
		{
			className: 'wp-block-mbs-blob-container-block__blob-inner',
			style: { backgroundColor: fillColor },
		}, { template: [
			[
				'core/paragraph',
				{
					placeholder: 'Add content…',
					align: 'center',
				},
			],
		] } );
	const themeColors = useSelect(
		( select ) =>
			select( blockEditorStore ).getSettings().colors,
		[]
	);
	return <>
		<InspectorControls group="styles">
			<PanelBody title="Blob Settings">
				<SelectControl
					__next40pxDefaultSize
					__nextHasNoMarginBottom
					label="Blob Shape"
					options={ [
						{ label: 'Blob 1', value: 'blob-1' },
						{ label: 'Blob 2', value: 'blob-2' },
						{ label: 'Blob 3', value: 'blob-3' },
						{ label: 'Blob 4', value: 'blob-4' },
						{ label: 'Blob 5', value: 'blob-5' },
					] as { label: string, value: BlobKey }[] }
					value={ blobType }
					onChange={ ( value: BlobKey ) => setAttributes( { blobType: value } ) }
				/>
				<ColorPaletteControl
					label="Blob Fill Color"
					colors={ themeColors }
					value={ fillColor }
					onChange={ ( color ) =>
						setAttributes( { fillColor: color } )
					}
				/>
			</PanelBody>
		</InspectorControls>

		<div { ...blockProps }>
			<svg width="0" height="0" aria-hidden="true" focusable="false">
				<defs>
					<clipPath id={ clipId } clipPathUnits="objectBoundingBox">
						<path d={ path } />
					</clipPath>
				</defs>
			</svg>
			<div className="wp-block-mbs-blob-container-block__clip" style={ { clipPath: `url(#${ clipId })`, aspectRatio: blobs[ blobType ].aspectRatio } }>
				<div { ...innerBlocksProps } />
			</div>
		</div>
	</>;
}
