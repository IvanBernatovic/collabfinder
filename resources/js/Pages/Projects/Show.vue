<template>
  <div class="py-4">
    <div class="p-6 bg-white rounded-lg">
      <div class="flex justify-between items-center">
        <h1 class="text-xl font-semibold">{{ project.name }}</h1>
        <button
          class="text-black p-2 rounded-lg box-border border border-gray-500 hover:cursor-pointer"
        >
          <ShareIcon class="w-4 h-4 text-[#5C5F62]" />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import { ShareIcon } from '@heroicons/vue/outline'

export default {
  layout: Layout
}
</script>

<script setup>
defineProps({
  project: Object
})
</script>
