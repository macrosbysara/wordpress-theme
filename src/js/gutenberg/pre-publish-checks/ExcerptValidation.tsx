import { useSelect } from '@wordpress/data';
import { store as editorStore } from '@wordpress/editor';
import { Flex, FlexBlock, FlexItem, Notice } from '@wordpress/components';

export default function ExcerptValidation() {
	const postStatus = useSelect( ( select ) => {
		return select( editorStore ).getEditedPostAttribute( 'status' );
	}, [] );
	const excerpt = useSelect( ( select ) => {
		return select( editorStore ).getEditedPostAttribute( 'excerpt' );
	}, [] );
	const validation = validateExcerpt( postStatus, excerpt );

	return (
		<Flex>
			<Notice status={ validation.status } isDismissible={ false }>
				<p style={ { marginBottom: 0 } }>
					<strong>Excerpt:</strong> { validation.message }
				</p>
			</Notice>
		</Flex>
	);
}

type ValidationResult = {
	valid: boolean;
	message?: string;
	status: 'info' | 'error' | 'success' | 'warning';
};

function validateExcerpt( status: string, excerpt: string ): ValidationResult {
	const ignoredStatuses = [ 'auto-draft', 'pending', 'private' ];
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
