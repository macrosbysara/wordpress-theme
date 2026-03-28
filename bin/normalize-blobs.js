#!/usr/bin/env ts-node

import fs from 'fs';
import path from 'path';
import { XMLParser } from 'fast-xml-parser';
import { SVGPathData, SVGPathDataTransformer } from 'svg-pathdata';

function parseViewBox( viewBox ) {
	const [ minX, minY, width, height ] = viewBox
		.split( /\s+|,/ )
		.map( Number );

	return { minX, minY, width, height };
}

function normalizePath( d, viewBox ) {
	const { minX, minY, width, height } = viewBox;

	const transformed = new SVGPathData( d )
		.toAbs()
		.transform( SVGPathDataTransformer.NORMALIZE_HVZ() )
		 .transform( ( cmd ) => {
			if ( 'x' in cmd ) {
				cmd.x = ( cmd.x - minX ) / width;
			}
			if ( 'y' in cmd ) {
				cmd.y = ( cmd.y - minY ) / height;
			}

			if ( 'x1' in cmd ) {
				cmd.x1 = ( cmd.x1 - minX ) / width;
			}
			if ( 'y1' in cmd ) {
				cmd.y1 = ( cmd.y1 - minY ) / height;
			}

			if ( 'x2' in cmd ) {
				cmd.x2 = ( cmd.x2 - minX ) / width;
			}
			if ( 'y2' in cmd ) {
				cmd.y2 = ( cmd.y2 - minY ) / height;
			}

			return cmd;
		} );

	return transformed.encode();
}

function extractPathData( svgContent ) {
	const parser = new XMLParser( {
		ignoreAttributes: false,
		attributeNamePrefix: '',
	} );

	const parsed = parser.parse( svgContent );

	const svg = parsed.svg;

	if ( ! svg.viewBox ) {
		throw new Error( 'SVG missing viewBox' );
	}

	// Support single or multiple paths (take first)
	const pathNode = Array.isArray( svg.path )
		? svg.path[ 0 ]
		: svg.path;

	if ( ! pathNode?.d ) {
		throw new Error( 'No <path d="..."> found' );
	}

	return {
		d: pathNode.d,
		viewBox: svg.viewBox,
	};
}

function processFile( filePath ) {
	const content = fs.readFileSync( filePath, 'utf-8' );
	const { d, viewBox } = extractPathData( content );

	const normalized = normalizePath( d, parseViewBox( viewBox ) );

	const name = path.basename( filePath, '.svg' );

	return { name, path: normalized };
}

function run() {
	const inputDir = process.argv[ 2 ];

	if ( ! inputDir ) {
		console.error( 'Usage: normalize-blobs <folder>' );
		process.exit( 1 );
	}

	const files = fs
		.readdirSync( inputDir )
		.filter( ( f ) => f.endsWith( '.svg' ) );

	const results = files.map( ( file ) =>
		processFile( path.join( inputDir, file ) )
	);

	const output = `export const blobs = ${ JSON.stringify(
		Object.fromEntries( results.map( ( r ) => [ r.name, r.path ] ) ),
		null,
		2
	) } as const;\n`;

	fs.writeFileSync( 'blobs.ts', output );

	console.log( 'Generated blobs.ts' );
}

run();
