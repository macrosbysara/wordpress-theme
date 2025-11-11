import { useSelect } from '@wordpress/data';
import { store as blockEditorStore, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function BlockSettings( { attributes, setAttributes } ) {
	return <InspectorControls>
		<PanelBody title="Border Settings" initialOpen={ true }>
			<TextControl
				label="Border Radius (e.g., 10px, 1rem)"
				value={ attributes.borderRadius }
				onChange={ ( value ) =>
					setAttributes( { borderRadius: value } )
				}
			/>
		</PanelBody>
	</InspectorControls>;
}
