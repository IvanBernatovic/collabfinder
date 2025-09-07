<template>
  <div id="comments">
    <h2 class="text-xl font-semibold mb-6">
      Comments ({{ commentsCount }})
    </h2>

    <CommentForm :project-id="projectId" @comment-added="$emit('commentAdded')" />

    <div v-if="parentComments.length > 0">
      <CommentItem v-for="comment in parentComments" :key="comment.id" :comment="comment" :project-id="projectId"
        @deleted="handleCommentDeleted" @reply-added="$emit('commentAdded')" />
    </div>

    <div v-else class="text-center py-8 text-gray-500">
      <p>No comments yet. Be the first to share your thoughts!</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import CommentForm from './CommentForm.vue'
import CommentItem from './CommentItem.vue'

const props = defineProps({
  comments: {
    type: Array,
    required: true
  },
  commentsCount: {
    type: Number,
    required: true
  },
  projectId: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['commentAdded', 'commentDeleted'])

// Filter to only show parent comments (replies are shown within CommentItem)
const parentComments = computed(() => {
  return props.comments.filter(comment => !comment.parent_id)
})

const handleCommentDeleted = (commentId) => {
  emit('commentDeleted', commentId)
}
</script>
