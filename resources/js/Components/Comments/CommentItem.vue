<template>
  <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-4">
    <div class="flex justify-between items-start mb-2">
      <div class="flex items-center">
        <img :src="comment.user.profile_photo_url" :alt="comment.user.name" class="w-8 h-8 rounded-full mr-3" />
        <div>
          <h4 class="font-semibold text-sm">{{ comment.user.name }}</h4>
          <p class="text-xs text-gray-500 dark:text-white">{{ formattedDate }}</p>
        </div>
      </div>
      <div v-if="canModify" class="flex gap-2">
        <button @click="toggleEdit"
          class="text-blue-600 hover:text-blue-800 dark:text-blue-300 hover:dark:text-blue-500 text-xs">
          Edit
        </button>
        <button @click="deleteComment"
          class="text-red-600 hover:text-red-800 dark:text-red-300 hover:dark:text-red-500 text-xs">
          Delete
        </button>
      </div>
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

    <div v-else>
      <form @submit.prevent="updateComment" class="mt-2">
        <textarea v-model="editContent" class="w-full p-2 border border-gray-300 rounded-md resize-none" rows="3"
          placeholder="Edit your comment..." required></textarea>
        <div class="flex gap-2 mt-2">
          <button type="submit" :disabled="editForm.processing"
            class="px-3 py-1 bg-blue-500 text-white rounded-sm text-sm hover:bg-blue-600 disabled:opacity-50">
            Save
          </button>
          <button type="button" @click="cancelEdit"
            class="px-3 py-1 bg-gray-300 text-gray-700 rounded-sm text-sm hover:bg-gray-400">
            Cancel
          </button>
        </div>
      </form>
    </div>

    <!-- Reply form -->
    <div v-if="showReplyForm" class="mt-4">
      <CommentForm :project-id="projectId" :parent-id="comment.id" @comment-added="handleReplyAdded"
        @cancel="cancelReply" />
    </div>

    <!-- Replies -->
    <div v-if="comment.replies && comment.replies.length > 0" class="mt-4 ml-6 space-y-3">
      <div v-for="reply in comment.replies" :key="reply.id"
        class="bg-white dark:bg-gray-900 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-start mb-2">
          <div class="flex items-center">
            <img :src="reply.user.profile_photo_url" :alt="reply.user.name" class="w-6 h-6 rounded-full mr-2" />
            <div>
              <h5 class="font-semibold text-sm">{{ reply.user.name }}</h5>
              <p class="text-xs text-gray-500">{{ dayjs(reply.created_at).fromNow() }}</p>
            </div>
          </div>
          <div v-if="user.id === reply.user.id" class="flex gap-2">
            <button @click="editReply(reply)"
              class="text-blue-500 dark:text-blue-300 hover:text-blue-700 hover:dark:text-blue-500 text-xs">
              Edit
            </button>
            <button @click="deleteReply(reply)"
              class="text-red-600 hover:text-red-800 dark:text-red-300 hover:dark:text-red-500 text-xs">
              Delete
            </button>
          </div>
        </div>

        <div v-if="editingReplyId !== reply.id">
          <p class="text-gray-800 dark:text-gray-100 text-sm">{{ reply.content }}</p>

          <!-- Reply button for nested replies -->
          <div class="flex gap-2 mt-2">
            <button @click="toggleReplyToReply(reply.id)"
              class="text-blue-500 dark:text-blue-300 hover:text-blue-700 hover:dark:text-blue-500 text-xs">
              {{ showReplyToReplyForm === reply.id ? 'Cancel Reply' : 'Reply' }}
            </button>
          </div>
        </div>

        <div v-else>
          <form @submit.prevent="updateReply(reply)" class="mt-2">
            <textarea v-model="replyEditContent"
              class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md resize-none text-sm" rows="2"
              placeholder="Edit your reply..." required></textarea>
            <div class="flex gap-2 mt-2">
              <button type="submit" :disabled="replyEditForm.processing"
                class="px-2 py-1 bg-blue-500 text-white rounded-sm text-sm hover:bg-blue-600 disabled:opacity-50">
                Save
              </button>
              <button type="button" @click="cancelReplyEdit"
                class="px-2 py-1 bg-gray-300 text-gray-700 rounded-sm text-xs hover:bg-gray-400">
                Cancel
              </button>
            </div>
          </form>
        </div>

        <!-- Reply form for this specific reply -->
        <div v-if="showReplyToReplyForm === reply.id" class="mt-3">
          <CommentForm :project-id="projectId" :parent-id="reply.id" @comment-added="handleReplyAdded"
            @cancel="cancelReplyToReply" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'
