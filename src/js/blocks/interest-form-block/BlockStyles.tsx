import { useSelect } from '@wordpress/data';
import { store as blockEditorStore, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ColorPalette, BorderControl } from '@wordpress/components';

export default function BlockStyles( { attributes, setAttributes } ) {
	const { borderColor, buttonColor, buttonBackgroundColor, buttonBorderColor } = attributes;
	const themeColors = useSelect(
		( select ) =>
			select( blockEditorStore ).getSettings().colors,
		[]
	);

	return ( <InspectorControls group="styles">
		<PanelBody title="Input Border">
			<BorderControl
				__next40pxDefaultSize
				colors={ themeColors }
				label={ 'Border' }
				onChange={ ( color ) =>
					setAttributes( { borderColor: color } )
				}
				value={ borderColor }
			/>
		</PanelBody>
		<PanelBody title="Button Color" initialOpen={ false }>
			<ColorPalette
				colors={ themeColors }
				value={ buttonColor }
				onChange={ ( color ) =>
					setAttributes( { buttonColor: color } )
				}
			/>
		</PanelBody>
		<PanelBody title="Button Background Color" initialOpen={ false }>
			<ColorPalette
				colors={ themeColors }
				value={ buttonBackgroundColor }
				onChange={ ( color ) =>
					setAttributes( { buttonBackgroundColor: color } )
				}
			/>
		</PanelBody>
		<PanelBody title="Button Border" initialOpen={ false }>
			<BorderControl
				__next40pxDefaultSize
				colors={ themeColors }
				label={ 'Button Border' }
				onChange={ ( color ) =>
					setAttributes( { buttonBorderColor: color } )
				}
				value={ buttonBorderColor }
			/>
		</PanelBody>
	</InspectorControls> );
}
