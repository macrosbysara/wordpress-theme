import { useSelect } from '@wordpress/data';
import { store as editorStore } from '@wordpress/editor';
import { Flex, FlexItem } from '@wordpress/components';
import { check, caution, error, info } from '@wordpress/icons';
import { createElement } from '@wordpress/element';

export default function ExcerptValidation() {
	const postStatus = useSelect( ( select ) => {
		return select( editorStore ).getEditedPostAttribute( 'status' );
	}, [] );
	const excerpt = useSelect( ( select ) => {
		return select( editorStore ).getEditedPostAttribute( 'excerpt' );
	}, [] );
	const validation = validateExcerpt( postStatus, excerpt );
	const IconComponent = getValidationIcon( validation.status );
	console.log( IconComponent );
	return (
		<Flex>
			<FlexItem>{ createElement( IconComponent ) }</FlexItem>
			<FlexItem>
				<p>Excerpt: { validation.message }</p>
			</FlexItem>
		</Flex>
	);
}

type ValidationResult = {
	valid: boolean;
	message?: string;
	status: 'info' | 'error' | 'success' | 'warning';
};

function validateExcerpt( status: string, excerpt: string ): ValidationResult {
	const ignoredStatuses = [ 'draft', 'auto-draft', 'pending', 'private' ];
	if ( ignoredStatuses.includes( status ) ) {
		return {
			status: 'info',
			valid: true,
			message: 'Post Status allows empty excerpt',
		};
	}
	if ( excerpt.trim().length < 120 ) {
		return {
			status: 'error',
			valid: false,
			message: 'Excerpt is too short. Minimum length is 120 characters.',
		};
	}
	if ( excerpt.trim().length > 160 ) {
		return {
			status: 'error',
			valid: false,
			message: 'Excerpt is too long. Maximum length is 160 characters.',
		};
	}
	return {
		status: 'success',
		valid: true,
		message: 'Excerpt length is between 120 and 160 characters.',
	};
}

function getValidationIcon( status: ValidationResult[ 'status' ] ) {
	const icons = {
		info,
		error,
		success: check,
		warning: caution,
	};
	if ( ! icons[ status ] ) {
		return null;
	}
	return icons[ status ];
}
