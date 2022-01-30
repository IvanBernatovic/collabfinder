<script>
import { InertiaLink } from '@inertiajs/inertia-vue3'

export default {
  props: {
    nextUrl: {
      type: String,
      default: ''
    },
    previousUrl: {
      type: String,
      default: ''
    }
  },
  components: {
    InertiaLink
  }
}
</script>

<template>
  <div class="flex justify-center items-center py-4">
    <inertia-link
      v-if="previousUrl"
      :href="previousUrl"
      class="pagination-button"
      >Previous</inertia-link
    >
    <button
      class="pagination-button"
      v-if="!previousUrl"
      disabled="!previousUrl"
    >
      Previous
    </button>
    <inertia-link v-if="nextUrl" class="pagination-button" :href="nextUrl"
      >Next</inertia-link
    >
    <button class="pagination-button" v-if="!nextUrl" disabled="!nextUrl">
      Next
    </button>
  </div>
</template>

<style lang="postcss">
.pagination-button {
  @apply px-4 py-2 bg-white shadow rounded-md uppercase text-sm mx-3 font-medium transition-colors duration-100 text-black;

  &:disabled {
    @apply opacity-50 cursor-not-allowed;
  }

  &:hover {
    @apply bg-gray-200;
  }
}
</style>