import dayjs from '@/dayjs'
import CommentForm from './CommentForm.vue'

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

const toast = useToast()
const user = usePage().props.auth.user
const isEditing = ref(false)
const editContent = ref(props.comment.content)
const showReplyForm = ref(false)
const showReplyToReplyForm = ref(null) // Track which reply we're replying to
const editingReplyId = ref(null)
const replyEditContent = ref('')

const editForm = useForm({
  content: props.comment.content
})

const replyEditForm = useForm({
  content: ''
})

const formattedDate = computed(() => {
  return dayjs(props.comment.created_at).fromNow()
})

const canModify = computed(() => {
  return user.id === props.comment.user.id
})

const toggleEdit = () => {
  isEditing.value = !isEditing.value
  editContent.value = props.comment.content
}

const cancelEdit = () => {
  isEditing.value = false
  editContent.value = props.comment.content
}

const updateComment = () => {
  editForm.content = editContent.value

  editForm.put(`/comments/${props.comment.id}`, {
    onSuccess: () => {
      isEditing.value = false
      toast.success('Comment updated successfully!')
    },
    onError: () => {
      toast.error('Failed to update comment')
    }
  })
}

const deleteComment = () => {
  if (confirm('Are you sure you want to delete this comment?')) {
    editForm.delete(`/comments/${props.comment.id}`, {
      onSuccess: () => {
        toast.success('Comment deleted successfully!')
        emit('deleted', props.comment.id)
      },
      onError: () => {
        toast.error('Failed to delete comment')
      }
    })
  }
}

const toggleReply = () => {
  showReplyForm.value = !showReplyForm.value
}

const cancelReply = () => {
  showReplyForm.value = false
}

const handleReplyAdded = () => {
  showReplyForm.value = false
  showReplyToReplyForm.value = null
  emit('reply-added')
}

const toggleReplyToReply = (replyId) => {
  if (showReplyToReplyForm.value === replyId) {
    showReplyToReplyForm.value = null
  } else {
    showReplyToReplyForm.value = replyId
    showReplyForm.value = false // Close main reply form if open
  }
}

const cancelReplyToReply = () => {
  showReplyToReplyForm.value = null
}

const editReply = (reply) => {
  editingReplyId.value = reply.id
  replyEditContent.value = reply.content
}

const cancelReplyEdit = () => {
  editingReplyId.value = null
  replyEditContent.value = ''
}

const updateReply = (reply) => {
  replyEditForm.content = replyEditContent.value

  replyEditForm.put(`/comments/${reply.id}`, {
    onSuccess: () => {
      editingReplyId.value = null
      replyEditContent.value = ''
      toast.success('Reply updated successfully!')
      emit('reply-added') // Trigger refresh
    },
    onError: () => {
      toast.error('Failed to update reply')
    }
  })
}

const deleteReply = (reply) => {
  if (confirm('Are you sure you want to delete this reply?')) {
    replyEditForm.delete(`/comments/${reply.id}`, {
      onSuccess: () => {
        toast.success('Reply deleted successfully!')
        emit('reply-added') // Trigger refresh
      },
      onError: () => {
        toast.error('Failed to delete reply')
      }
    })
  }
}
</script>
