/**
 * Type definition for a validation rule
 */
type ValidationRule = {
    /**
     * Unique identifier for the rule
     */
    id: string;
    /**
     * Function that validates the post
     * @param post - The post object from the editor store
     * @return Validation result with valid flag and optional message
     */
    validate: ( post: any ) => ValidationResult;
};

/**
 * Type definition for validation result
 */
type ValidationResult = {
    /**
     * Whether the validation passed
     */
    valid: boolean;
    /**
     * Optional error message to display if validation failed
     */
    message?: string;
};
