<template>
  <div class="py-4 mb-4 border-b last:border-b-0 border-gray-300 dark:border-gray-500">
    <div class="flex justify-between items-start mb-2">
      <div class="flex items-center">
        <img :src="comment.user.profile_photo_url" :alt="comment.user.name" class="size-8 rounded-full mr-3" />
        <div>
          <h4 class="font-semibold text-sm">{{ comment.user.name }}</h4>
          <p class="text-xs text-gray-500 dark:text-white">{{ formattedDate }}</p>
        </div>
      </div>

      <CommentActions :user-id="comment.user.id" @edit="startEdit" @delete="handleDelete" />
    </div>

    <div v-if="!isEditing">
      <p class="text-gray-800 dark:text-gray-100">{{ comment.content }}</p>

      <!-- Action buttons -->
      <div class="flex gap-2 mt-3">
        <button @click="toggleReply"
          class="text-blue-500 dark:text-blue-300 hover:text-blue-700 hover:dark:text-blue-500 text-xs font-medium">
          {{ showReplyForm ? 'Cancel Reply' : 'Reply' }}
        </button>
        <span v-if="comment.replies && comment.replies.length > 0" class="text-xs text-gray-500">
          {{ comment.replies.length }} {{ comment.replies.length === 1 ? 'reply' : 'replies' }}
        </span>
      </div>
    </div>

    <CommentEditForm v-else :content="editContent" :processing="editForm.processing" @submit="handleUpdate"
      @cancel="cancelEdit" @update:content="editContent = $event" />

    <!-- Reply form -->
    <div v-if="showReplyForm" class="mt-4">
      <CommentForm :project-id="projectId" :parent-id="comment.id" @comment-added="handleReplyAdded"
        @cancel="cancelReply" />
    </div>

    <!-- Replies -->
    <div v-if="comment.replies && comment.replies.length > 0" class="mt-4 ml-6 space-y-3">
      <ReplyItem v-for="reply in comment.replies" :key="reply.id" :reply="reply" :project-id="projectId"
        @reply-added="handleReplyAdded" />
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import CommentForm from './CommentForm.vue'
import CommentActions from './CommentActions.vue'
import CommentEditForm from './CommentEditForm.vue'
import ReplyItem from './ReplyItem.vue'
import { useCommentActions } from './useCommentActions'
import { formatRelativeDate } from './utils'

const props = defineProps({
  comment: {
    type: Object,
    required: true
  },
  projectId: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['deleted', 'reply-added'])

const showReplyForm = ref(false)

const {
  editForm,
  isEditing,
  editContent,
  startEdit: baseStartEdit,
  cancelEdit: baseCancelEdit,
  updateComment: baseUpdateComment,
  deleteComment: baseDeleteComment
} = useCommentActions()

const formattedDate = computed(() => {
  return formatRelativeDate(props.comment.created_at)
})

const startEdit = () => {
  baseStartEdit(props.comment)
}

const cancelEdit = () => {
  baseCancelEdit(props.comment.content)
}

const handleUpdate = () => {
  baseUpdateComment(props.comment.id, editContent.value)
}

const handleDelete = () => {
  baseDeleteComment(props.comment.id, (commentId) => {
    emit('deleted', commentId)
  })
}

const toggleReply = () => {
  showReplyForm.value = !showReplyForm.value
}

const cancelReply = () => {
  showReplyForm.value = false
}

const handleReplyAdded = () => {
  showReplyForm.value = false
  emit('reply-added')
}
</script>
