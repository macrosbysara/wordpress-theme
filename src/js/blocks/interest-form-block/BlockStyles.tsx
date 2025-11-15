import { useSelect } from '@wordpress/data';
import { store as blockEditorStore, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ColorPalette, BorderControl, Flex, FlexBlock } from '@wordpress/components';

export default function BlockStyles( { attributes, setAttributes } ) {
	const { inputBorder, buttonColor, buttonBackgroundColor, buttonBorder } = attributes;
	const themeColors = useSelect(
		( select ) =>
			select( blockEditorStore ).getSettings().colors,
		[]
	);

	return ( <InspectorControls group="styles">
		<PanelBody title="Input Styles">
			<Flex direction="column" gap={ 6 }>
				<FlexBlock>
					<BorderControl
						__next40pxDefaultSize
						colors={ themeColors }
						label={ 'Input Border' }
						enableStyle={ false }
						max={ 5 }
						onChange={ ( inputBorder ) =>
							setAttributes( { inputBorder } )
						}
						value={ inputBorder }
					/>
				</FlexBlock>
			</Flex>
		</PanelBody>
		<PanelBody title="Button Styles">
			<Flex direction="column" gap={ 4 }>
				<FlexBlock>
					<p>Button Color</p>
					<ColorPalette
						colors={ themeColors }
						value={ buttonColor }
						onChange={ ( color ) =>
							setAttributes( { buttonColor: color } )
						}
					/>
				</FlexBlock>
				<FlexBlock>
					<p>Button Background Color</p>
					<ColorPalette
						colors={ themeColors }
						value={ buttonBackgroundColor }
						onChange={ ( color ) =>
							setAttributes( { buttonBackgroundColor: color } )
						}
					/>
				</FlexBlock>
				<FlexBlock>
					<BorderControl
						__next40pxDefaultSize
						colors={ themeColors }
						label={ 'Button Border' }
						enableStyle={ false }
						max={ 5 }
						onChange={ ( buttonBorder ) =>
							setAttributes( { buttonBorder } )
						}
						value={ buttonBorder }
					/>
				</FlexBlock>
			</Flex>

		</PanelBody>

	</InspectorControls> );
}
