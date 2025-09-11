# Comments Component Architecture

This directory contains a refactored, modular comment system designed for better maintainability and reusability.

## Structure

### Components

- **`CommentList.vue`** - Main container component that displays the list of comments and handles the overall comment state
- **`CommentItem.vue`** - Displays individual comments with edit/delete functionality and manages replies
- **`CommentForm.vue`** - Reusable form component for creating new comments or replies
- **`ReplyItem.vue`** - Specialized component for displaying replies with nested reply support
- **`CommentActions.vue`** - Reusable component for edit/delete action buttons
- **`CommentEditForm.vue`** - Reusable form component for editing existing comments/replies

### Composables

- **`useCommentActions.js`** - Custom hook that provides comment management logic (CRUD operations, form handling, state management)

### Utilities

- **`utils.js`** - Utility functions for date formatting, filtering, and comment manipulation
- **`constants.js`** - Centralized constants for messages, configuration, and magic numbers

### Index

- **`index.js`** - Barrel export for clean imports

## Key Improvements

### 1. Separation of Concerns
- **UI Components**: Focus solely on rendering and user interaction
- **Business Logic**: Extracted into composables and utilities
- **Constants**: Centralized configuration and messages

### 2. Reusability
- `CommentActions` and `CommentEditForm` are shared between main comments and replies
- `useCommentActions` composable can be used in any component that needs comment functionality
- Utility functions can be reused across different parts of the application

### 3. Maintainability
- Single source of truth for messages and configuration
- Consistent patterns across all comment-related components
- Easy to modify behavior by updating composables/utilities

### 4. Type Safety & Error Handling
- Centralized error messages and success notifications
- Consistent form validation and processing states
- Proper prop definitions with required/optional specifications

## Usage

```javascript
// Import individual components
import { CommentList, CommentItem, CommentForm } from '@/Components/Comments'

// Import utilities and composables
import { useCommentActions, formatRelativeDate, COMMENT_MESSAGES } from '@/Components/Comments'

// Use in a component
<CommentList 
  :comments="comments" 
  :project-id="projectId" 
  :comments-count="commentsCount"
  @comment-added="handleCommentAdded"
  @comment-deleted="handleCommentDeleted" 
/>
```

## Configuration

Update `constants.js` to modify:
- Character limits
- Toast messages
- Default form configurations
- UI text and labels

## Extension Points

The architecture makes it easy to:
- Add new comment types (e.g., private comments, admin notes)
- Implement different permission levels
- Add rich text editing capabilities
- Integrate with different backend APIs
- Add real-time updates via WebSockets
