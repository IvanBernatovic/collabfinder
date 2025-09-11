<template>
  <div v-if="canModify" class="flex gap-2">
    <button @click="$emit('edit')"
      class="text-blue-600 hover:text-blue-800 dark:text-blue-300 hover:dark:text-blue-500 text-xs">
      Edit
    </button>
    <button @click="$emit('delete')"
      class="text-red-600 hover:text-red-800 dark:text-red-300 hover:dark:text-red-500 text-xs">
      Delete
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  userId: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['edit', 'delete'])

const user = usePage().props.auth.user

const canModify = computed(() => {
  return user.id === props.userId
})
</script>
