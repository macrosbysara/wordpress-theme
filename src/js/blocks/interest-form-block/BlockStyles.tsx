import { useSelect } from '@wordpress/data';
import { store as blockEditorStore, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ColorPalette, Panel, PanelHeader } from '@wordpress/components';

export default function BlockStyles( { attributes, setAttributes } ) {
	const { borderColor, buttonColor, buttonBackgroundColor } = attributes;
	const themeColors = useSelect(
		( select ) =>
			select( blockEditorStore ).getSettings().colors,
		[]
	);

	return ( <InspectorControls group="styles">
		<PanelBody title="Input Settings">
			<ColorPalette
				colors={ themeColors }
				value={ borderColor }
				onChange={ ( color ) =>
					setAttributes( { borderColor: color } )
				}
			/>
		</PanelBody>
		<PanelBody title="Button Settings">
			<ColorPalette
				colors={ themeColors }
				value={ buttonColor }
				onChange={ ( color ) =>
					setAttributes( { buttonColor: color } )
				}
			/>
		</PanelBody>
	</InspectorControls> );
}
