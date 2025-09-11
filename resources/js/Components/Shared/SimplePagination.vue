<script>
import { Link as InertiaLink } from '@inertiajs/vue3'

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
    <InertiaLink v-if="previousUrl" :href="previousUrl" class="pagination-button">Previous</InertiaLink>
    <button class="pagination-button" v-if="!previousUrl" disabled="!previousUrl">
      Previous
    </button>
    <InertiaLink v-if="nextUrl" class="pagination-button" :href="nextUrl">Next</InertiaLink>
    <button class="pagination-button" v-if="!nextUrl" disabled="!nextUrl">
      Next
    </button>
  </div>
</template>

<style lang="postcss">
@reference "../../../css/app.css";

.pagination-button {
  @apply px-4 py-2 bg-white dark:bg-gray-300 shadow rounded-md uppercase text-sm mx-3 font-medium transition-colors duration-100 text-black;

  &:disabled {
    @apply opacity-50 cursor-not-allowed;
  }

  &:hover {
    @apply bg-gray-200 dark:bg-gray-400;
  }
}
</style>
