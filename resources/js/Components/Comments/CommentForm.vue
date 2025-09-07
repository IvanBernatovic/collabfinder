<template>
  <div class="bg-white border border-gray-200 rounded-lg p-4" :class="{ 'mb-6': !parentId, 'mb-3': parentId }">
    <div class="flex justify-between items-center mb-3">
      <h3 class="text-lg font-semibold">{{ parentId ? 'Reply to Comment' : 'Add a Comment' }}</h3>
      <button v-if="parentId && showCancel" @click="cancelReply" class="text-gray-500 hover:text-gray-700 text-sm">
        Cancel
      </button>
    </div>
    <form @submit.prevent="submitComment">
      <textarea v-model="form.content"
        class="w-full p-3 border border-gray-300 rounded-md resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        :rows="parentId ? 3 : 4"
        :placeholder="parentId ? 'Write your reply...' : 'Share your thoughts about this project...'"
        required></textarea>

      <div class="flex justify-between items-center mt-3">
        <span class="text-sm text-gray-500">
          {{ remainingChars }} characters remaining
        </span>
        <button type="submit" :disabled="form.processing || !form.content.trim()"
          class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
          {{ form.processing ? (parentId ? 'Replying...' : 'Posting...') : (parentId ? 'Post Reply' : 'Post Comment') }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'

const props = defineProps({
  projectId: {
    type: Number,
    required: true
  },
  parentId: {
    type: Number,
    default: null
  },
  showCancel: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['commentAdded', 'cancel'])

const toast = useToast()
const maxChars = 1000

const form = useForm({
  content: '',
  parent_id: props.parentId
})

const remainingChars = computed(() => {
  return maxChars - form.content.length
})

const submitComment = () => {
  // Update parent_id in case it changed
  form.parent_id = props.parentId

  form.post(`/projects/${props.projectId}/comments`, {
    onSuccess: () => {
      form.reset()
      form.parent_id = props.parentId // Restore parent_id after reset
      toast.success(props.parentId ? 'Reply added successfully!' : 'Comment added successfully!')
      emit('commentAdded')
    },
    onError: () => {
      toast.error(props.parentId ? 'Failed to add reply' : 'Failed to add comment')
    }
  })
}

const cancelReply = () => {
  form.reset()
  emit('cancel')
}
</script>
