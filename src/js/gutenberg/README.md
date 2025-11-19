# Pre-Publish Validation System

## Overview

The pre-publish validation system prevents publishing posts when editorial rules are not met. It uses WordPress's post locking mechanism to block publishing and displays clear error messages to users.

## Current Rules

### Excerpt Length Validation

Posts with excerpt support must have an excerpt that:
- Is not empty
- Is at least 120 characters
- Is no more than 160 characters

This validation only applies when:
- The post type supports excerpts
- The post is being transitioned to a publishing status (not draft or pending)

## Adding New Validation Rules

To add new validation rules, you can use the `registerPrePublishRule` function:

```typescript
import { registerPrePublishRule } from './prePublishValidation';

// Register a new rule
registerPrePublishRule('myCustomRule', (post) => {
  // Your validation logic here
  if (/* validation fails */) {
    return {
      valid: false,
      message: 'Your error message here'
    };
  }
  
  return { valid: true };
});
```

### Example: Require Featured Image

```typescript
import { registerPrePublishRule } from './prePublishValidation';
import { select } from '@wordpress/data';

registerPrePublishRule('featuredImage', (post) => {
  const editorStore = select('core/editor');
  const featuredImageId = editorStore.getEditedPostAttribute('featured_media');
  
  if (!featuredImageId) {
    return {
      valid: false,
      message: 'Please set a featured image before publishing.'
    };
  }
  
  return { valid: true };
});
```

### Example: Require Category (Not Uncategorized)

```typescript
import { registerPrePublishRule } from './prePublishValidation';
import { select } from '@wordpress/data';

registerPrePublishRule('requiredCategory', (post) => {
  const editorStore = select('core/editor');
  const categories = editorStore.getEditedPostAttribute('categories') || [];
  
  // Get the Uncategorized category ID (usually 1)
  const uncategorizedId = 1;
  
  if (categories.length === 0 || (categories.length === 1 && categories[0] === uncategorizedId)) {
    return {
      valid: false,
      message: 'Please select at least one category other than "Uncategorized" before publishing.'
    };
  }
  
  return { valid: true };
});
```

## Technical Details

### How It Works

1. **Subscription**: The system subscribes to the WordPress editor store to detect changes
2. **Validation**: When status or content changes, all registered rules are evaluated
3. **Locking**: If any rule fails, `lockPostSaving()` is called to prevent publishing
4. **Notices**: Error messages are displayed via the WordPress notices system
5. **Unlocking**: When all rules pass, `unlockPostSaving()` is called to allow publishing

### Status Handling

Validation is skipped for these post statuses:
- `draft` - Allows saving drafts without validation
- `pending` - Allows pending review without validation

All other status transitions (e.g., to `publish`, `future`) are validated.

### Post Type Support

Rules can check if a post type supports specific features:

```typescript
const coreStore = select('core');
const postType = coreStore.getPostType(post.type);

if (postType?.supports?.excerpt) {
  // Post type supports excerpts
}
```

## Files

- `prePublishValidation.ts` - Main validation system implementation
- Registered in: `webpack.config.cjs` (build configuration)
- Enqueued in: `inc/theme/class-gutenberg-handler.php` (WordPress integration)
