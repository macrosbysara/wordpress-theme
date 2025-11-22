import { select, dispatch, subscribe } from '@wordpress/data';
import { store as coreDataStore } from '@wordpress/core-data';
import { store as editorStore } from '@wordpress/editor';
import domReady from '@wordpress/dom-ready';

/**
 * Pre-publish validation system
 * Manages validation rules and enforces them before publishing
 */
class PrePublishValidation {
	private rules: Map< string, ValidationRule > = new Map();
	private namespace: string;
	private lockName: string;

	constructor( namespace: string ) {
		this.namespace = namespace;
		this.lockName = `${ namespace }/pre-publish-validation`;
		this.initialize();
	}

	/**
	 * Initialize the validation system by subscribing to editor changes
	 */
	private initialize(): void {
		// Subscribe to editor changes to validate on status changes
		let previousStatus = '';
		let previousExcerpt = '';

		subscribe( () => {
			const editorStore = select( 'core/editor' ) as any;
			if ( ! editorStore ) {
				return;
			}

			const currentStatus = editorStore.getEditedPostAttribute( 'status' );
			const currentExcerpt = editorStore.getEditedPostAttribute( 'excerpt' ) || '';

			// Check if status changed or excerpt changed
			if ( currentStatus !== previousStatus || currentExcerpt !== previousExcerpt ) {
				this.validateAndLock();
				previousStatus = currentStatus;
				previousExcerpt = currentExcerpt;
			}
		}, 'core/editor' );

		// Run initial validation
		setTimeout( () => this.validateAndLock(), 1000 );
	}

	/**
	 * Register a validation rule
	 * @param id         - Unique identifier for the rule
	 * @param validateFn - Function that validates the post
	 */
	public registerRule(
		id: string,
		validateFn: ( post: any ) => ValidationResult
	): void {
		this.rules.set( id, {
			id,
			validate: validateFn,
		} );
	}

	/**
	 * Validate and lock/unlock post saving based on validation result
	 */
	private validateAndLock(): void {
		const editorStore = select( 'core/editor' ) as any;
		const editorDispatch = dispatch( 'core/editor' ) as any;

		if ( ! editorStore || ! editorDispatch ) {
			return;
		}

		const currentStatus = editorStore.getEditedPostAttribute( 'status' );

		// Skip validation for non-publishing statuses
		if ( this.shouldSkipValidation( currentStatus ) ) {
			// Unlock if it was previously locked
			if ( editorDispatch.unlockPostSaving ) {
				editorDispatch.unlockPostSaving( this.lockName );
			}
			// Clear any previous errors
			this.clearError();
			return;
		}

		// Run validation
		const post = editorStore.getCurrentPost();
		let isValid = true;
		let errorMessage = '';

		for ( const rule of this.rules.values() ) {
			const result = rule.validate( post );
			if ( ! result.valid ) {
				isValid = false;
				errorMessage = result.message || 'Validation failed';
				break;
			}
		}

		if ( ! isValid ) {
			// Lock post saving
			if ( editorDispatch.lockPostSaving ) {
				editorDispatch.lockPostSaving( this.lockName );
			}
			this.showError( errorMessage );
		} else {
			// Unlock post saving
			if ( editorDispatch.unlockPostSaving ) {
				editorDispatch.unlockPostSaving( this.lockName );
			}
			this.clearError();
		}
	}

	/**
	 * Check if validation should be skipped based on post status
	 */
	private shouldSkipValidation( postStatus: string ): boolean {
		const allowedStatuses = [ 'draft', 'pending' ];
		return allowedStatuses.includes( postStatus );
	}

	/**
	 * Show error message in the editor
	 */
	private showError( message: string ): void {
		const noticesStore = dispatch( 'core/notices' ) as any;
		if ( noticesStore && noticesStore.createErrorNotice ) {
			// Remove previous notice first
			if ( noticesStore.removeNotice ) {
				noticesStore.removeNotice( 'pre-publish-validation-error' );
			}
			// Create new error notice
			noticesStore.createErrorNotice( message, {
				id: 'pre-publish-validation-error',
				isDismissible: true,
			} );
		}
	}

	/**
	 * Clear error message from the editor
	 */
	private clearError(): void {
		const noticesStore = dispatch( 'core/notices' ) as any;
		if ( noticesStore && noticesStore.removeNotice ) {
			noticesStore.removeNotice( 'pre-publish-validation-error' );
		}
	}
}

// Create a singleton instance
let validationInstance: PrePublishValidation | null = null;

/**
 * Initialize the pre-publish validation system
 */
function initPrePublishChecks(): void {
	if ( validationInstance ) {
		return;
	}

	const namespace = 'macrosbysara';
	validationInstance = new PrePublishValidation( namespace );

	// Register the excerpt length validation rule
	validationInstance.registerRule( 'excerptLength', ( post: any ) => {
		// Check if post type supports excerpts
		const coreStore = select( coreDataStore ) as any;
		if ( coreStore && coreStore.getPostType ) {
			const currentPostType = coreStore.getPostType( post.type );
			if (
				! currentPostType ||
				! currentPostType.supports ||
				! currentPostType.supports.excerpt
			) {
				// Skip validation if post type doesn't support excerpts
				return { valid: true };
			}
		}

		// Get the excerpt from the editor
		const editor = select( editorStore );
		const excerpt = editor
			? editor.getEditedPostAttribute( 'excerpt' )
			: post.excerpt?.raw || '';

		// Validate excerpt length
		const excerptLength = excerpt ? excerpt.trim().length : 0;

		if ( excerptLength === 0 ) {
			return {
				valid: false,
				message:
					'Please add an excerpt before publishing. Excerpt is required.',
			};
		}

		if ( excerptLength < 120 ) {
			return {
				valid: false,
				message: `Excerpt is too short (${ excerptLength } characters). It must be at least 120 characters.`,
			};
		}

		if ( excerptLength > 160 ) {
			return {
				valid: false,
				message: `Excerpt is too long (${ excerptLength } characters). It must be no more than 160 characters.`,
			};
		}

		return { valid: true };
	} );
}

/**
 * Export the registration function for extensibility
 */
export function registerPrePublishRule(
	id: string,
	validateFn: ( post: any ) => ValidationResult
): void {
	if ( ! validationInstance ) {
		throw new Error(
			'PrePublishValidation not initialized. Call initializePrePublishValidation first.'
		);
	}
	validationInstance.registerRule( id, validateFn );
}

domReady( () => {
	initPrePublishChecks();
} );
