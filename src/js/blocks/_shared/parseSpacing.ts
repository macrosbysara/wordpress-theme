const spacingSizes = {
	'var:preset|spacing|none': 0,
	'var:preset|spacing|xs': '.25rem',
	'var:preset|spacing|sm': '.5rem',
	'var:preset|spacing|base': '1rem',
	'var:preset|spacing|lg': '1.5rem',
	'var:preset|spacing|xl': '3rem',
};

/**
 * Parses the spacing blockGap attribute and returns corresponding value.
 * @param spacing props.attributes.spacing object
 */
export default function parseSpacing( spacing: { [ key: string ]: string } ):string {
	const blockGap = spacing.blockGap;
	const defaultSpacing = 'var:preset|spacing|base';
	if ( blockGap && spacingSizes[ blockGap ] !== undefined ) {
		return spacingSizes[ blockGap ];
	}
	return spacingSizes[ defaultSpacing ];
}
