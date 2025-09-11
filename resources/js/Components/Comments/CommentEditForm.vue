<template>
  <form @submit.prevent="$emit('submit')" class="mt-2">
    <textarea v-model="localContent"
      class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md resize-none" :rows="rows"
      :placeholder="placeholder" required />
    <div class="flex gap-2 mt-2">
      <button type="submit" :disabled="processing"
        class="px-3 py-1 bg-blue-500 text-white rounded-sm text-sm hover:bg-blue-600 disabled:opacity-50">
        {{ processing ? 'Saving...' : 'Save' }}
      </button>
      <button type="button" @click="$emit('cancel')"
        class="px-3 py-1 bg-gray-300 text-gray-700 rounded-sm text-sm hover:bg-gray-400">
        Cancel
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  content: {
    type: String,
    required: true
  },
  processing: {
    type: Boolean,
    default: false
  },
  rows: {
    type: Number,
    default: 3
  },
  placeholder: {
    type: String,
    default: 'Edit your comment...'
  }
})

const emit = defineEmits(['submit', 'cancel', 'update:content'])

const localContent = ref(props.content)

watch(() => props.content, (newContent) => {
  localContent.value = newContent
})

watch(localContent, (newContent) => {
  emit('update:content', newContent)
})
</script>
