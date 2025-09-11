import dayjs from '@/dayjs'

/**
 * Formats a date relative to now (e.g., "2 hours ago")
 */
export function formatRelativeDate(date) {
  return dayjs(date).fromNow()
}

/**
 * Filters comments to only return parent comments (no replies)
 */
export function filterParentComments(comments) {
  return comments.filter(comment => !comment.parent_id)
}

/**
 * Counts total comments including replies
 */
export function countTotalComments(comments) {
  return comments.reduce((total, comment) => {
    return total + 1 + (comment.replies ? comment.replies.length : 0)
  }, 0)
}

/**
 * Finds a comment by ID in a nested structure
 */
export function findCommentById(comments, commentId) {
  for (const comment of comments) {
    if (comment.id === commentId) {
      return comment
    }
    if (comment.replies) {
      const found = findCommentById(comment.replies, commentId)
      if (found) return found
    }
  }
  return null
}

/**
 * Removes a comment from the comments array by ID
 */
export function removeCommentById(comments, commentId) {
  return comments.filter(comment => {
    if (comment.id === commentId) {
      return false
    }
    if (comment.replies) {
      comment.replies = removeCommentById(comment.replies, commentId)
    }
    return true
  })
}
