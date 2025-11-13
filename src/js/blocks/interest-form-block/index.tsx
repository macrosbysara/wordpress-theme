import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './Edit';
import metadata from './block.json';
import { selectOptions } from './consts';
import parseSpacing from './_lib/parseSpacing';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata.name, {
	/**
	 * @see ./edit.js
	 */
	edit: Edit,
	save: ( { attributes } ) => {
		const { style, borderRadius, borderColor, buttonColor, buttonBackgroundColor, buttonBorderColor } = attributes;
		const blockGap = parseSpacing( style?.spacing || {} );
		const blockProps = useBlockProps.save( {
			style: {
				'--gap': blockGap,
				'--border-radius': borderRadius,
				'--border-color': borderColor,
				'--button-color': buttonColor,
				'--button-background-color': buttonBackgroundColor,
				'--button-border-color': buttonBorderColor,
			},
			action: '/wp-json/mbs/v1/forms/interest-form',
			method: 'post',
		} );
		return (
			<form { ...blockProps }>
				<div className="col-md-6 form-floating mb-3">
					<input
						type="text"
						className="form-control"
						id="mbs-first-name"
						name="firstName"
						placeholder="First name"
						autoComplete="given-name"
					/>
					<label htmlFor="mbs-first-name">First name</label>
				</div>

				<div className="col-md-6 form-floating mb-3">
					<input
						type="text"
						className="form-control"
						id="mbs-last-name"
						name="lastName"
						placeholder="Last name"
						autoComplete="family-name"
					/>
					<label htmlFor="mbs-last-name">Last name</label>
				</div>

				<div className="col-12 form-floating mb-3">
					<input
						type="email"
						className="form-control"
						id="mbs-email"
						name="email"
						placeholder="name@example.com"
						autoComplete="email"
					/>
					<label htmlFor="mbs-email">Email address</label>
				</div>

				<div className="col-12 form-floating mb-3">
					<select
						className="form-select"
						id="mbs-interest"
						name="interest"
						aria-label="Interest"
					>
						{ selectOptions.map( ( option ) => (
							<option
								key={ option.value }
								value={ option.value }
							>
								{ option.name }
							</option>
						) ) }
					</select>
					<label htmlFor="mbs-interest">Interest</label>
				</div>
				<div className="col-12">
					<button type="submit" className="btn btn-primary">Submit</button>
				</div>
				<div className="col-12 response-area" />
				<div className="cf-turnstile" data-sitekey="0x4AAAAAACAcVKqyxt1TEIP2" data-appearance="interaction-only" />
			</form>
		);
	},
} );
