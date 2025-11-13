import { useBlockProps } from '@wordpress/block-editor';
import { Fragment } from '@wordpress/element';

import { selectOptions } from './consts';
import './editor.scss';
import BlockStyles from './BlockStyles';
import parseSpacing from './_lib/parseSpacing';

export default function Edit( props ) {
	const { style, borderRadius, borderColor, buttonColor, buttonBackgroundColor, buttonBorderColor } = props.attributes;
	const blockGap = parseSpacing( style?.spacing || {} );
	const blockProps = useBlockProps( {
		disabled: true,
		style: {
			'--gap': blockGap,
			'--border-radius': borderRadius,
			'--border-color': borderColor,
			'--button-color': buttonColor,
			'--button-background-color': buttonBackgroundColor,
			'--button-border-color': buttonBorderColor,
		},
	} );
	return (
		<Fragment>
			<BlockStyles { ...props } />
			<form { ...blockProps }>
				<div className="col-md-6 form-floating">
					<input
						type="text"
						className="form-control"
						id="mbs-first-name"
						name="firstName"
						placeholder="First name"
						autoComplete="given-name"
						disabled={ true }
					/>
					<label htmlFor="mbs-first-name">First name</label>
				</div>

				<div className="col-md-6 form-floating">
					<input
						disabled={ true }
						type="text"
						className="form-control"
						id="mbs-last-name"
						name="lastName"
						placeholder="Last name"
						autoComplete="family-name"
					/>
					<label htmlFor="mbs-last-name">Last name</label>
				</div>

				<div className="col-12 form-floating">
					<input
						disabled={ true }
						type="email"
						className="form-control"
						id="mbs-email"
						name="email"
						placeholder="name@example.com"
						autoComplete="email"
					/>
					<label htmlFor="mbs-email">Email address</label>
				</div>

				<div className="col-12 form-floating">
					<select
						disabled={ true }
						className="form-select"
						id="mbs-interest"
						name="interest"
						aria-label="Interest"
						autoComplete="section-interest"
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
					<button type="submit" disabled={ true } className="btn btn-primary">Submit</button>
				</div>
			</form>
		</Fragment>
	);
}
