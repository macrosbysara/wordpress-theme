import path from 'path';
import { fileURLToPath } from 'url';
import config from '@wordpress/scripts/config/webpack.config.js';

const appNames = [];
const blockEditor = [ 'editDefaultBlocks' ];
const styleSheets = []; // for scss only

const __filename = fileURLToPath( import.meta.url );
const __dirname = path.dirname( __filename );

const configs = Array.isArray( config ) ? config : [ config ];

const addAlias = ( webpackConfig ) => ( {
	...webpackConfig,
	resolve: {
		...webpackConfig.resolve,
		alias: {
			...webpackConfig.resolve?.alias,
			'@styles': path.resolve( __dirname, './src/styles' ),
			'@shared': path.resolve( __dirname, './src/js/blocks/_shared' ),
		},
	},
} );

const addEditorEntry = ( webpackConfig ) => {
	const isModuleBuild = webpackConfig.output?.module;

	if ( isModuleBuild ) {
		return webpackConfig;
	}

	const originalEntry = webpackConfig.entry;

	return {
		...webpackConfig,
		entry: async () => {
			const entries =
				typeof originalEntry === 'function'
					? await originalEntry()
					: originalEntry;

			return {
				...entries,
				global: path.resolve( __dirname, `./src/index.ts` ),
				'admin/editor': path.resolve(
					__dirname,
					`./src/styles/editor.scss`
				),
				...addEntries( appNames, 'pages' ),
				...addEntries( styleSheets, 'styles' ),
				...addEntries( blockEditor, 'admin' ),
			};
		},
	};
};

export default configs.map( addAlias ).map( addEditorEntry );

/**
 * Helper function to add entries to the entries object. It takes an array of strings in either kebab-case or snake_case and returns an object with the key as the entry name and the value as the path to the entry file.
 * @param {Array}  array - Array of strings
 * @param {string} type  - The type of entry. Either 'pages' or 'styles'
 */
function addEntries( array, type ) {
	if ( ! Array.isArray( array ) ) {
		throw new Error( `Expecting an array, received ${ typeof array }!` );
	}
	if ( 0 >= array.length ) {
		return {};
	}
	const entries = {};
	const typeOutput = {
		styles: {
			outputDir: ( assetOutput ) => `pages/${ assetOutput }`,
			path: ( asset ) =>
				path.resolve( __dirname, `./src/styles/pages/${ asset }.scss` ),
		},
		pages: {
			outputDir: ( assetOutput ) => `pages/${ assetOutput }`,
			path: ( asset ) =>
				path.resolve( __dirname, `./src/js/${ asset }/index.ts` ),
		},
		admin: {
			outputDir: ( assetOutput ) => `admin/${ assetOutput }`,
			path: ( asset ) =>
				path.resolve( __dirname, `./src/js/gutenberg/${ asset }.ts` ),
		},
	};
	array.forEach( ( asset ) => {
		const assetOutput = snakeToCamel( asset );

		if ( Object.hasOwn( typeOutput, type ) ) {
			const output = typeOutput[ type ];
			entries[ output.outputDir( assetOutput ) ] = output.path( asset );
		} else {
			throw new Error(
				`Invalid type! Expected one of ${ Object.keys(
					typeOutput
				).join( ', ' ) }, received "${ type }"`
			);
		}
	} );
	return entries;
}

/**
 * A simple utility class to alter strings from kebab-case or snake_case to camelCase
 *
 * @param {string} str - The string to be converted
 */
function snakeToCamel( str ) {
	return str.replace( /([-_][a-z])/g, ( group ) =>
		group.toUpperCase().replace( '-', '' ).replace( '_', '' )
	);
}
