import { useSelect } from '@wordpress/data';
import { store as blockEditorStore } from '@wordpress/block-editor';
import { useMemo, useState, useEffect } from '@wordpress/element';

export default function useColorPalettes() {
	const baseColors = useSelect(
		( select ) => select( blockEditorStore ).getSettings().colors,
		[]
	);

	const palette = useMemo( () => {
		const baseColorsPalette = {
			name: 'Theme Colors',
			colors: baseColors.map( ( { name, color } ) => ( {
				name,
				color,
			} ) ),
		};
		const palette = {
			baseColorsPalette,
		};
		return palette;
	}, [ baseColors ] );
	return palette;
}
