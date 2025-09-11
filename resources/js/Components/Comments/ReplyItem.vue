<template>
  <div class="bg-white dark:bg-gray-900 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-start mb-2">
      <div class="flex items-center">
        <img :src="reply.user.profile_photo_url" :alt="reply.user.name" class="w-6 h-6 rounded-full mr-2" />
        <div>
          <h5 class="font-semibold text-sm">{{ reply.user.name }}</h5>
          <p class="text-xs text-gray-500">{{ formatRelativeDate(reply.created_at) }}</p>
        </div>
      </div>

      <CommentActions :user-id="reply.user.id" @edit="startEdit" @delete="handleDelete" />
    </div>

    <div v-if="!isEditing">
      <p class="text-gray-800 dark:text-gray-100 text-sm">{{ reply.content }}</p>

      <div class="flex gap-2 mt-2">
        <button @click="toggleReplyForm"
          class="text-blue-500 dark:text-blue-300 hover:text-blue-700 hover:dark:text-blue-500 text-xs">
          {{ showReplyForm ? 'Cancel Reply' : 'Reply' }}
        </button>
      </div>
    </div>

    <CommentEditForm v-else :content="editContent" :processing="editForm.processing" :rows="2"
      placeholder="Edit your reply..." @submit="handleUpdate" @cancel="cancelEdit"
      @update:content="editContent = $event" />

    <!-- Reply form for nested replies -->
    <div v-if="showReplyForm" class="mt-3">
      <CommentForm :project-id="projectId" :parent-id="reply.id" @comment-added="handleReplyAdded"
        @cancel="cancelReplyForm" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import CommentActions from './CommentActions.vue'
import CommentEditForm from './CommentEditForm.vue'
import CommentForm from './CommentForm.vue'
import { useCommentActions } from './useCommentActions'
import { formatRelativeDate } from './utils'

const props = defineProps({
  reply: {
    type: Object,
    required: true
  },
  projectId: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['reply-added', 'deleted'])

const showReplyForm = ref(false)
const {
  editForm,
  isEditing,
  editContent,
  startEdit: baseStartEdit,
  cancelEdit: baseCancelEdit,
  updateComment,
  deleteComment
} = useCommentActions()

const startEdit = () => {
  baseStartEdit(props.reply)
}

const cancelEdit = () => {
  baseCancelEdit(props.reply.content)
}

const handleUpdate = () => {
  updateComment(props.reply.id, editContent.value, () => {
    emit('reply-added') // Trigger refresh
  })
}

const handleDelete = () => {
  deleteComment(props.reply.id, () => {
    emit('reply-added') // Trigger refresh
  })
}

const toggleReplyForm = () => {
  showReplyForm.value = !showReplyForm.value
}

const cancelReplyForm = () => {
  showReplyForm.value = false
}

const handleReplyAdded = () => {
  showReplyForm.value = false
  emit('reply-added')
}
</script>
