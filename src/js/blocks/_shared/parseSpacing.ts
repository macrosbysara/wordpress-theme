/**
 * Parses the spacing blockGap attribute and returns corresponding value.
 * @param spacing props.attributes.spacing object
 */
export default function parseSpacing( spacing: {
	[ key: string ]: string;
} ): string {
	const blockGap = spacing.blockGap;
	const spacingString = blockGap
		.slice( blockGap.indexOf( ':' ) + 1 )
		.replaceAll( '|', '--' );
	const fullSpacingString = `var(--wp--${ spacingString })`;
	return fullSpacingString;
}
